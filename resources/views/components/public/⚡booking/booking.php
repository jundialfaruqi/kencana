<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Url;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

new #[Layout('layouts::public.app')] #[Title('Pesan Arena')] class extends Component
{
    #[Url(as: 'lapangan_id')]
    public $lapanganId;
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

    public function load()
    {
        if (!Session::has('auth_token')) {
            $this->redirect('/login', navigate: true);
            return;
        }

        $this->tanggal = Carbon::now()->toDateString();
        if ($this->lapanganId) {
            if (!$this->isArenaOpen((string) $this->lapanganId)) {
                $this->error = 'Arena belum dibuka';
                $this->lapanganId = null;
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
            $this->namaLapangan = '';
            $this->timeSlots = [];
            $this->fetchArenas();
            $this->dispatch('booking-loaded');
            return;
        }
        $this->lapanganId = $id;
        $this->namaLapangan = $nama;
        $this->fetchJadwal();
    }

    public function selectTime(string $mulai, string $selesai): void
    {
        $this->selectedSlot = [
            'mulai' => $mulai,
            'selesai' => $selesai,
        ];
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
            $this->error = 'Silakan pilih arena';
            return;
        }
        if (!$this->tanggal) {
            $this->error = 'Silakan pilih tanggal';
            return;
        }
        if (!$this->selectedSlot || empty($this->selectedSlot['mulai']) || empty($this->selectedSlot['selesai'])) {
            $this->error = 'Silakan pilih waktu';
            return;
        }
        $this->error = null;

        $this->resetValidation();
        $validated = $this->validate();
        $jumlah = intval($validated['jumlahPemain']);

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

    public function closeSuccessModal(): void
    {
        $this->showSuccessModal = false;
        $this->bookingMessage = null;
        $this->bookingCode = null;
        $this->error = null;
        $this->lapanganId = null;
        $this->namaLapangan = '';
        $this->selectedSlot = null;
        $this->namaKomunitas = null;
        $this->jumlahPemain = null;
        $this->kategoriPemain = '';
        $this->jenisPermainan = '';
        $this->keterangan = null;
        $this->timeSlots = [];
        $this->fetchArenas();
        $this->dispatch('booking-loaded');
    }
};
