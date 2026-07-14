@extends('admin.layouts.admin')

@section('title', 'Leads')
@section('subtitle', 'Kelola data leads masuk')

@section('content')
<div class="d-flex flex-wrap gap-2 justify-content-between align-items-center mb-3">
    <div>
        <h4 class="mb-1">Leads</h4>
        <div class="text-muted small">Daftar leads dari form / sumber lain.</div>
    </div>

    <div class="d-flex flex-wrap gap-2">
        <form method="GET" class="d-flex flex-wrap gap-2">
            <input type="text" name="q" value="{{ $q }}" class="form-control form-control-sm"
                   placeholder="Cari nama / phone / email / source...">

            <select name="status" class="form-select form-select-sm" style="min-width:160px;">
                <option value="">Semua Status</option>
                @foreach($statusOptions as $k => $label)
                    <option value="{{ $k }}" {{ $status===$k ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>

            <div class="form-check align-self-center ms-1">
                <input class="form-check-input" type="checkbox" value="1" id="trashed" name="trashed" {{ $withTrashed ? 'checked' : '' }}>
                <label class="form-check-label small" for="trashed">Include deleted</label>
            </div>

            <button class="btn btn-outline-secondary btn-sm" type="submit">
                <i class="bi bi-search"></i>
            </button>
        </form>
    </div>
</div>

<div class="table-responsive">
    <table class="table align-middle">
        <thead>
            <tr class="text-muted small">
                <th style="width:60px;">#</th>
                <th>Nama</th>
                <th>Kontak</th>
                <th>Coverage</th>
                <th>Package</th>
                <th class="text-center" style="width:120px;">Status</th>
                <th class="text-center" style="width:160px;">Handled</th>
                <th class="text-end" style="width:190px;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($leads as $l)
                <tr class="{{ $l->trashed() ? 'table-danger' : '' }}">
                    <td class="text-muted">#{{ $l->id }}</td>

                    <td class="fw-semibold">
                        {{ $l->name }}
                        <div class="text-muted small">
                            {{ $l->source ? 'Source: '.$l->source : 'Source: -' }}
                        </div>
                    </td>

                    <td class="text-muted">
                        <div><i class="bi bi-telephone me-1"></i>{{ $l->phone }}</div>
                        <div class="small"><i class="bi bi-envelope me-1"></i>{{ $l->email ?? '-' }}</div>
                    </td>

                    <td class="text-muted">{{ $l->coverage?->name ?? '-' }}</td>
                    <td class="text-muted">{{ $l->package?->name ?? '-' }}</td>

                    <td class="text-center">
                        @php
                            $badge = match($l->status){
                                'new' => 'text-bg-primary',
                                'contacted' => 'text-bg-warning',
                                'closed' => 'text-bg-success',
                                'spam' => 'text-bg-secondary',
                                default => 'text-bg-light'
                            };
                        @endphp
                        <span class="badge {{ $badge }}">{{ $statusOptions[$l->status] ?? $l->status }}</span>
                    </td>

                    <td class="text-center text-muted small">
                        @if($l->handled_at)
                            <div>{{ $l->handled_at->format('d M Y H:i') }}</div>
                            <div>by {{ $l->handler?->name ?? 'User #'.$l->handled_by }}</div>
                        @else
                            -
                        @endif
                    </td>

                    <td class="text-end">
                        <a href="{{ route('admin.leads.show', $l) }}" class="btn btn-outline-secondary btn-sm">
                            <i class="bi bi-eye"></i>
                        </a>

                        @if(!$l->trashed())
                            <a href="{{ route('admin.leads.edit', $l) }}" class="btn btn-outline-primary btn-sm">
                                <i class="bi bi-pencil"></i>
                            </a>

                            <form action="{{ route('admin.leads.destroy', $l) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Hapus lead ini?');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-outline-danger btn-sm" type="submit">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        @else
                            <form action="{{ route('admin.leads.restore', $l->id) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Restore lead ini?');">
                                @csrf
                                <button class="btn btn-outline-success btn-sm" type="submit">
                                    <i class="bi bi-arrow-counterclockwise"></i>
                                </button>
                            </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center text-muted py-4">
                        Belum ada lead.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-3">
    {{ $leads->links() }}
</div>
@endsection
