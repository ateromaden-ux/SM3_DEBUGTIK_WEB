<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SuperAdminController extends Controller
{
    public function index()
    {
        $gurus = Guru::all();
        return view('admin.kelola-guru', compact('gurus'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:gurus,email',
            'password' => 'required|min:6',
            'role' => 'required|in:teacher,lab_admin',
            'sekolah' => 'required'
        ]);

        Guru::create([
            'nip' => 'G-' . substr(md5(time()), 0, 8),
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
            'sekolah' => $validated['sekolah'],
            'active' => true,
        ]);

        return redirect()->back()->with('success', 'Guru berhasil ditambahkan ke database.');
    }

    public function destroy(Guru $guru)
    {
        $guru->delete();
        return redirect()->route('admin.guru.index')->with('success', 'Guru berhasil dihapus');
    }
}
