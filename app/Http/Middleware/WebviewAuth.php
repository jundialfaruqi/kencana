<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class WebviewAuth
{
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Cek session — sudah login sebelumnya
        if (Session::has('auth_token')) {
            return $next($request);
        }

        // 2. Cek ?token= di URL — jika Next.js / iframe mengoper bearer token langsung
        $directToken = $request->query('token');
        if (!empty($directToken)) {
            Session::put('auth_token', $directToken);
            Session::put('webview_mode', true);
            return $next($request);
        }

        // 3. Fallback: cek ?code= di URL — verifikasi langsung ke Kencana API
        $code = $request->query('code');
        if (!empty($code)) {
            try {
                $apiBase   = rtrim((string) config('services.api.base_url'), '/');
                $verifySsl = filter_var(config('services.api.verify_ssl', true), FILTER_VALIDATE_BOOLEAN);

                $response = Http::withOptions(['verify' => $verifySsl])
                    ->accept('application/json')
                    ->get($apiBase . '/v1/callback', ['code' => $code]);

                $json = $response->json();

                if (($json['success'] ?? false) === true) {
                    $authToken = $json['data']['token'] ?? null;

                    if (!empty($authToken)) {
                        Session::put('auth_token', $authToken);
                        Session::put('webview_mode', true);

                        Log::info('[WebView SSO] Login via URL code berhasil.', [
                            'user_id'   => $json['data']['user']['id'] ?? null,
                            'user_name' => $json['data']['user']['name'] ?? null,
                            'path'      => $request->path(),
                        ]);

                        return $next($request);
                    }
                }

                Log::warning('[WebView SSO] Verifikasi code via URL gagal.', [
                    'message' => $json['message'] ?? '-',
                    'path'    => $request->path(),
                ]);
            } catch (\Throwable $e) {
                Log::error('[WebView SSO] Exception saat verifikasi code via URL.', [
                    'error' => $e->getMessage(),
                ]);
            }
        }

        // 3. Tidak ada session dan tidak ada code yang valid → expired
        return redirect()->route('webview.expired');
    }
}
