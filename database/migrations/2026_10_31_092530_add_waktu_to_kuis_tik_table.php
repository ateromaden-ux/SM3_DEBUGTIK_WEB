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
        Schema::table('kuis_tik', function (Blueprint $table) {
            $table->unsignedSmallInteger('waktu')->default(30)->after('poin')->comment('Waktu per soal dalam satuan di kuis_settings');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kuis_tik', function (Blueprint $table) {
            $table->dropColumn('waktu');
        });
    }
};
