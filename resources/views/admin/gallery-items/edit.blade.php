@extends('admin.layouts.admin')

@section('title', 'Edit Item')
@section('subtitle', 'Edit data gallery item')

@section('content')

<form method="POST"
      enctype="multipart/form-data"
      action="{{ route('admin.gallery-items.update', $item) }}">

    @csrf
    @method('PUT')

    @include('admin.gallery-items._form', [
        'item' => $item,
        'albums' => $albums
    ])

    <div class="mt-3">

        <button class="btn btn-primary">
            <i class="bi bi-save me-1"></i>
            Update
        </button>

        <a href="{{ route('admin.gallery-items.index') }}"
           class="btn btn-secondary">
            Batal
        </a>

    </div>

</form>

@endsection