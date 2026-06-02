<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin \Illuminate\Database\Eloquent\Builder
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Siswa when($value, $callback = null, $default = null)
 * @method static \App\Models\Siswa|null find($id, $columns = ['*'])
 */
class Siswa extends Model
{
    use HasFactory;

    // 🛠️ Daftarkan semua kolom baru agar diizinkan masuk ke database MySQL
    protected $fillable = [
        'classroom_id', // 👈 WAJIB MASUKIN INI JUGA BIAR RELASI KELASNYA GAK GAGAL DI-UPDATE!
        'no_absen',
        'nis',
        'nama',
        'jenis_kelamin',
        'jabatan_dev',
        'foto',              // Menyimpan URL secure_url dari Cloudinary
        'profile_public_id', 
        'tanggal_lahir',
        'whatsapp',
        'instagram',
        'bio',
        'quote',
    ];

    // ── 🔴 SUNTIKAN RELASI SAKTI: HUBUNGKAN STRUKTUR KE TABEL CLASSROOMS ──
    public function classroom()
    {
        // Menghubungkan kolom classroom_id di tabel siswas ke id di tabel classrooms
        return $this->belongsTo(Classroom::class, 'classroom_id')->withDefault([
            'id' => 0,
            'nama_kelas' => 'Belum Pilih Kelas' // Antisipasi aman biar gak pemicu eror null pointer 
        ]);
    }
}