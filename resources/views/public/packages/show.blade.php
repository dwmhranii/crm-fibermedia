@extends('public.layouts.app')

@section('title', $package->name)

@push('styles')
<style>
    .pkg-hero{
        border-radius: 22px;
        padding: 28px;
        background: radial-gradient(circle at top left, rgba(37,99,235,.18), transparent 55%),
                    radial-gradient(circle at bottom right, rgba(34,197,94,.14), transparent 50%),
                    #ffffff;
        border: 1px solid #e5e7eb;
        box-shadow: 0 14px 40px rgba(15,23,42,.06);
    }

    body.dark-mode .pkg-hero{
        background: radial-gradient(circle at top left, rgba(37,99,235,.22), transparent 55%),
                    radial-gradient(circle at bottom right, rgba(34,197,94,.16), transparent 50%),
                    #0f172a;
        border-color:#1f2937;
        box-shadow: 0 18px 55px rgba(0,0,0,.55);
    }

    .pkg-thumb{
        width: 100%;
        border-radius: 18px;
        overflow: hidden;
        border: 1px solid #e5e7eb;
        background: #f9fafb;
        aspect-ratio: 16/10;
        display:flex;
        align-items:center;
        justify-content:center;
    }

    body.dark-mode .pkg-thumb{
        border-color:#1f2937;
        background:#020617;
    }

    .pkg-thumb img{
        width: 100%;
        height: 100%;
        object-fit: cover;
        display:block;
    }

    .pkg-badges .badge{
        border-radius: 999px;
        padding: .45rem .75rem;
        font-weight: 700;
    }

    .pkg-price{
        font-size: 2.1rem;
        font-weight: 900;
        letter-spacing: -0.02em;
    }

    .pkg-muted{ color:#6b7280; }
    body.dark-mode .pkg-muted{ color:#9ca3af; }

    .pkg-card{
        border-radius: 18px;
        border: 1px solid #e5e7eb;
        background:#fff;
        box-shadow: 0 10px 26px rgba(15,23,42,.06);
    }
    body.dark-mode .pkg-card{
        background:#0b1220;
        border-color:#1f2937;
        box-shadow: 0 14px 32px rgba(0,0,0,.6);
    }

    .pkg-feature-list li{ margin-bottom: .4rem; }
</style>
@endpush

@section('content')
<div class="mb-3">
    <a href="{{ route('public.packages') }}" class="text-decoration-none">
        <i class="bi bi-arrow-left"></i> Kembali ke daftar paket
    </a>
</div>

<div class="pkg-hero">
    <div class="row g-4 align-items-center">
        <div class="col-lg-5">
            <div class="pkg-thumb">
                @php
                    $thumb = $package->thumbnail ? asset('storage/'.$package->thumbnail) : asset('assets/package-default.png');
                @endphp
                <img src="{{ $thumb }}" alt="{{ $package->name }}">
            </div>
        </div>

        <div class="col-lg-7">
            <div class="pkg-badges d-flex flex-wrap gap-2 mb-2">
                <span class="badge text-bg-primary">
                    {{ strtoupper($package->type) }}
                </span>

                @if($package->is_best_seller)
                    <span class="badge text-bg-warning">
                        <i class="bi bi-star-fill me-1"></i> Best Seller
                    </span>
                @endif

                @if($package->is_featured)
                    <span class="badge text-bg-success">
                        <i class="bi bi-lightning-fill me-1"></i> Featured
                    </span>
                @endif
            </div>

            <h1 class="fw-bold mb-1">{{ $package->name }}</h1>

            @if($package->short_description)
                <div class="pkg-muted mb-3">{{ $package->short_description }}</div>
            @endif

            <div class="d-flex flex-wrap align-items-end gap-3 mb-3">
                <div>
                    <div class="pkg-price">
                        Rp {{ number_format((int)$package->price_monthly, 0, ',', '.') }}
                    </div>
                    <div class="pkg-muted small">
                        / {{ (int) $package->duration_months }} bulan
                    </div>
                </div>

                <div class="ms-auto d-flex flex-wrap gap-2">
                    @php
                        $wa = $settings['contact_whatsapp'] ?? '6281234567890';
                        $wa = preg_replace('/\D+/', '', $wa);

                        $waUrl = $package->whatsapp_order_url;
                        if (!$waUrl) {
                            $text = "Halo, saya ingin berlangganan paket: {$package->name}";
                            $waUrl = "https://wa.me/{$wa}?text=" . urlencode($text);
                        }
                    @endphp

                    <a href="{{ $waUrl }}" target="_blank" class="btn btn-primary btn-lg px-4">
                        <i class="bi bi-whatsapp me-1"></i> Pesan via WhatsApp
                    </a>

                    <a href="{{ route('public.coverage') }}" class="btn btn-outline-secondary btn-lg">
                        Cek Coverage
                    </a>
                </div>
            </div>

            <div class="row g-2">
                <div class="col-sm-6 col-lg-4">
                    <div class="pkg-card p-3 h-100">
                        <div class="pkg-muted small">Kecepatan</div>
                        <div class="fw-bold fs-5">{{ (int) $package->speed_mbps }} Mbps</div>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-4">
                    <div class="pkg-card p-3 h-100">
                        <div class="pkg-muted small">Cocok untuk</div>
                        <div class="fw-bold">{{ $package->best_for ?? '-' }}</div>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-4">
                    <div class="pkg-card p-3 h-100">
                        <div class="pkg-muted small">Kategori</div>
                        <div class="fw-bold">
                            {{ $package->category ? str_replace('_',' ', $package->category) : '-' }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-3 pkg-muted small">
                @php
                    $bullets = [];
                    if($package->good_for_gaming) $bullets[] = 'Gaming';
                    if($package->good_for_streaming) $bullets[] = 'Streaming';
                    if($package->good_for_wfh) $bullets[] = 'WFH';
                    if($package->includes_tv) $bullets[] = 'Include TV';
                    if($package->includes_streaming_app) $bullets[] = 'Include Streaming App';
                    if($package->includes_mobile_quota) $bullets[] = 'Include Kuota HP';
                @endphp

                @if(count($bullets))
                    <i class="bi bi-check2-circle me-1"></i>
                    {{ implode(' • ', $bullets) }}
                @endif
            </div>
        </div>
    </div>
</div>

{{-- FEATURES --}}
<div class="row g-4 mt-1">
    <div class="col-lg-8">
        <div class="pkg-card p-4">
            <h5 class="fw-bold mb-3">Detail Paket</h5>

            @if($package->features)
                <div class="pkg-muted" style="white-space: pre-line;">
                    {{ $package->features }}
                </div>
            @else
                <div class="text-muted">Belum ada detail fitur.</div>
            @endif
        </div>
    </div>

    <div class="col-lg-4">
        <div class="pkg-card p-4">
            <h6 class="fw-bold mb-3">Info Tambahan</h6>

            <ul class="mb-0 pkg-feature-list">
                <li>Minimal pengguna: <strong>{{ $package->min_users ?? '-' }}</strong></li>
                <li>Maksimal pengguna: <strong>{{ $package->max_users ?? '-' }}</strong></li>
                <li>Device ideal: <strong>{{ $package->device_ideal ?? '-' }}</strong></li>
            </ul>

            <hr class="my-4">

            <div class="d-grid gap-2">
                <a href="{{ $waUrl }}" target="_blank" class="btn btn-primary">
                    <i class="bi bi-whatsapp me-1"></i> Order Sekarang
                </a>
                <a href="{{ route('public.packages') }}" class="btn btn-outline-secondary">
                    Lihat Paket Lain
                </a>
            </div>
        </div>
    </div>
</div>

{{-- RELATED --}}
@if(isset($related) && $related->count())
<div class="mt-4">
    <div class="d-flex align-items-center justify-content-between mb-2">
        <h5 class="fw-bold mb-0">Paket Lainnya</h5>
        <a class="text-decoration-none" href="{{ route('public.packages') }}">Lihat semua</a>
    </div>

    <div class="row g-3">
        @foreach($related as $p)
            <div class="col-md-6 col-lg-4">
                <div class="pkg-card p-3 h-100">
                    <div class="d-flex align-items-start justify-content-between gap-2">
                        <div>
                            <div class="fw-bold">{{ $p->name }}</div>
                            <div class="pkg-muted small">{{ (int)$p->speed_mbps }} Mbps</div>
                        </div>
                        @if($p->is_best_seller)
                            <span class="badge text-bg-warning">Best</span>
                        @endif
                    </div>

                    <div class="mt-2 fw-bold">
                        Rp {{ number_format((int)$p->price_monthly, 0, ',', '.') }}
                        <span class="pkg-muted small">/bulan</span>
                    </div>

                    <div class="mt-3 d-flex gap-2">
                        <a href="{{ route('public.packages.show', $p->slug) }}" class="btn btn-outline-primary btn-sm">
                            Detail
                        </a>
                        <a href="{{ route('public.packages') }}" class="btn btn-outline-secondary btn-sm">
                            Semua Paket
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endif
@endsection
