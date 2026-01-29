<?php

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

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
            if ($user && $user['role'] === 'admin') {
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

        try {
            $response = Http::post(config('services.api.base_url') . '/login', [
                'email' => $this->email,
                'password' => $this->password,
            ]);

            $result = $response->json();

            if ($response->successful() && $result['success']) {
                // Simpan data ke session
                Session::put('auth_token', $result['data']['token']);
                Session::put('user_data', $result['data']['user']);

                // Redirect berdasarkan role
                $role = $result['data']['user']['role'];

                if ($role === 'admin') {
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

            // Handle error dari API (401 atau lainnya)
            $message = $result['message'] ?? 'Login gagal, silakan coba lagi.';
            $this->addError('loginError', $message);
        } catch (\Exception $e) {
            $this->addError('loginError', 'Terjadi kesalahan sistem. Silakan coba beberapa saat lagi.');
        }
    }
};
