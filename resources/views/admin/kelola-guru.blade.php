@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Kelola Akun Guru</h1>
        <button onclick="document.getElementById('modal-tambah').classList.remove('hidden')" class="bg-blue-600 text-white px-4 py-2 rounded">Tambah Guru</button>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white shadow-md rounded my-6 overflow-x-auto">
        <table class="min-w-full bg-white">
            <thead>
                <tr class="w-full bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                    <th class="py-3 px-6 text-left">Nama</th>
                    <th class="py-3 px-6 text-left">Email</th>
                    <th class="py-3 px-6 text-left">Role</th>
                    <th class="py-3 px-6 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 text-sm font-light">
                @foreach($gurus as $guru)
                <tr class="border-b border-gray-200 hover:bg-gray-100">
                    <td class="py-3 px-6 text-left">{{ $guru->name }}</td>
                    <td class="py-3 px-6 text-left">{{ $guru->email }}</td>
                    <td class="py-3 px-6 text-left">{{ $guru->role }}</td>
                    <td class="py-3 px-6 text-center">
                        <form action="{{ route('admin.guru.destroy', $guru->id) }}" method="POST" onsubmit="return confirm('Hapus guru ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Tambah -->
<div id="modal-tambah" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden flex items-center justify-center">
    <div class="bg-white p-8 rounded shadow-lg w-full max-w-md">
        <h2 class="text-xl font-bold mb-4">Tambah Akun Guru</h2>
        <form action="{{ route('admin.guru.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700">Nama</label>
                <input type="text" name="name" class="w-full border rounded px-3 py-2" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700">Email</label>
                <input type="email" name="email" class="w-full border rounded px-3 py-2" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700">Password</label>
                <input type="password" name="password" class="w-full border rounded px-3 py-2" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700">Role</label>
                <select name="role" class="w-full border rounded px-3 py-2">
                    <option value="teacher">Teacher</option>
                    <option value="lab_admin">Lab Admin</option>
                </select>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700">Sekolah</label>
                <input type="text" name="sekolah" class="w-full border rounded px-3 py-2" required>
            </div>
            <div class="flex justify-end">
                <button type="button" onclick="document.getElementById('modal-tambah').classList.add('hidden')" class="mr-2 px-4 py-2 text-gray-600">Batal</button>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection
