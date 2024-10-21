<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    use HasFactory;
    protected $table = 'guru';
    protected $primaryKey = 'NIK'; // Nama kolom primary key
    public $incrementing = false; // Karena primary key tidak auto-increment
    protected $keyType = 'string'; // Set primary key sebagai string

    protected $fillable = [
        'NIK'
        // Tambahkan atribut lain sesuai kebutuhan
    ];
}
