@extends('admin.layouts.admin')

@section('title', 'Tambah FAQ')
@section('subtitle', 'Buat FAQ baru')

@section('content')
@if ($errors->any())
    <div class="alert alert-danger border-0 shadow-sm rounded-4">
        <div class="fw-semibold mb-2">Ada data yang perlu diperbaiki:</div>
        <ul class="mb-0 ps-3">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('admin.faqs.store') }}">
    @csrf
    @include('admin.faqs._form')
</form>
@endsection