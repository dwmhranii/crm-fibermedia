@extends('admin.layouts.admin')

@section('title', 'Banners')
@section('subtitle', 'Kelola banner slider & promo')

@section('content')
<div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
    <form class="d-flex gap-2" method="GET">
        <input class="form-control" name="q" value="{{ $q }}" placeholder="Cari title / position...">
        <button class="btn btn-outline-secondary" type="submit">
            <i class="bi bi-search"></i>
        </button>
    </form>

    <a href="{{ route('admin.banners.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i> Tambah Banner
    </a>
</div>

<div class="table-responsive">
    <table class="table align-middle">
        <thead>
        <tr>
            <th>Banner</th>
            <th>Position</th>
            <th>Schedule</th>
            <th>Status</th>
            <th class="text-end" style="width: 170px;">Aksi</th>
        </tr>
        </thead>
        <tbody>
        @forelse($banners as $b)
            <tr>
                <td>
                    <div class="d-flex align-items-center gap-3">
                        <div style="width:72px">
                            @if($b->image_desktop)
                                <img src="{{ asset('storage/'.$b->image_desktop) }}" class="img-fluid rounded" alt="">
                            @else
                                <div class="text-muted small">No image</div>
                            @endif
                        </div>
                        <div>
                            <div class="fw-bold">{{ $b->title }}</div>
                            <div class="text-muted small">
                                Sort: {{ $b->sort_order ?? 0 }}
                                @if($b->cta_text) • CTA: {{ $b->cta_text }} @endif
                            </div>
                        </div>
                    </div>
                </td>
                <td>
                    <span class="badge text-bg-light">{{ $b->position }}</span>
                </td>
                <td class="small text-muted">
                    <div>Start: {{ $b->start_at?->format('Y-m-d H:i') ?? '-' }}</div>
                    <div>End: {{ $b->end_at?->format('Y-m-d H:i') ?? '-' }}</div>
                </td>
                <td>
                    @if($b->is_active)
                        <span class="badge text-bg-success">Active</span>
                    @else
                        <span class="badge text-bg-secondary">Inactive</span>
                    @endif
                </td>
                <td class="text-end">
                    <a href="{{ route('admin.banners.show', $b) }}" class="btn btn-sm btn-outline-secondary">View</a>
                    <a href="{{ route('admin.banners.edit', $b) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                    <form action="{{ route('admin.banners.destroy', $b) }}" method="POST" class="d-inline"
                          onsubmit="return confirm('Hapus banner ini?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger" type="submit">Hapus</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="5" class="text-center text-muted py-4">Belum ada banner.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>

<div class="mt-3">
    {{ $banners->appends(['q'=>$q])->links() }}
</div>
@endsection
