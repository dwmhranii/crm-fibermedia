@extends('admin.layouts.admin')

@section('title', 'Detail Page')

@section('content')
<h4 class="mb-3">{{ $page->title }}</h4>

<div class="mb-2">
    <span class="badge bg-secondary">{{ $page->slug }}</span>
    @if($page->is_active)
        <span class="badge bg-success">Aktif</span>
    @else
        <span class="badge bg-warning text-dark">Draft</span>
    @endif
</div>

<hr>

<div class="prose">
    {!! nl2br(e($page->content)) !!}
</div>

<div class="mt-4">
    <a href="{{ route('admin.pages.index') }}" class="btn btn-secondary">
        Kembali
    </a>
</div>
@endsection
