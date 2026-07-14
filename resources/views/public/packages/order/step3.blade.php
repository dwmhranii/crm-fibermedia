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
    background: #1d4ed8;
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

.summary-card {
    border: 1px solid #dbeafe;
    background: linear-gradient(135deg, #eff6ff, #f8fafc);
    border-radius: 20px;
    padding: 1.25rem;
    margin-bottom: 1rem;
}

.summary-title {
    font-weight: 800;
    color: #003682;
    margin-bottom: .9rem;
    font-size: 1rem;
}

.summary-row {
    display: grid;
    grid-template-columns: 180px 1fr;
    gap: 12px;
    padding: .45rem 0;
    border-bottom: 1px dashed #dbe3ef;
}

.summary-row:last-child {
    border-bottom: 0;
}

.summary-label {
    font-weight: 700;
    color: #334155;
}

.summary-value {
    color: #0f172a;
}

.order-footer {
    display: flex;
    justify-content: space-between;
    gap: 12px;
    margin-top: 2rem;
    flex-wrap: wrap;
}

.btn-order-back,
.btn-order-submit {
    border-radius: 16px;
    padding: 12px 22px;
    font-weight: 700;
}

.btn-order-submit {
    background: linear-gradient(135deg, #22c55e, #16a34a);
    border: 0;
    color: #fff;
    box-shadow: 0 12px 24px rgba(34, 197, 94, .22);
    transition: all .25s ease;
}

.btn-order-submit:hover {
    color: #fff;
    transform: translateY(-1px);
    box-shadow: 0 16px 28px rgba(34, 197, 94, .28);
}

/* ===================== POPUP PREMIUM ===================== */
.order-popup {
    display: none;
}

.order-popup-backdrop {
    position: fixed;
    inset: 0;
    background: rgba(15, 23, 42, 0.55);
    backdrop-filter: blur(4px);
    z-index: 9998;
}

.order-popup-content {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%) scale(.85);
    width: min(92%, 390px);
    background: #fff;
    border-radius: 26px;
    padding: 2rem 1.5rem;
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
    box-shadow: 0 12px 30px rgba(34,197,94,.5);
    animation: popCheck .5s ease;
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

/* CLOSE BUTTON */
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

/* ANIMATION */
@keyframes popCheck {
    0% { transform: scale(0); }
    70% { transform: scale(1.2); }
    100% { transform: scale(1); }
}

@media (max-width: 768px) {
    .order-title {
        font-size: 1.8rem;
    }

    .order-card {
        padding: 1.25rem;
    }

    .summary-row {
        grid-template-columns: 1fr;
        gap: 4px;
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

    .order-popup-content {
        padding: 1.8rem 1.15rem;
        border-radius: 22px;
    }

    .order-popup-check {
        width: 72px;
        height: 72px;
        font-size: 2.1rem;
    }

    .order-popup-title {
        font-size: 1.15rem;
    }

    .order-popup-close {
        top: 10px;
        right: 10px;
    }
}
</style>

<div class="order-wrap">
    <div class="order-steps">
        <div class="order-step done">
            <span class="order-step-badge">✓</span>
            <span class="order-step-text">Paket</span>
        </div>
        <div class="order-step-line"></div>
        <div class="order-step done">
            <span class="order-step-badge">✓</span>
            <span class="order-step-text">Data</span>
        </div>
        <div class="order-step-line"></div>
        <div class="order-step active">
            <span class="order-step-badge">3</span>
            <span class="order-step-text">Konfirmasi</span>
        </div>
    </div>

    <div class="order-card">
        <div class="order-header">
            <h1 class="order-title">Konfirmasi Pesanan</h1>
            <p class="order-subtitle">Pastikan data paket dan pelanggan sudah benar</p>
        </div>

        <div class="summary-card">
            <div class="summary-title">Data Paket</div>

            <div class="summary-row">
                <div class="summary-label">Nama Paket</div>
                <div class="summary-value">{{ $package->name }}</div>
            </div>

            <div class="summary-row">
                <div class="summary-label">Kecepatan</div>
                <div class="summary-value">{{ $package->speed_mbps }} Mbps</div>
            </div>

            <div class="summary-row">
                <div class="summary-label">Harga</div>
                <div class="summary-value">
                    Rp {{ number_format((float) $package->price_monthly, 0, ',', '.') }} / bulan
                </div>
            </div>

            <div class="summary-row">
                <div class="summary-label">Tipe</div>
                <div class="summary-value">{{ $package->type === 'business' ? 'Bisnis' : 'Home Retail' }}</div>
            </div>
        </div>

        <div class="summary-card">
            <div class="summary-title">Data Pelanggan</div>

            <div class="summary-row">
                <div class="summary-label">Nama Lengkap</div>
                <div class="summary-value">{{ $formData['customer_name'] }}</div>
            </div>

            <div class="summary-row">
                <div class="summary-label">Nomor HP/WhatsApp</div>
                <div class="summary-value">{{ $formData['customer_phone'] }}</div>
            </div>

            <div class="summary-row">
                <div class="summary-label">Alamat Lengkap</div>
                <div class="summary-value">{{ $formData['customer_address'] }}</div>
            </div>

            <div class="summary-row">
                <div class="summary-label">Catatan Tambahan</div>
                <div class="summary-value">{{ $formData['customer_note'] ?: '-' }}</div>
            </div>
        </div>

        <div class="order-footer">
            <a href="{{ route('public.order.step2') }}" class="btn btn-outline-secondary btn-order-back">
                Kembali Edit
            </a>

            <button type="button" class="btn btn-order-submit" onclick="sendOrderToWhatsapp('{{ $whatsappUrl }}')">
                Kirim Pesanan
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