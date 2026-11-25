@extends('layouts.dashboard', [
    'title' => 'Panel Administrator',
    'subtitle' => 'Panel Admin / Manajemen Sistem'
])

@section('content')
<div class="mb-8 flex flex-col sm:flex-row sm:items-end justify-between gap-4">
    <div>
        <div class="flex items-center gap-2 mb-2">
            <p class="text-xs tracking-[0.14em] uppercase text-text-muted">Manajemen Glamping</p>
            <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-semibold bg-sunken text-text-muted">Role: admin</span>
        </div>
        <h1 class="font-display text-[clamp(1.8rem,3vw,2.5rem)] font-semibold leading-tight">Panel Administrator</h1>
        <p class="mt-2 text-text-muted text-sm sm:text-base">Kelola akun, inventori kamar, dan pantau log aktivitas staf operasional glamping.</p>
    </div>
    <a href="{{ route('admin.users.create') }}" class="inline-flex items-center justify-center w-full sm:w-auto rounded-md bg-pine-700 hover:bg-pine-600 text-white text-sm font-semibold px-4 min-h-11 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-pine-700">Tambah akun</a>
</div>

<!-- Metrik Administrator -->
<div class="grid grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-4 mb-8">
    <div class="bg-surface border border-line rounded-[10px] p-4 sm:p-5">
        <p class="text-[11px] sm:text-xs text-text-muted font-medium mb-1">TOTAL PENGGUNA TAMU</p>
        <p class="font-display text-xl sm:text-2xl font-semibold tabular-nums">{{ $metrics['total_users'] }}</p>
    </div>
    <div class="bg-surface border border-line rounded-[10px] p-4 sm:p-5">
        <p class="text-[11px] sm:text-xs text-text-muted font-medium mb-1">TOTAL STAF</p>
        <p class="font-display text-xl sm:text-2xl font-semibold tabular-nums">{{ $metrics['total_staff'] }}</p>
    </div>
    <div class="bg-surface border border-line rounded-[10px] p-4 sm:p-5">
        <p class="text-[11px] sm:text-xs text-text-muted font-medium mb-1">TOTAL TIPE KAMAR</p>
        <p class="font-display text-xl sm:text-2xl font-semibold tabular-nums">{{ $metrics['total_rooms'] }}</p>
    </div>
    <div class="bg-surface border border-line rounded-[10px] p-4 sm:p-5">
        <p class="text-[11px] sm:text-xs text-text-muted font-medium mb-1">TOTAL RESERVASI</p>
        <p class="font-display text-xl sm:text-2xl font-semibold tabular-nums">{{ $metrics['total_bookings'] }}</p>
    </div>
    <div class="col-span-2 sm:col-span-1 bg-surface border border-line rounded-[10px] p-4 sm:p-5">
        <p class="text-[11px] sm:text-xs text-text-muted font-medium mb-1">PENDAPATAN (DUMMY)</p>
        <p class="font-display text-xl sm:text-2xl font-semibold tabular-nums">Rp {{ number_format($metrics['revenue'], 0, ',', '.') }}</p>
    </div>
    <div class="col-span-2 sm:col-span-1 bg-surface border border-line rounded-[10px] p-4 sm:p-5">
        <p class="text-[11px] sm:text-xs text-text-muted font-medium mb-1">PEMBATALAN PENDING</p>
        <p class="font-display text-xl sm:text-2xl font-semibold tabular-nums {{ $metrics['pending_cancellations'] > 0 ? 'text-unpaid-fg' : '' }}">{{ $metrics['pending_cancellations'] }}</p>
    </div>
</div>

<div class="grid lg:grid-cols-3 gap-6 items-start">
    <!-- Sebaran Status Reservasi -->
    <section class="bg-surface border border-line rounded-[10px] p-5 sm:p-6 lg:col-span-1">
        <h2 class="font-semibold text-lg mb-1">Status reservasi</h2>
        <p class="text-xs text-text-muted mb-4">Jumlah reservasi per status saat ini.</p>
        @php
            $statusRows = [
                'unpaid' => ['Menunggu pembayaran', 'bg-unpaid-bg text-unpaid-fg'],
                'confirmed' => ['Terkonfirmasi', 'bg-confirmed-bg text-confirmed-fg'],
                'cancellation_requested' => ['Menunggu pembatalan', 'bg-unpaid-bg text-unpaid-fg'],
                'checked_in' => ['Sedang menginap', 'bg-checkedin-bg text-checkedin-fg'],
                'completed' => ['Selesai', 'bg-completed-bg text-completed-fg'],
                'cancelled' => ['Dibatalkan', 'bg-cancelled-bg text-cancelled-fg'],
            ];
        @endphp
        <ul class="divide-y divide-line">
            @foreach ($statusRows as $key => [$label, $badge])
                <li class="flex items-center justify-between py-2.5">
                    <span class="inline-block px-2 py-0.5 rounded-full text-[11px] font-semibold {{ $badge }}">{{ $label }}</span>
                    <span class="text-sm font-semibold tabular-nums">{{ $statusCounts[$key] ?? 0 }}</span>
                </li>
            @endforeach
        </ul>
    </section>

    <!-- Log Aktivitas Staf -->
    <section class="bg-surface border border-line rounded-[10px] p-5 sm:p-6 lg:col-span-2">
        <div class="flex items-center justify-between gap-3 mb-5">
            <div>
                <h2 class="font-semibold text-lg">Catatan audit terbaru</h2>
                <p class="text-xs text-text-muted">Rekam jejak tindakan staf dan administrator sistem.</p>
            </div>
            <a href="{{ route('admin.logs') }}" class="inline-flex items-center min-h-11 sm:min-h-0 text-pine-700 underline underline-offset-4 text-xs font-semibold whitespace-nowrap">Lihat semua</a>
        </div>

        @if ($recentLogs->isEmpty())
            <div class="py-8 text-center text-xs text-text-muted">
                Belum ada log aktivitas tercatat.
            </div>
        @else
            <ul class="md:hidden divide-y divide-line">
                @foreach ($recentLogs as $log)
                    <li class="py-3 first:pt-0 last:pb-0 space-y-1.5">
                        <div class="flex items-center justify-between gap-2">
                            <span class="inline-block px-2 py-0.5 rounded bg-sunken font-semibold text-[11px]">{{ $log->action }}</span>
                            <span class="text-[11px] text-text-muted tabular-nums">{{ $log->created_at->timezone('Asia/Jakarta')->format('d/m/Y H:i') }}</span>
                        </div>
                        <p class="text-xs font-medium">{{ $log->user?->name ?? 'Sistem' }} <span class="text-text-muted font-normal">({{ $log->user?->role ?? '-' }})</span></p>
                        <p class="text-xs text-text-muted wrap-break-word">{{ $log->description }}</p>
                    </li>
                @endforeach
            </ul>

            <div class="hidden md:block overflow-x-auto">
                <table class="w-full text-left text-xs border-collapse">
                    <thead>
                        <tr class="border-b border-line text-text-muted uppercase text-[11px]">
                            <th class="py-2.5 px-3">Waktu</th>
                            <th class="py-2.5 px-3">Pengguna</th>
                            <th class="py-2.5 px-3">Aksi</th>
                            <th class="py-2.5 px-3">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-line">
                        @foreach ($recentLogs as $log)
                            <tr>
                                <td class="py-3 px-3 text-text-muted tabular-nums whitespace-nowrap">{{ $log->created_at->timezone('Asia/Jakarta')->format('d/m/Y H:i') }}</td>
                                <td class="py-3 px-3 font-medium whitespace-nowrap">{{ $log->user?->name ?? 'Sistem' }} ({{ $log->user?->role ?? '-' }})</td>
                                <td class="py-3 px-3"><span class="inline-block px-2 py-0.5 rounded bg-sunken font-semibold text-[11px]">{{ $log->action }}</span></td>
                                <td class="py-3 px-3">{{ $log->description }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </section>
</div>
@endsection
