<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index()
    {
        $gurus = Guru::all();
        return view('admin.dashboard', compact('gurus'));
    }

    public function storeGuru(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:gurus,email',
            'password' => 'required|string|min:6',
        ]);

        Guru::create([
            'nip' => 'G-' . rand(10000, 99999),
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'teacher',
            'sekolah' => 'Sekolah',
            'active' => true,
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Akun guru berhasil dibuat!');
    }
}
