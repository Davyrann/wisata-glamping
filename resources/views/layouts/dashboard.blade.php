<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#161816">
    <title>{{ $title ?? 'Dashboard' }} | Atara Glamping</title>
    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:wght@500;600&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-paper text-text font-sans antialiased">
    <div class="min-h-screen lg:flex">
        <!-- Sidebar Desktop & Tablet -->
        <aside class="hidden sm:flex sm:w-16 lg:w-63 shrink-0 flex-col bg-ink-900 text-text-on-ink min-h-screen sticky top-0 h-screen">
            <a href="{{ route('home') }}" class="flex items-center justify-center lg:justify-start gap-3 px-3 lg:px-6 h-20 border-b border-white/10" aria-label="Atara Glamping, kembali ke beranda">
                <img src="{{ asset('images/logo/atara-logo-mark.svg') }}" alt="" class="h-9 w-9 object-contain bg-white rounded-sm p-1">
                <span class="hidden lg:block text-xl tracking-[0.2em] font-semibold">ATARA</span>
            </a>

            <nav class="px-2 lg:px-3 py-6 space-y-1" aria-label="Navigasi dashboard">
                @if (auth()->user()?->role === 'staff')
                    <a href="{{ route('staff.dashboard') }}"
                       class="flex items-center justify-center lg:justify-start gap-3 min-h-11 px-3 rounded-md text-sm {{ request()->routeIs('staff.dashboard') ? 'bg-ink-800 border-l-2 border-ember-600 text-white font-semibold' : 'text-text-on-ink/80 hover:bg-ink-800' }}">
                        <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" aria-hidden="true"><rect x="3" y="3" width="8" height="8" rx="1"/><rect x="13" y="3" width="8" height="8" rx="1"/><rect x="3" y="13" width="8" height="8" rx="1"/><rect x="13" y="13" width="8" height="8" rx="1"/></svg>
                        <span class="hidden lg:block">Operasional Staff</span>
                    </a>
                @elseif (auth()->user()?->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}"
                       class="flex items-center justify-center lg:justify-start gap-3 min-h-11 px-3 rounded-md text-sm {{ request()->routeIs('admin.dashboard') ? 'bg-ink-800 border-l-2 border-ember-600 text-white font-semibold' : 'text-text-on-ink/80 hover:bg-ink-800' }}">
                        <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" aria-hidden="true"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
                        <span class="hidden lg:block">Panel Admin</span>
                    </a>
                @else
                    {{-- Navigasi Pengguna Tamu (User) --}}
                    <a href="{{ route('dashboard') }}"
                       class="flex items-center justify-center lg:justify-start gap-3 min-h-11 px-3 rounded-md text-sm {{ request()->routeIs('dashboard') ? 'bg-ink-800 border-l-2 border-ember-600 text-white font-semibold' : 'text-text-on-ink/80 hover:bg-ink-800' }}">
                        <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" aria-hidden="true"><rect x="3" y="3" width="8" height="8" rx="1"/><rect x="13" y="3" width="8" height="8" rx="1"/><rect x="3" y="13" width="8" height="8" rx="1"/><rect x="13" y="13" width="8" height="8" rx="1"/></svg>
                        <span class="hidden lg:block">Ringkasan</span>
                    </a>
                    <a href="{{ route('dashboard.rooms') }}"
                       class="flex items-center justify-center lg:justify-start gap-3 min-h-11 px-3 rounded-md text-sm {{ request()->routeIs('dashboard.rooms') ? 'bg-ink-800 border-l-2 border-ember-600 text-white font-semibold' : 'text-text-on-ink/80 hover:bg-ink-800' }}">
                        <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" aria-hidden="true"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                        <span class="hidden lg:block">Katalog Kamar</span>
                    </a>
                    <a href="{{ route('dashboard.bookings') }}"
                       class="flex items-center justify-center lg:justify-start gap-3 min-h-11 px-3 rounded-md text-sm {{ request()->routeIs('dashboard.bookings*') ? 'bg-ink-800 border-l-2 border-ember-600 text-white font-semibold' : 'text-text-on-ink/80 hover:bg-ink-800' }}">
                        <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" aria-hidden="true"><rect x="4" y="5" width="16" height="14" rx="2"/><path d="M8 9h8M8 13h6"/></svg>
                        <span class="hidden lg:block">Pesanan Saya</span>
                    </a>
                    <a href="{{ route('dashboard.cards') }}"
                       class="flex items-center justify-center lg:justify-start gap-3 min-h-11 px-3 rounded-md text-sm {{ request()->routeIs('dashboard.cards') ? 'bg-ink-800 border-l-2 border-ember-600 text-white font-semibold' : 'text-text-on-ink/80 hover:bg-ink-800' }}">
                        <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" aria-hidden="true"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="M7 9h4v4H7zM14 9h3M14 13h3"/></svg>
                        <span class="hidden lg:block">Kartu Digital</span>
                    </a>
                    <a href="{{ route('dashboard.payments') }}"
                       class="flex items-center justify-center lg:justify-start gap-3 min-h-11 px-3 rounded-md text-sm {{ request()->routeIs('dashboard.payments') ? 'bg-ink-800 border-l-2 border-ember-600 text-white font-semibold' : 'text-text-on-ink/80 hover:bg-ink-800' }}">
                        <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" aria-hidden="true"><rect x="2" y="5" width="20" height="14" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/></svg>
                        <span class="hidden lg:block">Pembayaran</span>
                    </a>
                    <a href="{{ route('dashboard.profile') }}"
                       class="flex items-center justify-center lg:justify-start gap-3 min-h-11 px-3 rounded-md text-sm {{ request()->routeIs('dashboard.profile') ? 'bg-ink-800 border-l-2 border-ember-600 text-white font-semibold' : 'text-text-on-ink/80 hover:bg-ink-800' }}">
                        <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" aria-hidden="true"><circle cx="12" cy="8" r="4"/><path d="M4 21c0-5 16-5 16 0"/></svg>
                        <span class="hidden lg:block">Profil & Keamanan</span>
                    </a>
                @endif
            </nav>

            <div class="mt-auto border-t border-white/10 px-3 lg:px-5 py-5">
                <div class="hidden lg:block mb-3">
                    <p class="font-semibold text-sm truncate">{{ auth()->user()?->name }}</p>
                    <p class="text-xs text-text-on-ink/60 truncate">{{ auth()->user()?->email }}</p>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full min-h-10 px-2 lg:px-3 text-xs lg:text-sm border border-white/20 rounded-md hover:bg-ink-800 focus-visible:outline-2 focus-visible:outline-white font-medium" aria-label="Keluar dari akun">Keluar</button>
                </form>
            </div>
        </aside>

        <!-- Main Content Area -->
        <div class="flex-1 min-w-0">
            <header class="sticky top-0 z-20 h-20 bg-paper/95 backdrop-blur-sm border-b border-line flex items-center justify-between gap-3 px-5 sm:px-7 lg:px-9">
                <div class="min-w-0">
                    <p class="text-xs text-text-muted">{{ $subtitle ?? 'Area Tamu Atara' }}</p>
                    <p class="text-sm font-semibold truncate">Halo, {{ auth()->user()?->name }}</p>
                </div>
                <div class="flex items-center gap-2">
                    @if (auth()->user()?->role === 'user')
                        <a href="{{ route('dashboard.rooms') }}" class="inline-flex items-center justify-center rounded-md bg-pine-700 hover:bg-pine-600 text-white text-xs sm:text-sm font-semibold px-3 sm:px-4 min-h-10 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-pine-700">Katalog Kamar</a>
                    @endif
                </div>
            </header>

            <main class="max-w-280 mx-auto px-5 sm:px-7 lg:px-9 py-8 pb-28 sm:pb-10">
                @if (session('status'))
                    <div role="status" class="mb-5 rounded-md border border-line bg-surface px-4 py-3 text-sm text-pine-700 font-medium">
                        {{ session('status') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div role="alert" class="mb-5 rounded-md border border-line bg-surface px-4 py-3 text-sm text-red-700 font-medium">
                        {{ $errors->first() }}
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <!-- Mobile Bottom Navigation (User Role Only) -->
    @if (auth()->user()?->role === 'user')
        <nav class="sm:hidden fixed bottom-0 inset-x-0 bg-ink-900 text-text-on-ink border-t border-white/10 flex justify-around items-center px-1 pt-1 pb-[max(0.5rem,env(safe-area-inset-bottom))] z-30" aria-label="Navigasi seluler">
            <a href="{{ route('dashboard') }}" class="flex-1 text-center text-xs py-2 min-h-11 flex flex-col items-center justify-center {{ request()->routeIs('dashboard') ? 'text-white font-semibold border-t-2 border-ember-600' : 'text-text-on-ink/80' }}">
                <span>Ringkasan</span>
            </a>
            <a href="{{ route('dashboard.rooms') }}" class="flex-1 text-center text-xs py-2 min-h-11 flex flex-col items-center justify-center {{ request()->routeIs('dashboard.rooms') ? 'text-white font-semibold border-t-2 border-ember-600' : 'text-text-on-ink/80' }}">
                <span>Kamar</span>
            </a>
            <a href="{{ route('dashboard.bookings') }}" class="flex-1 text-center text-xs py-2 min-h-11 flex flex-col items-center justify-center {{ request()->routeIs('dashboard.bookings*') ? 'text-white font-semibold border-t-2 border-ember-600' : 'text-text-on-ink/80' }}">
                <span>Pesanan</span>
            </a>
            <a href="{{ route('dashboard.cards') }}" class="flex-1 text-center text-xs py-2 min-h-11 flex flex-col items-center justify-center {{ request()->routeIs('dashboard.cards') ? 'text-white font-semibold border-t-2 border-ember-600' : 'text-text-on-ink/80' }}">
                <span>Kartu QR</span>
            </a>
            <a href="{{ route('dashboard.profile') }}" class="flex-1 text-center text-xs py-2 min-h-11 flex flex-col items-center justify-center {{ request()->routeIs('dashboard.profile') ? 'text-white font-semibold border-t-2 border-ember-600' : 'text-text-on-ink/80' }}">
                <span>Akun</span>
            </a>
        </nav>
    @endif

    <script>
        document.querySelectorAll('[data-copy-code]').forEach((button) => {
            button.addEventListener('click', async () => {
                try {
                    await navigator.clipboard.writeText(button.dataset.copyCode);
                    button.textContent = 'Tersalin';
                } catch (error) {
                    button.textContent = 'Salin manual dari kartu';
                }
            });
        });
    </script>
    @stack('scripts')
</body>
</html>
