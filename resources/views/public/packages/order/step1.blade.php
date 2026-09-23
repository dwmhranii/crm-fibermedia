@extends('public.layouts.public')

@section('content')
<style>
.order-wrap {
    max-width: 1100px;
    margin: 0 auto;
    padding: 1.5rem 1rem 3rem;
}

/* ===================== STEPPER ===================== */
.order-steps {
    display: flex;
    justify-content: center;
    align-items: flex-start;
    gap: 12px;
    margin-bottom: 1.75rem;
    flex-wrap: nowrap;
}

.order-step {
    display: flex;
    flex-direction: column;
    align-items: center;
    min-width: 60px;
    flex: 0 0 auto;
}

.order-step-badge {
    width: 42px;
    height: 42px;
    border-radius: 999px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border: 2px solid #cbd5e1;
    background: #fff;
    color: #475569;
    font-weight: 800;
    font-size: 16px;
    box-shadow: 0 4px 10px rgba(15, 23, 42, .05);
}

.order-step-text {
    margin-top: 6px;
    font-size: 13px;
    font-weight: 600;
    color: #64748b;
    text-align: center;
    line-height: 1.2;
}

.order-step-line {
    width: 70px;
    height: 3px;
    border-radius: 999px;
    background: #e2e8f0;
    margin-top: 19px;
    flex: 0 0 auto;
}

.order-step.active .order-step-badge,
.order-step.done .order-step-badge {
    background: linear-gradient(135deg, #1E5FA8, #2575C0);
    border-color: #1E5FA8;
    color: #fff;
    box-shadow: 0 6px 16px rgba(30, 95, 168, .28);
}

.order-step.active .order-step-text,
.order-step.done .order-step-text {
    color: #1E5FA8;
    font-weight: 700;
}

.order-card {
    background: #fff;
    border: 1px solid #e2e8f0;
    border-radius: 24px;
    padding: 1.75rem;
    box-shadow: 0 10px 30px rgba(15, 23, 42, .05);
}

.order-header {
    text-align: center;
    margin-bottom: 1.25rem;
}

.order-title {
    font-size: 2rem;
    font-weight: 800;
    color: #1E5FA8;
    margin-bottom: .25rem;
}

.order-subtitle {
    color: #64748b;
    font-size: .92rem;
}

/* ===================== TYPE TABS ===================== */
.order-tabs {
    max-width: 380px;
    margin: 0 auto .85rem;
    display: flex;
    gap: 6px;
    background: #f1f5f9;
    padding: 4px;
    border-radius: 999px;
    border: 1px solid #e2e8f0;
}

.order-tab {
    flex: 1;
    text-align: center;
    padding: 7px 14px;
    border-radius: 999px;
    text-decoration: none;
    font-weight: 700;
    font-size: 0.85rem;
    color: #475569;
    background: transparent;
    transition: all .22s ease;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
}

.order-tab:hover {
    color: #1E5FA8;
}

.order-tab.active {
    background: linear-gradient(135deg, #1E5FA8, #2575C0);
    color: #fff;
    box-shadow: 0 4px 14px rgba(30, 95, 168, .28);
}

/* ===================== CATEGORY FILTER BUTTONS ===================== */
.order-filter-menu {
    display: flex;
    justify-content: center;
    gap: 6px;
    flex-wrap: wrap;
    margin-bottom: 1.15rem;
}

.order-filter-btn {
    padding: 6px 14px;
    border-radius: 999px;
    background: #ffffff;
    color: #334155;
    text-decoration: none;
    text-align: center;
    font-weight: 600;
    font-size: .82rem;
    border: 1px solid #e2e8f0;
    transition: all .22s ease;
    display: inline-flex;
    align-items: center;
    gap: 5px;
    box-shadow: 0 2px 4px rgba(15, 23, 42, .03);
    white-space: nowrap;
}

.order-filter-btn:hover {
    color: #1E5FA8;
    border-color: #cbd5e1;
    transform: translateY(-1px);
}

.order-filter-btn.active {
    background: linear-gradient(135deg, #1E5FA8, #2575C0);
    color: #fff;
    border-color: transparent;
    box-shadow: 0 4px 14px rgba(30, 95, 168, .25);
}

/* ===================== FILTER SEARCH BAR ===================== */
.order-search-box {
    background: linear-gradient(135deg, #f8fbff, #f0fdf4);
    border: 1px solid #dbeafe;
    border-radius: 16px;
    padding: .75rem 1rem;
    margin-bottom: 1.5rem;
}

.order-search-row {
    display: flex;
    gap: 8px;
    align-items: center;
    flex-wrap: wrap;
}

.order-search-input-group {
    flex: 1 1 200px;
    display: flex !important;
    flex-wrap: nowrap !important;
}

.order-search-input-group .input-group-text {
    background: #fff;
    border-color: #cbd5e1;
    border-right: 0;
    border-radius: 10px 0 0 10px;
    padding: 0 10px;
    display: flex;
    align-items: center;
}

.order-search-input {
    height: 38px;
    border-radius: 0 10px 10px 0 !important;
    border: 1px solid #cbd5e1;
    border-left: 0;
    font-size: .84rem;
    color: #0f172a;
    background: #fff;
    width: 100%;
}

.order-search-input:focus {
    outline: none;
    border-color: #1E5FA8;
    box-shadow: none;
}

.order-filter-select {
    max-width: 190px;
    height: 38px;
    border-radius: 10px;
    border: 1px solid #cbd5e1;
    font-size: .84rem;
    color: #0f172a;
    box-shadow: none !important;
}

.order-filter-select:focus {
    border-color: #1E5FA8;
    box-shadow: 0 0 0 0.15rem rgba(30, 95, 168, .12) !important;
}

.btn-order-apply {
    height: 38px;
    padding: 0 16px;
    border-radius: 999px;
    border: 0;
    font-size: .82rem;
    font-weight: 600;
    background: linear-gradient(135deg, #1E5FA8, #2575C0);
    color: #fff;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    transition: .2s ease;
    box-shadow: 0 4px 12px rgba(30, 95, 168, .2);
}

.btn-order-apply:hover {
    color: #fff;
    transform: translateY(-1px);
}

.btn-order-reset {
    height: 38px;
    padding: 0 14px;
    border-radius: 999px;
    font-size: .82rem;
    font-weight: 600;
}

.package-section-title {
    text-align: center;
    font-size: 1.35rem;
    font-weight: 800;
    color: #1E5FA8;
    margin-bottom: .2rem;
}

.package-section-sub {
    text-align: center;
    color: #64748b;
    font-size: .85rem;
    margin-bottom: 1.25rem;
}

/* ===================== COMPACT INTUITIVE PACKAGE CARDS ===================== */
.package-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 14px;
}

.package-option {
    position: relative;
    display: flex;
    flex-direction: column;
}

.package-radio {
    position: absolute;
    opacity: 0;
    pointer-events: none;
}

.package-card {
    border: 1.5px solid #e2e8f0;
    background: #ffffff;
    border-radius: 16px;
    padding: 1rem 1rem .85rem;
    min-height: 100%;
    cursor: pointer;
    transition: all .22s ease;
    position: relative;
    display: flex;
    flex-direction: column;
    box-shadow: 0 2px 8px rgba(15, 23, 42, .03);
}

.package-card:hover {
    transform: translateY(-3px);
    border-color: #93c5fd;
    box-shadow: 0 10px 22px rgba(30, 95, 168, .09);
}

/* SELECTED STATE */
.package-radio:checked + .package-card {
    border-color: #1E5FA8;
    background: linear-gradient(180deg, #f0f7ff 0%, #ffffff 100%);
    box-shadow: 0 0 0 3px rgba(30, 95, 168, .18), 0 12px 26px rgba(30, 95, 168, .12);
}

/* TOP HEADER OF CARD */
.pkg-card-top {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: .6rem;
}

.pkg-speed-pill {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    padding: 3px 8px;
    border-radius: 999px;
    background: #ecfdf5;
    color: #065f46;
    border: 1px solid #a7f3d0;
    font-size: .78rem;
    font-weight: 800;
}

.pkg-radio-indicator {
    width: 20px;
    height: 20px;
    border-radius: 999px;
    border: 2px solid #cbd5e1;
    background: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all .2s ease;
    flex-shrink: 0;
}

.pkg-radio-indicator i {
    display: none;
    font-size: 11px;
    color: #fff;
}

.package-radio:checked + .package-card .pkg-radio-indicator {
    border-color: #1E5FA8;
    background: linear-gradient(135deg, #1E5FA8, #2575C0);
    box-shadow: 0 2px 6px rgba(30, 95, 168, .35);
}

.package-radio:checked + .package-card .pkg-radio-indicator i {
    display: block;
}

/* PACKAGE INFO */
.package-name {
    font-size: .95rem;
    font-weight: 800;
    color: #1e293b;
    margin-bottom: .3rem;
    line-height: 1.3;
}

.package-price-wrap {
    display: flex;
    align-items: baseline;
    gap: 3px;
    margin-bottom: .55rem;
    padding-bottom: .45rem;
    border-bottom: 1px dashed #e2e8f0;
}

.package-price-val {
    font-size: 1.3rem;
    font-weight: 900;
    color: #1E5FA8;
    line-height: 1;
}

.package-price-unit {
    font-size: .78rem;
    color: #64748b;
    font-weight: 600;
}

/* FEATURES COMPACT */
.package-features-list {
    margin: 0;
    padding: 0;
    list-style: none;
    display: flex;
    flex-direction: column;
    gap: 4px;
    margin-bottom: .75rem;
    flex-grow: 1;
}

.package-feature-item {
    font-size: .78rem;
    color: #475569;
    display: flex;
    align-items: flex-start;
    gap: 5px;
    line-height: 1.35;
}

.package-feature-item i {
    color: #10b981;
    font-size: .85rem;
    flex-shrink: 0;
    margin-top: 1px;
}

/* SELECT STATUS FOOTER */
.pkg-status-btn {
    text-align: center;
    padding: 6px 10px;
    border-radius: 8px;
    font-size: .76rem;
    font-weight: 700;
    transition: all .2s ease;
    border: 1px solid #e2e8f0;
    background: #f8fafc;
    color: #64748b;
}

.package-radio:checked + .package-card .pkg-status-btn {
    background: linear-gradient(135deg, #1E5FA8, #2575C0);
    border-color: transparent;
    color: #fff;
    box-shadow: 0 3px 10px rgba(30, 95, 168, .25);
}

.order-footer {
    display: flex;
    justify-content: flex-end;
    margin-top: 1.75rem;
    padding-top: 1rem;
    border-top: 1px solid #e2e8f0;
}

.btn-order-next {
    border-radius: 999px;
    padding: 10px 32px;
    font-weight: 700;
    font-size: .92rem;
    background: linear-gradient(135deg, #1E5FA8, #2575C0);
    color: #fff;
    border: 0;
    box-shadow: 0 8px 20px rgba(30, 95, 168, .22);
    transition: .2s ease;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}

.btn-order-next:hover {
    color: #fff;
    transform: translateY(-1px);
    box-shadow: 0 12px 26px rgba(30, 95, 168, .3);
}

/* ===================== DARK MODE ===================== */
body.dark-mode .order-card {
    background: #0f172a;
    border-color: #1e293b;
    box-shadow: 0 18px 45px rgba(0,0,0,.6);
}

body.dark-mode .order-tabs {
    background: #0b1329;
    border-color: #1e293b;
}

body.dark-mode .order-tab {
    color: #94a3b8;
}

body.dark-mode .order-tab.active {
    color: #fff;
}

body.dark-mode .order-filter-btn {
    background: #1e293b;
    color: #cbd5e1;
    border-color: #334155;
}

body.dark-mode .order-filter-btn:hover {
    color: #fff;
    border-color: #3b82f6;
}

body.dark-mode .order-filter-btn.active {
    background: linear-gradient(135deg, #1E5FA8, #2575C0);
    color: #fff;
    border-color: transparent;
}

body.dark-mode .order-search-box {
    background: linear-gradient(135deg, #021021, #02260e);
    border-color: #1f2937;
}

body.dark-mode .order-search-input,
body.dark-mode .order-filter-select,
body.dark-mode .order-search-input-group .input-group-text {
    background: #0f172a;
    color: #e5e7eb;
    border-color: #243041;
}

body.dark-mode .order-title,
body.dark-mode .package-section-title {
    color: #e5e7eb;
}

body.dark-mode .package-card {
    background: #1e293b;
    border-color: #334155;
    box-shadow: none;
}

body.dark-mode .package-radio:checked + .package-card {
    border-color: #3b82f6;
    background: linear-gradient(180deg, rgba(30, 95, 168, 0.25) 0%, #1e293b 100%);
    box-shadow: 0 0 0 3px rgba(59, 130, 246, .25);
}

body.dark-mode .package-name {
    color: #f1f5f9;
}

body.dark-mode .package-feature-item {
    color: #cbd5e1;
}

body.dark-mode .package-price-wrap {
    border-bottom-color: #334155;
}

body.dark-mode .pkg-status-btn {
    background: #0f172a;
    border-color: #334155;
    color: #94a3b8;
}

body.dark-mode .pkg-speed-pill {
    background: rgba(16, 185, 129, 0.15);
    border-color: rgba(16, 185, 129, 0.3);
    color: #34d399;
}

/* ===================== RESPONSIVE (MOBILE & TABLET) ===================== */
@media (max-width: 1100px) {
    .package-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 576px) {
    .order-wrap {
        padding: .75rem .4rem 2rem;
    }

    .order-steps {
        gap: 6px;
        margin-bottom: 1.15rem;
    }

    .order-step {
        min-width: 48px;
    }

    .order-step-badge {
        width: 34px;
        height: 34px;
        font-size: 14px;
    }

    .order-step-text {
        font-size: 11px;
        margin-top: 4px;
    }

    .order-step-line {
        width: 24px;
        height: 2px;
        margin-top: 16px;
    }

    .order-card {
        padding: 1rem .85rem;
        border-radius: 18px;
    }

    .order-header {
        margin-bottom: .85rem;
    }

    .order-title {
        font-size: 1.35rem;
    }

    .order-subtitle {
        font-size: .8rem;
    }

    .order-tabs {
        max-width: 100%;
        margin-bottom: .65rem;
    }

    .order-tab {
        font-size: .8rem;
        padding: 6px 10px;
    }

    .order-filter-menu {
        gap: 5px;
        margin-bottom: .85rem;
        overflow-x: auto;
        flex-wrap: nowrap;
        justify-content: flex-start;
        padding-bottom: 4px;
        -webkit-overflow-scrolling: touch;
        scrollbar-width: none;
    }

    .order-filter-menu::-webkit-scrollbar {
        display: none;
    }

    .order-filter-btn {
        font-size: .76rem;
        padding: 5px 11px;
    }

    .order-search-box {
        padding: .65rem .75rem;
        margin-bottom: 1.15rem;
        border-radius: 14px;
    }

    .order-search-row {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .order-search-input-group {
        width: 100% !important;
        flex: 1 1 100% !important;
    }

    .order-search-input {
        height: 36px;
        font-size: .8rem;
    }

    .order-search-input-group .input-group-text {
        padding: 0 8px;
        font-size: .85rem;
    }

    .order-search-actions {
        display: flex;
        gap: 6px;
        width: 100%;
    }

    .order-filter-select {
        height: 36px;
        font-size: .8rem;
        flex: 1;
        max-width: none;
    }

    .btn-order-apply {
        height: 36px;
        font-size: .78rem;
        padding: 0 14px;
        flex: 0 0 auto;
    }

    .btn-order-reset {
        height: 36px;
        font-size: .78rem;
        padding: 0 10px;
    }

    .package-section-title {
        font-size: 1.15rem;
    }

    .package-section-sub {
        font-size: .78rem;
        margin-bottom: .85rem;
    }

    .package-grid {
        grid-template-columns: 1fr;
        gap: 10px;
    }

    .package-card {
        padding: .85rem .85rem .75rem;
        border-radius: 14px;
    }

    .package-name {
        font-size: .92rem;
    }

    .package-price-val {
        font-size: 1.2rem;
    }

    .order-footer {
        margin-top: 1.25rem;
        padding-top: .85rem;
    }

    .order-footer .btn-order-next {
        width: 100%;
        justify-content: center;
        font-size: .88rem;
        padding: 9px 20px;
    }
}
</style>

@php
    $categoryLabels = [
        ''              => 'Semua',
        'internet_only' => 'Internet Only',
        'internet_tv'   => 'Internet + TV',
        'streaming'     => 'Streaming',
    ];

    $categoryIcons = [
        ''              => 'bi-grid-fill',
        'internet_only' => 'bi-wifi',
        'internet_tv'   => 'bi-tv-fill',
        'streaming'     => 'bi-play-circle-fill',
    ];

    $currentType = $type ?? request('type', 'home');
    $currentCategory = $category ?? request('category', '');
    $currentSort = $sort ?? request('sort', '');
    $currentQ = $q ?? request('q', '');

    function filterUrl($params = []) {
        return route('public.order.step1', array_merge(request()->query(), $params));
    }
@endphp

<div class="order-wrap">
    {{-- STEP PROGRESS --}}
    <div class="order-steps">
        <div class="order-step active">
            <span class="order-step-badge">1</span>
            <span class="order-step-text">Pilih Paket</span>
        </div>
        <div class="order-step-line"></div>
        <div class="order-step">
            <span class="order-step-badge">2</span>
            <span class="order-step-text">Isi Data</span>
        </div>
        <div class="order-step-line"></div>
        <div class="order-step">
            <span class="order-step-badge">3</span>
            <span class="order-step-text">Konfirmasi</span>
        </div>
    </div>

    <div class="order-card">
        <div class="order-header">
            <h1 class="order-title">Pilih Paket Internet</h1>
            <p class="order-subtitle">Pilih paket terbaik yang sesuai dengan kebutuhan rumah atau bisnis Anda</p>
        </div>

        @if($errors->any())
            <div class="alert alert-danger mb-3 p-2 px-3 small">
                <ul class="mb-0 ps-3">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- TYPE TABS (Home Retail / Bisnis) --}}
        <div class="order-tabs">
            <a href="{{ filterUrl(['type' => 'home']) }}"
               class="order-tab {{ $currentType === 'home' ? 'active' : '' }}">
                <i class="bi bi-house-door-fill"></i> Home Retail
            </a>

            <a href="{{ filterUrl(['type' => 'business']) }}"
               class="order-tab {{ $currentType === 'business' ? 'active' : '' }}">
                <i class="bi bi-building"></i> Bisnis
            </a>
        </div>

        {{-- CATEGORY FILTER BUTTONS (Compact pill chips) --}}
        <div class="order-filter-menu">
            @foreach($categoryLabels as $value => $label)
                <a href="{{ filterUrl(['category' => $value]) }}"
                   class="order-filter-btn {{ $currentCategory === $value ? 'active' : '' }}">
                    <i class="bi {{ $categoryIcons[$value] ?? 'bi-tag-fill' }}"></i> {{ $label }}
                </a>
            @endforeach
        </div>

        {{-- FILTER SEARCH & SORT BAR --}}
        <div class="order-search-box">
            <form method="GET" action="{{ route('public.order.step1') }}">
                <input type="hidden" name="type" value="{{ $currentType }}">
                <input type="hidden" name="category" value="{{ $currentCategory }}">

                <div class="order-search-row">
                    <div class="input-group order-search-input-group">
                        <span class="input-group-text"><i class="bi bi-search text-muted"></i></span>
                        <input
                            type="text"
                            name="q"
                            class="form-control order-search-input"
                            value="{{ $currentQ }}"
                            placeholder="Cari nama paket atau kecepatan..."
                        >
                    </div>

                    <div class="order-search-actions">
                        <select name="sort" class="form-select form-select-sm order-filter-select" onchange="this.form.submit()">
                            <option value="">Urutkan: Rekomendasi</option>
                            <option value="price_asc" {{ $currentSort === 'price_asc' ? 'selected' : '' }}>Harga Termurah</option>
                            <option value="price_desc" {{ $currentSort === 'price_desc' ? 'selected' : '' }}>Harga Termahal</option>
                            <option value="speed_desc" {{ $currentSort === 'speed_desc' ? 'selected' : '' }}>Kecepatan Tertinggi</option>
                        </select>

                        @if($currentQ || $currentSort || $currentCategory)
                            <a href="{{ route('public.order.step1', ['type' => $currentType]) }}" class="btn btn-outline-secondary btn-sm btn-order-reset">
                                Reset
                            </a>
                        @endif

                        <button type="submit" class="btn btn-order-apply">
                            Terapkan
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <div class="package-section-title">Daftar Paket Tersedia</div>
        <div class="package-section-sub">Menampilkan <strong>{{ $packages->count() }}</strong> paket untuk tipe <strong>{{ $currentType === 'business' ? 'Bisnis' : 'Home Retail' }}</strong></div>

        <form method="POST" action="{{ route('public.order.storeStep1') }}">
            @csrf

            <div class="package-grid">
                @foreach($packages as $package)
                    @php
                        $features = collect(preg_split("/\r\n|\n|\r|,/", $package->features ?? ''))
                            ->map(fn($item) => trim($item))
                            ->filter()
                            ->values()
                            ->take(2);
                    @endphp

                    <label class="package-option">
                        <input
                            type="radio"
                            name="package_id"
                            value="{{ $package->id }}"
                            class="package-radio"
                            {{ (old('package_id', $selectedPackageId) == $package->id) ? 'checked' : '' }}
                        >

                        <div class="package-card">
                            <div class="pkg-card-top">
                                <span class="pkg-speed-pill">
                                    <i class="bi bi-lightning-charge-fill"></i> {{ $package->speed_mbps }} Mbps
                                </span>
                                <span class="pkg-radio-indicator">
                                    <i class="bi bi-check-lg"></i>
                                </span>
                            </div>

                            <div class="package-name">{{ $package->name }}</div>

                            <div class="package-price-wrap">
                                <span class="package-price-val">
                                    Rp {{ number_format((float) $package->price_monthly, 0, ',', '.') }}
                                </span>
                                <span class="package-price-unit">/bln</span>
                            </div>

                            <ul class="package-features-list">
                                @forelse($features as $feature)
                                    <li class="package-feature-item">
                                        <i class="bi bi-check2-circle"></i>
                                        <span>{{ $feature }}</span>
                                    </li>
                                @empty
                                    <li class="package-feature-item">
                                        <i class="bi bi-check2-circle"></i>
                                        <span>Internet Full Fiber Optic</span>
                                    </li>
                                    <li class="package-feature-item">
                                        <i class="bi bi-check2-circle"></i>
                                        <span>Unlimited tanpa batas FUP</span>
                                    </li>
                                @endforelse
                            </ul>

                            <div class="pkg-status-btn">
                                @if(old('package_id', $selectedPackageId) == $package->id)
                                    <i class="bi bi-check-circle-fill me-1"></i> Paket Dipilih
                                @else
                                    Pilih Paket Ini
                                @endif
                            </div>
                        </div>
                    </label>
                @endforeach
            </div>

            <div class="order-footer">
                <button type="submit" class="btn-order-next">
                    Lanjut ke Data Pemesan <i class="bi bi-arrow-right"></i>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection