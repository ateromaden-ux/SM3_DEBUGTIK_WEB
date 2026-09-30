<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('attachments', function (Blueprint $table) {
            $table->id();

            // Polymorphic: bisa ke materi_belajar atau kuis_tik
            $table->morphs('attachable'); // attachable_type + attachable_id

            $table->string('nama_file');           // nama asli dari user
            $table->string('path');                // path di storage/app/public
            $table->string('mime_type');           // application/pdf, image/png, dst
            $table->unsignedBigInteger('ukuran');  // bytes
            $table->string('disk')->default('public');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attachments');
    }
};
