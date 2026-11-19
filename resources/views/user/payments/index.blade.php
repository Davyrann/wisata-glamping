@extends('layouts.dashboard', [
    'title' => 'Simulasi Pembayaran',
    'subtitle' => 'Area Tamu Atara / Pembayaran'
])

@section('content')
<div class="mb-7">
    <p class="text-xs tracking-[0.14em] uppercase text-text-muted mb-2">Sandbox Pembayaran</p>
    <h1 class="font-display text-[clamp(1.8rem,3vw,2.5rem)] font-semibold leading-tight">Pembayaran Sandbox</h1>
    <p class="mt-2 text-text-muted text-sm sm:text-base">Simulasi pembayaran QRIS dummy untuk verifikasi alur reservasi tanpa perpindahan dana riil.</p>
</div>

@forelse ($bookings as $booking)
    <article class="bg-surface border border-line rounded-[10px] p-5 sm:p-7 mb-5 shadow-sm">
        <div class="flex flex-wrap items-start justify-between gap-4">
            <div>
                <span class="text-xs font-mono font-semibold text-text-muted">{{ $booking->booking_code }}</span>
                <h2 class="font-display font-semibold text-xl mt-1">{{ $booking->room_name }}</h2>
                <p class="text-xs text-text-muted mt-1 tabular-nums">
                    Jadwal: {{ $booking->check_in_date }} sampai {{ $booking->check_out_date }} ({{ $booking->duration_nights }} malam)
                </p>
            </div>
            <div class="text-right">
                <p class="text-xs text-text-muted">Total Pembayaran</p>
                <p class="font-display font-semibold text-xl text-pine-700 tabular-nums">
                    Rp {{ number_format((float) $booking->total_amount, 0, ',', '.') }}
                </p>
            </div>
        </div>

        <div class="mt-6 p-5 border border-line bg-sunken rounded-md text-center max-w-sm mx-auto sm:mx-0">
            <p class="font-semibold text-xs tracking-wider text-text-muted uppercase">QRIS Dummy - Simulasi Sandbox</p>
            <div aria-hidden="true" class="mt-3 mx-auto w-32 h-32 border-4 border-white bg-ink-900 flex items-center justify-center text-white text-xs font-mono rounded shadow-inner">
                ATARA<br>SANDBOX
            </div>
            <p class="mt-2 text-[11px] text-text-muted">Ilustrasi kode dummy untuk simulasi pengujian sistem</p>
        </div>

        <div class="flex flex-wrap gap-3 mt-6 pt-4 border-t border-line">
            <form method="POST" action="{{ route('dashboard.bookings.pay', $booking->booking_code) }}">
                @csrf
                <button type="submit" class="min-h-10 px-5 bg-pine-700 hover:bg-pine-600 text-white rounded-md font-semibold text-xs transition-colors">
                    Simulasikan Bayar Berhasil
                </button>
            </form>
            <form method="POST" action="{{ route('dashboard.bookings.discard', $booking->booking_code) }}" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan pesanan yang belum dibayar ini?')">
                @csrf
                <button type="submit" class="min-h-10 px-5 border border-line-strong hover:bg-sunken rounded-md font-semibold text-xs transition-colors">
                    Batalkan Pesanan
                </button>
            </form>
        </div>
    </article>
@empty
    <section class="bg-surface border border-line rounded-[10px] p-8 sm:p-12 text-center">
        <svg class="w-10 h-10 mx-auto text-text-faint" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><rect x="2" y="5" width="20" height="14" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/></svg>
        <h2 class="font-semibold text-lg mt-4">Tidak ada tagihan tertunda</h2>
        <p class="text-xs sm:text-sm text-text-muted mt-2 max-w-sm mx-auto">Semua pesanan Anda telah diproses atau belum ada pemesanan baru yang menunggu pembayaran.</p>
        <div class="flex flex-wrap gap-3 justify-center mt-6">
            <a href="{{ route('dashboard.rooms') }}" class="inline-flex items-center px-4 min-h-10 bg-pine-700 hover:bg-pine-600 text-white rounded-md text-xs font-semibold">Pilih Kamar Glamping</a>
            <a href="{{ route('dashboard.bookings') }}" class="inline-flex items-center px-4 min-h-10 border border-line-strong hover:bg-sunken rounded-md text-xs font-semibold">Lihat Pesanan Saya</a>
        </div>
    </section>
@endforelse

<div class="mt-5">{{ $bookings->links() }}</div>
@endsection
