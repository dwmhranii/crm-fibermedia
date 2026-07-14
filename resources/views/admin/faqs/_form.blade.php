@php
    /** @var \App\Models\Faq|null $faq */
    $faq = $faq ?? null;

    $val = function(string $key, $default = '') use ($faq) {
        return old($key, $faq?->{$key} ?? $default);
    };

    $checked = function(string $key, $default = 0) use ($faq) {
        return old($key, (int)($faq?->{$key} ?? $default)) ? 'checked' : '';
    };
@endphp

<div class="row g-4">
    <div class="col-lg-8">
        <div class="p-3 border rounded-4">
            <h5 class="fw-bold mb-3">Informasi FAQ</h5>

            <div class="mb-3">
                <label class="form-label fw-semibold">Pertanyaan <span class="text-danger">*</span></label>
                <input type="text"
                       name="question"
                       class="form-control @error('question') is-invalid @enderror"
                       value="{{ $val('question') }}"
                       placeholder="Contoh: Bagaimana cara daftar layanan internet?"
                       required>
                @error('question')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-0">
                <label class="form-label fw-semibold">Jawaban <span class="text-danger">*</span></label>
                <textarea name="answer"
                          rows="8"
                          class="form-control @error('answer') is-invalid @enderror"
                          placeholder="Tulis jawaban FAQ di sini..."
                          required>{{ $val('answer') }}</textarea>
                @error('answer')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="p-3 border rounded-4 mb-3">
            <h5 class="fw-bold mb-3">Pengaturan</h5>

            <div class="mb-3">
                <label class="form-label fw-semibold">Kategori</label>
                <select name="category" class="form-select @error('category') is-invalid @enderror">
                    <option value="">-- Tanpa kategori --</option>
                    @foreach($categories as $key => $label)
                        <option value="{{ $key }}" {{ $val('category') === $key ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
                @error('category')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Urutan Tampil</label>
                <input type="number"
                       name="sort_order"
                       min="0"
                       class="form-control @error('sort_order') is-invalid @enderror"
                       value="{{ $val('sort_order', 0) }}">
                @error('sort_order')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-check form-switch mb-0">
                <input class="form-check-input"
                       type="checkbox"
                       name="is_active"
                       value="1"
                       {{ $checked('is_active', 1) }}>
                <label class="form-check-label fw-semibold">Aktif</label>
            </div>
        </div>

        <div class="p-3 border rounded-4 bg-light">
            <div class="fw-semibold mb-2">Tips</div>
            <div class="small text-muted">
                Gunakan pertanyaan yang singkat dan jelas. Jawaban sebaiknya langsung menjawab inti pertanyaan customer.
            </div>
        </div>
    </div>
</div>

<div class="d-flex gap-2 mt-4">
    <button class="btn btn-primary" type="submit">
        <i class="bi bi-save me-1"></i> Simpan
    </button>
    <a href="{{ route('admin.faqs.index') }}" class="btn btn-outline-secondary">
        Batal
    </a>
</div>