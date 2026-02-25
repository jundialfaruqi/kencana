<?php

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

new #[Title('Ubah Catatan')] #[Layout('layouts::admin.app')] class extends Component
{
    public $id;

    public ?string $error = null;
    public bool $ready = false;
    public ?int $httpStatus = null;

    public array $arenas = [];
    public array $availableKategoriCatatan = [];
    public ?string $selectedKategoriCatatan = null;

    public ?string $lapangan_id = null;
    public ?string $kategori_catatan = null;
    public ?string $catatan = null;

    public function mount($id = null): void
    {
        if ($id !== null && $id !== '') {
            $this->id = $id;
        } elseif ($this->id === null) {
            $this->id = request()->query('id');
        }
    }

    public function load(): void
    {
        $this->fetchArenas();
        $this->fetchKategoriCatatan();
        $this->fetchNote();
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

    protected function fetchKategoriCatatan(): void
    {
        try {
            $token = Session::get('auth_token');
            $base = rtrim((string) config('services.api.base_url'), '/');
            $url = $base . '/v1/master/catatan';
            /** @var \Illuminate\Http\Client\Response $response */
            $response = Http::withToken($token)->accept('application/json')->get($url);
            $result = $response->json();
            if ($response->successful() && ($result['success'] ?? false)) {
                $categories = collect($result['data'] ?? [])->pluck('kategori_catatan')->unique()->sort()->values()->all();
                $this->availableKategoriCatatan = $categories;
                $this->error = null;
                return;
            }
            $this->availableKategoriCatatan = [];
            $this->error = (string) ($result['message'] ?? 'Gagal memuat daftar kategori catatan');
        } catch (\Throwable) {
            $this->availableKategoriCatatan = [];
            $this->error = 'Terjadi kesalahan saat mengambil daftar kategori catatan';
        }
    }

    protected function fetchNote(): void
    {
        try {
            $token = Session::get('auth_token');
            $base = rtrim((string) config('services.api.base_url'), '/');
            $url = $base . '/v1/master/catatan/' . $this->id;
            /** @var \Illuminate\Http\Client\Response $response */
            $response = Http::withToken($token)->accept('application/json')->get($url);
            $result = $response->json();
            if ($response->successful() && ($result['success'] ?? false)) {
                $data = (array) ($result['data'] ?? []);
                $this->lapangan_id = (string) ($data['lapangan_id'] ?? '');
                $this->kategori_catatan = (string) ($data['kategori_catatan'] ?? '');
                $this->catatan = (string) ($data['catatan'] ?? '');
                $this->selectedKategoriCatatan = null;
                $this->error = null;
                return;
            }
            $this->error = (string) ($result['message'] ?? 'Gagal memuat detail catatan');
        } catch (\Throwable) {
            $this->error = 'Terjadi kesalahan saat mengambil detail catatan';
        }
    }

    public function selectKategoriCatatan(?string $value): void
    {
        if ($this->selectedKategoriCatatan === $value) {
            $this->selectedKategoriCatatan = null;
            $this->kategori_catatan = null;
        } else {
            $this->selectedKategoriCatatan = $value;
            $this->kategori_catatan = $value;
        }
    }

    protected function rules(): array
    {
        return [
            'lapangan_id' => ['required'],
            'kategori_catatan' => ['required', 'string'],
            'catatan' => ['required', 'string'],
        ];
    }

    protected function messages(): array
    {
        return [
            'lapangan_id.required' => 'Lapangan wajib dipilih',
            'kategori_catatan.required' => 'Kategori catatan wajib diisi',
            'catatan.required' => 'Isi catatan wajib diisi',
        ];
    }

    public function submit(): void
    {
        $this->resetValidation();
        $validated = $this->validate();

        try {
            $token = Session::get('auth_token');
            $base = rtrim((string) config('services.api.base_url'), '/');
            $url = $base . '/v1/master/catatan/' . $this->id;
            /** @var \Illuminate\Http\Client\Response $response */
            $response = Http::withToken($token)
                ->asForm()
                ->accept('application/json')
                ->post($url, [
                    'lapangan_id' => (string) ($validated['lapangan_id'] ?? ''),
                    'kategori_catatan' => (string) ($validated['kategori_catatan'] ?? ''),
                    'catatan' => (string) ($validated['catatan'] ?? ''),
                ]);
            $result = $response->json();
            $this->httpStatus = $response->status();
            if ($response->successful() && ($result['success'] ?? false)) {
                $this->error = null;
                $this->dispatch('toast', [
                    'title' => 'Berhasil',
                    'message' => (string) ($result['message'] ?? 'Catatan berhasil diperbarui'),
                    'type' => 'success',
                ]);
                $this->fetchKategoriCatatan();
                $this->fetchNote();
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
            $this->error = (string) ($result['message'] ?? 'Gagal memperbarui catatan');
            $toastMessage = trim($this->error . (count($flatMessages) ? ' — ' . implode('; ', $flatMessages) : ''));
            $this->dispatch('toast', [
                'title' => 'Gagal',
                'message' => $toastMessage,
                'type' => 'error',
            ]);
        } catch (\Throwable) {
            $this->error = 'Terjadi kesalahan saat memperbarui catatan';
            $this->httpStatus = null;
            $this->dispatch('toast', [
                'title' => 'Gagal',
                'message' => $this->error,
                'type' => 'error',
            ]);
        }
    }
};
