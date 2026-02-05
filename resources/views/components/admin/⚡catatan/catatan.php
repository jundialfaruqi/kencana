<?php

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

new #[Title('Catatan')] #[Layout('layouts::admin.app')] class extends Component
{
    public bool $ready = false;
    public array $catatans = [];
    public ?string $error = null;
    public ?string $search = null;
    public ?string $kategori = null;

    public function load(): void
    {
        $this->ready = false;
        $this->fetchCatatan();
        $this->ready = true;
    }

    protected function fetchCatatan(): void
    {
        try {
            $token = Session::get('auth_token');
            $base = rtrim((string) config('services.api.base_url'), '/');
            $url = $base . '/v1/master/catatan';
            /** @var \Illuminate\Http\Client\Response $response */
            $response = Http::withToken($token)->accept('application/json')->get($url);
            $result = json_decode((string) $response->body(), true);
            if (is_array($result) && ($result['success'] ?? false)) {
                $this->catatans = (array) ($result['data'] ?? []);
                $this->error = null;
                return;
            }
            $this->catatans = [];
            $this->error = (string) ((is_array($result) ? ($result['message'] ?? null) : null) ?: 'Gagal memuat data catatan');
        } catch (\Throwable) {
            $this->catatans = [];
            $this->error = 'Terjadi kesalahan saat mengambil data';
        }
    }
};
