@extends('admin.layouts.admin')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h3 class="mb-1">Detail Why Card</h3>
            <p class="text-muted mb-0">Lihat detail Why Card</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.why-cards.edit', $whyCard) }}" class="btn btn-warning text-dark">
                Edit
            </a>
            <a href="{{ route('admin.why-cards.index') }}" class="btn btn-outline-secondary">
                Kembali
            </a>
        </div>
    </div>

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <div class="row g-4">
                <div class="col-md-7">
                    <table class="table table-bordered align-middle">
                        <tr>
                            <th width="180">Title</th>
                            <td>{{ $whyCard->title }}</td>
                        </tr>
                        <tr>
                            <th>Subtitle</th>
                            <td>{{ $whyCard->subtitle ?: '-' }}</td>
                        </tr>
                        <tr>
                            <th>Description</th>
                            <td>{!! nl2br(e($whyCard->description)) !!}</td>
                        </tr>
                        <tr>
                            <th>Icon</th>
                            <td>
                                @if($whyCard->icon)
                                    <i class="bi {{ $whyCard->icon }} me-2"></i>
                                    <code>{{ $whyCard->icon }}</code>
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>BG Color</th>
                            <td>{{ $whyCard->bg_color ?: '-' }}</td>
                        </tr>
                        <tr>
                            <th>Text Color</th>
                            <td>{{ $whyCard->text_color ?: '-' }}</td>
                        </tr>
                        <tr>
                            <th>Sort Order</th>
                            <td>{{ $whyCard->sort_order }}</td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>
                                @if($whyCard->is_active)
                                    <span class="badge bg-success">Aktif</span>
                                @else
                                    <span class="badge bg-secondary">Nonaktif</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Dibuat</th>
                            <td>{{ $whyCard->created_at }}</td>
                        </tr>
                        <tr>
                            <th>Diupdate</th>
                            <td>{{ $whyCard->updated_at }}</td>
                        </tr>
                    </table>
                </div>

                <div class="col-md-5">
                    <div class="fw-semibold mb-2">Preview Card</div>
                    <div
                        style="
                            background: {{ $whyCard->bg_color ?: '#ffffff' }};
                            color: {{ $whyCard->text_color ?: '#1f2937' }};
                            border: 1px solid #ddd;
                            border-radius: 20px;
                            padding: 22px;
                            min-height: 220px;
                        "
                    >
                        <h5 class="fw-bold d-flex align-items-center gap-2">
                            @if($whyCard->icon)
                                <span style="width:40px;height:40px;border-radius:999px;background:rgba(0,0,0,.06);display:inline-flex;align-items:center;justify-content:center;">
                                    <i class="bi {{ $whyCard->icon }}"></i>
                                </span>
                            @endif
                            <span>{{ $whyCard->title }}</span>
                        </h5>

                        @if($whyCard->subtitle)
                            <p class="mb-2">{{ $whyCard->subtitle }}</p>
                        @endif

                        <p class="mb-0">{!! nl2br(e($whyCard->description)) !!}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection@extends('admin.layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h3 class="mb-1">Detail Why Card</h3>
            <p class="text-muted mb-0">Lihat detail Why Card</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.why-cards.edit', $whyCard) }}" class="btn btn-warning text-dark">
                Edit
            </a>
            <a href="{{ route('admin.why-cards.index') }}" class="btn btn-outline-secondary">
                Kembali
            </a>
        </div>
    </div>

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <div class="row g-4">
                <div class="col-md-7">
                    <table class="table table-bordered align-middle">
                        <tr>
                            <th width="180">Title</th>
                            <td>{{ $whyCard->title }}</td>
                        </tr>
                        <tr>
                            <th>Subtitle</th>
                            <td>{{ $whyCard->subtitle ?: '-' }}</td>
                        </tr>
                        <tr>
                            <th>Description</th>
                            <td>{!! nl2br(e($whyCard->description)) !!}</td>
                        </tr>
                        <tr>
                            <th>Icon</th>
                            <td>
                                @if($whyCard->icon)
                                    <i class="bi {{ $whyCard->icon }} me-2"></i>
                                    <code>{{ $whyCard->icon }}</code>
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>BG Color</th>
                            <td>{{ $whyCard->bg_color ?: '-' }}</td>
                        </tr>
                        <tr>
                            <th>Text Color</th>
                            <td>{{ $whyCard->text_color ?: '-' }}</td>
                        </tr>
                        <tr>
                            <th>Sort Order</th>
                            <td>{{ $whyCard->sort_order }}</td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>
                                @if($whyCard->is_active)
                                    <span class="badge bg-success">Aktif</span>
                                @else
                                    <span class="badge bg-secondary">Nonaktif</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Dibuat</th>
                            <td>{{ $whyCard->created_at }}</td>
                        </tr>
                        <tr>
                            <th>Diupdate</th>
                            <td>{{ $whyCard->updated_at }}</td>
                        </tr>
                    </table>
                </div>

                <div class="col-md-5">
                    <div class="fw-semibold mb-2">Preview Card</div>
                    <div
                        style="
                            background: {{ $whyCard->bg_color ?: '#ffffff' }};
                            color: {{ $whyCard->text_color ?: '#1f2937' }};
                            border: 1px solid #ddd;
                            border-radius: 20px;
                            padding: 22px;
                            min-height: 220px;
                        "
                    >
                        <h5 class="fw-bold d-flex align-items-center gap-2">
                            @if($whyCard->icon)
                                <span style="width:40px;height:40px;border-radius:999px;background:rgba(0,0,0,.06);display:inline-flex;align-items:center;justify-content:center;">
                                    <i class="bi {{ $whyCard->icon }}"></i>
                                </span>
                            @endif
                            <span>{{ $whyCard->title }}</span>
                        </h5>

                        @if($whyCard->subtitle)
                            <p class="mb-2">{{ $whyCard->subtitle }}</p>
                        @endif

                        <p class="mb-0">{!! nl2br(e($whyCard->description)) !!}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection