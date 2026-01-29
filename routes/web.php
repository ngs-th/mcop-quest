<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Pages\WorldMap;

Route::view('/', 'welcome');

Route::get('/dashboard', WorldMap::class)
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
