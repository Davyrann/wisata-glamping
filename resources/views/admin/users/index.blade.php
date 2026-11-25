@extends('layouts.dashboard', [
    'title' => 'Manajemen Akun',
    'subtitle' => 'Panel Admin / Manajemen Akun'
])

@section('content')
@php
    $roleBadge = [
        'admin' => 'bg-ember-100 text-ember-600',
        'staff' => 'bg-checkedin-bg text-checkedin-fg',
        'user' => 'bg-completed-bg text-completed-fg',
    ];
@endphp

<div class="mb-7 flex flex-col sm:flex-row sm:items-end justify-between gap-4">
    <div>
        <p class="text-xs tracking-[0.14em] uppercase text-text-muted mb-2">Akses & Peran</p>
        <h1 class="font-display text-[clamp(1.8rem,3vw,2.5rem)] font-semibold leading-tight">Manajemen Akun</h1>
        <p class="mt-2 text-text-muted text-sm sm:text-base">Buat, ubah, dan hapus akun Admin, Staff, maupun Tamu.</p>
    </div>
    <a href="{{ route('admin.users.create') }}" class="inline-flex items-center justify-center w-full sm:w-auto rounded-md bg-pine-700 hover:bg-pine-600 text-white text-sm font-semibold px-4 min-h-11 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-pine-700">Tambah akun</a>
</div>

<!-- Tab Peran -->
<nav class="grid grid-cols-2 lg:grid-cols-4 gap-2 mb-5" aria-label="Filter peran">
    <a href="{{ route('admin.users.index', request()->except('page', 'role')) }}" @if (empty($filters['role'])) aria-current="page" @endif
       class="flex items-center justify-between gap-2 min-h-11 px-3 sm:px-4 rounded-md border text-sm font-semibold transition-colors {{ empty($filters['role']) ? 'bg-pine-700 text-white border-pine-700' : 'bg-surface border-line text-text hover:border-line-strong' }}">
        <span>Semua</span>
        <span class="text-xs tabular-nums {{ empty($filters['role']) ? 'text-white/85' : 'text-text-muted' }}">{{ $counts->sum() }}</span>
    </a>
    @foreach ($roles as $key => $label)
        @php $active = ($filters['role'] ?? '') === $key; @endphp
        <a href="{{ route('admin.users.index', array_merge(request()->except('page', 'role'), ['role' => $key])) }}" @if ($active) aria-current="page" @endif
           class="flex items-center justify-between gap-2 min-h-11 px-3 sm:px-4 rounded-md border text-sm font-semibold transition-colors {{ $active ? 'bg-pine-700 text-white border-pine-700' : 'bg-surface border-line text-text hover:border-line-strong' }}">
            <span>{{ $label }}</span>
            <span class="text-xs tabular-nums {{ $active ? 'text-white/85' : 'text-text-muted' }}">{{ $counts[$key] ?? 0 }}</span>
        </a>
    @endforeach
</nav>

<!-- Pencarian -->
<form method="GET" action="{{ route('admin.users.index') }}" class="bg-surface border border-line rounded-[10px] p-4 sm:p-5 mb-5" aria-label="Cari akun">
    @if (! empty($filters['role']))
        <input type="hidden" name="role" value="{{ $filters['role'] }}">
    @endif
    <div class="flex flex-col sm:flex-row gap-3 sm:items-end">
        <label class="block text-xs font-semibold text-text-muted flex-1">Nama atau email
            <input type="search" name="search" maxlength="100" value="{{ $filters['search'] ?? '' }}" placeholder="Cari akun..." class="mt-1.5 w-full h-10 rounded-md border border-line-strong bg-surface px-3 text-sm text-text focus:outline-2 focus:outline-offset-1 focus:outline-pine-700">
        </label>
        <div class="flex gap-3 items-center">
            <button type="submit" class="bg-pine-700 hover:bg-pine-600 text-white text-xs font-semibold min-h-11 sm:min-h-10 px-4 rounded-md">Cari</button>
            <a href="{{ route('admin.users.index') }}" class="text-pine-700 underline underline-offset-4 text-xs font-semibold min-h-11 sm:min-h-10 inline-flex items-center">Atur ulang</a>
        </div>
    </div>
</form>

@if ($users->isEmpty())
    <section class="bg-surface border border-line rounded-[10px] p-8 sm:p-12 text-center" aria-live="polite">
        <h2 class="font-semibold text-lg">Tidak ada akun ditemukan</h2>
        <p class="mt-2 text-sm text-text-muted">Coba ubah kata kunci atau filter peran.</p>
    </section>
@else
    <div class="md:hidden space-y-3">
        @foreach ($users as $account)
            <article class="bg-surface border border-line rounded-[10px] p-4 space-y-3">
                <div class="flex items-start justify-between gap-2">
                    <div class="min-w-0">
                        <p class="font-semibold text-sm wrap-break-word">{{ $account->name }}@if ($account->is(auth()->user())) <span class="ml-1 text-[11px] font-medium text-text-muted">(Anda)</span>@endif</p>
                        <p class="text-xs text-text-muted">Bergabung {{ $account->created_at?->locale('id')->translatedFormat('d M Y') }}</p>
                    </div>
                    <span class="shrink-0 inline-block px-2 py-0.5 rounded-full text-[11px] font-semibold {{ $roleBadge[$account->role] ?? 'bg-sunken text-text-muted' }}">{{ $roles[$account->role] ?? $account->role }}</span>
                </div>
                <div class="text-xs space-y-1">
                    <p class="break-all">{{ $account->email }}</p>
                    <p class="text-text-muted tabular-nums">{{ $account->phone ?: '-' }} · {{ $account->bookings_count }} reservasi</p>
                </div>
                <div class="flex items-center gap-2 pt-2 border-t border-line">
                    <a href="{{ route('admin.users.edit', $account) }}" class="flex-1 inline-flex items-center justify-center min-h-11 px-3 rounded-md border border-line-strong bg-surface hover:bg-sunken text-xs font-semibold">Ubah</a>
                    @unless ($account->is(auth()->user()))
                        <form method="POST" action="{{ route('admin.users.destroy', $account) }}" class="flex-1" onsubmit="return confirm(@js('Hapus akun '.$account->name.'? Tindakan ini tidak dapat dibatalkan.'))">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full inline-flex items-center justify-center min-h-11 px-3 rounded-md border border-danger text-danger hover:bg-cancelled-bg text-xs font-semibold">Hapus</button>
                        </form>
                    @endunless
                </div>
            </article>
        @endforeach
    </div>

    <section class="hidden md:block bg-surface border border-line rounded-[10px] overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm border-collapse">
                <thead>
                    <tr class="bg-sunken text-text-muted text-[11px] uppercase">
                        <th class="py-3 px-4">Nama</th>
                        <th class="py-3 px-4">Kontak</th>
                        <th class="py-3 px-4">Peran</th>
                        <th class="py-3 px-4 text-right">Reservasi</th>
                        <th class="py-3 px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-line">
                    @foreach ($users as $account)
                        <tr>
                            <td class="py-3 px-4">
                                <p class="font-semibold">{{ $account->name }}@if ($account->is(auth()->user())) <span class="ml-1 text-[11px] font-medium text-text-muted">(Anda)</span>@endif</p>
                                <p class="text-xs text-text-muted">Bergabung {{ $account->created_at?->locale('id')->translatedFormat('d M Y') }}</p>
                            </td>
                            <td class="py-3 px-4 text-xs">
                                <p>{{ $account->email }}</p>
                                <p class="text-text-muted tabular-nums">{{ $account->phone ?: '-' }}</p>
                            </td>
                            <td class="py-3 px-4">
                                <span class="inline-block px-2 py-0.5 rounded-full text-[11px] font-semibold {{ $roleBadge[$account->role] ?? 'bg-sunken text-text-muted' }}">{{ $roles[$account->role] ?? $account->role }}</span>
                            </td>
                            <td class="py-3 px-4 text-right tabular-nums">{{ $account->bookings_count }}</td>
                            <td class="py-3 px-4">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.users.edit', $account) }}" class="inline-flex items-center justify-center min-h-9 px-3 rounded-md border border-line-strong bg-surface hover:bg-sunken text-xs font-semibold">Ubah</a>
                                    @unless ($account->is(auth()->user()))
                                        <form method="POST" action="{{ route('admin.users.destroy', $account) }}" onsubmit="return confirm(@js('Hapus akun '.$account->name.'? Tindakan ini tidak dapat dibatalkan.'))">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center justify-center min-h-9 px-3 rounded-md border border-danger text-danger hover:bg-cancelled-bg text-xs font-semibold">Hapus</button>
                                        </form>
                                    @endunless
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>

    <div class="mt-6">{{ $users->links() }}</div>
@endif
@endsection
