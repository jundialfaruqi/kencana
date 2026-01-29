<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class ApiAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ?string $role = null): Response
    {
        if (!Session::has('auth_token')) {
            return redirect('/login');
        }

        if ($role) {
            $user = Session::get('user_data');

            if (!$user || ($role === 'admin' && !in_array($user['role'], ['admin', 'superadmin'])) || ($role !== 'admin' && $user['role'] !== $role)) {
                // Jika bukan admin atau superadmin tapi mencoba akses dashboard, lempar ke home
                if ($role === 'admin') {
                    return redirect('/');
                }
            }
        }

        return $next($request);
    }
}
