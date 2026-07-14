@extends('admin.layouts.admin')

@section('title', 'Add Ons')
@section('subtitle', 'Kelola data add ons untuk website')

@section('content')
<div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
    <div>
        <h4 class="fw-bold mb-1">Add Ons</h4>
        <div class="text-muted">Daftar add ons yang tampil di website.</div>
    </div>

    <a href="{{ route('admin.addons.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle me-1"></i> Tambah Add On
    </a>
</div>

<form method="GET" class="row g-2 mb-4">
    <div class="col-md-6">
        <input
            type="text"
            name="q"
            class="form-control"
            value="{{ $q }}"
            placeholder="Cari nama, slug, type, kategori..."
        >
    </div>
    <div class="col-auto">
        <button class="btn btn-outline-primary" type="submit">Cari</button>
    </div>
    <div class="col-auto">
        <a href="{{ route('admin.addons.index') }}" class="btn btn-outline-secondary">Reset</a>
    </div>
</form>

<div class="table-responsive">
    <table class="table align-middle">
        <thead>
            <tr>
                <th>#</th>
                <th>Nama</th>
                <th>Type</th>
                <th>Kategori</th>
                <th>Harga</th>
                <th>Status</th>
                <th style="width: 220px;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($addons as $addon)
                <tr>
                    <td>{{ $addons->firstItem() + $loop->index }}</td>
                    <td>
                        <div class="fw-semibold">{{ $addon->name }}</div>
                        <div class="small text-muted">{{ $addon->slug }}</div>
                    </td>
                    <td>
                        <span class="badge text-bg-light">
                            {{ $addon->type === 'business' ? 'Bisnis' : 'Home Retail' }}
                        </span>
                    </td>
                    <td>{{ $addon->category ?: '-' }}</td>
                    <td>Rp {{ number_format((float) $addon->price, 0, ',', '.') }}</td>
                    <td>
                        @if($addon->is_active)
                            <span class="badge text-bg-success">Aktif</span>
                        @else
                            <span class="badge text-bg-secondary">Nonaktif</span>
                        @endif
                    </td>
                    <td>
                        <div class="d-flex flex-wrap gap-2">
                            <a href="{{ route('admin.addons.show', $addon->id) }}" class="btn btn-sm btn-outline-info">Detail</a>
                            <a href="{{ route('admin.addons.edit', $addon->id) }}" class="btn btn-sm btn-outline-primary">Edit</a>

                            <form action="{{ route('admin.addons.destroy', $addon->id) }}" method="POST" onsubmit="return confirm('Yakin hapus add on ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center text-muted py-4">
                        Belum ada data add ons.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if(method_exists($addons, 'links'))
    <div class="mt-3">
        {{ $addons->links() }}
    </div>
@endif
@endsection