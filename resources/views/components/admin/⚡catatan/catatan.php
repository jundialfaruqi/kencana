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

    public bool $ready = false;
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

    public function load(): void
    {
        $this->ready = false;
        $this->fetchCatatan();
        $this->ready = true;
    }

    protected function fetchCatatan(): void
    {
        try {
            $token = Session::get('auth_token');
            $base = rtrim((string) config('services.api.base_url'), '/');
            $url = $base . '/v1/master/catatan';
            /** @var \Illuminate\Http\Client\Response $response */
            $response = Http::withToken($token)->accept('application/json')->get($url);
            $result = json_decode((string) $response->body(), true);
            if (is_array($result) && ($result['success'] ?? false)) {
                $all = (array) ($result['data'] ?? []);
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
        $this->fetchCatatan();
        $this->ready = true;
    }
};
