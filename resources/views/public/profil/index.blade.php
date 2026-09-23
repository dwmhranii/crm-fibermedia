@extends('public.layouts.public')

@php
    // Safety
    $settings = $settings ?? [];
    $wa = $wa ?? preg_replace('/\D+/', '', ($settings['contact_whatsapp'] ?? '6281234567890'));
    $siteTitle = $siteTitle ?? (($settings['site_name'] ?? null) ?: 'FibermediaPlay');

    // Logo mini di card brand: pakai settings logo kalau ada
    $logoUrl = !empty($settings['logo'])
        ? asset('storage/' . ltrim($settings['logo'], '/'))
        : asset('assets/logo.png');

    $galleryItems = \Illuminate\Support\Collection::make($galleryItems ?? []);

    /**
     * Path hosting kamu:
     * public_html/storage/gallery/items
     *
     * Jadi kalau DB simpan:
     * - gallery/items/xxx.jpg -> jadi /storage/gallery/items/xxx.jpg
     * - storage/gallery/items/xxx.jpg -> pakai langsung
     * - uploads/... -> pakai langsung
     * - nama file saja -> anggap file ada di storage/gallery/items/
     */
    $photoUrl = function ($path) {
        if (!$path) {
            return null;
        }

        $path = trim((string) $path);

        if (\Illuminate\Support\Str::startsWith($path, ['http://', 'https://'])) {
            return $path;
        }

        $path = ltrim($path, '/');

        if (\Illuminate\Support\Str::startsWith($path, ['storage/', 'uploads/'])) {
            return asset($path);
        }

        if (\Illuminate\Support\Str::startsWith($path, ['gallery/items/', 'gallery/albums/', 'settings/'])) {
            return asset('storage/' . $path);
        }

        return asset('storage/gallery/items/' . $path);
    };

    $cards = \Illuminate\Support\Collection::make([]);

    foreach ($galleryItems->take(2) as $it) {
        $rawPath = $it->thumb_path ?: $it->file_path;
        $img = $photoUrl($rawPath);

        if (!$img) {
            continue;
        }

        $cards->push((object)[
            'img' => $img,
            'tag' => strtoupper($album->title ?? 'GALERI'),
            'title' => $it->title ?: ('Galeri ' . $siteTitle),
            'desc' => $it->caption ?: ('Dokumentasi layanan & aktivitas ' . $siteTitle . '.'),
        ]);
    }
@endphp

@push('styles')
<style>
    :root {
        --brand-blue: #1E5FA8;
        --brand-blue-soft: #2575C0;
        --brand-green: #5bab23;
    }

    .text-brand { color: var(--brand-blue); }

    /* ============= PAGE WRAPPER ============= */
    .profile-page { padding: 1rem 0 3.5rem; }

    /* ============= HERO ============= */
    .profile-hero-badge {
        display: inline-flex;
        align-items: center;
        gap: .35rem;
        font-size: .75rem;
        text-transform: uppercase;
        letter-spacing: .16em;
        padding: .35rem .8rem;
        border-radius: 999px;
        background: rgba(30, 95, 168, .08);
        color: var(--brand-blue);
        font-weight: 700;
        margin-bottom: .6rem;
    }

    .profile-hero-title {
        font-size: 2rem;
        font-weight: 800;
        color: #111827;
        margin-bottom: .4rem;
    }

    .profile-hero-title span { color: var(--brand-blue); }

    .profile-hero-text {
        font-size: .95rem;
        color: #4b5563;
        max-width: 640px;
        margin-bottom: 1.5rem;
    }

    .profile-hero-card {
        border-radius: 24px;
        padding: 1.4rem 1.6rem;
        background: linear-gradient(135deg, #f4f8ff, #e8f7ec);
        border: 1px solid #e5e7eb;
        box-shadow: 0 18px 45px rgba(15,23,42,0.10);
    }

    .profile-hero-card p {
        margin-bottom: .45rem;
        font-size: .9rem;
        color: #5e759dff;
    }

    .profile-hero-chip {
        display: inline-flex;
        align-items: center;
        gap: .35rem;
        padding: .25rem .65rem;
        border-radius: 999px;
        font-size: .8rem;
        background: rgba(30,95,168,.08);
        color: #5e759dff;
        margin: .1rem .25rem .1rem 0;
    }

    /* ============= VISI & MISI ============= */
    .profile-section-title {
        font-size: 1rem;
        font-weight: 800;
        color: #111827;
        margin-bottom: .5rem;
    }

    .profile-vision-card,
    .profile-mission-card {
        border-radius: 22px;
        padding: 1.4rem 1.6rem;
        border: 1px solid #e5e7eb;
        box-shadow: 0 18px 45px rgba(15,23,42,0.08);
        background: #ffffff;
        font-size: .9rem;
        color: #374151;
        height: 100%;
    }

    .profile-vision-card {
        background: radial-gradient(circle at top left, rgba(91,171,35,0.18) 0, transparent 45%), #ffffff;
    }

    .profile-mission-card {
        background: radial-gradient(circle at top left, rgba(30,95,168,0.16) 0, transparent 45%), #ffffff;
    }

    .profile-section-label {
        font-size: .8rem;
        text-transform: uppercase;
        letter-spacing: .16em;
        font-weight: 700;
        color: #6b7280;
        margin-bottom: .3rem;
    }

    .profile-section-heading {
        font-size: 1rem;
        font-weight: 700;
        color: var(--brand-blue);
        margin-bottom: .4rem;
    }

    .profile-vision-card ul,
    .profile-mission-card ul {
        padding-left: 1rem;
        margin-bottom: 0;
    }

    .profile-vision-card li,
    .profile-mission-card li { margin-bottom: .25rem; }

    /* ============= NILAI & LEGALITAS GRID ============= */
    .profile-values-section { margin-top: 2.5rem; }

    .profile-value-card {
        border-radius: 18px;
        padding: 1rem 1.1rem;
        border: 1px solid #e5e7eb;
        background: #ffffff;
        box-shadow: 0 14px 35px rgba(15,23,42,0.06);
        font-size: .88rem;
        height: 100%;
        display: flex;
        gap: .75rem;
    }

    .profile-value-icon {
        width: 34px;
        height: 34px;
        border-radius: 999px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
        color: #ffffff;
        background: linear-gradient(135deg, var(--brand-blue), var(--brand-green));
        box-shadow: 0 10px 20px rgba(30,95,168,0.28);
        flex-shrink: 0;
    }

    .profile-value-title {
        font-weight: 700;
        margin-bottom: .15rem;
        color: #111827;
    }

    .profile-value-text { margin-bottom: 0; color: #4b5563; }

    .profile-legal-card {
        border-radius: 22px;
        padding: 1.3rem 1.4rem;
        border: 1px solid #e5e7eb;
        background: #ffffff;
        box-shadow: 0 18px 45px rgba(15,23,42,0.08);
        font-size: .88rem;
        color: #374151;
        height: 100%;
    }

    .profile-legal-tagline {
        font-size: .86rem;
        color: #6b7280;
        margin-bottom: .4rem;
    }

    .profile-legal-badge {
        display: inline-flex;
        align-items: center;
        gap: .3rem;
        padding: .25rem .6rem;
        border-radius: 999px;
        font-size: .78rem;
        background: rgba(30,95,168,0.08);
        color: #111827;
        margin: .1rem .25rem .1rem 0;
    }

    /* ============= GALERI BRANDING ===== */
    .profile-gallery-section { margin-top: 3rem; margin-bottom: 3rem; }
    .profile-gallery-title {
        font-size: 1.4rem;
        font-weight: 800;
        color: #111827;
        margin-bottom: .4rem;
        text-align: center;
    }
    .profile-gallery-subtitle {
        font-size: .9rem;
        color: #6b7280;
        text-align: center;
        max-width: 520px;
        margin: 0 auto 1.7rem auto;
    }
    .profile-gallery-grid { row-gap: 1.5rem; }

    .profile-gallery-card {
        border-radius: 22px;
        overflow: hidden;
        position: relative;
        background-color: #020617;
        box-shadow: 0 18px 45px rgba(15,23,42,0.16);
        height: 100%;
    }
    .profile-gallery-img {
        width: 100%;
        height: 220px;
        object-fit: cover;
        display: block;
        transition: transform .35s ease, filter .35s ease;
    }
    .profile-gallery-card:hover .profile-gallery-img {
        transform: scale(1.05);
        filter: brightness(1.05);
    }
    .profile-gallery-overlay {
        position: absolute;
        inset: auto 0 0 0;
        padding: 14px 16px 16px;
        background-image: linear-gradient(to top, rgba(0,0,0,0.75) 0%, rgba(0,0,0,0.45) 55%, transparent 100%);
        color: #ffffff;
    }
    .profile-gallery-tag { font-size: .72rem; text-transform: uppercase; letter-spacing: .16em; opacity: .85; margin-bottom: .15rem; }
    .profile-gallery-caption { font-size: .95rem; font-weight: 700; margin-bottom: .1rem; }
    .profile-gallery-desc { font-size: .8rem; opacity: .9; margin-bottom: 0; }

    .profile-gallery-card-brand {
        background-image:
            radial-gradient(circle at top left, rgba(255,255,255,0.24) 0, transparent 55%),
            linear-gradient(135deg, var(--brand-blue), var(--brand-blue-soft), var(--brand-green));
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: left;
        padding: 20px 18px;
        color: #ffffff;
    }
    .profile-gallery-logo-mini { height: 40px; width: auto; display: block; margin-bottom: .6rem; }
    .profile-gallery-card-brand-title { font-size: 1.05rem; font-weight: 800; margin-bottom: .2rem; }
    .profile-gallery-card-brand-text { font-size: .86rem; opacity: .95; margin-bottom: .6rem; }
    .profile-gallery-pill {
        display: inline-flex;
        align-items: center;
        gap: .35rem;
        padding: .25rem .7rem;
        border-radius: 999px;
        background: rgba(15,23,42,0.3);
        font-size: .78rem;
    }

    /* ============= CTA BOTTOM ============= */
    .profile-cta-bar {
        margin-top: 1rem;
        border-radius: 26px;
        padding: 1.6rem 1.8rem;
        background-image:
            radial-gradient(circle at top left, rgba(255,255,255,0.18) 0, transparent 55%),
            linear-gradient(135deg, var(--brand-blue), var(--brand-blue-soft), var(--brand-green));
        color: #ffffff;
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        align-items: center;
        gap: 1rem;
        box-shadow: 0 24px 60px rgba(30,95,168,0.40);
    }
    .profile-cta-title { font-size: 1.3rem; font-weight: 800; margin-bottom: .2rem; }
    .profile-cta-text { font-size: .9rem; margin-bottom: 0; opacity: .96; }
    .profile-cta-btn {
        border-radius: 999px;
        font-weight: 600;
        padding-inline: 1.6rem;
        box-shadow: 0 16px 40px rgba(15,23,42,0.45);
    }

    /* ============= DARK MODE ============= */
    body.dark-mode .profile-hero-title { color: #f9fafb; }
    body.dark-mode .profile-hero-title span { color: #a5d6ff; }
    body.dark-mode .profile-hero-text { color: #d1d5db; }

    body.dark-mode .profile-hero-card {
        background: radial-gradient(circle at top left, rgba(15,118,110,0.4) 0, transparent 45%), #020617;
        border-color: #1e293b;
        box-shadow: 0 24px 60px rgba(0,0,0,.9);
    }

    body.dark-mode .profile-vision-card,
    body.dark-mode .profile-mission-card,
    body.dark-mode .profile-value-card,
    body.dark-mode .profile-legal-card {
        background: #020617;
        border-color: #1e293b;
        box-shadow: 0 22px 55px rgba(0,0,0,0.9);
        color: #e5e7eb;
    }

    body.dark-mode .profile-section-title,
    body.dark-mode .profile-value-title { color: #f9fafb; }

    body.dark-mode .profile-gallery-title { color: #f9fafb; }
    body.dark-mode .profile-gallery-subtitle { color: #9ca3af; }
    body.dark-mode .profile-gallery-card { box-shadow: 0 22px 55px rgba(0,0,0,0.9); }
    body.dark-mode .profile-cta-bar { box-shadow: 0 30px 80px rgba(0,0,0,1); }

    @media (max-width: 768px) {
        .profile-hero-title { font-size: 1.7rem; }
        .profile-cta-bar { padding: 1.3rem 1.4rem; }
    }

    /* DARK MODE EXTRA */
    body.dark-mode .profile-page {
        background:
            radial-gradient(circle at top left, rgba(59,130,246,0.16) 0, transparent 55%),
            radial-gradient(circle at bottom right, rgba(34,197,94,0.16) 0, transparent 55%);
        padding-left: 1.8rem;
        padding-right: 1.8rem;
    }

    body.dark-mode .profile-hero-badge { background: rgba(56,189,248,0.16); color: #e0f2fe; }
    body.dark-mode .profile-hero-card p { color: #cbd5f5; }
    body.dark-mode .profile-hero-chip { background: rgba(15,23,42,0.9); color: #e5e7eb; }
    body.dark-mode .profile-section-label { color: #94a3b8; }
    body.dark-mode .profile-section-heading { color: #bfdbfe; }
    body.dark-mode .profile-legal-tagline { color: #9ca3af; }
    body.dark-mode .profile-legal-badge { background: rgba(15,23,42,0.8); border-color: transparent; color: #e5e7eb; }
</style>
@endpush

@section('content')
<div class="profile-page">

    {{-- HERO + INTRO --}}
    <section class="mb-4">
        <div class="row g-4 align-items-start">
            <div class="col-lg-7">
                <div class="profile-hero-badge">
                    <i class="bi bi-building-check"></i> Tentang Perusahaan
                </div>
                <h1 class="profile-hero-title">
                    FibermediaPlay <span>Networks</span>
                </h1>
                <p class="profile-hero-text ">
                    PT Fibermedia Linktel Akses Indonesia adalah penyelenggara layanan internet berbasis
                    <strong>fiber optik</strong> yang berfokus menghadirkan koneksi stabil, jujur, dan mudah dijangkau
                    untuk rumah, pelaku usaha, hingga institusi di wilayah Malang Raya dan sekitarnya.
                </p>
                <p class="profile-hero-text mb-0">
                    Kami percaya internet bukan hanya soal kecepatan, tetapi juga pelayanan yang manusiawi,
                    transparansi paket, dan dukungan teknis yang sigap ketika pelanggan membutuhkan bantuan.
                </p>
            </div>

            <div class="col-lg-5">
                <div class="profile-hero-card">
                    <p><strong>Kenapa kami hadir?</strong></p>
                    <p>
                        Banyak pelanggan merasa bingung dengan paket internet yang rumit, harga tidak jelas,
                        dan support yang sulit dihubungi. FibermediaPlay ingin menjadi kebalikan dari itu.
                    </p>
                    <p class="mb-2">
                        Dengan infrastruktur fiber optik yang berkembang di Malang, kami berkomitmen menjadi
                        mitra digital yang dekat dengan pelanggan, dari pemasangan sampai after–sales.
                    </p>
                    <div class="mt-1">
                        <span class="profile-hero-chip">
                            <i class="bi bi-lightning-charge-fill"></i> 100% Jaringan Fiber
                        </span>
                        <span class="profile-hero-chip">
                            <i class="bi bi-emoji-smile"></i> Dukungan 24/7
                        </span>
                        <span class="profile-hero-chip">
                            <i class="bi bi-shield-check"></i> ISP Terdaftar
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- VISI & MISI --}}
    <section class="mb-4">
        <div class="row g-4">
            <div class="col-lg-6">
                <div class="profile-vision-card">
                    <div class="profile-section-label">VISI</div>
                    <div class="profile-section-heading">
                        Menjadi penyedia internet fiber pilihan utama di wilayah layanan kami
                    </div>
                    <ul>
                        <li>Menghadirkan pengalaman internet yang cepat, stabil, dan konsisten untuk setiap pelanggan.</li>
                        <li>Menjadi mitra digital yang terpercaya bagi rumah tangga, pelaku usaha, dan institusi.</li>
                        <li>Ber kontribusi pada perkembangan ekonomi digital di Indonesia melalui konektivitas yang andal.</li>
                    </ul>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="profile-mission-card">
                    <div class="profile-section-label">MISI</div>
                    <div class="profile-section-heading">
                        Menghubungkan lebih banyak orang dengan layanan yang jujur dan responsif
                    </div>
                    <ul>
                        <li>Menyediakan paket internet yang transparan, tanpa biaya tersembunyi, dan mudah dipahami.</li>
                        <li>Memberikan layanan purna jual yang responsif melalui perbaikan proaktif dan monitoring jaringan.</li>
                        <li>Membangun jaringan fiber yang kuat dan relevan dengan kebutuhan harian: WFH, hiburan digital, hingga bisnis online.</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    {{-- NILAI & LEGALITAS --}}
    <section class="profile-values-section">
        <div class="row g-4">
            {{-- Nilai --}}
            <div class="col-lg-7">
                <h2 class="profile-section-title">Nilai yang Kami Pegang</h2>
                <p class="profile-legal-tagline">
                    Nilai inti yang menjadi dasar dalam setiap layanan internet yang kami hadirkan.
                </p>

                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="profile-value-card">
                            <div class="profile-value-icon">
                                <i class="bi bi-wifi"></i>
                            </div>
                            <div>
                                <div class="profile-value-title">Koneksi Stabil &amp; Konsisten</div>
                                <p class="profile-value-text">
                                    Fokus kami bukan hanya kecepatan di awal, tetapi stabilitas koneksi harian
                                    untuk bekerja, belajar, dan hiburan.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="profile-value-card">
                            <div class="profile-value-icon">
                                <i class="bi bi-people-heart"></i>
                            </div>
                            <div>
                                <div class="profile-value-title">Pelayanan Manusiawi</div>
                                <p class="profile-value-text">
                                    Tim support yang ramah, mudah dihubungi, dan berusaha menyelesaikan masalah
                                    hingga tuntas, bukan sekadar tiket.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="profile-value-card">
                            <div class="profile-value-icon">
                                <i class="bi bi-receipt"></i>
                            </div>
                            <div>
                                <div class="profile-value-title">Transparansi Paket</div>
                                <p class="profile-value-text">
                                    Informasi paket dan harga disampaikan apa adanya, sehingga pelanggan tahu
                                    sejak awal apa yang mereka dapatkan.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="profile-value-card">
                            <div class="profile-value-icon">
                                <i class="bi bi-diagram-3"></i>
                            </div>
                            <div>
                                <div class="profile-value-title">Infrastruktur Terukur</div>
                                <p class="profile-value-text">
                                    Pembangunan jaringan dilakukan bertahap dengan perencanaan yang terukur
                                    agar kualitas layanan tetap terjaga.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Legalitas --}}
            <div class="col-lg-5">
                <h2 class="profile-section-title">Legalitas &amp; Penyelenggaraan</h2>
                <div class="profile-legal-card">
                    <p class="profile-legal-tagline">
                        Sebagai penyelenggara jasa internet, kami beroperasi dengan izin dan standar yang jelas.
                    </p>
                    <p class="mb-2">
                        PT Fibermedia Linktel Akses Indonesia terdaftar sebagai penyelenggara jaringan dan jasa
                        internet data berbasis fiber optic dengan jangkauan yang terus berkembang di wilayah Malang.
                    </p>
                    <p class="mb-2">
                        Setiap pengembangan jaringan dilakukan dengan memperhatikan regulasi dan standar teknis
                        yang berlaku, agar pelanggan mendapatkan layanan yang aman dan dapat diandalkan.
                    </p>
                    <div class="mt-2">
                        <span class="profile-legal-badge">
                            <i class="bi bi-file-earmark-check"></i> ISP Terdaftar
                        </span>
                        <span class="profile-legal-badge">
                            <i class="bi bi-fiber"></i> Infrastruktur Fiber Optik
                        </span>
                        <span class="profile-legal-badge">
                            <i class="bi bi-building"></i> Layanan Home &amp; Business
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- GALERI BRANDING (DINAMIS DARI DB) --}}
    <section class="profile-gallery-section">
        <div class="container px-0">
            <h2 class="profile-gallery-title">
                Galeri Branding <span class="text-brand">{{ $siteTitle }}</span>
            </h2>
            <p class="profile-gallery-subtitle">
                Sekilas suasana kantor, aktivitas tim, dan identitas visual yang kami bawa dalam setiap layanan
                internet fiber untuk pelanggan.
            </p>

            <div class="row profile-gallery-grid">
                {{-- 2 Card dari DB / fallback --}}
                @if($cards->count())
                    @foreach($cards as $card)
                        <div class="col-md-4">
                            <div class="profile-gallery-card">
                                <img src="{{ $card->img }}" alt="{{ $card->title }}" class="profile-gallery-img">
                                <div class="profile-gallery-overlay">
                                    <div class="profile-gallery-tag">{{ $card->tag }}</div>
                                    <div class="profile-gallery-caption">{{ $card->title }}</div>
                                    <p class="profile-gallery-desc">{{ $card->desc }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif

                {{-- Brand Card --}}
                <div class="col-md-4">
                    <div class="profile-gallery-card profile-gallery-card-brand">
                        <div>
                            <img src="{{ $logoUrl }}" alt="Logo {{ $siteTitle }}" class="profile-gallery-logo-mini">

                            <div class="profile-gallery-card-brand-title">
                                Identitas Visual &amp; Brand
                            </div>
                            <p class="profile-gallery-card-brand-text">
                                Warna <strong>biru</strong> dan <strong>hijau</strong> menggambarkan kestabilan jaringan,
                                kepercayaan, dan pertumbuhan. Logo kami hadir konsisten di seluruh touchpoint pelanggan.
                            </p>

                            <div class="profile-gallery-pill">
                                <i class="bi bi-palette"></i>
                                <span>#1E5FA8 · #5BAB23</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- CTA BOTTOM --}}
    <section>
        <div class="profile-cta-bar">
            <div>
                <div class="profile-cta-title">Siap beralih ke internet fiber yang lebih jujur?</div>
                <p class="profile-cta-text">
                    Konsultasikan kebutuhan rumah atau bisnis kamu dengan tim {{ $siteTitle }}.
                    Kami bantu pilihkan paket yang paling pas.
                </p>
            </div>
            <div>
                <a href="https://wa.me/{{ $wa }}?text={{ rawurlencode('Halo, saya ingin konsultasi paket internet '.$siteTitle) }}"
                   target="_blank"
                   class="btn btn-light profile-cta-btn">
                    Hubungi Tim Sales <i class="bi bi-arrow-up-right ms-1"></i>
                </a>
            </div>
        </div>
    </section>

</div>
@endsection