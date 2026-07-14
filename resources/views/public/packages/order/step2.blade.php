@extends('public.layouts.public')

@section('content')
<style>
.order-wrap {
    max-width: 980px;
    margin: 0 auto;
    padding: 2rem 1rem 3rem;
}

.order-steps {
    display: flex;
    justify-content: center;
    align-items: flex-start;
    gap: 12px;
    margin-bottom: 2rem;
    flex-wrap: nowrap;
}

.order-step {
    display: flex;
    flex-direction: column;
    align-items: center;
    min-width: 64px;
    flex: 0 0 auto;
}

.order-step-badge {
    width: 50px;
    height: 50px;
    border-radius: 999px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border: 2px solid #cbd5e1;
    background: #fff;
    color: #475569;
    font-weight: 800;
    font-size: 20px;
    box-shadow: 0 8px 18px rgba(15, 23, 42, .08);
}

.order-step-text {
    margin-top: 12px;
    font-size: 15px;
    font-weight: 500;
    color: #64748b;
    text-align: center;
    line-height: 1.2;
}

.order-step-line {
    width: 84px;
    height: 4px;
    border-radius: 999px;
    background: #d1d5db;
    margin-top: 23px;
    flex: 0 0 auto;
}

.order-step.done .order-step-badge,
.order-step.active .order-step-badge {
    background: #1d4ed8;
    border-color: #1d4ed8;
    color: #fff;
}

.order-step.done .order-step-text,
.order-step.active .order-step-text {
    color: #1e3a8a;
    font-weight: 600;
}

.order-step-line.active {
    background: #1d4ed8;
}

.order-card {
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 24px;
    padding: 2rem;
    box-shadow: 0 12px 35px rgba(15, 23, 42, .06);
}

.order-header {
    text-align: center;
    margin-bottom: 2rem;
}

.order-title {
    font-size: 2.2rem;
    font-weight: 800;
    color: #0f172a;
    margin-bottom: .35rem;
}

.order-subtitle {
    color: #64748b;
    font-size: 1.05rem;
}

.order-package-box {
    border: 1px solid #dbeafe;
    background: linear-gradient(135deg, #eff6ff, #f0fdf4);
    border-radius: 18px;
    padding: 1rem 1.1rem;
    margin-bottom: 1.5rem;
}

.order-package-name {
    font-weight: 800;
    color: #003682;
    font-size: 1.1rem;
}

.order-package-meta {
    color: #475569;
    margin-top: .35rem;
}

.order-label {
    font-weight: 700;
    color: #1f2937;
    margin-bottom: .45rem;
    display: block;
}

.order-form .form-control,
.order-form textarea {
    border-radius: 14px;
    min-height: 52px;
    border-color: #cbd5e1;
    box-shadow: none;
}

.order-form .form-control:focus,
.order-form textarea:focus {
    border-color: rgba(29, 78, 216, .35);
    box-shadow: 0 0 0 0.16rem rgba(29, 78, 216, .08);
}

.order-form textarea {
    min-height: 120px;
    resize: vertical;
}

.order-footer {
    display: flex;
    justify-content: space-between;
    gap: 12px;
    margin-top: 2rem;
    flex-wrap: wrap;
}

.btn-order-back,
.btn-order-next {
    border-radius: 16px;
    padding: 12px 22px;
    font-weight: 700;
}

.btn-order-next {
    background: linear-gradient(135deg, #2563eb, #0891b2);
    border: 0;
    color: #fff;
}

.btn-order-next:hover {
    color: #fff;
}

@media (max-width: 768px) {
    .order-title {
        font-size: 1.8rem;
    }

    .order-card {
        padding: 1.25rem;
    }
}

@media (max-width: 576px) {
    .order-wrap {
        padding: 1.25rem .85rem 2rem;
    }

    .order-steps {
        gap: 8px;
        margin-bottom: 1.5rem;
    }

    .order-step {
        min-width: 52px;
    }

    .order-step-badge {
        width: 44px;
        height: 44px;
        font-size: 18px;
    }

    .order-step-text {
        font-size: 13px;
        margin-top: 8px;
    }

    .order-step-line {
        width: 38px;
        height: 3px;
        margin-top: 20px;
    }

    .order-title {
        font-size: 1.5rem;
    }

    .order-subtitle {
        font-size: .95rem;
    }

    .order-footer {
        flex-direction: column-reverse;
    }

    .order-footer .btn {
        width: 100%;
    }
}
</style>

<div class="order-wrap">
    <div class="order-steps">
        <div class="order-step done">
            <span class="order-step-badge">✓</span>
            <span class="order-step-text">Paket</span>
        </div>
        <div class="order-step-line active"></div>
        <div class="order-step active">
            <span class="order-step-badge">2</span>
            <span class="order-step-text">Data</span>
        </div>
        <div class="order-step-line"></div>
        <div class="order-step">
            <span class="order-step-badge">3</span>
            <span class="order-step-text">Konfirmasi</span>
        </div>
    </div>

    <div class="order-card">
        <div class="order-header">
            <h1 class="order-title">Data Pelanggan</h1>
            <p class="order-subtitle">Isi data diri Anda untuk proses pemasangan</p>
        </div>

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0 ps-3">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="order-package-box">
            <div class="order-package-name">{{ $package->name }}</div>
            <div class="order-package-meta">
                {{ $package->speed_mbps }} Mbps ·
                Rp {{ number_format((float) $package->price_monthly, 0, ',', '.') }} / bulan
            </div>
        </div>

        <form method="POST" action="{{ route('public.order.storeStep2') }}" class="order-form">
            @csrf

            <div class="row g-4">
                <div class="col-md-6">
                    <label class="order-label">Nama Lengkap *</label>
                    <input
                        type="text"
                        name="customer_name"
                        class="form-control"
                        value="{{ old('customer_name', $formData['customer_name'] ?? '') }}"
                        placeholder="Contoh: John Doe"
                        required
                    >
                </div>

                <div class="col-md-6">
                    <label class="order-label">Nomor HP/WhatsApp *</label>
                    <input
                        type="text"
                        name="customer_phone"
                        class="form-control"
                        value="{{ old('customer_phone', $formData['customer_phone'] ?? '') }}"
                        placeholder="Contoh: 081234567890"
                        required
                    >
                </div>

                <div class="col-12">
                    <label class="order-label">Alamat Lengkap *</label>
                    <textarea
                        name="customer_address"
                        class="form-control"
                        placeholder="Masukkan alamat lengkap untuk instalasi (jalan, RT/RW, kelurahan, kecamatan, kota)"
                        required
                    >{{ old('customer_address', $formData['customer_address'] ?? '') }}</textarea>
                </div>

                <div class="col-12">
                    <label class="order-label">Catatan Tambahan (Opsional)</label>
                    <textarea
                        name="customer_note"
                        class="form-control"
                        placeholder="Catatan khusus untuk tim instalasi atau pertanyaan tambahan"
                    >{{ old('customer_note', $formData['customer_note'] ?? '') }}</textarea>
                    <div class="text-muted small mt-2">
                        * Tim kami akan menghubungi Anda untuk konfirmasi jadwal instalasi
                    </div>
                </div>
            </div>

            <div class="order-footer">
                <a href="{{ route('public.packages') }}" class="btn btn-outline-secondary btn-order-back">
                    Kembali
                </a>

                <button type="submit" class="btn btn-order-next">
                    Next →
                </button>
            </div>
        </form>
    </div>
</div>
@endsection