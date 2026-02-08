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

    public function load(): void
    {
        $this->fetch();
        $this->ready = true;
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
            $response = Http::withToken($token)->accept('application/json')->get($url);
            $result = $response->json();
            if ($response->successful() && ($result['success'] ?? false)) {
                $data = $result['data'] ?? [];
                $this->nama_lapangan = (string)($data['nama_lapangan'] ?? '');
                $this->deskripsi = (string)($data['deskripsi'] ?? '');
                $this->alamat = (string)($data['alamat'] ?? '');
                $this->gmap = (string)($data['gmap'] ?? '');
                $this->np_telp = (string)($data['np_telp'] ?? '');
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

            /** @var Response $response */
            $response = $request->post($url, $payload);
            $result = $response->json();

            if ($response->successful() && ($result['success'] ?? false)) {
                $this->error = null;
                $this->dispatch('toast', [
                    'title' => 'Berhasil',
                    'message' => $result['message'] ?? 'Data lapangan berhasil diperbarui',
                    'type' => 'success',
                ]);
                $this->image_cover = null;
                $this->images = [];
                $this->fetch();
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
