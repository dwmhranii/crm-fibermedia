@extends('admin.layouts.admin')

@section('title', 'Detail Banner')
@section('subtitle', 'Preview banner')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <div class="fw-bold fs-5">{{ $banner->title }}</div>
        <div class="text-muted small">Position: {{ $banner->position }} • Sort: {{ $banner->sort_order }}</div>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.banners.edit', $banner) }}" class="btn btn-outline-primary btn-sm">Edit</a>
        <a href="{{ route('admin.banners.index') }}" class="btn btn-outline-secondary btn-sm">Back</a>
    </div>
</div>

<div class="row g-3">
    <div class="col-md-6">
        <div class="fw-bold mb-2">Desktop Image</div>
        @if($banner->image_desktop)
            <img class="img-fluid rounded" src="{{ asset('storage/'.$banner->image_desktop) }}">
        @else
            <div class="text-muted">No image</div>
        @endif
    </div>

    <div class="col-md-6">
        <div class="fw-bold mb-2">Mobile Image</div>
        @if($banner->image_mobile)
            <img class="img-fluid rounded" src="{{ asset('storage/'.$banner->image_mobile) }}">
        @else
            <div class="text-muted">No image</div>
        @endif
    </div>
</div>

<hr class="my-4">

<div class="row g-3">
    <div class="col-md-6">
        <div class="fw-bold">Subtitle</div>
        <div class="text-muted">{{ $banner->subtitle ?: '-' }}</div>
    </div>
    <div class="col-md-6">
        <div class="fw-bold">Status</div>
        @if($banner->is_active)
            <span class="badge text-bg-success">Active</span>
        @else
            <span class="badge text-bg-secondary">Inactive</span>
        @endif
    </div>

    <div class="col-12">
        <div class="fw-bold">Description</div>
        <div class="text-muted">{!! nl2br(e($banner->description ?: '-')) !!}</div>
    </div>

    <div class="col-md-6">
        <div class="fw-bold">CTA</div>
        <div class="text-muted">
            {{ $banner->cta_text ?: '-' }}
            @if($banner->cta_url)
                • <a href="{{ $banner->cta_url }}" target="_blank">Open</a>
            @endif
        </div>
    </div>

    <div class="col-md-6">
        <div class="fw-bold">Schedule</div>
        <div class="text-muted small">
            Start: {{ $banner->start_at?->format('Y-m-d H:i') ?? '-' }}<br>
            End: {{ $banner->end_at?->format('Y-m-d H:i') ?? '-' }}
        </div>
    </div>
</div>
@endsection
