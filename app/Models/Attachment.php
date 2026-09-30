<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Attachment extends Model
{
    protected $fillable = [
        'attachable_type',
        'attachable_id',
        'nama_file',
        'path',
        'mime_type',
        'ukuran',
        'disk',
    ];

    // Relasi polymorphic
    public function attachable()
    {
        return $this->morphTo();
    }

    // URL publik file
    public function getUrlAttribute(): string
    {
        return Storage::disk($this->disk)->url($this->path);
    }

    // Ukuran dalam format human-readable
    public function getUkuranReadableAttribute(): string
    {
        $bytes = $this->ukuran;
        if ($bytes < 1024)       return $bytes . ' B';
        if ($bytes < 1048576)    return round($bytes / 1024, 1) . ' KB';
        return round($bytes / 1048576, 1) . ' MB';
    }

    // Apakah file ini gambar
    public function isImage(): bool
    {
        return str_starts_with($this->mime_type, 'image/');
    }

    // Apakah file ini PDF
    public function isPdf(): bool
    {
        return $this->mime_type === 'application/pdf';
    }

    // Icon material symbols berdasarkan tipe
    public function getIconAttribute(): string
    {
        if ($this->isPdf())   return 'picture_as_pdf';
        if ($this->isImage()) return 'image';
        return 'attach_file';
    }
}
