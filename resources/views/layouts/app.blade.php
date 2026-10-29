<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Atara Glamping - Pengalaman menginap mewah di dataran tinggi dengan panorama pegunungan dan sewa perlengkapan camping lengkap.">
    <title>@yield('title', 'Atara Glamping | Refined Alpine Sanctuary & Camping Retreat')</title>

    <!-- Google Fonts: Plus Jakarta Sans (Geometric Sans), Newsreader (Classical Serif), JetBrains Mono (Precision Mono) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;700&family=Newsreader:ital,opsz,wght@0,6..72,300;0,6..72,400;0,6..72,500;1,6..72,300;1,6..72,400&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#F9F7F5] text-[#1D1D1C] font-sans antialiased selection:bg-[#1D1D1C] selection:text-white min-h-screen flex flex-col">

    <!-- Header Navigation -->
    @include('partials.navbar')

    <!-- Main Content -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Footer -->
    @include('partials.footer')

    @stack('scripts')
</body>
</html>
