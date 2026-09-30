<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMateriRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id_materi' => ['required', 'string', 'max:100', 'unique:materi_belajar,id_materi'],
            'judul' => ['required', 'string', 'max:255', 'unique:materi_belajar,judul'],
            'deskripsi' => ['nullable', 'string'],
            'kategori' => ['required', 'in:HTML Dasar,CSS Dasar,JS Dasar,Web Responsif'],
            'level' => ['required', 'in:Pemula,Menengah,Lanjutan'],
            'konten' => ['nullable', 'string'],
            'estimasi_waktu' => ['required', 'integer', 'min:0', 'max:9999'],
            'tingkat_kesulitan' => ['integer', 'in:1,2,3'],
        ];
    }

    public function messages(): array
    {
        return [
            'id_materi.unique' => 'ID materi sudah digunakan, gunakan ID yang berbeda.',
            'judul.unique' => 'Judul materi ini sudah ada, gunakan judul yang berbeda.',
        ];
    }
}
