<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ClassroomSeeder extends Seeder
{
    public function run(): void
    {
        // Matikan foreign key check biar aman dari amukan MySQL
        Schema::disableForeignKeyConstraints();
        
        DB::table('classrooms')->truncate();

        $classrooms = [];

        // ==================== KELAS X ====================
        for ($i = 1; $i <= 6; $i++) {
            $classrooms[] = [
                'nama_kelas' => 'X PPLG ' . $i,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        for ($i = 1; $i <= 5; $i++) {
            $classrooms[] = [
                'nama_kelas' => 'X TJKT ' . $i,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // ==================== KELAS XI ====================
        for ($i = 1; $i <= 7; $i++) {
            $classrooms[] = [
                'nama_kelas' => 'XI PPLG ' . $i,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        for ($i = 1; $i <= 5; $i++) {
            $classrooms[] = [
                'nama_kelas' => 'XI TJKT ' . $i,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // ==================== KELAS XII ====================
        for ($i = 1; $i <= 7; $i++) {
            $classrooms[] = [
                'nama_kelas' => 'XII PPLG ' . $i,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        for ($i = 1; $i <= 5; $i++) {
            $classrooms[] = [
                'nama_kelas' => 'XII TJKT ' . $i,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Masukkan semua data kelas ke database (Urutan ID dijamin tetep sama su!)
        DB::table('classrooms')->insert($classrooms);

        // Nyalain lagi sensor pengamannya
        Schema::enableForeignKeyConstraints();
    }
}