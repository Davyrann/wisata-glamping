<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#161816">
    <title>Detail Reservasi | Atara Glamping</title>
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
                <p class="text-xs text-text-muted">Akun tamu / Detail Pesanan</p>
                <p class="text-sm font-semibold truncate">Halo, {{ $user->name }}</p>
            </div>
            <a href="{{ route('home') }}#kamar" class="inline-flex items-center justify-center rounded-md bg-pine-700 hover:bg-pine-600 text-white text-sm font-semibold px-3 sm:px-4 min-h-11 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-pine-700">Pesan lagi</a>
        </header>
        <main class="max-w-[1120px] mx-auto px-5 sm:px-7 lg:px-9 py-8 pb-28 sm:pb-10">
            @php
                $statusMap = [
                    'unpaid' => ['Menunggu pembayaran','bg-unpaid-bg text-unpaid-fg',1],
                    'confirmed' => ['Terkonfirmasi','bg-confirmed-bg text-confirmed-fg',2],
                    'checked_in' => ['Sedang menginap','bg-checkedin-bg text-checkedin-fg',3],
                    'completed' => ['Selesai','bg-completed-bg text-completed-fg',4],
                    'cancelled' => ['Dibatalkan','bg-cancelled-bg text-cancelled-fg',0],
                    'refunded' => ['Dana dikembalikan','bg-refunded-bg text-refunded-fg',0],
                    'expired' => ['Kedaluwarsa','bg-expired-bg text-expired-fg',0],
                ];
                $status = $statusMap[$booking->status] ?? ['Status belum diketahui','bg-sunken text-text-muted',0];
                $fromDate = \Illuminate\Support\Carbon::parse($booking->check_in_date)->locale('id');
                $toDate = \Illuminate\Support\Carbon::parse($booking->check_out_date)->locale('id');
                $roomSubtotal = (float) $booking->room_price * (int) $booking->duration_nights;
            @endphp
            @if (session('status'))<div role="status" class="mb-4 p-4 bg-surface rounded-md border border-line text-pine-700">{{ session('status') }}</div>@endif
            @if ($errors->any())<div role="alert" class="mb-4 p-4 bg-surface rounded-md border border-line text-red-700">{{ $errors->first() }}</div>@endif
            <a href="{{ route('dashboard.bookings') }}" class="text-sm font-semibold text-pine-700 hover:underline">← Kembali ke Pesanan Saya</a>
            <div class="mt-6 mb-7 flex flex-wrap items-center justify-between gap-3">
                <div class="min-w-0"><p class="text-xs text-text-muted mb-2">Detail reservasi</p><h1 class="font-display text-[clamp(1.8rem,3vw,2.25rem)] font-semibold">{{ $booking->room_name }}</h1><p class="font-mono text-xs text-text-muted mt-2 break-all">{{ $booking->booking_code }}</p></div>
                <span class="inline-flex items-center gap-2 px-3 min-h-7 rounded-full text-xs font-semibold {{ $status[1] }}"><span aria-hidden="true">●</span>{{ $status[0] }}</span>
            </div>
            <div class="grid lg:grid-cols-[minmax(0,2fr)_minmax(270px,1fr)] gap-5 items-start">
                <div class="space-y-5 min-w-0">
                    <section class="bg-surface border border-line rounded-[10px] p-5 sm:p-6" aria-labelledby="progress-heading">
                        <h2 id="progress-heading" class="font-semibold text-lg mb-5">Perjalanan reservasi</h2>
                        @if ($status[2] === 0)
                            <p class="text-sm text-text-muted">Reservasi ini {{ strtolower($status[0]) }} dan tidak memiliki tahapan aktif berikutnya.</p>
                        @else
                            <ol class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                                @foreach (['Dipesan','Dibayar','Check-in','Selesai'] as $index => $step)
                                    <li class="border-t-[3px] {{ $status[2] > $index ? 'border-pine-700' : 'border-line-strong' }} pt-3 text-sm"><span class="inline-block font-semibold {{ $status[2] > $index ? 'text-pine-700' : 'text-text-muted' }}">{{ $index + 1 }}. {{ $step }}</span></li>
                                @endforeach
                            </ol>
                        @endif
                    </section>
                    <section class="bg-surface border border-line rounded-[10px] p-5 sm:p-6" aria-labelledby="stay-heading">
                        <h2 id="stay-heading" class="font-semibold text-lg mb-5">Informasi menginap</h2>
                        <dl class="grid sm:grid-cols-2 gap-5 text-sm">
                            <div><dt class="text-text-muted">Check-in</dt><dd class="font-semibold mt-1 tabular-nums">{{ $fromDate->translatedFormat('d M Y') }} · 14.00 WIB</dd></div>
                            <div><dt class="text-text-muted">Check-out</dt><dd class="font-semibold mt-1 tabular-nums">{{ $toDate->translatedFormat('d M Y') }} · 12.00 WIB</dd></div>
                            <div><dt class="text-text-muted">Durasi</dt><dd class="font-semibold mt-1">{{ $booking->duration_nights }} malam</dd></div>
                            <div><dt class="text-text-muted">Jenis kamar</dt><dd class="font-semibold mt-1">{{ $booking->room_category }}</dd></div>
                        </dl>
                        <h3 class="font-semibold mt-6 mb-2">Kontak tamu</h3>
                        <dl class="text-sm space-y-1 break-words"><div><dt class="inline text-text-muted">Nama: </dt><dd class="inline">{{ $booking->guest_name }}</dd></div><div><dt class="inline text-text-muted">Email: </dt><dd class="inline">{{ $booking->guest_email }}</dd></div><div><dt class="inline text-text-muted">Telepon: </dt><dd class="inline">{{ $booking->guest_phone }}</dd></div></dl>
                        <p class="text-xs text-text-muted mt-5">Fasilitas glamping mengikuti informasi pada paket kamar yang dipilih.</p>
                    </section>
                    @if (in_array($booking->status, ['confirmed', 'checked_in'], true))
                        <section aria-labelledby="ticket-heading"><h2 id="ticket-heading" class="font-semibold text-lg mb-3">Kartu digital Anda</h2>@php($ticket = $booking) @include('dashboard.partials.ticket')<p class="text-xs text-text-muted mt-2">Perlihatkan kode booking kepada staf. QR di atas merupakan ilustrasi dummy, bukan kode yang dapat dipindai.</p></section>
                    @else
                        <section class="border border-line rounded-[10px] bg-sunken p-5"><h2 class="font-semibold">Kartu digital belum tersedia</h2><p class="text-sm text-text-muted mt-2">Kartu hanya muncul saat reservasi terkonfirmasi atau ketika Anda sedang menginap.</p></section>
                    @endif
                </div>
                <aside class="lg:sticky lg:top-5 bg-surface border border-line rounded-[10px] p-5 sm:p-6">
                    <h2 class="font-semibold text-lg mb-5">Rincian biaya</h2>
                    <dl class="text-sm space-y-4 tabular-nums">
                        <div class="flex justify-between gap-3"><dt>Tarif kamar × {{ $booking->duration_nights }} malam</dt><dd class="font-semibold whitespace-nowrap">Rp {{ number_format($roomSubtotal, 0, ',', '.') }}</dd></div>
                        <div class="flex justify-between gap-3"><dt>Asuransi pembatalan</dt><dd class="font-semibold whitespace-nowrap">Rp {{ number_format((float) $booking->insurance_fee, 0, ',', '.') }}</dd></div>
                        <div class="flex justify-between gap-3 border-t border-line pt-4"><dt class="font-semibold">Total</dt><dd class="font-display font-semibold text-xl whitespace-nowrap">Rp {{ number_format((float) $booking->total_amount, 0, ',', '.') }}</dd></div>
                    </dl>
                    <p class="text-xs text-text-muted mt-3">Tidak ada deposit jaminan.</p>
                    @if ($booking->status === 'unpaid')
                        <p class="mt-5 text-sm bg-unpaid-bg text-unpaid-fg p-3 rounded-md">Menunggu pembayaran. Pilih tombol di bawah untuk melanjutkan simulasi.</p>
                        <a href="{{ route('dashboard.payments') }}" class="mt-3 inline-flex justify-center items-center bg-pine-700 text-white min-h-11 px-4 rounded-md font-semibold text-sm w-full">Buka pembayaran dummy</a>
                    @elseif (in_array($booking->status, ['confirmed','checked_in'], true))
                        <a href="{{ route('dashboard.cards') }}" class="mt-5 inline-flex justify-center items-center bg-pine-700 text-white min-h-11 px-4 rounded-md font-semibold text-sm w-full">Lihat kartu QR</a>
                    @else
                        <a href="{{ route('home') }}#kamar" class="mt-5 inline-flex justify-center items-center bg-pine-700 text-white min-h-11 px-4 rounded-md font-semibold text-sm w-full">Pesan lagi</a>
                    @endif
                    <section class="border-t border-line mt-5 pt-5" aria-label="Pembatalan reservasi">
                        <h3 class="font-semibold text-base mb-3">Pengajuan pembatalan</h3>
                        @if ($cancellation)
                            <p class="text-sm mb-2">Status terakhir: <strong>{{ ucfirst($cancellation->status) }}</strong></p>
                            <p class="text-sm text-text-muted">Alasan: {{ $cancellation->reason }}</p>
                            <p class="text-sm mt-2">Estimasi refund administratif: <strong>{{ $cancellation->refund_percentage }}% (Rp {{ number_format($cancellation->refund_amount,0,',','.') }})</strong></p>
                            @if ($cancellation->status === 'pending')<p class="text-xs text-text-muted mt-2">Menunggu keputusan Staff. Pesanan belum dibatalkan.</p>@endif
                        @endif
                        @if ($booking->status === 'confirmed' && $booking->check_in_date > now('Asia/Jakarta')->toDateString() && (!$cancellation || $cancellation->status !== 'pending'))
                            <form method="POST" action="{{ route('dashboard.bookings.cancellation', $booking->booking_code) }}" class="space-y-3 mt-4">@csrf
                                <label class="block text-sm font-semibold">Alasan pembatalan
                                    <textarea name="reason" minlength="10" maxlength="2000" rows="3" required class="mt-2 w-full border border-line-strong rounded-md px-3 py-2 bg-surface">{{ old('reason') }}</textarea>
                                </label><button type="submit" class="min-h-11 w-full border border-line-strong rounded-md font-semibold text-sm">Ajukan pembatalan</button>
                            </form>
                        @endif
                    </section>
                    <div class="border-t border-line mt-5 pt-4 text-xs text-text-muted space-y-2"><p>Asuransi pembatalan: refund 100% biaya kamar jika lebih dari 3 hari sebelum check-in, atau 50% jika 3 hari atau kurang. Premi tidak kembali.</p><p>Tanpa asuransi: refund 0%. Pengajuan pembatalan menunggu persetujuan staf.</p></div>
                </aside>
            </div>
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
