@extends('layouts.dashboard', [
    'title' => 'Profil & Keamanan',
    'subtitle' => 'Area Tamu Atara / Profil & Keamanan'
])

@section('content')
<div class="mb-7">
    <p class="text-xs tracking-[0.14em] uppercase text-text-muted mb-2">Pengaturan Akun</p>
    <h1 class="font-display text-[clamp(1.8rem,3vw,2.5rem)] font-semibold leading-tight">Profil & Keamanan</h1>
    <p class="mt-2 text-text-muted text-sm sm:text-base">Perbarui informasi kontak dan kata sandi akun Anda untuk keamanan transaksi.</p>
</div>

<div class="grid lg:grid-cols-2 gap-6 items-start">
    <!-- Form Data Pribadi -->
    <section class="bg-surface border border-line rounded-[10px] p-5 sm:p-7 shadow-sm">
        <h2 class="font-semibold text-lg mb-1">Data Pribadi</h2>
        <p class="text-xs text-text-muted mb-5">Informasi kontak Anda digunakan untuk komunikasi reservasi kamar.</p>

        <form method="POST" action="{{ route('dashboard.profile.update') }}" class="space-y-4">
            @csrf
            @method('PATCH')
            <label class="block text-xs font-semibold text-text-muted">Nama Lengkap
                <input required maxlength="255" name="name" value="{{ old('name', $user->name) }}" class="block w-full mt-1.5 h-10 border border-line-strong rounded-md px-3 text-sm text-text bg-surface focus:outline-2 focus:outline-pine-700">
            </label>
            <label class="block text-xs font-semibold text-text-muted">Alamat Email
                <input required type="email" name="email" maxlength="255" value="{{ old('email', $user->email) }}" class="block w-full mt-1.5 h-10 border border-line-strong rounded-md px-3 text-sm text-text bg-surface focus:outline-2 focus:outline-pine-700">
            </label>
            <label class="block text-xs font-semibold text-text-muted">Nomor Telepon
                <input name="phone" maxlength="30" value="{{ old('phone', $user->phone) }}" placeholder="Contoh: 081234567890" class="block w-full mt-1.5 h-10 border border-line-strong rounded-md px-3 text-sm text-text bg-surface focus:outline-2 focus:outline-pine-700">
            </label>
            <button type="submit" class="bg-pine-700 hover:bg-pine-600 text-white rounded-md font-semibold text-xs min-h-10 px-5 transition-colors">
                Simpan Perubahan Profil
            </button>
        </form>
    </section>

    <!-- Form Ganti Kata Sandi -->
    <section class="bg-surface border border-line rounded-[10px] p-5 sm:p-7 shadow-sm">
        <h2 class="font-semibold text-lg mb-1">Ubah Kata Sandi</h2>
        <p class="text-xs text-text-muted mb-5">Pastikan kata sandi baru terdiri minimal 8 karakter yang aman.</p>

        <form method="POST" action="{{ route('dashboard.profile.password') }}" class="space-y-4">
            @csrf
            @method('PATCH')
            <label class="block text-xs font-semibold text-text-muted">Kata Sandi Saat Ini
                <input required type="password" name="current_password" autocomplete="current-password" class="block w-full mt-1.5 h-10 border border-line-strong rounded-md px-3 text-sm text-text bg-surface focus:outline-2 focus:outline-pine-700">
            </label>
            <label class="block text-xs font-semibold text-text-muted">Kata Sandi Baru
                <input required type="password" minlength="8" name="password" autocomplete="new-password" class="block w-full mt-1.5 h-10 border border-line-strong rounded-md px-3 text-sm text-text bg-surface focus:outline-2 focus:outline-pine-700">
            </label>
            <label class="block text-xs font-semibold text-text-muted">Konfirmasi Kata Sandi Baru
                <input required type="password" minlength="8" name="password_confirmation" autocomplete="new-password" class="block w-full mt-1.5 h-10 border border-line-strong rounded-md px-3 text-sm text-text bg-surface focus:outline-2 focus:outline-pine-700">
            </label>
            <button type="submit" class="bg-pine-700 hover:bg-pine-600 text-white rounded-md font-semibold text-xs min-h-10 px-5 transition-colors">
                Perbarui Kata Sandi
            </button>
        </form>
    </section>

    <!-- Sesi & Tombol Keluar (Terutama untuk Pengguna Mobile) -->
    <section class="bg-surface border border-line rounded-[10px] p-5 sm:p-7 shadow-sm lg:col-span-2">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h2 class="font-semibold text-base mb-1 text-text">Sesi Akun</h2>
                <p class="text-xs text-text-muted">Keluar dari akun Anda di perangkat ini untuk mengakhiri sesi aktif.</p>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="inline-flex items-center justify-center min-h-11 px-5 border border-red-300 text-red-700 hover:bg-red-50 rounded-md font-semibold text-xs transition-colors w-full sm:w-auto">
                    <svg class="w-4 h-4 mr-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                    Keluar dari Akun
                </button>
            </form>
        </div>
    </section>
</div>
@endsection
