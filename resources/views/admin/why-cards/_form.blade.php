<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label">Title <span class="text-danger">*</span></label>
        <input
            type="text"
            name="title"
            class="form-control @error('title') is-invalid @enderror"
            value="{{ old('title', $whyCard->title ?? '') }}"
            maxlength="150"
            required
        >
        @error('title')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label class="form-label">Subtitle</label>
        <input
            type="text"
            name="subtitle"
            class="form-control @error('subtitle') is-invalid @enderror"
            value="{{ old('subtitle', $whyCard->subtitle ?? '') }}"
            maxlength="200"
        >
        @error('subtitle')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-3">
        <label class="form-label">Sort Order <span class="text-danger">*</span></label>
        <input
            type="number"
            name="sort_order"
            class="form-control @error('sort_order') is-invalid @enderror"
            value="{{ old('sort_order', $whyCard->sort_order ?? 0) }}"
            min="0"
            required
        >
        @error('sort_order')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-3 d-flex align-items-end">
        <div class="form-check form-switch">
            <input
                class="form-check-input"
                type="checkbox"
                role="switch"
                id="is_active"
                name="is_active"
                value="1"
                {{ old('is_active', $whyCard->is_active ?? true) ? 'checked' : '' }}
            >
            <label class="form-check-label" for="is_active">Aktif</label>
        </div>
    </div>

    <div class="col-12">
        <label class="form-label">Description <span class="text-danger">*</span></label>
        <textarea
            name="description"
            rows="5"
            class="form-control @error('description') is-invalid @enderror"
            required
        >{{ old('description', $whyCard->description ?? '') }}</textarea>
        @error('description')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>