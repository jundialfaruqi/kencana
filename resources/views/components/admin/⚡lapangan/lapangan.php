<?php

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

new #[Title('Manajamen Lapangan')] #[Layout('layouts::admin.app')] class extends Component
{
    public $ready = false;
    public $error = null;
    public $lapangan = [];

    public function load()
    {
        $this->fetch();
        $this->ready = true;
    }

    protected function fetch(): void
    {
        try {
            $token = Session::get('auth_token');
            $base = rtrim(config('services.api.base_url'), '/');
            $url = $base . '/v1/master/lapangan';
            /** @var \Illuminate\Http\Client\Response $response */
            $response = Http::withToken($token)->accept('application/json')->get($url);
            $result = $response->json();
            if ($response->successful() && ($result['success'] ?? false)) {
                $this->lapangan = $result['data'] ?? [];
                $this->error = null;
                return;
            }
            $this->error = $result['message'] ?? 'Gagal memuat data lapangan';
        } catch (\Throwable $e) {
            $this->error = 'Terjadi kesalahan saat mengambil data lapangan';
        }
    }
};
