<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AbsensiController extends Controller
{
    public function index()
    {
        $absensi = Absensi::all();

        $absensi = DB::table('absensi')
        ->leftJoin('siswa', 'absensi.pin', '=', 'siswa.PINAbsensi')
        ->leftJoin('kelas', 'siswa.KelasId', '=', 'kelas.id') // Menggabungkan berdasarkan id kelas
        ->leftJoin('kelasparalel', 'siswa.KelasParalelId', '=', 'kelasparalel.id') 
        ->select('siswa.*', 'kelas.NamaKelas','kelasparalel.NamaKelasParalel','absensi.scan_date') // Memilih kolom yang diinginkan
        ->get(); // Mengambil hasil query
        

        // $title = 'Delete Guru!';
        // $text = "Are you sure you want to delete ?";
        // confirmDelete($title, $text);

        return view("absensi.absensi", [
            'absensi' => $absensi,
        ]);
    }
}
