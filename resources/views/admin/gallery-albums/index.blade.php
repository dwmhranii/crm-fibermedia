@extends('admin.layouts.admin')

@section('title', 'Gallery Albums')
@section('subtitle', 'Kelola album gallery')

@section('content')
<div class="d-flex flex-wrap gap-2 justify-content-between align-items-center mb-3">
    <div>
        <h4 class="mb-1">Gallery Albums</h4>
        <div class="text-muted small">List album untuk konten gallery.</div>
    </div>

    <div class="d-flex gap-2">
        <form method="GET" class="d-flex gap-2">
            <input type="text" name="q" value="{{ $q }}" class="form-control form-control-sm" placeholder="Cari judul / slug...">
            <button class="btn btn-outline-secondary btn-sm" type="submit">
                <i class="bi bi-search"></i>
            </button>
        </form>

        <a href="{{ route('admin.gallery-albums.create') }}" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-lg me-1"></i> Tambah Album
        </a>
    </div>
</div>

<div class="table-responsive">
    <table class="table align-middle">
        <thead>
            <tr class="text-muted small">
                <th style="width:80px;">Cover</th>
                <th>Title</th>
                <th>Slug</th>
                <th class="text-center" style="width:110px;">Active</th>
                <th class="text-center" style="width:110px;">Order</th>
                <th class="text-end" style="width:180px;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($albums as $a)
                <tr>
                    <td>
                        @if($a->cover_image)
                            <img src="{{ asset('storage/'.$a->cover_image) }}"
                                 class="rounded"
                                 style="width:64px;height:44px;object-fit:cover;">
                        @else
                            <div class="rounded bg-light border d-flex align-items-center justify-content-center"
                                 style="width:64px;height:44px;">
                                <i class="bi bi-image text-muted"></i>
                            </div>
                        @endif
                    </td>
                    <td class="fw-semibold">
                        {{ $a->title }}
                        <div class="text-muted small">#{{ $a->id }}</div>
                    </td>
                    <td class="text-muted">{{ $a->slug }}</td>
                    <td class="text-center">
                        @if($a->is_active)
                            <span class="badge text-bg-success">Active</span>
                        @else
                            <span class="badge text-bg-secondary">Off</span>
                        @endif
                    </td>
                    <td class="text-center">{{ $a->sort_order ?? 0 }}</td>
                    <td class="text-end">
                        <a href="{{ route('admin.gallery-albums.show', $a) }}" class="btn btn-outline-secondary btn-sm">
                            <i class="bi bi-eye"></i>
                        </a>
                        <a href="{{ route('admin.gallery-albums.edit', $a) }}" class="btn btn-outline-primary btn-sm">
                            <i class="bi bi-pencil"></i>
                        </a>

                        <form action="{{ route('admin.gallery-albums.destroy', $a) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('Hapus album ini?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-outline-danger btn-sm" type="submit">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-4">
                        Belum ada album.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-3">
    {{ $albums->appends(['q' => $q])->links() }}
</div>
@endsection
