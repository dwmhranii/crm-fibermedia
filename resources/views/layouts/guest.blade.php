<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        @php
            $siteName = \App\Models\SiteSetting::where('key', 'site_name')->value('value') ?: 'FibermediaPlay';
            $faviconPath = \App\Models\SiteSetting::where('key', 'favicon')->value('value');
            $faviconUrl = $faviconPath && file_exists(public_path('storage/'.$faviconPath))
                ? asset('storage/'.$faviconPath)
                : asset('favicon.ico');
        @endphp

        <title>{{ $siteName }} - Masuk Portal</title>
        <link rel="icon" href="{{ $faviconUrl }}">

        <!-- Fonts: Plus Jakarta Sans -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet" />

        <!-- Bootstrap Icons -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

        <!-- Scripts -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            <script src="https://cdn.tailwindcss.com"></script>
            <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
        @endif

        <style>
            * {
                font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            }
            .fiber-bg {
                background-color: #060e1a;
                background-image:
                    radial-gradient(circle at 15% 15%, rgba(30, 95, 168, 0.28) 0%, transparent 45%),
                    radial-gradient(circle at 85% 85%, rgba(56, 189, 248, 0.18) 0%, transparent 50%),
                    radial-gradient(rgba(56, 189, 248, 0.08) 1.2px, transparent 1.2px);
                background-size: 100% 100%, 100% 100%, 28px 28px;
            }
            .fiber-ambient-1 {
                position: absolute;
                top: -120px;
                left: -80px;
                width: 480px;
                height: 480px;
                background: radial-gradient(circle, rgba(30, 95, 168, 0.32) 0%, transparent 70%);
                filter: blur(80px);
                pointer-events: none;
            }
            .fiber-ambient-2 {
                position: absolute;
                bottom: -120px;
                right: -80px;
                width: 520px;
                height: 520px;
                background: radial-gradient(circle, rgba(14, 165, 233, 0.22) 0%, transparent 70%);
                filter: blur(90px);
                pointer-events: none;
            }
        </style>
    </head>
    <body class="fiber-bg min-h-screen text-slate-800 antialiased flex flex-col justify-between relative overflow-x-hidden selection:bg-[#1E5FA8] selection:text-white">
        <!-- Ambient Glowing Lights -->
        <div class="fiber-ambient-1"></div>
        <div class="fiber-ambient-2"></div>

        <!-- Header Bar -->
        <header class="relative z-10 w-full max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-2 group transition-transform hover:scale-105">
                <x-application-logo class="h-10 w-auto" />
            </a>

            <a href="{{ route('home') }}" class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full text-xs font-semibold text-slate-300 bg-white/5 hover:bg-white/10 hover:text-white border border-white/10 transition backdrop-blur">
                <i class="bi bi-arrow-left"></i>
                <span>Kembali ke Website</span>
            </a>
        </header>

        <!-- Main Content Slot -->
        <main class="relative z-10 flex-grow flex items-center justify-center p-4 sm:p-6 lg:p-8">
            {{ $slot }}
        </main>

        <!-- Footer -->
        <footer class="relative z-10 py-4 text-center text-xs text-slate-400">
            <p>&copy; {{ date('Y') }} {{ $siteName }} &bull; PT Fibermedia Linktel Akses Indonesia. All rights reserved.</p>
        </footer>
    </body>
</html>
