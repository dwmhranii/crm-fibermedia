@extends('public.layouts.public')

@push('styles')
    <link rel="stylesheet"
          href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
          integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
          crossorigin=""/>

    <style>
        .fiber-area-page {
            padding: 40px 0 70px;
        }

        .fiber-hero {
            text-align: center;
        }

        .fiber-map-wrapper {
            max-width: 980px;
            margin: 0 auto 24px auto;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 22px 45px rgba(0,0,0,0.20);
            position: relative;
            background: radial-gradient(circle at top left,
                rgba(255,255,255,0.22) 0,
                rgba(0,54,130,0.2) 30%,
                rgba(0,0,0,0.75) 100%);
        }

        #coverageMap {
            width: 100%;
            height: 420px;
        }

        .fiber-map-wrapper::after {
            content: "";
            position: absolute;
            left: 0;
            right: 0;
            bottom: -1px;
            height: 80px;
            background: linear-gradient(
                to bottom,
                rgba(248,249,250,0) 0%,
                rgba(248,249,250,1) 100%
            );
            pointer-events: none;
        }

        .fiber-title {
            font-weight: 800;
            font-size: 2rem;
            color: #003682;
            margin-bottom: 4px;
        }

        .fiber-subtitle {
            font-size: .95rem;
            color: #6b7280;
            margin-bottom: 20px;
        }

        .fiber-search-wrapper {
            position: relative;
            max-width: 720px;
            margin: 0 auto;
        }

        .fiber-search-input {
            border-radius: 999px;
            padding: 14px 20px 14px 52px;
            font-size: 1.05rem;
            box-shadow: 0 10px 26px rgba(15,23,42,0.20);
            border: 1px solid #dbe2f0;
            background-color: #ffffff;
        }

        .fiber-search-icon {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 1.3rem;
            color: #003682;
            z-index: 2;
        }

        .fiber-results {
            max-width: 720px;
            margin: 14px auto 0 auto;
            position: relative;
            z-index: 9999;
        }

        .fiber-results-box {
            border-radius: 18px;
            overflow: hidden;
            background: #ffffff;
            box-shadow: 0 10px 26px rgba(15,23,42,0.18);
            text-align: left;
        }

        .fiber-result-item {
            display: block;
            width: 100%;
            padding: 12px 18px;
            font-size: .98rem;
            border: none;
            border-bottom: 1px solid #e5e7eb;
            background: #fff;
            cursor: pointer;
            text-align: left;
        }

        .fiber-result-item:last-child {
            border-bottom: none;
        }

        .fiber-result-item:hover {
            background: #e5f0ff;
        }

        .fiber-result-item small {
            opacity: .8;
        }

        .coverage-info {
            font-size: .9rem;
            color: #6b7280;
            margin-top: 24px;
            text-align: center;
        }

        /* ===== PULSE MARKER ===== */
        .coverage-pulse-marker {
            position: relative;
            width: 18px;
            height: 18px;
        }

        .coverage-pulse-marker .pulse-core {
            position: absolute;
            inset: 0;
            border-radius: 999px;
            background: linear-gradient(135deg, #003682, #5bab23);
            border: 3px solid #ffffff;
            box-shadow: 0 0 0 3px rgba(0,54,130,.18);
            z-index: 3;
        }

        .coverage-pulse-marker .pulse-ring {
            position: absolute;
            left: 50%;
            top: 50%;
            width: 18px;
            height: 18px;
            transform: translate(-50%, -50%);
            border-radius: 999px;
            border: 2px solid rgba(91,171,35,.65);
            background: rgba(91,171,35,.12);
            animation: coveragePulse 2.2s ease-out infinite;
            z-index: 1;
        }

        .coverage-pulse-marker .pulse-ring.ring-2 {
            animation-delay: .8s;
        }

        .coverage-pulse-marker.active .pulse-core {
            background: linear-gradient(135deg, #0b63a8, #22c55e);
            box-shadow: 0 0 0 5px rgba(91,171,35,.20);
        }

        @keyframes coveragePulse {
            0% {
                width: 18px;
                height: 18px;
                opacity: .75;
            }
            70% {
                width: 52px;
                height: 52px;
                opacity: 0;
            }
            100% {
                width: 52px;
                height: 52px;
                opacity: 0;
            }
        }

        body.dark-mode .fiber-search-input {
            background-color: #020617;
            border-color: #1f2937;
            color: #e5e7eb;
        }

        body.dark-mode .fiber-results-box {
            background: #020617;
        }

        body.dark-mode .fiber-result-item {
            color: #e5e7eb;
            border-color: #1f2937;
            background: #020617;
        }

        body.dark-mode .fiber-result-item:hover {
            background: #111827;
        }

        @media (max-width: 768px) {
            #coverageMap {
                height: 320px;
            }

            .fiber-title {
                font-size: 1.6rem;
            }
        }
        .leaflet-interactive {
            transition: all .25s ease;
        }
    </style>
@endpush

@section('content')
<div class="container">
    <div class="fiber-area-page">
        <section class="fiber-hero">
            <div class="fiber-map-wrapper">
                <div id="coverageMap"></div>
            </div>

            <h2 class="fiber-title">{{ $pageHeading }}</h2>
            <p class="fiber-subtitle">{{ $pageSubtitle }}</p>

            <div class="fiber-search-wrapper">
                <span class="fiber-search-icon">
                    <i class="bi bi-search"></i>
                </span>
                <input
                    type="text"
                    id="searchBox"
                    class="form-control fiber-search-input"
                    placeholder="Search your area (contoh: Bululawang, Gadang, Malang)">
            </div>

            <div id="coverageResults" class="fiber-results" style="display: none;">
                <div class="fiber-results-box">
                    <div id="resultList"></div>
                </div>
            </div>
        </section>

        <div class="coverage-info">
            <i class="bi bi-info-circle"></i>
            Saat ini ter-cover <strong>{{ $coverages->count() }}</strong> wilayah di Malang Raya.
            Ketik minimal 2 huruf untuk mulai mencari.
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
        crossorigin=""></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const areas = @json($coveragesForMap ?? []);

    const mapEl = document.getElementById('coverageMap');
    const searchBox = document.getElementById('searchBox');
    const coverageResults = document.getElementById('coverageResults');
    const resultList = document.getElementById('resultList');

    let map = null;
    let markerLayer = null;
    let coverageLayer = null;
    const markerMap = {};

    // Radius coverage visual
    // Ubah angka ini sesuai kebutuhan
    // 3000 = 3 km
    const COVERAGE_RADIUS = 250;

    function normalizeText(value) {
        return String(value || '').toLowerCase().trim();
    }

    function escapeHtml(value) {
        return String(value || '')
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }

    function resetAllCoverageStyles() {
        Object.values(markerMap).forEach(function(item) {
            if (item.marker) {
                item.marker.setStyle({
                    radius: 6,
                    color: '#ffffff',
                    weight: 2,
                    fillColor: '#003682',
                    fillOpacity: 1
                });
            }

            if (item.coverage) {
                item.coverage.setStyle({
                    color: '#ef4444',
                    weight: 2,
                    opacity: 0.95,
                    fillColor: '#ef4444',
                    fillOpacity: 0.12
                });
            }
        });
    }

    function activateArea(areaId, zoom = 13) {
        const selected = markerMap[areaId];
        if (!selected || !map) return;

        resetAllCoverageStyles();

        selected.marker.setStyle({
            radius: 7,
            color: '#ffffff',
            weight: 3,
            fillColor: '#2563eb',
            fillOpacity: 1
        });

        selected.coverage.setStyle({
            color: '#dc2626',
            weight: 3,
            opacity: 1,
            fillColor: '#ef4444',
            fillOpacity: 0.18
        });

        map.fitBounds(selected.coverage.getBounds(), {
            padding: [40, 40]
        });

        selected.marker.openPopup();
    }

    if (mapEl && typeof L !== 'undefined') {
        map = L.map('coverageMap', { scrollWheelZoom: false });

        const malangCenter = [-7.98, 112.63];
        map.setView(malangCenter, 11);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; OpenStreetMap'
        }).addTo(map);

        coverageLayer = L.featureGroup().addTo(map);
        markerLayer = L.featureGroup().addTo(map);

        areas.forEach(function(area) {
            const lat = parseFloat(area.lat);
            const lng = parseFloat(area.lng);

            if (!isNaN(lat) && !isNaN(lng)) {
                // Lingkaran area coverage
                const coverageCircle = L.circle([lat, lng], {
                    radius: COVERAGE_RADIUS,
                    color: '#ef4444',
                    weight: 2,
                    opacity: 0.95,
                    fillColor: '#ef4444',
                    fillOpacity: 0.12
                }).bindPopup(
                    '<strong>' + escapeHtml(area.name || '-') + '</strong><br>' +
                    (area.district ? escapeHtml(area.district) + '<br>' : '') +
                    (area.city ? escapeHtml(area.city) + '<br>' : '') +
                    '<span style="font-size:11px;color:#555;">Area coverage sekitar ' + (COVERAGE_RADIUS / 1000) + ' km dari titik pusat</span>'
                );

                // Titik pusat
                const centerMarker = L.circleMarker([lat, lng], {
                    radius: 6,
                    color: '#ffffff',
                    weight: 2,
                    fillColor: '#003682',
                    fillOpacity: 1
                }).bindPopup(
                    '<strong>' + escapeHtml(area.name || '-') + '</strong><br>' +
                    (area.district ? escapeHtml(area.district) + '<br>' : '') +
                    (area.city ? escapeHtml(area.city) + '<br>' : '') +
                    '<span style="font-size:11px;color:#555;">Titik pusat coverage FibermediaPlay</span>'
                );

                coverageCircle.on('click', function () {
                    activateArea(area.id);
                });

                centerMarker.on('click', function () {
                    activateArea(area.id);
                });

                coverageLayer.addLayer(coverageCircle);
                markerLayer.addLayer(centerMarker);

                markerMap[area.id] = {
                    marker: centerMarker,
                    coverage: coverageCircle,
                    lat: lat,
                    lng: lng
                };
            }
        });

        const allLayers = L.featureGroup([
            ...coverageLayer.getLayers(),
            ...markerLayer.getLayers()
        ]);

        if (allLayers.getLayers().length > 0) {
            map.fitBounds(allLayers.getBounds(), { padding: [30, 30] });
        }
    }

    function showResults(items) {
        resultList.innerHTML = '';

        if (items.length === 0) {
            resultList.innerHTML = `
                <div class="fiber-result-item text-muted">
                    Wilayah tidak ditemukan dalam database kami.
                </div>
            `;
            coverageResults.style.display = 'block';
            return;
        }

        items.forEach(function(area) {
            const btn = document.createElement('button');
            btn.type = 'button';
            btn.className = 'fiber-result-item';

            btn.innerHTML =
                '📍 <strong>' + escapeHtml(area.name || '-') + '</strong><br>' +
                '<small>' +
                escapeHtml(area.district || '') +
                ((area.district && area.city) ? ', ' : '') +
                escapeHtml(area.city || 'Malang') +
                '</small>';

            btn.addEventListener('click', function() {
                activateArea(area.id);
                searchBox.value = area.name || '';
                coverageResults.style.display = 'none';
            });

            resultList.appendChild(btn);
        });

        coverageResults.style.display = 'block';
    }

    function searchAreas(query) {
        const q = normalizeText(query);

        if (q.length < 2) {
            coverageResults.style.display = 'none';
            resultList.innerHTML = '';
            return;
        }

        const filtered = areas.filter(function(area) {
            const text = [
                area.name,
                area.district,
                area.city
            ].map(normalizeText).join(' ');

            return text.includes(q);
        });

        showResults(filtered);
    }

    if (searchBox) {
        searchBox.addEventListener('input', function() {
            searchAreas(this.value);
        });
    }

    document.addEventListener('click', function(e) {
        if (!e.target.closest('.fiber-search-wrapper') && !e.target.closest('#coverageResults')) {
            coverageResults.style.display = 'none';
        }
    });
});
</script>
@endpush