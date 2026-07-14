@php
    /** @var \App\Models\GalleryItem|null $item */
    $isEdit = isset($item) && $item?->exists;
@endphp

<div class="row g-3">
    {{-- ALBUM --}}
    <div class="col-md-6">
        <label class="form-label">Album <span class="text-danger">*</span></label>

        <select name="album_id"
                class="form-select @error('album_id') is-invalid @enderror"
                required>

            <option value="">-- Select Album --</option>

            @foreach($albums as $album)
                <option value="{{ $album->id }}"
                    @selected(old('album_id', $item->album_id ?? null) == $album->id)>

                    {{ $album->title }}

                </option>
            @endforeach

        </select>

        @error('album_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    {{-- TYPE --}}
    <div class="col-md-6">
        <label class="form-label">Type <span class="text-danger">*</span></label>

        <select id="gi_type"
                name="type"
                class="form-select @error('type') is-invalid @enderror"
                required>

            <option value="image"
                @selected(old('type', $item->type ?? 'image') === 'image')>
                Image
            </option>

            <option value="video"
                @selected(old('type', $item->type ?? '') === 'video')>
                Video
            </option>

        </select>

        @error('type')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    {{-- TITLE --}}
    <div class="col-md-6">
        <label class="form-label">Title</label>

        <input type="text"
               name="title"
               class="form-control @error('title') is-invalid @enderror"
               value="{{ old('title', $item->title ?? '') }}"
               maxlength="255">

        @error('title')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    {{-- SORT --}}
    <div class="col-md-6">
        <label class="form-label">Sort Order</label>

        <input type="number"
               name="sort_order"
               class="form-control @error('sort_order') is-invalid @enderror"
               value="{{ old('sort_order', $item->sort_order ?? 0) }}"
               min="0">

        @error('sort_order')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    {{-- CAPTION --}}
    <div class="col-12">
        <label class="form-label">Caption</label>

        <textarea name="caption"
                  class="form-control @error('caption') is-invalid @enderror"
                  rows="3">{{ old('caption', $item->caption ?? '') }}</textarea>

        @error('caption')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    {{-- FILE --}}
    <div id="gi_file_wrap" class="col-12">

        <label class="form-label">
            File
            @if(!$isEdit || empty($item->file_path))
                <span class="text-danger">*</span>
            @endif
        </label>

        <input type="file"
               name="file"
               class="form-control @error('file') is-invalid @enderror"
               accept="image/*,video/*">

        @error('file')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror

        @if($isEdit && $item->file_path)
            <div class="form-text mt-1">
                Current file:
                <a href="{{ asset('storage/'.$item->file_path) }}" target="_blank">
                    Open
                </a>
            </div>
        @endif

    </div>

    {{-- VIDEO URL --}}
    <div id="gi_video_url_wrap" class="col-12">

        <label class="form-label">
            Video URL
            <span class="text-danger">*</span>
        </label>

        <input type="url"
               name="video_url"
               class="form-control @error('video_url') is-invalid @enderror"
               value="{{ old('video_url', $item->video_url ?? '') }}"
               placeholder="https://...">

        @error('video_url')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror

        <div class="form-text">Required if type is Video.</div>

    </div>

    {{-- THUMB --}}
    <div class="col-12">

        <label class="form-label">Thumbnail</label>

        <input type="file"
               name="thumb"
               class="form-control @error('thumb') is-invalid @enderror"
               accept="image/*">

        @error('thumb')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror

        @if($isEdit && $item->thumb_path)
            <div class="form-text mt-1">
                Current thumbnail:
                <a href="{{ asset('storage/'.$item->thumb_path) }}" target="_blank">
                    Open
                </a>
            </div>
        @endif

    </div>

    {{-- ACTIVE --}}
    <div class="col-12">

        <div class="form-check mt-2">

            <input class="form-check-input"
                   type="checkbox"
                   name="is_active"
                   id="is_active"
                   value="1"
                   @checked(old('is_active', $item->is_active ?? true))>

            <label class="form-check-label" for="is_active">
                Active
            </label>

        </div>

    </div>
</div>