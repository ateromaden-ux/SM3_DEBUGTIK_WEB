<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('progress_belajar', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('materi_id')->constrained('materi_belajar')->onDelete('cascade');
            $table->enum('status', ['belum_mulai', 'sedang_belajar', 'selesai'])->default('belum_mulai');
            $table->integer('progress_persen')->default(0);
            $table->integer('skor')->nullable();
            $table->timestamp('mulai_belajar')->nullable();
            $table->timestamp('selesai_belajar')->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();
            
            $table->unique(['user_id', 'materi_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('progress_belajar');
    }
};
