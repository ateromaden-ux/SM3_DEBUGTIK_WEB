<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('kuis_tik', function (Blueprint $table) {
            $table->unsignedSmallInteger('waktu')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('kuis_tik', function (Blueprint $table) {
            $table->unsignedSmallInteger('waktu')->default(30)->change();
        });
    }
};
