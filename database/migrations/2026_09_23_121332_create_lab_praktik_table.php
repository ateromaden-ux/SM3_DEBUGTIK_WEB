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
        Schema::create('lab_praktik', function (Blueprint $table) {
            $table->id();
            $table->foreignId('materi_id')->constrained('materi_belajar')->onDelete('cascade');
            $table->string('id_lab')->unique();
            $table->text('deskripsi_kasus');
            $table->text('kode_soal_awal');
            $table->text('bug_target');
            $table->text('solusi_fix');
            $table->enum('tingkat_kesulitan', ['mudah', 'sedang', 'sulit'])->default('mudah');
            $table->integer('poin_max')->default(100);
            $table->json('test_cases')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lab_praktik');
    }
};
