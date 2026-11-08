@extends('layouts.app')

@section('title', 'Atara Glamping | Refined Alpine Sanctuary & Camping Retreat')

@section('content')

{{-- 1. HERO SECTION --}}
<section class="relative bg-[#F9F7F5] pt-8 sm:pt-16 pb-16 sm:pb-24 border-b border-[#E0DEDC]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Metadata Header Bar -->
        <div class="flex flex-wrap items-center justify-between gap-4 border-b border-[#E0DEDC] pb-4 mb-8 sm:mb-12 font-mono text-xs text-[#444444] uppercase tracking-widest">
            <div class="flex items-center gap-3">
                <span class="w-2 h-2 bg-[#1D1D1C]"></span>
                <span>Elevasi 1.620 mdpl</span>
            </div>
            <div class="hidden sm:flex items-center gap-6 text-[#969696]">
                <span>Suhu 14°C - 20°C</span>
                <span>Jalur Puncak Dingin KM 18</span>
            </div>
            <div class="text-[#1D1D1C] font-semibold">
                Kawasan Hutan Pinus Asri
            </div>
        </div>

        <!-- Hero Headline & Introduction -->
        <div class="max-w-4xl mb-8 sm:mb-12">
            <h1 class="text-3xl sm:text-5xl lg:text-7xl font-sans font-bold text-[#1D1D1C] tracking-tight leading-[1.05] mb-6">
                Kenyamanan Kabin Mewah di Pelukan Rimba Pegunungan
            </h1>
            <p class="font-serif font-light text-base sm:text-xl lg:text-2xl text-[#444444] leading-relaxed max-w-3xl">
                Atara Glamping menyatukan keteduhan hutan pinus alami, perlindungan kanvas berkualitas tinggi, dan fasilitas kabin yang hangat. Sebuah jeda tenang tanpa meninggalkan kenyamanan beristirahat.
            </p>
        </div>

        <!-- Action CTAs -->
        <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-4 mb-10 sm:mb-14">
            <a href="#kamar"
               class="inline-flex items-center justify-center px-6 sm:px-8 py-3.5 sm:py-4 bg-[#1D1D1C] text-white text-xs sm:text-sm font-semibold tracking-wider uppercase hover:bg-black transition-colors rounded-[5px] focus:outline-none focus:ring-2 focus:ring-[#1D1D1C] focus:ring-offset-2">
                Pilih Unit Kamar
            </a>
            <a href="#panduan"
               class="inline-flex items-center justify-center px-6 sm:px-8 py-3.5 sm:py-4 border border-[#1D1D1C] text-[#1D1D1C] text-xs sm:text-sm font-semibold tracking-wider uppercase hover:bg-[#E0DEDC]/40 transition-colors rounded-[5px] focus:outline-none focus:ring-2 focus:ring-[#1D1D1C] focus:ring-offset-2">
                Pelajari Alur Reservasi
            </a>
        </div>

        <!-- Hero Main Landscape Image -->
        <div class="relative w-full overflow-hidden border border-[#1D1D1C] bg-[#000000]">
            <img src="{{ asset('images/Camp_premium.jpg') }}"
                 alt="Panorama lanskap pegunungan dan kabut Atara Glamping"
                 class="w-full h-[320px] sm:h-[480px] lg:h-[620px] object-cover object-center filter brightness-95"
                 loading="eager">
            <div class="absolute bottom-0 inset-x-0 bg-gradient-to-t from-black/80 via-black/30 to-transparent p-4 sm:p-6 text-white flex flex-col sm:flex-row justify-between items-start sm:items-end gap-2">
                <div>
                    <span class="font-mono text-[10px] sm:text-xs uppercase tracking-widest text-[#E0DEDC]">Lanskap Pagi Hari</span>
                    <p class="font-serif text-sm sm:text-base font-light">Lembah Pinus Selatan Atara Sanctuary</p>
                </div>
                <div class="font-mono text-[10px] sm:text-xs text-[#E0DEDC]">
                    Check-in 14.00 WIB : Check-out 12.00 WIB
                </div>
            </div>
        </div>

        <!-- Key Stats / Value Pillars -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 pt-8 sm:pt-12 text-[#1D1D1C]">
            <div class="border-l-2 border-[#1D1D1C] pl-4">
                <span class="block font-mono text-2xl sm:text-3xl font-bold">3 Tipe</span>
                <span class="text-xs sm:text-sm text-[#444444] font-serif">Kamar Glamping Terkurasi</span>
            </div>
            <div class="border-l-2 border-[#1D1D1C] pl-4">
                <span class="block font-mono text-2xl sm:text-3xl font-bold">15 Menit</span>
                <span class="text-xs sm:text-sm text-[#444444] font-serif">Hold Kuota Pembayaran QRIS</span>
            </div>
            <div class="border-l-2 border-[#1D1D1C] pl-4">
                <span class="block font-mono text-2xl sm:text-3xl font-bold">100%</span>
                <span class="text-xs sm:text-sm text-[#444444] font-serif">Garansi Refund Berasuransi</span>
            </div>
            <div class="border-l-2 border-[#1D1D1C] pl-4">
                <span class="block font-mono text-2xl sm:text-3xl font-bold">Rp 25 Rb</span>
                <span class="text-xs sm:text-sm text-[#444444] font-serif">Opsi Asuransi Pembatalan</span>
            </div>
        </div>

    </div>
</section>

{{-- 2. SECTION KAMAR GLAMPING --}}
<section id="kamar" class="py-16 sm:py-24 bg-white border-b border-[#E0DEDC] scroll-mt-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Section Header -->
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-12 sm:mb-16 pb-6 border-b border-[#E0DEDC]">
            <div>
                <span class="font-mono text-xs uppercase tracking-widest text-[#969696] block mb-2">
                    Koleksi Akomodasi
                </span>
                <h2 class="text-2xl sm:text-4xl font-sans font-bold text-[#1D1D1C]">
                    Tipe Kamar Glamping Utama
                </h2>
            </div>
            <p class="font-serif text-sm sm:text-base text-[#444444] max-w-md">
                Setiap reservasi mewajibkan pemilihan 1 unit kamar utama dengan durasi sewa dihitung per malam. Fasilitas dirancang untuk ketenangan total.
            </p>
        </div>

        <!-- 3 Room Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            
            <!-- Room 1: Safari Luxury Suite -->
            <article class="flex flex-col border border-[#E0DEDC] bg-[#F9F7F5] group">
                <div class="relative overflow-hidden aspect-[4/3] bg-black">
                    <img src="{{ asset('images/Camp_with_chair.jpg') }}"
                         alt="Safari Luxury Suite di malam hari"
                         class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                         loading="lazy">
                    <div class="absolute top-3 left-3 bg-[#1D1D1C] text-white text-[10px] font-mono uppercase tracking-widest px-2.5 py-1">
                        Kapasitas 2 - 4 Tamu
                    </div>
                </div>
                <div class="p-6 flex-grow flex flex-col justify-between space-y-6">
                    <div>
                        <div class="flex items-baseline justify-between gap-2 mb-2">
                            <h3 class="text-xl font-bold font-sans text-[#1D1D1C]">
                                Safari Luxury Suite
                            </h3>
                        </div>
                        <p class="font-serif text-sm text-[#444444] leading-relaxed mb-4">
                            Tenda kanvas premium berarsitektur safari dengan ranjang king-size, beranda kayu privat menghadap kelembutan kabut lembah, dan pemanas air.
                        </p>
                        <ul class="text-xs font-mono text-[#444444] space-y-2 border-t border-[#E0DEDC] pt-4">
                            <li class="flex items-center gap-2">
                                <span class="w-1.5 h-1.5 bg-[#1D1D1C]"></span>
                                <span>King-size Plush Bed & Duvet Hangat</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <span class="w-1.5 h-1.5 bg-[#1D1D1C]"></span>
                                <span>Balkon Dek Kayu Menghadap Lembah</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <span class="w-1.5 h-1.5 bg-[#1D1D1C]"></span>
                                <span>Listrik 24 Jam & Teko Listrik Kopi</span>
                            </li>
                        </ul>
                    </div>
                    <div class="pt-4 border-t border-[#E0DEDC] flex items-center justify-between">
                        <div>
                            <span class="block text-[11px] font-mono text-[#969696] uppercase">Tarif Sewa</span>
                            <span class="text-lg font-bold font-mono text-[#1D1D1C]">Rp 850.000</span>
                            <span class="text-xs text-[#969696]"> / malam</span>
                        </div>
                        <a href="#panduan"
                           class="px-4 py-2 bg-[#1D1D1C] text-white text-xs font-semibold uppercase tracking-wider rounded-[5px] hover:bg-black transition-colors focus:ring-2 focus:ring-[#1D1D1C]">
                            Alur Pesan
                        </a>
                    </div>
                </div>
            </article>

            <!-- Room 2: Alpine Geodesic Dome -->
            <article class="flex flex-col border border-[#1D1D1C] bg-white group shadow-[0_6px_17px_rgba(0,0,0,0.06)] relative">
                <div class="absolute -top-3 right-4 z-10 bg-[#1D1D1C] text-white text-[10px] font-mono uppercase tracking-widest px-3 py-0.5">
                    Paling Diminati
                </div>
                <div class="relative overflow-hidden aspect-[4/3] bg-black">
                    <img src="{{ asset('images/Camp_from_above.jpg') }}"
                         alt="Alpine Geodesic Dome dengan pemandangan puncak"
                         class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                         loading="lazy">
                    <div class="absolute top-3 left-3 bg-[#1D1D1C] text-white text-[10px] font-mono uppercase tracking-widest px-2.5 py-1">
                        Kapasitas 2 Tamu (Romantic)
                    </div>
                </div>
                <div class="p-6 flex-grow flex flex-col justify-between space-y-6">
                    <div>
                        <div class="flex items-baseline justify-between gap-2 mb-2">
                            <h3 class="text-xl font-bold font-sans text-[#1D1D1C]">
                                Alpine Geodesic Dome
                            </h3>
                        </div>
                        <p class="font-serif text-sm text-[#444444] leading-relaxed mb-4">
                            Kubah kubus futuristik dengan dinding kaca panorama 180 derajat. Menatap gugusan bintang malam langsung dari ranjang empuk dengan kamar mandi dalam.
                        </p>
                        <ul class="text-xs font-mono text-[#444444] space-y-2 border-t border-[#E0DEDC] pt-4">
                            <li class="flex items-center gap-2">
                                <span class="w-1.5 h-1.5 bg-[#1D1D1C]"></span>
                                <span>Kamar Mandi Dalam (En-suite & Water Heater)</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <span class="w-1.5 h-1.5 bg-[#1D1D1C]"></span>
                                <span>Kaca Skylight Pemandangan Langit Bintang</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <span class="w-1.5 h-1.5 bg-[#1D1D1C]"></span>
                                <span>Pemanas Ruangan & Sarapan Alpine</span>
                            </li>
                        </ul>
                    </div>
                    <div class="pt-4 border-t border-[#E0DEDC] flex items-center justify-between">
                        <div>
                            <span class="block text-[11px] font-mono text-[#969696] uppercase">Tarif Sewa</span>
                            <span class="text-lg font-bold font-mono text-[#1D1D1C]">Rp 1.100.000</span>
                            <span class="text-xs text-[#969696]"> / malam</span>
                        </div>
                        <a href="#panduan"
                           class="px-4 py-2 bg-[#1D1D1C] text-white text-xs font-semibold uppercase tracking-wider rounded-[5px] hover:bg-black transition-colors focus:ring-2 focus:ring-[#1D1D1C]">
                            Alur Pesan
                        </a>
                    </div>
                </div>
            </article>

            <!-- Room 3: Bell Tent Pine Retreat -->
            <article class="flex flex-col border border-[#E0DEDC] bg-[#F9F7F5] group">
                <div class="relative overflow-hidden aspect-[4/3] bg-black">
                    <img src="{{ asset('images/High_standart_camp.jpg') }}"
                         alt="Bell Tent Pine Retreat dengan api unggun"
                         class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                         loading="lazy">
                    <div class="absolute top-3 left-3 bg-[#1D1D1C] text-white text-[10px] font-mono uppercase tracking-widest px-2.5 py-1">
                        Kapasitas 2 - 3 Tamu
                    </div>
                </div>
                <div class="p-6 flex-grow flex flex-col justify-between space-y-6">
                    <div>
                        <div class="flex items-baseline justify-between gap-2 mb-2">
                            <h3 class="text-xl font-bold font-sans text-[#1D1D1C]">
                                Bell Tent Pine Retreat
                            </h3>
                        </div>
                        <p class="font-serif text-sm text-[#444444] leading-relaxed mb-4">
                            Tenda bell katun tebal berventilasi sejuk di tengah rapatnya pohon pinus. Dilengkapi area perapian batu privat untuk suasana api unggun malam hari.
                        </p>
                        <ul class="text-xs font-mono text-[#444444] space-y-2 border-t border-[#E0DEDC] pt-4">
                            <li class="flex items-center gap-2">
                                <span class="w-1.5 h-1.5 bg-[#1D1D1C]"></span>
                                <span>Queen Bed Katun & Matras Tambahan</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <span class="w-1.5 h-1.5 bg-[#1D1D1C]"></span>
                                <span>Area Perapian Batu & Kayu Bakar Kering</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <span class="w-1.5 h-1.5 bg-[#1D1D1C]"></span>
                                <span>Akses Dekat Sumber Air Alami & Kafe</span>
                            </li>
                        </ul>
                    </div>
                    <div class="pt-4 border-t border-[#E0DEDC] flex items-center justify-between">
                        <div>
                            <span class="block text-[11px] font-mono text-[#969696] uppercase">Tarif Sewa</span>
                            <span class="text-lg font-bold font-mono text-[#1D1D1C]">Rp 650.000</span>
                            <span class="text-xs text-[#969696]"> / malam</span>
                        </div>
                        <a href="#panduan"
                           class="px-4 py-2 bg-[#1D1D1C] text-white text-xs font-semibold uppercase tracking-wider rounded-[5px] hover:bg-black transition-colors focus:ring-2 focus:ring-[#1D1D1C]">
                            Alur Pesan
                        </a>
                    </div>
                </div>
            </article>

        </div>
    </div>
</section>

{{-- 3. SECTION FASILITAS UNGGULAN GLAMPING (INCLUDED) --}}
<section id="fasilitas" class="py-16 sm:py-24 bg-[#F9F7F5] border-b border-[#E0DEDC] scroll-mt-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-12 sm:mb-16 pb-6 border-b border-[#E0DEDC]">
            <div>
                <span class="font-mono text-xs uppercase tracking-widest text-[#969696] block mb-2">
                    Kenyamanan Lengkap
                </span>
                <h2 class="text-2xl sm:text-4xl font-sans font-bold text-[#1D1D1C]">
                    Fasilitas Unggulan Setiap Unit
                </h2>
            </div>
            <p class="font-serif text-sm sm:text-base text-[#444444] max-w-md">
                Setiap reservasi kamar glamping telah dilengkapi dengan fasilitas esensial alpine untuk menjamin kehangatan dan ketenangan Anda tanpa perlu menyewa alat tambahan.
            </p>
        </div>

        <!-- 4 Included Facility Cards Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            
            <!-- Item 1: Firepit & Wood -->
            <div class="border border-[#E0DEDC] bg-white p-6 flex flex-col justify-between">
                <div>
                    <span class="inline-block px-2.5 py-0.5 bg-[#F9F7F5] border border-[#E0DEDC] text-[10px] font-mono uppercase text-[#444444] mb-4">
                        Suasana Malam
                    </span>
                    <h3 class="text-lg font-bold font-sans text-[#1D1D1C] mb-2">
                        Perapian Batu & Kayu Bakar
                    </h3>
                    <p class="font-serif text-xs text-[#444444] leading-relaxed mb-4">
                        Area api unggun privat di dekat tenda lengkap dengan pasokan kayu bakar kering berkualitas dan tempat duduk teras kayu yang hangat.
                    </p>
                </div>
                <div class="pt-4 border-t border-[#E0DEDC]">
                    <span class="text-xs font-mono font-semibold text-[#1D1D1C] uppercase tracking-wider">Sudah Termasuk Unit</span>
                </div>
            </div>

            <!-- Item 2: Sanitasi & Water Heater -->
            <div class="border border-[#E0DEDC] bg-white p-6 flex flex-col justify-between">
                <div>
                    <span class="inline-block px-2.5 py-0.5 bg-[#F9F7F5] border border-[#E0DEDC] text-[10px] font-mono uppercase text-[#444444] mb-4">
                        Kebersihan Higienis
                    </span>
                    <h3 class="text-lg font-bold font-sans text-[#1D1D1C] mb-2">
                        Pancuran Air Panas 24 Jam
                    </h3>
                    <p class="font-serif text-xs text-[#444444] leading-relaxed mb-4">
                        Sanitasi modern dengan water heater bersuhu stabil, handuk katun bersih, serta perlengkapan mandi herbal ramah lingkungan pegunungan.
                    </p>
                </div>
                <div class="pt-4 border-t border-[#E0DEDC]">
                    <span class="text-xs font-mono font-semibold text-[#1D1D1C] uppercase tracking-wider">Sudah Termasuk Unit</span>
                </div>
            </div>

            <!-- Item 3: Kelistrikan & Wi-Fi -->
            <div class="border border-[#E0DEDC] bg-white p-6 flex flex-col justify-between">
                <div>
                    <span class="inline-block px-2.5 py-0.5 bg-[#F9F7F5] border border-[#E0DEDC] text-[10px] font-mono uppercase text-[#444444] mb-4">
                        Konektivitas Stabil
                    </span>
                    <h3 class="text-lg font-bold font-sans text-[#1D1D1C] mb-2">
                        Listrik 24 Jam & Wi-Fi Area
                    </h3>
                    <p class="font-serif text-xs text-[#444444] leading-relaxed mb-4">
                        Stopkontak pengisian daya gawai di dalam tenda, lentera baca ambient hangat, serta akses jaringan internet nirkabel di seluruh area santai.
                    </p>
                </div>
                <div class="pt-4 border-t border-[#E0DEDC]">
                    <span class="text-xs font-mono font-semibold text-[#1D1D1C] uppercase tracking-wider">Sudah Termasuk Unit</span>
                </div>
            </div>

            <!-- Item 4: Sarapan & Racikan Kopi -->
            <div class="border border-[#E0DEDC] bg-white p-6 flex flex-col justify-between">
                <div>
                    <span class="inline-block px-2.5 py-0.5 bg-[#F9F7F5] border border-[#E0DEDC] text-[10px] font-mono uppercase text-[#444444] mb-4">
                        Kuliner Hangat
                    </span>
                    <h3 class="text-lg font-bold font-sans text-[#1D1D1C] mb-2">
                        Sarapan Alpine & Racikan Teh
                    </h3>
                    <p class="font-serif text-xs text-[#444444] leading-relaxed mb-4">
                        Menu sarapan pagi segar diantar ke teras kabin, teko pemanas air, serta pilihan seduhan teh herbal dan biji kopi lokal dataran tinggi.
                    </p>
                </div>
                <div class="pt-4 border-t border-[#E0DEDC]">
                    <span class="text-xs font-mono font-semibold text-[#1D1D1C] uppercase tracking-wider">Sudah Termasuk Unit</span>
                </div>
            </div>

        </div>

        <!-- Note banner -->
        <div class="mt-8 p-4 border border-[#E0DEDC] bg-[#E0DEDC]/30 flex flex-col sm:flex-row sm:items-center justify-between gap-3 text-xs font-mono text-[#444444]">
            <div class="flex items-center gap-2">
                <span class="w-2 h-2 bg-[#1D1D1C]"></span>
                <span>Kondisi kamar dan kelengkapan fasilitas diverifikasi bersama saat serah terima check-in dan check-out.</span>
            </div>
            <a href="#kebijakan" class="underline hover:text-black">
                Pelajari Ketentuan Asuransi & Kebijakan
            </a>
        </div>

    </div>
</section>

{{-- 4. SECTION PANDUAN CARA RESERVASI --}}
<section id="panduan" class="py-16 sm:py-24 bg-white border-b border-[#E0DEDC] scroll-mt-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="max-w-3xl mb-12 sm:mb-16">
            <span class="font-mono text-xs uppercase tracking-widest text-[#969696] block mb-2">
                Tata Cara Reservasi
            </span>
            <h2 class="text-2xl sm:text-4xl font-sans font-bold text-[#1D1D1C] mb-4">
                Lima Langkah Menikmati Liburan di Atara Glamping
            </h2>
            <p class="font-serif text-sm sm:text-base text-[#444444]">
                Alur pemesanan dirancang lugas dan transparan. Kuota ketersediaan unit diverifikasi langsung secara real-time pada sistem kami.
            </p>
        </div>

        <!-- Steps Timeline / Grid -->
        <div class="grid grid-cols-1 md:grid-cols-5 gap-6">
            
            <!-- Step 1 -->
            <div class="border-t-2 border-[#1D1D1C] pt-6 flex flex-col justify-between">
                <div>
                    <span class="font-mono text-xs text-[#969696] uppercase tracking-wider block mb-2">Langkah 01</span>
                    <h3 class="text-base font-bold font-sans text-[#1D1D1C] mb-3">
                        Pilih Kamar & Tanggal
                    </h3>
                    <p class="font-serif text-xs text-[#444444] leading-relaxed">
                        Tentukan 1 unit glamping utama serta jadwal check-in (14.00 WIB) dan check-out (12.00 WIB). Durasi sewa dihitung per malam.
                    </p>
                </div>
                <div class="mt-6 text-[11px] font-mono text-[#969696]">
                    Stok Kamar Real-time
                </div>
            </div>

            <!-- Step 2 -->
            <div class="border-t-2 border-[#1D1D1C] pt-6 flex flex-col justify-between">
                <div>
                    <span class="font-mono text-xs text-[#969696] uppercase tracking-wider block mb-2">Langkah 02</span>
                    <h3 class="text-base font-bold font-sans text-[#1D1D1C] mb-3">
                        Data Kontak Tamu
                    </h3>
                    <p class="font-serif text-xs text-[#444444] leading-relaxed">
                        Lengkapi nama lengkap, alamat email, dan nomor telepon aktif untuk penerbitan konfirmasi dan kartu digital reservasi Anda.
                    </p>
                </div>
                <div class="mt-6 text-[11px] font-mono text-[#969696]">
                    Verifikasi Instan
                </div>
            </div>

            <!-- Step 3 -->
            <div class="border-t-2 border-[#1D1D1C] pt-6 flex flex-col justify-between">
                <div>
                    <span class="font-mono text-xs text-[#969696] uppercase tracking-wider block mb-2">Langkah 03</span>
                    <h3 class="text-base font-bold font-sans text-[#1D1D1C] mb-3">
                        Asuransi Pembatalan
                    </h3>
                    <p class="font-serif text-xs text-[#444444] leading-relaxed">
                        Pilih opsi Asuransi Pembatalan (flat Rp 25.000) untuk garansi pengembalian dana hingga 100% jika perjalanan Anda tertunda.
                    </p>
                </div>
                <div class="mt-6 text-[11px] font-mono text-[#969696]">
                    Jaminan Fleksibel
                </div>
            </div>

            <!-- Step 4 -->
            <div class="border-t-2 border-[#1D1D1C] pt-6 flex flex-col justify-between">
                <div>
                    <span class="font-mono text-xs text-[#969696] uppercase tracking-wider block mb-2">Langkah 04</span>
                    <h3 class="text-base font-bold font-sans text-[#1D1D1C] mb-3">
                        Simulasi Bayar QRIS
                    </h3>
                    <p class="font-serif text-xs text-[#444444] leading-relaxed">
                        Lakukan pembayaran sandbox melalui QRIS dummy. Konfirmasi instan langsung mengalihkan status reservasi Anda menjadi confirmed.
                    </p>
                </div>
                <div class="mt-6 text-[11px] font-mono text-[#969696]">
                    Sandbox Tanpa Biaya
                </div>
            </div>

            <!-- Step 5 -->
            <div class="border-t-2 border-[#1D1D1C] pt-6 flex flex-col justify-between">
                <div>
                    <span class="font-mono text-xs text-[#969696] uppercase tracking-wider block mb-2">Langkah 05</span>
                    <h3 class="text-base font-bold font-sans text-[#1D1D1C] mb-3">
                        Kartu QR Serah Terima
                    </h3>
                    <p class="font-serif text-xs text-[#444444] leading-relaxed">
                        Dapatkan kartu digital berisi kode booking unik dan kode QR untuk verifikasi checklist fisik oleh staf saat tiba di lokasi glamping.
                    </p>
                </div>
                <div class="mt-6 text-[11px] font-mono text-[#969696]">
                    Check-in Cepat & Nyaman
                </div>
            </div>

        </div>

    </div>
</section>

{{-- 5. SECTION TRANSPARANSI KETENTUAN BIAYA & REFUND --}}
<section id="kebijakan" class="py-16 sm:py-24 bg-[#1D1D1C] text-white scroll-mt-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="max-w-3xl mb-12 sm:mb-16">
            <span class="font-mono text-xs uppercase tracking-widest text-[#969696] block mb-2">
                Aturan Finansial & Pembatalan
            </span>
            <h2 class="text-2xl sm:text-4xl font-sans font-bold text-white mb-4">
                Transparansi Biaya dan Kebijakan Refund
            </h2>
            <p class="font-serif text-sm sm:text-base text-[#969696]">
                Kami menjamin kejelasan rincian tarif tanpa biaya tersembunyi. Pelajari aturan asuransi dan pengembalian dana sebelum melakukan reservasi.
            </p>
        </div>

        <!-- 2 Column Policy Details -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 sm:gap-12">
            
            <!-- Left: Formula & Financial Structure -->
            <div class="border border-[#353536] bg-[#0F0F10] p-6 sm:p-8 space-y-6">
                <div class="flex items-center gap-2 font-mono text-xs text-[#969696] uppercase tracking-wider">
                    <span class="w-2 h-2 bg-white"></span>
                    <span>Struktur Komponen Biaya</span>
                </div>
                
                <div class="p-4 bg-[#1D1D1E] border border-[#353536] font-mono text-xs text-white leading-relaxed">
                    Total Bayar = (Tarif Kamar x Jumlah Malam) + Premi Asuransi Pembatalan (Opsional)
                </div>

                <div class="space-y-4 font-sans text-xs sm:text-sm text-[#969696]">
                    <div class="border-b border-[#29292A] pb-3">
                        <span class="font-bold text-white block mb-1">Durasi Sewa Per Malam</span>
                        Check-in resmi dibuka pukul 14.00 WIB dan check-out selesai pukul 12.00 WIB hari berikutnya.
                    </div>
                    <div class="border-b border-[#29292A] pb-3">
                        <span class="font-bold text-white block mb-1">Bebas Biaya Deposit</span>
                        Tidak ada deposit jaminan kerusakan. Seluruh biaya menginap terhitung murni dari tarif sewa unit kamar glamping pilihan Anda.
                    </div>
                    <div>
                        <span class="font-bold text-white block mb-1">Asuransi Pembatalan (Flat Rp 25.000)</span>
                        Fitur opsional yang memberikan hak pengembalian dana sewa kamar (hingga 100%) jika Anda membatalkan kunjungan sebelum proses check-in.
                    </div>
                </div>
            </div>

            <!-- Right: Refund Matrix Table -->
            <div class="border border-[#353536] bg-[#0F0F10] p-6 sm:p-8 space-y-6">
                <div class="flex items-center gap-2 font-mono text-xs text-[#969696] uppercase tracking-wider">
                    <span class="w-2 h-2 bg-white"></span>
                    <span>Skema Pengembalian Dana (Refund)</span>
                </div>

                <p class="font-serif text-xs sm:text-sm text-[#969696]">
                    Permohonan pembatalan diajukan melalui sistem sebelum tanggal mulai sewa (sebelum proses check-in dilakukan oleh staf).
                </p>

                <!-- Comparison Table -->
                <div class="overflow-x-auto">
                    <table class="w-full text-left font-mono text-xs border border-[#353536]">
                        <thead class="bg-[#1D1D1E] text-white">
                            <tr>
                                <th class="p-3 border-b border-r border-[#353536]">Waktu Pembatalan</th>
                                <th class="p-3 border-b border-r border-[#353536]">Dengan Asuransi</th>
                                <th class="p-3 border-b border-[#353536]">Tanpa Asuransi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#353536] text-[#969696]">
                            <tr>
                                <td class="p-3 border-r border-[#353536] font-sans text-white">
                                    Lebih dari 3 hari sebelum check-in
                                </td>
                                <td class="p-3 border-r border-[#353536] text-white font-bold">
                                    Refund 100% Biaya Sewa
                                    <span class="block text-[10px] text-[#969696] font-normal font-sans">Premi asuransi Rp 25.000 hangus</span>
                                </td>
                                <td class="p-3 text-red-400 font-bold">
                                    Refund 0%
                                    <span class="block text-[10px] text-[#969696] font-normal font-sans">Biaya sewa kamar hangus</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="p-3 border-r border-[#353536] font-sans text-white">
                                    3 hari atau kurang sebelum check-in
                                </td>
                                <td class="p-3 border-r border-[#353536] text-white font-bold">
                                    Refund 50% Biaya Sewa
                                    <span class="block text-[10px] text-[#969696] font-normal font-sans">Premi asuransi Rp 25.000 hangus</span>
                                </td>
                                <td class="p-3 text-red-400 font-bold">
                                    Refund 0%
                                    <span class="block text-[10px] text-[#969696] font-normal font-sans">Biaya sewa kamar hangus</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <p class="text-[11px] font-mono text-[#969696]">
                    Catatan: Pengembalian dana dicatat secara administratif pada sistem setelah permohonan disetujui staf operasional.
                </p>
            </div>

        </div>

    </div>
</section>

{{-- 6. SECTION EDUKASI & ARTIKEL --}}
<section id="artikel" class="py-16 sm:py-24 bg-white border-b border-[#E0DEDC] scroll-mt-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-12 sm:mb-16 pb-6 border-b border-[#E0DEDC]">
            <div>
                <span class="font-mono text-xs uppercase tracking-widest text-[#969696] block mb-2">
                    Jurnal & Edukasi
                </span>
                <h2 class="text-2xl sm:text-4xl font-sans font-bold text-[#1D1D1C]">
                    Wawasan Berwisata Alam Bebas
                </h2>
            </div>
            <p class="font-serif text-sm sm:text-base text-[#444444] max-w-md">
                Kumpulan artikel edukatif mengenai persiapan berkemah, pemilihan tenda, serta panduan menikmati keheningan alam pegunungan.
            </p>
        </div>

        <!-- 3 Articles Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            
            <!-- Article 1 -->
            <article class="flex flex-col border border-[#E0DEDC] bg-[#F9F7F5] group">
                <div class="relative overflow-hidden aspect-[16/10] bg-black">
                    <img src="{{ asset('images/Camp_premium.jpg') }}"
                         alt="Pemandangan pegunungan dan persiapan tenda"
                         class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                         loading="lazy">
                    <div class="absolute top-3 left-3 bg-[#1D1D1C] text-white text-[10px] font-mono uppercase px-2 py-0.5">
                        Panduan Pemula
                    </div>
                </div>
                <div class="p-6 flex-grow flex flex-col justify-between space-y-4">
                    <div>
                        <div class="font-mono text-[11px] text-[#969696] mb-2">
                            4 Menit Baca : Outdoor Guide
                        </div>
                        <h3 class="text-lg font-bold font-sans text-[#1D1D1C] leading-snug mb-3">
                            Tips Memilih Tenda untuk Pemula di Cuaca Dingin Pegunungan
                        </h3>
                        <p class="font-serif text-xs sm:text-sm text-[#444444] leading-relaxed">
                            Mengenal ketebalan kain kanvas, pengaturan ventilasi sirkulasi udara guna mencegah kondensasi kabut, serta trik mengunci pasak di lereng perbukitan berangin.
                        </p>
                    </div>
                    <div class="pt-4 border-t border-[#E0DEDC] flex items-center justify-between text-xs font-mono text-[#1D1D1C]">
                        <span>Oleh Tim Konservasi Atara</span>
                        <span class="underline">Baca Selengkapnya</span>
                    </div>
                </div>
            </article>

            <!-- Article 2 -->
            <article class="flex flex-col border border-[#E0DEDC] bg-[#F9F7F5] group">
                <div class="relative overflow-hidden aspect-[16/10] bg-black">
                    <img src="{{ asset('images/Camp_from_above.jpg') }}"
                         alt="Aktivitas memanggang marshmallow di dekat tenda"
                         class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                         loading="lazy">
                    <div class="absolute top-3 left-3 bg-[#1D1D1C] text-white text-[10px] font-mono uppercase px-2 py-0.5">
                        Persiapan Keluarga
                    </div>
                </div>
                <div class="p-6 flex-grow flex flex-col justify-between space-y-4">
                    <div>
                        <div class="font-mono text-[11px] text-[#969696] mb-2">
                            5 Menit Baca : Checklist
                        </div>
                        <h3 class="text-lg font-bold font-sans text-[#1D1D1C] leading-snug mb-3">
                            Checklist Alat Camping Esensial untuk Glamping Nyaman Bersama Keluarga
                        </h3>
                        <p class="font-serif text-xs sm:text-sm text-[#444444] leading-relaxed">
                            Panduan barang bawaan krusial mulai dari pakaian hangat berlapis, lampu lentera portabel, perlengkapan seduh minuman hangat, hingga kotak pertolongan pertama.
                        </p>
                    </div>
                    <div class="pt-4 border-t border-[#E0DEDC] flex items-center justify-between text-xs font-mono text-[#1D1D1C]">
                        <span>Oleh Staf Lapangan Atara</span>
                        <span class="underline">Baca Selengkapnya</span>
                    </div>
                </div>
            </article>

            <!-- Article 3 -->
            <article class="flex flex-col border border-[#E0DEDC] bg-[#F9F7F5] group">
                <div class="relative overflow-hidden aspect-[16/10] bg-black">
                    <img src="{{ asset('images/High_standart_camp.jpg') }}"
                         alt="Api unggun senja di perkemahan glamping"
                         class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                         loading="lazy">
                    <div class="absolute top-3 left-3 bg-[#1D1D1C] text-white text-[10px] font-mono uppercase px-2 py-0.5">
                        Gaya Hidup & Filosofi
                    </div>
                </div>
                <div class="p-6 flex-grow flex flex-col justify-between space-y-4">
                    <div>
                        <div class="font-mono text-[11px] text-[#969696] mb-2">
                            6 Menit Baca : Refleksi
                        </div>
                        <h3 class="text-lg font-bold font-sans text-[#1D1D1C] leading-snug mb-3">
                            Glamping Minimalis: Mendekap Keheningan Alam Tanpa Mengorbankan Kenyamanan
                        </h3>
                        <p class="font-serif text-xs sm:text-sm text-[#444444] leading-relaxed">
                            Bagaimana perpaduan arsitektur ramah lingkungan dan pelayanan hangat memungkinkan manusia modern melepaskan lelah batin dan menyatu dengan semesta.
                        </p>
                    </div>
                    <div class="pt-4 border-t border-[#E0DEDC] flex items-center justify-between text-xs font-mono text-[#1D1D1C]">
                        <span>Oleh Kurator Atara Glamping</span>
                        <span class="underline">Baca Selengkapnya</span>
                    </div>
                </div>
            </article>

        </div>

    </div>
</section>

{{-- 7. SECTION CEK STATUS RESERVASI --}}
<section id="cek-reservasi" class="py-16 sm:py-24 bg-[#F9F7F5] border-b border-[#E0DEDC] scroll-mt-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-center">
            
            <!-- Left Info (Col 5) -->
            <div class="lg:col-span-5 space-y-6">
                <div>
                    <span class="font-mono text-xs uppercase tracking-widest text-[#969696] block mb-2">
                        Pelacakan Digital
                    </span>
                    <h2 class="text-2xl sm:text-4xl font-sans font-bold text-[#1D1D1C] mb-4">
                        Cek Status Booking & Kartu Digital
                    </h2>
                    <p class="font-serif text-sm sm:text-base text-[#444444] leading-relaxed">
                        Lacak kepastian reservasi Anda secara mandiri. Tunjukkan kartu digital dan kode QR saat tiba di lokasi untuk proses serah terima kamar yang cepat.
                    </p>
                </div>

                <div class="space-y-3 font-mono text-xs border border-[#E0DEDC] bg-white p-5">
                    <div class="flex items-center gap-3">
                        <span class="w-2 h-2 bg-[#1D1D1C]"></span>
                        <span class="text-[#1D1D1C] font-semibold">Akses Tanpa Login</span>
                    </div>
                    <p class="font-serif text-xs text-[#444444] leading-relaxed">
                        Cukup gunakan kode booking unik dan email atau nomor telepon yang didaftarkan saat pemesanan.
                    </p>
                    <div class="pt-3 border-t border-[#E0DEDC] flex flex-wrap gap-2 text-[10px] text-[#969696]">
                        <span class="px-2 py-0.5 bg-[#F9F7F5] border border-[#E0DEDC]">Unpaid</span>
                        <span class="px-2 py-0.5 bg-[#F9F7F5] border border-[#E0DEDC]">Confirmed</span>
                        <span class="px-2 py-0.5 bg-[#F9F7F5] border border-[#E0DEDC]">Checked In</span>
                        <span class="px-2 py-0.5 bg-[#F9F7F5] border border-[#E0DEDC]">Completed</span>
                    </div>
                </div>
            </div>

            <!-- Right Form Card (Col 7) -->
            <div class="lg:col-span-7">
                <div class="border border-[#1D1D1C] bg-white p-6 sm:p-10 shadow-[0_6px_20px_rgba(0,0,0,0.04)]">
                    <div class="flex items-center justify-between pb-4 mb-6 border-b border-[#E0DEDC]">
                        <span class="font-mono text-xs uppercase tracking-wider text-[#1D1D1C] font-semibold">
                            Formulir Pelacakan Reservasi
                        </span>
                        <span class="font-mono text-[11px] text-[#969696]">
                            Verifikasi Real-time
                        </span>
                    </div>

                    <form action="#" method="GET" class="space-y-5">
                        <div>
                            <label for="booking_code" class="block font-mono text-xs uppercase tracking-wider text-[#1D1D1C] font-semibold mb-2">
                                Kode Booking Unik
                            </label>
                            <input type="text"
                                   id="booking_code"
                                   name="booking_code"
                                   placeholder="Contoh: GLAMP-2026-ABCD"
                                   class="w-full px-4 py-3 border border-[#E0DEDC] bg-[#F9F7F5] text-sm font-mono text-[#1D1D1C] placeholder-[#969696] focus:outline-none focus:ring-2 focus:ring-[#1D1D1C] focus:bg-white transition-all rounded-[3px]">
                            <span class="block font-serif text-[11px] text-[#969696] mt-1.5">
                                Kode alfanumerik tertera pada bukti pesanan atau konfirmasi pembayaran.
                            </span>
                        </div>

                        <div>
                            <label for="contact_lookup" class="block font-mono text-xs uppercase tracking-wider text-[#1D1D1C] font-semibold mb-2">
                                Email atau Nomor Telepon
                            </label>
                            <input type="text"
                                   id="contact_lookup"
                                   name="contact_lookup"
                                   placeholder="Contoh: tamu@domain.test / 081234567890"
                                   class="w-full px-4 py-3 border border-[#E0DEDC] bg-[#F9F7F5] text-sm font-mono text-[#1D1D1C] placeholder-[#969696] focus:outline-none focus:ring-2 focus:ring-[#1D1D1C] focus:bg-white transition-all rounded-[3px]">
                            <span class="block font-serif text-[11px] text-[#969696] mt-1.5">
                                Gunakan kontak yang sama saat mengisi formulir checkout pemesanan.
                            </span>
                        </div>

                        <div class="pt-2">
                            <button type="button"
                                    class="w-full inline-flex items-center justify-center px-6 py-4 bg-[#1D1D1C] text-white text-xs sm:text-sm font-semibold tracking-wider uppercase hover:bg-black transition-colors rounded-[5px] focus:outline-none focus:ring-2 focus:ring-[#1D1D1C] focus:ring-offset-2">
                                Periksa Status Reservasi & Kartu Digital
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>

    </div>
</section>

{{-- 8. SECTION LOKASI & KONTAK --}}
<section id="kontak" class="py-16 sm:py-24 bg-[#F9F7F5] border-b border-[#E0DEDC] scroll-mt-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
            
            <!-- Left Info (Col 5) -->
            <div class="lg:col-span-5 space-y-8">
                <div>
                    <span class="font-mono text-xs uppercase tracking-widest text-[#969696] block mb-2">
                        Lokasi & Akses
                    </span>
                    <h2 class="text-2xl sm:text-4xl font-sans font-bold text-[#1D1D1C] mb-4">
                        Jalur Menuju Suaka Atara Glamping
                    </h2>
                    <p class="font-serif text-sm sm:text-base text-[#444444] leading-relaxed">
                        Terletak di lereng perbukitan pinus dengan akses jalan aspal beraspal baik yang dapat dijangkau oleh kendaraan roda dua maupun mobil keluarga.
                    </p>
                </div>

                <div class="space-y-4 font-mono text-xs border border-[#E0DEDC] bg-white p-6">
                    <div class="border-b border-[#E0DEDC] pb-3">
                        <span class="text-[#969696] uppercase block text-[10px] mb-1">Alamat Resmi</span>
                        <p class="text-[#1D1D1C] font-semibold font-sans text-sm">
                            Kawasan Dataran Tinggi Pinus Asri, Jalur Puncak Dingin KM 18
                        </p>
                    </div>
                    <div class="border-b border-[#E0DEDC] pb-3">
                        <span class="text-[#969696] uppercase block text-[10px] mb-1">Waktu Tempuh Perjalanan</span>
                        <p class="text-[#444444] font-sans text-xs">
                            Sekitar 45 menit perjalanan santai dari gerbang tol atau stasiun kota terdekat.
                        </p>
                    </div>
                    <div class="border-b border-[#E0DEDC] pb-3">
                        <span class="text-[#969696] uppercase block text-[10px] mb-1">Pusat Bantuan & WhatsApp</span>
                        <p class="text-[#1D1D1C] font-bold text-sm">
                            +62 812-3456-7890
                        </p>
                        <span class="text-[10px] text-[#969696]">Buka setiap hari : 08.00 sampai 20.00 WIB</span>
                    </div>
                    <div>
                        <span class="text-[#969696] uppercase block text-[10px] mb-1">Kanal Surel Reservasi</span>
                        <p class="text-[#1D1D1C]">concierge@atara-glamping.test</p>
                    </div>
                </div>

                <a href="https://wa.me/6281234567890" target="_blank" rel="noopener noreferrer"
                   class="inline-flex items-center justify-center w-full px-6 py-3.5 bg-[#1D1D1C] text-white text-xs sm:text-sm font-semibold tracking-wider uppercase hover:bg-black transition-colors rounded-[5px]">
                    Hubungi Petugas Concierge Via WhatsApp
                </a>
            </div>

            <!-- Right FAQ (Col 7) -->
            <div class="lg:col-span-7 space-y-6">
                <div>
                    <span class="font-mono text-xs uppercase tracking-widest text-[#969696] block mb-2">
                        Pertanyaan Umum
                    </span>
                    <h3 class="text-xl sm:text-2xl font-sans font-bold text-[#1D1D1C] mb-2">
                        Informasi Penting Sebelum Berkunjung
                    </h3>
                    <p class="font-serif text-xs sm:text-sm text-[#444444]">
                        Jawaban atas pertanyaan yang sering diajukan terkait sanitasi, pasokan listrik, dan keamanan keluarga di alam bebas.
                    </p>
                </div>

                <!-- FAQ Accordions / List -->
                <div class="space-y-4">
                    
                    <div class="border border-[#E0DEDC] bg-white p-5">
                        <h4 class="font-bold text-sm font-sans text-[#1D1D1C] mb-2">
                            Apakah tipe kamar glamping ramah untuk anak-anak dan lansia?
                        </h4>
                        <p class="font-serif text-xs text-[#444444] leading-relaxed">
                            Ya, seluruh unit glamping Atara didirikan di atas dek kayu kokoh dengan tangga landai berpegangan tangan. Tipe Safari Luxury Suite dan Dome Cabin memiliki lantai rata bebas undakan berbahaya sehingga nyaman untuk seluruh anggota keluarga.
                        </p>
                    </div>

                    <div class="border border-[#E0DEDC] bg-white p-5">
                        <h4 class="font-bold text-sm font-sans text-[#1D1D1C] mb-2">
                            Bagaimana fasilitas sanitasi dan pasokan air hangat di lokasi?
                        </h4>
                        <p class="font-serif text-xs text-[#444444] leading-relaxed">
                            Tipe Alpine Dome Cabin memiliki kamar mandi dalam (en-suite) lengkap dengan water heater. Untuk tipe Safari Suite dan Bell Tent, tersedia toilet privat higienis dengan pancuran air panas yang hanya berjarak beberapa langkah dari pintu kanvas tenda Anda.
                        </p>
                    </div>

                    <div class="border border-[#E0DEDC] bg-white p-5">
                        <h4 class="font-bold text-sm font-sans text-[#1D1D1C] mb-2">
                            Apakah terdapat colokan listrik dan jaringan sinyal internet?
                        </h4>
                        <p class="font-serif text-xs text-[#444444] leading-relaxed">
                            Setiap unit tenda dialiri daya listrik 24 jam dengan stopkontak standar untuk pengisian daya gawai dan lampu penerangan. Sinyal seluler 4G menjangkau seluruh area glamping dan tersedia koneksi Wi-Fi di area lobi resepsionis.
                        </p>
                    </div>

                    <div class="border border-[#E0DEDC] bg-white p-5">
                        <h4 class="font-bold text-sm font-sans text-[#1D1D1C] mb-2">
                            Bagaimana ketentuan pembatalan dan klaim asuransi reservasi?
                        </h4>
                        <p class="font-serif text-xs text-[#444444] leading-relaxed">
                            Permohonan pembatalan dapat diajukan sebelum tanggal check-in. Apabila Anda memilih Asuransi Pembatalan (Rp 25.000), Anda berhak atas refund 100% biaya sewa untuk pembatalan lebih dari 3 hari sebelum menginap, atau refund 50% untuk pembatalan dalam rentang 3 hari atau kurang. Tanpa asuransi, biaya sewa kamar tidak dapat dikembalikan.
                        </p>
                    </div>

                </div>

            </div>

        </div>

    </div>
</section>

@endsection
