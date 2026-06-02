<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
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
            'classroom_id' => null,
        ]);

        $token = $user->createToken('android-token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Register akun umum berhasil',
            'token' => $token,
            'user' => $this->formatUser($user),
        ], 201);
    }

    public function login(Request $request)
    {
        $validated = $request->validate([
            'login_input' => 'required|string',
            'password' => 'required|string',
        ]);

        $fieldType = filter_var($validated['login_input'], FILTER_VALIDATE_EMAIL) ? 'email' : 'nis';
        $user = User::with(['classroom', 'siswa.classroom'])->where($fieldType, $validated['login_input'])->first();

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
            'user' => $this->formatUser($user),
        ], 200);
    }

    public function me(Request $request)
    {
        $user = User::with(['classroom', 'siswa.classroom'])->find($request->user()->id);

        return response()->json([
            'success' => true,
            'user' => $this->formatUser($user),
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

    private function formatUser(User $user): array
    {
        $student = $user->siswa;

        return [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'nis' => $user->nis,
            'role' => $user->role,
            'classroom' => $user->classroom ? [
                'id' => $user->classroom->id,
                'tingkat' => $user->classroom->tingkat,
                'jurusan' => $user->classroom->jurusan,
                'nomor_kelas' => $user->classroom->nomor_kelas,
                'nama_kelas' => $user->classroom->nama_kelas,
            ] : null,
            'student' => $student ? [
                'id' => $student->id,
                'no_absen' => $student->no_absen,
                'nis' => $student->nis,
                'nama' => $student->nama,
                'jenis_kelamin' => $student->jenis_kelamin,
                'tanggal_lahir' => $student->tanggal_lahir,
                'whatsapp' => $student->whatsapp,
                'instagram' => $student->instagram,
                'email' => $student->user?->email ?: ($student->nis ? $student->nis . '@smktelkom-pwt.sch.id' : null),
                'bio' => $student->bio,
                'quote' => $student->quote,
                'foto' => $student->foto,
                'classroom_id' => $student->classroom_id,
                'class_name' => $student->classroom?->nama_kelas,
            ] : null,
        ];
    }
}
