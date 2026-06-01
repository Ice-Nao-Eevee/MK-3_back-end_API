<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    // Fungsi Register khusus untuk Orang Lain / Umum
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email:rfc,dns|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'nis' => null, 
            'password' => Hash::make($validated['password']),
            'role' => 'umum', 
            'classroom_id' => null, // Akun umum tidak punya kelas cong
        ]);

        $token = $user->createToken('android-token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Register akun umum berhasil',
            'token' => $token,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'nis' => $user->nis,
                'role' => $user->role,
                'classroom' => null // Akun umum otomatis null kelasnya
            ],
        ], 201);
    }

    // Fungsi Login Dinamis (Mendeteksi Email Asli atau NIS + Angkut Data Kelas)
    public function login(Request $request)
    {
        $validated = $request->validate([
            'login_input' => 'required|string',
            'password' => 'required|string',
        ]);

        // Logika cerdas lu tetep kejaga su!
        $fieldType = filter_var($validated['login_input'], FILTER_VALIDATE_EMAIL) ? 'email' : 'nis';

        // 🔴 MODIFIKASI: Tambah Eager Loading .with('classroom') biar data kelas ikut kebawa
        $user = User::with('classroom')->where($fieldType, $validated['login_input'])->first();

        if (!$user || !Hash::check($validated['password'], $user->password)) {
            throw ValidationException::withMessages([
                'login_input' => ['NIS atau Email/Password yang kamu masukkan salah.'],
            ]);
        }

        $token = $user->createToken('android-token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Login berhasil',
            'token' => $token,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'nis' => $user->nis,
                'role' => $user->role,
                // 🔴 MODIFIKASI: Kondisi ngecek apakah dia punya kelas atau kagak
                'classroom' => $user->classroom ? [
                    'id' => $user->classroom->id,
                    'tingkat' => $user->classroom->tingkat,
                    'jurusan' => $user->classroom->jurusan,
                    'nama_kelas' => $user->classroom->nama_kelas,
                ] : null
            ],
        ], 200);
    }

    // Fungsi cek profil login sekalian bawa detail kelasnya cong
    public function me(Request $request)
    {
        // Ambil data user yang sedang login beserta relasi kelasnya
        $user = User::with('classroom')->find($request->user()->id);

        return response()->json([
            'success' => true,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'nis' => $user->nis,
                'role' => $user->role,
                'classroom' => $user->classroom ? [
                    'id' => $user->classroom->id,
                    'tingkat' => $user->classroom->tingkat,
                    'jurusan' => $user->classroom->jurusan,
                    'nama_kelas' => $user->classroom->nama_kelas,
                ] : null
            ],
        ], 200);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Logout berhasil',
        ], 200);
    }
}