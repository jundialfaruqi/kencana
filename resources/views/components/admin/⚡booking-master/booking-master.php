<?php

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;

new class extends Component
{
    public bool $ready = false;

    public array $bookings = [];

    public array $links = [];

    public int $currentPage = 1;

    public int $lastPage = 1;

    public int $perPage = 10;

    public int $total = 0;

    public ?string $nextPageUrl = null;

    public ?string $prevPageUrl = null;

    public ?string $path = null;

    public ?string $error = null;

    public ?string $status = null;

    public ?string $search = null;

    public ?string $from = null;

    public ?string $to = null;

    #[Url(as: 'page', history: true)]
    public int $page = 1;

    public bool $showCancelModal = false;

    public ?int $cancelBookingId = null;

    public ?string $cancelReason = null;

    public ?string $cancelError = null;

    public ?string $cancelMessage = null;

    public bool $showExportModal = false;

    public ?string $exportFrom = null;

    public ?string $exportTo = null;

    public string $exportFormat = 'pdf';

    public bool $isExporting = false;

    public ?string $exportPath = null;

    public ?string $exportMessage = null;

    #[Title('Booking Master')]
    #[Layout('layouts::admin.app')]
    public function mount(): void
    {
        $this->ready = true;
        $this->fetchBookings();
    }

    public function applyFilter(): void
    {
        $this->ready = false;
        $this->fetchBookings();
        $this->ready = true;
    }

    public function updatedStatus($value): void
    {
        $this->status = (string) ($value ?? '');
        $this->ready = false;
        $this->fetchBookings();
        $this->ready = true;
    }

    public function updatedSearch($value): void
    {
        $this->search = (string) ($value ?? '');
        $this->ready = false;
        $this->fetchBookings();
        $this->ready = true;
    }

    public function updatedFrom($value): void
    {
        $this->from = (string) ($value ?? '');
        $this->ready = false;
        $this->fetchBookings();
        $this->ready = true;
    }

    public function updatedTo($value): void
    {
        $this->to = (string) ($value ?? '');
        $this->ready = false;
        $this->fetchBookings();
        $this->ready = true;
    }

    public function goToUrl(?string $url): void
    {
        if (! $url) {
            return;
        }
        $this->ready = false;
        $this->fetchByUrl((string) $url);
        $this->ready = true;
    }

    protected function fetchBookings(): void
    {
        try {
            $token = Session::get('auth_token');
            $base = rtrim((string) config('services.api.base_url'), '/');
            $url = $base.'/v1/master/bookings';
            $params = array_filter([
                'status' => $this->status ? (string) $this->status : null,
                'search' => $this->search ? (string) $this->search : null,
                'from' => $this->from ? (string) $this->from : null,
                'to' => $this->to ? (string) $this->to : null,
                'page' => $this->page ? intval($this->page) : null,
            ], fn ($v) => $v !== null && $v !== '');
            if (! empty($params)) {
                $url .= '?'.http_build_query($params);
            }
            /** @var \Illuminate\Http\Client\Response $response */
            $response = Http::withOptions(['verify' => filter_var(config('services.api.verify_ssl', true), FILTER_VALIDATE_BOOLEAN)])->withToken($token)->accept('application/json')->get($url);
            $result = $response->json();
            if ($response->successful() && ($result['success'] ?? false)) {
                $data = (array) ($result['data'] ?? []);
                $this->bookings = (array) ($data['data'] ?? []);
                $this->links = (array) ($data['links'] ?? []);
                $this->currentPage = intval($data['current_page'] ?? 1);
                $this->page = $this->currentPage;
                $this->lastPage = intval($data['last_page'] ?? 1);
                $this->perPage = intval($data['per_page'] ?? 10);
                $this->total = intval($data['total'] ?? 0);
                $this->nextPageUrl = (string) ($data['next_page_url'] ?? '');
                $this->prevPageUrl = (string) ($data['prev_page_url'] ?? '');
                $this->path = (string) ($data['path'] ?? '');
                $this->error = null;

                return;
            }
            $this->bookings = [];
            $this->links = [];
            $this->error = (string) ($result['message'] ?? 'Gagal memuat data booking');
        } catch (\Throwable) {
            $this->bookings = [];
            $this->links = [];
            $this->error = 'Terjadi kesalahan saat mengambil data booking';
        }
    }

    public function goToPage(?int $page): void
    {
        if (! $page) {
            return;
        }
        $this->page = intval($page);
        $this->ready = false;
        $this->fetchBookings();
        $this->ready = true;
    }

    public function openCancelModal(?int $id)
    {
        $this->cancelBookingId = $id ?: null;
        $payload = ['id' => $this->cancelBookingId];
        if ($this->cancelBookingId) {
            try {
                $token = Session::get('auth_token');
                $base = rtrim((string) config('services.api.base_url'), '/');
                $url = $base.'/v1/master/bookings/'.urlencode((string) $this->cancelBookingId);
                /** @var \Illuminate\Http\Client\Response $response */
                $response = Http::withOptions(['verify' => filter_var(config('services.api.verify_ssl', true), FILTER_VALIDATE_BOOLEAN)])->withToken($token)->accept('application/json')->get($url);
                $result = $response->json();
                if ($response->successful() && ($result['success'] ?? false)) {
                    $data = (array) ($result['data'] ?? []);
                    $payload['kode'] = (string) ($data['kode_booking'] ?? '-');
                    $payload['tanggal'] = (string) ($data['tanggal'] ?? '-');
                    $payload['jam'] = (string) ($data['jam'] ?? '');
                    $payload['jam_mulai'] = (string) ($data['jam_mulai'] ?? '');
                    $payload['jam_selesai'] = (string) ($data['jam_selesai'] ?? '');
                    $payload['user'] = (string) ((data_get($data, 'user.name') ?: data_get($data, 'pemesan.nama')) ?? '-');
                    $payload['lapangan'] = (string) ((data_get($data, 'lapangan.nama_lapangan') ?: data_get($data, 'lapangan.nama')) ?? '-');
                }
            } catch (\Throwable) {
            }
        }
        $this->dispatch('modal-cancel-open', $payload);

        return $this->skipRender();
    }

    public function closeCancelModal()
    {
        $this->dispatch('modal-cancel-close');

        return $this->skipRender();
    }

    public function executeCancelBooking(): void
    {
        if (! $this->cancelBookingId) {
            $this->cancelError = 'ID booking tidak valid';
            $this->dispatch('toast', [
                'title' => 'Gagal',
                'message' => $this->cancelError,
                'type' => 'error',
            ]);

            return;
        }
        try {
            $token = Session::get('auth_token');
            $base = rtrim((string) config('services.api.base_url'), '/');
            $url = $base.'/v1/master/bookings/'.urlencode((string) $this->cancelBookingId).'/cancel';
            $ket = trim((string) ($this->cancelReason ?? ''));
            $payload = [];
            if ($ket !== '') {
                $payload['keterangan'] = $ket;
            }
            /** @var \Illuminate\Http\Client\Response $response */
            $response = Http::withOptions(['verify' => filter_var(config('services.api.verify_ssl', true), FILTER_VALIDATE_BOOLEAN)])->withToken($token)
                ->asForm()
                ->accept('application/json')
                ->post($url, $payload);
            $result = $response->json();
            if ($response->successful() && ($result['success'] ?? false)) {
                $this->cancelMessage = (string) ($result['message'] ?? 'Booking berhasil dibatalkan');
                $this->showCancelModal = false;
                $this->dispatch('modal-cancel-close');
                $this->ready = false;
                $this->fetchBookings();
                $this->ready = true;
                $this->dispatch('toast', [
                    'title' => 'Berhasil',
                    'message' => $this->cancelMessage,
                    'type' => 'success',
                ]);

                return;
            }
            $this->cancelError = (string) ($result['message'] ?? 'Gagal membatalkan booking');
            $this->dispatch('toast', [
                'title' => 'Gagal',
                'message' => $this->cancelError,
                'type' => 'error',
            ]);
        } catch (\Throwable) {
            $this->cancelError = 'Terjadi kesalahan saat membatalkan booking';
            $this->dispatch('toast', [
                'title' => 'Gagal',
                'message' => $this->cancelError,
                'type' => 'error',
            ]);
        }
    }

    protected function fetchByUrl(string $url): void
    {
        try {
            $token = Session::get('auth_token');
            /** @var \Illuminate\Http\Client\Response $response */
            $response = Http::withOptions(['verify' => filter_var(config('services.api.verify_ssl', true), FILTER_VALIDATE_BOOLEAN)])->withToken($token)->accept('application/json')->get($url);
            $result = $response->json();
            if ($response->successful() && ($result['success'] ?? false)) {
                $data = (array) ($result['data'] ?? []);
                $this->bookings = (array) ($data['data'] ?? []);
                $this->links = (array) ($data['links'] ?? []);
                $this->currentPage = intval($data['current_page'] ?? 1);
                $this->lastPage = intval($data['last_page'] ?? 1);
                $this->perPage = intval($data['per_page'] ?? 10);
                $this->total = intval($data['total'] ?? 0);
                $this->nextPageUrl = (string) ($data['next_page_url'] ?? '');
                $this->prevPageUrl = (string) ($data['prev_page_url'] ?? '');
                $this->path = (string) ($data['path'] ?? '');
                $this->error = null;

                return;
            }
            $this->error = (string) ($result['message'] ?? 'Gagal memuat data booking');
        } catch (\Throwable) {
            $this->error = 'Terjadi kesalahan saat mengambil data booking';
        }
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
            $url = $base.'/v1/master/bookings';

            $allBookings = [];
            $currentPage = 1;
            $lastPage = 1;

            do {
                $params = array_filter([
                    'from' => $this->exportFrom ? (string) $this->exportFrom : null,
                    'to' => $this->exportTo ? (string) $this->exportTo : null,
                    'page' => $currentPage,
                    'per_page' => 100,
                ], fn ($v) => $v !== null && $v !== '');

                $requestUrl = $url;
                if (! empty($params)) {
                    $requestUrl .= '?'.http_build_query($params);
                }

                $response = Http::withOptions(['verify' => filter_var(config('services.api.verify_ssl', true), FILTER_VALIDATE_BOOLEAN)])->withToken($token)->accept('application/json')->get($requestUrl);
                $result = $response->json();

                if ($response->successful() && ($result['success'] ?? false)) {
                    $data = (array) ($result['data'] ?? []);
                    $items = (array) ($data['data'] ?? []);
                    $allBookings = array_merge($allBookings, $items);
                    $lastPage = intval($data['last_page'] ?? 1);
                } else {
                    break;
                }

                $currentPage++;
            } while ($currentPage <= $lastPage);

            if ($this->exportFormat === 'xlsx') {
                $title = 'Data Booking Kencana Arena';
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
                    'Kode Booking',
                    'Tanggal',
                    'Jam',
                    'Pemesan',
                    'Komunitas',
                    'Lapangan',
                    'Status',
                    'Pemain',
                ];

                $rows = [];
                foreach ($allBookings as $index => $b) {
                    $tanggal = \Carbon\Carbon::parse(data_get($b, 'tanggal'))->format('d M Y');
                    $jam = substr(data_get($b, 'jam_mulai', ''), 0, 5).' - '.substr(data_get($b, 'jam_selesai', ''), 0, 5);
                    $pemesan = data_get($b, 'user.name') ?? data_get($b, 'pemesan.nama', '-');
                    $komunitas = data_get($b, 'nama_komunitas') ?? data_get($b, 'pemesan.nama_komunitas', '-');
                    $lapangan = data_get($b, 'lapangan.nama_lapangan') ?? data_get($b, 'lapangan.nama', '-');
                    $status = data_get($b, 'status', '-');
                    $pemain = data_get($b, 'jumlah_pemain', '-').' org';

                    $rows[] = [
                        $index + 1,
                        data_get($b, 'kode_booking', '-'),
                        $tanggal,
                        $jam,
                        $pemesan,
                        $komunitas,
                        $lapangan,
                        $status,
                        $pemain,
                    ];
                }

                $formats = [
                    'A' => 'center',
                    'B' => 'center',
                    'C' => 'center',
                    'D' => 'center',
                    'H' => 'center',
                    'I' => 'center',
                ];

                $spreadsheet = \App\Services\ExcelExportService::generate($title, $metadata, $headers, $rows, $formats);

                $filename = 'Export_Booking_'.time().'.xlsx';
                $path = 'exports/'.$filename;

                $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);

                if (! Storage::disk('local')->exists('exports')) {
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
                $pdf = Pdf::loadView('pdf.booking-export', [
                    'bookings' => $allBookings,
                    'from' => $this->exportFrom,
                    'to' => $this->exportTo,
                ]);

                // Save to local storage
                $filename = 'Export_Booking_'.time().'.pdf';
                $path = 'exports/'.$filename;

                Storage::disk('local')->put($path, $pdf->output());

                $this->exportPath = $path;
                $this->exportMessage = 'File PDF sudah siap di download.';
            }
        } catch (\Throwable $th) {
            $this->dispatch('toast', [
                'title' => 'Gagal',
                'message' => 'Terjadi kesalahan saat memproses export: '.$th->getMessage(),
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
            $filename = 'Export_Booking_'.date('Ymd_His').'.'.$ext;

            return response()->streamDownload(function () {
                echo Storage::disk('local')->get($this->exportPath);
            }, $filename);
        }
    }
};
