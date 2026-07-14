@php
    $recoAction = $recoAction ?? url()->current();
    $recommendedPackages = $recommendedPackages ?? collect();

    $hasRecoFilter =
        request()->filled('usage') ||
        request()->filled('users') ||
        request()->filled('extra');

    $hasRecoResult = false;
    if (is_object($recommendedPackages) && method_exists($recommendedPackages, 'count')) {
        $hasRecoResult = $recommendedPackages->count() > 0;
    } elseif (is_array($recommendedPackages)) {
        $hasRecoResult = count($recommendedPackages) > 0;
    }

    $waNumberReco = preg_replace('/[^0-9]/', '', $whatsApp ?? '6281234567890');
@endphp

@once
@push('styles')
<style>
/* ===================== REKOMENDASI WRAPPER ===================== */

.reco-wrapper {
    border-radius: 24px;

    background: linear-gradient(
        135deg,
        #c5d5e6 0%,
        #f7fbff 45%,
        #dfefd8 100%
    );

    background-size: 200% 200%;
    animation: recoGradient 14s ease infinite;

    border: 1px solid #e5e7eb;
}

@keyframes recoGradient {
    0% {background-position:0% 50%;}
    50% {background-position:100% 50%;}
    100% {background-position:0% 50%;}
}

.reco-kicker {
    font-size: .75rem;
    letter-spacing: .18em;
    text-transform: uppercase;
    color: #6b7280;
    font-weight: 700;
}

.reco-title {
    font-weight: 800;
    color: #003682;
}

.reco-lead {
    font-size: .9rem;
    color: #4b5563;
}

.btn-brand {
    background: linear-gradient(135deg, #003682, #5bab23);
    color: #fff;
    border: none;
    font-weight: 600;
    border-radius: 999px;
    box-shadow: 0 10px 25px rgba(0, 54, 130, .35);
}

.btn-brand:hover {
    filter: brightness(.96);
    color: #fff;
}

.text-brand {
    color: #003682;
}


/* ===================== HASIL REKOMENDASI SECTION ===================== */

.reco-pricing-section {
    padding-top: 2rem;
    padding-bottom: 2rem;

    position: relative;
    overflow: hidden;

    background: linear-gradient(
        135deg,
        #c5d5e6 0%,
        #f7fbff 45%,
        #dfefd8 100%
    );

    background-size: 200% 200%;
    animation: recoGradient 16s ease infinite;

    border-radius: 32px;
    border: 1px solid #e5e7eb;
    box-shadow: 0 18px 45px rgba(15, 23, 42, .08);
}

/* overlay glow supaya gradient lebih smooth */

.reco-pricing-section::before {
    content: "";
    position: absolute;
    inset: 0;

    background: radial-gradient(
        circle at top left,
        rgba(255,255,255,0.4),
        transparent 60%
    );

    pointer-events: none;
}


/* ===================== HEADER ===================== */

.reco-pricing-kicker {
    font-size: .8rem;
    font-weight: 700;
    letter-spacing: .18em;
    text-transform: uppercase;
    color: #5bab23;
}

.reco-pricing-title {
    font-size: 2.05rem;
    font-weight: 800;
    color: #111827;
    line-height: 1.2;
}

.reco-pricing-lead {
    font-size: .98rem;
    color: #4b5563;
    max-width: 380px;
}


/* ===================== FILTER SUMMARY ===================== */

.reco-filter-summary {
    border-radius: 18px;
    padding: 1rem 1.1rem;
    background: rgba(255,255,255,.72);
    border: 1px solid #dbe7f5;
}

.reco-filter-item {
    font-size: .88rem;
    color: #4b5563;
    margin-bottom: .35rem;
}

.reco-filter-item:last-child {
    margin-bottom: 0;
}

.reco-filter-item strong {
    color: #111827;
}


/* ===================== CARD GRID ===================== */

.reco-pricing-cards {
    display: grid;
    gap: 1.5rem;
}

@media (min-width: 992px) {

    .reco-pricing-cards {
        grid-template-columns: repeat(2, minmax(0,1fr));
    }

}


/* ===================== PACKAGE CARD ===================== */

.reco-package-card {

    border-radius: 26px;
    padding: 1.75rem 1.75rem 1.5rem;

    background: #ffffff;

    box-shadow: 0 18px 45px rgba(15,23,42,.10);
    border: 1px solid #e5e7eb;

    display: flex;
    flex-direction: column;
    height: 100%;

    position: relative;
    overflow: hidden;

    transition: transform .25s ease, box-shadow .25s ease;
}

/* hover effect */

.reco-package-card:hover{
    transform: translateY(-6px);
    box-shadow: 0 28px 60px rgba(15,23,42,.18);
}

/* top gradient line */

.reco-package-card::before {

    content:"";
    position:absolute;

    inset:0 0 auto 0;
    height:6px;

    border-radius:26px 26px 0 0;

    background:linear-gradient(
        90deg,
        #003682,
        #0b63a8,
        #5bab23
    );
}


/* ===================== BEST SELLER CARD ===================== */

.reco-package-card-best {

    color:#ffffff;
    border:none;

    box-shadow:0 26px 60px rgba(0,54,130,.45);

    background-image:
        radial-gradient(circle at top left, rgba(255,255,255,.22) 0, transparent 55%),
        linear-gradient(
            135deg,
            #003682 0%,
            #0b63a8 35%,
            #0f9150 75%,
            #5bab23 100%
        );
}

.reco-package-card-best-alt {

    background-image:
        radial-gradient(circle at top left, rgba(255,255,255,.22) 0, transparent 55%),
        linear-gradient(
            135deg,
            #5bab23 0%,
            #0f9150 35%,
            #0b63a8 75%,
            #003682 100%
        );
}


/* ===================== BADGE ===================== */

.reco-package-badge {

    position:absolute;
    top:1.4rem;
    right:1.6rem;

    font-size:.8rem;
    padding:.25rem .7rem;

    border-radius:999px;

    background-color:rgba(15,23,42,.08);
    color:#111827;

    font-weight:600;
}

.reco-package-card-best .reco-package-badge{
    background-color:rgba(15,23,42,.22);
    color:#fefce8;
}


/* ===================== PACKAGE INFO ===================== */

.reco-package-name{
    font-size:1.1rem;
    font-weight:700;
    margin-bottom:.25rem;
}

.reco-package-speed{
    font-size:.92rem;
    font-weight:600;
    color:#6b7280;
    margin-bottom:1rem;
}

.reco-package-card-best .reco-package-speed{
    color:#e5e7eb;
}

.reco-package-speed strong{
    color:#111827;
}

.reco-package-card-best .reco-package-speed strong{
    color:#ffffff;
}


/* ===================== PRICE ===================== */

.reco-package-price{
    font-size:2rem;
    font-weight:800;
    margin-bottom:.1rem;
}

.reco-package-price span{
    font-size:.9rem;
    font-weight:500;
}

.reco-package-sub{
    font-size:.78rem;
    opacity:.88;
    margin-bottom:1rem;
}

.reco-package-card-best .reco-package-sub{
    color:#fef9c3;
}


/* ===================== FEATURES ===================== */

.reco-package-features{
    list-style:none;
    padding:0;
    margin:0 0 1.25rem;
    font-size:.88rem;
}

.reco-package-features li{
    display:flex;
    align-items:flex-start;
    gap:.45rem;
    margin-bottom:.4rem;
}

.reco-package-feature-icon{
    color:#22c55e;
    margin-top:.15rem;
    font-size:.9rem;
}

.reco-package-card-best .reco-package-feature-icon{
    color:#bbf7d0;
}

.reco-package-feature-text{
    color:#4b5563;
}

.reco-package-card-best .reco-package-feature-text{
    color:#fefce8;
}


/* ===================== BUTTON ===================== */

.reco-package-btn{
    border-radius:999px;
    font-weight:700;
}

.reco-package-note{
    font-size:.8rem;
    color:#6b7280;
    margin-top:.35rem;
}

.reco-package-card-best .reco-package-note{
    color:#fefce8;
    opacity:.9;
}


/* ===================== DARK MODE ===================== */

body.dark-mode .reco-wrapper{

    background:linear-gradient(
        135deg,
        #021021,
        #02260e
    );

    border-color:#1f2937;
}

body.dark-mode .reco-pricing-section{

    background:#020617;

    border-color:#1f2937;
}

body.dark-mode .reco-package-card{

    background:#020617;
    border-color:#1e293b;

    box-shadow:0 18px 45px rgba(0,0,0,.7);
}

body.dark-mode .reco-package-name{
    color:#f9fafb;
}

body.dark-mode .reco-package-speed{
    color:#9ca3af;
}

body.dark-mode .reco-package-speed strong{
    color:#e5e7eb;
}

body.dark-mode .reco-package-feature-text{
    color:#e5e7eb;
}

body.dark-mode .reco-package-note{
    color:#9ca3af;
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const overlay = document.getElementById('recoOverlay');
    if (!overlay) return;

    const close = () => overlay.remove();

    document.getElementById('recoToastClose')?.addEventListener('click', close);

    overlay.addEventListener('click', e => {
        if (e.target === overlay) close();
    });

    document.addEventListener('keydown', e => {
        if (e.key === 'Escape') close();
    });

    document.getElementById('recoToastRetry')?.addEventListener('click', () => {
        close();
        location.hash = '#rekomendasi';
        setTimeout(() => {
            document.querySelector('select[name="usage"]')?.focus();
        }, 200);
    });
});
</script>
@endpush
@endonce

<section id="rekomendasi" class="py-5">
    <div class="container">

        <div class="reco-wrapper shadow-sm rounded-4 p-4 p-md-5 mb-4">
            <div class="row g-4 align-items-center">
                <div class="col-lg-4">
                    <p class="reco-kicker mb-1">REKOMENDASI PAKET</p>
                    <h2 class="reco-title mb-2">Bingung pilih paket?</h2>
                    <p class="reco-lead mb-0">
                        Jawab beberapa pertanyaan singkat, dan kami akan merekomendasikan paket
                        FibermediaPlay yang paling sesuai dengan kebutuhanmu.
                    </p>
                </div>

                <div class="col-lg-8">
                    <form method="GET" action="{{ $recoAction }}#rekomendasi" class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label small mb-1 fw-semibold">Kebutuhan utama</label>
                            <select name="usage" class="form-select form-select-sm">
                                <option value="">Pilih...</option>
                                <option value="browsing"  {{ request('usage') == 'browsing'  ? 'selected' : '' }}>Browsing & Sosmed</option>
                                <option value="streaming" {{ request('usage') == 'streaming' ? 'selected' : '' }}>Streaming Film / YouTube</option>
                                <option value="gaming"    {{ request('usage') == 'gaming'    ? 'selected' : '' }}>Gaming Online</option>
                                <option value="wfh"       {{ request('usage') == 'wfh'       ? 'selected' : '' }}>WFH / Meeting Online</option>
                                <option value="tv"        {{ request('usage') == 'tv'        ? 'selected' : '' }}>Butuh TV Channel</option>
                                <option value="kuota_hp"  {{ request('usage') == 'kuota_hp'  ? 'selected' : '' }}>Internet + Kuota HP</option>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label small mb-1 fw-semibold">Jumlah pengguna di rumah</label>
                            <select name="users" class="form-select form-select-sm">
                                <option value="">Pilih...</option>
                                <option value="1-2"   {{ request('users') == '1-2'   ? 'selected' : '' }}>1–2 orang</option>
                                <option value="3-4"   {{ request('users') == '3-4'   ? 'selected' : '' }}>3–4 orang</option>
                                <option value="5-7"   {{ request('users') == '5-7'   ? 'selected' : '' }}>5–7 orang</option>
                                <option value="8plus" {{ request('users') == '8plus' ? 'selected' : '' }}>8+ orang / banyak device</option>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label small mb-1 fw-semibold">Tambahan yang diinginkan</label>
                            <select name="extra" class="form-select form-select-sm">
                                <option value="">Tidak ada</option>
                                <option value="tv"        {{ request('extra') == 'tv'        ? 'selected' : '' }}>TV Channel</option>
                                <option value="streaming" {{ request('extra') == 'streaming' ? 'selected' : '' }}>Aplikasi Streaming</option>
                                <option value="kuota_hp"  {{ request('extra') == 'kuota_hp'  ? 'selected' : '' }}>Kuota HP</option>
                            </select>
                        </div>

                        <div class="col-md-1 d-flex align-items-end">
                            <button type="submit" class="btn btn-brand w-100">Cari</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- HASIL REKOMENDASI --}}
        @if($hasRecoResult)
            <div class="reco-pricing-section p-4 p-lg-5">
                <div class="row g-4 align-items-start">
                    <div class="col-lg-4">
                        <div class="mb-3">
                            <div class="reco-pricing-kicker">HASIL REKOMENDASI</div>
                            <h3 class="reco-pricing-title mt-2">
                                Paket yang cocok untuk kebutuhanmu
                            </h3>
                        </div>

                        <p class="reco-pricing-lead mb-3">
                            Berdasarkan pilihanmu, berikut paket yang paling relevan untuk dipilih sekarang.
                        </p>

                        <div class="reco-filter-summary">
                            <div class="reco-filter-item">
                                <strong>Kebutuhan:</strong>
                                {{ request('usage') ? ucfirst(str_replace('_', ' ', request('usage'))) : '-' }}
                            </div>
                            <div class="reco-filter-item">
                                <strong>Pengguna:</strong>
                                {{ request('users') ?: '-' }}
                            </div>
                            <div class="reco-filter-item">
                                <strong>Tambahan:</strong>
                                {{ request('extra') ? ucfirst(str_replace('_', ' ', request('extra'))) : 'Tidak ada' }}
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-8">
                        <div class="reco-pricing-cards">
                            @foreach($recommendedPackages as $pkg)
                                @php
                                    $isBest = (int) ($pkg->is_best_seller ?? 0) === 1;
                                    $cardClass = $isBest ? 'reco-package-card reco-package-card-best' : 'reco-package-card';

                                    if ($isBest && $loop->first) {
                                        $cardClass .= ' reco-package-card-best-alt';
                                    }

                                    $features = collect(preg_split("/\r\n|\n|\r/", $pkg->features ?? ''))
                                        ->map(fn($item) => trim($item))
                                        ->filter()
                                        ->take(6);
                                @endphp

                                <div class="{{ $cardClass }}">
                                    @if($isBest)
                                        <span class="reco-package-badge">Best Seller</span>
                                    @endif

                                    <div class="mb-2">
                                        <div class="reco-package-name">{{ $pkg->name }}</div>
                                        <div class="reco-package-speed">
                                            Speed up to <strong>{{ $pkg->speed_mbps }} Mbps</strong>
                                        </div>
                                    </div>

                                    <div class="mb-2">
                                        <div class="reco-package-price">
                                            Rp {{ number_format($pkg->price_monthly, 0, ',', '.') }}
                                            <span>/bulan</span>
                                        </div>
                                        <div class="reco-package-sub">
                                            {{ $pkg->short_description ?: 'Rekomendasi paket sesuai kebutuhan penggunaanmu.' }}
                                        </div>
                                    </div>

                                    @if($features->count())
                                        <ul class="reco-package-features">
                                            @foreach($features as $feature)
                                                <li>
                                                    <span class="reco-package-feature-icon">
                                                        <i class="bi bi-check2"></i>
                                                    </span>
                                                    <span class="reco-package-feature-text">{{ $feature }}</span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif

                                    <div class="mt-auto">
                                        @if($pkg->whatsapp_order_url)
                                            <a href="{{ $pkg->whatsapp_order_url }}"
                                               target="_blank"
                                               class="btn reco-package-btn w-100 {{ $isBest ? 'btn-light text-dark' : 'btn-primary text-white' }}">
                                                {{ $isBest ? 'Berlangganan Sekarang' : 'Pilih Paket Ini' }}
                                            </a>
                                        @else
                                            <a href="https://wa.me/{{ $waNumberReco }}?text={{ urlencode('Halo CS, saya tertarik dengan paket ' . $pkg->name) }}"
                                               target="_blank"
                                               class="btn reco-package-btn w-100 {{ $isBest ? 'btn-light text-dark' : 'btn-success text-white' }}">
                                                Hubungi Customer Service
                                            </a>
                                        @endif

                                        <div class="reco-package-note">
                                            *Rekomendasi ini disesuaikan dengan filter pilihanmu
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @endif

    </div>
</section>

{{-- POPUP: FILTER ADA TAPI HASIL KOSONG --}}
@if($hasRecoFilter && !$hasRecoResult)
<div id="recoOverlay" class="reco-overlay" role="dialog" aria-modal="true">
    <div class="reco-toast">
        <div class="reco-toast-inner">
            <div class="reco-toast-icon">
                <i class="bi bi-stars"></i>
            </div>

            <div class="reco-toast-content">
                <div class="reco-toast-title">Belum ada paket yang cocok 😅</div>
                <div class="reco-toast-text">
                    Coba longgarkan pilihan, atau chat tim kami biar dibantu rekomendasi paket terbaik.
                </div>

                <div class="reco-toast-actions">
                    <a class="reco-toast-btn"
                       target="_blank"
                       href="https://wa.me/{{ $waNumberReco }}?text={{ urlencode('Halo FibermediaPlay, saya butuh rekomendasi paket. Kebutuhan: ' . request('usage') . ' - Pengguna: ' . request('users') . ' - Tambahan: ' . request('extra')) }}">
                        Konsultasi WhatsApp
                    </a>

                    <button type="button" class="reco-toast-btn-outline" id="recoToastRetry">
                        Ubah Pilihan
                    </button>
                </div>
            </div>

            <button type="button" class="reco-toast-close" id="recoToastClose" aria-label="Tutup">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
    </div>
</div>
@endif