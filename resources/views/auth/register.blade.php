<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Daftar akun tamu Atara Glamping untuk memesan unit glamping, memantau status reservasi, dan mengakses kartu digital QR.">
    <title>Daftar Akun Tamu | Atara Glamping</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <meta name="theme-color" content="#161816">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,500;9..144,600;9..144,700&family=JetBrains+Mono:wght@400;500;600&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full bg-paper text-text font-sans antialiased selection:bg-pine-700 selection:text-white">
    <div class="min-h-screen flex flex-col lg:flex-row lg:h-screen lg:overflow-hidden">
        <div class="relative w-full lg:w-5/12 h-40 lg:h-full bg-ink-900 shrink-0 overflow-hidden">
            <img src="{{ asset('images/Camp_with_chair.jpg') }}" alt="Suasana tenda glamping Atara di kawasan hutan pinus" class="w-full h-full object-cover object-center opacity-90 lg:opacity-85" loading="eager">
            <div class="absolute inset-0 bg-linear-to-t from-ink-950/80 via-ink-900/30 to-ink-950/60 lg:to-transparent pointer-events-none"></div>
            <div class="absolute top-4 left-4 lg:top-8 lg:left-8 z-10">
                <a href="{{ route('home') }}" class="inline-flex items-center gap-2.5 px-3 py-1.5 rounded-md bg-ink-900/80 backdrop-blur-sm text-text-on-ink text-xs font-mono uppercase tracking-wider hover:bg-ink-900 hover:text-white transition-colors border border-white/10">
                    <span>&larr; Beranda</span>
                </a>
            </div>
            <div class="absolute bottom-4 left-4 lg:bottom-8 lg:left-8 right-4 z-10">
                <p class="font-mono text-xs uppercase tracking-[0.2em] text-text-on-ink/90 flex items-center gap-2">
                    <span class="inline-block w-2 h-2 rounded-full bg-ember-600 shrink-0" aria-hidden="true"></span>
                    <span>Registrasi Tamu · Atara Glamping</span>
                </p>
            </div>
        </div>

        <main class="w-full lg:w-7/12 flex-1 flex justify-center px-6 py-8 sm:px-10 lg:px-12 lg:py-10 overflow-y-auto">
            <div class="w-full max-w-[400px] my-auto">
                <div class="mb-6">
                    <div class="flex items-center gap-3 mb-4">
                        <img src="{{ asset('images/logo/atara-logo-mark.svg') }}" alt="Logo Atara Glamping" class="h-9 w-auto object-contain shrink-0">
                        <span class="font-mono text-xs uppercase tracking-[0.25em] text-text-muted font-semibold">Atara Glamping</span>
                    </div>
                    <h1 class="font-display text-2xl sm:text-3xl font-semibold text-text tracking-tight leading-tight">Daftar Akun Tamu</h1>
                    <p class="text-sm text-text-muted mt-1.5 leading-relaxed">Buat akun untuk memesan kamar glamping dan memantau reservasi Anda.</p>
                </div>

                @php $input = 'w-full h-11 px-3.5 bg-surface text-text text-sm rounded-[6px] border border-line-strong focus:border-pine-700 focus:outline-none focus:ring-2 focus:ring-pine-700 focus:ring-offset-1 focus:ring-offset-paper placeholder:text-text-faint transition-colors'; @endphp

                <form method="POST" action="{{ route('register.store') }}" class="space-y-4">
                    @csrf
                    <div>
                        <label for="name" class="block text-sm font-medium text-text mb-1.5">Nama Lengkap</label>
                        <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" placeholder="Nama lengkap Anda" class="{{ $input }}">
                        @error('name') <p class="mt-1.5 text-xs text-danger font-medium" role="alert">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium text-text mb-1.5">Alamat Email</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" inputmode="email" placeholder="nama@email.com" class="{{ $input }}">
                        @error('email') <p class="mt-1.5 text-xs text-danger font-medium" role="alert">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="phone" class="block text-sm font-medium text-text mb-1.5">Nomor Telepon (opsional)</label>
                        <input id="phone" type="tel" name="phone" value="{{ old('phone') }}" autocomplete="tel" placeholder="081234567890" class="{{ $input }}">
                        @error('phone') <p class="mt-1.5 text-xs text-danger font-medium" role="alert">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="password" class="block text-sm font-medium text-text mb-1.5">Kata Sandi</label>
                        <input id="password" type="password" name="password" required minlength="8" autocomplete="new-password" placeholder="Minimal 8 karakter" class="{{ $input }}">
                        @error('password') <p class="mt-1.5 text-xs text-danger font-medium" role="alert">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-text mb-1.5">Konfirmasi Kata Sandi</label>
                        <input id="password_confirmation" type="password" name="password_confirmation" required minlength="8" autocomplete="new-password" placeholder="Ulangi kata sandi" class="{{ $input }}">
                    </div>

                    <button type="submit" class="w-full h-11 px-4 bg-pine-700 hover:bg-pine-600 text-white font-semibold text-sm rounded-[6px] tracking-wide transition-colors">
                        Buat Akun Tamu
                    </button>
                </form>

                <div class="mt-5 pt-4 border-t border-line text-center">
                    <p class="text-xs text-text-muted">
                        Sudah memiliki akun?
                        <a href="{{ route('login') }}" class="font-semibold text-pine-700 hover:underline underline-offset-4">Masuk di sini</a>
                    </p>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
