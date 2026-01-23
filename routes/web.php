<?php

use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::livewire('/login', 'auth::login');
Route::livewire('/booking', 'landing-page::landing-page.booking');
Route::livewire('/', 'landing-page::landing-page');
