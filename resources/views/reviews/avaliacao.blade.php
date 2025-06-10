@extends('layouts.admin')

@section('page-title')
    Review
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="#">Review</a></li>
    <li class="breadcrumb-item active" aria-current="page">Avaliações</li>
@endsection

@section('title')
    <div class="d-inline-block">
        <h5 class="h4 d-inline-block text-white font-weight-bold mb-0">Avaliações</h5>
    </div>
@endsection

@section('content')
<div class="container-fluid mt-4">
    <!-- cabeçalho: filtros, ordenação e busca -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
        <div class="btn-group mb-2">
            <button class="btn btn-outline-secondary">
                <i data-feather="sliders"></i> Filtros
            </button>
            <button class="btn btn-outline-secondary">
                <i data-feather="arrow-down"></i> Mais novo
            </button>
        </div>
        <div class="input-group mb-2" style="max-width: 300px;">
            <input type="text" class="form-control" placeholder="Buscar produtos...">
            <div class="input-group-append">
                <span class="input-group-text"><i data-feather="search"></i></span>
            </div>
        </div>
    </div>

    <!-- abas -->
    <ul class="nav nav-tabs mb-4" id="avaliacoesTabs" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="todos-tab" data-toggle="tab" href="#todos" role="tab">
                Todos <span class="badge badge-secondary ml-1">4</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="avaliacoes-tab" data-toggle="tab" href="#avaliacoes" role="tab">
                Avaliações <span class="badge badge-secondary ml-1">1</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="nao-avaliados-tab" data-toggle="tab" href="#nao-avaliados" role="tab">
                Não avaliados <span class="badge badge-secondary ml-1">1</span>
            </a>
        </li>
    </ul>

    <div class="tab-content" id="avaliacoesTabsContent">
        {{-- Aba “Todos” --}}
        <div class="tab-pane fade show active" id="todos" role="tabpanel" aria-labelledby="todos-tab">
            <div class="list-group list-group-flush">
                <!-- item com avaliação -->
                <div class="list-group-item py-4">
                    <div class="d-flex justify-content-between mb-3">
                        <div class="d-flex">
                            <img src="{{ asset('assets/images/user/avatar-1.jpg') }}"
                                 alt="Blusa de Botão"
                                 class="rounded mr-3"
                                 width="60" height="60">
                            <div>
                                <strong>Blusa de Botão</strong><br>
                                <small class="text-muted">SKU: 19038403 | 19/11/2024</small><br>
                                <i class="fas fa-star text-warning"></i>
                                <strong>5.0</strong>
                                <small>(6 avaliações)</small><br>
                                <small class="text-muted">2 dias atrás</small><br>
                                <strong>Marcelo Carvalho</strong>
                            </div>
                        </div>
                        <div class="text-right">
                            <a href="#" class="text-secondary mr-2"><i data-feather="eye"></i></a>
                            <button class="btn btn-sm btn-outline-secondary mr-2"><i data-feather="heart"></i></button>
                            <button class="btn btn-sm btn-outline-danger"><i data-feather="trash-2"></i></button><br>
                            <span class="badge badge-success mt-2">Aprovado</span>
                        </div>
                    </div>

                    <p class="mb-2"><strong>Qualidade:</strong> Perfeito!</p>
                    <p class="mb-2"><strong>Parecido com o anúncio:</strong> Sem dúvidas!</p>
                    <p class="mb-0">Produto de ótima qualidade e com a entrega super rápida!</p>

                    <div class="d-flex my-3">
                        <!-- thumbnail 1 -->
                        <div class="position-relative mr-2">
                            <img src="https://via.placeholder.com/100x100" class="rounded" alt="Vídeo 1">
                            <div class="position-absolute"
                                 style="bottom:5px; right:5px; background:rgba(0,0,0,0.6); color:#fff; font-size:12px; padding:2px 4px;">
                                0:15
                            </div>
                        </div>
                        <!-- thumbnail 2 -->
                        <div class="position-relative mr-2">
                            <img src="https://via.placeholder.com/100x100" class="rounded" alt="Vídeo 2">
                            <div class="position-absolute"
                                 style="bottom:5px; right:5px; background:rgba(0,0,0,0.6); color:#fff; font-size:12px; padding:2px 4px;">
                                0:15
                            </div>
                        </div>
                        <!-- thumbnail 3 -->
                        <div class="position-relative">
                            <img src="https://via.placeholder.com/100x100" class="rounded" alt="Vídeo 3">
                            <div class="position-absolute"
                                 style="bottom:5px; right:5px; background:rgba(0,0,0,0.6); color:#fff; font-size:12px; padding:2px 4px;">
                                0:15
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-link p-0">Ver menos</button>
                </div>

                <!-- item sem avaliação -->
                <div class="list-group-item py-3 d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <img src="{{ asset('assets/images/user/avatar-1.jpg') }}"
                             alt="Blusa de Botão"
                             class="rounded mr-3"
                             width="60" height="60">
                        <div>
                            <strong>Blusa de Botão</strong><br>
                            <small class="text-muted">SKU: 19038403 | 19/11/2024</small>
                        </div>
                    </div>
                    <button class="btn btn-primary">
                        <i class="fas fa-star mr-1"></i> Incentivar avaliação
                    </button>
                </div>
            </div>
        </div>

        {{-- Aba “Avaliados” --}}
        <div class="tab-pane fade" id="avaliacoes" role="tabpanel" aria-labelledby="avaliacoes-tab">
            <div class="list-group list-group-flush">
                <!-- repete aqui apenas os itens que já têm avaliação -->
                {{-- ... --}}
            </div>
        </div>

        {{-- Aba “Não avaliados” --}}
        <div class="tab-pane fade" id="nao-avaliados" role="tabpanel" aria-labelledby="nao-avaliados-tab">
            <div class="list-group list-group-flush">
                <!-- repete aqui apenas os itens sem avaliação -->
                {{-- ... --}}
            </div>
        </div>
    </div>
</div>
@endsection

@push('script-page')
<script>
document.addEventListener('DOMContentLoaded', function(){
    // inicializa Feather Icons
    feather.replace();
    // ativa as abas do Bootstrap
    $('#avaliacoesTabs a').on('click', function (e) {
        e.preventDefault();
        $(this).tab('show');
    });
});
</script>
@endpush
