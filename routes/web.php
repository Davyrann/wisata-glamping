<?php

declare(strict_types=1);

use App\Http\Controllers\LandingController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Rute publik aplikasi Atara Glamping.
|
*/

Route::get('/', [LandingController::class, 'index'])->name('home');
Route::get('/login', [LandingController::class, 'authUnavailable'])->name('login');
