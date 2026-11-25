<?php

declare(strict_types=1);

use App\Http\Controllers\Admin\ActivityLogController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\PreparationChecklistController;
use App\Http\Controllers\PublicBookingCheckController;
use App\Http\Controllers\Staff\DashboardController as StaffDashboardController;
use App\Http\Controllers\User\AccountController;
use App\Http\Controllers\User\BookingController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\User\RoomController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Rute aplikasi Atara Glamping: beranda publik, alur autentikasi (login/logout),
| serta dashboard ringkasan akun terpisah berdasarkan role (User, Staff, Admin).
|
*/

// Rute Publik
Route::get('/', [LandingController::class, 'index'])->name('home');
Route::get('/cek-reservasi', PublicBookingCheckController::class)->name('booking.check');
Route::get('/artikel/{slug}', [ArticleController::class, 'show'])->name('articles.show');
Route::get('/persiapan-glamping', PreparationChecklistController::class)
    ->name('preparation.checklist');

// Rute Tamu (Guest Only)
Route::middleware('guest')->group(function (): void {
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store'])->name('login.store');
    Route::get('/register', [RegisterController::class, 'create'])->name('register');
    Route::post('/register', [RegisterController::class, 'store'])->name('register.store');
});

// Rute Terautentikasi (Auth Only)
Route::middleware('auth')->group(function (): void {
    // Role Dispatcher untuk rute /dashboard
    Route::get('/dashboard', function (Request $request) {
        $role = $request->user()?->role;

        if ($role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        if ($role === 'staff') {
            return redirect()->route('staff.dashboard');
        }

        return app(UserDashboardController::class)($request);
    })->name('dashboard');

    // Rute Khusus Peran Tamu (User Role)
    Route::middleware('role:user')->prefix('dashboard')->group(function (): void {
        Route::get('/rooms', RoomController::class)->name('dashboard.rooms');
        Route::get('/rooms/{room}/book', [BookingController::class, 'create'])->name('dashboard.rooms.book');
        Route::post('/rooms/{room}/book', [BookingController::class, 'store'])->name('dashboard.rooms.reserve');
        Route::get('/bookings', [BookingController::class, 'index'])->name('dashboard.bookings');
        Route::get('/bookings/{code}', [BookingController::class, 'show'])->name('dashboard.bookings.show');
        Route::get('/cards', [BookingController::class, 'cards'])->name('dashboard.cards');
        Route::get('/payments', [BookingController::class, 'payments'])->name('dashboard.payments');
        Route::post('/bookings/{code}/pay', [BookingController::class, 'pay'])->name('dashboard.bookings.pay');
        Route::post('/bookings/{code}/discard', [BookingController::class, 'discard'])->name('dashboard.bookings.discard');
        Route::post('/bookings/{code}/cancellation', [BookingController::class, 'cancellation'])->name('dashboard.bookings.cancellation');
        Route::get('/profile', [AccountController::class, 'edit'])->name('dashboard.profile');
        Route::patch('/profile', [AccountController::class, 'update'])->name('dashboard.profile.update');
        Route::patch('/profile/password', [AccountController::class, 'password'])->name('dashboard.profile.password');
    });

    // Rute Khusus Peran Staf Operasional & Supervisi Admin
    Route::middleware('role:staff,admin')->prefix('staff')->group(function (): void {
        Route::get('/dashboard', StaffDashboardController::class)->name('staff.dashboard');
    });

    // Rute Khusus Administrator Sistem (Admin Role)
    Route::middleware('role:admin')->prefix('admin')->group(function (): void {
        Route::get('/dashboard', AdminDashboardController::class)->name('admin.dashboard');
        Route::get('/logs', ActivityLogController::class)->name('admin.logs');
        Route::resource('users', AdminUserController::class)
            ->except('show')
            ->names('admin.users');
    });

    Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');
});
