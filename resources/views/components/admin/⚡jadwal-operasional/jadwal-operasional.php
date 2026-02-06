<?php

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Url;

new #[Title('Jadwal Operasional')] #[Layout('layouts::admin.app')] class extends Component
{
    public bool $ready = false;
    public array $jadwal = [];
    public ?string $error = null;
    public array $links = [];
    public int $currentPage = 1;
    public int $lastPage = 1;
    public int $perPage = 10;
    public int $total = 0;
    public ?string $path = '/manajemen-jadwal-operasional';
    #[Url(as: 'page', history: true)]
    public int $page = 1;

    public function load(): void
    {
        $this->ready = false;
        $this->fetchJadwal();
        $this->dispatch('jadwal-loaded');
        $this->ready = true;
    }

    private function fetchJadwal(): void
    {
        $base = config('services.api.base_url');
        $url = rtrim((string) $base, '/') . '/v1/master/jadwal';
        try {
            $token = Session::get('auth_token');
            /** @var \Illuminate\Http\Client\Response $response */
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
                $this->jadwal = array_slice($all, $offset, $this->perPage);
                $this->links = $this->buildLinks();
                $this->error = null;
                return;
            }
            $this->jadwal = [];
            $this->links = [];
            $this->currentPage = 1;
            $this->lastPage = 1;
            $this->total = 0;
            $this->error = (string) ($json['message'] ?? 'Gagal memuat jadwal operasional');
        } catch (\Throwable) {
            $this->jadwal = [];
            $this->links = [];
            $this->currentPage = 1;
            $this->lastPage = 1;
            $this->total = 0;
            $this->error = 'Terjadi kesalahan saat mengambil jadwal operasional';
        }
    }

    private function buildLinks(): array
    {
        $links = [];
        $curr = $this->currentPage;
        $last = $this->lastPage;
        $path = (string) ($this->path ?: '/manajemen-jadwal-operasional');
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
        $this->fetchJadwal();
        $this->ready = true;
    }

    public function deleteJadwal(int $id): void
    {
        $base = config('services.api.base_url');
        $url = rtrim((string) $base, '/') . '/v1/master/jadwal/' . $id;
        try {
            $token = Session::get('auth_token');
            /** @var \Illuminate\Http\Client\Response $response */
            $response = Http::withToken($token)
                ->accept('application/json')
                ->delete($url);
            $json = $response->json();
            if ($response->successful() && ($json['success'] ?? false)) {
                $this->fetchJadwal();
                $this->dispatch('toast', [
                    'title' => 'Berhasil',
                    'message' => (string) ($json['message'] ?? 'Jadwal operasional berhasil dihapus'),
                    'type' => 'success',
                ]);
                return;
            }
            $this->error = (string) ($json['message'] ?? 'Gagal menghapus jadwal operasional');
            $this->dispatch('toast', [
                'title' => 'Gagal',
                'message' => $this->error,
                'type' => 'error',
            ]);
        } catch (\Throwable) {
            $this->error = 'Terjadi kesalahan saat menghapus jadwal operasional';
            $this->dispatch('toast', [
                'title' => 'Gagal',
                'message' => $this->error,
                'type' => 'error',
            ]);
        }
    }
};
