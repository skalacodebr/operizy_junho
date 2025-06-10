@extends('layouts.admin')

@section('page-title')
    Review
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="#">Review</a></li>
    <li class="breadcrumb-item active" aria-current="page">Perguntas</li>
@endsection

@section('title')
    <div class="d-inline-block">
        <h5 class="h4 d-inline-block text-white font-weight-bold mb-0">Perguntas</h5>
    </div>
@endsection

@section('content')
<div class="container-fluid mt-4">
    <!-- cabeçalho: ordenação e busca -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <button class="btn btn-outline-secondary">
                <i data-feather="arrow-down"></i> Mais novo
            </button>
        </div>
        <div class="input-group" style="max-width: 300px;">
            <input type="text" class="form-control" placeholder="Buscar produtos...">
            <div class="input-group-append">
                <span class="input-group-text"><i data-feather="search"></i></span>
            </div>
        </div>
    </div>

    <!-- abas -->
    <ul class="nav nav-tabs mb-4" id="perguntasTabs" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="tab-todos" data-toggle="tab" href="#todos" role="tab">
                Todos <span class="badge badge-secondary ml-1">4</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="tab-aguardando" data-toggle="tab" href="#aguardando" role="tab">
                Aguardando Resposta <span class="badge badge-secondary ml-1">3</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="tab-respondidas" data-toggle="tab" href="#respondidas" role="tab">
                Perguntas Respondidas <span class="badge badge-secondary ml-1">1</span>
            </a>
        </li>
    </ul>

    <div class="tab-content" id="perguntasTabsContent">
        {{-- Todos --}}
        <div class="tab-pane fade show active" id="todos" role="tabpanel" aria-labelledby="tab-todos">
            <div class="list-group list-group-flush">

                {{-- Item respondido --}}
                <div class="list-group-item pb-4">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div class="d-flex align-items-center gap-2">
                            <img src="{{ asset('assets/images/user/avatar-1.jpg') }}"
                                 class="rounded mr-3" width="60" height="60" alt="Blusa de Botão">
                            <div>
                                <strong>Blusa de Botão</strong><br>
                                <small class="text-muted">SKU: 19038403</small>
                            </div>
                        </div>
                        <div class="text-right">
                            <small class="text-muted">19/11/2024</small><br>
                            <a href="#" class="text-secondary mr-2"><i data-feather="eye"></i></a>
                            <a href="#" class="text-secondary mr-2"><i data-feather="heart"></i></a>
                            <a href="#" class="text-danger"><i data-feather="trash-2"></i></a>
                        </div>
                    </div>
                    <div class="mb-1">
                        <strong>Marcelo Carvalho</strong>
                    </div>
                    <div class="mb-1">
                        Boa noite! Qual o material da camiseta? 
                        <small class="text-muted ml-2">2 dias atrás</small>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <i data-feather="corner-down-left" class="mr-2"></i>
                        <span class="text-muted">Olá! tudo bem? A camiseta é de algodão.</span>
                        <a href="#" class="text-secondary ml-2"><i data-feather="edit-3"></i></a>
                    </div>
                </div>

                {{-- Item aguardando resposta 1 --}}
                <div class="list-group-item d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center gap-2">
                        <img src="{{ asset('assets/images/user/avatar-1.jpg') }}"
                             class="rounded mr-3" width="60" height="60" alt="Blusa de Botão">
                        <div>
                            <strong>Blusa de Botão</strong><br>
                            <small class="text-muted">SKU: 19038403</small>
                        </div>
                    </div>
                    <button class="btn btn-purple">
                        <i data-feather="message-circle" class="mr-1"></i> Responder
                    </button>
                </div>

                {{-- Item aguardando resposta 2 --}}
                <div class="list-group-item d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center gap-2">
                        <img src="{{ asset('assets/images/user/avatar-1.jpg') }}"
                             class="rounded mr-3" width="60" height="60" alt="Blusa de Botão">
                        <div>
                            <strong>Blusa de Botão</strong><br>
                            <small class="text-muted">SKU: 19038403</small>
                        </div>
                    </div>
                    <button class="btn btn-purple">
                        <i data-feather="message-circle" class="mr-1"></i> Responder
                    </button>
                </div>

                {{-- Item aguardando resposta 3 --}}
                <div class="list-group-item d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center gap-2">
                        <img src="{{ asset('assets/images/user/avatar-1.jpg') }}"
                             class="rounded mr-3" width="60" height="60" alt="Blusa de Botão">
                        <div>
                            <strong>Blusa de Botão</strong><br>
                            <small class="text-muted">SKU: 19038403</small>
                        </div>
                    </div>
                    <button class="btn btn-purple">
                        <i data-feather="message-circle" class="mr-1"></i> Responder
                    </button>
                </div>
            </div>
        </div>

        {{-- Aguardando Resposta --}}
        <div class="tab-pane fade" id="aguardando" role="tabpanel" aria-labelledby="tab-aguardando">
            <div class="list-group list-group-flush">
                {{-- repetir apenas itens aguardando --}}
                {{-- Item aguardando resposta 1 --}}
                <div class="list-group-item d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center gap-2">
                        <img src="{{ asset('assets/images/user/avatar-1.jpg') }}"
                             class="rounded mr-3" width="60" height="60" alt="Blusa de Botão">
                        <div>
                            <strong>Blusa de Botão</strong><br>
                            <small class="text-muted">SKU: 19038403</small>
                        </div>
                    </div>
                    <button class="btn btn-purple">
                        <i data-feather="message-circle" class="mr-1"></i> Responder
                    </button>
                </div>
                {{-- ... outros ... --}}
            </div>
        </div>

        {{-- Respondidas --}}
        <div class="tab-pane fade" id="respondidas" role="tabpanel" aria-labelledby="tab-respondidas">
            <div class="list-group list-group-flush">
                {{-- repetir apenas itens respondidos --}}
                {{-- Item respondido --}}
                <div class="list-group-item pb-4">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div class="d-flex align-items-center gap-2">
                            <img src="{{ asset('assets/images/user/avatar-1.jpg') }}"
                                 class="rounded mr-3" width="60" height="60" alt="Blusa de Botão">
                            <div>
                                <strong>Blusa de Botão</strong><br>
                                <small class="text-muted">SKU: 19038403</small>
                            </div>
                        </div>
                        <div class="text-right">
                            <small class="text-muted">19/11/2024</small><br>
                            <a href="#" class="text-secondary mr-2"><i data-feather="eye"></i></a>
                            <a href="#" class="text-secondary mr-2"><i data-feather="heart"></i></a>
                            <a href="#" class="text-danger"><i data-feather="trash-2"></i></a>
                        </div>
                    </div>
                    <div class="mb-1"><strong>Marcelo Carvalho</strong></div>
                    <div class="mb-1">
                        Boa noite! Qual o material da camiseta?
                        <small class="text-muted ml-2">2 dias atrás</small>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <i data-feather="corner-down-left" class="mr-2"></i>
                        <span class="text-muted">Olá! tudo bem? A camiseta é de algodão.</span>
                        <a href="#" class="text-secondary ml-2"><i data-feather="edit-3"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script-page')
<script>
document.addEventListener('DOMContentLoaded', function(){
    feather.replace();
    // ativa abas
    $('#perguntasTabs a').on('click', function(e){
        e.preventDefault();
        $(this).tab('show');
    });
});
</script>
@endpush
