@extends('admin.layouts.admin')

@section('title', 'Edit User')
@section('subtitle', 'Update data akun user')

@section('content')
<div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
    <div>
        <div class="fw-bold fs-4">Edit User</div>
        <div class="text-muted small">Perbarui data user</div>
    </div>

    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i> Kembali
    </a>
</div>

<form action="{{ route('admin.users.update', $user) }}" method="POST">
    @csrf
    @method('PUT')
    @include('admin.users._form', ['user' => $user])
    <hr class="my-4">
    <button type="submit" class="btn btn-primary">
        <i class="bi bi-save me-1"></i> Update User
    </button>
</form>
@endsection