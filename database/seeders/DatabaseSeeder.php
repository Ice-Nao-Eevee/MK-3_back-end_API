<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Buat Akun Wali Kelas Spesifik (Data dari Stash kamu)
        User::create([
            'name'     => 'Biebha Arya Wirawan',
            'email'    => 'biebha@gmail.com',
            'password' => Hash::make('biebhaarya123'),
            'role'     => 'wali_kelas',
        ]);

        // 2. Jalankan Seeder Siswa (Data terbaru dari Main/Temanmu)
        $this->call([
            SiswaKelasSeeder::class,
        ]);
    }
}