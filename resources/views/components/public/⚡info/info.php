<?php

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use RalphJSmit\Laravel\SEO\Support\SEOData;

new #[Layout('layouts::public.app')] #[Title('Detail Info')] class extends Component
{
    public string $slug = '';

    public bool $isLoading = false;

    public ?string $error = null;

    public ?array $info = null;

    public array $otherBanners = [];

    public function mount(string $slug): void
    {
        $this->slug = $slug;
        $this->fetch();
    }

    protected function fetch(): void
    {
        try {
            $apiBase = rtrim((string) config('services.api.base_url'), '/');

            $response = Http::withOptions(['verify' => filter_var(config('services.api.verify_ssl', true), FILTER_VALIDATE_BOOLEAN)])
                ->accept('application/json')
                ->get($apiBase.'/v1/slider');

            $json = $response->json() ?? [];
            $ok = $response->successful();

            if ($ok && ($json['success'] ?? false)) {
                $items = (array) ($json['data'] ?? []);
                
                // Pisahkan current info dan other banners
                foreach ($items as $item) {
                    $judul = (string) ($item['judul'] ?? '');
                    if (Str::slug($judul) === $this->slug) {
                        $this->info = $item;
                    } else {
                        $this->otherBanners[] = $item;
                    }
                }

                if ($this->info) {
                    $deskripsi = (string) ($this->info['deskripsi'] ?? '');
                    $coverImage = (string) ($this->info['image'] ?? '');
                    $judul = (string) ($this->info['judul'] ?? '');

                    $seoData = new SEOData(
                        title: $judul,
                        description: Str::limit(strip_tags($deskripsi), 160) ?: $judul,
                        image: $coverImage,
                        url: url()->current(),
                    );

                    view()->share('SEOData', $seoData);

                    return;
                }

                $this->error = 'Informasi tidak ditemukan';
                return;
            }
            $this->error = (string) ($json['message'] ?? 'Gagal memuat informasi');
        } catch (\Throwable) {
            $this->error = 'Terjadi kesalahan saat mengambil informasi';
        }
    }
};
