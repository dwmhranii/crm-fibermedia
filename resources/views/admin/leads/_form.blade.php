<div class="row g-3">
    <div class="col-lg-8">
        <div class="mb-3">
            <label class="form-label">Name *</label>
            <input type="text" name="name" class="form-control"
                   value="{{ old('name', $lead->name ?? '') }}" required>
        </div>

        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Phone *</label>
                <input type="text" name="phone" class="form-control"
                       value="{{ old('phone', $lead->phone ?? '') }}" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control"
                       value="{{ old('email', $lead->email ?? '') }}">
            </div>
        </div>

        <div class="mb-3 mt-3">
            <label class="form-label">Address</label>
            <input type="text" name="address" class="form-control"
                   value="{{ old('address', $lead->address ?? '') }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Message</label>
            <textarea name="message" rows="6" class="form-control"
                      placeholder="Pesan dari user...">{{ old('message', $lead->message ?? '') }}</textarea>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="mb-3">
            <label class="form-label">Status *</label>
            <select name="status" class="form-select" required>
                @foreach($statusOptions as $k => $label)
                    <option value="{{ $k }}" {{ old('status', $lead->status ?? 'new')===$k ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
                @endforeach
            </select>
            <div class="form-text">Ubah status sesuai progress follow-up.</div>
        </div>

        <div class="mb-3">
            <label class="form-label">Coverage</label>
            <select name="coverage_id" class="form-select">
                <option value="">-</option>
                @foreach($coverages as $c)
                    <option value="{{ $c->id }}" {{ (string)old('coverage_id', $lead->coverage_id) === (string)$c->id ? 'selected' : '' }}>
                        {{ $c->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Package</label>
            <select name="package_id" class="form-select">
                <option value="">-</option>
                @foreach($packages as $p)
                    <option value="{{ $p->id }}" {{ (string)old('package_id', $lead->package_id) === (string)$p->id ? 'selected' : '' }}>
                        {{ $p->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Source</label>
            <input type="text" name="source" class="form-control"
                   value="{{ old('source', $lead->source ?? '') }}"
                   placeholder="ex: landingpage, whatsapp, ig...">
        </div>

        <div class="form-check">
            <input class="form-check-input" type="checkbox" value="1" id="set_handled" name="set_handled"
                   {{ old('set_handled') ? 'checked' : '' }}>
            <label class="form-check-label" for="set_handled">
                Set handled (isi handled_by & handled_at)
            </label>
        </div>

        @if(!empty($lead?->handled_at))
            <div class="text-muted small mt-2">
                Terakhir handled: {{ $lead->handled_at->format('d M Y H:i') }}
                <br>by {{ $lead->handler?->name ?? 'User #'.$lead->handled_by }}
            </div>
        @endif
    </div>
</div>

<hr class="my-4">

<div class="d-flex gap-2">
    <button class="btn btn-primary" type="submit">
        <i class="bi bi-save me-1"></i> Simpan
    </button>
    <a href="{{ route('admin.leads.index') }}" class="btn btn-outline-secondary">
        Batal
    </a>
</div>
