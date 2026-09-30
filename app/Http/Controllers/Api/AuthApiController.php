<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Guru;
use App\Models\ApiToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthApiController extends Controller
{
    /**
     * POST /api/auth/register
     * Registrasi akun siswa baru.
     *
     * Body: { name, email, password, password_confirmation, kelas?, no_hp? }
     * Response: { success, message, data: { user, token } }
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name'                  => 'required|string|max:255',
            'email'                 => 'required|email|unique:users,email',
            'password'              => 'required|string|min:8|confirmed',
            'kelas'                 => 'nullable|string|max:20',
            'no_hp'                 => 'nullable|string|max:15',
        ], [
            'email.unique'          => 'Email sudah terdaftar.',
            'password.min'          => 'Password minimal 8 karakter.',
            'password.confirmed'    => 'Konfirmasi password tidak cocok.',
        ]);

        $user = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => $validated['password'], // auto-hashed via cast
            'kelas'    => $validated['kelas'] ?? null,
            'no_hp'    => $validated['no_hp']  ?? null,
            'active'   => true,
        ]);

        $token = $user->createApiToken('android-register');

        return response()->json([
            'success' => true,
            'message' => 'Registrasi berhasil. Selamat datang, ' . $user->name . '!',
            'data'    => [
                'token' => $token,
                'type'  => 'Bearer',
                'user'  => $this->formatUser($user),
            ],
        ], 201);
    }

    /**
     * POST /api/auth/login
     * Login untuk siswa (users) atau guru (gurus).
     *
     * Body: { email, password, role?: "siswa"|"guru" }
     * Response: { success, message, data: { token, type, user|guru, role } }
     */
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
            'role'     => 'nullable|in:siswa,guru',
        ]);

        $role  = $request->input('role', 'siswa'); // default: coba siswa dulu
        $email = $request->input('email');
        $pass  = $request->input('password');

        // ── Coba login sebagai siswa ──────────────────────────────────────────
        if ($role !== 'guru') {
            $user = User::where('email', $email)->where('active', true)->first();

            if ($user && Hash::check($pass, $user->password)) {
                // Hapus token lama untuk device ini (opsional — bisa multi-device)
                $user->apiTokens()->where('name', 'android-login')->delete();
                $token = $user->createApiToken('android-login');

                return response()->json([
                    'success' => true,
                    'message' => 'Login berhasil.',
                    'data'    => [
                        'token' => $token,
                        'type'  => 'Bearer',
                        'role'  => 'siswa',
                        'user'  => $this->formatUser($user),
                    ],
                ]);
            }
        }

        // ── Coba login sebagai guru ───────────────────────────────────────────
        if ($role !== 'siswa') {
            $guru = Guru::where('email', $email)->where('active', true)->first();

            if ($guru && Hash::check($pass, $guru->password)) {
                $guru->apiTokens()->where('name', 'android-login')->delete();
                $token = $guru->createApiToken('android-login');

                return response()->json([
                    'success' => true,
                    'message' => 'Login berhasil.',
                    'data'    => [
                        'token' => $token,
                        'type'  => 'Bearer',
                        'role'  => 'guru',
                        'guru'  => $this->formatGuru($guru),
                    ],
                ]);
            }
        }

        return response()->json([
            'success' => false,
            'message' => 'Email atau password salah.',
        ], 401);
    }

    /**
     * POST /api/auth/logout
     * Logout — hapus token yang dipakai sekarang.
     * Header: Authorization: Bearer {token}
     */
    public function logout(Request $request)
    {
        $plain  = $request->bearerToken();
        $hashed = hash('sha256', $plain ?? '');
        ApiToken::where('token', $hashed)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Logout berhasil.',
        ]);
    }

    /**
     * GET /api/auth/me
     * Ambil profil user/guru yang sedang login.
     * Header: Authorization: Bearer {token}
     */
    public function me(Request $request)
    {
        $tokenable = $request->user(); // diset oleh middleware ApiTokenAuth

        if ($tokenable instanceof User) {
            return response()->json([
                'success' => true,
                'role'    => 'siswa',
                'data'    => $this->formatUser($tokenable),
            ]);
        }

        if ($tokenable instanceof Guru) {
            return response()->json([
                'success' => true,
                'role'    => 'guru',
                'data'    => $this->formatGuru($tokenable),
            ]);
        }

        return response()->json(['success' => false, 'message' => 'User tidak ditemukan.'], 404);
    }

    /**
     * PUT /api/auth/profile
     * Update profil siswa (nama, kelas, no_hp, foto_profil).
     */
    public function updateProfile(Request $request)
    {
        $user = $request->user();

        if (!($user instanceof User)) {
            return response()->json(['message' => 'Hanya siswa yang bisa update profil via endpoint ini.'], 403);
        }

        $validated = $request->validate([
            'name'   => 'sometimes|string|max:255',
            'kelas'  => 'sometimes|nullable|string|max:20',
            'no_hp'  => 'sometimes|nullable|string|max:15',
            'foto'   => 'sometimes|image|max:2048', // maks 2 MB
        ]);

        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('profil/siswa', 'public');
            $validated['foto_profil'] = $path;
            unset($validated['foto']);
        }

        $user->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Profil berhasil diperbarui.',
            'data'    => $this->formatUser($user->fresh()),
        ]);
    }

    /**
     * PUT /api/auth/change-password
     * Ganti password siswa.
     */
    public function changePassword(Request $request)
    {
        $user = $request->user();

        if (!($user instanceof User)) {
            return response()->json(['message' => 'Endpoint ini hanya untuk siswa.'], 403);
        }

        $request->validate([
            'current_password' => 'required|string',
            'password'         => 'required|string|min:8|confirmed',
        ], [
            'password.confirmed' => 'Konfirmasi password baru tidak cocok.',
        ]);

        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Password lama salah.',
            ], 422);
        }

        $user->update(['password' => $request->password]);

        return response()->json([
            'success' => true,
            'message' => 'Password berhasil diubah.',
        ]);
    }

    // ─── Helpers ──────────────────────────────────────────────────────────────

    private function formatUser(User $user): array
    {
        return [
            'id'          => $user->id,
            'name'        => $user->name,
            'email'       => $user->email,
            'kelas'       => $user->kelas,
            'no_hp'       => $user->no_hp,
            'foto_profil' => $user->foto_profil
                ? \Illuminate\Support\Facades\Storage::disk('public')->url($user->foto_profil)
                : null,
            'active'      => $user->active,
            'last_login'  => $user->last_login?->toIso8601String(),
            'created_at'  => $user->created_at?->toIso8601String(),
        ];
    }

    private function formatGuru(Guru $guru): array
    {
        return [
            'id'       => $guru->id,
            'name'     => $guru->name,
            'email'    => $guru->email,
            'role'     => $guru->role,
            'sekolah'  => $guru->sekolah,
            'active'   => $guru->active,
            'last_login' => $guru->last_login?->toIso8601String(),
        ];
    }
}
