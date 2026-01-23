<?php

use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::livewire('/login', 'auth::login');
Route::livewire('/', 'landing-page::landing-page');
