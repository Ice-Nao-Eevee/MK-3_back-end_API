<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // ==========================================
        // 1. KELOMPOK AKUN WALI KELAS DUMMY (LINTAS TINGKAT)
        // ==========================================

        // Akun Bu Biebha (Wali Kelas XI PPLG 4)
        User::updateOrCreate(
            ['email' => 'biebha@gmail.com'], // Kalau email ini udah ada, di-update! Kalau belum, di-create!
            [
                'name' => 'Bu Biebha',
                'password' => Hash::make('password123'),
                'role' => 'wali_kelas',
                'classroom_id' => 15,
            ]
        );

        // Akun Pak Eko (Wali Kelas X PPLG 1)
        User::updateOrCreate(
            ['email' => 'pakeko@gmail.com'],
            [
                'name' => 'Pak Eko (Walas X)',
                'password' => Hash::make('password123'),
                'role' => 'wali_kelas',
                'classroom_id' => 1,
            ]
        );

        // Akun Bu Sri (Wali Kelas XII PPLG 1)
        User::updateOrCreate(
            ['email' => 'busri@gmail.com'],
            [
                'name' => 'Bu Sri (Walas XII)',
                'password' => Hash::make('password123'),
                'role' => 'wali_kelas',
                'classroom_id' => 25,
            ]
        );


        // ==========================================
        // 2. KELOMPOK AKUN SISWA DAN UMUM
        // ==========================================

        // Akun Siswa
        User::updateOrCreate(
            ['email' => 'pplg4@gmail.com'],
            [
                'name' => 'Siswa PPLG 4',
                'password' => Hash::make('password123'),
                'role' => 'siswa',
            ]
        );

        // Akun Orang Umum
        User::updateOrCreate(
            ['email' => 'umum@gmail.com'],
            [
                'name' => 'Masyarakat Umum',
                'password' => Hash::make('password123'),
                'role' => 'umum',
            ]
        );
    }
}