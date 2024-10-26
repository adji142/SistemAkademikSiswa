<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Absensi;
use App\Models\TemplateMessage;
use App\Models\Siswa;


use App\Http\Controllers\WhatsAppController;

class SendMessageController extends Controller
{
    public function SendAbsenNotification($templateId){
        $data = array('success'=>true, 'message'=>'', 'data'=>array());
        $template = TemplateMessage::where('id', $templateId)->first();
        $currentDate = now()->toDateString();
        $oSiswa = Siswa::where('Status', 1)->get();

        $oMessageResponse = array();

        foreach ($oSiswa as $key) {
            // dd($key->NoTlpWali);
            $NoTlpWali = $key->NoTlpWali;
            $SQL = "datasekolah.NamaSekolah, datasekolah.AlamatSekolah, siswa.NISN AS NISNSiswa,
            siswa.NamaSiswa, siswa.NamaWali, COALESCE(CONCAT('Absen Masuk: ', absensi.Scan_IN, '\n','Absen Keluar: ', absensi.Scan_OUT),'') DataAbsen, 
            absensi.Scan_IN AS DataAbsenMasuk,absensi.Scan_OUT DataAbsenKeluar, NOW() TanggalHariIni, 
            hari.NamaHariID AS Hari, CASE WHEN absensi.Scan_IN IS NULL THEN 'Tidak Masuk Sekolah' ELSE 'Masuk Sekolah' END StatusKehadiran ";
            $subAbsensi = DB::table('absensi')
                            ->select('absensi.PIN', 'absensi.TanggalAbsen', 'absensi.Scan_IN', 'absensi.Scan_OUT')
                            ->where('absensi.TanggalAbsen', $currentDate);

            $absensi = Siswa::selectRaw($SQL)
                        ->leftJoinSub($subAbsensi, 'absensi', function ($join)  {
                            $join->on('siswa.PINAbsensi','absensi.PIN');
                        })
                        ->leftJoin('kelas', 'siswa.KelasID','kelas.id')
                        ->leftJoin('kelasparalel','siswa.KelasParalelID', 'kelasparalel.id')
                        ->leftJoin('datasekolah',DB::raw('1'),DB::raw('1'))
                        ->leftJoin('hari', DB::raw('DAYNAME(NOW())'), 'hari.NamaHariEN')
                        ->where('siswa.NISN', $key->NISN)
                        ->get();

            // dd(response()->json($absensi));

            $message = $template->TemplateContent;
            foreach ($absensi->toArray()[0] as $key => $value) {
                $message = str_replace("#$key#", $value, $message);
            }

            // Send
            if ($NoTlpWali != "") {
                $oSend = WhatsAppController::SendMessage($NoTlpWali, $message);
                array_push($oMessageResponse, $oSend);
            }
        }

        $data['data'] = $oMessageResponse;
        return response()->json($data);
    }
}
