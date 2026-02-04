<?php

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

new #[Title('Booking Detail')] #[Layout('layouts::admin.app')] class extends Component
{
    #[Url(as: 'id')]
    public $id;

    public bool $ready = false;
    public ?string $error = null;
    public array $detail = [];
    public ?string $jamFmt = null;

    public function load(): void
    {
        $this->ready = false;
        $this->fetchDetail();
        $this->ready = true;
    }

    protected function fetchDetail(): void
    {
        try {
            $token = Session::get('auth_token');
            $base = rtrim((string) config('services.api.base_url'), '/');
            $url = $base . '/v1/master/bookings/' . urlencode((string) $this->id);
            /** @var \Illuminate\Http\Client\Response $response */
            $response = Http::withToken($token)->accept('application/json')->get($url);
            $result = $response->json();
            if ($response->successful() && ($result['success'] ?? false)) {
                $this->detail = (array) ($result['data'] ?? []);
                $this->jamFmt = $this->formatJam((string) data_get($this->detail, 'jam', ''));
                $this->error = null;
                return;
            }
            $this->detail = [];
            $this->jamFmt = null;
            $this->error = (string) ($result['message'] ?? 'Gagal memuat detail booking');
        } catch (\Throwable) {
            $this->detail = [];
            $this->jamFmt = null;
            $this->error = 'Terjadi kesalahan saat mengambil detail booking';
        }
    }

    private function formatJam(string $jam): ?string
    {
        $jam = trim($jam);
        if ($jam === '') {
            return null;
        }
        $parts = array_map('trim', explode('-', $jam));
        $fmtParts = [];
        foreach ($parts as $p) {
            if ($p === '') continue;
            $seg = explode(':', $p);
            if (count($seg) >= 2) {
                $fmtParts[] = sprintf('%02d:%02d', intval($seg[0]), intval($seg[1]));
            } else {
                $fmtParts[] = substr($p, 0, 5);
            }
        }
        if (empty($fmtParts)) {
            return null;
        }
        return implode(' ', $fmtParts);
    }
};
