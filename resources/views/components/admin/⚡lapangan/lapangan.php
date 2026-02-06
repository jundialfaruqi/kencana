<?php

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

new #[Title('Manajamen Lapangan')] #[Layout('layouts::admin.app')] class extends Component
{
    public $ready = false;
    public $error = null;
    public $lapangan = [];
    public $deletingId = null;
    #[Url]
    public int $page = 1;
    public int $perPage = 9;
    public int $total = 0;
    public int $lastPage = 1;
    public int $curr = 1;
    public array $slice = [];
    public array $links = [];

    public function load()
    {
        $this->fetch();
        $this->ready = true;
    }

    protected function fetch(): void
    {
        try {
            $token = Session::get('auth_token');
            $base = rtrim(config('services.api.base_url'), '/');
            $url = $base . '/v1/master/lapangan';
            /** @var \Illuminate\Http\Client\Response $response */
            $response = Http::withToken($token)->accept('application/json')->get($url);
            $result = $response->json();
            if ($response->successful() && ($result['success'] ?? false)) {
                $this->lapangan = $result['data'] ?? [];
                $this->error = null;
                $this->paginate();
                return;
            }
            $this->error = $result['message'] ?? 'Gagal memuat data lapangan';
            $this->lapangan = [];
        } catch (\Throwable $e) {
            $this->error = 'Terjadi kesalahan saat mengambil data lapangan';
            $this->lapangan = [];
        }
        $this->paginate();
    }

    public function confirmDelete(int $id): void
    {
        $this->deletingId = $id;
    }

    public function deleteLapangan(): void
    {
        if (!$this->deletingId) {
            return;
        }
        try {
            $token = Session::get('auth_token');
            $base = rtrim(config('services.api.base_url'), '/');
            $url = $base . '/v1/master/lapangan/' . intval($this->deletingId);
            /** @var \Illuminate\Http\Client\Response $response */
            $response = Http::withToken($token)->accept('application/json')->delete($url);
            $result = $response->json();
            if ($response->successful() && ($result['success'] ?? false)) {
                $this->deletingId = null;
                $this->fetch();
                $this->dispatch('toast', [
                    'title' => 'Berhasil',
                    'message' => $result['message'] ?? 'Lapangan berhasil dihapus',
                    'type' => 'success',
                ]);
                return;
            }
            $this->error = $result['message'] ?? 'Gagal menghapus lapangan';
        } catch (\Throwable $e) {
            $this->error = 'Terjadi kesalahan saat menghapus lapangan';
        }
    }

    protected function paginate(): void
    {
        $this->total = is_array($this->lapangan) ? count($this->lapangan) : 0;
        $this->lastPage = max(1, (int) ceil(($this->total ?: 0) / $this->perPage));
        $this->curr = min(max((int) $this->page, 1), $this->lastPage);
        $offset = max(0, ($this->curr - 1) * $this->perPage);
        $this->slice = array_slice($this->lapangan ?? [], $offset, $this->perPage);
        $path = '/manajemen-lapangan';
        $links = [];
        $links[] = ['label' => 'Prev', 'url' => $this->curr > 1 ? ($path . '?page=' . ($this->curr - 1)) : null, 'active' => false];
        for ($p = 1; $p <= $this->lastPage; $p++) {
            $links[] = ['label' => (string) $p, 'url' => $path . '?page=' . $p, 'active' => ($p === $this->curr)];
        }
        $links[] = ['label' => 'Next', 'url' => $this->curr < $this->lastPage ? ($path . '?page=' . ($this->curr + 1)) : null, 'active' => false];
        $this->links = $links;
    }

    public function updatedPage($value): void
    {
        $this->paginate();
    }
};
