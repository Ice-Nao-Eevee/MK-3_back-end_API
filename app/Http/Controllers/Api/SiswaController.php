<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Http;

class SiswaController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');
        $classroomId = $request->query('classroom_id');
        $viewer = auth('sanctum')->user();
        $viewerRole = $viewer?->role ?? 'umum';

        $siswa = Siswa::with([
                'classroom:id,tingkat,jurusan,nomor_kelas,nama_kelas',
                'user:id,email,nis',
            ])
            ->when($classroomId, function ($query) use ($classroomId) {
                return $query->where('classroom_id', $classroomId);
            })
            ->when($search, function ($query) use ($search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('nama', 'LIKE', '%' . $search . '%')
                        ->orWhere('nis', 'LIKE', '%' . $search . '%');
                });
            })
            ->orderBy('classroom_id')
            ->orderBy('no_absen')
            ->get()
            ->map(fn (Siswa $item) => $this->formatSiswaForRole($item, $viewerRole));

        return response()->json([
            'success' => true,
            'message' => $viewerRole === 'umum'
                ? 'Daftar data siswa publik berhasil dimuat. Kontak pribadi disembunyikan.'
                : 'Daftar data siswa berhasil dimuat.',
            'viewer_role' => $viewerRole,
            'data' => $siswa,
        ], 200);
    }

    public function show(Request $request, $id)
    {
        $siswa = Siswa::with([
            'classroom:id,tingkat,jurusan,nomor_kelas,nama_kelas',
            'user:id,email,nis',
        ])->find($id);

        if (!$siswa) {
            return response()->json([
                'success' => false,
                'message' => 'Data siswa tidak ditemukan.',
            ], 404);
        }

        $viewerRole = $request->user()?->role ?? 'umum';

        return response()->json([
            'success' => true,
            'message' => 'Detail data siswa.',
            'viewer_role' => $viewerRole,
            'data' => $this->formatSiswaForRole($siswa, $viewerRole),
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $role = $request->user()->role;

        if (!in_array($role, ['wali_kelas', 'admin_sekolah'], true)) {
            return response()->json([
                'success' => false,
                'message' => 'Hanya wali kelas atau admin sekolah yang dapat mengubah data siswa.',
            ], 403);
        }

        $siswa = Siswa::find($id);

        if (!$siswa) {
            return response()->json([
                'success' => false,
                'message' => 'Data siswa tidak ditemukan.',
            ], 404);
        }

        if ($role === 'wali_kelas' && (int) $request->user()->classroom_id !== (int) $siswa->classroom_id) {
            return response()->json([
                'success' => false,
                'message' => 'Wali kelas hanya dapat mengubah data siswa di kelasnya sendiri.',
            ], 403);
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
            'foto'          => 'sometimes|nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'tanggal_lahir' => 'sometimes|nullable|string|max:255',
            'whatsapp'      => 'sometimes|nullable|string|max:20',
            'instagram'     => 'sometimes|nullable|string|max:255',
            'bio'           => 'sometimes|nullable|string',
            'quote'         => 'sometimes|nullable|string',
            'nama_ayah'     => 'sometimes|nullable|string|max:255',
            'nama_ibu'      => 'sometimes|nullable|string|max:255',
        ]);

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $cloudName = env('CLOUDINARY_CLOUD_NAME');
            $apiKey = env('CLOUDINARY_API_KEY');
            $apiSecret = env('CLOUDINARY_API_SECRET');

            $timestamp = time();
            $folder = 'profile_siswa';
            $signature = sha1("folder={$folder}&timestamp={$timestamp}" . $apiSecret);

            $response = Http::attach(
                'file',
                file_get_contents($file->getRealPath()),
                $file->getClientOriginalName()
            )->post("https://api.cloudinary.com/v1_1/{$cloudName}/image/upload", [
                'folder' => $folder,
                'api_key' => $apiKey,
                'timestamp' => $timestamp,
                'signature' => $signature,
            ]);

            if ($response->successful()) {
                $validated['foto'] = $response->json()['secure_url'];
            } else {
                $cloudinaryError = $response->json()['error']['message'] ?? 'Cek konfigurasi Cloudinary di .env';

                return response()->json([
                    'success' => false,
                    'message' => 'Gagal upload ke Cloudinary: ' . $cloudinaryError,
                    'detail' => $response->json(),
                ], 500);
            }
        }

        $siswa->update($validated);
        $siswa->load('classroom:id,tingkat,jurusan,nomor_kelas,nama_kelas', 'user:id,email,nis');

        return response()->json([
            'success' => true,
            'message' => 'Data siswa berhasil diubah.',
            'data' => $this->formatSiswaForRole($siswa, $role),
        ], 200);
    }

    private function formatSiswaForRole(Siswa $siswa, string $role): array
    {
        $classroom = $siswa->classroom;
        $isGeneral = $role === 'umum';
        $isStaff = in_array($role, ['wali_kelas', 'admin_sekolah'], true);
        $nis = (string) ($siswa->nis ?? '');

        $data = [
            'id' => $siswa->id,
            'user_id' => $siswa->user_id,
            'classroom_id' => $siswa->classroom_id,
            'no_absen' => $siswa->no_absen,
            'nis' => $isGeneral ? $this->maskNis($nis) : $nis,
            'nama' => $siswa->nama,
            'jenis_kelamin' => $siswa->jenis_kelamin,
            'jabatan_dev' => $siswa->jabatan_dev ?: 'Siswa',
            'foto' => $siswa->foto,
            'classroom' => $classroom ? [
                'id' => $classroom->id,
                'tingkat' => $classroom->tingkat,
                'jurusan' => $classroom->jurusan,
                'nomor_kelas' => $classroom->nomor_kelas,
                'nama_kelas' => $classroom->nama_kelas,
            ] : null,
            'is_sensitive_hidden' => $isGeneral,
            'privacy_notice' => $isGeneral
                ? 'Data kontak, tanggal lahir, dan informasi keluarga disembunyikan untuk akun umum.'
                : null,
        ];

        if (!$isGeneral) {
            $data['email'] = $siswa->user?->email ?: ($nis !== '' ? $nis . '@smktelkom-pwt.sch.id' : null);
            $data['tanggal_lahir'] = $siswa->tanggal_lahir;
            $data['whatsapp'] = $siswa->whatsapp;
            $data['instagram'] = $siswa->instagram;
            $data['bio'] = $siswa->bio;
            $data['quote'] = $siswa->quote;
        }

        if ($isStaff) {
            $data['nama_ayah'] = $siswa->nama_ayah;
            $data['nama_ibu'] = $siswa->nama_ibu;
        }

        return $data;
    }

    private function maskNis(string $nis): string
    {
        if (strlen($nis) <= 5) {
            return 'Disembunyikan';
        }

        return substr($nis, 0, 5) . str_repeat('*', max(strlen($nis) - 5, 3));
    }
}
