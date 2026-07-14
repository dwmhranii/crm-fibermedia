@extends('admin.layouts.admin')

@section('content')
<div class="container py-4">
    <div class="mb-3">
        <h3 class="mb-1">Tambah Why Card</h3>
        <p class="text-muted mb-0">Buat card alasan memilih layanan</p>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <form action="{{ route('admin.why-cards.store') }}" method="POST">
                @csrf

                @include('admin.why-cards._form')

                <div class="mt-4 d-flex gap-2">
                    <button class="btn btn-primary">Simpan</button>
                    <a href="{{ route('admin.why-cards.index') }}" class="btn btn-outline-secondary">Kembali</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection