@extends('layouts.dashboard', [
    'title' => 'Panel Administrator',
    'subtitle' => 'Panel Admin / Manajemen Sistem'
])

@section('content')
<div class="mb-8">
    <div class="flex items-center gap-2 mb-2">
        <p class="text-xs tracking-[0.14em] uppercase text-text-muted">Manajemen Glamping</p>
        <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-semibold bg-sunken text-text-muted">Role: admin</span>
    </div>
    <h1 class="font-display text-[clamp(1.8rem,3vw,2.5rem)] font-semibold leading-tight">Panel Administrator</h1>
    <p class="mt-2 text-text-muted text-sm sm:text-base">Kelola akun, inventori kamar, dan pantau log aktivitas staf operasional glamping.</p>
</div>

<!-- Metrik Administrator -->
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
    <div class="bg-surface border border-line rounded-[10px] p-5 shadow-sm">
        <p class="text-xs text-text-muted font-medium mb-1">TOTAL PENGGUNA TAMU</p>
        <p class="font-display text-2xl font-semibold tabular-nums">{{ $metrics['total_users'] }}</p>
    </div>
    <div class="bg-surface border border-line rounded-[10px] p-5 shadow-sm">
        <p class="text-xs text-text-muted font-medium mb-1">TOTAL STAF</p>
        <p class="font-display text-2xl font-semibold tabular-nums">{{ $metrics['total_staff'] }}</p>
    </div>
    <div class="bg-surface border border-line rounded-[10px] p-5 shadow-sm">
        <p class="text-xs text-text-muted font-medium mb-1">TOTAL TIPE KAMAR</p>
        <p class="font-display text-2xl font-semibold tabular-nums">{{ $metrics['total_rooms'] }}</p>
    </div>
    <div class="bg-surface border border-line rounded-[10px] p-5 shadow-sm">
        <p class="text-xs text-text-muted font-medium mb-1">TOTAL RESERVASI</p>
        <p class="font-display text-2xl font-semibold tabular-nums">{{ $metrics['total_bookings'] }}</p>
    </div>
</div>

<!-- Log Aktivitas Staf -->
<section class="bg-surface border border-line rounded-[10px] p-5 sm:p-7 shadow-sm">
    <div class="flex items-center justify-between mb-5">
        <div>
            <h2 class="font-semibold text-lg">Catatan Audit Staf (Activity Logs)</h2>
            <p class="text-xs text-text-muted">Rekam jejak tindakan staf dan administrator sistem.</p>
        </div>
    </div>

    @if ($recentLogs->isEmpty())
        <div class="py-8 text-center text-xs text-text-muted">
            Belum ada log aktivitas tercatat.
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs border-collapse">
                <thead>
                    <tr class="border-b border-line text-text-muted uppercase text-[11px]">
                        <th class="py-2.5 px-3">Waktu</th>
                        <th class="py-2.5 px-3">Pengguna</th>
                        <th class="py-2.5 px-3">Aksi</th>
                        <th class="py-2.5 px-3">Keterangan</th>
                        <th class="py-2.5 px-3">IP Address</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-line">
                    @foreach ($recentLogs as $log)
                        <tr>
                            <td class="py-3 px-3 text-text-muted tabular-nums whitespace-nowrap">{{ $log->created_at->format('d/m/Y H:i') }}</td>
                            <td class="py-3 px-3 font-medium whitespace-nowrap">{{ $log->user?->name ?? 'Sistem' }} ({{ $log->user?->role ?? '-' }})</td>
                            <td class="py-3 px-3 font-semibold uppercase text-[11px]">{{ $log->action }}</td>
                            <td class="py-3 px-3">{{ $log->description }}</td>
                            <td class="py-3 px-3 font-mono text-[11px] text-text-muted">{{ $log->ip_address ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</section>
@endsection
