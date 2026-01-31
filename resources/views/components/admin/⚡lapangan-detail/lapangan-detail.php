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
            $apiBase = rtrim(config('services.api.base_url'), '/');
            $imageBase = rtrim(config('services.api.image_base_url'), '/');
            $url = $apiBase . '/v1/master/lapangan/' . $this->id;
            /** @var \Illuminate\Http\Client\Response $response */
            $response = Http::withToken($token)->accept('application/json')->get($url);
            $result = $response->json();
            if ($response->successful() && ($result['success'] ?? false)) {
                $this->lapangan = $result['data'] ?? null;
                $this->error = null;
                $cover = data_get($this->lapangan, 'image_cover');
                if (!empty($cover)) {
                    $p = ltrim((string)$cover, '/');
                    if (preg_match('/^https?:\/\//', $p)) {
                        $this->coverUrl = $p;
                    } else {
                        $this->coverUrl = $imageBase . '/' . $p;
                    }
                } else {
                    $this->coverUrl = null;
                }
                $images = (array) data_get($this->lapangan, 'images', []);
                $this->galleryUrls = array_map(function ($img) use ($imageBase) {
                    $p = ltrim((string)$img, '/');
                    if (preg_match('/^https?:\/\//', $p)) {
                        return $p;
                    }
                    return $imageBase . '/' . $p;
                }, $images);
                return;
            }
            $this->error = $result['message'] ?? 'Gagal memuat detail lapangan';
        } catch (\Throwable $e) {
            $this->error = 'Terjadi kesalahan saat mengambil detail lapangan';
        }
    }
};
