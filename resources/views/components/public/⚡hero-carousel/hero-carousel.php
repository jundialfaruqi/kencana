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

        $verifySsl = filter_var(config('services.api.verify_ssl', true), FILTER_VALIDATE_BOOLEAN);

        try {
            $context = stream_context_create([
                'http' => [
                    'method' => 'GET',
                    'header' => "Accept: application/json\r\n",
                    'ignore_errors' => true,
                    'timeout' => 10,
                ],
                'ssl' => [
                    'verify_peer' => $verifySsl,
                    'verify_peer_name' => $verifySsl,
                ]
            ]);
            $lastError = error_get_last();
            $raw = @file_get_contents($url, false, $context);
            $newError = error_get_last();
            
            $feError = ($raw === false || $lastError !== $newError) ? $newError : null;
            $json = is_string($raw) ? json_decode($raw, true) : null;
            
            $statusCode = 0;
            if (isset($http_response_header) && is_array($http_response_header) && count($http_response_header) > 0) {
                preg_match('{HTTP\/\S*\s(\d{3})}', $http_response_header[0], $match);
                $statusCode = $match[1] ?? 0;
            }
            
            $apiError = null;
            if ($statusCode >= 400 || (is_array($json) && !($json['success'] ?? false))) {
                $apiError = [
                    'status_code' => $statusCode,
                    'headers' => $http_response_header ?? [],
                    'raw_response' => $raw,
                ];
            }

            // dd() dihapus agar proses bisa lanjut me-render UI

            if (is_array($json) && ($json['success'] ?? false)) {
                $data = $json['data'] ?? [];
                $this->lapangan = array_map(function ($item) {
                    $cover = $item['image_cover'] ?? null;
                    $coverUrl = $cover ? ($this->imageBase . '/' . ltrim($cover, '/')) : asset('assets/images/landing-pages/mini-soccer.webp');
                    return [
                        'id' => $item['id'] ?? null,
                        'nama_lapangan' => $item['nama_lapangan'] ?? '',
                        'status' => $item['status'] ?? '',
                        'status_label' => $item['status_label'] ?? '',
                        'alamat' => $item['alamat'] ?? '',
                        'cover_url' => $coverUrl,
                    ];
                }, $data);
            } else {
                $this->lapangan = [];
            }
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error('Hero carousel error: ' . $e->getMessage());
            $this->lapangan = [];
        }

        $this->ready = true;
        $this->dispatch('hero-carousel-loaded');
    }
};
