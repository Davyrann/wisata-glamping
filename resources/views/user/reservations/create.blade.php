@extends('layouts.dashboard', [
    'title' => 'Reservasi ' . $room->name,
    'subtitle' => 'Area Tamu Atara / Formulir Reservasi'
])

@section('content')
@php
    $today = now('Asia/Jakarta')->toDateString();
    $tomorrow = now('Asia/Jakarta')->addDay()->toDateString();
    $dayAfter = now('Asia/Jakarta')->addDays(2)->toDateString();
    $defaultCheckIn = old('check_in_date', $tomorrow);
    $defaultCheckOut = old('check_out_date', $dayAfter);
    $image = $room->image_path ? asset($room->image_path) : asset('images/Camp_premium.jpg');
@endphp

<div class="mb-5">
    <a href="{{ route('dashboard.rooms') }}" class="text-xs font-semibold text-pine-700 hover:underline inline-flex items-center gap-1 mb-3">
        ← Kembali ke Katalog Kamar
    </a>
    <p class="text-xs tracking-[0.14em] uppercase text-text-muted mb-1">Pemesanan Paket Kamar</p>
    <h1 class="font-display text-[clamp(1.8rem,3vw,2.25rem)] font-semibold leading-tight">Formulir Reservasi Glamping</h1>
    <p class="mt-2 text-text-muted text-xs sm:text-base">Lengkapi jadwal menginap dan data kontak tamu untuk mengamankan unit kamar glamping Anda.</p>
</div>

<form id="reservation-form" method="POST" action="{{ route('dashboard.rooms.reserve', $room->id) }}">
    @csrf

    <div class="grid lg:grid-cols-[minmax(0,1.6fr)_minmax(300px,1fr)] gap-6 items-start">
        <!-- Kolom 1: Formulir Input -->
        <div class="space-y-6">
            <!-- Section 1: Jadwal Menginap -->
            <section class="bg-surface border border-line rounded-[10px] p-5 sm:p-7 shadow-sm">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="font-semibold text-base">1. Jadwal Menginap</h2>
                    <span class="text-[11px] text-text-muted font-medium">Check-in 14.00 · Check-out 12.00 WIB</span>
                </div>
                <div class="grid sm:grid-cols-2 gap-4">
                    <label class="block text-xs font-semibold text-text-muted">
                        Tanggal Check-in
                        <input type="date" id="check_in_date" name="check_in_date" min="{{ $today }}" value="{{ $defaultCheckIn }}" required
                               class="mt-1.5 w-full h-10 rounded-md border border-line-strong bg-surface px-3 text-sm text-text focus:outline-2 focus:outline-pine-700">
                    </label>
                    <label class="block text-xs font-semibold text-text-muted">
                        Tanggal Check-out
                        <input type="date" id="check_out_date" name="check_out_date" min="{{ $tomorrow }}" value="{{ $defaultCheckOut }}" required
                               class="mt-1.5 w-full h-10 rounded-md border border-line-strong bg-surface px-3 text-sm text-text focus:outline-2 focus:outline-pine-700">
                    </label>
                </div>
                <p class="text-[11px] text-text-muted mt-3">Durasi sewa dihitung per malam. Pastikan tanggal check-out setelah tanggal check-in.</p>
            </section>

            <!-- Section 2: Data Kontak Tamu -->
            <section class="bg-surface border border-line rounded-[10px] p-5 sm:p-7 shadow-sm">
                <h2 class="font-semibold text-base mb-4">2. Data Kontak Tamu</h2>
                <div class="space-y-4">
                    <label class="block text-xs font-semibold text-text-muted">
                        Nama Lengkap Tamu
                        <input type="text" name="guest_name" maxlength="255" value="{{ old('guest_name', $user->name) }}" required
                               class="mt-1.5 w-full h-10 rounded-md border border-line-strong bg-surface px-3 text-sm text-text focus:outline-2 focus:outline-pine-700">
                    </label>
                    <div class="grid sm:grid-cols-2 gap-4">
                        <label class="block text-xs font-semibold text-text-muted">
                            Alamat Email
                            <input type="email" name="guest_email" maxlength="255" value="{{ old('guest_email', $user->email) }}" required
                                   class="mt-1.5 w-full h-10 rounded-md border border-line-strong bg-surface px-3 text-sm text-text focus:outline-2 focus:outline-pine-700">
                        </label>
                        <label class="block text-xs font-semibold text-text-muted">
                            Nomor Telepon / WhatsApp
                            <input type="text" name="guest_phone" maxlength="30" value="{{ old('guest_phone', $user->phone ?: '081234567890') }}" required
                                   class="mt-1.5 w-full h-10 rounded-md border border-line-strong bg-surface px-3 text-sm text-text focus:outline-2 focus:outline-pine-700">
                        </label>
                    </div>
                </div>
            </section>

            <!-- Section 3: Asuransi Pembatalan (PRD Rule) -->
            <section class="bg-surface border border-line rounded-[10px] p-5 sm:p-7 shadow-sm">
                <div class="flex items-start gap-3">
                    <input type="checkbox" id="has_insurance" name="has_insurance" value="1" @checked(old('has_insurance', true))
                           class="mt-1 h-4 w-4 rounded border-line-strong text-pine-700 focus:ring-pine-700">
                    <label for="has_insurance" class="cursor-pointer">
                        <span class="block text-sm font-semibold text-text">Tambahkan Asuransi Pembatalan (+ Rp 25.000)</span>
                        <span class="block text-xs text-text-muted mt-1 leading-relaxed">
                            Dapatkan jaminan pengembalian dana biaya sewa jika Anda harus membatalkan perjalanan sebelum tanggal check-in:
                        </span>
                        <span class="block text-[11px] text-text-muted mt-1 space-y-0.5">
                            <span>• Pembatalan &gt; 3 hari sebelum check-in: <strong>Refund 100%</strong> biaya sewa kamar.</span><br>
                            <span>• Pembatalan &le; 3 hari sebelum check-in: <strong>Refund 50%</strong> biaya sewa kamar.</span><br>
                            <span>• Tanpa asuransi: Pembatalan tidak memperoleh pengembalian dana (refund 0%).</span>
                        </span>
                    </label>
                </div>
            </section>
        </div>

        <!-- Kolom 2: Ringkasan Kamar & Rincian Estimasi Biaya (Sidebar) -->
        <aside class="lg:sticky lg:top-24 space-y-5">
            <article class="bg-surface border border-line rounded-[10px] overflow-hidden shadow-sm">
                <div class="relative aspect-16/10 bg-sunken">
                    <img src="{{ $image }}" alt="{{ $room->name }}" class="w-full h-full object-cover">
                    <span class="absolute top-3 left-3 bg-ink-900/80 backdrop-blur-sm text-white text-[11px] font-semibold px-2.5 py-1 rounded">
                        {{ $room->category }}
                    </span>
                </div>
                <div class="p-5">
                    <h3 class="font-display font-semibold text-lg">{{ $room->name }}</h3>
                    <p class="text-xs text-text-muted mt-1 leading-relaxed">{{ $room->description }}</p>
                    <div class="mt-4 pt-3 border-t border-line flex items-baseline justify-between text-xs">
                        <span class="text-text-muted">Tarif kamar:</span>
                        <strong class="font-semibold text-sm text-pine-700 tabular-nums">
                            Rp {{ number_format((float) $room->price_per_night, 0, ',', '.') }}
                            <span class="text-xs font-normal text-text-muted">/ malam</span>
                        </strong>
                    </div>
                    <div class="mt-2 flex items-baseline justify-between text-xs">
                        <span class="text-text-muted">Ketersediaan total:</span>
                        <span class="font-semibold">{{ $room->total_stock }} unit glamping</span>
                    </div>
                </div>
            </article>

            <!-- Kartu Kalkulasi Biaya Live dengan Hirarki Jelas -->
            <section class="bg-surface border border-line rounded-[10px] p-5 sm:p-6 shadow-sm" aria-labelledby="calc-heading">
                <div class="border-b border-line pb-3 mb-4">
                    <p class="text-[11px] text-text-muted font-medium tracking-wider uppercase">Rincian Perhitungan</p>
                    <h3 id="calc-heading" class="font-display font-semibold text-lg text-text">Estimasi Biaya Reservasi</h3>
                </div>

                <div class="space-y-4 text-xs">
                    <!-- Item 1: Biaya Sewa Kamar Glamping -->
                    <div class="flex items-start justify-between gap-3">
                        <div class="min-w-0">
                            <p class="font-semibold text-sm text-text truncate">{{ $room->name }}</p>
                            <p class="text-text-muted mt-0.5 tabular-nums">
                                Rp {{ number_format((float) $room->price_per_night, 0, ',', '.') }} × <span id="summary-nights-text" class="font-medium text-text">1 malam</span>
                            </p>
                        </div>
                        <div class="text-right shrink-0">
                            <span id="summary-room-subtotal" class="font-semibold text-sm text-text tabular-nums">
                                Rp {{ number_format((float) $room->price_per_night, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>

                    <!-- Item 2: Premi Asuransi Pembatalan -->
                    <div class="flex items-start justify-between gap-3 pt-3 border-t border-line/60">
                        <div class="min-w-0">
                            <p class="font-semibold text-sm text-text">Asuransi Pembatalan</p>
                            <p id="summary-insurance-desc" class="text-text-muted mt-0.5 text-[11px]">
                                Dipilih (Garansi refund hingga 100%)
                            </p>
                        </div>
                        <div class="text-right shrink-0">
                            <span id="summary-insurance" class="font-semibold text-sm text-text tabular-nums">
                                Rp 25.000
                            </span>
                        </div>
                    </div>

                    <!-- Divider & Total Tagihan (Hierarchy Utama) -->
                    <div class="pt-4 border-t-2 border-line">
                        <div class="flex items-baseline justify-between gap-3">
                            <div>
                                <p class="text-[11px] uppercase tracking-wider text-text-muted font-medium">Total Pembayaran</p>
                                <p class="font-display font-semibold text-base text-text">Total Tagihan</p>
                            </div>
                            <div class="text-right">
                                <p id="summary-total" class="font-display font-semibold text-xl sm:text-2xl text-pine-700 tabular-nums">
                                    Rp {{ number_format((float) $room->price_per_night + 25000, 0, ',', '.') }}
                                </p>
                            </div>
                        </div>
                        <p class="text-[11px] text-text-muted mt-2 text-right">Termasuk fasilitas kamar dan pelayanan staf</p>
                    </div>
                </div>

                <div class="mt-4 p-3 bg-sunken rounded-md border border-line text-[11px] text-text-muted">
                    Status awal reservasi akan tercatat sebagai <strong class="text-text">unpaid</strong>. Anda akan langsung dialihkan ke sandbox QRIS untuk simulasi pembayaran.
                </div>

                <!-- Tombol Konfirmasi Utama (Terletak di Paling Akhir setelah Rincian Biaya) -->
                <button type="submit" class="w-full mt-5 min-h-11 bg-pine-700 hover:bg-pine-600 text-white rounded-md font-semibold text-sm transition-colors shadow-sm">
                    Konfirmasi Reservasi & Lanjut ke Pembayaran
                </button>
            </section>
        </aside>
    </div>
</form>

@push('scripts')
<script>
    (function() {
        const pricePerNight = {{ (float) $room->price_per_night }};
        const insuranceFee = 25000;

        const checkInInput = document.getElementById('check_in_date');
        const checkOutInput = document.getElementById('check_out_date');
        const insuranceInput = document.getElementById('has_insurance');

        const nightsTextEl = document.getElementById('summary-nights-text');
        const subtotalEl = document.getElementById('summary-room-subtotal');
        const insuranceDescEl = document.getElementById('summary-insurance-desc');
        const insuranceEl = document.getElementById('summary-insurance');
        const totalEl = document.getElementById('summary-total');

        function formatIDR(amount) {
            return 'Rp ' + amount.toLocaleString('id-ID');
        }

        function recalculate() {
            const inDate = new Date(checkInInput.value);
            const outDate = new Date(checkOutInput.value);

            let nights = Math.round((outDate - inDate) / (1000 * 60 * 60 * 24));
            if (isNaN(nights) || nights < 1) {
                nights = 1;
            }

            const roomSubtotal = pricePerNight * nights;
            const hasIns = insuranceInput.checked;
            const insTotal = hasIns ? insuranceFee : 0;
            const grandTotal = roomSubtotal + insTotal;

            if (nightsTextEl) {
                nightsTextEl.textContent = nights + ' malam';
            }
            if (subtotalEl) {
                subtotalEl.textContent = formatIDR(roomSubtotal);
            }
            if (insuranceDescEl) {
                insuranceDescEl.textContent = hasIns
                    ? 'Dipilih (Garansi refund hingga 100%)'
                    : 'Tidak dipilih (Refund 0%)';
            }
            if (insuranceEl) {
                insuranceEl.textContent = hasIns ? formatIDR(insuranceFee) : 'Rp 0';
            }
            if (totalEl) {
                totalEl.textContent = formatIDR(grandTotal);
            }

            // Perbarui batas minimal check-out date
            if (checkInInput.value) {
                const nextDay = new Date(inDate);
                nextDay.setDate(nextDay.getDate() + 1);
                const nextDayStr = nextDay.toISOString().split('T')[0];
                checkOutInput.min = nextDayStr;
                if (checkOutInput.value && checkOutInput.value <= checkInInput.value) {
                    checkOutInput.value = nextDayStr;
                    recalculate();
                }
            }
        }

        checkInInput.addEventListener('change', recalculate);
        checkOutInput.addEventListener('change', recalculate);
        insuranceInput.addEventListener('change', recalculate);

        recalculate();
    })();
</script>
@endpush
@endsection
