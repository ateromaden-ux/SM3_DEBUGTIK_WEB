<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MateriBelajar extends Model
{
    protected $table = 'materi_belajar';

    protected $fillable = [
        'id_materi',
        'guru_id',
        'judul',
        'deskripsi',
        'kategori',
        'level',
        'konten',
        'estimasi_waktu',
        'tingkat_kesulitan',
        'published',
    ];

    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }

    public function progressBelajar()
    {
        return $this->hasMany(ProgressBelajar::class, 'materi_id');
    }

    public function kuis()
    {
        return $this->hasMany(KuisTik::class, 'materi_id');
    }

    public function labPraktik()
    {
        return $this->hasMany(LabPraktik::class, 'materi_id');
    }

    public function kuisSettings()
    {
        return $this->hasOne(KuisSettings::class, 'materi_id');
    }

    public function attachments()
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }
}
