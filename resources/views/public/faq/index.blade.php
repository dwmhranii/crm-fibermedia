@extends('public.layouts.public')

@php
    $faqCategoryLabels = [
        'general'      => 'Umum',
        'billing'      => 'Tagihan & Pembayaran',
        'technical'    => 'Gangguan Teknis',
        'installation' => 'Pemasangan',
        'coverage'     => 'Coverage Area',
        'package'      => 'Paket & Layanan',
    ];
@endphp

@push('styles')
<style>
    :root{
        --brand-blue:#003682;
        --brand-blue-soft:#0b63a8;
        --brand-green:#5bab23;
        --ink:#111827;
        --muted:#6b7280;
        --border:#e5e7eb;
    }

    .help-page{ padding: 1.25rem 0 3.5rem; }

    .help-kicker{
        font-size:.75rem;
        letter-spacing:.18em;
        text-transform:uppercase;
        color:var(--muted);
        font-weight:800;
        text-align:center;
        margin-bottom:.35rem;
    }
    .help-title{
        text-align:center;
        font-weight:900;
        font-size:2.2rem;
        color:var(--brand-blue);
        margin-bottom:.35rem;
    }
    .help-subtitle{
        text-align:center;
        color:var(--muted);
        font-size:.95rem;
        max-width:720px;
        margin:0 auto 1.4rem auto;
    }

    .help-search{
        max-width:720px;
        margin:0 auto 2rem auto;
    }
    .help-search .form-control{
        border-radius:999px;
        padding: .9rem 1.1rem .9rem 3rem;
        border:1px solid var(--border);
        box-shadow: 0 12px 30px rgba(15,23,42,.06);
    }
    .help-search-icon{
        position:absolute;
        left: 1.1rem;
        top: 50%;
        transform: translateY(-50%);
        color: var(--brand-blue-soft);
        font-size: 1.1rem;
    }

    .help-grid{ margin-top:.5rem; }

    .faq-list{
        position:relative;
        padding-left: 2.6rem;
    }
    .faq-list::before{
        content:"";
        position:absolute;
        left: 18px;
        top: 6px;
        bottom: 6px;
        width: 2px;
        background: linear-gradient(to bottom, rgba(0,54,130,.18), rgba(91,171,35,.18));
        border-radius: 999px;
    }

    .faq-item{
        position:relative;
        padding: 1rem 1rem 1rem 1.1rem;
        border: 1px solid var(--border);
        border-radius: 18px;
        background:#fff;
        box-shadow: 0 14px 35px rgba(15,23,42,.06);
        margin-bottom: 1rem;
        cursor:pointer;
        transition: transform .15s ease, box-shadow .15s ease;
    }
    .faq-item:hover{
        transform: translateY(-2px);
        box-shadow: 0 18px 45px rgba(15,23,42,.10);
    }

    .faq-dot{
        position:absolute;
        left: -2.6rem;
        top: 1.05rem;
        width: 34px;
        height: 34px;
        border-radius: 999px;
        background: linear-gradient(135deg, var(--brand-blue), var(--brand-green));
        color:#fff;
        display:flex;
        align-items:center;
        justify-content:center;
        font-weight:800;
        box-shadow: 0 14px 30px rgba(0,54,130,.25);
        font-size:.85rem;
    }

    .faq-q{
        font-weight:800;
        color: var(--ink);
        margin:0;
        font-size: 1rem;
    }

    .faq-category-badge{
        display:inline-flex;
        align-items:center;
        padding:.3rem .7rem;
        border-radius:999px;
        font-size:.76rem;
        font-weight:700;
        background:#f8fafc;
        color:#374151;
        border:1px solid #dbe3ee;
        line-height:1;
    }

    .faq-a{
        margin-top:.7rem;
        color:#4b5563;
        font-size:.92rem;
        display:none;
    }
    .faq-item.active .faq-a{ display:block; }

    .faq-item .faq-toggle{
        margin-left:auto;
        color: var(--brand-blue-soft);
        font-size:1.2rem;
        flex-shrink: 0;
    }

    .help-side-card{
        border-radius: 22px;
        padding: 1.4rem 1.4rem;
        background:
            radial-gradient(circle at top left, rgba(255,255,255,.18) 0, transparent 55%),
            linear-gradient(135deg, var(--brand-blue), var(--brand-blue-soft), var(--brand-green));
        color:#fff;
        box-shadow: 0 22px 55px rgba(0,54,130,.35);
        position: sticky;
        top: 90px;
    }
    .help-side-title{
        font-weight:900;
        font-size:1.2rem;
        margin-bottom:.4rem;
        text-transform:uppercase;
        letter-spacing:.04em;
    }
    .help-side-text{
        opacity:.95;
        font-size:.92rem;
        margin-bottom:1rem;
    }
    .help-side-btn{
        border-radius: 12px;
        font-weight:800;
        padding:.75rem 1rem;
        width:100%;
    }
    .help-side-meta{
        margin-top: .9rem;
        display:flex;
        gap:.5rem;
        flex-wrap:wrap;
    }
    .help-chip{
        background: rgba(15,23,42,.25);
        border: 1px solid rgba(255,255,255,.18);
        padding:.25rem .6rem;
        border-radius:999px;
        font-size:.78rem;
        display:inline-flex;
        gap:.35rem;
        align-items:center;
    }

    body.dark-mode .help-kicker{ color:#93c5fd; }
    body.dark-mode .help-title{ color:#bfdbfe; }
    body.dark-mode .help-subtitle{ color:#9ca3af; }
    body.dark-mode .help-search .form-control{
        background:#020617;
        border-color:#1f2937;
        color:#e5e7eb;
        box-shadow: 0 16px 40px rgba(0,0,0,.85);
    }
    body.dark-mode .help-search .form-control::placeholder{ color:#6b7280; }

    body.dark-mode .faq-item{
        background:#020617;
        border-color:#1f2937;
        box-shadow: 0 18px 45px rgba(0,0,0,.85);
    }
    body.dark-mode .faq-q{ color:#f9fafb; }
    body.dark-mode .faq-a{ color:#cbd5e1; }
    body.dark-mode .faq-toggle{ color:#93c5fd; }
    body.dark-mode .faq-category-badge{
        background:#0f172a;
        color:#e5e7eb;
        border-color:#334155;
    }

    @media (max-width: 991px){
        .help-side-card{ position: static; top:auto; }
        .faq-list{ padding-left: 2.2rem; }
        .faq-dot{ left: -2.2rem; }
    }
</style>
@endpush

@section('content')
<div class="help-page">
    <div class="help-kicker">FAQ QUESTIONS & ANSWERS</div>
    <h1 class="help-title">Bantuan & Pertanyaan Umum</h1>
    <p class="help-subtitle">
        Temukan jawaban cepat seputar layanan internet fiber FibermediaPlay. Kalau masih bingung, kamu bisa langsung hubungi tim kami.
    </p>

    <form method="GET" action="{{ route('public.faq') }}" class="help-search position-relative">
        <span class="help-search-icon"><i class="bi bi-search"></i></span>
        <input
            type="text"
            name="q"
            value="{{ $q ?? '' }}"
            class="form-control"
            placeholder="Cari pertanyaan… contoh: pemasangan, pembayaran, SLA">
    </form>

    <div class="row g-4 help-grid">
        <div class="col-lg-7">
            <div class="faq-list">
                @forelse($faqs as $i => $faq)
                    <div class="faq-item" data-faq>
                        <div class="faq-dot">
                            {{ method_exists($faqs, 'firstItem') ? $faqs->firstItem() + $i : $i + 1 }}
                        </div>

                        <div class="d-flex align-items-start gap-2">
                            <div class="flex-grow-1">
                                <p class="faq-q">{{ $faq->question }}</p>

                                @if(!empty($faq->category))
                                    <div class="mt-2 mb-1">
                                        <span class="faq-category-badge">
                                            {{ $faqCategoryLabels[$faq->category] ?? ucfirst(str_replace('_', ' ', $faq->category)) }}
                                        </span>
                                    </div>
                                @endif

                                <div class="faq-a">
                                    {!! nl2br(e($faq->answer)) !!}
                                </div>
                            </div>

                            <div class="faq-toggle">
                                <i class="bi bi-plus-circle-fill"></i>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="alert alert-warning border-0 shadow-sm">
                        Tidak ada FAQ yang cocok dengan pencarian kamu.
                    </div>
                @endforelse
            </div>

            @if(method_exists($faqs, 'links'))
                <div class="mt-3">
                    {{ $faqs->links() }}
                </div>
            @endif
        </div>

        <div class="col-lg-5">
            <div class="help-side-card">
                <div class="help-side-title">Anda masih memiliki pertanyaan?</div>
                <p class="help-side-text">
                    Jangan ragu untuk menghubungi kami. Tim kami siap membantu dari info paket sampai kendala teknis.
                </p>

                <a
                    href="https://wa.me/{{ $wa }}?text=Halo%20{{ urlencode($siteTitle ?? 'FibermediaPlay') }},%20saya%20butuh%20bantuan"
                    target="_blank"
                    class="btn btn-light help-side-btn">
                    <i class="bi bi-whatsapp me-2"></i> Kontak Kami
                </a>

                <div class="help-side-meta">
                    <span class="help-chip"><i class="bi bi-clock"></i> Respon cepat</span>
                    <span class="help-chip"><i class="bi bi-headset"></i> Support 24/7</span>
                    <span class="help-chip"><i class="bi bi-wifi"></i> Fiber Optic</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const items = document.querySelectorAll('[data-faq]');

    items.forEach((item) => {
        item.addEventListener('click', () => {
            const isActive = item.classList.contains('active');

            items.forEach(i => {
                i.classList.remove('active');
                const icon = i.querySelector('.faq-toggle i');
                if (icon) icon.className = 'bi bi-plus-circle-fill';
            });

            if (!isActive) {
                item.classList.add('active');
                const icon = item.querySelector('.faq-toggle i');
                if (icon) icon.className = 'bi bi-dash-circle-fill';
            }
        });
    });
});
</script>
@endpush