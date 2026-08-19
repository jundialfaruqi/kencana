<?php

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

new #[Title('Menu')] #[Layout('layouts::android-webview.app')] class extends Component
{
    public bool $showTermsModal = false;
    public bool $termsAgreed = false;
    public array $banners = [];

    public function mount(): void
    {
        // Tampilkan modal jika belum pernah disetujui pada sesi ini
        if (! Session::get('webview_menu_terms_agreed', false)) {
            $this->showTermsModal = true;
        }

        $this->fetchBanners();
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
