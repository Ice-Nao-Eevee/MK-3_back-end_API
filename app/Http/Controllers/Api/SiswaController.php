<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Siswa; // Pastikan Model Siswa sudah dibuat ya
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    public function index(Request $request)
    {
        // Ambil input 'search' dari URL
        $search = $request->query('search');

        // Query ke tabel siswas
        $siswa = Siswa::when($search, function ($query, $search) {
            return $query->where('nama', 'LIKE', '%' . $search . '%')
                         ->orWhere('nis', 'LIKE', '%' . $search . '%');
        })->get();

        return response()->json([
            'success' => true,
            'message' => 'Data Siswa XI PPLG 4',
            'data'    => $siswa
        ], 200);
    }
}