@extends('public.layouts.public')

@push('styles')
<style>
    /* ===================== GLOBAL ANIMATION ===================== */
    @keyframes sectionGradientFlow {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }

    @keyframes recoToastIn {
        from {
            opacity: 0;
            transform: scale(.95) translateY(10px);
        }
        to {
            opacity: 1;
            transform: scale(1) translateY(0);
        }
    }

    @keyframes softFloat {
        0% { transform: translateY(0); }
        50% { transform: translateY(-4px); }
        100% { transform: translateY(0); }
    }

    /* ===================== LAYANAN UTAMA ===================== */
    .service-section-title {
        font-weight: 700;
    }

    .service-card {
        border-radius: 20px;
        border: none;
        box-shadow: 0 18px 40px rgba(15,23,42,0.08);
        transition: transform .2s ease, box-shadow .2s ease;
        background: #ffffff;
    }

    .service-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 24px 55px rgba(15,23,42,0.18);
    }

    .service-icon-wrapper {
        width: 90px;
        height: 90px;
        border-radius: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 14px auto;
        color: #ffffff;
        font-size: 2rem;
        box-shadow: 0 12px 25px rgba(30, 95, 168, 0.30);
    }

    .service-icon-1 {
        background: linear-gradient(135deg, #1E5FA8, #2575C0);
    }
    .service-icon-2 {
        background: linear-gradient(135deg, #2575C0, #5bab23);
    }
    .service-icon-3 {
        background: linear-gradient(135deg, #0095b3, #5bab23);
    }
    .service-icon-4 {
        background: linear-gradient(135deg, #115e59, #5bab23);
    }

    .service-card-title {
        font-weight: 700;
        font-size: 1.05rem;
    }

    .service-card-text {
        font-size: .9rem;
        color: #6b7280;
    }

    /* ===================== DEDICATED INTERNET / PR SERVICES ===================== */
    .dedicated-title {
        font-weight: 700;
        font-size: 2rem;
        color: #1E5FA8;
    }

    .dedicated-body p {
        font-size: .95rem;
        line-height: 1.8;
        color: #4b5563;
        margin-bottom: .6rem;
    }

    .btn-gradient-primary {
        background: linear-gradient(135deg, #1E5FA8, #5bab23);
        border: none;
        color: #ffffff;
        font-weight: 700;
        padding-inline: 2.4rem;
        border-radius: 999px;
        box-shadow: 0 12px 30px rgba(30,95,168,0.30);
    }

    .btn-gradient-primary:hover {
        filter: brightness(0.95);
        color: #ffffff;
        transform: translateY(-1px);
    }

    .dedicated-link {
        font-weight: 500;
        text-decoration: underline;
        color: #1E5FA8;
    }

    .dedicated-link:hover {
        color: #2575C0;
    }

    .feature-small {
        display: flex;
        gap: 12px;
        margin-bottom: 1.5rem;
    }

    .feature-small-icon {
        width: 42px;
        height: 42px;
        border-radius: 999px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.4rem;
        color: #ffffff;
    }

    .feature-small-icon.icon-1 {
        background: linear-gradient(135deg, #22c55e, #5bab23);
    }
    .feature-small-icon.icon-2 {
        background: linear-gradient(135deg, #1E5FA8, #2575C0);
    }
    .feature-small-icon.icon-3 {
        background: linear-gradient(135deg, #2575C0, #5bab23);
    }
    .feature-small-icon.icon-4 {
        background: linear-gradient(135deg, #0095b3, #5bab23);
    }

    .feature-small-title {
        font-weight: 700;
        margin-bottom: .1rem;
    }

    .feature-small-text {
        font-size: .9rem;
        color: #4b5563;
        margin-bottom: 0;
    }

    /* ===================== DARK MODE BASE UNTUK SECTION ATAS ===================== */
    body.dark-mode .service-card {
        background: #020617;
        box-shadow: 0 18px 40px rgba(0,0,0,0.7);
    }

    body.dark-mode .service-card-text {
        color: #9ca3af;
    }

    body.dark-mode .dedicated-title {
        color: #e5f3ff;
    }

    body.dark-mode .dedicated-body p,
    body.dark-mode .feature-small-text {
        color: #9ca3af;
    }

    body.dark-mode .dedicated-link {
        color: #93c5fd;
    }

    body.dark-mode .dedicated-link:hover {
        color: #60a5fa;
    }

    body.dark-mode .btn-gradient-primary {
        box-shadow: 0 16px 40px rgba(0,0,0,0.9);
    }

    /* ===================== ICON CARDS (CATEGORY STRIP) ===================== */
    .category-strip {
        padding-top: 1rem;
        padding-bottom: 2rem;
    }

    .category-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 16px;
    }

    @media (min-width: 576px) {
        .category-grid {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }
    }

    @media (min-width: 992px) {
        .category-grid {
            grid-template-columns: repeat(6, minmax(0, 1fr));
        }
    }

    .category-item {
        text-align: center;
        cursor: pointer;
        transition: transform .18s ease, box-shadow .18s ease, background .18s ease;
        border-radius: 18px;
        padding: 14px 10px;
    }

    .category-item:hover {
        background: #f1f5f9;
        transform: translateY(-3px);
        box-shadow: 0 12px 25px rgba(15,23,42,0.10);
    }

    .category-icon {
        width: 56px;
        height: 56px;
        border-radius: 18px;
        margin: 0 auto 8px auto;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #ffffff;
        background: linear-gradient(135deg, #1E5FA8, #5bab23);
        font-size: 1.7rem;
        box-shadow: 0 10px 20px rgba(30, 95, 168, 0.25);
    }

    .category-label,
    .category-item .category-label,
    a.text-decoration-none .category-label {
        font-size: 0.92rem;
        font-weight: 600;
        color: #111827 !important;
        transition: color .18s ease;
    }

    .category-item:hover .category-label {
        color: #000000 !important;
    }

    body.dark-mode .category-item:hover {
        background: #1e293b;
        box-shadow: 0 15px 35px rgba(0,0,0,0.8);
    }

    body.dark-mode .category-label,
    body.dark-mode .category-item .category-label,
    body.dark-mode a.text-decoration-none .category-label {
        color: #f8fafc !important;
    }

    /* ===================== BANNER CARA BERLANGGANAN ===================== */
    .fm-steps-banner {
        position: relative;
        border-radius: 32px;
        background-image:
            radial-gradient(circle at top left,
                rgba(255,255,255,0.22) 0,
                transparent 55%),
            linear-gradient(135deg,
                #1E5FA8 0%,
                #2575C0 35%,
                #0f9150 75%,
                #5bab23 100%);
        color: #ffffff;
        overflow: hidden;
    }

    .fm-steps-banner::before,
    .fm-steps-banner::after {
        content: "";
        position: absolute;
        top: 0;
        bottom: 0;
        width: 180px;
        opacity: 0.16;
        background-image:
            linear-gradient(
                135deg,
                rgba(255,255,255,0.45) 25%,
                transparent 25%,
                transparent 50%,
                rgba(255,255,255,0.45) 50%,
                rgba(255,255,255,0.45) 75%,
                transparent 75%,
                transparent
            );
        background-size: 40px 40px;
    }

    .fm-steps-banner::before {
        left: 0;
    }

    .fm-steps-banner::after {
        right: 0;
        transform: scaleX(-1);
    }

    .fm-steps-title {
        font-weight: 700;
    }

    .fm-steps-subtitle {
        opacity: .9;
    }

    .fm-step-item {
        position: relative;
        z-index: 2;
    }

    .fm-step-badge {
        width: 56px;
        height: 56px;
        border-radius: 999px;
        margin: 0 auto 10px auto;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(255,255,255,0.20);
        border: 2px solid rgba(255,255,255,0.6);
        color: #ffffff;
        font-size: 1.6rem;
    }

    .fm-step-title {
        font-weight: 700;
        margin-bottom: .35rem;
    }

    .fm-step-text {
        font-size: .9rem;
        opacity: .95;
    }

    .fm-step-btn {
        background: #ffffff;
        color: #1E5FA8;
        border-radius: 999px;
        font-size: .85rem;
        font-weight: 600;
        padding-inline: 1.6rem;
        box-shadow: 0 10px 25px rgba(15,23,42,0.25);
    }

    .fm-step-btn:hover {
        background: #e5f0ff;
        color: #16467d;
    }

    body.dark-mode .fm-steps-banner {
        box-shadow: 0 24px 60px rgba(0,0,0,0.9);
    }

    /* ===================== PRICING SECTION ===================== */
    .pricing-section {
        padding-top: 2rem;
        padding-bottom: 3rem;
        position: relative;
        overflow: hidden;
        background: linear-gradient(
            135deg,
            #c5d5e6 0%,
            #f7fbff 45%,
            #dfefd8 100%
        );
        background-size: 200% 200%;
        animation: sectionGradientFlow 16s ease infinite;
        border-radius: 32px;
        border: 1px solid #e5e7eb;
        box-shadow: 0 18px 45px rgba(15, 23, 42, 0.08);
    }

    .pricing-section::before {
        content: "";
        position: absolute;
        inset: 0;
        background:
            radial-gradient(circle at top left, rgba(255,255,255,0.45), transparent 55%),
            radial-gradient(circle at bottom right, rgba(255,255,255,0.18), transparent 35%);
        pointer-events: none;
    }

    .pricing-kicker {
        font-size: .8rem;
        font-weight: 700;
        letter-spacing: .18em;
        text-transform: uppercase;
        color: #5bab23;
    }

    .pricing-title {
        font-size: 2.2rem;
        font-weight: 800;
        color: #111827;
        line-height: 1.2;
    }

    .pricing-lead {
        font-size: 1rem;
        color: #4b5563;
        max-width: 360px;
    }

    .pricing-link-all {
        font-size: .9rem;
        font-weight: 600;
        color: #1E5FA8;
        text-decoration: none;
        border-bottom: 1px solid transparent;
    }

    .pricing-link-all:hover {
        border-bottom-color: #1E5FA8;
    }

    .pricing-cards-wrapper {
        display: grid;
        gap: 1.5rem;
        align-items: stretch;
    }

    @media (min-width: 992px) {
        .pricing-cards-wrapper {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    .pricing-card {
        border-radius: 28px;
        padding: 2rem 2rem 1.75rem;
        background:
            linear-gradient(180deg, rgba(255,255,255,0.95), rgba(255,255,255,0.92));
        backdrop-filter: blur(8px);
        box-shadow:
            0 18px 45px rgba(15, 23, 42, 0.10),
            inset 0 1px 0 rgba(255,255,255,0.85);
        border: 1px solid rgba(255,255,255,0.72);
        display: flex;
        flex-direction: column;
        height: 100%;
        position: relative;
        overflow: hidden;
        transition: transform .28s ease, box-shadow .28s ease, border-color .28s ease;
    }

    .pricing-card::after {
        content: "";
        position: absolute;
        inset: auto -20% -42% auto;
        width: 180px;
        height: 180px;
        border-radius: 999px;
        background: radial-gradient(circle, rgba(30,95,168,0.10), transparent 65%);
        pointer-events: none;
    }

    .pricing-card:hover {
        transform: translateY(-8px);
        box-shadow:
            0 28px 60px rgba(15, 23, 42, 0.16),
            0 10px 30px rgba(30,95,168,0.08);
        border-color: rgba(30,95,168,0.16);
    }

    .pricing-card::before {
        content: "";
        position: absolute;
        inset: 0 0 auto 0;
        height: 6px;
        border-radius: 28px 28px 0 0;
        background: linear-gradient(90deg, #1E5FA8, #2575C0, #5bab23);
    }

    .pricing-card-best {
        color: #ffffff;
        border: none;
        box-shadow:
            0 28px 65px rgba(30,95,168,0.28),
            inset 0 1px 0 rgba(255,255,255,0.18);
        background-image:
            radial-gradient(circle at top left, rgba(255,255,255,0.24) 0, transparent 55%),
            radial-gradient(circle at bottom right, rgba(255,255,255,0.10) 0, transparent 42%),
            linear-gradient(
                135deg,
                #1E5FA8 0%,
                #2575C0 35%,
                #0f9150 75%,
                #5bab23 100%
            );
    }

    .pricing-card-best:hover {
        transform: translateY(-10px);
        box-shadow:
            0 34px 70px rgba(30,95,168,0.36),
            0 12px 34px rgba(37,117,192,0.18);
    }

    .pricing-card-best-alt {
        background-image:
            radial-gradient(circle at top left, rgba(255,255,255,0.24) 0, transparent 55%),
            radial-gradient(circle at bottom right, rgba(255,255,255,0.10) 0, transparent 42%),
            linear-gradient(
                135deg,
                #5bab23 0%,
                #0f9150 35%,
                #2575C0 75%,
                #1E5FA8 100%
            );
    }

    .pricing-card-badge-top {
        position: absolute;
        top: 1.2rem;
        right: 1.3rem;
        font-size: .78rem;
        padding: .38rem .82rem;
        border-radius: 999px;
        background-color: rgba(15,23,42,0.08);
        color: #111827;
        font-weight: 700;
        letter-spacing: .02em;
        z-index: 2;
    }

    .pricing-card-best .pricing-card-badge-top {
        background-color: rgba(15,23,42,0.22);
        color: #fefce8;
        box-shadow: inset 0 1px 0 rgba(255,255,255,0.12);
    }

    .pricing-name {
        font-size: 1.2rem;
        font-weight: 800;
        margin-bottom: .35rem;
        line-height: 1.25;
        max-width: calc(100% - 120px);
    }

    .pricing-speed {
        font-size: .95rem;
        font-weight: 600;
        color: #6b7280;
        margin-bottom: 1.15rem;
    }

    .pricing-card-best .pricing-speed {
        color: #e5e7eb;
    }

    .pricing-speed strong {
        color: #111827;
    }

    .pricing-card-best .pricing-speed strong {
        color: #ffffff;
    }

    .pricing-price {
        font-size: 2.2rem;
        font-weight: 800;
        margin-bottom: .2rem;
        line-height: 1.08;
        letter-spacing: -.02em;
    }

    .pricing-price span {
        font-size: .95rem;
        font-weight: 600;
        margin-left: .1rem;
    }

    .pricing-price-sub {
        font-size: .79rem;
        opacity: .9;
        margin-bottom: 1.2rem;
        color: #6b7280;
        line-height: 1.55;
    }

    .pricing-card-best .pricing-price-sub {
        color: #fef9c3;
    }

    .pricing-feature-list {
        list-style: none;
        padding: 0;
        margin: 0 0 1.45rem;
        font-size: .91rem;
    }

    .pricing-feature-list li {
        display: flex;
        align-items: flex-start;
        gap: .6rem;
        margin-bottom: .55rem;
        line-height: 1.58;
    }

    .pricing-feature-icon {
        color: #22c55e;
        margin-top: .15rem;
        font-size: .92rem;
        flex-shrink: 0;
    }

    .pricing-card-best .pricing-feature-icon {
        color: #bbf7d0;
    }

    .pricing-feature-text {
        color: #4b5563;
    }

    .pricing-card-best .pricing-feature-text {
        color: #fefce8;
    }

    .pricing-cta-btn {
        border-radius: 999px;
        font-weight: 700;
        padding: .82rem 1rem;
        box-shadow: none !important;
    }

    .pricing-card .pricing-cta-btn.btn-primary,
    .pricing-card .pricing-cta-btn.btn-success {
        background: linear-gradient(135deg, #0b63a8, #5bab23);
        border: none;
    }

    .pricing-card .pricing-cta-btn.btn-primary:hover,
    .pricing-card .pricing-cta-btn.btn-success:hover {
        filter: brightness(.97);
        transform: translateY(-1px);
    }

    .pricing-card-best .pricing-cta-btn.btn-light {
        background: rgba(255,255,255,0.95);
        border: none;
        font-weight: 800;
    }

    .pricing-card-best .pricing-cta-btn.btn-light:hover {
        background: #ffffff;
    }

    .pricing-cta-secondary {
        font-size: .8rem;
        color: #6b7280;
        margin-top: .55rem;
    }

    .pricing-card-best .pricing-cta-secondary {
        color: #fefce8;
        opacity: .9;
    }

    /* ================== WHY SECTION ================== */
    .why-section {
        margin-top: 3.25rem;
        margin-bottom: 4rem;
    }

    .why-section-head {
        max-width: 760px;
        margin: 0 auto 2.2rem;
        text-align: center;
    }

    .why-section-kicker {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 14px;
        border-radius: 999px;
        background: linear-gradient(135deg, rgba(30,95,168,.08), rgba(91,171,35,.10));
        color: #1E5FA8;
        font-size: .78rem;
        font-weight: 800;
        letter-spacing: .08em;
        text-transform: uppercase;
        margin-bottom: 1rem;
        border: 1px solid rgba(30,95,168,.08);
    }

    .why-section-title {
        font-weight: 900;
        font-size: clamp(1.8rem, 2.8vw, 2.5rem);
        color: #0f172a;
        margin-bottom: .65rem;
        letter-spacing: -0.03em;
        line-height: 1.15;
    }

    .why-highlight {
        background: linear-gradient(135deg, #1E5FA8, #2575C0, #5bab23);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .why-section-subtitle {
        max-width: 680px;
        margin: 0 auto;
        color: #64748b;
        font-size: 1rem;
        line-height: 1.8;
    }

    /* CARD */
    .why-card {
        position: relative;
        height: 100%;
        border-radius: 28px;
        padding: 1.45rem 1.35rem 1.35rem;
        overflow: hidden;
        box-shadow: 0 18px 40px rgba(15, 23, 42, 0.08);
        transition: transform .28s ease, box-shadow .28s ease, border-color .28s ease;
        display: flex;
        flex-direction: column;
        border: 1px solid rgba(255,255,255,.22);
        isolation: isolate;
    }

    .why-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 28px 60px rgba(15, 23, 42, 0.14);
    }

    .why-card::before {
        content: "";
        position: absolute;
        inset: 0;
        background: radial-gradient(circle at top right, rgba(255,255,255,.22), transparent 42%);
        pointer-events: none;
        z-index: 0;
    }

    .why-card::after {
        content: "";
        position: absolute;
        width: 150px;
        height: 150px;
        right: -48px;
        bottom: -48px;
        border-radius: 999px;
        background: rgba(255,255,255,.08);
        pointer-events: none;
        z-index: 0;
    }

    .why-card-primary {
        background:
            linear-gradient(135deg, rgba(255,255,255,.08), rgba(255,255,255,.02)),
            linear-gradient(135deg, #1E5FA8 0%, #2575C0 42%, #0f9150 76%, #5bab23 100%);
        color: #ffffff;
    }

    .why-card-secondary {
        background:
            linear-gradient(135deg, rgba(255,255,255,.72), rgba(255,255,255,.28)),
            linear-gradient(135deg, #ecf5ff 0%, #f8fbff 48%, #eef9ef 100%);
        color: #0f172a;
        border: 1px solid #dde9f7;
    }

    .why-card-accent {
        background:
            linear-gradient(135deg, rgba(255,255,255,.10), rgba(255,255,255,.03)),
            linear-gradient(135deg, #0b63a8 0%, #0095b3 48%, #22c55e 100%);
        color: #ffffff;
    }

    /* TOP DECOR */
    .why-card-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        margin-bottom: 1rem;
        position: relative;
        z-index: 1;
    }

    .why-badge-icon {
        width: 58px;
        height: 58px;
        border-radius: 18px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 1.45rem;
        flex-shrink: 0;
    }

    .why-card-primary .why-badge-icon,
    .why-card-accent .why-badge-icon {
        background: rgba(255,255,255,.16);
        color: #ffffff;
        border: 1px solid rgba(255,255,255,.22);
        box-shadow: inset 0 1px 0 rgba(255,255,255,.10);
    }

    .why-card-secondary .why-badge-icon {
        background: linear-gradient(135deg, #1E5FA8, #5bab23);
        color: #ffffff;
        box-shadow: 0 14px 26px rgba(30,95,168,.18);
    }

    .why-card-line {
        flex: 1;
        height: 8px;
        border-radius: 999px;
        opacity: .8;
    }

    .why-card-primary .why-card-line,
    .why-card-accent .why-card-line {
        background: rgba(255,255,255,.20);
    }

    .why-card-secondary .why-card-line {
        background: linear-gradient(90deg, rgba(30,95,168,.14), rgba(91,171,35,.18));
    }

    /* CONTENT */
    .why-card-title {
        font-size: 1.14rem;
        font-weight: 900;
        line-height: 1.4;
        margin-bottom: .45rem;
        position: relative;
        z-index: 1;
        letter-spacing: -0.01em;
    }

    .why-card-subtitle {
        font-size: .92rem;
        font-weight: 700;
        line-height: 1.55;
        margin-bottom: .7rem;
        position: relative;
        z-index: 1;
        opacity: .95;
    }

    .why-card-text {
        font-size: .93rem;
        line-height: 1.78;
        margin-bottom: 0;
        position: relative;
        z-index: 1;
        opacity: .96;
    }

    .why-card-footer {
        margin-top: auto;
        padding-top: 1rem;
        position: relative;
        z-index: 1;
    }

    .why-chip {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        border-radius: 999px;
        padding: 7px 12px;
        font-size: .78rem;
        font-weight: 700;
    }

    .why-card-primary .why-chip,
    .why-card-accent .why-chip {
        background: rgba(255,255,255,.14);
        color: #f8fafc;
        border: 1px solid rgba(255,255,255,.14);
    }

    .why-card-secondary .why-chip {
        background: rgba(30,95,168,.07);
        color: #1E5FA8;
        border: 1px solid rgba(30,95,168,.10);
    }

    .why-card-primary .why-card-title,
    .why-card-primary .why-card-subtitle,
    .why-card-primary .why-card-text,
    .why-card-accent .why-card-title,
    .why-card-accent .why-card-subtitle,
    .why-card-accent .why-card-text {
        color: #f8fafc;
    }

    .why-card-secondary .why-card-title {
        color: #1E5FA8;
    }

    .why-card-secondary .why-card-subtitle,
    .why-card-secondary .why-card-text {
        color: #475569;
    }

    /* DARK MODE */
    body.dark-mode .why-section-title {
        color: #f8fafc;
    }

    body.dark-mode .why-highlight {
        background: linear-gradient(135deg, #93c5fd, #5eead4, #86efac);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    body.dark-mode .why-section-subtitle {
        color: #94a3b8;
    }

    body.dark-mode .why-card-secondary {
        background:
            linear-gradient(135deg, rgba(15,23,42,.92), rgba(15,23,42,.78)),
            linear-gradient(135deg, #0b1120 0%, #0f172a 100%);
        border-color: #1e293b;
    }

    body.dark-mode .why-card-secondary .why-card-title {
        color: #e5e7eb;
    }

    body.dark-mode .why-card-secondary .why-card-subtitle,
    body.dark-mode .why-card-secondary .why-card-text {
        color: #cbd5e1;
    }

    body.dark-mode .why-card-secondary .why-chip {
        background: rgba(148,163,184,.12);
        color: #e5e7eb;
        border-color: rgba(148,163,184,.18);
    }

    /* MOBILE */
    @media (max-width: 768px) {
        .why-card {
            padding: 1.2rem 1.05rem 1.1rem;
            border-radius: 22px;
        }

        .why-badge-icon {
            width: 50px;
            height: 50px;
            border-radius: 16px;
            font-size: 1.2rem;
        }

        .why-card-title {
            font-size: 1.03rem;
        }

        .why-card-text {
            font-size: .9rem;
        }
    }

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
        animation: sectionGradientFlow 14s ease infinite;
        border: 1px solid #e5e7eb;
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
        color: #1E5FA8;
    }

    .reco-lead {
        font-size: .9rem;
        color: #4b5563;
    }

    .btn-brand {
        background: linear-gradient(135deg, #1E5FA8, #5bab23);
        color: #fff;
        border: none;
        font-weight: 600;
        border-radius: 999px;
        box-shadow: 0 10px 25px rgba(30, 95, 168, .30);
    }

    .btn-brand:hover {
        filter: brightness(0.96);
        color: #fff;
    }

    .text-brand {
        color: #1E5FA8;
    }

    .reco-result-card {
        border-radius: 20px;
        padding: 1.25rem 1.3rem 1.2rem;
        border: 1px solid #e5e7eb;
        background-color: #ffffff;
        box-shadow: 0 14px 35px rgba(15, 23, 42, .07);
        display: flex;
        flex-direction: column;
    }

    /* ===================== REKOMENDASI TOAST ======================= */
    .reco-toast {
        position: fixed;
        right: 22px;
        bottom: 22px;
        width: min(440px, calc(100vw - 32px));
        z-index: 1080;
        animation: recoToastIn .35s ease-out;
    }

    .reco-toast-inner {
        position: relative;
        display: flex;
        gap: 14px;
        border-radius: 22px;
        padding: 14px;
        border: 1px solid rgba(229,231,235,.9);
        background: linear-gradient(
            135deg,
            rgba(197,213,230,.98) 0%,
            rgba(247,251,255,.98) 45%,
            rgba(223,239,216,.98) 100%
        );
        box-shadow: 0 22px 60px rgba(15,23,42,.20);
        backdrop-filter: blur(8px);
    }

    .reco-toast-icon {
        width: 46px;
        height: 46px;
        border-radius: 999px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        background: linear-gradient(135deg, #1E5FA8, #5bab23);
        box-shadow: 0 12px 30px rgba(30,95,168,.30);
        flex-shrink: 0;
        margin-left: 2px;
    }

    .reco-toast-title {
        font-weight: 800;
        color: #1E5FA8;
        margin-bottom: 2px;
        font-size: 1rem;
    }

    .reco-toast-text {
        font-size: .9rem;
        color: #4b5563;
        margin-bottom: 10px;
    }

    .reco-toast-actions {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .reco-toast-btn {
        border-radius: 999px;
        border: none;
        font-weight: 700;
        color: #fff !important;
        background: linear-gradient(135deg, #1E5FA8, #5bab23);
        box-shadow: 0 14px 35px rgba(30,95,168,.25);
        padding: .45rem .85rem;
    }

    .reco-toast-btn:hover {
        filter: brightness(.97);
    }

    .reco-toast-btn-outline {
        border-radius: 999px;
        font-weight: 700;
        padding: .45rem .85rem;
        border: 1px solid rgba(30,95,168,.25);
        background: rgba(255,255,255,.7);
        color: #1E5FA8;
    }

    .reco-toast-close {
        position: absolute;
        right: 10px;
        top: 10px;
        border: none;
        background: transparent;
        color: rgba(17,24,39,.55);
        padding: 6px;
        line-height: 1;
        border-radius: 10px;
    }

    .reco-toast-close:hover {
        background: rgba(0,0,0,.05);
    }

    /* ======================= CENTER ALERT OVERLAY ======================= */
    .reco-overlay {
        position: fixed;
        inset: 0;
        background: rgba(15,23,42,0.55);
        backdrop-filter: blur(6px);
        z-index: 1070;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .reco-toast {
        position: relative;
        right: auto;
        bottom: auto;
        width: min(520px, calc(100vw - 32px));
        z-index: 1080;
    }

    /* ===================== DARK MODE PRICING ===================== */
    body.dark-mode .pricing-section {
        background: radial-gradient(circle at left top, #020617 0, #020617 40%, #020617 100%);
        border-color: #1f2937;
    }

    body.dark-mode .pricing-title {
        color: #f9fafb;
    }

    body.dark-mode .pricing-lead {
        color: #d1d5db;
    }

    body.dark-mode .pricing-card {
        background: linear-gradient(180deg, rgba(2,6,23,0.96), rgba(2,6,23,0.92));
        border-color: #1e293b;
        box-shadow:
            0 18px 45px rgba(0,0,0,0.7),
            inset 0 1px 0 rgba(255,255,255,0.03);
    }

    body.dark-mode .pricing-card::after {
        background: radial-gradient(circle, rgba(91,171,35,0.12), transparent 65%);
    }

    body.dark-mode .pricing-name {
        color: #f9fafb;
    }

    body.dark-mode .pricing-speed {
        color: #9ca3af;
    }

    body.dark-mode .pricing-speed strong {
        color: #e5e7eb;
    }

    body.dark-mode .pricing-price-sub {
        color: #9ca3af;
    }

    body.dark-mode .pricing-feature-text {
        color: #e5e7eb;
    }

    body.dark-mode .pricing-cta-secondary {
        color: #9ca3af;
    }

    body.dark-mode .pricing-card-badge-top {
        background: rgba(148,163,184,0.12);
        color: #e5e7eb;
    }

    /* ================== DARK MODE WHY CARD ================== */
    body.dark-mode .why-section-title {
        color: #f8fafc;
    }

    body.dark-mode .why-highlight {
        color: #93c5fd;
    }

    body.dark-mode .why-section-subtitle {
        color: #94a3b8;
    }

    body.dark-mode .why-card-secondary {
        background:
            linear-gradient(135deg, rgba(15,23,42,.92), rgba(15,23,42,.78)),
            linear-gradient(135deg, #0b1120 0%, #0f172a 100%);
        border-color: #1e293b;
    }

    body.dark-mode .why-card-secondary .why-card-title {
        color: #e5e7eb;
    }

    body.dark-mode .why-card-secondary .why-card-subtitle,
    body.dark-mode .why-card-secondary .why-card-text {
        color: #cbd5e1;
    }

    body.dark-mode .why-card-secondary .why-card-tag {
        background: rgba(148,163,184,.12);
        color: #e5e7eb;
        border-color: rgba(148,163,184,.18);
    }

    /* ===================== DARK MODE REKOMENDASI ===================== */
    body.dark-mode .reco-wrapper {
        background: linear-gradient(135deg, #021021, #02260e);
        border-color: #1f2937;
    }

    body.dark-mode .reco-kicker {
        color: #93c5fd;
    }

    body.dark-mode .reco-title {
        color: #e5e7eb;
    }

    body.dark-mode .reco-lead {
        color: #9ca3af;
    }

    body.dark-mode .reco-result-card {
        background-color: #020617;
        border-color: #1f2937;
        box-shadow: 0 18px 45px rgba(0, 0, 0, .8);
    }

    body.dark-mode .reco-result-card .text-muted,
    body.dark-mode .reco-result-card li {
        color: #d1d5db !important;
    }

    body.dark-mode .text-brand {
        color: #a5d6ff;
    }

    body.dark-mode .reco-toast-inner {
        border-color: #1e293b;
        background: linear-gradient(135deg, rgba(2,16,33,.98), rgba(2,38,14,.98));
        box-shadow: 0 28px 80px rgba(0,0,0,.92);
    }

    body.dark-mode .reco-toast-title {
        color: #e5e7eb;
    }

    body.dark-mode .reco-toast-text {
        color: #9ca3af;
    }

    body.dark-mode .reco-toast-btn-outline {
        background: rgba(2,6,23,.55);
        border-color: rgba(148,163,184,.25);
        color: #e5e7eb;
    }

    body.dark-mode .reco-toast-close {
        color: rgba(226,232,240,.65);
    }

    body.dark-mode .reco-toast-close:hover {
        background: rgba(255,255,255,.06);
    }

    body.dark-mode .reco-overlay {
        background: rgba(2,6,23,0.75);
    }

    /* ===================== RECO PACKAGE CARD SUPPORT ===================== */
    .reco-package-card {
        padding: 2rem 2rem 1.75rem;
    }

    .reco-package-badge {
        top: 1.2rem;
        right: 1.3rem;
    }

    .reco-package-name {
        margin-bottom: .35rem;
    }

    .reco-package-speed {
        margin-bottom: 1.1rem;
    }

    .reco-package-price {
        margin-bottom: .2rem;
        line-height: 1.08;
    }

    .reco-package-sub {
        margin-bottom: 1.2rem;
    }

    .reco-package-features {
        margin: 0 0 1.45rem;
        padding-right: .2rem;
    }

    .reco-package-features li {
        gap: .6rem;
        margin-bottom: .55rem;
        line-height: 1.58;
    }

    .reco-package-btn {
        padding: .82rem 1rem;
    }

    .reco-package-note {
        margin-top: .55rem;
    }

    /* ===================== MOBILE ===================== */
    @media (max-width: 991.98px) {
        .pricing-title {
            font-size: 1.95rem;
        }
    }

    @media (max-width: 768px) {
        .pricing-card,
        .reco-package-card {
            padding: 1.55rem 1.35rem 1.3rem;
            border-radius: 24px;
        }

        .pricing-card::before {
            border-radius: 24px 24px 0 0;
        }

        .pricing-card-badge-top,
        .reco-package-badge {
            top: 1rem;
            right: 1rem;
        }

        .pricing-name {
            max-width: calc(100% - 100px);
            font-size: 1.08rem;
        }

        .pricing-price {
            font-size: 1.9rem;
        }

        .pricing-feature-list li,
        .reco-package-features li {
            margin-bottom: .48rem;
        }

        .why-card {
            padding: 1.25rem 1.15rem;
            border-radius: 22px;
        }

        .why-badge-icon {
            width: 48px;
            height: 48px;
            border-radius: 16px;
            font-size: 1.2rem;
        }
    }
</style>
@endpush

@section('content')

{{-- SLIDER BANNER (dari DB) --}}
<div id="heroCarousel" class="carousel slide mb-5"
     data-bs-ride="carousel" data-bs-interval="5000">

    <div class="carousel-inner rounded-4 shadow">

        @forelse($banners as $banner)
            @php
                $active = $loop->first ? 'active' : '';
                $img = $banner->image_desktop
                    ? asset('storage/' . ltrim($banner->image_desktop, '/'))
                    : asset('assets/3.png');
            @endphp

            <div class="carousel-item {{ $active }}">
                <img src="{{ $img }}" class="d-block w-100" alt="{{ $banner->title ?? 'Banner' }}">
            </div>
        @empty
            <div class="carousel-item active">
                <img src="{{ asset('assets/3.png') }}" class="d-block w-100" alt="Banner Default">
            </div>
        @endforelse

    </div>

    @if($banners->count() > 1)
        <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>
    @endif
</div>

{{-- STRIP KATEGORI --}}
<section class="category-strip mb-4">
    <div class="container">
        <div class="row g-3 justify-content-center">
            <div class="col-4 col-md-2">
                <a href="{{ route('public.packages', ['category' => 'internet_only']) }}" class="text-decoration-none">
                    <div class="category-item">
                        <div class="category-icon"><i class="bi bi-router"></i></div>
                        <div class="category-label">Internet</div>
                    </div>
                </a>
            </div>

            <div class="col-4 col-md-2">
                <a href="{{ route('public.packages', ['category' => 'streaming']) }}" class="text-decoration-none">
                    <div class="category-item">
                        <div class="category-icon"><i class="bi bi-play-btn-fill"></i></div>
                        <div class="category-label">Internet + Streaming</div>
                    </div>
                </a>
            </div>

            <div class="col-4 col-md-2">
                <a href="{{ route('public.packages', ['category' => 'internet_tv']) }}" class="text-decoration-none">
                    <div class="category-item">
                        <div class="category-icon"><i class="bi bi-tv-fill"></i></div>
                        <div class="category-label">Internet + TV</div>
                    </div>
                </a>
            </div>

            <div class="col-4 col-md-2">
                <a href="{{ route('public.packages', ['sort' => 'price_asc']) }}" class="text-decoration-none">
                    <div class="category-item">
                        <div class="category-icon"><i class="bi bi-gift-fill"></i></div>
                        <div class="category-label">Promo</div>
                    </div>
                </a>
            </div>

            <div class="col-4 col-md-2">
                <a href="https://fast.com" target="_blank" class="text-decoration-none">
                    <div class="category-item">
                        <div class="category-icon"><i class="bi bi-speedometer2"></i></div>
                        <div class="category-label">Speed Test</div>
                    </div>
                </a>
            </div>

            <div class="col-4 col-md-2">
                @php $waNumber = preg_replace('/[^0-9]/', '', $whatsApp ?? '6281234567890'); @endphp
                <a href="https://wa.me/{{ $waNumber }}?text=Halo%20saya%20ingin%20melaporkan%20gangguan"
                   target="_blank"
                   class="text-decoration-none">
                    <div class="category-item">
                        <div class="category-icon"><i class="bi bi-headset"></i></div>
                        <div class="category-label">Pengaduan 24/7</div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</section>

{{-- SECTION PR SERVICES --}}
<section class="py-5">
    <div class="container">
        <style>
            .dedicated-title {
                font-weight: 800;
                font-size: 2.5rem;
                line-height: 1.15;
                color: #1E5FA8;
                margin-bottom: 1rem;
                letter-spacing: -0.02em;
            }

            .dedicated-title span {
                background: linear-gradient(135deg, #1E5FA8, #2575C0, #5bab23);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-clip: text;
            }

            .dedicated-body {
                max-width: 620px;
            }

            .dedicated-body p {
                font-size: 1rem;
                line-height: 1.9;
                color: #475569;
                margin-bottom: 1rem;
            }

            .dedicated-body strong {
                color: #1e293b;
                font-weight: 800;
            }

            .btn-gradient-primary {
                background: linear-gradient(135deg, #1E5FA8, #5bab23);
                border: none;
                color: #ffffff;
                font-weight: 800;
                padding: 14px 28px;
                border-radius: 999px;
                box-shadow: 0 12px 28px rgba(30,95,168,0.20);
                transition: all .25s ease;
            }

            .btn-gradient-primary:hover {
                filter: brightness(0.97);
                color: #ffffff;
                transform: translateY(-2px);
                box-shadow: 0 18px 34px rgba(30,95,168,0.26);
            }

            .dedicated-link {
                font-weight: 700;
                text-decoration: underline;
                text-underline-offset: 3px;
                color: #1E5FA8;
                transition: .2s ease;
            }

            .dedicated-link:hover {
                color: #2575C0;
            }

            .feature-small {
                display: flex;
                gap: 14px;
                margin-bottom: 1.1rem;
                padding: 14px 4px;
                transition: transform .22s ease;
            }

            .feature-small:hover {
                transform: translateY(-2px);
            }

            .feature-small-icon {
                width: 50px;
                height: 50px;
                border-radius: 16px;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 1.35rem;
                color: #ffffff;
                flex-shrink: 0;
                box-shadow: 0 10px 20px rgba(15, 23, 42, 0.12);
            }

            .feature-small-icon.icon-1 {
                background: linear-gradient(135deg, #22c55e, #5bab23);
            }

            .feature-small-icon.icon-2 {
                background: linear-gradient(135deg, #1E5FA8, #2575C0);
            }

            .feature-small-icon.icon-3 {
                background: linear-gradient(135deg, #2575C0, #16a34a);
            }

            .feature-small-icon.icon-4 {
                background: linear-gradient(135deg, #0f9d7a, #5bab23);
            }

            .feature-small-title {
                font-weight: 800;
                font-size: 1.12rem;
                color: #0f172a;
                margin-bottom: .35rem;
                line-height: 1.35;
            }

            .feature-small-text {
                font-size: .96rem;
                color: #475569;
                line-height: 1.7;
                margin-bottom: 0;
            }

            @media (max-width: 991.98px) {
                .dedicated-title {
                    font-size: 2rem;
                }
            }

            @media (max-width: 767.98px) {
                .dedicated-title {
                    font-size: 1.7rem;
                }

                .feature-small {
                    padding: 10px 0;
                    margin-bottom: .85rem;
                }

                .feature-small-icon {
                    width: 46px;
                    height: 46px;
                    border-radius: 14px;
                    font-size: 1.2rem;
                }

                .feature-small-title {
                    font-size: 1rem;
                }

                .feature-small-text {
                    font-size: .92rem;
                }
            }

            /* DARK MODE OVERRIDES */
            body.dark-mode .dedicated-title {
                color: #ffffff;
            }

            body.dark-mode .dedicated-title span {
                background: linear-gradient(135deg, #38bdf8, #4ade80);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-clip: text;
            }

            body.dark-mode .dedicated-body p {
                color: #cbd5e1;
            }

            body.dark-mode .dedicated-body strong {
                color: #f8fafc;
            }

            body.dark-mode .dedicated-link {
                color: #38bdf8;
            }

            body.dark-mode .dedicated-link:hover {
                color: #7dd3fc;
            }

            body.dark-mode .feature-small-title {
                color: #f8fafc;
            }

            body.dark-mode .feature-small-text {
                color: #94a3b8;
            }
        </style>

        <div class="row g-4 align-items-start">
            <div class="col-lg-6">
                <h2 class="dedicated-title">
                    Public Relations <span>Services</span>
                </h2>

                <div class="dedicated-body mb-4">
                    <p>
                        <strong>Dedicated Internet Access</strong> adalah solusi koneksi premium untuk perusahaan, kantor, instansi, dan pelaku usaha yang membutuhkan performa jaringan stabil setiap saat.
                    </p>
                    <p>
                        Dengan alokasi bandwidth <strong>dedicated 1:1</strong>, koneksi menjadi lebih konsisten untuk aktivitas penting seperti video conference, cloud system, operasional bisnis, monitoring, dan komunikasi internal.
                    </p>
                    <p>
                        Layanan ini juga mendukung kebutuhan akses yang lebih aman, cepat, dan terpercaya dengan dukungan teknis profesional agar aktivitas bisnis kamu berjalan lancar tanpa gangguan berarti.
                    </p>
                </div>

                @php $waNumber = preg_replace('/[^0-9]/', '', $whatsApp ?? '6281234567890'); @endphp
                <div class="d-flex align-items-center gap-3 flex-wrap">
                    <a href="https://wa.me/{{ $waNumber }}?text=Halo%20saya%20ingin%20informasi%20Dedicated%20Internet"
                       class="btn btn-gradient-primary rounded-pill">
                        Hubungi Kami
                    </a>
                    <a href="{{ route('public.packages') }}" class="dedicated-link">Lihat Semua Fitur</a>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="feature-small">
                            <div class="feature-small-icon icon-1">
                                <i class="bi bi-speedometer2"></i>
                            </div>
                            <div>
                                <div class="feature-small-title">Ultra-speed Connection</div>
                                <p class="feature-small-text">
                                    Rasio upload dan download seimbang untuk mendukung meeting online, transfer data, dan pekerjaan digital tanpa hambatan.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="feature-small">
                            <div class="feature-small-icon icon-2">
                                <i class="bi bi-hdd-network"></i>
                            </div>
                            <div>
                                <div class="feature-small-title">SLA 99.50%</div>
                                <p class="feature-small-text">
                                    Jaminan uptime tinggi untuk menjaga koneksi tetap stabil dan membantu aktivitas bisnis berjalan lebih aman setiap hari.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="feature-small">
                            <div class="feature-small-icon icon-3">
                                <i class="bi bi-graph-up-arrow"></i>
                            </div>
                            <div>
                                <div class="feature-small-title">MRTG Monitoring</div>
                                <p class="feature-small-text">
                                    Pemantauan trafik real-time yang membantu kontrol penggunaan bandwidth dan analisis performa jaringan secara lebih akurat.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="feature-small">
                            <div class="feature-small-icon icon-4">
                                <i class="bi bi-headset"></i>
                            </div>
                            <div>
                                <div class="feature-small-title">Fast Support 24/7</div>
                                <p class="feature-small-text">
                                    Tim NOC dan teknisi berpengalaman siap membantu lebih cepat saat ada kendala maupun kebutuhan teknis mendesak.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

{{-- PRICING SECTION --}}
<section class="pricing-section">
    <div class="container">
        <div class="row g-4 align-items-start">
            <div class="col-lg-4">
                <div class="mb-3">
                    <div class="pricing-kicker">Paket &amp; Harga</div>
                    <h2 class="pricing-title mt-2">
                        Kami Transparan Masalah Harga, Pilih Paket yang Sesuai Kebutuhanmu
                    </h2>
                </div>

                <p class="pricing-lead mb-4">
                    Semua paket sudah menggunakan jaringan 100% full fiber optic tanpa batas kuota (unlimited) dengan kecepatan simetris dan stabil.
                </p>

                <a href="{{ route('public.packages') }}"
                   class="btn btn-gradient-primary rounded-pill">
                    Lihat Semua Paket
                </a>
            </div>

            <div class="col-lg-8">
                <div class="pricing-cards-wrapper">
                    @forelse($packages as $package)
                        @php
                            $isBest = (int) $package->is_best_seller === 1;
                            $cardClass = $isBest ? 'pricing-card pricing-card-best' : 'pricing-card';
                            if ($isBest && $loop->first) $cardClass .= ' pricing-card-best-alt';
                        @endphp

                        <div class="{{ $cardClass }}">
                            @if($isBest)
                                <span class="pricing-card-badge-top">Best Seller</span>
                            @endif

                            <div class="mb-2">
                                <div class="pricing-name">{{ $package->name }}</div>
                                <div class="pricing-speed">
                                    Speed up to <strong>{{ $package->speed_mbps }} Mbps</strong>
                                </div>
                            </div>

                            <div class="mb-2">
                                <div class="pricing-price">
                                    Rp {{ number_format($package->price_monthly, 0, ',', '.') }}
                                    <span>/bulan</span>
                                </div>
                                <div class="pricing-price-sub">
                                    Sudah termasuk biaya instalasi &amp; sewa modem*
                                </div>
                            </div>

                            @if($package->features)
                                <ul class="pricing-feature-list">
                                    @foreach(preg_split("/\r\n|\n|\r/", $package->features) as $feature)
                                        @if(trim($feature) !== '')
                                            <li>
                                                <span class="pricing-feature-icon"><i class="bi bi-check2"></i></span>
                                                <span class="pricing-feature-text">{{ trim($feature) }}</span>
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            @endif

                            <div class="mt-auto">
                                @if($package->whatsapp_order_url)
                                    <a href="{{ $package->whatsapp_order_url }}"
                                       target="_blank"
                                       class="btn pricing-cta-btn w-100 {{ $isBest ? 'btn-light text-dark' : 'btn-primary text-white' }}">
                                        {{ $isBest ? 'Berlangganan Sekarang' : 'Pilih Paket Ini' }}
                                    </a>
                                @else
                                    @php
                                        $waNumber = preg_replace('/[^0-9]/', '', $whatsApp ?? '');
                                        $waLink = $waNumber
                                            ? "https://wa.me/{$waNumber}?text=" . urlencode("Halo CS, saya ingin info paket {$package->name}")
                                            : null;
                                    @endphp

                                    @if($waLink)
                                        <a href="{{ $waLink }}" target="_blank"
                                           class="btn btn-success pricing-cta-btn w-100">
                                            Hubungi Customer Service
                                        </a>
                                    @else
                                        <button class="btn btn-secondary pricing-cta-btn w-100" disabled>
                                            WhatsApp CS belum diset
                                        </button>
                                    @endif
                                @endif

                                <div class="pricing-cta-secondary">
                                    *Syarat &amp; ketentuan berlaku
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-center text-muted">
                            Belum ada paket yang tersedia. Silakan hubungi admin.
                        </p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</section>

{{-- REKOMENDASI PAKET (BINGUNG PILIH PAKET) --}}
@include('partials.rekomendasi-paket', [
    'recommendedPackages' => $recommendedPackages ?? collect(),
])

{{-- Cara berlangganan --}}
<section class="my-5">
    <div class="container">
        <div class="fm-steps-banner p-4 p-md-5 shadow-lg">
            <div class="text-center mb-4">
                <h2 class="fm-steps-title mb-2">Cara Berlangganan Internet FibermediaPlay</h2>
                <p class="fm-steps-subtitle mb-0">Tiga langkah mudah menikmati koneksi internet super cepat dan stabil di rumah Anda</p>
            </div>

            <div class="row text-center g-4">
                <div class="col-md-4 fm-step-item">
                    <div class="fm-step-badge mb-2"><i class="bi bi-person-plus-fill"></i></div>
                    <div class="fm-step-title">1. Registrasi</div>
                    <p class="fm-step-text mb-0">Pilih paket favorit Anda dan isi formulir pendaftaran secara online atau via WhatsApp Sales.</p>
                </div>

                <div class="col-md-4 fm-step-item">
                    <div class="fm-step-badge mb-2"><i class="bi bi-tools"></i></div>
                    <div class="fm-step-title">2. Instalasi</div>
                    <p class="fm-step-text mb-0">Tim teknisi profesional kami segera datang ke lokasi untuk penarikan kabel fiber optic dan setting modem.</p>
                </div>

                <div class="col-md-4 fm-step-item">
                    <div class="fm-step-badge mb-2"><i class="bi bi-credit-card-2-front-fill"></i></div>
                    <div class="fm-step-title">3. Aktivasi &amp; Bayar</div>
                    <p class="fm-step-text mb-0">Setelah jaringan aktif dan teruji stabil, lakukan pembayaran tagihan pertama dan nikmati internetnya.</p>
                </div>
            </div>

        </div>
    </div>
</section>

{{-- WHY SECTION --}}
<section class="py-5 mt-4 why-section">
    <div class="container">
        <div class="why-section-head">
            <div class="why-section-kicker">
                <i class="bi bi-stars"></i>
                <span>Kenapa pelanggan memilih kami</span>
            </div>

            <h2 class="why-section-title">
                Kenapa Pilih <span class="why-highlight">FibermediaPlay</span>?
            </h2>

            <p class="why-section-subtitle">
                Kami hadir dengan jaringan yang stabil, layanan yang responsif, dan pengalaman pelanggan yang dibuat lebih nyaman untuk kebutuhan rumah maupun bisnis.
            </p>
        </div>

        <div class="row g-4">
            @forelse ($whyCards->take(4) as $card)
                @php
                    $styles = [
                        'why-card-primary',
                        'why-card-secondary',
                        'why-card-accent',
                        'why-card-secondary'
                    ];

                    $cardClass = $styles[$loop->index] ?? 'why-card-secondary';

                    $icons = [
                        'bi-speedometer2',
                        'bi-shield-check',
                        'bi-headset',
                        'bi-sliders',
                    ];

                    $iconClass = $card->icon ?: ($icons[$loop->index] ?? 'bi-star');
                @endphp

                <div class="col-md-6 col-lg-3">
                    <div class="why-card {{ $cardClass }}">
                        <div class="why-card-top">
                            <div class="why-badge-icon">
                                <i class="bi {{ $iconClass }}"></i>
                            </div>
                            <div class="why-card-line"></div>
                        </div>

                        <div class="why-card-title">
                            {{ $card->title }}
                        </div>

                        @if($card->subtitle)
                            <div class="why-card-subtitle">
                                {{ $card->subtitle }}
                            </div>
                        @endif

                        <p class="why-card-text">
                            {!! nl2br(e($card->description)) !!}
                        </p>

                        <div class="why-card-footer">
                            <div class="why-chip">
                                <i class="bi bi-check-circle-fill"></i>
                                <span>Layanan terpercaya</span>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="text-center text-muted py-4">
                        Belum ada data Why Card
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</section>

@endsection