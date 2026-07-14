@php
    use Illuminate\Support\Facades\Storage;
    use Illuminate\Support\Str;

    /** @var \App\Models\Addon|null $addon */
    $addon = $addon ?? null;

    $val = function(string $key, $default = '') use ($addon) {
        return old($key, $addon?->{$key} ?? $default);
    };

    $checked = function(string $key) use ($addon) {
        return old($key, (int)($addon?->{$key} ?? 0)) ? 'checked' : '';
    };

    $thumbnailUrl = null;
    if ($addon && !empty($addon->thumbnail)) {
        if (Str::startsWith($addon->thumbnail, ['http://', 'https://'])) {
            $thumbnailUrl = $addon->thumbnail;
        } elseif (Str::startsWith($addon->thumbnail, '/storage/')) {
            $thumbnailUrl = $addon->thumbnail;
        } elseif (Str::startsWith($addon->thumbnail, 'storage/')) {
            $thumbnailUrl = asset($addon->thumbnail);
        } else {
            $thumbnailUrl = Storage::url($addon->thumbnail);
        }
    }

    $bannerUrl = null;
    if ($addon && !empty($addon->banner_image)) {
        if (Str::startsWith($addon->banner_image, ['http://', 'https://'])) {
            $bannerUrl = $addon->banner_image;
        } elseif (Str::startsWith($addon->banner_image, '/storage/')) {
            $bannerUrl = $addon->banner_image;
        } elseif (Str::startsWith($addon->banner_image, 'storage/')) {
            $bannerUrl = asset($addon->banner_image);
        } else {
            $bannerUrl = Storage::url($addon->banner_image);
        }
    }
@endphp

<div class="row g-4">
    <div class="col-lg-8">

        <div class="p-3 border rounded-4 mb-4">
            <h5 class="fw-bold mb-3">Informasi Utama Add On</h5>

            <div class="mb-3">
                <label class="form-label fw-semibold">Nama Add On</label>
                <input type="text" name="name" class="form-control" value="{{ $val('name') }}" required
                       placeholder="Contoh: Netflix, STB Android OS 14, CCTV Indoor">
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Slug</label>
                <input type="text" name="slug" class="form-control" value="{{ $val('slug') }}"
                       placeholder="Contoh: netflix">
                <div class="text-muted small mt-1">
                    Boleh dikosongkan, nanti dibuat otomatis dari nama add on.
                </div>
            </div>

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Tipe</label>
                    <select name="type" class="form-select" required>
                        <option value="">-- Pilih tipe --</option>
                        <option value="home" {{ $val('type') === 'home' ? 'selected' : '' }}>Home / Rumah</option>
                        <option value="business" {{ $val('type') === 'business' ? 'selected' : '' }}>Business / Bisnis</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Kategori</label>
                    <select name="category" class="form-select">
                        <option value="">-- Pilih kategori --</option>
                        <option value="cctv" {{ $val('category') === 'cctv' ? 'selected' : '' }}>CCTV</option>
                        <option value="network-device" {{ $val('category') === 'network-device' ? 'selected' : '' }}>Access Point AP Router</option>
                        <option value="smart-home" {{ $val('category') === 'smart-home' ? 'selected' : '' }}>Smart Home</option>
                        <option value="stb-android" {{ $val('category') === 'stb-android' ? 'selected' : '' }}>STB Android</option>
                        <option value="streaming" {{ $val('category') === 'streaming' ? 'selected' : '' }}>Streaming</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="p-3 border rounded-4 mb-4">
            <h5 class="fw-bold mb-3">Harga & Detail</h5>

            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Harga</label>
                    <input type="number" name="price" class="form-control" value="{{ $val('price') }}"
                           min="0" placeholder="Contoh: 65000" required>
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-semibold">Tipe Harga</label>
                    <select name="pricing_type" class="form-select" required>
                        <option value="">-- Pilih tipe harga --</option>
                        <option value="monthly" {{ $val('pricing_type') === 'monthly' ? 'selected' : '' }}>Bulanan</option>
                        <option value="one_time" {{ $val('pricing_type') === 'one_time' ? 'selected' : '' }}>Sekali Bayar</option>
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-semibold">Durasi (bulan)</label>
                    <input type="number" name="duration_months" class="form-control" value="{{ $val('duration_months') }}"
                           min="1" placeholder="Contoh: 1">
                    <div class="text-muted small mt-1">
                        Isi jika add on bulanan.
                    </div>
                </div>
            </div>
        </div>

        <div class="p-3 border rounded-4 mb-4">
            <h5 class="fw-bold mb-3">Deskripsi Add On</h5>

            <div class="mb-3">
                <label class="form-label fw-semibold">Cocok Untuk</label>
                <input type="text" name="best_for" class="form-control" value="{{ $val('best_for') }}"
                       placeholder="Contoh: Hiburan keluarga, keamanan rumah, perluasan WiFi">
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Perangkat Ideal</label>
                <input type="text" name="device_ideal" class="form-control" value="{{ $val('device_ideal') }}"
                       placeholder="Contoh: Smart TV / STB Android">
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Deskripsi Singkat</label>
                <textarea name="short_description" class="form-control" rows="3"
                          placeholder="Tulis ringkasan singkat add on ini...">{{ $val('short_description') }}</textarea>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Deskripsi Lengkap</label>
                <textarea name="description" class="form-control" rows="5"
                          placeholder="Tulis deskripsi lengkap add on ini...">{{ $val('description') }}</textarea>
            </div>

            <div class="mb-0">
                <label class="form-label fw-semibold">Fitur / Highlight</label>
                <textarea name="features" class="form-control" rows="5"
                          placeholder="Contoh: Streaming stabil, Akses film populer, Mudah dipasang">{{ $val('features') }}</textarea>
                <div class="text-muted small mt-1">
                    Bisa dipisahkan dengan koma atau baris baru.
                </div>
            </div>
        </div>

        <div class="p-3 border rounded-4 mb-4">
            <h5 class="fw-bold mb-3">Media & Banner</h5>

            {{-- <div class="mb-4">
                <label class="form-label fw-semibold">Thumbnail</label>
                <input type="file" name="thumbnail_file" class="form-control" accept=".jpg,.jpeg,.png,.webp,image/*">

                @if($thumbnailUrl)
                    <div class="mt-3">
                        <div class="small text-muted mb-2">Thumbnail saat ini</div>
                        <img src="{{ $thumbnailUrl }}" alt="Thumbnail" style="max-width: 240px; width: 100%; border-radius: 14px; border: 1px solid #dee2e6;">
                    </div>

                    <div class="form-check mt-2">
                        <input class="form-check-input" type="checkbox" name="remove_thumbnail" value="1" id="remove_thumbnail">
                        <label class="form-check-label" for="remove_thumbnail">
                            Hapus thumbnail lama
                        </label>
                    </div>
                @endif
            </div>  --}}

            <div class="mb-4">
                <label class="form-label fw-semibold">Banner Image</label>
                <input type="file" name="banner_file" class="form-control" accept=".jpg,.jpeg,.png,.webp,image/*">

                @if($bannerUrl)
                    <div class="mt-3">
                        <div class="small text-muted mb-2">Banner saat ini</div>
                        <div style="max-width: 100%; border-radius: 16px; overflow: hidden; border: 1px solid #dee2e6;">
                            <img src="{{ $bannerUrl }}" alt="Banner" style="width: 100%; max-height: 220px; object-fit: cover;">
                        </div>
                    </div>

                    <div class="form-check mt-2">
                        <input class="form-check-input" type="checkbox" name="remove_banner" value="1" id="remove_banner">
                        <label class="form-check-label" for="remove_banner">
                            Hapus banner lama
                        </label>
                    </div>
                @endif

                <div class="text-muted small mt-2">
                    Kosongkan jika ingin pakai warna gradient saja.
                </div>
            </div>

            {{-- <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Warna Banner Awal</label>
                    <input type="text" name="banner_color_start" class="form-control"
                           value="{{ $val('banner_color_start', '#2563eb') }}"
                           placeholder="Contoh: #2563eb">
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Warna Banner Akhir</label>
                    <input type="text" name="banner_color_end" class="form-control"
                           value="{{ $val('banner_color_end', '#22c55e') }}"
                           placeholder="Contoh: #22c55e">
                </div>
            </div>  --}}

            <div class="mb-0">
                <label class="form-label fw-semibold">WhatsApp URL</label>
                <input type="url" name="whatsapp_url" class="form-control" value="{{ $val('whatsapp_url') }}"
                       placeholder="Contoh: https://wa.me/6281234567890">
            </div>
        </div>
    </div>

    <div class="col-lg-4">

        <div class="p-3 border rounded-4 mb-4">
            <h5 class="fw-bold mb-3">Status Tampil</h5>

            <div class="mb-3">
                <label class="form-label fw-semibold">Urutan Tampil</label>
                <input type="number" name="sort_order" class="form-control" value="{{ $val('sort_order', 0) }}"
                       min="0" placeholder="Contoh: 1">
            </div>

            <div class="form-check form-switch mb-2">
                <input class="form-check-input" type="checkbox" name="is_active" value="1" {{ $checked('is_active') }}>
                <label class="form-check-label">Aktif</label>
            </div>

            <div class="form-check form-switch mb-2">
                <input class="form-check-input" type="checkbox" name="is_featured" value="1" {{ $checked('is_featured') }}>
                <label class="form-check-label">Featured / Unggulan</label>
            </div>

            <div class="form-check form-switch mb-0">
                <input class="form-check-input" type="checkbox" name="is_best_seller" value="1" {{ $checked('is_best_seller') }}>
                <label class="form-check-label">Best Seller</label>
            </div>
        </div>

        <div class="p-3 border rounded-4 mb-4">
            <h6 class="fw-bold mb-3">Preview Banner</h6>

            @php
                $previewStart = $val('banner_color_start', '#2563eb');
                $previewEnd = $val('banner_color_end', '#22c55e');
            @endphp

            <div style="border-radius:16px; overflow:hidden; border:1px solid #dee2e6;">
                <div style="height:140px; position:relative; background:linear-gradient(135deg, {{ $previewStart }}, {{ $previewEnd }});">
                    @if($bannerUrl)
                        <img src="{{ $bannerUrl }}"
                             alt="Banner preview"
                             style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;">
                    @endif
                    <div style="position:absolute;inset:0;background:linear-gradient(180deg,rgba(0,0,0,.10),rgba(0,0,0,.40));"></div>
                    <div style="position:absolute;left:12px;right:12px;bottom:12px;color:#fff;font-weight:700;font-size:.92rem;">
                        {{ $val('short_description', 'Preview banner add on akan tampil di sini.') }}
                    </div>
                </div>
            </div>
        </div>

        <div class="p-3 border rounded-4 bg-light">
            <h6 class="fw-bold mb-2">Petunjuk Singkat</h6>
            <div class="small text-muted">
                Upload <strong>Banner Image</strong> kalau ingin banner gambar. Kalau tidak upload banner, sistem akan pakai <strong>gradient warna banner</strong>.
            </div>
        </div>
    </div>
</div>