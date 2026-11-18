<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#161816">
    <title>Ringkasan Akun | Atara Glamping</title>
    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:wght@500;600&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-paper text-text font-sans antialiased">
    <div class="min-h-screen lg:flex">
        <!-- Navigasi samping desktop; tablet menggunakan rail ringkas. -->
        <aside class="hidden sm:flex sm:w-16 lg:w-[248px] shrink-0 flex-col bg-ink-900 text-text-on-ink min-h-screen sticky top-0 h-screen">
            <a href="{{ route('home') }}" class="flex items-center justify-center lg:justify-start gap-3 px-3 lg:px-6 h-20 border-b border-white/10" aria-label="Atara, kembali ke beranda">
                <img src="{{ asset('images/logo/atara-logo-mark.svg') }}" alt="" class="h-9 w-9 object-contain bg-white rounded-sm p-1">
                <span class="hidden lg:block text-xl tracking-[0.2em] font-semibold">ATARA</span>
            </a>
            <nav class="px-2 lg:px-3 py-6 space-y-1" aria-label="Navigasi akun">
                <a href="{{ route('dashboard') }}" aria-current="page" class="flex items-center justify-center lg:justify-start gap-3 min-h-11 px-3 bg-ink-800 border-l-2 border-ember-600 text-white rounded-r-md font-semibold text-sm">
                    <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" aria-hidden="true"><rect x="3" y="3" width="8" height="8" rx="1"/><rect x="13" y="3" width="8" height="8" rx="1"/><rect x="3" y="13" width="8" height="8" rx="1"/><rect x="13" y="13" width="8" height="8" rx="1"/></svg>
                    <span class="hidden lg:block">Ringkasan</span>
                </a>
                <a href="{{ route('dashboard.bookings') }}" class="flex items-center justify-center lg:justify-start min-h-11 gap-3 px-3 text-text-on-ink/80 hover:bg-ink-800 rounded-md text-sm" aria-label="Pesanan Saya">
                    <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" aria-hidden="true"><rect x="4" y="5" width="16" height="14" rx="2"/><path d="M8 9h8M8 13h6"/></svg>
                    <span class="hidden lg:block">Pesanan Saya</span>
                </a>
                <a href="{{ route('dashboard.cards') }}" class="flex items-center justify-center lg:justify-start min-h-11 gap-3 px-3 text-text-on-ink/80 hover:bg-ink-800 rounded-md text-sm" aria-label="Kartu Digital">
                    <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" aria-hidden="true"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="M7 9h4v4H7zM14 9h3M14 13h3"/></svg><span class="hidden lg:block">Kartu Digital</span>
                </a>
            <a href="{{ route('dashboard.payments') }}" class="flex items-center justify-center lg:justify-start min-h-11 gap-3 px-3 text-text-on-ink/80 hover:bg-ink-800 rounded-md text-sm"><svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" aria-hidden="true"><rect x="4" y="5" width="16" height="14" rx="2"/><path d="M8 9h8M8 13h6"/></svg><span class="hidden lg:block">Pembayaran</span></a>
            <a href="{{ route('dashboard.profile') }}" class="flex items-center justify-center lg:justify-start min-h-11 gap-3 px-3 text-text-on-ink/80 hover:bg-ink-800 rounded-md text-sm"><svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" aria-hidden="true"><circle cx="12" cy="8" r="4"/><path d="M4 21c0-5 16-5 16 0"/></svg><span class="hidden lg:block">Profil & Keamanan</span></a>

            </nav>
            <div class="mt-auto border-t border-white/10 px-3 lg:px-5 py-5">
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

        <div class="flex-1 min-w-0">
            <header class="h-16 bg-paper border-b border-line flex items-center justify-between gap-3 px-5 sm:px-7 lg:px-9">
                <div class="min-w-0">
                    <p class="text-xs text-text-muted">Akun tamu / Ringkasan</p>
                    <p class="text-sm font-semibold truncate">Halo, {{ $user->name }}</p>
                </div>
                <a href="{{ route('home') }}#kamar" class="inline-flex items-center justify-center rounded-md bg-pine-700 hover:bg-pine-600 text-white text-sm font-semibold px-4 min-h-10 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-pine-700">Jelajahi kamar</a>
            </header>

            <main class="max-w-[1120px] mx-auto px-5 sm:px-7 lg:px-9 py-8 pb-28 sm:pb-10">
                <div class="mb-8">
                    <p class="text-xs tracking-[0.14em] uppercase text-text-muted mb-3">Area tamu Atara</p>
                    <h1 class="font-display text-[clamp(1.8rem,3vw,2.5rem)] font-semibold leading-tight">Ringkasan akun</h1>
                    <p class="mt-3 max-w-2xl text-text-muted text-sm sm:text-base">Selamat datang kembali. Kelola perjalanan dan informasi akunmu dari satu tempat.</p>
                </div>

                <div class="grid lg:grid-cols-[minmax(0,1.5fr)_minmax(260px,1fr)] gap-5">
                    <section class="bg-surface border border-line rounded-[10px] p-5 sm:p-7" aria-labelledby="booking-title">
                        <div class="flex flex-wrap items-start justify-between gap-3">
                            <div>
                                <p class="text-xs tracking-wider text-text-muted mb-2">RESERVASI</p>
                                <h2 id="booking-title" class="font-semibold text-lg">Pesanan Anda</h2>
                            </div>
                            <a href="{{ route('dashboard.bookings') }}" class="text-xs rounded-md border border-line-strong px-3 py-2 text-pine-700 hover:bg-sunken">Lihat pesanan</a>
                        </div>
                        <div class="mt-8 py-8 border-t border-line text-center">
                            <svg class="w-10 h-10 mx-auto text-text-faint" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><rect x="3" y="5" width="18" height="16" rx="2"/><path d="M7 3v4m10-4v4M3 10h18m-13 4h4"/></svg>
                            <p class="mt-4 font-semibold">Riwayat reservasi belum ditampilkan</p>
                            <p class="mt-2 text-sm text-text-muted max-w-sm mx-auto">Data reservasi akan muncul di sini setelah modul pemesanan dihubungkan ke dashboard.</p>
                            <a href="{{ route('home') }}#kamar" class="inline-flex mt-6 items-center justify-center min-h-10 px-4 rounded-md bg-pine-700 text-white hover:bg-pine-600 font-semibold text-sm">Lihat pilihan kamar</a>
                        </div>
                    </section>
                    <section class="bg-surface border border-line rounded-[10px] p-5 sm:p-7" aria-labelledby="account-title">
                        <p class="text-xs tracking-wider text-text-muted mb-2">INFORMASI PRIBADI</p>
                        <h2 id="account-title" class="font-semibold text-lg mb-6">Akun Anda</h2>
                        <dl class="space-y-5 text-sm">
                            <div><dt class="text-text-muted mb-1">Nama lengkap</dt><dd class="font-semibold break-words">{{ $user->name }}</dd></div>
                            <div><dt class="text-text-muted mb-1">Alamat email</dt><dd class="font-semibold break-all">{{ $user->email }}</dd></div>
                            <div><dt class="text-text-muted mb-1">Nomor telepon</dt><dd class="font-semibold">{{ $user->phone ?: 'Belum ditambahkan' }}</dd></div>
                        </dl>
                        <p class="mt-6 pt-4 border-t border-line text-xs text-text-muted">Pengeditan profil akan tersedia setelah modul akun selesai.</p>
                    </section>
                </div>
                <div class="mt-5 border border-line rounded-[10px] bg-sunken px-5 py-4 text-sm text-text-muted">
                    <strong class="text-text">Informasi menginap:</strong> Check-in mulai pukul 14.00 WIB dan check-out maksimal pukul 12.00 WIB. Asuransi pembatalan bersifat opsional saat memesan kamar.
                </div>
            </main>
        </div>
    </div>

    <!-- Mobile: navigasi bawah; item yang belum tersedia sengaja tidak dibuat tautan. -->
    <nav class="sm:hidden fixed bottom-0 inset-x-0 bg-ink-900 text-text-on-ink border-t border-white/10 flex justify-around items-center px-2 pt-2 pb-[max(0.5rem,env(safe-area-inset-bottom))] z-30" aria-label="Navigasi akun seluler">
        <a href="{{ route('dashboard') }}" aria-current="page" class="text-white flex-1 text-center text-xs font-semibold py-2 border-t-2 border-ember-600">Ringkasan</a>
        <a href="{{ route('dashboard.bookings') }}" class="flex-1 text-center text-xs text-text-on-ink/80 py-2 min-h-11 flex items-center justify-center">Pesanan</a>
        <a href="{{ route('dashboard.cards') }}" class="flex-1 text-center text-xs text-text-on-ink/80 py-2 min-h-11 flex items-center justify-center">Kartu QR</a>
        <a href="{{ route('dashboard.profile') }}" class="flex-1 text-center text-xs text-text-on-ink/80 py-2 min-h-11 flex items-center justify-center">Akun</a>
    </nav>
</body>
</html>
