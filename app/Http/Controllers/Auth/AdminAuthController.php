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
            'email' => 'required',
            'password' => 'required',
        ]);

        $admin = \App\Models\SuperAdmin::where('username', $credentials['email'])->first();

        if ($admin && \Hash::check($credentials['password'], $admin->password)) {
            session(['is_super_admin' => true]);
            $request->session()->regenerate();
            return redirect('/admin/dashboard');
        }

        throw \Illuminate\Validation\ValidationException::withMessages([
            'email' => 'Kredensial tidak valid.',
        ]);
    }

    public function logout(Request $request)
    {
        session()->forget('is_super_admin');
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/admin/login');
    }
}
