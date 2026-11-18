<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

/** Pengaturan profil dan kata sandi pengguna yang sedang login. */
class UserAccountController extends Controller
{
    /** Tampilkan data profil dari akun terautentikasi. */
    public function edit(Request $request): View
    {
        return view('dashboard.profile', ['user' => $request->user()]);
    }

    /** Simpan profil dengan validasi unik email. Role tidak dapat diubah dari form ini. */
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

    /** Perbarui kata sandi hanya jika kata sandi lama terbukti benar. */
    public function password(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'string', 'min:8', 'confirmed', 'different:current_password'],
        ]);
        $request->user()->update(['password' => Hash::make($data['password'])]);
        return back()->with('status', 'Kata sandi berhasil diperbarui.');
    }
}
