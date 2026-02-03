<?php

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

new #[Title('Update Jadwal Operasional')] #[Layout('layouts::admin.app')] class extends Component
{
    public $id = null;

    public bool $ready = false;
    public ?string $error = null;
    public ?int $httpStatus = null;

    public ?string $lapangan_nama = null;
    public ?string $lapangan_id = null;
    public ?string $hari_label = null;
    public ?string $hari = null;
    public ?string $buka = null;
    public ?string $tutup = null;
    public bool $is_active = true;
    public array $arenas = [];

    public function mount(?string $id = null): void
    {
        if ($id !== null) {
            $this->id = $id;
        }
    }

    public function load(): void
    {
        $this->fetchArenas();
        $this->fetch();
        $this->ready = true;
    }

    protected function fetch(): void
    {
        try {
            $token = Session::get('auth_token');
            $base = rtrim(config('services.api.base_url'), '/');
            $id = intval($this->id ?? 0);
            if ($id <= 0) {
                $this->error = 'ID jadwal tidak valid';
                return;
            }
            $detailUrl = $base . '/v1/master/jadwal/' . $id;
            /** @var \Illuminate\Http\Client\Response $response */
            $response = Http::withToken($token)->accept('application/json')->get($detailUrl);
            $json = $response->json();
            if ($response->successful() && ($json['success'] ?? false)) {
                $raw = $json['data'] ?? [];
                $item = null;
                if (is_array($raw)) {
                    if (isset($raw['id'])) {
                        $item = $raw;
                    } elseif (isset($raw[0]) && is_array($raw[0])) {
                        foreach ($raw as $row) {
                            $iid = intval(data_get($row, 'id', 0));
                            if ($iid === $id) {
                                $item = $row;
                                break;
                            }
                        }
                        if ($item === null) {
                            $item = $raw[0];
                        }
                    }
                }
                if (is_array($item)) {
                    $this->lapangan_nama = (string) data_get($item, 'lapangan.nama_lapangan', '-');
                    $this->lapangan_id = (string) (data_get($item, 'lapangan_id') ?? data_get($item, 'lapangan.id'));
                    $this->hari_label = (string) ($item['hari_label'] ?? '-');
                    $this->hari = (string) ($item['hari'] ?? null);
                    $this->buka = substr((string) ($item['buka'] ?? ''), 0, 5);
                    $this->tutup = substr((string) ($item['tutup'] ?? ''), 0, 5);
                    $this->is_active = (bool) ($item['is_active'] ?? true);
                    $this->error = null;
                    return;
                }
            }
            $listUrl = $base . '/v1/master/jadwal';
            /** @var \Illuminate\Http\Client\Response $listResp */
            $listResp = Http::withToken($token)->accept('application/json')->get($listUrl);
            $listJson = $listResp->json();
            if ($listResp->successful() && ($listJson['success'] ?? false)) {
                $items = (array) ($listJson['data'] ?? []);
                foreach ($items as $it) {
                    $iid = intval(data_get($it, 'id', 0));
                    if ($iid === $id) {
                        $this->lapangan_nama = (string) data_get($it, 'lapangan.nama_lapangan', '-');
                        $this->lapangan_id = (string) (data_get($it, 'lapangan_id') ?? data_get($it, 'lapangan.id'));
                        $this->hari_label = (string) ($it['hari_label'] ?? '-');
                        $this->hari = (string) ($it['hari'] ?? null);
                        $this->buka = substr((string) ($it['buka'] ?? ''), 0, 5);
                        $this->tutup = substr((string) ($it['tutup'] ?? ''), 0, 5);
                        $this->is_active = (bool) ($it['is_active'] ?? true);
                        $this->error = null;
                        return;
                    }
                }
            }
            $this->error = 'Gagal memuat detail jadwal';
        } catch (\Throwable) {
            $this->error = 'Terjadi kesalahan saat mengambil data jadwal';
        }
    }

    protected function fetchArenas(): void
    {
        try {
            $token = Session::get('auth_token');
            $base = rtrim(config('services.api.base_url'), '/');
            $url = $base . '/v1/master/lapangan';
            /** @var \Illuminate\Http\Client\Response $response */
            $response = Http::withToken($token)->accept('application/json')->get($url);
            $json = $response->json();
            if ($response->successful() && ($json['success'] ?? false)) {
                $this->arenas = (array) ($json['data'] ?? []);
                return;
            }
            $this->arenas = [];
        } catch (\Throwable) {
            $this->arenas = [];
        }
    }

    public function updatedLapanganId($value): void
    {
        $id = (string) ($value ?? '');
        $this->lapangan_id = $id;
        foreach ((array) $this->arenas as $a) {
            $aid = (string) ($a['id'] ?? '');
            if ($aid === $id) {
                $this->lapangan_nama = (string) ($a['nama_lapangan'] ?? '-');
                break;
            }
        }
    }

    public function updatedHari($value): void
    {
        $map = [
            '0' => 'Minggu',
            '1' => 'Senin',
            '2' => 'Selasa',
            '3' => 'Rabu',
            '4' => 'Kamis',
            '5' => 'Jumat',
            '6' => 'Sabtu',
        ];
        $key = (string) ($value ?? '');
        $this->hari = $key;
        $this->hari_label = $map[$key] ?? $this->hari_label;
    }
    protected function rules(): array
    {
        return [
            'hari' => ['required', 'in:0,1,2,3,4,5,6'],
            'buka' => ['required', 'date_format:H:i'],
            'tutup' => ['required', 'date_format:H:i'],
        ];
    }

    protected function messages(): array
    {
        return [
            'hari.required' => 'Hari wajib diisi',
            'hari.in' => 'Hari tidak valid',
            'buka.required' => 'Jam buka wajib diisi',
            'buka.date_format' => 'Format jam buka harus HH:MM',
            'tutup.required' => 'Jam tutup wajib diisi',
            'tutup.date_format' => 'Format jam tutup harus HH:MM',
        ];
    }

    public function submit(): void
    {
        $this->resetValidation();
        $validated = $this->validate();
        try {
            $token = Session::get('auth_token');
            $base = rtrim(config('services.api.base_url'), '/');
            $id = intval($this->id ?? 0);
            if ($id <= 0) {
                $this->error = 'ID jadwal tidak valid';
                return;
            }
            $url = $base . '/v1/master/jadwal/' . $id;
            /** @var \Illuminate\Http\Client\Response $response */
            $response = Http::withToken($token)
                ->asForm()
                ->accept('application/json')
                ->post($url, [
                    'lapangan_id' => intval($this->lapangan_id ?? 0),
                    'hari' => intval($this->hari ?? -1),
                    'buka' => (string) ($validated['buka'] ?? ''),
                    'tutup' => (string) ($validated['tutup'] ?? ''),
                    'is_active' => $this->is_active ? 1 : 0,
                ]);
            $result = $response->json();
            $this->httpStatus = $response->status();
            if ($response->successful() && ($result['success'] ?? false)) {
                $this->error = null;
                $this->dispatch('toast', [
                    'title' => 'Berhasil',
                    'message' => (string) ($result['message'] ?? 'Jadwal operasional berhasil diperbarui'),
                    'type' => 'success',
                ]);
                $this->fetch();
                return;
            }
            $flatMessages = [];
            $errors = (array) ($result['errors'] ?? []);
            foreach ($errors as $msgs) {
                foreach ((array) $msgs as $msg) {
                    $flatMessages[] = (string) $msg;
                }
            }
            $this->error = (string) ($result['message'] ?? 'Gagal memperbarui jadwal operasional');
            $toastMessage = trim($this->error . (count($flatMessages) ? ' — ' . implode('; ', $flatMessages) : ''));
            $this->dispatch('toast', [
                'title' => 'Gagal',
                'message' => $toastMessage,
                'type' => 'error',
            ]);
        } catch (\Throwable) {
            $this->error = 'Terjadi kesalahan saat mengirim data';
            $this->dispatch('toast', [
                'title' => 'Gagal',
                'message' => $this->error,
                'type' => 'error',
            ]);
        }
    }
};
