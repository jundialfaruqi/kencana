<?php

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

new #[Title('Banner Carousel Detail')] #[Layout('layouts::admin.app')] class extends Component
{
    public $id = null;

    public bool $ready = false;
    public ?string $error = null;
    public array $banner = [];
    public ?string $imageUrl = null;
    public ?string $updatedAtFormatted = null;
    public ?string $createdAtFormatted = null;

    public function mount(int $id): void
    {
        $this->id = $id;
    }

    public function load(): void
    {
        $this->fetch();
        $this->ready = true;
    }

    protected function fetch(): void
    {
        try {
            $token = Session::get('auth_token');
            $apiBase = rtrim((string) config('services.api.base_url'), '/');
            $imageBase = rtrim((string) config('services.api.image_base_url'), '/');
            $id = intval($this->id ?? 0);
            if ($id <= 0) {
                $this->error = 'ID banner tidak valid';
                return;
            }
            $url = $apiBase . '/v1/master/slider/' . $id;
            /** @var \Illuminate\Http\Client\Response $response */
            $response = Http::withToken($token)->accept('application/json')->get($url);
            $result = $response->json();
            if ($response->successful() && ($result['success'] ?? false)) {
                $data = (array) ($result['data'] ?? []);
                $this->banner = [
                    'id' => $data['id'] ?? null,
                    'kategori' => (string) ($data['kategori'] ?? ''),
                    'judul' => (string) ($data['judul'] ?? ''),
                    'deskripsi' => (string) ($data['deskripsi'] ?? ''),
                    'image' => (string) ($data['image'] ?? ''),
                    'is_active' => (bool) ($data['is_active'] ?? false),
                    'urutan' => $data['urutan'] ?? null,
                    'created_at' => (string) ($data['created_at'] ?? ''),
                    'updated_at' => (string) ($data['updated_at'] ?? ''),
                ];
                $this->updatedAtFormatted = $this->formatDate((string) ($this->banner['updated_at'] ?? ''));
                $this->createdAtFormatted = $this->formatDate((string) ($this->banner['created_at'] ?? ''));
                $img = (string) ($this->banner['image'] ?? '');
                $img = ltrim($img, '/');
                if ($img !== '') {
                    if (preg_match('/^https?:\/\//', $img)) {
                        $this->imageUrl = $img;
                    } else {
                        $this->imageUrl = $imageBase . '/' . $img;
                    }
                } else {
                    $this->imageUrl = null;
                }
                $this->error = null;
                return;
            }
            $this->error = (string) ($result['message'] ?? 'Gagal memuat detail banner');
        } catch (\Throwable) {
            $this->error = 'Terjadi kesalahan saat mengambil detail banner';
        }
    }

    protected function formatDate(?string $iso): ?string
    {
        $str = (string) ($iso ?? '');
        if ($str === '') return '-';
        try {
            return Carbon::parse($str)->timezone('Asia/Jakarta')->format('d-m-Y H:i');
        } catch (\Throwable) {
            return $str;
        }
    }
};
