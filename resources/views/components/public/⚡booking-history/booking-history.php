<?php

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

new #[Title('Booking History')] #[Layout('layouts::public.app')] class extends Component
{
    public bool $ready = false;
    public array $items = [];
    public array $links = [];
    public ?string $error = null;
    public ?string $status = null;
    public ?string $from = null;
    public ?string $to = null;
    public int $currentPage = 1;
    public int $lastPage = 1;
    public int $perPage = 0;
    public int $total = 0;

    public function load()
    {
        if (!Session::has('auth_token')) {
            $this->redirect('/login', navigate: true);
            return;
        }
        $this->fetchHistory(1);
        $this->ready = true;
    }

    protected function fetchHistory(int $page = 1): void
    {
        $base = config('services.api.base_url');
        $url = rtrim((string) $base, '/') . '/v1/lapangan/historyBooking';
        try {
            $token = Session::get('auth_token');
            /** @var \Illuminate\Http\Client\Response $response */
            $response = Http::withToken($token)
                ->asForm()
                ->accept('application/json')
                ->post($url . '?page=' . intval($page), [
                    'status' => (string) ($this->status ?? ''),
                    'from' => (string) ($this->from ?? ''),
                    'to' => (string) ($this->to ?? ''),
                ]);
            $json = $response->json();
            if ($response->successful() && ($json['success'] ?? false)) {
                $data = (array) ($json['data'] ?? []);
                $this->items = (array) ($data['data'] ?? []);
                $this->links = (array) ($data['links'] ?? []);
                $this->currentPage = intval($data['current_page'] ?? 1);
                $this->lastPage = intval($data['last_page'] ?? 1);
                $this->perPage = intval($data['per_page'] ?? 0);
                $this->total = intval($data['total'] ?? 0);
                $this->error = null;
            } else {
                $this->items = [];
                $this->links = [];
                $this->currentPage = 1;
                $this->lastPage = 1;
                $this->perPage = 0;
                $this->total = 0;
                $this->error = $json['message'] ?? 'Gagal memuat history';
            }
        } catch (\Throwable) {
            $this->items = [];
            $this->links = [];
            $this->currentPage = 1;
            $this->lastPage = 1;
            $this->perPage = 0;
            $this->total = 0;
            $this->error = 'Terjadi kesalahan saat mengambil history';
        }
    }

    public function goToPage(?int $page): void
    {
        if (!$page) return;
        $this->ready = false;
        $this->fetchHistory(intval($page));
        $this->ready = true;
    }

    public function applyFilter(): void
    {
        $this->ready = false;
        $this->fetchHistory(1);
        $this->ready = true;
    }
};
