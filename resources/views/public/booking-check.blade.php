@extends('layouts.app')

@section('title', 'Cek Status Reservasi & Kartu Digital | Atara Glamping')

@section('content')
<section class="bg-canvas border-b border-border-subtle py-12 sm:py-16">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-wrap items-center gap-2 font-mono text-[10px] sm:text-xs uppercase tracking-[0.18em] text-muted-stone mb-5">
            <a href="{{ route('home') }}" class="hover:text-primary">Beranda</a>
            <span>/</span>
            <span class="text-primary">Cek Reservasi</span>
        </div>

        <h1 class="font-sans font-bold text-2xl sm:text-4xl text-primary tracking-tight mb-3">
            Cek Status Reservasi & Kartu Digital
        </h1>
        <p class="font-serif text-sm sm:text-base text-neutral-dark mb-8">
            Masukkan kode booking dan email atau nomor telepon yang Anda daftarkan saat pemesanan.
        </p>

        <form method="GET" action="{{ route('booking.check') }}" class="bg-white border border-primary p-5 sm:p-8 space-y-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="booking_code" class="block font-mono text-xs uppercase tracking-wider text-primary font-semibold mb-2">
                        Kode Booking
                    </label>
                    <input id="booking_code" type="text" name="booking_code" required maxlength="40"
                           value="{{ old('booking_code', $filters['booking_code']) }}"
                           placeholder="Contoh: GLAMP-ABCD12"
                           class="w-full h-11 px-3.5 border border-border-subtle bg-canvas text-sm font-mono text-primary focus:outline-none focus:ring-2 focus:ring-primary focus:bg-white rounded-[3px]">
                    @error('booking_code') <p class="mt-1.5 text-xs text-danger font-medium">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="contact" class="block font-mono text-xs uppercase tracking-wider text-primary font-semibold mb-2">
                        Email atau Nomor Telepon
                    </label>
                    <input id="contact" type="text" name="contact" required maxlength="120"
                           value="{{ old('contact', $filters['contact']) }}"
                           placeholder="tamu@domain.test / 081234567890"
                           class="w-full h-11 px-3.5 border border-border-subtle bg-canvas text-sm font-mono text-primary focus:outline-none focus:ring-2 focus:ring-primary focus:bg-white rounded-[3px]">
                    @error('contact') <p class="mt-1.5 text-xs text-danger font-medium">{{ $message }}</p> @enderror
                </div>
            </div>
            <div class="pt-1 flex flex-wrap gap-3 items-center">
                <button type="submit" class="w-full sm:w-auto min-h-11 px-6 bg-primary text-white text-xs font-semibold tracking-wider uppercase hover:bg-black transition-colors rounded-[5px]">
                    Periksa Status Reservasi
                </button>
                @if ($searched)
                    <a href="{{ route('booking.check') }}" class="text-xs font-mono underline text-neutral-dark hover:text-primary min-h-11 inline-flex items-center">Atur ulang</a>
                @endif
            </div>
        </form>

        @if ($searched && ! $errors->any())
            @if ($booking === null)
                <div class="mt-6 bg-white border border-border-subtle p-6 text-center" role="status">
                    <p class="font-sans font-semibold text-base text-primary">Reservasi tidak ditemukan</p>
                    <p class="mt-2 font-serif text-sm text-neutral-dark">
                        Pastikan kode booking dan email atau nomor telepon cocok dengan data pemesanan Anda.
                    </p>
                </div>
            @else
                @php
                    $statusLabels = [
                        'unpaid' => ['Menunggu Pembayaran', 'bg-unpaid-bg text-unpaid-fg'],
                        'confirmed' => ['Terkonfirmasi', 'bg-confirmed-bg text-confirmed-fg'],
                        'cancellation_requested' => ['Menunggu Persetujuan Pembatalan', 'bg-unpaid-bg text-unpaid-fg'],
                        'checked_in' => ['Sedang Menginap (Check-in)', 'bg-checkedin-bg text-checkedin-fg'],
                        'completed' => ['Selesai (Check-out)', 'bg-completed-bg text-completed-fg'],
                        'cancelled' => ['Dibatalkan', 'bg-cancelled-bg text-cancelled-fg'],
                    ];
                    [$statusText, $statusClass] = $statusLabels[$booking->status] ?? [$booking->status, 'bg-sunken text-text-muted'];
                    $checkIn = \Illuminate\Support\Carbon::parse($booking->check_in_date)->locale('id')->translatedFormat('d M Y');
                    $checkOut = \Illuminate\Support\Carbon::parse($booking->check_out_date)->locale('id')->translatedFormat('d M Y');
                @endphp

                <div class="mt-6 space-y-5">
                    <div class="bg-white border border-border-subtle p-5 sm:p-7 space-y-5">
                        <div class="flex flex-wrap items-center justify-between gap-3 pb-4 border-b border-border-subtle">
                            <div>
                                <p class="font-mono text-xs text-muted-stone">KODE BOOKING</p>
                                <p class="font-mono text-lg font-bold text-primary">{{ $booking->booking_code }}</p>
                            </div>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold {{ $statusClass }}">
                                {{ $statusText }}
                            </span>
                        </div>

                        <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                            <div>
                                <dt class="text-xs text-muted-stone">Tipe Kamar</dt>
                                <dd class="font-semibold text-primary mt-0.5">{{ $booking->room?->name ?? '-' }}</dd>
                            </div>
                            <div>
                                <dt class="text-xs text-muted-stone">Nama Tamu</dt>
                                <dd class="font-semibold text-primary mt-0.5">{{ $booking->guest_name }}</dd>
                            </div>
                            <div>
                                <dt class="text-xs text-muted-stone">Jadwal Menginap ({{ $booking->duration_nights }} malam)</dt>
                                <dd class="font-semibold text-primary mt-0.5 tabular-nums">{{ $checkIn }} sampai {{ $checkOut }}</dd>
                            </div>
                            <div>
                                <dt class="text-xs text-muted-stone">Total Pembayaran</dt>
                                <dd class="font-semibold text-primary mt-0.5 tabular-nums">Rp {{ number_format((float) $booking->total_amount, 0, ',', '.') }}</dd>
                            </div>
                        </dl>

                        <div class="pt-4 border-t border-border-subtle text-xs text-neutral-dark space-y-1">
                            <p class="font-mono uppercase tracking-wider text-primary font-semibold">Ringkasan Serah Terima Kamar</p>
                            <p>Waktu standar: Check-in mulai pukul 14.00 WIB &middot; Check-out maksimal pukul 12.00 WIB.</p>
                            @if ($booking->check_in_at)
                                <p class="tabular-nums">Tercatat check-in: {{ $booking->check_in_at->timezone('Asia/Jakarta')->format('d/m/Y H:i') }} WIB</p>
                            @endif
                            @if ($booking->check_out_at)
                                <p class="tabular-nums">Tercatat check-out: {{ $booking->check_out_at->timezone('Asia/Jakarta')->format('d/m/Y H:i') }} WIB</p>
                            @endif
                        </div>
                    </div>

                    @if (in_array($booking->status, ['confirmed', 'checked_in'], true))
                        @php
                            $ticket = (object) [
                                'booking_code' => $booking->booking_code,
                                'room_name' => $booking->room?->name ?? 'Kamar Glamping',
                                'guest_name' => $booking->guest_name,
                                'check_in_date' => $booking->check_in_date,
                                'check_out_date' => $booking->check_out_date,
                            ];
                        @endphp
                        @include('user.partials.ticket', ['ticket' => $ticket])
                    @endif
                </div>
            @endif
        @endif
    </div>
</section>
@endsection
