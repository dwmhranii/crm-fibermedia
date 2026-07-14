@extends('admin.layouts.admin')

@section('title', 'Edit Lead')
@section('subtitle', 'Update status & data lead')

@section('content')
<h4 class="mb-3">Edit Lead</h4>

<form method="POST" action="{{ route('admin.leads.update', $lead) }}">
    @csrf
    @method('PUT')
    @include('admin.leads._form', ['lead' => $lead])
</form>
@endsection
