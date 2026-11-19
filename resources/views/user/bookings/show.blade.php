@extends('layouts.dashboard', [
    'title' => 'Detail Reservasi ' . $booking->booking_code,
    'subtitle' => 'Area Tamu Atara / Detail Reservasi'
])

@section('content')
@php
    $statusMap = [
        'unpaid' => ['Menunggu pembayaran', 'bg-unpaid-bg text-unpaid-fg', 1],
        'confirmed' => ['Terkonfirmasi', 'bg-confirmed-bg text-confirmed-fg', 2],
        'cancellation_requested' => ['Menunggu verifikasi pembatalan', 'bg-amber-100 text-amber-800', 2],
        'checked_in' => ['Sedang menginap', 'bg-checkedin-bg text-checkedin-fg', 3],
        'completed' => ['Selesai', 'bg-completed-bg text-completed-fg', 4],
        'cancelled' => ['Dibatalkan', 'bg-cancelled-bg text-cancelled-fg', 0],
    ];
    $status = $statusMap[$booking->status] ?? ['Status belum diketahui', 'bg-sunken text-text-muted', 0];
    $fromDate = \Illuminate\Support\Carbon::parse($booking->check_in_date)->locale('id');
    $toDate = \Illuminate\Support\Carbon::parse($booking->check_out_date)->locale('id');
    $roomSubtotal = (float) $booking->room_price * (int) $booking->duration_nights;
@endphp

<a href="{{ route('dashboard.bookings') }}" class="text-xs font-semibold text-pine-700 hover:underline inline-flex items-center gap-1 mb-5">
    ← Kembali ke Pesanan Saya
</a>

<div class="mb-7 flex flex-wrap items-center justify-between gap-3">
    <div class="min-w-0">
        <p class="text-xs text-text-muted mb-1 font-mono font-semibold">{{ $booking->booking_code }}</p>
        <h1 class="font-display text-[clamp(1.8rem,3vw,2.25rem)] font-semibold">{{ $booking->room_name }}</h1>
    </div>
    <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold {{ $status[1] }}">
        <span aria-hidden="true">●</span>{{ $status[0] }}
    </span>
</div>

<div class="grid lg:grid-cols-[minmax(0,2fr)_minmax(280px,1fr)] gap-6 items-start">
    <div class="space-y-6 min-w-0">
        <!-- Progress Perjalanan -->
        <section class="bg-surface border border-line rounded-[10px] p-5 sm:p-6" aria-labelledby="progress-heading">
            <h2 id="progress-heading" class="font-semibold text-base mb-4">Tahapan Reservasi</h2>
            @if ($status[2] === 0)
                <p class="text-xs text-text-muted">Reservasi ini telah dibatalkan dan tidak memiliki tahapan aktif berikutnya.</p>
            @else
                <ol class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                    @foreach (['Dipesan', 'Dibayar', 'Check-in', 'Selesai'] as $index => $step)
                        <li class="border-t-[3px] {{ $status[2] > $index ? 'border-pine-700' : 'border-line-strong' }} pt-3 text-xs">
                            <span class="inline-block font-semibold {{ $status[2] > $index ? 'text-pine-700' : 'text-text-muted' }}">
                                {{ $index + 1 }}. {{ $step }}
                            </span>
                        </li>
                    @endforeach
                </ol>
            @endif
        </section>

        <!-- Informasi Menginap -->
        <section class="bg-surface border border-line rounded-[10px] p-5 sm:p-6" aria-labelledby="stay-heading">
            <h2 id="stay-heading" class="font-semibold text-base mb-4">Informasi Menginap</h2>
            <dl class="grid sm:grid-cols-2 gap-4 text-xs sm:text-sm">
                <div>
                    <dt class="text-text-muted">Check-in</dt>
                    <dd class="font-semibold mt-1 tabular-nums">{{ $fromDate->translatedFormat('d M Y') }} · 14.00 WIB</dd>
                </div>
                <div>
                    <dt class="text-text-muted">Check-out</dt>
                    <dd class="font-semibold mt-1 tabular-nums">{{ $toDate->translatedFormat('d M Y') }} · 12.00 WIB</dd>
                </div>
                <div>
                    <dt class="text-text-muted">Durasi menginap</dt>
                    <dd class="font-semibold mt-1">{{ $booking->duration_nights }} malam</dd>
                </div>
                <div>
                    <dt class="text-text-muted">Kategori kamar</dt>
                    <dd class="font-semibold mt-1">{{ $booking->room_category }}</dd>
                </div>
            </dl>
            <h3 class="font-semibold mt-6 mb-2 text-xs uppercase tracking-wider text-text-muted">Kontak Tamu</h3>
            <dl class="text-xs sm:text-sm space-y-1">
                <div><dt class="inline text-text-muted">Nama: </dt><dd class="inline font-medium">{{ $booking->guest_name }}</dd></div>
                <div><dt class="inline text-text-muted">Email: </dt><dd class="inline font-medium">{{ $booking->guest_email }}</dd></div>
                <div><dt class="inline text-text-muted">Telepon: </dt><dd class="inline font-medium">{{ $booking->guest_phone }}</dd></div>
            </dl>
        </section>

        <!-- Kartu Digital Menginap -->
        @if (in_array($booking->status, ['confirmed', 'checked_in'], true))
            <section aria-labelledby="ticket-heading">
                <h2 id="ticket-heading" class="font-semibold text-base mb-3">Kartu digital Anda</h2>
                @php($ticket = $booking)
                @include('user.partials.ticket')
                <p class="text-xs text-text-muted mt-2">Perlihatkan kode booking kepada staf operasional saat tiba di lokasi glamping.</p>
            </section>
        @else
            <section class="border border-line rounded-[10px] bg-sunken p-5">
                <h2 class="font-semibold text-sm">Kartu digital belum tersedia</h2>
                <p class="text-xs text-text-muted mt-1.5">
                    @if ($booking->status === 'cancellation_requested')
                        Reservasi sedang dalam proses pengajuan pembatalan sehingga kartu digital dinonaktifkan sementara.
                    @else
                        Kartu digital hanya aktif ketika reservasi telah terkonfirmasi lunas atau saat Anda sedang menginap.
                    @endif
                </p>
            </section>
        @endif
    </div>

    <!-- Rincian Biaya & Pengajuan Pembatalan -->
    <aside class="lg:sticky lg:top-5 bg-surface border border-line rounded-[10px] p-5 sm:p-6">
        <h2 class="font-semibold text-base mb-4">Rincian Biaya</h2>
        <dl class="text-xs sm:text-sm space-y-3 tabular-nums">
            <div class="flex justify-between gap-3">
                <dt>Tarif sewa ({{ $booking->duration_nights }} malam)</dt>
                <dd class="font-semibold whitespace-nowrap">Rp {{ number_format($roomSubtotal, 0, ',', '.') }}</dd>
            </div>
            <div class="flex justify-between gap-3">
                <dt>Asuransi pembatalan</dt>
                <dd class="font-semibold whitespace-nowrap">Rp {{ number_format((float) $booking->insurance_fee, 0, ',', '.') }}</dd>
            </div>
            <div class="flex justify-between gap-3 border-t border-line pt-3">
                <dt class="font-semibold">Total tagihan</dt>
                <dd class="font-display font-semibold text-lg text-pine-700 whitespace-nowrap">Rp {{ number_format((float) $booking->total_amount, 0, ',', '.') }}</dd>
            </div>
        </dl>

        @if ($booking->status === 'unpaid')
            <div class="mt-5 p-3 rounded-md bg-unpaid-bg text-unpaid-fg text-xs font-medium">
                Menunggu pembayaran. Silakan lanjutkan simulasi pembayaran QRIS dummy.
            </div>
            <a href="{{ route('dashboard.payments') }}" class="mt-3 inline-flex justify-center items-center bg-pine-700 hover:bg-pine-600 text-white min-h-10 px-4 rounded-md font-semibold text-xs sm:text-sm w-full transition-colors">
                Buka Pembayaran Sandbox
            </a>
        @elseif (in_array($booking->status, ['confirmed', 'checked_in'], true))
            <a href="{{ route('dashboard.cards') }}" class="mt-5 inline-flex justify-center items-center bg-pine-700 hover:bg-pine-600 text-white min-h-10 px-4 rounded-md font-semibold text-xs sm:text-sm w-full transition-colors">
                Buka Kartu Digital QR
            </a>
        @else
            <a href="{{ route('dashboard.rooms') }}" class="mt-5 inline-flex justify-center items-center bg-pine-700 hover:bg-pine-600 text-white min-h-10 px-4 rounded-md font-semibold text-xs sm:text-sm w-full transition-colors">
                Pilih Kamar Lain
            </a>
        @endif

        <!-- Area Pengajuan Pembatalan -->
        <section class="border-t border-line mt-6 pt-5" aria-label="Pembatalan reservasi">
            <h3 class="font-semibold text-sm mb-3">Pengajuan Pembatalan</h3>
            @if ($cancellation)
                <div class="bg-sunken border border-line rounded-md p-3.5 mb-3 text-xs space-y-1.5">
                    <p>Status permohonan: <strong class="uppercase text-pine-700 font-semibold">{{ $cancellation->status }}</strong></p>
                    <p class="text-text-muted">Alasan: {{ $cancellation->reason }}</p>
                    <p class="font-semibold">Estimasi refund: {{ $cancellation->refund_percentage }}% (Rp {{ number_format((float) $cancellation->refund_amount, 0, ',', '.') }})</p>
                    @if ($cancellation->status === 'pending')
                        <p class="text-[11px] text-text-muted mt-1">Menunggu peninjauan dan persetujuan staf operasional.</p>
                    @endif
                </div>
            @endif

            @if ($booking->status === 'confirmed' && $booking->check_in_date > now('Asia/Jakarta')->toDateString() && (! $cancellation || $cancellation->status !== 'pending'))
                <form method="POST" action="{{ route('dashboard.bookings.cancellation', $booking->booking_code) }}" class="space-y-3 mt-3">
                    @csrf
                    <label class="block text-xs font-semibold">Alasan pembatalan
                        <textarea name="reason" minlength="10" maxlength="2000" rows="3" required placeholder="Tuliskan alasan pembatalan reservasi Anda (minimal 10 karakter)..." class="mt-1.5 w-full border border-line-strong rounded-md p-2.5 text-xs text-text bg-surface focus:outline-2 focus:outline-pine-700">{{ old('reason') }}</textarea>
                    </label>
                    <button type="submit" class="min-h-10 w-full border border-line-strong hover:bg-sunken rounded-md font-semibold text-xs transition-colors">
                        Ajukan Pembatalan
                    </button>
                </form>
            @endif

            <div class="mt-4 pt-3 border-t border-line text-[11px] text-text-muted space-y-1.5">
                <p><strong>Ketentuan Asuransi Pembatalan:</strong></p>
                <p>• Dibatalkan > 3 hari sebelum check-in: refund 100% biaya sewa kamar (premi hangus).</p>
                <p>• Dibatalkan <= 3 hari sebelum check-in: refund 50% biaya sewa kamar (premi hangus).</p>
                <p>• Tanpa asuransi: refund 0% biaya sewa.</p>
            </div>
        </section>
    </aside>
</div>
@endsection
