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
        body.dark-mode .card, body.dark-mode .list-group-item { background-color:#111827; color:#e5e7eb; border-color:#1f2937; }
        body.dark-mode .form-control { background-color:#020617; color:#e5e7eb; border-color:#1f2937; }
        body.dark-mode .form-control::placeholder { color:#6b7280; }
        body.dark-mode footer { background-color:#020617; border-top-color:#1f2937; color:#9ca3af; }
        body.dark-mode #coverageList .list-group-item:hover { background-color:#1f2937; }

        /* ===================== ELEGANT NAVBAR ===================== */
        .navbar {
            padding: 0.85rem 0;
            background-color: rgba(255, 255, 255, 0.96) !important;
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border-bottom: 1px solid rgba(229, 231, 235, 0.85);
            transition: all 0.25s ease;
        }

        .navbar .navbar-nav {
            display: flex;
            align-items: center;
            gap: 0.35rem;
        }

        .navbar .nav-link {
            font-size: 0.95rem;
            font-weight: 600;
            color: #334155 !important;
            padding: 0.55rem 0.85rem !important;
            border-radius: 12px;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            letter-spacing: -0.01em;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
        }

        .navbar .nav-link:hover {
            color: #1E5FA8 !important;
            background-color: rgba(30, 95, 168, 0.07);
        }

        .navbar .nav-link.active {
            color: #1E5FA8 !important;
            font-weight: 700;
            background-color: rgba(30, 95, 168, 0.09);
        }

        .navbar .dropdown-toggle::after {
            display: none !important;
        }

        .nav-chevron {
            font-size: 0.68rem;
            transition: transform 0.25s ease, opacity 0.2s ease;
            opacity: 0.75;
            margin-top: 1px;
        }

        .nav-item.dropdown:hover .nav-chevron,
        .nav-link[aria-expanded="true"] .nav-chevron {
            transform: rotate(180deg);
            opacity: 1;
        }

        /* CUSTOM ANIMATED HAMBURGER TOGGLER */
        .navbar-toggler {
            border: 1px solid rgba(30, 95, 168, 0.18) !important;
            background: rgba(30, 95, 168, 0.05);
            border-radius: 12px;
            width: 44px;
            height: 44px;
            padding: 0;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            gap: 4.5px;
            box-shadow: none !important;
            outline: none !important;
            transition: all 0.25s ease;
        }

        .navbar-toggler:hover {
            background: rgba(30, 95, 168, 0.1);
            border-color: rgba(30, 95, 168, 0.35) !important;
        }

        .navbar-toggler .toggler-icon {
            display: block;
            width: 20px;
            height: 2.2px;
            background-color: #1E5FA8;
            border-radius: 3px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            transform-origin: center;
        }

        /* Toggler Animation to X on expanded */
        .navbar-toggler[aria-expanded="true"] .top-bar {
            transform: translateY(6.7px) rotate(45deg);
        }

        .navbar-toggler[aria-expanded="true"] .middle-bar {
            opacity: 0;
            transform: scaleX(0);
        }

        .navbar-toggler[aria-expanded="true"] .bottom-bar {
            transform: translateY(-6.7px) rotate(-45deg);
        }

        /* DESKTOP NAVBAR STYLES */
        @media (min-width: 992px) {
            .navbar .navbar-nav {
                gap: 1.25rem;
            }

            .navbar .nav-item.dropdown:hover .dropdown-menu {
                display: block;
                margin-top: 0;
            }

            .navbar .dropdown-menu {
                border: 1px solid rgba(229, 231, 235, 0.9);
                border-radius: 18px;
                padding: 0.6rem;
                box-shadow: 0 20px 45px rgba(15, 23, 42, 0.12);
                background: rgba(255, 255, 255, 0.98);
                backdrop-filter: blur(16px);
                -webkit-backdrop-filter: blur(16px);
                min-width: 230px;
                margin-top: 0.5rem;
                animation: navDropdownFade 0.2s ease forwards;
            }

            @keyframes navDropdownFade {
                from { opacity: 0; transform: translateY(6px); }
                to { opacity: 1; transform: translateY(0); }
            }

            .navbar-action-box {
                margin-left: auto;
                display: flex;
                align-items: center;
                gap: 0.75rem;
            }

            .navbar-action-box .btn-cta {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                padding: 0.55rem 1.4rem;
                border-radius: 12px;
                font-weight: 700;
                font-size: 0.92rem;
                background: linear-gradient(135deg, #1E5FA8 0%, #2563eb 100%);
                border: none;
                color: #ffffff !important;
                text-decoration: none;
                box-shadow: 0 4px 14px rgba(30, 95, 168, 0.25);
                transition: all 0.2s ease;
            }

            .navbar-action-box .btn-cta:hover {
                transform: translateY(-1px);
                box-shadow: 0 6px 20px rgba(30, 95, 168, 0.38);
            }

            .navbar-action-box .theme-toggle-btn {
                width: 40px;
                height: 40px;
                border-radius: 11px;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                border: 1px solid #e2e8f0;
                background: #f8fafc;
                color: #64748b;
                transition: all 0.2s ease;
            }

            .navbar-action-box .theme-toggle-btn:hover {
                background: #e2e8f0;
                color: #1e293b;
            }
        }

        /* MOBILE NAVBAR STYLES (UNDER 992px) */
        @media (max-width: 991.98px) {
            .navbar .navbar-collapse {
                background: rgba(255, 255, 255, 0.98);
                backdrop-filter: blur(20px);
                -webkit-backdrop-filter: blur(20px);
                border: 1px solid rgba(226, 232, 240, 0.95);
                border-radius: 20px;
                padding: 1.15rem;
                margin-top: 0.9rem;
                box-shadow: 0 20px 45px -10px rgba(15, 23, 42, 0.15), 0 4px 16px rgba(0, 0, 0, 0.04);
                max-height: 80vh;
                overflow-y: auto;
            }

            .navbar .navbar-nav {
                display: flex;
                flex-direction: column;
                align-items: stretch !important;
                width: 100%;
                gap: 0.35rem;
            }

            .navbar .nav-link {
                display: flex;
                align-items: center;
                justify-content: space-between;
                width: 100%;
                padding: 0.75rem 1rem !important;
                border-radius: 12px;
                font-size: 0.96rem;
            }

            .navbar .dropdown-menu {
                position: static !important;
                float: none !important;
                box-shadow: none !important;
                background: rgba(241, 245, 249, 0.7) !important;
                border: 1px solid rgba(226, 232, 240, 0.8) !important;
                border-radius: 14px !important;
                margin: 0.4rem 0 0.6rem 0 !important;
                padding: 0.45rem !important;
                animation: none !important;
            }

            .navbar .dropdown-item {
                padding: 0.65rem 0.95rem !important;
                border-radius: 10px;
                font-size: 0.9rem;
            }

            .navbar-action-box {
                margin-top: 0.9rem !important;
                padding-top: 0.9rem !important;
                border-top: 1px solid rgba(226, 232, 240, 0.85);
                display: flex;
                align-items: center;
                gap: 0.75rem;
                width: 100%;
            }

            .navbar-action-box .btn-cta {
                flex: 1;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                height: 46px;
                border-radius: 12px;
                font-size: 0.95rem;
                font-weight: 700;
                background: linear-gradient(135deg, #1E5FA8 0%, #2563eb 100%);
                border: none;
                box-shadow: 0 4px 14px rgba(30, 95, 168, 0.3);
                color: #ffffff !important;
                text-decoration: none;
            }

            .navbar-action-box .theme-toggle-btn {
                width: 46px;
                height: 46px;
                border-radius: 12px !important;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                font-size: 1.15rem;
                flex-shrink: 0;
                background: #f1f5f9;
                border: 1px solid #e2e8f0;
                color: #475569;
            }
        }

        /* DROPDOWN ITEMS GENERAL */
        .navbar .dropdown-item {
            font-size: 0.9rem;
            font-weight: 500;
            color: #334155;
            padding: 0.55rem 0.9rem;
            border-radius: 10px;
            display: flex;
            align-items: center;
            gap: 0.65rem;
            transition: all 0.15s ease;
        }

        .navbar .dropdown-item:hover {
            color: #1E5FA8;
            background-color: rgba(30, 95, 168, 0.08);
            transform: translateX(3px);
        }

        .navbar .dropdown-item i {
            font-size: 1rem;
            color: #1E5FA8;
        }

        /* DARK MODE NAVBAR OVERRIDES */
        body.dark-mode .navbar {
            background-color: rgba(11, 16, 32, 0.95) !important;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }

        body.dark-mode .navbar-brand { color: #ffffff !important; }

        body.dark-mode .navbar-toggler {
            background: rgba(255, 255, 255, 0.06);
            border-color: rgba(255, 255, 255, 0.14) !important;
        }

        body.dark-mode .navbar-toggler:hover {
            background: rgba(255, 255, 255, 0.12);
        }

        body.dark-mode .navbar-toggler .toggler-icon {
            background-color: #38bdf8;
        }

        body.dark-mode .navbar .nav-link {
            color: #f1f5f9 !important;
        }

        body.dark-mode .navbar .nav-link:hover {
            color: #38bdf8 !important;
            background-color: rgba(56, 189, 248, 0.12);
        }

        body.dark-mode .navbar .nav-link.active {
            color: #38bdf8 !important;
            background-color: rgba(56, 189, 248, 0.15);
        }

        body.dark-mode .navbar .dropdown-menu {
            background: rgba(17, 24, 39, 0.98) !important;
            border-color: rgba(255, 255, 255, 0.1) !important;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.85);
        }

        @media (max-width: 991.98px) {
            body.dark-mode .navbar .navbar-collapse {
                background: rgba(15, 23, 42, 0.98);
                border-color: rgba(255, 255, 255, 0.12);
                box-shadow: 0 24px 55px -10px rgba(0, 0, 0, 0.75);
            }

            body.dark-mode .navbar .dropdown-menu {
                background: rgba(2, 6, 23, 0.65) !important;
                border-color: rgba(255, 255, 255, 0.08) !important;
            }

            body.dark-mode .navbar-action-box {
                border-top-color: rgba(255, 255, 255, 0.08);
            }

            body.dark-mode .navbar-action-box .theme-toggle-btn {
                background: #1e293b;
                border-color: rgba(255, 255, 255, 0.12);
                color: #fbbf24;
            }
        }

        body.dark-mode .navbar-action-box .theme-toggle-btn {
            background: #1e293b;
            border-color: rgba(255, 255, 255, 0.12);
            color: #fbbf24;
        }

        body.dark-mode .navbar-action-box .theme-toggle-btn:hover {
            background: #334155;
        }

        body.dark-mode .navbar .dropdown-item {
            color: #e2e8f0;
        }

        body.dark-mode .navbar .dropdown-item:hover {
            color: #38bdf8;
            background-color: rgba(56, 189, 248, 0.12);
        }

        body.dark-mode .navbar .dropdown-item i {
            color: #38bdf8;
        }

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
            <button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="toggler-icon top-bar"></span>
                <span class="toggler-icon middle-bar"></span>
                <span class="toggler-icon bottom-bar"></span>
            </button>

            {{-- MENU --}}
            <div class="collapse navbar-collapse" id="mainNavbar">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}"
                           href="{{ route('home') }}">Beranda</a>
                    </li>

                    {{-- PROFIL DROPDOWN --}}
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle {{ request()->routeIs('public.profil') ? 'active' : '' }}"
                           href="{{ route('public.profil') }}"
                           id="profilDropdown"
                           role="button"
                           data-bs-toggle="dropdown"
                           aria-expanded="false">
                            Profil <i class="bi bi-chevron-down nav-chevron"></i>
                        </a>
                        <ul class="dropdown-menu shadow-lg" aria-labelledby="profilDropdown">
                            <li>
                                <a class="dropdown-item" href="{{ route('public.profil') }}">
                                    <i class="bi bi-building"></i> Tentang Kami
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('public.profil') }}#visimisi">
                                    <i class="bi bi-bullseye"></i> Visi &amp; Misi
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('public.profil') }}#legalitas">
                                    <i class="bi bi-shield-check"></i> Legalitas
                                </a>
                            </li>
                        </ul>
                    </li>

                    {{-- LAYANAN / PAKET DROPDOWN --}}
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle {{ request()->routeIs('public.packages*', 'public.addons*', 'public.simulation*') ? 'active' : '' }}"
                           href="{{ route('public.packages') }}"
                           id="layananDropdown"
                           role="button"
                           data-bs-toggle="dropdown"
                           aria-expanded="false">
                            Layanan <i class="bi bi-chevron-down nav-chevron"></i>
                        </a>
                        <ul class="dropdown-menu shadow-lg" aria-labelledby="layananDropdown">
                            <li>
                                <a class="dropdown-item" href="{{ route('public.packages') }}">
                                    <i class="bi bi-wifi"></i> Paket Internet
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('public.addons') }}">
                                    <i class="bi bi-plus-circle"></i> Add-on Tambahan
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item {{ request()->routeIs('public.simulation') ? 'active' : '' }}" href="{{ route('public.simulation') }}">
                                    <i class="bi bi-calculator"></i> Simulasi Biaya
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('home') }}#rekomendasi">
                                    <i class="bi bi-magic"></i> Rekomendasi Paket
                                </a>
                            </li>
                        </ul>
                    </li>

                    {{-- WILAYAH --}}
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('public.coverage') ? 'active' : '' }}"
                           href="{{ route('public.coverage') }}">Wilayah</a>
                    </li>

                    {{-- BANTUAN DROPDOWN --}}
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle {{ request()->routeIs('public.faq') ? 'active' : '' }}"
                           href="{{ route('public.faq') }}"
                           id="bantuanDropdown"
                           role="button"
                           data-bs-toggle="dropdown"
                           aria-expanded="false">
                            Bantuan <i class="bi bi-chevron-down nav-chevron"></i>
                        </a>
                        <ul class="dropdown-menu shadow-lg" aria-labelledby="bantuanDropdown">
                            <li>
                                <a class="dropdown-item" href="{{ route('public.faq') }}">
                                    <i class="bi bi-question-circle"></i> FAQ
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="https://wa.me/{{ $wa }}?text=Halo%20CS%20FibermediaPlay" target="_blank">
                                    <i class="bi bi-headset"></i> Kontak CS / WhatsApp
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>

                {{-- KANAN --}}
                <div class="navbar-action-box">
                    {{-- TOGGLE DARK MODE --}}
                    <button id="themeToggle" class="theme-toggle-btn" type="button" aria-label="Toggle theme">
                        <i class="bi bi-moon-fill"></i>
                    </button>

                    {{-- BUTTON LANGGANAN --}}
                    <a href="{{ route('public.order.step1') }}" class="btn-cta">
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
                        <a href="{{ route('public.coverage') }}" class="footer-link">Cek Wilayah</a>
                        <a href="{{ route('public.packages') }}" class="footer-link">Harga Paket</a>
                        <a href="{{ route('public.simulation') }}" class="footer-link">Simulasi Biaya</a>
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