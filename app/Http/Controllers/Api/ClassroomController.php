<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Classroom;
use Illuminate\Http\Request;

class ClassroomController extends Controller
{
    /**
     * Mengambil semua daftar kelas untuk picker di Android
     */
    public function index(Request $request)
    {
        // Temen lu di Android bisa kirim query parameter buat memfilter, misal: ?jurusan=PPLG atau ?tingkat=XI
        $query = Classroom::query();

        if ($request->has('jurusan')) {
            $query->where('jurusan', $request->jurusan);
        }

        if ($request->has('tingkat')) {
            $query->where('tingkat', $request->tingkat);
        }

        $classrooms = $query->orderBy('tingkat', 'asc')
                            ->orderBy('nama_kelas', 'asc')
                            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Daftar kelas berhasil dimuat, su!',
            'data'    => $classrooms
        ], 200);
    }
}