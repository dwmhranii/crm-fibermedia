@extends('admin.layouts.admin')

@section('title', 'Edit Page')

@section('content')
<h4 class="mb-3">Edit Page</h4>

<form method="POST" action="{{ route('admin.pages.update', $page) }}">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label class="form-label">Judul</label>
        <input type="text"
               name="title"
               class="form-control"
               value="{{ old('title', $page->title) }}"
               required>
    </div>

    <div class="mb-3">
        <label class="form-label">Slug</label>
        <input type="text"
               name="slug"
               class="form-control"
               value="{{ old('slug', $page->slug) }}"
               required>
    </div>

    <div class="mb-3">
        <label class="form-label">Konten</label>
        <textarea name="content"
                  rows="10"
                  class="form-control">{{ old('content', $page->content) }}</textarea>
    </div>

    <div class="form-check mb-3">
        <input class="form-check-input"
               type="checkbox"
               name="is_active"
               value="1"
               {{ $page->is_active ? 'checked' : '' }}>
        <label class="form-check-label">
            Aktifkan Page
        </label>
    </div>

    <div class="d-flex gap-2">
        <button class="btn btn-primary">
            <i class="bi bi-save"></i> Update
        </button>
        <a href="{{ route('admin.pages.index') }}" class="btn btn-secondary">
            Kembali
        </a>
    </div>
</form>
@endsection
