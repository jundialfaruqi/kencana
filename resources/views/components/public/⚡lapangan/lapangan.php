<?php

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Illuminate\Support\Facades\Http;

new #[Title('Daftar Lapangan')] #[Layout('layouts::public.app')] class extends Component
{
    public bool $isLoading = true;
    public ?string $error = null;
    public array $lapangan = [];

    public function loadLapangan(): void
    {
        $this->isLoading = true;
        $this->error = null;
        $this->lapangan = [];
        $this->fetch();
        $this->isLoading = false;
        $this->dispatch('lapangan-loaded');
    }

    protected function fetch(): void
    {
        try {
            $apiBase = rtrim(config('services.api.base_url'), '/');
            $imageBase = rtrim(config('services.api.image_base_url'), '/');
            $url = $apiBase . '/v1/lapangan';
            /** @var \Illuminate\Http\Client\Response $response */
            $response = Http::accept('application/json')->get($url);
            $result = $response->json();
            if ($response->successful() && ($result['success'] ?? false)) {
                $data = (array) ($result['data'] ?? []);
                $this->lapangan = array_map(function ($d) use ($imageBase) {
                    $cover = ltrim((string)($d['image_cover'] ?? ''), '/');
                    $coverUrl = null;
                    if (!empty($cover)) {
                        $coverUrl = preg_match('/^https?:\/\//', $cover) ? $cover : $imageBase . '/' . $cover;
                    }
                    $images = (array)($d['images'] ?? []);
                    $gallery = array_map(function ($img) use ($imageBase) {
                        $p = ltrim((string)$img, '/');
                        return preg_match('/^https?:\/\//', $p) ? $p : $imageBase . '/' . $p;
                    }, $images);
                    return [
                        'id' => $d['id'] ?? null,
                        'nama_lapangan' => (string)($d['nama_lapangan'] ?? ''),
                        'deskripsi' => (string)($d['deskripsi'] ?? ''),
                        'alamat' => (string)($d['alamat'] ?? ''),
                        'gmap' => (string)($d['gmap'] ?? ''),
                        'status' => (string)($d['status'] ?? ''),
                        'status_label' => (string)($d['status_label'] ?? ''),
                        'latitude' => $d['latitude'] ?? null,
                        'longitude' => $d['longitude'] ?? null,
                        'coverUrl' => $coverUrl,
                        'galleryUrls' => $gallery,
                        'admin' => $d['admin'] ?? null,
                    ];
                }, $data);
                $this->error = null;
                return;
            }
            $this->error = $result['message'] ?? 'Gagal memuat data lapangan';
            $this->lapangan = [];
        } catch (\Throwable $e) {
            $this->error = 'Terjadi kesalahan saat mengambil data lapangan';
            $this->lapangan = [];
        }
    }
};
