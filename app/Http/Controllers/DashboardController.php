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

use App\Models\Siswa;
use App\Models\Absensi;
use App\Models\Kelas;

class DashboardController extends Controller
{
    public function dashboard(){
        $currentDate = now()->toDateString();
        $firstDayOfMonth = Carbon::now()->startOfMonth()->toDateString();
        $lastDayOfMonth = Carbon::now()->endOfMonth()->toDateString();

        $subAbsensi = DB::table('absensi')
                        ->select('absensi.PIN', 'absensi.TanggalAbsen', 'absensi.Scan_IN', 'absensi.Scan_OUT')
                        ->whereBetween('absensi.TanggalAbsen', [$currentDate, $currentDate]);

        $countSiswa = Siswa::where('Status', DB::raw('1'))->count();
        $countSiswaMasuk = Siswa::selectRaw("siswa.*, absensi.ScanIN, absensi.Scan_OUT")
                            ->leftJoinSub($subAbsensi, 'absensi', function ($join)  {
                                $join->on('siswa.PINAbsensi','absensi.PIN');
                            })
                            ->whereNotNull('absensi.TanggalAbsen')
                            ->count();
        $countTidakSiswaMasuk = Siswa::selectRaw("siswa.*, absensi.ScanIN, absensi.Scan_OUT")
                            ->leftJoinSub($subAbsensi, 'absensi', function ($join)  {
                                $join->on('siswa.PINAbsensi','absensi.PIN');
                            })
                            ->whereNull('absensi.TanggalAbsen')
                            ->count();

        $kelas = Kelas::all();
        $dataAbsen = array('series' => array(), 'label'=>array());
        $dataTidakHadir = array('series' => array(), 'label'=>array());

        foreach ($kelas as $key) {
            $temp = array('name' => '', 'data' => array());
            $subAbsensiKehadiran = DB::table('absensi')
                        ->select('absensi.PIN', 'absensi.TanggalAbsen', 'absensi.Scan_IN', 'absensi.Scan_OUT')
                        ->whereBetween('absensi.TanggalAbsen', [$firstDayOfMonth, $lastDayOfMonth]);

            $SiswaMasuk = Siswa::selectRaw("DATE_FORMAT(absensi.TanggalAbsen , '%d-%m') as label, COUNT(DISTINCT siswa.PINAbsensi) JmlMasuk")
                            ->leftJoinSub($subAbsensiKehadiran, 'absensi', function ($join)  {
                                $join->on('siswa.PINAbsensi','absensi.PIN');
                            })
                            ->whereNotNull('absensi.TanggalAbsen')
                            ->where('siswa.KelasID', $key->id)
                            ->groupBy('absensi.TanggalAbsen')
                            ->orderBy('absensi.TanggalAbsen', 'asc')
                            ->get();
            $temp['name'] = $key->NamaKelas;
            $tempData = array();
            $tempLabel = array();
            foreach ($SiswaMasuk as $SM) {
                array_push($tempData, $SM->JmlMasuk);
                array_push($tempLabel, $SM->label);
            }
            
            $temp['data'] = $tempData;
            $temp['Label'] = $tempLabel;

            array_push($dataAbsen['series'], $temp);
            array_push($dataAbsen['label'], $tempLabel);
        }

        foreach ($kelas as $key) {
            $temp = array('name' => '', 'data' => array());
            $subAbsensiKehadiran = DB::table('absensi')
                        ->select('absensi.PIN', 'absensi.TanggalAbsen', 'absensi.Scan_IN', 'absensi.Scan_OUT')
                        ->whereBetween('absensi.TanggalAbsen', [$currentDate, $lastDayOfMonth]);

            $SiswaMasuk = Siswa::selectRaw("DATE_FORMAT(absensi.TanggalAbsen , '%d-%m') as label, COUNT(DISTINCT siswa.PINAbsensi) JmlMasuk")
                            ->leftJoinSub($subAbsensiKehadiran, 'absensi', function ($join)  {
                                $join->on('siswa.PINAbsensi','absensi.PIN');
                            })
                            ->whereNull('absensi.TanggalAbsen')
                            ->where('siswa.KelasID', $key->id)
                            ->groupBy('absensi.TanggalAbsen')
                            ->orderBy('absensi.TanggalAbsen', 'asc')
                            ->get();
            $temp['name'] = $key->NamaKelas;
            $tempData = array();
            $tempLabel = array();
            foreach ($SiswaMasuk as $SM) {
                array_push($tempData, $SM->JmlMasuk);
                array_push($tempLabel, $SM->label);
            }
            
            $temp['data'] = $tempData;
            $temp['Label'] = $tempLabel;

            array_push($dataTidakHadir['series'], $temp);
            array_push($dataTidakHadir['label'], $tempLabel);
        }

        return view(
            "dashboard",[
                "siswaCount" => $countSiswa,
                "siswaMasuk" => $countSiswaMasuk,
                "siswaTidakMasuk" => $countTidakSiswaMasuk,
                "AbsensiMasuk" => $dataAbsen,
                "dataTidakHadir" => $dataTidakHadir
            ]
        );
    }
}
