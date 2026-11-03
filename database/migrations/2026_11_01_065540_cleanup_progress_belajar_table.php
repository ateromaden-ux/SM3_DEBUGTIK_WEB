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
        Schema::table('progress_belajar', function (Blueprint $table) {
            $table->dropColumn(['skor', 'progress_persen']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('progress_belajar', function (Blueprint $table) {
            $table->smallInteger('skor')->nullable();
            $table->tinyInteger('progress_persen')->nullable();
        });
    }
};
