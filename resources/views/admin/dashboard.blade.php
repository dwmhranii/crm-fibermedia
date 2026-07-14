@extends('admin.layouts.admin')

@section('title', 'Dashboard')
@section('subtitle', 'Ringkasan sistem & pintasan cepat')

@php
    $user = auth()->user();

    $isSuper = false;
    if ($user) {
        if (method_exists($user, 'hasRole')) {
            $isSuper = $user->hasRole('superadmin');
        } else {
            $isSuper = optional($user->role)->slug === 'superadmin';
        }
    }

    $stats = [
        [
            'label' => 'Packages',
            'value' => $packagesCount ?? 0,
            'icon'  => 'bi-box-seam',
            'hint'  => 'Paket aktif di website',
            'route' => route('admin.packages.index'),
        ],
        [
            'label' => 'Coverages',
            'value' => $coveragesCount ?? 0,
            'icon'  => 'bi-geo-alt',
            'hint'  => 'Data area coverage',
            'route' => route('admin.coverages.index'),
        ],
        [
            'label' => 'Users',
            'value' => $usersCount ?? 0,
            'icon'  => 'bi-people',
            'hint'  => 'User yang terdaftar',
            'route' => route('admin.users.index'),
            'super' => true,
        ],
        [
            'label' => 'Banners',
            'value' => $bannersCount ?? 0,
            'icon'  => 'bi-images',
            'hint'  => 'Banner homepage (superadmin)',
            'route' => route('admin.banners.index'),
            'super' => true,
        ],
    ];
@endphp

@push('styles')
<style>
    .kpi-card{
        border-radius: 18px;
        border: 1px solid #e5e7eb;
        box-shadow: 0 14px 40px rgba(15,23,42,.06);
        background: #fff;
        overflow: hidden;
        height: 100%;
    }
    .kpi-top{
        height: 6px;
        background: linear-gradient(90deg, #2563eb, #22c55e);
    }
    .kpi-icon{
        width: 44px; height: 44px;
        border-radius: 14px;
        display:flex; align-items:center; justify-content:center;
        background: rgba(37,99,235,.08);
        color: #2563eb;
        border: 1px solid rgba(37,99,235,.12);
        font-size: 1.2rem;
    }
    body.admin-body.dark .kpi-card{
        background: #0f172a;
        border-color: #1f2937;
        box-shadow: 0 18px 55px rgba(0,0,0,.35);
    }
    body.admin-body.dark .kpi-icon{
        background: rgba(255,255,255,.06);
        border-color: rgba(255,255,255,.10);
        color: #e5e7eb;
    }
    .quick-card{
        border-radius: 18px;
        border: 1px solid #e5e7eb;
        background: #fff;
        box-shadow: 0 14px 40px rgba(15,23,42,.06);
    }
    body.admin-body.dark .quick-card{
        background: #0f172a;
        border-color: #1f2937;
        box-shadow: 0 18px 55px rgba(0,0,0,.35);
    }
    .quick-link{
        display:flex;
        align-items:center;
        justify-content: space-between;
        gap: 12px;
        padding: 12px 14px;
        border-radius: 14px;
        border: 1px solid #e5e7eb;
        text-decoration: none;
        color: inherit;
        transition: transform .12s ease, box-shadow .12s ease;
        background: #fff;
    }
    .quick-link:hover{
        transform: translateY(-2px);
        box-shadow: 0 12px 28px rgba(15,23,42,.10);
    }
    body.admin-body.dark .quick-link{
        background: #0b1220;
        border-color: #1f2937;
    }
</style>
@endpush

@section('content')

<div class="row g-3">
    @foreach($stats as $s)
        @if(!($s['super'] ?? false) || $isSuper)
            <div class="col-12 col-md-6 col-xl-3">
                <a href="{{ $s['route'] }}" class="text-decoration-none">
                    <div class="kpi-card">
                        <div class="kpi-top"></div>
                        <div class="p-3">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="kpi-icon">
                                    <i class="bi {{ $s['icon'] }}"></i>
                                </div>
                                <div class="text-end">
                                    <div class="fw-bold fs-3">{{ $s['value'] }}</div>
                                    <div class="text-muted small">{{ $s['label'] }}</div>
                                </div>
                            </div>
                            <div class="text-muted small mt-2">{{ $s['hint'] }}</div>
                        </div>
                    </div>
                </a>
            </div>
        @endif
    @endforeach
</div>

<div class="row g-3 mt-1">
    <div class="col-lg-7">
        <div class="quick-card p-3 p-md-4 h-100">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <div class="fw-bold fs-5">Quick Actions</div>
                    <div class="text-muted small">Pintasan untuk kelola konten</div>
                </div>
                <span class="badge text-bg-primary">Admin</span>
            </div>

            <div class="row g-2 mt-2">
                <div class="col-md-6">
                    <a class="quick-link" href="{{ route('admin.packages.create') }}">
                        <span class="fw-semibold"><i class="bi bi-plus-circle me-2"></i>Tambah Package</span>
                        <i class="bi bi-arrow-right"></i>
                    </a>
                </div>

                <div class="col-md-6">
                    <a class="quick-link" href="{{ route('admin.coverages.create') }}">
                        <span class="fw-semibold"><i class="bi bi-plus-circle me-2"></i>Tambah Coverage</span>
                        <i class="bi bi-arrow-right"></i>
                    </a>
                </div>

                @if($isSuper)
                    <div class="col-md-6">
                        <a class="quick-link" href="{{ route('admin.banners.index') }}">
                            <span class="fw-semibold"><i class="bi bi-images me-2"></i>Kelola Banner</span>
                            <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>

                    <div class="col-md-6">
                        <a class="quick-link" href="{{ route('admin.settings.index') }}">
                            <span class="fw-semibold"><i class="bi bi-gear me-2"></i>Site Settings</span>
                            <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                @else
                    <div class="col-12">
                        <div class="alert alert-info mt-2 mb-0">
                            <i class="bi bi-info-circle me-1"></i>
                            Menu <b>Settings</b> dan beberapa konten hanya bisa diubah oleh <b>Superadmin</b>.
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-lg-5">
        <div class="quick-card p-3 p-md-4 h-100">
            <div class="fw-bold fs-5">Account</div>
            <div class="text-muted small mb-3">Info user yang sedang login</div>

            <div class="d-flex align-items-center gap-3">
                <div style="width:52px;height:52px;border-radius:18px;display:flex;align-items:center;justify-content:center;background:rgba(37,99,235,.08);border:1px solid rgba(37,99,235,.12);">
                    <i class="bi bi-person-fill fs-3"></i>
                </div>
                <div>
                    <div class="fw-bold">{{ auth()->user()->name }}</div>
                    <div class="text-muted small">{{ auth()->user()->email }}</div>
                    <div class="mt-1">
                        <span class="badge {{ $isSuper ? 'text-bg-success' : 'text-bg-secondary' }}">
                            {{ $isSuper ? 'Superadmin' : 'Admin' }}
                        </span>
                    </div>
                </div>
            </div>

            <hr>

            <a class="btn btn-outline-secondary w-100" href="{{ url('/') }}" target="_blank">
                <i class="bi bi-box-arrow-up-right me-1"></i> Buka Website Publik
            </a>
        </div>
    </div>
</div>

@endsection