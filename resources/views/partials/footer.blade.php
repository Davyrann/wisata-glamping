<footer class="bg-surface-alt text-white pt-16 sm:pt-24 pb-12 sm:pb-16 border-t border-primary">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Top Grid -->
        <div class="grid grid-cols-1 md:grid-cols-12 gap-12 pb-16 border-b border-[#29292A]">
            
            <!-- Col 1: Identity & Elevation Statement -->
            <div class="md:col-span-5 space-y-6">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('images/logo/atara-logo-mark-dark.svg') }}" alt="Logo Atara Glamping" class="h-9 w-auto object-contain shrink-0" />
                    <span class="font-sans font-bold text-xl tracking-[0.2em] uppercase">Atara Glamping</span>
                </div>
                <p class="font-serif font-light text-base text-muted-stone leading-relaxed max-w-sm">
                    Kombinasi kemewahan kanvas alpine, kenyamanan fasilitas kabin, dan lanskap pegunungan berkabut pada ketinggian 1.620 mdpl.
                </p>
                <div class="font-mono text-xs text-muted-stone space-y-1">
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
                <ul class="space-y-2.5 font-serif text-sm text-muted-stone">
                    <li><a href="#kamar" class="hover:text-white transition-colors">Tipe Kamar Glamping</a></li>
                    <li><a href="#fasilitas" class="hover:text-white transition-colors">Fasilitas Unggulan</a></li>
                    <li><a href="#panduan" class="hover:text-white transition-colors">Panduan & Alur Reservasi</a></li>
                    <li><a href="#cek-reservasi" class="hover:text-white transition-colors">Cek Status Booking</a></li>
                    <li><a href="#kebijakan" class="hover:text-white transition-colors">Kebijakan & Asuransi</a></li>
                    <li><a href="#artikel" class="hover:text-white transition-colors">Jurnal & Tips Outdoor</a></li>
                </ul>
            </div>

            <!-- Col 3: Ketentuan Operasional (PRD Rules) -->
            <div class="md:col-span-4 space-y-4">
                <h4 class="font-mono text-xs uppercase tracking-widest text-white border-b border-[#29292A] pb-2">
                    Jadwal Operasional
                </h4>
                <div class="space-y-3 font-sans text-xs text-muted-stone">
                    <div class="flex justify-between items-center py-1 border-b border-primary">
                        <span>Check-in Mandiri</span>
                        <span class="font-mono text-white">14.00 WIB</span>
                    </div>
                    <div class="flex justify-between items-center py-1 border-b border-primary">
                        <span>Check-out Selesai</span>
                        <span class="font-mono text-white">12.00 WIB</span>
                    </div>
                    <div class="flex justify-between items-center py-1 border-b border-primary">
                        <span>Simulasi Sandbox QRIS</span>
                        <span class="font-mono text-white">Instan</span>
                    </div>
                    <div class="flex justify-between items-center py-1 border-b border-primary">
                        <span>Asuransi Pembatalan</span>
                        <span class="font-mono text-white">Opsional (Rp 25.000)</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bottom Bar -->
        <div class="pt-8 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs font-mono text-muted-stone">
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
