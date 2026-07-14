@extends('admin.layouts.admin')

@section('title', 'Gallery Item Detail')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 mb-0">Gallery Item Detail</h1>

        <div class="d-flex gap-2">
            <a href="{{ route('admin.gallery-items.index') }}" class="btn btn-outline-secondary">
                Back
            </a>

            <a href="{{ route('admin.gallery-items.edit', $item) }}" class="btn btn-primary">
                Edit
            </a>

            <form action="{{ route('admin.gallery-items.destroy', $item) }}"
                  method="POST"
                  onsubmit="return confirm('Delete this item?')"
                  class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">
                    Delete
                </button>
            </form>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card mb-3">
        <div class="card-body">
            <dl class="row mb-0">
                <dt class="col-sm-3">ID</dt>
                <dd class="col-sm-9">{{ $item->id }}</dd>

                <dt class="col-sm-3">Album</dt>
                <dd class="col-sm-9">
                    {{ optional($item->album)->title ?? '-' }}
                </dd>

                <dt class="col-sm-3">Type</dt>
                <dd class="col-sm-9">{{ $item->type }}</dd>

                <dt class="col-sm-3">Title</dt>
                <dd class="col-sm-9">{{ $item->title ?: '-' }}</dd>

                <dt class="col-sm-3">Caption</dt>
                <dd class="col-sm-9">{{ $item->caption ?: '-' }}</dd>

                <dt class="col-sm-3">Sort Order</dt>
                <dd class="col-sm-9">{{ $item->sort_order ?? 0 }}</dd>

                <dt class="col-sm-3">Active</dt>
                <dd class="col-sm-9">
                    @if($item->is_active)
                        <span class="badge bg-success">Yes</span>
                    @else
                        <span class="badge bg-secondary">No</span>
                    @endif
                </dd>

                <dt class="col-sm-3">Video URL</dt>
                <dd class="col-sm-9">
                    @if($item->video_url)
                        <a href="{{ $item->video_url }}" target="_blank" rel="noopener noreferrer">
                            Open
                        </a>
                        <div class="text-muted small">{{ $item->video_url }}</div>
                    @else
                        -
                    @endif
                </dd>

                <dt class="col-sm-3">File</dt>
                <dd class="col-sm-9">
                    @if($item->file_path)
                        <a href="{{ asset('storage/'.$item->file_path) }}" target="_blank" rel="noopener noreferrer">
                            Open
                        </a>
                        <div class="text-muted small">{{ $item->file_path }}</div>
                    @else
                        -
                    @endif
                </dd>

                <dt class="col-sm-3">Thumbnail</dt>
                <dd class="col-sm-9">
                    @if($item->thumb_path)
                        <a href="{{ asset('storage/'.$item->thumb_path) }}" target="_blank" rel="noopener noreferrer">
                            Open
                        </a>
                        <div class="text-muted small">{{ $item->thumb_path }}</div>
                    @else
                        -
                    @endif
                </dd>

                <dt class="col-sm-3">Created</dt>
                <dd class="col-sm-9">{{ $item->created_at }}</dd>

                <dt class="col-sm-3">Updated</dt>
                <dd class="col-sm-9">{{ $item->updated_at }}</dd>
            </dl>
        </div>
    </div>

    {{-- Preview --}}
    <div class="card">
        <div class="card-header">
            Preview
        </div>
        <div class="card-body">
            @if($item->type === 'video' && $item->video_url)
                <div class="ratio ratio-16x9">
                    <iframe src="{{ $item->video_url }}" title="Video" allowfullscreen></iframe>
                </div>

            @elseif($item->file_path)
                @php
                    $ext = strtolower(pathinfo($item->file_path, PATHINFO_EXTENSION));
                    $isVideo = in_array($ext, ['mp4', 'mov', 'webm', 'm4v']);
                @endphp

                @if($isVideo)
                    <video controls class="w-100" style="max-height: 420px;">
                        <source src="{{ asset('storage/'.$item->file_path) }}">
                        Your browser does not support the video tag.
                    </video>
                @else
                    <img src="{{ asset('storage/'.$item->file_path) }}"
                         alt="Gallery Item"
                         class="img-fluid rounded">
                @endif

            @else
                <div class="text-muted">No preview available.</div>
            @endif
        </div>
    </div>
</div>
@endsection