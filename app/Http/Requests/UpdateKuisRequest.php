<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateKuisRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $kuis = $this->route('kuis');

        return [
            'pertanyaan' => [
                'sometimes',
                'required',
                'string',
                $kuis->materi_id
                    ? Rule::unique('kuis_tik', 'pertanyaan')->ignore($kuis->id)->where('materi_id', $kuis->materi_id)
                    : Rule::unique('kuis_tik', 'pertanyaan')->ignore($kuis->id)->where('kuis_settings_id', $kuis->kuis_settings_id),
            ],
            'tipe' => ['sometimes', 'in:pilihan_ganda,multiple_answer,essay'],
            'opsi_jawaban' => ['nullable', 'array', 'min:2'],
            'kunci_jawaban' => ['sometimes', 'required', 'array', 'min:1'],
            'kunci_jawaban.*' => ['string'],
            'penjelasan_opsi' => ['nullable', 'array'],
            'poin' => ['sometimes', 'integer', 'min:1', 'max:200'],
            'waktu' => ['nullable', 'integer', 'min:1', 'max:3600'],
            'urutan' => ['sometimes', 'integer', 'min:1'],
        ];
    }

    public function messages(): array
    {
        return [
            'pertanyaan.unique' => 'Pertanyaan ini sudah ada di kuis ini.',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $kuis = $this->route('kuis');
            
            // Skip essay soal
            if ($this->input('tipe', $kuis->tipe) === 'essay') {
                return;
            }

            $kunciJawaban = $this->input('kunci_jawaban', $kuis->kunci_jawaban);
            $opsiJawaban = $this->input('opsi_jawaban', $kuis->opsi_jawaban);

            if (!$kunciJawaban || !$opsiJawaban) {
                return;
            }

            // Cari index huruf dari kunci jawaban
            $kunciIndex = [];
            foreach ($kunciJawaban as $kunci) {
                $index = array_search($kunci, $opsiJawaban);
                if ($index !== false) {
                    $kunciIndex[] = $index;
                }
            }

            if (empty($kunciIndex)) {
                return;
            }

            // Ambil semua soal existing dalam kuis yang sama (exclude soal ini)
            $query = \App\Models\KuisTik::where('id', '!=', $kuis->id);
            if ($kuis->kuis_settings_id) {
                $query->where('kuis_settings_id', $kuis->kuis_settings_id);
            } elseif ($kuis->materi_id) {
                $query->where('materi_id', $kuis->materi_id)->whereNull('kuis_settings_id');
            } else {
                return;
            }

            $existingSoal = $query->where('tipe', '!=', 'essay')->get();

            // Hitung distribusi kunci jawaban yang sudah ada
            $distribusi = [0 => 0, 1 => 0, 2 => 0, 3 => 0]; // index 0=A, 1=B, 2=C, 3=D

            foreach ($existingSoal as $soal) {
                $opsi = $soal->opsi_jawaban ?? [];
                $kunci = $soal->kunci_jawaban ?? [];
                
                foreach ($kunci as $k) {
                    $idx = array_search($k, $opsi);
                    if ($idx !== false && $idx < 4) {
                        $distribusi[$idx]++;
                    }
                }
            }

            // Tambahkan soal update ke distribusi
            foreach ($kunciIndex as $idx) {
                if ($idx < 4) {
                    $distribusi[$idx]++;
                }
            }

            $totalSoal = $existingSoal->count() + 1;

            // Cek apakah ada satu opsi yang dominan (>60% dari total soal)
            $maxDistribusi = max($distribusi);
            $persentase = ($maxDistribusi / $totalSoal) * 100;

            if ($totalSoal >= 5 && $persentase > 60) {
                $huruf = ['A', 'B', 'C', 'D'];
                $dominanIndex = array_search($maxDistribusi, $distribusi);
                $validator->errors()->add(
                    'kunci_jawaban',
                    "Distribusi jawaban tidak merata. Opsi {$huruf[$dominanIndex]} sudah muncul {$maxDistribusi}x dari {$totalSoal} soal ({$persentase}%). Variasikan jawaban benar agar siswa tidak mudah menebak pola."
                );
            }
        });
    }
}
