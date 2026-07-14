@extends('admin.layouts.admin')

@section('title', 'Edit FAQ')
@section('subtitle', 'Perbarui data FAQ')

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

<form method="POST" action="{{ route('admin.faqs.update', $faq->id) }}">
    @csrf
    @method('PUT')

    @include('admin.faqs._form', ['faq' => $faq])
</form>
@endsection