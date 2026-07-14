@extends('admin.layouts.admin')

@section('title', 'Coverages')
@section('subtitle', 'Kelola titik area coverage')

@section('content')
<div class="d-flex align-items-center justify-content-between gap-2 flex-wrap mb-3">
    <div>
        <div class="fw-bold fs-5">Coverages</div>
        <div class="text-muted small">Daftar area yang sudah tercover</div>
    </div>

    <div class="d-flex gap-2 flex-wrap">
        <form method="GET" action="{{ route('admin.coverages.index') }}" class="d-flex gap-2">
            <input
                type="text"
                name="q"
                value="{{ $q ?? '' }}"
                class="form-control form-control-sm"
                placeholder="Cari nama / kecamatan / kota...">

            <button class="btn btn-outline-secondary btn-sm" type="submit" title="Cari">
                <i class="bi bi-search"></i>
            </button>

            @if(!empty($q))
                <a href="{{ route('admin.coverages.index') }}" class="btn btn-outline-secondary btn-sm" title="Reset">
                    <i class="bi bi-x-circle me-1"></i> Reset
                </a>
            @endif
        </form>

        <a href="{{ route('admin.coverages.create') }}" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-lg me-1"></i> Tambah
        </a>
    </div>
</div>

<div class="table-responsive">
    <table class="table align-middle mb-0">
        <thead>
        <tr class="text-muted small">
            <th style="width:90px;">Status</th>
            <th>Nama</th>
            <th>Kecamatan</th>
            <th>Kota</th>
            <th style="width:190px;">Koordinat</th>
            <th style="width:140px;" class="text-end">Aksi</th>
        </tr>
        </thead>

        <tbody>
        @forelse($coverages as $c)
            @php
                // Aman kalau lat/lng belum ada atau null
                $hasCoord = !is_null($c->lat ?? null) && !is_null($c->lng ?? null);
                $mapsUrl  = $hasCoord ? "https://www.google.com/maps?q={$c->lat},{$c->lng}" : null;
            @endphp

            <tr>
                <td>
                    @if($c->is_active)
                        <span class="badge text-bg-success">Active</span>
                    @else
                        <span class="badge text-bg-secondary">Off</span>
                    @endif
                </td>

                <td class="fw-semibold">{{ $c->name }}</td>
                <td>{{ $c->district ?? '-' }}</td>
                <td>{{ $c->city ?? '-' }}</td>

                <td>
                    @if($hasCoord)
                        <div class="d-flex flex-column">
                            <span class="small text-muted">
                                {{ number_format((float)$c->lat, 6) }}, {{ number_format((float)$c->lng, 6) }}
                            </span>
                            <a href="{{ $mapsUrl }}" target="_blank" class="small text-decoration-none">
                                <i class="bi bi-geo-alt"></i> Open Maps
                            </a>
                        </div>
                    @else
                        <span class="badge text-bg-warning">
                            Belum di-set
                        </span>
                    @endif
                </td>

                <td class="text-end">
                    <div class="d-inline-flex align-items-center gap-1">
                        <a class="btn btn-outline-secondary btn-sm"
                           href="{{ route('admin.coverages.show', $c->id) }}"
                           title="Detail">
                            <i class="bi bi-eye"></i>
                        </a>

                        <a class="btn btn-outline-primary btn-sm"
                           href="{{ route('admin.coverages.edit', $c->id) }}"
                           title="Edit">
                            <i class="bi bi-pencil"></i>
                        </a>

                        <form method="POST"
                              action="{{ route('admin.coverages.destroy', $c->id) }}"
                              class="d-inline"
                              onsubmit="return confirm('Yakin hapus coverage ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-outline-danger btn-sm" type="submit" title="Hapus">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="text-center text-muted py-4">
                    Belum ada coverage.
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>
</div>

<div class="mt-3 d-flex flex-wrap gap-2 justify-content-between align-items-center">
    <div class="text-muted small">
        @if($coverages->total() > 0)
            Showing {{ $coverages->firstItem() }} to {{ $coverages->lastItem() }} of {{ $coverages->total() }} results
        @else
            Showing 0 results
        @endif
    </div>

    <div class="adm-pagination">
        {{-- controller sudah withQueryString(), jadi cukup links() saja --}}
        {{ $coverages->onEachSide(1)->links() }}
    </div>
</div>
@endsection
