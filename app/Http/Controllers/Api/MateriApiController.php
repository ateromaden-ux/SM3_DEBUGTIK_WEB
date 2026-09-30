<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MateriBelajar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MateriApiController extends Controller
{
    /**
     * GET /api/materi
     * Daftar semua materi yang published, beserta info kuis jika ada.
     */
    public function index(Request $request)
    {
        $materi = MateriBelajar::where('published', true)
            ->with(['kuisSettings', 'kuis', 'attachments'])
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(fn($m) => $this->formatMateri($m, false));

        return response()->json([
            'success' => true,
            'total'   => $materi->count(),
            'data'    => $materi,
        ]);
    }

    /**
     * GET /api/materi/{materi}
     * Detail satu materi + konten + attachment.
     */
    public function show(MateriBelajar $materi)
    {
        if (!$materi->published) {
            return response()->json(['success' => false, 'message' => 'Materi tidak tersedia.'], 404);
        }

        $materi->load(['kuisSettings', 'kuis', 'attachments', 'guru']);

        return response()->json([
            'success' => true,
            'data'    => $this->formatMateri($materi, true),
        ]);
    }

    private function formatMateri(MateriBelajar $m, bool $withKonten = false): array
    {
        $data = [
            'id'              => $m->id,
            'id_materi'       => $m->id_materi,
            'judul'           => $m->judul,
            'deskripsi'       => $m->deskripsi,
            'kategori'        => $m->kategori,
            'level'           => $m->level,
            'estimasi_waktu'  => $m->estimasi_waktu,
            'guru'            => $m->guru ? ['name' => $m->guru->name] : null,
            'kuis' => $m->kuisSettings ? [
                'ada'         => true,
                'status'      => $m->kuisSettings->status,
                'available'   => $m->kuisSettings->isPublished(),
                'total_soal'  => $m->kuis->count(),
                'waktu_per_soal' => $m->kuisSettings->waktu_per_soal,
                'satuan_waktu'   => $m->kuisSettings->satuan_waktu,
                'kkm'            => $m->kuisSettings->kkm,
            ] : ['ada' => false],
            'attachments' => $m->attachments->map(fn($a) => [
                'id'        => $a->id,
                'nama_file' => $a->nama_file,
                'url'       => $a->url,
                'mime_type' => $a->mime_type,
                'ukuran'    => $a->ukuran_readable,
                'is_image'  => $a->isImage(),
                'is_pdf'    => $a->isPdf(),
            ])->values(),
        ];

        if ($withKonten) {
            $data['konten'] = $m->konten;
        }

        return $data;
    }
}
