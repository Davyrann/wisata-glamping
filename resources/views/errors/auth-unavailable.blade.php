@extends('layouts.app')

@section('title', '503 Layanan Belum Tersedia | Atara Glamping')

@section('content')
<section class="min-h-[75vh] flex items-center justify-center px-4 sm:px-6 py-16 sm:py-24">
    <div class="max-w-xl w-full border border-[#E0DEDC] bg-white p-8 sm:p-12 text-center shadow-[0_24px_105px_0_rgba(0,0,0,0.06)]">
        
        <!-- Status Code Badge -->
        <div class="inline-flex items-center gap-2 px-3 py-1 bg-[#F9F7F5] border border-[#E0DEDC] text-[11px] font-mono tracking-wider uppercase text-[#1D1D1C] mb-6">
            <span class="w-1.5 h-1.5 bg-[#1D1D1C]"></span>
            <span>Status 503 : Service Temporarily Unavailable</span>
        </div>

        <h1 class="text-3xl sm:text-4xl font-serif font-light text-[#1D1D1C] mb-4 leading-tight">
            Gerbang Masuk Sedang Disiapkan
        </h1>

        <p class="text-sm sm:text-base text-[#444444] font-sans leading-relaxed mb-8">
            Modul autentikasi akun pelanggan, staf operasional, dan administrator Atara Glamping sedang dalam proses sinkronisasi sistem keamanan. Silakan kembali ke beranda untuk menjelajahi katalog unit tenda mewah dan perlengkapan camping kami.
        </p>

        <!-- Divider line -->
        <div class="h-px w-16 bg-[#1D1D1C] mx-auto mb-8"></div>

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row items-center justify-center gap-3">
            <a href="{{ route('home') }}"
               class="w-full sm:w-auto px-6 py-3 bg-[#1D1D1C] text-white text-xs sm:text-sm font-semibold tracking-wider uppercase hover:bg-black transition-colors rounded-[5px] focus:outline-none focus:ring-2 focus:ring-[#1D1D1C] focus:ring-offset-2">
                Kembali ke Beranda
            </a>
            <a href="{{ route('home') }}#kontak"
               class="w-full sm:w-auto px-6 py-3 border border-[#1D1D1C] text-[#1D1D1C] text-xs sm:text-sm font-semibold tracking-wider uppercase hover:bg-[#F9F7F5] transition-colors rounded-[5px] focus:outline-none focus:ring-2 focus:ring-[#1D1D1C] focus:ring-offset-2">
                Hubungi Concierge
            </a>
        </div>

        <!-- Technical note -->
        <p class="mt-8 text-[11px] font-mono text-[#969696] uppercase tracking-wider">
            Atara Glamping System Core v1.0.0
        </p>
    </div>
</section>
@endsection
