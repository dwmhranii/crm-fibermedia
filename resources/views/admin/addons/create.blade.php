@extends('admin.layouts.admin')

@section('title', 'Tambah Add On')
@section('subtitle', 'Buat add on baru untuk website')

@section('content')
<h4 class="fw-bold mb-4">Tambah Add On</h4>

<form action="{{ route('admin.addons.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @include('admin.addons._form')

    <div class="d-flex gap-2">
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('admin.addons.index') }}" class="btn btn-outline-secondary">Batal</a>
    </div>
</form>
@endsection