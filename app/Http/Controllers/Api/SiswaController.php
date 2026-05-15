<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Siswa; 
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SiswaController extends Controller
{
    public function index(Request $request)
    {
        // Ambil input 'search' dari URL
        $search = $request->query('search');

        // Query ke tabel siswa dengan penulisan yang lebih eksplisit
        $siswa = Siswa::when($search, function ($query) use ($search) {
            return $query->where('nama', 'LIKE', '%' . $search . '%')
                         ->orWhere('nis', 'LIKE', '%' . $search . '%');
        })->get();

        return response()->json([
            'success' => true,
            'message' => 'Data Siswa XI PPLG 4',
            'data'    => $siswa
        ], 200);
    }

    public function show($id)
    {
        $siswa = Siswa::find($id);

        if (!$siswa) {
            return response()->json([
                'success' => false,
                'message' => 'Data siswa tidak ditemukan.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Detail data siswa.',
            'data'    => $siswa,
        ], 200);
    }

    public function update(Request $request, $id)
    {
        // Pastikan user terautentikasi sebelum cek role
        if (!$request->user() || $request->user()->role !== 'wali_kelas') {
            return response()->json([
                'success' => false,
                'message' => 'Hanya wali kelas yang dapat mengubah data siswa.',
            ], 403);
        }

        $siswa = Siswa::find($id);

        if (!$siswa) {
            return response()->json([
                'success' => false,
                'message' => 'Data siswa tidak ditemukan.',
            ], 404);
        }

        $validated = $request->validate([
            'no_absen'      => 'sometimes|nullable|integer|min:1',
            'nis'           => [
                'sometimes',
                'required',
                'string',
                'max:50',
                Rule::unique('siswas', 'nis')->ignore($siswa->id),
            ],
            'nama'          => 'sometimes|required|string|max:255',
            'jenis_kelamin' => 'sometimes|nullable|in:L,P',
            'jabatan_dev'   => 'sometimes|nullable|string|max:255',
            'foto'          => 'sometimes|nullable|string|max:255',
        ]);

        $siswa->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Data siswa berhasil diubah.',
            'data'    => $siswa,
        ], 200);
    }
}