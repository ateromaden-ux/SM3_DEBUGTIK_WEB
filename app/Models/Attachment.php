<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Attachment extends Model
{
    protected $table = 'attachments';

    protected $fillable = [
        'attachable_type',
        'attachable_id',
        'nama_file',
        'path',
        'mime_type',
        'ukuran',
        'disk',
    ];

    // ─── Relasi polymorphic ───────────────────────────────────────────────────

    public function attachable()
    {
        return $this->morphTo();
    }

    // ─── Accessors ────────────────────────────────────────────────────────────

    /** URL publik file. */
    public function getUrlAttribute(): string
    {
        return Storage::disk($this->disk)->url($this->path);
    }

    /** Ukuran file dalam format readable (KB/MB). */
    public function getUkuranReadableAttribute(): string
    {
        $bytes = $this->ukuran;
        if ($bytes >= 1048576) {
            return round($bytes / 1048576, 1).' MB';
        }

        return round($bytes / 1024, 1).' KB';
    }

    /** Icon Material Symbols sesuai tipe file. */
    public function getIconAttribute(): string
    {
        if ($this->isImage()) {
            return 'image';
        }
        if ($this->isPdf()) {
            return 'picture_as_pdf';
        }

        return 'description';
    }

    // ─── Helpers ──────────────────────────────────────────────────────────────

    public function isImage(): bool
    {
        return str_starts_with($this->mime_type, 'image/');
    }

    public function isPdf(): bool
    {
        return $this->mime_type === 'application/pdf';
    }
}
