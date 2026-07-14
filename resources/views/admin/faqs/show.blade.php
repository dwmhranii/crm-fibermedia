@extends('admin.layouts.admin')

@section('title', 'Detail FAQ')
@section('subtitle', 'Lihat detail FAQ')

@section('content')
<div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
    <div>
        <div class="fw-bold fs-5">{{ $faq->question }}</div>
        <div class="text-muted small">
            {{ $faq->category && isset($categories[$faq->category]) ? $categories[$faq->category] : 'Tanpa kategori' }}
        </div>
    </div>

    <div class="d-flex gap-2">
        <a href="{{ route('admin.faqs.edit', $faq->id) }}" class="btn btn-primary btn-sm">
            <i class="bi bi-pencil me-1"></i> Edit
        </a>
        <a href="{{ route('admin.faqs.index') }}" class="btn btn-outline-secondary btn-sm">
            Kembali
        </a>
    </div>
</div>

<div class="row g-3">
    <div class="col-lg-8">
        <div class="p-3 border rounded-4 bg-white h-100">
            <div class="fw-bold mb-2">Jawaban</div>
            <div style="white-space: pre-line;">{{ $faq->answer }}</div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="p-3 border rounded-4 bg-white">
            <div class="fw-bold mb-2">Informasi</div>

            <div class="small text-muted">Kategori</div>
            <div class="mb-2">
                {{ $faq->category && isset($categories[$faq->category]) ? $categories[$faq->category] : '-' }}
            </div>

            <div class="small text-muted">Urutan</div>
            <div class="mb-2">{{ $faq->sort_order ?? 0 }}</div>

            <div class="small text-muted">Status</div>
            <div class="mb-2">
                @if($faq->is_active)
                    <span class="badge bg-success">Aktif</span>
                @else
                    <span class="badge bg-secondary">Nonaktif</span>
                @endif
            </div>

            <div class="small text-muted">Dibuat</div>
            <div class="mb-2">{{ $faq->created_at?->format('d M Y H:i') ?? '-' }}</div>

            <div class="small text-muted">Diupdate</div>
            <div class="mb-0">{{ $faq->updated_at?->format('d M Y H:i') ?? '-' }}</div>
        </div>
    </div>
</div>
@endsection