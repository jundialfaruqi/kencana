<?php

use Illuminate\Support\Facades\Route;

// Public Route
Route::livewire('/login', 'auth::login');
Route::livewire('/register', 'auth::register');
Route::livewire('/store', 'public::public.store');
Route::livewire('/', 'public::landing-page');

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
    Route::livewire('/dashboard', 'admin::dashboard');

    // Manajemen User
    Route::livewire('/manajemen-user', 'admin::user');
    Route::livewire('/user-detail', 'admin::user-detail');
    Route::livewire('/user-update', 'admin::user-update');

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
    Route::livewire('/booking-master', 'admin::booking-master');
    Route::livewire('/booking-detail', 'admin::booking-detail');

    // Catatan
    Route::livewire('/catatan', 'admin::catatan');
    Route::livewire('/catatan-create', 'admin::catatan-create');

    // Banner Carousel
    Route::livewire('/banner-carousel', 'admin::banner-carousel');
    Route::livewire('/banner-carousel-create', 'admin::banner-carousel-create');
    Route::livewire('/banner-carousel-update/{id}', 'admin::banner-carousel-update');
    Route::livewire('/banner-carousel-detail/{id}', 'admin::banner-carousel-detail');
});
