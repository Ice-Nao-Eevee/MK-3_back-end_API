<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'classroom_id',
        'no_absen',
        'nis',
        'nama',
        'jenis_kelamin',
        'jabatan_dev',
        'foto',
        'profile_public_id',
        'tanggal_lahir',
        'whatsapp',
        'instagram',
        'bio',
        'quote',
        'nama_ayah',
        'nama_ibu',
    ];

    public function classroom()
    {
        return $this->belongsTo(Classroom::class, 'classroom_id')->withDefault([
            'id' => 0,
            'tingkat' => '-',
            'jurusan' => '-',
            'nomor_kelas' => 0,
            'nama_kelas' => 'Belum Pilih Kelas',
        ]);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
