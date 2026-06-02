<?php

namespace Database\Seeders;

use App\Models\Classroom;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SiswaDummySeeder extends Seeder
{
    private array $names = [
        'Aditya Pratama', 'Nabila Putri', 'Raka Wijaya', 'Salsabila Zahra', 'Fahri Ramadhan',
        'Kayla Maharani', 'Rizky Saputra', 'Aulia Rahma', 'Dimas Prasetyo', 'Nayla Kirana',
        'Bagas Nugroho', 'Tiara Anindya', 'Ilham Maulana', 'Citra Lestari', 'Rafi Alfarizi',
        'Dewi Anggraini', 'Fajar Hidayat', 'Aisyah Fitri', 'Arkan Mahendra', 'Zahra Nasywa',
        'Gilang Permana', 'Putri Amelia', 'Rangga Saputra', 'Nadya Maharani', 'Alif Fauzan',
        'Niken Larasati', 'Yoga Kurniawan', 'Syifa Nuraini', 'Bima Santoso', 'Keisha Azzahra',
        'Farhan Akbar', 'Almira Putri', 'Reno Adhitama', 'Hana Salsabila', 'Rivaldi Firmansyah',
    ];

    private array $ayahNames = [
        'Bambang Saputra', 'Teguh Prasetyo', 'Rizal Maulana', 'Wahyu Hidayat', 'Feri Kurniawan',
        'Dian Nugroho', 'Herman Setiawan', 'Yoga Permana', 'Yanto Wijaya', 'Irfan Fauzi',
    ];

    private array $ibuNames = [
        'Ratna Sari', 'Endang Susanti', 'Murni Lestari', 'Kartika Dewi', 'Ayu Wulandari',
        'Rika Andriani', 'Nia Kurniasih', 'Siska Amelia', 'Vina Rahmawati', 'Putri Handayani',
    ];

    public function run(): void
    {
        $classrooms = Classroom::orderByRaw("FIELD(tingkat, 'X', 'XI', 'XII')")
            ->orderByRaw("FIELD(jurusan, 'PPLG', 'TJKT')")
            ->orderBy('nomor_kelas')
            ->get();

        foreach ($classrooms as $index => $classroom) {
            if ($classroom->nama_kelas === 'XI PPLG 4') {
                continue;
            }

            $name = $this->names[$index % count($this->names)] . ' ' . $classroom->nama_kelas;
            $nis = $this->makeNis($classroom->id);
            $gender = $index % 2 === 0 ? 'L' : 'P';

            $user = User::updateOrCreate(
                ['nis' => $nis],
                [
                    'name' => $name,
                    'email' => null,
                    'password' => Hash::make($nis),
                    'role' => 'siswa',
                    'classroom_id' => $classroom->id,
                ]
            );

            DB::table('siswas')->updateOrInsert(
                ['nis' => $nis],
                [
                    'user_id' => $user->id,
                    'classroom_id' => $classroom->id,
                    'no_absen' => 1,
                    'nama' => strtoupper($name),
                    'jenis_kelamin' => $gender,
                    'jabatan_dev' => 'Siswa',
                    'foto' => 'default.jpg',
                    'tanggal_lahir' => sprintf('%04d-%02d-%02d', 2008, (($index % 12) + 1), (($index % 28) + 1)),
                    'whatsapp' => '08' . str_pad((string) (1300000000 + $index), 10, '0', STR_PAD_LEFT),
                    'instagram' => '@demo' . strtolower(str_replace(' ', '', $classroom->nama_kelas)),
                    'bio' => 'Data dummy untuk demo School Hub SMK Telkom Purwokerto.',
                    'quote' => 'Belajar hari ini, sukses esok hari.',
                    'nama_ayah' => $this->ayahNames[$index % count($this->ayahNames)],
                    'nama_ibu' => $this->ibuNames[$index % count($this->ibuNames)],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }

    private function makeNis(int $classroomId): string
    {
        return '99' . str_pad((string) $classroomId, 4, '0', STR_PAD_LEFT) . '01';
    }
}
