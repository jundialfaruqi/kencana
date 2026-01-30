<?php

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

new #[Title('Update User')] #[Layout('layouts::admin.app')] class extends Component
{
    #[Url(as: 'id')]
    public $id;

    public $ready = false;
    public $error = null;

    public $name = '';
    public $email = '';
    public $nik = '';
    public $no_wa = '';
    public $phone_number = '';
    public $password = '';
    public $showPassword = false;

    public function load()
    {
        $this->fetch();
        $this->ready = true;
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
                $data = $result['data'] ?? [];
                $this->name = (string)($data['name'] ?? '');
                $this->email = (string)($data['email'] ?? '');
                $this->nik = (string)($data['nik'] ?? '');
                $this->no_wa = (string)($data['no_wa'] ?? '');
                $digits = preg_replace('/\D/', '', $this->no_wa);
                if (str_starts_with($digits, '62')) {
                    $this->phone_number = substr($digits, 2);
                } elseif (str_starts_with($digits, '0')) {
                    $this->phone_number = substr($digits, 1);
                } else {
                    $this->phone_number = $digits;
                }
                $this->error = null;
                return;
            }
            $this->error = $result['message'] ?? 'Gagal memuat data user';
        } catch (\Throwable $e) {
            $this->error = 'Terjadi kesalahan saat mengambil data';
        }
    }

    public function updatedPhoneNumber($value): void
    {
        $value = preg_replace('/[^0-9]/', '', (string)$value);
        $apiValue = $value;
        if (str_starts_with($apiValue, '0')) {
            $apiValue = substr($apiValue, 1);
        }
        $displayValue = $value;
        if (str_starts_with($displayValue, '0')) {
            $displayValue = substr($displayValue, 1);
        }
        $this->phone_number = $displayValue;
        $this->no_wa = '+62' . $apiValue;
    }

    public function toggleShowPassword(): void
    {
        $this->showPassword = !$this->showPassword;
    }

    public function submit(): void
    {
        try {
            $token = Session::get('auth_token');
            $base = rtrim(config('services.api.base_url'), '/');
            $url = $base . '/v1/master/user/' . $this->id;
            $sanitized = preg_replace('/[^0-9]/', '', (string)$this->phone_number);
            $apiNumber = $sanitized;
            if (str_starts_with($apiNumber, '0')) {
                $apiNumber = substr($apiNumber, 1);
            }
            $this->no_wa = '+62' . $apiNumber;
            $payload = [
                'name' => $this->name,
                'email' => $this->email,
                'nik' => $this->nik,
                'no_wa' => $this->no_wa,
                'password' => $this->password,
            ];
            /** @var \Illuminate\Http\Client\Response $response */
            $response = Http::withToken($token)->accept('application/json')->post($url, $payload);
            $result = $response->json();
            if ($response->successful() && ($result['success'] ?? false)) {
                $this->error = null;
                $this->dispatch('toast', [
                    'title' => 'Berhasil',
                    'message' => $result['message'] ?? 'Data user berhasil diperbarui',
                    'type' => 'success',
                ]);
                return;
            }
            $errors = $result['errors'] ?? ($result['data']['errors'] ?? null);
            if (is_array($errors)) {
                foreach ($errors as $field => $messages) {
                    $messages = (array) $messages;
                    foreach ($messages as $msg) {
                        $this->addError($field, (string) $msg);
                    }
                }
                $this->error = null;
            } else {
                $this->error = $result['message'] ?? 'Gagal memperbarui data user';
                $this->dispatch('toast', [
                    'title' => 'Gagal',
                    'message' => $this->error,
                    'type' => 'error',
                ]);
            }
        } catch (\Throwable $e) {
            $this->error = 'Terjadi kesalahan saat memperbarui data user';
            $this->dispatch('toast', [
                'title' => 'Gagal',
                'message' => $this->error,
                'type' => 'error',
            ]);
        }
    }
};
