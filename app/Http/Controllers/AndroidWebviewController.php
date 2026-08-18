<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class AndroidWebviewController extends Controller
{
    /**
     * SSO Callback — Super App membuka WebView ke URL ini dengan ?code=<sso_code>.
     *
     * Alur:
     *   1. Super App login ke SSO → dapat access_token
     *   2. Super App hit generate-code SSO → dapat code + callback_url
     *   3. Super App buka WebView ke: /kencana/web-view/callback?code=<code>
     *   4. Controller ini hit Kencana API: GET /api/v1/callback?code=<code>
     *   5. Jika sukses → simpan token ke session → redirect ke /menu
     *   6. Jika gagal  → redirect ke /expired
     *
     * Route: GET /kencana/web-view/callback?code={sso_code}
     */
    public function callback(Request $request)
    {
        $code = $request->query('code');

        // Tidak ada code → tampilkan error inline
        if (empty($code)) {
            Log::warning('[WebView SSO] Callback dipanggil tanpa code.');
            return response()->view('webview.callback-error', [
                'message'    => 'Parameter kode tidak ditemukan.',
                'ssoMessage' => null,
            ]);
        }

        try {
            $apiBase   = rtrim((string) config('services.api.base_url'), '/');
            $verifySsl = filter_var(config('services.api.verify_ssl', true), FILTER_VALIDATE_BOOLEAN);

            // Hit Kencana API untuk menukar code dengan token
            $response = Http::withOptions(['verify' => $verifySsl])
                ->accept('application/json')
                ->get($apiBase . '/v1/callback', [
                    'code' => $code,
                ]);

            $json = $response->json();

            // Cek sukses dari body response (bukan hanya HTTP status)
            if (($json['success'] ?? false) === true) {
                $authToken = $json['data']['token'] ?? null;

                if (empty($authToken)) {
                    Log::warning('[WebView SSO] Response sukses tapi token kosong.', ['json' => $json]);
                    return response()->view('webview.callback-error', [
                        'message'    => 'Login berhasil tetapi token tidak ditemukan.',
                        'ssoMessage' => null,
                    ]);
                }

                Session::put('auth_token', $authToken);
                Session::put('webview_mode', true);

                Log::info('[WebView SSO] Login berhasil.', [
                    'user_id'   => $json['data']['user']['id'] ?? null,
                    'user_name' => $json['data']['user']['name'] ?? null,
                ]);

                return redirect()->route('webview.menu');
            }

            // Gagal: tampilkan pesan dari API secara inline
            $message    = $json['message'] ?? 'Verifikasi SSO gagal.';
            $ssoMessage = $json['sso_response']['message'] ?? null;

            Log::warning('[WebView SSO] Callback gagal.', [
                'message'      => $message,
                'sso_response' => $json['sso_response'] ?? null,
            ]);

            return response()->view('webview.callback-error', [
                'message'    => $message,
                'ssoMessage' => $ssoMessage,
            ]);

        } catch (\Throwable $e) {
            Log::error('[WebView SSO] Exception saat callback.', [
                'error' => $e->getMessage(),
                'code'  => $code,
            ]);

            return response()->view('webview.callback-error', [
                'message'    => 'Terjadi kesalahan saat memproses verifikasi.',
                'ssoMessage' => $e->getMessage(),
            ], 500);
        }
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
