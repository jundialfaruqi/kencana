<?php

use Illuminate\Http\Client\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Livewire\Component;

new class extends Component
{
    public array $banners = [];

    public function mount()
    {
        $base = config('services.api.base_url');
        $url = rtrim((string) $base, '/').'/v1/slider';
        try {
            $verifySsl = filter_var(config('services.api.verify_ssl', true), FILTER_VALIDATE_BOOLEAN);

            /** @var Response $response */
            $response = Http::accept('application/json')->withOptions(['verify' => $verifySsl])->get($url);
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
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error('Banner carousel error: '.$e->getMessage());
            $this->banners = [];
        }
    }
};
