<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Attributes\Session as LivewireSession;
use Livewire\Attributes\Title;
use Livewire\Component;

/**
 * Komponen Pesan Lapangan untuk Android WebView
 *
 * Step 0 : Pilih Lapangan  ← tambahan vs booking publik
 * Step 1 : Pilih Tanggal
 * Step 2 : Pilih Jam
 * Step 3 : Isi Form & Konfirmasi (+ Terms modal)
 */
new #[Title('Pesan Lapangan')] #[Layout('layouts::android-webview.app')] class extends Component
{
    #[LivewireSession]
    public int $currentStep = 0;

    #[LivewireSession]
    public ?string $lapanganId = null;

    #[LivewireSession]
    public string $tanggal = '';

    #[LivewireSession]
    public string $namaLapangan = '';

    #[LivewireSession]
    public ?string $coverLapangan = null;

    public array $timeSlots = [];
    public ?string $error = null;
    public array $arenas = [];
    public bool $isLoadingArenas = false;

    #[LivewireSession]
    public ?array $selectedSlot = null;

    #[LivewireSession]
    public ?string $namaKomunitas = null;

    #[LivewireSession]
    public ?int $jumlahPemain = null;

    #[LivewireSession]
    public string $kategoriPemain = '';

    #[LivewireSession]
    public string $jenisPermainan = '';


    public bool $showSuccessModal = false;
    public bool $showErrorModal = false;
    public bool $showTermsModal = false;
    public bool $showCancelConfirm = false;
    public bool $showChangeArenaModal = false;
    public bool $termsAgreed = false;
    public ?string $bookingMessage = null;
    public ?string $bookingCode = null;
    public ?string $successNamaLapangan = null;
    public ?string $successTanggal = null;
    public ?array $successSelectedSlot = null;
    public array $catatan = [];
    public ?string $listJadwalStatus = null;

    // Calendar state
    public $calCurrLabel;
    public $calNextLabel;
    public $calCurrDays;
    public $calNextDays;
    public $calCurrStartDow;
    public $calNextStartDow;
    public $calCurrMonth;
    public $calNextMonth;
    public string $todayDate = '';
    public string $maxDate = '';
    public array $carouselDates = [];

    public function mount(): void
    {
        if (! Session::has('auth_token')) {
            $this->redirect(route('webview.expired'));
            return;
        }

        Carbon::setLocale('id');
        if (! $this->tanggal) {
            $this->tanggal = Carbon::now()->toDateString();
        }

        $today = Carbon::now();
        $curr  = $today->copy()->startOfMonth();
        $next  = $today->copy()->addMonthNoOverflow()->startOfMonth();

        $this->calCurrLabel     = $curr->translatedFormat('F Y');
        $this->calNextLabel     = $next->translatedFormat('F Y');
        $this->calCurrDays      = $curr->daysInMonth;
        $this->calNextDays      = $next->daysInMonth;
        $this->calCurrStartDow  = $curr->dayOfWeek;
        $this->calNextStartDow  = $next->dayOfWeek;
        $this->calCurrMonth     = $curr->format('Y-m');
        $this->calNextMonth     = $next->format('Y-m');
        $this->todayDate        = $today->toDateString();
        $this->maxDate          = $today->copy()->endOfMonth()->toDateString();

        $startOfMonth = $today->copy()->startOfMonth();
        for ($i = 0; $i < $today->daysInMonth; $i++) {
            $this->carouselDates[] = $startOfMonth->copy()->addDays($i)->toDateString();
        }

        // Tangkap parameter lapangan_id jika dikirim dari beranda
        $paramLapanganId = request()->query('lapangan_id') ?: request()->query('lapangan');
        if ($paramLapanganId) {
            $isNewArena = ! $this->lapanganId || ((string) $this->lapanganId !== (string) $paramLapanganId);
            $this->lapanganId = $paramLapanganId;
            $this->fetchArenas();
            foreach ($this->arenas as $a) {
                if ((string) ($a['id'] ?? '') === (string) $paramLapanganId) {
                    $this->namaLapangan  = $a['nama'] ?? ($a['nama_lapangan'] ?? '');
                    $this->coverLapangan = $a['image_cover'] ?? null;
                    break;
                }
            }

            if ($isNewArena) {
                // Arena baru dipilih dari menu/URL, mulai dari Step 0 (Pilih Tanggal)
                $this->currentStep  = 0;
                $this->selectedSlot = null;
            }
        } elseif ($this->lapanganId) {
            $this->fetchArenas();
        } else {
            // Tidak ada lapangan dipilih, redirect ke menu
            $this->redirect(route('webview.menu'), navigate: true);
            return;
        }

        // Validasi state step saat reload agar tidak stuck
        if ($this->currentStep === 2 && (! $this->selectedSlot || empty($this->selectedSlot['mulai']))) {
            $this->currentStep = 1;
        }
        if ($this->currentStep === 1 && (! $this->tanggal || ! $this->isDateValid($this->tanggal))) {
            $this->currentStep = 0;
        }

        // Muat jadwal jika sedang berada di Step 1 (Pilih Jam) atau Step 2 (Konfirmasi)
        if ($this->currentStep >= 1 && $this->lapanganId) {
            $this->fetchJadwal();
        }
    }

    // ── Helpers ────────────────────────────────────────────────────────────────

    protected function isDateValid(?string $dateStr): bool
    {
        if (empty($dateStr)) return false;
        try {
            $date        = Carbon::parse($dateStr)->startOfDay();
            $today       = Carbon::now()->startOfDay();
            $endOfMonth  = Carbon::now()->endOfMonth()->startOfDay();
            return $date->betweenIncluded($today, $endOfMonth);
        } catch (\Throwable) {
            return false;
        }
    }

    protected ?string $currentTimeStrCache = null;

    protected function getCurrentTimeStr(): string
    {
        if ($this->currentTimeStrCache === null) {
            $this->currentTimeStrCache = Carbon::now('Asia/Jakarta')->format('Y-m-d H:i');
        }
        return $this->currentTimeStrCache;
    }

    // ── Step Navigation ────────────────────────────────────────────────────────

    public function prevStep(): void
    {
        if ($this->currentStep > 0) {
            $this->currentStep--;
            if ($this->currentStep === 0) {
                // Kembali ke step 0 (Pilih Tanggal) — reset pilihan jam
                $this->timeSlots    = [];
                $this->selectedSlot = null;
                $this->error        = null;
            }
        } else {
            // Step 0: tanya apakah mau batal dan kembali ke menu
            $this->showCancelConfirm = true;
        }
    }

    public function openChangeArenaModal(): void
    {
        if (empty($this->arenas)) {
            $this->fetchArenas();
        }
        $this->showChangeArenaModal = true;
    }

    public function closeChangeArenaModal(): void
    {
        $this->showChangeArenaModal = false;
    }

    public function selectNewArena(string $id, string $nama, ?string $cover = null): void
    {
        $this->lapanganId     = $id;
        $this->namaLapangan   = $nama;
        $this->coverLapangan  = $cover;
        $this->selectedSlot   = null;
        $this->timeSlots      = [];
        $this->error          = null;
        $this->showChangeArenaModal = false;

        // Jika berada di step 1 (pilih jam) atau step 2 (konfirmasi), muat ulang jadwal
        if ($this->currentStep === 1) {
            $this->listJadwalStatus = 'loading';
            $this->dispatch('load-jadwal');
        } elseif ($this->currentStep === 2) {
            $this->currentStep = 1;
            $this->listJadwalStatus = 'loading';
            $this->dispatch('load-jadwal');
        }
    }

    public function cancelBooking()
    {
        $this->reset([
            'currentStep', 'lapanganId', 'tanggal', 'namaLapangan', 'coverLapangan',
            'selectedSlot', 'namaKomunitas', 'jumlahPemain',
            'kategoriPemain', 'jenisPermainan',
        ]);
        return $this->redirect(route('webview.menu'), navigate: true);
    }

    public function closeCancelConfirm(): void
    {
        $this->showCancelConfirm = false;
    }

    // Step 0 → 1 : pilih lapangan
    public function selectArena(string $id, string $nama, ?string $cover = null): void
    {
        $this->lapanganId     = $id;
        $this->namaLapangan   = $nama;
        $this->coverLapangan  = $cover;
        $this->timeSlots      = [];
        $this->selectedSlot   = null;
        $this->error          = null;
        $this->currentStep    = 1;
    }

    public function getCoverUrlProperty(): ?string
    {
        if ($this->coverLapangan) {
            $cover = ltrim((string) $this->coverLapangan, '/');
            return preg_match('/^https?:\/\//', $cover) ? $cover : rtrim(config('services.api.image_base_url'), '/') . '/' . $cover;
        }
        if ($this->lapanganId && !empty($this->arenas)) {
            foreach ($this->arenas as $a) {
                if ((string)($a['id'] ?? '') === (string)$this->lapanganId) {
                    $cover = ltrim((string) ($a['image_cover'] ?? ''), '/');
                    return !empty($cover) ? (preg_match('/^https?:\/\//', $cover) ? $cover : rtrim(config('services.api.image_base_url'), '/') . '/' . $cover) : null;
                }
            }
        }
        return null;
    }

    // Step 0 → 1 : pilih tanggal dari client Alpine.js, maju ke pilih jam
    public function proceedToTimeSlots(?string $date = null): void
    {
        if ($date && $this->isDateValid($date)) {
            $this->tanggal      = $date;
            $this->selectedSlot = null;
        }

        if (! $this->tanggal || ! $this->isDateValid($this->tanggal)) {
            $this->dispatch('toast', ['title' => 'Gagal', 'message' => 'Pilih tanggal yang valid', 'type' => 'error']);
            return;
        }

        $this->currentStep = 1;
        $this->listJadwalStatus = 'loading';
        $this->dispatch('load-jadwal');
    }

    public function nextStep(?string $date = null): void
    {
        if ($this->currentStep === 0) {
            $this->proceedToTimeSlots($date);
        }
    }

    // Step 2 → 3: konfirmasi jam dari client Alpine.js
    public function proceedToConfirmation(string $slotKey): void
    {
        if (empty($slotKey)) {
            $this->dispatch('toast', ['title' => 'Gagal', 'message' => 'Pilih jam bermain terlebih dahulu', 'type' => 'error']);
            return;
        }

        $parts = explode('-', $slotKey, 2);
        if (count($parts) !== 2) {
            $this->dispatch('toast', ['title' => 'Gagal', 'message' => 'Format jam tidak valid', 'type' => 'error']);
            return;
        }

        [$mulai, $selesai] = $parts;
        $clicked = ['mulai' => $mulai, 'selesai' => $selesai];
        $this->selectedSlot = $clicked;

        $match = null;
        foreach ((array) $this->timeSlots as $s) {
            if ((string) ($s['mulai'] ?? '') === $mulai && (string) ($s['selesai'] ?? '') === $selesai) {
                $match = $s;
                break;
            }
        }

        if (! $match || (string) ($match['status'] ?? '') !== 'tersedia' || ! $this->slotIsAvailable($match)) {
            $this->selectedSlot = null;
            $msg = (string) ($match['message'] ?? ($match['status_label'] ?? ($this->error ?? 'Jam tidak tersedia')));
            $this->dispatch('toast', ['title' => 'Tidak tersedia', 'message' => $msg, 'type' => 'error']);
            return;
        }

        $this->currentStep = 2;
    }

    public function selectDate(string $date): void
    {
        if (! $this->isDateValid($date)) return;
        $this->tanggal      = $date;
        $this->selectedSlot = null;
    }

    // ── Arena & Jadwal Fetching ────────────────────────────────────────────────

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
                $this->error  = null;
            } else {
                $this->arenas = [];
                $this->error  = $json['message'] ?? 'Gagal memuat daftar arena';
            }
        } catch (\Throwable) {
            $this->arenas = [];
            $this->error  = 'Terjadi kesalahan saat mengambil daftar arena';
        }
    }

    protected function fetchJadwal(): void
    {
        if (! $this->lapanganId) {
            $this->timeSlots       = [];
            $this->listJadwalStatus = null;
            return;
        }
        $url = rtrim((string) config('services.api.base_url'), '/') . '/v1/lapangan/listJadwal';
        try {
            $token = Session::get('auth_token');
            $response = Http::withOptions(['verify' => filter_var(config('services.api.verify_ssl', true), FILTER_VALIDATE_BOOLEAN)])
                ->withToken($token)->asForm()->accept('application/json')
                ->post($url, ['tanggal' => $this->tanggal, 'lapangan_id' => $this->lapanganId]);
            $json = $response->json();
            if ($response->successful() && ($json['success'] ?? false)) {
                $data  = $json['data'] ?? [];
                $first = $data[0] ?? null;
                $this->namaLapangan     = $first['nama_lapangan'] ?? '';
                $this->listJadwalStatus = (string) ($first['status'] ?? ($first['tipe'] ?? ''));
                $slots = (array) ($first['slots'] ?? []);
                $this->timeSlots = array_map(fn($s) => [
                    'mulai'   => (string) ($s['mulai'] ?? ($s['jam_mulai'] ?? '')),
                    'selesai' => (string) ($s['selesai'] ?? ($s['jam_selesai'] ?? '')),
                    'status'  => (string) ($s['status'] ?? ''),
                ] + (array) $s, $slots);
                $this->error = null;
            } else {
                $this->error            = $json['message'] ?? 'Gagal memuat jadwal';
                $this->listJadwalStatus = null;
            }
        } catch (\Throwable) {
            $this->error            = 'Terjadi kesalahan saat memuat jadwal';
            $this->listJadwalStatus = null;
        }
        $this->dispatch('booking-loaded');
    }

    #[On('load-jadwal')]
    public function loadJadwalAfterSelection(): void
    {
        $this->fetchJadwal();
    }

    // ── Slot Helpers ──────────────────────────────────────────────────────────

    public function slotIsAvailable(array $slot): bool
    {
        if (($slot['status'] ?? '') !== 'tersedia') return false;
        $slotTimeStr = "{$this->tanggal} {$slot['mulai']}";
        return $slotTimeStr > $this->getCurrentTimeStr();
    }

    public function slotIsSelected(array $slot): bool
    {
        return $this->selectedSlot
            && (($this->selectedSlot['mulai'] ?? null) === ($slot['mulai'] ?? null))
            && (($this->selectedSlot['selesai'] ?? null) === ($slot['selesai'] ?? null));
    }

    public function getSlotDisplayStatus(array $slot): string
    {
        $slotTimeStr = "{$this->tanggal} {$slot['mulai']}";
        if ($slotTimeStr <= $this->getCurrentTimeStr()) return 'Tidak Tersedia';
        return $slot['status'] ?? '';
    }

    public function arenaIsComing(array $arena): bool
    {
        return ($arena['status'] ?? '') === 'coming_soon';
    }

    // ── Booking Confirmation ──────────────────────────────────────────────────

    protected function rules(): array
    {
        return [
            'namaKomunitas'  => ['nullable', 'string'],
            'jumlahPemain'   => ['required', 'integer', 'min:1'],
            'kategoriPemain' => ['required', 'in:anak-anak,remaja,dewasa'],
            'jenisPermainan' => ['required', 'in:fun_match,latihan,turnamen_kecil'],
        ];
    }

    protected function messages(): array
    {
        return [
            'jumlahPemain.required'   => 'Jumlah pemain wajib diisi',
            'jumlahPemain.integer'    => 'Jumlah pemain harus berupa angka',
            'jumlahPemain.min'        => 'Jumlah pemain minimal 1',
            'kategoriPemain.required' => 'Kategori pemain wajib dipilih',
            'kategoriPemain.in'       => 'Kategori pemain tidak valid',
            'jenisPermainan.required' => 'Jenis permainan wajib dipilih',
            'jenisPermainan.in'       => 'Jenis permainan tidak valid',
        ];
    }

    public function updatedJumlahPemain($value): void
    {
        $digits = preg_replace('/\D/', '', (string) $value);
        $this->jumlahPemain = is_numeric($digits) ? intval($digits) : null;
    }

    public function confirmBooking(): void
    {
        if (! Session::has('auth_token')) { $this->redirect(route('webview.expired')); return; }
        if (! $this->lapanganId)          { $this->error = 'Arena belum dipilih'; return; }
        if (! $this->isDateValid($this->tanggal)) { $this->error = 'Tanggal tidak valid'; return; }
        if (! $this->selectedSlot || empty($this->selectedSlot['mulai'])) { $this->error = 'Jam belum dipilih'; return; }

        $this->error = null;
        $this->resetValidation();
        $this->validate();

        $this->termsAgreed = false;
        $this->catatan     = [];

        try {
            $url = rtrim((string) config('services.api.base_url'), '/') . '/v1/catatan/' . $this->lapanganId;
            $response = Http::withOptions(['verify' => filter_var(config('services.api.verify_ssl', true), FILTER_VALIDATE_BOOLEAN)])
                ->withToken(Session::get('auth_token'))->accept('application/json')->get($url);
            $json = $response->json();
            if ($response->successful() && ($json['success'] ?? false)) {
                $this->catatan = (array) ($json['data'] ?? []);
            }
        } catch (\Throwable) {}

        $this->showTermsModal = true;
    }

    public function finalizeBooking(): void
    {
        $this->showTermsModal = false;
        if (! Session::has('auth_token')) { $this->redirect(route('webview.expired')); return; }
        if (! $this->lapanganId || ! $this->tanggal || ! $this->selectedSlot) { $this->error = 'Data tidak lengkap'; return; }

        $this->resetValidation();
        $validated = $this->validate();
        $clicked   = ['mulai' => (string) ($this->selectedSlot['mulai'] ?? ''), 'selesai' => (string) ($this->selectedSlot['selesai'] ?? '')];
        $this->selectedSlot = $clicked;

        $url = rtrim((string) config('services.api.base_url'), '/') . '/v1/lapangan/bookingLapangan';
        try {
            $response = Http::withOptions(['verify' => filter_var(config('services.api.verify_ssl', true), FILTER_VALIDATE_BOOLEAN)])
                ->withToken(Session::get('auth_token'))->asForm()->accept('application/json')
                ->post($url, [
                    'lapangan_id'     => $this->lapanganId,
                    'tanggal'         => $this->tanggal,
                    'jam_mulai'       => $clicked['mulai'],
                    'jam_selesai'     => $clicked['selesai'],
                    'nama_komunitas'  => (string) ($validated['namaKomunitas'] ?? ''),
                    'jumlah_pemain'   => intval($validated['jumlahPemain']),
                    'kategori_pemain' => (string) $validated['kategoriPemain'],
                    'jenis_permainan' => (string) $validated['jenisPermainan'],
                ]);

            $result = $response->json();
            if ($response->successful() && ($result['success'] ?? false)) {
                $msg  = (string) ($result['message'] ?? 'Booking berhasil');
                $code = null;
                if (preg_match('/BK\-[0-9]{8}\-[A-Z0-9]+/i', $msg, $m)) {
                    $code = $m[0];
                }
                $this->bookingMessage        = strip_tags($msg);
                $this->bookingCode           = $code;
                $this->successNamaLapangan   = $this->namaLapangan;
                $this->successTanggal        = $this->tanggal;
                $this->successSelectedSlot   = $this->selectedSlot;

                $this->reset(['currentStep', 'lapanganId', 'tanggal', 'namaLapangan', 'selectedSlot', 'namaKomunitas', 'jumlahPemain', 'kategoriPemain', 'jenisPermainan']);
                $this->showSuccessModal = true;
                return;
            }
            $this->error          = $result['message'] ?? 'Gagal melakukan booking';
            $this->showErrorModal = true;
        } catch (\Throwable) {
            $this->error          = 'Terjadi kesalahan saat melakukan booking';
            $this->showErrorModal = true;
        }
    }

    public function handleErrorClose(): void
    {
        $this->reset(['currentStep', 'lapanganId', 'tanggal', 'namaLapangan', 'selectedSlot', 'namaKomunitas', 'jumlahPemain', 'kategoriPemain', 'jenisPermainan']);
        $this->showErrorModal = false;
        $this->redirect(route('webview.menu'), navigate: true);
    }

    public function render()
    {
        return view('components.android-webview.pesan.pesan');
    }
};
