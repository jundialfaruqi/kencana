<?php

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

new #[Title('Buat Jadwal Khusus')] #[Layout('layouts::admin.app')] class extends Component
{
    public ?string $error = null;
    public bool $ready = false;

    public array $arenas = [];
    public ?string $lapangan_id = null;
    public ?string $tanggal = null;
    public ?string $buka = null;
    public ?string $tutup = null;
    public ?string $tipe = null;
    public ?string $keterangan = null;
    public ?int $httpStatus = null;

    public function load(): void
    {
        $this->fetchArenas();
        $this->ready = true;
    }

    protected function fetchArenas(): void
    {
        try {
            $token = Session::get('auth_token');
            $base = rtrim((string) config('services.api.base_url'), '/');
            $url = $base . '/v1/master/lapangan';
            /** @var \Illuminate\Http\Client\Response $response */
            $response = Http::withToken($token)->accept('application/json')->get($url);
            $result = $response->json();
            if ($response->successful() && ($result['success'] ?? false)) {
                $this->arenas = (array) ($result['data'] ?? []);
                $this->error = null;
                return;
            }
            $this->arenas = [];
            $this->error = (string) ($result['message'] ?? 'Gagal memuat daftar lapangan');
        } catch (\Throwable) {
            $this->arenas = [];
            $this->error = 'Terjadi kesalahan saat mengambil daftar lapangan';
        }
    }

    protected function rules(): array
    {
        $isLibur = ($this->tipe ?? '') === 'libur';
        $bukaRule = $isLibur ? ['nullable'] : ['required', 'date_format:H:i'];
        $tutupRule = $isLibur ? ['nullable'] : ['required', 'date_format:H:i'];
        return [
            'lapangan_id' => ['required'],
            'tanggal' => ['required', 'date_format:Y-m-d'],
            'tipe' => ['required', 'in:libur,event,tambahan'],
            'buka' => $bukaRule,
            'tutup' => $tutupRule,
            'keterangan' => ['nullable', 'string'],
        ];
    }

    protected function messages(): array
    {
        return [
            'lapangan_id.required' => 'Lapangan wajib dipilih',
            'tanggal.required' => 'Tanggal wajib diisi',
            'tanggal.date_format' => 'Format tanggal harus YYYY-MM-DD',
            'tipe.required' => 'Tipe wajib dipilih',
            'tipe.in' => 'Tipe tidak valid',
            'buka.required' => 'Jam buka wajib diisi',
            'buka.date_format' => 'Format jam buka harus HH:MM',
            'tutup.required' => 'Jam tutup wajib diisi',
            'tutup.date_format' => 'Format jam tutup harus HH:MM',
        ];
    }

    public function updatedTipe($value): void
    {
        $this->tipe = (string) ($value ?? '');
        if ($this->tipe === 'libur') {
            $this->buka = null;
            $this->tutup = null;
        }
    }

    public function submit(): void
    {
        $this->resetValidation();
        $validated = $this->validate();

        try {
            $token = Session::get('auth_token');
            $base = rtrim((string) config('services.api.base_url'), '/');
            $url = $base . '/v1/master/jadwalKhusus';
            $payload = [
                'lapangan_id' => (string) ($validated['lapangan_id'] ?? ''),
                'tanggal' => (string) ($validated['tanggal'] ?? ''),
                'tipe' => (string) ($validated['tipe'] ?? ''),
                'keterangan' => (string) ($validated['keterangan'] ?? ''),
            ];
            if (($validated['tipe'] ?? '') !== 'libur') {
                $payload['buka'] = (string) ($validated['buka'] ?? '');
                $payload['tutup'] = (string) ($validated['tutup'] ?? '');
            }
            /** @var \Illuminate\Http\Client\Response $response */
            $response = Http::withToken($token)
                ->asForm()
                ->accept('application/json')
                ->post($url, $payload);
            $result = $response->json();
            $this->httpStatus = $response->status();
            if ($response->successful() && ($result['success'] ?? false)) {
                $this->error = null;
                $this->dispatch('toast', [
                    'title' => 'Berhasil',
                    'message' => (string) ($result['message'] ?? 'Jadwal khusus berhasil dibuat'),
                    'type' => 'success',
                ]);
                $this->lapangan_id = null;
                $this->tanggal = null;
                $this->tipe = null;
                $this->buka = null;
                $this->tutup = null;
                $this->keterangan = null;
                return;
            }
            $errors = (array) ($result['errors'] ?? []);
            $flatMessages = [];
            foreach ($errors as $field => $messages) {
                foreach ((array) $messages as $msg) {
                    $this->addError((string) $field, (string) $msg);
                    $flatMessages[] = (string) $msg;
                }
            }
            $this->error = (string) ($result['message'] ?? 'Gagal membuat jadwal khusus');
            $toastMessage = trim($this->error . (count($flatMessages) ? ' — ' . implode('; ', $flatMessages) : ''));
            $this->dispatch('toast', [
                'title' => 'Gagal',
                'message' => $toastMessage,
                'type' => 'error',
            ]);
        } catch (\Throwable) {
            $this->error = 'Terjadi kesalahan saat membuat jadwal khusus';
            $this->httpStatus = null;
            $this->dispatch('toast', [
                'title' => 'Gagal',
                'message' => $this->error,
                'type' => 'error',
            ]);
        }
    }
};
