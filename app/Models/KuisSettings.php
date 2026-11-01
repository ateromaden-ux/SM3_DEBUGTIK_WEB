<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KuisSettings extends Model
{
    protected $table = 'kuis_settings';

    protected $fillable = [
        'guru_id',
        'nama_kuis',
        'deskripsi',
        'id_kuis',
        'kkm',
        'status',
        'published_at',
    ];

    protected $casts = [
        'kkm' => 'integer',
        'published_at' => 'datetime',
    ];

    // ─── Helpers ──────────────────────────────────────────────────────────────

    public function isPublished(): bool
    {
        return $this->status === 'published';
    }

    public function isDraft(): bool
    {
        return $this->status === 'draft';
    }

    /**
     * Nama tampilan kuis — pakai nama_kuis jika ada, fallback ke id_kuis.
     */
    public function getNamaDisplayAttribute(): string
    {
        return $this->nama_kuis ?? $this->id_kuis;
    }

    // ─── Relasi ───────────────────────────────────────────────────────────────

    /** Kuis bisa terikat ke materi (opsional). */
    public function materi()
    {
        return $this->belongsTo(MateriBelajar::class, 'materi_id');
    }

    /** Kuis selalu dimiliki guru. */
    public function guru()
    {
        return $this->belongsTo(Guru::class, 'guru_id');
    }

    /** Soal-soal milik kuis ini. */
    public function soal()
    {
        return $this->hasMany(KuisTik::class, 'kuis_settings_id');
    }
}
