@extends('admin.layouts.admin')

@section('title', 'Tambah Album')
@section('subtitle', 'Buat album gallery baru')

@section('content')
<h4 class="mb-3">Tambah Album</h4>

<form method="POST" action="{{ route('admin.gallery-albums.store') }}" enctype="multipart/form-data">
    @csrf
    @include('admin.gallery-albums._form')
</form>
@endsection
