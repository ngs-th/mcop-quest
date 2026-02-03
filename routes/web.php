<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Pages\WorldMap;
use App\Livewire\Pages\ActivityLog;
use App\Livewire\Pages\Shop;
use App\Livewire\Pages\CommanderDetail;
use App\Livewire\Pages\Hero;
use App\Livewire\Pages\CityDetail;
use App\Livewire\Pages\Team;

Route::view('/', 'welcome');

Route::get('/dashboard', WorldMap::class)
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('/activity', ActivityLog::class)
    ->middleware(['auth'])
    ->name('activity');

Route::get('/shop', Shop::class)
    ->middleware(['auth'])
    ->name('shop');

Route::get('/commander/{id}', CommanderDetail::class)
    ->middleware(['auth'])
    ->name('commander.detail');

Route::get('/hero', Hero::class)
    ->middleware(['auth'])
    ->name('hero');

Route::get('/city/{id}', CityDetail::class)
    ->middleware(['auth'])
    ->name('city.detail');

Route::get('/team', Team::class)
    ->middleware(['auth'])
    ->name('team');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
