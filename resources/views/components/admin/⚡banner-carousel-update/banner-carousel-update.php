<?php

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Client\Response;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

new #[Title('Update Banner Carousel')] #[Layout('layouts::admin.app')] class extends Component
{
    use WithFileUploads;

    public $id = null;
    public bool $ready = false;
    public ?string $error = null;

    public string $judul = '';
    public string $kategori = '';
    public string $deskripsi = '';
    public $image = null;
    public ?string $imageUrl = null;

    protected function rules(): array
    {
        return [
            'judul' => ['required', 'string', 'min:1'],
            'kategori' => ['required', 'string', 'min:1'],
            'deskripsi' => ['required', 'string', 'min:1'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2000'],
        ];
    }

    public function load(): void
    {
        $this->ready = false;
        try {
            $token = Session::get('auth_token');
            $base = rtrim((string) config('services.api.base_url'), '/');
            $url = $base . '/v1/master/slider/' . (int) $this->id;
            /** @var Response $response */
            $response = Http::withToken($token)->accept('application/json')->get($url);
            $json = $response->json();
            if ($response->successful() && ($json['success'] ?? false)) {
                $data = (array) ($json['data'] ?? []);
                $this->judul = (string) ($data['judul'] ?? '');
                $this->kategori = (string) ($data['kategori'] ?? '');
                $this->deskripsi = (string) ($data['deskripsi'] ?? '');
                $img = (string) ($data['image'] ?? '');
                $img = ltrim($img, '/');
                $this->imageUrl = $img ? rtrim((string) config('services.api.image_base_url'), '/') . '/' . $img : null;
                $this->error = null;
                $this->ready = true;
                return;
            }
            $this->error = (string) ($json['message'] ?? 'Gagal memuat data banner');
        } catch (\Throwable) {
            $this->error = 'Terjadi kesalahan saat mengambil data banner';
        }
        $this->ready = true;
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
            $url = $base . '/v1/master/slider/' . (int) $this->id;
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
                $payload = [
                    'title' => 'Berhasil',
                    'message' => (string) ($json['message'] ?? 'Banner berhasil diperbarui'),
                    'type' => 'success',
                ];
                $this->dispatch('set-pending-toast', $payload);
                $this->redirect('/banner-carousel', navigate: true);
                return;
            }
            $errors = (array) ($json['errors'] ?? []);
            $flatMessages = [];
            foreach ($errors as $field => $messages) {
                foreach ((array) $messages as $msg) {
                    $this->addError((string) $field, (string) $msg);
                    $flatMessages[] = (string) $msg;
                }
            }
            $this->error = (string) ($json['message'] ?? 'Gagal memperbarui banner');
        } catch (\Throwable) {
            $this->error = 'Terjadi kesalahan saat memperbarui banner';
        }
    }
};
