<?php

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

// Nominatim Proxy — server-side to avoid browser CORS & rate-limit issues
Route::get('/api/geocode/reverse', function () {
    $lat = request('lat');
    $lng = request('lng');

    if (! $lat || ! $lng) {
        return response()->json(['error' => 'Missing lat/lng'], 422);
    }

    $response = Http::withHeaders(['User-Agent' => config('app.name').' geocoder'])
        ->get('https://nominatim.openstreetmap.org/reverse', [
            'format' => 'json',
            'lat' => $lat,
            'lon' => $lng,
            'zoom' => 18,
            'addressdetails' => 1,
        ]);

    return response()->json($response->json(), $response->status());
})->name('geocode.reverse');

Route::get('/api/geocode/search', function () {
    $query = request('q');

    if (! $query) {
        return response()->json(['error' => 'Missing query'], 422);
    }

    $response = Http::withHeaders(['User-Agent' => config('app.name').' geocoder'])
        ->get('https://nominatim.openstreetmap.org/search', [
            'format' => 'json',
            'q' => $query,
            'limit' => request('limit', 5),
        ]);

    return response()->json($response->json(), $response->status());
})->name('geocode.search');

// Dynamic Sitemap Route
Route::get('/sitemap.xml', function () {
    $baseUrl = rtrim((string) config('app.url'), '/');
    if (empty($baseUrl)) {
        $baseUrl = 'https://kencana.pekanbaru.go.id';
    }

    $sitemap = \Spatie\Sitemap\Sitemap::create();

    // Add static pages
    $sitemap->add(\Spatie\Sitemap\Tags\Url::create($baseUrl.'/')->setPriority(1.0)->setChangeFrequency(\Spatie\Sitemap\Tags\Url::CHANGE_FREQUENCY_DAILY))
        ->add(\Spatie\Sitemap\Tags\Url::create($baseUrl.'/lapangan')->setPriority(0.8)->setChangeFrequency(\Spatie\Sitemap\Tags\Url::CHANGE_FREQUENCY_WEEKLY));

    // Add dynamic arena pages
    try {
        $token = session()->get('auth_token');
        $base = rtrim((string) config('services.api.base_url'), '/');
        $url = $base.'/v1/master/lapangan';

        $req = Http::withOptions(['verify' => filter_var(config('services.api.verify_ssl', true), FILTER_VALIDATE_BOOLEAN)]);
        if ($token) {
            $req = $req->withToken($token);
        }
        $response = $req->accept('application/json')->get($url);
        $result = $response->json();

        if ($response->successful() && ($result['success'] ?? false)) {
            $lapanganList = (array) ($result['data'] ?? []);
            foreach ($lapanganList as $lapangan) {
                $slug = data_get($lapangan, 'slug');
                if ($slug) {
                    $sitemap->add(
                        \Spatie\Sitemap\Tags\Url::create($baseUrl.'/detail-lapangan/'.$slug)
                            ->setPriority(0.9)
                            ->setChangeFrequency(\Spatie\Sitemap\Tags\Url::CHANGE_FREQUENCY_WEEKLY)
                    );
                }
            }
        }
    } catch (\Throwable) {
        // Fallback
    }

    return $sitemap->toResponse(request());
})->name('sitemap');

// Public Route
Route::livewire('/login', 'auth::login')
    ->name('login');
Route::livewire('/register', 'auth::register')
    ->name('register');
Route::livewire('/store', 'public::public.store');
Route::livewire('/', 'public::landing-page')
    ->name('home');
Route::livewire('/lapangan', 'public::public.lapangan')
    ->name('lapangan');

Route::livewire('/detail-lapangan', 'public::public.detail-lapangan')
    ->name('detail-lapangan');
Route::livewire('/detail-lapangan/{slug}', 'public::public.detail-lapangan')
    ->name('detail-lapangan.slug');

// Protected Public Route
Route::middleware(['api.auth'])->group(function () {
    // Profile
    Route::livewire('/profile', 'public::public.profile');

    // Manajemen booking
    Route::livewire('/booking', 'public::public.booking');
    Route::livewire('/booking-history', 'public::public.booking-history');
    Route::livewire('/booking-detail/{kode_booking}', 'public::public.booking-detail');
});

// Admin Route
Route::middleware(['api.auth:admin'])->group(function () {
    // Protected APK Download Route
    Route::get('/admin/apk-download/{filename}', function ($filename) {
        $path = storage_path('app/private/apk-download/'.$filename);
        if (! file_exists($path)) {
            abort(404);
        }

        return response()->download($path);
    })->name('admin.apk-download');

    Route::livewire('/dashboard', 'admin::dashboard')
        ->name('dashboard');

    Route::livewire('/statistik-analitik', 'admin::statistik-analitik')
        ->name('statistik-analitik');

    // Manajemen User
    Route::livewire('/manajemen-user', 'admin::user')
        ->name('manajemen-user');
    Route::livewire('/user-detail', 'admin::user-detail')
        ->name('user-detail');
    Route::livewire('/user-update', 'admin::user-update')
        ->name('user-update');

    // Manajemen Lapangan atau booking lapangan
    Route::livewire('/manajemen-lapangan', 'admin::lapangan');
    Route::livewire('/lapangan-detail', 'admin::lapangan-detail');
    Route::livewire('/lapangan-create', 'admin::lapangan-create');
    Route::livewire('/lapangan-update', 'admin::lapangan-update');

    // Manajemen Jadwal Operasional
    Route::livewire('/manajemen-jadwal-operasional', 'admin::jadwal-operasional');
    Route::livewire('/jadwal-operasional-create', 'admin::jadwal-operasional-create');
    Route::livewire('/jadwal-operasional-update/{id}', 'admin::jadwal-operasional-update');
    Route::livewire('/jadwal-operasional-update', 'admin::jadwal-operasional-update');

    // Jadwal Khusus
    Route::livewire('/jadwal-khusus', 'admin::jadwal-khusus');
    Route::livewire('/jadwal-khusus-create', 'admin::jadwal-khusus-create');
    Route::livewire('/jadwal-khusus-update/{id}', 'admin::jadwal-khusus-update');

    // Manajemen Master Booking
    Route::livewire('/booking-master', 'admin::booking-master')
        ->name('booking-master');
    Route::livewire('/booking-detail', 'admin::booking-detail')
        ->name('booking-detail');

    // Catatan
    Route::livewire('/catatan', 'admin::catatan')
        ->name('catatan');
    Route::livewire('/catatan-create', 'admin::catatan-create')
        ->name('catatan-create');
    Route::livewire('/catatan-update/{id}', 'admin::catatan-update')
        ->name('catatan-update');

    // Banner Carousel
    Route::livewire('/banner-carousel', 'admin::banner-carousel')
        ->name('banner-carousel');
    Route::livewire('/banner-carousel-create', 'admin::banner-carousel-create')
        ->name('banner-carousel-create');
    Route::livewire('/banner-carousel-update/{id}', 'admin::banner-carousel-update')
        ->name('banner-carousel-update');
});
