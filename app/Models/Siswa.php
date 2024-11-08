<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;
    protected $table = 'siswa';
    protected $primaryKey = 'NISN'; // Nama kolom primary key
    public $incrementing = false; // Karena primary key tidak auto-increment
    protected $keyType = 'string'; // Set primary key sebagai string

    protected $fillable = [
        'NISN',
        'NIK',
        'PINAbsensi',
            'NamaSiswa' ,
            'JenisKelamin' ,
            'TempatLahir' ,
            'TanggalLahir',
            'AlamatSiswa',
            'ProvID',
            'KotaID' ,
            'KecID' ,
            'KelID',
            'KelasID',
            'KelasParalelID' ,
            'Email' ,
            'NoHP' ,
            'tahunajaran' ,
            'Status' ,
            'AlamatWali' ,
            'WaliProvID',
            'WaliKotaID',
            'WaliKecID',
            'WaliKelID' ,
            'HubunganWali',
            'NamaWali' ,
            'NoTlpWali' 
        // Tambahkan atribut lain sesuai kebutuhan
    ];
}
