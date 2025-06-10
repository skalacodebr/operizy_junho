@extends('layouts.admin')

@section('page-title')
    Review
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="#">Review</a></li>
    <li class="breadcrumb-item active" aria-current="page">Campanhas</li>
@endsection

@section('title')
    <div class="d-inline-block">
        <h5 class="h4 d-inline-block text-white font-weight-bold mb-0">Campanhas</h5>
    </div>
@endsection

@section('content')
<div class="container-fluid">
    <div class="card mb-4">
        <div class="card-body">
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
                    <input type="text" class="form-control" placeholder="Buscar...">
                    <div class="input-group-append">
                        <span class="input-group-text"><i data-feather="search"></i></span>
                    </div>
                </div>
                <button class="btn btn-primary mb-2">
                    <i data-feather="plus"></i> Nova Campanha
                </button>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr class="text-secondary">
                            <th>Nome</th>
                            <th>Avaliações</th>
                            <th>Desconto</th>
                            <th>Conversão</th>
                            <th>Criado em</th>
                            <th>Status</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <strong>Campanha de janeiro</strong><br>
                                <small class="text-muted">Cupom de engajamento</small>
                            </td>
                            <td>
                                <span class="badge badge-light px-2 py-1">{{ number_format(4567, 0, ',', '.') }}</span>
                            </td>
                            <td>
                                <strong>10%</strong>
                            </td>
                            <td>
                                <span class="badge badge-success px-2 py-1">1.2 %</span>
                            </td>
                            <td>15/09/2024</td>
                            <td>
                                <span class="badge badge-pill badge-success">Ativo</span>
                            </td>
                            <td>
                                <a href="#" class="text-secondary mr-2"><i data-feather="copy"></i></a>
                                <a href="#" class="text-secondary mr-2"><i data-feather="edit"></i></a>
                                <a href="#" class="text-danger"><i data-feather="trash-2"></i></a>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Campanha de fevereiro</strong><br>
                                <small class="text-muted">Cupom de engajamento</small>
                            </td>
                            <td>
                                <span class="badge badge-light px-2 py-1">{{ number_format(4567, 0, ',', '.') }}</span>
                            </td>
                            <td>
                                <strong>15%</strong>
                            </td>
                            <td>
                                <span class="badge badge-success px-2 py-1">1.2 %</span>
                            </td>
                            <td>15/09/2024</td>
                            <td>
                                <div class="dropdown">
                                    <span class="badge badge-pill badge-danger dropdown-toggle" data-toggle="dropdown">
                                        Desativado
                                    </span>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="#">Ativar</a>
                                        <a class="dropdown-item" href="#">Excluir</a>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <a href="#" class="text-secondary mr-2"><i data-feather="copy"></i></a>
                                <a href="#" class="text-secondary mr-2"><i data-feather="edit"></i></a>
                                <a href="#" class="text-danger"><i data-feather="trash-2"></i></a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Paginação estática exemplo -->
            <nav class="mt-3">
                <ul class="pagination justify-content-center mb-0">
                    <li class="page-item disabled"><a class="page-link" href="#">Anterior</a></li>
                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><span class="page-link">…</span></li>
                    <li class="page-item"><a class="page-link" href="#">10</a></li>
                    <li class="page-item"><a class="page-link" href="#">Próximo</a></li>
                </ul>
            </nav>
        </div>
    </div>
</div>
@endsection

@push('script-page')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        feather.replace();
        // inicialização de dropdowns do Bootstrap
        $('.dropdown-toggle').dropdown();
    });
</script>
@endpush
