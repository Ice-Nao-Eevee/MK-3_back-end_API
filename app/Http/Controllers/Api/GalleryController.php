<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    // Lihat semua foto gallery
    public function index()
    {
        $galleries = Gallery::with('user:id,nama')->latest()->get();
        return response()->json([
            'success' => true,
            'data'    => $galleries
        ]);
    }

    // Upload foto baru
    public function store(Request $request)
    {
        $request->validate([
            'image'   => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'caption' => 'nullable|string',
            'user_id' => 'required' // Nanti ini otomatis kalau sudah ada sistem Login
        ]);

        // Proses simpan gambar
        $image = $request->file('image');
        $image->storeAs('public/gallery', $image->hashName());

        $gallery = Gallery::create([
            'user_id' => $request->user_id,
            'image'   => $image->hashName(),
            'caption' => $request->caption,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Foto berhasil diupload!',
            'data'    => $gallery
        ]);
    }
}