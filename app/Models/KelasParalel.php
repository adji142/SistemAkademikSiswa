<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KelasParalel extends Model
{
    use HasFactory;
    protected $table = 'kelasparalel';
    protected $fillable = [
        'kelas_id',
        'NamaKelasParalel'
    ];
}
