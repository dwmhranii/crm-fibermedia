@extends('admin.layouts.admin')

@section('title', 'Settings')
@section('subtitle', 'Konfigurasi global website (superadmin bisa edit)')

@php
    $settings = $settings ?? ($values ?? []);
    $settings = is_array($settings) ? $settings : [];

    $user = auth()->user();
    $isSuper = false;

    if ($user) {
        if (method_exists($user, 'hasRole')) {
            $isSuper = $user->hasRole('superadmin');
        } else {
            $isSuper = optional($user->role)->slug === 'superadmin';
        }
    }

    $val = function(string $key, $default = '') use ($settings) {
        return old($key, $settings[$key] ?? $default);
    };

    $disabled = $isSuper ? '' : 'disabled';

    $imgUrl = function(?string $path) {
        if (!$path) return null;
        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) return $path;
        if (str_starts_with($path, 'storage/')) return asset($path);
        return asset('storage/'.$path);
    };

    $logoUrl    = $imgUrl($settings['logo'] ?? null);
    $faviconUrl = $imgUrl($settings['favicon'] ?? null);
    $ogUrl      = $imgUrl($settings['og_image'] ?? null);

    $legalLogo1Url = $imgUrl($settings['legal_logo_1'] ?? null);
    $legalLogo2Url = $imgUrl($settings['legal_logo_2'] ?? null);

    $albums = $albums ?? collect();
@endphp

@push('styles')
<style>
    .tab-card{
        border-radius: 18px;
        border: 1px solid #e5e7eb;
        background: #fff;
        box-shadow: 0 14px 40px rgba(15,23,42,.06);
    }
    body.admin-body.dark .tab-card{
        background: #0f172a;
        border-color: #1f2937;
        box-shadow: 0 18px 55px rgba(0,0,0,.35);
    }
    .preview-box{
        border-radius: 16px;
        border: 1px dashed #cbd5e1;
        background: rgba(2,6,23,.02);
        padding: 12px;
    }
    body.admin-body.dark .preview-box{
        border-color: #334155;
        background: rgba(255,255,255,.04);
    }
    .mini-img{
        max-height: 46px;
        width: auto;
        display: inline-block;
        background: #fff;
        border-radius: 10px;
        padding: 6px;
        border: 1px solid #e5e7eb;
    }
    body.admin-body.dark .mini-img{
        background: #0b1220;
        border-color: #1f2937;
    }
</style>
@endpush

@section('content')

@if(!$isSuper)
    <div class="alert alert-info">
        <i class="bi bi-shield-lock me-1"></i>
        Kamu login sebagai <b>Admin</b>. Halaman ini hanya <b>read-only</b>.
        Hanya <b>Superadmin</b> yang bisa mengubah settings.
    </div>
@endif

<form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="row g-3">
        <div class="col-lg-3">
            <div class="tab-card p-3">
                <div class="fw-bold mb-2">Menu</div>

                <div class="list-group">
                    <button class="list-group-item list-group-item-action active"
                            type="button" data-bs-toggle="tab" data-bs-target="#tab-general">
                        <i class="bi bi-sliders2 me-1"></i> General
                    </button>

                    <button class="list-group-item list-group-item-action"
                            type="button" data-bs-toggle="tab" data-bs-target="#tab-contact">
                        <i class="bi bi-telephone me-1"></i> Contact
                    </button>

                    <button class="list-group-item list-group-item-action"
                            type="button" data-bs-toggle="tab" data-bs-target="#tab-seo">
                        <i class="bi bi-search me-1"></i> SEO
                    </button>

                    <button class="list-group-item list-group-item-action"
                            type="button" data-bs-toggle="tab" data-bs-target="#tab-social">
                        <i class="bi bi-share me-1"></i> Social
                    </button>

                    <button class="list-group-item list-group-item-action"
                            type="button" data-bs-toggle="tab" data-bs-target="#tab-legal">
                        <i class="bi bi-patch-check me-1"></i> Legalitas
                    </button>

                    <button class="list-group-item list-group-item-action"
                            type="button" data-bs-toggle="tab" data-bs-target="#tab-profile">
                        <i class="bi bi-person-badge me-1"></i> Profile
                    </button>
                </div>
            </div>
        </div>

        <div class="col-lg-9">
            <div class="tab-card p-3 p-md-4">
                <div class="tab-content">

                    {{-- GENERAL --}}
                    <div class="tab-pane fade show active" id="tab-general">
                        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
                            <div>
                                <div class="fw-bold fs-5">General</div>
                                <div class="text-muted small">Identitas website (nama, logo, favicon)</div>
                            </div>
                            @if($isSuper)
                                <span class="badge text-bg-success">Editable</span>
                            @else
                                <span class="badge text-bg-secondary">Read-only</span>
                            @endif
                        </div>

                        <div class="row g-3">
                            <div class="col-md-7">
                                <label class="form-label fw-semibold">Site Name</label>
                                <input type="text" name="site_name" class="form-control"
                                       value="{{ $val('site_name') }}" {{ $disabled }}>
                            </div>

                            <div class="col-md-5">
                                <div class="preview-box h-100">
                                    <div class="fw-semibold mb-2">Preview</div>
                                    <div class="text-muted small mb-2">Logo / Favicon yang tersimpan</div>

                                    <div class="d-flex align-items-center gap-2 flex-wrap">
                                        @if($logoUrl)
                                            <div>
                                                <div class="text-muted small">Logo</div>
                                                <img class="mini-img" src="{{ $logoUrl }}" alt="Logo">
                                            </div>
                                        @endif

                                        @if($faviconUrl)
                                            <div>
                                                <div class="text-muted small">Favicon</div>
                                                <img class="mini-img" src="{{ $faviconUrl }}" alt="Favicon">
                                            </div>
                                        @endif

                                        @if(!$logoUrl && !$faviconUrl)
                                            <div class="text-muted small">Belum ada file tersimpan.</div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Logo (upload)</label>
                                <input type="file" name="logo" class="form-control" accept="image/*" {{ $disabled }}>
                                <div class="text-muted small mt-1">Disarankan PNG/SVG, tinggi sekitar 48–64px.</div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Favicon (upload)</label>
                                <input type="file" name="favicon" class="form-control" accept="image/*" {{ $disabled }}>
                                <div class="text-muted small mt-1">Disarankan PNG 32x32 / 48x48.</div>
                            </div>
                        </div>
                    </div>

                    {{-- CONTACT --}}
                    <div class="tab-pane fade" id="tab-contact">
                        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
                            <div>
                                <div class="fw-bold fs-5">Contact</div>
                                <div class="text-muted small">Kontak utama yang tampil di website</div>
                            </div>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">WhatsApp</label>
                                <input type="text" name="contact_whatsapp" class="form-control"
                                       value="{{ $val('contact_whatsapp') }}"
                                       placeholder="contoh: 6281234567890" {{ $disabled }}>
                                <div class="text-muted small mt-1">Simpan nomor tanpa + dan tanpa spasi.</div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Email</label>
                                <input type="email" name="contact_email" class="form-control"
                                       value="{{ $val('contact_email') }}"
                                       placeholder="cs@domain.com" {{ $disabled }}>
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-semibold">Alamat</label>
                                <textarea name="contact_address" class="form-control" rows="4" {{ $disabled }}
                                          placeholder="Tulis alamat lengkap...">{{ $val('contact_address') }}</textarea>
                            </div>
                        </div>
                    </div>

                    {{-- SEO --}}
                    <div class="tab-pane fade" id="tab-seo">
                        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
                            <div>
                                <div class="fw-bold fs-5">SEO</div>
                                <div class="text-muted small">Default SEO title/description + Open Graph image</div>
                            </div>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-7">
                                <label class="form-label fw-semibold">Default Title</label>
                                <input type="text" name="seo_default_title" class="form-control"
                                       value="{{ $val('seo_default_title') }}" {{ $disabled }}>
                            </div>

                            <div class="col-md-5">
                                <div class="preview-box h-100">
                                    <div class="fw-semibold mb-2">OG Image Preview</div>
                                    @if($ogUrl)
                                        <img src="{{ $ogUrl }}"
                                             alt="OG Image"
                                             style="max-width:100%; border-radius:14px; border:1px solid #e5e7eb;">
                                    @else
                                        <div class="text-muted small">Belum ada OG image.</div>
                                    @endif
                                </div>
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-semibold">Default Description</label>
                                <textarea name="seo_default_description" class="form-control" rows="4" {{ $disabled }}
                                          placeholder="Deskripsi default untuk SEO...">{{ $val('seo_default_description') }}</textarea>
                                <div class="text-muted small mt-1">Saran: 120–160 karakter.</div>
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-semibold">OG Image (upload)</label>
                                <input type="file" name="og_image" class="form-control" accept="image/*" {{ $disabled }}>
                                <div class="text-muted small mt-1">Saran ukuran 1200x630.</div>
                            </div>
                        </div>
                    </div>

                    {{-- SOCIAL --}}
                    <div class="tab-pane fade" id="tab-social">
                        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
                            <div>
                                <div class="fw-bold fs-5">Social</div>
                                <div class="text-muted small">URL social media</div>
                            </div>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Instagram URL</label>
                                <input type="url" name="instagram_url" class="form-control"
                                       value="{{ $val('instagram_url') }}"
                                       placeholder="https://instagram.com/..." {{ $disabled }}>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">TikTok URL</label>
                                <input type="url" name="tiktok_url" class="form-control"
                                       value="{{ $val('tiktok_url') }}"
                                       placeholder="https://tiktok.com/@..." {{ $disabled }}>
                            </div>
                        </div>
                    </div>

                    {{-- LEGAL --}}
                    <div class="tab-pane fade" id="tab-legal">
                        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
                            <div>
                                <div class="fw-bold fs-5">Legalitas</div>
                                <div class="text-muted small">Konten & logo bagian “Legalitas Penyelenggara” di footer</div>
                            </div>
                            @if($isSuper)
                                <span class="badge text-bg-success">Editable</span>
                            @else
                                <span class="badge text-bg-secondary">Read-only</span>
                            @endif
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Judul Legalitas</label>
                                <input type="text" name="legal_title" class="form-control"
                                       value="{{ $val('legal_title', 'Legalitas Penyelenggara') }}" {{ $disabled }}>
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-semibold">Deskripsi Legalitas</label>
                                <textarea name="legal_description" class="form-control" rows="4" {{ $disabled }}
                                          placeholder="Deskripsi legalitas...">{{ $val('legal_description', 'PT Fibermedia Linktel Akses Indonesia sebagai penyelenggara jasa internet & jaringan data berbasis fiber optik.') }}</textarea>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Legal Logo 1 (upload)</label>
                                <input type="file" name="legal_logo_1" class="form-control" accept="image/*" {{ $disabled }}>
                                <div class="text-muted small mt-1">PNG/SVG disarankan, max 2MB.</div>

                                <div class="mt-2">
                                    <div class="text-muted small">Preview</div>
                                    @if($legalLogo1Url)
                                        <img src="{{ $legalLogo1Url }}" class="mini-img" alt="Legal Logo 1">
                                    @else
                                        <div class="text-muted small">Belum ada.</div>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Legal Logo 2 (upload)</label>
                                <input type="file" name="legal_logo_2" class="form-control" accept="image/*" {{ $disabled }}>
                                <div class="text-muted small mt-1">PNG/SVG disarankan, max 2MB.</div>

                                <div class="mt-2">
                                    <div class="text-muted small">Preview</div>
                                    @if($legalLogo2Url)
                                        <img src="{{ $legalLogo2Url }}" class="mini-img" alt="Legal Logo 2">
                                    @else
                                        <div class="text-muted small">Belum ada.</div>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Legal Logo 1 Alt</label>
                                <input type="text" name="legal_logo_1_alt" class="form-control"
                                       value="{{ $val('legal_logo_1_alt', 'FibermediaPlay Networks') }}" {{ $disabled }}>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Legal Logo 2 Alt</label>
                                <input type="text" name="legal_logo_2_alt" class="form-control"
                                       value="{{ $val('legal_logo_2_alt', 'Partner') }}" {{ $disabled }}>
                            </div>
                        </div>
                    </div>

                    {{-- ✅ PROFILE --}}
                    <div class="tab-pane fade" id="tab-profile">
                        <div class="fw-bold fs-5 mb-1">Profile Page</div>
                        <div class="text-muted small mb-3">Setting galeri yang tampil di halaman Profil</div>

                        <div class="row g-3">
                            <div class="col-md-8">
                                <label class="form-label fw-semibold">Album <span class="text-danger">*</span></label>

                                <select name="profile_album_id" class="form-select" {{ $disabled }}>
                                    <option value="">-- Select Album --</option>

                                    @forelse($albums as $album)
                                        <option value="{{ $album->id }}"
                                            @selected((string)$val('profile_album_id') === (string)$album->id)>
                                            {{ $album->title }} ({{ $album->slug }})
                                        </option>
                                    @empty
                                        {{-- Kalau kosong biar jelas --}}
                                        <option value="" disabled>(Tidak ada album aktif / data album belum terkirim)</option>
                                    @endforelse
                                </select>

                                <div class="text-muted small mt-1">
                                    Pastikan album <b>is_active = 1</b>.
                                </div>

                                {{-- Debug opsional (hapus kalau sudah OK) --}}
                                {{-- <div class="text-muted small">Albums count: {{ $albums->count() }}</div> --}}
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Jumlah item ditampilkan</label>
                                <input type="number" name="profile_items_limit" class="form-control"
                                       value="{{ $val('profile_items_limit', 2) }}" min="1" max="24" {{ $disabled }}>
                                <div class="text-muted small mt-1">
                                    Disarankan 2 (layout kamu 2 gambar + 1 brand card).
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <hr class="my-4">

                <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                    <div class="text-muted small">
                        Terakhir update: <b>{{ $lastUpdatedAt ?? '-' }}</b>
                    </div>

                    @if($isSuper)
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save me-1"></i> Save Settings
                        </button>
                    @else
                        <button type="button" class="btn btn-secondary" disabled>
                            <i class="bi bi-lock me-1"></i> Read-only
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</form>

@endsection