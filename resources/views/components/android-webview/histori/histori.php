<?php

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

new #[Title('Histori Booking')] #[Layout('layouts::android-webview.app')] class extends Component
{
    public array $items = [];
    public ?string $error = null;
    public ?string $status = 'dipesan';
    public int $currentPage = 1;
    public int $lastPage = 1;
    public int $perPage = 0;

    public function mount(): void
    {
        if (! Session::has('auth_token')) {
            $this->redirect(route('webview.expired'));
            return;
        }
        $this->fetchHistory(1);
    }

    protected function fetchHistory(int $page = 1): void
    {
        $url = rtrim((string) config('services.api.base_url'), '/') . '/v1/lapangan/historyBooking';
        try {
            $token = Session::get('auth_token');
            $response = Http::withOptions([
                'verify' => filter_var(config('services.api.verify_ssl', true), FILTER_VALIDATE_BOOLEAN),
            ])->withToken($token)->asForm()->accept('application/json')
              ->post($url . '?page=' . intval($page), [
                  'status' => (string) ($this->status ?? ''),
              ]);

            $json = $response->json();
            if ($response->successful() && ($json['success'] ?? false)) {
                $data  = (array) ($json['data'] ?? []);
                $items = (array) ($data['data'] ?? []);

                usort($items, function ($a, $b) {
                    $tA = isset($a['dibuat_pada']) ? strtotime((string) $a['dibuat_pada']) : 0;
                    $tB = isset($b['dibuat_pada']) ? strtotime((string) $b['dibuat_pada']) : 0;
                    return $tB <=> $tA;
                });

                $this->items       = $items;
                $this->currentPage = intval($data['current_page'] ?? 1);
                $this->lastPage    = intval($data['last_page'] ?? 1);
                $this->perPage     = intval($data['per_page'] ?? 0);
                $this->error       = null;
            } else {
                $this->items       = [];
                $this->currentPage = 1;
                $this->lastPage    = 1;
                $this->error       = $json['message'] ?? 'Gagal memuat histori';
            }
        } catch (\Throwable) {
            $this->items       = [];
            $this->currentPage = 1;
            $this->lastPage    = 1;
            $this->error       = 'Terjadi kesalahan saat mengambil histori';
        }
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
        $this->fetchHistory(1);
    }

    public function goToPage(?int $page): void
    {
        if (! $page) return;
        $this->fetchHistory(intval($page));
    }

    public function render()
    {
        return view('components.android-webview.histori.histori');
    }
};
