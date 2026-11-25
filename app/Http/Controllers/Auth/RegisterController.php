<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Mengelola registrasi mandiri khusus untuk peran Tamu (User).
 */
class RegisterController extends Controller
{
    /**
     * Tampilkan formulir pendaftaran akun tamu baru.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Simpan akun tamu baru dengan peran terkunci sebagai 'user' lalu login otomatis.
     */
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'phone' => ['nullable', 'string', 'max:30', 'regex:/^[0-9+() .-]*$/'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'] ?? null,
            'password' => $data['password'],
            'role' => 'user',
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('dashboard')
            ->with('status', 'Akun berhasil dibuat. Selamat datang di Atara Glamping.');
    }
}
