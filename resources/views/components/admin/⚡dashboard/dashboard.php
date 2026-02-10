<?php

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Client\Response;

new #[Title('Dashboard')] #[Layout('layouts::admin.app')] class extends Component
{
    public string $searchQuery = '';
    public bool $isLoading = false;
    public ?array $bookingDetail = null;
    public ?string $searchError = null;
    public ?string $error = null;

    public function load(): void
    {
        // Inisialisasi error saat komponen dimuat
        $this->error = null;
    }

    protected function rules(): array
    {
        return [
            'searchQuery' => ['required', 'string', 'min:1'],
        ];
    }

    public function getJenisPermainanAlias(string $jenis): string
    {
        return match ($jenis) {
            'fun_match' => 'Fun Match',
            'latihan' => 'Latihan',
            'turnamen_kecil' => 'Turnamen Kecil',
            default => ucfirst(str_replace('_', ' ', $jenis)),
        };
    }

    public function searchBooking(): void
    {
        $this->resetValidation();
        $this->validate();

        $this->isLoading = true;
        $this->bookingDetail = null;
        $this->searchError = null;

        try {
            $token = Session::get('auth_token');
            $base = rtrim((string) config('services.api.base_url'), '/');
            $url = $base . '/v1/master/bookings?search=' . $this->searchQuery;

            /** @var Response $response */
            $response = Http::withToken($token)->get($url);
            $json = $response->json();

            if ($response->successful() && ($json['success'] ?? false)) {
                // Mengakses data booking dari struktur bersarang: json['data']['data'][0]
                $nestedData = (array) ($json['data']['data'][0] ?? []);
                if (!empty($nestedData) && isset($nestedData['kode_booking'])) {
                    $this->bookingDetail = $nestedData;
                } else {
                    $this->searchError = 'Kode booking tidak ditemukan.';
                }
            } else {
                $this->searchError = (string) ($json['message'] ?? 'Gagal mencari kode booking.');
            }
        } catch (\Throwable) {
            $this->searchError = 'Terjadi kesalahan saat mencari kode booking.';
        } finally {
            $this->isLoading = false;
        }
    }
};
