<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use DB;
use Log;

use App\Models\MesinAbsensi;
use App\Models\Siswa;
use App\Models\AppSetting;
use App\Models\AttLog;
use App\Models\AttLogGuru;
use App\Models\Guru;
use App\Models\TemplateMessage;
use App\Models\SendedLogModel;
use App\Models\InformasiSekolah;

class FingerSpotController extends Controller
{
    function CreateUser(Request $request){
        $data = array('success' => false, 'message'=>'', 'data'=>array());
        $nisns = $request->input('nisns');

        try {
            $oMesin = MesinAbsensi::all();
            $oSetting = new AppSetting();

            foreach ($oMesin as $key) {
                $oDataDetail = array();
                
                $oSiswa = Siswa::whereIn('NISN', $nisns)->get();
                foreach ($oSiswa as $siswa) {
                    $textCount = strlen($siswa->NamaSiswa);

                    $oParam = [
                        'trans_id' => strval($siswa->PINAbsensi),
                        'cloud_id' => $key->CloudKey,
                        'data' => [
                            'pin' => strval($siswa->PINAbsensi),
                            'name' => substr($siswa->NamaSiswa, 0, ($textCount > 10) ? 10 : $textCount), 
                            'privilege' => '1',
                            'password' => strval($siswa->PINAbsensi),
                            'template' => ''
                        ]
                    ];

                    // Saving
                    $url = $oSetting->BaseURL()."set_userinfo";
                    $response = Http::withToken($key->APIToken)->post($url, $oParam);
                    // var_dump($response->json());
                    if ($response->successful()) {
                        $oResponseData = $response->json();

                        if ($oResponseData["success"] == false) {
                            $data['success'] = false;
                            $data['data'] = "Siswa ".substr($siswa->NamaSiswa, 0, ($textCount > 10) ? 10 : $textCount). "Gagal diupload, karena ". $oResponseData["message"] ;

                            goto jump;
                        }
                        $data['success'] = true;
                        $data['data'] = $oResponseData;

                        Siswa::where('NISN', $siswa->NISN)->update([
                            'isUploaded' => 1
                        ]);
                    }
                    else{
                        $data["success"] = false;
                        $data["message"] = "Gagal Membuat User Mesin Absensi";
                    }

                }
            }
jump:
        } catch (RedirectException $e) {
            $data["success"] = false;
            $data["message"] = $th->getMessage();
        }

        return response()->json($data);
    }

    function CreateUserGuru(Request $request){
        $data = array('success' => false, 'message'=>'', 'data'=>array());
        $nisns = $request->input('nisns');

        try {
            $oMesin = MesinAbsensi::all();
            $oSetting = new AppSetting();

            foreach ($oMesin as $key) {
                $oDataDetail = array();
                
                $oSiswa = Guru::whereIn('NIK', $nisns)->get();
                foreach ($oSiswa as $siswa) {
                    $textCount = strlen($siswa->NamaGuru);

                    $oParam = [
                        'trans_id' => strval($siswa->NIK),
                        'cloud_id' => $key->CloudKey,
                        'data' => [
                            'pin' => strval($siswa->NIK),
                            'name' => substr($siswa->NamaGuru, 0, ($textCount > 10) ? 10 : $textCount), 
                            'privilege' => '1',
                            'password' => strval($siswa->NIK),
                            'template' => ''
                        ]
                    ];

                    // Saving
                    $url = $oSetting->BaseURL()."set_userinfo";
                    $response = Http::withToken($key->APIToken)->post($url, $oParam);
                    // var_dump($response->json());
                    if ($response->successful()) {
                        $oResponseData = $response->json();

                        if ($oResponseData["success"] == false) {
                            $data['success'] = false;
                            $data['data'] = "Siswa ".substr($siswa->NamaGuru, 0, ($textCount > 10) ? 10 : $textCount). "Gagal diupload, karena ". $oResponseData["message"] ;

                            goto jump;
                        }
                        $data['success'] = true;
                        $data['data'] = $oResponseData;

                        Guru::where('NIK', $siswa->NIK)->update([
                            'isUploaded' => 1
                        ]);
                    }
                    else{
                        $data["success"] = false;
                        $data["message"] = "Gagal Membuat User Mesin Absensi";
                    }

                }
            }
jump:
        } catch (RedirectException $e) {
            $data["success"] = false;
            $data["message"] = $th->getMessage();
        }

        return response()->json($data);
    }

    function GetAttandance(Request $request) {
        $data = array('success' => false, 'message'=>'', 'data'=>array());
        $currentDate = now()->toDateString();
        $previousDate = now()->subDay()->toDateString();

        // $currentDate = '2024-10-25';
        // $previousDate = '2024-10-24';
        // dd($previousDate);
        try {
            $oMesin = MesinAbsensi::all();
            $oSetting = new AppSetting();

            foreach ($oMesin as $key) {
                $oPref = AttLog::where('sn',$key->CloudKey)
                            ->whereBetween(DB::raw("CAST(scan_date as date)"), [$previousDate, $currentDate])
                            ->count();
                if ($oPref > 0) {
                    DB::table('att_log')
                        ->where('sn','=', $key->CloudKey)
                        ->whereBetween(DB::raw("CAST(scan_date as date)"), [$previousDate, $currentDate])
                        ->delete();
                }

                // dd($oPref);
                // {"trans_id":"1", "cloud_id":"xxxx", "start_date":"2020-07-25", "end_date":"2020-07-26"}
                $oParam = [
                    'trans_id' => "ATT".$key->CloudKey,
                    'cloud_id' => $key->CloudKey,
                    'start_date' => $previousDate,
                    'end_date' => $currentDate
                ];

                $url = $oSetting->BaseURL()."get_attlog";
                $response = Http::withToken($key->APIToken)->post($url, $oParam);
                // var_dump($response->json());
                if ($response->successful()) {
                    $oResponseData = $response->json();

                    if ($oResponseData["success"] == false) {
                        $data['success'] = false;
                        $data['data'] = $oResponseData["message"] ;
                    }
                    $data['success'] = true;
                    $data['data'] = $oResponseData;

                    // dd($oResponseData);
                    foreach ($oResponseData["data"] as $keyAbsen) {
                        // dd($key['pin']);
                        $absensi = new AttLog();
                        $absensi->sn = $key->CloudKey;
                        $absensi->scan_date = $keyAbsen["scan_date"];
                        $absensi->pin = $keyAbsen["pin"];
                        $absensi->verifymode = $keyAbsen["verify"];
                        $absensi->inoutmode = $keyAbsen["status_scan"];
                        $absensi->reserved = 0;
                        $absensi->work_code = 0;
                        $absensi->att_id = "";
                        $absensi->save();
                    }
                }
                else{
                    $data["success"] = false;
                    $data["message"] = "Gagal Membuat User Mesin Absensi";
                }
            }
        jump:
        } catch (\Throwable $th) {
            $data["success"] = false;
            $data["message"] = $th->getMessage();
        }
        return response()->json($data);
    }

    public function RealtimeAttandance(Request $request)
    {
        $odata = ['success' => true, 'message' => '', 'data' => []];

        // Log semua data yang diterima
        Log::debug('Webhook Fingerspot Diterima:', $request->all());

        // Ambil data tanpa validasi
        $type = $request->input('type');
        $cloud_id = $request->input('cloud_id');
        $pin = $request->input('data.pin');
        $scan = $request->input('data.scan');
        $verify = $request->input('data.verify');
        $status_scan = $request->input('data.status_scan');

        Log::debug('Data :', [
            'type' => $type,
            'cloud_id' => $cloud_id,
            'pin' => $pin,
            'scan' => $scan,
            'verify' => $verify,
            'status_scan' => $status_scan,
        ]);

        if ($type == 'attlog') {
            $InformasiSekolah = InformasiSekolah::first();

            // Simpan ke tabel attlog


            $oDataMurid = Siswa::where('PINAbsensi', $pin)->first();
            $oDataGuru = Guru::where('NIK', $pin)->first();

            if($oDataMurid){
                $absensi = new AttLog();
                $absensi->sn = $cloud_id;
                $absensi->scan_date = $scan;
                $absensi->pin = $pin;
                $absensi->verifymode = $verify;
                $absensi->inoutmode = $status_scan;
                $absensi->reserved = 0;
                $absensi->work_code = 0;
                $absensi->att_id = "";
                $absensi->save();

                // Lanjutkan proses pengambilan data siswa dan kirim pesan
                // $template = TemplateMessage::where('id', '2')->first();
                $currentDate = now()->toDateString();
                $oMessageResponse = [];

                $siswa = Siswa::where('PINAbsensi', $pin)->first();

                if ($siswa) {
                    $NoTlpWali = $siswa->NoTlpWali;

                    $SQL = "datasekolah.NamaSekolah, datasekolah.AlamatSekolah, siswa.NISN AS NISNSiswa,
                        siswa.NamaSiswa, siswa.NamaWali, COALESCE(CONCAT('Absen Masuk: ', absensi.Scan_IN, '\n','Absen Keluar: ', absensi.Scan_OUT),'') DataAbsen, 
                        absensi.Scan_IN AS DataAbsenMasuk,absensi.Scan_OUT DataAbsenKeluar, NOW() TanggalHariIni, 
                        hari.NamaHariID AS Hari, CASE WHEN absensi.Scan_IN IS NULL THEN 'Tidak Masuk Sekolah' ELSE 'Masuk Sekolah' END StatusKehadiran ";

                    $subAbsensi = DB::table('absensi')
                        ->select('absensi.PIN', 'absensi.TanggalAbsen', 'absensi.Scan_IN', 'absensi.Scan_OUT')
                        ->where('absensi.PIN', $pin);

                    $absensiData = Siswa::selectRaw($SQL)
                        ->leftJoinSub($subAbsensi, 'absensi', function ($join) {
                            $join->on('siswa.PINAbsensi', 'absensi.PIN');
                        })
                        ->leftJoin('kelas', 'siswa.KelasID', 'kelas.id')
                        ->leftJoin('kelasparalel', 'siswa.KelasParalelID', 'kelasparalel.id')
                        ->leftJoin('datasekolah', DB::raw('1'), DB::raw('1'))
                        ->leftJoin('hari', DB::raw('DAYNAME(NOW())'), 'hari.NamaHariEN')
                        ->where('siswa.PINAbsensi', $pin)
                        ->get();

                    if($InformasiSekolah) {
                        // $template = TemplateMessage::where('id', '2')->first();
                        // in
                        if ($status_scan == '0' &&
                            isset($InformasiSekolah->TemplateAbsenMasuk) &&
                            is_numeric($InformasiSekolah->TemplateAbsenMasuk) &&
                            intval($InformasiSekolah->TemplateAbsenMasuk) > 0) {
                            $template = TemplateMessage::where('id', $InformasiSekolah->TemplateAbsenMasuk)->first();
                        }
                        // out
                        else if ( $status_scan == '1' &&
                                isset($InformasiSekolah->TemplateAbsenKeluar) &&
                                is_numeric($InformasiSekolah->TemplateAbsenKeluar) &&
                                intval($InformasiSekolah->TemplateAbsenKeluar) > 0) {
                            $template = TemplateMessage::where('id', $InformasiSekolah->TemplateAbsenKeluar)->first();
                        } else {
                            // $template = TemplateMessage::where('id', '1')->first();
                            $odata['success'] = false;
                            $odata['message'] = 'Status Scan tidak dikenali.';
                            goto jump;
                        }
                    } else {
                        // $template = TemplateMessage::where('id', '1')->first();
                        $odata['success'] = false;
                        $odata['message'] = 'Informasi Sekolah tidak ditemukan.';
                        goto jump;
                    }
                    
                    $message = $template->TemplateContent;
                    foreach ($absensiData->toArray()[0] as $key => $value) {
                        $message = str_replace("#$key#", $value, $message);
                    }

                    log::debug('Pesan yang akan dikirim:', ['message' => $message]);

                    if (!empty($NoTlpWali)) {
                        $oLog = SendedLogModel::where('pin', $pin)
                            ->where('LastSended', $currentDate)
                            ->where('inoutmode', $status_scan)
                            ->first();
                        log::debug('Log Sended:', ['log' => $oLog]);

                        if (!$oLog) {
                            $oLogInsert = new SendedLogModel();
                            $oLogInsert->pin = $pin;
                            $oLogInsert->LastSended = $currentDate;
                            $oLogInsert->inoutmode = $status_scan;
                            $oLogInsert->save();

                            Log::debug('Send WhatsApp');

                            $odata['message'] = $message;
                            $oSend = WhatsAppController::SendMessage($NoTlpWali, $message);
                            array_push($oMessageResponse, $oSend);
                            $odata['data'] = $oMessageResponse;
                        } else {
                            Log::debug('Jangan Send WhatsApp');
                        }
                    }
    jump:
                    Log::debug("Webhook Fingerspot:", [
                        'Result' => json_encode($odata, JSON_PRETTY_PRINT)
                    ]);
                }
            }
            else if($oDataGuru){
                
                $absensi = new AttLogGuru();
                $absensi->sn = $cloud_id;
                $absensi->scan_date = $scan;
                $absensi->pin = $pin;
                $absensi->verifymode = $verify;
                $absensi->inoutmode = $status_scan;
                $absensi->reserved = 0;
                $absensi->work_code = 0;
                $absensi->att_id = "";
                $absensi->save();

                // Lanjutkan proses pengambilan data siswa dan kirim pesan
                // $template = TemplateMessage::where('id', '2')->first();
                $currentDate = now()->toDateString();
                $oMessageResponse = [];
                $NoTlpWali = $InformasiSekolah->NoHPPeneriaNotif;

                $SQL = "datasekolah.NamaSekolah, datasekolah.AlamatSekolah, guru.NIK PINGuru,
                    guru.NamaGuru, COALESCE(CONCAT('Absen Masuk: ', absensi.Scan_IN, '\n','Absen Keluar: ', absensi.Scan_OUT),'') DataAbsen, 
                    absensi.Scan_IN AS DataAbsenMasuk,absensi.Scan_OUT DataAbsenKeluar, NOW() TanggalHariIni, 
                    hari.NamaHariID AS Hari, CASE WHEN absensi.Scan_IN IS NULL THEN 'Tidak Masuk Sekolah' ELSE 'Masuk Sekolah' END StatusKehadiran ";

                $subAbsensi = DB::table('absensi')
                    ->select('absensi.PIN', 'absensi.TanggalAbsen', 'absensi.Scan_IN', 'absensi.Scan_OUT')
                    ->where('absensi.PIN', $pin);

                $absensiData = Guru::selectRaw($SQL)
                    ->leftJoinSub($subAbsensi, 'absensi', function ($join) {
                        $join->on('guru.NIK', 'absensi.PIN');
                    })
                    ->leftJoin('datasekolah', DB::raw('1'), DB::raw('1'))
                    ->leftJoin('hari', DB::raw('DAYNAME(NOW())'), 'hari.NamaHariEN')
                    ->where('guru.NIK', $pin)
                    ->get();

                if($InformasiSekolah) {
                    // $template = TemplateMessage::where('id', '2')->first();
                    // in
                    if ($status_scan == '0' &&
                        isset($InformasiSekolah->TemplateAbsenMasukGuru) &&
                        is_numeric($InformasiSekolah->TemplateAbsenMasukGuru) &&
                        intval($InformasiSekolah->TemplateAbsenMasukGuru) > 0) {
                        $template = TemplateMessage::where('id', $InformasiSekolah->TemplateAbsenMasukGuru)->first();
                    }
                    // out
                    else if ( $status_scan == '1' &&
                            isset($InformasiSekolah->TemplateAbsenKeluarGuru) &&
                            is_numeric($InformasiSekolah->TemplateAbsenKeluarGuru) &&
                            intval($InformasiSekolah->TemplateAbsenKeluarGuru) > 0) {
                        $template = TemplateMessage::where('id', $InformasiSekolah->TemplateAbsenKeluarGuru)->first();
                    } else {
                        // $template = TemplateMessage::where('id', '1')->first();
                        $odata['success'] = false;
                        $odata['message'] = 'Status Scan tidak dikenali.';
                        goto jumpguru;
                    }
                } else {
                    // $template = TemplateMessage::where('id', '1')->first();
                    $odata['success'] = false;
                    $odata['message'] = 'Informasi Sekolah tidak ditemukan.';
                    goto jumpguru;
                }
                
                $message = $template->TemplateContent;
                foreach ($absensiData->toArray()[0] as $key => $value) {
                    $message = str_replace("#$key#", $value, $message);
                }

                log::debug('Pesan yang akan dikirim:', ['message' => $message]);

                if (!empty($NoTlpWali)) {
                    $oLog = SendedLogModel::where('pin', $pin)
                        ->where('LastSended', $currentDate)
                        ->where('inoutmode', $status_scan)
                        ->first();
                    log::debug('Log Sended:', ['log' => $oLog]);

                    if (!$oLog) {
                        $oLogInsert = new SendedLogModel();
                        $oLogInsert->pin = $pin;
                        $oLogInsert->LastSended = $currentDate;
                        $oLogInsert->inoutmode = $status_scan;
                        $oLogInsert->save();

                        Log::debug('Send WhatsApp');

                        $odata['message'] = $message;
                        $oSend = WhatsAppController::SendMessage($NoTlpWali, $message);
                        array_push($oMessageResponse, $oSend);
                        $odata['data'] = $oMessageResponse;
                    } else {
                        Log::debug('Jangan Send WhatsApp');
                    }
                }
jumpguru:
                Log::debug("Webhook Fingerspot:", [
                    'Result' => json_encode($odata, JSON_PRETTY_PRINT)
                ]);
            }
        } elseif ($type == 'set_userinfo') {
            Log::debug('Webhook Fingerspot Diterima Dari Set User Info:', $request->all());
        } elseif ($type == 'get_userinfo') {
            Log::debug('Webhook Fingerspot Diterima Dari Get User Info:', $request->all());
        } 
        elseif ($type == 'register_online') {
            Log::debug('Webhook Fingerspot Diterima Dari Register Online:', $request->all());
        } 
        else {
            Log::debug("Ini Bukan Attandance");
        }
    }

}
