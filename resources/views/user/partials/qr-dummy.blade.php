<div class="bg-white rounded-md p-3 w-[160px] shrink-0" role="img" aria-label="Ilustrasi QR dummy, verifikasi dengan kode booking">
    <svg viewBox="0 0 132 132" width="132" height="132" class="mx-auto max-w-full text-ink-900" aria-hidden="true">
        <rect width="132" height="132" fill="white"/>
        @php
            $seed = hash('sha256', (string) $ticket->booking_code);
        @endphp
        @for ($r=0; $r<21; $r++)
            @for ($c=0; $c<21; $c++)
                @php
                    $finder = ($r < 7 && $c < 7) || ($r < 7 && $c >= 14) || ($r >= 14 && $c < 7);
                    $fr = $r < 7 ? $r : ($r >= 14 ? $r - 14 : -1);
                    $fc = $c < 7 ? $c : ($c >= 14 ? $c - 14 : -1);
                    $bit = $finder
                        ? ($fr === 0 || $fr === 6 || $fc === 0 || $fc === 6 || ($fr >= 2 && $fr <= 4 && $fc >= 2 && $fc <= 4))
                        : (hexdec($seed[($r * 21 + $c) % 64]) % 2 === 1);
                @endphp
                @if ($bit)<rect x="{{ $c * 6 }}" y="{{ $r * 6 }}" width="6" height="6" fill="currentColor"/>@endif
            @endfor
        @endfor
    </svg>
    <p class="mt-1 text-center text-[10px] font-semibold text-gray-700">QR dummy (gunakan kode)</p>
</div>
