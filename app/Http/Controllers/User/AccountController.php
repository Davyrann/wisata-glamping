<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

/**
 * Pengaturan profil dan kata sandi pengguna tamu yang sedang login.
 */
class AccountController extends Controller
{
    /**
     * Tampilkan data profil dari akun tamu terautentikasi.
     */
    public function edit(Request $request): View
    {
        return view('user.profile', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Simpan pembaruan profil dengan validasi keunikan email.
     * Peran akun (role) tidak dapat dimanipulasi dari form ini.
     */
    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'phone' => ['nullable', 'string', 'max:30', 'regex:/^[0-9+() .-]*$/'],
        ]);

        $user->update($data);

        return back()->with('status', 'Profil berhasil diperbarui.');
    }

    /**
     * Perbarui kata sandi akun jika kata sandi saat ini terverifikasi benar.
     */
    public function password(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'string', 'min:8', 'confirmed', 'different:current_password'],
        ]);

        $request->user()->update([
            'password' => $data['password'],
        ]);

        return back()->with('status', 'Kata sandi berhasil diperbarui.');
    }
}
