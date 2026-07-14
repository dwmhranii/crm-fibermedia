@extends('admin.layouts.admin')

@section('title', 'Tambah Item')
@section('subtitle', 'Buat Item gallery baru')

@section('content')

<form method="POST"
      enctype="multipart/form-data"
      action="{{ route('admin.gallery-items.store') }}">

    @csrf

    @include('admin.gallery-items._form', [
        'albums' => $albums
    ])

    <div class="mt-3">

        <button class="btn btn-primary">
            <i class="bi bi-save me-1"></i>
            Simpan
        </button>

        <a href="{{ route('admin.gallery-items.index') }}"
           class="btn btn-secondary">
            Batal
        </a>

    </div>

</form>

@endsection