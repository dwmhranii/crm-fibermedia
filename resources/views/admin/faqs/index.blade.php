@extends('admin.layouts.admin')

@section('title', 'FAQs')
@section('subtitle', 'Kelola pertanyaan yang sering ditanyakan')

@php
    use Illuminate\Support\Str;
@endphp

@section('content')
<div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
    <form method="GET" class="row g-2 align-items-end">
        <div class="col-auto">
            <label class="form-label small text-muted">Cari</label>
            <input type="text"
                   name="q"
                   value="{{ $q }}"
                   class="form-control"
                   placeholder="Cari pertanyaan / jawaban...">
        </div>

        <div class="col-auto">
            <label class="form-label small text-muted">Kategori</label>
            <select name="category" class="form-select">
                <option value="">Semua kategori</option>
                @foreach($categories as $key => $label)
                    <option value="{{ $key }}" {{ $category === $key ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-auto">
            <button class="btn btn-outline-secondary">Cari</button>
        </div>

        <div class="col-auto">
            <a href="{{ route('admin.faqs.index') }}" class="btn btn-outline-secondary">
                Reset
            </a>
        </div>
    </form>

    <a href="{{ route('admin.faqs.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i> Tambah FAQ
    </a>
</div>

<div class="table-responsive">
    <table class="table table-hover align-middle">
        <thead>
        <tr>
            <th>Pertanyaan</th>
            <th>Kategori</th>
            <th>Urutan</th>
            <th>Status</th>
            <th width="180">Aksi</th>
        </tr>
        </thead>
        <tbody>
        @forelse($faqs as $faq)
            <tr>
                <td>
                    <div class="fw-semibold">{{ $faq->question }}</div>
                    <div class="text-muted small">
                        {{ Str::limit(strip_tags($faq->answer), 90) }}
                    </div>
                </td>

                <td>
                    @if($faq->category && isset($categories[$faq->category]))
                        <span class="badge text-bg-light border">{{ $categories[$faq->category] }}</span>
                    @else
                        <span class="text-muted small">-</span>
                    @endif
                </td>

                <td>{{ $faq->sort_order ?? 0 }}</td>

                <td>
                    @if($faq->is_active)
                        <span class="badge bg-success">Aktif</span>
                    @else
                        <span class="badge bg-secondary">Nonaktif</span>
                    @endif
                </td>

                <td>
                    <a href="{{ route('admin.faqs.show', $faq->id) }}"
                       class="btn btn-sm btn-outline-secondary">
                        Lihat
                    </a>

                    <a href="{{ route('admin.faqs.edit', $faq->id) }}"
                       class="btn btn-sm btn-outline-primary">
                        Edit
                    </a>

                    <form action="{{ route('admin.faqs.destroy', $faq->id) }}"
                          method="POST"
                          class="d-inline"
                          onsubmit="return confirm('Hapus FAQ ini?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger">
                            Hapus
                        </button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="text-center text-muted py-4">
                    Belum ada FAQ.
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>
</div>

<div class="mt-3">
    {{ $faqs->appends(['q' => $q, 'category' => $category])->links() }}
</div>
@endsection