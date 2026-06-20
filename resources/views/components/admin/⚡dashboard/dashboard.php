<?php

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Client\Response;
use Carbon\Carbon;

new #[Title('Dashboard')] #[Layout('layouts::admin.app')] class extends Component
{
    // Search Booking properties
    public string $searchQuery = '';
    public bool $isLoading = false;
    public ?array $bookingDetail = null;
    public ?string $searchError = null;
    public ?string $error = null;

    // Analytics properties
    public ?string $tahun = null;
    public ?string $lapanganId = null;
    public array $lapangans = [];
    
    // Arrays for charts
    public array $chartData = []; // monthly data
    public array $chartDaysLabels = [];
    public array $chartDaysData = [];
    public array $chartTimesLabels = [];
    public array $chartTimesData = [];
    
    public bool $isFetchingAnalytics = false;
    public ?string $analyticsError = null;

    public function load(): void
    {
        // Inisialisasi error saat komponen dimuat
        $this->error = null;
        $this->tahun = (string) date('Y');
        $this->lapanganId = 'all';
        
        $this->fetchLapangans();
        $this->fetchAnalytics();
        
        $this->dispatch('inputs-ready'); // Dispatch event when inputs are ready
    }

    public function updatedTahun(): void
    {
        $this->fetchAnalytics();
    }

    public function updatedLapanganId(): void
    {
        $this->fetchAnalytics();
    }

    public function fetchLapangans(): void
    {
        try {
            $token = Session::get('auth_token');
            $base = rtrim((string) config('services.api.base_url'), '/');
            $url = $base . '/v1/master/lapangan';
            
            $response = Http::withToken($token)->get($url);
            $json = $response->json();
            
            if ($response->successful() && ($json['success'] ?? false)) {
                $this->lapangans = $json['data']['data'] ?? [];
            }
        } catch (\Throwable) {
            $this->lapangans = [];
        }
    }

    public function fetchAnalytics(): void
    {
        $this->isFetchingAnalytics = true;
        $this->analyticsError = null;
        
        try {
            $token = Session::get('auth_token');
            $base = rtrim((string) config('services.api.base_url'), '/');
            $url = $base . '/v1/master/bookings';
            
            $from = $this->tahun . '-01-01';
            $to = $this->tahun . '-12-31';

            $allBookings = [];
            $currentPage = 1;
            $lastPage = 1;

            do {
                $params = array_filter([
                    'from' => $from,
                    'to' => $to,
                    'lapangan_id' => $this->lapanganId !== 'all' ? $this->lapanganId : null,
                    'page' => $currentPage,
                    'per_page' => 100,
                ], fn($v) => $v !== null && $v !== '');

                $requestUrl = $url;
                if (!empty($params)) {
                    $requestUrl .= '?' . http_build_query($params);
                }

                $response = Http::withToken($token)->accept('application/json')->get($requestUrl);
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
            
            $this->calculateAnalytics($allBookings);

        } catch (\Throwable $th) {
            $this->analyticsError = 'Gagal memuat data analitik.';
        } finally {
            $this->isFetchingAnalytics = false;
        }
    }

    protected function calculateAnalytics(array $bookings): void
    {
        $months = array_fill(1, 12, 0);
        $days = [];
        $times = [];
        
        // Initialize days for ordering correctly
        $orderedDays = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
        foreach ($orderedDays as $d) {
            $days[$d] = 0;
        }
        
        foreach ($bookings as $b) {
            $date = $b['tanggal'] ?? null;
            $jam = $b['jam_mulai'] ?? null;
            
            if ($date) {
                $carbonDate = Carbon::parse($date);
                $month = $carbonDate->month;
                $dayName = $carbonDate->locale('id')->isoFormat('dddd');
                
                $months[$month]++;
                
                if (isset($days[$dayName])) {
                    $days[$dayName]++;
                }
            }
            
            if ($jam) {
                $jamFormat = substr($jam, 0, 5);
                if (!isset($times[$jamFormat])) {
                    $times[$jamFormat] = 0;
                }
                $times[$jamFormat]++;
            }
        }
        
        // Sort times logically (e.g. 08:00, 09:00)
        ksort($times);
        
        $this->chartData = array_values($months);
        $this->chartDaysLabels = array_keys($days);
        $this->chartDaysData = array_values($days);
        $this->chartTimesLabels = array_keys($times);
        $this->chartTimesData = array_values($times);
        
        $this->dispatch('analytics-updated', [
            'chartData' => $this->chartData,
            'chartDaysLabels' => $this->chartDaysLabels,
            'chartDaysData' => $this->chartDaysData,
            'chartTimesLabels' => $this->chartTimesLabels,
            'chartTimesData' => $this->chartTimesData,
        ]);
    }

    protected function rules(): array
    {
        return [
            'searchQuery' => ['required', 'string', 'min:1'],
        ];
    }

    public function getJenisPermainanAlias(string $jenis): string
    {
        return match ($jenis) {
            'fun_match' => 'Fun Match',
            'latihan' => 'Latihan',
            'turnamen_kecil' => 'Turnamen Kecil',
            default => ucfirst(str_replace('_', ' ', $jenis)),
        };
    }

    public function searchBooking(): void
    {
        $this->resetValidation();
        $this->validate();

        $this->isLoading = true;
        $this->bookingDetail = null;
        $this->searchError = null;

        try {
            $token = Session::get('auth_token');
            $base = rtrim((string) config('services.api.base_url'), '/');
            $url = $base . '/v1/master/bookings?search=' . $this->searchQuery;

            /** @var Response $response */
            $response = Http::withToken($token)->get($url);
            $json = $response->json();

            if ($response->successful() && ($json['success'] ?? false)) {
                $nestedData = (array) ($json['data']['data'][0] ?? []);
                if (!empty($nestedData) && isset($nestedData['kode_booking'])) {
                    $this->bookingDetail = $nestedData;
                } else {
                    $this->searchError = 'Kode booking tidak ditemukan.';
                }
            } else {
                $this->searchError = (string) ($json['message'] ?? 'Gagal mencari kode booking.');
            }
        } catch (\Throwable) {
            $this->searchError = 'Terjadi kesalahan saat mencari kode booking.';
        } finally {
            $this->isLoading = false;
        }
    }
};
