<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MateriBelajar;
use Illuminate\Http\Request;

class MateriApiController extends Controller
{
    /**
     * GET /api/materi
     * Daftar semua materi yang published, beserta info kuis jika ada.
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $materi = MateriBelajar::where('published', true)
            ->with(['kuisSettings', 'kuis', 'attachments'])
            ->with(['progressBelajar' => fn($q) => $q->where('user_id', $user?->id)])
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(fn ($m) => $this->formatMateri($m, false));

        return response()->json([
            'success' => true,
            'total' => $materi->count(),
            'data' => $materi,
        ]);
    }

    /**
     * GET /api/materi/{materi}
     * Detail satu materi + konten + attachment.
     */
    public function show(Request $request, MateriBelajar $materi)
    {
        if (! $materi->published) {
            return response()->json(['success' => false, 'message' => 'Materi tidak tersedia.'], 404);
        }

        $user = $request->user();
        $materi->load(['kuisSettings', 'kuis', 'attachments', 'guru', 'progressBelajar' => fn($q) => $q->where('user_id', $user?->id)]);

        return response()->json([
            'success' => true,
            'data' => $this->formatMateri($materi, true),
        ]);
    }

    private function formatMateri(MateriBelajar $m, bool $withKonten = false): array
    {
        $progress = $m->progressBelajar->first();

        $data = [
            'id' => $m->id,
            'id_materi' => $m->id_materi,
            'judul' => $m->judul,
            'deskripsi' => $m->deskripsi,
            'kategori' => $m->kategori,
            'level' => $m->level,
            'estimasi_waktu' => $m->estimasi_waktu,
            'guru' => $m->guru ? ['name' => $m->guru->name] : null,
            'progres' => [
                'status' => $progress ? $progress->status : 'belum_mulai',
                'nilai_kuis' => $progress ? $progress->nilai_kuis : null,
                'nilai_akhir' => $progress ? $progress->nilai_akhir : null,
                'status_selesai' => $progress ? (bool) $progress->status_selesai : false,
                'persentase_selesai' => $progress ? $progress->persentase_selesai : 0,
            ],
            'kuis' => $m->kuisSettings ? [
                'ada' => true,
                'status' => $m->kuisSettings->status,
                'available' => $m->kuisSettings->isPublished(),
                'total_soal' => $m->kuis->count(),
                'kkm' => $m->kuisSettings->kkm,
            ] : ['ada' => false],
            'attachments' => $m->attachments->map(fn ($a) => [
                'id' => $a->id,
                'nama_file' => $a->nama_file,
                'url' => $a->url,
                'mime_type' => $a->mime_type,
                'ukuran' => $a->ukuran_readable,
                'is_image' => $a->isImage(),
                'is_pdf' => $a->isPdf(),
            ])->values(),
        ];

        if ($withKonten) {
            $data['konten'] = $m->konten;
        }

        return $data;
    }
}
