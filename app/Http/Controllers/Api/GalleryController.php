<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class GalleryController extends Controller
{
    /**
     * FUNGSI INDEX: Mengambil semua data foto
     */
    public function index()
    {
        // Mengambil data gallery beserta informasi user (id & nama) yang upload
        // latest() digunakan agar foto terbaru muncul di paling atas
        $galleries = Gallery::with('user:id,name')->latest()->get();

        return response()->json([
            'success' => true,
            'data'    => $galleries
        ]);
    }

    /**
     * FUNGSI STORE: Proses upload foto ke Cloudinary dan simpan ke database
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        // 1. Validasi input: File harus gambar, format tertentu, dan maksimal 2MB
        $request->validate([
            'image'   => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'caption' => 'nullable|string',
        ]);

        try {
            $data = [];
            // Mengambil ID user yang sedang login untuk dicatat sebagai pemilik foto
            /** @var User|null $user */
            $user = $request->user();
            $data['user_id'] = $user?->id;

            // 2. Cek apakah ada file gambar yang dikirim
            if ($request->hasFile('image')) {
                $file = $request->file('image');

                // Mengambil kredensial API Cloudinary dari file .env
                $cloudName = env('CLOUDINARY_CLOUD_NAME');
                $apiKey = env('CLOUDINARY_API_KEY');
                $apiSecret = env('CLOUDINARY_API_SECRET');

                // 3. Proses Pengiriman (Upload) ke API Cloudinary
                $response = Http::asMultipart()
                    ->withBasicAuth($apiKey, $apiSecret) // Autentikasi API
                    ->post(
                        "https://api.cloudinary.com/v1_1/{$cloudName}/image/upload",
                        [
                            'file' => fopen($file->getRealPath(), 'r'), // Membuka file gambar
                            'folder' => 'gallery', // Nama folder di dashboard Cloudinary
                        ],
                    );

                // 4. Jika upload ke Cloudinary berhasil
                if ($response->successful()) {
                    // Ambil URL foto yang aman (HTTPS) dari respon Cloudinary
                    $data['image'] = $response->json()['secure_url'];
                    // Ambil Public ID untuk keperluan hapus foto nantinya
                    $data['public_id'] = $response->json()['public_id'];
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'Upload Cloudinary Gagal',
                        'detail' => $response->json(),
                    ], 500);
                }
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'File image tidak ditemukan'
                ], 400);
            }

            // 5. Simpan caption dan data lainnya ke database lokal
            $data['caption'] = $request->caption;
            $gallery = Gallery::create($data);

            return response()->json([
                'success' => true,
                'message' => 'Foto berhasil diupload!',
                'data'    => $gallery
            ], 201);

        } catch (\Exception $e) {
            // Menangkap error jika terjadi kegagalan sistem
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * FUNGSI DESTROY: Menghapus foto dari Cloudinary dan Database lokal
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        // 1. Cari data foto berdasarkan ID
        /** @var Gallery|null $gallery */
        $gallery = Gallery::find($id);

        if (!$gallery) {
            return response()->json([
                'success' => false,
                'message' => 'Foto tidak ditemukan'
            ], 404);
        }

        // 2. CEK KEAMANAN: Pastikan yang menghapus adalah pemilik foto tersebut
        /** @var User|null $user */
        $user = Auth::user();
        if ($gallery->user_id !== $user?->id) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak berhak menghapus foto ini'
            ], 403);
        }

        try {
            // 3. Proses Hapus file fisik di Cloudinary
            if ($gallery->public_id) {
                $cloudName = env('CLOUDINARY_CLOUD_NAME');
                $apiKey = env('CLOUDINARY_API_KEY');
                $apiSecret = env('CLOUDINARY_API_SECRET');

                // Meminta Cloudinary menghapus file berdasarkan public_id
                Http::asMultipart()
                    ->withBasicAuth($apiKey, $apiSecret)
                    ->delete(
                        "https://api.cloudinary.com/v1_1/{$cloudName}/resources/image/upload",
                        ['public_ids' => [$gallery->public_id]],
                    );
            }

            // 4. Hapus record data dari database lokal
            $gallery->delete();

            return response()->json([
                'success' => true,
                'message' => 'Foto berhasil dihapus!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}