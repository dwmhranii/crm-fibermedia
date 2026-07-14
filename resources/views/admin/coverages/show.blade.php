@extends('admin.layouts.admin')

@section('title', 'Detail Coverage')
@section('subtitle', 'Lihat detail area coverage')

@push('styles')
    <link rel="stylesheet"
          href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
          integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
          crossorigin=""/>

    <style>
        .coverage-hero{
            border: 1px solid #e5e7eb;
            border-radius: 22px;
            padding: 1.25rem 1.25rem;
            background: linear-gradient(135deg, rgba(37,99,235,.05), rgba(34,197,94,.06));
            box-shadow: 0 14px 40px rgba(15,23,42,.06);
        }

        .coverage-title{
            font-size: 1.8rem;
            font-weight: 800;
            line-height: 1.15;
            margin-bottom: .3rem;
        }

        .coverage-sub{
            color: #6b7280;
            font-size: .95rem;
        }

        .soft-pill{
            display: inline-flex;
            align-items: center;
            gap: .4rem;
            border: 1px solid rgba(0,0,0,.08);
            background: rgba(255,255,255,.7);
            border-radius: 999px;
            padding: .38rem .75rem;
            font-size: .8rem;
            font-weight: 700;
        }

        .detail-card{
            border: 1px solid #e5e7eb;
            border-radius: 20px;
            background: #fff;
            padding: 1rem 1rem;
            box-shadow: 0 10px 30px rgba(15,23,42,.05);
            height: 100%;
        }

        .detail-card-title{
            font-size: 1rem;
            font-weight: 800;
            margin-bottom: .9rem;
        }

        .detail-label{
            font-size: .78rem;
            color: #6b7280;
            margin-bottom: .18rem;
        }

        .detail-value{
            font-size: .98rem;
            font-weight: 600;
            color: #111827;
            line-height: 1.45;
        }

        .info-grid{
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 1rem 1.25rem;
        }

        .stat-grid{
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: .75rem;
        }

        .stat-box{
            border: 1px solid rgba(0,0,0,.06);
            border-radius: 16px;
            padding: .9rem;
            background: rgba(0,0,0,.02);
        }

        .stat-box-label{
            font-size: .75rem;
            color: #6b7280;
            margin-bottom: .2rem;
        }

        .stat-box-value{
            font-size: 1rem;
            font-weight: 800;
            color: #111827;
        }

        .map-wrap{
            border-radius: 16px;
            overflow: hidden;
            border: 1px solid #e5e7eb;
            background: #fff;
        }

        #coverageShowMap{
            width: 100%;
            height: 320px;
        }

        .empty-note{
            border: 1px dashed rgba(0,0,0,.14);
            border-radius: 16px;
            padding: .9rem 1rem;
            color: #6b7280;
            background: rgba(0,0,0,.015);
            font-size: .92rem;
        }

        body.admin-body.dark .coverage-hero,
        body.admin-body.dark .detail-card,
        body.admin-body.dark .soft-pill,
        body.admin-body.dark .stat-box,
        body.admin-body.dark .map-wrap,
        body.admin-body.dark .empty-note{
            background: rgba(255,255,255,.03);
            border-color: rgba(255,255,255,.10);
            box-shadow: 0 18px 55px rgba(0,0,0,.35);
        }

        body.admin-body.dark .coverage-title,
        body.admin-body.dark .detail-value,
        body.admin-body.dark .stat-box-value,
        body.admin-body.dark .detail-card-title{
            color: #f3f4f6;
        }

        body.admin-body.dark .coverage-sub,
        body.admin-body.dark .detail-label,
        body.admin-body.dark .stat-box-label,
        body.admin-body.dark .empty-note{
            color: rgba(255,255,255,.7);
        }

        @media (max-width: 767.98px){
            .coverage-title{
                font-size: 1.45rem;
            }

            .info-grid,
            .stat-grid{
                grid-template-columns: 1fr;
            }
        }
    </style>
@endpush

@section('content')
@php
    $hasCoord = !is_null($coverage->lat) && !is_null($coverage->lng);
    $mapsUrl = $hasCoord ? "https://www.google.com/maps?q={$coverage->lat},{$coverage->lng}" : null;
@endphp

<div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-3">
    <div>
        <div class="fw-bold fs-5">Detail Coverage</div>
        <div class="text-muted small">Informasi lengkap area coverage.</div>
    </div>

    <div class="d-flex gap-2 flex-wrap">
        <a href="{{ route('admin.coverages.edit', $coverage->id) }}" class="btn btn-primary">
            <i class="bi bi-pencil me-1"></i> Edit Coverage
        </a>

        <a href="{{ route('admin.coverages.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
    </div>
</div>

<div class="coverage-hero mb-4">
    <div class="row g-3 align-items-start">
        <div class="col-lg-8">
            <div class="d-flex flex-wrap gap-2 mb-3">
                <span class="badge {{ $coverage->is_active ? 'text-bg-success' : 'text-bg-secondary' }}">
                    {{ $coverage->is_active ? 'Active' : 'Nonaktif' }}
                </span>

                @if(!empty($coverage->city))
                    <span class="soft-pill">
                        <i class="bi bi-building"></i> {{ $coverage->city }}
                    </span>
                @endif

                @if(!empty($coverage->district))
                    <span class="soft-pill">
                        <i class="bi bi-geo"></i> {{ $coverage->district }}
                    </span>
                @endif

                <span class="soft-pill">
                    <i class="bi bi-sort-numeric-down"></i> Sort: {{ $coverage->sort_order ?? 0 }}
                </span>
            </div>

            <div class="coverage-title">{{ $coverage->name }}</div>
            <div class="coverage-sub">
                {{ $coverage->city ?? '-' }}
                @if(!empty($coverage->district))
                    • {{ $coverage->district }}
                @endif
            </div>
        </div>

        <div class="col-lg-4">
            <div class="stat-grid">
                <div class="stat-box">
                    <div class="stat-box-label">Latitude</div>
                    <div class="stat-box-value">{{ $coverage->lat ?? '-' }}</div>
                </div>

                <div class="stat-box">
                    <div class="stat-box-label">Longitude</div>
                    <div class="stat-box-value">{{ $coverage->lng ?? '-' }}</div>
                </div>

                <div class="stat-box">
                    <div class="stat-box-label">Status</div>
                    <div class="stat-box-value">{{ $coverage->is_active ? 'Active' : 'Nonaktif' }}</div>
                </div>

                <div class="stat-box">
                    <div class="stat-box-label">Sort Order</div>
                    <div class="stat-box-value">{{ $coverage->sort_order ?? 0 }}</div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-lg-6">
        <div class="detail-card">
            <div class="detail-card-title">Informasi Area</div>

            <div class="info-grid">
                <div>
                    <div class="detail-label">Nama Area</div>
                    <div class="detail-value">{{ $coverage->name }}</div>
                </div>

                <div>
                    <div class="detail-label">Status</div>
                    <div class="detail-value">
                        {{ $coverage->is_active ? 'Active' : 'Nonaktif' }}
                    </div>
                </div>

                <div>
                    <div class="detail-label">Kecamatan</div>
                    <div class="detail-value">{{ $coverage->district ?? '-' }}</div>
                </div>

                <div>
                    <div class="detail-label">Kota</div>
                    <div class="detail-value">{{ $coverage->city ?? '-' }}</div>
                </div>

                <div>
                    <div class="detail-label">Sort Order</div>
                    <div class="detail-value">{{ $coverage->sort_order ?? 0 }}</div>
                </div>

                <div>
                    <div class="detail-label">ID Data</div>
                    <div class="detail-value">#{{ $coverage->id }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="detail-card">
            <div class="detail-card-title">Koordinat</div>

            <div class="info-grid mb-3">
                <div>
                    <div class="detail-label">Latitude</div>
                    <div class="detail-value">{{ $coverage->lat ?? '-' }}</div>
                </div>

                <div>
                    <div class="detail-label">Longitude</div>
                    <div class="detail-value">{{ $coverage->lng ?? '-' }}</div>
                </div>
            </div>

            @if($hasCoord)
                <div class="d-flex gap-2 flex-wrap">
                    <a class="btn btn-outline-primary btn-sm"
                       target="_blank"
                       rel="noopener noreferrer"
                       href="{{ $mapsUrl }}">
                        <i class="bi bi-geo-alt me-1"></i> Buka di Maps
                    </a>
                </div>
            @else
                <div class="empty-note">
                    Koordinat belum diisi. Silakan buka halaman edit lalu klik peta untuk menambahkan marker.
                </div>
            @endif
        </div>
    </div>

    <div class="col-12">
        <div class="detail-card">
            <div class="detail-card-title">Peta Lokasi</div>

            @if($hasCoord)
                <div class="map-wrap">
                    <div id="coverageShowMap"></div>
                </div>
            @else
                <div class="empty-note">
                    Peta belum bisa ditampilkan karena latitude dan longitude belum tersedia.
                </div>
            @endif
        </div>
    </div>

    <div class="col-12">
        <div class="detail-card">
            <div class="detail-card-title">Informasi Sistem</div>

            <div class="info-grid">
                <div>
                    <div class="detail-label">Dibuat pada</div>
                    <div class="detail-value">
                        {{ $coverage->created_at ? $coverage->created_at->format('d M Y, H:i') : '-' }}
                    </div>
                </div>

                <div>
                    <div class="detail-label">Terakhir diupdate</div>
                    <div class="detail-value">
                        {{ $coverage->updated_at ? $coverage->updated_at->format('d M Y, H:i') : '-' }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    @if($hasCoord)
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
                integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
                crossorigin=""></script>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const lat = {{ (float) $coverage->lat }};
                const lng = {{ (float) $coverage->lng }};

                const map = L.map('coverageShowMap', {
                    scrollWheelZoom: false
                }).setView([lat, lng], 15);

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19,
                    attribution: '&copy; OpenStreetMap'
                }).addTo(map);

                L.marker([lat, lng]).addTo(map)
                    .bindPopup(@json($coverage->name))
                    .openPopup();

                setTimeout(() => {
                    map.invalidateSize();
                }, 150);
            });
        </script>
    @endif
@endpush