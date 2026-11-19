@php
    $from = \Illuminate\Support\Carbon::parse($ticket->check_in_date)->locale('id')->translatedFormat('d M Y');
    $to = \Illuminate\Support\Carbon::parse($ticket->check_out_date)->locale('id')->translatedFormat('d M Y');
@endphp
<article class="bg-ink-900 text-text-on-ink rounded-[14px] border-t-[3px] border-ember-600 overflow-hidden" aria-label="Kartu digital {{ $ticket->booking_code }}">
    <div class="p-5 sm:p-6 flex flex-col sm:flex-row gap-5 sm:items-center sm:justify-between">
        <div class="min-w-0">
            <p class="text-xs text-text-on-ink/65 mb-3">ATARA · KARTU MENGINAP</p>
            <h2 class="font-display text-xl font-semibold wrap-break-word">{{ $ticket->room_name }}</h2>
            <p class="mt-3 text-sm">{{ $ticket->guest_name }}</p>
            <p class="mt-1 text-sm text-text-on-ink/80 tabular-nums">{{ $from }} sampai {{ $to }}</p>
            <p class="mt-2 text-xs text-text-on-ink/70">Check-in 14.00 · Check-out 12.00 WIB</p>
        </div>
        @include('user.partials.qr-dummy')
    </div>
    <div class="border-t border-dashed border-white/30 px-5 sm:px-6 py-4 flex flex-wrap gap-3 justify-between items-center">
        <div class="min-w-0">
            <p class="text-xs text-text-on-ink/70">Kode reservasi</p>
            <p class="font-mono text-base break-all tracking-wide font-semibold">{{ $ticket->booking_code }}</p>
        </div>
        <button type="button" data-copy-code="{{ $ticket->booking_code }}" class="rounded-md border border-white/50 min-h-10 px-4 text-sm font-semibold hover:bg-white/10" aria-label="Salin kode booking">Salin kode</button>
    </div>
</article>
