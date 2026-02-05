<?php

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

new #[Title('Jadwal Khusus')] #[Layout('layouts::admin.app')] class extends Component
{
    use WithPagination;

    public bool $ready = false;
    public array $items = [];
    public ?string $error = null;
    public array $links = [];
    public int $currentPage = 1;
    public int $lastPage = 1;
    public int $perPage = 10;
    public int $total = 0;
    public ?string $path = '/jadwal-khusus';
    #[Url(as: 'page', history: true)]
    public int $page = 1;

    public function load(): void
    {
        $this->ready = false;
        $this->fetchItems();
        $this->ready = true;
    }

    protected function fetchItems(): void
    {
        try {
            $token = Session::get('auth_token');
            $base = rtrim((string) config('services.api.base_url'), '/');
            $url = $base . '/v1/master/jadwalKhusus';
            /** @var \Illuminate\Http\Client\Response $response */
            $response = Http::withToken($token)->accept('application/json')->get($url);
            $result = $response->json();
            if ($response->successful() && ($result['success'] ?? false)) {
                $all = (array) ($result['data'] ?? []);
                $this->total = count($all);
                $this->lastPage = max(1, (int) ceil(($this->total ?: 0) / $this->perPage));
                $this->currentPage = min(max((int) $this->page, 1), $this->lastPage);
                $offset = max(0, ($this->currentPage - 1) * $this->perPage);
                $this->items = array_slice($all, $offset, $this->perPage);
                $this->links = $this->buildLinks();
                $this->error = null;
                return;
            }
            $this->items = [];
            $this->error = (string) ($result['message'] ?? 'Gagal memuat jadwal khusus');
        } catch (\Throwable) {
            $this->items = [];
            $this->error = 'Terjadi kesalahan saat mengambil jadwal khusus';
        }
    }

    protected function buildLinks(): array
    {
        $links = [];
        $curr = $this->currentPage;
        $last = $this->lastPage;
        $path = (string) ($this->path ?: '/jadwal-khusus');
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
        $this->ready = false;
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
        $this->fetchItems();
        $this->ready = true;
    }

    public function deleteJadwal(int $id): void
    {
        $this->ready = false;
        try {
            $token = Session::get('auth_token');
            $base = rtrim((string) config('services.api.base_url'), '/');
            $url = $base . '/v1/master/jadwalKhusus/' . $id;
            /** @var \Illuminate\Http\Client\Response $response */
            $response = Http::withToken($token)->accept('application/json')->delete($url);
            $result = $response->json();
            if ($response->successful() && ($result['success'] ?? false)) {
                $this->error = null;
                $this->dispatch('toast', [
                    'title' => 'Berhasil',
                    'message' => (string) ($result['message'] ?? 'Jadwal khusus berhasil dihapus'),
                    'type' => 'success',
                ]);
                $this->fetchItems();
                $this->ready = true;
                return;
            }
            $this->error = (string) ((is_array($result) ? ($result['message'] ?? null) : null) ?: 'Gagal menghapus jadwal khusus');
            $this->dispatch('toast', [
                'title' => 'Gagal',
                'message' => $this->error,
                'type' => 'error',
            ]);
        } catch (\Throwable) {
            $this->error = 'Terjadi kesalahan saat menghapus jadwal khusus';
            $this->dispatch('toast', [
                'title' => 'Gagal',
                'message' => $this->error,
                'type' => 'error',
            ]);
        }
        $this->fetchItems();
        $this->ready = true;
    }
};
