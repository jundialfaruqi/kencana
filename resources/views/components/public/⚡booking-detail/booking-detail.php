<?php

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

new #[Title('Booking Detail')] #[Layout('layouts::public.app')] class extends Component
{
    public bool $ready = false;
    public ?string $kode_booking = null;
    public array $detail = [];
    public ?string $error = null;

    public function mount(string $kode_booking): void
    {
        $this->kode_booking = $kode_booking;
    }

    public function load(): void
    {
        $this->ready = false;
        $this->fetchDetail();
        sleep(1);
        $this->ready = true;
        $this->dispatch('detail-loaded');
    }

    private function fetchDetail(): void
    {
        $baseUrl = config('services.api.base_url');
        $url = rtrim($baseUrl, '/') . '/v1/lapangan/historyBooking/' . urlencode((string) $this->kode_booking);
        $token = Session::get('auth_token');

        $response = Http::withToken($token)
            ->asForm()
            ->accept('application/json')
            ->post($url, []);

        if ($response->successful()) {
            $data = $response->json();
            if (($data['success'] ?? false) && is_array($data['data'] ?? null)) {
                $this->detail = $data['data'];
                $this->error = null;
            } else {
                $this->detail = [];
                $this->error = $data['message'] ?? 'Gagal memuat detail booking';
            }
        } else {
            $this->detail = [];
            $this->error = 'Gagal terhubung ke server';
        }
    }
};
