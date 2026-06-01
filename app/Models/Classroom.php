<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
    // Daftarkan kolom yang boleh diisi su
    protected $fillable = [
        'tingkat',
        'jurusan',
        'nama_kelas'
    ];
}