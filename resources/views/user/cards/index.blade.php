@extends('layouts.dashboard', [
    'title' => 'Kartu Digital Menginap',
    'subtitle' => 'Area Tamu Atara / Kartu Digital'
])

@section('content')
<div class="mb-7">
    <p class="text-xs tracking-[0.14em] uppercase text-text-muted mb-2">Tiket & Akses Check-in</p>
    <h1 class="font-display text-[clamp(1.8rem,3vw,2.5rem)] font-semibold leading-tight">Kartu Digital Menginap</h1>
    <p class="mt-2 text-text-muted text-sm sm:text-base">Gunakan kode reservasi atau tunjukkan kartu ini kepada staf saat tiba di resepsionis.</p>
</div>

@if ($cards->isEmpty())
    <section class="bg-surface border border-line rounded-[10px] p-8 sm:p-12 text-center">
        <svg class="w-10 h-10 mx-auto text-text-faint" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="M7 9h4v4H7zM14 9h3M14 13h3"/></svg>
        <h2 class="font-semibold text-lg mt-4">Belum ada kartu digital</h2>
        <p class="text-text-muted text-xs sm:text-sm mt-2 max-w-sm mx-auto">Kartu hanya diterbitkan setelah pembayaran berhasil dan status reservasi terkonfirmasi.</p>
        <div class="flex flex-wrap gap-3 justify-center mt-6">
            <a href="{{ route('dashboard.rooms') }}" class="inline-flex justify-center items-center bg-pine-700 hover:bg-pine-600 text-white rounded-md min-h-10 px-4 text-xs font-semibold">Pilih Kamar Glamping</a>
            <a href="{{ route('dashboard.bookings') }}" class="inline-flex justify-center items-center border border-line-strong hover:bg-sunken rounded-md min-h-10 px-4 text-xs font-semibold">Lihat Pesanan Saya</a>
        </div>
    </section>
@else
    <div class="grid lg:grid-cols-2 gap-6">
        @foreach ($cards as $ticket)
            <div class="min-w-0">
                @include('user.partials.ticket')
                <div class="mt-2 text-right">
                    <a href="{{ route('dashboard.bookings.show', $ticket->booking_code) }}" class="text-xs text-pine-700 hover:underline font-semibold inline-flex items-center gap-1">
                        Buka rincian lengkap pesanan →
                    </a>
                </div>
            </div>
        @endforeach
    </div>
    <div class="mt-8 border border-line rounded-[10px] bg-sunken px-5 py-4 text-xs text-text-muted">
        <strong class="text-text font-semibold">Petunjuk Check-in:</strong> Harap naikkan kecerahan layar perangkat Anda saat memperlihatkan kode booking kepada staf operasional di pos serah terima kamar.
    </div>
@endif
@endsection
