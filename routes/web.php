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
    Route::livewire('/banner-carousel-detail/{id}', 'admin::banner-carousel-detail')
        ->name('banner-carousel-detail');
});
