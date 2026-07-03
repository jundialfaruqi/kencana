<?php

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Session;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\WithFileUploads;

new #[Title('Update Lapangan')] #[Layout('layouts::admin.app')] class extends Component
{
    use WithFileUploads;

    public $error = null;
    #[Url(as: 'id')]
    public $id = null;
    public $ready = false;
    public $coverUrl = null;
    public $galleryUrls = [];

    public $nama_lapangan = '';
    public $deskripsi = '';
    public $alamat = '';
    public $gmap = '';
    public $no_tlp = '';
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
            'no_tlp' => ['nullable', 'string'],
            'status' => ['required', 'in:open,coming_soon'],
            'latitude' => ['nullable', 'numeric'],
            'longitude' => ['nullable', 'numeric'],
            'image_cover' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2000'],
            'images' => ['nullable', 'array', 'max:4'],
            'images.*' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2000'],
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
            'image_cover.mimes' => 'Cover harus bertipe JPG, JPEG, PNG, atau WEBP',
            'image_cover.max' => 'Ukuran cover maksimal 2MB',
            'images.array' => 'Galeri harus berupa daftar gambar',
            'images.max' => 'Maksimum 4 gambar galeri',
            'images.*.image' => 'Setiap gambar galeri harus berupa gambar',
            'images.*.mimes' => 'Gambar galeri harus bertipe JPG, JPEG, PNG, atau WEBP',
            'images.*.max' => 'Ukuran setiap gambar maksimal 2MB',
        ];
    }

    public function mount(): void
    {
        $this->ready = true;
        $this->images = [null, null, null, null];
        $this->fetch();
    }

    protected function fetch(): void
    {
        try {
            $token = Session::get('auth_token');
            $base = rtrim(config('services.api.base_url'), '/');
            $imageBase = rtrim(config('services.api.image_base_url'), '/');
            $id = intval($this->id ?? 0);
            if ($id <= 0) {
                $this->error = 'ID lapangan tidak valid';
                return;
            }
            $url = $base . '/v1/master/lapangan/' . $id;
            /** @var Response $response */
            $response = Http::withOptions(['verify' => filter_var(config('services.api.verify_ssl', true), FILTER_VALIDATE_BOOLEAN)])->withToken($token)->accept('application/json')->get($url);
            $result = $response->json();
            if ($response->successful() && ($result['success'] ?? false)) {
                $data = $result['data'] ?? [];
                $this->nama_lapangan = (string)($data['nama_lapangan'] ?? '');
                $this->deskripsi = (string)($data['deskripsi'] ?? '');
                $this->alamat = (string)($data['alamat'] ?? '');
                $this->gmap = (string)($data['gmap'] ?? '');
                $this->no_tlp = (string)($data['no_tlp'] ?? '');
                $this->status = (string)($data['status'] ?? 'open');
                $this->latitude = $data['latitude'] ?? null;
                $this->longitude = $data['longitude'] ?? null;
                $cover = data_get($data, 'image_cover');
                if (!empty($cover)) {
                    $p = ltrim((string)$cover, '/');
                    if (preg_match('/^https?:\/\//', $p)) {
                        $this->coverUrl = $p;
                    } else {
                        $this->coverUrl = $imageBase . '/' . $p;
                    }
                } else {
                    $this->coverUrl = null;
                }
                $images = (array) data_get($data, 'images', []);
                $this->galleryUrls = array_map(function ($img) use ($imageBase) {
                    $p = ltrim((string)$img, '/');
                    if (preg_match('/^https?:\/\//', $p)) {
                        return $p;
                    }
                    return $imageBase . '/' . $p;
                }, $images);
                $this->error = null;
                return;
            }
            $this->error = $result['message'] ?? 'Gagal memuat data lapangan';
        } catch (\Throwable) {
            $this->error = 'Terjadi kesalahan saat mengambil data lapangan';
        }
    }

    public function removeImage(int $index): void
    {
        if (array_key_exists($index, $this->images)) {
            $this->images[$index] = null;
        }
    }

    public function removeGalleryUrl(int $index): void
    {
        if (array_key_exists($index, $this->galleryUrls)) {
            $this->galleryUrls[$index] = null;
        }
    }

    public function cancel(): mixed
    {
        $this->reset([
            'nama_lapangan',
            'deskripsi',
            'alamat',
            'gmap',
            'no_tlp',
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
            $id = intval($this->id ?? 0);
            if ($id <= 0) {
                $this->error = 'ID lapangan tidak valid';
                return;
            }
            $url = $base . '/v1/master/lapangan/' . $id;

            $payload = [
                'nama_lapangan' => (string)($validated['nama_lapangan'] ?? ''),
                'deskripsi' => (string)($validated['deskripsi'] ?? ''),
                'alamat' => (string)($validated['alamat'] ?? ''),
                'gmap' => (string)($validated['gmap'] ?? ''),
                'no_tlp' => (string)($validated['no_tlp'] ?? ''),
                'status' => (string)($validated['status'] ?? 'open'),
                'latitude' => $validated['latitude'] ?? null,
                'longitude' => $validated['longitude'] ?? null,
            ];

            $request = Http::withOptions(['verify' => filter_var(config('services.api.verify_ssl', true), FILTER_VALIDATE_BOOLEAN)])->asMultipart()->withToken($token)->accept('application/json');

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

            /** @var Response $response */
            $response = $request->post($url, $payload);
            $result = $response->json();

            if ($response->successful() && ($result['success'] ?? false)) {
                $this->error = null;
                $this->dispatch('set-pending-toast', [
                    'title' => 'Berhasil',
                    'message' => $result['message'] ?? 'Data lapangan berhasil diperbarui',
                    'type' => 'success',
                ]);
                $this->redirect('/manajemen-lapangan', navigate: true);
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
                $this->error = $result['message'] ?? 'Gagal memperbarui lapangan';
            }
        } catch (\Throwable) {
            $this->error = 'Terjadi kesalahan saat memperbarui lapangan';
        }
    }
};
