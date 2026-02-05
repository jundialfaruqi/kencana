<?php

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

new #[Title('Update Jadwal Khusus')] #[Layout('layouts::admin.app')] class extends Component
{
    public int $id = 0;
    public bool $ready = false;
    public ?string $error = null;

    public array $arenas = [];
    public ?string $lapangan_id = null;
    public ?string $lapangan_nama = null;
    public ?string $tanggal = null;
    public ?string $tipe = null;
    public ?string $buka = null;
    public ?string $tutup = null;
    public ?string $keterangan = null;

    public function mount(int $id): void
    {
        $this->id = (int) $id;
    }

    public function load(): void
    {
        $this->ready = false;
        $this->fetchArenas();
        $this->fetchDetail();
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

    protected function fetchDetail(): void
    {
        try {
            $token = Session::get('auth_token');
            $base = rtrim((string) config('services.api.base_url'), '/');
            $url = $base . '/v1/master/jadwalKhusus';
            /** @var \Illuminate\Http\Client\Response $response */
            $response = Http::withToken($token)->accept('application/json')->get($url);
            $result = $response->json();
            if ($response->successful() && ($result['success'] ?? false)) {
                $list = (array) ($result['data'] ?? []);
                $item = null;
                foreach ($list as $row) {
                    if ((int) ($row['id'] ?? 0) === $this->id) {
                        $item = (array) $row;
                        break;
                    }
                }
                if ($item) {
                    $this->lapangan_id = isset($item['lapangan_id'])
                        ? (string) $item['lapangan_id']
                        : (string) data_get($item, 'lapangan.id');
                    $this->tanggal = substr((string) ($item['tanggal'] ?? ''), 0, 10) ?: null;
                    $this->tipe = (string) ($item['tipe'] ?? null) ?: null;
                    $this->buka = isset($item['buka']) && $item['buka'] ? substr((string) $item['buka'], 0, 5) : null;
                    $this->tutup = isset($item['tutup']) && $item['tutup'] ? substr((string) $item['tutup'], 0, 5) : null;
                    $this->keterangan = (string) ($item['keterangan'] ?? null) ?: null;
                    if ($this->lapangan_id) {
                        $this->fetchArenaById($this->lapangan_id);
                    }
                    $this->error = null;
                    return;
                }
                $this->error = 'Data tidak ditemukan';
                return;
            }
            $this->error = (string) ($result['message'] ?? 'Gagal memuat data');
        } catch (\Throwable) {
            $this->error = 'Terjadi kesalahan saat mengambil data';
        }
    }

    protected function fetchArenaById(string|int $id): void
    {
        try {
            $token = Session::get('auth_token');
            $base = rtrim((string) config('services.api.base_url'), '/');
            $url = $base . '/v1/master/lapangan/' . $id;
            /** @var \Illuminate\Http\Client\Response $response */
            $response = Http::withToken($token)->accept('application/json')->get($url);
            $result = $response->json();
            if ($response->successful() && ($result['success'] ?? false)) {
                $data = (array) ($result['data'] ?? []);
                $this->lapangan_nama = (string) ($data['nama_lapangan'] ?? null) ?: null;
                $exists = false;
                foreach ($this->arenas as $a) {
                    if ((string) ($a['id'] ?? '') === (string) $id) {
                        $exists = true;
                        break;
                    }
                }
                if (!$exists && !empty($data)) {
                    $this->arenas[] = $data;
                }
                return;
            }
        } catch (\Throwable) {
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
        $this->ready = false;
        $this->resetValidation();
        $validated = $this->validate();
        try {
            $token = Session::get('auth_token');
            $base = rtrim((string) config('services.api.base_url'), '/');
            $url = $base . '/v1/master/jadwalKhusus/' . $this->id;
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
            $response = Http::withToken($token)->asForm()->accept('application/json')->post($url, $payload);
            $result = $response->json();
            if ($response->successful() && ($result['success'] ?? false)) {
                $this->dispatch('toast', [
                    'title' => 'Berhasil',
                    'message' => (string) ($result['message'] ?? 'Jadwal khusus berhasil diperbarui'),
                    'type' => 'success',
                ]);
                $this->error = null;
                $this->ready = true;
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
            $this->error = (string) ($result['message'] ?? 'Gagal memperbarui jadwal khusus');
            $toastMessage = trim($this->error . (count($flatMessages) ? ' — ' . implode('; ', $flatMessages) : ''));
            $this->dispatch('toast', [
                'title' => 'Gagal',
                'message' => $toastMessage,
                'type' => 'error',
            ]);
        } catch (\Throwable) {
            $this->error = 'Terjadi kesalahan saat memperbarui jadwal khusus';
            $this->dispatch('toast', [
                'title' => 'Gagal',
                'message' => $this->error,
                'type' => 'error',
            ]);
        }
        $this->ready = true;
    }
};
