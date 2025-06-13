@php
    $setting = App\Models\Utility::settings();
@endphp

@extends('layouts.admin')
@section('page-title')
    {{ __('Dashboard') }}
@endsection
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Home') }}</a></li>
@endsection
@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h4 id="greetings" class="mb-4"></h4>
            <div class="row g-3">
                <div class="col-md-3 col-sm-6">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">3 Pedidos aguardando atendimento</h5>
                            <span class="badge text-white" style="background-color: var(--color-customColor);">Ação necessária</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">1 Pedido com solicitação de troca/devolução</h5>
                            <span class="badge text-white" style="background-color: var(--color-customColor);">Ação necessária</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">Pedidos cancelados: Nenhum cancelado</h5>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="card h-100">
                        <div class="card-body d-flex align-items-center">
                            <a href="#" class="stretched-link">Desempenho da loja</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="alert mt-3 text-white" style="background-color: var(--color-customColor);">
                Impulsione seu negócio com novos recursos. Conheça nossos planos.
            </div>
        </div>
    </div>
    <div class="row mb-4">
        <div class="col-12 d-flex gap-2">
            <a href="{{ $store_id['store_url'] ?? '#' }}" class="btn text-white" style="background-color: var(--color-customColor);">Visitar minha loja</a>
            <a href="#" class="btn btn-light">Loja de temas</a>
            <a href="#" class="btn btn-light">Loja de serviços</a>
        </div>
    </div>
    <div class="row g-4">
        <div class="col-md-3">
            <div class="card h-100">
                <div class="card-header"><h6 class="mb-0">Últimas Avaliações</h6></div>
                <div class="card-body">
                    <p class="mb-2">"Produto ótimo!" <small class="text-muted">– João S. sobre Camiseta DryFit</small></p>
                    <p class="mb-0">"Tem tamanho GG?" – Moletom Oversized <a href="#" class="btn btn-sm text-white" style="background-color: var(--color-customColor);">Responder</a></p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card h-100">
                <div class="card-header"><h6 class="mb-0">Interações em Vídeos</h6></div>
                <div class="card-body">
                    <p class="mb-2">"É impermeável?" – Tênis Boost</p>
                    <p class="mb-0">"Tem tamanho 42?" – Tênis Boost</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card h-100">
                <div class="card-header"><h6 class="mb-0">Mensagens Recentes</h6></div>
                <div class="card-body">
                    <p class="mb-2"><strong>Rafael B.</strong>: "Meu pedido ainda não chegou…" <a href="#" class="btn btn-sm text-white" style="background-color: var(--color-customColor);">Ver Conversa</a></p>
                    <p class="mb-0"><strong>Lucas T.</strong>: "Posso trocar o tamanho?" <a href="#" class="btn btn-sm text-white" style="background-color: var(--color-customColor);">Ver Conversa</a></p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card h-100">
                <div class="card-header"><h6 class="mb-0">Afiliados com pendência</h6></div>
                <div class="card-body">
                    <p class="mb-2"><strong>Amanda C.</strong>: Pagamento pendente <span class="badge text-white" style="background-color: var(--color-customColor);">Pagar até sexta</span></p>
                    <p class="mb-0"><strong>Bruno C.</strong>: 3 indicações pendentes <a href="#" class="btn btn-sm text-white" style="background-color: var(--color-customColor);">Acompanhar ganhos</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script-page')
<script>
    var timezone = '{{ !empty($setting['timezone']) ? $setting['timezone'] : 'Asia/Kolkata' }}';
    let today = new Date(new Date().toLocaleString("en-US", { timeZone: timezone }));
    var curHr = today.getHours();
    var target = document.getElementById("greetings");
    if (curHr < 12) {
        target.innerHTML = "Olá, {{ Auth::user()->name }}! Que bom te ver por aqui.";
    } else if (curHr < 17) {
        target.innerHTML = "Olá, {{ Auth::user()->name }}! Que bom te ver por aqui.";
    } else {
        target.innerHTML = "Olá, {{ Auth::user()->name }}! Que bom te ver por aqui.";
    }
</script>
@endpush
