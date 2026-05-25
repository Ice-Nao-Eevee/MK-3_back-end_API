<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    // 🛠️ MODIFIKASI: Daftarkan semua kolom baru agar diizinkan masuk ke database MySQL
    protected $fillable = [
    'no_absen',
    'nis',
    'nama',
    'jenis_kelamin',
    'jabatan_dev',
    'foto',             // Ini nanti bakal nyimpen URL secure_url dari Cloudinary
    'profile_public_id', // 👈 Tambahin ini di model & di database lewat phpMyAdmin jika diperlukan, atau jadikan satu fungsi mandiri
    'tanggal_lahir',
    'whatsapp',
    'instagram',
    'bio',
    'quote',
];
}