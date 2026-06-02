<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Classroom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClassroomController extends Controller
{
    public function index(Request $request)
    {
        $query = Classroom::query();

        if ($request->filled('tingkat')) {
            $query->where('tingkat', $request->query('tingkat'));
        }

        if ($request->filled('jurusan')) {
            $query->where('jurusan', $request->query('jurusan'));
        }

        $classrooms = $query
            ->orderByRaw("FIELD(tingkat, 'X', 'XI', 'XII')")
            ->orderByRaw("FIELD(jurusan, 'PPLG', 'TJKT')")
            ->orderBy('nomor_kelas')
            ->get(['id', 'tingkat', 'jurusan', 'nomor_kelas', 'nama_kelas', 'is_active']);

        return response()->json([
            'success' => true,
            'message' => 'Daftar kelas berhasil dimuat.',
            'data' => $classrooms,
        ], 200);
    }
}
