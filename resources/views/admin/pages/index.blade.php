@extends('admin.layouts.admin')

@section('title', 'Pages')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Pages</h4>

    @if(auth()->user()?->role?->slug === 'superadmin')
        <a href="{{ route('admin.pages.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> Tambah Page
        </a>
    @endif
</div>

<div class="table-responsive">
    <table class="table align-middle">
        <thead>
            <tr>
                <th>Title</th>
                <th>Slug</th>
                <th>Status</th>
                <th width="160">Aksi</th>
            </tr>
        </thead>
        <tbody>
        @forelse($pages as $page)
            <tr>
                <td>
                    <strong>{{ $page->title }}</strong>
                </td>
                <td>
                    <code>{{ $page->slug }}</code>
                </td>
                <td>
                    @if($page->is_active)
                        <span class="badge bg-success">Aktif</span>
                    @else
                        <span class="badge bg-secondary">Draft</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('admin.pages.show', $page) }}"
                       class="btn btn-sm btn-outline-secondary">
                        <i class="bi bi-eye"></i>
                    </a>

                    @if(auth()->user()?->role?->slug === 'superadmin')
                        <a href="{{ route('admin.pages.edit', $page) }}"
                           class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-pencil"></i>
                        </a>

                        <form action="{{ route('admin.pages.destroy', $page) }}"
                              method="POST"
                              class="d-inline"
                              onsubmit="return confirm('Hapus page ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    @endif
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="4" class="text-center text-muted">
                    Belum ada page.
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>
</div>

{{ $pages->links() }}
@endsection
