    @php($editing = isset($coverage))

    @push('styles')
        {{-- Leaflet CSS --}}
        <link rel="stylesheet"
            href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
            integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
            crossorigin=""/>

        <style>
            .map-wrap{
                border-radius: 18px;
                overflow: hidden;
                border: 1px solid #e5e7eb;
                box-shadow: 0 14px 35px rgba(15,23,42,.08);
                background: #fff;
            }
            #adminCoverageMap{
                width: 100%;
                height: 360px;
            }
            body.admin-body.dark .map-wrap{
                background:#0f172a;
                border-color:#1f2937;
                box-shadow: 0 18px 55px rgba(0,0,0,.35);
            }
        </style>
    @endpush

    <div class="row g-3">
        <div class="col-lg-6">
            <label class="form-label fw-semibold">
                Nama Area <span class="text-danger">*</span>
            </label>
            <input type="text" name="name" class="form-control"
                value="{{ old('name', $coverage->name ?? '') }}" required>
            <div class="form-text">Contoh: Wonokoyo / Tlogowaru / Gadang</div>
            @error('name') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
        </div>

        <div class="col-lg-3">
            <label class="form-label fw-semibold">Kecamatan</label>
            <input type="text" name="district" class="form-control"
                value="{{ old('district', $coverage->district ?? '') }}"
                placeholder="ex: Kedungkandang">
            @error('district') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
        </div>

        <div class="col-lg-3">
            <label class="form-label fw-semibold">Kota</label>
            <input type="text" name="city" class="form-control"
                value="{{ old('city', $coverage->city ?? 'Malang') }}"
                placeholder="ex: Kota Malang / Kab. Malang">
            <div class="form-text">Boleh isi: Kota Malang / Kab. Malang</div>
            @error('city') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
        </div>

        <div class="col-lg-3">
            <label class="form-label fw-semibold">Sort Order</label>
            <input type="number" min="0" name="sort_order" class="form-control"
                value="{{ old('sort_order', $coverage->sort_order ?? 0) }}">
            @error('sort_order') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
        </div>

        <div class="col-lg-3 d-flex align-items-end">
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" role="switch"
                    name="is_active" value="1"
                    @checked(old('is_active', $coverage->is_active ?? 1))>
                <label class="form-check-label fw-semibold">Active</label>
            </div>
        </div>

        {{-- LAT/LNG --}}
        <div class="col-lg-3">
            <label class="form-label fw-semibold">Latitude</label>
            <input type="text" name="lat" id="latInput" class="form-control"
                value="{{ old('lat', $coverage->lat ?? '') }}"
                placeholder="-7.98" inputmode="decimal">
            <div class="form-text">Klik peta untuk isi otomatis.</div>
            @error('lat') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
        </div>

        <div class="col-lg-3">
            <label class="form-label fw-semibold">Longitude</label>
            <input type="text" name="lng" id="lngInput" class="form-control"
                value="{{ old('lng', $coverage->lng ?? '') }}"
                placeholder="112.63" inputmode="decimal">
            <div class="form-text">Klik peta untuk isi otomatis.</div>
            @error('lng') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
        </div>

        <div class="col-lg-6 d-flex align-items-end gap-2">
            <button type="button" id="btnUseMalang" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-geo-alt"></i> Center Malang
            </button>

            <button type="button" id="btnClearCoord" class="btn btn-outline-danger btn-sm">
                <i class="bi bi-x-circle"></i> Reset Koordinat
            </button>

            <a href="#" id="btnOpenMaps" class="btn btn-outline-primary btn-sm ms-auto d-none" target="_blank">
                <i class="bi bi-google"></i> Open Maps
            </a>
        </div>
    </div>

    <hr class="my-4">

    {{-- MAP --}}
    <div class="mb-3">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-2">
            <div>
                <div class="fw-semibold">Pilih Titik di Peta</div>
                <div class="text-muted small">Klik peta untuk menentukan marker coverage.</div>
            </div>
            <span class="badge text-bg-info">
                <i class="bi bi-mouse"></i> Klik peta = isi lat/lng
            </span>
        </div>

        <div class="map-wrap">
            <div id="adminCoverageMap"></div>
        </div>
    </div>

    <div class="d-flex gap-2">
        <button class="btn btn-primary" type="submit">
            <i class="bi bi-save me-1"></i> Simpan
        </button>
        <a href="{{ route('admin.coverages.index') }}" class="btn btn-outline-secondary">
            Batal
        </a>
    </div>

    @push('scripts')
        {{-- Leaflet JS --}}
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
                integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
                crossorigin=""></script>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const latInput = document.getElementById('latInput');
                const lngInput = document.getElementById('lngInput');
                const openMapsBtn = document.getElementById('btnOpenMaps');

                const malangCenter = [-7.98, 112.63];

                // initial value (edit mode)
                let initLat = parseFloat(latInput.value);
                let initLng = parseFloat(lngInput.value);

                const map = L.map('adminCoverageMap', { scrollWheelZoom: true });
                map.setView(malangCenter, 11);

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19,
                    attribution: '&copy; OpenStreetMap'
                }).addTo(map);

                let marker = null;

                function setMarker(lat, lng, fit = false){
                    const pos = [lat, lng];

                    if (!marker) {
                        marker = L.marker(pos, { draggable: true }).addTo(map);
                        marker.on('dragend', function(e){
                            const p = e.target.getLatLng();
                            setInputs(p.lat, p.lng);
                            updateMapsBtn(p.lat, p.lng);
                        });
                    } else {
                        marker.setLatLng(pos);
                    }

                    if (fit) map.setView(pos, 15);
                }

                function setInputs(lat, lng){
                    latInput.value = (Number(lat)).toFixed(7);
                    lngInput.value = (Number(lng)).toFixed(7);
                }

                function updateMapsBtn(lat, lng){
                    if (!openMapsBtn) return;
                    openMapsBtn.href = `https://www.google.com/maps?q=${lat},${lng}`;
                    openMapsBtn.classList.remove('d-none');
                }

                function hideMapsBtn(){
                    if (!openMapsBtn) return;
                    openMapsBtn.classList.add('d-none');
                    openMapsBtn.href = '#';
                }

                // If existing coordinate -> show marker
                if (!isNaN(initLat) && !isNaN(initLng)) {
                    setMarker(initLat, initLng, true);
                    updateMapsBtn(initLat, initLng);
                }

                // Click map -> set marker + inputs
                map.on('click', function(e){
                    const { lat, lng } = e.latlng;
                    setMarker(lat, lng, true);
                    setInputs(lat, lng);
                    updateMapsBtn(lat, lng);
                });

                // Manual typing lat/lng -> update marker
                function tryUpdateFromInputs(){
                    const lat = parseFloat(latInput.value);
                    const lng = parseFloat(lngInput.value);
                    if (!isNaN(lat) && !isNaN(lng)) {
                        setMarker(lat, lng, true);
                        updateMapsBtn(lat, lng);
                    } else {
                        // kalau gak valid, jangan paksa marker
                        hideMapsBtn();
                    }
                }

                latInput.addEventListener('change', tryUpdateFromInputs);
                lngInput.addEventListener('change', tryUpdateFromInputs);

                // Buttons
                document.getElementById('btnUseMalang')?.addEventListener('click', function(){
                    map.setView(malangCenter, 11);
                });

                document.getElementById('btnClearCoord')?.addEventListener('click', function(){
                    latInput.value = '';
                    lngInput.value = '';
                    hideMapsBtn();
                    if (marker) {
                        map.removeLayer(marker);
                        marker = null;
                    }
                });
            });
        </script>
    @endpush
