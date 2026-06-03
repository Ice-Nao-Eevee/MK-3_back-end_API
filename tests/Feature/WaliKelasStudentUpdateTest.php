<?php

namespace Tests\Feature;

use App\Models\Classroom;
use App\Models\Siswa;
use Database\Seeders\ClassroomSeeder;
use Database\Seeders\SiswaKelasSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WaliKelasStudentUpdateTest extends TestCase
{
    use RefreshDatabase;

    public function test_biebha_login_returns_classroom_id_for_android_permission_check(): void
    {
        $this->seed([ClassroomSeeder::class, UserSeeder::class]);

        $classroom = Classroom::where('nama_kelas', 'XI PPLG 4')->firstOrFail();

        $this->postJson('/api/login', [
            'login_input' => 'biebha@gmail.com',
            'password' => 'password123',
        ])
            ->assertOk()
            ->assertJsonPath('user.role', 'wali_kelas')
            ->assertJsonPath('user.classroom_id', $classroom->id)
            ->assertJsonPath('user.class_name', 'XI PPLG 4')
            ->assertJsonPath('user.classroom.id', $classroom->id);
    }

    public function test_biebha_can_update_xi_pplg_4_student(): void
    {
        $this->seed([ClassroomSeeder::class, UserSeeder::class, SiswaKelasSeeder::class]);

        $login = $this->postJson('/api/login', [
            'login_input' => 'biebha@gmail.com',
            'password' => 'password123',
        ])->assertOk();

        $token = $login->json('token');
        $student = Siswa::where('nis', '541241042')->firstOrFail();

        $this->withToken($token)
            ->postJson("/api/siswa/update/{$student->id}", [
                'quote' => 'Tetap semangat belajar.',
            ])
            ->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.quote', 'Tetap semangat belajar.')
            ->assertJsonPath('data.classroom_id', $student->classroom_id);
    }
}
