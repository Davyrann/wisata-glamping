<?php

declare(strict_types=1);

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\PreparationChecklistController;
use App\Http\Controllers\UserBookingController;
use App\Http\Controllers\UserPaymentController;
use App\Http\Controllers\UserCancellationController;
use App\Http\Controllers\UserAccountController;
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
    Route::get('/dashboard/bookings', [UserBookingController::class, 'index'])->name('dashboard.bookings');
    Route::get('/dashboard/bookings/{code}', [UserBookingController::class, 'show'])->name('dashboard.bookings.show');
    Route::get('/dashboard/cards', [UserBookingController::class, 'cards'])->name('dashboard.cards');
    Route::get('/dashboard/payments', [UserPaymentController::class, 'index'])->name('dashboard.payments');
    Route::post('/dashboard/bookings/{code}/pay', [UserPaymentController::class, 'pay'])->name('dashboard.bookings.pay');
    Route::post('/dashboard/bookings/{code}/discard', [UserPaymentController::class, 'discard'])->name('dashboard.bookings.discard');
    Route::post('/dashboard/bookings/{code}/cancellation', [UserCancellationController::class, 'store'])->name('dashboard.bookings.cancellation');
    Route::get('/dashboard/profile', [UserAccountController::class, 'edit'])->name('dashboard.profile');
    Route::patch('/dashboard/profile', [UserAccountController::class, 'update'])->name('dashboard.profile.update');
    Route::patch('/dashboard/profile/password', [UserAccountController::class, 'password'])->name('dashboard.profile.password');
    Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');
});
