<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Siswa;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\KelasParalel;

class AbsensiController extends Controller
{
    public function index(Request $request)
    {
        // $absensi = Absensi::all();
        $TglAwal = $request->input('TglAwal');
        $TglAkhir = $request->input('TglAkhir');
        $KelasID = $request->input('KelasID');
        $KelasParalelID = $request->input('KelasParalelID');

        $kelas = Kelas::all();
        $kelasparalel = KelasParalel::all();

        $SQL = "absensi.TanggalAbsen,siswa.NISN AS NISNSiswa,siswa.NamaSiswa, siswa.PINAbsensi, absensi.Scan_IN AS DataAbsenMasuk,
                absensi.Scan_OUT DataAbsenKeluar, hari.NamaHariID AS Hari, kelas.NamaKelas, kelasparalel.NamaKelasParalel,
                CASE WHEN absensi.Scan_IN IS NULL THEN 'Tidak Masuk Sekolah' ELSE 'Masuk Sekolah' END StatusKehadiran ";
        $subAbsensi = DB::table('absensi')
                        ->select('absensi.PIN', 'absensi.TanggalAbsen', 'absensi.Scan_IN', 'absensi.Scan_OUT', 'absensi.KelompokAbsen')
                        ->whereBetween('absensi.TanggalAbsen', [$TglAwal, $TglAkhir]);

        $absensi = Siswa::selectRaw($SQL)
                    ->leftJoinSub($subAbsensi, 'absensi', function ($join)  {
                        $join->on('siswa.PINAbsensi','absensi.PIN');
                    })
                    ->leftJoin('kelas', 'siswa.KelasID','kelas.id')
                    ->leftJoin('kelasparalel','siswa.KelasParalelID', 'kelasparalel.id')
                    ->leftJoin('hari', DB::raw('DAYNAME(NOW())'), 'hari.NamaHariEN')
                    ->where('absensi.KelompokAbsen', 'SISWA');

        if ($KelasID != "") {
            $absensi->where('siswa.KelasID', $KelasID);
        }
        if ($KelasParalelID != "") {
            $absensi->where('siswa.KelasParalelID', $KelasParalelID);
        }
        

        // $title = 'Delete Guru!';
        // $text = "Are you sure you want to delete ?";
        // confirmDelete($title, $text);

        return view("absensi.absensi", [
            'absensi' => $absensi->get(),
            'kelas' => $kelas,
            'kelasparalel' => $kelasparalel,
            'oldTglAwal' => $TglAwal,
            'oldTglAkhir' => $TglAkhir,
            'oldKelasID' => $KelasID,
            'oldKelasParalelID' => $KelasParalelID
        ]);
    }

    public function indexGuru(Request $request)
    {
        // $absensi = Absensi::all();
        $TglAwal = $request->input('TglAwal');
        $TglAkhir = $request->input('TglAkhir');


        $SQL = "absensi.TanggalAbsen,guru.NIK,guru.NamaGuru, absensi.Scan_IN AS DataAbsenMasuk,
                absensi.Scan_OUT DataAbsenKeluar, hari.NamaHariID AS Hari,
                CASE WHEN absensi.Scan_IN IS NULL THEN 'Tidak Masuk Sekolah' ELSE 'Masuk Sekolah' END StatusKehadiran ";
        $subAbsensi = DB::table('absensi')
                        ->select('absensi.PIN', 'absensi.TanggalAbsen', 'absensi.Scan_IN', 'absensi.Scan_OUT','absensi.KelompokAbsen')
                        ->whereBetween('absensi.TanggalAbsen', [$TglAwal, $TglAkhir]);

        $absensi = Guru::selectRaw($SQL)
                    ->leftJoinSub($subAbsensi, 'absensi', function ($join)  {
                        $join->on('guru.NIK','absensi.PIN');
                    })
                    ->leftJoin('hari', DB::raw('DAYNAME(NOW())'), 'hari.NamaHariEN')
                    ->where('absensi.KelompokAbsen', 'GURU');
        

        // $title = 'Delete Guru!';
        // $text = "Are you sure you want to delete ?";
        // confirmDelete($title, $text);

        return view("absensi.absensiguru", [
            'absensi' => $absensi->get(),
            'oldTglAwal' => $TglAwal,
            'oldTglAkhir' => $TglAkhir
        ]);
    }
}
