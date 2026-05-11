<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SiswaKelasSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('siswas')->truncate();

        DB::table('siswas')->insert([
            ['no_absen' => 1, 'nis' => '541241001', 'nama' => 'ABSARI BEKTI SYAHFITRI', 'jenis_kelamin' => 'P', 'jabatan_dev' => 'Siswa', 'foto' => 'default.jpg', 'created_at' => now(), 'updated_at' => now()],
            ['no_absen' => 2, 'nis' => '541241003', 'nama' => 'ADARA AURORA KUSUMA', 'jenis_kelamin' => 'P', 'jabatan_dev' => 'Siswa', 'foto' => 'default.jpg', 'created_at' => now(), 'updated_at' => now()],
            ['no_absen' => 3, 'nis' => '541241009', 'nama' => 'AFFANDO FATHINATHA', 'jenis_kelamin' => 'L', 'jabatan_dev' => 'Siswa', 'foto' => 'default.jpg', 'created_at' => now(), 'updated_at' => now()],
            ['no_absen' => 4, 'nis' => '541241033', 'nama' => 'BIMA VALIANT ALENTRA WIMBO', 'jenis_kelamin' => 'L', 'jabatan_dev' => 'Siswa', 'foto' => 'default.jpg', 'created_at' => now(), 'updated_at' => now()],
            ['no_absen' => 5, 'nis' => '541241034', 'nama' => 'BINTANG NABA AL HAKIM', 'jenis_kelamin' => 'L', 'jabatan_dev' => 'Siswa', 'foto' => 'default.jpg', 'created_at' => now(), 'updated_at' => now()],
            ['no_absen' => 6, 'nis' => '541241042', 'nama' => 'DANISH ADELIO', 'jenis_kelamin' => 'L', 'jabatan_dev' => 'Siswa', 'foto' => 'default.jpg', 'created_at' => now(), 'updated_at' => now()],
            ['no_absen' => 7, 'nis' => '541241045', 'nama' => 'DEMAS BANYU BIRU', 'jenis_kelamin' => 'L', 'jabatan_dev' => 'Siswa', 'foto' => 'default.jpg', 'created_at' => now(), 'updated_at' => now()],
            ['no_absen' => 8, 'nis' => '541241050', 'nama' => 'DORETHA GELSEY ANEZKA', 'jenis_kelamin' => 'P', 'jabatan_dev' => 'Siswa', 'foto' => 'default.jpg', 'created_at' => now(), 'updated_at' => now()],
            ['no_absen' => 9, 'nis' => '541241056', 'nama' => "EVAN FA'ADILLAH PRAWIDYA", 'jenis_kelamin' => 'L', 'jabatan_dev' => 'Siswa', 'foto' => 'default.jpg', 'created_at' => now(), 'updated_at' => now()],
            ['no_absen' => 10, 'nis' => '541241059', 'nama' => 'FABIAN ROZAN FANANI', 'jenis_kelamin' => 'L', 'jabatan_dev' => 'Siswa', 'foto' => 'default.jpg', 'created_at' => now(), 'updated_at' => now()],
            ['no_absen' => 11, 'nis' => '541241062', 'nama' => 'FADHIL REKH SAPUTRA', 'jenis_kelamin' => 'L', 'jabatan_dev' => 'Siswa', 'foto' => 'default.jpg', 'created_at' => now(), 'updated_at' => now()],
            ['no_absen' => 12, 'nis' => '541241064', 'nama' => 'FAIRUZ HIDAYAT', 'jenis_kelamin' => 'L', 'jabatan_dev' => 'Siswa', 'foto' => 'default.jpg', 'created_at' => now(), 'updated_at' => now()],
            ['no_absen' => 13, 'nis' => '541241074', 'nama' => 'FIRMAN NOOR ADI NUGROHO', 'jenis_kelamin' => 'L', 'jabatan_dev' => 'Siswa', 'foto' => 'default.jpg', 'created_at' => now(), 'updated_at' => now()],
            ['no_absen' => 14, 'nis' => '541241082', 'nama' => 'HAJAR ASSYIFA ADHEAZASMI', 'jenis_kelamin' => 'P', 'jabatan_dev' => 'Siswa', 'foto' => 'default.jpg', 'created_at' => now(), 'updated_at' => now()],
            ['no_absen' => 15, 'nis' => '541241091', 'nama' => "IMTIYAZ FADHILAH 'AZMI", 'jenis_kelamin' => 'P', 'jabatan_dev' => 'Siswa', 'foto' => 'default.jpg', 'created_at' => now(), 'updated_at' => now()],
            ['no_absen' => 16, 'nis' => '541241106', 'nama' => 'KHAFIDZ RIZIQ IKHSANI', 'jenis_kelamin' => 'L', 'jabatan_dev' => 'Siswa', 'foto' => 'default.jpg', 'created_at' => now(), 'updated_at' => now()],
            ['no_absen' => 17, 'nis' => '541241125', 'nama' => 'MEZZALUNA AZZAFIRA', 'jenis_kelamin' => 'P', 'jabatan_dev' => 'Siswa', 'foto' => 'default.jpg', 'created_at' => now(), 'updated_at' => now()],
            ['no_absen' => 18, 'nis' => '541241132', 'nama' => 'MUHAMMAD ASHRAF AURAVYANO SAKA', 'jenis_kelamin' => 'L', 'jabatan_dev' => 'Siswa', 'foto' => 'default.jpg', 'created_at' => now(), 'updated_at' => now()],
            ['no_absen' => 19, 'nis' => '541241142', 'nama' => 'MUHAMMAD ROFIQ HIDAYAT', 'jenis_kelamin' => 'L', 'jabatan_dev' => 'Siswa', 'foto' => 'default.jpg', 'created_at' => now(), 'updated_at' => now()],
            ['no_absen' => 20, 'nis' => '541241149', 'nama' => 'NAIFA ASHILA HANDOYO', 'jenis_kelamin' => 'P', 'jabatan_dev' => 'Siswa', 'foto' => 'default.jpg', 'created_at' => now(), 'updated_at' => now()],
            ['no_absen' => 21, 'nis' => '541241152', 'nama' => 'NAWAF GADI AL-FATIH', 'jenis_kelamin' => 'L', 'jabatan_dev' => 'Siswa', 'foto' => 'default.jpg', 'created_at' => now(), 'updated_at' => now()],
            ['no_absen' => 22, 'nis' => '541241159', 'nama' => 'QUEENA AISYA PRASETYAWAN', 'jenis_kelamin' => 'P', 'jabatan_dev' => 'Siswa', 'foto' => 'default.jpg', 'created_at' => now(), 'updated_at' => now()],
            ['no_absen' => 23, 'nis' => '541241161', 'nama' => 'RAFI IBRAHIM', 'jenis_kelamin' => 'L', 'jabatan_dev' => 'Siswa', 'foto' => 'default.jpg', 'created_at' => now(), 'updated_at' => now()],
            ['no_absen' => 24, 'nis' => '541241164', 'nama' => 'RAJA FIDHIAZKA PRATAMA', 'jenis_kelamin' => 'L', 'jabatan_dev' => 'Siswa', 'foto' => 'default.jpg', 'created_at' => now(), 'updated_at' => now()],
            ['no_absen' => 25, 'nis' => '541241168', 'nama' => 'RAZYA FAHMI AFRIANTO', 'jenis_kelamin' => 'L', 'jabatan_dev' => 'Siswa', 'foto' => 'default.jpg', 'created_at' => now(), 'updated_at' => now()],
            ['no_absen' => 26, 'nis' => '541231192', 'nama' => 'RIZKY MADYACHANDRA RAMADHAN', 'jenis_kelamin' => 'L', 'jabatan_dev' => 'Siswa', 'foto' => 'default.jpg', 'created_at' => now(), 'updated_at' => now()],
            ['no_absen' => 27, 'nis' => '541241171', 'nama' => 'RONA MIFTAHULJANNAH', 'jenis_kelamin' => 'P', 'jabatan_dev' => 'Siswa', 'foto' => 'default.jpg', 'created_at' => now(), 'updated_at' => now()],
            ['no_absen' => 28, 'nis' => '541241178', 'nama' => 'SASKIA SYIFA SALSABILA', 'jenis_kelamin' => 'P', 'jabatan_dev' => 'Siswa', 'foto' => 'default.jpg', 'created_at' => now(), 'updated_at' => now()],
            ['no_absen' => 29, 'nis' => '541241185', 'nama' => 'SIAM AL SOBARI', 'jenis_kelamin' => 'L', 'jabatan_dev' => 'Siswa', 'foto' => 'default.jpg', 'created_at' => now(), 'updated_at' => now()],
            ['no_absen' => 30, 'nis' => '541241190', 'nama' => 'TANISHA NADIA HANZ', 'jenis_kelamin' => 'P', 'jabatan_dev' => 'Siswa', 'foto' => 'default.jpg', 'created_at' => now(), 'updated_at' => now()],
            ['no_absen' => 31, 'nis' => '541241191', 'nama' => 'TIYAS AYU LESTARI', 'jenis_kelamin' => 'P', 'jabatan_dev' => 'Siswa', 'foto' => 'default.jpg', 'created_at' => now(), 'updated_at' => now()],
            ['no_absen' => 32, 'nis' => '541241198', 'nama' => 'WISNU SATRIA SUJATMIKO', 'jenis_kelamin' => 'L', 'jabatan_dev' => 'Siswa', 'foto' => 'default.jpg', 'created_at' => now(), 'updated_at' => now()],
            ['no_absen' => 33, 'nis' => '541241199', 'nama' => 'WIWEKO SINUADI', 'jenis_kelamin' => 'L', 'jabatan_dev' => 'Siswa', 'foto' => 'default.jpg', 'created_at' => now(), 'updated_at' => now()],
            ['no_absen' => 34, 'nis' => '541241201', 'nama' => 'YUDHISTIRA', 'jenis_kelamin' => 'L', 'jabatan_dev' => 'Siswa', 'foto' => 'default.jpg', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}