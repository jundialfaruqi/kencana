<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;

new #[Layout('layouts::auth.app')] #[Title('Login Admin')] class extends Component
{
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

    public function load()
    {
        $this->ready = true;
    }

    public function authenticate()
    {
        $this->validate();

        // Rate limiting implementation (matching the real login page)
        $maxAttempts = 5;
        $lockoutMinutes = 1;
        $attemptsKey = 'login_failed_attempts_'.md5($this->email);
        $lockoutKey = 'login_lockout_until_'.md5($this->email);

        // Check if user is locked out
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

        usleep(rand(800000, 1500000));

        // Handle failed login attempts
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
        $this->addError('loginError', "Email atau password salah. (Upaya tersisa: {$remainingAttempts})");
    }
};
