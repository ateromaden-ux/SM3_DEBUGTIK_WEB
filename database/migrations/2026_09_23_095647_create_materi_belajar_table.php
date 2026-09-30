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
        Schema::create('materi_belajar', function (Blueprint $table) {
            $table->id();
            $table->string('id_materi')->unique();
            $table->foreignId('guru_id')->constrained('gurus')->onDelete('cascade');
            $table->string('judul');
            $table->text('deskripsi');
            $table->enum('kategori', ['HTML Dasar', 'CSS Dasar', 'JS Dasar', 'Web Responsif']);
            $table->enum('level', ['Pemula', 'Menengah', 'Lanjutan'])->default('Pemula');
            $table->text('konten');
            $table->integer('estimasi_waktu')->default(45);
            $table->integer('tingkat_kesulitan')->default(1);
            $table->boolean('published')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('materi_belajar');
    }
};
