<?php

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

new #[Title('Booking Detail')]
#[Layout('layouts::public.app')]
class extends Component
{
    public bool $ready = false;
    public ?string $kode_booking = null;
    public array $detail = [];
    public ?string $error = null;
    public ?string $cancelMessage = null;
    public ?string $cancelError = null;
    public bool $showCancelConfirm = false;

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

        $data = json_decode((string) $response, true);
        if (is_array($data) && ($data['success'] ?? false) && is_array($data['data'] ?? null)) {
            $this->detail = (array) $data['data'];
            $this->error = null;
            return;
        }
        $this->detail = [];
        $this->error = is_array($data) ? (string) ($data['message'] ?? 'Gagal memuat detail booking') : 'Gagal terhubung ke server';
    }

    public function cancelBooking(): void
    {
        $this->showCancelConfirm = false;
        if (! Session::has('auth_token')) {
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
            $json = json_decode((string) $response, true);
            if (is_array($json) && ($json['success'] ?? false)) {
                $this->cancelMessage = (string) ($json['message'] ?? 'Booking berhasil dibatalkan');
                $this->cancelError = null;
                $this->fetchDetail();
                $this->dispatch('toast', [
                    'title' => 'Berhasil',
                    'message' => (string) $this->cancelMessage,
                    'type' => 'success',
                ]);
                return;
            }
            $this->cancelError = is_array($json) ? (string) ($json['message'] ?? 'Gagal membatalkan booking') : 'Gagal membatalkan booking';
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

    public function openCancelConfirm(): void
    {
        $this->cancelMessage = null;
        $this->cancelError = null;
        $this->showCancelConfirm = true;
    }
};
