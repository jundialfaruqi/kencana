<?php

use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::livewire('/login', 'auth::login');
Route::livewire('/booking', 'public::public.booking');
Route::livewire('/store', 'public::public.store');
Route::livewire('/', 'public::landing-page');
