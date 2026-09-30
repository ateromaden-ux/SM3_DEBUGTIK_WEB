<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreKuisRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $materiId = $this->input('materi_id');

        return [
            'materi_id' => ['required', 'exists:materi_belajar,id'],
            'id_soal' => ['nullable', 'string', 'unique:kuis_tik,id_soal'],
            'pertanyaan' => [
                'required',
                'string',
                Rule::unique('kuis_tik', 'pertanyaan')->where('materi_id', $materiId),
            ],
            'tipe' => ['required', 'in:pilihan_ganda,multiple_answer,essay'],
            'opsi_jawaban' => ['nullable', 'array', 'min:2'],
            'kunci_jawaban' => ['required', 'array', 'min:1'],
            'kunci_jawaban.*' => ['string'],
            'penjelasan_opsi' => ['nullable', 'array'],
            'poin' => ['required', 'integer', 'min:1', 'max:200'],
            'urutan' => ['nullable', 'integer', 'min:1'],
        ];
    }

    public function messages(): array
    {
        return [
            'id_soal.unique' => 'ID soal sudah digunakan.',
            'pertanyaan.unique' => 'Pertanyaan ini sudah ada di kuis materi ini.',
            'poin.required' => 'Poin wajib diisi.',
        ];
    }
}
