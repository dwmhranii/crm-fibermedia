@extends('public.layouts.public')

@push('styles')
<link rel="stylesheet"
      href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
      integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
      crossorigin=""/>

<style>
.order-wrap {
    max-width: 980px;
    margin: 0 auto;
    padding: 1.5rem 1rem 3rem;
}

/* ===================== STEPPER ===================== */
.order-steps {
    display: flex;
    justify-content: center;
    align-items: flex-start;
    gap: 12px;
    margin-bottom: 1.75rem;
    flex-wrap: nowrap;
}

.order-step {
    display: flex;
    flex-direction: column;
    align-items: center;
    min-width: 60px;
    flex: 0 0 auto;
}

.order-step-badge {
    width: 42px;
    height: 42px;
    border-radius: 999px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border: 2px solid #cbd5e1;
    background: #fff;
    color: #475569;
    font-weight: 800;
    font-size: 16px;
    box-shadow: 0 4px 10px rgba(15, 23, 42, .05);
}

.order-step-text {
    margin-top: 6px;
    font-size: 13px;
    font-weight: 600;
    color: #64748b;
    text-align: center;
    line-height: 1.2;
}

.order-step-line {
    width: 70px;
    height: 3px;
    border-radius: 999px;
    background: #e2e8f0;
    margin-top: 19px;
    flex: 0 0 auto;
}

.order-step.done .order-step-badge,
.order-step.active .order-step-badge {
    background: linear-gradient(135deg, #1E5FA8, #2575C0);
    border-color: #1E5FA8;
    color: #fff;
    box-shadow: 0 6px 16px rgba(30, 95, 168, .28);
}

.order-step.done .order-step-text,
.order-step.active .order-step-text {
    color: #1E5FA8;
    font-weight: 700;
}

.order-step-line.active {
    background: #1E5FA8;
}

.order-card {
    background: #fff;
    border: 1px solid #e2e8f0;
    border-radius: 24px;
    padding: 1.75rem;
    box-shadow: 0 10px 30px rgba(15, 23, 42, .05);
}

.order-header {
    text-align: center;
    margin-bottom: 1.25rem;
}

.order-title {
    font-size: 2rem;
    font-weight: 800;
    color: #1E5FA8;
    margin-bottom: .25rem;
}

.order-subtitle {
    color: #64748b;
    font-size: .92rem;
}

.order-package-box {
    border: 1px solid #dbeafe;
    background: linear-gradient(135deg, #eff6ff, #f0fdf4);
    border-radius: 16px;
    padding: 1rem 1.25rem;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 12px;
}

.order-package-box.has-addons {
    background: linear-gradient(135deg, #f0f7ff, #ffffff);
    border-color: #cbd5e1;
    box-shadow: 0 4px 14px rgba(30, 95, 168, .06);
}

.order-pkg-left {
    flex: 1 1 300px;
}

.order-pkg-right {
    flex-shrink: 0;
}

.order-package-name {
    font-weight: 800;
    color: #1E5FA8;
    font-size: 1.1rem;
}

.order-package-meta {
    color: #059669;
    font-weight: 800;
    font-size: 1.15rem;
}

.order-package-total {
    color: #1E5FA8;
    font-weight: 800;
    font-size: 1.35rem;
    line-height: 1.1;
}

.order-addon-tag {
    font-size: .78rem;
    background: #ffffff;
    border: 1px solid #dbeafe;
    padding: 3px 10px;
    border-radius: 999px;
    display: inline-flex;
    align-items: center;
    gap: 5px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, .04);
}

body.dark-mode .order-package-box {
    background: #1e293b;
    border-color: #334155;
}

body.dark-mode .order-addon-tag {
    background: #0f172a;
    border-color: #334155;
    color: #e2e8f0;
}

.order-section-divider {
    font-size: .92rem;
    font-weight: 800;
    color: #1E5FA8;
    display: flex;
    align-items: center;
    gap: 8px;
    margin-top: .75rem;
    margin-bottom: .25rem;
    padding-bottom: .4rem;
    border-bottom: 2px solid #eff6ff;
}

.order-label {
    font-weight: 700;
    font-size: .84rem;
    color: #334155;
    margin-bottom: .35rem;
    display: block;
}

.order-form .form-control,
.order-form .form-select,
.order-form textarea {
    border-radius: 12px;
    min-height: 44px;
    font-size: .88rem;
    border-color: #cbd5e1;
    box-shadow: none;
    background: #ffffff;
}

.order-form .form-control:focus,
.order-form .form-select:focus,
.order-form textarea:focus {
    border-color: #1E5FA8;
    box-shadow: 0 0 0 0.15rem rgba(30, 95, 168, .12);
}

.order-form textarea {
    min-height: 75px;
    resize: vertical;
}

/* ===================== MAPS PICKER ===================== */
.map-picker-box {
    border: 1px solid #dbeafe;
    border-radius: 18px;
    overflow: hidden;
    background: #f8fbff;
    margin-top: .5rem;
    margin-bottom: 1rem;
    position: relative;
    box-shadow: 0 4px 14px rgba(15, 23, 42, .04);
}

.map-picker-header {
    padding: .75rem 1rem;
    background: #ffffff;
    border-bottom: 1px solid #e2e8f0;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 8px;
}

.map-picker-title {
    font-size: .86rem;
    font-weight: 800;
    color: #1E5FA8;
    display: flex;
    align-items: center;
    gap: 6px;
}

.btn-gps-detect {
    font-size: .78rem;
    font-weight: 700;
    padding: 5px 12px;
    border-radius: 999px;
    background: linear-gradient(135deg, #10b981, #059669);
    border: none;
    color: #fff;
    display: inline-flex;
    align-items: center;
    gap: 5px;
    transition: all .2s ease;
    box-shadow: 0 3px 8px rgba(16, 185, 129, .2);
}

.btn-gps-detect:hover {
    color: #fff;
    transform: translateY(-1px);
    box-shadow: 0 5px 12px rgba(16, 185, 129, .3);
}

#orderLocationMap {
    width: 100%;
    height: 320px;
    z-index: 10;
}

.map-picker-footer {
    padding: .65rem 1rem;
    background: #ffffff;
    border-top: 1px solid #e2e8f0;
    font-size: .8rem;
    color: #64748b;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 8px;
}

.map-coords-badge {
    background: #eff6ff;
    color: #1E5FA8;
    border: 1px solid #bfdbfe;
    padding: 3px 9px;
    border-radius: 999px;
    font-size: .76rem;
    font-weight: 700;
    font-family: monospace;
}

.order-footer {
    display: flex;
    justify-content: space-between;
    gap: 12px;
    margin-top: 1.75rem;
    padding-top: 1rem;
    border-top: 1px solid #e2e8f0;
}

.btn-order-back {
    border-radius: 999px;
    padding: 9px 24px;
    font-weight: 600;
    font-size: .88rem;
}

.btn-order-next {
    border-radius: 999px;
    padding: 10px 30px;
    font-weight: 700;
    font-size: .92rem;
    background: linear-gradient(135deg, #1E5FA8, #2575C0);
    border: 0;
    color: #fff;
    box-shadow: 0 8px 20px rgba(30, 95, 168, .22);
    transition: all .2s ease;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}

.btn-order-next:hover {
    color: #fff;
    transform: translateY(-1px);
    box-shadow: 0 12px 26px rgba(30, 95, 168, .3);
}

/* ===================== DARK MODE ===================== */
/* ===================== DARK MODE ===================== */
body.dark-mode .order-card {
    background: #0f172a;
    border-color: #1e293b;
    box-shadow: 0 18px 45px rgba(0,0,0,.7);
}

body.dark-mode .order-package-box {
    background: linear-gradient(135deg, rgba(30, 95, 168, 0.25), rgba(16, 185, 129, 0.15));
    border-color: rgba(59, 130, 246, 0.3);
}

body.dark-mode .order-package-name {
    color: #60a5fa !important;
}

body.dark-mode .order-package-box .text-muted {
    color: #94a3b8 !important;
}

body.dark-mode .order-package-meta {
    color: #4ade80 !important;
}

body.dark-mode .order-title {
    color: #f1f5f9;
}

body.dark-mode .order-subtitle {
    color: #94a3b8;
}

body.dark-mode .order-section-divider {
    color: #60a5fa;
    border-bottom-color: #1e293b;
}

body.dark-mode .order-label {
    color: #e2e8f0;
}

body.dark-mode .order-form .form-control,
body.dark-mode .order-form .form-select,
body.dark-mode .order-form textarea {
    background: #1e293b;
    color: #f8fafc;
    border-color: #334155;
}

body.dark-mode .order-form .form-control::placeholder,
body.dark-mode .order-form textarea::placeholder {
    color: #64748b;
}

body.dark-mode .order-form .form-control:focus,
body.dark-mode .order-form .form-select:focus,
body.dark-mode .order-form textarea:focus {
    background: #1e293b;
    color: #ffffff;
    border-color: #38bdf8;
    box-shadow: 0 0 0 0.18rem rgba(56, 189, 248, 0.18);
}

body.dark-mode .order-form .form-select option {
    background: #1e293b;
    color: #f8fafc;
}

body.dark-mode .order-form .input-group-text {
    background: #1e293b;
    border-color: #334155;
    color: #22c55e;
}

body.dark-mode .map-picker-box {
    background: #0b1329;
    border-color: #1e293b;
    box-shadow: 0 8px 24px rgba(0,0,0,.4);
}

body.dark-mode .map-picker-header {
    background: #1e293b;
    border-bottom-color: #334155;
}

body.dark-mode .map-picker-title {
    color: #93c5fd;
}

body.dark-mode .map-picker-footer {
    background: #1e293b;
    border-top-color: #334155;
    color: #94a3b8;
}

body.dark-mode .map-coords-badge {
    background: #0f172a;
    color: #38bdf8;
    border-color: #334155;
}

body.dark-mode .order-step-badge {
    background: #1e293b;
    border-color: #334155;
    color: #cbd5e1;
}

body.dark-mode .order-step.done .order-step-badge {
    background: #10b981;
    border-color: #10b981;
    color: #fff;
    box-shadow: 0 4px 14px rgba(16, 185, 129, 0.4);
}

body.dark-mode .order-step.active .order-step-badge {
    background: linear-gradient(135deg, #1E5FA8, #2575C0);
    border-color: #38bdf8;
    color: #fff;
    box-shadow: 0 4px 14px rgba(30, 95, 168, 0.5);
}

body.dark-mode .order-step-text {
    color: #64748b;
}

body.dark-mode .order-step.done .order-step-text,
body.dark-mode .order-step.active .order-step-text {
    color: #93c5fd;
}

body.dark-mode .order-step-line {
    background: #334155;
}

body.dark-mode .order-step-line.active {
    background: #2563eb;
}

body.dark-mode .btn-order-back {
    color: #cbd5e1;
    border-color: #475569;
    background: #1e293b;
}

body.dark-mode .btn-order-back:hover {
    color: #fff;
    background: #334155;
    border-color: #64748b;
}

@media (max-width: 576px) {
    .order-wrap {
        padding: .75rem .4rem 2rem;
    }

    .order-steps {
        gap: 6px;
        margin-bottom: 1.15rem;
    }

    .order-step {
        min-width: 48px;
    }

    .order-step-badge {
        width: 34px;
        height: 34px;
        font-size: 14px;
    }

    .order-step-text {
        font-size: 11px;
        margin-top: 4px;
    }

    .order-step-line {
        width: 24px;
        height: 2px;
        margin-top: 16px;
    }

    .order-card {
        padding: 1rem .85rem;
        border-radius: 18px;
    }

    .order-title {
        font-size: 1.35rem;
    }

    .order-subtitle {
        font-size: .8rem;
    }

    #orderLocationMap {
        height: 260px;
    }

    .order-footer {
        flex-direction: column-reverse;
        gap: 8px;
    }

    .order-footer .btn {
        width: 100%;
        justify-content: center;
    }
}
</style>
@endpush

@section('content')
<div class="order-wrap">
    {{-- STEP PROGRESS --}}
    <div class="order-steps">
        <div class="order-step done">
            <span class="order-step-badge"><i class="bi bi-check-lg"></i></span>
            <span class="order-step-text">Pilih Paket</span>
        </div>
        <div class="order-step-line active"></div>
        <div class="order-step active">
            <span class="order-step-badge">2</span>
            <span class="order-step-text">Isi Data</span>
        </div>
        <div class="order-step-line"></div>
        <div class="order-step">
            <span class="order-step-badge">3</span>
            <span class="order-step-text">Konfirmasi</span>
        </div>
    </div>

    <div class="order-card">
        <div class="order-header">
            <h1 class="order-title">Data Pelanggan &amp; Lokasi</h1>
            <p class="order-subtitle">Lengkapi data diri dan tentukan titik pemasangan internet FiberMedia</p>
        </div>

        @if(session('error'))
            <div class="alert alert-danger mb-3 p-2 px-3 small">{{ session('error') }}</div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger mb-3 p-2 px-3 small">
                <ul class="mb-0 ps-3">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @php
            $hasAddons = isset($selectedAddons) && $selectedAddons->count() > 0;
            $packageMonthly = (float) $package->price_monthly;
            $addonMonthly = $hasAddons ? (float) $selectedAddons->where('pricing_type', 'monthly')->sum('price') : 0;
            $addonOneTime = $hasAddons ? (float) $selectedAddons->where('pricing_type', 'one_time')->sum('price') : 0;
            $totalMonthly = $packageMonthly + $addonMonthly;
        @endphp

        <div class="order-package-box {{ $hasAddons ? 'has-addons' : '' }}">
            <div class="order-pkg-left">
                <span class="text-muted small">Paket yang Dipilih:</span>
                <div class="d-flex align-items-center gap-2 flex-wrap">
                    <span class="order-package-name">{{ $package->name }}</span>
                    <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-2 py-1">{{ $package->speed_mbps }} Mbps</span>
                </div>

                @if($hasAddons)
                    <div class="order-pkg-addons-mini mt-2 pt-2 border-top">
                        <div class="small fw-bold text-dark mb-1 d-flex align-items-center gap-1">
                            <i class="bi bi-puzzle-fill text-primary"></i>
                            <span>Add-on Tambahan ({{ $selectedAddons->count() }}):</span>
                        </div>
                        <div class="d-flex flex-wrap gap-2">
                            @foreach($selectedAddons as $ad)
                                @php
                                    $pLabel = $ad->pricing_type === 'monthly' ? '/bln' : '(1x bayar)';
                                @endphp
                                <span class="order-addon-tag">
                                    <i class="bi bi-check-circle-fill text-success"></i>
                                    <strong>{{ $ad->name }}</strong>
                                    <span class="text-muted">(Rp {{ number_format((float) $ad->price, 0, ',', '.') }} {{ $pLabel }})</span>
                                </span>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <div class="order-pkg-right text-md-end">
                @if($hasAddons)
                    <span class="text-muted small d-block">Estimasi Total Bulanan:</span>
                    <div class="order-package-total">
                        Rp {{ number_format($totalMonthly, 0, ',', '.') }} <span class="fs-6 fw-normal text-muted">/bln</span>
                    </div>
                    @if($addonOneTime > 0)
                        <div class="small text-muted mt-1">
                            + Biaya Perangkat: <strong>Rp {{ number_format($addonOneTime, 0, ',', '.') }}</strong> (sekali bayar)
                        </div>
                    @endif
                @else
                    <span class="text-muted small d-block">Biaya Berlangganan:</span>
                    <div class="order-package-meta">
                        Rp {{ number_format($packageMonthly, 0, ',', '.') }} / bulan
                    </div>
                @endif
            </div>
        </div>

        <form method="POST" action="{{ route('public.order.storeStep2') }}" class="order-form" id="orderStep2Form">
            @csrf

            {{-- Hidden GPS Coordinates --}}
            <input type="hidden" name="customer_lat" id="customerLat" value="{{ old('customer_lat', $formData['customer_lat'] ?? '-7.9826') }}">
            <input type="hidden" name="customer_lng" id="customerLng" value="{{ old('customer_lng', $formData['customer_lng'] ?? '112.6308') }}">

            {{-- SECTION 1: DATA KONTAK --}}
            <div class="order-section-divider">
                <i class="bi bi-person-lines-fill text-primary"></i>
                <span>1. Data Kontak Pemesan</span>
            </div>

            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label class="order-label">Nama Lengkap *</label>
                    <input
                        type="text"
                        name="customer_name"
                        class="form-control"
                        value="{{ old('customer_name', $formData['customer_name'] ?? '') }}"
                        placeholder="Contoh: Budi Santoso"
                        required
                    >
                </div>

                <div class="col-md-6">
                    <label class="order-label">Nomor WhatsApp / HP *</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-whatsapp text-success"></i></span>
                        <input
                            type="text"
                            name="customer_phone"
                            class="form-control"
                            value="{{ old('customer_phone', $formData['customer_phone'] ?? '') }}"
                            placeholder="Contoh: 081234567890"
                            required
                        >
                    </div>
                </div>
            </div>

            {{-- SECTION 2: WILAYAH MALANG RAYA (CASCADING) --}}
            <div class="order-section-divider">
                <i class="bi bi-geo-alt-fill text-primary"></i>
                <span>2. Pilih Wilayah Pemasangan (Malang Raya)</span>
            </div>

            <div class="row g-3 mb-3">
                <div class="col-md-4">
                    <label class="order-label">Kota / Kabupaten *</label>
                    <select name="customer_city" id="selectCity" class="form-select" required>
                        <option value="Kota Malang" {{ old('customer_city', $formData['customer_city'] ?? '') === 'Kota Malang' ? 'selected' : '' }}>Kota Malang</option>
                        <option value="Kabupaten Malang" {{ old('customer_city', $formData['customer_city'] ?? '') === 'Kabupaten Malang' ? 'selected' : '' }}>Kabupaten Malang</option>
                        <option value="Kota Batu" {{ old('customer_city', $formData['customer_city'] ?? '') === 'Kota Batu' ? 'selected' : '' }}>Kota Batu</option>
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="order-label">Kecamatan *</label>
                    <select name="customer_district" id="selectDistrict" class="form-select" required>
                        <option value="">Pilih Kecamatan...</option>
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="order-label">Kelurahan / Desa *</label>
                    <select name="customer_village" id="selectVillage" class="form-select" required>
                        <option value="">Pilih Kelurahan/Desa...</option>
                    </select>
                </div>

                {{-- RT, RW, and Detail Street --}}
                <div class="col-6 col-sm-3 col-md-2">
                    <label class="order-label">RT *</label>
                    <input
                        type="text"
                        name="customer_rt"
                        class="form-control"
                        value="{{ old('customer_rt', $formData['customer_rt'] ?? '') }}"
                        placeholder="01"
                        required
                    >
                </div>

                <div class="col-6 col-sm-3 col-md-2">
                    <label class="order-label">RW *</label>
                    <input
                        type="text"
                        name="customer_rw"
                        class="form-control"
                        value="{{ old('customer_rw', $formData['customer_rw'] ?? '') }}"
                        placeholder="02"
                        required
                    >
                </div>

                <div class="col-12 col-sm-6 col-md-8">
                    <label class="order-label">Nama Jalan, No. Rumah / Patokan *</label>
                    <input
                        type="text"
                        name="customer_street"
                        class="form-control"
                        value="{{ old('customer_street', $formData['customer_street'] ?? '') }}"
                        placeholder="Contoh: Jl. Soekarno Hatta No. 45, Blok A (Dekat Masjid)"
                        required
                    >
                </div>
            </div>

            {{-- SECTION 3: TITIK LOKASI PADA MAPS --}}
            <div class="order-section-divider">
                <i class="bi bi-pin-map-fill text-primary"></i>
                <span>3. Tandai Titik Pemasangan di Peta</span>
            </div>

            <div class="map-picker-box">
                <div class="map-picker-header">
                    <div class="map-picker-title">
                        <i class="bi bi-cursor-fill text-primary"></i>
                        <span>Geser pin atau klik peta untuk menentukan titik tepat</span>
                    </div>
                    <button type="button" class="btn-gps-detect" id="btnGpsDetect">
                        <i class="bi bi-crosshair"></i> Deteksi Lokasi Saya (GPS)
                    </button>
                </div>

                <div id="orderLocationMap"></div>

                <div class="map-picker-footer">
                    <div>
                        <i class="bi bi-info-circle me-1 text-primary"></i>
                        Titik ini membantu teknisi FiberMedia menemukan lokasi pemasangan dengan cepat.
                    </div>
                    <div class="map-coords-badge" id="mapCoordsDisplay">
                        Lat: -7.9826, Lng: 112.6308
                    </div>
                </div>
            </div>

            {{-- SECTION 4: CATATAN TAMBAHAN --}}
            <div class="mb-3">
                <label class="order-label">Catatan Tambahan untuk Tim Teknisi (Opsional)</label>
                <textarea
                    name="customer_note"
                    class="form-control"
                    placeholder="Contoh: Rumah pagar hitam, kabel mohon lewat samping, atau jadwal instalasi yang diinginkan."
                >{{ old('customer_note', $formData['customer_note'] ?? '') }}</textarea>
            </div>

            <div class="order-footer">
                <a href="{{ route('public.order.step1') }}" class="btn btn-outline-secondary btn-order-back">
                    <i class="bi bi-arrow-left me-1"></i> Kembali ke Pilih Paket
                </a>

                <button type="submit" class="btn btn-order-next">
                    Lanjut ke Konfirmasi <i class="bi bi-arrow-right"></i>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
        crossorigin=""></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // ===================== REGION DATA (MALANG RAYA) =====================
    const malangData = {
        "Kota Malang": {
            center: [-7.9826, 112.6308],
            zoom: 13,
            districts: {
                "Blimbing": ["Arjosari", "Balearjosari", "Blimbing", "Jodipan", "Kesatrian", "Pandanwangi", "Polehan", "Polowijen", "Purwantoro", "Purwodadi"],
                "Kedungkandang": ["Arjowinangun", "Bumiayu", "Buring", "Cemorokandang", "Kedungkandang", "Kotalama", "Lesanpuro", "Madyopuro", "Mergosono", "Sawojajar", "Tlogowaru", "Wonokoyo"],
                "Klojen": ["Bareng", "Gadingkasri", "Kasin", "Kauman", "Kiduldalem", "Klojen", "Oro-oro Dowo", "Penanggungan", "Rampal Celaket", "Samaan", "Sukoharjo"],
                "Lowokwaru": ["Dinoyo", "Jatimulyo", "Ketawanggede", "Lowokwaru", "Merjosari", "Mojolangu", "Sumbersari", "Tasikmadu", "Tlogomas", "Tulusrejo", "Tunggulwulung"],
                "Sukun": ["Bakalankrajan", "Bandulan", "Bandungrejosari", "Ciptomulyo", "Gadang", "Karangbesuki", "Kebonsari", "Mulyorejo", "Pisangcandi", "Sukun", "Tanjungrejo"]
            }
        },
        "Kota Batu": {
            center: [-7.8671, 112.5239],
            zoom: 13,
            districts: {
                "Batu": ["Oro-Oro Ombo", "Pesanggrahan", "Sidomulyo", "Sumberejo", "Ngaglik", "Sisir", "Songgokerto", "Temas"],
                "Bumiaji": ["Bumiaji", "Bulukerto", "Giripurno", "Gunungsari", "Punten", "Sumber Brantas", "Sumbergondo", "Tulungrejo"],
                "Junrejo": ["Beji", "Junrejo", "Mojorejo", "Pendem", "Tlekung", "Torongrejo", "Dadaprejo"]
            }
        },
        "Kabupaten Malang": {
            center: [-8.1331, 112.5714],
            zoom: 11,
            districts: {
                "Ampelgading": ["Lebakharjo", "Mulyoasri", "Purwoharjo", "Sidorenggo", "Simojayan", "Sonowangi", "Tawangagung", "Tirtomarto", "Tirtomoyo", "Wirotaman"],
                "Bantur": ["Bandungrejo", "Bantur", "Karangsari", "Pringgodani", "Rejosari", "Rejoyoso", "Srigonco", "Sumberbening", "Wonokerto", "Wonorejo"],
                "Bululawang": ["Bakalan", "Bululawang", "Gading", "Kasembon", "Kasri", "Krebet", "Krebet Senggrong", "Kuwolu", "Lumbangsari", "Pringu", "Sempalwadak", "Sudimoro", "Sukonolo", "Wandanpuro"],
                "Dampit": ["Amadanom", "Baturetno", "Bumirejo", "Dampit", "Jambangan", "Majangtengah", "Pamotan", "Pojok", "Rembun", "Srimulyo", "Sukodono", "Sumbersuko"],
                "Dau": ["Gadingkulon", "Kalisongo", "Karangwidoro", "Kucur", "Landungsari", "Mulyoagung", "Petungsewu", "Selorejo", "Sumbersekar", "Tegalweru"],
                "Donomulyo": ["Banjarejo", "Donomulyo", "Kedungsalam", "Mentaraman", "Purworejo", "Purwodadi", "Sumberoto", "Tempursari", "Tlogosari", "Tulungrejo"],
                "Gedangan": ["Gajahrejo", "Gedangan", "Girimulyo", "Segaran", "Sidodadi", "Sindurejo", "Tumpakrejo"],
                "Gondanglegi": ["Ganjaran", "Gondanglegi Kulon", "Gondanglegi Wetan", "Ketawang", "Panggungrejo", "Putat Kidul", "Putat Lor", "Putukrejo", "Sepanjang", "Sukorejo", "Sukosari", "Sumberjaya", "Urek-Urek"],
                "Jabung": ["Argosari", "Gadingkembar", "Gunung Jati", "Jabung", "Kemantren", "Kemiri", "Kenongo", "Ngadirejo", "Pandansari Lor", "Slamparejo", "Sukolilo", "Sukopuro", "Taji"],
                "Kalipare": ["Arjowilangun", "Arjosari", "Kalipare", "Kalirejo", "Kaliasri", "Putukrejo", "Sukowilangun", "Tumpakrejo"],
                "Karangploso": ["Ampeldento", "Bocek", "Donowarih", "Girimoyo", "Kepuharjo", "Ngenep", "Ngijo", "Tawangargo", "Tegalgondo"],
                "Kasembon": ["Bayem", "Kasembon", "Pait", "Pondokagung", "Sukosari", "Wonoagung"],
                "Kepanjen": ["Ardirejo", "Cepokomulyo", "Curungrejo", "Dilem", "Jatirejoyoso", "Jenggolo", "Kedungpedaringan", "Kemiri", "Kepanjen", "Mangunrejo", "Mojosari", "Ngadilangkung", "Panggungrejo", "Penarukan", "Sengguruh", "Sukoraharjo", "Talangagung", "Tegalsari"],
                "Kromengan": ["Butter", "Jambuwer", "Jatikerto", "Kromengan", "Ngadirejo", "Peniwen", "Slorok"],
                "Lawang": ["Bedali", "Ketindan", "Lawang", "Mulyoarjo", "Sidodadi", "Srigading", "Sumberngepoh", "Sumberporong", "Turirejo", "Wonorejo", "Kalirejo"],
                "Ngajum": ["Babadan", "Balesari", "Banjarsari", "Kesamben", "Kranggan", "Maguan", "Ngajum", "Ngasem", "Palaan"],
                "Ngantang": ["Banjarejo", "Banturejo", "Jombok", "Kaumrejo", "Mulyorejo", "Ngadirejo", "Ngantru", "Pagersari", "Pandansari", "Purworejo", "Sidodadi", "Sumberagung", "Tulungrejo", "Waturejo"],
                "Pagak": ["Gampingan", "Pagak", "Pandanrejo", "Sempol", "Sumberejo", "Sumberkerto", "Tumpakrejo"],
                "Pagelaran": ["Balearjo", "Banjarejo", "Brongkal", "Clumprit", "Kademangan", "Kanigoro", "Karangsuko", "Pagelaran", "Sidorejo", "Suwaru"],
                "Pakis": ["Ampeldento", "Asrikaton", "Banjarejo", "Bunutwetan", "Kedungrejo", "Mangliawan", "Pakisjajar", "Pakiskembar", "Pagentan", "Saptorenggo", "Sekarpuro", "Sukoanyar", "Sumberkradenan", "Sumberpasir", "Tirtomoyo"],
                "Pakisaji": ["Genengan", "Glanggang", "Jatisari", "Karangduren", "Karangpandan", "Kebonagung", "Kendalpayak", "Pakisaji", "Permanu", "Sutojayan", "Wonokerso"],
                "Poncokusumo": ["Argosuko", "Belung", "Dawuhan", "Gubugklakah", "Jambesari", "Karanganyar", "Karangnongko", "Ngadas", "Ngadireso", "Padasuka", "Poncokusumo", "Sumberejo", "Wonomulyo", "Wonorejo"],
                "Pujon": ["Bendosari", "Madiredo", "Ngabab", "Ngroto", "Pandesari", "Pujon Kidul", "Pujon Lor", "Sukomulyo", "Tawangsari", "Wiyurejo"],
                "Singosari": ["Ardimulyo", "Banjararum", "Baturetno", "Candirenggo", "Dengkol", "Gunungrejo", "Klampok", "Lang-Lang", "Losari", "Pagentan", "Purwoasri", "Randuagung", "Toyomarto", "Tunjungtirto", "Watugede", "Wonorejo"],
                "Sumbermanjing Wetan": ["Argotirto", "Druju", "Harjokuncaran", "Kedungbanteng", "Klepu", "Ringinkembar", "Ringinsari", "Sekarbanyu", "Sidoasri", "Sitiarjo", "Sumberagung", "Sumbermanjing Wetan", "Tambakasri", "Tambakrejo"],
                "Sumberpucung": ["Jatiguwi", "Karangkates", "Ngebruk", "Sambigede", "Senggreng", "Sumberpucung", "Ternyang"],
                "Tajinan": ["Gunungronggo", "Gunungsari", "Jambearjo", "Jatisari", "Ngawonggo", "Pandanmulyo", "Purwosekar", "Randugading", "Sumbersuko", "Tajinan", "Tangkilsari"],
                "Tirtoyudo": ["Ampelgading", "Gadungsari", "Jogomulyan", "Kepatihan", "Pujiharjo", "Purwodadi", "Sukorejo", "Sumbertangkil", "Tamankuncaran", "Tamansatriyan", "Tirtoyudo", "Tlogosari", "Wonoagung"],
                "Tumpang": ["Benjor", "Bokor", "Duwet", "Duwet Krajan", "Jeru", "Kambingan", "Kidal", "Malangsuko", "Ngingit", "Pandanajeng", "Pulungdowo", "Slamet", "Tulusbesar", "Tumpang", "Wringinsongo"],
                "Turen": ["Gedog Kulon", "Gedog Wetan", "Jeru", "Kedok", "Kemulan", "Pagedangan", "Sanankerto", "Sananrejo", "Sawahan", "Talok", "Talangsuko", "Tanggung", "Tawangrejeni", "Turen", "Undaan"],
                "Wagir": ["Dalisodo", "Gondowangi", "Jedong", "Mendalanwangi", "Pandanlandung", "Pandanrejo", "Parangargo", "Petungsewu", "Sitirejo", "Sukodadi", "Sumbersuko"],
                "Wajak": ["Bambang", "Blayu", "Bringin", "Codo", "Dadapan", "Kidangbang", "Ngembal", "Patokpicis", "Sukoanyar", "Sukolilo", "Wajak", "Wonoayu"],
                "Wonosari": ["Bangelan", "Kebobang", "Kluwut", "Plandi", "Plaosan", "Sumberdem", "Sumbertempur", "Wonosari"]
            }
        }
    };

    // Elements
    const citySelect = document.getElementById('selectCity');
    const districtSelect = document.getElementById('selectDistrict');
    const villageSelect = document.getElementById('selectVillage');
    const latInput = document.getElementById('customerLat');
    const lngInput = document.getElementById('customerLng');
    const coordsDisplay = document.getElementById('mapCoordsDisplay');
    const btnGps = document.getElementById('btnGpsDetect');

    const oldDistrict = "{{ old('customer_district', $formData['customer_district'] ?? '') }}";
    const oldVillage = "{{ old('customer_village', $formData['customer_village'] ?? '') }}";

    // Populate Districts based on City
    function populateDistricts(selectedCity, preselectedDistrict = '') {
        districtSelect.innerHTML = '<option value="">Pilih Kecamatan...</option>';
        villageSelect.innerHTML = '<option value="">Pilih Kelurahan/Desa...</option>';

        if (!selectedCity || !malangData[selectedCity]) return;

        const districts = Object.keys(malangData[selectedCity].districts).sort();
        districts.forEach(dist => {
            const opt = document.createElement('option');
            opt.value = dist;
            opt.textContent = dist;
            if (dist === preselectedDistrict) opt.selected = true;
            districtSelect.appendChild(opt);
        });

        if (preselectedDistrict) {
            populateVillages(selectedCity, preselectedDistrict, oldVillage);
        }
    }

    // Populate Villages based on District
    function populateVillages(selectedCity, selectedDistrict, preselectedVillage = '') {
        villageSelect.innerHTML = '<option value="">Pilih Kelurahan/Desa...</option>';

        if (!selectedCity || !selectedDistrict || !malangData[selectedCity] || !malangData[selectedCity].districts[selectedDistrict]) return;

        const villages = malangData[selectedCity].districts[selectedDistrict].slice().sort();
        villages.forEach(vil => {
            const opt = document.createElement('option');
            opt.value = vil;
            opt.textContent = vil;
            if (vil === preselectedVillage) opt.selected = true;
            villageSelect.appendChild(opt);
        });
    }

    // Event Listeners for Cascading
    citySelect.addEventListener('change', function () {
        populateDistricts(this.value);
        if (malangData[this.value] && map) {
            map.setView(malangData[this.value].center, malangData[this.value].zoom);
        }
    });

    districtSelect.addEventListener('change', function () {
        populateVillages(citySelect.value, this.value);
    });

    // Initial Population
    populateDistricts(citySelect.value, oldDistrict);

    // ===================== LEAFLET MAP INITIALIZATION =====================
    let initialLat = parseFloat(latInput.value) || -7.9826;
    let initialLng = parseFloat(lngInput.value) || 112.6308;

    const map = L.map('orderLocationMap', {
        zoomControl: true,
        scrollWheelZoom: false
    }).setView([initialLat, initialLng], 14);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '© OpenStreetMap'
    }).addTo(map);

    // Custom Marker Icon
    const customIcon = L.divIcon({
        className: 'custom-map-pin',
        html: `<div style="
            width: 32px;
            height: 32px;
            background: linear-gradient(135deg, #1E5FA8, #2575C0);
            border: 3px solid #fff;
            border-radius: 999px;
            box-shadow: 0 4px 14px rgba(30,95,168,0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 15px;
        "><i class="bi bi-geo-alt-fill"></i></div>`,
        iconSize: [32, 32],
        iconAnchor: [16, 32]
    });

    const marker = L.marker([initialLat, initialLng], {
        draggable: true,
        icon: customIcon
    }).addTo(map);

    function updateCoords(lat, lng) {
        latInput.value = lat.toFixed(6);
        lngInput.value = lng.toFixed(6);
        coordsDisplay.textContent = `Lat: ${lat.toFixed(5)}, Lng: ${lng.toFixed(5)}`;
    }

    updateCoords(initialLat, initialLng);

    // Marker Drag Event
    marker.on('dragend', function (e) {
        const position = marker.getLatLng();
        updateCoords(position.lat, position.lng);
    });

    // Map Click Event
    map.on('click', function (e) {
        marker.setLatLng(e.latlng);
        updateCoords(e.latlng.lat, e.latlng.lng);
    });

    // GPS Detect Button
    btnGps.addEventListener('click', function () {
        if (!navigator.geolocation) {
            alert('Browser Anda tidak mendukung deteksi lokasi (Geolocation).');
            return;
        }

        const originalText = btnGps.innerHTML;
        btnGps.disabled = true;
        btnGps.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Mendeteksi...';

        navigator.geolocation.getCurrentPosition(
            function (pos) {
                const lat = pos.coords.latitude;
                const lng = pos.coords.longitude;

                marker.setLatLng([lat, lng]);
                map.setView([lat, lng], 16);
                updateCoords(lat, lng);

                btnGps.disabled = false;
                btnGps.innerHTML = '<i class="bi bi-check2"></i> Lokasi Terdeteksi!';
                setTimeout(() => { btnGps.innerHTML = originalText; }, 2500);
            },
            function (err) {
                btnGps.disabled = false;
                btnGps.innerHTML = originalText;
                alert('Gagal mendeteksi lokasi otomatis. Silakan izinkan akses lokasi di browser atau geser pin manual pada peta.');
            },
            { enableHighAccuracy: true, timeout: 10000 }
        );
    });

    // Invalidate map size on tab/load
    setTimeout(() => { map.invalidateSize(); }, 300);
});
</script>
@endpush