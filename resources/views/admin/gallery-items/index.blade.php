@extends('admin.layouts.admin')

@section('title', 'Gallery Items')
@section('subtitle', 'Kelola item gallery')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <form class="d-flex gap-2">
        <select name="album_id" class="form-select">
            <option value="">Semua Album</option>
            @foreach($albums as $album)
                <option value="{{ $album->id }}"
                    @selected(request('album_id') == $album->id)>
                    {{ $album->title }}
                </option>
            @endforeach
        </select>

        <input type="text" name="q" class="form-control"
               placeholder="Cari judul..." value="{{ request('q') }}">

        <button class="btn btn-outline-secondary">
            <i class="bi bi-search"></i>
        </button>
    </form>

    <a href="{{ route('admin.gallery-items.create') }}"
       class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> Tambah Item
    </a>
</div>

<div class="row g-3">
@forelse($items as $item)
    <div class="col-md-3">
        <div class="card h-100">
            @if($item->type === 'image' && $item->file_path)
                <img src="{{ asset('storage/'.$item->file_path) }}"
                     class="card-img-top">
            @else
                <div class="ratio ratio-16x9 bg-dark text-white
                            d-flex align-items-center justify-content-center">
                    VIDEO
                </div>
            @endif

            <div class="card-body">
                <div class="small text-muted">
                    {{ $item->album->title }}
                </div>
                <div class="fw-bold">{{ $item->title }}</div>

                <span class="badge {{ $item->is_active ? 'bg-success' : 'bg-secondary' }}">
                    {{ $item->is_active ? 'Active' : 'Inactive' }}
                </span>
            </div>

            <div class="card-footer text-end">
                <a href="{{ route('admin.gallery-items.show', $item) }}"
                   class="btn btn-sm btn-outline-info">Show</a>
                <a href="{{ route('admin.gallery-items.edit', $item) }}"
                   class="btn btn-sm btn-outline-warning">Edit</a>
                <form method="POST"
                      action="{{ route('admin.gallery-items.destroy', $item) }}"
                      class="d-inline"
                      onsubmit="return confirm('Hapus item ini?')">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-outline-danger">Del</button>
                </form>
            </div>
        </div>
    </div>
@empty
    <div class="text-center text-muted">Belum ada item.</div>
@endforelse
</div>

<div class="mt-3">
    {{ $items->links() }}
</div>
@endsection
