<footer class="bg-[#000000] text-white pt-16 sm:pt-24 pb-12 sm:pb-16 border-t border-[#1D1D1C]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Top Grid -->
        <div class="grid grid-cols-1 md:grid-cols-12 gap-12 pb-16 border-b border-[#29292A]">
            
            <!-- Col 1: Identity & Elevation Statement -->
            <div class="md:col-span-5 space-y-6">
                <div class="flex items-center gap-3">
                    <span class="w-3 h-3 bg-white"></span>
                    <span class="font-sans font-bold text-xl tracking-[0.2em] uppercase">Atara Glamping</span>
                </div>
                <p class="font-serif font-light text-base text-[#969696] leading-relaxed max-w-sm">
                    Kombinasi kemewahan kanvas alpine, kenyamanan fasilitas kabin, dan lanskap pegunungan berkabut pada ketinggian 1.620 mdpl.
                </p>
                <div class="font-mono text-xs text-[#969696] space-y-1">
                    <p>Elevasi : 1.620 mdpl</p>
                    <p>Koordinat : 7.2418° S, 107.6189° E</p>
                    <p>Zona Waktu : Waktu Indonesia Barat (WIB)</p>
                </div>
            </div>

            <!-- Col 2: Navigasi Cepat -->
            <div class="md:col-span-3 space-y-4">
                <h4 class="font-mono text-xs uppercase tracking-widest text-white border-b border-[#29292A] pb-2">
                    Eksplorasi
                </h4>
                <ul class="space-y-2.5 font-serif text-sm text-[#969696]">
                    <li><a href="#kamar" class="hover:text-white transition-colors">Tipe Kamar Glamping</a></li>
                    <li><a href="#alat" class="hover:text-white transition-colors">Perlengkapan Camping</a></li>
                    <li><a href="#panduan" class="hover:text-white transition-colors">Panduan & Alur Reservasi</a></li>
                    <li><a href="#kebijakan" class="hover:text-white transition-colors">Deposit & Pembatalan</a></li>
                    <li><a href="#artikel" class="hover:text-white transition-colors">Jurnal & Tips Outdoor</a></li>
                </ul>
            </div>

            <!-- Col 3: Ketentuan Operasional (PRD Rules) -->
            <div class="md:col-span-4 space-y-4">
                <h4 class="font-mono text-xs uppercase tracking-widest text-white border-b border-[#29292A] pb-2">
                    Jadwal Operasional
                </h4>
                <div class="space-y-3 font-sans text-xs text-[#969696]">
                    <div class="flex justify-between items-center py-1 border-b border-[#1D1D1C]">
                        <span>Check-in Mandiri</span>
                        <span class="font-mono text-white">14.00 WIB</span>
                    </div>
                    <div class="flex justify-between items-center py-1 border-b border-[#1D1D1C]">
                        <span>Check-out Selesai</span>
                        <span class="font-mono text-white">12.00 WIB</span>
                    </div>
                    <div class="flex justify-between items-center py-1 border-b border-[#1D1D1C]">
                        <span>Hold Pembayaran QRIS</span>
                        <span class="font-mono text-white">15 Menit</span>
                    </div>
                    <div class="flex justify-between items-center py-1 border-b border-[#1D1D1C]">
                        <span>Deposit Kerusakan</span>
                        <span class="font-mono text-white">Rp 50.000 (Refundable)</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bottom Bar -->
        <div class="pt-8 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs font-mono text-[#969696]">
            <div>
                &copy; {{ date('Y') }} Atara Glamping Sanctuary. Hak Cipta Dilindungi.
            </div>
            <div class="flex items-center gap-6">
                <span>UAS Pemrograman Web</span>
                <span>Laravel 12 & Tailwind CSS v4</span>
            </div>
        </div>
    </div>
</footer>
