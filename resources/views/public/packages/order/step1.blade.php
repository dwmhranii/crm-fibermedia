@extends('public.layouts.public')

@section('content')
<style>
.order-wrap {
    max-width: 1100px;
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

.order-step.active .order-step-badge,
.order-step.done .order-step-badge {
    background: linear-gradient(135deg, #1E5FA8, #2575C0);
    border-color: #1E5FA8;
    color: #fff;
    box-shadow: 0 6px 16px rgba(30, 95, 168, .28);
}

.order-step.active .order-step-text,
.order-step.done .order-step-text {
    color: #1E5FA8;
    font-weight: 700;
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

/* ===================== TYPE TABS ===================== */
.order-tabs {
    max-width: 380px;
    margin: 0 auto .85rem;
    display: flex;
    gap: 6px;
    background: #f1f5f9;
    padding: 4px;
    border-radius: 999px;
    border: 1px solid #e2e8f0;
}

.order-tab {
    flex: 1;
    text-align: center;
    padding: 7px 14px;
    border-radius: 999px;
    text-decoration: none;
    font-weight: 700;
    font-size: 0.85rem;
    color: #475569;
    background: transparent;
    transition: all .22s ease;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
}

.order-tab:hover {
    color: #1E5FA8;
}

.order-tab.active {
    background: linear-gradient(135deg, #1E5FA8, #2575C0);
    color: #fff;
    box-shadow: 0 4px 14px rgba(30, 95, 168, .28);
}

/* ===================== CATEGORY FILTER BUTTONS ===================== */
.order-filter-menu {
    display: flex;
    justify-content: center;
    gap: 6px;
    flex-wrap: wrap;
    margin-bottom: 1.15rem;
}

.order-filter-btn {
    padding: 6px 14px;
    border-radius: 999px;
    background: #ffffff;
    color: #334155;
    text-decoration: none;
    text-align: center;
    font-weight: 600;
    font-size: .82rem;
    border: 1px solid #e2e8f0;
    transition: all .22s ease;
    display: inline-flex;
    align-items: center;
    gap: 5px;
    box-shadow: 0 2px 4px rgba(15, 23, 42, .03);
    white-space: nowrap;
}

.order-filter-btn:hover {
    color: #1E5FA8;
    border-color: #cbd5e1;
    transform: translateY(-1px);
}

.order-filter-btn.active {
    background: linear-gradient(135deg, #1E5FA8, #2575C0);
    color: #fff;
    border-color: transparent;
    box-shadow: 0 4px 14px rgba(30, 95, 168, .25);
}

/* ===================== FILTER SEARCH BAR ===================== */
.order-search-box {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 16px;
    padding: .75rem 1rem;
    margin-bottom: 1.5rem;
    box-shadow: 0 2px 10px rgba(15, 23, 42, .03);
}

.order-search-row {
    display: flex;
    gap: 10px;
    align-items: center;
    flex-wrap: wrap;
}

.order-search-wrap {
    flex: 1 1 300px;
    display: flex;
    align-items: center;
    background: #ffffff;
    border: 1.5px solid #cbd5e1;
    border-radius: 12px;
    height: 42px;
    padding: 3px 4px 3px 12px;
    transition: all .2s ease;
}

.order-search-wrap:focus-within {
    border-color: #1E5FA8;
    box-shadow: 0 0 0 3px rgba(30, 95, 168, .12);
}

.order-search-icon {
    color: #94a3b8;
    font-size: .95rem;
    flex-shrink: 0;
    margin-right: 8px;
}

.order-search-input {
    border: none;
    background: transparent;
    outline: none;
    flex: 1;
    min-width: 0;
    font-size: .86rem;
    color: #0f172a;
    height: 100%;
    padding: 0;
}

.order-search-input::placeholder {
    color: #94a3b8;
}

.order-search-clear {
    color: #94a3b8;
    padding: 4px 6px;
    font-size: .85rem;
    line-height: 1;
    text-decoration: none;
    transition: color .15s ease;
    flex-shrink: 0;
}

.order-search-clear:hover {
    color: #ef4444;
}

.btn-order-apply {
    height: 34px;
    padding: 0 14px;
    border-radius: 8px;
    border: 0;
    font-size: .82rem;
    font-weight: 600;
    background: linear-gradient(135deg, #1E5FA8, #2575C0);
    color: #fff;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    transition: all .2s ease;
    box-shadow: 0 2px 6px rgba(30, 95, 168, .2);
    flex-shrink: 0;
}

.btn-order-apply:hover {
    color: #fff;
    transform: translateY(-1px);
    box-shadow: 0 4px 10px rgba(30, 95, 168, .3);
}

.order-search-actions {
    display: flex;
    gap: 8px;
    align-items: center;
    flex-shrink: 0;
}

.order-sort-wrap {
    display: inline-flex;
    align-items: center;
    position: relative;
    background: #ffffff;
    border: 1.5px solid #cbd5e1;
    border-radius: 12px;
    height: 42px;
    padding: 0 28px 0 12px;
    transition: all .2s ease;
}

.order-sort-wrap:hover,
.order-sort-wrap:focus-within {
    border-color: #1E5FA8;
    box-shadow: 0 0 0 3px rgba(30, 95, 168, .1);
}

.order-sort-label {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    font-size: .82rem;
    font-weight: 600;
    color: #64748b;
    white-space: nowrap;
    pointer-events: none;
    margin-right: 4px;
}

.order-sort-label i {
    color: #1E5FA8;
    font-size: .85rem;
}

.order-filter-select {
    appearance: none;
    -webkit-appearance: none;
    -moz-appearance: none;
    border: none;
    background: transparent;
    outline: none;
    font-size: .84rem;
    font-weight: 700;
    color: #1e293b;
    cursor: pointer;
    padding: 0;
    height: 100%;
    box-shadow: none !important;
}

.order-sort-chevron {
    position: absolute;
    right: 10px;
    pointer-events: none;
    font-size: .75rem;
    color: #64748b;
}

.btn-order-reset {
    height: 42px;
    padding: 0 14px;
    border-radius: 12px;
    border: 1.5px solid #cbd5e1;
    background: #ffffff;
    color: #64748b;
    font-size: .82rem;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    text-decoration: none;
    transition: all .2s ease;
    flex-shrink: 0;
}

.btn-order-reset:hover {
    background: #fef2f2;
    border-color: #fca5a5;
    color: #dc2626;
    transform: translateY(-1px);
}

.package-section-title {
    text-align: center;
    font-size: 1.35rem;
    font-weight: 800;
    color: #1E5FA8;
    margin-bottom: .2rem;
}

.package-section-sub {
    text-align: center;
    color: #64748b;
    font-size: .85rem;
    margin-bottom: 1.25rem;
}

/* ===================== COMPACT INTUITIVE PACKAGE CARDS ===================== */
.package-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 14px;
}

.package-option {
    position: relative;
    display: flex;
    flex-direction: column;
}

.package-radio {
    position: absolute;
    opacity: 0;
    pointer-events: none;
}

.package-card {
    border: 1.5px solid #e2e8f0;
    background: #ffffff;
    border-radius: 16px;
    padding: 1rem 1rem .85rem;
    min-height: 100%;
    cursor: pointer;
    transition: all .22s ease;
    position: relative;
    display: flex;
    flex-direction: column;
    box-shadow: 0 2px 8px rgba(15, 23, 42, .03);
}

.package-card:hover {
    transform: translateY(-3px);
    border-color: #93c5fd;
    box-shadow: 0 10px 22px rgba(30, 95, 168, .09);
}

/* SELECTED STATE */
.package-radio:checked + .package-card {
    border-color: #1E5FA8;
    background: linear-gradient(180deg, #f0f7ff 0%, #ffffff 100%);
    box-shadow: 0 0 0 3px rgba(30, 95, 168, .18), 0 12px 26px rgba(30, 95, 168, .12);
}

/* TOP HEADER OF CARD */
.pkg-card-top {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: .6rem;
}

.pkg-speed-pill {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    padding: 3px 8px;
    border-radius: 999px;
    background: #ecfdf5;
    color: #065f46;
    border: 1px solid #a7f3d0;
    font-size: .78rem;
    font-weight: 800;
}

.pkg-radio-indicator {
    width: 20px;
    height: 20px;
    border-radius: 999px;
    border: 2px solid #cbd5e1;
    background: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all .2s ease;
    flex-shrink: 0;
}

.pkg-radio-indicator i {
    display: none;
    font-size: 11px;
    color: #fff;
}

.package-radio:checked + .package-card .pkg-radio-indicator {
    border-color: #1E5FA8;
    background: linear-gradient(135deg, #1E5FA8, #2575C0);
    box-shadow: 0 2px 6px rgba(30, 95, 168, .35);
}

.package-radio:checked + .package-card .pkg-radio-indicator i {
    display: block;
}

/* PACKAGE INFO */
.package-name {
    font-size: .95rem;
    font-weight: 800;
    color: #1e293b;
    margin-bottom: .3rem;
    line-height: 1.3;
}

.package-price-wrap {
    display: flex;
    align-items: baseline;
    gap: 3px;
    margin-bottom: .55rem;
    padding-bottom: .45rem;
    border-bottom: 1px dashed #e2e8f0;
}

.package-price-val {
    font-size: 1.3rem;
    font-weight: 900;
    color: #1E5FA8;
    line-height: 1;
}

.package-price-unit {
    font-size: .78rem;
    color: #64748b;
    font-weight: 600;
}

/* FEATURES COMPACT */
.package-features-list {
    margin: 0;
    padding: 0;
    list-style: none;
    display: flex;
    flex-direction: column;
    gap: 4px;
    margin-bottom: .75rem;
    flex-grow: 1;
}

.package-feature-item {
    font-size: .78rem;
    color: #475569;
    display: flex;
    align-items: flex-start;
    gap: 5px;
    line-height: 1.35;
}

.package-feature-item i {
    color: #10b981;
    font-size: .85rem;
    flex-shrink: 0;
    margin-top: 1px;
}

/* SELECT STATUS FOOTER */
.pkg-status-btn {
    text-align: center;
    padding: 6px 10px;
    border-radius: 8px;
    font-size: .76rem;
    font-weight: 700;
    transition: all .2s ease;
    border: 1px solid #e2e8f0;
    background: #f8fafc;
    color: #64748b;
}

.package-radio:checked + .package-card .pkg-status-btn {
    background: linear-gradient(135deg, #1E5FA8, #2575C0);
    border-color: transparent;
    color: #fff;
    box-shadow: 0 3px 10px rgba(30, 95, 168, .25);
}

.order-footer {
    display: flex;
    justify-content: flex-end;
    margin-top: 1.75rem;
    padding-top: 1rem;
    border-top: 1px solid #e2e8f0;
}

.btn-order-next {
    border-radius: 999px;
    padding: 10px 32px;
    font-weight: 700;
    font-size: .92rem;
    background: linear-gradient(135deg, #1E5FA8, #2575C0);
    color: #fff;
    border: 0;
    box-shadow: 0 8px 20px rgba(30, 95, 168, .22);
    transition: .2s ease;
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
body.dark-mode .order-card {
    background: #0f172a;
    border-color: #1e293b;
    box-shadow: 0 18px 45px rgba(0,0,0,.6);
}

body.dark-mode .order-tabs {
    background: #0b1329;
    border-color: #1e293b;
}

body.dark-mode .order-tab {
    color: #94a3b8;
}

body.dark-mode .order-tab.active {
    color: #fff;
}

body.dark-mode .order-filter-btn {
    background: #1e293b;
    color: #cbd5e1;
    border-color: #334155;
}

body.dark-mode .order-filter-btn:hover {
    color: #fff;
    border-color: #3b82f6;
}

body.dark-mode .order-filter-btn.active {
    background: linear-gradient(135deg, #1E5FA8, #2575C0);
    color: #fff;
    border-color: transparent;
}

body.dark-mode .order-search-box {
    background: #0f172a;
    border-color: #1e293b;
}

body.dark-mode .order-search-wrap,
body.dark-mode .order-sort-wrap,
body.dark-mode .btn-order-reset {
    background: #1e293b;
    border-color: #334155;
    color: #e2e8f0;
}

body.dark-mode .order-search-wrap:focus-within,
body.dark-mode .order-sort-wrap:hover,
body.dark-mode .order-sort-wrap:focus-within {
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, .2);
}

body.dark-mode .order-search-input {
    color: #f1f5f9;
}

body.dark-mode .order-search-input::placeholder {
    color: #64748b;
}

body.dark-mode .order-sort-label {
    color: #94a3b8;
}

body.dark-mode .order-sort-label i {
    color: #60a5fa;
}

body.dark-mode .order-filter-select {
    color: #f1f5f9;
}

body.dark-mode .order-filter-select option {
    background: #1e293b;
    color: #f1f5f9;
}

body.dark-mode .order-sort-chevron {
    color: #94a3b8;
}

body.dark-mode .btn-order-reset {
    color: #94a3b8;
}

body.dark-mode .btn-order-reset:hover {
    background: rgba(239, 68, 68, .15);
    border-color: #ef4444;
    color: #f87171;
}

body.dark-mode .order-title,
body.dark-mode .package-section-title {
    color: #e5e7eb;
}

body.dark-mode .package-card {
    background: #1e293b;
    border-color: #334155;
    box-shadow: none;
}

body.dark-mode .package-radio:checked + .package-card {
    border-color: #3b82f6;
    background: linear-gradient(180deg, rgba(30, 95, 168, 0.25) 0%, #1e293b 100%);
    box-shadow: 0 0 0 3px rgba(59, 130, 246, .25);
}

body.dark-mode .package-name {
    color: #f1f5f9;
}

body.dark-mode .package-feature-item {
    color: #cbd5e1;
}

body.dark-mode .package-price-wrap {
    border-bottom-color: #334155;
}

body.dark-mode .pkg-status-btn {
    background: #0f172a;
    border-color: #334155;
    color: #94a3b8;
}

body.dark-mode .pkg-speed-pill {
    background: rgba(16, 185, 129, 0.15);
    border-color: rgba(16, 185, 129, 0.3);
    color: #34d399;
}

/* ===================== RESPONSIVE (MOBILE & TABLET) ===================== */
@media (max-width: 1100px) {
    .package-grid {
        grid-template-columns: repeat(2, 1fr);
    }
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

    .order-header {
        margin-bottom: .85rem;
    }

    .order-title {
        font-size: 1.35rem;
    }

    .order-subtitle {
        font-size: .8rem;
    }

    .order-tabs {
        max-width: 100%;
        margin-bottom: .65rem;
    }

    .order-tab {
        font-size: .8rem;
        padding: 6px 10px;
    }

    .order-filter-menu {
        gap: 5px;
        margin-bottom: .85rem;
        overflow-x: auto;
        flex-wrap: nowrap;
        justify-content: flex-start;
        padding-bottom: 4px;
        -webkit-overflow-scrolling: touch;
        scrollbar-width: none;
    }

    .order-filter-menu::-webkit-scrollbar {
        display: none;
    }

    .order-filter-btn {
        font-size: .76rem;
        padding: 5px 11px;
    }

    .order-search-box {
        padding: .65rem .75rem;
        margin-bottom: 1.15rem;
        border-radius: 14px;
    }

    .order-search-row {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .order-search-wrap {
        width: 100% !important;
        flex: 1 1 100% !important;
        height: 40px;
    }

    .order-search-input {
        font-size: .82rem;
    }

    .btn-order-apply {
        height: 32px;
        padding: 0 12px;
        font-size: .78rem;
    }

    .order-search-actions {
        display: flex;
        gap: 8px;
        width: 100%;
    }

    .order-sort-wrap {
        height: 40px;
        flex: 1;
        width: 100%;
    }

    .order-filter-select {
        font-size: .8rem;
        flex: 1;
        width: 100%;
    }

    .btn-order-reset {
        height: 40px;
        font-size: .78rem;
        padding: 0 12px;
    }

    .package-section-title {
        font-size: 1.15rem;
    }

    .package-section-sub {
        font-size: .78rem;
        margin-bottom: .85rem;
    }

    .package-grid {
        grid-template-columns: 1fr;
        gap: 10px;
    }

    .package-card {
        padding: .85rem .85rem .75rem;
        border-radius: 14px;
    }

    .package-name {
        font-size: .92rem;
    }

    .package-price-val {
        font-size: 1.2rem;
    }

    .order-footer {
        margin-top: 1.25rem;
        padding-top: .85rem;
    }

    .order-footer .btn-order-next {
        width: 100%;
        justify-content: center;
        font-size: .88rem;
        padding: 9px 20px;
    }
}

/* ===================== ADD-ONS COLLAPSIBLE SECTION ===================== */
.order-addons-wrapper {
    margin-top: 1.75rem;
    margin-bottom: .5rem;
}

.order-addons-banner {
    background: #ffffff;
    border: 1.5px dashed #cbd5e1;
    border-radius: 18px;
    padding: 1.1rem 1.4rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
    transition: all .25s ease;
}

.order-addons-banner:hover {
    border-color: #1E5FA8;
    background: #f8fafc;
}

.order-addons-banner.is-active {
    border-style: solid;
    border-color: #1E5FA8;
    background: linear-gradient(135deg, #f0f7ff, #ffffff);
    box-shadow: 0 4px 16px rgba(30, 95, 168, .08);
}

.addons-banner-left {
    display: flex;
    align-items: center;
    gap: 14px;
}

.addons-banner-icon {
    width: 44px;
    height: 44px;
    border-radius: 12px;
    background: #eff6ff;
    color: #1E5FA8;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.35rem;
    flex-shrink: 0;
}

.addons-banner-title {
    font-size: 1rem;
    font-weight: 700;
    color: #0f172a;
    display: flex;
    align-items: center;
    gap: 8px;
    flex-wrap: wrap;
}

.addons-banner-sub {
    font-size: .83rem;
    color: #64748b;
    margin-top: 2px;
}

.btn-addon-toggle {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 8px 18px;
    border-radius: 999px;
    font-size: .85rem;
    font-weight: 700;
    border: 1.5px solid #1E5FA8;
    color: #1E5FA8;
    background: #ffffff;
    transition: all .2s ease;
    white-space: nowrap;
    box-shadow: 0 2px 8px rgba(30, 95, 168, .08);
}

.btn-addon-toggle:hover {
    background: #1E5FA8;
    color: #ffffff;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(30, 95, 168, .2);
}

.btn-addon-toggle.active {
    background: linear-gradient(135deg, #1E5FA8, #2575C0);
    color: #ffffff;
    border-color: transparent;
    box-shadow: 0 4px 14px rgba(30, 95, 168, .25);
}

.addons-count-badge {
    background: #22c55e;
    color: #ffffff;
    font-size: .72rem;
    font-weight: 800;
    padding: 2px 7px;
    border-radius: 999px;
    margin-left: 2px;
}

.order-addons-collapse {
    display: none;
    margin-top: 1rem;
    animation: fadeInSlide .3s ease forwards;
}

.order-addons-collapse.show {
    display: block;
}

@keyframes fadeInSlide {
    from {
        opacity: 0;
        transform: translateY(-8px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.addons-collapse-inner {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 20px;
    padding: 1.25rem;
}

.addons-helper-text {
    font-size: .84rem;
    color: #475569;
    margin-bottom: 1rem;
    font-weight: 500;
}

.order-addons-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 12px;
}

.order-addon-card {
    position: relative;
    cursor: pointer;
    background: #ffffff;
    border: 1.5px solid #e2e8f0;
    border-radius: 16px;
    padding: 1rem;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    transition: all .2s ease;
    user-select: none;
}

.order-addon-card:hover {
    border-color: #94a3b8;
    transform: translateY(-2px);
    box-shadow: 0 6px 18px rgba(15, 23, 42, .06);
}

.order-addon-card.selected {
    border-color: #1E5FA8;
    background: linear-gradient(180deg, #f0f7ff 0%, #ffffff 100%);
    box-shadow: 0 0 0 2px rgba(30, 95, 168, .2), 0 6px 18px rgba(30, 95, 168, .12);
}

.addon-checkbox {
    position: absolute;
    opacity: 0;
    pointer-events: none;
}

.addon-card-head {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: .65rem;
}

.addon-cat-tag {
    font-size: .72rem;
    font-weight: 700;
    color: #64748b;
    background: #f1f5f9;
    padding: 2px 8px;
    border-radius: 6px;
    display: inline-flex;
    align-items: center;
    gap: 4px;
}

.addon-check-indicator {
    width: 22px;
    height: 22px;
    border-radius: 6px;
    border: 1.5px solid #cbd5e1;
    background: #ffffff;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 13px;
    color: transparent;
    transition: all .2s ease;
}

.order-addon-card.selected .addon-check-indicator {
    background: #1E5FA8;
    border-color: #1E5FA8;
    color: #ffffff;
}

.addon-card-body {
    margin-bottom: .85rem;
}

.addon-name {
    font-size: .95rem;
    font-weight: 800;
    color: #0f172a;
    line-height: 1.25;
    margin-bottom: 4px;
}

.addon-desc {
    font-size: .78rem;
    color: #64748b;
    line-height: 1.35;
}

.addon-card-footer {
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    padding-top: .65rem;
    border-top: 1px solid #f1f5f9;
}

.addon-price-num {
    font-size: .92rem;
    font-weight: 800;
    color: #1E5FA8;
    display: block;
}

.addon-price-period {
    font-size: .72rem;
    color: #94a3b8;
    font-weight: 500;
}

.addon-btn-state {
    font-size: .75rem;
    font-weight: 700;
    padding: 3px 8px;
    border-radius: 6px;
    background: #f1f5f9;
    color: #475569;
    transition: all .2s ease;
}

.order-addon-card.selected .addon-btn-state {
    background: #dbeafe;
    color: #1E5FA8;
}

/* Dark mode for Addons */
body.dark-mode .order-addons-banner {
    background: #111827;
    border-color: #334155;
}

body.dark-mode .order-addons-banner.is-active {
    background: #1e293b;
    border-color: #3b82f6;
}

body.dark-mode .addons-banner-icon {
    background: #1e293b;
    color: #60a5fa;
}

body.dark-mode .addons-banner-title {
    color: #f1f5f9;
}

body.dark-mode .addons-collapse-inner {
    background: #0f172a;
    border-color: #1e293b;
}

body.dark-mode .order-addon-card {
    background: #1e293b;
    border-color: #334155;
}

body.dark-mode .order-addon-card.selected {
    background: #1e293b;
    border-color: #3b82f6;
    box-shadow: 0 0 0 2px rgba(59, 130, 246, .3);
}

body.dark-mode .addon-name {
    color: #f1f5f9;
}

body.dark-mode .addon-cat-tag {
    background: #334155;
    color: #cbd5e1;
}

body.dark-mode .addon-card-footer {
    border-top-color: #334155;
}

/* Responsive Addons */
@media (max-width: 991px) {
    .order-addons-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 768px) {
    .order-addons-banner {
        flex-direction: column;
        align-items: flex-start;
        gap: 12px;
    }

    .btn-addon-toggle {
        width: 100%;
        justify-content: center;
    }

    .order-addons-grid {
        grid-template-columns: 1fr;
    }
}
</style>

@php
    $categoryLabels = [
        ''              => 'Semua',
        'internet_only' => 'Internet Only',
        'internet_tv'   => 'Internet + TV',
        'streaming'     => 'Streaming',
    ];

    $categoryIcons = [
        ''              => 'bi-grid-fill',
        'internet_only' => 'bi-wifi',
        'internet_tv'   => 'bi-tv-fill',
        'streaming'     => 'bi-play-circle-fill',
    ];

    $currentType = $type ?? request('type', 'home');
    $currentCategory = $category ?? request('category', '');
    $currentSort = $sort ?? request('sort', '');
    $currentQ = $q ?? request('q', '');

    function filterUrl($params = []) {
        return route('public.order.step1', array_merge(request()->query(), $params));
    }
@endphp

<div class="order-wrap">
    {{-- STEP PROGRESS --}}
    <div class="order-steps">
        <div class="order-step active">
            <span class="order-step-badge">1</span>
            <span class="order-step-text">Pilih Paket</span>
        </div>
        <div class="order-step-line"></div>
        <div class="order-step">
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
            <h1 class="order-title">Pilih Paket Internet</h1>
            <p class="order-subtitle">Pilih paket terbaik yang sesuai dengan kebutuhan rumah atau bisnis Anda</p>
        </div>

        @if($errors->any())
            <div class="alert alert-danger mb-3 p-2 px-3 small">
                <ul class="mb-0 ps-3">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- TYPE TABS (Home Retail / Bisnis) --}}
        <div class="order-tabs">
            <a href="{{ filterUrl(['type' => 'home']) }}"
               class="order-tab {{ $currentType === 'home' ? 'active' : '' }}">
                <i class="bi bi-house-door-fill"></i> Home Retail
            </a>

            <a href="{{ filterUrl(['type' => 'business']) }}"
               class="order-tab {{ $currentType === 'business' ? 'active' : '' }}">
                <i class="bi bi-building"></i> Bisnis
            </a>
        </div>

        {{-- CATEGORY FILTER BUTTONS (Compact pill chips) --}}
        <div class="order-filter-menu">
            @foreach($categoryLabels as $value => $label)
                <a href="{{ filterUrl(['category' => $value]) }}"
                   class="order-filter-btn {{ $currentCategory === $value ? 'active' : '' }}">
                    <i class="bi {{ $categoryIcons[$value] ?? 'bi-tag-fill' }}"></i> {{ $label }}
                </a>
            @endforeach
        </div>

        {{-- FILTER SEARCH & SORT BAR --}}
        <div class="order-search-box">
            <form method="GET" action="{{ route('public.order.step1') }}">
                <input type="hidden" name="type" value="{{ $currentType }}">
                <input type="hidden" name="category" value="{{ $currentCategory }}">

                <div class="order-search-row">
                    <div class="order-search-wrap">
                        <i class="bi bi-search order-search-icon"></i>
                        <input
                            type="text"
                            name="q"
                            class="order-search-input"
                            value="{{ $currentQ }}"
                            placeholder="Cari nama paket atau kecepatan..."
                            autocomplete="off"
                        >
                        @if($currentQ)
                            <a href="{{ filterUrl(['q' => null]) }}" class="order-search-clear" title="Hapus pencarian">
                                <i class="bi bi-x-circle-fill"></i>
                            </a>
                        @endif
                        <button type="submit" class="btn-order-apply" title="Cari paket">
                            <i class="bi bi-search"></i>
                            <span>Cari</span>
                        </button>
                    </div>

                    <div class="order-search-actions">
                        <div class="order-sort-wrap">
                            <span class="order-sort-label">
                                <i class="bi bi-arrow-down-up"></i>
                                <span>Urutkan:</span>
                            </span>
                            <select name="sort" class="order-filter-select" onchange="this.form.submit()">
                                <option value="">Rekomendasi</option>
                                <option value="price_asc" {{ $currentSort === 'price_asc' ? 'selected' : '' }}>Harga Termurah</option>
                                <option value="price_desc" {{ $currentSort === 'price_desc' ? 'selected' : '' }}>Harga Termahal</option>
                                <option value="speed_desc" {{ $currentSort === 'speed_desc' ? 'selected' : '' }}>Kecepatan Tertinggi</option>
                            </select>
                            <i class="bi bi-chevron-down order-sort-chevron"></i>
                        </div>

                        @if($currentQ || $currentSort || $currentCategory)
                            <a href="{{ route('public.order.step1', ['type' => $currentType]) }}" class="btn-order-reset" title="Reset filter">
                                <i class="bi bi-arrow-counterclockwise"></i>
                                <span>Reset</span>
                            </a>
                        @endif
                    </div>
                </div>
            </form>
        </div>

        <div class="package-section-title">Daftar Paket Tersedia</div>
        <div class="package-section-sub">Menampilkan <strong>{{ $packages->count() }}</strong> paket untuk tipe <strong>{{ $currentType === 'business' ? 'Bisnis' : 'Home Retail' }}</strong></div>

        <form method="POST" action="{{ route('public.order.storeStep1') }}">
            @csrf

            <div class="package-grid">
                @foreach($packages as $package)
                    @php
                        $features = collect(preg_split("/\r\n|\n|\r|,/", $package->features ?? ''))
                            ->map(fn($item) => trim($item))
                            ->filter()
                            ->values()
                            ->take(2);
                    @endphp

                    <label class="package-option">
                        <input
                            type="radio"
                            name="package_id"
                            value="{{ $package->id }}"
                            class="package-radio"
                            {{ (old('package_id', $selectedPackageId) == $package->id) ? 'checked' : '' }}
                        >

                        <div class="package-card">
                            <div class="pkg-card-top">
                                <span class="pkg-speed-pill">
                                    <i class="bi bi-lightning-charge-fill"></i> {{ $package->speed_mbps }} Mbps
                                </span>
                                <span class="pkg-radio-indicator">
                                    <i class="bi bi-check-lg"></i>
                                </span>
                            </div>

                            <div class="package-name">{{ $package->name }}</div>

                            <div class="package-price-wrap">
                                <span class="package-price-val">
                                    Rp {{ number_format((float) $package->price_monthly, 0, ',', '.') }}
                                </span>
                                <span class="package-price-unit">/bln</span>
                            </div>

                            <ul class="package-features-list">
                                @forelse($features as $feature)
                                    <li class="package-feature-item">
                                        <i class="bi bi-check2-circle"></i>
                                        <span>{{ $feature }}</span>
                                    </li>
                                @empty
                                    <li class="package-feature-item">
                                        <i class="bi bi-check2-circle"></i>
                                        <span>Internet Full Fiber Optic</span>
                                    </li>
                                    <li class="package-feature-item">
                                        <i class="bi bi-check2-circle"></i>
                                        <span>Unlimited tanpa batas FUP</span>
                                    </li>
                                @endforelse
                            </ul>

                            <div class="pkg-status-btn">
                                @if(old('package_id', $selectedPackageId) == $package->id)
                                    <i class="bi bi-check-circle-fill me-1"></i> Paket Dipilih
                                @else
                                    Pilih Paket Ini
                                @endif
                            </div>
                        </div>
                    </label>
                @endforeach
            </div>

            {{-- ADDONS OPTIONAL COLLAPSIBLE SECTION --}}
            @if(isset($addons) && $addons->count() > 0)
                @php
                    $hasSelectedAddons = !empty($selectedAddonIds) && count($selectedAddonIds) > 0;
                @endphp

                <div class="order-addons-wrapper">
                    {{-- Trigger Banner --}}
                    <div class="order-addons-banner {{ $hasSelectedAddons ? 'is-active' : '' }}" id="addonsBanner">
                        <div class="addons-banner-left">
                            <div class="addons-banner-icon">
                                <i class="bi bi-puzzle-fill"></i>
                            </div>
                            <div>
                                <div class="addons-banner-title">
                                    Layanan &amp; Perangkat Tambahan (Add-on)
                                    <span class="badge bg-light text-primary border ms-1 fw-semibold">Opsional</span>
                                </div>
                                <p class="addons-banner-sub mb-0">
                                    Tingkatkan konektivitas dengan WiFi Extender, Android TV Box, Router Tambahan, atau Hiburan Streaming.
                                </p>
                            </div>
                        </div>

                        <div class="addons-banner-action">
                            <button type="button" class="btn btn-addon-toggle {{ $hasSelectedAddons ? 'active' : '' }}" id="btnToggleAddons">
                                <i class="bi {{ $hasSelectedAddons ? 'bi-dash-circle-fill' : 'bi-plus-circle-fill' }}" id="toggleAddonIcon"></i>
                                <span id="toggleAddonText">{{ $hasSelectedAddons ? 'Tutup Add-on' : 'Tambah Add-on' }}</span>
                                <span class="addons-count-badge {{ $hasSelectedAddons ? '' : 'd-none' }}" id="addonCountBadge">
                                    {{ count($selectedAddonIds) }} Dipilih
                                </span>
                            </button>
                        </div>
                    </div>

                    {{-- Collapsible Content --}}
                    <div class="order-addons-collapse {{ $hasSelectedAddons ? 'show' : '' }}" id="addonsCollapse">
                        <div class="addons-collapse-inner">
                            <div class="addons-helper-text">
                                <i class="bi bi-info-circle me-1 text-primary"></i>
                                Klik pada kartu add-on untuk memilih atau membatalkan pilihan (bisa pilih lebih dari satu):
                            </div>

                            <div class="order-addons-grid">
                                @foreach($addons as $addon)
                                    @php
                                        $isChecked = in_array($addon->id, old('addon_ids', $selectedAddonIds ?? []));
                                        $pricingTypeLabel = $addon->pricing_type === 'monthly' ? '/bln' : 'sekali bayar';

                                        $catIcons = [
                                            'cctv'           => 'bi-camera-video-fill',
                                            'network-device' => 'bi-router-fill',
                                            'smart-home'     => 'bi-house-gear-fill',
                                            'stb-android'    => 'bi-tv-fill',
                                            'streaming'      => 'bi-play-circle-fill',
                                        ];
                                        $icon = $catIcons[$addon->category] ?? 'bi-box-seam-fill';
                                    @endphp

                                    <label class="order-addon-card {{ $isChecked ? 'selected' : '' }}" for="addon_{{ $addon->id }}">
                                        <input
                                            type="checkbox"
                                            name="addon_ids[]"
                                            value="{{ $addon->id }}"
                                            id="addon_{{ $addon->id }}"
                                            class="addon-checkbox"
                                            {{ $isChecked ? 'checked' : '' }}
                                        >

                                        <div class="addon-card-head">
                                            <span class="addon-cat-tag">
                                                <i class="bi {{ $icon }}"></i>
                                                {{ ucfirst(str_replace('-', ' ', $addon->category ?? 'Add-on')) }}
                                            </span>
                                            <span class="addon-check-indicator">
                                                <i class="bi bi-check-lg"></i>
                                            </span>
                                        </div>

                                        <div class="addon-card-body">
                                            <div class="addon-name">{{ $addon->name }}</div>
                                            @if($addon->short_description)
                                                <div class="addon-desc">{{ Str::limit($addon->short_description, 75) }}</div>
                                            @endif
                                        </div>

                                        <div class="addon-card-footer">
                                            <div class="addon-price">
                                                <span class="addon-price-num">Rp {{ number_format((float) $addon->price, 0, ',', '.') }}</span>
                                                <span class="addon-price-period">{{ $pricingTypeLabel }}</span>
                                            </div>
                                            <span class="addon-btn-state">
                                                {{ $isChecked ? '✓ Dipilih' : '+ Pilih' }}
                                            </span>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="order-footer">
                <button type="submit" class="btn-order-next">
                    Lanjut ke Data Pemesan <i class="bi bi-arrow-right"></i>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const btnToggle = document.getElementById('btnToggleAddons');
    const collapseSection = document.getElementById('addonsCollapse');
    const banner = document.getElementById('addonsBanner');
    const toggleIcon = document.getElementById('toggleAddonIcon');
    const toggleText = document.getElementById('toggleAddonText');
    const countBadge = document.getElementById('addonCountBadge');
    const addonCheckboxes = document.querySelectorAll('.addon-checkbox');

    function updateAddonCounter() {
        const checkedCount = document.querySelectorAll('.addon-checkbox:checked').length;
        if (countBadge) {
            countBadge.textContent = checkedCount + ' Dipilih';
            if (checkedCount > 0) {
                countBadge.classList.remove('d-none');
                banner?.classList.add('is-active');
            } else {
                countBadge.classList.add('d-none');
                if (!collapseSection?.classList.contains('show')) {
                    banner?.classList.remove('is-active');
                }
            }
        }
    }

    if (btnToggle && collapseSection) {
        btnToggle.addEventListener('click', function () {
            const isShowing = collapseSection.classList.contains('show');
            if (isShowing) {
                collapseSection.classList.remove('show');
                btnToggle.classList.remove('active');
                if (toggleIcon) toggleIcon.className = 'bi bi-plus-circle-fill';
                if (toggleText) toggleText.textContent = 'Tambah Add-on';
                const checkedCount = document.querySelectorAll('.addon-checkbox:checked').length;
                if (checkedCount === 0) {
                    banner?.classList.remove('is-active');
                }
            } else {
                collapseSection.classList.add('show');
                btnToggle.classList.add('active');
                banner?.classList.add('is-active');
                if (toggleIcon) toggleIcon.className = 'bi bi-dash-circle-fill';
                if (toggleText) toggleText.textContent = 'Tutup Add-on';
            }
        });
    }

    addonCheckboxes.forEach(function (cb) {
        cb.addEventListener('change', function () {
            const card = this.closest('.order-addon-card');
            const stateBtn = card?.querySelector('.addon-btn-state');
            if (this.checked) {
                card?.classList.add('selected');
                if (stateBtn) stateBtn.textContent = '✓ Dipilih';
            } else {
                card?.classList.remove('selected');
                if (stateBtn) stateBtn.textContent = '+ Pilih';
            }
            updateAddonCounter();
        });
    });

    updateAddonCounter();
});
</script>
@endsection