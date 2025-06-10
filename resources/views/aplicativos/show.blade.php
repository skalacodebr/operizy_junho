@extends('layouts.admin')
@section('page-title')
    {{ __('Detalhes do Aplicativo') }}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Home') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('aplicativos.index') }}">{{ __('Aplicativos') }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('Detalhes') }}</li>
@endsection
@section('title')
    <div class="d-inline-block">
        <h5 class="h4 d-inline-block text-white font-weight-bold mb-0 ">{{ __('Detalhes do Aplicativo') }}</h5>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body text-center p-5">
                    <div class="mb-4">
                        <i class="ti ti-apps" style="font-size: 4rem; color: #6366f1;"></i>
                    </div>
                    <h3 class="mb-3">Aplicativo ID: {{ $id }}</h3>
                    <p class="text-muted mb-4">Esta página mostrará os detalhes específicos do aplicativo selecionado.</p>
                    <div class="d-flex justify-content-center gap-3">
                        <a href="{{ route('aplicativos.index') }}" class="btn btn-secondary">
                            <i class="ti ti-arrow-left me-2"></i>Voltar para Aplicativos
                        </a>
                        <button class="btn btn-primary">
                            <i class="ti ti-download me-2"></i>Assinar Aplicativo
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection 