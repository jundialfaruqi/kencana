<?php

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

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

    public bool $showExportModal = false;
    public string $exportFormat = 'pdf';
    public bool $isExporting = false;
    public ?string $exportPath = null;
    public ?string $exportMessage = null;

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
                $this->dispatch('toast', [
                    'message' => $result['message'] ?? 'Status user berhasil diubah',
                    'type' => 'success',
                ]);
                return;
            }
            $this->error = $result['message'] ?? 'Gagal mengubah status user';
            $this->dispatch('toast', [
                'message' => $this->error,
                'type' => 'error',
            ]);
        } catch (\Throwable $e) {
            $this->dispatch('toast', [
                'message' => $this->error,
                'type' => 'error',
            ]);
        }
    }

    public function openExportModal()
    {
        $this->showExportModal = true;
        $this->exportFormat = 'pdf';
        $this->exportPath = null;
        $this->exportMessage = null;
        $this->isExporting = false;
        $this->dispatch('modal-export-open');
        return $this->skipRender();
    }

    public function closeExportModal()
    {
        $this->showExportModal = false;
        if ($this->exportPath && Storage::disk('local')->exists($this->exportPath)) {
            Storage::disk('local')->delete($this->exportPath);
        }
        $this->exportPath = null;
        $this->isExporting = false;
        $this->dispatch('modal-export-close');
        return $this->skipRender();
    }

    public function processExport()
    {
        $this->isExporting = true;
        $this->exportPath = null;
        $this->exportMessage = null;

        try {
            $token = Session::get('auth_token');
            $base = rtrim((string) config('services.api.base_url'), '/');
            $url = $base . '/v1/master/user';

            $allUsers = [];
            $currentPage = 1;
            $lastPage = 1;

            do {
                $params = [
                    'page' => $currentPage,
                    'per_page' => 100,
                ];

                $requestUrl = $url . '?' . http_build_query($params);

                $response = Http::withToken($token)->accept('application/json')->get($requestUrl);
                $result = $response->json();

                if ($response->successful() && ($result['success'] ?? false)) {
                    $data = (array) ($result['data'] ?? []);
                    $items = (array) ($data['data'] ?? []);
                    $allUsers = array_merge($allUsers, $items);
                    $lastPage = intval($data['last_page'] ?? 1);
                } else {
                    break;
                }

                $currentPage++;
            } while ($currentPage <= $lastPage);

            // Mask data function
            $maskEmail = function ($email) {
                if (!$email) return '-';
                $parts = explode('@', $email);
                if (count($parts) === 2) {
                    $name = $parts[0];
                    if (strlen($name) > 2) {
                        $maskedName = substr($name, 0, 1) . str_repeat('*', strlen($name) - 2) . substr($name, -1);
                        return $maskedName . '@' . $parts[1];
                    }
                    return '*' . '@' . $parts[1];
                }
                return $email;
            };

            $maskNumber = function ($number) {
                if (!$number) return '-';
                $len = strlen($number);
                if ($len > 8) {
                    return substr($number, 0, 4) . str_repeat('*', $len - 8) . substr($number, -4);
                } elseif ($len > 4) {
                    return substr($number, 0, 2) . str_repeat('*', $len - 4) . substr($number, -2);
                }
                return str_repeat('*', $len);
            };

            // Apply mask
            foreach ($allUsers as &$u) {
                $u['email_masked'] = $maskEmail($u['email'] ?? '');
                $u['nik_masked'] = $maskNumber($u['nik'] ?? '');
                $u['no_wa_masked'] = $maskNumber($u['no_wa'] ?? '');
            }
            unset($u);

            if ($this->exportFormat === 'xlsx') {
                $title = 'Data User Kencana Arena';
                
                $metadata = [
                    'Kategori' => 'Keseluruhan Data User Terdaftar',
                    'Dicetak Pada' => \Carbon\Carbon::now()->format('d M Y H:i:s'),
                ];
                
                $headers = [
                    'No',
                    'Nama',
                    'Email',
                    'Role',
                    'NIK',
                    'No. WA',
                    'Status'
                ];
                
                $rows = [];
                foreach ($allUsers as $index => $u) {
                    $status = (($u['is_active'] ?? false) === true) ? 'Aktif' : 'Tidak Aktif';
                    
                    $rows[] = [
                        $index + 1,
                        data_get($u, 'name', '-'),
                        data_get($u, 'email_masked', '-'),
                        data_get($u, 'role', '-'),
                        data_get($u, 'nik_masked', '-'),
                        data_get($u, 'no_wa_masked', '-'),
                        $status
                    ];
                }
                
                $formats = [
                    'A' => 'center',
                    'C' => 'center',
                    'D' => 'center',
                    'E' => 'center',
                    'F' => 'center',
                    'G' => 'center',
                ];
                
                $spreadsheet = \App\Services\ExcelExportService::generate($title, $metadata, $headers, $rows, $formats);
                
                $filename = 'Export_User_' . time() . '.xlsx';
                $path = 'exports/' . $filename;
                
                $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
                
                if (!Storage::disk('local')->exists('exports')) {
                    Storage::disk('local')->makeDirectory('exports');
                }
                
                $tempFile = tempnam(sys_get_temp_dir(), 'excel');
                $writer->save($tempFile);
                Storage::disk('local')->put($path, fopen($tempFile, 'r'));
                unlink($tempFile);
                
                $this->exportPath = $path;
                $this->exportMessage = 'File Excel sudah siap di download.';
            } else {
                // Generate PDF
                $pdf = Pdf::loadView('pdf.user-export', [
                    'users' => $allUsers,
                ]);

                // Save to local storage
                $filename = 'Export_User_' . time() . '.pdf';
                $path = 'exports/' . $filename;
                
                Storage::disk('local')->put($path, $pdf->output());

                $this->exportPath = $path;
                $this->exportMessage = 'File PDF sudah siap di download.';
            }
        } catch (\Throwable $th) {
            $this->dispatch('toast', [
                'title' => 'Gagal',
                'message' => 'Terjadi kesalahan saat memproses export: ' . $th->getMessage(),
                'type' => 'error',
            ]);
        } finally {
            $this->isExporting = false;
        }
    }

    public function downloadExport()
    {
        if ($this->exportPath && Storage::disk('local')->exists($this->exportPath)) {
            $ext = pathinfo($this->exportPath, PATHINFO_EXTENSION);
            $filename = 'Export_User_' . date('Ymd_His') . '.' . $ext;
            return response()->streamDownload(function () {
                echo Storage::disk('local')->get($this->exportPath);
            }, $filename);
        }
    }
};
