<?php

namespace Database\Seeders;

use App\Models\Classroom;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SiswaKelasSeeder extends Seeder
{
    private array $ayahNames = [
        'Budi Santoso', 'Agus Prasetyo', 'Rudi Hartono', 'Dedi Kurniawan', 'Hendra Wijaya',
        'Slamet Riyadi', 'Eko Saputra', 'Andi Setiawan', 'Arif Wibowo', 'Joko Susilo',
    ];

    private array $ibuNames = [
        'Siti Aminah', 'Sri Wahyuni', 'Rina Lestari', 'Dewi Anggraini', 'Nurhayati',
        'Fitri Handayani', 'Yuni Astuti', 'Anisa Rahma', 'Maya Sari', 'Lina Marlina',
    ];

    public function run(): void
    {
        $classroom = Classroom::where('nama_kelas', 'XI PPLG 4')->firstOrFail();

        $siswas = [
            ['no_absen' => 1, 'nis' => '541241001', 'nama' => 'ABSARI BEKTI SYAHFITRI', 'jenis_kelamin' => 'P'],
            ['no_absen' => 2, 'nis' => '541241003', 'nama' => 'ADARA AURORA KUSUMA', 'jenis_kelamin' => 'P'],
            ['no_absen' => 3, 'nis' => '541241009', 'nama' => 'AFFANDO FATHINATHA', 'jenis_kelamin' => 'L'],
            ['no_absen' => 4, 'nis' => '541241033', 'nama' => 'BIMA VALIANT ALENTRA WIMBO', 'jenis_kelamin' => 'L'],
            ['no_absen' => 5, 'nis' => '541241034', 'nama' => 'BINTANG NABA AL HAKIM', 'jenis_kelamin' => 'L'],
            ['no_absen' => 6, 'nis' => '541241042', 'nama' => 'DANISH ADELIO', 'jenis_kelamin' => 'L'],
            ['no_absen' => 7, 'nis' => '541241045', 'nama' => 'DEMAS BANYU BIRU', 'jenis_kelamin' => 'L'],
            ['no_absen' => 8, 'nis' => '541241050', 'nama' => 'DORETHA GELSEY ANEZKA', 'jenis_kelamin' => 'P'],
            ['no_absen' => 9, 'nis' => '541241056', 'nama' => "EVAN FA'ADILLAH PRAWIDYA", 'jenis_kelamin' => 'L'],
            ['no_absen' => 10, 'nis' => '541241059', 'nama' => 'FABIAN ROZAN FANANI', 'jenis_kelamin' => 'L'],
            ['no_absen' => 11, 'nis' => '541241062', 'nama' => 'FADHIL REKH SAPUTRA', 'jenis_kelamin' => 'L'],
            ['no_absen' => 12, 'nis' => '541241064', 'nama' => 'FAIRUZ HIDAYAT', 'jenis_kelamin' => 'L'],
            ['no_absen' => 13, 'nis' => '541241074', 'nama' => 'FIRMAN NOOR ADI NUGROHO', 'jenis_kelamin' => 'L'],
            ['no_absen' => 14, 'nis' => '541241082', 'nama' => 'HAJAR ASSYIFA ADHEAZASMI', 'jenis_kelamin' => 'P'],
            ['no_absen' => 15, 'nis' => '541241091', 'nama' => "IMTIYAZ FADHILAH 'AZMI", 'jenis_kelamin' => 'P'],
            ['no_absen' => 16, 'nis' => '541241106', 'nama' => 'KHAFIDZ RIZIQ IKHSANI', 'jenis_kelamin' => 'L'],
            ['no_absen' => 17, 'nis' => '541241125', 'nama' => 'MEZZALUNA AZZAFIRA', 'jenis_kelamin' => 'P'],
            ['no_absen' => 18, 'nis' => '541241132', 'nama' => 'MUHAMMAD ASHRAF AURAVYANO SAKA', 'jenis_kelamin' => 'L'],
            ['no_absen' => 19, 'nis' => '541241142', 'nama' => 'MUHAMMAD ROFIQ HIDAYAT', 'jenis_kelamin' => 'L'],
            ['no_absen' => 20, 'nis' => '541241149', 'nama' => 'NAIFA ASHILA HANDOYO', 'jenis_kelamin' => 'P'],
            ['no_absen' => 21, 'nis' => '541241152', 'nama' => 'NAWAF GADI AL-FATIH', 'jenis_kelamin' => 'L'],
            ['no_absen' => 22, 'nis' => '541241159', 'nama' => 'QUEENA AISYA PRASETYAWAN', 'jenis_kelamin' => 'P'],
            ['no_absen' => 23, 'nis' => '541241161', 'nama' => 'RAFI IBRAHIM', 'jenis_kelamin' => 'L'],
            ['no_absen' => 24, 'nis' => '541241164', 'nama' => 'RAJA FIDHIAZKA PRATAMA', 'jenis_kelamin' => 'L'],
            ['no_absen' => 25, 'nis' => '541241168', 'nama' => 'RAZYA FAHMI AFRIANTO', 'jenis_kelamin' => 'L'],
            ['no_absen' => 26, 'nis' => '541231192', 'nama' => 'RIZKY MADYACHANDRA RAMADHAN', 'jenis_kelamin' => 'L'],
            ['no_absen' => 27, 'nis' => '541241171', 'nama' => 'RONA MIFTAHULJANNAH', 'jenis_kelamin' => 'P'],
            ['no_absen' => 28, 'nis' => '541241178', 'nama' => 'SASKIA SYIFA SALSABILA', 'jenis_kelamin' => 'P'],
            ['no_absen' => 29, 'nis' => '541241185', 'nama' => 'SIAM AL SOBARI', 'jenis_kelamin' => 'L'],
            ['no_absen' => 30, 'nis' => '541241190', 'nama' => 'TANISHA NADIA HANZ', 'jenis_kelamin' => 'P'],
            ['no_absen' => 31, 'nis' => '541241191', 'nama' => 'TIYAS AYU LESTARI', 'jenis_kelamin' => 'P'],
            ['no_absen' => 32, 'nis' => '541241198', 'nama' => 'WISNU SATRIA SUJATMIKO', 'jenis_kelamin' => 'L'],
            ['no_absen' => 33, 'nis' => '541241199', 'nama' => 'WIWEKO SINUADI', 'jenis_kelamin' => 'L'],
            ['no_absen' => 34, 'nis' => '541241201', 'nama' => 'YUDHISTIRA', 'jenis_kelamin' => 'L'],
        ];

        foreach ($siswas as $siswa) {
            $user = User::updateOrCreate(
                ['nis' => $siswa['nis']],
                [
                    'name' => $siswa['nama'],
                    'email' => null,
                    'password' => Hash::make($siswa['nis']),
                    'role' => 'siswa',
                    'classroom_id' => $classroom->id,
                ]
            );

            DB::table('siswas')->updateOrInsert(
                ['nis' => $siswa['nis']],
                [
                    'user_id' => $user->id,
                    'classroom_id' => $classroom->id,
                    'no_absen' => $siswa['no_absen'],
                    'nama' => $siswa['nama'],
                    'jenis_kelamin' => $siswa['jenis_kelamin'],
                    'jabatan_dev' => 'Siswa',
                    'foto' => 'default.jpg',
                    'tanggal_lahir' => sprintf('%04d-%02d-%02d', 2008, (($siswa['no_absen'] - 1) % 12) + 1, (($siswa['no_absen'] - 1) % 28) + 1),
                    'whatsapp' => '08' . str_pad((string) (1200000000 + $siswa['no_absen']), 10, '0', STR_PAD_LEFT),
                    'instagram' => '@' . strtolower(preg_replace('/[^a-zA-Z0-9]/', '', explode(' ', $siswa['nama'])[0])) . $siswa['no_absen'],
                    'bio' => 'Siswa XI PPLG 4 SMK Telkom Purwokerto.',
                    'quote' => 'Belajar hari ini, sukses esok hari.',
                    'nama_ayah' => $this->ayahNames[($siswa['no_absen'] - 1) % count($this->ayahNames)],
                    'nama_ibu' => $this->ibuNames[($siswa['no_absen'] - 1) % count($this->ibuNames)],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}
