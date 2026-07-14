@php
    $isEdit = isset($album);
@endphp

<div class="row g-3">
    <div class="col-lg-8">
        <div class="mb-3">
            <label class="form-label">Title *</label>
            <input type="text" name="title" class="form-control"
                   value="{{ old('title', $album->title ?? '') }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Slug (optional)</label>
            <input type="text" name="slug" class="form-control"
                   value="{{ old('slug', $album->slug ?? '') }}"
                   placeholder="kosongkan untuk auto-generate">
        </div>

        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" rows="6" class="form-control"
                      placeholder="Deskripsi album...">{{ old('description', $album->description ?? '') }}</textarea>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="mb-3">
            <label class="form-label">Cover Image</label>
            <input type="file" name="cover_image" class="form-control" accept="image/*">
            <div class="form-text">JPG/PNG/WEBP, max 4MB.</div>
        </div>

        @if($isEdit && !empty($album->cover_image))
            <div class="mb-2">
                <img src="{{ asset('storage/'.$album->cover_image) }}"
                     class="rounded w-100"
                     style="max-height:180px;object-fit:cover;">
            </div>

            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" value="1" id="remove_cover" name="remove_cover">
                <label class="form-check-label" for="remove_cover">Hapus cover</label>
            </div>
        @endif

        <div class="mb-3">
            <label class="form-label">Sort Order</label>
            <input type="number" min="0" name="sort_order" class="form-control"
                   value="{{ old('sort_order', $album->sort_order ?? 0) }}">
        </div>

        <div class="form-check">
            <input class="form-check-input" type="checkbox" value="1" id="is_active" name="is_active"
                   {{ old('is_active', $album->is_active ?? true) ? 'checked' : '' }}>
            <label class="form-check-label" for="is_active">Active</label>
        </div>
    </div>
</div>

<hr class="my-4">

<div class="d-flex gap-2">
    <button class="btn btn-primary" type="submit">
        <i class="bi bi-save me-1"></i> Simpan
    </button>
    <a href="{{ route('admin.gallery-albums.index') }}" class="btn btn-outline-secondary">
        Batal
    </a>
</div>
