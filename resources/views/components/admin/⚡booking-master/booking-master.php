<?php

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

new class extends Component
{
    public bool $ready = false;
    public array $bookings = [];
    public array $links = [];
    public int $currentPage = 1;
    public int $lastPage = 1;
    public int $perPage = 10;
    public int $total = 0;
    public ?string $nextPageUrl = null;
    public ?string $prevPageUrl = null;
    public ?string $path = null;
    public ?string $error = null;
    public ?string $status = null;
    public ?string $search = null;
    public ?string $from = null;
    public ?string $to = null;
    #[Url(as: 'page', history: true)]
    public int $page = 1;

    #[Title('Booking Master')]
    #[Layout('layouts::admin.app')]

    public function load(): void
    {
        $this->ready = false;
        $this->fetchBookings();
        $this->ready = true;
    }

    public function applyFilter(): void
    {
        $this->ready = false;
        $this->fetchBookings();
        $this->ready = true;
    }

    public function updatedStatus($value): void
    {
        $this->status = (string) ($value ?? '');
        $this->ready = false;
        $this->fetchBookings();
        $this->ready = true;
    }

    public function updatedSearch($value): void
    {
        $this->search = (string) ($value ?? '');
        $this->ready = false;
        $this->fetchBookings();
        $this->ready = true;
    }

    public function updatedFrom($value): void
    {
        $this->from = (string) ($value ?? '');
        $this->ready = false;
        $this->fetchBookings();
        $this->ready = true;
    }

    public function updatedTo($value): void
    {
        $this->to = (string) ($value ?? '');
        $this->ready = false;
        $this->fetchBookings();
        $this->ready = true;
    }

    public function goToUrl(?string $url): void
    {
        if (!$url) return;
        $this->ready = false;
        $this->fetchByUrl((string) $url);
        $this->ready = true;
    }

    protected function fetchBookings(): void
    {
        try {
            $token = Session::get('auth_token');
            $base = rtrim((string) config('services.api.base_url'), '/');
            $url = $base . '/v1/master/bookings';
            $params = array_filter([
                'status' => $this->status ? (string) $this->status : null,
                'search' => $this->search ? (string) $this->search : null,
                'from' => $this->from ? (string) $this->from : null,
                'to' => $this->to ? (string) $this->to : null,
                'page' => $this->page ? intval($this->page) : null,
            ], fn($v) => $v !== null && $v !== '');
            if (!empty($params)) {
                $url .= '?' . http_build_query($params);
            }
            /** @var \Illuminate\Http\Client\Response $response */
            $response = Http::withToken($token)->accept('application/json')->get($url);
            $result = $response->json();
            if ($response->successful() && ($result['success'] ?? false)) {
                $data = (array) ($result['data'] ?? []);
                $this->bookings = (array) ($data['data'] ?? []);
                $this->links = (array) ($data['links'] ?? []);
                $this->currentPage = intval($data['current_page'] ?? 1);
                $this->page = $this->currentPage;
                $this->lastPage = intval($data['last_page'] ?? 1);
                $this->perPage = intval($data['per_page'] ?? 10);
                $this->total = intval($data['total'] ?? 0);
                $this->nextPageUrl = (string) ($data['next_page_url'] ?? '');
                $this->prevPageUrl = (string) ($data['prev_page_url'] ?? '');
                $this->path = (string) ($data['path'] ?? '');
                $this->error = null;
                return;
            }
            $this->bookings = [];
            $this->links = [];
            $this->error = (string) ($result['message'] ?? 'Gagal memuat data booking');
        } catch (\Throwable) {
            $this->bookings = [];
            $this->links = [];
            $this->error = 'Terjadi kesalahan saat mengambil data booking';
        }
    }

    public function goToPage(?int $page): void
    {
        if (!$page) return;
        $this->page = intval($page);
        $this->ready = false;
        $this->fetchBookings();
        $this->ready = true;
    }

    protected function fetchByUrl(string $url): void
    {
        try {
            $token = Session::get('auth_token');
            /** @var \Illuminate\Http\Client\Response $response */
            $response = Http::withToken($token)->accept('application/json')->get($url);
            $result = $response->json();
            if ($response->successful() && ($result['success'] ?? false)) {
                $data = (array) ($result['data'] ?? []);
                $this->bookings = (array) ($data['data'] ?? []);
                $this->links = (array) ($data['links'] ?? []);
                $this->currentPage = intval($data['current_page'] ?? 1);
                $this->lastPage = intval($data['last_page'] ?? 1);
                $this->perPage = intval($data['per_page'] ?? 10);
                $this->total = intval($data['total'] ?? 0);
                $this->nextPageUrl = (string) ($data['next_page_url'] ?? '');
                $this->prevPageUrl = (string) ($data['prev_page_url'] ?? '');
                $this->path = (string) ($data['path'] ?? '');
                $this->error = null;
                return;
            }
            $this->error = (string) ($result['message'] ?? 'Gagal memuat data booking');
        } catch (\Throwable) {
            $this->error = 'Terjadi kesalahan saat mengambil data booking';
        }
    }
};
