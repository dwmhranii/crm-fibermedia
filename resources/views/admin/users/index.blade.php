@extends('admin.layouts.admin')

@section('title', 'Users')
@section('subtitle', 'Kelola user admin dan superadmin')

@section('content')
<div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
    <div>
        <div class="fw-bold fs-4">Users</div>
        <div class="text-muted small">Daftar akun yang bisa login ke admin panel</div>
    </div>

    <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle me-1"></i> Tambah User
    </a>
</div>

<form method="GET" action="{{ route('admin.users.index') }}" class="row g-2 mb-3">
    <div class="col-md-4">
        <input type="text" name="q" class="form-control"
               value="{{ $q ?? '' }}"
               placeholder="Cari nama atau email...">
    </div>
    <div class="col-auto">
        <button type="submit" class="btn btn-outline-secondary">
            <i class="bi bi-search me-1"></i> Cari
        </button>
    </div>
</form>

<div class="table-responsive">
    <table class="table align-middle">
        <thead>
            <tr>
                <th width="70">#</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Role</th>
                <th>Dibuat</th>
                <th width="180">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $item)
                <tr>
                    <td>{{ $users->firstItem() + $loop->index }}</td>
                    <td class="fw-semibold">{{ $item->name }}</td>
                    <td>{{ $item->email }}</td>
                    <td>
                        <span class="badge {{ optional($item->role)->slug === 'superadmin' ? 'text-bg-success' : 'text-bg-secondary' }}">
                            {{ optional($item->role)->name ?? '-' }}
                        </span>
                    </td>
                    <td>{{ $item->created_at?->format('d M Y H:i') ?? '-' }}</td>
                    <td>
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.users.edit', $item) }}" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-pencil-square"></i>
                            </a>

                            <form action="{{ route('admin.users.destroy', $item) }}" method="POST"
                                  onsubmit="return confirm('Yakin hapus user ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger" type="submit">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-4">
                        Belum ada data user.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($users->hasPages())
    <div class="adm-pagination mt-3">
        {{ $users->links() }}
    </div>
@endif
@endsection