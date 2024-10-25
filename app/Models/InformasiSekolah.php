<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InformasiSekolah extends Model
{
    use HasFactory;
    protected $table = 'datasekolah';
    protected $fillable = [
        'NPSN',
        'NamaSekolah',
        'AlamatSekolah',
        'SKPendirianSekolah',
        'TanggalSKPendirian',
        'SKIzinOperasional',
        'TanggalSKOperasional'
    ];
}
