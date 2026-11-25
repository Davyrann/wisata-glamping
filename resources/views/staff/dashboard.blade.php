@extends('layouts.dashboard', [
    'title' => 'Dashboard Operasional Staf',
    'subtitle' => 'Panel Staf Glamping / Operasional'
])

@section('content')
<div class="mb-8">
    <div class="flex items-center gap-2 mb-2">
        <p class="text-xs tracking-[0.14em] uppercase text-text-muted">Operasional Staf</p>
        <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-semibold bg-sunken text-text-muted">Role: {{ auth()->user()->role }}</span>
    </div>
    <h1 class="font-display text-[clamp(1.8rem,3vw,2.5rem)] font-semibold leading-tight">Dashboard Operasional</h1>
    <p class="mt-2 text-text-muted text-sm sm:text-base">Pantau jadwal serah terima kamar, check-in, check-out, serta permohonan pembatalan tamu.</p>
</div>

<!-- Metrik Operasional -->
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
    <div class="bg-surface border border-line rounded-[10px] p-5 shadow-sm">
        <p class="text-xs text-text-muted font-medium mb-1">CHECK-IN HARI INI</p>
        <p class="font-display text-2xl font-semibold tabular-nums">{{ $metrics['today_checkins'] }}</p>
    </div>
    <div class="bg-surface border border-line rounded-[10px] p-5 shadow-sm">
        <p class="text-xs text-text-muted font-medium mb-1">RESERVASI AKTIF</p>
        <p class="font-display text-2xl font-semibold tabular-nums">{{ $metrics['active_reservations'] }}</p>
    </div>
    <div class="bg-surface border border-line rounded-[10px] p-5 shadow-sm">
        <p class="text-xs text-text-muted font-medium mb-1">PEMBATALAN PENDING</p>
        <p class="font-display text-2xl font-semibold tabular-nums {{ $metrics['pending_cancellations'] > 0 ? 'text-amber-700' : '' }}">{{ $metrics['pending_cancellations'] }}</p>
    </div>
    <div class="bg-surface border border-line rounded-[10px] p-5 shadow-sm">
        <p class="text-xs text-text-muted font-medium mb-1">TOTAL TIPE KAMAR</p>
        <p class="font-display text-2xl font-semibold tabular-nums">{{ $metrics['total_rooms'] }}</p>
    </div>
</div>

<!-- Transaksi / Reservasi Terkini -->
<section class="bg-surface border border-line rounded-[10px] p-5 sm:p-7 shadow-sm">
    <div class="flex items-center justify-between mb-5">
        <div>
            <h2 class="font-semibold text-lg">Aktivitas Reservasi Terkini</h2>
            <p class="text-xs text-text-muted">Daftar pemesanan terbaru yang masuk ke dalam sistem.</p>
        </div>
    </div>

    @if ($recentBookings->isEmpty())
        <div class="py-8 text-center text-xs text-text-muted">
            Belum ada data reservasi tercatat di sistem.
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs border-collapse">
                <thead>
                    <tr class="border-b border-line text-text-muted uppercase text-[11px]">
                        <th class="py-2.5 px-3">Kode Booking</th>
                        <th class="py-2.5 px-3">Tamu</th>
                        <th class="py-2.5 px-3">Kamar</th>
                        <th class="py-2.5 px-3">Check-in</th>
                        <th class="py-2.5 px-3">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-line">
                    @foreach ($recentBookings as $b)
                        <tr>
                            <td class="py-3 px-3 font-mono font-semibold">{{ $b->booking_code }}</td>
                            <td class="py-3 px-3 font-medium">{{ $b->guest_name }}</td>
                            <td class="py-3 px-3">{{ $b->room_name }}</td>
                            <td class="py-3 px-3 tabular-nums">{{ $b->check_in_date }}</td>
                            <td class="py-3 px-3">
                                <span class="inline-block px-2 py-0.5 rounded text-[11px] font-semibold bg-sunken">
                                    {{ $b->status }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</section>
@endsection
