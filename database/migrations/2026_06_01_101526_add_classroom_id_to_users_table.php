<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // 1. Suntik kolom classroom_id setelah kolom password secara aman
            $table->foreignId('classroom_id')->nullable()->after('password')->constrained('classrooms')->onDelete('set null');
            
            // 2. Karena merubah tipe ENUM di tengah jalan agak rawan di MySQL tanpa library doctrine,
            // trik paling aman adalah mengubah kolom role menjadi string biasa dulu biar bisa nampung role baru!
            $table->string('role')->default('umum')->change();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['classroom_id']);
            $table->dropColumn('classroom_id');
        });
    }
};