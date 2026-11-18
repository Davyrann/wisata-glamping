<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#161816">
    <title>Pesanan Saya | Atara Glamping</title>
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
            <a href="{{ route('dashboard.bookings') }}" aria-current="page" class="flex items-center justify-center lg:justify-start gap-3 min-h-11 px-3 bg-ink-800 border-l-2 border-ember-600 text-white rounded-r-md font-semibold text-sm">
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
        <header class="min-h-16 bg-paper border-b border-line flex items-center justify-between gap-3 px-5 sm:px-7 lg:px-9 py-3">
            <div class="min-w-0">
                <p class="text-xs text-text-muted">Akun tamu / Pesanan Saya</p>
                <p class="text-sm font-semibold truncate">Halo, {{ $user->name }}</p>
            </div>
            <a href="{{ route('home') }}#kamar" class="inline-flex items-center justify-center rounded-md bg-pine-700 hover:bg-pine-600 text-white text-sm font-semibold px-3 sm:px-4 min-h-11 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-pine-700">Pesan lagi</a>
        </header>
        <main class="max-w-[1120px] mx-auto px-5 sm:px-7 lg:px-9 py-8 pb-28 sm:pb-10">
            <div class="mb-7">
                <p class="text-xs tracking-[0.14em] uppercase text-text-muted mb-3">Area tamu Atara</p>
                <h1 class="font-display text-[clamp(1.8rem,3vw,2.5rem)] font-semibold leading-tight">Pesanan Saya</h1>
                <p class="mt-3 text-text-muted text-sm sm:text-base">Lihat jadwal menginap dan status reservasi Anda di satu tempat.</p>
            </div>
            <nav class="grid grid-cols-2 lg:grid-cols-4 gap-2 mb-5" aria-label="Kategori pesanan">
                @foreach (['upcoming' => 'Akan datang', 'ongoing' => 'Berlangsung', 'completed' => 'Selesai', 'cancelled' => 'Dibatalkan'] as $key => $label)
                    <a href="{{ route('dashboard.bookings', array_merge(request()->except('page', 'tab'), ['tab' => $key])) }}"
                       @if ($tab === $key) aria-current="page" @endif
                       class="flex items-center justify-between gap-2 min-h-11 px-3 sm:px-4 rounded-md border text-sm font-semibold {{ $tab === $key ? 'bg-pine-700 text-white border-pine-700' : 'bg-surface border-line text-text hover:border-line-strong' }}">
                        <span>{{ $label }}</span><span class="text-xs tabular-nums {{ $tab === $key ? 'text-white/85' : 'text-text-muted' }}">{{ $counts[$key] }}</span>
                    </a>
                @endforeach
            </nav>
            <form method="GET" action="{{ route('dashboard.bookings') }}" class="bg-surface border border-line rounded-[10px] p-4 sm:p-5 mb-5" aria-label="Filter pesanan">
                <input type="hidden" name="tab" value="{{ $tab }}">
                <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-3">
                    <label class="block text-sm font-medium">Kode booking
                        <input type="search" name="search" maxlength="60" value="{{ $filters['search'] ?? '' }}" placeholder="GLAMP-XXXX" class="mt-1.5 w-full h-11 rounded-md border border-line-strong bg-surface px-3 focus:outline-2 focus:outline-offset-1 focus:outline-pine-700">
                    </label>
                    <label class="block text-sm font-medium">Check-in mulai
                        <input type="date" name="from" value="{{ $filters['from'] ?? '' }}" class="mt-1.5 w-full h-11 rounded-md border border-line-strong bg-surface px-3 focus:outline-2 focus:outline-offset-1 focus:outline-pine-700">
                    </label>
                    <label class="block text-sm font-medium">Check-out sampai
                        <input type="date" name="to" value="{{ $filters['to'] ?? '' }}" class="mt-1.5 w-full h-11 rounded-md border border-line-strong bg-surface px-3 focus:outline-2 focus:outline-offset-1 focus:outline-pine-700">
                    </label>
                    <label class="block text-sm font-medium">Jenis kamar
                        <select name="category" class="mt-1.5 w-full h-11 rounded-md border border-line-strong bg-surface px-3 focus:outline-2 focus:outline-offset-1 focus:outline-pine-700">
                            <option value="">Semua jenis</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category }}" @selected(($filters['category'] ?? '') === $category)>{{ $category }}</option>
                            @endforeach
                        </select>
                    </label>
                </div>
                @if ($errors->any())
                    <p class="mt-3 text-sm text-danger" role="alert">Filter tidak valid. Periksa kembali rentang tanggal atau kode booking Anda.</p>
                @endif
                <div class="flex flex-wrap gap-3 items-center mt-4">
                    <button type="submit" class="bg-pine-700 hover:bg-pine-600 text-white text-sm font-semibold min-h-11 px-5 rounded-md">Terapkan filter</button>
                    <a href="{{ route('dashboard.bookings', ['tab' => $tab]) }}" class="text-pine-700 underline underline-offset-4 text-sm font-semibold min-h-11 inline-flex items-center">Atur ulang</a>
                </div>
            </form>

            @if ($bookings->isEmpty())
                <section class="bg-surface border border-line rounded-[10px] p-8 sm:p-12 text-center" aria-live="polite">
                    <svg class="w-10 h-10 mx-auto text-text-faint" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><rect x="3" y="5" width="18" height="16" rx="2"/><path d="M7 3v4m10-4v4M3 10h18m-13 4h4"/></svg>
                    <h2 class="font-semibold text-lg mt-4">Tidak ada pesanan ditemukan</h2>
                    <p class="mt-2 text-sm text-text-muted">Belum ada reservasi dalam kategori atau filter ini.</p>
                    <a href="{{ route('home') }}#kamar" class="inline-flex mt-5 items-center justify-center min-h-11 px-5 bg-pine-700 text-white text-sm font-semibold rounded-md hover:bg-pine-600">Jelajahi kamar</a>
                </section>
            @else
                <div class="space-y-3" aria-live="polite">
                    @foreach ($bookings as $booking)
                        @php
                            $status = match ($booking->status) {
                                'unpaid' => ['Menunggu pembayaran', 'bg-unpaid-bg text-unpaid-fg'],
                                'confirmed' => ['Terkonfirmasi', 'bg-confirmed-bg text-confirmed-fg'],
                                'checked_in' => ['Sedang menginap', 'bg-checkedin-bg text-checkedin-fg'],
                                'completed' => ['Selesai', 'bg-completed-bg text-completed-fg'],
                                'cancelled' => ['Dibatalkan', 'bg-cancelled-bg text-cancelled-fg'],
                                default => ['Status belum dikenal', 'bg-sunken text-text-muted'],
                            };
                            $fromDate = \Illuminate\Support\Carbon::parse($booking->check_in_date)->locale('id');
                            $toDate = \Illuminate\Support\Carbon::parse($booking->check_out_date)->locale('id');
                            $image = $booking->room_image ? asset('storage/'.ltrim($booking->room_image, '/')) : asset('images/Camp_premium.jpg');
                        @endphp
                        <article class="bg-surface border border-line hover:border-line-strong rounded-[10px] p-4 sm:p-5 flex flex-col md:flex-row gap-4 md:items-center">
                            <img src="{{ $image }}" width="96" height="72" loading="lazy" alt="Foto kamar {{ $booking->room_name }}" class="w-24 h-[72px] object-cover rounded-md bg-sunken shrink-0">
                            <div class="flex-1 min-w-0">
                                <h2 class="font-display text-lg font-semibold break-words">{{ $booking->room_name }}</h2>
                                <p class="text-sm text-text-muted mt-1 tabular-nums">{{ $fromDate->translatedFormat('d M Y') }} – {{ $toDate->translatedFormat('d M Y') }} · {{ $booking->duration_nights }} malam</p>
                                <p class="text-xs text-text-muted mt-2 font-mono break-all">{{ $booking->booking_code }}</p>
                            </div>
                            <div class="md:text-right md:min-w-[185px] flex flex-col gap-2 md:items-end">
                                <span class="inline-flex self-start md:self-auto items-center gap-1.5 px-3 h-6 rounded-full text-xs font-semibold {{ $status[1] }}"><span aria-hidden="true">●</span>{{ $status[0] }}</span>
                                <p class="font-semibold tabular-nums">Rp {{ number_format((float) $booking->total_amount, 0, ',', '.') }}</p>
                                <a href="{{ route('dashboard.bookings.show', $booking->booking_code) }}" class="inline-flex items-center justify-center rounded-md bg-pine-700 hover:bg-pine-600 text-white text-sm font-semibold min-h-10 px-4">Lihat detail</a>
                            </div>
                        </article>
                    @endforeach
                </div>
                <div class="mt-6">{{ $bookings->links() }}</div>
            @endif
            <p class="mt-6 text-xs text-text-muted">Check-in mulai pukul 14.00 WIB. Check-out maksimal pukul 12.00 WIB.</p>
        </main>
    </div>
</div>
<nav class="sm:hidden fixed bottom-0 inset-x-0 bg-ink-900 text-text-on-ink border-t border-white/10 flex justify-around items-center px-2 pt-2 pb-[max(0.5rem,env(safe-area-inset-bottom))] z-30" aria-label="Navigasi akun seluler">
    <a href="{{ route('dashboard') }}" class="flex-1 text-center text-xs text-text-on-ink/80 py-2 min-h-11 flex items-center justify-center">Ringkasan</a>
    <a href="{{ route('dashboard.bookings') }}" aria-current="page" class="flex-1 text-center text-xs text-white font-semibold py-2 border-t-2 border-ember-600 min-h-11 flex items-center justify-center">Pesanan</a>
    <a href="{{ route('dashboard.cards') }}" class="flex-1 text-center text-xs text-text-on-ink/80 py-2 min-h-11 flex items-center justify-center">Kartu QR</a>
    <a href="{{ route('dashboard.profile') }}" class="flex-1 text-center text-xs text-text-on-ink/80 py-2 min-h-11 flex items-center justify-center">Akun</a>
</nav>
</body>
</html>
