<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KuisTik extends Model
{
    protected $table = 'kuis_tik';

    protected $fillable = [
        'materi_id',
        'kuis_settings_id',
        'id_soal',
        'pertanyaan',
        'tipe',
        'opsi_jawaban',
        'kunci_jawaban',
        'penjelasan_opsi',
        'poin',
        'waktu',
        'urutan',
    ];

    protected $casts = [
        'opsi_jawaban' => 'array',
        'kunci_jawaban' => 'array',
        'penjelasan_opsi' => 'array',
        'waktu' => 'integer',
    ];

    // ─── Relasi ───────────────────────────────────────────────────────────────

    /** Soal bisa terikat ke materi (legacy/opsional). */
    public function materi()
    {
        return $this->belongsTo(MateriBelajar::class, 'materi_id');
    }

    /** Soal terikat langsung ke kuis settings (mode standalone). */
    public function kuisSettings()
    {
        return $this->belongsTo(KuisSettings::class, 'kuis_settings_id');
    }
}
