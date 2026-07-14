@extends('admin.layouts.admin')

@section('title', 'Detail Album')
@section('subtitle', 'Preview album & info')

@section('content')
<div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-3">
    <div>
        <h4 class="mb-1">{{ $album->title }}</h4>
        <div class="text-muted small">Slug: {{ $album->slug }} • Items: {{ $album->items_count ?? 0 }}</div>
    </div>

    <div class="d-flex gap-2">
        <a href="{{ route('admin.gallery-albums.edit', $album) }}" class="btn btn-primary btn-sm">
            <i class="bi bi-pencil me-1"></i> Edit
        </a>
        <a href="{{ route('admin.gallery-albums.index') }}" class="btn btn-outline-secondary btn-sm">
            Kembali
        </a>
    </div>
</div>

<div class="row g-3">
    <div class="col-lg-4">
        <div class="border rounded p-2">
            @if($album->cover_image)
                <img src="{{ asset('storage/'.$album->cover_image) }}" class="w-100 rounded"
                     style="max-height:220px;object-fit:cover;">
            @else
                <div class="text-center text-muted py-5">
                    <i class="bi bi-image" style="font-size:2rem;"></i>
                    <div class="mt-2">No cover</div>
                </div>
            @endif
        </div>
    </div>

    <div class="col-lg-8">
        <div class="mb-2">
            <span class="badge {{ $album->is_active ? 'text-bg-success' : 'text-bg-secondary' }}">
                {{ $album->is_active ? 'Active' : 'Off' }}
            </span>
            <span class="badge text-bg-light">Order: {{ $album->sort_order ?? 0 }}</span>
        </div>

        <div class="text-muted small mb-2">Description</div>
        <div class="border rounded p-3">
            {!! nl2br(e($album->description ?? '-')) !!}
        </div>
    </div>
</div>
@endsection
