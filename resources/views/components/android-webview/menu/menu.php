<?php

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

new #[Title('Beranda')] #[Layout('layouts::android-webview.app')] class extends Component
{
    public bool $showTermsModal = false;
    public bool $termsAgreed = false;
    public array $banners = [];
    public array $arenas = [];
    public array $recentBookings = [];
    public ?string $arenaError = null;

    public function mount(): void
    {
        // Tampilkan modal jika belum pernah disetujui pada sesi ini
        if (! Session::get('webview_menu_terms_agreed', false)) {
            $this->showTermsModal = true;
        }

        $this->fetchBanners();
        $this->fetchArenas();
        $this->fetchRecentBookings();
    }

    protected function fetchBanners(): void
    {
        $base = config('services.api.base_url');
        $url = rtrim((string) $base, '/').'/v1/slider';
        try {
            $verifySsl = filter_var(config('services.api.verify_ssl', true), FILTER_VALIDATE_BOOLEAN);

            $response = Http::accept('application/json')->withOptions(['verify' => $verifySsl])->get($url);
            $json = $response->json();
            if ($response->successful() && ($json['success'] ?? false)) {
                $data = (array) ($json['data'] ?? []);
                $this->banners = array_map(function ($item) {
                    return [
                        'kategori' => (string) Arr::get($item, 'kategori', ''),
                        'judul' => (string) Arr::get($item, 'judul', ''),
                        'deskripsi' => (string) Arr::get($item, 'deskripsi', ''),
                        'image' => (string) Arr::get($item, 'image', ''),
                    ];
                }, $data);
            } else {
                $this->banners = [];
            }
        } catch (\Throwable $e) {
            Log::error('Webview banner carousel error: '.$e->getMessage());
            $this->banners = [];
        }
    }

    protected function fetchArenas(): void
    {
        $url = rtrim((string) config('services.api.base_url'), '/') . '/v1/lapangan';
        try {
            $token = Session::get('auth_token');
            $response = Http::withOptions(['verify' => filter_var(config('services.api.verify_ssl', true), FILTER_VALIDATE_BOOLEAN)])
                ->withToken($token)->accept('application/json')->get($url);
            $json = $response->json();
            if ($response->successful() && ($json['success'] ?? false)) {
                $this->arenas = (array) ($json['data'] ?? []);
                $this->arenaError = null;
            } else {
                $this->arenas = [];
                $this->arenaError = $json['message'] ?? 'Gagal memuat daftar lapangan';
            }
        } catch (\Throwable $e) {
            $this->arenas = [];
            $this->arenaError = 'Terjadi kesalahan saat mengambil data lapangan';
            Log::error('Webview fetch arenas error: '.$e->getMessage());
        }
    }

    protected function fetchRecentBookings(): void
    {
        $url = rtrim((string) config('services.api.base_url'), '/') . '/v1/lapangan/historyBooking';
        try {
            $token = Session::get('auth_token');
            if (!$token) {
                $this->recentBookings = [];
                return;
            }

            $response = Http::withOptions([
                'verify' => filter_var(config('services.api.verify_ssl', true), FILTER_VALIDATE_BOOLEAN),
            ])->withToken($token)->asForm()->accept('application/json')
              ->post($url . '?page=1', [
                  'status' => '',
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

                $this->recentBookings = array_slice($items, 0, 3);
            } else {
                $this->recentBookings = [];
            }
        } catch (\Throwable $e) {
            $this->recentBookings = [];
            Log::error('Webview fetch recent bookings error: '.$e->getMessage());
        }
    }

    public function getCoverUrl(?string $imagePath): ?string
    {
        if (empty($imagePath)) return null;
        $cover = ltrim((string) $imagePath, '/');
        return preg_match('/^https?:\/\//', $cover) ? $cover : rtrim(config('services.api.image_base_url'), '/') . '/' . $cover;
    }

    public function isArenaAvailable(array $arena): bool
    {
        $status = strtolower((string) ($arena['status'] ?? ''));
        return in_array($status, ['open', 'buka', 'aktif']);
    }

    public function acceptTerms(): void
    {
        if ($this->termsAgreed) {
            Session::put('webview_menu_terms_agreed', true);
            $this->showTermsModal = false;
        }
    }

    public function render()
    {
        return view('components.android-webview.menu.menu');
    }
};
