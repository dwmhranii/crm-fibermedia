{{-- resources/views/layouts/public.blade.php --}}
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">

    @php
        // safety supaya tidak error kalau belum ke-pass
        $settings = $settings ?? [];

        // site name (judul)
        $siteName = $siteName ?? ($settings['site_name'] ?? 'FibermediaPlay');

        // helper: bikin URL gambar dari path settings
        $imgUrl = function (?string $path) {
            if (!$path) return null;
            if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) return $path;
            if (str_starts_with($path, 'storage/')) return asset($path);
            return asset('storage/'.$path);
        };

        // favicon dari CMS settings: key = 'favicon'
        $faviconPath = $faviconPath ?? ($settings['favicon'] ?? null);

        // fallback: kalau belum ada setting favicon, pakai favicon.ico di public/
        $faviconUrl = $faviconPath ? $imgUrl($faviconPath) : asset('favicon.ico');

        // cache-busting biar browser gak nahan favicon lama
        $faviconVer = $faviconPath ? md5($faviconPath) : '1';
    @endphp

    <title>{{ $siteName }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- FAVICON (CMS) --}}
    <link rel="icon" href="{{ $faviconUrl }}?v={{ $faviconVer }}">
    <link rel="shortcut icon" href="{{ $faviconUrl }}?v={{ $faviconVer }}">

    {{-- Bootstrap CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Bootstrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    @stack('styles')

    <style>
        /* DARK MODE BASE */
        body.dark-mode { background-color:#0b1020; color:#f5f5f5; }
        body.dark-mode .navbar { background-color:#111827 !important; border-bottom:1px solid #1f2937; }
        body.dark-mode .navbar .nav-link { color:#e5e7eb !important; }
        body.dark-mode .navbar .nav-link.active { color:#38bdf8 !important; }
        body.dark-mode .navbar-brand { color:#ffffff !important; }
        body.dark-mode .card, body.dark-mode .list-group-item { background-color:#111827; color:#e5e7eb; border-color:#1f2937; }
        body.dark-mode .form-control { background-color:#020617; color:#e5e7eb; border-color:#1f2937; }
        body.dark-mode .form-control::placeholder { color:#6b7280; }
        body.dark-mode footer { background-color:#020617; border-top-color:#1f2937; color:#9ca3af; }
        body.dark-mode #coverageList .list-group-item:hover { background-color:#1f2937; }

        /* FOOTER STYLE */
        .site-footer { margin-top:4rem; border-top:1px solid #e5e7eb; background-color:#f9fafb; font-size:.9rem; }
        .site-footer-top { padding:3rem 0 2rem; }
        .footer-logo-main { height:42px; margin-bottom:1rem; }
        .footer-desc { color:#6b7280; max-width:320px; }
        .footer-heading { font-size:.9rem; letter-spacing:.08em; text-transform:uppercase; font-weight:700; color:#4b5563; margin-bottom:.8rem; }
        .footer-link { display:block; color:#4b5563; text-decoration:none; padding:.18rem 0; }
        .footer-link:hover { color:#2563eb; }
        .footer-social { display:flex; gap:.5rem; margin-top:.75rem; }
        .footer-social-icon { width:34px; height:34px; border-radius:999px; display:inline-flex; align-items:center; justify-content:center; background-color:#ffffff; border:1px solid #e5e7eb; color:#4b5563; font-size:1.1rem; transition:.15s; }
        .footer-social-icon:hover { background:linear-gradient(135deg,#4f46e5,#3b82f6); color:#ffffff; transform:translateY(-2px); box-shadow:0 10px 20px rgba(37,99,235,.35); }
        .footer-logos img { max-height:40px; width:auto; }
        .footer-logos img + img { margin-left:1rem; }
        .footer-bottom { border-top:1px solid #e5e7eb; padding:.9rem 0; font-size:.8rem; color:#6b7280; }
        .footer-text-small { font-size:.8rem; color:#6b7280; }

        /* DARK MODE FOOTER */
        body.dark-mode .site-footer { background-color:#020617; border-top-color:#1f2937; }
        body.dark-mode .footer-bottom { border-top-color:#1f2937; color:#9ca3af; }
        body.dark-mode .footer-heading { color:#e5e7eb; }
        body.dark-mode .footer-desc, body.dark-mode .footer-link, body.dark-mode .footer-text-small { color:#9ca3af; }
        body.dark-mode .footer-link:hover { color:#bfdbfe; }
        body.dark-mode .footer-social-icon { background-color:#020617; border-color:#1f2937; color:#e5e7eb; }
        body.dark-mode .footer-social-icon:hover { background:linear-gradient(135deg,#4f46e5,#3b82f6); color:#ffffff; box-shadow:0 10px 25px rgba(0,0,0,.9); }
    </style>
</head>

@php
    // logo dari DB (path di storage/app/public/..)
    $logoPath = $settings['logo'] ?? null;
    $logoUrl  = $logoPath ? $imgUrl($logoPath) : asset('assets/logo.png');

    // whatsapp dari DB
    $wa = $settings['contact_whatsapp'] ?? '6281234567890';
    $wa = preg_replace('/\D+/', '', $wa);

    // site title (dipakai alt, footer)
    $siteTitle = ($settings['site_name'] ?? null) ?: 'FibermediaPlay';

    // social settings (optional kalau nanti mau)
    $igUrl = $settings['instagram_url'] ?? 'https://www.instagram.com/fibermediaplay?igsh=aHpua3VkY3Riem1m';
    $ttUrl = $settings['tiktok_url'] ?? 'https://www.tiktok.com/@fibermediaplay?_r=1&_t=ZS-91vi4vu7IRQ';

    // ===== LEGALITAS (dari CMS Settings) =====
    $legalTitle = $settings['legal_title'] ?? 'Legalitas Penyelenggara';
    $legalDesc  = $settings['legal_description'] ?? 'PT Fibermedia Linktel Akses Indonesia sebagai penyelenggara jasa internet & jaringan data berbasis fiber optik.';

    $legalLogo1Path = $settings['legal_logo_1'] ?? null;
    $legalLogo2Path = $settings['legal_logo_2'] ?? null;

    $legalLogo1Url = $legalLogo1Path ? $imgUrl($legalLogo1Path) : $logoUrl; // fallback: pakai logo utama
    $legalLogo2Url = $legalLogo2Path ? $imgUrl($legalLogo2Path) : asset('assets/logoion.png'); // fallback: logoion.png

    $legalLogo1Alt = $settings['legal_logo_1_alt'] ?? ($siteTitle.' Networks');
    $legalLogo2Alt = $settings['legal_logo_2_alt'] ?? 'ION Partnership';
@endphp

<body class="bg-light">

    {{-- NAVBAR --}}
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
        <div class="container">

            {{-- BRAND --}}
            <a class="navbar-brand fw-bold" href="{{ route('home') }}">
                <img
                    src="{{ $logoUrl }}"
                    style="height: 50px;"
                    alt="{{ $siteTitle }}"
                >
            </a>

            {{-- TOGGLER MOBILE --}}
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>

            {{-- MENU --}}
            <div class="collapse navbar-collapse" id="mainNavbar">
                <ul class="navbar-nav ms-3 mb-2 mb-lg-0 fw-semibold">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('public.packages') ? 'active' : '' }}"
                           href="{{ route('public.packages') }}">Paket</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('public.faq') ? 'active' : '' }}"
                           href="{{ route('public.faq') }}">Bantuan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('public.profil') ? 'active' : '' }}"
                           href="{{ route('public.profil') }}">Profil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('public.coverage') ? 'active' : '' }}"
                           href="{{ route('public.coverage') }}">Coverage</a>
                    </li>
                </ul>

                {{-- KANAN --}}
                <div class="ms-auto d-flex align-items-center gap-2">

                    {{-- TOGGLE DARK MODE --}}
                    <button id="themeToggle" class="btn btn-outline-secondary btn-sm rounded-circle" type="button">
                        <i class="bi bi-moon-fill"></i>
                    </button>

                    {{-- BUTTON LANGGANAN (WA dari DB) --}}
                    <a href="{{ route('public.order.step1') }}"
                        class="btn btn-primary fw-bold px-4">
                        Langganan Sekarang
                    </a>
                </div>
            </div>
        </div>
    </nav>

    {{-- KONTEN --}}
    <main class="py-4">
        <div class="container">
            @yield('content')
        </div>
    </main>

    {{-- FOOTER --}}
    <footer class="site-footer">
        <div class="site-footer-top">
            <div class="container">
                <div class="row gy-4">

                    {{-- KOLOM 1 --}}
                    <div class="col-lg-4">
                        <img
                            src="{{ $logoUrl }}"
                            alt="{{ $siteTitle }}"
                            class="footer-logo-main"
                        >

                        <p class="footer-desc">
                            PT Fibermedia Linktel Akses Indonesia adalah ISP provider fiber optik
                            yang menghadirkan koneksi internet stabil dan berkualitas untuk rumah,
                            bisnis, dan perusahaan.
                        </p>

                        <div class="mt-3">
                            <div class="footer-heading">Ikuti Kami</div>
                            <div class="footer-social">
                                <a href="{{ $igUrl }}"
                                   target="_blank"
                                   class="footer-social-icon"
                                   aria-label="Instagram {{ $siteTitle }}">
                                    <i class="bi bi-instagram"></i>
                                </a>

                                <a href="{{ $ttUrl }}"
                                   target="_blank"
                                   class="footer-social-icon"
                                   aria-label="TikTok {{ $siteTitle }}">
                                    <i class="bi bi-tiktok"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    {{-- KOLOM 2 --}}
                    <div class="col-6 col-md-3 col-lg-2">
                        <div class="footer-heading">Paket</div>
                        <a href="{{ route('public.packages') }}" class="footer-link">Internet Fiber</a>
                        <a href="{{ route('public.packages') }}" class="footer-link">Combo Fiber + TV</a>
                        <a href="{{ route('public.packages') }}" class="footer-link">Add On</a>
                        <a href="{{ route('public.packages') }}" class="footer-link">Internet Harian</a>
                        <a href="{{ route('public.packages') }}" class="footer-link">Promo</a>
                    </div>

                    {{-- KOLOM 3 --}}
                    <div class="col-6 col-md-3 col-lg-2">
                        <div class="footer-heading">Perusahaan</div>
                        <a href="{{ route('public.profil') }}" class="footer-link">Tentang Kami</a>
                    </div>

                    {{-- KOLOM 4 --}}
                    <div class="col-6 col-md-3 col-lg-2">
                        <div class="footer-heading">Bantuan</div>
                        <a href="{{ route('public.faq') }}" class="footer-link">Hubungi Kami</a>
                        <a href="{{ url('/syarat-ketentuan') }}" class="footer-link">Syarat &amp; Ketentuan</a>
                        <a href="{{ url('/kebijakan-privasi') }}" class="footer-link">Kebijakan Privasi</a>
                        <a href="{{ url('/pusat-bantuan') }}" class="footer-link">Pusat Bantuan</a>
                    </div>

                    {{-- KOLOM 5 --}}
                    <div class="col-6 col-md-3 col-lg-2">
                        <div class="footer-heading">Quick Link</div>
                        <a href="{{ route('public.coverage') }}" class="footer-link">Cek Coverage</a>
                        <a href="{{ route('public.packages') }}" class="footer-link">Harga Paket</a>
                        <a href="https://wa.me/{{ $wa }}?text=Halo%20saya%20ingin%20berlangganan%20{{ urlencode($siteTitle) }}"
                           target="_blank"
                           class="footer-link">
                            WhatsApp Sales
                        </a>
                    </div>
                </div>

                {{-- ✅ LEGALITAS (NGIKUT SETTINGS CMS) --}}
                <div class="row mt-4 gy-3">
                    <div class="col-md-6 col-lg-4">
                        <div class="footer-heading">{{ $legalTitle }}</div>

                        <p class="footer-text-small mb-2">
                            {{ $legalDesc }}
                        </p>

                        <div class="footer-logos d-flex align-items-center flex-wrap">
                            <img src="{{ $legalLogo1Url }}" alt="{{ $legalLogo1Alt }}">
                            <img src="{{ $legalLogo2Url }}" alt="{{ $legalLogo2Alt }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- FOOTER BOTTOM --}}
        <div class="footer-bottom">
            <div class="container">
                <div class="row align-items-center gy-2">
                    <div class="col-md-6 text-center text-md-start footer-text-small">
                        ©{{ date('Y') }} {{ $siteTitle }} Indonesia
                    </div>
                    <div class="col-md-6 text-center text-md-end footer-text-small">
                        Internet Service Provider Fiber Optik • PT Fibermedia Linktel Akses Indonesia
                    </div>
                </div>
            </div>
        </div>
    </footer>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    @stack('scripts')

    {{-- DARK MODE TOGGLE SCRIPT --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const body = document.body;
            const toggleBtn = document.getElementById('themeToggle');
            const savedTheme = localStorage.getItem('theme');

            if (savedTheme === 'dark') {
                body.classList.add('dark-mode');
                body.classList.remove('bg-light');
                if (toggleBtn) toggleBtn.innerHTML = '<i class="bi bi-sun-fill"></i>';
            }

            if (toggleBtn) {
                toggleBtn.addEventListener('click', function () {
                    body.classList.toggle('dark-mode');

                    if (body.classList.contains('dark-mode')) {
                        body.classList.remove('bg-light');
                        localStorage.setItem('theme', 'dark');
                        toggleBtn.innerHTML = '<i class="bi bi-sun-fill"></i>';
                    } else {
                        body.classList.add('bg-light');
                        localStorage.setItem('theme', 'light');
                        toggleBtn.innerHTML = '<i class="bi bi-moon-fill"></i>';
                    }
                });
            }
        });
    </script>
</body>
</html>