<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KuisSettings extends Model
{
    protected $table = 'kuis_settings';

    protected $fillable = [
        'materi_id',
        'id_kuis',
        'waktu_per_soal',
        'satuan_waktu',
        'kkm',
        'status',
        'published_at',
    ];

    protected $casts = [
        'waktu_per_soal' => 'integer',
        'kkm' => 'integer',
        'published_at' => 'datetime',
    ];

    public function isPublished(): bool
    {
        return $this->status === 'published';
    }

    public function isDraft(): bool
    {
        return $this->status === 'draft';
    }

    // Relasi ke MateriBelajar
    public function materi()
    {
        return $this->belongsTo(MateriBelajar::class, 'materi_id');
    }

    /**
     * Konversi waktu_per_soal ke detik (untuk frontend timer).
     */
    public function waktuDalamDetik(): int
    {
        return match ($this->satuan_waktu) {
            'menit' => $this->waktu_per_soal * 60,
            'jam' => $this->waktu_per_soal * 3600,
            default => $this->waktu_per_soal,
        };
    }
}
