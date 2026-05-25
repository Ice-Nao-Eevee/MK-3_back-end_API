<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Siswa; // Pastikan Model Siswa sudah dibuat ya
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Http; // 👈 WAJIB DITAMBAH: Untuk nembak API Cloudinary

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

    public function update(Request $request, $id)
    {
        // Proteksi: Hanya Akun dengan Role wali_kelas yang bisa tembus edit
        if ($request->user()->role !== 'wali_kelas') {
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

        // 🛠️ VALIDASI SAKTI: Kita ubah aturan 'foto' agar menerima FILE gambar asli dari Android
        $validated = $request->validate([
            'no_absen' => 'sometimes|nullable|integer|min:1',
            'nis' => [
                'sometimes',
                'required',
                'string',
                'max:50',
                Rule::unique('siswas', 'nis')->ignore($siswa->id),
            ],
            'nama' => 'sometimes|required|string|max:255',
            'jenis_kelamin' => 'sometimes|nullable|in:L,P',
            'jabatan_dev' => 'sometimes|nullable|string|max:255',
            
            // MODIFIKASI: Menerima file image, maksimal 2MB
            'foto' => 'sometimes|nullable|image|mimes:jpeg,png,jpg,gif|max:2048', 
            
            'tanggal_lahir' => 'sometimes|nullable|string|max:255',
            'whatsapp'      => 'sometimes|nullable|string|max:20',
            'instagram'     => 'sometimes|nullable|string|max:255',
            'bio'           => 'sometimes|nullable|string',
            'quote'         => 'sometimes|nullable|string',
        ]);

        // 🛠️ MODIFIKASI SAKTI: LOGIKA UPLOAD FOTO PROFIL KE CLOUDINARY
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $cloudName = env('CLOUDINARY_CLOUD_NAME');
            $apiKey = env('CLOUDINARY_API_KEY');
            $apiSecret = env('CLOUDINARY_API_SECRET');

            // Kirim file foto profil ke Cloudinary masuk ke folder 'profile_siswa'
            $response = Http::asMultipart()
                ->withBasicAuth($apiKey, $apiSecret)
                ->post("https://api.cloudinary.com/v1_1/{$cloudName}/image/upload", [
                    'file' => fopen($file->getRealPath(), 'r'),
                    'folder' => 'profile_siswa', 
                ]);

            if ($response->successful()) {
                // Ambil secure_url (HTTPS) dari Cloudinary, masukkan ke array validated kolom 'foto'
                $validated['foto'] = $response->json()['secure_url'];
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal upload foto profil ke Cloudinary.',
                    'detail' => $response->json()
                ], 500);
            }
        }

        // Eksekusi pembaruan ke MySQL (Semua data teks + URL Cloudinary otomatis masuk)
        $siswa->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Data siswa berhasil diubah.',
            'data' => $siswa,
        ], 200);
    }
}