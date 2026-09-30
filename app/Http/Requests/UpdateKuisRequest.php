<?php

namespace App\Http\Requests;

use App\Models\KuisTik;
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
        /** @var KuisTik $kuis */
        $kuis = $this->route('kuis');

        return [
            'pertanyaan' => [
                'sometimes',
                'required',
                'string',
                Rule::unique('kuis_tik', 'pertanyaan')
                    ->ignore($kuis->id)
                    ->where('materi_id', $kuis->materi_id),
            ],
            'tipe' => ['sometimes', 'in:pilihan_ganda,multiple_answer,essay'],
            'opsi_jawaban' => ['nullable', 'array', 'min:2'],
            'kunci_jawaban' => ['sometimes', 'required', 'array', 'min:1'],
            'kunci_jawaban.*' => ['string'],
            'penjelasan_opsi' => ['nullable', 'array'],
            'poin' => ['sometimes', 'integer', 'min:1', 'max:200'],
            'urutan' => ['sometimes', 'integer', 'min:1'],
        ];
    }

    public function messages(): array
    {
        return [
            'pertanyaan.unique' => 'Pertanyaan ini sudah ada di kuis materi ini.',
        ];
    }
}
