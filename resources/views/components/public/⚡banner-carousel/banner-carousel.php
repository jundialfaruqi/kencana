<?php

use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Arr;
use Illuminate\Http\Client\Response;

new class extends Component
{
    public bool $readyToLoad = false;
    public array $banners = [];

    public function load()
    {
        $base = config('services.api.base_url');
        $url = rtrim((string) $base, '/') . '/v1/slider';
        try {
            /** @var Response $response */
            $response = Http::accept('application/json')->get($url);
            $json = $response->json();
            if ($response->successful() && ($json['success'] ?? false)) {
                $data = (array) ($json['data'] ?? []);
                $this->banners = array_map(function ($item) {
                    return [
                        'kategori' => (string) Arr::get($item, 'kategori', ''),
                        'judul' => (string) Arr::get($item, 'judul', ''),
                        'deskripsi' => (string) Arr::get($item, 'deskripsi', ''),
                        'image' => (string) Arr::get($item, 'image', ''),
                    ];
                }, $data);
            } else {
                $this->banners = [];
            }
        } catch (\Throwable) {
            $this->banners = [];
        }
        $this->readyToLoad = true;
        $this->dispatch('banner-carousel-loaded');
    }
};
