<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('siswas', function (Blueprint $table) {
            // 🔴 Suntik user_id di awal setelah kolom id secara aman
            $table->foreignId('user_id')->nullable()->after('id')->constrained('users')->onDelete('cascade');
            
            // 🔴 Suntik classroom_id setelah user_id
            $table->foreignId('classroom_id')->nullable()->after('user_id')->constrained('classrooms')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('siswas', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['classroom_id']);
            $table->dropColumn(['user_id', 'classroom_id']);
        });
    }
};