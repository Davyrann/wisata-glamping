@extends('layouts.dashboard', [
    'title' => 'Pesanan Saya',
    'subtitle' => 'Area Tamu Atara / Pesanan Saya'
])

@section('content')
<div class="mb-7">
    <p class="text-xs tracking-[0.14em] uppercase text-text-muted mb-2">Riwayat Reservasi</p>
    <h1 class="font-display text-[clamp(1.8rem,3vw,2.5rem)] font-semibold leading-tight">Pesanan Saya</h1>
    <p class="mt-2 text-text-muted text-sm sm:text-base">Lihat jadwal menginap dan status reservasi Anda di satu tempat.</p>
</div>

<!-- Navigasi Tab Status -->
<nav class="grid grid-cols-2 lg:grid-cols-4 gap-2 mb-5" aria-label="Kategori pesanan">
    @foreach (['upcoming' => 'Akan datang', 'ongoing' => 'Berlangsung', 'completed' => 'Selesai', 'cancelled' => 'Dibatalkan'] as $key => $label)
        <a href="{{ route('dashboard.bookings', array_merge(request()->except('page', 'tab'), ['tab' => $key])) }}"
           @if ($tab === $key) aria-current="page" @endif
           class="flex items-center justify-between gap-2 min-h-11 px-3 sm:px-4 rounded-md border text-sm font-semibold transition-colors {{ $tab === $key ? 'bg-pine-700 text-white border-pine-700' : 'bg-surface border-line text-text hover:border-line-strong' }}">
            <span>{{ $label }}</span>
            <span class="text-xs tabular-nums {{ $tab === $key ? 'text-white/85' : 'text-text-muted' }}">{{ $counts[$key] }}</span>
        </a>
    @endforeach
</nav>

<!-- Filter Form -->
<form method="GET" action="{{ route('dashboard.bookings') }}" class="bg-surface border border-line rounded-[10px] p-4 sm:p-5 mb-5" aria-label="Filter pesanan">
    <input type="hidden" name="tab" value="{{ $tab }}">
    <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-3">
        <label class="block text-xs font-semibold text-text-muted">Kode booking
            <input type="search" name="search" maxlength="60" value="{{ $filters['search'] ?? '' }}" placeholder="GLAMP-XXXX" class="mt-1.5 w-full h-10 rounded-md border border-line-strong bg-surface px-3 text-sm text-text focus:outline-2 focus:outline-offset-1 focus:outline-pine-700">
        </label>
        <label class="block text-xs font-semibold text-text-muted">Check-in mulai
            <input type="date" name="from" value="{{ $filters['from'] ?? '' }}" class="mt-1.5 w-full h-10 rounded-md border border-line-strong bg-surface px-3 text-sm text-text focus:outline-2 focus:outline-offset-1 focus:outline-pine-700">
        </label>
        <label class="block text-xs font-semibold text-text-muted">Check-out sampai
            <input type="date" name="to" value="{{ $filters['to'] ?? '' }}" class="mt-1.5 w-full h-10 rounded-md border border-line-strong bg-surface px-3 text-sm text-text focus:outline-2 focus:outline-offset-1 focus:outline-pine-700">
        </label>
        <label class="block text-xs font-semibold text-text-muted">Jenis kamar
            <select name="category" class="mt-1.5 w-full h-10 rounded-md border border-line-strong bg-surface px-3 text-sm text-text focus:outline-2 focus:outline-offset-1 focus:outline-pine-700">
                <option value="">Semua jenis</option>
                @foreach ($categories as $category)
                    <option value="{{ $category }}" @selected(($filters['category'] ?? '') === $category)>{{ $category }}</option>
                @endforeach
            </select>
        </label>
    </div>
    @if ($errors->any())
        <p class="mt-3 text-xs text-red-700 font-medium" role="alert">Filter tidak valid. Periksa kembali rentang tanggal atau kode booking Anda.</p>
    @endif
    <div class="flex flex-wrap gap-3 items-center mt-4 pt-3 border-t border-line">
        <button type="submit" class="bg-pine-700 hover:bg-pine-600 text-white text-xs font-semibold min-h-10 px-4 rounded-md">Terapkan filter</button>
        <a href="{{ route('dashboard.bookings', ['tab' => $tab]) }}" class="text-pine-700 underline underline-offset-4 text-xs font-semibold min-h-10 inline-flex items-center">Atur ulang</a>
    </div>
</form>

@if ($bookings->isEmpty())
    <section class="bg-surface border border-line rounded-[10px] p-8 sm:p-12 text-center" aria-live="polite">
        <svg class="w-10 h-10 mx-auto text-text-faint" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><rect x="3" y="5" width="18" height="16" rx="2"/><path d="M7 3v4m10-4v4M3 10h18m-13 4h4"/></svg>
        <h2 class="font-semibold text-lg mt-4">Tidak ada pesanan ditemukan</h2>
        <p class="mt-2 text-sm text-text-muted">Belum ada reservasi dalam kategori atau filter pencarian ini.</p>
        <a href="{{ route('dashboard.rooms') }}" class="inline-flex mt-5 items-center justify-center min-h-10 px-5 bg-pine-700 text-white text-xs sm:text-sm font-semibold rounded-md hover:bg-pine-600">Pilih Kamar Glamping</a>
    </section>
@else
    <div class="space-y-3" aria-live="polite">
        @foreach ($bookings as $booking)
            @php
                $statusMap = [
                    'unpaid' => ['Menunggu pembayaran', 'bg-unpaid-bg text-unpaid-fg'],
                    'confirmed' => ['Terkonfirmasi', 'bg-confirmed-bg text-confirmed-fg'],
                    'cancellation_requested' => ['Menunggu pembatalan', 'bg-amber-100 text-amber-800'],
                    'checked_in' => ['Sedang menginap', 'bg-checkedin-bg text-checkedin-fg'],
                    'completed' => ['Selesai', 'bg-completed-bg text-completed-fg'],
                    'cancelled' => ['Dibatalkan', 'bg-cancelled-bg text-cancelled-fg'],
                ];
                $status = $statusMap[$booking->status] ?? ['Status belum dikenal', 'bg-sunken text-text-muted'];
                $fromDate = \Illuminate\Support\Carbon::parse($booking->check_in_date)->locale('id');
                $toDate = \Illuminate\Support\Carbon::parse($booking->check_out_date)->locale('id');
                $image = $booking->room_image ? asset($booking->room_image) : asset('images/Camp_premium.jpg');
            @endphp
            <article class="bg-surface border border-line hover:border-line-strong rounded-[10px] p-4 sm:p-5 flex flex-col md:flex-row gap-4 md:items-center transition-colors">
                <img src="{{ $image }}" width="96" height="72" loading="lazy" alt="Foto kamar {{ $booking->room_name }}" class="w-24 h-[72px] object-cover rounded-md bg-sunken shrink-0">
                <div class="flex-1 min-w-0">
                    <h2 class="font-display text-lg font-semibold wrap-break-word">{{ $booking->room_name }}</h2>
                    <p class="text-sm text-text-muted mt-1 tabular-nums">{{ $fromDate->translatedFormat('d M Y') }} sampai {{ $toDate->translatedFormat('d M Y') }} ({{ $booking->duration_nights }} malam)</p>
                    <p class="text-xs text-text-muted mt-2 font-mono break-all font-semibold">{{ $booking->booking_code }}</p>
                </div>
                <div class="md:text-right md:min-w-[190px] flex flex-col gap-2 md:items-end">
                    <span class="inline-flex self-start md:self-auto items-center gap-1.5 px-3 h-6 rounded-full text-xs font-semibold {{ $status[1] }}">
                        <span aria-hidden="true">●</span>{{ $status[0] }}
                    </span>
                    <p class="font-semibold tabular-nums text-sm">Rp {{ number_format((float) $booking->total_amount, 0, ',', '.') }}</p>
                    <a href="{{ route('dashboard.bookings.show', $booking->booking_code) }}" class="inline-flex items-center justify-center rounded-md bg-pine-700 hover:bg-pine-600 text-white text-xs font-semibold min-h-10 px-4">Lihat detail</a>
                </div>
            </article>
        @endforeach
    </div>
    <div class="mt-6">{{ $bookings->links() }}</div>
@endif

<p class="mt-6 text-xs text-text-muted">Informasi operasional: Check-in mulai pukul 14.00 WIB. Check-out maksimal pukul 12.00 WIB.</p>
@endsection
