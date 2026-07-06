<?php

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use RalphJSmit\Laravel\SEO\Support\SEOData;

new #[Layout('layouts::public.app')] #[Title('Detail Lapangan')] class extends Component
{
    #[Url(as: 'id')]
    public ?int $id = null;
    public ?string $slug = null;
    public bool $isLoading = false;
    public ?string $error = null;
    public ?array $lapangan = null;
    public ?string $coverUrl = null;
    public array $galleryUrls = [];

    public function mount(?string $slug = null): void
    {
        $this->slug = $slug;
        $this->fetch();
    }

    protected function fetch(): void
    {
        try {
            $apiBase = rtrim((string) config('services.api.base_url'), '/');
            $imageBase = rtrim((string) config('services.api.image_base_url'), '/');
            $id = intval($this->id ?? 0);
            if ($id <= 0 && !empty($this->slug)) {
                /** @var \Illuminate\Http\Client\Response $response */
                $response = Http::withOptions(['verify' => filter_var(config('services.api.verify_ssl', true), FILTER_VALIDATE_BOOLEAN)])->accept('application/json')->get($apiBase . '/v1/lapangan');
                $json = $response->json() ?? [];
                $ok = $response->successful();
                if ($ok && ($json['success'] ?? false)) {
                    $items = (array) ($json['data'] ?? []);
                    foreach ($items as $item) {
                        $name = (string) ($item['nama_lapangan'] ?? '');
                        if ($name && Str::slug($name) === $this->slug) {
                            $id = intval($item['id'] ?? 0);
                            break;
                        }
                    }
                }
            }
            if ($id <= 0) {
                $this->error = 'ID lapangan tidak valid';
                return;
            }
            /** @var \Illuminate\Http\Client\Response $response */
            $response = Http::withOptions(['verify' => filter_var(config('services.api.verify_ssl', true), FILTER_VALIDATE_BOOLEAN)])->accept('application/json')->get($apiBase . '/v1/lapangan/' . $id);
            $json = $response->json() ?? [];
            $ok = $response->successful();
            if ($ok && ($json['success'] ?? false)) {
                $data = (array) ($json['data'] ?? []);
                $this->lapangan = $data;
                $cover = ltrim((string) ($data['image_cover'] ?? ''), '/');
                if (!empty($cover)) {
                    $this->coverUrl = preg_match('/^https?:\/\//', $cover) ? $cover : $imageBase . '/' . $cover;
                } else {
                    $this->coverUrl = null;
                }
                $images = (array) ($data['images'] ?? []);
                $this->galleryUrls = array_map(function ($img) use ($imageBase) {
                    $p = ltrim((string) $img, '/');
                    return preg_match('/^https?:\/\//', $p) ? $p : $imageBase . '/' . $p;
                }, $images);
                $this->error = null;

                $namaLapangan = (string) ($data['nama_lapangan'] ?? 'Detail Lapangan');
                $deskripsi = (string) ($data['deskripsi'] ?? '');
                $coverImage = $this->coverUrl;

                $seoData = new SEOData(
                    title: $namaLapangan,
                    description: Str::limit(strip_tags($deskripsi), 160) ?: "Lihat detail, fasilitas, dan jadwal booking lapangan {$namaLapangan} di Kencana Arena Pekanbaru.",
                    image: $coverImage,
                    url: url()->current(),
                );
                
                // Share to view so the layout can access it dynamically
                view()->share('SEOData', $seoData);

                return;
            }
            $this->error = (string) ($json['message'] ?? 'Gagal memuat detail lapangan');
            $this->lapangan = null;
            $this->coverUrl = null;
            $this->galleryUrls = [];
        } catch (\Throwable) {
            $this->error = 'Terjadi kesalahan saat mengambil detail lapangan';
            $this->lapangan = null;
            $this->coverUrl = null;
            $this->galleryUrls = [];
        }
    }
};
