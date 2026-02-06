<?php

use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Client\Response;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;

new #[Title('Banner Carousel')] #[Layout('layouts::admin.app')] class extends Component
{
    public bool $readyToLoad = false;
    public ?string $error = null;
    public array $banners = [];
    public array $links = [];
    public int $currentPage = 1;
    public int $lastPage = 1;
    public int $perPage = 10;
    public int $total = 0;
    public ?string $path = '/banner-carousel';
    #[Url(as: 'page', history: true)]
    public int $page = 1;

    public function load()
    {
        if (!Session::has('auth_token')) {
            $this->redirect('/login', navigate: true);
            return;
        }
        $this->fetchBanners();
        $this->readyToLoad = true;
        $this->dispatch('admin-banner-carousel-loaded');
    }
    protected function fetchBanners(): void
    {
        $base = config('services.api.base_url');
        $url = rtrim((string) $base, '/') . '/v1/master/slider';
        try {
            $token = Session::get('auth_token');
            /** @var Response $response */
            $response = Http::withToken($token)
                ->accept('application/json')
                ->get($url);
            $json = $response->json();
            if ($response->successful() && ($json['success'] ?? false)) {
                $all = (array) ($json['data'] ?? []);
                $this->total = count($all);
                $this->lastPage = max(1, (int) ceil(($this->total ?: 0) / $this->perPage));
                $this->currentPage = min(max((int) $this->page, 1), $this->lastPage);
                $offset = max(0, ($this->currentPage - 1) * $this->perPage);
                $slice = array_slice($all, $offset, $this->perPage);
                $this->banners = array_map(function ($it) {
                    return [
                        'id' => $it['id'] ?? null,
                        'kategori' => (string) ($it['kategori'] ?? ''),
                        'judul' => (string) ($it['judul'] ?? ''),
                        'deskripsi' => (string) ($it['deskripsi'] ?? ''),
                        'image' => (string) ($it['image'] ?? ''),
                        'is_active' => (bool) ($it['is_active'] ?? false),
                        'urutan' => $it['urutan'] ?? null,
                        'created_at' => (string) ($it['created_at'] ?? ''),
                        'updated_at' => (string) ($it['updated_at'] ?? ''),
                    ];
                }, $slice);
                $this->links = $this->buildLinks();
                $this->error = null;
                return;
            }
            $this->banners = [];
            $this->links = [];
            $this->error = $json['message'] ?? 'Gagal memuat data banner';
        } catch (\Throwable) {
            $this->banners = [];
            $this->links = [];
            $this->error = 'Terjadi kesalahan saat mengambil data banner';
        }
    }

    protected function buildLinks(): array
    {
        $links = [];
        $curr = $this->currentPage;
        $last = $this->lastPage;
        $path = (string) ($this->path ?: '/banner-carousel');
        $links[] = [
            'label' => 'Prev',
            'url' => $curr > 1 ? ($path . '?page=' . ($curr - 1)) : null,
            'active' => false,
        ];
        for ($p = 1; $p <= $last; $p++) {
            $links[] = [
                'label' => (string) $p,
                'url' => $path . '?page=' . $p,
                'active' => ($p === $curr),
            ];
        }
        $links[] = [
            'label' => 'Next',
            'url' => $curr < $last ? ($path . '?page=' . ($curr + 1)) : null,
            'active' => false,
        ];
        return $links;
    }

    public function goToUrl(?string $url): void
    {
        if (!$url) return;
        $this->readyToLoad = false;
        $page = 1;
        try {
            $parts = parse_url((string) $url);
            $query = [];
            if (isset($parts['query'])) {
                parse_str((string) $parts['query'], $query);
            }
            $page = (int) (($query['page'] ?? 1));
        } catch (\Throwable) {
        }
        $this->page = max(1, (int) $page);
        $this->fetchBanners();
        $this->readyToLoad = true;
    }

    public function deleteBanner(int $id): void
    {
        if ($id <= 0) {
            $this->dispatch('toast', [
                'title' => 'Gagal',
                'message' => 'ID banner tidak valid',
                'type' => 'error',
            ]);
            return;
        }
        try {
            $token = Session::get('auth_token');
            $base = rtrim((string) config('services.api.base_url'), '/');
            $url = $base . '/v1/master/slider/' . $id;
            /** @var Response $response */
            $response = Http::withToken($token)->accept('application/json')->delete($url);
            $result = $response->json();
            if ($response->successful() && ($result['success'] ?? false)) {
                $this->dispatch('toast', [
                    'title' => 'Berhasil',
                    'message' => (string) ($result['message'] ?? 'Banner berhasil dihapus'),
                    'type' => 'success',
                ]);
                $this->fetchBanners();
                return;
            }
            $msg = (string) ((is_array($result) ? ($result['message'] ?? null) : null) ?: 'Gagal menghapus banner');
            $this->dispatch('toast', [
                'title' => 'Gagal',
                'message' => $msg,
                'type' => 'error',
            ]);
        } catch (\Throwable) {
            $this->dispatch('toast', [
                'title' => 'Gagal',
                'message' => 'Terjadi kesalahan saat menghapus banner',
                'type' => 'error',
            ]);
        }
    }
};
