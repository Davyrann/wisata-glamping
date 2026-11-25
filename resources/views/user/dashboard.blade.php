@extends('layouts.dashboard', [
    'title' => 'Ringkasan Akun',
    'subtitle' => 'Area Tamu Atara / Ringkasan'
])

@section('content')
<div class="mb-8">
    <div class="flex items-center gap-2 mb-3">
        <p class="text-xs tracking-[0.14em] uppercase text-text-muted">Area tamu Atara</p>
        <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-semibold bg-sunken text-text-muted">Role User: {{ $user->role }}</span>
    </div>
    <h1 class="font-display text-[clamp(1.8rem,3vw,2.5rem)] font-semibold leading-tight">Ringkasan akun</h1>
    <p class="mt-2 max-w-2xl text-text-muted text-sm sm:text-base">Selamat datang kembali, {{ $user->name }}. Kelola perjalanan dan informasi akunmu dari satu tempat.</p>
</div>

<!-- Kartu Ringkasan Metrik Tamu -->
<div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-7">
    <a href="{{ route('dashboard.bookings') }}" class="bg-surface border border-line hover:border-line-strong rounded-[10px] p-5 block transition-colors">
        <p class="text-xs text-text-muted mb-1 font-medium">TOTAL RESERVASI</p>
        <p class="font-display text-2xl font-semibold tabular-nums">{{ $counts['bookings'] }}</p>
        <p class="text-xs text-pine-700 mt-2 font-medium">Lihat semua riwayat →</p>
    </a>
    <a href="{{ route('dashboard.payments') }}" class="bg-surface border border-line hover:border-line-strong rounded-[10px] p-5 block transition-colors">
        <p class="text-xs text-text-muted mb-1 font-medium">MENUNGGU PEMBAYARAN</p>
        <p class="font-display text-2xl font-semibold tabular-nums {{ $counts['unpaid'] > 0 ? 'text-ember-600' : '' }}">{{ $counts['unpaid'] }}</p>
        <p class="text-xs text-pine-700 mt-2 font-medium">Buka simulasi bayar →</p>
    </a>
    <a href="{{ route('dashboard.cards') }}" class="bg-surface border border-line hover:border-line-strong rounded-[10px] p-5 block transition-colors">
        <p class="text-xs text-text-muted mb-1 font-medium">KARTU DIGITAL AKTIF</p>
        <p class="font-display text-2xl font-semibold tabular-nums">{{ $counts['cards'] }}</p>
        <p class="text-xs text-pine-700 mt-2 font-medium">Buka kartu check-in →</p>
    </a>
</div>

<div class="grid lg:grid-cols-[minmax(0,1.5fr)_minmax(260px,1fr)] gap-5">
    <section class="bg-surface border border-line rounded-[10px] p-5 sm:p-7" aria-labelledby="booking-title">
        <div class="flex flex-wrap items-start justify-between gap-3 mb-6">
            <div>
                <p class="text-xs tracking-wider text-text-muted mb-1">RESERVASI TERBARU</p>
                <h2 id="booking-title" class="font-semibold text-lg">Pesanan Anda</h2>
            </div>
            <a href="{{ route('dashboard.bookings') }}" class="text-xs rounded-md border border-line-strong px-3 py-1.5 text-pine-700 hover:bg-sunken font-semibold">Semua pesanan</a>
        </div>

        @if ($latestBooking)
            <div class="border border-line rounded-md p-4 bg-sunken/40">
                <div class="flex flex-col sm:flex-row gap-4 sm:items-center justify-between">
                    <div>
                        <span class="text-xs font-mono text-text-muted">{{ $latestBooking->booking_code }}</span>
                        <h3 class="font-semibold text-base mt-0.5">{{ $latestBooking->room_name }}</h3>
                        <p class="text-xs text-text-muted mt-1 tabular-nums">
                            {{ \Illuminate\Support\Carbon::parse($latestBooking->check_in_date)->locale('id')->translatedFormat('d M Y') }} sampai {{ \Illuminate\Support\Carbon::parse($latestBooking->check_out_date)->locale('id')->translatedFormat('d M Y') }} ({{ $latestBooking->duration_nights }} malam)
                        </p>
                    </div>
                    <div class="sm:text-right flex flex-col items-start sm:items-end gap-2">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-surface border border-line">
                            {{ ucfirst(str_replace('_', ' ', $latestBooking->status)) }}
                        </span>
                        <a href="{{ route('dashboard.bookings.show', $latestBooking->booking_code) }}" class="inline-flex items-center text-xs font-semibold text-pine-700 hover:underline">
                            Buka detail reservasi →
                        </a>
                    </div>
                </div>
            </div>
        @else
            <div class="py-8 border-t border-line text-center">
                <svg class="w-10 h-10 mx-auto text-text-faint" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><rect x="3" y="5" width="18" height="16" rx="2"/><path d="M7 3v4m10-4v4M3 10h18m-13 4h4"/></svg>
                <p class="mt-4 font-semibold text-sm">Belum ada riwayat reservasi</p>
                <p class="mt-1 text-xs text-text-muted max-w-sm mx-auto">Pilih kamar glamping impianmu di katalog untuk memulai liburan tak terlupakan.</p>
                <a href="{{ route('dashboard.rooms') }}" class="inline-flex mt-5 items-center justify-center min-h-10 px-4 rounded-md bg-pine-700 text-white hover:bg-pine-600 font-semibold text-xs sm:text-sm">Jelajahi Katalog Kamar</a>
            </div>
        @endif
    </section>

    <section class="bg-surface border border-line rounded-[10px] p-5 sm:p-7" aria-labelledby="account-title">
        <div class="flex items-center justify-between mb-4">
            <div>
                <p class="text-xs tracking-wider text-text-muted mb-1">INFORMASI PRIBADI</p>
                <h2 id="account-title" class="font-semibold text-lg">Akun Anda</h2>
            </div>
            <a href="{{ route('dashboard.profile') }}" class="text-xs text-pine-700 hover:underline font-semibold">Ubah</a>
        </div>
        <dl class="space-y-4 text-sm">
            <div>
                <dt class="text-text-muted text-xs mb-0.5">Nama lengkap</dt>
                <dd class="font-semibold wrap-break-word">{{ $user->name }}</dd>
            </div>
            <div>
                <dt class="text-text-muted text-xs mb-0.5">Alamat email</dt>
                <dd class="font-semibold break-all">{{ $user->email }}</dd>
            </div>
            <div>
                <dt class="text-text-muted text-xs mb-0.5">Nomor telepon</dt>
                <dd class="font-semibold">{{ $user->phone ?: 'Belum ditambahkan' }}</dd>
            </div>
        </dl>
        <div class="mt-6 pt-4 border-t border-line">
            <a href="{{ route('dashboard.profile') }}" class="inline-flex items-center text-xs font-semibold text-pine-700 hover:underline">
                Kelola profil & ubah kata sandi →
            </a>
        </div>
    </section>
</div>

<div class="mt-5 bg-surface border border-line rounded-[10px] p-5 sm:p-7" aria-labelledby="chart-title">
    <div class="flex flex-wrap items-center justify-between gap-2 mb-5">
        <div>
            <p class="text-xs tracking-wider text-text-muted mb-1">RIWAYAT SEWA & PENGELUARAN</p>
            <h2 id="chart-title" class="font-semibold text-lg">Pengeluaran 6 Bulan Terakhir</h2>
        </div>
        <span class="text-xs text-text-muted tabular-nums">
            Total: Rp {{ number_format((float) collect($monthlySpending)->sum('amount'), 0, ',', '.') }}
        </span>
    </div>

    <div class="grid grid-cols-6 gap-2 sm:gap-4 items-end h-40 pt-4 border-b border-line pb-2">
        @foreach ($monthlySpending as $bar)
            @php
                $heightPercent = $bar['amount'] > 0 ? max(10, (int) round(($bar['amount'] / $maxMonthlySpend) * 100)) : 4;
            @endphp
            <div class="flex flex-col items-center justify-end h-full gap-1.5 min-w-0">
                <span class="text-[10px] text-text-muted tabular-nums truncate max-w-full" title="Rp {{ number_format($bar['amount'], 0, ',', '.') }}">
                    {{ $bar['count'] > 0 ? $bar['count'].'x' : '-' }}
                </span>
                <div class="w-full max-w-10 rounded-t bg-pine-700/90 transition-all" style="height: {{ $heightPercent }}%" aria-label="{{ $bar['label'] }}: Rp {{ number_format($bar['amount'], 0, ',', '.') }}"></div>
            </div>
        @endforeach
    </div>
    <div class="grid grid-cols-6 gap-2 sm:gap-4 pt-2 text-center">
        @foreach ($monthlySpending as $bar)
            <span class="text-[11px] text-text-muted truncate">{{ $bar['label'] }}</span>
        @endforeach
    </div>
</div>

<div class="mt-5 border border-line rounded-[10px] bg-sunken px-5 py-4 text-xs sm:text-sm text-text-muted">
    <strong class="text-text font-semibold">Informasi operasional menginap:</strong> Check-in mulai pukul 14.00 WIB dan check-out maksimal pukul 12.00 WIB. Asuransi pembatalan (Rp 25.000) bersifat opsional saat reservasi.
</div>
@endsection
