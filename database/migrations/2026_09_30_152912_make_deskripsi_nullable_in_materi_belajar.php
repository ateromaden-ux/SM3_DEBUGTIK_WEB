<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('materi_belajar', function (Blueprint $table) {
            $table->text('deskripsi')->nullable()->change();
            $table->text('konten')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('materi_belajar', function (Blueprint $table) {
            $table->text('deskripsi')->nullable(false)->change();
            $table->text('konten')->nullable(false)->change();
        });
    }
};
