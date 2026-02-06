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

    protected function rules(): array
    {
        return [
            'judul' => ['required', 'string', 'min:1'],
            'kategori' => ['required', 'string', 'min:1'],
            'deskripsi' => ['required', 'string', 'min:1'],
            'image' => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:5120'],
        ];
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
                return;
            }
            $this->error = (string) ($json['message'] ?? 'Gagal membuat banner');
        } catch (\Throwable) {
            $this->error = 'Terjadi kesalahan saat membuat banner';
        }
    }
};
