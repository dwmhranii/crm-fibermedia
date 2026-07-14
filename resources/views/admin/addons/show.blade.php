@extends('admin.layouts.admin')

@section('title', 'Detail Add On')
@section('subtitle', 'Lihat detail add on')

@section('content')
<div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
    <div>
        <h4 class="fw-bold mb-1">{{ $addon->name }}</h4>
        <div class="text-muted">{{ $addon->slug }}</div>
    </div>

    <div class="d-flex gap-2">
        <a href="{{ route('admin.addons.edit', $addon->id) }}" class="btn btn-primary">Edit</a>
        <a href="{{ route('admin.addons.index') }}" class="btn btn-outline-secondary">Kembali</a>
    </div>
</div>

<div class="row g-4">
    <div class="col-md-6">
        <div class="p-3 border rounded-4 h-100">
            <h5 class="fw-bold mb-3">Informasi Utama</h5>
            <div class="mb-2"><strong>Type:</strong> {{ $addon->type }}</div>
            <div class="mb-2"><strong>Kategori:</strong> {{ $addon->category }}</div>
            <div class="mb-2"><strong>Harga:</strong> Rp {{ number_format((float) $addon->price, 0, ',', '.') }}</div>
            <div class="mb-2"><strong>Tipe Harga:</strong> {{ $addon->pricing_type }}</div>
            <div class="mb-0"><strong>Durasi:</strong> {{ $addon->duration_months ?: '-' }}</div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="p-3 border rounded-4 h-100">
            <h5 class="fw-bold mb-3">Deskripsi</h5>
            <div class="mb-2"><strong>Short Description:</strong><br>{{ $addon->short_description ?: '-' }}</div>
            <div class="mb-2"><strong>Best For:</strong> {{ $addon->best_for ?: '-' }}</div>
            <div class="mb-0"><strong>Device Ideal:</strong> {{ $addon->device_ideal ?: '-' }}</div>
        </div>
    </div>
</div>
@endsection