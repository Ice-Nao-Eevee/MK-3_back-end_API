<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class GalleryController extends Controller
{
    // Lihat semua foto gallery
    public function index()
    {
        $galleries = Gallery::with('user:id,name')->latest()->get();

        return response()->json([
            'success' => true,
            'data'    => $galleries
        ]);
    }

    // Upload foto ke Cloudinary
    public function store(Request $request)
    {
        $request->validate([
            'image'   => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'caption' => 'nullable|string',
        ]);

        try {
            $data = [];
            $data['user_id'] = auth()->id();

            if ($request->hasFile('image')) {
                $file = $request->file('image');

                $cloudName = env('CLOUDINARY_CLOUD_NAME');
                $apiKey = env('CLOUDINARY_API_KEY');
                $apiSecret = env('CLOUDINARY_API_SECRET');

                $response = Http::asMultipart()
                    ->withBasicAuth($apiKey, $apiSecret)
                    ->post(
                        "https://api.cloudinary.com/v1_1/{$cloudName}/image/upload",
                        [
                            'file' => fopen($file->getRealPath(), 'r'),
                            'folder' => 'gallery',
                        ],
                    );

                if ($response->successful()) {
                    $data['image'] = $response->json()['secure_url'];
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

            $data['caption'] = $request->caption;

            $gallery = Gallery::create($data);

            return response()->json([
                'success' => true,
                'message' => 'Foto berhasil diupload!',
                'data'    => $gallery
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    // Hapus foto dari Cloudinary dan database
    public function destroy($id)
    {
        $gallery = Gallery::find($id);

        if (!$gallery) {
            return response()->json([
                'success' => false,
                'message' => 'Foto tidak ditemukan'
            ], 404);
        }

        // Cek ownership
        if ($gallery->user_id !== auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak berhak menghapus foto ini'
            ], 403);
        }

        try {
            // Hapus dari Cloudinary
            if ($gallery->public_id) {
                $cloudName = env('CLOUDINARY_CLOUD_NAME');
                $apiKey = env('CLOUDINARY_API_KEY');
                $apiSecret = env('CLOUDINARY_API_SECRET');

                Http::asMultipart()
                    ->withBasicAuth($apiKey, $apiSecret)
                    ->delete(
                        "https://api.cloudinary.com/v1_1/{$cloudName}/resources/image/upload",
                        ['public_ids' => [$gallery->public_id]],
                    );
            }

            // Hapus dari database
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