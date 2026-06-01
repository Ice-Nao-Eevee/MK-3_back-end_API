<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SiswaDummySeeder extends Seeder
{
    public function run(): void
    {
        // 1. Ambil semua kelas yang terdaftar di database
        $classrooms = DB::table('classrooms')->get();

        foreach ($classrooms ?? [] as $class) {
            // 🔴 SKALPING: Kalau ID-nya 15 (XI PPLG 4), SKIP! Biar data asli lu aman.
            if ($class->id == 15) {
                continue;
            }

            // 2. Bikin 2 siswa dummy per kelas
            for ($i = 1; $i <= 2; $i++) {
                
                // Generate NIS dummy unik berdasarkan ID kelas (Cth kelas ID 1 anak ke 1: 5410101)
                $dummyNis = '541' . str_pad($class->id, 2, '0', STR_PAD_LEFT) . str_pad($i, 2, '0', STR_PAD_LEFT);
                $namaSiswa = 'Dummy Siswa ' . $i . ' ' . $class->nama_kelas;

                // A. Buat Akun Login di tabel 'users'
                $userId = DB::table('users')->insertGetId([
                    'name' => $namaSiswa,
                    'nis' => $dummyNis,
                    'email' => null, // Login murni pake NIS
                    'password' => Hash::make($dummyNis), // Password disamain kayak NIS dummy-nya
                    'role' => 'siswa',
                    'classroom_id' => $class->id, // Hubungkan ke ID kelasnya
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                // B. Buat Biodata di tabel 'siswas'
                DB::table('siswas')->insert([
                    'user_id' => $userId,
                    'classroom_id' => $class->id,
                    'no_absen' => $i,
                    'nis' => $dummyNis,
                    'nama' => $namaSiswa,
                    'jenis_kelamin' => $i == 1 ? 'L' : 'P', // Anak pertama Laki-laki, anak kedua Perempuan
                    'jabatan_dev' => 'Siswa',
                    'foto' => 'default.jpg',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}