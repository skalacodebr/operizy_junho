@extends('layouts.admin')

@section('page-title')
    Review
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="#">Review</a></li>
    <li class="breadcrumb-item active" aria-current="page">Avaliações e Perguntas</li>
@endsection

@section('title')
    <div class="d-inline-block">
        <h5 class="h4 d-inline-block text-white font-weight-bold mb-0">Avaliações e Perguntas</h5>
    </div>
@endsection

@section('content')
<div class="container-fluid mt-4">
    <!-- header: filtros + busca -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <button class="btn btn-outline-secondary">
            <i data-feather="sliders"></i> Filtros
        </button>
        <div class="input-group" style="max-width: 300px;">
            <input type="text" class="form-control" placeholder="Buscar...">
            <div class="input-group-append">
                <span class="input-group-text"><i data-feather="search"></i></span>
            </div>
        </div>
    </div>

    <!-- abas -->
    <ul class="nav nav-tabs mb-4" id="perguntasTabs" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="produtos-tab" data-toggle="tab" href="#produtos" role="tab">
                Produtos
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="loja-tab" data-toggle="tab" href="#loja" role="tab">
                Loja
            </a>
        </li>
    </ul>

    <div class="tab-content" id="perguntasTabsContent">
        {{-- Aba Produtos --}}
        <div class="tab-pane fade show active" id="produtos" role="tabpanel">
            <div class="table-responsive">
                <table class="table table-borderless align-middle mb-0">
                    <thead>
                        <tr class="text-secondary">
                            <th style="width:35%;">Produto</th>
                            <th style="width:20%;">Avaliações</th>
                            <th style="width:20%;">Perguntas</th>
                            <th style="width:15%;">Status</th>
                            <th style="width:10%;">Visualizar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="d-flex align-items-center gap-2">
                                <img src="{{ asset('assets/images/user/avatar-1.jpg') }}"
                                     alt="Camiseta Ovni"
                                     class="rounded mr-3"
                                     width="60" height="60">
                                <strong>Camiseta Ovni</strong>
                            </td>
                            <td>
                                <a href="{{ route('review.perguntas') }}"
                                        class="btn border rounded-pill w-100 text-left d-flex justify-content-between align-items-center py-2">
                                    <div>
                                    <i class="fas fa-star text-warning mr-1"></i>
                                    <strong>5.0</strong>
                                    <small class="text-muted">(6 avaliações)</small>
                                    </div>
                                    <small class="text-success">+2 novas</small>
                                </a>
                            </td>
                            <td style="width:20%;">
                                <a href="{{ route('review.perguntas_respsotas') }}"
                                        class="btn border rounded-pill w-100 text-left d-flex justify-content-between align-items-center py-2">
                                    <div class="d-flex align-items-center">
                                    <i class="fas fa-question-circle text-secondary mr-1"></i>
                                    <strong>1 pergunta respondida</strong>
                                    </div>
                                    <small class="text-success">+2 novas</small>
                                </a>
                            </td>

                            <td>
                                <span class="badge badge-warning">3 perguntas aguardando resposta</span>
                            </td>
                            <td class="text-center">
                                <a href="#" class="text-secondary">
                                    <i data-feather="external-link"></i>
                                </a>
                            </td>
                        </tr>
                        {{-- outros produtos... --}}
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Aba Loja --}}
        <div class="tab-pane fade" id="loja" role="tabpanel">
            <div class="list-group">
                <!-- comentário pendente -->
                <div class="list-group-item">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div>
                            <!-- estrelas -->
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <small class="text-muted ml-2">2 dias atrás</small>
                            <div><strong>Marcelo Carvalho</strong></div>
                        </div>
                        <div>
                            <button class="btn btn-sm btn-outline-success mr-1">
                                <i data-feather="check"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-danger">
                                <i data-feather="x"></i>
                            </button>
                        </div>
                    </div>
                    <p class="mb-0">
                        Loja de confiança, ótimos produtos e com o preço baixo!  
                        Os produtos chegaram no prazo tudo certinho. Ótimo atendimento.
                    </p>
                </div>

                <!-- comentário aprovado -->
                <div class="list-group-item">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div>
                            <!-- estrelas -->
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <small class="text-muted ml-2">2 dias atrás</small>
                            <div><strong>Marcelo Carvalho</strong></div>
                        </div>
                        <div class="d-flex align-items-center">
                            <span class="badge badge-success">Aprovado</span>
                            <button class="btn btn-sm btn-outline-secondary ml-2">
                                <i data-feather="eye"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-secondary ml-1">
                                <i data-feather="heart"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-danger ml-1">
                                <i data-feather="trash-2"></i>
                            </button>
                        </div>
                    </div>
                    <p class="mb-0">
                        Confortável, estiloso e perfeito para qualquer ocasião –  
                        este tênis é uma escolha incrível para quem busca qualidade e versatilidade!
                    </p>
                </div>
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
    $('#perguntasTabs a').on('click', function (e) {
        e.preventDefault();
        $(this).tab('show');
    });
});
</script>
@endpush
