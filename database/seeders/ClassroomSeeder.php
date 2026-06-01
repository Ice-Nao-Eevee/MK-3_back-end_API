<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ClassroomSeeder extends Seeder
{
    public function run(): void
    {
        // 🔴 FIX: Matikan foreign key check biar aman dari ngamuknya MySQL
        Schema::disableForeignKeyConstraints();
        
        // Sekarang truncate dijamin lolos aman jaya
        DB::table('classrooms')->truncate();

        $classrooms = [];

        // ==================== KELAS X ====================
        for ($i = 1; $i <= 6; $i++) {
            $classrooms[] = [
                'tingkat' => 'X',
                'jurusan' => 'PPLG',
                'nama_kelas' => 'X PPLG ' . $i,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        for ($i = 1; $i <= 5; $i++) {
            $classrooms[] = [
                'tingkat' => 'X',
                'jurusan' => 'TJKT',
                'nama_kelas' => 'X TJKT ' . $i,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // ==================== KELAS XI ====================
        for ($i = 1; $i <= 7; $i++) {
            $classrooms[] = [
                'tingkat' => 'XI',
                'jurusan' => 'PPLG',
                'nama_kelas' => 'XI PPLG ' . $i,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        for ($i = 1; $i <= 5; $i++) {
            $classrooms[] = [
                'tingkat' => 'XI',
                'jurusan' => 'TJKT',
                'nama_kelas' => 'XI TJKT ' . $i,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // ==================== KELAS XII ====================
        for ($i = 1; $i <= 7; $i++) {
            $classrooms[] = [
                'tingkat' => 'XII',
                'jurusan' => 'PPLG',
                'nama_kelas' => 'XII PPLG ' . $i,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        for ($i = 1; $i <= 5; $i++) {
            $classrooms[] = [
                'tingkat' => 'XII',
                'jurusan' => 'TJKT',
                'nama_kelas' => 'XII TJKT ' . $i,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Masukkan semua data kelas (total ada 35 kelas)
        DB::table('classrooms')->insert($classrooms);

        // 🔴 FIX: Nyalain lagi sensor pengamannya setelah selesai input data
        Schema::enableForeignKeyConstraints();
    }
}