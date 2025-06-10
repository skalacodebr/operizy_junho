@extends('layouts.admin')
@section('page-title')
    Leads
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Leads</a></li>
    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
@endsection
@section('title')
    <div class="d-inline-block">
        <h5 class="h4 d-inline-block text-white font-weight-bold mb-0 ">Dashboard</h5>
    </div>
@endsection

@push('css-page')

@endpush

@section('content')
    <div class="aplicativos-container">
        <div class="container">
          
        </div>
    </div>
@endsection

@push('script-page')

@endpush 