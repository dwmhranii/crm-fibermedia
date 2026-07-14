@extends('admin.layouts.admin')

@section('title', 'Tambah Package')
@section('subtitle', 'Buat data package baru')

@section('content')
<div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-3">
    <div>
        <div class="fw-bold fs-5">Tambah Paket</div>
        <div class="text-muted small">
            Isi data paket dengan lengkap agar mudah dipahami admin dan customer.
        </div>
    </div>

    <a href="{{ route('admin.packages.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i> Kembali
    </a>
</div>

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
        <form action="{{ route('admin.packages.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            @include('admin.packages._form')

            <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                <a href="{{ route('admin.packages.index') }}" class="btn btn-outline-secondary px-4">
                    Batal
                </a>
                <button type="submit" class="btn btn-primary px-4">
                    <i class="bi bi-save me-1"></i> Simpan Paket
                </button>
            </div>
        </form>
    </div>
</div>
@endsection