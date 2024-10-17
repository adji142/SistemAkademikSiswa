<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MesinAbsensi extends Model
{
    use HasFactory;
    protected $table = 'mesinabsensi';
    protected $fillable = [
        'NamaMesin',
        'SerialNumber',
        'ActivationCode',
        'APIToken',
        'CloudKey'
    ];
}
