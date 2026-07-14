@extends('admin.layouts.admin')

@section('title', 'Edit Banner')
@section('subtitle', 'Update banner')

@section('content')
<form method="POST" action="{{ route('admin.banners.update', $banner) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    @include('admin.banners._form', ['banner' => $banner])

    <div class="mt-4 d-flex gap-2">
        <a href="{{ route('admin.banners.index') }}" class="btn btn-outline-secondary">Batal</a>
        <button class="btn btn-primary" type="submit">
            <i class="bi bi-save me-1"></i> Update
        </button>
    </div>
</form>
@endsection
