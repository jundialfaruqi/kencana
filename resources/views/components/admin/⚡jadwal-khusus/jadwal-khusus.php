<?php

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

new #[Title('Jadwal Khusus')] #[Layout('layouts::admin.app')] class extends Component
{
    use WithPagination;

    public bool $ready = false;
    public array $items = [];
    public ?string $error = null;
    public array $links = [];
    public int $currentPage = 1;
    public int $lastPage = 1;
    public int $perPage = 10;
    public int $total = 0;
    public ?string $path = '/jadwal-khusus';
    #[Url(as: 'page', history: true)]
    public int $page = 1;

    public bool $showExportModal = false;
    public ?string $exportFrom = null;
    public ?string $exportTo = null;
    public string $exportFormat = 'pdf';
    public bool $isExporting = false;
    public ?string $exportPath = null;
    public ?string $exportMessage = null;

    public function load(): void
    {
        $this->ready = false;
        $this->fetchItems();
        $this->ready = true;
    }

    protected function fetchItems(): void
    {
        try {
            $token = Session::get('auth_token');
            $base = rtrim((string) config('services.api.base_url'), '/');
            $url = $base . '/v1/master/jadwalKhusus';
            /** @var \Illuminate\Http\Client\Response $response */
            $response = Http::withOptions(['verify' => filter_var(config('services.api.verify_ssl', true), FILTER_VALIDATE_BOOLEAN)])->withToken($token)->accept('application/json')->get($url);
            $result = $response->json();
            if ($response->successful() && ($result['success'] ?? false)) {
                $all = (array) ($result['data'] ?? []);
                $this->total = count($all);
                $this->lastPage = max(1, (int) ceil(($this->total ?: 0) / $this->perPage));
                $this->currentPage = min(max((int) $this->page, 1), $this->lastPage);
                $offset = max(0, ($this->currentPage - 1) * $this->perPage);
                $this->items = array_slice($all, $offset, $this->perPage);
                $this->links = $this->buildLinks();
                $this->error = null;
                return;
            }
            $this->items = [];
            $this->error = (string) ($result['message'] ?? 'Gagal memuat jadwal khusus');
        } catch (\Throwable) {
            $this->items = [];
            $this->error = 'Terjadi kesalahan saat mengambil jadwal khusus';
        }
    }

    protected function buildLinks(): array
    {
        $links = [];
        $curr = $this->currentPage;
        $last = $this->lastPage;
        $path = (string) ($this->path ?: '/jadwal-khusus');
        // Prev
        $links[] = [
            'label' => 'Prev',
            'url' => $curr > 1 ? ($path . '?page=' . ($curr - 1)) : null,
            'active' => false,
        ];
        // Pages
        for ($p = 1; $p <= $last; $p++) {
            $links[] = [
                'label' => (string) $p,
                'url' => $path . '?page=' . $p,
                'active' => ($p === $curr),
            ];
        }
        // Next
        $links[] = [
            'label' => 'Next',
            'url' => $curr < $last ? ($path . '?page=' . ($curr + 1)) : null,
            'active' => false,
        ];
        return $links;
    }

    public function goToUrl(?string $url): void
    {
        if (!$url) return;
        $this->ready = false;
        $page = 1;
        try {
            $parts = parse_url((string) $url);
            $query = [];
            if (isset($parts['query'])) {
                parse_str((string) $parts['query'], $query);
            }
            $page = (int) (($query['page'] ?? 1));
        } catch (\Throwable) {
        }
        $this->page = max(1, (int) $page);
        $this->fetchItems();
        $this->ready = true;
    }

    public function deleteJadwal(int $id): void
    {
        $this->ready = false;
        try {
            $token = Session::get('auth_token');
            $base = rtrim((string) config('services.api.base_url'), '/');
            $url = $base . '/v1/master/jadwalKhusus/' . $id;
            /** @var \Illuminate\Http\Client\Response $response */
            $response = Http::withOptions(['verify' => filter_var(config('services.api.verify_ssl', true), FILTER_VALIDATE_BOOLEAN)])->withToken($token)->accept('application/json')->delete($url);
            $result = $response->json();
            if ($response->successful() && ($result['success'] ?? false)) {
                $this->error = null;
                $this->dispatch('toast', [
                    'title' => 'Berhasil',
                    'message' => (string) ($result['message'] ?? 'Jadwal khusus berhasil dihapus'),
                    'type' => 'success',
                ]);
                $this->fetchItems();
                $this->ready = true;
                return;
            }
            $this->error = (string) ((is_array($result) ? ($result['message'] ?? null) : null) ?: 'Gagal menghapus jadwal khusus');
            $this->dispatch('toast', [
                'title' => 'Gagal',
                'message' => $this->error,
                'type' => 'error',
            ]);
        } catch (\Throwable) {
            $this->error = 'Terjadi kesalahan saat menghapus jadwal khusus';
            $this->dispatch('toast', [
                'title' => 'Gagal',
                'message' => $this->error,
                'type' => 'error',
            ]);
        }
        $this->fetchItems();
        $this->ready = true;
    }

    public function openExportModal()
    {
        $this->showExportModal = true;
        $this->exportFrom = null;
        $this->exportTo = null;
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
            $url = $base . '/v1/master/jadwalKhusus';
            
            $response = Http::withOptions(['verify' => filter_var(config('services.api.verify_ssl', true), FILTER_VALIDATE_BOOLEAN)])->withToken($token)->accept('application/json')->get($url);
            $result = $response->json();
            
            $all = [];
            if ($response->successful() && ($result['success'] ?? false)) {
                $all = (array) ($result['data'] ?? []);
            }
            
            if ($this->exportFrom || $this->exportTo) {
                $all = array_filter($all, function($item) {
                    $tanggal = $item['tanggal'] ?? null;
                    if (!$tanggal) return false;
                    $ts = strtotime(substr($tanggal, 0, 10));
                    if ($this->exportFrom && $ts < strtotime($this->exportFrom)) return false;
                    if ($this->exportTo && $ts > strtotime($this->exportTo)) return false;
                    return true;
                });
            }

            if ($this->exportFormat === 'xlsx') {
                $title = 'Data Jadwal Khusus Kencana Arena';
                $fromStr = $this->exportFrom ? \Carbon\Carbon::parse($this->exportFrom)->format('d M Y') : '';
                $toStr = $this->exportTo ? \Carbon\Carbon::parse($this->exportTo)->format('d M Y') : '';
                
                $period = 'Keseluruhan';
                if ($fromStr && $toStr) {
                    $period = "$fromStr - $toStr";
                } elseif ($fromStr) {
                    $period = "Sejak $fromStr";
                } elseif ($toStr) {
                    $period = "Hingga $toStr";
                }
                
                $metadata = [
                    'Periode' => $period,
                    'Dicetak Pada' => \Carbon\Carbon::now()->format('d M Y H:i:s'),
                ];
                
                $headers = [
                    'No',
                    'Tanggal',
                    'Jam',
                    'Tipe',
                    'Keterangan',
                    'Arena'
                ];
                
                $rows = [];
                foreach (array_values($all) as $index => $it) {
                    $tanggal = \Carbon\Carbon::parse(data_get($it, 'tanggal'))->format('d M Y');
                    $jam = substr(data_get($it, 'buka', ''), 0, 5) . ' - ' . substr(data_get($it, 'tutup', ''), 0, 5);
                    $tipe = data_get($it, 'tipe_label', '-');
                    $keterangan = data_get($it, 'keterangan', '-');
                    $arena = data_get($it, 'lapangan.nama_lapangan') ?? data_get($it, 'lapangan.nama', '-');
                    
                    $rows[] = [
                        $index + 1,
                        $tanggal,
                        $jam,
                        $tipe,
                        $keterangan,
                        $arena
                    ];
                }
                
                $formats = [
                    'A' => 'center',
                    'B' => 'center',
                    'C' => 'center',
                    'D' => 'center',
                ];
                
                $spreadsheet = \App\Services\ExcelExportService::generate($title, $metadata, $headers, $rows, $formats);
                
                $filename = 'Export_Jadwal_Khusus_' . time() . '.xlsx';
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
                $pdf = Pdf::loadView('pdf.jadwal-khusus-export', [
                    'items' => $all,
                    'from' => $this->exportFrom,
                    'to' => $this->exportTo,
                ]);

                $filename = 'Export_Jadwal_Khusus_' . time() . '.pdf';
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
            $filename = 'Export_Jadwal_Khusus_' . date('Ymd_His') . '.' . $ext;
            return response()->streamDownload(function () {
                echo Storage::disk('local')->get($this->exportPath);
            }, $filename);
        }
    }
};
