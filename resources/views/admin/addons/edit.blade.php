@extends('admin.layouts.admin')

@section('title', 'Edit Add On')
@section('subtitle', 'Perbarui data add on')

@section('content')
<h4 class="fw-bold mb-4">Edit Add On</h4>

<form action="{{ route('admin.addons.update', $addon->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    @include('admin.addons._form')

    <div class="d-flex gap-2">
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('admin.addons.index') }}" class="btn btn-outline-secondary">Batal</a>
    </div>
</form>
@endsection