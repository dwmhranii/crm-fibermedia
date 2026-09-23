@extends('public.layouts.public')

@section('content')
<style>
/* Modern Confirmation Page Styling */
.order-wrap {
    max-width: 860px;
    margin: 0 auto;
    padding: 1.5rem 1rem 3.5rem;
}

/* Stepper */
.order-steps {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 12px;
    margin-bottom: 2.2rem;
}

.order-step {
    display: flex;
    align-items: center;
    gap: 8px;
}

.order-step-badge {
    width: 38px;
    height: 38px;
    border-radius: 50%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 0.95rem;
    background: #f1f5f9;
    color: #64748b;
    border: 2px solid #cbd5e1;
    transition: all 0.3s ease;
}

.order-step.done .order-step-badge {
    background: #10b981;
    border-color: #10b981;
    color: #ffffff;
    box-shadow: 0 4px 12px rgba(16, 185, 129, 0.25);
}

.order-step.active .order-step-badge {
    background: linear-gradient(135deg, #1E5FA8, #2563eb);
    border-color: #1E5FA8;
    color: #ffffff;
    box-shadow: 0 4px 14px rgba(30, 95, 168, 0.35);
}

.order-step-text {
    font-size: 0.92rem;
    font-weight: 600;
    color: #64748b;
}

.order-step.active .order-step-text {
    color: #1E5FA8;
    font-weight: 700;
}

.order-step.done .order-step-text {
    color: #10b981;
}

.order-step-line {
    width: 44px;
    height: 3px;
    border-radius: 99px;
    background: #10b981;
}

/* Card Container */
.confirm-card {
    background: #ffffff;
    border: 1px solid rgba(226, 232, 240, 0.9);
    border-radius: 24px;
    padding: 2.25rem;
    box-shadow: 0 16px 40px -12px rgba(15, 23, 42, 0.08);
}

.confirm-header {
    text-align: center;
    margin-bottom: 1.8rem;
}

.confirm-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 0.35rem 0.9rem;
    border-radius: 999px;
    font-size: 0.82rem;
    font-weight: 700;
    background: rgba(30, 95, 168, 0.08);
    color: #1E5FA8;
    margin-bottom: 0.65rem;
}

.confirm-title {
    font-size: 1.85rem;
    font-weight: 800;
    color: #0f172a;
    letter-spacing: -0.02em;
    margin-bottom: 0.35rem;
}

.confirm-subtitle {
    color: #64748b;
    font-size: 0.95rem;
}

/* Package Banner Card */
.package-summary-card {
    background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
    border-radius: 20px;
    padding: 1.5rem;
    color: #ffffff;
    margin-bottom: 1.35rem;
    position: relative;
    overflow: hidden;
    box-shadow: 0 10px 25px -5px rgba(15, 23, 42, 0.2);
}

.package-summary-card::before {
    content: '';
    position: absolute;
    top: -50px;
    right: -50px;
    width: 150px;
    height: 150px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(56, 189, 248, 0.25) 0%, transparent 70%);
}

.package-summary-inner {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 1rem;
    position: relative;
    z-index: 1;
}

.pkg-type-tag {
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 0.08em;
    font-weight: 700;
    color: #38bdf8;
    margin-bottom: 0.25rem;
}

.pkg-name-text {
    font-size: 1.5rem;
    font-weight: 800;
    color: #ffffff;
    line-height: 1.2;
}

.pkg-speed-pill {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 0.3rem 0.75rem;
    border-radius: 999px;
    background: rgba(56, 189, 248, 0.15);
    border: 1px solid rgba(56, 189, 248, 0.3);
    color: #38bdf8;
    font-size: 0.85rem;
    font-weight: 700;
    margin-top: 0.5rem;
}

.pkg-price-box {
    text-align: right;
}

.pkg-price-val {
    font-size: 1.55rem;
    font-weight: 800;
    color: #4ade80;
    line-height: 1.1;
}

.pkg-price-unit {
    font-size: 0.82rem;
    color: #94a3b8;
}

/* Details Section Card */
.details-card {
    border: 1px solid #e2e8f0;
    border-radius: 18px;
    background: #f8fafc;
    padding: 1.35rem;
    margin-bottom: 1.35rem;
}

.details-card-header {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 0.95rem;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 1.1rem;
    padding-bottom: 0.65rem;
    border-bottom: 1px solid #e2e8f0;
}

.details-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1.1rem;
}

.detail-item {
    display: flex;
    flex-direction: column;
    gap: 4px;
}

.detail-item.full-width {
    grid-column: 1 / -1;
}

.detail-label {
    font-size: 0.8rem;
    font-weight: 600;
    color: #64748b;
    display: flex;
    align-items: center;
    gap: 5px;
}

.detail-val {
    font-size: 0.95rem;
    font-weight: 600;
    color: #0f172a;
}

/* Maps button */
.btn-maps-preview {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 0.4rem 0.85rem;
    border-radius: 10px;
    background: #eff6ff;
    border: 1px solid #bfdbfe;
    color: #1d4ed8;
    font-size: 0.85rem;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.2s ease;
    margin-top: 0.25rem;
    width: fit-content;
}

.btn-maps-preview:hover {
    background: #dbeafe;
    color: #1e40af;
    transform: translateY(-1px);
}

/* Notice box */
.order-notice {
    display: flex;
    align-items: flex-start;
    gap: 10px;
    background: #f0fdf4;
    border: 1px solid #bbf7d0;
    border-radius: 14px;
    padding: 0.9rem 1.1rem;
    margin-bottom: 1.5rem;
    font-size: 0.88rem;
    color: #166534;
}

/* Actions footer */
.order-actions {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
    flex-wrap: wrap;
}

.btn-back-action {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 0.75rem 1.4rem;
    border-radius: 14px;
    border: 1px solid #cbd5e1;
    background: #ffffff;
    color: #475569;
    font-weight: 600;
    font-size: 0.92rem;
    text-decoration: none;
    transition: all 0.2s ease;
}

.btn-back-action:hover {
    background: #f1f5f9;
    color: #0f172a;
    border-color: #94a3b8;
}

.btn-wa-submit {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 0.85rem 1.75rem;
    border-radius: 14px;
    background: linear-gradient(135deg, #25D366 0%, #128C7E 100%);
    color: #ffffff;
    border: none;
    font-weight: 700;
    font-size: 0.98rem;
    box-shadow: 0 8px 22px rgba(37, 211, 102, 0.35);
    cursor: pointer;
    transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
}

.btn-wa-submit:hover {
    transform: translateY(-2px);
    box-shadow: 0 12px 28px rgba(37, 211, 102, 0.45);
    color: #ffffff;
}

/* ===================== POPUP PREMIUM ===================== */
.order-popup {
    display: none;
}

.order-popup-backdrop {
    position: fixed;
    inset: 0;
    background: rgba(15, 23, 42, 0.6);
    backdrop-filter: blur(4px);
    z-index: 9998;
}

.order-popup-content {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%) scale(.85);
    width: min(92%, 400px);
    background: #fff;
    border-radius: 26px;
    padding: 2.2rem 1.6rem;
    text-align: center;
    z-index: 9999;
    box-shadow: 0 30px 80px rgba(0,0,0,.3);
    opacity: 0;
    transition: all .35s cubic-bezier(.22,1,.36,1);
}

.order-popup.show .order-popup-content {
    transform: translate(-50%, -50%) scale(1);
    opacity: 1;
}

.order-popup-check {
    width: 80px;
    height: 80px;
    border-radius: 999px;
    margin: 0 auto 1.2rem;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2.4rem;
    font-weight: 900;
    color: #fff;
    background: linear-gradient(135deg, #22c55e, #16a34a);
    box-shadow: 0 12px 30px rgba(34,197,94,.4);
}

.order-popup-title {
    font-size: 1.35rem;
    font-weight: 900;
    color: #0f172a;
    margin-bottom: .4rem;
}

.order-popup-text {
    font-size: .95rem;
    color: #64748b;
    line-height: 1.6;
    margin-bottom: 1rem;
}

.order-popup-loading {
    font-size: .85rem;
    color: #94a3b8;
}

.order-popup-close {
    position: absolute;
    top: 12px;
    right: 14px;
    width: 36px;
    height: 36px;
    border: none;
    background: #f8fafc;
    color: #94a3b8;
    border-radius: 999px;
    font-size: 22px;
    font-weight: 700;
    line-height: 1;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    transition: all .2s ease;
}

.order-popup-close:hover {
    background: #e2e8f0;
    color: #0f172a;
    transform: scale(1.08);
}

/* Dark Mode Styles */
body.dark-mode .confirm-card {
    background: #0f172a;
    border-color: rgba(255, 255, 255, 0.08);
    box-shadow: 0 20px 45px rgba(0, 0, 0, 0.6);
}

body.dark-mode .confirm-title {
    color: #f8fafc;
}

body.dark-mode .confirm-subtitle {
    color: #94a3b8;
}

body.dark-mode .confirm-badge {
    background: rgba(56, 189, 248, 0.15);
    color: #38bdf8;
}

body.dark-mode .package-summary-card {
    background: linear-gradient(135deg, #1e293b 0%, #0b1020 100%);
    border: 1px solid rgba(255, 255, 255, 0.1);
}

body.dark-mode .details-card {
    background: rgba(15, 23, 42, 0.7);
    border-color: rgba(255, 255, 255, 0.08);
}

body.dark-mode .details-card-header {
    color: #e2e8f0;
    border-bottom-color: rgba(255, 255, 255, 0.08);
}

body.dark-mode .detail-label {
    color: #94a3b8;
}

body.dark-mode .detail-val {
    color: #f1f5f9;
}

body.dark-mode .btn-maps-preview {
    background: rgba(30, 58, 138, 0.4);
    border-color: rgba(59, 130, 246, 0.4);
    color: #93c5fd;
}

body.dark-mode .btn-maps-preview:hover {
    background: rgba(30, 58, 138, 0.6);
    color: #bfdbfe;
}

body.dark-mode .order-notice {
    background: rgba(6, 78, 59, 0.3);
    border-color: rgba(16, 185, 129, 0.3);
    color: #6ee7b7;
}

body.dark-mode .btn-back-action {
    background: #1e293b;
    border-color: rgba(255, 255, 255, 0.12);
    color: #cbd5e1;
}

body.dark-mode .btn-back-action:hover {
    background: #334155;
    color: #ffffff;
}

body.dark-mode .order-step-badge {
    background: #1e293b;
    border-color: #334155;
    color: #94a3b8;
}

body.dark-mode .order-step.done .order-step-badge {
    background: #10b981;
    border-color: #10b981;
    color: #ffffff;
}

body.dark-mode .order-step.active .order-step-badge {
    background: linear-gradient(135deg, #1E5FA8, #2575C0);
    border-color: #38bdf8;
    color: #ffffff;
}

body.dark-mode .order-popup-content {
    background: #0f172a;
    border: 1px solid #1e293b;
    box-shadow: 0 30px 80px rgba(0,0,0,.8);
}

body.dark-mode .order-popup-title {
    color: #f8fafc;
}

body.dark-mode .order-popup-text {
    color: #cbd5e1;
}

body.dark-mode .order-popup-close {
    background: #1e293b;
    color: #94a3b8;
}

body.dark-mode .order-popup-close:hover {
    background: #334155;
    color: #fff;
}

@media (max-width: 640px) {
    .order-wrap {
        padding: 1rem 0.75rem 2.5rem;
    }

    .confirm-card {
        padding: 1.35rem;
        border-radius: 20px;
    }

    .details-grid {
        grid-template-columns: 1fr;
        gap: 0.85rem;
    }

    .package-summary-inner {
        flex-direction: column;
        align-items: flex-start;
    }

    .pkg-price-box {
        text-align: left;
    }

    .order-actions {
        flex-direction: column-reverse;
    }

    .order-actions .btn-back-action,
    .order-actions .btn-wa-submit {
        width: 100%;
    }

    .order-step-text {
        font-size: 0.82rem;
    }

    .order-step-line {
        width: 24px;
    }
}
</style>

<div class="order-wrap">
    {{-- Stepper Progress --}}
    <div class="order-steps">
        <div class="order-step done">
            <span class="order-step-badge"><i class="bi bi-check-lg"></i></span>
            <span class="order-step-text">Pilih Paket</span>
        </div>
        <div class="order-step-line"></div>
        <div class="order-step done">
            <span class="order-step-badge"><i class="bi bi-check-lg"></i></span>
            <span class="order-step-text">Isi Data</span>
        </div>
        <div class="order-step-line"></div>
        <div class="order-step active">
            <span class="order-step-badge">3</span>
            <span class="order-step-text">Konfirmasi</span>
        </div>
    </div>

    <div class="confirm-card">
        <div class="confirm-header">
            <span class="confirm-badge">
                <i class="bi bi-shield-check"></i> Langkah Terakhir
            </span>
            <h1 class="confirm-title">Konfirmasi Pesanan</h1>
            <p class="confirm-subtitle">Periksa kembali data paket dan alamat sebelum mengirim ke WhatsApp</p>
        </div>

        {{-- 1. Package Highlight Card --}}
        <div class="package-summary-card">
            <div class="package-summary-inner">
                <div>
                    <div class="pkg-type-tag">
                        <i class="bi bi-tag-fill me-1"></i> {{ $package->type === 'business' ? 'Paket Bisnis' : 'Paket Home Retail' }}
                    </div>
                    <div class="pkg-name-text">{{ $package->name }}</div>
                    <div class="pkg-speed-pill">
                        <i class="bi bi-speedometer2"></i> Speed Hingga {{ $package->speed_mbps }} Mbps
                    </div>
                </div>

                <div class="pkg-price-box">
                    <div class="pkg-price-unit">Biaya Berlangganan</div>
                    <div class="pkg-price-val">Rp {{ number_format((float) $package->price_monthly, 0, ',', '.') }}</div>
                    <div class="pkg-price-unit">/ bulan (Flat)</div>
                </div>
            </div>
        </div>

        {{-- 2. Customer & Address Details Card --}}
        <div class="details-card">
            <div class="details-card-header">
                <i class="bi bi-person-lines-fill text-primary"></i> Data Pelanggan &amp; Titik Pemasangan
            </div>

            <div class="details-grid">
                <div class="detail-item">
                    <span class="detail-label"><i class="bi bi-person"></i> Nama Lengkap</span>
                    <span class="detail-val">{{ $formData['customer_name'] }}</span>
                </div>

                <div class="detail-item">
                    <span class="detail-label"><i class="bi bi-whatsapp"></i> Nomor WhatsApp</span>
                    <span class="detail-val font-monospace">{{ $formData['customer_phone'] }}</span>
                </div>

                <div class="detail-item">
                    <span class="detail-label"><i class="bi bi-geo-alt"></i> Wilayah (Malang Raya)</span>
                    <span class="detail-val">
                        {{ $formData['customer_village'] ?? '-' }}, Kec. {{ $formData['customer_district'] ?? '-' }}, {{ $formData['customer_city'] ?? '-' }}
                    </span>
                </div>

                <div class="detail-item">
                    <span class="detail-label"><i class="bi bi-signpost-2"></i> RT / RW</span>
                    <span class="detail-val">
                        RT {{ $formData['customer_rt'] ?? '-' }} / RW {{ $formData['customer_rw'] ?? '-' }}
                    </span>
                </div>

                <div class="detail-item full-width">
                    <span class="detail-label"><i class="bi bi-house-door"></i> Detail Alamat / Patokan</span>
                    <span class="detail-val">{{ $formData['customer_street'] ?? ($formData['customer_address'] ?? '-') }}</span>
                </div>

                @if(!empty($formData['customer_lat']) && !empty($formData['customer_lng']))
                    <div class="detail-item full-width">
                        <span class="detail-label"><i class="bi bi-pin-map-fill text-danger"></i> Titik Koordinat Peta</span>
                        <div>
                            <a href="https://maps.google.com/?q={{ $formData['customer_lat'] }},{{ $formData['customer_lng'] }}" target="_blank" rel="noopener noreferrer" class="btn-maps-preview">
                                <i class="bi bi-google"></i> Buka Google Maps ({{ round($formData['customer_lat'], 4) }}, {{ round($formData['customer_lng'], 4) }})
                                <i class="bi bi-box-arrow-up-right ms-1 small"></i>
                            </a>
                        </div>
                    </div>
                @endif

                @if(!empty($formData['customer_note']))
                    <div class="detail-item full-width">
                        <span class="detail-label"><i class="bi bi-chat-left-text"></i> Catatan Tambahan</span>
                        <span class="detail-val text-muted fst-italic">{{ $formData['customer_note'] }}</span>
                    </div>
                @endif
            </div>
        </div>

        {{-- 3. Notice --}}
        <div class="order-notice">
            <i class="bi bi-info-circle-fill fs-5 flex-shrink-0"></i>
            <div>
                Setelah klik tombol di bawah, Anda akan diarahkan ke WhatsApp resmi FibermediaPlay dengan pesan pesanan terformat otomatis. Tim kami akan segera merespons untuk jadwal pemasangan.
            </div>
        </div>

        {{-- 4. Actions --}}
        <div class="order-actions">
            <a href="{{ route('public.order.step2') }}" class="btn-back-action">
                <i class="bi bi-arrow-left"></i> Ubah Data
            </a>

            <button type="button" class="btn-wa-submit" onclick="sendOrderToWhatsapp('{{ $whatsappUrl }}')">
                <i class="bi bi-whatsapp fs-5"></i> Kirim Pesanan ke WhatsApp
            </button>
        </div>
    </div>
</div>

<div id="orderSuccessPopup" class="order-popup">
    <div class="order-popup-backdrop" onclick="closeOrderPopup()"></div>

    <div class="order-popup-content">
        <button type="button" class="order-popup-close" onclick="closeOrderPopup()">×</button>

        <div class="order-popup-check">
            ✓
        </div>

        <div class="order-popup-title">
            Pesanan Berhasil 🎉
        </div>

        <div class="order-popup-text">
            Pesanan kamu sedang diproses oleh admin.<br>
            Tim kami akan segera menghubungi kamu via WhatsApp.
        </div>

        <div class="order-popup-loading">
            Silakan tunggu konfirmasi dari admin ya 🙂
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>

<script>
function sendOrderToWhatsapp(url) {
    const popup = document.getElementById('orderSuccessPopup');

    popup.style.display = 'block';

    setTimeout(() => {
        popup.classList.add('show');
    }, 50);

    confetti({
        particleCount: 120,
        spread: 70,
        origin: { y: 0.6 }
    });

    window.open(url, '_blank');

    setTimeout(() => {
        confetti({
            particleCount: 80,
            spread: 100,
            origin: { y: 0.7 }
        });
    }, 400);
}

function closeOrderPopup() {
    const popup = document.getElementById('orderSuccessPopup');

    popup.classList.remove('show');

    setTimeout(() => {
        popup.style.display = 'none';
        window.location.href = "{{ route('public.packages') }}";
    }, 300);
}
</script>
@endsection