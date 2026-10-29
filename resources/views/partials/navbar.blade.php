<header class="sticky top-0 z-40 bg-[#F9F7F5]/95 backdrop-blur-sm border-b border-[#E0DEDC]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16 sm:h-20">
            
            <!-- Brand Logo / Wordmark -->
            <a href="{{ route('home') }}" class="group flex items-center gap-3 focus:outline-none focus:ring-2 focus:ring-[#1D1D1C] p-1">
                <span class="w-2.5 h-2.5 bg-[#1D1D1C] transition-transform group-hover:scale-125"></span>
                <div class="flex flex-col">
                    <span class="font-sans font-extrabold text-base sm:text-lg tracking-[0.2em] text-[#1D1D1C] leading-none uppercase">
                        Atara
                    </span>
                    <span class="font-mono text-[9px] sm:text-[10px] tracking-[0.3em] text-[#969696] uppercase leading-tight mt-0.5">
                        Glamping & Alpine Retreat
                    </span>
                </div>
            </a>

            <!-- Desktop Navigation Links -->
            <nav class="hidden md:flex items-center gap-8 text-xs font-mono uppercase tracking-wider text-[#444444]" aria-label="Navigasi Utama">
                <a href="#kamar" class="hover:text-[#1D1D1C] transition-colors py-2 border-b border-transparent hover:border-[#1D1D1C]">
                    Kamar Glamping
                </a>
                <a href="#alat" class="hover:text-[#1D1D1C] transition-colors py-2 border-b border-transparent hover:border-[#1D1D1C]">
                    Peralatan Camping
                </a>
                <a href="#panduan" class="hover:text-[#1D1D1C] transition-colors py-2 border-b border-transparent hover:border-[#1D1D1C]">
                    Alur Reservasi
                </a>
                <a href="#artikel" class="hover:text-[#1D1D1C] transition-colors py-2 border-b border-transparent hover:border-[#1D1D1C]">
                    Edukasi
                </a>
                <a href="#kontak" class="hover:text-[#1D1D1C] transition-colors py-2 border-b border-transparent hover:border-[#1D1D1C]">
                    Lokasi & Kontak
                </a>
            </nav>

            <!-- Actions (Login & Mobile Hamburger) -->
            <div class="flex items-center gap-3">
                <a href="{{ route('login') }}"
                   class="inline-flex items-center justify-center px-4 sm:px-5 py-2 sm:py-2.5 bg-[#1D1D1C] text-white text-xs font-semibold tracking-wider uppercase hover:bg-black transition-colors rounded-[5px] focus:outline-none focus:ring-2 focus:ring-[#1D1D1C] focus:ring-offset-2">
                    Masuk Akun
                </a>

                <!-- Mobile Hamburger Button -->
                <button type="button"
                        id="mobile-menu-btn"
                        class="md:hidden p-2 text-[#1D1D1C] hover:bg-[#E0DEDC]/50 rounded-[5px] focus:outline-none focus:ring-2 focus:ring-[#1D1D1C]"
                        aria-controls="mobile-nav"
                        aria-expanded="false"
                        aria-label="Buka menu navigasi">
                    <svg class="w-6 h-6" id="menu-icon-open" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                    <svg class="w-6 h-6 hidden" id="menu-icon-close" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Drawer Panel -->
    <div id="mobile-nav" class="hidden md:hidden border-b border-[#E0DEDC] bg-[#F9F7F5] px-4 pt-4 pb-6 space-y-3">
        <a href="#kamar" class="mobile-nav-link block px-3 py-2 text-sm font-mono uppercase tracking-wider text-[#1D1D1C] hover:bg-[#E0DEDC]/40">
            Kamar Glamping
        </a>
        <a href="#alat" class="mobile-nav-link block px-3 py-2 text-sm font-mono uppercase tracking-wider text-[#1D1D1C] hover:bg-[#E0DEDC]/40">
            Peralatan Camping
        </a>
        <a href="#panduan" class="mobile-nav-link block px-3 py-2 text-sm font-mono uppercase tracking-wider text-[#1D1D1C] hover:bg-[#E0DEDC]/40">
            Alur Reservasi
        </a>
        <a href="#artikel" class="mobile-nav-link block px-3 py-2 text-sm font-mono uppercase tracking-wider text-[#1D1D1C] hover:bg-[#E0DEDC]/40">
            Edukasi
        </a>
        <a href="#kontak" class="mobile-nav-link block px-3 py-2 text-sm font-mono uppercase tracking-wider text-[#1D1D1C] hover:bg-[#E0DEDC]/40">
            Lokasi & Kontak
        </a>
        <div class="pt-2 border-t border-[#E0DEDC]">
            <a href="{{ route('login') }}" class="block w-full text-center px-4 py-2.5 bg-[#1D1D1C] text-white text-xs font-semibold tracking-wider uppercase hover:bg-black rounded-[5px]">
                Masuk Akun (Staff & Tamu)
            </a>
        </div>
    </div>
</header>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const btn = document.getElementById('mobile-menu-btn');
        const nav = document.getElementById('mobile-nav');
        const openIcon = document.getElementById('menu-icon-open');
        const closeIcon = document.getElementById('menu-icon-close');
        const links = document.querySelectorAll('.mobile-nav-link');

        if (btn && nav) {
            btn.addEventListener('click', function () {
                const isExpanded = btn.getAttribute('aria-expanded') === 'true';
                btn.setAttribute('aria-expanded', !isExpanded);
                nav.classList.toggle('hidden');
                openIcon.classList.toggle('hidden');
                closeIcon.classList.toggle('hidden');
            });

            links.forEach(link => {
                link.addEventListener('click', function () {
                    nav.classList.add('hidden');
                    openIcon.classList.remove('hidden');
                    closeIcon.classList.add('hidden');
                    btn.setAttribute('aria-expanded', 'false');
                });
            });
        }
    });
</script>
@endpush
