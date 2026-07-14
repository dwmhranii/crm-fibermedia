@extends('admin.layouts.admin')

@section('title', 'Edit Coverage')
@section('subtitle', 'Perbarui area coverage')

@section('content')
<form method="POST" action="{{ route('admin.coverages.update', $coverage->id) }}">
    @csrf   
    @method('PUT')

    @include('admin.coverages._form', ['coverage' => $coverage])
</form>
@endsection