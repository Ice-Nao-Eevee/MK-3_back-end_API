<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Classroom;
use App\Models\Schedule;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index(Request $request)
    {
        $kelas = $request->query('kelas');

        $classroom = Classroom::where('nama_kelas', $kelas)->first();

        if (!$classroom) {
            return response()->json([
                'success' => false,
                'message' => 'Kelas tidak ditemukan.',
                'data' => [],
            ], 404);
        }

        $schedules = Schedule::where('classroom_id', $classroom->id)
            ->orderByRaw("FIELD(day, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu')")
            ->orderBy('start_time')
            ->get()
            ->map(fn (Schedule $schedule) => $this->formatSchedule($schedule, $classroom->nama_kelas));

        return response()->json([
            'success' => true,
            'message' => 'Jadwal kelas berhasil dimuat.',
            'kelas' => $classroom->nama_kelas,
            'data' => $schedules,
        ]);
    }

    public function current(Request $request)
    {
        $kelas = $request->query('kelas', 'XI PPLG 4');
        $classroom = Classroom::where('nama_kelas', $kelas)->first();

        if (!$classroom) {
            return response()->json([
                'success' => false,
                'status' => 'belum_tersedia',
                'message' => 'Jadwal kelas ini belum tersedia.',
                'kelas' => $kelas,
                'current' => null,
                'next' => null,
                'holiday' => null,
                'today_schedules' => [],
            ], 404);
        }

        $now = Carbon::now('Asia/Jakarta');
        $holiday = $this->holidayFor($now);

        if ($holiday) {
            return response()->json([
                'success' => true,
                'status' => 'libur',
                'message' => 'Hari ini libur.',
                'kelas' => $classroom->nama_kelas,
                'current' => null,
                'next' => null,
                'holiday' => $holiday,
                'today_schedules' => [],
            ]);
        }

        $day = $this->indonesianDay($now);

        if ($day === 'Minggu') {
            return response()->json([
                'success' => true,
                'status' => 'selesai',
                'message' => 'Hari Minggu tidak ada jadwal pelajaran.',
                'kelas' => $classroom->nama_kelas,
                'current' => null,
                'next' => null,
                'holiday' => null,
                'today_schedules' => [],
            ]);
        }

        $todaySchedules = Schedule::where('classroom_id', $classroom->id)
            ->where('day', $day)
            ->orderBy('start_time')
            ->get();

        if ($todaySchedules->isEmpty()) {
            return response()->json([
                'success' => true,
                'status' => 'belum_tersedia',
                'message' => 'Jadwal untuk hari ini belum tersedia.',
                'kelas' => $classroom->nama_kelas,
                'current' => null,
                'next' => null,
                'holiday' => null,
                'today_schedules' => [],
            ]);
        }

        $time = $now->format('H:i:s');

        $current = $todaySchedules->first(function (Schedule $schedule) use ($time) {
            return $schedule->start_time <= $time && $schedule->end_time > $time;
        });

        $next = $todaySchedules->first(function (Schedule $schedule) use ($time) {
            return $schedule->start_time > $time;
        });

        $today = $todaySchedules
            ->map(fn (Schedule $schedule) => $this->formatSchedule($schedule, $classroom->nama_kelas))
            ->values();

        if ($current) {
            return response()->json([
                'success' => true,
                'status' => 'berlangsung',
                'message' => 'Jadwal sedang berlangsung.',
                'kelas' => $classroom->nama_kelas,
                'current' => $this->formatSchedule($current, $classroom->nama_kelas),
                'next' => $next ? $this->formatSchedule($next, $classroom->nama_kelas) : null,
                'holiday' => null,
                'today_schedules' => $today,
            ]);
        }

        if ($next) {
            return response()->json([
                'success' => true,
                'status' => 'istirahat',
                'message' => 'Sedang tidak ada pelajaran. Menunggu jadwal berikutnya.',
                'kelas' => $classroom->nama_kelas,
                'current' => null,
                'next' => $this->formatSchedule($next, $classroom->nama_kelas),
                'holiday' => null,
                'today_schedules' => $today,
            ]);
        }

        return response()->json([
            'success' => true,
            'status' => 'selesai',
            'message' => 'Jadwal hari ini sudah selesai.',
            'kelas' => $classroom->nama_kelas,
            'current' => null,
            'next' => null,
            'holiday' => null,
            'today_schedules' => $today,
        ]);
    }

    private function formatSchedule(Schedule $schedule, string $className): array
    {
        return [
            'class_name' => $className,
            'hari' => $schedule->day,
            'mapel' => $schedule->subject_name,
            'guru' => $schedule->teacher_name,
            'ruangan' => $schedule->room,
            'jam_mulai' => substr((string) $schedule->start_time, 0, 5),
            'jam_selesai' => substr((string) $schedule->end_time, 0, 5),
        ];
    }

    private function indonesianDay(Carbon $date): string
    {
        return [
            1 => 'Senin',
            2 => 'Selasa',
            3 => 'Rabu',
            4 => 'Kamis',
            5 => 'Jumat',
            6 => 'Sabtu',
            7 => 'Minggu',
        ][$date->dayOfWeekIso];
    }

    private function holidayFor(Carbon $date): ?array
    {
        $holidays = [
            '2026-06-01' => [
                'judul' => 'Hari Pancasila',
                'keterangan' => 'Libur nasional. Tidak ada kegiatan belajar mengajar.',
            ],
            '2026-08-17' => [
                'judul' => 'Hari Kemerdekaan Indonesia',
                'keterangan' => 'Libur nasional.',
            ],
            '2026-12-25' => [
                'judul' => 'Hari Raya Natal',
                'keterangan' => 'Libur nasional.',
            ],
        ];

        $key = $date->toDateString();

        if (!isset($holidays[$key])) {
            return null;
        }

        return [
            'tanggal' => $key,
            'judul' => $holidays[$key]['judul'],
            'keterangan' => $holidays[$key]['keterangan'],
        ];
    }
}
