<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Akun Wali Kelas
        User::create([
            'name' => 'Pak Guru Walas',
            'email' => 'walas@gmail.com',
            'password' => Hash::make('password123'),
            'role' => 'wali_kelas', // 🔴 Sesuai ENUM!
        ]);

        // 2. Akun Siswa XI PPLG 4
        User::create([
            'name' => 'Siswa PPLG 4',
            'email' => 'pplg4@gmail.com',
            'password' => Hash::make('password123'),
            'role' => 'siswa_pplg4', // 🔴 FIX: Kemarin 'xipplg4', diganti jadi 'siswa_pplg4' sesuai ENUM!
        ]);

        // 3. Akun Orang Umum
        User::create([
            'name' => 'Masyarakat Umum',
            'email' => 'umum@gmail.com',
            'password' => Hash::make('password123'),
            'role' => 'umum', // 🔴 FIX: Kemarin 'orang umum', diganti jadi 'umum' sesuai ENUM!
        ]);
    }
}