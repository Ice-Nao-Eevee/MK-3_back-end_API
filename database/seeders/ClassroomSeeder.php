<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ClassroomSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        DB::table('classrooms')->truncate();
        Schema::enableForeignKeyConstraints();

        $classrooms = [];

        foreach (['X', 'XI', 'XII'] as $tingkat) {
            foreach (['PPLG', 'TJKT'] as $jurusan) {
                $max = $jurusan === 'PPLG' ? ($tingkat === 'X' ? 6 : 7) : 5;

                for ($i = 1; $i <= $max; $i++) {
                    $classrooms[] = [
                        'tingkat' => $tingkat,
                        'jurusan' => $jurusan,
                        'nomor_kelas' => $i,
                        'nama_kelas' => "{$tingkat} {$jurusan} {$i}",
                        'is_active' => true,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }
        }

        DB::table('classrooms')->insert($classrooms);
    }
}
