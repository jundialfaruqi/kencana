<?php

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

new #[Title('Booking Detail')] #[Layout('layouts::public.app')] class extends Component
{
    public bool $ready = false;
    public ?string $kode_booking = null;
    public array $detail = [];
    public array $catatan = [];
    public ?string $error = null;
    public ?string $cancelMessage = null;
    public ?string $cancelError = null;
    public bool $showCancelConfirm = false;
    public ?string $tgl = null;
    public ?string $tglFmt = null;
    public ?string $mulai = null;
    public ?string $selesai = null;
    public ?string $jenisAlias = null;
    public ?string $dpFmt = null;

    public function mount(string $kode_booking): void
    {
        $this->kode_booking = $kode_booking;
    }

    public function load(): void
    {
        $this->ready = false;
        $this->fetchDetail();
        $this->computeTanggalJam();
        $this->computeJenisAlias();
        $this->computeDibuatPada();
        $this->fetchCatatan();
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


    private function fetchCatatan(): void
    {
        $this->catatan = [];
        $lapId = $this->resolveLapanganIdFromCatalog();
        if (!$lapId) return;
        try {
            $token = Session::get('auth_token');
            $base = rtrim((string) config('services.api.base_url'), '/');
            $url = $base . '/v1/catatan/' . urlencode((string) $lapId);
            $response = Http::withToken($token)->accept('application/json')->get($url);
            $json = json_decode((string) $response, true);
            if (is_array($json) && ($json['success'] ?? false)) {
                $data = (array) ($json['data'] ?? []);
                if (!empty($data)) {
                    $first = $data[0] ?? [];
                    if (is_array($first) && array_key_exists('items', $first)) {
                        foreach ($data as $idx => $grp) {
                            $items = (array) ($grp['items'] ?? []);
                            usort($items, fn($a, $b) => intval($a['urutan'] ?? 0) <=> intval($b['urutan'] ?? 0));
                            $data[$idx]['items'] = $items;
                        }
                    }
                }
                $this->catatan = $data;
            } else {
                $this->catatan = [];
            }
        } catch (\Throwable) {
            $this->catatan = [];
        }
    }

    private function resolveLapanganIdFromCatalog(): ?string
    {
        try {
            $base = rtrim((string) config('services.api.base_url'), '/');
            $url = $base . '/v1/lapangan';
            $response = Http::accept('application/json')->get($url);
            $result = json_decode((string) $response, true);
            if (!is_array($result) || !($result['success'] ?? false)) {
                return null;
            }
            $list = (array) ($result['data'] ?? []);
            $target = (string) (data_get($this->detail, 'lapangan.nama') ?? data_get($this->detail, 'lapangan') ?? '');
            if ($target === '') return null;
            $targetSlug = Str::slug($target);
            foreach ($list as $row) {
                $name = (string) ($row['nama_lapangan'] ?? '');
                if ($name === '') continue;
                if (Str::slug($name) === $targetSlug) {
                    $id = $row['id'] ?? null;
                    return $id !== null ? (string) $id : null;
                }
            }
        } catch (\Throwable) {
        }
        return null;
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

    private function computeTanggalJam(): void
    {
        $this->tgl = (string) ($this->detail['tanggal'] ?? '');
        $this->tglFmt = null;
        if (preg_match('/^\d{4}-\d{2}-\d{2}/', (string) $this->tgl)) {
            $this->tglFmt = date('d/m/Y', strtotime((string) $this->tgl));
        } else {
            $parts = explode(',', (string) $this->tgl);
            $rest = trim((string) end($parts));
            $tok = preg_split('/\s+/', $rest);
            $bulanMap = [
                'januari' => 1,
                'februari' => 2,
                'maret' => 3,
                'april' => 4,
                'mei' => 5,
                'juni' => 6,
                'juli' => 7,
                'agustus' => 8,
                'september' => 9,
                'oktober' => 10,
                'november' => 11,
                'desember' => 12,
            ];
            if (is_array($tok) && count($tok) >= 3) {
                $d = (int) preg_replace('/\D/', '', (string) $tok[0]);
                $b = $bulanMap[strtolower((string) $tok[1])] ?? null;
                $y = (int) preg_replace('/\D/', '', (string) $tok[2]);
                if ($d && $b && $y) {
                    $this->tglFmt = sprintf('%02d/%02d/%04d', $d, (int) $b, $y);
                }
            }
        }
        $this->mulai = (string) data_get($this->detail, 'jam.mulai');
        $this->selesai = (string) data_get($this->detail, 'jam.selesai');
    }

    private function computeJenisAlias(): void
    {
        $raw = (string) (data_get($this->detail, 'pemesan.jenis_permainan') ?? '');
        $this->jenisAlias = match ($raw) {
            'fun_match' => 'FUN MATCH',
            'latihan' => 'LATIHAN',
            'turnamen_kecil' => 'TURNAMEN KECIL',
            default => strtoupper(str_replace('_', ' ', $raw)),
        };
    }

    private function computeDibuatPada(): void
    {
        $dp = (string) (data_get($this->detail, 'dibuat_pada') ?? '');
        $this->dpFmt = null;
        if (preg_match('/^\d{4}-\d{2}-\d{2}/', $dp)) {
            $this->dpFmt = date('d-m-Y H:i', strtotime($dp));
            return;
        }
        $tok = preg_split('/\s+/', trim($dp));
        $bulanMap = [
            'januari' => 1,
            'februari' => 2,
            'maret' => 3,
            'april' => 4,
            'mei' => 5,
            'juni' => 6,
            'juli' => 7,
            'agustus' => 8,
            'september' => 9,
            'oktober' => 10,
            'november' => 11,
            'desember' => 12,
        ];
        if (is_array($tok) && count($tok) >= 4) {
            $d = (int) preg_replace('/\D/', '', (string) $tok[0]);
            $b = $bulanMap[strtolower((string) $tok[1])] ?? null;
            $y = (int) preg_replace('/\D/', '', (string) $tok[2]);
            $time = (string) $tok[3];
            if ($d && $b && $y && preg_match('/^\d{2}:\d{2}/', $time)) {
                $this->dpFmt = sprintf('%02d-%02d-%04d %s', $d, (int) $b, $y, $time);
            }
        }
    }
};
