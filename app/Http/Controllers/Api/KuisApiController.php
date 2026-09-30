<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MateriBelajar;
use App\Models\KuisTik;
use App\Models\KuisSettings;
use App\Models\ProgressBelajar;
use App\Models\User;
use Illuminate\Http\Request;

class KuisApiController extends Controller
{
    /**
     * GET /api/kuis/{materi}
     * Ambil semua soal kuis yang sudah published.
     * Soal dikocok urutan (shuffle) agar tidak mudah menghafal posisi.
     */
    public function show(MateriBelajar $materi)
    {
        $settings = KuisSettings::where('materi_id', $materi->id)
            ->where('status', 'published')
            ->first();

        if (!$settings) {
            return response()->json([
                'success' => false,
                'message' => 'Kuis untuk materi ini belum tersedia atau belum dipublish.',
            ], 404);
        }

        $soalList = KuisTik::where('materi_id', $materi->id)
            ->with('attachments')
            ->orderBy('urutan')
            ->get()
            ->map(fn($s) => $this->formatSoal($s));

        return response()->json([
            'success'  => true,
            'data'     => [
                'id_kuis'        => $settings->id_kuis,
                'judul_materi'   => $materi->judul,
                'total_soal'     => $soalList->count(),
                'waktu_per_soal' => $settings->waktu_per_soal,
                'satuan_waktu'   => $settings->satuan_waktu,
                'waktu_detik'    => $settings->waktuDalamDetik(),
                'kkm'            => $settings->kkm,
                'soal'           => $soalList,
            ],
        ]);
    }

    /**
     * POST /api/kuis/{materi}/submit
     * Kirim jawaban siswa, hitung skor, simpan ke progress_belajar.
     *
     * Body: {
     *   jawaban: [
     *     { id_soal: 1, jawaban: ["Opsi A"] },   // pilihan_ganda
     *     { id_soal: 2, jawaban: ["B", "D"] },    // multiple_answer
     *     { id_soal: 3, jawaban: ["teks bebas"] } // essay
     *   ]
     * }
     */
    public function submit(Request $request, MateriBelajar $materi)
    {
        $settings = KuisSettings::where('materi_id', $materi->id)
            ->where('status', 'published')
            ->first();

        if (!$settings) {
            return response()->json(['success' => false, 'message' => 'Kuis tidak tersedia.'], 404);
        }

        $request->validate([
            'jawaban'           => 'required|array|min:1',
            'jawaban.*.id_soal' => 'required|integer',
            'jawaban.*.jawaban' => 'required|array',
        ]);

        $soalMap = KuisTik::where('materi_id', $materi->id)
            ->get()
            ->keyBy('id');

        $totalPoin    = 0;
        $poinDapat    = 0;
        $hasilPerSoal = [];

        foreach ($request->jawaban as $item) {
            $soal = $soalMap->get($item['id_soal']);
            if (!$soal) continue;

            $totalPoin += $soal->poin;
            $jawabanSiswa = $item['jawaban'];

            // Hitung benar/salah
            $benar = false;

            if ($soal->tipe === 'essay') {
                // Essay: selalu dianggap submitted, nilai manual (default 0)
                $benar = false;
                $poinSoal = 0;
            } else {
                // Normalize: huruf besar, trim
                $kunciSoal    = array_map(fn($k) => strtolower(trim($k)), $soal->kunci_jawaban ?? []);
                $jawabanNorm  = array_map(fn($j) => strtolower(trim($j)), $jawabanSiswa);

                // Benar jika semua kunci ada di jawaban dan jumlahnya sama
                sort($kunciSoal);
                sort($jawabanNorm);
                $benar    = $kunciSoal === $jawabanNorm;
                $poinSoal = $benar ? $soal->poin : 0;
                $poinDapat += $poinSoal;
            }

            $hasilPerSoal[] = [
                'id_soal'        => $soal->id,
                'pertanyaan'     => $soal->pertanyaan,
                'tipe'           => $soal->tipe,
                'jawaban_siswa'  => $jawabanSiswa,
                'kunci_jawaban'  => $soal->tipe !== 'essay' ? $soal->kunci_jawaban : null,
                'penjelasan'     => $soal->penjelasan_opsi,
                'benar'          => $benar,
                'poin_dapat'     => $soal->tipe === 'essay' ? null : ($benar ? $soal->poin : 0),
                'poin_max'       => $soal->poin,
            ];
        }

        // Hitung persentase dan nilai akhir (skala 100)
        $persentase  = $totalPoin > 0 ? round(($poinDapat / $totalPoin) * 100) : 0;
        $nilaiAkhir  = $persentase;
        $lulus       = $persentase >= $settings->kkm;

        // Simpan ke progress_belajar
        $user = $request->user();
        if ($user instanceof User) {
            ProgressBelajar::updateOrCreate(
                ['user_id' => $user->id, 'materi_id' => $materi->id],
                [
                    'nilai_kuis'         => $nilaiAkhir,
                    'nilai_akhir'        => $nilaiAkhir,
                    'status_selesai'     => $lulus,
                    'persentase_selesai' => $persentase,
                    'status'             => 'selesai',
                    'selesai_belajar'    => now(),
                ]
            );
        }

        return response()->json([
            'success' => true,
            'data'    => [
                'poin_dapat'  => $poinDapat,
                'total_poin'  => $totalPoin,
                'persentase'  => $persentase,
                'nilai_akhir' => $nilaiAkhir,
                'lulus'       => $lulus,
                'kkm'         => $settings->kkm,
                'pesan'       => $lulus
                    ? "Selamat! Kamu lulus dengan nilai {$nilaiAkhir}."
                    : "Nilai kamu {$nilaiAkhir}, belum mencapai KKM {$settings->kkm}. Coba lagi!",
                'hasil_per_soal' => $hasilPerSoal,
            ],
        ]);
    }

    private function formatSoal(KuisTik $soal): array
    {
        // Acak urutan opsi jawaban agar tidak mudah ditebak
        $opsi = $soal->opsi_jawaban ?? [];
        $penj = $soal->penjelasan_opsi ?? [];

        // Gabungkan opsi + penjelasan sebelum shuffle
        $opsiDenganPenj = collect($opsi)->map(fn($o, $i) => [
            'teks'       => $o,
            'penjelasan' => $penj[$i] ?? null,
        ])->values()->toArray();

        if ($soal->tipe !== 'essay' && count($opsiDenganPenj) > 1) {
            shuffle($opsiDenganPenj);
        }

        // Attachment gambar per opsi (format: opsi-A-..., opsi-B-...)
        $opsiImages = [];
        foreach ($soal->attachments as $att) {
            if (preg_match('/^opsi-([ABCD])-/i', $att->nama_file, $m)) {
                $opsiImages[strtolower($m[1])] = $att->url;
            }
        }

        // Attachment soal (bukan opsi)
        $soalAttachments = $soal->attachments
            ->filter(fn($a) => !preg_match('/^opsi-[ABCD]-/i', $a->nama_file))
            ->map(fn($a) => [
                'url'       => $a->url,
                'mime_type' => $a->mime_type,
                'is_image'  => $a->isImage(),
                'is_pdf'    => $a->isPdf(),
            ])->values();

        return [
            'id'          => $soal->id,
            'id_soal'     => $soal->id_soal,
            'tipe'        => $soal->tipe,
            'pertanyaan'  => $soal->pertanyaan,
            'poin'        => $soal->poin,
            'urutan'      => $soal->urutan,
            'opsi'        => $opsiDenganPenj, // sudah ter-shuffle
            'opsi_images' => $opsiImages,     // { a: url, b: url, ... }
            'attachments' => $soalAttachments,
            // kunci_jawaban TIDAK dikirim ke client — hanya ada di submit response
        ];
    }
}
