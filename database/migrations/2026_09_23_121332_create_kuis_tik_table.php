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
        Schema::create('kuis_tik', function (Blueprint $table) {
            $table->id();
            $table->foreignId('materi_id')->constrained('materi_belajar')->onDelete('cascade');
            $table->string('id_soal')->unique();
            $table->text('pertanyaan');
            $table->enum('tipe', ['pilihan_ganda', 'essay'])->default('pilihan_ganda');
            $table->json('opsi_jawaban')->nullable();
            $table->text('kunci_jawaban');
            $table->integer('poin')->default(25);
            $table->integer('urutan')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kuis_tik');
    }
};
