<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Gallery extends Model
{
    protected $fillable = ['user_id', 'image', 'public_id', 'caption'];

    // Ini rahasianya: Appends akan memunculkan kolom baru 'image_url' saat di-JSON
    protected $appends = ['image_url'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Membuat URL lengkap untuk gambar
     */
    public function getImageUrlAttribute()
    {
        // Jika image berisi URL (http...), langsung balikin. 
        // Jika cuma nama file, arahkan ke folder storage.
        if (filter_var($this->image, FILTER_VALIDATE_URL)) {
            return $this->image;
        }

        return asset('storage/gallery/' . $this->image);
    }
}