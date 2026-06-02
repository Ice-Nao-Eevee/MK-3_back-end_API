<?php

namespace Database\Seeders;

use App\Models\Classroom;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ScheduleSeeder extends Seeder
{
    private array $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];

    private array $regularSlots = [
        ['07:00:00', '07:40:00'],
        ['07:40:00', '08:20:00'],
        ['08:20:00', '08:50:00'],
        ['08:50:00', '09:30:00'],
        ['09:30:00', '10:10:00'],
        ['10:10:00', '10:50:00'],
        ['10:50:00', '11:30:00'],
        ['11:30:00', '12:10:00'],
        ['13:10:00', '13:50:00'],
        ['13:50:00', '14:30:00'],
        ['14:30:00', '15:10:00'],
        ['15:10:00', '15:50:00'],
    ];

    private array $fridaySlots = [
        ['07:00:00', '07:40:00'],
        ['07:40:00', '08:20:00'],
        ['08:20:00', '08:50:00'],
        ['08:50:00', '09:30:00'],
        ['09:30:00', '10:10:00'],
        ['10:10:00', '10:50:00'],
        ['10:50:00', '11:30:00'],
        ['12:50:00', '13:30:00'],
        ['13:30:00', '14:10:00'],
        ['14:10:00', '14:50:00'],
        ['14:50:00', '15:30:00'],
    ];

    private array $teachers = [
        'Basis Data' => 'Fendi Riawan',
        'Pemrograman Web' => 'Aris Puji Santoso',
        'Pemrograman Mobile' => 'Dimas Prasetyo',
        'Bahasa Indonesia' => 'Desti Nurcahyani',
        'Bahasa Inggris' => 'Rina Wulandari',
        'Matematika' => 'Wulan Handayani',
        'BK' => 'Nia Rahmawati',
        'PJOK' => 'Rudi Hartono',
        'Sejarah' => 'Agus Setiawan',
        'PPKn' => 'Siti Aminah',
        'Bahasa Jawa' => 'Sri Lestari',
        'Pendidikan Agama' => 'Ahmad Fauzi',
        'Produktif PPLG' => 'Arif Rahman',
        'Jaringan Komputer' => 'Rizal Maulana',
        'Administrasi Sistem Jaringan' => 'Eko Prasetyo',
        'Konsentrasi Keahlian' => 'Guru Produktif',
        'Projek Kreatif' => 'Tim Projek',
        'Literasi Sekolah' => 'Wali Kelas',
    ];

    private array $rooms = ['A.1.2', 'A.1.3', 'A.2.3', 'A.3.4', 'B.1.1', 'B.2.1', 'B.3.2', 'C.2.2', 'D.1.1', 'RPS-SEL'];

    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        DB::table('schedules')->truncate();
        Schema::enableForeignKeyConstraints();

        $rows = [];
        $classrooms = Classroom::orderBy('id')->get();

        foreach ($classrooms as $classIndex => $classroom) {
            foreach ($this->days as $dayIndex => $day) {
                $slots = $day === 'Jumat' ? $this->fridaySlots : $this->regularSlots;
                $subjects = $this->subjectsFor($classroom->tingkat, $classroom->jurusan, $classroom->nama_kelas, $dayIndex, $classIndex);
                $rooms = $this->roomsFor($classroom->tingkat, $classroom->jurusan, $classroom->nama_kelas, $dayIndex, $classIndex);

                foreach ($slots as $slotIndex => $slot) {
                    $subject = $subjects[$slotIndex % count($subjects)];
                    $room = $rooms[$slotIndex % count($rooms)];

                    $rows[] = [
                        'classroom_id' => $classroom->id,
                        'day' => $day,
                        'subject_name' => $subject,
                        'teacher_name' => $this->teachers[$this->baseSubject($subject)] ?? 'Guru SMK Telkom',
                        'room' => $room,
                        'start_time' => $slot[0],
                        'end_time' => $slot[1],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }
        }

        foreach (array_chunk($rows, 500) as $chunk) {
            DB::table('schedules')->insert($chunk);
        }
    }

    private function subjectsFor(string $tingkat, string $jurusan, string $namaKelas, int $dayIndex, int $classIndex): array
    {
        if ($tingkat === 'XI') {
            return $this->xiSubjects($jurusan, $namaKelas, $dayIndex, $classIndex);
        }

        if ($jurusan === 'PPLG') {
            $subjects = [
                ['Pemrograman Web', 'Basis Data', 'Bahasa Indonesia', 'Matematika', 'BK', 'Produktif PPLG'],
                ['Pemrograman Mobile', 'PPKn', 'Bahasa Inggris', 'Projek Kreatif', 'PJOK', 'Produktif PPLG'],
                ['Basis Data', 'Sejarah', 'Bahasa Jawa', 'Pemrograman Web', 'Matematika', 'Pendidikan Agama'],
                ['Produktif PPLG', 'Pemrograman Mobile', 'Bahasa Indonesia', 'BK', 'Projek Kreatif', 'Bahasa Inggris'],
                ['Literasi Sekolah', 'Pendidikan Agama', 'PJOK', 'Basis Data', 'Pemrograman Web'],
            ];
        } else {
            $subjects = [
                ['Jaringan Komputer', 'Administrasi Sistem Jaringan', 'Bahasa Indonesia', 'Matematika', 'BK', 'Konsentrasi Keahlian'],
                ['Administrasi Sistem Jaringan', 'PPKn', 'Bahasa Inggris', 'Projek Kreatif', 'PJOK', 'Konsentrasi Keahlian'],
                ['Jaringan Komputer', 'Sejarah', 'Bahasa Jawa', 'Administrasi Sistem Jaringan', 'Matematika', 'Pendidikan Agama'],
                ['Konsentrasi Keahlian', 'Jaringan Komputer', 'Bahasa Indonesia', 'BK', 'Projek Kreatif', 'Bahasa Inggris'],
                ['Literasi Sekolah', 'Pendidikan Agama', 'PJOK', 'Jaringan Komputer', 'Administrasi Sistem Jaringan'],
            ];
        }

        return $this->rotate($subjects[$dayIndex], $classIndex);
    }

    private function xiSubjects(string $jurusan, string $namaKelas, int $dayIndex, int $classIndex): array
    {
        $pplg4 = [
            ['Bahasa Indonesia (INA-2)', 'Projek Kreatif (MP1-A)', 'BK (BK-2)', 'Matematika (MTK-3)', 'Basis Data (MK2-B)', 'PJOK (JOK-2)'],
            ['PJOK (JOK-2)', 'Pemrograman Web (MK3-A)', 'Projek Kreatif (MP1-A)', 'Basis Data (MK2-B)', 'Matematika (MTK-3)', 'Pemrograman Mobile (MK1-A)', 'Produktif PPLG (MK4-B)'],
            ['Bahasa Inggris (ING-4)', 'Produktif PPLG (MK4-A)', 'Basis Data (MK2-B)', 'PPKn (PPc-1)', 'Bahasa Indonesia (INA-2)', 'Konsentrasi Keahlian (KIK-A)'],
            ['Bahasa Jawa (BJW-1)', 'Basis Data (MK2-B)', 'Bahasa Inggris (ING-4)', 'Bahasa Indonesia (INA-2)', 'Konsentrasi Keahlian (KIK-A)', 'Projek Kreatif (MP1-A)'],
            ['Pendidikan Agama (PAI-1)', 'Bahasa Indonesia (INA-3)', 'Produktif PPLG (MK4-A)', 'Matematika (MTK-3)', 'Konsentrasi Keahlian (KIK-A)', 'BK (BK-4)'],
        ];

        if ($namaKelas === 'XI PPLG 4') {
            return $pplg4[$dayIndex];
        }

        if ($jurusan === 'PPLG') {
            $base = [
                ['Pemrograman Web (MK3-A)', 'Basis Data (MK2-B)', 'Bahasa Indonesia (INA-2)', 'Matematika (MTK-3)', 'Konsentrasi Keahlian (KIK-A)', 'BK (BK-2)'],
                ['Pemrograman Mobile (MK1-A)', 'Projek Kreatif (MP1-A)', 'Bahasa Inggris (ING-2)', 'PPKn (PPc-1)', 'Basis Data (MK2-A)', 'PJOK (JOK-1)'],
                ['Produktif PPLG (MK4-A)', 'Bahasa Jawa (BJW-1)', 'Sejarah (SEJ-2)', 'Pemrograman Web (MK3-B)', 'Matematika (MTK-4)', 'Pendidikan Agama (PAI-1)'],
                ['Basis Data (MK2-B)', 'Projek Kreatif (MP1-A)', 'Bahasa Indonesia (INA-1)', 'Konsentrasi Keahlian (KIK-B)', 'BK (BK-4)', 'Bahasa Inggris (ING-4)'],
                ['Literasi Sekolah', 'Pendidikan Agama (PAI-3)', 'PJOK (JOK-2)', 'Produktif PPLG (MK4-B)', 'Sejarah (SEJ-1)'],
            ];
        } else {
            $base = [
                ['Jaringan Komputer (MP1)', 'Administrasi Sistem Jaringan (MK1)', 'Bahasa Indonesia (INA-2)', 'Matematika (MTK-2)', 'BK (BK-4)', 'Konsentrasi Keahlian (KIK-B)'],
                ['Jaringan Komputer (MK3-A)', 'Bahasa Inggris (ING-2)', 'PPKn (PPc-1)', 'Sejarah (SEJ-2)', 'Matematika (MTK-4)', 'PJOK (JOK-1)'],
                ['Produktif TJKT (MK2-A)', 'Bahasa Jawa (BJW-1)', 'Administrasi Sistem Jaringan (MK2-B)', 'Konsentrasi Keahlian (KIK-A)', 'Pendidikan Agama (PAI-1)', 'BK (BK-2)'],
                ['Jaringan Komputer (MK3-B)', 'Bahasa Indonesia (INA-1)', 'Projek Kreatif (MP1-A)', 'Konsentrasi Keahlian (KIK-C)', 'Bahasa Inggris (ING-4)', 'Sejarah (SEJ-1)'],
                ['Literasi Sekolah', 'Pendidikan Agama (PAI-3)', 'PJOK (JOK-2)', 'Produktif TJKT (MK4-B)', 'Konsentrasi Keahlian (KIK-B)'],
            ];
        }

        return $this->rotate($base[$dayIndex], $classIndex);
    }

    private function roomsFor(string $tingkat, string $jurusan, string $namaKelas, int $dayIndex, int $classIndex): array
    {
        if ($tingkat === 'XI') {
            if ($namaKelas === 'XI PPLG 4') {
                return [
                    ['A.2.3', 'RPS-SEL', 'B.2.5', 'A.2.8', 'B.3.3', 'B.2.1'],
                    ['D.1.1', 'A.3.4', 'B.2.1', 'A.1.5', 'C.3.2', 'B.1.4'],
                    ['A.3.5', 'B.3.2', 'A.1.3', 'B.1.2', 'B.1.1', 'D.1.1'],
                    ['A.2.3', 'B.1.4', 'A.2.1', 'B.2.3', 'C.3.1', 'A.3.2'],
                    ['A.1.4', 'A.2.3', 'A.3.5', 'B.2.1', 'C.2.2'],
                ][$dayIndex];
            }

            return $this->rotate($this->rooms, $classIndex + $dayIndex);
        }

        $prefixRooms = $jurusan === 'PPLG'
            ? ['Lab RPL 1', 'Lab RPL 2', 'A.2.1', 'A.2.2', 'B.1.1', 'B.2.1']
            : ['Lab TJKT 1', 'Lab TJKT 2', 'B.2.3', 'B.3.1', 'A.1.2', 'A.3.1'];

        return $this->rotate($prefixRooms, $classIndex + $dayIndex);
    }

    private function baseSubject(string $subject): string
    {
        return trim(preg_replace('/\s*\([^)]*\)/', '', $subject));
    }

    private function rotate(array $items, int $offset): array
    {
        $count = count($items);
        if ($count === 0) {
            return $items;
        }

        $offset = $offset % $count;
        return array_merge(array_slice($items, $offset), array_slice($items, 0, $offset));
    }
}
