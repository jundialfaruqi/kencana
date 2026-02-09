<?php

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Client\Response;

new #[Title('Banner Carousel Create')] #[Layout('layouts::admin.app')] class extends Component
{
    use WithFileUploads;

    public ?string $error = null;

    public string $judul = '';
    public string $kategori = '';
    public string $deskripsi = '';
    public $image = null;
    public array $availableKategoriBanner = [];
    public ?string $selectedKategoriBanner = null;

    public function mount(): void
    {
        $this->fetchKategoriBanner();
    }

    protected function rules(): array
    {
        return [
            'judul' => ['required', 'string', 'min:1'],
            'kategori' => ['required', 'string', 'min:1'],
            'deskripsi' => ['required', 'string', 'min:1'],
            'image' => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:2000'],
        ];
    }

    public function fetchKategoriBanner(): void
    {
        try {
            $token = Session::get('auth_token');
            $base = rtrim((string) config('services.api.base_url'), '/');
            $url = $base . '/v1/master/slider';

            /** @var Response $response */
            $response = Http::withToken($token)->get($url);
            $json = $response->json();

            if ($response->successful() && ($json['success'] ?? false)) {
                $this->availableKategoriBanner = collect($json['data'] ?? [])->pluck('kategori')->unique()->toArray();
            } else {
                $this->availableKategoriBanner = [];
            }
        } catch (\Throwable) {
            $this->availableKategoriBanner = [];
        }
    }

    public function selectKategoriBanner(string $value): void
    {
        if ($this->selectedKategoriBanner === $value) {
            $this->selectedKategoriBanner = null;
            $this->kategori = '';
        } else {
            $this->selectedKategoriBanner = $value;
            $this->kategori = $value;
        }
    }

    public function cancel(): void
    {
        $this->redirect('/banner-carousel', navigate: true);
    }

    public function submit(): void
    {
        $this->resetValidation();
        $validated = $this->validate();

        try {
            $token = Session::get('auth_token');
            $base = rtrim((string) config('services.api.base_url'), '/');
            $url = $base . '/v1/master/slider';

            $request = Http::asMultipart()->withToken($token)->accept('application/json');
            if ($this->image) {
                $request = $request->attach(
                    'image',
                    fopen($this->image->getRealPath(), 'r'),
                    $this->image->getClientOriginalName()
                );
            }
            /** @var Response $response */
            $response = $request->post($url, [
                'judul' => (string) ($validated['judul'] ?? ''),
                'kategori' => (string) ($validated['kategori'] ?? ''),
                'deskripsi' => (string) ($validated['deskripsi'] ?? ''),
            ]);
            $json = $response->json();
            if ($response->successful() && ($json['success'] ?? false)) {
                $this->error = null;
                $payload = [
                    'title' => 'Sukses',
                    'message' => 'Banner berhasil dibuat',
                    'type' => 'success',
                ];
                $this->dispatch('set-pending-toast', $payload);
                $this->redirect('/banner-carousel', navigate: true);
                $this->fetchKategoriBanner(); // Panggil setelah berhasil menyimpan
                return;
            }
            $this->error = (string) ($json['message'] ?? 'Gagal membuat banner');
        } catch (\Throwable) {
            $this->error = 'Terjadi kesalahan saat membuat banner';
        }
    }
};
