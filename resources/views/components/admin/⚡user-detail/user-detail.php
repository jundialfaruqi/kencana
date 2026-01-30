<?php

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

new #[Title('Detail User')] #[Layout('layouts::admin.app')] class extends Component
{
    #[Url(as: 'id')]
    public $id;

    public $user = null;
    public $error = null;
    public $blurKtp = true;
    public $showNik = false;
    public $createdAtFormatted = null;

    public function load()
    {
        $this->fetch();
    }

    protected function fetch(): void
    {
        try {
            $token = Session::get('auth_token');
            $base = rtrim(config('services.api.base_url'), '/');
            $url = $base . '/v1/master/user/' . $this->id;
            /** @var \Illuminate\Http\Client\Response $response */
            $response = Http::withToken($token)->accept('application/json')->get($url);
            $result = $response->json();
            if ($response->successful() && ($result['success'] ?? false)) {
                $this->user = $result['data'] ?? null;
                $this->error = null;
                $created = $this->user['created_at'] ?? null;
                if (!empty($created)) {
                    $this->createdAtFormatted = \Carbon\Carbon::parse($created)
                        ->setTimezone('Asia/Jakarta')
                        ->locale('id')
                        ->isoFormat('D MMMM YYYY [Jam] HH:mm') . ' WIB';
                } else {
                    $this->createdAtFormatted = null;
                }
                return;
            }
            $this->error = $result['message'] ?? 'Gagal memuat detail user';
        } catch (\Throwable $e) {
            $this->error = 'Terjadi kesalahan saat mengambil detail user';
        }
    }
    public function toggleBlurKtp(): void
    {
        $this->blurKtp = !$this->blurKtp;
    }
    public function toggleShowNik(): void
    {
        $this->showNik = !$this->showNik;
    }
};
