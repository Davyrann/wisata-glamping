<?php

declare(strict_types=1);

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\PreparationChecklistController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Rute aplikasi Atara Glamping: beranda publik, alur autentikasi (login/logout),
| serta dashboard ringkasan akun pengguna.
|
*/

// Rute Publik
Route::get('/', [LandingController::class, 'index'])->name('home');
Route::get('/persiapan-glamping', PreparationChecklistController::class)
    ->name('preparation.checklist');

// Rute Tamu (Guest Only)
Route::middleware('guest')->group(function (): void {
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store'])->name('login.store');
});

// Rute Terautentikasi (Auth Only)
Route::middleware('auth')->group(function (): void {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');
});
