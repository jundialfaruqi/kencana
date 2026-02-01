<?php

use Livewire\Component;

new class extends Component {
    public $ready = false;
    public array $lapangan = [];
    public string $imageBase = '';

    public function load()
    {
        $this->imageBase = rtrim((string) config('services.api.image_base_url'), '/');

        $base = config('services.api.base_url');
        if (!$base) {
            $this->lapangan = [];
            $this->ready = true;
            $this->dispatch('hero-carousel-loaded');
            return;
        }

        $url = rtrim($base, '/') . '/v1/lapangan';

        try {
            $context = stream_context_create([
                'http' => [
                    'method' => 'GET',
                    'header' => "Accept: application/json\r\n",
                    'ignore_errors' => true,
                    'timeout' => 10,
                ],
            ]);
            $raw = @file_get_contents($url, false, $context);
            $json = is_string($raw) ? json_decode($raw, true) : [];

            if (($json['success'] ?? false)) {
                $data = $json['data'] ?? [];
                $this->lapangan = array_map(function ($item) {
                    $cover = $item['image_cover'] ?? null;
                    $coverUrl = $cover ? ($this->imageBase . '/' . ltrim($cover, '/')) : asset('assets/images/landing-pages/mini-soccer.webp');
                    return [
                        'id' => $item['id'] ?? null,
                        'nama_lapangan' => $item['nama_lapangan'] ?? '',
                        'deskripsi' => $item['deskripsi'] ?? '',
                        'status' => $item['status'] ?? '',
                        'status_label' => $item['status_label'] ?? '',
                        'cover_url' => $coverUrl,
                    ];
                }, $data);
            } else {
                $this->lapangan = [];
            }
        } catch (\Throwable $e) {
            $this->lapangan = [];
        }

        $this->ready = true;
        $this->dispatch('hero-carousel-loaded');
    }
};
