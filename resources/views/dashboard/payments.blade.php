<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#161816">
    <title>Pembayaran | Atara Glamping</title>
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
            <a href="{{ route('dashboard.cards') }}" class="flex items-center justify-center lg:justify-start min-h-11 gap-3 px-3 text-text-on-ink/80 hover:bg-ink-800 rounded-md text-sm" aria-label="Kartu Digital"><svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" aria-hidden="true"><rect x="3" y="5" width="16" height="14" rx="2"/><path d="M7 9h4v4H7zM14 9h3M14 13h3"/></svg><span class="hidden lg:block">Kartu Digital</span></a>
            <a href="{{ route('dashboard.payments') }}" aria-current="page" class="flex items-center justify-center lg:justify-start min-h-11 gap-3 px-3 bg-ink-800 border-l-2 border-ember-600 text-white rounded-r-md font-semibold text-sm"><svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" aria-hidden="true"><rect x="4" y="5" width="16" height="14" rx="2"/><path d="M8 9h8M8 13h6"/></svg><span class="hidden lg:block">Pembayaran</span></a>
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
        <header class="min-h-16 bg-paper border-b border-line flex items-center justify-between gap-3 px-5 sm:px-7 lg:px-9 py-3">
            <div class="min-w-0">
                <p class="text-xs text-text-muted">Akun tamu / Pembayaran</p>
                <p class="text-sm font-semibold truncate">Halo, {{ $user->name }}</p>
            </div>
            <a href="{{ route('home') }}#kamar" class="inline-flex items-center justify-center rounded-md bg-pine-700 hover:bg-pine-600 text-white text-sm font-semibold px-3 sm:px-4 min-h-11 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-pine-700">Pesan lagi</a>
        </header>
        <main class="max-w-[1120px] mx-auto px-5 sm:px-7 lg:px-9 py-8 pb-28 sm:pb-10">
            <p class="text-xs tracking-[0.14em] uppercase text-text-muted mb-3">Area tamu Atara</p>
            <h1 class="font-display text-[clamp(1.8rem,3vw,2.5rem)] font-semibold leading-tight">Pembayaran</h1>
            @if (session('status'))<div role="status" class="mt-5 rounded-md border border-line bg-surface px-4 py-3 text-sm text-pine-700">{{ session('status') }}</div>@endif
            @if ($errors->any())<div role="alert" class="mt-5 rounded-md border border-line bg-surface px-4 py-3 text-sm text-red-700">{{ $errors->first() }}</div>@endif
            <p class="mt-3 mb-7 text-text-muted text-sm sm:text-base">Simulasi pembayaran QRIS dummy. Tidak ada dana nyata yang diproses.</p>
            @forelse ($bookings as $booking)
              <article class="bg-surface border border-line rounded-[10px] p-5 sm:p-7 mb-4">
                <div class="flex flex-wrap items-start justify-between gap-3"><div><p class="text-xs text-text-muted">{{ $booking->booking_code }}</p><h2 class="font-semibold text-lg mt-1">{{ $booking->room_name }}</h2><p class="text-sm text-text-muted mt-2">{{ $booking->check_in_date }} hingga {{ $booking->check_out_date }}</p></div><strong class="text-xl">Rp {{ number_format($booking->total_amount,0,',','.') }}</strong></div>
                <div class="mt-5 p-5 border border-line bg-sunken rounded-md text-center max-w-sm"><p class="font-semibold">QRIS DUMMY - SIMULASI</p><div aria-hidden="true" class="mt-3 mx-auto w-32 h-32 border-8 border-white bg-ink-900 flex items-center justify-center text-white text-xs font-mono">ATARA<br>DEMO</div><p class="mt-2 text-xs text-text-muted">Tidak bisa dipindai dan tidak memindahkan uang</p></div>
                <div class="flex flex-wrap gap-3 mt-5">
                  <form method="POST" action="{{ route('dashboard.bookings.pay',$booking->booking_code) }}">@csrf<button class="min-h-11 px-5 bg-pine-700 text-white rounded-md font-semibold text-sm">Simulasikan Bayar Berhasil</button></form>
                  <form method="POST" action="{{ route('dashboard.bookings.discard',$booking->booking_code) }}" onsubmit="return confirm('Batalkan pesanan yang belum dibayar?')">@csrf<button class="min-h-11 px-5 border border-line-strong rounded-md font-semibold text-sm">Batalkan Pesanan</button></form>
                </div>
              </article>
            @empty
              <section class="bg-surface border border-line rounded-[10px] p-9 text-center"><h2 class="font-semibold text-lg">Tidak ada pembayaran tertunda</h2><p class="text-sm text-text-muted mt-3">Semua pembayaran yang belum diselesaikan akan muncul di halaman ini.</p><a href="{{ route('dashboard.bookings') }}" class="inline-flex mt-5 px-5 min-h-11 items-center bg-pine-700 text-white rounded-md">Lihat Pesanan Saya</a></section>
            @endforelse
            <div class="mt-5">{{ $bookings->links() }}</div>

        </main>
    </div>
</div>
<nav class="sm:hidden fixed bottom-0 inset-x-0 bg-ink-900 text-text-on-ink border-t border-white/10 flex justify-around items-center px-2 pt-2 pb-[max(0.5rem,env(safe-area-inset-bottom))] z-30" aria-label="Navigasi akun seluler">
    <a href="{{ route('dashboard') }}" class="flex-1 text-center text-xs text-text-on-ink/80 py-2 min-h-11 flex items-center justify-center">Ringkasan</a>
    <a href="{{ route('dashboard.bookings') }}" class="flex-1 text-center text-xs text-white font-semibold py-2 border-t-2 border-ember-600 min-h-11 flex items-center justify-center">Pesanan</a>
    <a href="{{ route('dashboard.cards') }}" class="flex-1 text-center text-xs text-text-on-ink/80 py-2 min-h-11 flex items-center justify-center">Kartu QR</a>
    <a href="{{ route('dashboard.profile') }}" class="flex-1 text-center text-xs text-text-on-ink/80 py-2 min-h-11 flex items-center justify-center">Akun</a>
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
