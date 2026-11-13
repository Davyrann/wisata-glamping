<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\ActivityLog;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Class LoginController
 *
 * Mengelola siklus autentikasi pengguna: menampilkan antarmuka login,
 * memproses verifikasi sesi masuk, mencatat log audit untuk peran staff/admin,
 * serta menangani proses keluar (logout).
 */
class LoginController extends Controller
{
    /**
     * Menampilkan formulir login Atara Glamping.
     *
     * Jika pengguna sudah dalam keadaan login, otomatis dialihkan ke halaman dashboard.
     */
    public function create(): View|RedirectResponse
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        return view('auth.login');
    }

    /**
     * Memproses permintaan masuk (login) pengguna.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $user = $request->user();

        // Mencatat log aktivitas untuk peran staff dan admin sesuai PRD & Agent Guidelines
        if ($user !== null && in_array($user->role, ['staff', 'admin'], true)) {
            ActivityLog::create([
                'user_id' => $user->id,
                'action' => 'login',
                'description' => "Pengguna {$user->name} ({$user->role}) berhasil masuk ke dalam sistem.",
                'ip_address' => $request->ip(),
            ]);
        }

        return redirect()->intended(route('dashboard'));
    }

    /**
     * Memproses keluar (logout) dan memutus sesi pengguna saat ini.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $user = $request->user();

        if ($user !== null && in_array($user->role, ['staff', 'admin'], true)) {
            ActivityLog::create([
                'user_id' => $user->id,
                'action' => 'logout',
                'description' => "Pengguna {$user->name} ({$user->role}) telah keluar dari sistem.",
                'ip_address' => $request->ip(),
            ]);
        }

        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('status', 'Anda telah berhasil keluar dari akun.');
    }
}
