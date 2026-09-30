<?php

namespace App\Http\Controllers;

use App\Models\Attachment;
use App\Models\MateriBelajar;
use App\Models\KuisTik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AttachmentController extends Controller
{
    /**
     * POST /api/attachment/materi/{materi}
     * Upload satu atau lebih file ke materi belajar.
     * Accepted: PDF, gambar (jpg/png/gif/webp), dokumen (doc/docx/ppt/pptx)
     */
    public function uploadMateri(Request $request, MateriBelajar $materi)
    {
        $request->validate([
            'files'    => 'required|array|min:1|max:5',
            'files.*'  => 'file|max:20480|mimes:pdf,jpg,jpeg,png,gif,webp,doc,docx,ppt,pptx',
        ], [
            'files.*.max'   => 'Ukuran file maksimal 20 MB.',
            'files.*.mimes' => 'Tipe file tidak didukung. Gunakan PDF, gambar, atau dokumen.',
        ]);

        $uploaded = [];

        foreach ($request->file('files') as $file) {
            $path = $file->store("attachments/materi/{$materi->id}", 'public');

            $att = Attachment::create([
                'attachable_type' => MateriBelajar::class,
                'attachable_id'   => $materi->id,
                'nama_file'       => $file->getClientOriginalName(),
                'path'            => $path,
                'mime_type'       => $file->getMimeType(),
                'ukuran'          => $file->getSize(),
                'disk'            => 'public',
            ]);

            $uploaded[] = $this->formatAttachment($att);
        }

        return response()->json([
            'success' => true,
            'message' => count($uploaded) . ' file berhasil diunggah.',
            'data'    => $uploaded,
        ], 201);
    }

    /**
     * POST /api/attachment/soal/{soal}
     * Upload gambar/file ke soal kuis.
     * Accepted: gambar saja (untuk ditampilkan di soal)
     */
    public function uploadSoal(Request $request, KuisTik $soal)
    {
        $request->validate([
            'files'   => 'required|array|min:1|max:3',
            'files.*' => 'file|max:5120|mimes:jpg,jpeg,png,gif,webp,pdf',
        ], [
            'files.*.max'   => 'Ukuran file maksimal 5 MB.',
            'files.*.mimes' => 'Hanya gambar (JPG/PNG/GIF/WebP) dan PDF yang diizinkan.',
        ]);

        $uploaded = [];

        foreach ($request->file('files') as $file) {
            $path = $file->store("attachments/soal/{$soal->id}", 'public');

            $att = Attachment::create([
                'attachable_type' => KuisTik::class,
                'attachable_id'   => $soal->id,
                'nama_file'       => $file->getClientOriginalName(),
                'path'            => $path,
                'mime_type'       => $file->getMimeType(),
                'ukuran'          => $file->getSize(),
                'disk'            => 'public',
            ]);

            $uploaded[] = $this->formatAttachment($att);
        }

        return response()->json([
            'success' => true,
            'message' => count($uploaded) . ' file berhasil diunggah.',
            'data'    => $uploaded,
        ], 201);
    }

    /**
     * DELETE /api/attachment/{attachment}
     * Hapus satu attachment.
     */
    public function destroy(Attachment $attachment)
    {
        Storage::disk($attachment->disk)->delete($attachment->path);
        $attachment->delete();

        return response()->json([
            'success' => true,
            'message' => 'File berhasil dihapus.',
        ]);
    }

    /**
     * GET /api/attachment/materi/{materi}
     * List semua attachment untuk satu materi.
     */
    public function listMateri(MateriBelajar $materi)
    {
        $attachments = $materi->attachments()->latest()->get()
            ->map(fn($a) => $this->formatAttachment($a));

        return response()->json(['success' => true, 'data' => $attachments]);
    }

    /**
     * GET /api/attachment/soal/{soal}
     * List semua attachment untuk satu soal.
     */
    public function listSoal(KuisTik $soal)
    {
        $attachments = $soal->attachments()->latest()->get()
            ->map(fn($a) => $this->formatAttachment($a));

        return response()->json(['success' => true, 'data' => $attachments]);
    }

    // ─── Helper ───────────────────────────────────────────────────────────────

    private function formatAttachment(Attachment $att): array
    {
        return [
            'id'              => $att->id,
            'nama_file'       => $att->nama_file,
            'url'             => $att->url,
            'mime_type'       => $att->mime_type,
            'ukuran'          => $att->ukuran,
            'ukuran_readable' => $att->ukuran_readable,
            'icon'            => $att->icon,
            'is_image'        => $att->isImage(),
            'is_pdf'          => $att->isPdf(),
        ];
    }
}
