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
        // 1. Jalankan Master Data Kelas Dulu (Wajib Paling Atas, Cong!)
        $this->call([
            ClassroomSeeder::class, 
        ]);

        // 2. Buat Akun Wali Kelas Spesifik (Data lama lu tetap aman nangkring di sini)
        User::create([
            'name'     => 'Biebha Arya Wirawan',
            'email'    => 'biebha@gmail.com',
            'password' => Hash::make('biebhaarya123'),
            'role'     => 'wali_kelas',
            // Catatan: Kalau mau langsung ditautin ke kelas XI PPLG 4, 
            // nanti tinggal ditambahin 'classroom_id' => id_kelasnya di sini su.
        ]);

        // 3. Jalankan Seeder Lainnya (User tambahan & Biodata Siswa lama)
        $this->call([
            UserSeeder::class,         // Akun role lainnya dari UserSeeder lu
            SiswaKelasSeeder::class,   // Data siswa lama dari temenmu
            SiswaDummySeeder::class,   // Data siswa dummy baru yang kita buat
        ]);
    }
}