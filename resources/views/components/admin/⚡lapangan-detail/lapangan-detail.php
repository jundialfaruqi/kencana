<?php

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

new #[Title('Detail Lapangan')] #[Layout('layouts::admin.app')] class extends Component
{
    #[Url(as: 'id')]
    public $id;

    public $ready = false;
    public $error = null;
    public $lapangan = null;
    public $coverUrl = null;
    public $galleryUrls = [];

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
            $url = $base . '/v1/master/lapangan/' . $this->id;
            /** @var \Illuminate\Http\Client\Response $response */
            $response = Http::withToken($token)->accept('application/json')->get($url);
            $result = $response->json();
            if ($response->successful() && ($result['success'] ?? false)) {
                $this->lapangan = $result['data'] ?? null;
                $this->error = null;
                $cover = data_get($this->lapangan, 'image_cover');
                $this->coverUrl = $cover ? $base . '/storage/' . ltrim($cover, '/') : null;
                $images = (array) data_get($this->lapangan, 'images', []);
                $this->galleryUrls = array_map(function ($img) use ($base) {
                    return $base . '/storage/' . ltrim($img, '/');
                }, $images);
                return;
            }
            $this->error = $result['message'] ?? 'Gagal memuat detail lapangan';
        } catch (\Throwable $e) {
            $this->error = 'Terjadi kesalahan saat mengambil detail lapangan';
        }
    }
};
