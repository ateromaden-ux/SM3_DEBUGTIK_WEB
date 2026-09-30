<?php

namespace Database\Seeders;

use App\Models\MateriBelajar;
use App\Models\KuisTik;
use App\Models\LabPraktik;
use Illuminate\Database\Seeder;

class MateriBelajarSeeder extends Seeder
{
    public function run(): void
    {
        // Sample materis
        $materi1 = MateriBelajar::create([
            'id_materi' => 'MAT-HTML-01',
            'guru_id' => 1,
            'judul' => 'HTML Dasar: Struktur Dokumen & Tag Essential',
            'deskripsi' => 'Materi pengenalan HTML: struktur dokumen, tag HTML, heading, paragraph, link, dan gambar.',
            'kategori' => 'HTML Dasar',
            'level' => 'Pemula',
            'konten' => '<p>HTML adalah bahasa markup untuk membuat struktur halaman web.</p>',
            'estimasi_waktu' => 45,
            'tingkat_kesulitan' => 1,
            'published' => true,
        ]);

        $materi2 = MateriBelajar::create([
            'id_materi' => 'MAT-CSS-02',
            'guru_id' => 1,
            'judul' => 'CSS Dasar: Styling & Layout Box Model',
            'deskripsi' => 'Pengenalan CSS: syntax, selector, property, box model, margin, padding, dan display.',
            'kategori' => 'CSS Dasar',
            'level' => 'Pemula',
            'konten' => '<p>CSS mengatur tampilan dan layout elemen HTML.</p>',
            'estimasi_waktu' => 60,
            'tingkat_kesulitan' => 2,
            'published' => true,
        ]);

        $materi3 = MateriBelajar::create([
            'id_materi' => 'MAT-JS-03',
            'guru_id' => 1,
            'judul' => 'JavaScript Dasar: Variabel, Function, dan DOM',
            'deskripsi' => 'Pengenalan JavaScript: variabel, tipe data, function, event listener, dan DOM manipulation.',
            'kategori' => 'JS Dasar',
            'level' => 'Menengah',
            'konten' => '<p>JavaScript membuat halaman web interaktif.</p>',
            'estimasi_waktu' => 75,
            'tingkat_kesulitan' => 2,
            'published' => true,
        ]);

        // Sample kuis for HTML
        KuisTik::create([
            'materi_id' => $materi1->id,
            'id_soal' => 'KUIS-HTML-01',
            'pertanyaan' => 'Tag HTML untuk membuat heading level 1?',
            'tipe' => 'pilihan_ganda',
            'opsi_jawaban' => ['<h1>', '<h2>', '<title>', '<head>'],
            'kunci_jawaban' => '<h1>',
            'poin' => 25,
            'urutan' => 1,
        ]);

        KuisTik::create([
            'materi_id' => $materi1->id,
            'id_soal' => 'KUIS-HTML-02',
            'pertanyaan' => 'Atribut untuk hyperlink?',
            'tipe' => 'pilihan_ganda',
            'opsi_jawaban' => ['href', 'src', 'alt', 'style'],
            'kunci_jawaban' => 'href',
            'poin' => 25,
            'urutan' => 2,
        ]);

        // Sample lab cases for CSS
        LabPraktik::create([
            'materi_id' => $materi2->id,
            'id_lab' => 'LAB-CSS-01',
            'deskripsi_kasus' => 'Fix CSS box model: padding missing, border double.',
            'kode_soal_awal' => '.box { margin: 10px; padding: 20px; border: 5px solid red; }',
            'bug_target' => 'padding: 20px;',
            'solusi_fix' => '.box { margin: 10px; padding: 30px; border: 5px solid red; }',
            'tingkat_kesulitan' => 'mudah',
            'poin_max' => 100,
            'test_cases' => ['padding: 30px;', 'border: 5px solid red;'],
        ]);
    }
}
