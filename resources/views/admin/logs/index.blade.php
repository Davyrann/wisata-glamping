@extends('layouts.dashboard', [
    'title' => 'Log Aktivitas',
    'subtitle' => 'Panel Admin / Log Aktivitas'
])

@section('content')
<div class="mb-7">
    <p class="text-xs tracking-[0.14em] uppercase text-text-muted mb-2">Audit Trail</p>
    <h1 class="font-display text-[clamp(1.8rem,3vw,2.5rem)] font-semibold leading-tight">Log Aktivitas</h1>
    <p class="mt-2 text-text-muted text-sm sm:text-base">Rekam jejak tindakan staf dan administrator: login, pengelolaan akun, dan operasional.</p>
</div>

<form method="GET" action="{{ route('admin.logs') }}" class="bg-surface border border-line rounded-[10px] p-4 sm:p-5 mb-5" aria-label="Filter log aktivitas">
    <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-3">
        <label class="block text-xs font-semibold text-text-muted">Kata kunci
            <input type="search" name="search" maxlength="100" value="{{ $filters['search'] ?? '' }}" placeholder="Nama atau keterangan" class="mt-1.5 w-full h-10 rounded-md border border-line-strong bg-surface px-3 text-sm text-text focus:outline-2 focus:outline-offset-1 focus:outline-pine-700">
        </label>
        <label class="block text-xs font-semibold text-text-muted">Aksi
            <select name="action" class="mt-1.5 w-full h-10 rounded-md border border-line-strong bg-surface px-3 text-sm text-text focus:outline-2 focus:outline-offset-1 focus:outline-pine-700">
                <option value="">Semua aksi</option>
                @foreach ($actions as $action)
                    <option value="{{ $action }}" @selected(($filters['action'] ?? '') === $action)>{{ $action }}</option>
                @endforeach
            </select>
        </label>
        <label class="block text-xs font-semibold text-text-muted">Dari tanggal
            <input type="date" name="from" value="{{ $filters['from'] ?? '' }}" class="mt-1.5 w-full h-10 rounded-md border border-line-strong bg-surface px-3 text-sm text-text focus:outline-2 focus:outline-offset-1 focus:outline-pine-700">
        </label>
        <label class="block text-xs font-semibold text-text-muted">Sampai tanggal
            <input type="date" name="to" value="{{ $filters['to'] ?? '' }}" class="mt-1.5 w-full h-10 rounded-md border border-line-strong bg-surface px-3 text-sm text-text focus:outline-2 focus:outline-offset-1 focus:outline-pine-700">
        </label>
    </div>
    @if ($errors->any())
        <p class="mt-3 text-xs text-danger font-medium" role="alert">Filter tidak valid. Periksa kembali rentang tanggal.</p>
    @endif
    <div class="flex flex-wrap gap-3 items-center mt-4 pt-3 border-t border-line">
        <button type="submit" class="bg-pine-700 hover:bg-pine-600 text-white text-xs font-semibold min-h-10 px-4 rounded-md">Terapkan filter</button>
        <a href="{{ route('admin.logs') }}" class="text-pine-700 underline underline-offset-4 text-xs font-semibold min-h-10 inline-flex items-center">Atur ulang</a>
    </div>
</form>

@if ($logs->isEmpty())
    <section class="bg-surface border border-line rounded-[10px] p-8 sm:p-12 text-center" aria-live="polite">
        <h2 class="font-semibold text-lg">Tidak ada log ditemukan</h2>
        <p class="mt-2 text-sm text-text-muted">Belum ada aktivitas yang cocok dengan filter ini.</p>
    </section>
@else
    <section class="bg-surface border border-line rounded-[10px] overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs border-collapse">
                <thead>
                    <tr class="bg-sunken text-text-muted uppercase text-[11px]">
                        <th class="py-3 px-4">Waktu</th>
                        <th class="py-3 px-4">Pengguna</th>
                        <th class="py-3 px-4">Aksi</th>
                        <th class="py-3 px-4">Keterangan</th>
                        <th class="py-3 px-4">IP Address</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-line">
                    @foreach ($logs as $log)
                        <tr>
                            <td class="py-3 px-4 text-text-muted tabular-nums whitespace-nowrap">{{ $log->created_at?->timezone('Asia/Jakarta')->format('d/m/Y H:i') }}</td>
                            <td class="py-3 px-4 font-medium whitespace-nowrap">{{ $log->user?->name ?? 'Sistem' }} <span class="text-text-muted font-normal">({{ $log->user?->role ?? '-' }})</span></td>
                            <td class="py-3 px-4"><span class="inline-block px-2 py-0.5 rounded bg-sunken font-semibold text-[11px]">{{ $log->action }}</span></td>
                            <td class="py-3 px-4 min-w-64">{{ $log->description }}</td>
                            <td class="py-3 px-4 font-mono text-[11px] text-text-muted">{{ $log->ip_address ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>

    <div class="mt-6">{{ $logs->links() }}</div>
@endif
@endsection
