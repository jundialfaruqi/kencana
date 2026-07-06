<?php

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

new #[Title('Buat Jadwal Operasional')] #[Layout('layouts::admin.app')] class extends Component
{
    public ?string $error = null;

    public array $arenas = [];

    public ?string $lapangan_id = null;

    public ?string $hari = null;

    public ?string $buka = null;

    public ?string $tutup = null;

    public ?int $httpStatus = null;

    public function mount(): void
    {
        $this->fetchArenas();
    }

    protected function fetchArenas(): void
    {
        try {
            $token = Session::get('auth_token');
            $base = rtrim(config('services.api.base_url'), '/');
            $url = $base.'/v1/master/lapangan';
            /** @var \Illuminate\Http\Client\Response $response */
            $response = Http::withOptions(['verify' => filter_var(config('services.api.verify_ssl', true), FILTER_VALIDATE_BOOLEAN)])->withToken($token)->accept('application/json')->get($url);
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
        return [
            'lapangan_id' => ['required'],
            'hari' => ['required', 'in:0,1,2,3,4,5,6'],
            'buka' => ['required', 'date_format:H:i'],
            'tutup' => ['required', 'date_format:H:i'],
        ];
    }

    protected function messages(): array
    {
        return [
            'lapangan_id.required' => 'Lapangan wajib dipilih',
            'hari.required' => 'Hari wajib dipilih',
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
            $url = $base.'/v1/master/jadwal';
            /** @var \Illuminate\Http\Client\Response $response */
            $response = Http::withOptions(['verify' => filter_var(config('services.api.verify_ssl', true), FILTER_VALIDATE_BOOLEAN)])->withToken($token)
                ->asForm()
                ->accept('application/json')
                ->post($url, [
                    'lapangan_id' => (string) ($validated['lapangan_id'] ?? ''),
                    'hari' => (string) ($validated['hari'] ?? ''),
                    'buka' => (string) ($validated['buka'] ?? ''),
                    'tutup' => (string) ($validated['tutup'] ?? ''),
                ]);
            $result = $response->json();
            $this->httpStatus = $response->status();
            if ($response->successful() && ($result['success'] ?? false)) {
                $this->error = null;
                $this->dispatch('set-pending-toast', [
                    'title' => 'Berhasil',
                    'message' => (string) ($result['message'] ?? 'Jadwal operasional berhasil dibuat'),
                    'type' => 'success',
                ]);
                $this->redirect('/manajemen-jadwal-operasional', navigate: true);

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
            $this->error = (string) ($result['message'] ?? 'Gagal membuat jadwal operasional');
            $toastMessage = trim($this->error.(count($flatMessages) ? ' — '.implode('; ', $flatMessages) : ''));
            $this->dispatch('toast', [
                'title' => 'Gagal',
                'message' => $toastMessage,
                'type' => 'error',
            ]);
        } catch (\Throwable) {
            $this->error = 'Terjadi kesalahan saat membuat jadwal operasional';
            $this->httpStatus = null;
            $this->dispatch('toast', [
                'title' => 'Gagal',
                'message' => $this->error,
                'type' => 'error',
            ]);
        }
    }
};
