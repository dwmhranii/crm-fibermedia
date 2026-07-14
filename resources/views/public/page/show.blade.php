@extends('public.layouts.app')
@section('title',$page->title)

@section('content')
<div class="container">
  <h3 class="mb-3">{{ $page->title }}</h3>
  <div class="card">
    <div class="card-body">
      {!! $page->content !!}
    </div>
  </div>
</div>
@endsection

