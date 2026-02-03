<?php

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

new #[Title('Jadwal Operasional')] #[Layout('layouts::admin.app')] class extends Component
{
    public bool $ready = false;
    public array $jadwal = [];
    public ?string $error = null;

    public function load(): void
    {
        $this->ready = false;
        $this->fetchJadwal();
        $this->dispatch('jadwal-loaded');
        $this->ready = true;
    }

    private function fetchJadwal(): void
    {
        $base = config('services.api.base_url');
        $url = rtrim((string) $base, '/') . '/v1/master/jadwal';
        try {
            $token = Session::get('auth_token');
            /** @var \Illuminate\Http\Client\Response $response */
            $response = Http::withToken($token)
                ->accept('application/json')
                ->get($url);
            $json = $response->json();
            if ($response->successful() && ($json['success'] ?? false)) {
                $this->jadwal = (array) ($json['data'] ?? []);
                $this->error = null;
                return;
            }
            $this->jadwal = [];
            $this->error = (string) ($json['message'] ?? 'Gagal memuat jadwal operasional');
        } catch (\Throwable) {
            $this->jadwal = [];
            $this->error = 'Terjadi kesalahan saat mengambil jadwal operasional';
        }
    }

    public function deleteJadwal(int $id): void
    {
        $base = config('services.api.base_url');
        $url = rtrim((string) $base, '/') . '/v1/master/jadwal/' . $id;
        try {
            $token = Session::get('auth_token');
            /** @var \Illuminate\Http\Client\Response $response */
            $response = Http::withToken($token)
                ->accept('application/json')
                ->delete($url);
            $json = $response->json();
            if ($response->successful() && ($json['success'] ?? false)) {
                $this->fetchJadwal();
                $this->dispatch('toast', [
                    'title' => 'Berhasil',
                    'message' => (string) ($json['message'] ?? 'Jadwal operasional berhasil dihapus'),
                    'type' => 'success',
                ]);
                return;
            }
            $this->error = (string) ($json['message'] ?? 'Gagal menghapus jadwal operasional');
            $this->dispatch('toast', [
                'title' => 'Gagal',
                'message' => $this->error,
                'type' => 'error',
            ]);
        } catch (\Throwable) {
            $this->error = 'Terjadi kesalahan saat menghapus jadwal operasional';
            $this->dispatch('toast', [
                'title' => 'Gagal',
                'message' => $this->error,
                'type' => 'error',
            ]);
        }
    }
};
