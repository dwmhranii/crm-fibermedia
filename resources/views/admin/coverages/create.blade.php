@extends('admin.layouts.admin')

@section('title', 'Tambah Coverage')
@section('subtitle', 'Buat area coverage baru')

@section('content')
<form method="POST" action="{{ route('admin.coverages.store') }}">
    @csrf
    @include('admin.coverages._form')
</form>
@endsection