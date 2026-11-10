<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Models\User;

class AdminAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.admin-login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $credentials['email'])
                    ->where('role', 'admin')
                    ->first();

        if ($user && Hash::check($credentials['password'], $user->password)) {
            Auth::guard('web')->login($user, $request->filled('remember'));
            $request->session()->regenerate();
            return redirect()->intended('/admin/dashboard');
        }

        throw ValidationException::withMessages([
            'email' => 'Kredensial admin tidak valid.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/admin/login');
    }
}
