<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Crypt;
use Livewire\Attributes\Url;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

new #[Layout('layouts::public.app')] #[Title('Pesan Arena')] class extends Component
{
    public $lapanganId;
    #[Url(as: 'lapangan_id')]
    public ?string $lapanganParam = null;
    public bool $ready = false;
    public string $tanggal = '';
    public string $namaLapangan = '';
    public array $timeSlots = [];
    public ?string $error = null;
    public array $arenas = [];
    public ?array $selectedSlot = null;
    public ?string $namaKomunitas = null;
    public ?int $jumlahPemain = null;
    public string $kategoriPemain = '';
    public string $jenisPermainan = '';
    public ?string $keterangan = null;
    public bool $showSuccessModal = false;
    public ?string $bookingMessage = null;
    public ?string $bookingCode = null;
    public bool $showTermsModal = false;
    public bool $termsAgreed = false;
    public array $catatan = [];
    public $calCurrLabel;
    public $calNextLabel;
    public $calCurrDays;
    public $calNextDays;
    public $calCurrStartDow;
    public $calNextStartDow;
    public $calCurrMonth;
    public $calNextMonth;
    public $todayDate;
    public array $carouselDates = [];

    public function load()
    {
        if (!Session::has('auth_token')) {
            $this->redirect('/login', navigate: true);
            return;
        }

        if ($this->lapanganParam && !$this->lapanganId) {
            $decoded = null;
            try {
                $decoded = Crypt::decryptString((string) $this->lapanganParam);
            } catch (\Throwable) {
                $decoded = $this->lapanganParam;
            }
            $this->lapanganId = (string) $decoded;
        }

        Carbon::setLocale('id');
        $this->tanggal = Carbon::now()->toDateString();
        $today = Carbon::now();
        $curr = $today->copy()->startOfMonth();
        $next = $today->copy()->addMonthNoOverflow()->startOfMonth();
        $this->calCurrLabel = $curr->translatedFormat('F Y');
        $this->calNextLabel = $next->translatedFormat('F Y');
        $this->calCurrDays = $curr->daysInMonth;
        $this->calNextDays = $next->daysInMonth;
        $this->calCurrStartDow = $curr->dayOfWeek;
        $this->calNextStartDow = $next->dayOfWeek;
        $this->calCurrMonth = $curr->format('Y-m');
        $this->calNextMonth = $next->format('Y-m');
        $this->todayDate = $today->toDateString();
        $start = $today->copy()->startOfDay();
        $end = $start->copy()->addMonthNoOverflow()->endOfMonth()->startOfDay();
        $days = $start->diffInDays($end) + 1;
        $this->carouselDates = [];
        for ($i = 0; $i < $days; $i++) {
            $d = $start->copy()->addDays($i);
            $this->carouselDates[] = $d->toDateString();
        }
        if ($this->lapanganId) {
            if (!$this->isArenaOpen((string) $this->lapanganId)) {
                $this->error = 'Arena belum dibuka';
                $this->lapanganId = null;
                $this->lapanganParam = null;
                $this->namaLapangan = '';
                $this->timeSlots = [];
                $this->fetchArenas();
                $this->dispatch('booking-loaded');
            } else {
                $this->fetchJadwal();
            }
        } else {
            $this->fetchArenas();
        }
        $this->ready = true;
    }

    public function selectDate(string $date)
    {
        $this->tanggal = $date;
        $this->selectedSlot = null;
        $this->fetchJadwal();
    }

    protected function fetchJadwal(): void
    {
        if (!$this->lapanganId) {
            $this->timeSlots = [];
            $this->namaLapangan = '';
            $this->error = null;
            $this->dispatch('booking-loaded');
            return;
        }
        if (!$this->isArenaOpen((string) $this->lapanganId)) {
            $this->error = 'Arena belum dibuka';
            $this->timeSlots = [];
            $this->namaLapangan = '';
            $this->lapanganId = null;
            $this->dispatch('booking-loaded');
            return;
        }

        $base = config('services.api.base_url');
        $url = rtrim((string) $base, '/') . '/v1/lapangan/listJadwal';

        try {
            $token = Session::get('auth_token');
            /** @var \Illuminate\Http\Client\Response $response */
            $response = Http::withToken($token)
                ->asForm()
                ->accept('application/json')
                ->post($url, [
                    'tanggal' => $this->tanggal,
                    'lapangan_id' => $this->lapanganId,
                ]);

            $json = $response->json();
            if ($response->successful() && ($json['success'] ?? false)) {
                $data = $json['data'] ?? [];
                $first = $data[0] ?? null;
                $this->namaLapangan = $first['nama_lapangan'] ?? '';
                $slots = (array) ($first['slots'] ?? []);
                $this->timeSlots = array_map(function ($s) {
                    $mulai = (string) ($s['mulai'] ?? ($s['jam_mulai'] ?? ''));
                    $selesai = (string) ($s['selesai'] ?? ($s['jam_selesai'] ?? ''));
                    $status = (string) ($s['status'] ?? '');
                    return ['mulai' => $mulai, 'selesai' => $selesai, 'status' => $status] + (array) $s;
                }, $slots);
                $this->error = null;
            } else {
                $this->error = $json['message'] ?? 'Gagal memuat jadwal';
            }
        } catch (\Throwable) {
            $this->error = 'Terjadi kesalahan saat memuat jadwal';
        }

        $this->dispatch('booking-loaded');
    }

    public function selectArena(string $id, string $nama): void
    {
        if (!$this->isArenaOpen($id)) {
            $this->error = 'Arena belum dibuka';
            $this->lapanganId = null;
            $this->lapanganParam = null;
            $this->namaLapangan = '';
            $this->timeSlots = [];
            $this->fetchArenas();
            $this->dispatch('booking-loaded');
            return;
        }
        $this->lapanganId = $id;
        try {
            $this->lapanganParam = Crypt::encryptString((string) $id);
        } catch (\Throwable) {
            $this->lapanganParam = (string) $id;
        }
        $this->namaLapangan = $nama;
        $this->fetchJadwal();
    }

    public function selectTime(string $mulai, string $selesai): void
    {
        $clicked = [
            'mulai' => $mulai,
            'selesai' => $selesai,
        ];
        $this->selectedSlot = $clicked;
        try {
            $this->fetchJadwal();
            $match = null;
            foreach ((array) $this->timeSlots as $s) {
                if (
                    (string) ($s['mulai'] ?? '') === (string) $clicked['mulai']
                    && (string) ($s['selesai'] ?? '') === (string) $clicked['selesai']
                ) {
                    $match = $s;
                    break;
                }
            }
            if (!$match || (string) ($match['status'] ?? '') !== 'tersedia') {
                $this->selectedSlot = null;
                $msg = (string) ($match['message'] ?? ($match['status_label'] ?? ($this->error ?? 'Jam sudah dibooking oleh pengguna lain')));
                $this->dispatch('toast', [
                    'title' => 'Tidak tersedia',
                    'message' => $msg,
                    'type' => 'error',
                ]);
            }
        } catch (\Throwable) {
        }
        sleep(1);
    }

    protected function fetchArenas(): void
    {
        $base = config('services.api.base_url');
        $url = rtrim((string) $base, '/') . '/v1/lapangan';
        try {
            $token = Session::get('auth_token');
            /** @var \Illuminate\Http\Client\Response $response */
            $response = Http::withToken($token)
                ->accept('application/json')
                ->get($url);
            $json = $response->json();
            if ($response->successful() && ($json['success'] ?? false)) {
                $this->arenas = (array) ($json['data'] ?? []);
                $this->error = null;
            } else {
                $this->error = $json['message'] ?? 'Gagal memuat daftar arena';
                $this->arenas = [];
            }
        } catch (\Throwable) {
            $this->error = 'Terjadi kesalahan saat mengambil daftar arena';
            $this->arenas = [];
        }
    }

    protected function isArenaOpen(string $id): bool
    {
        try {
            $base = config('services.api.base_url');
            $url = rtrim((string) $base, '/') . '/v1/lapangan';
            $token = Session::get('auth_token');
            /** @var \Illuminate\Http\Client\Response $response */
            $response = Http::withToken($token)
                ->accept('application/json')
                ->get($url);
            $json = $response->json();
            $list = ($json['data'] ?? []);
            foreach ((array) $list as $item) {
                if ((string) ($item['id'] ?? '') === (string) $id) {
                    return (($item['status'] ?? '') === 'open');
                }
            }
        } catch (\Throwable) {
        }
        return false;
    }

    public function arenaIsComing(array $arena): bool
    {
        return (($arena['status'] ?? '') === 'coming_soon');
    }

    public function arenaIsSelected(array $arena): bool
    {
        return (string) ($arena['id'] ?? '') === (string) ($this->lapanganId ?? '');
    }

    public function slotIsAvailable(array $slot): bool
    {
        return (($slot['status'] ?? '') === 'tersedia');
    }

    public function slotIsSelected(array $slot): bool
    {
        return $this->selectedSlot
            && (($this->selectedSlot['mulai'] ?? null) === ($slot['mulai'] ?? null))
            && (($this->selectedSlot['selesai'] ?? null) === ($slot['selesai'] ?? null));
    }

    public function isValidationErr(?string $error): bool
    {
        return in_array((string) ($error ?? ''), ['Arena belum dipilih, pilih arenanya dulu!', 'Tanggal belum dipilih, pilih tanggalnya dulu!', 'Jam belum dipilih, pilih jamnya dulu'], true);
    }

    public function jenisLabel(): string
    {
        if ($this->jenisPermainan === 'fun_match') {
            return 'FUN MATCH';
        }
        if ($this->jenisPermainan === 'latihan') {
            return 'LATIHAN';
        }
        if ($this->jenisPermainan === 'turnamen_kecil') {
            return 'TURNAMEN KECIL';
        }
        return 'Pilih jenis';
    }

    public function updatedJumlahPemain($value): void
    {
        $digits = preg_replace('/\D/', '', (string) $value);
        $num = is_numeric($digits) ? intval($digits) : null;
        $this->jumlahPemain = $num;
    }

    protected function rules(): array
    {
        return [
            'namaKomunitas' => ['nullable', 'string'],
            'jumlahPemain' => ['required', 'integer', 'min:1'],
            'kategoriPemain' => ['required', 'in:anak-anak,remaja,dewasa'],
            'jenisPermainan' => ['required', 'in:fun_match,latihan,turnamen_kecil'],
        ];
    }

    protected function messages(): array
    {
        return [
            'jumlahPemain.required' => 'Jumlah pemain wajib diisi',
            'jumlahPemain.integer' => 'Jumlah pemain harus berupa angka',
            'jumlahPemain.min' => 'Jumlah pemain minimal 1',
            'kategoriPemain.required' => 'Kategori pemain wajib dipilih',
            'kategoriPemain.in' => 'Kategori pemain tidak valid',
            'jenisPermainan.required' => 'Jenis permainan wajib dipilih',
            'jenisPermainan.in' => 'Jenis permainan tidak valid',
        ];
    }

    public function confirmBooking(): void
    {
        if (!Session::has('auth_token')) {
            $this->redirect('/login', navigate: true);
            return;
        }
        if (!$this->lapanganId) {
            $this->error = 'Arena belum dipilih, pilih arenanya dulu!';
            return;
        }
        if (!$this->tanggal) {
            $this->error = 'Tanggal belum dipilih, pilih tanggalnya dulu!';
            return;
        }
        if (!$this->selectedSlot || empty($this->selectedSlot['mulai']) || empty($this->selectedSlot['selesai'])) {
            $this->error = 'Jam belum dipilih, pilih jamnya dulu!';
            return;
        }
        $this->error = null;

        $this->resetValidation();
        $this->validate();

        $this->termsAgreed = false;
        $this->catatan = [];
        try {
            $base = config('services.api.base_url');
            $url = rtrim((string) $base, '/') . '/v1/catatan/' . (string) $this->lapanganId;
            $token = Session::get('auth_token');
            /** @var \Illuminate\Http\Client\Response $response */
            $response = Http::withToken($token)
                ->accept('application/json')
                ->get($url);
            $json = $response->json();
            if ($response->successful() && ($json['success'] ?? false)) {
                $this->catatan = (array) ($json['data'] ?? []);
            } else {
                $this->catatan = [];
            }
        } catch (\Throwable) {
            $this->catatan = [];
        }
        $this->showTermsModal = true;
    }

    public function finalizeBooking(): void
    {
        if (!$this->termsAgreed) {
            $this->dispatch('toast', [
                'title' => 'Perlu persetujuan',
                'message' => 'Ceklist setuju syarat dan ketentuan terlebih dahulu',
                'type' => 'error',
            ]);
            return;
        }
        $this->showTermsModal = false;
        if (!Session::has('auth_token')) {
            $this->redirect('/login', navigate: true);
            return;
        }
        if (!$this->lapanganId || !$this->tanggal || !$this->selectedSlot || empty($this->selectedSlot['mulai']) || empty($this->selectedSlot['selesai'])) {
            $this->error = 'Data booking tidak lengkap';
            return;
        }

        sleep(1);

        $this->resetValidation();
        $validated = $this->validate();
        $jumlah = intval($validated['jumlahPemain']);
        $clicked = [
            'mulai' => (string) ($this->selectedSlot['mulai'] ?? ''),
            'selesai' => (string) ($this->selectedSlot['selesai'] ?? ''),
        ];
        $this->selectedSlot = $clicked;
        try {
            $this->fetchJadwal();
            $match = null;
            foreach ((array) $this->timeSlots as $s) {
                if (
                    (string) ($s['mulai'] ?? '') === (string) $clicked['mulai']
                    && (string) ($s['selesai'] ?? '') === (string) $clicked['selesai']
                ) {
                    $match = $s;
                    break;
                }
            }
            if (!$match || (string) ($match['status'] ?? '') !== 'tersedia') {
                $this->selectedSlot = null;
                $msg = (string) ($match['message'] ?? ($match['status_label'] ?? ($this->error ?? 'Jam sudah dibooking oleh pengguna lain')));
                $this->dispatch('toast', [
                    'title' => 'Tidak tersedia',
                    'message' => $msg,
                    'type' => 'error',
                ]);
                return;
            }
        } catch (\Throwable) {
        }
        $base = config('services.api.base_url');
        $url = rtrim((string) $base, '/') . '/v1/lapangan/bookingLapangan';
        try {
            $token = Session::get('auth_token');
            /** @var \Illuminate\Http\Client\Response $response */
            $response = Http::withToken($token)
                ->asForm()
                ->accept('application/json')
                ->post($url, [
                    'lapangan_id' => $this->lapanganId,
                    'tanggal' => $this->tanggal,
                    'jam_mulai' => (string) ($this->selectedSlot['mulai'] ?? ''),
                    'jam_selesai' => (string) ($this->selectedSlot['selesai'] ?? ''),
                    'nama_komunitas' => (string) ($validated['namaKomunitas'] ?? ''),
                    'jumlah_pemain' => $jumlah,
                    'kategori_pemain' => (string) $validated['kategoriPemain'],
                    'jenis_permainan' => (string) $validated['jenisPermainan'],
                    'keterangan' => (string) ($this->keterangan ?? ''),
                ]);
            $result = $response->json();
            if ($response->successful() && ($result['success'] ?? false)) {
                $this->error = null;
                $msg = (string) ($result['message'] ?? 'Booking berhasil');
                $this->bookingMessage = strip_tags($msg);
                $code = null;
                if (preg_match('/BK\-[0-9]{8}\-[A-Z0-9]+/i', $msg, $m)) {
                    $code = (string) ($m[0] ?? null);
                }
                $this->bookingCode = $code;
                $this->showSuccessModal = true;
                return;
            }
            $this->error = $result['message'] ?? 'Gagal melakukan booking';
            $this->dispatch('toast', [
                'title' => 'Gagal',
                'message' => $this->error,
                'type' => 'error',
            ]);
        } catch (\Throwable) {
            $this->error = 'Terjadi kesalahan saat melakukan booking';
            $this->dispatch('toast', [
                'title' => 'Gagal',
                'message' => $this->error,
                'type' => 'error',
            ]);
        }
    }
};
