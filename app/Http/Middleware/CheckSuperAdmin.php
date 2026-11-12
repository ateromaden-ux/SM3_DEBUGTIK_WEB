<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckSuperAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!session()->has('is_super_admin')) {
            return redirect('/admin/login')->withErrors(['email' => 'Silakan login terlebih dahulu.']);
        }

        return $next($request);
    }
}
