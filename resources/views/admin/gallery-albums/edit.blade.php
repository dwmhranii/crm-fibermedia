@extends('admin.layouts.admin')

@section('title', 'Edit Album')
@section('subtitle', 'Update album')

@section('content')
<h4 class="mb-3">Edit Album</h4>

<form method="POST" action="{{ route('admin.gallery-albums.update', $album) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    @include('admin.gallery-albums._form', ['album' => $album])
</form>
@endsection
