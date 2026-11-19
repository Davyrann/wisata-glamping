@extends('layouts.dashboard', [
    'title' => 'Katalog Kamar Glamping',
    'subtitle' => 'Area Tamu Atara / Katalog Kamar'
])

@section('content')
<div class="mb-7">
    <p class="text-xs tracking-[0.14em] uppercase text-text-muted mb-2">Pilihan Akomodasi</p>
    <h1 class="font-display text-[clamp(1.8rem,3vw,2.5rem)] font-semibold leading-tight">Katalog Kamar Glamping</h1>
    <p class="mt-2 text-text-muted text-sm sm:text-base">Temukan tenda safari dan dome eksklusif di dataran tinggi Atara. Dilengkapi perapian, deck santai, dan panorama alam pegunungan.</p>
</div>

<!-- Kategori Filter -->
<div class="flex flex-wrap gap-2 mb-7 items-center">
    <a href="{{ route('dashboard.rooms') }}"
       class="px-4 py-2 rounded-md text-xs sm:text-sm font-semibold border transition-colors {{ empty($selectedCategory) ? 'bg-pine-700 text-white border-pine-700' : 'bg-surface border-line text-text hover:border-line-strong' }}">
        Semua Tipe
    </a>
    @foreach ($categories as $cat)
        <a href="{{ route('dashboard.rooms', ['category' => $cat]) }}"
           class="px-4 py-2 rounded-md text-xs sm:text-sm font-semibold border transition-colors {{ $selectedCategory === $cat ? 'bg-pine-700 text-white border-pine-700' : 'bg-surface border-line text-text hover:border-line-strong' }}">
            {{ $cat }}
        </a>
    @endforeach
</div>

<!-- Grid Kamar Glamping -->
@if ($rooms->isEmpty())
    <div class="bg-surface border border-line rounded-[10px] p-8 sm:p-12 text-center">
        <h2 class="font-semibold text-lg">Tidak ada unit kamar ditemukan</h2>
        <p class="text-sm text-text-muted mt-2">Belum ada kamar glamping yang sesuai dengan filter kategori ini.</p>
        <a href="{{ route('dashboard.rooms') }}" class="inline-flex mt-5 px-4 py-2 bg-pine-700 text-white rounded-md text-sm font-semibold">Tampilkan Semua Kamar</a>
    </div>
@else
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach ($rooms as $room)
            @php
                $image = $room->image_path ? asset($room->image_path) : asset('images/Camp_premium.jpg');
            @endphp
            <article class="bg-surface border border-line hover:border-line-strong rounded-[10px] overflow-hidden flex flex-col transition-colors shadow-sm">
                <div class="relative aspect-16/10 bg-sunken overflow-hidden">
                    <img src="{{ $image }}" alt="{{ $room->name }}" class="w-full h-full object-cover">
                    <span class="absolute top-3 left-3 bg-ink-900/80 backdrop-blur-sm text-white text-[11px] font-semibold px-2.5 py-1 rounded">
                        {{ $room->category }}
                    </span>
                    <span class="absolute bottom-3 right-3 bg-surface/90 backdrop-blur-sm text-text text-xs font-semibold px-2 py-0.5 rounded">
                        Stok: {{ $room->total_stock }} unit
                    </span>
                </div>
                <div class="p-5 flex-1 flex flex-col justify-between">
                    <div>
                        <h2 class="font-display text-lg font-semibold">{{ $room->name }}</h2>
                        <p class="text-xs text-text-muted mt-2 leading-relaxed">{{ $room->description }}</p>
                    </div>
                    <div class="mt-6 pt-4 border-t border-line flex items-center justify-between gap-3">
                        <div>
                            <p class="text-[11px] text-text-muted uppercase tracking-wider">Mulai dari</p>
                            <p class="font-display font-semibold text-base sm:text-lg text-pine-700 tabular-nums">
                                Rp {{ number_format((float) $room->price_per_night, 0, ',', '.') }}
                                <span class="text-xs text-text-muted font-normal">/ malam</span>
                            </p>
                        </div>
                        <a href="{{ route('dashboard.rooms.book', $room->id) }}" class="inline-flex items-center justify-center rounded-md bg-pine-700 hover:bg-pine-600 text-white text-xs font-semibold px-3.5 min-h-10 transition-colors">
                            Pesan Kamar
                        </a>
                    </div>
                </div>
            </article>
        @endforeach
    </div>
@endif

<div class="mt-8 border border-line rounded-[10px] bg-sunken px-5 py-4 text-xs text-text-muted">
    <strong class="text-text font-semibold">Ketentuan sewa kamar:</strong> Check-in mulai pukul 14.00 WIB, Check-out maksimal pukul 12.00 WIB. Pilihan asuransi pembatalan (Rp 25.000) dapat ditambahkan saat pemesanan paket kamar.
</div>
@endsection
