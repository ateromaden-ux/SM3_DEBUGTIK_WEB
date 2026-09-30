<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KuisTik extends Model
{
    protected $table = 'kuis_tik';

    protected $fillable = [
        'materi_id',
        'id_soal',
        'pertanyaan',
        'tipe',
        'opsi_jawaban',
        'kunci_jawaban',
        'penjelasan_opsi',
        'poin',
        'urutan',
    ];

    protected $casts = [
        'opsi_jawaban' => 'array',
        'kunci_jawaban' => 'array',
        'penjelasan_opsi' => 'array',
    ];

    public function materi()
    {
        return $this->belongsTo(MateriBelajar::class, 'materi_id');
    }

    public function attachments()
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }
}
