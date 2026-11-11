<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\KuisTik;
use Illuminate\Support\Str;

class KuisTikSeeder extends Seeder
{
    public function run()
    {
        for ($i = 1; $i <= 20; $i++) {
            KuisTik::create([
                'materi_id' => 8,
                'kuis_settings_id' => 3,
                'id_soal' => 'SOAL-DUMMY-' . Str::random(5) . '-' . $i,
                'pertanyaan' => 'Pertanyaan dummy ke-' . $i . ': Apa fungsi dari tag <div> dalam HTML?',
                'tipe' => 'pilihan_ganda',
                'opsi_jawaban' => ['Paragraf', 'Link', 'Container/Pembungkus', 'Gambar'],
                'kunci_jawaban' => ['c'],
                'penjelasan_opsi' => ['Bukan', 'Bukan', 'Benar', 'Bukan'],
                'poin' => 5,
                'waktu' => 30,
                'urutan' => $i
            ]);
        }
    }
}
