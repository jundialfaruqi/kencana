<?php

use Illuminate\Support\Facades\Route;

// Public Route
Route::livewire('/login', 'auth::login');
Route::livewire('/register', 'auth::register');
Route::livewire('/store', 'public::public.store');
Route::livewire('/', 'public::landing-page');

// Protected Public Route
Route::middleware(['api.auth'])->group(function () {
    Route::livewire('/booking', 'public::public.booking');
    Route::livewire('/profile', 'public::public.profile');
});

// Admin Route
Route::middleware(['api.auth:admin'])->group(function () {
    Route::livewire('/dashboard', 'admin::dashboard');

    // Manajemen User
    Route::livewire('/manajemen-user', 'admin::user');
    Route::livewire('/user-detail', 'admin::user-detail');
    Route::livewire('/user-update', 'admin::user-update');

    // Manajemen Lapangan
    Route::livewire('/manajemen-lapangan', 'admin::lapangan');
    Route::livewire('/lapangan-detail', 'admin::lapangan-detail');
    Route::livewire('/lapangan-create', 'admin::lapangan-create');
    Route::livewire('/lapangan-update', 'admin::lapangan-update');

    // Manajemen Jadwal Operasional
    Route::livewire('/manajemen-jadwal-operasional', 'admin::jadwal-operasional');
});
