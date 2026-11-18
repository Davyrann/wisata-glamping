<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#161816">
    <title>Kartu Digital | Atara Glamping</title>
    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:wght@500;600&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-paper text-text font-sans antialiased">
<div class="min-h-screen lg:flex">
    <aside class="hidden sm:flex sm:w-16 lg:w-[248px] shrink-0 flex-col bg-ink-900 text-text-on-ink min-h-screen sticky top-0 h-screen">
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
            <a href="{{ route('dashboard.cards') }}" aria-current="page" class="flex items-center justify-center lg:justify-start min-h-11 gap-3 px-3 bg-ink-800 border-l-2 border-ember-600 text-white rounded-r-md font-semibold text-sm" aria-label="Kartu Digital"><svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" aria-hidden="true"><rect x="3" y="5" width="16" height="14" rx="2"/><path d="M7 9h4v4H7zM14 9h3M14 13h3"/></svg><span class="hidden lg:block">Kartu Digital</span></a>
            @foreach (['Pembayaran', 'Profil & Keamanan'] as $label)
                <span class="flex items-center justify-center lg:justify-start min-h-11 gap-3 px-3 text-text-on-ink/55 text-sm cursor-not-allowed" aria-disabled="true" title="Fitur sedang dikembangkan">
                    <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" aria-hidden="true"><rect x="4" y="5" width="16" height="14" rx="2"/><path d="M8 9h8M8 13h6"/></svg>
                    <span class="hidden lg:block">{{ $label }}</span>
                </span>
            @endforeach
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
        <header class="min-h-16 bg-paper border-b border-line flex items-center justify-between gap-3 px-5 sm:px-7 lg:px-9 py-3">
            <div class="min-w-0">
                <p class="text-xs text-text-muted">Akun tamu / Kartu Digital</p>
                <p class="text-sm font-semibold truncate">Halo, {{ $user->name }}</p>
            </div>
            <a href="{{ route('home') }}#kamar" class="inline-flex items-center justify-center rounded-md bg-pine-700 hover:bg-pine-600 text-white text-sm font-semibold px-3 sm:px-4 min-h-11 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-pine-700">Pesan lagi</a>
        </header>
        <main class="max-w-[1120px] mx-auto px-5 sm:px-7 lg:px-9 py-8 pb-28 sm:pb-10">
            <p class="text-xs tracking-[0.14em] uppercase text-text-muted mb-3">Area tamu Atara</p>
            <h1 class="font-display text-[clamp(1.8rem,3vw,2.5rem)] font-semibold leading-tight">Kartu Digital</h1>
            <p class="mt-3 mb-7 text-text-muted text-sm sm:text-base">Gunakan kode reservasi untuk verifikasi saat tiba di lokasi.</p>
            @if ($cards->isEmpty())
                <section class="bg-surface border border-line rounded-[10px] p-8 sm:p-12 text-center">
                    <h2 class="font-semibold text-lg">Belum ada kartu digital</h2>
                    <p class="text-text-muted text-sm mt-3">Kartu hanya tersedia setelah pembayaran berhasil dan status pesanan terkonfirmasi.</p>
                    <a href="{{ route('dashboard.bookings') }}" class="inline-flex mt-5 justify-center items-center bg-pine-700 text-white rounded-md min-h-11 px-5 text-sm font-semibold">Lihat pesanan saya</a>
                </section>
            @else
                <div class="grid lg:grid-cols-2 gap-5">
                    @foreach ($cards as $ticket)
                        <div class="min-w-0">@include('dashboard.partials.ticket')<a href="{{ route('dashboard.bookings.show', $ticket->booking_code) }}" class="text-sm text-pine-700 underline underline-offset-4 inline-block mt-3">Lihat detail reservasi</a></div>
                    @endforeach
                </div>
                <p class="mt-5 text-xs text-text-muted">Naikkan kecerahan layar saat menunjukkan kartu kepada staf. QR di kartu adalah ilustrasi dummy; verifikasi menggunakan kode booking.</p>
            @endif
        </main>
    </div>
</div>
<nav class="sm:hidden fixed bottom-0 inset-x-0 bg-ink-900 text-text-on-ink border-t border-white/10 flex justify-around items-center px-2 pt-2 pb-[max(0.5rem,env(safe-area-inset-bottom))] z-30" aria-label="Navigasi akun seluler">
    <a href="{{ route('dashboard') }}" class="flex-1 text-center text-xs text-text-on-ink/80 py-2 min-h-11 flex items-center justify-center">Ringkasan</a>
    <a href="{{ route('dashboard.bookings') }}" class="flex-1 text-center text-xs text-white font-semibold py-2 border-t-2 border-ember-600 min-h-11 flex items-center justify-center">Pesanan</a>
    <a href="{{ route('dashboard.cards') }}" aria-current="page" class="flex-1 text-center text-xs text-white font-semibold py-2 border-t-2 border-ember-600 min-h-11 flex items-center justify-center">Kartu QR</a>
    <span aria-disabled="true" class="flex-1 text-center text-xs text-text-on-ink/50 py-2">Akun</span>
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
