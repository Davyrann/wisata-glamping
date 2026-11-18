<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#161816">
    <title>Profil & Keamanan | Atara Glamping</title>
    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:wght@500;600&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* Layout Profil ATARA: sidebar tetap penuh; dua form muat pada desktop.
           Tidak mematikan scroll paksa agar validasi/zoom tidak memotong tombol. */
        .profile-shell { min-height: 100dvh; }
        .profile-sidebar { background: #161816; }
        .profile-content { min-width: 0; }
        .profile-form input:focus-visible { outline: 2px solid #2C4636; outline-offset: 1px; }

        @media (min-width: 1024px) {
            .profile-shell { min-height: 100dvh; display: flex; align-items: stretch; }
            .profile-sidebar { height: 100dvh; min-height: 100dvh; position: sticky; top: 0; display: flex; flex-direction: column; }
            .profile-sidebar nav { flex: 1 1 auto; }
            .profile-sidebar .profile-sidebar-footer { margin-top: auto; flex-shrink: 0; }
            .profile-content { min-height: 100dvh; }
            .profile-header { min-height: 58px !important; padding-top: 7px !important; padding-bottom: 7px !important; }
            .profile-header > a { min-height: 39px !important; }
            .profile-main { padding-top: 12px !important; padding-bottom: 12px !important; }
            .profile-eyebrow { font-size: 11px !important; margin-bottom: 2px !important; }
            .profile-title { font-size: clamp(26px, 2.3vw, 34px) !important; line-height: 1.1 !important; }
            .profile-intro { margin-top: 5px !important; margin-bottom: 11px !important; font-size: 13px !important; line-height: 1.35 !important; }
            .profile-panels { gap: 14px !important; }
            .profile-panel { padding: 14px 18px !important; }
            .profile-panel-heading { margin-bottom: 8px !important; font-size: 17px !important; line-height: 1.25 !important; }
            .profile-form { display: grid; gap: 7px !important; align-content: start; }
            .profile-form > :not([hidden]) ~ :not([hidden]) { margin-top: 0 !important; }
            .profile-form label { font-size: 12px !important; line-height: 1.25 !important; }
            .profile-form input { display: block; width: 100%; height: 39px !important; min-height: 39px !important; margin-top: 4px !important; font-size: 13px !important; }
            .profile-form button { min-height: 38px !important; padding: 0 16px !important; justify-self: start; font-size: 13px !important; }
            .profile-help { margin-top: 7px !important; font-size: 10.5px !important; line-height: 1.3 !important; }
        }
        /* Layar desktop pendek: lebih kompak, tanpa mengubah sidebar. */
        @media (min-width: 1024px) and (max-height: 700px) {
            .profile-header { min-height: 52px !important; }
            .profile-main { padding-top: 7px !important; padding-bottom: 8px !important; }
            .profile-title { font-size: 28px !important; }
            .profile-intro { margin-bottom: 8px !important; }
            .profile-panel { padding: 11px 15px !important; }
            .profile-panel-heading { margin-bottom: 6px !important; }
            .profile-form { gap: 5px !important; }
            .profile-form input { height: 36px !important; min-height: 36px !important; }
            .profile-form button { min-height: 36px !important; }
        }
        /* Pada HP/tablet, scroll tetap aman untuk input dan keyboard virtual. */
    </style>

</head>
<body class="min-h-screen bg-paper text-text font-sans antialiased">
<div class="profile-shell min-h-screen lg:flex">
    <aside class="profile-sidebar hidden sm:flex sm:w-16 lg:w-[248px] shrink-0 flex-col bg-ink-900 text-text-on-ink min-h-screen sticky top-0 h-screen">
        <a href="{{ route('home') }}" class="flex items-center justify-center lg:justify-start gap-3 px-3 lg:px-6 h-20 border-b border-white/10" aria-label="Atara, kembali ke beranda">
            <img src="{{ asset('images/logo/atara-logo-mark.svg') }}" alt="" class="h-9 w-9 object-contain bg-white rounded-sm p-1">
            <span class="hidden lg:block text-xl tracking-[0.2em] font-semibold">ATARA</span>
        </a>
        <nav class="px-2 lg:px-3 py-6 space-y-1" aria-label="Navigasi akun">
            <a href="{{ route('dashboard') }}" class="flex items-center justify-center lg:justify-start gap-3 min-h-11 px-3 text-text-on-ink/80 hover:bg-ink-800 rounded-md text-sm">
                <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" aria-hidden="true"><rect x="3" y="3" width="8" height="8" rx="1"/><rect x="13" y="3" width="8" height="8" rx="1"/><rect x="3" y="13" width="8" height="8" rx="1"/><rect x="13" y="13" width="8" height="8" rx="1"/></svg>
                <span class="hidden lg:block">Ringkasan</span>
            </a>
            <a href="{{ route('dashboard.bookings') }}" class="flex items-center justify-center lg:justify-start gap-3 min-h-11 px-3 text-text-on-ink/80 hover:bg-ink-800 rounded-md text-sm">
                <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" aria-hidden="true"><rect x="4" y="5" width="16" height="14" rx="2"/><path d="M8 9h8M8 13h6"/></svg>
                <span class="hidden lg:block">Pesanan Saya</span>
            </a>
            <a href="{{ route('dashboard.cards') }}" class="flex items-center justify-center lg:justify-start min-h-11 gap-3 px-3 text-text-on-ink/80 hover:bg-ink-800 rounded-md text-sm" aria-label="Kartu Digital"><svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" aria-hidden="true"><rect x="3" y="5" width="16" height="14" rx="2"/><path d="M7 9h4v4H7zM14 9h3M14 13h3"/></svg><span class="hidden lg:block">Kartu Digital</span></a>
            <a href="{{ route('dashboard.payments') }}" class="flex items-center justify-center lg:justify-start min-h-11 gap-3 px-3 text-text-on-ink/80 hover:bg-ink-800 rounded-md text-sm"><svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" aria-hidden="true"><rect x="4" y="5" width="16" height="14" rx="2"/><path d="M8 9h8M8 13h6"/></svg><span class="hidden lg:block">Pembayaran</span></a>
            <a href="{{ route('dashboard.profile') }}" aria-current="page" class="flex items-center justify-center lg:justify-start min-h-11 gap-3 px-3 bg-ink-800 border-l-2 border-ember-600 text-white rounded-r-md font-semibold text-sm"><svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" aria-hidden="true"><circle cx="12" cy="8" r="4"/><path d="M4 21c0-5 16-5 16 0"/></svg><span class="hidden lg:block">Profil & Keamanan</span></a>
        </nav>
        <div class="profile-sidebar-footer mt-auto border-t border-white/10 px-3 lg:px-5 py-5">
            <div class="hidden lg:block mb-3">
                <p class="font-semibold text-sm truncate">{{ $user->name }}</p>
                <p class="text-xs text-text-on-ink/60 truncate">{{ $user->email }}</p>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full min-h-10 px-2 lg:px-3 text-xs lg:text-sm border border-white/20 rounded-md hover:bg-ink-800 focus-visible:outline-2 focus-visible:outline-white" aria-label="Keluar dari akun">Keluar</button>
            </form>
        </div>
    </aside>

    <div class="profile-content flex-1 min-w-0">
        <header class="profile-header min-h-16 bg-paper border-b border-line flex items-center justify-between gap-3 px-5 sm:px-7 lg:px-9 py-3">
            <div class="min-w-0">
                <p class="text-xs text-text-muted">Akun tamu / Profil & Keamanan</p>
                <p class="text-sm font-semibold truncate">Halo, {{ $user->name }}</p>
            </div>
            <a href="{{ route('home') }}#kamar" class="inline-flex items-center justify-center rounded-md bg-pine-700 hover:bg-pine-600 text-white text-sm font-semibold px-3 sm:px-4 min-h-11 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-pine-700">Pesan lagi</a>
        </header>
        <main class="profile-main max-w-[1120px] mx-auto px-5 sm:px-7 lg:px-9 py-8 pb-28 sm:pb-10">
            <p class="profile-eyebrow text-xs tracking-[0.14em] uppercase text-text-muted mb-3">Area tamu Atara</p>
            <h1 class="profile-title font-display text-[clamp(1.8rem,3vw,2.5rem)] font-semibold leading-tight">Profil & Keamanan</h1>
            @if (session('status'))<div role="status" class="mt-5 rounded-md border border-line bg-surface px-4 py-3 text-sm text-pine-700">{{ session('status') }}</div>@endif
            @if ($errors->any())<div role="alert" class="mt-5 rounded-md border border-line bg-surface px-4 py-3 text-sm text-red-700">{{ $errors->first() }}</div>@endif
            <p class="profile-intro mt-3 mb-7 text-text-muted text-sm sm:text-base">Perbarui informasi kontak dan keamanan akun. Perubahan disimpan dalam database.</p>
            <div class="profile-panels grid lg:grid-cols-2 gap-5 items-start">
              <section class="profile-panel bg-surface border border-line rounded-[10px] p-5 sm:p-7"><h2 class="profile-panel-heading font-semibold text-lg mb-5">Data pribadi</h2>
                <form method="POST" action="{{ route('dashboard.profile.update') }}" class="profile-form space-y-4">@csrf @method('PATCH')
                  <label class="block text-sm font-semibold">Nama lengkap<input required maxlength="255" name="name" value="{{ old('name',$user->name) }}" class="block w-full mt-2 min-h-11 border border-line-strong rounded-md px-3 bg-surface"></label>
                  <label class="block text-sm font-semibold">Email<input required type="email" name="email" maxlength="255" value="{{ old('email',$user->email) }}" class="block w-full mt-2 min-h-11 border border-line-strong rounded-md px-3 bg-surface"></label>
                  <label class="block text-sm font-semibold">Nomor telepon<input name="phone" maxlength="30" value="{{ old('phone',$user->phone) }}" class="block w-full mt-2 min-h-11 border border-line-strong rounded-md px-3 bg-surface"></label>
                  <button class="bg-pine-700 text-white rounded-md font-semibold min-h-11 px-5">Simpan profil</button>
                </form>
              </section>
              <section class="profile-panel bg-surface border border-line rounded-[10px] p-5 sm:p-7"><h2 class="profile-panel-heading font-semibold text-lg mb-5">Ubah kata sandi</h2>
                <form method="POST" action="{{ route('dashboard.profile.password') }}" class="profile-form space-y-4">@csrf @method('PATCH')
                  <label class="block text-sm font-semibold">Kata sandi sekarang<input required type="password" name="current_password" autocomplete="current-password" class="block w-full mt-2 min-h-11 border border-line-strong rounded-md px-3 bg-surface"></label>
                  <label class="block text-sm font-semibold">Kata sandi baru<input required type="password" minlength="8" name="password" autocomplete="new-password" class="block w-full mt-2 min-h-11 border border-line-strong rounded-md px-3 bg-surface"></label>
                  <label class="block text-sm font-semibold">Konfirmasi kata sandi baru<input required type="password" minlength="8" name="password_confirmation" autocomplete="new-password" class="block w-full mt-2 min-h-11 border border-line-strong rounded-md px-3 bg-surface"></label>
                  <button class="bg-pine-700 text-white rounded-md font-semibold min-h-11 px-5">Ubah kata sandi</button>
                </form><p class="profile-help text-text-muted text-xs mt-4">Kata sandi demo dapat berubah jika diperbarui melalui formulir ini. Penguji dapat mengembalikan data demo sesuai instruksi deployment.</p>
              </section>
            </div>

        </main>
    </div>
</div>
<nav class="sm:hidden fixed bottom-0 inset-x-0 bg-ink-900 text-text-on-ink border-t border-white/10 flex justify-around items-center px-2 pt-2 pb-[max(0.5rem,env(safe-area-inset-bottom))] z-30" aria-label="Navigasi akun seluler">
    <a href="{{ route('dashboard') }}" class="flex-1 text-center text-xs text-text-on-ink/80 py-2 min-h-11 flex items-center justify-center">Ringkasan</a>
    <a href="{{ route('dashboard.bookings') }}" class="flex-1 text-center text-xs text-text-on-ink/80 py-2 min-h-11 flex items-center justify-center">Pesanan</a>
    <a href="{{ route('dashboard.cards') }}" class="flex-1 text-center text-xs text-text-on-ink/80 py-2 min-h-11 flex items-center justify-center">Kartu QR</a>
    <a href="{{ route('dashboard.profile') }}" aria-current="page" class="flex-1 text-center text-xs text-white font-semibold py-2 border-t-2 border-ember-600 min-h-11 flex items-center justify-center">Akun</a>
</nav>
<script>
    document.querySelectorAll('[data-copy-code]').forEach((button) => {
        button.addEventListener('click', async () => {
            try {
                await navigator.clipboard.writeText(button.dataset.copyCode);
                button.textContent = 'Tersalin';
            } catch (error) {
                button.textContent = 'Salin manual dari kartu';
            }
        });
    });
</script>
</body>
</html>
