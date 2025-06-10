@extends('layouts.admin')
@section('page-title')
    {{ __('Aplicativos') }}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Home') }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('Aplicativos') }}</li>
@endsection
@section('title')
    <div class="d-inline-block">
        <h5 class="h4 d-inline-block text-white font-weight-bold mb-0 ">{{ __('Aplicativos') }}</h5>
    </div>
@endsection

@push('css-page')

@endpush

@section('content')
    <div class="aplicativos-container">
        <div class="container">
            <!-- Header Section -->
            <div class="text-center mb-5">
                <h1 class="section-title">Aplicativos Premium</h1>
                <p class="lead text-muted">Potencialize seu e-commerce com ferramentas profissionais</p>
            </div>

            <!-- Search Bar -->
            <div class="search-container mb-5">
                <input type="text" class="search-input" placeholder="Pesquisar aplicativos..." id="searchApp">
                <i class="fas fa-search search-icon"></i>
            </div>

        </div>
    </div>
@endsection

@push('script-page')

@endpush 