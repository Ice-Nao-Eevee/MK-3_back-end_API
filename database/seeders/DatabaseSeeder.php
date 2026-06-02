<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $this->call([
            ClassroomSeeder::class,
            UserSeeder::class,
            SiswaKelasSeeder::class,
            SiswaDummySeeder::class,
            ScheduleSeeder::class,
        ]);
    }
}
