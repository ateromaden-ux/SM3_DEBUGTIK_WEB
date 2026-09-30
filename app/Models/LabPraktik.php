<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LabPraktik extends Model
{
    protected $table = 'lab_praktik';

    protected $fillable = [
        'materi_id',
        'id_lab',
        'deskripsi_kasus',
        'kode_soal_awal',
        'bug_target',
        'solusi_fix',
        'tingkat_kesulitan',
        'poin_max',
        'test_cases',
    ];

    protected $casts = [
        'test_cases' => 'array',
    ];

    public function materi()
    {
        return $this->belongsTo(MateriBelajar::class, 'materi_id');
    }
}
