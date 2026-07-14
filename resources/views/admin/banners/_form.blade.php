@php
    $isEdit = isset($banner);
@endphp

<div class="row g-3">
    <div class="col-lg-8">
        <div class="mb-3">
            <label class="form-label">Title *</label>
            <input class="form-control" name="title" value="{{ old('title', $banner->title ?? '') }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Subtitle</label>
            <input class="form-control" name="subtitle" value="{{ old('subtitle', $banner->subtitle ?? '') }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea class="form-control" rows="4" name="description">{{ old('description', $banner->description ?? '') }}</textarea>
        </div>

        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Image Desktop</label>
                <input class="form-control" type="file" name="image_desktop" accept="image/*">
                @if($isEdit && $banner->image_desktop)
                    <div class="mt-2">
                        <img src="{{ asset('storage/'.$banner->image_desktop) }}" class="img-fluid rounded">
                    </div>
                @endif
            </div>

            <div class="col-md-6">
                <label class="form-label">Image Mobile</label>
                <input class="form-control" type="file" name="image_mobile" accept="image/*">
                @if($isEdit && $banner->image_mobile)
                    <div class="mt-2">
                        <img src="{{ asset('storage/'.$banner->image_mobile) }}" class="img-fluid rounded">
                    </div>
                @endif
            </div>
        </div>

        <hr class="my-4">

        <div class="row g-3">
            <div class="col-md-4">
                <label class="form-label">CTA Text</label>
                <input class="form-control" name="cta_text" value="{{ old('cta_text', $banner->cta_text ?? '') }}">
            </div>
            <div class="col-md-8">
                <label class="form-label">CTA URL</label>
                <input class="form-control" name="cta_url" value="{{ old('cta_url', $banner->cta_url ?? '') }}" placeholder="https://... / whatsapp link">
            </div>

            <div class="col-md-4">
                <div class="form-check mt-4">
                    <input class="form-check-input" type="checkbox" name="open_in_new_tab" value="1"
                        @checked(old('open_in_new_tab', $banner->open_in_new_tab ?? false))>
                    <label class="form-check-label">Open in new tab</label>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="border rounded-3 p-3">
            <div class="mb-3">
                <label class="form-label">Position *</label>
                <input class="form-control" name="position" value="{{ old('position', $banner->position ?? 'home_hero') }}" required>
                <div class="form-text">Contoh: home_hero</div>
            </div>

            <div class="mb-3">
                <label class="form-label">Sort Order</label>
                <input class="form-control" type="number" name="sort_order"
                       value="{{ old('sort_order', $banner->sort_order ?? 0) }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Start At</label>
                <input class="form-control" type="datetime-local" name="start_at"
                       value="{{ old('start_at', isset($banner->start_at) ? $banner->start_at->format('Y-m-d\TH:i') : '') }}">
            </div>

            <div class="mb-3">
                <label class="form-label">End At</label>
                <input class="form-control" type="datetime-local" name="end_at"
                       value="{{ old('end_at', isset($banner->end_at) ? $banner->end_at->format('Y-m-d\TH:i') : '') }}">
            </div>

            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="is_active" value="1"
                       @checked(old('is_active', $banner->is_active ?? true))>
                <label class="form-check-label">Active</label>
            </div>
        </div>
    </div>
</div>
