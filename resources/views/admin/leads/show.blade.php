@extends('admin.layouts.admin')

@section('title', 'Detail Lead')
@section('subtitle', 'Preview lead & informasi')

@section('content')
<div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-3">
    <div>
        <h4 class="mb-1">{{ $lead->name }}</h4>
        <div class="text-muted small">
            #{{ $lead->id }} •
            Status: <span class="fw-semibold">{{ \App\Models\Lead::statusOptions()[$lead->status] ?? $lead->status }}</span>
            • Created: {{ optional($lead->created_at)->format('d M Y H:i') }}
        </div>
    </div>

    <div class="d-flex gap-2">
        @if(!$lead->trashed())
            <a href="{{ route('admin.leads.edit', $lead) }}" class="btn btn-primary btn-sm">
                <i class="bi bi-pencil me-1"></i> Edit
            </a>
        @endif
        <a href="{{ route('admin.leads.index') }}" class="btn btn-outline-secondary btn-sm">
            Kembali
        </a>
    </div>
</div>

<div class="row g-3">
    <div class="col-lg-6">
        <div class="border rounded p-3">
            <div class="text-muted small mb-2">Kontak</div>
            <div><i class="bi bi-telephone me-1"></i>{{ $lead->phone }}</div>
            <div><i class="bi bi-envelope me-1"></i>{{ $lead->email ?? '-' }}</div>
            <div class="mt-2 text-muted small">Address</div>
            <div>{{ $lead->address ?? '-' }}</div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="border rounded p-3">
            <div class="text-muted small mb-2">Detail</div>
            <div>Coverage: <span class="fw-semibold">{{ $lead->coverage?->name ?? '-' }}</span></div>
            <div>Package: <span class="fw-semibold">{{ $lead->package?->name ?? '-' }}</span></div>
            <div>Source: <span class="fw-semibold">{{ $lead->source ?? '-' }}</span></div>

            <div class="mt-3 text-muted small">Handled</div>
            @if($lead->handled_at)
                <div>{{ $lead->handled_at->format('d M Y H:i') }}</div>
                <div class="text-muted small">by {{ $lead->handler?->name ?? 'User #'.$lead->handled_by }}</div>
            @else
                <div>-</div>
            @endif
        </div>
    </div>

    <div class="col-12">
        <div class="border rounded p-3">
            <div class="text-muted small mb-2">Message</div>
            <div>
                {!! nl2br(e($lead->message ?? '-')) !!}
            </div>
        </div>
    </div>
</div>
@endsection
