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
    public ?string $cancelMessage = null;
    public ?string $cancelError = null;

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

        $status = (int) $response->status();
        $data = json_decode((string) $response->body(), true) ?? [];
        if ($status >= 200 && $status < 300) {
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

    public function cancelBooking(): void
    {
        if (!Session::has('auth_token')) {
            $this->redirect('/login', navigate: true);
            return;
        }
        $code = (string) ($this->detail['kode_booking'] ?? $this->kode_booking ?? '');
        if (!$code) {
            $this->cancelError = 'Kode booking tidak ditemukan';
            $this->cancelMessage = null;
            return;
        }
        $base = config('services.api.base_url');
        $url = rtrim((string) $base, '/') . '/v1/lapangan/cancelBooking/' . urlencode($code);
        try {
            $token = Session::get('auth_token');
            $response = Http::withToken($token)
                ->asForm()
                ->accept('application/json')
                ->post($url, []);
            $status = (int) $response->status();
            $json = json_decode((string) $response->body(), true) ?? [];
            if ($status >= 200 && $status < 300 && ($json['success'] ?? false)) {
                $this->cancelMessage = (string) ($json['message'] ?? 'Booking berhasil dibatalkan');
                $this->cancelError = null;
                $this->fetchDetail();
                $this->dispatch('toast', [
                    'title' => 'Berhasil',
                    'message' => $this->cancelMessage,
                    'type' => 'success',
                ]);
                return;
            }
            $this->cancelError = (string) ($json['message'] ?? 'Gagal membatalkan booking');
            $this->cancelMessage = null;
            $this->dispatch('toast', [
                'title' => 'Gagal',
                'message' => $this->cancelError,
                'type' => 'error',
            ]);
        } catch (\Throwable) {
            $this->cancelError = 'Terjadi kesalahan saat membatalkan booking';
            $this->cancelMessage = null;
            $this->dispatch('toast', [
                'title' => 'Gagal',
                'message' => $this->cancelError,
                'type' => 'error',
            ]);
        }
    }
};
