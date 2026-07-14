@extends('public.layouts.public')

@section('content')
<style>
.order-wrap {
    max-width: 1100px;
    margin: 0 auto;
    padding: 2rem 1rem 3rem;
}

.order-steps {
    display: flex;
    justify-content: center;
    align-items: flex-start;
    gap: 12px;
    margin-bottom: 2rem;
    flex-wrap: nowrap;
}

.order-step {
    display: flex;
    flex-direction: column;
    align-items: center;
    min-width: 64px;
    flex: 0 0 auto;
}

.order-step-badge {
    width: 50px;
    height: 50px;
    border-radius: 999px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border: 2px solid #cbd5e1;
    background: #fff;
    color: #475569;
    font-weight: 800;
    font-size: 20px;
    box-shadow: 0 8px 18px rgba(15, 23, 42, .08);
}

.order-step-text {
    margin-top: 12px;
    font-size: 15px;
    font-weight: 500;
    color: #64748b;
    text-align: center;
    line-height: 1.2;
}

.order-step-line {
    width: 84px;
    height: 4px;
    border-radius: 999px;
    background: #d1d5db;
    margin-top: 23px;
    flex: 0 0 auto;
}

.order-step.active .order-step-badge,
.order-step.done .order-step-badge {
    background: #1d4ed8;
    border-color: #1d4ed8;
    color: #fff;
}

.order-step.active .order-step-text,
.order-step.done .order-step-text {
    color: #1e3a8a;
    font-weight: 600;
}

.order-card {
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 24px;
    padding: 2rem;
    box-shadow: 0 12px 35px rgba(15, 23, 42, .06);
}

.order-header {
    text-align: center;
    margin-bottom: 2rem;
}

.order-title {
    font-size: 2.2rem;
    font-weight: 800;
    color: #0f172a;
    margin-bottom: .35rem;
}

.order-subtitle {
    color: #64748b;
    font-size: 1.05rem;
}

/* FILTER BAR */
.order-filter-box {
    border: 1px solid #e5e7eb;
    background: linear-gradient(180deg, #fbfdff, #f8fafc);
    border-radius: 24px;
    padding: 1rem;
    margin-bottom: 1.5rem;
    box-shadow: 0 10px 25px rgba(15, 23, 42, .04);
}

.order-filter-row + .order-filter-row {
    margin-top: 1rem;
}

.order-pill-grid {
    display: grid;
    gap: 14px;
}

.order-pill-grid.type-grid {
    grid-template-columns: repeat(2, minmax(0, 1fr));
}

.order-pill-grid.category-grid {
    grid-template-columns: repeat(4, minmax(0, 1fr));
    max-width: 92%;
    margin: 0 auto;
}

.order-pill {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-height: 62px;
    padding: 0 22px;
    border-radius: 999px;
    border: 1px solid #dbe2ea;
    background: #f3f4f6;
    color: #1e3a8a;
    font-weight: 800;
    font-size: 1rem;
    text-decoration: none;
    transition: all .2s ease;
    box-shadow: inset 0 1px 0 rgba(255,255,255,.75);
}

.order-pill:hover {
    transform: translateY(-1px);
    color: #1d4ed8;
    background: #eef2ff;
    border-color: #cbd5e1;
}

.order-pill.active-type {
    color: #fff;
    border: 0;
    background: linear-gradient(90deg, #0f4c8a 0%, #49a128 100%);
    box-shadow: 0 14px 30px rgba(15, 76, 138, .22);
}

.order-pill.active-category {
    color: #fff;
    border: 0;
    background: linear-gradient(90deg, #3a56b0 0%, #2f56c8 100%);
    box-shadow: 0 10px 24px rgba(58, 86, 176, .24);
}

.order-pill-icon {
    margin-right: 10px;
    font-size: 1rem;
    line-height: 1;
}

.order-search-row {
    display: flex;
    gap: 12px;
    align-items: center;
    margin-top: 1rem;
    flex-wrap: wrap;
}

.order-search-input {
    flex: 1 1 280px;
    height: 48px;
    border-radius: 14px;
    border: 1px solid #dbe2ea;
    padding: 0 14px;
    font-size: .95rem;
    color: #0f172a;
    background: #fff;
}

.order-search-input:focus {
    outline: none;
    border-color: #93c5fd;
    box-shadow: 0 0 0 4px rgba(59, 130, 246, .10);
}

.order-filter-select {
    max-width: 220px;
    height: 48px;
    border-radius: 14px;
    border: 1px solid #dbe2ea;
    color: #0f172a;
    box-shadow: none !important;
}

.order-filter-select:focus {
    border-color: #93c5fd;
    box-shadow: 0 0 0 4px rgba(59, 130, 246, .10) !important;
}

.order-filter-btn {
    height: 48px;
    padding: 0 18px;
    border-radius: 14px;
    border: 0;
    font-weight: 700;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    transition: .2s ease;
}

.order-filter-btn-apply {
    background: linear-gradient(135deg, #2563eb, #0891b2);
    color: #fff;
}

.order-filter-btn-apply:hover {
    color: #fff;
    transform: translateY(-1px);
    box-shadow: 0 10px 20px rgba(37, 99, 235, .18);
}

.order-filter-btn-reset {
    background: #e5e7eb;
    color: #334155;
}

.order-filter-btn-reset:hover {
    color: #0f172a;
    background: #dbe2ea;
}

.package-section-title {
    text-align: center;
    font-size: 1.6rem;
    font-weight: 800;
    color: #0f172a;
    margin-bottom: .25rem;
}

.package-section-sub {
    text-align: center;
    color: #64748b;
    margin-bottom: 1.5rem;
}

.package-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 18px;
}

.package-option {
    position: relative;
}

.package-radio {
    position: absolute;
    opacity: 0;
    pointer-events: none;
}

/* PACKAGE CARD KHUSUS HIJAU */
.package-card {
    border: 1.5px solid #bbf7d0;
    background: linear-gradient(180deg, #f0fdf4, #dcfce7);
    border-radius: 18px;
    padding: 1.2rem;
    min-height: 100%;
    cursor: pointer;
    transition: .25s ease;
    position: relative;
}

.package-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 14px 28px rgba(34, 197, 94, .15);
}

.package-radio:checked + .package-card {
    border-color: #22c55e;
    box-shadow: 0 0 0 4px rgba(34, 197, 94, .14);
    background: linear-gradient(180deg, #dcfce7, #bbf7d0);
}

.package-check {
    position: absolute;
    top: 14px;
    right: 14px;
    width: 28px;
    height: 28px;
    border-radius: 999px;
    background: #16a34a;
    color: #fff;
    display: none;
    align-items: center;
    justify-content: center;
    font-size: 14px;
    font-weight: 800;
    box-shadow: 0 8px 16px rgba(22, 163, 74, .25);
}

.package-radio:checked + .package-card .package-check {
    display: inline-flex;
}

.package-chip {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 7px 12px;
    border-radius: 999px;
    background: #dcfce7;
    color: #166534;
    font-size: .82rem;
    font-weight: 700;
    margin-bottom: 1rem;
}

.package-name {
    font-size: 1.05rem;
    font-weight: 800;
    color: #14532d;
    margin-bottom: .45rem;
}

.package-desc {
    color: #475569;
    font-size: .9rem;
    line-height: 1.6;
    min-height: 56px;
    margin-bottom: 1rem;
}

.package-price {
    font-size: 2rem;
    font-weight: 900;
    color: #16a34a;
    line-height: 1;
    margin-bottom: .25rem;
}

.package-price-note {
    color: #64748b;
    font-size: .85rem;
    margin-bottom: 1rem;
}

.package-list {
    margin: 0;
    padding-left: 18px;
    color: #334155;
    font-size: .9rem;
}

.package-list li + li {
    margin-top: .35rem;
}

.order-footer {
    display: flex;
    justify-content: flex-end;
    margin-top: 2rem;
}

.btn-order-next {
    border-radius: 16px;
    padding: 12px 24px;
    font-weight: 700;
    background: linear-gradient(135deg, #2563eb, #0891b2);
    color: #fff;
    border: 0;
    box-shadow: 0 12px 24px rgba(37, 99, 235, .18);
    transition: .2s ease;
}

.btn-order-next:hover {
    transform: translateY(-1px);
    box-shadow: 0 16px 28px rgba(37, 99, 235, .22);
}

@media (max-width: 1100px) {
    .package-grid {
        grid-template-columns: repeat(2, 1fr);
    }

    .order-pill-grid.category-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
        max-width: 100%;
    }
}

@media (max-width: 768px) {
    .order-pill-grid.type-grid,
    .order-pill-grid.category-grid {
        grid-template-columns: 1fr;
        max-width: 100%;
    }
}

@media (max-width: 576px) {
    .order-wrap {
        padding: 1.25rem .85rem 2rem;
    }

    .order-steps {
        gap: 8px;
        margin-bottom: 1.5rem;
    }

    .order-step {
        min-width: 52px;
    }

    .order-step-badge {
        width: 44px;
        height: 44px;
        font-size: 18px;
    }

    .order-step-text {
        font-size: 13px;
        margin-top: 8px;
    }

    .order-step-line {
        width: 38px;
        height: 3px;
        margin-top: 20px;
    }

    .order-card {
        padding: 1.2rem;
    }

    .order-title {
        font-size: 1.7rem;
    }

    .package-grid {
        grid-template-columns: 1fr;
    }

    .order-footer .btn-order-next {
        width: 100%;
    }

    .order-pill {
        min-height: 56px;
        font-size: .95rem;
        padding: 0 16px;
    }

    .order-search-row {
        flex-direction: column;
        align-items: stretch;
    }

    .order-filter-btn,
    .order-filter-select {
        width: 100%;
        max-width: 100%;
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

    $currentType = $type ?? request('type', 'home');
    $currentCategory = $category ?? request('category', '');
    $currentSort = $sort ?? request('sort', '');
    $currentQ = $q ?? request('q', '');

    function filterUrl($params = []) {
        return route('public.order.step1', array_merge(request()->query(), $params));
    }
@endphp

<div class="order-wrap">
    <div class="order-steps">
        <div class="order-step active">
            <span class="order-step-badge">1</span>
            <span class="order-step-text">Paket</span>
        </div>
        <div class="order-step-line"></div>
        <div class="order-step">
            <span class="order-step-badge">2</span>
            <span class="order-step-text">Data</span>
        </div>
        <div class="order-step-line"></div>
        <div class="order-step">
            <span class="order-step-badge">3</span>
            <span class="order-step-text">Konfirmasi</span>
        </div>
    </div>

    <div class="order-card">
        <div class="order-header">
            <h1 class="order-title">Pilih Paket</h1>
            <p class="order-subtitle">Pilih paket internet terbaik sesuai kebutuhan Anda</p>
        </div>

        @if($errors->any())
            <div class="alert alert-danger mb-4">
                <ul class="mb-0 ps-3">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="order-filter-box">
            <div class="order-filter-row">
                <div class="order-pill-grid type-grid">
                    <a
                        href="{{ filterUrl(['type' => 'home']) }}"
                        class="order-pill {{ $currentType === 'home' ? 'active-type' : '' }}"
                    >
                        <span class="order-pill-icon">🏠</span>
                        Home Retail
                    </a>

                    <a
                        href="{{ filterUrl(['type' => 'business']) }}"
                        class="order-pill {{ $currentType === 'business' ? 'active-type' : '' }}"
                    >
                        <span class="order-pill-icon">🏢</span>
                        Bisnis
                    </a>
                </div>
            </div>

            <div class="order-filter-row">
                <div class="order-pill-grid category-grid">
                    @foreach($categoryLabels as $value => $label)
                        <a
                            href="{{ filterUrl(['category' => $value]) }}"
                            class="order-pill {{ $currentCategory === $value ? 'active-category' : '' }}"
                        >
                            {{ $label }}
                        </a>
                    @endforeach
                </div>
            </div>

            <form method="GET" action="{{ route('public.order.step1') }}">
                <input type="hidden" name="type" value="{{ $currentType }}">
                <input type="hidden" name="category" value="{{ $currentCategory }}">

                <div class="order-search-row">
                    <input
                        type="text"
                        name="q"
                        class="order-search-input"
                        value="{{ $currentQ }}"
                        placeholder="Cari paket..."
                    >

                    <select name="sort" class="form-select order-filter-select">
                        <option value="">Rekomendasi</option>
                        <option value="price_asc" {{ $currentSort === 'price_asc' ? 'selected' : '' }}>Harga Termurah</option>
                        <option value="price_desc" {{ $currentSort === 'price_desc' ? 'selected' : '' }}>Harga Termahal</option>
                        <option value="speed_desc" {{ $currentSort === 'speed_desc' ? 'selected' : '' }}>Kecepatan Tertinggi</option>
                    </select>

                    <button type="submit" class="order-filter-btn order-filter-btn-apply">
                        Terapkan
                    </button>

                    <a href="{{ route('public.order.step1') }}" class="order-filter-btn order-filter-btn-reset">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        <div class="package-section-title">Pilih Paket Internet</div>
        <div class="package-section-sub">{{ $packages->count() }} paket tersedia</div>

        <form method="POST" action="{{ route('public.order.storeStep1') }}">
            @csrf

            <div class="package-grid">
                @foreach($packages as $package)
                    @php
                        $features = collect(preg_split("/\r\n|\n|\r|,/", $package->features ?? ''))
                            ->map(fn($item) => trim($item))
                            ->filter()
                            ->values()
                            ->take(3);
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
                            <span class="package-check">✓</span>

                            <div class="package-chip">⚡ {{ $package->speed_mbps }} Mbps</div>

                            <div class="package-name">{{ $package->name }}</div>

                            <div class="package-desc">
                                {{ $package->short_description ?: 'Internet cepat dan stabil untuk kebutuhan rumah tangga.' }}
                            </div>

                            <div class="package-price">
                                Rp {{ number_format((float) $package->price_monthly, 0, ',', '.') }}
                            </div>
                            <div class="package-price-note">/bulan</div>

                            <ul class="package-list">
                                @forelse($features as $feature)
                                    <li>{{ $feature }}</li>
                                @empty
                                    <li>Full Fiber to the Home</li>
                                    <li>Koneksi stabil untuk aktivitas harian</li>
                                    <li>Unlimited tanpa FUP</li>
                                @endforelse
                            </ul>
                        </div>
                    </label>
                @endforeach
            </div>

            <div class="order-footer">
                <button type="submit" class="btn-order-next">
                    Next →
                </button>
            </div>
        </form>
    </div>
</div>
@endsection