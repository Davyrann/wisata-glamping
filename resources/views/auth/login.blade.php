<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Masuk ke portal akun Atara Glamping untuk mengelola reservasi kamar, melihat kartu digital QR, dan mengakses informasi menginap Anda.">
    <title>Masuk ke Akun | Atara Glamping</title>

    <!-- Favicon & App Icons -->
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
    <meta name="theme-color" content="#161816">

    <!-- Google Fonts: Plus Jakarta Sans, Fraunces, JetBrains Mono -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,500;9..144,600;9..144,700&family=JetBrains+Mono:wght@400;500;600&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full bg-paper text-text font-sans antialiased selection:bg-pine-700 selection:text-white">

    <div class="min-h-screen flex flex-col lg:flex-row lg:h-screen lg:overflow-hidden">

        <!-- Sisi Kiri (Desktop: 5/12 foto penuh; Mobile: 160px header band) -->
        <div class="relative w-full lg:w-5/12 h-40 lg:h-full bg-ink-900 shrink-0 overflow-hidden">
            <img src="{{ asset('images/Camp_premium.jpg') }}"
                 alt="Panorama tenda premium Atara Glamping dengan latar rimba pinus"
                 class="w-full h-full object-cover object-center opacity-90 lg:opacity-85"
                 loading="eager"
                 width="1200"
                 height="1600">

            <!-- Gradient Overlay Halus untuk Keterbacaan Teks -->
            <div class="absolute inset-0 bg-gradient-to-t from-ink-950/80 via-ink-900/30 to-ink-950/60 lg:to-transparent pointer-events-none"></div>

            <!-- Tautan Kembali ke Beranda & Logo di Sudut Kiri Atas -->
            <div class="absolute top-4 left-4 lg:top-8 lg:left-8 z-10">
                <a href="{{ route('home') }}"
                   class="inline-flex items-center gap-2.5 px-3 py-1.5 rounded-md bg-ink-900/80 backdrop-blur-sm text-text-on-ink text-xs font-mono uppercase tracking-wider hover:bg-ink-900 hover:text-white transition-colors border border-white/10 focus:outline-none focus:ring-2 focus:ring-white">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    <span>Beranda</span>
                </a>
            </div>

            <!-- Keterangan Lanskap di Sudut Kiri Bawah (Mematuhi R-02 Antislop: tanpa em dash) -->
            <div class="absolute bottom-4 left-4 lg:bottom-8 lg:left-8 right-4 z-10">
                <p class="font-mono text-xs uppercase tracking-[0.2em] text-text-on-ink/90 flex items-center gap-2">
                    <span class="inline-block w-2 h-2 rounded-full bg-ember-600 shrink-0" aria-hidden="true"></span>
                    <span>Lanskap Pagi Hari &middot; 1.620 mdpl</span>
                </p>
                <p class="hidden lg:block text-xs text-text-on-ink/70 mt-1 max-w-xs leading-relaxed">
                    Kesejukan udara pegunungan dan panorama pinus menyambut momen istirahat Anda di Atara Glamping.
                </p>
            </div>
        </div>

        <!-- Sisi Kanan (Desktop: 7/12 area konten paper; Form 400px) -->
        <main class="w-full lg:w-7/12 flex-1 flex items-center justify-center p-6 sm:p-10 lg:p-12 overflow-y-auto">
            <div class="w-full max-w-[400px] py-4">

                <!-- Header Form & Identitas Brand -->
                <div class="mb-8">
                    <div class="flex items-center gap-3 mb-4">
                        <img src="{{ asset('images/logo/atara-logo-mark.svg') }}"
                             alt="Logo Atara Glamping"
                             class="h-9 w-auto object-contain shrink-0" />
                        <span class="font-mono text-xs uppercase tracking-[0.25em] text-text-muted font-semibold">
                            Atara Glamping
                        </span>
                    </div>

                    <h1 class="font-display text-2xl sm:text-3xl font-semibold text-text tracking-tight leading-tight">
                        Masuk ke Akun
                    </h1>
                    <p class="text-sm text-text-muted mt-1.5 leading-relaxed">
                        Akses reservasi dan detail menginap Anda.
                    </p>
                </div>

                <!-- Formulir Login -->
                <form method="POST" action="{{ route('login.store') }}" class="space-y-5" novalidate>
                    @csrf

                    <!-- Field: Alamat Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-text mb-1.5">
                            Alamat Email
                        </label>
                        <div class="relative">
                            <input id="email"
                                   type="email"
                                   name="email"
                                   value="{{ old('email') }}"
                                   required
                                   autofocus
                                   autocomplete="email"
                                   inputmode="email"
                                   placeholder="nama@email.com"
                                   aria-describedby="@error('email') email-error @enderror"
                                   aria-invalid="@error('email') true @else false @enderror"
                                   class="w-full h-11 px-3.5 bg-surface text-text text-sm rounded-[6px] border @error('email') border-danger focus:ring-danger @else border-line-strong focus:border-pine-700 focus:ring-pine-700 @enderror focus:outline-none focus:ring-2 focus:ring-offset-1 focus:ring-offset-paper placeholder:text-text-faint transition-colors" />
                        </div>

                        @error('email')
                            <p id="email-error" class="mt-2 text-xs text-danger font-medium flex items-center gap-1.5" role="alert">
                                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>{{ $message }}</span>
                            </p>
                        @enderror
                    </div>

                    <!-- Field: Kata Sandi -->
                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <label for="password" class="block text-sm font-medium text-text">
                                Kata Sandi
                            </label>
                            <button type="button"
                                    id="forgot-password-btn"
                                    class="text-xs text-pine-700 hover:text-pine-600 font-medium underline underline-offset-2 focus:outline-none focus:ring-2 focus:ring-pine-700 rounded-sm">
                                Lupa kata sandi?
                            </button>
                        </div>

                        <div class="relative">
                            <input id="password"
                                   type="password"
                                   name="password"
                                   required
                                   autocomplete="current-password"
                                   placeholder="Masukkan kata sandi akun"
                                   aria-describedby="@error('password') password-error @enderror"
                                   aria-invalid="@error('password') true @else false @enderror"
                                   class="w-full h-11 pl-3.5 pr-11 bg-surface text-text text-sm rounded-[6px] border @error('password') border-danger focus:ring-danger @else border-line-strong focus:border-pine-700 focus:ring-pine-700 @enderror focus:outline-none focus:ring-2 focus:ring-offset-1 focus:ring-offset-paper placeholder:text-text-faint transition-colors" />

                            <!-- Tombol Toggle Lihat/Sembunyikan Sandi -->
                            <button type="button"
                                    id="toggle-password-btn"
                                    class="absolute inset-y-0 right-0 px-3 flex items-center text-text-muted hover:text-text focus:outline-none focus:text-pine-700"
                                    aria-label="Tampilkan atau sembunyikan kata sandi">
                                <svg id="eye-show-icon" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                <svg id="eye-hide-icon" class="w-4 h-4 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"></path>
                                </svg>
                            </button>
                        </div>

                        @error('password')
                            <p id="password-error" class="mt-2 text-xs text-danger font-medium flex items-center gap-1.5" role="alert">
                                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>{{ $message }}</span>
                            </p>
                        @enderror
                    </div>

                    <!-- Pilihan Ingat Saya -->
                    <div class="flex items-center">
                        <label for="remember" class="flex items-center gap-2.5 text-sm text-text cursor-pointer select-none">
                            <input id="remember"
                                   type="checkbox"
                                   name="remember"
                                   value="1"
                                   {{ old('remember') ? 'checked' : '' }}
                                   class="w-4 h-4 rounded-[4px] border-line-strong text-pine-700 focus:ring-pine-700 focus:ring-offset-1 focus:ring-offset-paper accent-pine-700 cursor-pointer" />
                            <span>Ingat saya di perangkat ini</span>
                        </label>
                    </div>

                    <!-- Tombol Aksi Utama (Masuk ke Akun) -->
                    <button type="submit"
                            class="w-full h-11 px-4 bg-pine-700 hover:bg-pine-600 text-white font-semibold text-sm rounded-[6px] tracking-wide transition-colors duration-150 flex items-center justify-center gap-2 focus:outline-none focus:ring-2 focus:ring-pine-700 focus:ring-offset-2 focus:ring-offset-paper">
                        <span>Masuk ke Akun</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                        </svg>
                    </button>
                </form>

                <!-- Tautan Sekunder: Cek Reservasi Tanpa Login (Sesuai DESIGN_dashboard_page.md §7.7) -->
                <div class="mt-6 pt-5 border-t border-line text-center space-y-3">
                    <p class="text-xs text-text-muted">
                        Ingin memeriksa pesanan secara instan?
                    </p>
                    <a href="{{ route('home') }}#cek-reservasi"
                       class="inline-flex items-center justify-center gap-1.5 text-xs font-medium text-pine-700 hover:text-pine-600 hover:underline underline-offset-4 focus:outline-none focus:ring-2 focus:ring-pine-700 rounded-sm">
                        <span>Cek booking tanpa login</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                        </svg>
                    </a>
                </div>

                <!-- Panel Bantuan Pengujian: Akun Demo Wajib Dosen & Evaluator -->
                <div class="mt-8 p-3.5 rounded-md bg-sunken border border-line text-xs">
                    <div class="flex items-center justify-between mb-2">
                        <span class="font-mono text-[10px] uppercase tracking-wider text-text-muted font-semibold">
                            Akun Uji Coba Demo
                        </span>
                        <span class="text-[10px] text-text-faint">
                            Klik untuk isi otomatis
                        </span>
                    </div>

                    <div class="grid grid-cols-3 gap-1.5 font-mono text-[11px]">
                        <button type="button"
                                data-email="user@demo.test"
                                data-password="User#2026"
                                class="demo-acc-btn px-2 py-1.5 text-center bg-surface hover:bg-white text-text rounded border border-line-strong hover:border-pine-700 focus:outline-none focus:ring-1 focus:ring-pine-700 transition-colors">
                            Tamu Demo
                        </button>
                        <button type="button"
                                data-email="staff@demo.test"
                                data-password="Staff#2026"
                                class="demo-acc-btn px-2 py-1.5 text-center bg-surface hover:bg-white text-text rounded border border-line-strong hover:border-pine-700 focus:outline-none focus:ring-1 focus:ring-pine-700 transition-colors">
                            Staff
                        </button>
                        <button type="button"
                                data-email="admin@demo.test"
                                data-password="Admin#2026"
                                class="demo-acc-btn px-2 py-1.5 text-center bg-surface hover:bg-white text-text rounded border border-line-strong hover:border-pine-700 focus:outline-none focus:ring-1 focus:ring-pine-700 transition-colors">
                            Admin
                        </button>
                    </div>
                </div>

            </div>
        </main>
    </div>

    <!-- Modal Informasi Bantuan Lupa Kata Sandi (Aksesibilitas Tinggi, Escape key support) -->
    <div id="forgot-password-modal"
         class="fixed inset-0 z-50 hidden flex items-center justify-center p-4 bg-ink-950/60 backdrop-blur-xs"
         role="dialog"
         aria-modal="true"
         aria-labelledby="modal-title">
        <div class="w-full max-w-md bg-surface rounded-xl border border-line p-6 shadow-xl relative animate-in fade-in duration-200">
            <div class="flex items-start justify-between mb-4">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-full bg-pine-100 flex items-center justify-center text-pine-700 shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                    </div>
                    <div>
                        <h2 id="modal-title" class="font-display text-lg font-semibold text-text">
                            Bantuan Pemulihan Sandi
                        </h2>
                        <p class="text-xs text-text-muted">
                            Layanan Concierge Atara Glamping
                        </p>
                    </div>
                </div>

                <button type="button"
                        id="close-modal-btn"
                        class="p-1 text-text-muted hover:text-text rounded focus:outline-none focus:ring-2 focus:ring-pine-700"
                        aria-label="Tutup jendela bantuan">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <div class="text-xs text-text-muted space-y-3 leading-relaxed">
                <p>
                    Untuk menjaga keamanan data reservasi tamu, pengaturan ulang kata sandi diproses langsung melalui konfirmasi identitas tim resepsionis kami.
                </p>
                <div class="p-3 bg-sunken rounded-md border border-line space-y-1">
                    <p class="font-medium text-text">
                        WhatsApp Concierge Resmi:
                    </p>
                    <p class="font-mono text-xs text-pine-700 font-semibold select-all">
                        +62 812-3456-7890
                    </p>
                    <p class="text-[11px] text-text-faint">
                        Jam operasional: Setiap hari pukul 08.00 - 20.00 WIB
                    </p>
                </div>
                <p class="text-[11px] text-text-faint">
                    Sebutkan alamat email terdaftar dan kode reservasi terakhir Anda kepada petugas layanan.
                </p>
            </div>

            <div class="mt-5 flex justify-end">
                <button type="button"
                        id="confirm-close-btn"
                        class="px-4 py-2 bg-pine-700 hover:bg-pine-600 text-white text-xs font-semibold rounded-[6px] focus:outline-none focus:ring-2 focus:ring-pine-700 focus:ring-offset-2">
                    Mengerti
                </button>
            </div>
        </div>
    </div>

    <!-- Script Pendukung Interaktivitas (Aksesibel, Ringan, Tanpa Framework Berlebih) -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Toggle Lihat / Sembunyikan Kata Sandi
            const togglePasswordBtn = document.getElementById('toggle-password-btn');
            const passwordInput = document.getElementById('password');
            const eyeShowIcon = document.getElementById('eye-show-icon');
            const eyeHideIcon = document.getElementById('eye-hide-icon');

            if (togglePasswordBtn && passwordInput) {
                togglePasswordBtn.addEventListener('click', function () {
                    const isPassword = passwordInput.getAttribute('type') === 'password';
                    passwordInput.setAttribute('type', isPassword ? 'text' : 'password');
                    eyeShowIcon.classList.toggle('hidden', isPassword);
                    eyeHideIcon.classList.toggle('hidden', !isPassword);
                    passwordInput.focus();
                });
            }

            // Pengisian Instan Akun Demo
            const demoButtons = document.querySelectorAll('.demo-acc-btn');
            const emailInput = document.getElementById('email');

            demoButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const email = this.getAttribute('data-email');
                    const password = this.getAttribute('data-password');

                    if (emailInput && passwordInput) {
                        emailInput.value = email;
                        passwordInput.value = password;
                        passwordInput.focus();
                    }
                });
            });

            // Modal Bantuan Lupa Kata Sandi
            const forgotPasswordBtn = document.getElementById('forgot-password-btn');
            const modal = document.getElementById('forgot-password-modal');
            const closeModalBtn = document.getElementById('close-modal-btn');
            const confirmCloseBtn = document.getElementById('confirm-close-btn');

            function openModal() {
                modal.classList.remove('hidden');
                confirmCloseBtn.focus();
            }

            function closeModal() {
                modal.classList.add('hidden');
                if (forgotPasswordBtn) forgotPasswordBtn.focus();
            }

            if (forgotPasswordBtn && modal) {
                forgotPasswordBtn.addEventListener('click', openModal);
                closeModalBtn.addEventListener('click', closeModal);
                confirmCloseBtn.addEventListener('click', closeModal);

                modal.addEventListener('click', function (e) {
                    if (e.target === modal) {
                        closeModal();
                    }
                });

                document.addEventListener('keydown', function (e) {
                    if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
                        closeModal();
                    }
                });
            }
        });
    </script>
</body>
</html>
