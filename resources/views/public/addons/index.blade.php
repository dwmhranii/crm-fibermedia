@extends('public.layouts.public')

@push('styles')
<style>
/* ===================== PAGE HEADER ===================== */
.addon-header {
    text-align: center;
    margin-bottom: 1.5rem;
}

.addon-header-title {
    font-size: 2.8rem;
    font-weight: 800;
    color: #1e3a8a;
    margin-bottom: .35rem;
    letter-spacing: -0.3px;
}

.addon-header-sub {
    color: #4b5563;
    font-size: .97rem;
    max-width: 720px;
    margin-inline: auto;
    line-height: 1.6;
}

/* ===================== TYPE TABS ===================== */
.addon-tabs {
    max-width: 760px;
    margin: 0 auto 1.25rem;
    display: flex;
    gap: 12px;
}

.addon-tab {
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

.addon-tab:hover {
    color: #1d4ed8;
    transform: translateY(-1px);
}

.addon-tab.active {
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
.addon-toolbar {
    border-radius: 24px;
    background: linear-gradient(135deg, #eff6ff, #f0fdf4);
    border: 1px solid #dbeafe;
    padding: 1rem;
    box-shadow: 0 14px 35px rgba(15, 23, 42, .06);
    margin-bottom: 1.25rem;
}

.addon-toolbar-form .form-control,
.addon-toolbar-form .form-select {
    border-radius: 14px;
    border-color: #cfe7ef;
    min-height: 46px;
    box-shadow: none;
    background: rgba(255,255,255,.92);
}

.addon-toolbar-form .form-control:focus,
.addon-toolbar-form .form-select:focus {
    border-color: rgba(37, 99, 235, .35);
    box-shadow: 0 0 0 0.16rem rgba(37, 99, 235, .08);
}

.addon-toolbar-label {
    font-size: .8rem;
    font-weight: 700;
    color: #4b5563;
    margin-bottom: .35rem;
}

.addon-toolbar-info {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 10px;
    margin-top: 1rem;
    flex-wrap: wrap;
}

.addon-toolbar-count {
    font-size: .9rem;
    color: #4b5563;
}

.addon-toolbar-count strong {
    color: #1e3a8a;
}

.btn-soft-reset {
    border-radius: 999px;
    padding-inline: 16px;
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

/* ===================== CARD ===================== */
.addon-card {
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

.addon-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 22px 42px rgba(37, 99, 235, .14);
    border-color: #bfe3d2;
}

.addon-banner {
    position: relative;
    width: 100%;
    height: clamp(110px, 14vw, 150px);
    overflow: hidden;
    background: linear-gradient(135deg, #60a5fa, #86efac);
    flex-shrink: 0;
}

.addon-banner img {
    position: absolute;
    inset: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center;
    z-index: 0;
}

.addon-banner::after {
    content: "";
    position: absolute;
    inset: 0;
    background: linear-gradient(180deg, rgba(15, 23, 42, .06), rgba(15, 23, 42, .18));
    z-index: 1;
}

.addon-body {
    padding: 14px;
    display: flex;
    flex-direction: column;
    height: 100%;
}

.addon-badges {
    display: flex;
    flex-wrap: wrap;
    gap: 6px;
    margin-bottom: .8rem;
}

.addon-badge {
    padding: 5px 10px;
    border-radius: 999px;
    font-size: .72rem;
    font-weight: 700;
    background: linear-gradient(135deg, #f0fdf4, #eff6ff);
    color: #334155;
    border: 1px solid #dbeafe;
}

.addon-badge.featured {
    background: rgba(59, 130, 246, .10);
    color: #1d4ed8;
    border-color: rgba(59, 130, 246, .18);
}

.addon-badge.best {
    background: rgba(34, 197, 94, .10);
    color: #15803d;
    border-color: rgba(34, 197, 94, .18);
}

.addon-name {
    font-weight: 800;
    color: #1e3a8a;
    font-size: 1rem;
    line-height: 1.45;
    margin-bottom: 8px;
    min-height: 44px;
}

.addon-price {
    border: 1px solid #d9ecf2;
    border-left: 4px solid #22c55e;
    border-radius: 14px;
    padding: 10px 12px;
    margin-bottom: 12px;
    background: linear-gradient(135deg, rgba(59, 130, 246, .05), rgba(34, 197, 94, .07));
}

.addon-price-main {
    font-weight: 800;
    color: #1e3a8a;
    margin-bottom: 2px;
}

.addon-price-note {
    font-size: .82rem;
    color: #64748b;
}

.addon-short-desc {
    color: #374151;
    font-size: .92rem;
    line-height: 1.65;
    font-weight: 500;
    margin-bottom: .95rem;
}

.addon-list-title {
    font-size: .88rem;
    font-weight: 800;
    color: #1e3a8a;
    margin-bottom: 6px;
}

.addon-list {
    padding-left: 18px;
    font-size: .9rem;
    color: #374151;
    margin-bottom: 14px;
}

.addon-list li {
    margin-bottom: 4px;
}

.addon-meta {
    font-size: .84rem;
    color: #4b5563;
    margin-bottom: .8rem;
}

.addon-meta div + div {
    margin-top: 3px;
}

.addon-actions {
    margin-top: auto;
    display: grid;
    grid-template-columns: 1fr;
    gap: 10px;
}

.addon-btn {
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

.addon-btn:hover {
    transform: translateY(-2px);
}

.addon-btn-primary {
    background: linear-gradient(135deg, #2563eb, #22c55e);
    color: #fff;
}

.addon-btn-primary:hover {
    color: #fff;
}

.addon-empty {
    grid-column: 1 / -1;
    text-align: center;
    color: #6b7280;
    padding: 28px 18px;
}

/* ===================== DARK MODE ===================== */
body.dark-mode .addon-toolbar,
body.dark-mode .addon-stage {
    background: linear-gradient(135deg, #021021, #02260e);
    border-color: #1f2937;
    box-shadow: 0 18px 45px rgba(0,0,0,.8);
}

body.dark-mode .addon-header-title,
body.dark-mode .addon-name,
body.dark-mode .addon-price-main,
body.dark-mode .addon-list-title {
    color: #e5e7eb;
}

body.dark-mode .addon-header-sub,
body.dark-mode .addon-toolbar-label,
body.dark-mode .addon-toolbar-count,
body.dark-mode .addon-price-note,
body.dark-mode .addon-meta,
body.dark-mode .addon-empty {
    color: #9ca3af;
}

body.dark-mode .addon-short-desc {
    color: #d1d5db;
}

body.dark-mode .addon-tab,
body.dark-mode .paket-filter-btn {
    background: #0f172a;
    color: #cbd5e1;
    border-color: #243041;
}

body.dark-mode .addon-tab.active,
body.dark-mode .paket-filter-btn.active {
    color: #fff;
    background: linear-gradient(135deg, #2563eb, #22c55e);
}

body.dark-mode .addon-card {
    background: linear-gradient(135deg, rgba(37, 99, 235, 0.12), rgba(34, 197, 94, 0.10));
    border-color: #314155;
    box-shadow: 0 24px 50px rgba(0,0,0,.65);
}

body.dark-mode .addon-badge {
    background: rgba(255,255,255,.05);
    color: #e5e7eb;
    border-color: rgba(255,255,255,.08);
}

body.dark-mode .addon-list li {
    color: #e5e7eb;
}

body.dark-mode .addon-toolbar-form .form-control,
body.dark-mode .addon-toolbar-form .form-select {
    background: #0f172a;
    color: #e5e7eb;
    border-color: #243041;
}

@media (max-width: 992px) {
    .addon-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 576px) {
    .addon-tabs {
        flex-direction: column;
    }

    .addon-grid {
        grid-template-columns: 1fr;
    }

    .addon-header-title {
        font-size: 2.2rem;
    }

    .addon-banner {
        height: 100px;
    }

    .paket-filter-btn {
        min-width: 140px;
        padding: 12px 18px;
        font-size: .95rem;
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
@endphp

<div class="addon-header">
    <h1 class="addon-header-title">Pilihan Add Ons Untuk Anda</h1>
    <p class="addon-header-sub">
        Lengkapi kebutuhan internet, hiburan, keamanan, dan perangkat pintar Anda dengan add ons terbaik.
    </p>
</div>

<div class="addon-tabs">
    <a href="{{ route('public.addons', array_merge(request()->except(['page','type']), ['type' => 'home'])) }}"
       class="addon-tab {{ $currentType === 'home' ? 'active' : '' }}">
        <i class="bi bi-house-door-fill me-2"></i> Home Retail
    </a>

    <a href="{{ route('public.addons', array_merge(request()->except(['page','type']), ['type' => 'business'])) }}"
       class="addon-tab {{ $currentType === 'business' ? 'active' : '' }}">
        <i class="bi bi-building me-2"></i> Bisnis
    </a>
</div>

<div class="paket-filter-menu">
    <a href="{{ route('public.addons', array_merge(request()->except(['page','category']), ['type' => $currentType])) }}"
       class="paket-filter-btn {{ request()->routeIs('public.addons') && empty($currentCategory) ? 'active' : '' }}">
        Semua
    </a>

    @foreach($categoryLabels as $value => $label)
        <a href="{{ route('public.addons', array_merge(request()->except('page'), ['type' => $currentType, 'category' => $value])) }}"
           class="paket-filter-btn {{ request()->routeIs('public.addons') && $currentCategory === $value ? 'active' : '' }}">
            {{ $label }}
        </a>
    @endforeach

    <a href="{{ route('public.packages', ['type' => $currentType]) }}"
       class="paket-filter-btn">
        Paket
    </a>
</div>

<div class="addon-toolbar">
    <form method="GET" action="{{ route('public.addons') }}" class="addon-toolbar-form">
        <input type="hidden" name="type" value="{{ $currentType }}">
        @if($currentCategory)
            <input type="hidden" name="category" value="{{ $currentCategory }}">
        @endif

        <div class="row g-3 align-items-end">
            <div class="col-md-8">
                <label class="addon-toolbar-label">Cari Add Ons</label>
                <input
                    type="text"
                    name="q"
                    class="form-control"
                    value="{{ $currentQ }}"
                    placeholder="Cari nama addon, kebutuhan, perangkat, atau deskripsi..."
                >
            </div>

            <div class="col-md-4">
                <label class="addon-toolbar-label">Urutkan</label>
                <select name="sort" class="form-select" onchange="this.form.submit()">
                    <option value="" {{ $currentSort == '' ? 'selected' : '' }}>Rekomendasi</option>
                    <option value="price_asc" {{ $currentSort === 'price_asc' ? 'selected' : '' }}>Harga Termurah</option>
                    <option value="price_desc" {{ $currentSort === 'price_desc' ? 'selected' : '' }}>Harga Termahal</option>
                </select>
            </div>
        </div>

        <div class="addon-toolbar-info">
            <div class="addon-toolbar-count">
                Menampilkan <strong>{{ $addons->total() }}</strong> add on
                @if($currentType)
                    untuk tipe <strong>{{ $currentType === 'business' ? 'Bisnis' : 'Home Retail' }}</strong>
                @endif
                @if($currentCategory)
                    dengan kategori <strong>{{ $categoryLabels[$currentCategory] ?? ucwords(str_replace('-', ' ', $currentCategory)) }}</strong>
                @endif
            </div>

            <div class="d-flex gap-2">
                <a href="{{ route('public.addons', ['type' => $currentType]) }}" class="btn btn-outline-secondary btn-sm btn-soft-reset">
                    Reset
                </a>
                <button type="submit" class="btn btn-primary btn-sm btn-soft-reset">
                    Terapkan
                </button>
            </div>
        </div>
    </form>
</div>

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

            <div class="addon-card">
                <div class="addon-banner" style="{{ $bannerStyle }}">
                    @if($bannerUrl)
                        <img
                            src="{{ $bannerUrl }}"
                            alt="{{ $addon->name }}"
                            loading="lazy"
                            onerror="this.style.display='none';"
                        >
                    @endif
                </div>

                <div class="addon-body">
                    <div class="addon-badges">
                        <span class="addon-badge">
                            {{ $addon->type === 'business' ? 'Bisnis' : 'Home Retail' }}
                        </span>

                        @if($addon->category)
                            <span class="addon-badge">
                                {{ $categoryLabels[$addon->category] ?? ucwords(str_replace('-', ' ', $addon->category)) }}
                            </span>
                        @endif

                        @if((int) ($addon->is_featured ?? 0) === 1)
                            <span class="addon-badge featured">Featured</span>
                        @endif

                        @if((int) ($addon->is_best_seller ?? 0) === 1)
                            <span class="addon-badge best">Best Seller</span>
                        @endif
                    </div>

                    <div class="addon-name">{{ $addon->name }}</div>

                    <div class="addon-price">
                        <p class="addon-price-main">
                            Rp {{ number_format((float) $addon->price, 0, ',', '.') }}
                        </p>
                        <div class="addon-price-note">
                            {{ $priceNote }}
                        </div>
                    </div>

                    @if($addon->short_description)
                        <div class="addon-short-desc">
                            {{ \Illuminate\Support\Str::limit($addon->short_description, 120) }}
                        </div>
                    @endif

                    <div class="addon-meta">
                        @if($addon->device_ideal)
                            <div><strong>Perangkat ideal:</strong> {{ $addon->device_ideal }}</div>
                        @endif

                        @if($addon->best_for)
                            <div><strong>Cocok untuk:</strong> {{ $addon->best_for }}</div>
                        @endif
                    </div>

                    <div class="addon-list-title">Highlight Add On</div>
                    <ul class="addon-list">
                        @forelse($features as $f)
                            <li>{{ $f }}</li>
                        @empty
                            <li>Instalasi rapi</li>
                            <li>Kualitas perangkat baik</li>
                            <li>Cocok untuk kebutuhan modern</li>
                        @endforelse
                    </ul>

                    <div class="addon-actions">
                        <a href="{{ $waUrl }}" class="addon-btn addon-btn-primary" target="_blank" rel="noopener noreferrer">
                            Tanya / Pasang Sekarang
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