@extends('admin.layouts.admin')

@section('title', 'Packages')
@section('subtitle', 'Kelola data paket layanan')

@php
    use Illuminate\Support\Facades\Storage;
    use Illuminate\Support\Str;

    $packages = $packages ?? collect();
    $isPaginator = $packages instanceof \Illuminate\Contracts\Pagination\Paginator
        || $packages instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator;

    $q = request('q', '');
@endphp

@push('styles')
<style>
    .package-table thead th {
        white-space: nowrap;
        font-size: .82rem;
        text-transform: uppercase;
        letter-spacing: .02em;
    }

    .package-card-hint {
        color: #6c757d;
        font-size: .9rem;
    }

    .badge-soft {
        display: inline-flex;
        align-items: center;
        gap: .35rem;
        border: 1px solid rgba(0,0,0,.08);
        background: rgba(0,0,0,.03);
        border-radius: 999px;
        padding: .3rem .65rem;
        font-weight: 600;
        font-size: .78rem;
    }

    .package-name {
        font-weight: 700;
        font-size: .96rem;
        line-height: 1.35;
    }

    .package-sub {
        color: #6c757d;
        font-size: .84rem;
        line-height: 1.45;
    }

    .package-price {
        font-weight: 700;
        font-size: .95rem;
    }

    .package-actions .btn {
        padding: .38rem .58rem;
    }

    .flag-stack {
        display: flex;
        flex-wrap: wrap;
        gap: .35rem;
    }

    .table-wrap {
        border: 1px solid rgba(0,0,0,.08);
        border-radius: 1rem;
        overflow: hidden;
        background: #fff;
    }

    .top-tools {
        border: 1px solid rgba(0,0,0,.08);
        border-radius: 1rem;
        padding: 1rem;
        background: #fff;
    }

    .empty-state {
        padding: 3rem 1rem;
        text-align: center;
        color: #6c757d;
    }

    .package-thumb {
        width: 72px;
        height: 52px;
        border-radius: 12px;
        overflow: hidden;
        flex-shrink: 0;
        position: relative;
        border: 1px solid rgba(0,0,0,.08);
        background: linear-gradient(135deg, #003682, #5bab23);
    }

    .package-thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    body.admin-body.dark .badge-soft,
    body.admin-body.dark .table-wrap,
    body.admin-body.dark .top-tools {
        border-color: rgba(255,255,255,.10);
        background: rgba(255,255,255,.03);
    }

    body.admin-body.dark .package-sub,
    body.admin-body.dark .package-card-hint,
    body.admin-body.dark .empty-state {
        color: rgba(255,255,255,.68);
    }
</style>
@endpush

@section('content')
<div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-3">
    <div>
        <div class="fw-bold fs-5">Daftar Paket</div>
        <div class="package-card-hint">Lihat, cari, ubah, dan kelola paket layanan internet.</div>
    </div>

    <a href="{{ route('admin.packages.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle me-1"></i> Tambah Paket
    </a>
</div>

<div class="top-tools mb-3">
    <form method="GET" class="row g-2 align-items-end">
        <div class="col-lg-6">
            <label class="form-label small text-muted">Cari paket</label>
            <input
                type="text"
                name="q"
                value="{{ $q }}"
                class="form-control"
                placeholder="Cari nama, slug, tipe, atau kategori..."
            >
        </div>

        <div class="col-sm-6 col-lg-3">
            <button class="btn btn-outline-secondary w-100" type="submit">
                <i class="bi bi-search me-1"></i> Cari
            </button>
        </div>

        <div class="col-sm-6 col-lg-3">
            <a href="{{ route('admin.packages.index') }}" class="btn btn-outline-secondary w-100">
                <i class="bi bi-arrow-counterclockwise me-1"></i> Reset
            </a>
        </div>
    </form>
</div>

<div class="table-wrap">
    <div class="table-responsive">
        <table class="table align-middle mb-0 package-table">
            <thead class="table-light">
                <tr class="text-muted">
                    <th style="width:70px;">#</th>
                    <th>Paket</th>
                    <th>Tipe</th>
                    <th>Harga</th>
                    <th>Fitur</th>
                    <th>Status</th>
                    <th class="text-end" style="width:190px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
            @forelse($packages as $i => $p)
                @php
                    $bannerUrl = null;

                    if (!empty($p->banner_image)) {
                        if (Str::startsWith($p->banner_image, ['http://', 'https://'])) {
                            $bannerUrl = $p->banner_image;
                        } elseif (Str::startsWith($p->banner_image, '/storage/')) {
                            $bannerUrl = $p->banner_image;
                        } elseif (Str::startsWith($p->banner_image, 'storage/')) {
                            $bannerUrl = asset($p->banner_image);
                        } else {
                            $bannerUrl = Storage::url($p->banner_image);
                        }
                    }
                @endphp
                <tr>
                    <td class="text-muted">
                        @if($isPaginator)
                            {{ ($packages->firstItem() ?? 1) + $i }}
                        @else
                            {{ $i + 1 }}
                        @endif
                    </td>

                    <td>
                        <div class="d-flex gap-3">
                            <div class="package-thumb"
                                 style="background:linear-gradient(135deg, {{ $p->banner_color_start ?: '#003682' }}, {{ $p->banner_color_end ?: '#5bab23' }});">
                                @if($bannerUrl)
                                    <img src="{{ $bannerUrl }}" alt="{{ $p->name }}">
                                @endif
                            </div>

                            <div>
                                <div class="package-name">{{ $p->name ?? '-' }}</div>
                                <div class="package-sub mb-1">{{ $p->slug ?? '-' }}</div>

                                <div class="d-flex flex-wrap gap-2">
                                    @if(!empty($p->category))
                                        <span class="badge-soft">{{ ucfirst(str_replace('_', ' ', $p->category)) }}</span>
                                    @endif

                                    @if(!empty($p->speed_mbps))
                                        <span class="badge-soft">{{ $p->speed_mbps }} Mbps</span>
                                    @endif

                                    @if(!empty($p->short_description))
                                        <span class="package-sub">
                                            {{ \Illuminate\Support\Str::limit($p->short_description, 70) }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </td>

                    <td>
                        <div class="fw-semibold">
                            {{ $p->type ? ucfirst($p->type) : '-' }}
                        </div>

                        @if(!is_null($p->min_users) || !is_null($p->max_users))
                            <div class="package-sub">
                                Pengguna:
                                {{ $p->min_users ?? '?' }} - {{ $p->max_users ?? '?' }}
                            </div>
                        @endif

                        @if(!empty($p->duration_months))
                            <div class="package-sub">
                                Durasi: {{ $p->duration_months }} bulan
                            </div>
                        @endif
                    </td>

                    <td>
                        <div class="package-price">
                            @if(!is_null($p->price_monthly))
                                Rp {{ number_format((float) $p->price_monthly, 0, ',', '.') }}
                            @else
                                -
                            @endif
                        </div>
                        <div class="package-sub">per bulan</div>
                    </td>

                    <td>
                        <div class="flag-stack">
                            @if((int)($p->includes_tv ?? 0) === 1)
                                <span class="badge text-bg-info">TV</span>
                            @endif

                            @if((int)($p->includes_streaming_app ?? 0) === 1)
                                <span class="badge text-bg-primary">Streaming App</span>
                            @endif

                            @if((int)($p->includes_mobile_quota ?? 0) === 1)
                                <span class="badge text-bg-dark">Kuota Mobile</span>
                            @endif

                            @if((int)($p->good_for_gaming ?? 0) === 1)
                                <span class="badge text-bg-warning">Gaming</span>
                            @endif

                            @if((int)($p->good_for_streaming ?? 0) === 1)
                                <span class="badge text-bg-success">Streaming</span>
                            @endif

                            @if((int)($p->good_for_wfh ?? 0) === 1)
                                <span class="badge text-bg-secondary">WFH</span>
                            @endif

                            @if(
                                (int)($p->includes_tv ?? 0) !== 1 &&
                                (int)($p->includes_streaming_app ?? 0) !== 1 &&
                                (int)($p->includes_mobile_quota ?? 0) !== 1 &&
                                (int)($p->good_for_gaming ?? 0) !== 1 &&
                                (int)($p->good_for_streaming ?? 0) !== 1 &&
                                (int)($p->good_for_wfh ?? 0) !== 1
                            )
                                <span class="text-muted small">-</span>
                            @endif
                        </div>
                    </td>

                    <td>
                        <div class="flag-stack">
                            <span class="badge {{ (int)($p->is_active ?? 0) ? 'text-bg-success' : 'text-bg-secondary' }}">
                                {{ (int)($p->is_active ?? 0) ? 'Aktif' : 'Nonaktif' }}
                            </span>

                            @if((int)($p->is_featured ?? 0) === 1)
                                <span class="badge text-bg-primary">Featured</span>
                            @endif

                            @if((int)($p->is_best_seller ?? 0) === 1)
                                <span class="badge text-bg-warning">Best Seller</span>
                            @endif
                        </div>
                    </td>

                    <td class="text-end package-actions">
                        <a class="btn btn-outline-secondary btn-sm" href="{{ route('admin.packages.show', $p->id) }}">
                            <i class="bi bi-eye"></i>
                        </a>

                        <a class="btn btn-outline-primary btn-sm" href="{{ route('admin.packages.edit', $p->id) }}">
                            <i class="bi bi-pencil"></i>
                        </a>

                        <form class="d-inline" method="POST" action="{{ route('admin.packages.destroy', $p->id) }}"
                              onsubmit="return confirm('Yakin ingin menghapus paket ini?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-outline-danger btn-sm" type="submit">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7">
                        <div class="empty-state">
                            <div class="fw-semibold mb-1">Belum ada data paket</div>
                            <div class="small">Silakan tambah paket baru agar muncul di daftar ini.</div>
                        </div>
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>

@if($isPaginator)
    <div class="mt-3">
        {{ $packages->withQueryString()->links() }}
    </div>
@endif
@endsection