<?php

namespace Database\Seeders;

use App\Models\Siswa; // Pastikan import Model Siswa di sini
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $siswas = [
            ['nis' => '2223001', 'nama' => 'Alexandre Dharma', 'jabatan' => 'Fullstack Developer'],
            ['nis' => '2223002', 'nama' => 'Aditya Pratama', 'jabatan' => 'UI/UX Designer'],
            ['nis' => '2223003', 'nama' => 'Ananda Putri', 'jabatan' => 'Frontend Developer'],
            ['nis' => '2223004', 'nama' => 'Bagus Setiawan', 'jabatan' => 'Backend Developer'],
            ['nis' => '2223005', 'nama' => 'Bunga Citra', 'jabatan' => 'Mobile Developer'],
            ['nis' => '2223006', 'nama' => 'Chandra Wijaya', 'jabatan' => 'DevOps Engineer'],
            ['nis' => '2223007', 'nama' => 'Daffa Ardiansyah', 'jabatan' => 'Quality Assurance'],
            ['nis' => '2223008', 'nama' => 'Dewi Sartika', 'jabatan' => 'System Analyst'],
            ['nis' => '2223009', 'nama' => 'Eka Saputra', 'jabatan' => 'Database Administrator'],
            ['nis' => '2223010', 'nama' => 'Fadhil Muhammad', 'jabatan' => 'Cyber Security'],
            ['nis' => '2223011', 'nama' => 'Gita Permata', 'jabatan' => 'Android Developer'],
            ['nis' => '2223012', 'nama' => 'Hendra Kurniawan', 'jabatan' => 'Fullstack Developer'],
            ['nis' => '2223013', 'nama' => 'Indah Cahyani', 'jabatan' => 'Product Manager'],
            ['nis' => '2223014', 'nama' => 'Joko Susilo', 'jabatan' => 'Technical Writer'],
            ['nis' => '2223015', 'nama' => 'Kurnia Ramadhan', 'jabatan' => 'Cloud Engineer'],
            ['nis' => '2223016', 'nama' => 'Lestari Putri', 'jabatan' => 'Frontend Developer'],
            ['nis' => '2223017', 'nama' => 'Mahendra Putra', 'jabatan' => 'Data Scientist'],
            ['nis' => '2223018', 'nama' => 'Nadia Rahma', 'jabatan' => 'UI Designer'],
            ['nis' => '2223019', 'nama' => 'Oka Antara', 'jabatan' => 'Game Developer'],
            ['nis' => '2223020', 'nama' => 'Putu Gede', 'jabatan' => 'iOS Developer'],
            ['nis' => '2223021', 'nama' => 'Qori Ananda', 'jabatan' => 'Network Engineer'],
            ['nis' => '2223022', 'nama' => 'Rizky Billar', 'jabatan' => 'Web Developer'],
            ['nis' => '2223023', 'nama' => 'Siti Aminah', 'jabatan' => 'QA Automation'],
            ['nis' => '2223024', 'nama' => 'Taufik Hidayat', 'jabatan' => 'Mobile Engineer'],
            ['nis' => '2223025', 'nama' => 'Umar Bin Khattab', 'jabatan' => 'Security Analyst'],
            ['nis' => '2223026', 'nama' => 'Vina Panduwinata', 'jabatan' => 'Digital Marketer'],
            ['nis' => '2223027', 'nama' => 'Wahyu Hidayat', 'jabatan' => 'SEO Specialist'],
            ['nis' => '2223028', 'nama' => 'Xena Gabriella', 'jabatan' => 'Content Creator'],
            ['nis' => '2223029', 'nama' => 'Yuda Pratama', 'jabatan' => 'Backend Developer'],
            ['nis' => '2223030', 'nama' => 'Zaskia Gotik', 'jabatan' => 'UX Researcher'],
            ['nis' => '2223031', 'nama' => 'Ahmad Dhani', 'jabatan' => 'Audio Engineer'],
            ['nis' => '2223032', 'nama' => 'Baim Wong', 'jabatan' => 'Video Editor'],
            ['nis' => '2223033', 'nama' => 'Chelsea Olivia', 'jabatan' => 'Graphic Designer'],
            ['nis' => '2223034', 'nama' => 'Deddy Corbuzier', 'jabatan' => 'Project Leader'],
        ];

        foreach ($siswas as $s) {
            \App\Models\Siswa::updateOrCreate(
                ['nis' => $s['nis']], // Cek berdasarkan NIS supaya tidak duplikat
                [
                    'nama' => $s['nama'],
                    'jabatan_dev' => $s['jabatan'],
                    'foto' => 'default.jpg'
                ]
            );
        }

        $this->command->info('Alhamdulillah, 34 data siswa berhasil masuk!');
    }
}