@extends('admin.layouts.admin')

@section('title', 'Detail Package')
@section('subtitle', 'Lihat detail data package')

@push('styles')
<style>
    .package-hero {
        border: 1px solid rgba(0,0,0,.08);
        border-radius: 20px;
        background: linear-gradient(135deg, rgba(0, 54, 130, 0.05), rgba(91, 171, 35, 0.07));
        padding: 1.25rem 1.25rem;
        position: relative;
        overflow: hidden;
        margin-bottom: 1rem;
    }

    .package-hero::after {
        content: "";
        position: absolute;
        right: -70px;
        top: -70px;
        width: 180px;
        height: 180px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(0, 54, 130, 0.10), rgba(91, 171, 35, 0.04));
        pointer-events: none;
    }

    .package-title {
        font-size: 1.6rem;
        font-weight: 800;
        line-height: 1.15;
        margin-bottom: .3rem;
    }

    .package-slug {
        color: #6b7280;
        font-size: .9rem;
    }

    .soft-badge {
        display: inline-flex;
        align-items: center;
        gap: .35rem;
        border: 1px solid rgba(0,0,0,.08);
        background: rgba(255,255,255,.7);
        border-radius: 999px;
        padding: .38rem .75rem;
        font-size: .78rem;
        font-weight: 700;
    }

    .detail-card {
        border: 1px solid rgba(0,0,0,.08);
        border-radius: 18px;
        background: #fff;
        padding: 1rem 1rem;
        box-shadow: 0 8px 24px rgba(15, 23, 42, .04);
        margin-bottom: 1rem;
    }

    .detail-card-title {
        font-size: .98rem;
        font-weight: 800;
        margin-bottom: .9rem;
    }

    .detail-label {
        font-size: .77rem;
        color: #6b7280;
        margin-bottom: .18rem;
    }

    .detail-value {
        font-size: .95rem;
        font-weight: 600;
        color: #111827;
        line-height: 1.45;
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 1rem 1.25rem;
    }

    .quick-stats {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: .75rem;
    }

    .stat-box {
        border: 1px solid rgba(0,0,0,.06);
        border-radius: 14px;
        padding: .85rem .9rem;
        background: rgba(0,0,0,.018);
    }

    .stat-box-label {
        font-size: .74rem;
        color: #6b7280;
        margin-bottom: .2rem;
    }

    .stat-box-value {
        font-size: .98rem;
        font-weight: 800;
        color: #111827;
        line-height: 1.3;
    }

    .feature-list {
        margin: 0;
        padding-left: 1rem;
    }

    .feature-list li {
        margin-bottom: .4rem;
        color: #374151;
        font-size: .9rem;
    }

    .chip-wrap {
        display: flex;
        flex-wrap: wrap;
        gap: .5rem;
    }

    .chip {
        border: 1px solid rgba(0,0,0,.08);
        border-radius: 999px;
        padding: .42rem .75rem;
        background: rgba(0,0,0,.03);
        font-size: .8rem;
        font-weight: 600;
        line-height: 1.2;
    }

    .thumb-preview {
        width: 100%;
        max-height: 220px;
        object-fit: cover;
        border-radius: 14px;
        border: 1px solid rgba(0,0,0,.08);
        background: #f8fafc;
    }

    .banner-preview-wrap {
        border-radius: 16px;
        overflow: hidden;
        border: 1px solid rgba(0,0,0,.08);
        background: #f8fafc;
    }

    .banner-preview {
        height: 220px;
        position: relative;
        overflow: hidden;
    }

    .banner-preview img {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        z-index: 0;
    }

    .banner-preview::after {
        content: "";
        position: absolute;
        inset: 0;
        background: linear-gradient(180deg, rgba(0,0,0,.10), rgba(0,0,0,.42));
        z-index: 1;
    }

    .banner-preview-text {
        position: absolute;
        left: 16px;
        right: 16px;
        bottom: 16px;
        color: #fff;
        z-index: 2;
    }

    .banner-preview-title {
        font-size: 1.15rem;
        font-weight: 800;
        margin-bottom: .2rem;
        line-height: 1.2;
    }

    .banner-preview-sub {
        font-size: .92rem;
        line-height: 1.4;
        opacity: .96;
    }

    .empty-box {
        border: 1px dashed rgba(0,0,0,.14);
        border-radius: 14px;
        padding: .85rem 1rem;
        color: #6b7280;
        font-size: .88rem;
        background: rgba(0,0,0,.015);
    }

    .compact-stack > * + * {
        margin-top: .8rem;
    }

    body.admin-body.dark .package-hero,
    body.admin-body.dark .detail-card,
    body.admin-body.dark .soft-badge,
    body.admin-body.dark .stat-box,
    body.admin-body.dark .chip,
    body.admin-body.dark .thumb-preview,
    body.admin-body.dark .empty-box,
    body.admin-body.dark .banner-preview-wrap {
        border-color: rgba(255,255,255,.10);
        background: rgba(255,255,255,.03);
    }

    body.admin-body.dark .package-title,
    body.admin-body.dark .detail-value,
    body.admin-body.dark .stat-box-value,
    body.admin-body.dark .detail-card-title {
        color: #f3f4f6;
    }

    body.admin-body.dark .package-slug,
    body.admin-body.dark .detail-label,
    body.admin-body.dark .stat-box-label,
    body.admin-body.dark .feature-list li,
    body.admin-body.dark .empty-box {
        color: rgba(255,255,255,.7);
    }

    @media (max-width: 991.98px) {
        .info-grid,
        .quick-stats {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 767.98px) {
        .package-title {
            font-size: 1.35rem;
        }

        .banner-preview {
            height: 180px;
        }
    }
</style>
@endpush

@section('content')
@php
    use Illuminate\Support\Facades\Storage;
    use Illuminate\Support\Str;

    $thumbnailUrl = null;
    if (!empty($package->thumbnail)) {
        if (Str::startsWith($package->thumbnail, ['http://', 'https://'])) {
            $thumbnailUrl = $package->thumbnail;
        } elseif (Str::startsWith($package->thumbnail, '/storage/')) {
            $thumbnailUrl = $package->thumbnail;
        } elseif (Str::startsWith($package->thumbnail, 'storage/')) {
            $thumbnailUrl = asset($package->thumbnail);
        } else {
            $thumbnailUrl = Storage::url($package->thumbnail);
        }
    }

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

    $categoryLabel = match($package->category) {
        'internet_only' => 'Internet Only',
        'internet_tv'   => 'Internet + TV',
        'streaming'     => 'Streaming',
        default         => $package->category ? ucfirst(str_replace('_', ' ', $package->category)) : '-',
    };

    $features = collect(preg_split("/\r\n|\n|\r|,/", $package->features ?? ''))
        ->map(fn($item) => trim($item))
        ->filter()
        ->values();

    $priceMonthly = !is_null($package->price_monthly)
        ? 'Rp ' . number_format((float) $package->price_monthly, 0, ',', '.')
        : '-';

    $speedLabel = !is_null($package->speed_mbps) ? $package->speed_mbps . ' Mbps' : '-';
    $durationLabel = !is_null($package->duration_months) ? $package->duration_months . ' bulan' : '-';
    $userLabel = (!is_null($package->min_users) || !is_null($package->max_users))
        ? ($package->min_users ?? '?') . ' - ' . ($package->max_users ?? '?') . ' pengguna'
        : '-';

    $bannerStart = $package->banner_color_start ?: '#003682';
    $bannerEnd   = $package->banner_color_end ?: '#5bab23';
@endphp

<div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-3">
    <div>
        <div class="fw-bold fs-5">Detail Paket</div>
        <div class="text-muted small">Informasi lengkap paket layanan.</div>
    </div>

    <div class="d-flex gap-2 flex-wrap">
        <a href="{{ route('admin.packages.edit', $package->id) }}" class="btn btn-primary">
            <i class="bi bi-pencil me-1"></i> Edit
        </a>
        <a href="{{ route('admin.packages.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
    </div>
</div>

<div class="package-hero">
    <div class="row g-3 align-items-start position-relative" style="z-index:1;">
        <div class="col-lg-8">
            <div class="d-flex flex-wrap gap-2 mb-3">
                <span class="soft-badge">
                    <i class="bi bi-house-door"></i>
                    {{ $package->type ? ucfirst($package->type) : '-' }}
                </span>

                @if($package->category)
                    <span class="soft-badge">
                        <i class="bi bi-tag"></i>
                        {{ $categoryLabel }}
                    </span>
                @endif

                @if((int) $package->is_featured === 1)
                    <span class="badge text-bg-primary">Featured</span>
                @endif

                @if((int) $package->is_best_seller === 1)
                    <span class="badge text-bg-warning">Best Seller</span>
                @endif

                <span class="badge {{ (int) $package->is_active === 1 ? 'text-bg-success' : 'text-bg-secondary' }}">
                    {{ (int) $package->is_active === 1 ? 'Aktif' : 'Nonaktif' }}
                </span>
            </div>

            <div class="package-title">{{ $package->name ?? 'Package' }}</div>
            <div class="package-slug mb-3">{{ $package->slug ?? '-' }}</div>

            @if($package->short_description)
                <div class="detail-value" style="font-weight:500; max-width:720px;">
                    {{ $package->short_description }}
                </div>
            @else
                <div class="package-slug">Belum ada deskripsi singkat.</div>
            @endif
        </div>

        <div class="col-lg-4">
            <div class="quick-stats">
                <div class="stat-box">
                    <div class="stat-box-label">Harga</div>
                    <div class="stat-box-value">{{ $priceMonthly }}</div>
                </div>
                <div class="stat-box">
                    <div class="stat-box-label">Kecepatan</div>
                    <div class="stat-box-value">{{ $speedLabel }}</div>
                </div>
                <div class="stat-box">
                    <div class="stat-box-label">Durasi</div>
                    <div class="stat-box-value">{{ $durationLabel }}</div>
                </div>
                <div class="stat-box">
                    <div class="stat-box-label">Pengguna</div>
                    <div class="stat-box-value">{{ $userLabel }}</div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-lg-8">
        <div class="detail-card">
            <div class="detail-card-title">Preview Banner Paket</div>

            <div class="banner-preview-wrap">
                <div class="banner-preview" style="background: linear-gradient(135deg, {{ $bannerStart }}, {{ $bannerEnd }});">
                    @if($bannerUrl)
                        <img src="{{ $bannerUrl }}" alt="{{ $package->name }}" onerror="this.style.display='none';">
                    @endif

                    <div class="banner-preview-text">
                        <div class="banner-preview-title">{{ $package->name ?: 'Nama Paket' }}</div>
                        <div class="banner-preview-sub">
                            {{ $package->short_description ?: 'Preview banner paket akan tampil di sini.' }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-3 mt-2">
                <div class="col-md-6">
                    <div class="detail-label">Banner Image</div>
                    <div class="detail-value" style="word-break: break-word;">
                        {{ $package->banner_image ?: '-' }}
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="detail-label">Banner Color Start</div>
                    <div class="detail-value">{{ $package->banner_color_start ?: '#003682' }}</div>
                </div>
                <div class="col-md-3">
                    <div class="detail-label">Banner Color End</div>
                    <div class="detail-value">{{ $package->banner_color_end ?: '#5bab23' }}</div>
                </div>
            </div>
        </div>

        <div class="detail-card">
            <div class="detail-card-title">Informasi Paket</div>

            <div class="info-grid">
                <div>
                    <div class="detail-label">Nama Paket</div>
                    <div class="detail-value">{{ $package->name ?: '-' }}</div>
                </div>
                <div>
                    <div class="detail-label">Slug</div>
                    <div class="detail-value">{{ $package->slug ?: '-' }}</div>
                </div>
                <div>
                    <div class="detail-label">Tipe Layanan</div>
                    <div class="detail-value">{{ $package->type ? ucfirst($package->type) : '-' }}</div>
                </div>
                <div>
                    <div class="detail-label">Kategori Paket</div>
                    <div class="detail-value">{{ $categoryLabel }}</div>
                </div>
                <div>
                    <div class="detail-label">Kecepatan</div>
                    <div class="detail-value">{{ $speedLabel }}</div>
                </div>
                <div>
                    <div class="detail-label">Harga per Bulan</div>
                    <div class="detail-value">{{ $priceMonthly }}</div>
                </div>
                <div>
                    <div class="detail-label">Durasi Paket</div>
                    <div class="detail-value">{{ $durationLabel }}</div>
                </div>
                <div>
                    <div class="detail-label">Jumlah Pengguna</div>
                    <div class="detail-value">{{ $userLabel }}</div>
                </div>
                <div>
                    <div class="detail-label">Cocok Untuk</div>
                    <div class="detail-value">{{ $package->best_for ?: '-' }}</div>
                </div>
                <div>
                    <div class="detail-label">Perangkat Ideal</div>
                    <div class="detail-value">{{ $package->device_ideal ?: '-' }}</div>
                </div>
            </div>
        </div>

        <div class="detail-card">
            <div class="detail-card-title">Fitur Paket</div>

            @if($features->count())
                <ul class="feature-list">
                    @foreach($features as $feature)
                        <li>{{ $feature }}</li>
                    @endforeach
                </ul>
            @else
                <div class="empty-box">Belum ada fitur paket yang diisi.</div>
            @endif
        </div>

        <div class="detail-card">
            <div class="detail-card-title">Media & Order</div>

            <div class="row g-3">
                <div class="col-md-6">
                    <div class="detail-label">Thumbnail</div>
                    @if($thumbnailUrl)
                        <div class="mb-2 small text-muted" style="word-break: break-word;">{{ $package->thumbnail }}</div>
                        <img src="{{ $thumbnailUrl }}" alt="{{ $package->name }}" class="thumb-preview" onerror="this.style.display='none';">
                    @else
                        <div class="empty-box">Belum ada thumbnail.</div>
                    @endif
                </div>

                <div class="col-md-6">
                    <div class="detail-label">WhatsApp Order URL</div>
                    @if($package->whatsapp_order_url)
                        <div class="detail-value mb-3" style="word-break: break-word;">
                            <a href="{{ $package->whatsapp_order_url }}" target="_blank" rel="noopener noreferrer">
                                {{ $package->whatsapp_order_url }}
                            </a>
                        </div>
                        <a href="{{ $package->whatsapp_order_url }}" target="_blank" rel="noopener noreferrer" class="btn btn-success">
                            <i class="bi bi-whatsapp me-1"></i> Buka Link Order
                        </a>
                    @else
                        <div class="empty-box">Belum ada link WhatsApp order.</div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="compact-stack">
            <div class="detail-card">
                <div class="detail-card-title">Fitur Tambahan</div>
                <div class="chip-wrap">
                    <span class="chip">TV: {{ (int)($package->includes_tv ?? 0) ? 'Ya' : 'Tidak' }}</span>
                    <span class="chip">Streaming App: {{ (int)($package->includes_streaming_app ?? 0) ? 'Ya' : 'Tidak' }}</span>
                    <span class="chip">Kuota Mobile: {{ (int)($package->includes_mobile_quota ?? 0) ? 'Ya' : 'Tidak' }}</span>
                </div>
            </div>

            <div class="detail-card">
                <div class="detail-card-title">Rekomendasi Penggunaan</div>
                <div class="chip-wrap">
                    <span class="chip">Gaming: {{ (int)($package->good_for_gaming ?? 0) ? 'Ya' : 'Tidak' }}</span>
                    <span class="chip">Streaming: {{ (int)($package->good_for_streaming ?? 0) ? 'Ya' : 'Tidak' }}</span>
                    <span class="chip">WFH: {{ (int)($package->good_for_wfh ?? 0) ? 'Ya' : 'Tidak' }}</span>
                </div>
            </div>

            <div class="detail-card">
                <div class="detail-card-title">Status Paket</div>
                <div class="chip-wrap mb-3">
                    <span class="badge {{ (int)($package->is_active ?? 0) ? 'text-bg-success' : 'text-bg-secondary' }}">
                        {{ (int)($package->is_active ?? 0) ? 'Aktif' : 'Nonaktif' }}
                    </span>
                    <span class="badge {{ (int)($package->is_featured ?? 0) ? 'text-bg-primary' : 'text-bg-secondary' }}">
                        {{ (int)($package->is_featured ?? 0) ? 'Featured' : 'Tidak Featured' }}
                    </span>
                    <span class="badge {{ (int)($package->is_best_seller ?? 0) ? 'text-bg-warning' : 'text-bg-secondary' }}">
                        {{ (int)($package->is_best_seller ?? 0) ? 'Best Seller' : 'Bukan Best Seller' }}
                    </span>
                </div>

                <div class="small text-muted">
                    Status ini menentukan visibilitas dan highlight paket di website.
                </div>
            </div>

            <div class="detail-card">
                <div class="detail-card-title">Informasi Sistem</div>

                <div class="mb-3">
                    <div class="detail-label">Dibuat pada</div>
                    <div class="detail-value">
                        {{ $package->created_at ? $package->created_at->format('d M Y, H:i') : '-' }}
                    </div>
                </div>

                <div>
                    <div class="detail-label">Terakhir diupdate</div>
                    <div class="detail-value">
                        {{ $package->updated_at ? $package->updated_at->format('d M Y, H:i') : '-' }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection