@extends('public.layouts.public')

@push('styles')
<style>
/* ===================== PAGE HEADER ===================== */
.paket-header {
    text-align: center;
    margin-bottom: 1.5rem;
}

.paket-header-title {
    font-size: 2.8rem;
    font-weight: 800;
    color: #1e3a8a;
    margin-bottom: .35rem;
    letter-spacing: -0.3px;
}

.paket-header-sub {
    color: #4b5563;
    font-size: .97rem;
    max-width: 720px;
    margin-inline: auto;
    line-height: 1.6;
}

/* ===================== TYPE TABS ===================== */
.paket-tabs {
    max-width: 760px;
    margin: 0 auto 1.25rem;
    display: flex;
    gap: 12px;
}

.paket-tab {
    flex: 1;
    text-align: center;
    padding: 14px 18px;
    border-radius: 999px;
    text-decoration: none;
    font-weight: 700;
    color: #374151;
    background: linear-gradient(135deg, #f0f9ff, #ecfeff);
    border: 1px solid #cfe7ef;
    transition: .25s ease;
    box-shadow: 0 8px 20px rgba(15, 23, 42, .04);
}

.paket-tab:hover {
    color: #1d4ed8;
    transform: translateY(-1px);
}

.paket-tab.active {
    background: linear-gradient(135deg, #2563eb, #22c55e);
    color: #fff;
    border-color: transparent;
    box-shadow: 0 12px 26px rgba(37, 99, 235, .22);
}

/* ===================== FILTER BUTTON MENU ===================== */
.paket-filter-menu {
    display: flex;
    justify-content: center;
    gap: 12px;
    flex-wrap: wrap;
    margin-bottom: 1.4rem;
}

.paket-filter-btn {
    min-width: 160px;
    padding: 13px 22px;
    border-radius: 999px;
    background: linear-gradient(135deg, #f0fdf4, #eff6ff);
    color: #334155;
    text-decoration: none;
    text-align: center;
    font-weight: 800;
    font-size: .98rem;
    border: 1px solid #dbeafe;
    transition: .25s ease;
}

.paket-filter-btn:hover {
    color: #1e3a8a;
    transform: translateY(-1px);
}

.paket-filter-btn.active {
    background: linear-gradient(135deg, #2563eb, #22c55e);
    color: #fff;
    border-color: transparent;
    box-shadow: 0 10px 24px rgba(37, 99, 235, .2);
}

/* ===================== TOOLBAR ===================== */
.paket-toolbar {
    border-radius: 24px;
    background: linear-gradient(135deg, #eff6ff, #f0fdf4);
    border: 1px solid #dbeafe;
    padding: 1rem;
    box-shadow: 0 14px 35px rgba(15, 23, 42, .06);
    margin-bottom: 1.25rem;
}

.paket-toolbar-form .form-control,
.paket-toolbar-form .form-select {
    border-radius: 14px;
    border-color: #cfe7ef;
    min-height: 46px;
    box-shadow: none;
    background: rgba(255,255,255,.92);
}

.paket-toolbar-form .form-control:focus,
.paket-toolbar-form .form-select:focus {
    border-color: rgba(37, 99, 235, .35);
    box-shadow: 0 0 0 0.16rem rgba(37, 99, 235, .08);
}

.paket-toolbar-label {
    font-size: .8rem;
    font-weight: 700;
    color: #4b5563;
    margin-bottom: .35rem;
}

.paket-toolbar-info {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 10px;
    margin-top: 1rem;
    flex-wrap: wrap;
}

.paket-toolbar-count {
    font-size: .9rem;
    color: #4b5563;
}

.paket-toolbar-count strong {
    color: #1e3a8a;
}

.btn-soft-reset {
    border-radius: 999px;
    padding-inline: 16px;
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

/* ===================== CARD ===================== */
.paket-card {
    background: linear-gradient(180deg, #ffffff, #f8fbff);
    border-radius: 22px;
    border: 1px solid #d9ecf2;
    box-shadow: 0 12px 28px rgba(15, 23, 42, .08);
    display: flex;
    flex-direction: column;
    overflow: hidden;
    transition: .28s ease;
    height: 100%;
    position: relative;
}

.paket-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 22px 42px rgba(37, 99, 235, .14);
    border-color: #bfe3d2;
}

/* ===================== BANNER ===================== */
.paket-banner {
    position: relative;
    width: 100%;
    height: clamp(110px, 14vw, 150px);
    overflow: hidden;
    background: linear-gradient(135deg, #60a5fa, #86efac);
    flex-shrink: 0;
}

.paket-banner img {
    position: absolute;
    inset: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center;
    z-index: 0;
}

.paket-banner::after {
    content: "";
    position: absolute;
    inset: 0;
    background: linear-gradient(180deg, rgba(15, 23, 42, .06), rgba(15, 23, 42, .18));
    z-index: 1;
}

/* ===================== BODY ===================== */
.paket-body {
    padding: 14px;
    display: flex;
    flex-direction: column;
    height: 100%;
}

.paket-badges {
    display: flex;
    flex-wrap: wrap;
    gap: 6px;
    margin-bottom: .8rem;
}

.paket-badge {
    padding: 5px 10px;
    border-radius: 999px;
    font-size: .72rem;
    font-weight: 700;
    background: linear-gradient(135deg, #f0fdf4, #eff6ff);
    color: #334155;
    border: 1px solid #dbeafe;
}

.paket-badge.featured {
    background: rgba(59, 130, 246, .10);
    color: #1d4ed8;
    border-color: rgba(59, 130, 246, .18);
}

.paket-badge.best {
    background: rgba(34, 197, 94, .10);
    color: #15803d;
    border-color: rgba(34, 197, 94, .18);
}

.paket-name {
    font-weight: 800;
    color: #1e3a8a;
    font-size: 1rem;
    line-height: 1.45;
    margin-bottom: 8px;
    min-height: 44px;
}

.paket-speed {
    font-size: 1.95rem;
    font-weight: 900;
    color: #0f766e;
    line-height: 1;
    margin-bottom: 10px;
}

.paket-price {
    border: 1px solid #d9ecf2;
    border-left: 4px solid #22c55e;
    border-radius: 14px;
    padding: 10px 12px;
    margin-bottom: 12px;
    background: linear-gradient(135deg, rgba(59, 130, 246, .05), rgba(34, 197, 94, .07));
}

.paket-price-main {
    font-weight: 800;
    color: #1e3a8a;
    margin-bottom: 2px;
}

.paket-price-note {
    font-size: .82rem;
    color: #64748b;
}

.paket-short-desc {
    color: #374151;
    font-size: .92rem;
    line-height: 1.65;
    font-weight: 500;
    margin-bottom: .95rem;
}

.paket-list-title {
    font-size: .88rem;
    font-weight: 800;
    color: #1e3a8a;
    margin-bottom: 6px;
}

.paket-list {
    padding-left: 18px;
    font-size: .9rem;
    color: #374151;
    margin-bottom: 14px;
}

.paket-list li {
    margin-bottom: 4px;
}

.paket-meta {
    font-size: .84rem;
    color: #4b5563;
    margin-bottom: .8rem;
}

.paket-meta div + div {
    margin-top: 3px;
}

/* ===================== CTA ===================== */
.paket-actions {
    margin-top: auto;
    display: grid;
    grid-template-columns: 1.2fr 1fr;
    gap: 10px;
}

.paket-btn {
    min-height: 46px;
    border-radius: 14px;
    text-decoration: none;
    font-weight: 800;
    font-size: .9rem;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    padding: 0 14px;
    transition: all .22s ease;
    border: 1px solid transparent;
    box-shadow: 0 8px 18px rgba(15, 23, 42, .08);
}

.paket-btn:hover {
    transform: translateY(-2px);
}

.paket-btn-primary {
    background: linear-gradient(135deg, #2563eb, #22c55e);
    color: #fff;
}

.paket-btn-primary:hover {
    color: #fff;
}

.paket-btn-secondary {
    background: #fff;
    color: #1e3a8a;
    border-color: #dbeafe;
}

.paket-btn-secondary:hover {
    color: #1e3a8a;
    background: #f8fbff;
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
body.dark-mode .paket-toolbar,
body.dark-mode .paket-stage {
    background: linear-gradient(135deg, #021021, #02260e);
    border-color: #1f2937;
    box-shadow: 0 18px 45px rgba(0,0,0,.8);
}

body.dark-mode .paket-header-title,
body.dark-mode .paket-name,
body.dark-mode .paket-speed,
body.dark-mode .paket-price-main,
body.dark-mode .paket-list-title {
    color: #e5e7eb;
}

body.dark-mode .paket-header-sub,
body.dark-mode .paket-toolbar-label,
body.dark-mode .paket-toolbar-count,
body.dark-mode .paket-price-note,
body.dark-mode .paket-meta,
body.dark-mode .paket-empty {
    color: #9ca3af;
}

body.dark-mode .paket-short-desc {
    color: #d1d5db;
}

body.dark-mode .paket-tab {
    background: #0f172a;
    color: #cbd5e1;
    border-color: #243041;
}

body.dark-mode .paket-tab.active {
    color: #fff;
}

body.dark-mode .paket-filter-btn {
    background: #0f172a;
    color: #e5e7eb;
    border-color: #243041;
}

body.dark-mode .paket-filter-btn.active {
    background: linear-gradient(135deg, #2563eb, #22c55e);
    color: #fff;
}

body.dark-mode .paket-card {
    background: linear-gradient(135deg, rgba(37, 99, 235, 0.12), rgba(34, 197, 94, 0.10));
    border-color: #314155;
    box-shadow: 0 24px 50px rgba(0,0,0,.65);
}

body.dark-mode .paket-badge {
    background: rgba(255,255,255,.05);
    color: #e5e7eb;
    border-color: rgba(255,255,255,.08);
}

body.dark-mode .paket-list li {
    color: #e5e7eb;
}

body.dark-mode .paket-toolbar-form .form-control,
body.dark-mode .paket-toolbar-form .form-select {
    background: #0f172a;
    color: #e5e7eb;
    border-color: #243041;
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

    .paket-filter-btn {
        min-width: 140px;
        padding: 12px 18px;
        font-size: .95rem;
    }

    .paket-tabs {
        flex-direction: column;
    }

    .paket-header-title {
        font-size: 2.2rem;
    }

    .paket-banner {
        height: 100px;
    }

    .paket-banner::after {
        background: linear-gradient(180deg, rgba(0,0,0,.10), rgba(0,0,0,.24));
    }

    .paket-actions {
        margin-top: auto;
        display: grid;
        grid-template-columns: 1fr;
        gap: 10px;
    }

    .paket-btn {
        text-align: center;
        padding: 11px 14px;
        border-radius: 999px;
        text-decoration: none;
        font-weight: 700;
        transition: .2s ease;
        display: inline-flex;
        justify-content: center;
        align-items: center;
    }

    .paket-btn:hover {
        transform: translateY(-1px);
    }

    .paket-btn-primary {
        background: linear-gradient(135deg, #2563eb, #22c55e);
        color: #fff;
    }

    .paket-btn-primary:hover {
        color: #fff;
    }

    .paket-btn-secondary {
        background: #fff;
        color: #1e3a8a;
        border: 1px solid #dbeafe;
    }

    .paket-btn-secondary:hover {
        color: #1e3a8a;
    }

    .paket-tab {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .paket-tab i {
        font-size: 1rem;
        line-height: 1;
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
        'internet_only' => 'Internet Only',
        'internet_tv'   => 'Internet + TV',
        'streaming'     => 'Streaming',
    ];
@endphp

<div class="paket-header">
    <h1 class="paket-header-title">Pilihan Paket Untuk Anda</h1>
    <p class="paket-header-sub">
        Pilih paket internet terbaik sesuai kebutuhan rumah atau bisnis Anda.
    </p>
</div>

<div class="paket-tabs">
    <a href="{{ route('public.packages', array_merge(request()->except(['page','type']), ['type' => 'home'])) }}"
       class="paket-tab {{ $currentType === 'home' ? 'active' : '' }}">
        <i class="bi bi-house-door-fill me-2"></i> Home Retail
    </a>

    <a href="{{ route('public.packages', array_merge(request()->except(['page','type']), ['type' => 'business'])) }}"
       class="paket-tab {{ $currentType === 'business' ? 'active' : '' }}">
        <i class="bi bi-building me-2"></i> Bisnis
    </a>
</div>

<div class="paket-filter-menu">
    <a href="{{ route('public.packages', array_merge(request()->except(['page','category']), ['type' => $currentType])) }}"
       class="paket-filter-btn {{ request()->routeIs('public.packages') && empty($currentCategory) ? 'active' : '' }}">
        Semua
    </a>

    @foreach($categoryLabels as $value => $label)
        <a href="{{ route('public.packages', array_merge(request()->except('page'), ['type' => $currentType, 'category' => $value])) }}"
           class="paket-filter-btn {{ request()->routeIs('public.packages') && $currentCategory === $value ? 'active' : '' }}">
            {{ $label }}
        </a>
    @endforeach

    <a href="{{ route('public.addons', ['type' => $currentType]) }}"
       class="paket-filter-btn {{ request()->routeIs('public.addons') ? 'active' : '' }}">
        Add Ons
    </a>
</div>

<div class="paket-toolbar">
    <form method="GET" action="{{ route('public.packages') }}" class="paket-toolbar-form">
        <input type="hidden" name="type" value="{{ $currentType }}">
        @if($currentCategory)
            <input type="hidden" name="category" value="{{ $currentCategory }}">
        @endif

        <div class="row g-3 align-items-end">
            <div class="col-md-8">
                <label class="paket-toolbar-label">Cari Paket</label>
                <input
                    type="text"
                    name="q"
                    class="form-control"
                    value="{{ $currentQ }}"
                    placeholder="Cari nama paket, kebutuhan, perangkat, atau deskripsi..."
                >
            </div>

            <div class="col-md-4">
                <label class="paket-toolbar-label">Urutkan</label>
                <select name="sort" class="form-select" onchange="this.form.submit()">
                    <option value="" {{ $currentSort == '' ? 'selected' : '' }}>Rekomendasi</option>
                    <option value="price_asc" {{ $currentSort === 'price_asc' ? 'selected' : '' }}>Harga Termurah</option>
                    <option value="price_desc" {{ $currentSort === 'price_desc' ? 'selected' : '' }}>Harga Termahal</option>
                    <option value="speed_desc" {{ $currentSort === 'speed_desc' ? 'selected' : '' }}>Kecepatan Tertinggi</option>
                </select>
            </div>
        </div>

        <div class="paket-toolbar-info">
            <div class="paket-toolbar-count">
                Menampilkan <strong>{{ $packages->total() }}</strong> paket
                @if($currentType)
                    untuk tipe <strong>{{ $currentType === 'business' ? 'Bisnis' : 'Home Retail' }}</strong>
                @endif
                @if($currentCategory)
                    dengan kategori <strong>{{ $categoryLabels[$currentCategory] ?? ucwords(str_replace('_', ' ', $currentCategory)) }}</strong>
                @endif
            </div>

            <div class="d-flex gap-2">
                <a href="{{ route('public.packages') }}" class="btn btn-outline-secondary btn-sm btn-soft-reset">
                    Reset
                </a>
                <button type="submit" class="btn btn-primary btn-sm btn-soft-reset">
                    Terapkan
                </button>
            </div>
        </div>
    </form>
</div>

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

            <div class="paket-card">
                <div class="paket-banner" style="{{ $bannerStyle }}">
                    @if($bannerUrl)
                        <img
                            src="{{ $bannerUrl }}"
                            alt="{{ $package->name }}"
                            loading="lazy"
                            onerror="this.style.display='none';"
                        >
                    @endif
                </div>

                <div class="paket-body">
                    <div class="paket-badges">
                        <span class="paket-badge">
                            {{ $package->type === 'business' ? 'Bisnis' : 'Home Retail' }}
                        </span>

                        @if($package->category)
                            <span class="paket-badge">
                                {{ $categoryLabels[$package->category] ?? ucwords(str_replace('_', ' ', $package->category)) }}
                            </span>
                        @endif

                        @if((int) ($package->is_featured ?? 0) === 1)
                            <span class="paket-badge featured">Featured</span>
                        @endif

                        @if((int) ($package->is_best_seller ?? 0) === 1)
                            <span class="paket-badge best">Best Seller</span>
                        @endif
                    </div>

                    <div class="paket-name">{{ $package->name }}</div>

                    <div class="paket-speed">{{ $package->speed_mbps }} Mbps</div>

                    <div class="paket-price">
                        <p class="paket-price-main">
                            Rp {{ number_format((float) $package->price_monthly, 0, ',', '.') }}
                        </p>
                        <div class="paket-price-note">
                            Durasi {{ $durationText }} | Belum termasuk PPN 11%
                        </div>
                    </div>

                    @if($package->short_description)
                        <div class="paket-short-desc">
                            {{ \Illuminate\Support\Str::limit($package->short_description, 120) }}
                        </div>
                    @endif

                    <div class="paket-meta">
                        @if($package->device_ideal)
                            <div><strong>Perangkat ideal:</strong> {{ $package->device_ideal }}</div>
                        @endif

                        @if($package->best_for)
                            <div><strong>Cocok untuk:</strong> {{ $package->best_for }}</div>
                        @endif
                    </div>

                    <div class="paket-list-title">Highlight Paket</div>
                    <ul class="paket-list">
                        @forelse($features as $f)
                            <li>{{ $f }}</li>
                        @empty
                            <li>Internet stabil</li>
                            <li>Full fiber optic</li>
                            <li>Unlimited tanpa FUP</li>
                        @endforelse
                    </ul>

                    <div class="paket-actions">
                        <a href="{{ route('public.order.step1', ['package' => $package->slug]) }}" class="paket-btn paket-btn-primary">
                            Pesan Sekarang
                        </a>

                        <a href="{{ $waUrl }}" class="paket-btn paket-btn-secondary" target="_blank" rel="noopener noreferrer">
                            Konsultasi Gratis
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