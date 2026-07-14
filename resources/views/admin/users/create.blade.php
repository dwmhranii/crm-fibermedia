@extends('admin.layouts.admin')

@section('title', 'Tambah User')
@section('subtitle', 'Buat akun admin atau superadmin baru')

@section('content')
<div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
    <div>
        <div class="fw-bold fs-4">Tambah User</div>
        <div class="text-muted small">Isi data akun baru</div>
    </div>

    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i> Kembali
    </a>
</div>

<form action="{{ route('admin.users.store') }}" method="POST">
    @csrf
    @include('admin.users._form')
    <hr class="my-4">
    <button type="submit" class="btn btn-primary">
        <i class="bi bi-save me-1"></i> Simpan User
    </button>
</form>
@endsection