<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgressBelajar extends Model
{
    protected $table = 'progress_belajar';

    protected $fillable = [
        'user_id',
        'materi_id',
        'status',
        'progress_persen',
        'persentase_selesai',
        'status_selesai',
        'skor',
        'nilai_kuis',
        'nilai_lab',
        'nilai_akhir',
        'mulai_belajar',
        'selesai_belajar',
        'catatan',
    ];

    protected $casts = [
        'mulai_belajar' => 'datetime',
        'selesai_belajar' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function materi()
    {
        return $this->belongsTo(MateriBelajar::class, 'materi_id');
    }
}
