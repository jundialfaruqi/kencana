<?php

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

new #[Title('Catatan')] #[Layout('layouts::admin.app')] class extends Component
{
    use WithPagination;

    public array $catatans = [];
    public ?string $error = null;
    public array $links = [];
    public int $currentPage = 1;
    public int $lastPage = 1;
    public int $perPage = 10;
    public int $total = 0;
    public ?string $path = '/catatan';
    #[Url(as: 'page', history: true)]
    public int $page = 1;

    public array $arenas = [];
    #[Url(as: 'lapangan', history: true)]
    public string $selectedLapanganId = 'all';

    public function mount(): void
    {
        $this->fetchArenas();
        $this->fetchCatatan();
    }

    public function updatedSelectedLapanganId(): void
    {
        $this->page = 1;
        $this->fetchCatatan();
    }

    private function fetchArenas(): void
    {
        try {
            $token = Session::get('auth_token');
            $base = rtrim((string) config('services.api.base_url'), '/');
            $url = $base . '/v1/master/lapangan';
            /** @var \Illuminate\Http\Client\Response $response */
            $response = Http::withOptions(['verify' => filter_var(config('services.api.verify_ssl', true), FILTER_VALIDATE_BOOLEAN)])->withToken($token)
                ->accept('application/json')
                ->get($url);
            $result = $response->json();
            if ($response->successful() && ($result['success'] ?? false)) {
                $this->arenas = (array) ($result['data'] ?? []);
            }
        } catch (\Throwable) {
            //
        }
    }

    protected function fetchCatatan(): void
    {
        try {
            $token = Session::get('auth_token');
            $base = rtrim((string) config('services.api.base_url'), '/');
            $url = $base . '/v1/master/catatan';
            /** @var \Illuminate\Http\Client\Response $response */
            $response = Http::withOptions(['verify' => filter_var(config('services.api.verify_ssl', true), FILTER_VALIDATE_BOOLEAN)])->withToken($token)->accept('application/json')->get($url);
            $result = json_decode((string) $response->body(), true);
            if (is_array($result) && ($result['success'] ?? false)) {
                $all = (array) ($result['data'] ?? []);
                if ($this->selectedLapanganId && $this->selectedLapanganId !== 'all') {
                    $all = array_filter($all, function($item) {
                        return (string) (data_get($item, 'lapangan_id') ?? data_get($item, 'lapangan.id')) === (string) $this->selectedLapanganId;
                    });
                }

                usort($all, function($a, $b) {
                    $arenaA = (string) (data_get($a, 'nama_lapangan') ?? '');
                    $arenaB = (string) (data_get($b, 'nama_lapangan') ?? '');
                    if ($arenaA !== $arenaB) {
                        return strcmp($arenaA, $arenaB);
                    }
                    $katA = (string) (data_get($a, 'kategori_catatan') ?? '');
                    $katB = (string) (data_get($b, 'kategori_catatan') ?? '');
                    return strcmp($katA, $katB);
                });

                $this->total = count($all);
                $this->lastPage = max(1, (int) ceil(($this->total ?: 0) / $this->perPage));
                $this->currentPage = min(max((int) $this->page, 1), $this->lastPage);
                $offset = max(0, ($this->currentPage - 1) * $this->perPage);
                $this->catatans = array_slice($all, $offset, $this->perPage);
                $this->links = $this->buildLinks();
                $this->error = null;
                return;
            }
            $this->catatans = [];
            $this->error = (string) ((is_array($result) ? ($result['message'] ?? null) : null) ?: 'Gagal memuat data catatan');
        } catch (\Throwable) {
            $this->catatans = [];
            $this->error = 'Terjadi kesalahan saat mengambil data';
        }
    }

    protected function buildLinks(): array
    {
        $links = [];
        $curr = $this->currentPage;
        $last = $this->lastPage;
        $path = (string) ($this->path ?: '/catatan');
        // Prev
        $links[] = [
            'label' => 'Prev',
            'url' => $curr > 1 ? ($path . '?page=' . ($curr - 1)) : null,
            'active' => false,
        ];
        // Pages
        for ($p = 1; $p <= $last; $p++) {
            $links[] = [
                'label' => (string) $p,
                'url' => $path . '?page=' . $p,
                'active' => ($p === $curr),
            ];
        }
        // Next
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
        $this->fetchCatatan();
     }

    public function deleteCatatan(?int $id): void
    {
        if (!$id) {
            $this->error = 'ID catatan tidak valid';
            $this->dispatch('toast', [
                'title' => 'Gagal',
                'message' => $this->error,
                'type' => 'error',
            ]);
            return;
        }
        try {
            $token = Session::get('auth_token');
            $base = rtrim((string) config('services.api.base_url'), '/');
            $url = $base . '/v1/master/catatan/' . urlencode((string) $id);
            /** @var \Illuminate\Http\Client\Response $response */
            $response = Http::withOptions(['verify' => filter_var(config('services.api.verify_ssl', true), FILTER_VALIDATE_BOOLEAN)])->withToken($token)->accept('application/json')->delete($url);
            $result = $response->json();
            if ($response->successful() && ($result['success'] ?? false)) {
                $this->error = null;
                $this->dispatch('toast', [
                    'title' => 'Berhasil',
                    'message' => (string) ($result['message'] ?? 'Catatan berhasil dihapus'),
                    'type' => 'success',
                ]);
                $this->fetchCatatan();
                return;
            }
            $this->error = (string) ($result['message'] ?? 'Gagal menghapus catatan');
            $this->dispatch('toast', [
                'title' => 'Gagal',
                'message' => $this->error,
                'type' => 'error',
            ]);
        } catch (\Throwable) {
            $this->error = 'Terjadi kesalahan saat menghapus catatan';
            $this->dispatch('toast', [
                'title' => 'Gagal',
                'message' => $this->error,
                'type' => 'error',
            ]);
        }
    }
};
