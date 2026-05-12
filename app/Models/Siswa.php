<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    protected $fillable = [
        'no_absen',
        'nis',
        'nama',
        'jenis_kelamin',
        'jabatan_dev',
        'foto',
    ];
}
