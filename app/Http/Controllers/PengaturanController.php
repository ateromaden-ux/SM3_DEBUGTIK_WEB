<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class PengaturanController extends Controller
{
    /**
     * POST /pengaturan/profil
     * Update profil guru: nama, nip, sekolah, mata_pelajaran, no_hp,
     * tahun_ajaran, semester, foto_profil.
     */
    public function updateProfil(Request $request)
    {
        $guru = Auth::guard('guru')->user();

        $validated = $request->validate([
            'name'           => 'required|string|max:255',
            'nip'            => 'required|string|max:50|unique:gurus,nip,' . $guru->id,
            'sekolah'        => 'nullable|string|max:255',
            'mata_pelajaran' => 'nullable|string|max:100',
            'no_hp'          => 'nullable|string|max:15',
            'tahun_ajaran'   => 'required|string|max:20',
            'semester'       => 'required|in:Ganjil,Genap',
            'foto'           => 'nullable|image|max:2048',
        ], [
            'nip.unique' => 'NIP sudah digunakan oleh akun lain.',
        ]);

        // Upload foto profil
        if ($request->hasFile('foto')) {
            // Hapus foto lama kalau ada
            if ($guru->foto_profil) {
                Storage::disk('public')->delete($guru->foto_profil);
            }
            $validated['foto_profil'] = $request->file('foto')->store('profil/guru', 'public');
        }
        unset($validated['foto']);

        $guru->update($validated);

        return response()->json([
            'success'     => true,
            'message'     => 'Profil berhasil diperbarui.',
            'foto_url'    => $guru->foto_profil
                ? Storage::disk('public')->url($guru->foto_profil)
                : null,
            'name'        => $guru->name,
            'tahun_ajaran'=> $guru->tahun_ajaran,
            'semester'    => $guru->semester,
        ]);
    }

    /**
     * POST /pengaturan/password
     * Ganti password guru.
     */
    public function updatePassword(Request $request)
    {
        $guru = Auth::guard('guru')->user();

        $request->validate([
            'current_password'      => 'required|string',
            'password'              => 'required|string|min:8|confirmed',
        ], [
            'password.confirmed' => 'Konfirmasi password baru tidak cocok.',
            'password.min'       => 'Password baru minimal 8 karakter.',
        ]);

        if (!Hash::check($request->current_password, $guru->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Password lama salah.',
            ], 422);
        }

        $guru->update(['password' => $request->password]);

        return response()->json([
            'success' => true,
            'message' => 'Password berhasil diubah.',
        ]);
    }
}
