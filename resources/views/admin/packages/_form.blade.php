@php
    use Illuminate\Support\Facades\Storage;
    use Illuminate\Support\Str;

    /** @var \App\Models\Package|null $package */
    $package = $package ?? null;

    $val = function(string $key, $default = '') use ($package) {
        return old($key, $package?->{$key} ?? $default);
    };

    $checked = function(string $key) use ($package) {
        return old($key, (int)($package?->{$key} ?? 0)) ? 'checked' : '';
    };

    $thumbnailUrl = null;
    if ($package && !empty($package->thumbnail)) {
        if (Str::startsWith($package->thumbnail, ['http://', 'https://'])) {
            $thumbnailUrl = $package->thumbnail;
        } elseif (Str::startsWith($package->thumbnail, '/storage/')) {
            $thumbnailUrl = $package->thumbnail;
        } elseif (Str::startsWith($package->thumbnail, 'storage/')) {
            $thumbnailUrl = asset($package->thumbnail);
        } else {
            $thumbnailUrl = Storage::url($package->thumbnail);
        }
    }

    $bannerUrl = null;
    if ($package && !empty($package->banner_image)) {
        if (Str::startsWith($package->banner_image, ['http://', 'https://'])) {
            $bannerUrl = $package->banner_image;
        } elseif (Str::startsWith($package->banner_image, '/storage/')) {
            $bannerUrl = $package->banner_image;
        } elseif (Str::startsWith($package->banner_image, 'storage/')) {
            $bannerUrl = asset($package->banner_image);
        } else {
            $bannerUrl = Storage::url($package->banner_image);
        }
    }
@endphp

<div class="row g-4">
    <div class="col-lg-8">

        <div class="p-3 border rounded-4 mb-4">
            <h5 class="fw-bold mb-3">Informasi Utama Paket</h5>

            <div class="mb-3">
                <label class="form-label fw-semibold">Nama Paket</label>
                <input type="text" name="name" class="form-control" value="{{ $val('name') }}" required
                       placeholder="Contoh: Fiber Home 50 Mbps">
            </div>

            {{-- <div class="mb-3">
                <label class="form-label fw-semibold">Slug</label>
                <input type="text" name="slug" class="form-control" value="{{ $val('slug') }}"
                       placeholder="Contoh: fiber-home-50-mbps">
                <div class="text-muted small mt-1">
                    Boleh dikosongkan, nanti dibuat otomatis dari nama paket.
                </div>
            </div>  --}}

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Tipe Paket</label>
                    <select name="type" class="form-select" required>
                        <option value="">-- Pilih tipe paket --</option>
                        <option value="home" {{ $val('type') === 'home' ? 'selected' : '' }}>Home / Rumah</option>
                        <option value="business" {{ $val('type') === 'business' ? 'selected' : '' }}>Business / Bisnis</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Kategori</label>
                    <select name="category" class="form-select">
                        <option value="">-- Pilih kategori --</option>
                        <option value="internet_only" {{ $val('category') === 'internet_only' ? 'selected' : '' }}>Internet Only</option>
                        <option value="internet_tv" {{ $val('category') === 'internet_tv' ? 'selected' : '' }}>Internet + TV</option>
                        <option value="streaming" {{ $val('category') === 'streaming' ? 'selected' : '' }}>Streaming</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="p-3 border rounded-4 mb-4">
            <h5 class="fw-bold mb-3">Harga & Spesifikasi</h5>

            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Kecepatan (Mbps)</label>
                    <input type="number" name="speed_mbps" class="form-control" value="{{ $val('speed_mbps') }}"
                           min="1" placeholder="Contoh: 50" required>
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-semibold">Harga per Bulan</label>
                    <input type="number" name="price_monthly" class="form-control" value="{{ $val('price_monthly') }}"
                           min="0" placeholder="Contoh: 350000" required>
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-semibold">Durasi (bulan)</label>
                    <input type="number" name="duration_months" class="form-control" value="{{ $val('duration_months', 1) }}"
                           min="1" placeholder="Contoh: 12">
                </div>
            </div>

            <div class="row g-3 mt-1">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Minimal Pengguna</label>
                    <input type="number" name="min_users" class="form-control" value="{{ $val('min_users') }}"
                           min="1" placeholder="Contoh: 1">
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Maksimal Pengguna</label>
                    <input type="number" name="max_users" class="form-control" value="{{ $val('max_users') }}"
                           min="1" placeholder="Contoh: 5">
                </div>
            </div>
        </div>

        <div class="p-3 border rounded-4 mb-4">
            <h5 class="fw-bold mb-3">Deskripsi Paket</h5>

            <div class="mb-3">
                <label class="form-label fw-semibold">Cocok Untuk</label>
                <input type="text" name="best_for" class="form-control" value="{{ $val('best_for') }}"
                       placeholder="Contoh: Keluarga kecil, gamer, WFH, UMKM">
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Perangkat Ideal</label>
                <input type="text" name="device_ideal" class="form-control" value="{{ $val('device_ideal') }}"
                       placeholder="Contoh: 5-10 perangkat">
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Deskripsi Singkat</label>
                <textarea name="short_description" class="form-control" rows="3"
                          placeholder="Tulis ringkasan singkat paket ini...">{{ $val('short_description') }}</textarea>
            </div>

            <div class="mb-0">
                <label class="form-label fw-semibold">Fitur Paket</label>
                <textarea name="features" class="form-control" rows="5"
                          placeholder="Contoh: Unlimited internet, router WiFi, support 24 jam, dll">{{ $val('features') }}</textarea>
                <div class="text-muted small mt-1">
                    Bisa isi poin fitur, dipisahkan koma atau baris baru sesuai kebutuhan.
                </div>
            </div>
        </div>

        <div class="p-3 border rounded-4 mb-4">
            <h5 class="fw-bold mb-3">Media & Banner</h5>

            <div class="mb-4">
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
            </div>

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
                    <input type="color" name="banner_color_start" class="form-control form-control-color w-100"
                           value="{{ $val('banner_color_start', '#003682') }}" title="Pilih warna awal banner">
                    <div class="small text-muted mt-1">{{ $val('banner_color_start', '#003682') }}</div>
                </div> 

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Warna Banner Akhir</label>
                    <input type="color" name="banner_color_end" class="form-control form-control-color w-100"
                           value="{{ $val('banner_color_end', '#5bab23') }}" title="Pilih warna akhir banner">
                    <div class="small text-muted mt-1">{{ $val('banner_color_end', '#5bab23') }}</div>
                </div>
            </div> --}}

            <div class="mb-0">
                <label class="form-label fw-semibold">WhatsApp Order URL</label>
                <input type="url" name="whatsapp_order_url" class="form-control" value="{{ $val('whatsapp_order_url') }}"
                       placeholder="Contoh: https://wa.me/6281234567890">
            </div>
        </div>
    </div>

    <div class="col-lg-4">

        <div class="p-3 border rounded-4 mb-4">
            <h5 class="fw-bold mb-3">Fitur Tambahan</h5>

            <div class="form-check form-switch mb-2">
                <input class="form-check-input" type="checkbox" name="includes_tv" value="1" {{ $checked('includes_tv') }}>
                <label class="form-check-label">Termasuk TV</label>
            </div>

            <div class="form-check form-switch mb-2">
                <input class="form-check-input" type="checkbox" name="includes_streaming_app" value="1" {{ $checked('includes_streaming_app') }}>
                <label class="form-check-label">Termasuk Aplikasi Streaming</label>
            </div>

            <div class="form-check form-switch mb-0">
                <input class="form-check-input" type="checkbox" name="includes_mobile_quota" value="1" {{ $checked('includes_mobile_quota') }}>
                <label class="form-check-label">Termasuk Kuota Mobile</label>
            </div>
        </div>

        <div class="p-3 border rounded-4 mb-4">
            <h5 class="fw-bold mb-3">Rekomendasi Penggunaan</h5>

            <div class="form-check form-switch mb-2">
                <input class="form-check-input" type="checkbox" name="good_for_gaming" value="1" {{ $checked('good_for_gaming') }}>
                <label class="form-check-label">Cocok untuk Gaming</label>
            </div>

            <div class="form-check form-switch mb-2">
                <input class="form-check-input" type="checkbox" name="good_for_streaming" value="1" {{ $checked('good_for_streaming') }}>
                <label class="form-check-label">Cocok untuk Streaming</label>
            </div>

            <div class="form-check form-switch mb-0">
                <input class="form-check-input" type="checkbox" name="good_for_wfh" value="1" {{ $checked('good_for_wfh') }}>
                <label class="form-check-label">Cocok untuk WFH</label>
            </div>
        </div>

        <div class="p-3 border rounded-4 mb-4">
            <h5 class="fw-bold mb-3">Status Tampil</h5>

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
                $previewStart = $val('banner_color_start', '#003682');
                $previewEnd = $val('banner_color_end', '#5bab23');
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
                        {{ $val('short_description', 'Preview banner paket akan tampil di sini.') }}
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