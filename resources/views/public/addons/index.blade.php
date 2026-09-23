@extends('public.layouts.public')

@push('styles')
<style>
/* ===================== PAGE HEADER ===================== */
.addon-header {
    text-align: center;
    margin-bottom: 1.25rem;
}

.addon-header-title {
    font-size: 2.5rem;
    font-weight: 800;
    color: #1E5FA8;
    margin-bottom: .35rem;
    letter-spacing: -0.3px;
}

.addon-header-sub {
    color: #4b5563;
    font-size: .95rem;
    max-width: 720px;
    margin-inline: auto;
    line-height: 1.5;
}

/* ===================== TYPE TABS ===================== */
.addon-tabs {
    max-width: 440px;
    margin: 0 auto 1.1rem;
    display: flex;
    gap: 8px;
    background: #f1f5f9;
    padding: 5px;
    border-radius: 999px;
    border: 1px solid #e2e8f0;
}

.addon-tab {
    flex: 1;
    text-align: center;
    padding: 8px 16px;
    border-radius: 999px;
    text-decoration: none;
    font-weight: 700;
    font-size: 0.88rem;
    color: #475569;
    background: transparent;
    transition: all .22s ease;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
}

.addon-tab:hover {
    color: #1E5FA8;
}

.addon-tab.active {
    background: linear-gradient(135deg, #1E5FA8, #2575C0);
    color: #fff;
    box-shadow: 0 4px 14px rgba(30, 95, 168, .28);
}

/* ===================== COMPACT FILTER BUTTON MENU ===================== */
.paket-filter-menu {
    display: flex;
    justify-content: center;
    gap: 8px;
    flex-wrap: wrap;
    margin-bottom: 1.25rem;
}

.paket-filter-btn {
    padding: 7px 16px;
    border-radius: 999px;
    background: #ffffff;
    color: #334155;
    text-decoration: none;
    text-align: center;
    font-weight: 600;
    font-size: .84rem;
    border: 1px solid #e2e8f0;
    transition: all .22s ease;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    box-shadow: 0 2px 5px rgba(15, 23, 42, .03);
}

.paket-filter-btn:hover {
    color: #1E5FA8;
    border-color: #cbd5e1;
    transform: translateY(-1px);
    box-shadow: 0 4px 10px rgba(15, 23, 42, .06);
}

.paket-filter-btn.active {
    background: linear-gradient(135deg, #1E5FA8, #2575C0);
    color: #fff;
    border-color: transparent;
    box-shadow: 0 6px 16px rgba(30, 95, 168, .25);
}

/* ===================== 2-COLUMN TOOLBAR (FILTER & REKOMENDASI) ===================== */
.addon-toolbar-box,
.addon-reco-box {
    border-radius: 20px;
    background: #ffffff;
    border: 1px solid #e2e8f0;
    padding: 1.15rem 1.25rem;
    box-shadow: 0 10px 25px rgba(15, 23, 42, .04);
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

.addon-toolbar-box {
    background: linear-gradient(135deg, #f8fbff, #f0fdf4);
    border-color: #dbeafe;
}

.addon-reco-box {
    background: linear-gradient(135deg, #f0f9ff, #faf5ff);
    border-color: #e0e7ff;
    position: relative;
    overflow: hidden;
}

.addon-box-header {
    font-size: .92rem;
    font-weight: 800;
    color: #1E5FA8;
    margin-bottom: .6rem;
    display: flex;
    align-items: center;
    gap: 7px;
}

.addon-box-sub {
    font-size: .8rem;
    color: #64748b;
    margin-bottom: .75rem;
    line-height: 1.4;
}

.addon-toolbar-form .form-control,
.addon-toolbar-form .form-select,
.addon-reco-box .form-select {
    border-radius: 12px;
    border-color: #cbd5e1;
    font-size: .85rem;
    min-height: 40px;
    background: #ffffff;
    box-shadow: none;
}

.addon-toolbar-form .form-control:focus,
.addon-toolbar-form .form-select:focus,
.addon-reco-box .form-select:focus {
    border-color: #1E5FA8;
    box-shadow: 0 0 0 0.15rem rgba(30, 95, 168, .12);
}

.addon-toolbar-label {
    font-size: .78rem;
    font-weight: 700;
    color: #475569;
    margin-bottom: .25rem;
}

.addon-toolbar-info {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 8px;
    margin-top: .75rem;
    padding-top: .65rem;
    border-top: 1px dashed #cbd5e1;
    flex-wrap: wrap;
}

.addon-toolbar-count {
    font-size: .83rem;
    color: #64748b;
}

.addon-toolbar-count strong {
    color: #1E5FA8;
}

.btn-soft-reset {
    border-radius: 999px;
    padding: 5px 14px;
    font-size: .82rem;
    font-weight: 600;
}

.btn-primary-action {
    background: linear-gradient(135deg, #1E5FA8, #2575C0);
    border: none;
    color: #fff;
    border-radius: 999px;
    padding: 5px 16px;
    font-size: .82rem;
    font-weight: 600;
    box-shadow: 0 4px 12px rgba(30, 95, 168, .2);
    transition: all .2s ease;
}

.btn-primary-action:hover {
    color: #fff;
    transform: translateY(-1px);
    box-shadow: 0 6px 16px rgba(30, 95, 168, .3);
}

.btn-reco-action {
    background: linear-gradient(135deg, #10b981, #059669);
    border: none;
    color: #fff;
    border-radius: 999px;
    padding: 6px 14px;
    font-size: .82rem;
    font-weight: 700;
    display: inline-flex;
    align-items: center;
    gap: 5px;
    transition: all .2s ease;
}

.btn-reco-action:hover {
    color: #fff;
    transform: translateY(-1px);
    box-shadow: 0 4px 14px rgba(16, 185, 129, .3);
}

.btn-wa-consult {
    border-radius: 999px;
    padding: 6px 14px;
    font-size: .82rem;
    font-weight: 600;
    border: 1px solid #10b981;
    color: #059669;
    background: #ffffff;
    display: inline-flex;
    align-items: center;
    gap: 5px;
    text-decoration: none;
    transition: all .2s ease;
}

.btn-wa-consult:hover {
    background: #ecfdf5;
    color: #047857;
    transform: translateY(-1px);
}

/* ===================== STAGE ===================== */
.addon-stage {
    border-radius: 24px;
    background: linear-gradient(135deg, #eff6ff, #f0fdf4);
    padding: 1.5rem;
    border: 1px solid #dbeafe;
    box-shadow: 0 14px 35px rgba(15, 23, 42, .06);
}

/* ===================== GRID ===================== */
.addon-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 18px;
}

/* ===================== NEW PROFESSIONAL ISP ADDON CARD ===================== */
.addon-card {
    background: #ffffff;
    border-radius: 20px;
    border: 1px solid #e2e8f0;
    box-shadow: 0 10px 25px rgba(15, 23, 42, .05);
    display: flex;
    flex-direction: column;
    position: relative;
    overflow: hidden;
    transition: all .28s cubic-bezier(0.16, 1, 0.3, 1);
    height: 100%;
}

.addon-card::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, #1E5FA8, #22c55e);
    opacity: 0.85;
}

.addon-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 20px 38px rgba(30, 95, 168, .12);
    border-color: #93c5fd;
}

.addon-card.is-popular {
    border-color: #86efac;
    box-shadow: 0 14px 32px rgba(34, 197, 94, .12);
}

.addon-card.is-popular::before {
    height: 5px;
    background: linear-gradient(90deg, #22c55e, #10b981, #1E5FA8);
}

/* Card Header (Category + Popular/Featured Pills) */
.addon-card-head {
    padding: 16px 18px 10px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 8px;
    flex-wrap: wrap;
    border-bottom: 1px solid #f1f5f9;
}

.addon-cat-badge {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    font-size: 0.74rem;
    font-weight: 700;
    color: #475569;
    background: #f1f5f9;
    padding: 3px 10px;
    border-radius: 999px;
    letter-spacing: 0.2px;
}

.addon-pill-badge {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    font-size: 0.72rem;
    font-weight: 800;
    padding: 4px 10px;
    border-radius: 999px;
    letter-spacing: 0.3px;
    text-transform: uppercase;
}

.addon-pill-badge.pill-popular {
    background: linear-gradient(135deg, #fef3c7, #fee2e2);
    color: #b45309;
    border: 1px solid #fde68a;
    box-shadow: 0 2px 6px rgba(245, 158, 11, .15);
}

.addon-pill-badge.pill-featured {
    background: linear-gradient(135deg, #eff6ff, #dbeafe);
    color: #1d4ed8;
    border: 1px solid #bfdbfe;
}

/* Card Body */
.addon-card-body {
    padding: 16px 18px 18px;
    display: flex;
    flex-direction: column;
    flex-grow: 1;
}

/* Product Media & Title Hero Box */
.addon-product-hero {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 12px;
}

.addon-media-box {
    width: 58px;
    height: 58px;
    border-radius: 14px;
    background: linear-gradient(135deg, #eff6ff, #ecfdf5);
    border: 1px solid #dbeafe;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    overflow: hidden;
    box-shadow: 0 4px 10px rgba(15, 23, 42, .04);
}

.addon-media-box img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.addon-media-box i {
    font-size: 1.6rem;
    color: #1E5FA8;
}

.addon-title-wrap {
    flex-grow: 1;
    min-width: 0;
}

.addon-plan-name {
    font-size: 1.12rem;
    font-weight: 800;
    color: #1E5FA8;
    line-height: 1.3;
    margin-bottom: 4px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.addon-type-pill {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    font-size: 0.72rem;
    font-weight: 600;
    color: #0f766e;
    background: #f0fdf4;
    padding: 2px 8px;
    border-radius: 6px;
    border: 1px solid #bbf7d0;
}

/* Pricing Card */
.addon-price-card {
    border-top: 1px dashed #e2e8f0;
    padding-top: 12px;
    margin-bottom: 14px;
}

.addon-price-row {
    display: flex;
    align-items: baseline;
    gap: 4px;
    margin-bottom: 2px;
}

.addon-price-row .currency {
    font-size: 0.95rem;
    font-weight: 700;
    color: #1E5FA8;
}

.addon-price-row .amount {
    font-size: 1.6rem;
    font-weight: 900;
    color: #1E5FA8;
    line-height: 1;
}

.addon-price-row .period {
    font-size: 0.84rem;
    font-weight: 600;
    color: #64748b;
    margin-left: 2px;
}

.addon-price-note {
    font-size: 0.78rem;
    color: #94a3b8;
    line-height: 1.3;
}

/* Specs (Device & Target) */
.addon-specs-box {
    background: #f8fafc;
    border-radius: 10px;
    padding: 8px 10px;
    margin-bottom: 12px;
    display: flex;
    flex-direction: column;
    gap: 5px;
    font-size: 0.8rem;
    color: #475569;
    border: 1px solid #f1f5f9;
}

.addon-specs-box .spec-row {
    display: flex;
    align-items: flex-start;
    gap: 7px;
    line-height: 1.4;
}

.addon-specs-box .spec-row i {
    font-size: 0.85rem;
    margin-top: 1px;
    flex-shrink: 0;
}

.addon-specs-box .spec-row strong {
    color: #1e293b;
}

/* Short Description */
.addon-short-desc {
    color: #4b5563;
    font-size: 0.84rem;
    line-height: 1.5;
    margin-bottom: 12px;
}

/* Feature List */
.addon-features-box {
    margin-bottom: 16px;
}

.addon-features-title {
    font-size: 0.8rem;
    font-weight: 800;
    color: #1E5FA8;
    text-transform: uppercase;
    letter-spacing: 0.3px;
    margin-bottom: 8px;
}

.addon-features-list {
    list-style: none;
    padding-left: 0;
    margin-bottom: 0;
    display: flex;
    flex-direction: column;
    gap: 7px;
}

.addon-features-list li {
    font-size: 0.83rem;
    color: #374151;
    display: flex;
    align-items: flex-start;
    gap: 8px;
    line-height: 1.4;
}

.addon-features-list li i {
    color: #10b981;
    font-size: 0.88rem;
    flex-shrink: 0;
    margin-top: 1px;
}

/* CTA Buttons */
.addon-actions {
    margin-top: auto;
    display: grid;
    grid-template-columns: 1fr;
    gap: 8px;
    padding-top: 10px;
}

.addon-btn {
    min-height: 42px;
    border-radius: 12px;
    text-decoration: none;
    font-weight: 700;
    font-size: 0.84rem;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    padding: 0 12px;
    transition: all .2s ease;
    border: 1px solid transparent;
}

.addon-btn:hover {
    transform: translateY(-2px);
}

.addon-btn-primary {
    background: linear-gradient(135deg, #1E5FA8, #22c55e);
    color: #ffffff;
    box-shadow: 0 4px 14px rgba(30, 95, 168, .22);
}

.addon-btn-primary:hover {
    color: #ffffff;
    box-shadow: 0 6px 18px rgba(34, 197, 94, .32);
}

.addon-empty {
    grid-column: 1 / -1;
    text-align: center;
    color: #6b7280;
    padding: 28px 18px;
}

/* ===================== DARK MODE ===================== */
body.dark-mode .addon-tabs {
    background: #0b1329;
    border-color: #1e293b;
}

body.dark-mode .addon-tab {
    color: #94a3b8;
}

body.dark-mode .addon-tab.active {
    color: #fff;
}

body.dark-mode .paket-filter-btn {
    background: #0f172a;
    color: #cbd5e1;
    border-color: #243041;
}

body.dark-mode .paket-filter-btn:hover {
    color: #ffffff;
    border-color: #3b82f6;
}

body.dark-mode .paket-filter-btn.active {
    background: linear-gradient(135deg, #1E5FA8, #2575C0);
    color: #fff;
    border-color: transparent;
}

body.dark-mode .addon-toolbar-box,
body.dark-mode .addon-reco-box,
body.dark-mode .addon-stage {
    background: linear-gradient(135deg, #021021, #02260e);
    border-color: #1f2937;
    box-shadow: 0 18px 45px rgba(0,0,0,.8);
}

body.dark-mode .addon-header-title,
body.dark-mode .addon-box-header,
body.dark-mode .addon-plan-name,
body.dark-mode .addon-features-title {
    color: #e5e7eb;
}

body.dark-mode .addon-header-sub,
body.dark-mode .addon-box-sub,
body.dark-mode .addon-toolbar-label,
body.dark-mode .addon-toolbar-count,
body.dark-mode .addon-price-note,
body.dark-mode .addon-empty {
    color: #9ca3af;
}

body.dark-mode .addon-short-desc {
    color: #d1d5db;
}

body.dark-mode .addon-card {
    background: #0f172a;
    border-color: #1e293b;
    box-shadow: 0 16px 36px rgba(0, 0, 0, .4);
}

body.dark-mode .addon-card:hover {
    border-color: #38bdf8;
    box-shadow: 0 20px 45px rgba(0, 0, 0, .6);
}

body.dark-mode .addon-card.is-popular {
    border-color: #059669;
}

body.dark-mode .addon-card-head {
    border-bottom-color: #1e293b;
}

body.dark-mode .addon-cat-badge {
    background: #1e293b;
    color: #94a3b8;
}

body.dark-mode .addon-media-box {
    background: #1e293b;
    border-color: #334155;
}

body.dark-mode .addon-media-box i {
    color: #38bdf8;
}

body.dark-mode .addon-type-pill {
    background: #064e3b;
    border-color: #059669;
    color: #6ee7b7;
}

body.dark-mode .addon-price-card {
    border-top-color: #1e293b;
}

body.dark-mode .addon-price-row .currency,
body.dark-mode .addon-price-row .amount {
    color: #60a5fa;
}

body.dark-mode .addon-price-row .period {
    color: #94a3b8;
}

body.dark-mode .addon-specs-box {
    background: #1e293b;
    border-color: #334155;
    color: #cbd5e1;
}

body.dark-mode .addon-specs-box .spec-row strong {
    color: #f8fafc;
}

body.dark-mode .addon-features-list li {
    color: #e5e7eb;
}

body.dark-mode .addon-toolbar-form .form-control,
body.dark-mode .addon-toolbar-form .form-select,
body.dark-mode .addon-reco-box .form-select {
    background: #0f172a;
    color: #e5e7eb;
    border-color: #243041;
}

body.dark-mode .btn-wa-consult {
    background: #0f172a;
    color: #34d399;
    border-color: #059669;
}

@media (max-width: 992px) {
    .addon-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 576px) {
    .addon-grid {
        grid-template-columns: 1fr;
    }

    .addon-header-title {
        font-size: 1.75rem;
    }

    .addon-header-sub {
        font-size: .84rem;
    }

    .addon-tabs {
        max-width: 100%;
        margin-bottom: .65rem;
    }

    .addon-tab {
        font-size: .8rem;
        padding: 6px 12px;
    }

    .paket-filter-menu {
        gap: 5px;
        margin-bottom: .85rem;
        overflow-x: auto;
        flex-wrap: nowrap;
        justify-content: flex-start;
        padding-bottom: 4px;
        -webkit-overflow-scrolling: touch;
        scrollbar-width: none;
    }

    .paket-filter-menu::-webkit-scrollbar {
        display: none;
    }

    .paket-filter-btn {
        font-size: .76rem;
        padding: 5px 11px;
        white-space: nowrap;
    }
}
</style>
@endpush

@section('content')
@php
    use Illuminate\Support\Facades\Storage;
    use Illuminate\Support\Str;

    $wa = $settings['contact_whatsapp'] ?? '6281234567890';
    $wa = preg_replace('/\D+/', '', $wa);

    $currentType = request('type', $type ?: 'home');
    $currentCategory = request('category', $category);
    $currentSort = request('sort', $sort);
    $currentQ = request('q', $q);

    $categoryLabels = [
        'cctv'           => 'CCTV',
        'network-device' => 'Access Point AP Router',
        'smart-home'     => 'Smart Home',
        'stb-android'    => 'STB Android',
        'streaming'      => 'Streaming',
    ];

    $categoryIcons = [
        'cctv'           => 'bi-camera-video-fill',
        'network-device' => 'bi-router-fill',
        'smart-home'     => 'bi-house-gear-fill',
        'stb-android'    => 'bi-tv-fill',
        'streaming'      => 'bi-play-circle-fill',
    ];
@endphp

<div class="addon-header">
    <h1 class="addon-header-title">Pilihan Add Ons Untuk Anda</h1>
    <p class="addon-header-sub">
        Lengkapi kebutuhan internet, hiburan, keamanan, dan perangkat pintar Anda dengan add ons terbaik.
    </p>
</div>

{{-- TYPE TABS (Home Retail / Bisnis) --}}
<div class="addon-tabs">
    <a href="{{ route('public.addons', array_merge(request()->except(['page','type']), ['type' => 'home'])) }}"
       class="addon-tab {{ $currentType === 'home' ? 'active' : '' }}">
        <i class="bi bi-house-door-fill"></i> Home Retail
    </a>

    <a href="{{ route('public.addons', array_merge(request()->except(['page','type']), ['type' => 'business'])) }}"
       class="addon-tab {{ $currentType === 'business' ? 'active' : '' }}">
        <i class="bi bi-building"></i> Bisnis
    </a>
</div>

{{-- CATEGORY FILTER BUTTONS (Compact, sleek & modern) --}}
<div class="paket-filter-menu">
    <a href="{{ route('public.addons', array_merge(request()->except(['page','category']), ['type' => $currentType])) }}"
       class="paket-filter-btn {{ request()->routeIs('public.addons') && empty($currentCategory) ? 'active' : '' }}">
        <i class="bi bi-grid-fill"></i> Semua
    </a>

    @foreach($categoryLabels as $value => $label)
        <a href="{{ route('public.addons', array_merge(request()->except('page'), ['type' => $currentType, 'category' => $value])) }}"
           class="paket-filter-btn {{ request()->routeIs('public.addons') && $currentCategory === $value ? 'active' : '' }}">
            <i class="bi {{ $categoryIcons[$value] ?? 'bi-tag-fill' }}"></i> {{ $label }}
        </a>
    @endforeach

    <a href="{{ route('public.packages', ['type' => $currentType]) }}"
       class="paket-filter-btn">
        <i class="bi bi-box-seam-fill"></i> Paket Internet
    </a>
</div>

{{-- 2-COLUMN TOOLBAR (LEFT: Search & Filter | RIGHT: Quick Recommendation & Consultation) --}}
<div class="row g-3 mb-4 align-items-stretch">
    {{-- LEFT: Search & Sort Filter --}}
    <div class="col-lg-7">
        <div class="addon-toolbar-box">
            <form method="GET" action="{{ route('public.addons') }}" class="addon-toolbar-form h-100 d-flex flex-column justify-content-between">
                <input type="hidden" name="type" value="{{ $currentType }}">
                @if($currentCategory)
                    <input type="hidden" name="category" value="{{ $currentCategory }}">
                @endif

                <div>
                    <div class="addon-box-header">
                        <i class="bi bi-funnel-fill text-primary"></i>
                        <span>Filter &amp; Cari Add Ons</span>
                    </div>

                    <div class="row g-2 align-items-end">
                        <div class="col-sm-7">
                            <label class="addon-toolbar-label">Cari Add Ons</label>
                            <div class="input-group input-group-sm">
                                <span class="input-group-text bg-white border-end-0"><i class="bi bi-search text-muted"></i></span>
                                <input
                                    type="text"
                                    name="q"
                                    class="form-control border-start-0 ps-0"
                                    value="{{ $currentQ }}"
                                    placeholder="Cari CCTV, router, smart home..."
                                >
                            </div>
                        </div>

                        <div class="col-sm-5">
                            <label class="addon-toolbar-label">Urutkan</label>
                            <select name="sort" class="form-select form-select-sm" onchange="this.form.submit()">
                                <option value="" {{ $currentSort == '' ? 'selected' : '' }}>Rekomendasi</option>
                                <option value="price_asc" {{ $currentSort === 'price_asc' ? 'selected' : '' }}>Harga Termurah</option>
                                <option value="price_desc" {{ $currentSort === 'price_desc' ? 'selected' : '' }}>Harga Termahal</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="addon-toolbar-info">
                    <div class="addon-toolbar-count">
                        Menampilkan <strong>{{ $addons->total() }}</strong> add on
                        @if($currentType)
                            tipe <strong>{{ $currentType === 'business' ? 'Bisnis' : 'Home Retail' }}</strong>
                        @endif
                        @if($currentCategory)
                            | <strong>{{ $categoryLabels[$currentCategory] ?? ucwords(str_replace('-', ' ', $currentCategory)) }}</strong>
                        @endif
                    </div>

                    <div class="d-flex gap-2">
                        @if($currentQ || $currentSort || $currentCategory)
                            <a href="{{ route('public.addons', ['type' => $currentType]) }}" class="btn btn-outline-secondary btn-sm btn-soft-reset">
                                Reset
                            </a>
                        @endif
                        <button type="submit" class="btn btn-primary-action">
                            Terapkan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- RIGHT: Quick Recommendation & Consultation --}}
    <div class="col-lg-5">
        <div class="addon-reco-box">
            <form method="GET" action="{{ route('public.addons') }}" class="h-100 d-flex flex-column justify-content-between">
                <input type="hidden" name="type" value="{{ $currentType }}">

                <div>
                    <div class="addon-box-header text-success">
                        <i class="bi bi-stars text-warning"></i>
                        <span>Butuh Rekomendasi Perangkat?</span>
                    </div>
                    <p class="addon-box-sub">
                        Pilih jenis perangkat tambahan yang Anda butuhkan untuk rumah atau kantor.
                    </p>

                    <div class="row g-2">
                        <div class="col-12">
                            <label class="addon-toolbar-label">Pilih Kebutuhan Perangkat</label>
                            <select name="category" class="form-select form-select-sm" onchange="this.form.submit()">
                                <option value="">Semua Kategori Perangkat...</option>
                                @foreach($categoryLabels as $val => $lbl)
                                    <option value="{{ $val }}" {{ $currentCategory === $val ? 'selected' : '' }}>
                                        {{ $lbl }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="d-flex align-items-center justify-content-between gap-2 mt-3 pt-2 border-top">
                    <a href="https://wa.me/{{ $wa }}?text={{ urlencode('Halo Fibermedia, saya ingin konsultasi memilih perangkat add ons tambahan.') }}" 
                       target="_blank" 
                       rel="noopener noreferrer"
                       class="btn-wa-consult"
                       title="Konsultasi langsung via WhatsApp">
                        <i class="bi bi-whatsapp"></i> Chat WA
                    </a>

                    <button type="submit" class="btn-reco-action">
                        <i class="bi bi-lightning-charge-fill"></i> Tampilkan Rekomendasi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- ADDONS STAGE --}}
<div class="addon-stage">
    <div class="addon-grid">
        @forelse ($addons as $addon)
            @php
                $features = collect(preg_split("/\r\n|\n|\r|,/", $addon->features ?? ''))
                    ->map(fn($item) => trim($item))
                    ->filter()
                    ->values()
                    ->take(3);

                $waUrl = $addon->whatsapp_url
                    ?: "https://wa.me/{$wa}?text=" . urlencode("Halo, saya ingin tanya add on: {$addon->name}");

                $priceNote = $addon->pricing_type === 'monthly'
                    ? 'Per bulan'
                    : 'Sekali bayar';

                if (!empty($addon->duration_months) && $addon->pricing_type === 'monthly') {
                    $priceNote .= ' • ' . $addon->duration_months . ' bulan';
                }

                $bannerUrl = null;

                if (!empty($addon->banner_image)) {
                    if (Str::startsWith($addon->banner_image, ['http://', 'https://'])) {
                        $bannerUrl = $addon->banner_image;
                    } elseif (Str::startsWith($addon->banner_image, '/storage/')) {
                        $bannerUrl = $addon->banner_image;
                    } elseif (Str::startsWith($addon->banner_image, 'storage/')) {
                        $bannerUrl = asset($addon->banner_image);
                    } else {
                        $bannerUrl = Storage::url($addon->banner_image);
                    }
                }

                $bannerStyle = 'background: linear-gradient(135deg, #60a5fa, #86efac);';

                if (!empty($addon->banner_color_start) && !empty($addon->banner_color_end)) {
                    $bannerStyle = "background: linear-gradient(135deg, {$addon->banner_color_start}, {$addon->banner_color_end});";
                }

                if ($bannerUrl) {
                    $bannerStyle = 'background: #0f172a;';
                }
            @endphp

            @php
                $isPopular = ((int) ($addon->is_best_seller ?? 0) === 1 || (int) ($addon->is_featured ?? 0) === 1);
                $catIcon = $categoryIcons[$addon->category] ?? 'bi-puzzle-fill';
                $pricingLabel = $addon->pricing_type === 'monthly' ? 'Langganan Bulanan' : 'Sekali Bayar (Beli)';
            @endphp

            <div class="addon-card {{ $isPopular ? 'is-popular' : '' }}">
                <div class="addon-card-head">
                    <div class="addon-cat-badge">
                        <i class="bi {{ $catIcon }}"></i>
                        {{ $categoryLabels[$addon->category] ?? ucwords(str_replace('-', ' ', $addon->category)) }}
                    </div>

                    @if((int) ($addon->is_best_seller ?? 0) === 1)
                        <span class="addon-pill-badge pill-popular">
                            <i class="bi bi-fire"></i> Best Seller
                        </span>
                    @elseif((int) ($addon->is_featured ?? 0) === 1)
                        <span class="addon-pill-badge pill-featured">
                            <i class="bi bi-star-fill"></i> Pilihan Utama
                        </span>
                    @endif
                </div>

                <div class="addon-card-body">
                    <div class="addon-product-hero">
                        <div class="addon-media-box">
                            @if($bannerUrl)
                                <img src="{{ $bannerUrl }}" alt="{{ $addon->name }}" loading="lazy" onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                                <i class="bi {{ $catIcon }}" style="display: none;"></i>
                            @else
                                <i class="bi {{ $catIcon }}"></i>
                            @endif
                        </div>
                        <div class="addon-title-wrap">
                            <div class="addon-plan-name" title="{{ $addon->name }}">{{ $addon->name }}</div>
                            <span class="addon-type-pill">
                                <i class="bi bi-tag-fill"></i> {{ $pricingLabel }}
                            </span>
                        </div>
                    </div>

                    <div class="addon-price-card">
                        <div class="addon-price-row">
                            <span class="currency">Rp</span>
                            <span class="amount">{{ number_format((float) $addon->price, 0, ',', '.') }}</span>
                            <span class="period">/{{ $addon->pricing_type === 'monthly' ? 'bln' : 'unit' }}</span>
                        </div>
                        <div class="addon-price-note">
                            {{ $priceNote }}
                        </div>
                    </div>

                    @if($addon->device_ideal || $addon->best_for)
                        <div class="addon-specs-box">
                            @if($addon->device_ideal)
                                <div class="spec-row">
                                    <i class="bi bi-display text-primary"></i>
                                    <span>Perangkat: <strong>{{ $addon->device_ideal }}</strong></span>
                                </div>
                            @endif
                            @if($addon->best_for)
                                <div class="spec-row">
                                    <i class="bi bi-check2-circle text-success"></i>
                                    <span>Cocok: <strong>{{ $addon->best_for }}</strong></span>
                                </div>
                            @endif
                        </div>
                    @endif

                    @if($addon->short_description)
                        <div class="addon-short-desc">
                            {{ \Illuminate\Support\Str::limit($addon->short_description, 110) }}
                        </div>
                    @endif

                    <div class="addon-features-box">
                        <div class="addon-features-title">Highlight Add On:</div>
                        <ul class="addon-features-list">
                            @forelse($features as $f)
                                <li>
                                    <i class="bi bi-check-circle-fill"></i>
                                    <span>{{ $f }}</span>
                                </li>
                            @empty
                                <li><i class="bi bi-check-circle-fill"></i> <span>Instalasi & konfigurasi mudah</span></li>
                                <li><i class="bi bi-check-circle-fill"></i> <span>Kualitas resmi terjamin</span></li>
                                <li><i class="bi bi-check-circle-fill"></i> <span>Dukungan teknis responsif</span></li>
                            @endforelse
                        </ul>
                    </div>

                    <div class="addon-actions">
                        <a href="{{ $waUrl }}" class="addon-btn addon-btn-primary" target="_blank" rel="noopener noreferrer">
                            <i class="bi bi-whatsapp"></i>
                            <span>Tanya / Pasang Sekarang</span>
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="addon-empty">
                Belum ada add on yang sesuai filter. Coba ubah pencarian atau kategori.
            </div>
        @endforelse
    </div>

    @if(method_exists($addons, 'links'))
        <div class="mt-4">
            {{ $addons->links() }}
        </div>
    @endif
</div>
@endsection