<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>
        @yield('title', 'Admin Panel') — {{ config('app.name', 'CMS') }}
    </title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script>
        (function() {
            try {
                const theme = localStorage.getItem('admin_theme');
                if (theme === 'dark' || (!theme && window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                    document.documentElement.setAttribute('data-bs-theme', 'dark');
                    document.documentElement.classList.add('dark');
                } else {
                    document.documentElement.setAttribute('data-bs-theme', 'light');
                    document.documentElement.classList.remove('dark');
                }
            } catch(e) {}
        })();
    </script>

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Bootstrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    @stack('styles')

    <style>
        :root{
            --adm-bg: #0b1220;
            --adm-card: #0f172a;
            --adm-border: #1f2937;
            --adm-text: #e5e7eb;
            --adm-muted: #9ca3af;
            --adm-brand: #2563eb;
            --adm-accent: #22c55e;
            --adm-shadow: 0 18px 55px rgba(0,0,0,.35);
            --adm-radius: 18px;
        }

        body.admin-body{
            background: #f5f7fb;
            color: #0f172a;
        }

        .adm-shell{
            min-height: 100vh;
            display: flex;
        }

        .adm-sidebar{
            width: 280px;
            background: linear-gradient(180deg, #0b1220 0%, #0b1220 60%, #08101e 100%);
            border-right: 1px solid rgba(255,255,255,.06);
            color: var(--adm-text);
            position: sticky;
            top: 0;
            height: 100vh;
            padding: 18px 14px;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .adm-brand{
            display:flex;
            align-items:center;
            gap:10px;
            padding: 10px 10px 16px;
            margin-bottom: 6px;
            border-bottom: 1px solid rgba(255,255,255,.08);
            flex: 0 0 auto;
        }

        .adm-brand .logo{
            width: 44px;
            height: 44px;
            border-radius: 14px;
            display:flex;
            align-items:center;
            justify-content:center;
            background: radial-gradient(circle at top left, rgba(255,255,255,.22), transparent 55%),
                        linear-gradient(135deg, var(--adm-brand), var(--adm-accent));
            box-shadow: 0 14px 35px rgba(37,99,235,.25);
            font-size: 1.2rem;
        }

        .adm-brand .name{
            font-weight: 800;
            letter-spacing: .02em;
            line-height: 1.15;
        }

        .adm-brand .sub{
            font-size: .78rem;
            color: rgba(229,231,235,.80);
        }

        .adm-nav-title{
            font-size: .72rem;
            letter-spacing: .16em;
            text-transform: uppercase;
            color: rgba(229,231,235,.55);
            margin: 16px 10px 8px;
        }

        .adm-link{
            display:flex;
            align-items:center;
            gap:10px;
            padding: 10px 12px;
            border-radius: 14px;
            color: rgba(229,231,235,.86);
            text-decoration:none;
            transition: background .15s, transform .15s, color .15s;
        }

        .adm-link:hover{
            background: rgba(255,255,255,.06);
            color: #fff;
            transform: translateX(2px);
        }

        .adm-link.active{
            background: linear-gradient(135deg, rgba(37,99,235,.35), rgba(34,197,94,.22));
            border: 1px solid rgba(255,255,255,.08);
            color: #fff;
        }

        .adm-link .icon{
            width: 32px;
            height: 32px;
            border-radius: 12px;
            display:flex;
            align-items:center;
            justify-content:center;
            background: rgba(255,255,255,.06);
            border: 1px solid rgba(255,255,255,.08);
        }

        .adm-link.active .icon{
            background: rgba(255,255,255,.10);
        }

        .adm-side-footer{
            margin-top: 18px;
            padding: 12px 10px;
            border-top: 1px solid rgba(255,255,255,.08);
            color: rgba(229,231,235,.72);
            font-size: .85rem;
            flex: 0 0 auto;
        }

        .adm-nav-scroll{
            flex: 1 1 auto;
            overflow-y: auto;
            overflow-x: hidden;
            padding-right: 6px;
        }

        .adm-main{
            flex: 1;
            padding: 18px;
        }

        .adm-topbar{
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: var(--adm-radius);
            box-shadow: 0 14px 40px rgba(15,23,42,.06);
            padding: 12px 14px;
            margin-bottom: 14px;
        }

        .adm-topbar .search{
            max-width: 520px;
        }

        .adm-pill{
            border-radius: 999px;
            font-weight: 700;
            font-size: .8rem;
            padding: .35rem .75rem;
        }

        .adm-card{
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: var(--adm-radius);
            box-shadow: 0 14px 40px rgba(15,23,42,.06);
        }

        .adm-content{
            border-radius: var(--adm-radius);
        }

        body.admin-body.dark,
        [data-bs-theme="dark"] body.admin-body,
        [data-bs-theme="dark"]{
            background: #050b16;
            color: var(--adm-text);
        }

        body.admin-body.dark .adm-topbar,
        body.admin-body.dark .adm-card,
        [data-bs-theme="dark"] .adm-topbar,
        [data-bs-theme="dark"] .adm-card{
            background: var(--adm-card) !important;
            border-color: var(--adm-border) !important;
            box-shadow: var(--adm-shadow);
        }

        body.admin-body.dark .text-muted,
        [data-bs-theme="dark"] .text-muted{
            color: #94a3b8 !important;
        }

        /* CARD & CONTAINERS */
        body.admin-body.dark .card,
        [data-bs-theme="dark"] .card{
            background: #0f172a !important;
            border-color: #1f2937 !important;
            color: #e5e7eb;
        }
        body.admin-body.dark .card-header,
        [data-bs-theme="dark"] .card-header{
            background: #0f172a !important;
            border-color: #1f2937 !important;
            color: #f1f5f9 !important;
        }
        body.admin-body.dark .card-footer,
        [data-bs-theme="dark"] .card-footer{
            background: #0b1220 !important;
            border-color: #1f2937 !important;
        }
        body.admin-body.dark .bg-white,
        body.admin-body.dark .bg-light,
        [data-bs-theme="dark"] .bg-white,
        [data-bs-theme="dark"] .bg-light{
            background-color: #0f172a !important;
            color: #e5e7eb !important;
        }

        /* LIST GROUP & TABS */
        body.admin-body.dark .list-group,
        [data-bs-theme="dark"] .list-group{
            background-color: #0f172a !important;
            border-color: #1f2937 !important;
        }
        body.admin-body.dark .list-group-item,
        [data-bs-theme="dark"] .list-group-item{
            background-color: #0f172a !important;
            border-color: #1f2937 !important;
            color: #94a3b8 !important;
        }
        body.admin-body.dark .list-group-item:hover,
        [data-bs-theme="dark"] .list-group-item:hover{
            background-color: #1e293b !important;
            color: #ffffff !important;
        }
        body.admin-body.dark .list-group-item.active,
        [data-bs-theme="dark"] .list-group-item.active{
            background-color: #2563eb !important;
            border-color: #2563eb !important;
            color: #ffffff !important;
        }

        /* FORM CONTROLS & INPUTS */
        body.admin-body.dark .form-label,
        [data-bs-theme="dark"] .form-label{
            color: #e2e8f0 !important;
        }
        body.admin-body.dark .form-text,
        [data-bs-theme="dark"] .form-text{
            color: #94a3b8 !important;
        }
        body.admin-body.dark .form-control,
        body.admin-body.dark .form-select,
        body.admin-body.dark textarea,
        [data-bs-theme="dark"] .form-control,
        [data-bs-theme="dark"] .form-select,
        [data-bs-theme="dark"] textarea{
            background-color: #0b1220 !important;
            border-color: #1f2937 !important;
            color: #f1f5f9 !important;
        }
        body.admin-body.dark .form-control:focus,
        body.admin-body.dark .form-select:focus,
        body.admin-body.dark textarea:focus,
        [data-bs-theme="dark"] .form-control:focus,
        [data-bs-theme="dark"] .form-select:focus,
        [data-bs-theme="dark"] textarea:focus{
            background-color: #0b1220 !important;
            border-color: #3b82f6 !important;
            color: #ffffff !important;
            box-shadow: 0 0 0 0.25rem rgba(37,99,235,.25) !important;
        }
        body.admin-body.dark .form-control::placeholder,
        body.admin-body.dark textarea::placeholder,
        [data-bs-theme="dark"] .form-control::placeholder,
        [data-bs-theme="dark"] textarea::placeholder{
            color: #64748b !important;
        }
        body.admin-body.dark .form-control:disabled,
        body.admin-body.dark .form-select:disabled,
        body.admin-body.dark textarea:disabled,
        [data-bs-theme="dark"] .form-control:disabled,
        [data-bs-theme="dark"] .form-select:disabled,
        [data-bs-theme="dark"] textarea:disabled{
            background-color: #080d17 !important;
            border-color: #172033 !important;
            color: #64748b !important;
            opacity: 0.8;
        }
        body.admin-body.dark .input-group-text,
        [data-bs-theme="dark"] .input-group-text{
            background-color: #1e293b !important;
            border-color: #334155 !important;
            color: #cbd5e1 !important;
        }

        /* FORM SWITCH & CHECKBOX */
        body.admin-body.dark .form-check-input,
        [data-bs-theme="dark"] .form-check-input{
            background-color: #1e293b;
            border-color: #475569;
        }
        body.admin-body.dark .form-check-input:checked,
        [data-bs-theme="dark"] .form-check-input:checked{
            background-color: #2563eb;
            border-color: #2563eb;
        }
        body.admin-body.dark .form-check-label,
        [data-bs-theme="dark"] .form-check-label{
            color: #e2e8f0;
        }

        /* ALERTS */
        body.admin-body.dark .alert,
        [data-bs-theme="dark"] .alert{
            color: #e2e8f0;
        }
        body.admin-body.dark .alert-light,
        [data-bs-theme="dark"] .alert-light{
            background-color: rgba(30, 41, 59, 0.7) !important;
            border-color: #334155 !important;
            color: #e2e8f0 !important;
        }
        body.admin-body.dark .alert-info,
        [data-bs-theme="dark"] .alert-info{
            background-color: rgba(14, 165, 233, 0.12) !important;
            border-color: rgba(14, 165, 233, 0.3) !important;
            color: #7dd3fc !important;
        }
        body.admin-body.dark .alert-secondary,
        [data-bs-theme="dark"] .alert-secondary{
            background-color: rgba(100, 116, 139, 0.15) !important;
            border-color: rgba(100, 116, 139, 0.3) !important;
            color: #cbd5e1 !important;
        }

        /* ACCORDIONS */
        body.admin-body.dark .accordion-item,
        [data-bs-theme="dark"] .accordion-item{
            background-color: #0f172a !important;
            border-color: #1f2937 !important;
            color: #e5e7eb;
        }
        body.admin-body.dark .accordion-button,
        [data-bs-theme="dark"] .accordion-button{
            background-color: #0f172a !important;
            color: #e5e7eb !important;
            border-color: #1f2937 !important;
        }
        body.admin-body.dark .accordion-button:not(.collapsed),
        [data-bs-theme="dark"] .accordion-button:not(.collapsed){
            background-color: #131d33 !important;
            color: #60a5fa !important;
            box-shadow: inset 0 -1px 0 #1f2937;
        }
        body.admin-body.dark .accordion-button::after,
        [data-bs-theme="dark"] .accordion-button::after{
            filter: invert(1);
        }
        body.admin-body.dark .accordion-body,
        [data-bs-theme="dark"] .accordion-body{
            background-color: #0b1220 !important;
            color: #e5e7eb !important;
        }

        /* BADGES & BORDERS */
        body.admin-body.dark .badge.text-bg-light,
        body.admin-body.dark .badge.bg-light,
        [data-bs-theme="dark"] .badge.text-bg-light,
        [data-bs-theme="dark"] .badge.bg-light{
            background-color: #1e293b !important;
            color: #cbd5e1 !important;
            border: 1px solid #334155;
        }
        body.admin-body.dark .badge.bg-info-subtle,
        [data-bs-theme="dark"] .badge.bg-info-subtle{
            background-color: rgba(14, 165, 233, 0.15) !important;
            color: #7dd3fc !important;
            border-color: rgba(14, 165, 233, 0.3) !important;
        }
        body.admin-body.dark .badge-soft,
        [data-bs-theme="dark"] .badge-soft{
            border-color: rgba(255,255,255,.15) !important;
            background: rgba(255,255,255,.06) !important;
            color: #e2e8f0 !important;
        }
        body.admin-body.dark .border,
        body.admin-body.dark .border-top,
        body.admin-body.dark .border-bottom,
        body.admin-body.dark .border-start,
        body.admin-body.dark .border-end,
        [data-bs-theme="dark"] .border,
        [data-bs-theme="dark"] .border-top,
        [data-bs-theme="dark"] .border-bottom,
        [data-bs-theme="dark"] .border-start,
        [data-bs-theme="dark"] .border-end{
            border-color: #1f2937 !important;
        }
        body.admin-body.dark hr,
        [data-bs-theme="dark"] hr{
            border-color: #1f2937;
            opacity: 1;
        }

        /* MODAL */
        body.admin-body.dark .modal-content,
        [data-bs-theme="dark"] .modal-content{
            background-color: #0f172a !important;
            border-color: #1f2937 !important;
            color: #e5e7eb;
        }
        body.admin-body.dark .modal-header,
        body.admin-body.dark .modal-footer,
        [data-bs-theme="dark"] .modal-header,
        [data-bs-theme="dark"] .modal-footer{
            border-color: #1f2937 !important;
        }

        body.admin-body.dark .dropdown-menu,
        [data-bs-theme="dark"] .dropdown-menu{
            background: #0b1220;
            border: 1px solid rgba(255,255,255,.12);
            box-shadow: 0 18px 55px rgba(0,0,0,.45);
        }

        body.admin-body.dark .dropdown-header{
            color: rgba(229,231,235,.70) !important;
        }

        body.admin-body.dark .dropdown-item,
        body.admin-body.dark .dropdown-item-text{
            color: rgba(229,231,235,.92) !important;
        }

        body.admin-body.dark .dropdown-item:hover,
        body.admin-body.dark .dropdown-item:focus{
            background: rgba(255,255,255,.06);
            color: #fff !important;
        }

        body.admin-body.dark .dropdown-divider{
            border-top-color: rgba(255,255,255,.10);
        }

        body.admin-body.dark .adm-topbar .btn-outline-dark{
            color: rgba(229,231,235,.92) !important;
            border-color: rgba(255,255,255,.18) !important;
            background: rgba(255,255,255,.04);
        }

        body.admin-body.dark .adm-topbar .btn-outline-dark:hover{
            background: rgba(255,255,255,.08);
        }

        body.admin-body.dark .adm-topbar .btn-outline-dark i{
            color: rgba(229,231,235,.92) !important;
        }

        body.admin-body.dark .dropdown-menu .dropdown-item-text.small{
            color: rgba(229,231,235,.78) !important;
        }

        body.admin-body.dark .table,
        [data-bs-theme="dark"] .table{
            --bs-table-bg: transparent;
            --bs-table-color: rgba(229,231,235,.9);
            --bs-table-border-color: #1f2937;
        }

        body.admin-body.dark .table thead th,
        [data-bs-theme="dark"] .table thead th{
            background: transparent;
            color: rgba(229,231,235,.75);
            border-bottom: 1px solid #1f2937;
        }

        body.admin-body.dark .table-light,
        [data-bs-theme="dark"] .table-light,
        body.admin-body.dark .table thead.table-light th,
        [data-bs-theme="dark"] .table thead.table-light th{
            background-color: #0b1220 !important;
            color: #94a3b8 !important;
            border-bottom: 1px solid #1f2937 !important;
        }

        body.admin-body.dark .table tbody td,
        [data-bs-theme="dark"] .table tbody td{
            background: transparent;
            border-top: 1px solid #1f2937;
        }

        body.admin-body.dark .table tbody tr:hover,
        [data-bs-theme="dark"] .table tbody tr:hover,
        body.admin-body.dark .table-hover > tbody > tr:hover,
        [data-bs-theme="dark"] .table-hover > tbody > tr:hover{
            background: rgba(255,255,255,.04) !important;
        }

        body.admin-body.dark .table tbody td.text-muted,
        [data-bs-theme="dark"] .table tbody td.text-muted{
            color: rgba(229,231,235,.65) !important;
        }

        body.admin-body.dark .adm-pagination .page-link{
            background: #0b1220;
            border-color: rgba(255,255,255,.12);
            color: rgba(229,231,235,.9);
        }

        body.admin-body.dark .adm-pagination .page-item.active .page-link{
            background: rgba(37,99,235,.35);
            border-color: rgba(255,255,255,.18);
            color: #fff;
        }

        body.admin-body.dark .adm-pagination .page-item.disabled .page-link{
            background: rgba(255,255,255,.03);
            color: rgba(229,231,235,.35);
            border-color: rgba(255,255,255,.10);
        }

        body.admin-body.dark .adm-pagination .page-link:hover{
            background: rgba(255,255,255,.06);
        }

        body.admin-body:not(.dark) .adm-sidebar{
            background: #ffffff;
            color: #0f172a;
            border-right: 1px solid #e5e7eb;
        }

        body.admin-body:not(.dark) .adm-brand{
            border-bottom: 1px solid #e5e7eb;
        }

        body.admin-body:not(.dark) .adm-nav-title{
            color: #64748b;
        }

        body.admin-body:not(.dark) .adm-link{
            color: #0f172a;
        }

        body.admin-body:not(.dark) .adm-link:hover{
            background: #f1f5f9;
            color: #0f172a;
        }

        body.admin-body:not(.dark) .adm-link .icon{
            background: #f8fafc;
            border-color: #e5e7eb;
        }

        body.admin-body:not(.dark) .adm-side-footer{
            border-top: 1px solid #e5e7eb;
            color: #334155;
        }

        body.admin-body:not(.dark) .adm-side-footer .d-flex{
            background: #f8fafc;
            border: 1px solid #e5e7eb;
        }

        body.admin-body:not(.dark) .adm-side-footer .fw-bold{
            color: #0f172a;
        }

        body.admin-body:not(.dark) .adm-side-footer .small{
            color: #64748b;
        }

        body.admin-body:not(.dark) .adm-side-footer .btn-outline-light{
            border-color: #e5e7eb;
            color: #0f172a;
        }

        body.admin-body:not(.dark) .adm-side-footer .btn-outline-light:hover{
            background: #f1f5f9;
        }

        body.admin-body:not(.dark) .adm-sidebar .adm-brand .sub{
            color: #64748b;
        }

        body.admin-body:not(.dark) .adm-sidebar .adm-brand .name{
            color: #0f172a;
        }

        body.admin-body:not(.dark) .adm-pagination .page-link{
            border-color: #e5e7eb;
        }

        @media(max-width: 992px){
            .adm-sidebar{ display:none; }
            .adm-main{ padding: 12px; }
        }
    </style>
</head>

@php
    $user = auth()->user();

    $isSuper = false;
    if ($user) {
        try {
            $isSuper = optional($user->role)->slug === 'superadmin';
        } catch (\Throwable $e) {
            $isSuper = false;
        }
    }

    $isActive = fn($pattern) => request()->routeIs($pattern) ? 'active' : '';
@endphp

<body class="admin-body">

<div class="adm-shell">

    {{-- SIDEBAR --}}
    <aside class="adm-sidebar">
        <div class="adm-brand">
            <div class="logo">
                <i class="bi bi-grid-1x2-fill"></i>
            </div>
            <div>
                <div class="name">{{ config('app.name', 'CMS') }}</div>
                <div class="sub">
                    {{ $isSuper ? 'Super Admin' : 'Admin' }} Panel
                </div>
            </div>
        </div>

        <div class="adm-nav-scroll">

            <div class="adm-nav-title">Main</div>

            <a class="adm-link {{ $isActive('admin.dashboard') }}"
               href="{{ route('admin.dashboard') }}">
                <span class="icon"><i class="bi bi-speedometer2"></i></span>
                <span>Dashboard</span>
            </a>

            <div class="adm-nav-title">Content</div>

            <a class="adm-link {{ $isActive('admin.packages.*') }}"
               href="{{ route('admin.packages.index') }}">
                <span class="icon"><i class="bi bi-box-seam"></i></span>
                <span>Packages</span>
            </a>
            <a class="adm-link {{ $isActive('admin.addons.*') }}"
                href="{{ route('admin.addons.index') }}">
                <span class="icon"><i class="bi bi-hdd-network"></i></span>
                <span>Add Ons</span>
            </a>
            <a class="adm-link {{ $isActive('admin.coverages.*') }}"
               href="{{ route('admin.coverages.index') }}">
                <span class="icon"><i class="bi bi-geo-alt"></i></span>
                <span>Coverages</span>
            </a>

            @if($isSuper)
                <a class="adm-link {{ $isActive('admin.faqs.*') }}"
                   href="{{ route('admin.faqs.index') }}">
                    <span class="icon"><i class="bi bi-question-circle"></i></span>
                    <span>FAQs</span>
                </a>

               {{--  <a class="adm-link {{ $isActive('admin.pages.*') }}"
                   href="{{ route('admin.pages.index') }}">
                    <span class="icon"><i class="bi bi-file-earmark-text"></i></span>
                    <span>Pages</span>
                </a>  --}}

                <a class="adm-link {{ $isActive('admin.why-cards.*') }}"
                    href="{{ route('admin.why-cards.index') }}">
                    <span class="icon"><i class="bi bi-patch-check-fill"></i></span>
                    <span>Why Cards</span>
                </a>

                <a class="adm-link {{ $isActive('admin.banners.*') }}"
                   href="{{ route('admin.banners.index') }}">
                    <span class="icon"><i class="bi bi-images"></i></span>
                    <span>Banners</span>
                </a>

                <a class="adm-link {{ $isActive('admin.gallery-albums.*') }}"
                   href="{{ route('admin.gallery-albums.index') }}">
                    <span class="icon"><i class="bi bi-collection"></i></span>
                    <span>Gallery Albums</span>
                </a>

                <a class="adm-link {{ $isActive('admin.gallery-items.*') }}"
                   href="{{ route('admin.gallery-items.index') }}">
                    <span class="icon"><i class="bi bi-image"></i></span>
                    <span>Gallery Items</span>
                </a>
            @endif

            <div class="adm-nav-title">Preview Publik</div>
            <a class="adm-link" href="{{ route('public.simulation') }}" target="_blank">
                <span class="icon"><i class="bi bi-calculator"></i></span>
                <span>Simulasi Biaya</span>
                <span class="badge text-bg-light ms-auto small"><i class="bi bi-box-arrow-up-right"></i></span>
            </a>

            <div class="adm-nav-title">System</div>

            @if($isSuper)
                <a class="adm-link {{ $isActive('admin.users.*') }}"
                   href="{{ route('admin.users.index') }}">
                    <span class="icon"><i class="bi bi-people"></i></span>
                    <span>Users</span>
                </a>

                <a class="adm-link {{ $isActive('admin.settings.*') }}"
                   href="{{ route('admin.settings.index') }}">
                    <span class="icon"><i class="bi bi-gear"></i></span>
                    <span>Settings</span>
                </a>
            @endif

        </div>

        <div class="adm-side-footer">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <div class="fw-bold">{{ $user?->name ?? 'Guest' }}</div>
                    <div class="small">{{ $user?->email ?? '' }}</div>
                </div>
                <button id="adminThemeToggle" type="button" class="btn btn-sm btn-outline-light">
                    <i class="bi bi-moon-stars-fill"></i>
                </button>
            </div>
        </div>
    </aside>

    {{-- MAIN --}}
    <main class="adm-main">

        <div class="adm-topbar">
            <div class="d-flex align-items-center gap-2 justify-content-between flex-wrap">
                <div class="d-flex align-items-center gap-2">
                    <span class="badge text-bg-primary adm-pill">
                        {{ $isSuper ? 'SUPERADMIN' : 'ADMIN' }}
                    </span>

                    <div class="text-muted small">
                        @yield('subtitle', 'Manage your CMS content & settings')
                    </div>
                </div>

                <div class="d-flex align-items-center gap-2">
                    <a href="{{ url('/') }}" target="_blank" class="btn btn-outline-secondary btn-sm">
                        <i class="bi bi-box-arrow-up-right me-1"></i> Open Website
                    </a>

                    <div class="dropdown">
                        <button class="btn btn-outline-dark btn-sm dropdown-toggle"
                                data-bs-toggle="dropdown" type="button">
                            <i class="bi bi-person-circle me-1"></i> {{ $user?->name ?? 'Account' }}
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li class="dropdown-header small text-muted">Account</li>
                            <li><span class="dropdown-item-text small">{{ $user?->email }}</span></li>
                            <li><hr class="dropdown-divider"></li>

                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button class="dropdown-item text-danger" type="submit">
                                        <i class="bi bi-box-arrow-right me-1"></i> Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>

                    <button id="adminThemeToggleMobile" type="button" class="btn btn-outline-secondary btn-sm d-lg-none">
                        <i class="bi bi-moon-stars-fill"></i>
                    </button>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success adm-card p-3 mb-3">
                <i class="bi bi-check-circle-fill me-1"></i> {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger adm-card p-3 mb-3">
                <i class="bi bi-exclamation-triangle-fill me-1"></i> {{ session('error') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger adm-card p-3 mb-3">
                <div class="fw-bold mb-1">Ada error:</div>
                <ul class="mb-0">
                    @foreach($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="adm-card p-3 p-md-4 adm-content">
            @yield('content')
        </div>

        <div class="text-center text-muted small mt-3">
            © {{ date('Y') }} {{ config('app.name', 'CMS') }} — Admin Panel
        </div>

    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

@stack('scripts')

<script>
    (function(){
        const body = document.body;
        const html = document.documentElement;
        const key = 'admin_theme';
        const toggleA = document.getElementById('adminThemeToggle');
        const toggleB = document.getElementById('adminThemeToggleMobile');

        const apply = (mode) => {
            if(mode === 'dark'){
                body.classList.add('dark');
                html.classList.add('dark');
                html.setAttribute('data-bs-theme', 'dark');
            }else{
                body.classList.remove('dark');
                html.classList.remove('dark');
                html.setAttribute('data-bs-theme', 'light');
            }
        };

        const saved = localStorage.getItem(key);
        if(saved) {
            apply(saved);
        } else if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
            apply('dark');
        }

        const onClick = () => {
            const isDark = !body.classList.contains('dark');
            const mode = isDark ? 'dark' : 'light';
            apply(mode);
            localStorage.setItem(key, mode);
        };

        if(toggleA) toggleA.addEventListener('click', onClick);
        if(toggleB) toggleB.addEventListener('click', onClick);
    })();
</script>
</body>
</html>