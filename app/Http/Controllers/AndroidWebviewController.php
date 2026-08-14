<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class AndroidWebviewController extends Controller
{
    /**
     * SSO Callback — menerima token dari Super App Pekanbaru,
     * memverifikasi ke backend API, lalu menyimpan auth_token ke session.
     *
     * Route: GET /kencana/web-view/callback/{token}
     *
     * NOTE: Logika verifikasi token di bawah adalah PLACEHOLDER.
     * Ganti endpoint dan payload sesuai spesifikasi API SSO backend.
     */
    public function callback(string $token)
    {
        try {
            $base = rtrim((string) config('services.api.base_url'), '/');

            // ── PLACEHOLDER: Kirim token ke backend untuk diverifikasi ──
            // Sesuaikan endpoint dan key payload sesuai spesifikasi SSO backend.
            $response = Http::withOptions([
                'verify' => filter_var(config('services.api.verify_ssl', true), FILTER_VALIDATE_BOOLEAN),
            ])
                ->accept('application/json')
                ->post($base . '/v1/auth/sso-verify', [
                    'token' => $token,
                ]);

            $json = $response->json();

            if ($response->successful() && ($json['success'] ?? false)) {
                // Simpan auth_token yang dikembalikan backend ke session
                $authToken = $json['data']['token'] ?? $json['data']['access_token'] ?? null;

                if (! $authToken) {
                    return redirect()->route('webview.expired');
                }

                Session::put('auth_token', $authToken);
                Session::put('webview_mode', true); // flag bahwa user masuk lewat webview

                return redirect()->route('webview.menu');
            }
        } catch (\Throwable) {
            // Jatuh ke halaman expired
        }

        return redirect()->route('webview.expired');
    }

    /**
     * Halaman session expired / token tidak valid.
     * Route: GET /kencana/web-view/expired
     */
    public function expired()
    {
        return view('webview.expired');
    }
}
