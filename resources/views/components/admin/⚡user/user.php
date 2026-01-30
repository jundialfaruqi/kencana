<?php

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

new #[Title('Manajamen User')] #[Layout('layouts::admin.app')] class extends Component
{
    public $ready = false;
    public $users = [];
    public $links = [];
    public $currentPage = 1;
    public $lastPage = 1;
    public $perPage = 10;
    public $total = 0;
    public $nextPageUrl = null;
    public $prevPageUrl = null;
    public $path = null;
    public $error = null;
    #[Url(as: 'q', history: true)]
    public $search = '';

    public function load()
    {
        $this->fetchUsers(1);
        $this->ready = true;
    }

    public function fetchUsers(int $page = 1)
    {
        $base = config('services.api.base_url');
        $url = rtrim($base, '/') . '/v1/master/user?page=' . $page;
        $this->fetchByUrl($url);
    }

    public function goToUrl(?string $url)
    {
        if (!$url) {
            return;
        }
        $this->fetchByUrl($url);
    }

    protected function fetchByUrl(string $url)
    {
        try {
            $token = Session::get('auth_token');
            /** @var \Illuminate\Http\Client\Response $response */
            $response = Http::withToken($token)->accept('application/json')->get($url);
            $result = $response->json();
            if ($response->successful() && ($result['success'] ?? false)) {
                $data = $result['data'] ?? [];
                $this->users = $data['data'] ?? [];
                $this->links = $data['links'] ?? [];
                $this->currentPage = $data['current_page'] ?? 1;
                $this->lastPage = $data['last_page'] ?? 1;
                $this->perPage = $data['per_page'] ?? 10;
                $this->total = $data['total'] ?? 0;
                $this->nextPageUrl = $data['next_page_url'] ?? null;
                $this->prevPageUrl = $data['prev_page_url'] ?? null;
                $this->path = $data['path'] ?? null;
                $this->error = null;
                return;
            }
            $this->error = $result['message'] ?? 'Gagal memuat data user';
        } catch (\Throwable $e) {
            $this->error = 'Terjadi kesalahan saat mengambil data';
        }
    }
    public function getFilteredUsersProperty(): array
    {
        $q = mb_strtolower(trim($this->search));
        if ($q === '') {
            return $this->users;
        }
        return array_values(array_filter($this->users, function ($u) use ($q) {
            $name = mb_strtolower((string)($u['name'] ?? ''));
            $email = mb_strtolower((string)($u['email'] ?? ''));
            $nik = mb_strtolower((string)($u['nik'] ?? ''));
            return str_contains($name, $q) || str_contains($email, $q) || str_contains($nik, $q);
        }));
    }
    public function toggleUserStatus(int $id): void
    {
        try {
            $token = Session::get('auth_token');
            $base = rtrim(config('services.api.base_url'), '/');
            $url = $base . '/v1/master/user/' . $id . '/status';
            /** @var \Illuminate\Http\Client\Response $response */
            $response = Http::withToken($token)->accept('application/json')->post($url);
            $result = $response->json();
            if ($response->successful() && ($result['success'] ?? false)) {
                foreach ($this->users as &$u) {
                    if (($u['id'] ?? null) === $id) {
                        $u['is_active'] = !((bool)($u['is_active'] ?? false));
                        break;
                    }
                }
                unset($u);
                $this->error = null;
                return;
            }
            $this->error = $result['message'] ?? 'Gagal mengubah status user';
        } catch (\Throwable $e) {
            $this->error = 'Terjadi kesalahan saat mengubah status user';
        }
    }
};
