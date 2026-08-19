<?php

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

new #[Title('Detail Booking')] #[Layout('layouts::android-webview.app')] class extends Component
{
    public ?string $kode_booking = null;
    public array $detail = [];
    public array $catatan = [];
    public ?string $error = null;
    public ?string $cancelMessage = null;
    public ?string $cancelError = null;
    public bool $showCancelConfirm = false;

    public function mount(string $kode_booking): void
    {
        if (! Session::has('auth_token')) {
            $this->redirect(route('webview.expired'));
            return;
        }

        $this->kode_booking = $kode_booking;
        $this->fetchDetail();
        $this->fetchCatatan();
    }

    public function fetchDetail(): void
    {
        $baseUrl = config('services.api.base_url');
        $url = rtrim((string) $baseUrl, '/') . '/v1/lapangan/historyBooking/' . urlencode((string) $this->kode_booking);
        $token = Session::get('auth_token');

        try {
            $response = Http::withOptions([
                'verify' => filter_var(config('services.api.verify_ssl', true), FILTER_VALIDATE_BOOLEAN),
            ])->withToken($token)->asForm()->accept('application/json')->post($url, []);

            $json = $response->json();
            if ($response->successful() && ($json['success'] ?? false) && is_array($json['data'] ?? null)) {
                $this->detail = (array) $json['data'];
                $this->error = null;
            } else {
                $this->detail = [];
                $this->error = $json['message'] ?? 'Gagal memuat detail booking';
            }
        } catch (\Throwable $e) {
            $this->detail = [];
            $this->error = 'Terjadi kesalahan saat memuat detail booking';
            Log::error('Webview detail booking error: ' . $e->getMessage());
        }
    }

    public function fetchCatatan(): void
    {
        $this->catatan = [];
        $lapId = data_get($this->detail, 'lapangan.id') 
            ?: data_get($this->detail, 'lapangan_id') 
            ?: data_get($this->detail, 'id_lapangan');

        if (! $lapId) {
            $lapId = $this->resolveLapanganId();
        }

        if (! $lapId) {
            return;
        }

        try {
            $token = Session::get('auth_token');
            $url = rtrim((string) config('services.api.base_url'), '/') . '/v1/catatan/' . urlencode((string) $lapId);
            $response = Http::withOptions([
                'verify' => filter_var(config('services.api.verify_ssl', true), FILTER_VALIDATE_BOOLEAN),
            ])->withToken($token)->accept('application/json')->get($url);

            $json = $response->json();
            if ($response->successful() && ($json['success'] ?? false)) {
                $data = (array) ($json['data'] ?? []);
                if (! empty($data)) {
                    foreach ($data as $idx => $grp) {
                        $items = (array) ($grp['items'] ?? []);
                        usort($items, fn ($a, $b) => intval($a['urutan'] ?? 0) <=> intval($b['urutan'] ?? 0));
                        $data[$idx]['items'] = $items;
                    }
                }
                $this->catatan = $data;
            }
        } catch (\Throwable) {
            $this->catatan = [];
        }
    }

    private function resolveLapanganId(): ?string
    {
        $nama = $this->namaLapangan;
        if (! $nama || $nama === '-') return null;
        $namaLower = strtolower(trim((string) $nama));

        try {
            $token = Session::get('auth_token');
            $url = rtrim((string) config('services.api.base_url'), '/') . '/v1/lapangan';
            $response = Http::withOptions([
                'verify' => filter_var(config('services.api.verify_ssl', true), FILTER_VALIDATE_BOOLEAN),
            ])->withToken($token)->accept('application/json')->get($url);

            $json = $response->json();
            if ($response->successful() && ($json['success'] ?? false)) {
                $arenas = (array) ($json['data'] ?? []);
                foreach ($arenas as $a) {
                    $aNama = strtolower(trim((string) ($a['nama_lapangan'] ?? ($a['nama'] ?? ''))));
                    if ($aNama === $namaLower || str_contains($namaLower, $aNama) || str_contains($aNama, $namaLower)) {
                        return (string) ($a['id'] ?? '');
                    }
                }
            }
        } catch (\Throwable) {}

        return null;
    }

    #[Computed]
    public function namaLapangan(): string
    {
        $lap = $this->detail['lapangan'] ?? null;
        if (is_array($lap)) {
            return (string) ($lap['nama'] ?? ($lap['nama_lapangan'] ?? '-'));
        }
        return (string) ($lap ?: (data_get($this->detail, 'nama_lapangan') ?: '-'));
    }

    #[Computed]
    public function bookingStatus(): string
    {
        return strtolower((string) data_get($this->detail, 'status', ''));
    }

    #[Computed]
    public function tanggalFmt(): string
    {
        $tgl = (string) data_get($this->detail, 'tanggal', '');
        if (preg_match('/^\d{4}-\d{2}-\d{2}/', $tgl)) {
            try {
                return \Carbon\Carbon::parse($tgl)->locale('id')->translatedFormat('l, d F Y');
            } catch (\Throwable) {}
        }
        return $tgl ?: '-';
    }

    #[Computed]
    public function jamFmt(): string
    {
        $jam = data_get($this->detail, 'jam');
        if (is_array($jam)) {
            $mulai = substr((string) ($jam['mulai'] ?? ''), 0, 5);
            $selesai = substr((string) ($jam['selesai'] ?? ''), 0, 5);
            $res = trim("{$mulai} - {$selesai}", ' -');
            return $res ?: '-';
        }
        if (!empty($this->detail['jam_mulai']) || !empty($this->detail['jam_selesai'])) {
            $mulai = substr((string) ($this->detail['jam_mulai'] ?? ''), 0, 5);
            $selesai = substr((string) ($this->detail['jam_selesai'] ?? ''), 0, 5);
            $res = trim("{$mulai} - {$selesai}", ' -');
            return $res ?: '-';
        }
        return is_string($jam) && !empty($jam) ? $jam : '-';
    }

    #[Computed]
    public function komunitas(): string
    {
        $team = data_get($this->detail, 'nama_komunitas') 
            ?: data_get($this->detail, 'pemesan.nama_komunitas')
            ?: data_get($this->detail, 'komunitas');
            
        $pemesan = data_get($this->detail, 'pemesan.nama')
            ?: data_get($this->detail, 'pemesan.user.name')
            ?: data_get($this->detail, 'user.name')
            ?: data_get(Session::get('user_data'), 'name');

        if (filled($team)) {
            return (string) $team;
        }

        if (filled($pemesan)) {
            return (string) $pemesan;
        }

        return '-';
    }

    #[Computed]
    public function jumlahPemain(): string
    {
        $jml = data_get($this->detail, 'pemesan.jumlah_pemain') 
            ?? data_get($this->detail, 'jumlah_pemain')
            ?? data_get($this->detail, 'pemesan.pemain');
        return $jml ? "{$jml} Orang" : '-';
    }

    #[Computed]
    public function kategori(): string
    {
        $kat = (string) (
            data_get($this->detail, 'pemesan.kategori')
            ?: data_get($this->detail, 'pemesan.kategori_pemain')
            ?: data_get($this->detail, 'kategori')
            ?: data_get($this->detail, 'kategori_pemain')
            ?: ''
        );
        
        $katLower = strtolower(trim($kat));
        return match ($katLower) {
            'anak-anak' => 'Anak-anak',
            'remaja'    => 'Remaja',
            'dewasa'    => 'Dewasa',
            default     => !empty($kat) ? ucfirst($katLower) : '-',
        };
    }

    #[Computed]
    public function jenis(): string
    {
        $jns = (string) (
            data_get($this->detail, 'pemesan.jenis_permainan')
            ?: data_get($this->detail, 'pemesan.jenis')
            ?: data_get($this->detail, 'jenis_permainan')
            ?: data_get($this->detail, 'jenis')
            ?: ''
        );
        
        $jnsLower = strtolower(trim($jns));
        return match ($jnsLower) {
            'fun_match'      => 'Fun Match',
            'latihan'        => 'Latihan',
            'turnamen_kecil' => 'Turnamen Kecil',
            default          => !empty($jns) ? ucwords(str_replace('_', ' ', $jnsLower)) : '-',
        };
    }

    #[Computed]
    public function dibuatPada(): string
    {
        $dp = (string) data_get($this->detail, 'dibuat_pada', '');
        if (preg_match('/^\d{4}-\d{2}-\d{2}/', $dp)) {
            try {
                return \Carbon\Carbon::parse($dp)->locale('id')->translatedFormat('d M Y H:i');
            } catch (\Throwable) {}
        }
        return $dp ?: '-';
    }

    public function openCancelConfirm(): void
    {
        $this->cancelMessage = null;
        $this->cancelError = null;
        $this->showCancelConfirm = true;
    }

    public function closeCancelConfirm(): void
    {
        $this->showCancelConfirm = false;
    }

    public function cancelBooking(): void
    {
        $code = (string) ($this->detail['kode_booking'] ?? $this->kode_booking ?? '');
        if (! $code) {
            $this->cancelError = 'Kode booking tidak ditemukan';
            return;
        }

        $url = rtrim((string) config('services.api.base_url'), '/') . '/v1/lapangan/cancelBooking/' . urlencode($code);
        try {
            $token = Session::get('auth_token');
            $response = Http::withOptions([
                'verify' => filter_var(config('services.api.verify_ssl', true), FILTER_VALIDATE_BOOLEAN),
            ])->withToken($token)->asForm()->accept('application/json')->post($url, []);

            $json = $response->json();
            if ($response->successful() && ($json['success'] ?? false)) {
                $this->cancelMessage = $json['message'] ?? 'Booking berhasil dibatalkan';
                $this->cancelError = null;
                $this->showCancelConfirm = false;
                $this->fetchDetail();
                $this->dispatch('toast', [
                    'title' => 'Berhasil',
                    'message' => (string) $this->cancelMessage,
                    'type' => 'success',
                ]);
            } else {
                $this->cancelError = $json['message'] ?? 'Gagal membatalkan booking';
                $this->dispatch('toast', [
                    'title' => 'Gagal',
                    'message' => $this->cancelError,
                    'type' => 'error',
                ]);
            }
        } catch (\Throwable $e) {
            $this->cancelError = 'Terjadi kesalahan saat membatalkan booking';
            $this->dispatch('toast', [
                'title' => 'Gagal',
                'message' => $this->cancelError,
                'type' => 'error',
            ]);
            Log::error('Webview cancel booking error: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('components.android-webview.detail-booking.detail-booking');
    }
};
