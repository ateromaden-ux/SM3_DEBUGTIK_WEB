<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateMateriRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $materi = $this->route('materi');

        return [
            'judul' => [
                'sometimes',
                'string',
                'max:255',
                Rule::unique('materi_belajar', 'judul')->ignore($materi),
            ],
            'deskripsi' => ['sometimes', 'nullable', 'string'],
            'kategori' => ['sometimes', 'in:HTML Dasar,CSS Dasar,JS Dasar,Web Responsif'],
            'level' => ['sometimes', 'in:Pemula,Menengah,Lanjutan'],
            'konten' => ['sometimes', 'string'],
            'estimasi_waktu' => ['sometimes', 'integer', 'min:0', 'max:9999'],
            'tingkat_kesulitan' => ['sometimes', 'integer', 'in:1,2,3'],
            'published' => ['sometimes', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'judul.unique' => 'Judul materi ini sudah ada, gunakan judul yang berbeda.',
        ];
    }
}
