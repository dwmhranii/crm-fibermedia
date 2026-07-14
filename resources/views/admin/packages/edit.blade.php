@extends('admin.layouts.admin')

@section('title', 'Edit Package')
@section('subtitle', 'Perbarui data package')

@section('content')
<div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-3">
    <div>
        <div class="fw-bold fs-5">Edit Paket</div>
        <div class="text-muted small">
            {{ $package->name ?? 'Package' }}
            @if(!empty($package->slug))
                • {{ $package->slug }}
            @endif
        </div>
    </div>

    <div class="d-flex gap-2 flex-wrap">
        <a href="{{ route('admin.packages.show', $package->id) }}" class="btn btn-outline-primary">
            <i class="bi bi-eye me-1"></i> Lihat Detail
        </a>
        <a href="{{ route('admin.packages.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
    </div>
</div>

@if (session('success'))
    <div class="alert alert-success border-0 shadow-sm rounded-4">
        {{ session('success') }}
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger border-0 shadow-sm rounded-4">
        <div class="fw-semibold mb-2">Ada data yang perlu diperbaiki:</div>
        <ul class="mb-0 ps-3">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-4">
        <form action="{{ route('admin.packages.update', $package->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            @include('admin.packages._form', ['package' => $package])

            <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                <a href="{{ route('admin.packages.show', $package->id) }}" class="btn btn-outline-secondary px-4">
                    Batal
                </a>
                <button type="submit" class="btn btn-primary px-4">
                    <i class="bi bi-save me-1"></i> Update Paket
                </button>
            </div>
        </form>
    </div>
</div>

<div class="mt-3 d-flex justify-content-end">
    <form method="POST"
          action="{{ route('admin.packages.destroy', $package->id) }}"
          onsubmit="return confirm('Yakin ingin menghapus paket ini?');">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-outline-danger px-4">
            <i class="bi bi-trash me-1"></i> Hapus Paket
        </button>
    </form>
</div>
@endsection