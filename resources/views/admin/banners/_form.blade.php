@php
    $isEdit = isset($banner);
@endphp

{{-- ALERT PEMBERITAHUAN SITE SETTING --}}
<div class="alert alert-info border-0 shadow-sm rounded-3 d-flex align-items-center justify-content-between flex-wrap gap-2 mb-4 p-3">
    <div class="d-flex align-items-center gap-3">
        <div class="bg-primary text-white rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 38px; height: 38px;">
            <i class="bi bi-info-circle fs-5"></i>
        </div>
        <div>
            <div class="fw-bold">Pengaturan Teks Header Website</div>
            <div class="small text-muted">
                Judul utama, tagline/badge, deskripsi, dan tombol CTA pada header beranda kini diatur secara terpusat di menu <strong>Site Setting</strong>. Form di bawah ini khusus untuk mengunggah <strong>gambar latar belakang (Background Slider)</strong>.
            </div>
        </div>
    </div>
    <a href="{{ route('admin.settings.index') }}" class="btn btn-sm btn-outline-primary fw-semibold text-nowrap">
        <i class="bi bi-gear-fill me-1"></i> Buka Site Setting
    </a>
</div>

<div class="row g-3">
    <div class="col-lg-8">
        {{-- CARD UTAMA: UPLOAD GAMBAR BACKGROUND --}}
        <div class="card border-0 shadow-sm rounded-3 mb-3">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-bold text-primary">
                    <i class="bi bi-image me-2"></i> Upload Gambar Banner (Hero Background)
                </h6>
                <small class="text-muted">Gambar yang akan tampil sebagai background penuh layar pada slider header.</small>
            </div>
            <div class="card-body">
                <div class="mb-4">
                    <label class="form-label fw-semibold">Nama / Label Banner <span class="text-danger">*</span></label>
                    <input class="form-control" name="title"
                           value="{{ old('title', $banner->title ?? '') }}"
                           placeholder="Contoh: Banner Fiber Optik Utama / Slide Promo" required>
                    <div class="form-text">Nama atau catatan internal banner ini (untuk identifikasi di daftar admin).</div>
                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Gambar Desktop <span class="text-danger">*</span></label>
                        <input class="form-control" type="file" name="image_desktop" accept="image/*" {{ $isEdit ? '' : 'required' }}>
                        <div class="form-text">Rekomendasi min. 1920x800px (JPG / PNG / WEBP).</div>
                        @if($isEdit && $banner->image_desktop)
                            <div class="mt-2 position-relative rounded overflow-hidden border" style="max-height: 160px;">
                                <img src="{{ asset('storage/'.$banner->image_desktop) }}" class="w-100 object-fit-cover" style="max-height: 160px;" alt="Preview Desktop">
                            </div>
                        @endif
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Gambar Mobile (Opsional)</label>
                        <input class="form-control" type="file" name="image_mobile" accept="image/*">
                        <div class="form-text">Ukuran proporsional smartphone (opsional).</div>
                        @if($isEdit && $banner->image_mobile)
                            <div class="mt-2 position-relative rounded overflow-hidden border" style="max-height: 160px;">
                                <img src="{{ asset('storage/'.$banner->image_mobile) }}" class="w-100 object-fit-cover" style="max-height: 160px;" alt="Preview Mobile">
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- COLLAPSIBLE / OPSIONAL: KONTEN KETERANGAN TAMBAHAN JIKA DIPERLUKAN --}}
        <div class="accordion mb-3" id="bannerAdvancedSettings">
            <div class="accordion-item border-0 shadow-sm rounded-3 overflow-hidden">
                <h2 class="accordion-header" id="headingAdv">
                    <button class="accordion-button collapsed bg-white fw-semibold py-3" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAdv" aria-expanded="false" aria-controls="collapseAdv">
                        <i class="bi bi-sliders2 me-2 text-secondary"></i> Catatan & Keterangan Tambahan (Opsional)
                    </button>
                </h2>
                <div id="collapseAdv" class="accordion-collapse collapse" aria-labelledby="headingAdv" data-bs-parent="#bannerAdvancedSettings">
                    <div class="accordion-body bg-light">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Tagline / Subtitle</label>
                            <input class="form-control" name="subtitle"
                                   value="{{ old('subtitle', $banner->subtitle ?? '') }}"
                                   placeholder="Opsional">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Deskripsi Tambahan</label>
                            <textarea class="form-control" rows="2" name="description"
                                      placeholder="Opsional">{{ old('description', $banner->description ?? '') }}</textarea>
                        </div>

                        <div class="row g-2">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Teks Tombol Khusus</label>
                                <input class="form-control" name="cta_text"
                                       value="{{ old('cta_text', $banner->cta_text ?? '') }}"
                                       placeholder="Kosongkan jika memakai Site Setting">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Link Tombol Khusus</label>
                                <input class="form-control" name="cta_url"
                                       value="{{ old('cta_url', $banner->cta_url ?? '') }}"
                                       placeholder="Kosongkan jika memakai Site Setting">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- SIDEBAR PENGATURAN STATUS & POSISI --}}
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm rounded-3 sticky-top" style="top: 85px;">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-bold">
                    <i class="bi bi-sliders me-2 text-primary"></i> Pengaturan Tayang
                </h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label fw-semibold">Posisi Banner <span class="text-danger">*</span></label>
                    <select class="form-select" name="position" required>
                        <option value="home_hero" @selected(old('position', $banner->position ?? 'home_hero') === 'home_hero')>
                            Header Beranda (Hero Slider Utama)
                        </option>
                        <option value="home_mid" @selected(old('position', $banner->position ?? '') === 'home_mid')>
                            Banner Tengah (Mid Banner)
                        </option>
                        <option value="home_bottom" @selected(old('position', $banner->position ?? '') === 'home_bottom')>
                            Banner Bawah (Bottom Banner)
                        </option>
                    </select>
                    <div class="form-text">Pilih <strong>Header Beranda</strong> untuk dijadikan background slider atas.</div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Urutan Slide (Sort Order)</label>
                    <input class="form-control" type="number" name="sort_order" min="0"
                           value="{{ old('sort_order', $banner->sort_order ?? 0) }}">
                    <div class="form-text">Angka lebih kecil tampil lebih dulu (0, 1, 2...).</div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Jadwal Mulai Tayang</label>
                    <input class="form-control" type="datetime-local" name="start_at"
                           value="{{ old('start_at', isset($banner->start_at) ? $banner->start_at->format('Y-m-d\TH:i') : '') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Jadwal Selesai Tayang</label>
                    <input class="form-control" type="datetime-local" name="end_at"
                           value="{{ old('end_at', isset($banner->end_at) ? $banner->end_at->format('Y-m-d\TH:i') : '') }}">
                </div>

                <hr>

                <div class="form-check form-switch fs-5">
                    <input class="form-check-input" type="checkbox" name="is_active" value="1" id="isActiveSwitch"
                           @checked(old('is_active', $banner->is_active ?? true))>
                    <label class="form-check-label fs-6 fw-bold ms-1" for="isActiveSwitch">Aktifkan Banner</label>
                </div>
                <small class="text-muted d-block mt-1">Nonaktifkan jika tidak ingin ditampilkan di website.</small>
            </div>
        </div>
    </div>
</div>
