<?php

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\WithFileUploads;

new #[Title('Buat Lapangan')] #[Layout('layouts::admin.app')] class extends Component
{
    use WithFileUploads;

    public $error = null;

    public $nama_lapangan = '';
    public $deskripsi = '';
    public $alamat = '';
    public $gmap = '';
    public $np_telp = '';
    public $status = 'open';
    public $latitude = null;
    public $longitude = null;
    public $image_cover = null;
    public $images = [];

    protected function rules(): array
    {
        return [
            'nama_lapangan' => ['required', 'string', 'min:3'],
            'deskripsi' => ['required', 'string'],
            'alamat' => ['required', 'string'],
            'gmap' => ['nullable', 'string'],
            'np_telp' => ['nullable', 'string'],
            'status' => ['required', 'in:open,coming_soon'],
            'latitude' => ['nullable', 'numeric'],
            'longitude' => ['nullable', 'numeric'],
            'image_cover' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2000'],
            'images' => ['nullable', 'array', 'max:4'],
            'images.*' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2000'],
        ];
    }

    protected function messages(): array
    {
        return [
            'nama_lapangan.required' => 'Nama lapangan wajib diisi',
            'nama_lapangan.min' => 'Nama lapangan minimal 3 karakter',
            'deskripsi.required' => 'Deskripsi wajib diisi',
            'alamat.required' => 'Alamat wajib diisi',
            'status.required' => 'Status wajib dipilih',
            'status.in' => 'Status tidak valid',
            'latitude.numeric' => 'Latitude harus berupa angka',
            'longitude.numeric' => 'Longitude harus berupa angka',
            'image_cover.image' => 'Cover harus berupa gambar',
            'image_cover.mimes' => 'Cover harus bertipe JPG, JPEG, atau PNG',
            'image_cover.max' => 'Ukuran cover maksimal 2MB',
            'images.array' => 'Galeri harus berupa daftar gambar',
            'images.max' => 'Maksimum 4 gambar galeri',
            'images.*.image' => 'Setiap gambar galeri harus berupa gambar',
            'images.*.mimes' => 'Gambar galeri harus bertipe JPG, JPEG, atau PNG',
            'images.*.max' => 'Ukuran setiap gambar maksimal 2MB',
        ];
    }

    public function addImageField(): void
    {
        if (count((array)$this->images) >= 4) {
            $this->addError('images', 'Maksimum 4 gambar di galeri');
            return;
        }
        $this->images[] = null;
    }

    public function removeImage(int $index): void
    {
        if (array_key_exists($index, $this->images)) {
            unset($this->images[$index]);
            $this->images = array_values($this->images);
        }
    }

    public function cancel(): mixed
    {
        $this->reset([
            'nama_lapangan',
            'deskripsi',
            'alamat',
            'gmap',
            'np_telp',
            'status',
            'latitude',
            'longitude',
            'image_cover',
            'images'
        ]);
        $this->dispatch('form-reset');
        return $this->redirect('/manajemen-lapangan', navigate: true);
    }

    public function submit(): void
    {
        $this->resetValidation();
        $validated = $this->validate();

        try {
            $token = Session::get('auth_token');
            $base = rtrim(config('services.api.base_url'), '/');
            $url = $base . '/v1/master/lapangan';

            $payload = [
                'nama_lapangan' => (string)($validated['nama_lapangan'] ?? ''),
                'deskripsi' => (string)($validated['deskripsi'] ?? ''),
                'alamat' => (string)($validated['alamat'] ?? ''),
                'gmap' => (string)($validated['gmap'] ?? ''),
                'np_telp' => (string)($validated['np_telp'] ?? ''),
                'status' => (string)($validated['status'] ?? 'open'),
                'latitude' => $validated['latitude'] ?? null,
                'longitude' => $validated['longitude'] ?? null,
            ];

            $request = Http::asMultipart()->withToken($token)->accept('application/json');

            if ($this->image_cover instanceof TemporaryUploadedFile) {
                $request = $request->attach(
                    'image_cover',
                    fopen($this->image_cover->getRealPath(), 'r'),
                    $this->image_cover->getClientOriginalName()
                );
            }

            if (is_array($this->images)) {
                foreach ($this->images as $file) {
                    if ($file instanceof TemporaryUploadedFile) {
                        $request = $request->attach(
                            'images[]',
                            fopen($file->getRealPath(), 'r'),
                            $file->getClientOriginalName()
                        );
                    }
                }
            }

            /** @var \Illuminate\Http\Client\Response $response */
            $response = $request->post($url, $payload);
            $result = $response->json();

            if ($response->successful() && ($result['success'] ?? false)) {
                $this->error = null;
                $this->reset([
                    'nama_lapangan',
                    'deskripsi',
                    'alamat',
                    'gmap',
                    'np_telp',
                    'status',
                    'latitude',
                    'longitude',
                    'image_cover',
                    'images'
                ]);
                $this->dispatch('form-reset');
                $this->dispatch('toast', [
                    'title' => 'Berhasil',
                    'message' => $result['message'] ?? 'Data lapangan berhasil dibuat',
                    'type' => 'success',
                ]);
                return;
            }

            $errors = $result['errors'] ?? ($result['data']['errors'] ?? null);
            if (is_array($errors)) {
                foreach ($errors as $field => $messages) {
                    foreach ((array) $messages as $msg) {
                        $this->addError((string)$field, (string)$msg);
                    }
                }
                $this->error = null;
            } else {
                $this->error = $result['message'] ?? 'Gagal membuat lapangan';
            }
        } catch (\Throwable $e) {
            $this->error = 'Terjadi kesalahan saat membuat lapangan';
        }
    }
};
