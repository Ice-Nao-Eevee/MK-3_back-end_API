<?php

namespace Database\Seeders;

use App\Models\Classroom;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $xiPplg4 = Classroom::where('nama_kelas', 'XI PPLG 4')->first();
        $xPplg1 = Classroom::where('nama_kelas', 'X PPLG 1')->first();
        $xiiPplg1 = Classroom::where('nama_kelas', 'XII PPLG 1')->first();

        User::updateOrCreate(
            ['email' => 'biebha@gmail.com'],
            [
                'name' => 'Biebha Arya Wirawan',
                'nis' => null,
                'password' => Hash::make('password123'),
                'role' => 'wali_kelas',
                'classroom_id' => $xiPplg4?->id,
            ]
        );

        User::updateOrCreate(
            ['email' => 'walas@gmail.com'],
            [
                'name' => 'Pak Guru Walas',
                'nis' => null,
                'password' => Hash::make('password123'),
                'role' => 'wali_kelas',
                'classroom_id' => $xiPplg4?->id,
            ]
        );

        User::updateOrCreate(
            ['email' => 'pakeko@gmail.com'],
            [
                'name' => 'Pak Eko',
                'nis' => null,
                'password' => Hash::make('password123'),
                'role' => 'wali_kelas',
                'classroom_id' => $xPplg1?->id,
            ]
        );

        User::updateOrCreate(
            ['email' => 'busri@gmail.com'],
            [
                'name' => 'Bu Sri',
                'nis' => null,
                'password' => Hash::make('password123'),
                'role' => 'wali_kelas',
                'classroom_id' => $xiiPplg1?->id,
            ]
        );

        User::updateOrCreate(
            ['email' => 'pplg4@gmail.com'],
            [
                'name' => 'Siswa PPLG 4',
                'nis' => null,
                'password' => Hash::make('password123'),
                'role' => 'siswa',
                'classroom_id' => $xiPplg4?->id,
            ]
        );

        User::updateOrCreate(
            ['email' => 'umum@gmail.com'],
            [
                'name' => 'Masyarakat Umum',
                'nis' => null,
                'password' => Hash::make('password123'),
                'role' => 'umum',
                'classroom_id' => null,
            ]
        );
    }
}
