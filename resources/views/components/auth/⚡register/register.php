<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

new #[Layout('layouts::auth.app')] #[Title('Register')] class extends Component
{
    use WithFileUploads;

    public $ready = false;

    public $registrationSuccess = false;

    public $successMessage = '';

    public $redirectUrl = '';

    #[Validate]
    public $name = '';

    #[Validate]
    public $email = '';

    #[Validate]
    public $no_wa = '';

    public $phone_number = '';

    public function updatedPhoneNumber($value)
    {
        // Remove all non-numeric characters
        $value = preg_replace('/[^0-9]/', '', $value);

        // Strip leading '0'
        while (str_starts_with($value, '0')) {
            $value = substr($value, 1);
        }

        // Strip leading '62' if present
        if (str_starts_with($value, '62')) {
            $value = substr($value, 2);
        }

        // Strip leading '0' again just in case (e.g. if it was 0620812...)
        while (str_starts_with($value, '0')) {
            $value = substr($value, 1);
        }

        // Update properties
        $value = substr($value, 0, 11);
        $this->phone_number = $value;
        $this->no_wa = '+62'.$value;
    }

    #[Validate]
    public $nik = '';

    #[Validate]
    public $password = '';

    #[Validate]
    public $password_confirmation = '';

    protected function rules()
    {
        return [
            'name' => 'required',
            'email' => 'required|email',
            'no_wa' => 'required',
            'nik' => 'required|digits:16',
            'password' => 'required|min:8',
            'password_confirmation' => 'required|same:password',
            // Hapus validasi file dari client-side, biarkan API menangani
        ];
    }

    protected function messages()
    {
        return [
            'name.required' => 'Nama wajib diisi',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'no_wa.required' => 'Nomor WhatsApp wajib diisi',
            'nik.required' => 'NIK wajib diisi',
            'nik.digits' => 'NIK harus terdiri dari 16 digit',
            'password.required' => 'Password wajib diisi',
            'password.min' => 'Password minimal 8 karakter',
            'password_confirmation.required' => 'Konfirmasi password wajib diisi',
            'password_confirmation.same' => 'Password dan konfirmasi password tidak cocok',
        ];
    }

    public function mount()
    {
        if (Session::has('auth_token')) {
            $user = Session::get('user_data');
            $defaultUrl = ($user && in_array($user['role'], ['admin', 'superadmin'])) ? '/dashboard' : '/';
            $intendedUrl = Session::pull('url.intended', $defaultUrl);

            return $this->redirect($intendedUrl, navigate: true);
        }
    }

    public function load()
    {
        $this->ready = true;
    }

    public function register()
    {
        // Normalize the phone number before validation
        $this->updatedPhoneNumber($this->phone_number);

        $this->validate();

        // Rate limiting: Max 100 registrations per day
        $dailyLimit = 100;
        $cacheKey = 'daily_registrations_'.Carbon::now()->format('Y-m-d');
        $currentCount = Cache::get($cacheKey, 0);

        if ($currentCount >= $dailyLimit) {
            $this->addError('registerError', 'Batas registrasi harian telah tercapai. Silakan coba lagi besok.');

            return;
        }

        try {
            // Persiapkan data untuk dikirim ke API
            $formData = [
                'name' => $this->name,
                'email' => $this->email,
                'password' => $this->password,
                'password_confirmation' => $this->password_confirmation,
                'nik' => $this->nik,
                'no_wa' => $this->no_wa,
            ];

            $verifySsl = filter_var(config('services.api.verify_ssl', true), FILTER_VALIDATE_BOOLEAN);

            /** @var \Illuminate\Http\Client\Response $response */
            $response = Http::asMultipart()
                ->withOptions(['verify' => $verifySsl])
                ->post(config('services.api.base_url').'/v1/daftarAkun', $formData);

            $result = $response->json();

            if ($response->successful() && $result['success']) {
                // Increment registration count
                Cache::put($cacheKey, $currentCount + 1, Carbon::now()->endOfDay());

                // Auto Login
                $loginResponse = Http::withOptions(['verify' => $verifySsl])
                    ->post(config('services.api.base_url').'/login', [
                        'email' => $this->email,
                        'password' => $this->password,
                    ]);

                $loginResult = $loginResponse->json();

                if ($loginResponse->successful() && ($loginResult['success'] ?? false)) {
                    Session::put('auth_token', $loginResult['data']['token']);
                    Session::put('user_data', $loginResult['data']['user']);

                    $role = $loginResult['data']['user']['role'] ?? 'user';
                    $defaultUrl = in_array($role, ['admin', 'superadmin']) ? '/dashboard' : '/';
                    $intendedUrl = Session::pull('url.intended', $defaultUrl);

                    $this->dispatch('registration-success',
                        redirectUrl: $intendedUrl,
                        message: 'Selamat, akun Anda berhasil dibuat dan Anda telah masuk otomatis.',
                    );

                    return;
                }

                // Tampilkan pesan sukses jika auto-login gagal untuk alasan apapun
                $this->dispatch('registration-success',
                    redirectUrl: route('login'),
                    message: $result['message'] ?? 'Pendaftaran berhasil, silakan masuk ke akun Anda.',
                );

                return;
            }

            if ($response->status() === 422) {
                $errors = $result['errors'] ?? [];
                foreach ($errors as $key => $messages) {
                    foreach ($messages as $message) {
                        $this->addError($key, $message);
                    }
                }

                return;
            }

            // Handle other errors
            $message = $result['message'] ?? 'Registrasi gagal, silakan coba lagi.';
            $this->addError('registerError', $message);
        } catch (\Exception) {
            $this->addError('registerError', 'Terjadi kesalahan sistem. Silakan coba beberapa saat lagi.');
        }
    }

    public function goToLogin()
    {
        return $this->redirect('/login', navigate: true);
    }
};
