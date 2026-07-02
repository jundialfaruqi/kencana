<?php

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

new #[Title('Booking History')] #[Layout('layouts::public.app')] class extends Component
{
    public array $items = [];

    public ?string $error = null;
    public ?string $status = 'dipesan';

    public int $currentPage = 1;
    public int $lastPage = 1;
    public int $perPage = 0;


    public function mount()
    {
        if (!Session::has('auth_token')) {
            $this->redirect('/login', navigate: true);
            return;
        }
        $this->fetchHistory(1);
    }

    protected function fetchHistory(int $page = 1): void
    {
        $base = config('services.api.base_url');
        $url = rtrim((string) $base, '/') . '/v1/lapangan/historyBooking';
        try {
            $token = Session::get('auth_token');
            /** @var \Illuminate\Http\Client\Response $response */
            $response = Http::withOptions(['verify' => filter_var(config('services.api.verify_ssl', true), FILTER_VALIDATE_BOOLEAN)])->withToken($token)
                ->asForm()
                ->accept('application/json')
                ->post($url . '?page=' . intval($page), [
                    'status' => (string) ($this->status ?? ''),
                ]);
            $json = $response->json();
            if ($response->successful() && ($json['success'] ?? false)) {
                $data = (array) ($json['data'] ?? []);
                $items = (array) ($data['data'] ?? []);
                usort($items, function ($a, $b) {
                    $timeA = isset($a['dibuat_pada']) ? strtotime((string)$a['dibuat_pada']) : 0;
                    $timeB = isset($b['dibuat_pada']) ? strtotime((string)$b['dibuat_pada']) : 0;
                    return $timeB <=> $timeA;
                });
                $this->items = $items;

                $this->currentPage = intval($data['current_page'] ?? 1);
                $this->lastPage = intval($data['last_page'] ?? 1);
                $this->perPage = intval($data['per_page'] ?? 0);

                $this->error = null;
            } else {
                $this->items = [];

                $this->currentPage = 1;
                $this->lastPage = 1;
                $this->perPage = 0;

                $this->error = $json['message'] ?? 'Gagal memuat history';
            }
        } catch (\Throwable) {
            $this->items = [];
            $this->currentPage = 1;
            $this->lastPage = 1;
            $this->perPage = 0;

            $this->error = 'Terjadi kesalahan saat mengambil history';
        }
    }

    public function goToPage(?int $page): void
    {
        if (!$page) return;
        $this->fetchHistory(intval($page));
    }

    public function applyFilter(): void
    {
        $this->fetchHistory(1);
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
        $this->applyFilter();
    }
};
