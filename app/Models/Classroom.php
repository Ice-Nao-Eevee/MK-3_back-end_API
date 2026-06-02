<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
    protected $fillable = [
        'tingkat',
        'jurusan',
        'nomor_kelas',
        'nama_kelas',
        'is_active',
    ];

    public function siswas()
    {
        return $this->hasMany(Siswa::class, 'classroom_id');
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class, 'classroom_id');
    }
}
