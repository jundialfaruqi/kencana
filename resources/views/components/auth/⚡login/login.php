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

        // Rate limiting implementation
        $maxAttempts = 5;
        $lockoutMinutes = 1;
        $attemptsKey = 'login_failed_attempts_' . md5($this->email);
        $lockoutKey = 'login_lockout_until_' . md5($this->email);

        // Check if user is locked out
        $lockoutUntil = Session::get($lockoutKey);
        if ($lockoutUntil) {
            // Hitung detik tersisa dengan urutan parameter yang benar: now()->diffInSeconds(future_date, false)
            $remainingSeconds = Carbon::now()->diffInSeconds($lockoutUntil, false);
            if ($remainingSeconds > 0) {
                // Konversi ke detik bulat untuk kemudahan user
                $remainingSeconds = ceil($remainingSeconds);
                $this->addError('loginError', "Terlalu banyak upaya gagal. Silakan coba lagi dalam {$remainingSeconds} detik.");
                return;
            } else {
                // Reset lockout jika waktu sudah habis
                Session::forget($lockoutKey);
                Session::forget($attemptsKey);
            }
        }

        try {
            $response = Http::post(config('services.api.base_url') . '/login', [
                'email' => $this->email,
                'password' => $this->password,
            ]);

            $result = $response->json();

            if ($response->successful() && $result['success']) {
                // Reset failed attempts on success
                Session::forget($attemptsKey);
                Session::forget($lockoutKey);

                // Simpan data ke session
                Session::put('auth_token', $result['data']['token']);
                Session::put('user_data', $result['data']['user']);

                // Redirect berdasarkan role
                $role = $result['data']['user']['role'];

                if (in_array($role, ['admin', 'superadmin'])) {
                    return $this->redirect('/dashboard', navigate: true);
                }

                return $this->redirect('/', navigate: true);
            }

            if ($response->status() === 422) {
                $errors = $result['errors'] ?? [];
                foreach ($errors as $key => $messages) {
                    foreach ($messages as $message) {
                        $this->addError($key, $message);
                    }
                }
                return;
            }

            // Check if user is already locked out before incrementing attempts
            $existingLockout = Session::get($lockoutKey);
            $isLockedOut = $existingLockout && Carbon::now()->lessThan($existingLockout);
            if (!$isLockedOut) {
                // Handle failed login (increment attempts) only if not locked out
                $failedAttempts = Session::get($attemptsKey, 0) + 1;
                Session::put($attemptsKey, $failedAttempts);

                // Lockout if max attempts reached
                if ($failedAttempts >= $maxAttempts) {
                    Session::put($lockoutKey, Carbon::now()->addMinutes($lockoutMinutes));
                    $this->addError('loginError', "Terlalu banyak upaya gagal. Silakan coba lagi dalam {$lockoutMinutes} menit.");
                    return;
                }

                // Show remaining attempts
                $remainingAttempts = $maxAttempts - $failedAttempts;
                $message = $result['message'] ?? 'Login gagal, silakan coba lagi.';
                $this->addError('loginError', "{$message} (Upaya tersisa: {$remainingAttempts})");
            }
            // If already locked out, do nothing - the error was already shown earlier
        } catch (\Exception) {
            $this->addError('loginError', 'Terjadi kesalahan sistem. Silakan coba beberapa saat lagi.');
        }
    }
};
