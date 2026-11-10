<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index()
    {
        $gurus = User::where('role', 'guru')->get();
        return view('admin.dashboard', compact('gurus'));
    }

    public function storeGuru(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'guru',
            'active' => true,
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Akun guru berhasil dibuat!');
    }
}
