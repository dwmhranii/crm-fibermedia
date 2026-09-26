@extends('public.layouts.public')

@section('title', 'Simulasi Biaya Langganan - ' . ($settings['site_name'] ?? 'FibermediaPlay'))

@push('styles')
<style>
    /* =========================================================
       SIMULASI BIAYA STYLES (WARNA KHAS FIBERMEDIA)
       Brand Blue: #1E5FA8, Accent: #2575C0, Sky: #0284c7
       ========================================================= */
    .sim-wrapper {
        padding-top: 1.5rem;
        padding-bottom: 4rem;
    }

    .sim-header {
        text-align: center;
        margin-bottom: 2.25rem;
    }

    .sim-title {
        font-size: 2.25rem;
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 0.5rem;
        letter-spacing: -0.02em;
    }

    .sim-title span {
        color: #1E5FA8;
        background: linear-gradient(135deg, #1E5FA8 0%, #2575C0 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .sim-subtitle {
        color: #64748b;
        font-size: 1rem;
        max-width: 600px;
        margin: 0 auto;
    }

    /* Category Pill Tabs */
    .sim-cat-tabs {
        display: flex;
        flex-wrap: wrap;
        gap: 0.6rem;
        margin-bottom: 1.5rem;
    }

    .sim-cat-btn {
        background: #f1f5f9;
        border: 1px solid #e2e8f0;
        border-radius: 9999px;
        padding: 0.45rem 1.25rem;
        font-size: 0.9rem;
        font-weight: 600;
        color: #475569;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .sim-cat-btn:hover {
        background: #e2e8f0;
        color: #1E5FA8;
    }

    .sim-cat-btn.active {
        background: linear-gradient(135deg, #1E5FA8 0%, #2575C0 100%);
        color: #ffffff;
        border-color: #1E5FA8;
        box-shadow: 0 4px 14px rgba(30, 95, 168, 0.28);
    }

    /* Package Cards Grid */
    .sim-pkg-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .sim-pkg-card {
        background: #ffffff;
        border: 2px solid #e2e8f0;
        border-radius: 14px;
        padding: 1.15rem 1rem;
        cursor: pointer;
        transition: all 0.22s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        text-align: left;
    }

    .sim-pkg-card:hover {
        border-color: #93c5fd;
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(30, 95, 168, 0.08);
    }

    .sim-pkg-card.active {
        border-color: #1E5FA8;
        background: #f0f7ff;
        box-shadow: 0 8px 24px rgba(30, 95, 168, 0.18);
    }

    .sim-pkg-card .pkg-speed {
        font-size: 0.92rem;
        font-weight: 700;
        color: #1E5FA8;
        margin-bottom: 0.2rem;
    }

    .sim-pkg-card .pkg-price {
        font-size: 1.12rem;
        font-weight: 800;
        color: #0f172a;
        line-height: 1.25;
    }

    .sim-pkg-card .pkg-price span {
        font-size: 0.78rem;
        font-weight: 500;
        color: #64748b;
    }

    .sim-pkg-card .pkg-name {
        font-size: 0.78rem;
        color: #475569;
        font-weight: 600;
        margin-top: 0.35rem;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .sim-pkg-card .active-indicator {
        position: absolute;
        top: 8px;
        right: 8px;
        width: 20px;
        height: 20px;
        background: #1E5FA8;
        color: white;
        border-radius: 50%;
        display: none;
        align-items: center;
        justify-content: center;
        font-size: 12px;
    }

    .sim-pkg-card.active .active-indicator {
        display: flex;
    }

    /* Selected Package Details Box */
    .sim-detail-box {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 1.35rem;
        margin-bottom: 2rem;
    }

    .sim-detail-box .detail-title {
        font-size: 1.05rem;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 0.75rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .sim-detail-box ul {
        list-style: none;
        padding-left: 0;
        margin-bottom: 0;
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 0.5rem;
    }

    .sim-detail-box li {
        font-size: 0.88rem;
        color: #475569;
        display: flex;
        align-items: center;
        gap: 0.45rem;
    }

    .sim-detail-box li i {
        color: #10b981;
        font-size: 1rem;
        flex-shrink: 0;
    }

    /* Section Subheadings */
    .sim-section-label {
        font-size: 1.05rem;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 0.85rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .sim-section-tag {
        font-size: 0.8rem;
        font-weight: 600;
        color: #64748b;
    }

    /* =========================================================
       ADDON TOGGLE & ACCORDION (WARNA KHAS FIBERMEDIA)
       ========================================================= */
    .sim-addon-master-card {
        background: #ffffff;
        border: 2px solid #e2e8f0;
        border-radius: 14px;
        padding: 1.1rem 1.35rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        cursor: pointer;
        transition: all 0.25s ease;
        margin-bottom: 1.15rem;
    }

    .sim-addon-master-card:hover {
        border-color: #93c5fd;
        background: #f8fbff;
    }

    .sim-addon-master-card.active {
        border-color: #1E5FA8;
        background: #f0f7ff;
        box-shadow: 0 4px 18px rgba(30, 95, 168, 0.14);
    }

    .master-left {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .master-icon {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        background: #e0f2fe;
        color: #1E5FA8;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.35rem;
        flex-shrink: 0;
        transition: all 0.2s ease;
    }

    .sim-addon-master-card.active .master-icon {
        background: #1E5FA8;
        color: #ffffff;
    }

    .master-title {
        font-size: 1rem;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 0.15rem;
    }

    .master-subtitle {
        font-size: 0.82rem;
        color: #64748b;
    }

    .master-right {
        display: flex;
        align-items: center;
        gap: 0.9rem;
    }

    .badge-selected-count {
        background: #1E5FA8;
        color: #ffffff;
        font-size: 0.78rem;
        font-weight: 700;
        padding: 0.35rem 0.8rem;
        border-radius: 999px;
    }

    .custom-master-switch .form-check-input {
        width: 48px;
        height: 26px;
        cursor: pointer;
    }

    .custom-master-switch .form-check-input:checked {
        background-color: #1E5FA8;
        border-color: #1E5FA8;
    }

    /* Addon Accordion Container */
    .addon-collapse-wrapper {
        display: none;
        margin-bottom: 2rem;
    }

    .addon-collapse-wrapper.show {
        display: block;
        animation: fadeInDown 0.3s ease;
    }

    @keyframes fadeInDown {
        from {
            opacity: 0;
            transform: translateY(-8px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Category Accordion */
    .sim-cat-accordion {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        overflow: hidden;
        margin-bottom: 0.85rem;
        transition: all 0.2s ease;
    }

    .sim-cat-accordion.has-selected {
        border-color: #1E5FA8;
    }

    .accordion-head {
        padding: 0.95rem 1.25rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        cursor: pointer;
        background: #ffffff;
        user-select: none;
        transition: background 0.2s ease;
    }

    .accordion-head:hover {
        background: #f8fbff;
    }

    .accordion-head .head-left {
        display: flex;
        align-items: center;
        gap: 0.85rem;
    }

    .accordion-head .head-icon {
        font-size: 1.25rem;
        color: #1E5FA8;
    }

    .accordion-head .head-title {
        font-size: 0.95rem;
        font-weight: 700;
        color: #1e293b;
    }

    .accordion-head .head-desc {
        font-size: 0.76rem;
        color: #64748b;
    }

    .accordion-head .head-right {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .cat-count-badge {
        font-size: 0.72rem;
        font-weight: 700;
        background: #e0f2fe;
        color: #1E5FA8;
        padding: 0.25rem 0.65rem;
        border-radius: 999px;
    }

    .chevron-icon {
        font-size: 0.9rem;
        color: #64748b;
        transition: transform 0.25s ease;
    }

    .sim-cat-accordion.open .chevron-icon {
        transform: rotate(180deg);
        color: #1E5FA8;
    }

    .accordion-content {
        display: none;
        padding: 0.5rem 1rem 1rem 1rem;
        border-top: 1px solid #f1f5f9;
        background: #fcfdfe;
    }

    .sim-cat-accordion.open .accordion-content {
        display: block;
    }

    /* Addon Item Card Inside Category */
    .sim-addon-item {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 0.85rem 1rem;
        display: flex;
        flex-direction: column;
        cursor: pointer;
        transition: all 0.2s ease;
        margin-top: 0.5rem;
    }

    .sim-addon-item:hover {
        background: #f8fbff;
        border-color: #93c5fd;
    }

    .sim-addon-item.selected {
        background: #f0f7ff;
        border-color: #1E5FA8;
        box-shadow: 0 2px 10px rgba(30, 95, 168, 0.12);
    }

    .addon-item-main {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 0.85rem;
        width: 100%;
    }

    .sim-addon-left {
        display: flex;
        align-items: center;
        gap: 0.85rem;
        flex: 1;
    }

    .sim-addon-checkbox {
        width: 19px;
        height: 19px;
        accent-color: #1E5FA8;
        cursor: pointer;
        flex-shrink: 0;
    }

    .sim-addon-name {
        font-size: 0.92rem;
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 0.1rem;
    }

    .sim-addon-desc {
        font-size: 0.77rem;
        color: #64748b;
    }

    .sim-addon-right {
        display: flex;
        align-items: center;
        gap: 0.85rem;
        text-align: right;
    }

    .sim-addon-price {
        font-size: 0.92rem;
        font-weight: 700;
        color: #1E5FA8;
        white-space: nowrap;
    }

    .sim-addon-type-badge {
        font-size: 0.68rem;
        padding: 2px 6px;
        border-radius: 5px;
        font-weight: 600;
        display: inline-block;
        margin-left: 5px;
    }
    .badge-onetime {
        background: #e0f2fe;
        color: #0369a1;
    }
    .badge-monthly {
        background: #eff6ff;
        color: #1E5FA8;
        border: 1px solid #bfdbfe;
    }

    /* Sub-panel yang terbuka otomatis ketika item dipilih */
    .addon-expanded-panel {
        display: none;
        margin-top: 0.75rem;
        padding-top: 0.75rem;
        border-top: 1px dashed #bfdbfe;
        font-size: 0.82rem;
        color: #334155;
        animation: fadeIn 0.2s ease;
    }

    .sim-addon-item.selected .addon-expanded-panel {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .sim-addon-qty {
        width: 65px;
        padding: 0.25rem 0.4rem;
        font-size: 0.85rem;
        border: 1px solid #93c5fd;
        border-radius: 8px;
        text-align: center;
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    /* Duration / Period Selection */
    .sim-period-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 0.75rem;
        margin-bottom: 2rem;
    }

    .sim-period-card {
        background: #ffffff;
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        padding: 0.85rem 0.5rem;
        text-align: center;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .sim-period-card:hover {
        border-color: #93c5fd;
    }

    .sim-period-card.active {
        border-color: #1E5FA8;
        background: #f0f7ff;
        box-shadow: 0 4px 14px rgba(30, 95, 168, 0.16);
    }

    .sim-period-months {
        font-size: 0.95rem;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 0.15rem;
    }

    .sim-period-sub {
        font-size: 0.75rem;
        color: #94a3b8;
    }

    .sim-period-card.active .sim-period-sub {
        color: #1E5FA8;
        font-weight: 700;
    }

    /* Sticky Summary Card (Right Column) */
    .sim-summary-sticky {
        position: sticky;
        top: 95px;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 18px;
        padding: 1.6rem;
        box-shadow: 0 10px 30px rgba(15, 23, 42, 0.06);
    }

    .sim-summary-title {
        font-size: 1.15rem;
        font-weight: 800;
        color: #1E5FA8;
        margin-bottom: 1.25rem;
        padding-bottom: 0.75rem;
        border-bottom: 2px solid #f0f7ff;
    }

    .sim-summary-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 0.88rem;
        color: #475569;
        margin-bottom: 0.8rem;
    }

    .sim-summary-row .val {
        font-weight: 600;
        color: #0f172a;
    }

    .sim-summary-divider {
        height: 1px;
        background: #e2e8f0;
        margin: 1.15rem 0;
    }

    .sim-total-row {
        display: flex;
        justify-content: space-between;
        align-items: baseline;
        margin-bottom: 1.5rem;
    }

    .sim-total-label {
        font-size: 1.05rem;
        font-weight: 800;
        color: #0f172a;
    }

    .sim-total-val {
        font-size: 1.45rem;
        font-weight: 900;
        color: #1E5FA8;
        letter-spacing: -0.5px;
    }

    /* Buttons (Fibermedia Gradient Blue) */
    .btn-sim-order {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        background: linear-gradient(135deg, #1E5FA8 0%, #2575C0 100%);
        color: #ffffff !important;
        font-weight: 700;
        font-size: 1rem;
        padding: 0.85rem 1.5rem;
        border-radius: 12px;
        border: none;
        box-shadow: 0 6px 18px rgba(30, 95, 168, 0.28);
        transition: all 0.2s ease;
        text-decoration: none;
        gap: 0.5rem;
    }

    .btn-sim-order:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 24px rgba(30, 95, 168, 0.38);
    }

    .btn-sim-wa {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        background: #25d366;
        color: #ffffff !important;
        font-weight: 700;
        font-size: 0.92rem;
        padding: 0.75rem 1.25rem;
        border-radius: 12px;
        border: none;
        box-shadow: 0 4px 12px rgba(37, 211, 102, 0.25);
        transition: all 0.2s ease;
        text-decoration: none;
        margin-top: 0.75rem;
        gap: 0.5rem;
    }

    .btn-sim-wa:hover {
        background: #20bd5a;
        transform: translateY(-2px);
        box-shadow: 0 8px 18px rgba(37, 211, 102, 0.35);
    }

    .sim-disclaimer {
        font-size: 0.75rem;
        color: #94a3b8;
        text-align: center;
        margin-top: 1rem;
        line-height: 1.4;
    }

    /* Dark Mode Support */
    body.dark-mode .sim-title { color: #f8fafc; }
    body.dark-mode .sim-title span { color: #38bdf8; background: linear-gradient(135deg, #38bdf8 0%, #60a5fa 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
    body.dark-mode .sim-subtitle { color: #94a3b8; }
    body.dark-mode .sim-cat-btn { background: #1e293b; border-color: #334155; color: #cbd5e1; }
    body.dark-mode .sim-cat-btn:hover { background: #334155; color: #ffffff; }
    body.dark-mode .sim-cat-btn.active { background: linear-gradient(135deg, #1E5FA8 0%, #2575C0 100%); color: #ffffff; border-color: #2575C0; }
    body.dark-mode .sim-pkg-card { background: #111827; border-color: #1f2937; }
    body.dark-mode .sim-pkg-card.active { background: #0f1d36; border-color: #38bdf8; }
    body.dark-mode .sim-pkg-card .pkg-speed { color: #38bdf8; }
    body.dark-mode .sim-pkg-card .pkg-price { color: #f8fafc; }
    body.dark-mode .sim-detail-box { background: #111827; border-color: #1f2937; }
    body.dark-mode .sim-detail-box .detail-title { color: #f8fafc; }
    body.dark-mode .sim-detail-box li { color: #cbd5e1; }
    body.dark-mode .sim-section-label { color: #f8fafc; }
    body.dark-mode .sim-addon-master-card { background: #111827; border-color: #1f2937; }
    body.dark-mode .sim-addon-master-card.active { background: #0f1d36; border-color: #38bdf8; }
    body.dark-mode .master-title { color: #f8fafc; }
    body.dark-mode .master-icon { background: #0f1d36; color: #38bdf8; }
    body.dark-mode .sim-cat-accordion { background: #111827; border-color: #1f2937; }
    body.dark-mode .sim-cat-accordion.has-selected { border-color: #38bdf8; }
    body.dark-mode .accordion-head { background: #111827; }
    body.dark-mode .accordion-head:hover { background: #1f2937; }
    body.dark-mode .accordion-head .head-title { color: #f8fafc; }
    body.dark-mode .accordion-head .head-icon { color: #38bdf8; }
    body.dark-mode .accordion-content { background: #0f172a; border-top-color: #1f2937; }
    body.dark-mode .sim-addon-item { background: #1e293b; border-color: #334155; }
    body.dark-mode .sim-addon-item.selected { background: #0f1d36; border-color: #38bdf8; }
    body.dark-mode .sim-addon-name { color: #f8fafc; }
    body.dark-mode .sim-addon-price { color: #38bdf8; }
    body.dark-mode .addon-expanded-panel { border-top-color: #334155; color: #cbd5e1; }
    body.dark-mode .sim-period-card { background: #111827; border-color: #1f2937; }
    body.dark-mode .sim-period-card.active { background: #0f1d36; border-color: #38bdf8; }
    body.dark-mode .sim-period-card.active .sim-period-sub { color: #38bdf8; }
    body.dark-mode .sim-period-months { color: #f8fafc; }
    body.dark-mode .sim-summary-sticky { background: #111827; border-color: #1f2937; box-shadow: 0 10px 30px rgba(0,0,0,0.4); }
    body.dark-mode .sim-summary-title { color: #38bdf8; border-bottom-color: #1f2937; }
    body.dark-mode .sim-summary-row { color: #94a3b8; }
    body.dark-mode .sim-summary-row .val { color: #f8fafc; }
    body.dark-mode .sim-summary-divider { background: #1f2937; }
    body.dark-mode .sim-total-label { color: #f8fafc; }
    body.dark-mode .sim-total-val { color: #38bdf8; }

    @media (max-width: 991.98px) {
        .sim-summary-sticky {
            position: static;
            margin-top: 2rem;
        }
        .sim-period-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }
</style>
@endpush

@section('content')
<div class="container sim-wrapper">
    {{-- Header --}}
    <div class="sim-header">
        <h1 class="sim-title">Simulasi <span>Biaya Langganan</span></h1>
        <p class="sim-subtitle">Hitung estimasi total biaya langganan internet Anda dengan mudah, akurat, dan transparan.</p>
    </div>

    <div class="row g-4">
        {{-- Left Form Panel --}}
        <div class="col-lg-8">
            {{-- 1. Kategori Tab --}}
            <div class="sim-cat-tabs">
                @foreach($categories as $catKey => $catLabel)
                    <button type="button" class="sim-cat-btn {{ $loop->first ? 'active' : '' }}" data-category="{{ $catKey }}" onclick="filterCategory('{{ $catKey }}', this)">
                        {{ $catLabel }}
                    </button>
                @endforeach
            </div>

            {{-- 2. Package Selector Cards --}}
            <div class="sim-section-label">
                <span>Pilih Paket Internet</span>
                <span class="sim-section-tag" id="activeCategoryText">Semua Paket</span>
            </div>

            <div class="sim-pkg-grid" id="packageGrid">
                @forelse($packages as $pkg)
                    <div class="sim-pkg-card {{ (int) $pkg->id === (int) $preselectedId ? 'active' : '' }}"
                         data-id="{{ $pkg->id }}"
                         data-slug="{{ $pkg->slug }}"
                         data-category="{{ $pkg->category ?? 'other' }}"
                         data-name="{{ $pkg->name }}"
                         data-speed="{{ $pkg->speed_mbps }}"
                         data-price="{{ (float) $pkg->price_monthly }}"
                         data-devices="{{ $pkg->device_ideal ?? ($pkg->min_users && $pkg->max_users ? $pkg->min_users . '-' . $pkg->max_users . ' Perangkat' : 'Ideal untuk keluarga') }}"
                         data-best-for="{{ $pkg->best_for ?? 'Streaming, Browsing & Gaming' }}"
                         onclick="selectPackage({{ $pkg->id }})">
                        <div class="active-indicator"><i class="bi bi-check-lg"></i></div>
                        <div class="pkg-speed">{{ $pkg->speed_mbps }} Mbps</div>
                        <div class="pkg-price">Rp {{ number_format($pkg->price_monthly, 0, ',', '.') }} <span>/bln</span></div>
                        <div class="pkg-name" title="{{ $pkg->name }}">{{ $pkg->name }}</div>
                    </div>
                @empty
                    <div class="alert alert-info w-100">Belum ada paket internet aktif yang tersedia saat ini.</div>
                @endforelse
            </div>

            {{-- 3. Selected Package Detail Box --}}
            <div class="sim-detail-box" id="packageDetailBox">
                <div class="detail-title">
                    <i class="bi bi-info-circle-fill text-primary"></i>
                    <span>Detail Paket: <strong id="detailPkgName">-</strong> (<span id="detailPkgSpeed">-</span> Mbps)</span>
                </div>
                <ul id="detailPkgFeatures">
                    <li><i class="bi bi-check-circle-fill"></i> <span id="detailPkgDevices">Ideal perangkat: -</span></li>
                    <li><i class="bi bi-check-circle-fill"></i> <span>Free Wi-Fi Router &amp; Instalasi</span></li>
                    <li><i class="bi bi-check-circle-fill"></i> <span>Internet Unlimited Tanpa FUP</span></li>
                    <li><i class="bi bi-check-circle-fill"></i> <span id="detailPkgBestFor">Cocok untuk kebutuhan keluarga</span></li>
                </ul>
            </div>

            {{-- 4. Layanan Tambahan (Add-on) with Toggle Master & Accordion --}}
            <div class="sim-section-label">
                <span>Layanan Tambahan (Add-on)</span>
            </div>

            {{-- Master Switch Card --}}
            <div class="sim-addon-master-card" id="masterAddonCard" onclick="toggleMasterAddon(event)">
                <div class="master-left">
                    <div class="master-icon">
                        <i class="bi bi-box-seam-fill"></i>
                    </div>
                    <div>
                        <div class="master-title">Tambahkan Layanan Tambahan (Add-on)?</div>
                        <div class="master-subtitle">Pilih perangkat tambahan, STB TV, streaming, atau smart home</div>
                    </div>
                </div>
                <div class="master-right">
                    <span class="badge-selected-count d-none" id="masterBadgeCount">0 Dipilih</span>
                    <div class="form-check form-switch custom-master-switch" onclick="event.stopPropagation()">
                        <input class="form-check-input" type="checkbox" id="masterAddonSwitch" onchange="onMasterSwitchToggle(this.checked)">
                    </div>
                </div>
            </div>

            {{-- Collapsible Container for Addons --}}
            <div class="addon-collapse-wrapper" id="addonCollapseWrapper">
                @foreach($groupedAddons as $catKey => $items)
                    @php
                        $meta = $addonMeta[$catKey] ?? [
                            'name' => ucwords(str_replace(['_', '-'], ' ', $catKey)),
                            'icon' => 'bi-box',
                            'desc' => 'Pilihan item tambahan',
                        ];
                    @endphp
                    <div class="sim-cat-accordion" id="accordionCat-{{ $catKey }}">
                        <div class="accordion-head" onclick="toggleCatAccordion('{{ $catKey }}')">
                            <div class="head-left">
                                <i class="bi {{ $meta['icon'] }} head-icon"></i>
                                <div>
                                    <div class="head-title">{{ $meta['name'] }} <small class="text-muted">({{ $items->count() }})</small></div>
                                    <div class="head-desc">{{ $meta['desc'] }}</div>
                                </div>
                            </div>
                            <div class="head-right">
                                <span class="cat-count-badge d-none" id="catBadge-{{ $catKey }}">0 dipilih</span>
                                <i class="bi bi-chevron-down chevron-icon"></i>
                            </div>
                        </div>

                        <div class="accordion-content">
                            @foreach($items as $addon)
                                @php
                                    $isCable = str_contains(strtolower($addon->name), 'kabel');
                                    $isMonthly = $addon->pricing_type === 'monthly';
                                @endphp
                                <div class="sim-addon-item" id="addonRow-{{ $addon->id }}" onclick="toggleAddonItem({{ $addon->id }}, '{{ $catKey }}', event)">
                                    <div class="addon-item-main">
                                        <div class="sim-addon-left">
                                            <input type="checkbox"
                                                   class="sim-addon-checkbox"
                                                   id="addonCb-{{ $addon->id }}"
                                                   data-id="{{ $addon->id }}"
                                                   data-category="{{ $catKey }}"
                                                   data-name="{{ $addon->name }}"
                                                   data-price="{{ (float) $addon->price }}"
                                                   data-pricing-type="{{ $addon->pricing_type }}"
                                                   data-is-cable="{{ $isCable ? '1' : '0' }}"
                                                   onchange="onAddonCheckboxChange({{ $addon->id }}, '{{ $catKey }}')">
                                            <div>
                                                <div class="sim-addon-name">
                                                    {{ $addon->name }}
                                                    <span class="sim-addon-type-badge {{ $isMonthly ? 'badge-monthly' : 'badge-onetime' }}">
                                                        {{ $isMonthly ? 'Bulanan' : 'Sekali Bayar' }}
                                                    </span>
                                                </div>
                                                @if(!empty($addon->short_description))
                                                    <div class="sim-addon-desc">{{ $addon->short_description }}</div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="sim-addon-right">
                                            <div class="sim-addon-price">
                                                Rp {{ number_format($addon->price, 0, ',', '.') }}
                                                @if($isCable)
                                                    <span class="text-muted fw-normal fs-7">/m</span>
                                                @elseif($isMonthly)
                                                    <span class="text-muted fw-normal fs-7">/bln</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Sub panel yang terbuka otomatis ketika item dipilih --}}
                                    <div class="addon-expanded-panel" onclick="event.stopPropagation()">
                                        @if($isCable)
                                            <div class="d-flex align-items-center gap-2">
                                                <label for="addonQty-{{ $addon->id }}" class="mb-0 fw-semibold text-primary">Panjang Kabel:</label>
                                                <input type="number"
                                                       min="1"
                                                       max="200"
                                                       value="1"
                                                       class="sim-addon-qty"
                                                       id="addonQty-{{ $addon->id }}"
                                                       oninput="recalculate()">
                                                <span class="fw-semibold">meter</span>
                                            </div>
                                            <div class="text-muted fs-8">Dihitung Rp {{ number_format($addon->price, 0, ',', '.') }} per meter</div>
                                        @else
                                            <div class="d-flex align-items-center gap-1 text-primary">
                                                <i class="bi bi-check2-circle"></i>
                                                <span>Layanan ini aktif dalam simulasi langganan Anda</span>
                                            </div>
                                            <div class="text-muted fs-8">Termasuk instalasi &amp; aktivasi</div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- 5. Periode Berlangganan --}}
            <div class="sim-section-label">
                <span>Periode Berlangganan</span>
                <span class="sim-section-tag">Pilih durasi</span>
            </div>

            <div class="sim-period-grid">
                <div class="sim-period-card active" data-months="1" data-discount="0" onclick="selectPeriod(1, 0, this)">
                    <div class="sim-period-months">1 Bulan</div>
                    <div class="sim-period-sub">Standar</div>
                </div>
                <div class="sim-period-card" data-months="3" data-discount="0" onclick="selectPeriod(3, 0, this)">
                    <div class="sim-period-months">3 Bulan</div>
                    <div class="sim-period-sub">Tanpa diskon</div>
                </div>
                <div class="sim-period-card" data-months="6" data-discount="5" onclick="selectPeriod(6, 5, this)">
                    <div class="sim-period-months">6 Bulan</div>
                    <div class="sim-period-sub">Hemat 5%</div>
                </div>
                <div class="sim-period-card" data-months="12" data-discount="10" onclick="selectPeriod(12, 10, this)">
                    <div class="sim-period-months">12 Bulan</div>
                    <div class="sim-period-sub">Hemat 10%</div>
                </div>
            </div>
        </div>

        {{-- Right Sticky Summary Panel --}}
        <div class="col-lg-4">
            <div class="sim-summary-sticky">
                <div class="sim-summary-title">Ringkasan Biaya</div>

                <div class="sim-summary-row">
                    <span>Biaya Bulanan Paket</span>
                    <span class="val" id="sumPkgPrice">Rp 0</span>
                </div>

                <div class="sim-summary-row">
                    <span>Layanan Tambahan</span>
                    <span class="val" id="sumAddonPrice">Rp 0</span>
                </div>

                <div class="sim-summary-row">
                    <span>Periode</span>
                    <span class="val" id="sumPeriod">1 Bulan</span>
                </div>

                <div class="sim-summary-row">
                    <span>Subtotal</span>
                    <span class="val" id="sumSubtotal">Rp 0</span>
                </div>

                <div class="sim-summary-row">
                    <span>Diskon Periode</span>
                    <span class="val text-success" id="sumDiscount">Rp 0</span>
                </div>

                <div class="sim-summary-divider"></div>

                <div class="sim-total-row">
                    <span class="sim-total-label">Total Pembayaran:</span>
                    <span class="sim-total-val" id="sumTotal">Rp 0</span>
                </div>

                {{-- Direct Order Form (Langsung ke Step 2 Isi Data Pelanggan) --}}
                <form id="formOrderDirect" action="{{ route('public.order.storeStep1') }}" method="POST">
                    @csrf
                    <input type="hidden" name="package_id" id="orderFormPackageId" value="">
                    <input type="hidden" name="duration_months" id="orderFormDuration" value="1">
                    <div id="orderFormAddonsContainer"></div>

                    <button type="submit" class="btn-sim-order">
                        <i class="bi bi-cart-check-fill"></i>
                        <span>Langganan Sekarang</span>
                    </button>
                </form>

                <div class="sim-disclaimer">
                    Harga sudah termasuk PPN. Data perhitungan berdasarkan promo dan ketentuan yang berlaku saat ini.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // State
    const packagesData = @json($packages);
    const addonsData = @json($addons);
    const whatsappBase = "{{ $whatsappNumber }}";
    const orderStartUrl = "{{ route('public.order.step1') }}";

    let selectedPackage = null;
    let selectedPeriodMonths = 1;
    let selectedPeriodDiscountPercent = 0;

    // Helper currency formatter
    function formatRupiah(amount) {
        return 'Rp ' + Number(amount || 0).toLocaleString('id-ID');
    }

    // Filter packages by category tabs
    function filterCategory(categoryKey, btn) {
        document.querySelectorAll('.sim-cat-btn').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');

        const activeTextEl = document.getElementById('activeCategoryText');
        if (activeTextEl) {
            activeTextEl.textContent = btn.textContent.trim();
        }

        const cards = document.querySelectorAll('.sim-pkg-card');
        let firstVisibleCard = null;

        cards.forEach(card => {
            const cardCat = card.getAttribute('data-category');
            if (categoryKey === 'all' || cardCat === categoryKey) {
                card.style.display = 'block';
                if (!firstVisibleCard) firstVisibleCard = card;
            } else {
                card.style.display = 'none';
            }
        });

        // If currently selected package is hidden in this category, select the first visible package
        if (selectedPackage) {
            const currentCard = document.querySelector(`.sim-pkg-card[data-id="${selectedPackage.id}"]`);
            if (currentCard && currentCard.style.display === 'none' && firstVisibleCard) {
                const newId = parseInt(firstVisibleCard.getAttribute('data-id'), 10);
                selectPackage(newId);
            }
        }
    }

    // Select a package card
    function selectPackage(packageId) {
        const pkg = packagesData.find(p => Number(p.id) === Number(packageId));
        if (!pkg) return;

        selectedPackage = pkg;

        // UI active class
        document.querySelectorAll('.sim-pkg-card').forEach(card => {
            if (Number(card.getAttribute('data-id')) === Number(packageId)) {
                card.classList.add('active');
            } else {
                card.classList.remove('active');
            }
        });

        // Update Detail Box
        document.getElementById('detailPkgName').textContent = pkg.name;
        document.getElementById('detailPkgSpeed').textContent = pkg.speed_mbps;
        document.getElementById('detailPkgDevices').textContent = 'Ideal untuk: ' + (pkg.device_ideal || (pkg.min_users && pkg.max_users ? pkg.min_users + '-' + pkg.max_users + ' Perangkat' : 'Keluarga'));
        document.getElementById('detailPkgBestFor').textContent = 'Rekomendasi: ' + (pkg.best_for || 'Browsing, Streaming & Gaming lancar');

        recalculate();
    }

    /* =========================================================
       MASTER ADDON TOGGLE & ACCORDION (BUKA / NUTUP)
       ========================================================= */
    function toggleMasterAddon(event) {
        const switchEl = document.getElementById('masterAddonSwitch');
        switchEl.checked = !switchEl.checked;
        onMasterSwitchToggle(switchEl.checked);
    }

    function onMasterSwitchToggle(isOpen) {
        const masterCard = document.getElementById('masterAddonCard');
        const wrapper = document.getElementById('addonCollapseWrapper');

        if (isOpen) {
            masterCard.classList.add('active');
            wrapper.classList.add('show');
            // Auto open first accordion category if none open
            const firstAccordion = document.querySelector('.sim-cat-accordion');
            if (firstAccordion && !document.querySelector('.sim-cat-accordion.open')) {
                firstAccordion.classList.add('open');
            }
        } else {
            masterCard.classList.remove('active');
            wrapper.classList.remove('show');
        }
    }

    // Toggle specific category accordion
    function toggleCatAccordion(catKey) {
        const accordion = document.getElementById('accordionCat-' + catKey);
        if (accordion) {
            accordion.classList.toggle('open');
        }
    }

    // Toggle single addon item click
    function toggleAddonItem(addonId, catKey, event) {
        // Prevent recursive trigger when clicking directly on checkbox or input
        if (event.target.tagName.toLowerCase() === 'input') return;

        const cb = document.getElementById('addonCb-' + addonId);
        if (cb) {
            cb.checked = !cb.checked;
            onAddonCheckboxChange(addonId, catKey);
        }
    }

    function onAddonCheckboxChange(addonId, catKey) {
        const cb = document.getElementById('addonCb-' + addonId);
        const row = document.getElementById('addonRow-' + addonId);

        if (cb && row) {
            if (cb.checked) {
                row.classList.add('selected');

                // If user checked an item, ensure master switch is ON and this category is OPEN
                const masterSwitch = document.getElementById('masterAddonSwitch');
                if (!masterSwitch.checked) {
                    masterSwitch.checked = true;
                    onMasterSwitchToggle(true);
                }

                const catAccordion = document.getElementById('accordionCat-' + catKey);
                if (catAccordion && !catAccordion.classList.contains('open')) {
                    catAccordion.classList.add('open');
                }
            } else {
                row.classList.remove('selected');
            }
        }

        updateAddonBadges();
        recalculate();
    }

    // Update counter badges for categories & master switch
    function updateAddonBadges() {
        const checkedBoxes = document.querySelectorAll('.sim-addon-checkbox:checked');
        const totalChecked = checkedBoxes.length;

        // Master badge
        const masterBadge = document.getElementById('masterBadgeCount');
        if (totalChecked > 0) {
            masterBadge.textContent = `${totalChecked} Dipilih`;
            masterBadge.classList.remove('d-none');
        } else {
            masterBadge.classList.add('d-none');
        }

        // Category badges
        const catMap = {};
        checkedBoxes.forEach(cb => {
            const cat = cb.getAttribute('data-category');
            catMap[cat] = (catMap[cat] || 0) + 1;
        });

        document.querySelectorAll('.sim-cat-accordion').forEach(acc => {
            const catKey = acc.id.replace('accordionCat-', '');
            const badge = document.getElementById('catBadge-' + catKey);
            const count = catMap[catKey] || 0;

            if (count > 0) {
                acc.classList.add('has-selected');
                if (badge) {
                    badge.textContent = `${count} dipilih`;
                    badge.classList.remove('d-none');
                }
            } else {
                acc.classList.remove('has-selected');
                if (badge) {
                    badge.classList.add('d-none');
                }
            }
        });
    }

    // Select Subscription Period
    function selectPeriod(months, discountPercent, el) {
        selectedPeriodMonths = Number(months);
        selectedPeriodDiscountPercent = Number(discountPercent);

        document.querySelectorAll('.sim-period-card').forEach(c => c.classList.remove('active'));
        el.classList.add('active');

        recalculate();
    }

    // Calculate All Totals Realtime
    function recalculate() {
        if (!selectedPackage) return;

        const monthlyPkgPrice = Number(selectedPackage.price_monthly) || 0;
        const totalPackageCost = monthlyPkgPrice * selectedPeriodMonths;

        // Addons cost
        let totalAddonsCost = 0;
        let selectedAddonNames = [];
        let selectedAddonIds = [];

        document.querySelectorAll('.sim-addon-checkbox:checked').forEach(cb => {
            const addonId = cb.getAttribute('data-id');
            const addonName = cb.getAttribute('data-name');
            const basePrice = Number(cb.getAttribute('data-price')) || 0;
            const pricingType = cb.getAttribute('data-pricing-type');
            const isCable = cb.getAttribute('data-is-cable') === '1';

            let qty = 1;
            if (isCable) {
                const qtyInput = document.getElementById('addonQty-' + addonId);
                qty = qtyInput ? (Math.max(1, parseInt(qtyInput.value, 10) || 1)) : 1;
            }

            let itemCost = 0;
            if (pricingType === 'monthly') {
                itemCost = basePrice * qty * selectedPeriodMonths;
            } else {
                itemCost = basePrice * qty; // one_time
            }

            totalAddonsCost += itemCost;
            selectedAddonIds.push(addonId);
            selectedAddonNames.push(`${addonName}${isCable ? ' (' + qty + 'm)' : ''}`);
        });

        // Subtotal before discount
        const subtotal = totalPackageCost + totalAddonsCost;

        // Discount applied to package cost
        const discountAmount = Math.round((totalPackageCost * selectedPeriodDiscountPercent) / 100);
        const finalTotal = Math.max(0, subtotal - discountAmount);

        // Update Summary DOM
        document.getElementById('sumPkgPrice').textContent = formatRupiah(monthlyPkgPrice) + (selectedPeriodMonths > 1 ? ` (x${selectedPeriodMonths} bln)` : '');
        document.getElementById('sumAddonPrice').textContent = formatRupiah(totalAddonsCost);
        document.getElementById('sumPeriod').textContent = `${selectedPeriodMonths} Bulan`;
        document.getElementById('sumSubtotal').textContent = formatRupiah(subtotal);
        document.getElementById('sumDiscount').textContent = discountAmount > 0 ? `-${formatRupiah(discountAmount)} (${selectedPeriodDiscountPercent}%)` : 'Rp 0';
        document.getElementById('sumTotal').textContent = formatRupiah(finalTotal);

        // Update Direct Order Form (Langsung ke Step 2 Isi Data Diri)
        const formPkgInput = document.getElementById('orderFormPackageId');
        if (formPkgInput) formPkgInput.value = selectedPackage.id;

        const formDurInput = document.getElementById('orderFormDuration');
        if (formDurInput) formDurInput.value = selectedPeriodMonths;

        const formAddonsContainer = document.getElementById('orderFormAddonsContainer');
        if (formAddonsContainer) {
            formAddonsContainer.innerHTML = '';
            selectedAddonIds.forEach(id => {
                const hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = 'addon_ids[]';
                hiddenInput.value = id;
                formAddonsContainer.appendChild(hiddenInput);
            });
        }

    }

    // Initialize on page load
    document.addEventListener('DOMContentLoaded', function () {
        const initialId = {{ $preselectedId ?? 'null' }};
        if (initialId) {
            selectPackage(initialId);
        } else if (packagesData.length > 0) {
            selectPackage(packagesData[0].id);
        }
    });
</script>
@endpush
