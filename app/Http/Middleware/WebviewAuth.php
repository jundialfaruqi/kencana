<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class WebviewAuth
{
    public function handle(Request $request, Closure $next): Response
    {
        // ══════════════════════════════════════════════════════════════
        // MODE TESTING (tanpa SSO) — uncomment baris di bawah untuk bypass
        // return $next($request);
        // ══════════════════════════════════════════════════════════════

        // MODE PRODUCTION (dengan SSO) — comment baris ini saat testing
        if (! Session::has('auth_token')) {
            return redirect()->route('webview.expired');
        }

        return $next($request);
    }
}
