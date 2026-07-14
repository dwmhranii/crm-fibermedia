@extends('admin.layouts.admin')

@section('title', 'Tambah Page')

@section('content')
<h4 class="mb-3">Tambah Page</h4>

<form method="POST" action="{{ route('admin.pages.store') }}">
    @csrf

    <div class="mb-3">
        <label class="form-label">Judul</label>
        <input type="text"
               name="title"
               class="form-control"
               value="{{ old('title') }}"
               required>
    </div>

    <div class="mb-3">
        <label class="form-label">Slug</label>
        <input type="text"
               name="slug"
               class="form-control"
               value="{{ old('slug') }}"
               placeholder="contoh: tentang-kami"
               required>
    </div>

    <div class="mb-3">
        <label class="form-label">Konten</label>
        <textarea name="content"
                  rows="10"
                  class="form-control">{{ old('content') }}</textarea>
    </div>

    <div class="form-check mb-3">
        <input class="form-check-input"
               type="checkbox"
               name="is_active"
               value="1"
               checked>
        <label class="form-check-label">
            Aktifkan Page
        </label>
    </div>

    <div class="d-flex gap-2">
        <button class="btn btn-primary">
            <i class="bi bi-save"></i> Simpan
        </button>
        <a href="{{ route('admin.pages.index') }}" class="btn btn-secondary">
            Kembali
        </a>
    </div>
</form>
@endsection
