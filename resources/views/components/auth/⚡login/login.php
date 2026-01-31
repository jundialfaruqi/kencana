<?php

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

new #[Layout('layouts::auth.app')] #[Title('Login')] class extends Component {
    public $ready = false;

    #[Validate]
    public $email = '';

    #[Validate]
    public $password = '';

    protected function rules()
    {
        return [
            'email' => 'required|email',
            'password' => 'required',
        ];
    }

    protected function messages()
    {
        return [
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'password.required' => 'Password wajib diisi',
        ];
    }

    public function mount()
    {
        if (Session::has('auth_token')) {
            $user = Session::get('user_data');
            if ($user && in_array($user['role'], ['admin', 'superadmin'])) {
                return $this->redirect('/dashboard', navigate: true);
            }
            return $this->redirect('/', navigate: true);
        }
    }

    public function load()
    {
        $this->ready = true;
    }

    public function authenticate()
    {
        $this->validate();

        // Rate limiting configuration
        $maxAttempts = 5;
        $lockoutMinutes = 1;
        $attemptsKey = 'login_failed_attempts_' . md5($this->email);
        $lockoutKey = 'login_lockout_until_' . md5($this->email);

        // 1. Cek Lockout
        $lockoutUntil = Session::get($lockoutKey);
        if ($lockoutUntil) {
            $remainingSeconds = Carbon::now()->diffInSeconds($lockoutUntil, false);
            if ($remainingSeconds > 0) {
                $remainingSeconds = ceil($remainingSeconds);
                $this->addError('loginError', "Terlalu banyak upaya gagal. Silakan coba lagi dalam {$remainingSeconds} detik.");
                return;
            } else {
                Session::forget($lockoutKey);
                Session::forget($attemptsKey);
            }
        }

        try {
            // 2. Hit API dengan penanganan SSL (withoutVerifying)
            // Pastikan config/services.php sudah benar memanggil env('API_BASE_URL')
            $apiUrl = config('services.api.base_url') . '/login';

            $response = Http::withoutVerifying() // Solusi masalah SSL di banyak hosting
                ->timeout(10) // Mencegah request gantung terlalu lama
                ->post($apiUrl, [
                    'email' => $this->email,
                    'password' => $this->password,
                ]);

            $result = $response->json();

            // 3. Response Sukses
            if ($response->successful() && isset($result['success']) && $result['success']) {
                Session::forget($attemptsKey);
                Session::forget($lockoutKey);

                // Simpan ke Session (Pastikan folder storage/framework/sessions writeable)
                if (isset($result['data']['token']) && isset($result['data']['user'])) {
                    Session::put('auth_token', $result['data']['token']);
                    Session::put('user_data', $result['data']['user']);

                    $role = $result['data']['user']['role'] ?? 'user';

                    if (in_array($role, ['admin', 'superadmin'])) {
                        return $this->redirect('/dashboard', navigate: true);
                    }
                    return $this->redirect('/', navigate: true);
                }
            }

            // 4. Handle Validasi API (Error 422)
            if ($response->status() === 422) {
                $errors = $result['errors'] ?? [];
                foreach ($errors as $key => $messages) {
                    foreach ((array)$messages as $message) {
                        $this->addError($key, $message);
                    }
                }
                return;
            }

            // 5. Handle Gagal Login & Increment Rate Limit
            $failedAttempts = Session::get($attemptsKey, 0) + 1;
            Session::put($attemptsKey, $failedAttempts);

            if ($failedAttempts >= $maxAttempts) {
                Session::put($lockoutKey, Carbon::now()->addMinutes($lockoutMinutes));
                $this->addError('loginError', "Terlalu banyak upaya gagal. Silakan coba lagi dalam {$lockoutMinutes} menit.");
            } else {
                $remainingAttempts = $maxAttempts - $failedAttempts;
                $message = $result['message'] ?? 'Login gagal, silakan periksa kembali email dan password Anda.';
                $this->addError('loginError', "{$message} (Sisa percobaan: {$remainingAttempts})");
            }
        } catch (\Exception $e) {
            // Log error asli ke file log hosting
            \Log::error('Login Error: ' . $e->getMessage());

            // Tampilkan pesan detail sementara untuk debug di hosting
            $this->addError('loginError', 'Koneksi gagal: ' . $e->getMessage() . ' (Cek koneksi server ke API)');
        }
    }
};
