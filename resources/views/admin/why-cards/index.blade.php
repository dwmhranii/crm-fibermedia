@extends('admin.layouts.admin')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h3 class="mb-1">Why Cards</h3>
            <p class="text-muted mb-0">Kelola konten alasan memilih layanan</p>
        </div>
        <a href="{{ route('admin.why-cards.create') }}" class="btn btn-primary">
            + Tambah Why Card
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow-sm border-0 mb-3">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.why-cards.index') }}">
                <div class="row g-2">
                    <div class="col-md-10">
                        <input
                            type="text"
                            name="q"
                            class="form-control"
                            placeholder="Cari title, subtitle, description..."
                            value="{{ $q }}"
                        >
                    </div>
                    <div class="col-md-2 d-grid">
                        <button class="btn btn-outline-primary">Cari</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th width="60">#</th>
                        <th>Title</th>
                        <th>Subtitle</th>
                        <th>Description</th>
                        <th>Order</th>
                        <th>Status</th>
                        <th width="240">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($whyCards as $item)
                        <tr>
                            <td>{{ $whyCards->firstItem() + $loop->index }}</td>
                            <td class="fw-semibold">{{ $item->title }}</td>
                            <td>{{ $item->subtitle ?: '-' }}</td>
                            <td>{{ \Illuminate\Support\Str::limit($item->description, 80) }}</td>
                            <td>{{ $item->sort_order }}</td>
                            <td>
                                @if($item->is_active)
                                    <span class="badge bg-success">Aktif</span>
                                @else
                                    <span class="badge bg-secondary">Nonaktif</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex gap-2 flex-wrap">
                                    <a href="{{ route('admin.why-cards.show', $item) }}" class="btn btn-sm btn-info text-white">
                                        Detail
                                    </a>
                                    <a href="{{ route('admin.why-cards.edit', $item) }}" class="btn btn-sm btn-warning text-dark">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.why-cards.destroy', $item) }}" method="POST" onsubmit="return confirm('Yakin hapus why card ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">
                                Belum ada data Why Card.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($whyCards->hasPages())
            <div class="card-footer bg-white">
                {{ $whyCards->links() }}
            </div>
        @endif
    </div>
</div>
@endsection