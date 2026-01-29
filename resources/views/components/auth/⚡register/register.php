<?php

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

new #[Layout('layouts::auth.app')] #[Title('Register')] class extends Component {
    use WithFileUploads;

    public $ready = false;
    public $registrationSuccess = false;
    public $successMessage = '';

    #[Validate]
    public $name = '';

    #[Validate]
    public $email = '';

    #[Validate]
    public $no_wa = '';

    public $phone_number = '';

    // Format phone number when it's updated
    public function updatedPhoneNumber($value)
    {
        // Remove all non-numeric characters
        $value = preg_replace('/[^0-9]/', '', $value);

        // Remove leading 0 for API
        $apiValue = $value;
        if (str_starts_with($apiValue, '0')) {
            $apiValue = substr($apiValue, 1);
        }

        // For display: only remove leading 0
        $displayValue = $value;
        if (str_starts_with($displayValue, '0')) {
            $displayValue = substr($displayValue, 1);
        }

        // Update properties
        $this->phone_number = $displayValue;
        $this->no_wa = '+62' . $apiValue;
    }

    #[Validate]
    public $nik = '';

    #[Validate]
    public $password = '';

    #[Validate]
    public $password_confirmation = '';

    public $foto_ktp = null;

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
            if ($user && in_array($user['role'], ['admin', 'superadmin'])) {
                return $this->redirect('/dashboard', navigate: true);
            }
            return $this->redirect('/', navigate: true);
        }
    }

    public function load()
    {
        $this->ready = true;
    }

    public function register()
    {
        $this->validate();

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

            // Tambahkan file foto_ktp jika ada
            if ($this->foto_ktp) {
                $formData['foto_ktp'] = fopen($this->foto_ktp->getRealPath(), 'r');
            }

            /** @var \Illuminate\Http\Client\Response $response */
            $response = Http::asMultipart()
                ->post(config('services.api.base_url') . '/v1/daftarAkun', $formData);

            $result = $response->json();

            if ($response->successful() && $result['success']) {
                // Tampilkan pesan sukses
                $this->registrationSuccess = true;
                $this->successMessage = $result['message'];
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
