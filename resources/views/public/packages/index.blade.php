@extends('public.layouts.public')

@push('styles')
<style>
/* ===================== PAGE HEADER ===================== */
.paket-header {
    text-align: center;
    margin-bottom: 1.25rem;
}

.paket-header-title {
    font-size: 2.5rem;
    font-weight: 800;
    color: #1E5FA8;
    margin-bottom: .35rem;
    letter-spacing: -0.3px;
}

.paket-header-sub {
    color: #4b5563;
    font-size: .95rem;
    max-width: 720px;
    margin-inline: auto;
    line-height: 1.5;
}

/* ===================== TYPE TABS ===================== */
.paket-tabs {
    max-width: 440px;
    margin: 0 auto 1.1rem;
    display: flex;
    gap: 8px;
    background: #f1f5f9;
    padding: 5px;
    border-radius: 999px;
    border: 1px solid #e2e8f0;
}

.paket-tab {
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

.paket-tab:hover {
    color: #1E5FA8;
}

.paket-tab.active {
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
.paket-toolbar-box,
.paket-reco-box {
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

.paket-toolbar-box {
    background: linear-gradient(135deg, #f8fbff, #f0fdf4);
    border-color: #dbeafe;
}

.paket-reco-box {
    background: linear-gradient(135deg, #f0f9ff, #faf5ff);
    border-color: #e0e7ff;
    position: relative;
    overflow: hidden;
}

.paket-box-header {
    font-size: .92rem;
    font-weight: 800;
    color: #1E5FA8;
    margin-bottom: .6rem;
    display: flex;
    align-items: center;
    gap: 7px;
}

.paket-box-sub {
    font-size: .8rem;
    color: #64748b;
    margin-bottom: .75rem;
    line-height: 1.4;
}

.paket-toolbar-form .form-control,
.paket-toolbar-form .form-select,
.paket-reco-box .form-select {
    border-radius: 12px;
    border-color: #cbd5e1;
    font-size: .85rem;
    min-height: 40px;
    background: #ffffff;
    box-shadow: none;
}

.paket-toolbar-form .form-control:focus,
.paket-toolbar-form .form-select:focus,
.paket-reco-box .form-select:focus {
    border-color: #1E5FA8;
    box-shadow: 0 0 0 0.15rem rgba(30, 95, 168, .12);
}

.paket-toolbar-label {
    font-size: .78rem;
    font-weight: 700;
    color: #475569;
    margin-bottom: .25rem;
}

.paket-toolbar-info {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 8px;
    margin-top: .75rem;
    padding-top: .65rem;
    border-top: 1px dashed #cbd5e1;
    flex-wrap: wrap;
}

.paket-toolbar-count {
    font-size: .83rem;
    color: #64748b;
}

.paket-toolbar-count strong {
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

/* ===================== RECO HIGHLIGHT BANNER ===================== */
.reco-highlight-card {
    border-radius: 20px;
    background: linear-gradient(135deg, #eff6ff, #ecfdf5);
    border: 1px solid #a7f3d0;
    padding: 1.25rem 1.5rem;
    margin-bottom: 1.25rem;
    box-shadow: 0 10px 25px rgba(16, 185, 129, .08);
}

/* ===================== PACKAGE STAGE ===================== */
.paket-stage {
    border-radius: 24px;
    background: linear-gradient(135deg, #eff6ff, #f0fdf4);
    padding: 1.5rem;
    border: 1px solid #dbeafe;
    box-shadow: 0 14px 35px rgba(15, 23, 42, .06);
}

/* ===================== PACKAGE GRID ===================== */
.paket-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 18px;
}

/* ===================== NEW PROFESSIONAL ISP CARD ===================== */
.paket-card {
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

.paket-card::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, #1E5FA8, #22c55e);
    opacity: 0.85;
}

.paket-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 20px 38px rgba(30, 95, 168, .12);
    border-color: #93c5fd;
}

.paket-card.is-popular {
    border-color: #86efac;
    box-shadow: 0 14px 32px rgba(34, 197, 94, .12);
}

.paket-card.is-popular::before {
    height: 5px;
    background: linear-gradient(90deg, #22c55e, #10b981, #1E5FA8);
}

/* Card Header (Category + Popular/Featured Pills) */
.paket-card-head {
    padding: 16px 18px 10px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 8px;
    flex-wrap: wrap;
    border-bottom: 1px solid #f1f5f9;
}

.paket-cat-badge {
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

.paket-pill-badge {
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

.paket-pill-badge.pill-popular {
    background: linear-gradient(135deg, #fef3c7, #fee2e2);
    color: #b45309;
    border: 1px solid #fde68a;
    box-shadow: 0 2px 6px rgba(245, 158, 11, .15);
}

.paket-pill-badge.pill-featured {
    background: linear-gradient(135deg, #eff6ff, #dbeafe);
    color: #1d4ed8;
    border: 1px solid #bfdbfe;
}

.paket-pill-badge.pill-reco {
    background: linear-gradient(135deg, #dcfce7, #d1fae5);
    color: #047857;
    border: 1px solid #a7f3d0;
}

/* Card Body */
.paket-card-body {
    padding: 16px 18px 18px;
    display: flex;
    flex-direction: column;
    flex-grow: 1;
}

.paket-plan-name {
    font-size: 1.15rem;
    font-weight: 800;
    color: #1E5FA8;
    line-height: 1.35;
    margin-bottom: 12px;
}

/* Speed Hero Box */
.paket-speed-hero {
    background: linear-gradient(135deg, #f8fbff 0%, #f0fdf4 100%);
    border: 1px solid #e0f2fe;
    border-radius: 14px;
    padding: 12px 14px;
    margin-bottom: 10px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 8px;
}

.paket-speed-val {
    display: flex;
    align-items: baseline;
    gap: 4px;
}

.paket-speed-val .speed-num {
    font-size: 2.15rem;
    font-weight: 900;
    color: #0f766e;
    line-height: 1;
    letter-spacing: -0.5px;
}

.paket-speed-val .speed-unit {
    font-size: 1rem;
    font-weight: 800;
    color: #0f766e;
}

.paket-speed-badge {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    background: #ffffff;
    border: 1px solid #a7f3d0;
    color: #065f46;
    font-size: 0.74rem;
    font-weight: 700;
    padding: 4px 9px;
    border-radius: 999px;
    box-shadow: 0 2px 4px rgba(16, 185, 129, .08);
}

.paket-speed-tagline {
    font-size: 0.78rem;
    font-weight: 600;
    color: #64748b;
    margin-bottom: 14px;
    display: flex;
    align-items: center;
    gap: 5px;
}

.paket-speed-tagline i {
    color: #22c55e;
}

/* Pricing Card */
.paket-price-card {
    border-top: 1px dashed #e2e8f0;
    padding-top: 12px;
    margin-bottom: 14px;
}

.paket-price-row {
    display: flex;
    align-items: baseline;
    gap: 4px;
    margin-bottom: 2px;
}

.paket-price-row .currency {
    font-size: 0.95rem;
    font-weight: 700;
    color: #1E5FA8;
}

.paket-price-row .amount {
    font-size: 1.6rem;
    font-weight: 900;
    color: #1E5FA8;
    line-height: 1;
}

.paket-price-row .period {
    font-size: 0.84rem;
    font-weight: 600;
    color: #64748b;
    margin-left: 2px;
}

.paket-price-note {
    font-size: 0.78rem;
    color: #94a3b8;
    line-height: 1.3;
}

/* Specs (Device Capacity & Target) */
.paket-specs-box {
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

.paket-specs-box .spec-row {
    display: flex;
    align-items: flex-start;
    gap: 7px;
    line-height: 1.4;
}

.paket-specs-box .spec-row i {
    font-size: 0.85rem;
    margin-top: 1px;
    flex-shrink: 0;
}

.paket-specs-box .spec-row strong {
    color: #1e293b;
}

/* Short Description */
.paket-short-desc {
    color: #4b5563;
    font-size: 0.84rem;
    line-height: 1.5;
    margin-bottom: 12px;
}

/* Feature List */
.paket-features-box {
    margin-bottom: 16px;
}

.paket-features-title {
    font-size: 0.8rem;
    font-weight: 800;
    color: #1E5FA8;
    text-transform: uppercase;
    letter-spacing: 0.3px;
    margin-bottom: 8px;
}

.paket-features-list {
    list-style: none;
    padding-left: 0;
    margin-bottom: 0;
    display: flex;
    flex-direction: column;
    gap: 7px;
}

.paket-features-list li {
    font-size: 0.83rem;
    color: #374151;
    display: flex;
    align-items: flex-start;
    gap: 8px;
    line-height: 1.4;
}

.paket-features-list li i {
    color: #10b981;
    font-size: 0.88rem;
    flex-shrink: 0;
    margin-top: 1px;
}

/* CTA Buttons */
.paket-actions {
    margin-top: auto;
    display: grid;
    grid-template-columns: 1.25fr 1fr;
    gap: 8px;
    padding-top: 10px;
}

.paket-btn {
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

.paket-btn:hover {
    transform: translateY(-2px);
}

.paket-btn-primary {
    background: linear-gradient(135deg, #1E5FA8, #22c55e);
    color: #ffffff;
    box-shadow: 0 4px 14px rgba(30, 95, 168, .22);
}

.paket-btn-primary:hover {
    color: #ffffff;
    box-shadow: 0 6px 18px rgba(34, 197, 94, .32);
}

.paket-btn-secondary {
    background: #ffffff;
    color: #1E5FA8;
    border-color: #cbd5e1;
}

.paket-btn-secondary:hover {
    color: #1E5FA8;
    background: #f8fafc;
    border-color: #94a3b8;
}

@media (max-width: 576px) {
    .paket-actions {
        grid-template-columns: 1fr;
    }
}

/* ===================== EMPTY ===================== */
.paket-empty {
    grid-column: 1 / -1;
    text-align: center;
    color: #6b7280;
    padding: 28px 18px;
}

/* ===================== DARK MODE ===================== */
body.dark-mode .paket-tabs {
    background: #0b1329;
    border-color: #1e293b;
}

body.dark-mode .paket-tab {
    color: #94a3b8;
}

body.dark-mode .paket-tab.active {
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

body.dark-mode .paket-toolbar-box,
body.dark-mode .paket-reco-box,
body.dark-mode .paket-stage,
body.dark-mode .reco-highlight-card {
    background: linear-gradient(135deg, #021021, #02260e);
    border-color: #1f2937;
    box-shadow: 0 18px 45px rgba(0,0,0,.8);
}

body.dark-mode .paket-header-title,
body.dark-mode .paket-box-header,
body.dark-mode .paket-plan-name,
body.dark-mode .paket-features-title {
    color: #e5e7eb;
}

body.dark-mode .paket-header-sub,
body.dark-mode .paket-box-sub,
body.dark-mode .paket-toolbar-label,
body.dark-mode .paket-toolbar-count,
body.dark-mode .paket-price-note,
body.dark-mode .paket-speed-tagline,
body.dark-mode .paket-empty {
    color: #9ca3af;
}

body.dark-mode .paket-short-desc {
    color: #d1d5db;
}

body.dark-mode .paket-card {
    background: #0f172a;
    border-color: #1e293b;
    box-shadow: 0 16px 36px rgba(0, 0, 0, .4);
}

body.dark-mode .paket-card:hover {
    border-color: #38bdf8;
    box-shadow: 0 20px 45px rgba(0, 0, 0, .6);
}

body.dark-mode .paket-card.is-popular {
    border-color: #059669;
}

body.dark-mode .paket-card-head {
    border-bottom-color: #1e293b;
}

body.dark-mode .paket-cat-badge {
    background: #1e293b;
    color: #94a3b8;
}

body.dark-mode .paket-speed-hero {
    background: linear-gradient(135deg, rgba(30, 95, 168, 0.2), rgba(16, 185, 129, 0.15));
    border-color: #1e3a5f;
}

body.dark-mode .paket-speed-val .speed-num,
body.dark-mode .paket-speed-val .speed-unit {
    color: #34d399;
}

body.dark-mode .paket-speed-badge {
    background: #064e3b;
    border-color: #059669;
    color: #6ee7b7;
}

body.dark-mode .paket-price-card {
    border-top-color: #1e293b;
}

body.dark-mode .paket-price-row .currency,
body.dark-mode .paket-price-row .amount {
    color: #60a5fa;
}

body.dark-mode .paket-price-row .period {
    color: #94a3b8;
}

body.dark-mode .paket-specs-box {
    background: #1e293b;
    border-color: #334155;
    color: #cbd5e1;
}

body.dark-mode .paket-specs-box .spec-row strong {
    color: #f8fafc;
}

body.dark-mode .paket-features-list li {
    color: #e5e7eb;
}

body.dark-mode .paket-btn-secondary {
    background: #1e293b;
    color: #cbd5e1;
    border-color: #334155;
}

body.dark-mode .paket-btn-secondary:hover {
    background: #334155;
    color: #ffffff;
}

body.dark-mode .paket-toolbar-form .form-control,
body.dark-mode .paket-toolbar-form .form-select,
body.dark-mode .paket-reco-box .form-select {
    background: #0f172a;
    color: #e5e7eb;
    border-color: #243041;
}

body.dark-mode .btn-wa-consult {
    background: #0f172a;
    color: #34d399;
    border-color: #059669;
}

/* ===================== RESPONSIVE ===================== */
@media (max-width: 992px) {
    .paket-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 576px) {
    .paket-grid {
        grid-template-columns: 1fr;
    }

    .paket-header-title {
        font-size: 1.75rem;
    }

    .paket-header-sub {
        font-size: .84rem;
    }

    .paket-tabs {
        max-width: 100%;
        margin-bottom: .65rem;
    }

    .paket-tab {
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
    $currentUsage = request('usage');
    $currentUsers = request('users');

    $categoryLabels = [
        'internet_only' => 'Internet Only',
        'internet_tv'   => 'Internet + TV',
        'streaming'     => 'Streaming',
    ];

    $hasActiveReco = isset($recommendedPackages) && $recommendedPackages->count() > 0;
@endphp

<div class="paket-header">
    <h1 class="paket-header-title">Pilihan Paket Untuk Anda</h1>
    <p class="paket-header-sub">
        Pilih paket internet terbaik sesuai kebutuhan rumah atau bisnis Anda.
    </p>
</div>

{{-- TYPE TABS (Home Retail / Bisnis) --}}
<div class="paket-tabs">
    <a href="{{ route('public.packages', array_merge(request()->except(['page','type']), ['type' => 'home'])) }}"
       class="paket-tab {{ $currentType === 'home' ? 'active' : '' }}">
        <i class="bi bi-house-door-fill"></i> Home Retail
    </a>

    <a href="{{ route('public.packages', array_merge(request()->except(['page','type']), ['type' => 'business'])) }}"
       class="paket-tab {{ $currentType === 'business' ? 'active' : '' }}">
        <i class="bi bi-building"></i> Bisnis
    </a>
</div>

{{-- CATEGORY FILTER BUTTONS (Compact, sleek & modern) --}}
<div class="paket-filter-menu">
    <a href="{{ route('public.packages', array_merge(request()->except(['page','category']), ['type' => $currentType])) }}"
       class="paket-filter-btn {{ request()->routeIs('public.packages') && empty($currentCategory) ? 'active' : '' }}">
        <i class="bi bi-grid-fill"></i> Semua
    </a>

    <a href="{{ route('public.packages', array_merge(request()->except('page'), ['type' => $currentType, 'category' => 'internet_only'])) }}"
       class="paket-filter-btn {{ request()->routeIs('public.packages') && $currentCategory === 'internet_only' ? 'active' : '' }}">
        <i class="bi bi-wifi"></i> Internet Only
    </a>

    <a href="{{ route('public.packages', array_merge(request()->except('page'), ['type' => $currentType, 'category' => 'internet_tv'])) }}"
       class="paket-filter-btn {{ request()->routeIs('public.packages') && $currentCategory === 'internet_tv' ? 'active' : '' }}">
        <i class="bi bi-tv-fill"></i> Internet + TV
    </a>

    <a href="{{ route('public.packages', array_merge(request()->except('page'), ['type' => $currentType, 'category' => 'streaming'])) }}"
       class="paket-filter-btn {{ request()->routeIs('public.packages') && $currentCategory === 'streaming' ? 'active' : '' }}">
        <i class="bi bi-play-circle-fill"></i> Streaming
    </a>

    <a href="{{ route('public.addons', ['type' => $currentType]) }}"
       class="paket-filter-btn {{ request()->routeIs('public.addons') ? 'active' : '' }}">
        <i class="bi bi-plus-circle-fill"></i> Add Ons
    </a>
</div>

{{-- 2-COLUMN TOOLBAR (LEFT: Search & Filter | RIGHT: Quick Recommendation) --}}
<div class="row g-3 mb-4 align-items-stretch">
    {{-- LEFT: Search & Sort Filter --}}
    <div class="col-lg-7">
        <div class="paket-toolbar-box">
            <form method="GET" action="{{ route('public.packages') }}" class="paket-toolbar-form h-100 d-flex flex-column justify-content-between">
                <input type="hidden" name="type" value="{{ $currentType }}">
                @if($currentCategory)
                    <input type="hidden" name="category" value="{{ $currentCategory }}">
                @endif
                @if($currentUsage)
                    <input type="hidden" name="usage" value="{{ $currentUsage }}">
                @endif
                @if($currentUsers)
                    <input type="hidden" name="users" value="{{ $currentUsers }}">
                @endif

                <div>
                    <div class="paket-box-header">
                        <i class="bi bi-funnel-fill text-primary"></i>
                        <span>Filter &amp; Cari Paket</span>
                    </div>

                    <div class="row g-2 align-items-end">
                        <div class="col-sm-7">
                            <label class="paket-toolbar-label">Cari Paket</label>
                            <div class="input-group input-group-sm">
                                <span class="input-group-text bg-white border-end-0"><i class="bi bi-search text-muted"></i></span>
                                <input
                                    type="text"
                                    name="q"
                                    class="form-control border-start-0 ps-0"
                                    value="{{ $currentQ }}"
                                    placeholder="Nama paket, perangkat, dll..."
                                >
                            </div>
                        </div>

                        <div class="col-sm-5">
                            <label class="paket-toolbar-label">Urutkan</label>
                            <select name="sort" class="form-select form-select-sm" onchange="this.form.submit()">
                                <option value="" {{ $currentSort == '' ? 'selected' : '' }}>Rekomendasi</option>
                                <option value="price_asc" {{ $currentSort === 'price_asc' ? 'selected' : '' }}>Harga Termurah</option>
                                <option value="price_desc" {{ $currentSort === 'price_desc' ? 'selected' : '' }}>Harga Termahal</option>
                                <option value="speed_desc" {{ $currentSort === 'speed_desc' ? 'selected' : '' }}>Kecepatan Tertinggi</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="paket-toolbar-info">
                    <div class="paket-toolbar-count">
                        Menampilkan <strong>{{ $packages->total() }}</strong> paket
                        @if($currentType)
                            tipe <strong>{{ $currentType === 'business' ? 'Bisnis' : 'Home Retail' }}</strong>
                        @endif
                        @if($currentCategory)
                            | <strong>{{ $categoryLabels[$currentCategory] ?? ucwords(str_replace('_', ' ', $currentCategory)) }}</strong>
                        @endif
                    </div>

                    <div class="d-flex gap-2">
                        @if($currentQ || $currentSort || $currentUsage || $currentUsers)
                            <a href="{{ route('public.packages', ['type' => $currentType, 'category' => $currentCategory]) }}" class="btn btn-outline-secondary btn-sm btn-soft-reset">
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

    {{-- RIGHT: Quick Recommendation --}}
    <div class="col-lg-5">
        <div class="paket-reco-box">
            <form method="GET" action="{{ route('public.packages') }}#rekomendasiHasil" class="h-100 d-flex flex-column justify-content-between">
                <input type="hidden" name="type" value="{{ $currentType }}">
                @if($currentCategory)
                    <input type="hidden" name="category" value="{{ $currentCategory }}">
                @endif
                @if($currentQ)
                    <input type="hidden" name="q" value="{{ $currentQ }}">
                @endif

                <div>
                    <div class="paket-box-header text-success">
                        <i class="bi bi-stars text-warning"></i>
                        <span>Bingung Pilih Paket?</span>
                    </div>
                    <p class="paket-box-sub">
                        Cari rekomendasi otomatis sesuai aktivitas dan kebutuhan perangkatmu.
                    </p>

                    <div class="row g-2">
                        <div class="col-6">
                            <label class="paket-toolbar-label">Aktivitas Utama</label>
                            <select name="usage" class="form-select form-select-sm">
                                <option value="">Pilih...</option>
                                <option value="browsing"  {{ $currentUsage == 'browsing'  ? 'selected' : '' }}>Browsing &amp; Sosmed</option>
                                <option value="streaming" {{ $currentUsage == 'streaming' ? 'selected' : '' }}>Streaming Video</option>
                                <option value="gaming"    {{ $currentUsage == 'gaming'    ? 'selected' : '' }}>Gaming Online</option>
                                <option value="wfh"       {{ $currentUsage == 'wfh'       ? 'selected' : '' }}>WFH / Zoom</option>
                                <option value="tv"        {{ $currentUsage == 'tv'        ? 'selected' : '' }}>Internet + TV</option>
                            </select>
                        </div>

                        <div class="col-6">
                            <label class="paket-toolbar-label">Jumlah Pengguna</label>
                            <select name="users" class="form-select form-select-sm">
                                <option value="">Pilih...</option>
                                <option value="1-2"   {{ $currentUsers == '1-2'   ? 'selected' : '' }}>1–2 orang</option>
                                <option value="3-4"   {{ $currentUsers == '3-4'   ? 'selected' : '' }}>3–4 orang</option>
                                <option value="5-7"   {{ $currentUsers == '5-7'   ? 'selected' : '' }}>5–7 orang</option>
                                <option value="8plus" {{ $currentUsers == '8plus' ? 'selected' : '' }}>8+ orang</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="d-flex align-items-center justify-content-between gap-2 mt-3 pt-2 border-top">
                    <a href="https://wa.me/{{ $wa }}?text={{ urlencode('Halo Fibermedia, saya ingin konsultasi memilih paket internet yang tepat.') }}" 
                       target="_blank" 
                       rel="noopener noreferrer"
                       class="btn-wa-consult"
                       title="Konsultasi langsung via WhatsApp">
                        <i class="bi bi-whatsapp"></i> Chat WA
                    </a>

                    <button type="submit" class="btn-reco-action">
                        <i class="bi bi-lightning-charge-fill"></i> Cari Rekomendasi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- REKOMENDASI HASIL SPOTLIGHT (If recommendation filter is active) --}}
@if($hasActiveReco)
    <div id="rekomendasiHasil" class="reco-highlight-card">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
            <div>
                <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-2 py-1 rounded-pill fw-bold mb-1">
                    <i class="bi bi-stars"></i> Rekomendasi Khusus Untuk Anda
                </span>
                <h4 class="fw-bold mb-0 text-dark" style="color: #1E5FA8 !important;">
                    Paket Paling Sesuai Berdasarkan Pilihan Anda
                </h4>
            </div>
            <a href="{{ route('public.packages', ['type' => $currentType, 'category' => $currentCategory]) }}" class="btn btn-sm btn-outline-secondary rounded-pill">
                <i class="bi bi-x-circle me-1"></i> Tutup Rekomendasi
            </a>
        </div>

        <div class="paket-grid mb-2">
            @foreach ($recommendedPackages as $recPkg)
                @php
                    $recFeatures = collect(preg_split("/\r\n|\n|\r|,/", $recPkg->features ?? ''))
                        ->map(fn($item) => trim($item))
                        ->filter()
                        ->values()
                        ->take(3);

                    $recWaUrl = $recPkg->whatsapp_order_url
                        ?: "https://wa.me/{$wa}?text=" . urlencode("Halo, saya ingin berlangganan paket rekomendasi: {$recPkg->name}");

                    $recBannerUrl = null;
                    if (!empty($recPkg->banner_image)) {
                        if (Str::startsWith($recPkg->banner_image, ['http://', 'https://'])) {
                            $recBannerUrl = $recPkg->banner_image;
                        } elseif (Str::startsWith($recPkg->banner_image, '/storage/')) {
                            $recBannerUrl = $recPkg->banner_image;
                        } elseif (Str::startsWith($recPkg->banner_image, 'storage/')) {
                            $recBannerUrl = asset($recPkg->banner_image);
                        } else {
                            $recBannerUrl = Storage::url($recPkg->banner_image);
                        }
                    }
                @endphp
                <div class="paket-card is-popular">
                    <div class="paket-card-head">
                        <div class="paket-cat-badge">
                            <i class="bi bi-patch-check-fill text-success"></i>
                            Rekomendasi Spesial
                        </div>
                        <span class="paket-pill-badge pill-reco">
                            <i class="bi bi-stars"></i> Terbaik Untuk Anda
                        </span>
                    </div>

                    <div class="paket-card-body">
                        <div class="paket-plan-name">{{ $recPkg->name }}</div>

                        <div class="paket-speed-hero">
                            <div class="paket-speed-val">
                                <span class="speed-num">{{ $recPkg->speed_mbps }}</span>
                                <span class="speed-unit">Mbps</span>
                            </div>
                            <div class="paket-speed-badge">
                                <i class="bi bi-arrow-down-up"></i> Simetris 1:1
                            </div>
                        </div>
                        <div class="paket-speed-tagline">
                            <i class="bi bi-check-circle-fill"></i> Sesuai dengan filter pilihan Anda
                        </div>

                        <div class="paket-price-card">
                            <div class="paket-price-row">
                                <span class="currency">Rp</span>
                                <span class="amount">{{ number_format((float) $recPkg->price_monthly, 0, ',', '.') }}</span>
                                <span class="period">/bln</span>
                            </div>
                            <div class="paket-price-note">Belum termasuk PPN 11%</div>
                        </div>

                        <div class="paket-actions">
                            <a href="{{ route('public.order.step1', ['package' => $recPkg->slug]) }}" class="paket-btn paket-btn-primary">
                                <span>Pesan Paket Ini</span>
                                <i class="bi bi-arrow-right"></i>
                            </a>
                            <a href="{{ $recWaUrl }}" class="paket-btn paket-btn-secondary" target="_blank" rel="noopener noreferrer">
                                <i class="bi bi-whatsapp"></i>
                                <span>Tanya CS</span>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endif

{{-- ALL PACKAGES STAGE --}}
<div class="paket-stage">
    <div class="paket-grid">
        @forelse ($packages as $package)
            @php
                $features = collect(preg_split("/\r\n|\n|\r|,/", $package->features ?? ''))
                    ->map(fn($item) => trim($item))
                    ->filter()
                    ->values()
                    ->take(3);

                $waUrl = $package->whatsapp_order_url
                    ?: "https://wa.me/{$wa}?text=" . urlencode("Halo, saya ingin berlangganan paket: {$package->name}");

                $durationText = !empty($package->duration_months)
                    ? $package->duration_months . ' bulan'
                    : '1 bulan';

                $bannerUrl = null;

                if (!empty($package->banner_image)) {
                    if (Str::startsWith($package->banner_image, ['http://', 'https://'])) {
                        $bannerUrl = $package->banner_image;
                    } elseif (Str::startsWith($package->banner_image, '/storage/')) {
                        $bannerUrl = $package->banner_image;
                    } elseif (Str::startsWith($package->banner_image, 'storage/')) {
                        $bannerUrl = asset($package->banner_image);
                    } else {
                        $bannerUrl = Storage::url($package->banner_image);
                    }
                }

                $bannerStyle = 'background: linear-gradient(135deg, #60a5fa, #86efac);';

                if (!empty($package->banner_color_start) && !empty($package->banner_color_end)) {
                    $bannerStyle = "background: linear-gradient(135deg, {$package->banner_color_start}, {$package->banner_color_end});";
                }

                if ($bannerUrl) {
                    $bannerStyle = 'background: #0f172a;';
                }
            @endphp

            @php
                $isPopular = ((int) ($package->is_best_seller ?? 0) === 1 || (int) ($package->is_featured ?? 0) === 1);
            @endphp

            <div class="paket-card {{ $isPopular ? 'is-popular' : '' }}">
                <div class="paket-card-head">
                    <div class="paket-cat-badge">
                        <i class="bi bi-wifi"></i>
                        {{ $categoryLabels[$package->category] ?? ($package->type === 'business' ? 'Bisnis Fiber' : 'Home Retail') }}
                    </div>

                    @if((int) ($package->is_best_seller ?? 0) === 1)
                        <span class="paket-pill-badge pill-popular">
                            <i class="bi bi-fire"></i> Best Seller
                        </span>
                    @elseif((int) ($package->is_featured ?? 0) === 1)
                        <span class="paket-pill-badge pill-featured">
                            <i class="bi bi-star-fill"></i> Pilihan Utama
                        </span>
                    @endif
                </div>

                <div class="paket-card-body">
                    <div class="paket-plan-name">{{ $package->name }}</div>

                    <div class="paket-speed-hero">
                        <div class="paket-speed-val">
                            <span class="speed-num">{{ $package->speed_mbps }}</span>
                            <span class="speed-unit">Mbps</span>
                        </div>
                        <div class="paket-speed-badge">
                            <i class="bi bi-arrow-down-up"></i> Simetris 1:1
                        </div>
                    </div>
                    <div class="paket-speed-tagline">
                        <i class="bi bi-check-circle-fill"></i> Full Fiber • Bebas FUP Tanpa Kuota
                    </div>

                    <div class="paket-price-card">
                        <div class="paket-price-row">
                            <span class="currency">Rp</span>
                            <span class="amount">{{ number_format((float) $package->price_monthly, 0, ',', '.') }}</span>
                            <span class="period">/bln</span>
                        </div>
                        <div class="paket-price-note">
                            Durasi {{ $durationText }} • Belum termasuk PPN 11%
                        </div>
                    </div>

                    @if($package->device_ideal || $package->best_for)
                        <div class="paket-specs-box">
                            @if($package->device_ideal)
                                <div class="spec-row">
                                    <i class="bi bi-laptop text-primary"></i>
                                    <span>Kapasitas: <strong>{{ $package->device_ideal }}</strong></span>
                                </div>
                            @endif
                            @if($package->best_for)
                                <div class="spec-row">
                                    <i class="bi bi-check2-circle text-success"></i>
                                    <span>Cocok: <strong>{{ $package->best_for }}</strong></span>
                                </div>
                            @endif
                        </div>
                    @endif

                    @if($package->short_description)
                        <div class="paket-short-desc">
                            {{ \Illuminate\Support\Str::limit($package->short_description, 110) }}
                        </div>
                    @endif

                    <div class="paket-features-box">
                        <div class="paket-features-title">Benefit Paket:</div>
                        <ul class="paket-features-list">
                            @forelse($features as $f)
                                <li>
                                    <i class="bi bi-check-circle-fill"></i>
                                    <span>{{ $f }}</span>
                                </li>
                            @empty
                                <li><i class="bi bi-check-circle-fill"></i> <span>Akses internet stabil 24/7</span></li>
                                <li><i class="bi bi-check-circle-fill"></i> <span>Gratis sewa modem WiFi</span></li>
                                <li><i class="bi bi-check-circle-fill"></i> <span>Unlimited tanpa batas FUP</span></li>
                            @endforelse
                        </ul>
                    </div>

                    <div class="paket-actions">
                        <a href="{{ route('public.order.step1', ['package' => $package->slug]) }}" class="paket-btn paket-btn-primary">
                            <span>Pesan Sekarang</span>
                            <i class="bi bi-arrow-right"></i>
                        </a>

                        <a href="{{ $waUrl }}" class="paket-btn paket-btn-secondary" target="_blank" rel="noopener noreferrer" title="Konsultasi via WhatsApp">
                            <i class="bi bi-whatsapp"></i>
                            <span>Konsultasi</span>
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="paket-empty">
                Belum ada paket yang sesuai filter. Coba ubah pencarian atau kategori.
            </div>
        @endforelse
    </div>

    @if(method_exists($packages, 'links'))
        <div class="mt-4">
            {{ $packages->links() }}
        </div>
    @endif
</div>

@include('partials.rekomendasi-paket')
@endsection