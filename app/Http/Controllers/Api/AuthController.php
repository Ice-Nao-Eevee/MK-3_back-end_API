<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    // Fungsi Register khusus untuk Orang Lain / Umum (Strict .com/.id dll)
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            // Pake email:rfc,dns biar wajib ada TLD valid (.com/.id/dll) & terdaftar di internet
            'email' => 'required|string|email:rfc,dns|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'nis' => null, // Akun umum tidak punya NIS
            'password' => Hash::make($validated['password']),
            'role' => 'umum', 
        ]);

        $token = $user->createToken('android-token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Register akun umum berhasil',
            'token' => $token,
            'user' => $user,
        ], 201);
    }

    // Fungsi Login Dinamis (Mendeteksi Email Asli atau NIS)
    public function login(Request $request)
    {
        $validated = $request->validate([
            'login_input' => 'required|string',
            'password' => 'required|string',
        ]);

        // Diproteksi FILTER_VALIDATE_EMAIL
        // Kalau ga lolos validasi email (seperti gapake .com), otomatis dibaca sebagai NIS
        $fieldType = filter_var($validated['login_input'], FILTER_VALIDATE_EMAIL) ? 'email' : 'nis';

        $user = User::where($fieldType, $validated['login_input'])->first();

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
            ],
        ], 200);
    }

    public function me(Request $request)
    {
        return response()->json([
            'success' => true,
            'user' => $request->user(),
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