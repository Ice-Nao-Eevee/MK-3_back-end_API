<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
// 🔴 TAMBAHAN: Import class BelongsTo untuk relasi database
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Classroom; // 🔴 SUNTIK INI BIAR KAGAK NOT FOUND LAGI CONG!

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'nis', 
        'classroom_id', // 🔴 FIX: Wajib masukin ini biar data ID kelas bisa disimpan ke database su!
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    /**
     * 🔴 MODIFIKASI: Relasi ke Master Kelas (Classroom)
     * Hubungan darah: Satu User (Siswa/Walas) memiliki satu Kelas
     */
    public function classroom(): BelongsTo
    {
        return $this->belongsTo(Classroom::class, 'classroom_id');
    }
}