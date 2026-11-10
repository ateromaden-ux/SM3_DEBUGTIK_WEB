<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Cek guard 'guru' atau default guard auth jika admin login via guru guard
        $user = auth()->user() ?? auth()->guard('guru')->user();
        
        if ($user && isset($user->role) && $user->role === 'admin') {
            return $next($request);
        }
        
        return redirect('/dashboard')->with('error', 'Akses khusus Super Admin ditolak!');
    }
}
