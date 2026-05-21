<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @mixin \Illuminate\Database\Eloquent\Builder
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Siswa when($value, $callback = null, $default = null)
 * @method static \App\Models\Siswa|null find($id, $columns = ['*'])
 */
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

    protected $table = 'siswas';
}
