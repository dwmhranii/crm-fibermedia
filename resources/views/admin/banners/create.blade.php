@extends('admin.layouts.admin')

@section('title', 'Tambah Banner')
@section('subtitle', 'Buat banner baru')

@section('content')
<form method="POST" action="{{ route('admin.banners.store') }}" enctype="multipart/form-data">
    @csrf

    @include('admin.banners._form')

    <div class="mt-4 d-flex gap-2">
        <a href="{{ route('admin.banners.index') }}" class="btn btn-outline-secondary">Batal</a>
        <button class="btn btn-primary" type="submit">
            <i class="bi bi-save me-1"></i> Simpan
        </button>
    </div>
</form>
@endsection
