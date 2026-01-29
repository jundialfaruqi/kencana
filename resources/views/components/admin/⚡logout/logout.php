<?php

use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

new class extends Component
{
    public function logout()
    {
        $user = Session::get('user_data');
        $role = $user['role'] ?? 'masyarakat';

        try {
            $token = Session::get('auth_token');

            if ($token) {
                Http::withToken($token)
                    ->post(config('services.api.base_url') . '/logout');
            }
        } catch (\Exception $e) {
            // Tetap lanjut logout lokal jika API gagal
        }

        Session::forget(['auth_token', 'user_data']);

        if (in_array($role, ['admin', 'superadmin'])) {
            return $this->redirect('/login', navigate: true);
        }

        return $this->redirect('/', navigate: true);
    }
};
