@extends('layouts.admin')

@section('page-title')
Desconto em Massa
@endsection

@push('head')
<meta name="csrf-token" content="{{ csrf_token() }}">
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('desconto-progressivo.index') }}">Desconto Progressivo</a></li>
    <li class="breadcrumb-item active" aria-current="page">Desconto em Massa</li>
@endsection

@section('action-btn')
    <div class="col-auto">
        <a href="{{ route('desconto-progressivo.index') }}" class="btn btn-sm btn-secondary me-2">
            <i class="ti ti-arrow-left"></i> Voltar
        </a>
        <button type="button" class="btn btn-sm btn-primary" onclick="salvarDesconto()">
            <i class="ti ti-device-floppy"></i> Salvar
        </button>
    </div>
@endsection


@section('content')

<style>
    .toggle-section {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 25px;
    }
    
    .custom-toggle {
        position: relative;
        display: inline-block;
        width: 50px;
        height: 24px;
    }
    
    .custom-toggle input {
        opacity: 0;
        width: 0;
        height: 0;
    }
    
    .toggle-slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        transition: .4s;
        border-radius: 24px;
    }
    
    .toggle-slider:before {
        position: absolute;
        content: "";
        height: 18px;
        width: 18px;
        left: 3px;
        bottom: 3px;
        background-color: white;
        transition: .4s;
        border-radius: 50%;
    }
    
    .custom-toggle input[type="checkbox"]:checked + .toggle-slider {
        background: #22c55e;
    }
    
    input:checked + .toggle-slider:before {
        transform: translateX(26px);
    }
    
    .toggle-label {
        font-size: 14px;
        font-weight: 500;
        color: #495057;
    }
    
    .toggle-status {
        background: #22c55e;
        color: #fff;
        border-radius: 12px;
        padding: 2px 12px;
        font-size: 0.95rem;
        margin-left: 6px;
    }
    
    .form-group {
        margin-bottom: 20px;
    }
    
    .form-label {
        font-weight: 500;
        color: #495057;
        margin-bottom: 8px;
    }
    
    .form-control {
        border: 1px solid #d1d5db29;
        border-radius: 8px;
        padding: 10px 14px;
        font-size: 14px;
    }
    
    .form-control:focus {
        border-color: #fff;
        box-shadow: 0 0 0 0.2rem rgba(139, 92, 246, 0.25);
    }
    
    .input-group-text {
        background: #f8f9fa00;
        border: 1px solid #d1d5db47;
        color: #6c757d;
        font-weight: 500;
    }
    
    .date-input {
        position: relative;
    }
    
    .date-input .form-control {
        background: #f8f9fa00;
        color: #6c757d;
        cursor: pointer;
    }


    
    .date-input::after {
        content: '\f073';
        font-family: 'Font Awesome 5 Free';
        font-weight: 900;
        position: absolute;
        right: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: #3b3c45;
        pointer-events: none;
    }
    
    .alert-primary {
        background-color: rgba(13, 110, 253, 0.1);
        border-color: rgba(13, 110, 253, 0.2);
        color: #084298;
    }
    
    .estado-tag {
        display: inline-block;
        background: #e9ecef;
        color: #495057;
        padding: 5px 12px;
        margin: 3px;
        border-radius: 20px;
        font-size: 12px;
        cursor: pointer;
        transition: all 0.3s ease;
        border: 2px solid transparent;
    }
    
    .estado-tag:hover {
        background: #dee2e6;
        transform: translateY(-1px);
    }
    
    .estado-tag.selected {
        background: #fb6c2b;
        color: white;
        border-color: #fb6c2b;
    }
    
    .padding-estado {
        padding: 2px;
    }
    
    .regra-desconto {
        background: #f8f9fa00;
    border: 1px solid #e9ecef00;
    border-radius: 12px;
    padding: 20px;
    margin-bottom: 15px;
    position: relative;
    }
    
    .regra-header {
        display: flex;
        justify-content: between;
        align-items: center;
        margin-bottom: 15px;
    }
    
    .regra-title {
        font-weight: 600;
    }
    
    /* Estilos para o modal de seleção de produtos */
    .produto-selecao-item {
        background: #fff;
        border: 2px solid #e9ecef;
        border-radius: 8px;
        padding: 12px;
        margin-bottom: 10px;
        cursor: pointer;
        transition: all 0.3s ease;
        position: relative;
    }
    
    .produto-selecao-item:hover {
        border-color: #007bff;
        box-shadow: 0 2px 8px rgba(0, 123, 255, 0.1);
        transform: translateY(-1px);
    }
    
    .produto-selecao-item.selected {
        border-color: #28a745;
        background-color: #f8fff9;
    }
    
    .produto-imagem-modal {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border-radius: 6px;
        border: 1px solid #dee2e6;
    }
    
    .produto-nome-modal {
        font-weight: 600;
        color: #495057;
        margin-bottom: 4px;
    }
    
    .produto-detalhes {
        font-size: 12px;
    }
    
    .produto-checkbox {
        width: 24px;
        height: 24px;
        border: 2px solid #dee2e6;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }
    
    .produto-selecao-item.selected .produto-checkbox {
        background-color: #28a745;
        border-color: #28a745;
        color: white;
    }
    
    .produto-selecao-item:not(.selected) .produto-checkbox i {
        display: none;
    }
    
    /* Estilos para produtos selecionados */
    .produto-item {
        display: flex;
        align-items: center;
        background: #f8f9fa;
        border: 1px solid #e9ecef;
        border-radius: 8px;
        padding: 12px;
        margin-bottom: 8px;
        transition: all 0.3s ease;
    }
    
    .produto-item:hover {
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    
    .produto-imagem {
        width: 40px;
        height: 40px;
        object-fit: cover;
        border-radius: 6px;
        margin-right: 12px;
        border: 1px solid #dee2e6;
    }
    
    .produto-info {
        flex-grow: 1;
    }
    
    .produto-nome {
        font-weight: 600;
        color: #495057;
        margin-bottom: 2px;
        font-size: 14px;
    }
    
    .produto-codigo {
        color: #6c757d;
        font-size: 12px;
    }
    
    .btn-remove-produto {
        background: none;
        border: none;
        color: #dc3545;
        padding: 4px;
        border-radius: 4px;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 32px;
        height: 32px;
    }
    
    .btn-remove-produto:hover {
        background-color: #dc3545;
        color: white;
    }
    
    /* Loading animation */
    .animate-spin {
        animation: spin 1s linear infinite;
    }
    
    @keyframes spin {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg);
    }
        color: #495057;
        margin-bottom: 5px;
    }
    
    .regra-description {
        font-size: 12px;
        color: #6c757d;
        margin-bottom: 15px;
    }
    
    .regra-campos {
        display: flex;
        gap: 15px;
        align-items: end;
        flex-wrap: wrap;
    }
    
    .campo-desconto, .campo-quantidade {
        flex: 1;
        min-width: 200px;
    }
    
    .input-counter {
        display: flex;
        align-items: center;
        border: 1px solid #d1d5db47;
        border-radius: 8px;
        overflow: hidden;
    }
    
    .counter-btn {
        background: #f8f9fa00;
        border: none;
        padding: 10px 12px;
        cursor: pointer;
        color: #6c757d;
        transition: all 0.3s ease;
    }
    
    .counter-btn:hover {
        background: #e9ecef;
        color: #495057;
    }
    
    .counter-input {
        border: none;
        text-align: center;
        width: 60px;
        padding: 10px 5px;
        background: transparent;
        color: #fff;
    }
    
    .counter-input:focus {
        outline: none;
    }
    
    .btn-remove-regra {
        position: absolute;
        top: 15px;
        right: 15px;
        background: none;
        border: none;
        color: #dc3545;
        font-size: 18px;
        cursor: pointer;
    }
    
    .btn-remove-regra:hover {
        color: #c82333;
    }
    
    .produto-item {
        display: flex;
        align-items: center;
        background: #f8f9fa;
        border: 1px solid #e9ecef;
        border-radius: 8px;
        padding: 12px;
        margin-bottom: 8px;
    }
    
    .produto-imagem {
        width: 40px;
        height: 40px;
        border-radius: 6px;
        margin-right: 12px;
        object-fit: cover;
    }
    
    .produto-info {
        flex: 1;
    }
    
    .produto-nome {
        font-weight: 500;
        color: #495057;
        margin-bottom: 2px;
    }
    
    .produto-codigo {
        font-size: 12px;
        color: #6c757d;
    }
    
    .btn-remove-produto {
        background: none;
        border: none;
        color: #dc3545;
        font-size: 16px;
        cursor: pointer;
        padding: 5px;
    }
    
    .btn-remove-produto:hover {
        color: #c82333;
    }
    
    .cliente-item {
        border: 1px solid #e9ecef;
        border-radius: 8px;
        padding: 12px;
        margin-bottom: 8px;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .cliente-item:hover {
        border-color: #0d6efd;
        background: #f8f9fa;
    }
    
    .cliente-item.selected {
        border-color: #0d6efd;
        background: rgba(13, 110, 253, 0.1);
    }
    
    .cliente-selecionado {
        background: #e7f3ff;
        border: 1px solid #0d6efd;
        border-radius: 8px;
        padding: 8px 12px;
        margin: 4px;
        display: inline-block;
        font-size: 12px;
    }
    
    .btn-remove-cliente {
        background: none;
        border: none;
        color: #dc3545;
        font-size: 16px;
        margin-left: 8px;
        cursor: pointer;
    }
    
    .card-header.clickable {
        cursor: pointer;
        transition: background-color 0.3s ease;
    }
    
    /* Estilos para clientes */
    .cliente-item {
        background: #fff;
        border: 2px solid #e9ecef;
        border-radius: 8px;
        padding: 12px;
        margin-bottom: 10px;
        cursor: pointer;
        transition: all 0.3s ease;
        position: relative;
    }
    
    .cliente-item:hover {
        border-color: #007bff;
        box-shadow: 0 2px 8px rgba(0, 123, 255, 0.1);
        transform: translateY(-1px);
    }
    
    .cliente-item.selected {
        border-color: #28a745;
        background-color: #f8fff9;
    }
    
    .cliente-item.selected .cliente-checkbox {
        display: block;
    }
    
    .cliente-avatar img {
        object-fit: cover;
    }
    
    .avatar-placeholder {
        width: 40px;
        height: 40px;
        background: #e9ecef;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #6c757d;
        font-size: 18px;
    }
    
    .cliente-checkbox {
        position: absolute;
        top: 12px;
        right: 12px;
        width: 24px;
        height: 24px;
        background: #28a745;
        border-radius: 50%;
        display: none;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 14px;
    }
    
    .cliente-selecionado {
        background: #e7f3ff;
        border: 1px solid #007bff;
        border-radius: 20px;
        padding: 5px 10px;
        margin: 3px;
        font-size: 12px;
        display: inline-block;
        position: relative;
        padding-right: 25px;
    }
    
    .btn-remove-cliente {
        background: none;
        border: none;
        color: #dc3545;
        position: absolute;
        right: 5px;
        top: 50%;
        transform: translateY(-50%);
        padding: 0;
        width: 16px;
        height: 16px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 10px;
    }
    
    .btn-remove-cliente:hover {
        background: #dc3545;
        color: white;
    }
    
    /* Estilos para botões de tipo de desconto */
    .btn-group .btn-check:checked + .btn {
        background-color: #fb643b !important;
        border-color: #fb643b !important;
        color: white !important;
    }
    
    .btn-group .btn:not(.btn-check:checked + .btn) {
        background-color: #f8f9fa;
        border-color: #dee2e6;
        color: #6c757d;
    }
    
    .btn-group .btn:hover:not(.btn-check:checked + .btn) {
        background-color: #e9ecef;
        border-color: #dee2e6;
        color: #495057;
    }
    
    .produto-detalhes {
        font-size: 12px;
    }
    
    .produto-checkbox {
        position: absolute;
        top: 15px;
        right: 15px;
    }

</style>

<div class="container-fluid mt-5">
    <div class="row">
        <!-- Sidebar com informações -->
        <div class="col-lg-4">
            <div class="card h-100">
                <div class="card-header border-0 pb-0">
                    <h6 class="card-title mb-0">
                        <i class="ti ti-tag text-primary me-2"></i>
                        Informações do Desconto
                    </h6>
                </div>
                <div class="card-body">
                    <p class="text-muted mb-3">Cadastre as informações e configurações do Desconto.</p>
                    
                    <div class="alert alert-primary border-0" role="alert">
                        <i class="ti ti-tag me-2 text-secondary"></i>
                        <strong style="color: #fb6c2b;">Resumo:</strong>
                        <div class="mt-2" id="resumoDesconto">
                            <ul class="list-unstyled mb-0 mt-2">
                                <li class="mb-1">
                                    <i class="ti ti-percentage text-muted me-1"></i>
                                    <span class="text-secondary" id="resumoPorcentagem">00,00% de desconto</span>
                                </li>
                                <li class="mb-1">
                                    <i class="ti ti-shopping-cart text-muted me-1"></i>
                                    <span class="text-secondary" id="resumoCompraMinima">Compra mínima de R$ 0,00</span>
                                </li>
                                <li class="mb-1">
                                    <i class="ti ti-user-check text-muted me-1"></i>
                                    <span class="text-secondary" id="resumoUtilizacao">Utilização única por cliente</span>
                                </li>
                                <li class="mb-1">
                                    <i class="ti ti-users text-muted me-1"></i>
                                    <span class="text-secondary" id="resumoClientes">Qualquer cliente pode utilizar</span>
                                </li>
                                <li class="mb-0">
                                    <i class="ti ti-calendar text-muted me-1"></i>
                                    <span class="text-secondary" id="resumoValidade">Válida a partir de hoje</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Área principal de configuração -->
        <div class="col-lg-8">
            
            <!-- Card: Ativar desconto em massa -->
            <div class="card mb-4">
                <div class="card-body">
                    <!-- Switch de ativação -->
                    <div class="d-flex align-items-center mb-3">
                        <label class="custom-toggle me-2 mb-0">
                            <input type="checkbox" id="ativarDescontoMassa" checked>
                            <span class="toggle-slider"></span>
                        </label>
                        <span class="toggle-status bg-success me-2">SIM</span>
                        <span class="fw-semibold" style="color: #495057;">Ativar desconto em massa</span>
                    </div>

                    <!-- Descrição -->
                    <div class="form-group mb-3">
                        <label for="descricaoDesconto" class="form-label fw-semibold">Descrição</label>
                        <input type="text" class="form-control" id="descricaoDesconto" placeholder="Ex: Toda categoria Masculina com 20% Off">
                    </div>

                    <!-- Tipo de Desconto -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Tipo de Desconto</label>
                        <div class="btn-group w-100" role="group">
                            <input type="radio" class="btn-check" name="tipoDesconto" id="porcentagem" value="porcentagem" autocomplete="off" checked>
                            <label class="btn btn-outline-primary" for="porcentagem">Porcentagem (%)</label>

                            <input type="radio" class="btn-check" name="tipoDesconto" id="valor_fixo" value="valor_fixo" autocomplete="off">
                            <label class="btn btn-outline-primary" for="valor_fixo">Valor fixo (R$)</label>
                        </div>
                    </div>

                    <!-- Porcentagem e Valor Fixo -->
                    <div class="row">
                        <div class="col-6" id="divPorcentagemDesconto">
                            <label for="porcentagemDesconto" class="form-label fw-semibold">Porcentagem</label>
                            <div class="input-group">
                                <span class="input-group-text">%</span>
                                <input type="number" class="form-control" id="porcentagemDesconto" value="0" min="0" max="100">
                            </div>
                        </div>
                        <div class="col-6" id="divValorFixoDesconto" style="display:none;">
                            <label for="valorFixoDesconto" class="form-label fw-semibold">Valor Fixo</label>
                            <div class="input-group">
                                <span class="input-group-text">R$</span>
                                <input type="number" class="form-control" id="valorFixoDesconto" value="0" min="0" step="0.01">
                            </div>
                        </div>
                        <div class="col-6">
                            <label for="valorMinimoProduto" class="form-label fw-semibold">Valor mínimo do produto</label>
                            <div class="input-group">
                                <span class="input-group-text">R$</span>
                                <input type="text" class="form-control" id="valorMinimoProduto" value="00,00">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

              <!-- Card: Aplicação em Produtos -->
              <div class="card mb-4">
                <div class="card-header">
                    <h6 class="card-title mb-0">
                        <i class="ti ti-package text-primary me-2"></i>
                        Aplicação em Produtos
                    </h6>
                </div>
                <div class="card-body">
                    <!-- Toggle Todos os Produtos -->
                    <div class="toggle-section">
                        <label class="custom-toggle">
                            <input type="checkbox" id="todosProdutos">
                            <span class="toggle-slider"></span>
                        </label>
                        <span class="toggle-status" id="statusTodosProdutos">NÃO</span>
                        <span class="toggle-label">Aplicar para todos os produtos</span>
                    </div>
                    
                    <div id="seletorProdutos">
                        <div class="form-group mb-3">
                            <label for="tipoAplicacao" class="form-label">Aplicar em</label>
                            <select class="form-control" id="tipoAplicacao">
                                <option value="produtos" selected>Produtos</option>
                            </select>
                        </div>
                        
                        <button type="button" class="btn btn-outline-primary w-100 mb-3" onclick="abrirSeletorProdutos()">
                            <i class="ti ti-plus me-1"></i> Selecionar Produtos
                        </button>
                        
                        <div id="produtosSelecionados">
                            <h6 class="text-muted mb-3">Produtos selecionados</h6>
                            <div id="listaProdutosSelecionados">
                                <!-- Produtos selecionados aparecerão aqui -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Card: Estados Específicos -->
            <div class="card mb-4">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="card-title mb-0">
                            <i class="ti ti-map-pin text-primary me-2"></i>
                            Estados específicos
                        </h6>
                        <span class="badge bg-primary" id="contadorEstados">0 Estados</span>
                    </div>
                </div>
                <div class="card-body" id="estadosBody">
                    <div class="row" id="listaEstados">
                        <!-- Estados serão carregados aqui -->
                    </div>
                </div>
            </div>
            
            <!-- Card: Clientes Específicos -->
            <div class="card mb-4">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="card-title mb-0">
                            <i class="ti ti-users text-primary me-2"></i>
                            Clientes específicos
                        </h6>
                        <span class="badge bg-primary" id="contadorClientes">Todos os Clientes</span>
                    </div>
                </div>
                <div class="card-body" id="clientesBody">
                    <div class="form-group mb-3">
                        <label for="selectClientes" class="form-label">Selecionar Clientes</label>
                        <select class="form-control" id="selectClientes" onchange="handleClienteSelection()">
                            <option value="todos" selected>Todos os Clientes</option>
                            <option value="especificos">Clientes Específicos</option>
                        </select>
                    </div>
                    
                    <div id="clientesEspecificosSection" style="display: none;">
                        <div class="row mb-3">
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="buscarCliente" placeholder="Digite o nome ou email do cliente...">
                            </div>
                            <div class="col-md-4">
                                <button type="button" class="btn btn-outline-primary w-100" onclick="buscarClientes()">
                                    <i class="ti ti-search me-1"></i> Buscar
                                </button>
                            </div>
                        </div>
                        <div id="resultadosClientes">
                            <!-- Resultados da busca aparecerão aqui -->
                        </div>
                        <div id="clientesSelecionados" class="mt-3">
                            <!-- Clientes selecionados aparecerão aqui -->
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Card: Configurações Avançadas -->
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="card-title mb-0">
                        <i class="ti ti-settings-2 text-primary me-2"></i>
                        Configurações Avançadas
                    </h6>
                </div>
                <div class="card-body">
                    <!-- Toggle Permitir uso com outras promoções -->
                    <div class="toggle-section mb-0">
                        <label class="custom-toggle">
                            <input type="checkbox" id="permitirOutrasPromocoes">
                            <span class="toggle-slider"></span>
                        </label>
                        <span class="toggle-status" id="statusOutrasPromocoes">NÃO</span>
                        <span class="toggle-label">Permitir o uso em produtos com outras promoções já ativas</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script-page')
<script>
// Função utilitária para mostrar mensagens
function mostrarMensagem(mensagem, tipo) {
    if (typeof toastr !== 'undefined') {
        // Usar Toastr se estiver disponível
        switch(tipo) {
            case 'success':
                toastr.success(mensagem);
                break;
            case 'error':
                toastr.error(mensagem);
                break;
            case 'warning':
                toastr.warning(mensagem);
                break;
            case 'info':
                toastr.info(mensagem);
                break;
            default:
                toastr.info(mensagem);
        }
    } else {
        // Fallback para alert padrão
        alert(mensagem);
    }
}

$(document).ready(function() {
    // Inicializar tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
    
    // Toggle para ativar frete grátis
    $('#ativarDesconto').change(function() {
        const isChecked = $(this).is(':checked');
        const status = $(this).siblings('.toggle-status');
        
        if (isChecked) {
            status.text('SIM').removeClass('bg-danger').addClass('bg-success');
        } else {
            status.text('NÃO').removeClass('bg-success').addClass('bg-danger');
        }
        updateResumo();
    });
    
    // Função para alternar entre os campos de porcentagem e valor fixo
    $('input[name="tipoDesconto"]').change(function() {
        const tipoSelecionado = $('input[name="tipoDesconto"]:checked').attr('id');
        console.log('Tipo de desconto selecionado:', tipoSelecionado);
        
        if (tipoSelecionado === 'porcentagem') {
            $('#divPorcentagemDesconto').show();
            $('#divValorFixoDesconto').hide();
            $('#valorFixoDesconto').val(0); // Reset valor fixo
        } else if (tipoSelecionado === 'valor_fixo') {
            $('#divPorcentagemDesconto').hide();
            $('#divValorFixoDesconto').show();
            $('#porcentagemDesconto').val(0); // Reset porcentagem
        }
        
        updateResumo();
    });
    
    // Inicializar o tipo de desconto na carga da página
    $('input[name="tipoDesconto"]:checked').trigger('change');
    
    // Controle das condições de aplicação
    $('input[name="condicaoAplicacao"]').on('change click', function() {
        console.log('Radio button mudou para:', $(this).val());
        controlarCamposCondicao();
    });
    
    // Toggle para limitar por data
    $('#limitarData').change(function() {
        const isChecked = $(this).is(':checked');
        const status = $(this).siblings('.toggle-status');
        const dateFields = $('#dataInicio, #dataFim');
        
        if (isChecked) {
            status.text('SIM').removeClass('bg-danger').addClass('bg-success');
            dateFields.prop('disabled', false);
        } else {
            status.text('NÃO').removeClass('bg-success').addClass('bg-danger');
            dateFields.prop('disabled', true);
            // Limpar campos de data quando desabilitar
            dateFields.val('');
        }
        updateResumo();
    });
    
    // Validação simples para valor monetário
    $('#valorMinimo').on('input', function() {
        let valor = $(this).val();
        // Permitir apenas números e ponto decimal
        valor = valor.replace(/[^0-9,]/g, '');
        // Substituir vírgula por ponto
        valor = valor.replace(',', '.');
        $(this).val(valor);
    });
    
    // Validação de datas
    $('#dataInicio, #dataFim').change(function() {
        const dataInicio = new Date($('#dataInicio').val());
        const dataFim = new Date($('#dataFim').val());
        
        if (dataInicio && dataFim && dataInicio >= dataFim) {
            Swal.fire({
                icon: 'warning',
                title: 'Data inválida',
                text: 'A data de início deve ser anterior à data de fim.',
                confirmButtonColor: '#fb6c2b'
            });
            $(this).val('');
        }
        updateResumo();
    });
    
    // Atualizar resumo quando campos mudarem
    $('#descricaoCupom, #porcentagemDesconto, #valorFixoDesconto, #dataInicio, #dataFim, #valorMinimoProduto, #quantidadeMinimaProdutos').on('input change', updateResumo);
    
    // Função para atualizar resumo do Desconto
    function updateResumo() {
        const ativo = $('#ativarDesconto').is(':checked');
        const tipoDesconto = $('input[name="tipoDesconto"]:checked').val();
        const porcentagem = parseFloat($('#porcentagemDesconto').val()) || 0;
        const valorFixo = parseFloat($('#valorFixoDesconto').val()) || 0;
        const limitarData = $('#limitarData').is(':checked');
        const dataInicio = $('#dataInicio').val();
        const dataFim = $('#dataFim').val();
        const selectClientes = $('#selectClientes').val();
        const ativarLeveMais = $('#ativarLeveMais').is(':checked');
        const tituloPromocao = $('#tituloPromocao').val();
        const ativarValorMinimo = $('#ativarValorMinimo').is(':checked');
        const valorMinimo = parseFloat($('#valorMinimo').val()) || 0;
        const quantidadeCompra = parseInt($('#quantidadeCompra').val()) || 3;
        const quantidadeDesconto = parseInt($('#quantidadeDesconto').val()) || 1;
        
        // Atualizar desconto baseado no tipo
        if (tipoDesconto === 'porcentagem') {
            $('#resumoPorcentagem').text(`${porcentagem.toFixed(2).replace('.', ',')}% de desconto`);
        } else {
            $('#resumoPorcentagem').text(`R$ ${valorFixo.toFixed(2).replace('.', ',')} de desconto`);
        }
        
        // Atualizar valor mínimo (do "Leve mais e pague menos")
        if (ativarLeveMais) {
            // Texto da regra Leve Mais e Pague Menos
            const textoRegra = `"Compre ${quantidadeCompra} itens e ganhe ${quantidadeDesconto} grátis"`;
            $('#resumoCompraMinima').html(`Regra: ${textoRegra}<br>Desconto aplicado aos itens mais baratos`);
            
            if (ativarValorMinimo) {
                $('#resumoCompraMinima').append(`<br>Valor mínimo: R$ ${valorMinimo.toFixed(2).replace('.', ',')}`);
            }
        } else {
            $('#resumoCompraMinima').text(`Desconto "Leve mais e pague menos" desativado`);
        }
        
        // Atualizar utilização (sempre única para frete grátis)
        $('#resumoUtilizacao').text('Utilização única por cliente');
        
        // Atualizar clientes
        if (selectClientes === 'todos') {
            $('#resumoClientes').text('Qualquer cliente pode utilizar');
        } else if (clientesSelecionados && clientesSelecionados.length > 0) {
            if (clientesSelecionados.length === 1) {
                $('#resumoClientes').text('1 cliente específico pode utilizar');
            } else {
                $('#resumoClientes').text(`${clientesSelecionados.length} clientes específicos podem utilizar`);
            }
        } else {
            $('#resumoClientes').text('Nenhum cliente selecionado');
        }
        
        // Atualizar validade
        if (limitarData && dataInicio && dataFim) {
            const inicio = new Date(dataInicio).toLocaleDateString('pt-BR');
            const fim = new Date(dataFim).toLocaleDateString('pt-BR');
            $('#resumoValidade').text(`Válida de ${inicio} até ${fim}`);
        } else if (limitarData && dataInicio) {
            const inicio = new Date(dataInicio).toLocaleDateString('pt-BR');
            $('#resumoValidade').text(`Válida a partir de ${inicio}`);
        } else {
            const hoje = new Date().toLocaleDateString('pt-BR');
            $('#resumoValidade').text(`Válida a partir de ${hoje}`);
        }
        
        // Adicionar classe de destaque se inativo
        const resumoContainer = $('#resumoDesconto');
        if (!ativo) {
            resumoContainer.addClass('text-muted');
            resumoContainer.find('span').addClass('text-muted');
        } else {
            resumoContainer.removeClass('text-muted');
            resumoContainer.find('span').removeClass('text-muted');
        }
    }
    
    // REMOVIDO: função de teste que pode interferir
    
    // Inicializar os campos de condição
    setTimeout(function() {
        console.log('Inicializando campos de condição...');
        // Garantir que o campo valor mínimo esteja visível por padrão
        controlarCamposCondicao();
    }, 200);
    
    // Toggle para Leve mais e pague menos
    $('#ativarLeveMais').change(function() {
        const isChecked = $(this).is(':checked');
        const status = $(this).siblings('.toggle-status');
        
        if (isChecked) {
            status.text('SIM').removeClass('bg-danger').addClass('bg-success');
        } else {
            status.text('NÃO').removeClass('bg-success').addClass('bg-danger');
        }
        updateResumo();
    });
    
    // Toggle para valor mínimo do produto
    $('#ativarValorMinimo').change(function() {
        const isChecked = $(this).is(':checked');
        const status = $(this).siblings('.toggle-status');
        
        if (isChecked) {
            status.text('SIM').removeClass('bg-danger').addClass('bg-success');
            $('#valorMinimo').prop('disabled', false);
        } else {
            status.text('NÃO').removeClass('bg-success').addClass('bg-danger');
            $('#valorMinimo').prop('disabled', true);
        }
        updateResumo();
    });
    
    // Eventos para campos da regra Leve Mais e Pague Menos
    $('#quantidadeCompra, #quantidadeDesconto').on('input change', function() {
        // Garantir que o valor seja pelo menos 1
        if (parseInt($(this).val()) < 1) {
            $(this).val(1);
        }
        
        // Atualizar texto no item(s) se for o campo de desconto
        if (this.id === 'quantidadeDesconto') {
            const qtd = parseInt($(this).val());
            const texto = qtd === 1 ? 'ITEM(S)' : 'ITENS';
            $(this).closest('.d-flex').find('.ms-2 + h6').text(texto);
        }
        
        updateResumo();
    });
    
    // Formatar input de valor mínimo
    $('#valorMinimo').on('input', function() {
        let valor = $(this).val();
        // Permitir apenas números e ponto decimal
        valor = valor.replace(/[^0-9,]/g, '');
        // Substituir vírgula por ponto
        valor = valor.replace(',', '.');
        $(this).val(valor);
    });
    
    // Inicializar resumo
    updateResumo();
    
    // Função para controlar campos de condição - MOVIDA PARA DENTRO DO ESCOPO
    function controlarCamposCondicao() {
        // Debug: verificar quantos radio buttons existem
        const todosRadios = $('input[name="condicaoAplicacao"]');
        console.log('Total de radio buttons encontrados:', todosRadios.length);
        
        // Debug: verificar qual está selecionado
        const radioSelecionado = $('input[name="condicaoAplicacao"]:checked');
        console.log('Radio selecionado:', radioSelecionado.length > 0 ? radioSelecionado.attr('id') : 'nenhum');
        
        const condicao = radioSelecionado.val();
        console.log('Valor da condição selecionada:', condicao);
        
        // Ocultar todos os campos primeiro
        $('#campoValorMinimoProduto').hide();
        $('#campoQuantidadeMinima').hide();
        
        // Mostrar o campo correspondente
        switch(condicao) {
            case 'valor_minimo':
                $('#campoValorMinimoProduto').show();
                console.log('Mostrando campo valor mínimo');
                break;
            case 'quantidade_minima':
                $('#campoQuantidadeMinima').show();
                console.log('Mostrando campo quantidade mínima');
                break;
            case 'sempre':
                console.log('Opção sempre selecionada - nenhum campo adicional');
                break;
            default:
                console.log('Nenhuma condição válida selecionada');
                // Se nenhum estiver selecionado, mostrar valor_minimo por padrão
                $('#valorMinimo').prop('checked', true);
                $('#campoValorMinimoProduto').show();
                console.log('Selecionado valor_minimo por padrão');
                break;
        }
        
        // Chamar updateResumo com try/catch para debug
        try {
            updateResumo();
        } catch (error) {
            console.error('Erro ao chamar updateResumo:', error);
        }
    }
    
    // Inicializar estados e clientes
    initEstados();
    initClientes();
    initProdutos();
    initConfiguracoes();
});

// Estados brasileiros
const estadosBrasil = [
    'Acre', 'Alagoas', 'Amapá', 'Amazonas', 'Bahia', 'Ceará', 'Distrito Federal',
    'Espírito Santo', 'Goiás', 'Maranhão', 'Mato Grosso', 'Mato Grosso do Sul',
    'Minas Gerais', 'Pará', 'Paraíba', 'Paraná', 'Pernambuco', 'Piauí',
    'Rio de Janeiro', 'Rio Grande do Norte', 'Rio Grande do Sul', 'Rondônia',
    'Roraima', 'Santa Catarina', 'São Paulo', 'Sergipe', 'Tocantins'
];

let estadosSelecionados = [];
let clientesSelecionados = [];
let produtosSelecionados = [];

function initEstados() {
    // Fazer header clicável
    $('.card').has('#estadosBody').find('.card-header').addClass('clickable').click(function() {
        $('#estadosBody').slideToggle();
        carregarEstados();
    });
    
    // Carregar estados automaticamente quando a página carregar (já que a seção fica aberta)
    carregarEstados();
}

function carregarEstados() {
    if ($('#listaEstados').children().length === 0) {
        let html = '';
        estadosBrasil.forEach(estado => {
            html += `<div class="col-auto padding-estado">
                        <span class="estado-tag" onclick="toggleEstado('${estado}')">${estado}</span>
                     </div>`;
        });
        $('#listaEstados').html(html);
    }
}

function toggleEstado(estado) {
    const index = estadosSelecionados.indexOf(estado);
    const element = $(`.estado-tag:contains('${estado}')`);
    
    if (index > -1) {
        estadosSelecionados.splice(index, 1);
        element.removeClass('selected');
    } else {
        estadosSelecionados.push(estado);
        element.addClass('selected');
    }
    
    updateContadorEstados();
    updateResumo();
}

function updateContadorEstados() {
    const total = estadosSelecionados.length;
    $('#contadorEstados').text(`${total} Estado${total !== 1 ? 's' : ''}`);
}

function initClientes() {
    // Fazer header clicável
    $('.card').has('#clientesBody').find('.card-header').addClass('clickable').click(function() {
        $('#clientesBody').slideToggle();
    });
}

function handleClienteSelection() {
    const selectValue = $('#selectClientes').val();
    
    if (selectValue === 'todos') {
        $('#clientesEspecificosSection').slideUp();
        clientesSelecionados = [];
        $('#resultadosClientes').html('');
        updateContadorClientes();
        updateResumo();
    } else if (selectValue === 'especificos') {
        $('#clientesEspecificosSection').slideDown();
        updateContadorClientes();
        updateResumo();
        
        // Carregar clientes automaticamente quando a seção abrir
        carregarTodosClientes();
    }
}

function carregarTodosClientes() {
    // Mostrar loading
    $('#resultadosClientes').html('<div class="text-center py-3"><i class="ti ti-loader-2 animate-spin me-2"></i>Carregando clientes...</div>');
    
    // Carregar todos os clientes da loja
    $.ajax({
        url: '{{ route("minha-loja-clientes") }}',
        method: 'GET',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            'Accept': 'application/json'
        },
        success: function(response) {
            if (response.sucesso && response.dados) {
                const clientes = response.dados.clientes;
                
                let html = '';
                if (clientes.length > 0) {
                    html += '<div class="mb-3"><small class="text-muted">Todos os clientes da sua loja:</small></div>';
                    
                    clientes.forEach(cliente => {
                        const jaSelecionado = clientesSelecionados.find(c => c.id === cliente.id);
                        html += `
                            <div class="cliente-item ${jaSelecionado ? 'selected' : ''}" onclick="toggleCliente(${cliente.id}, '${cliente.name}', '${cliente.email}')">
                                <div class="d-flex align-items-center">
                                    <div class="cliente-avatar me-3">
                                        ${cliente.avatar && cliente.avatar !== 'avatar.png' ? 
                                            `<img src="{{ asset('storage/uploads/') }}/${cliente.avatar}" alt="${cliente.name}" class="rounded-circle" width="40" height="40">` : 
                                            `<div class="avatar-placeholder"><i class="ti ti-user"></i></div>`
                                        }
                                    </div>
                                    <div class="flex-grow-1">
                                        <strong>${cliente.name}</strong><br>
                                        <small class="text-muted">${cliente.email}</small>
                                        ${cliente.phone_number ? `<br><small class="text-info"><i class="ti ti-phone me-1"></i>${cliente.phone_number}</small>` : ''}
                                    </div>
                                    <div class="cliente-checkbox">
                                        <i class="ti ti-check"></i>
                                    </div>
                                </div>
                            </div>
                        `;
                    });
                    
                    // Mostrar estatísticas
                    html += `<div class="mt-3 pt-3 border-top">
                                <small class="text-muted">
                                    <i class="ti ti-info-circle me-1"></i>
                                    Total: ${response.dados.estatisticas.total_clientes} clientes
                                    ${response.dados.estatisticas.clientes_com_telefone > 0 ? ` • ${response.dados.estatisticas.clientes_com_telefone} com telefone` : ''}
                                </small>
                             </div>`;
                } else {
                    html = '<div class="text-muted text-center py-4"><i class="ti ti-users-off mb-2" style="font-size: 2rem;"></i><br>Nenhum cliente cadastrado na sua loja</div>';
                }
                
                $('#resultadosClientes').html(html);
                
            } else {
                $('#resultadosClientes').html('<div class="text-danger text-center py-3">Erro ao carregar clientes</div>');
                Swal.fire({
                    icon: 'error',
                    title: 'Erro ao carregar',
                    text: 'Erro ao carregar clientes: ' + (response.erro || 'Erro desconhecido'),
                    confirmButtonColor: '#dc3545'
                });
            }
        },
        error: function(xhr, status, error) {
            console.error('Erro ao carregar clientes:', xhr.responseJSON);
            
            let mensagemErro = 'Erro ao carregar clientes';
            if (xhr.responseJSON && xhr.responseJSON.erro) {
                mensagemErro = xhr.responseJSON.erro;
            } else if (xhr.status === 401) {
                mensagemErro = 'Usuário não autenticado';
            } else if (xhr.status === 404) {
                mensagemErro = 'Loja não encontrada';
            }
            
            $('#resultadosClientes').html(`<div class="text-danger text-center py-3">${mensagemErro}</div>`);
            Swal.fire({
                icon: 'error',
                title: 'Erro ao carregar',
                text: mensagemErro,
                confirmButtonColor: '#dc3545'
            });
        }
    });
}

function buscarClientes() {
    const termo = $('#buscarCliente').val().trim();
    
    if (termo.length < 2) {
        Swal.fire({
            icon: 'warning',
            title: 'Campo obrigatório',
            text: 'Digite pelo menos 2 caracteres para buscar',
            confirmButtonColor: '#fb6c2b'
        });
        return;
    }
    
    // Mostrar loading
    $('#resultadosClientes').html('<div class="text-center py-3"><i class="ti ti-loader-2 animate-spin me-2"></i>Carregando clientes...</div>');
    
    // Buscar clientes através da API
    $.ajax({
        url: '{{ route("minha-loja-clientes") }}',
        method: 'GET',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            'Accept': 'application/json'
        },
        success: function(response) {
            if (response.sucesso && response.dados) {
                const todosClientes = response.dados.clientes;
                
                // Filtrar clientes pelo termo de busca
                const clientesEncontrados = todosClientes.filter(cliente => 
                    cliente.name.toLowerCase().includes(termo.toLowerCase()) ||
                    cliente.email.toLowerCase().includes(termo.toLowerCase()) ||
                    (cliente.phone_number && cliente.phone_number.includes(termo))
                );
                
                let html = '';
                if (clientesEncontrados.length > 0) {
                    clientesEncontrados.forEach(cliente => {
                        const jaSelecionado = clientesSelecionados.find(c => c.id === cliente.id);
                        html += `
                            <div class="cliente-item ${jaSelecionado ? 'selected' : ''}" onclick="toggleCliente(${cliente.id}, '${cliente.name}', '${cliente.email}')">
                                <div class="d-flex align-items-center">
                                    <div class="cliente-avatar me-3">
                                        ${cliente.avatar && cliente.avatar !== 'avatar.png' ? 
                                            `<img src="{{ asset('storage/uploads/') }}/${cliente.avatar}" alt="${cliente.name}" class="rounded-circle" width="40" height="40">` : 
                                            `<div class="avatar-placeholder"><i class="ti ti-user"></i></div>`
                                        }
                                    </div>
                                    <div class="flex-grow-1">
                                        <strong>${cliente.name}</strong><br>
                                        <small class="text-muted">${cliente.email}</small>
                                        ${cliente.phone_number ? `<br><small class="text-info"><i class="ti ti-phone me-1"></i>${cliente.phone_number}</small>` : ''}
                                    </div>
                                    <div class="cliente-checkbox">
                                        <i class="ti ti-check"></i>
                                    </div>
                                </div>
                            </div>
                        `;
                    });
                } else {
                    html = '<div class="text-muted text-center py-3">Nenhum cliente encontrado com esse termo</div>';
                }
                
                $('#resultadosClientes').html(html);
                
            } else {
                $('#resultadosClientes').html('<div class="text-danger text-center py-3">Erro ao carregar clientes</div>');
                Swal.fire({
                    icon: 'error',
                    title: 'Erro ao buscar',
                    text: 'Erro ao carregar clientes: ' + (response.erro || 'Erro desconhecido'),
                    confirmButtonColor: '#dc3545'
                });
            }
        },
        error: function(xhr, status, error) {
            console.error('Erro ao buscar clientes:', xhr.responseJSON);
            
            let mensagemErro = 'Erro ao carregar clientes';
            if (xhr.responseJSON && xhr.responseJSON.erro) {
                mensagemErro = xhr.responseJSON.erro;
            } else if (xhr.status === 401) {
                mensagemErro = 'Usuário não autenticado';
            } else if (xhr.status === 404) {
                mensagemErro = 'Loja não encontrada';
            }
            
            $('#resultadosClientes').html(`<div class="text-danger text-center py-3">${mensagemErro}</div>`);
            Swal.fire({
                icon: 'error',
                title: 'Erro ao buscar',
                text: mensagemErro,
                confirmButtonColor: '#dc3545'
            });
        }
    });
}

function toggleCliente(id, nome, email) {
    const index = clientesSelecionados.findIndex(c => c.id === id);
    
    if (index > -1) {
        clientesSelecionados.splice(index, 1);
        $(`.cliente-item`).eq(index).removeClass('selected');
    } else {
        clientesSelecionados.push({ id, nome, email });
    }
    
    updateClientesSelecionados();
    updateContadorClientes();
    updateResumo();
}

function removeCliente(id) {
    const index = clientesSelecionados.findIndex(c => c.id === id);
    if (index > -1) {
        clientesSelecionados.splice(index, 1);
        updateClientesSelecionados();
        updateContadorClientes();
        updateResumo();
    }
}

function updateClientesSelecionados() {
    let html = '';
    if (clientesSelecionados.length > 0) {
        html = '<h6>Clientes Selecionados:</h6>';
        clientesSelecionados.forEach(cliente => {
            html += `<span class="cliente-selecionado">
                        ${cliente.nome}
                        <button class="btn-remove-cliente" onclick="removeCliente(${cliente.id})" title="Remover">
                            <i class="ti ti-x"></i>
                        </button>
                     </span>`;
        });
    }
    $('#clientesSelecionados').html(html);
}

function updateContadorClientes() {
    const selectValue = $('#selectClientes').val();
    
    if (selectValue === 'todos') {
        $('#contadorClientes').text('Todos os Clientes');
    } else {
        const total = clientesSelecionados.length;
        $('#contadorClientes').text(`${total} Cliente${total !== 1 ? 's' : ''}`);
    }
}

// Funções para Produtos
function initProdutos() {
    // Toggle para todos os produtos
    $('#todosProdutos').change(function() {
        const isChecked = $(this).is(':checked');
        const status = $('#statusTodosProdutos');
        
        if (isChecked) {
            status.text('SIM').removeClass('bg-danger').addClass('bg-success');
            $('#seletorProdutos').slideUp();
        } else {
            status.text('NÃO').removeClass('bg-success').addClass('bg-danger');
            $('#seletorProdutos').slideDown();
        }
        updateResumo();
    });
}

function abrirSeletorProdutos() {
    // Mostrar loading no botão
    const botaoSelecionar = $('button[onclick="abrirSeletorProdutos()"]');
    const textoOriginal = botaoSelecionar.html();
    botaoSelecionar.html('<i class="ti ti-loader-2 animate-spin me-1"></i> Carregando...');
    botaoSelecionar.prop('disabled', true);
    
    // Buscar produtos da loja através da API
    $.ajax({
        url: '{{ route("minha-loja-produtos") }}',
        method: 'GET',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            'Accept': 'application/json'
        },
        success: function(response) {
            // Restaurar botão
            botaoSelecionar.html(textoOriginal);
            botaoSelecionar.prop('disabled', false);
            
            if (response.sucesso && response.dados) {
                const produtos = response.dados.produtos;
                
                if (produtos && produtos.length > 0) {
                    // Abrir modal com produtos disponíveis
                    exibirModalSelecaoProdutos(produtos);
                                 } else {
                     Swal.fire({
                         icon: 'info',
                         title: 'Nenhum produto',
                         text: 'Nenhum produto encontrado na sua loja.',
                         confirmButtonColor: '#fb6c2b'
                     });
                 }
             } else {
                 Swal.fire({
                     icon: 'error',
                     title: 'Erro ao carregar',
                     text: 'Erro ao carregar produtos: ' + (response.erro || 'Erro desconhecido'),
                     confirmButtonColor: '#dc3545'
                 });
             }
        },
        error: function(xhr, status, error) {
            // Restaurar botão
            botaoSelecionar.html(textoOriginal);
            botaoSelecionar.prop('disabled', false);
            
            console.error('Erro ao buscar produtos:', xhr.responseJSON);
            
            let mensagemErro = 'Erro ao carregar produtos';
            if (xhr.responseJSON && xhr.responseJSON.erro) {
                mensagemErro = xhr.responseJSON.erro;
            } else if (xhr.status === 401) {
                mensagemErro = 'Usuário não autenticado';
            } else if (xhr.status === 404) {
                mensagemErro = 'Loja não encontrada';
            }
            
                         Swal.fire({
                             icon: 'error',
                             title: 'Erro ao carregar produtos',
                             text: mensagemErro,
                             confirmButtonColor: '#dc3545'
                         });
        }
    });
}

function exibirModalSelecaoProdutos(produtos) {
    let produtosHtml = '';
    
    produtos.forEach(function(item) {
        const produto = item.produto;
        const imagens = item.imagens;
        const jaSelecionado = produtosSelecionados.find(p => p.id === produto.id) ? 'selected' : '';
        
        // Usar primeira imagem se existir, senão placeholder
        let imagemUrl = 'https://via.placeholder.com/60x60?text=Sem+Imagem';
        if (imagens && imagens.length > 0) {
            // Construir URL da imagem (assumindo que está em storage/uploads)
            imagemUrl = '{{ asset("storage/uploads/") }}/' + imagens[0].product_images;
        }
        
        // Formatar preço se existir
        let precoExibicao = 'Sem preço';
        if (produto.price) {
            precoExibicao = 'R$ ' + parseFloat(produto.price).toFixed(2).replace('.', ',');
        }
        
        // Mostrar status do estoque
        let estoqueInfo = '';
        if (produto.quantity > 0) {
            estoqueInfo = `<span class="badge bg-success">Estoque: ${produto.quantity}</span>`;
        } else {
            estoqueInfo = '<span class="badge bg-warning">Sem estoque</span>';
        }
        
        produtosHtml += `
            <div class="produto-selecao-item ${jaSelecionado}" onclick="toggleProdutoSelecao(${produto.id}, '${produto.name}', '${produto.SKU || ''}', '${imagemUrl}')">
                <div class="d-flex align-items-center">
                    <img src="${imagemUrl}" alt="${produto.name}" class="produto-imagem-modal me-3" onerror="this.src='https://via.placeholder.com/60x60?text=Sem+Imagem'">
                    <div class="flex-grow-1">
                        <div class="produto-nome-modal">${produto.name}</div>
                        <div class="produto-detalhes">
                            ${produto.SKU ? `<small class="text-muted">SKU: ${produto.SKU}</small><br>` : ''}
                            <small class="text-primary">${precoExibicao}</small>
                            <div class="mt-1">${estoqueInfo}</div>
                        </div>
                    </div>
                    <div class="produto-checkbox">
                        <i class="ti ti-check"></i>
                    </div>
                </div>
            </div>
        `;
    });
    
    const modalHtml = `
        <div class="modal fade" id="modalSelecaoProdutos" tabindex="-1" aria-labelledby="modalSelecaoProdutosLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalSelecaoProdutosLabel">
                            <i class="ti ti-package text-primary me-2"></i>
                            Selecionar Produtos
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <div class="input-group">
                                <span class="input-group-text"><i class="ti ti-search"></i></span>
                                <input type="text" class="form-control" id="buscarProdutoModal" placeholder="Buscar produto por nome ou SKU">
                            </div>
                        </div>
                        <div class="produtos-lista-modal" style="max-height: 400px; overflow-y: auto;">
                            ${produtosHtml}
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-primary" onclick="confirmarSelecaoProdutos()">
                            Confirmar Seleção
                        </button>
                    </div>
                </div>
            </div>
        </div>
    `;
    
    // Remover modal anterior se existir
    $('#modalSelecaoProdutos').remove();
    
    // Adicionar modal ao DOM
    $('body').append(modalHtml);
    
    // Mostrar modal
    $('#modalSelecaoProdutos').modal('show');
    
    // Configurar busca em tempo real
    $('#buscarProdutoModal').on('input', function() {
        const termo = $(this).val().toLowerCase();
        $('.produto-selecao-item').each(function() {
            const texto = $(this).text().toLowerCase();
            if (texto.includes(termo)) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    });
}

function toggleProdutoSelecao(id, nome, sku, imagem) {
    const index = produtosSelecionados.findIndex(p => p.id === id);
    const elemento = $(`.produto-selecao-item[onclick*="${id}"]`);
    
    if (index > -1) {
        // Remover seleção
        produtosSelecionados.splice(index, 1);
        elemento.removeClass('selected');
    } else {
        // Adicionar seleção
        produtosSelecionados.push({
            id: id,
            nome: nome,
            codigo: sku,
            imagem: imagem
        });
        elemento.addClass('selected');
    }
    
    // Atualizar contador no botão de confirmação
    const botaoConfirmar = $('.modal-footer button.btn-primary');
    const total = produtosSelecionados.length;
    if (total > 0) {
        botaoConfirmar.text(`Confirmar Seleção (${total})`);
    } else {
        botaoConfirmar.text('Confirmar Seleção');
    }
}

function confirmarSelecaoProdutos() {
    // Fechar modal
    $('#modalSelecaoProdutos').modal('hide');
    
    // Atualizar lista de produtos selecionados
    updateListaProdutos();
    updateResumo();
    
         if (produtosSelecionados.length > 0) {
        Swal.fire({
            icon: 'success',
            title: 'Produtos selecionados!',
            text: `${produtosSelecionados.length} produto(s) selecionado(s) com sucesso!`,
            confirmButtonColor: '#28a745',
            timer: 2000,
            timerProgressBar: true
        });
    }
}

function updateListaProdutos() {
    let html = '';
    
    if (produtosSelecionados.length === 0) {
        html = '<div class="text-muted text-center py-3">Nenhum produto selecionado</div>';
    } else {
        produtosSelecionados.forEach(produto => {
            html += `
                <div class="produto-item">
                    <img src="${produto.imagem}" alt="${produto.nome}" class="produto-imagem" onerror="this.src='https://via.placeholder.com/40x40?text=Sem+Imagem'">
                    <div class="produto-info">
                        <div class="produto-nome">${produto.nome}</div>
                        <div class="produto-codigo">${produto.codigo ? 'SKU: ' + produto.codigo : 'Sem SKU'}</div>
                    </div>
                    <button type="button" class="btn-remove-produto" onclick="removerProduto(${produto.id})" title="Remover produto">
                        <i class="ti ti-trash"></i>
                    </button>
                </div>
            `;
        });
    }
    
    $('#listaProdutosSelecionados').html(html);
}

function removerProduto(produtoId) {
    produtosSelecionados = produtosSelecionados.filter(p => p.id !== produtoId);
    updateListaProdutos();
    updateResumo();
}

// Funções para Configurações Avançadas
function initConfiguracoes() {
    // Toggle para permitir outras promoções
    $('#permitirOutrasPromocoes').change(function() {
        const isChecked = $(this).is(':checked');
        const status = $('#statusOutrasPromocoes');
        
        if (isChecked) {
            status.text('SIM').removeClass('bg-danger').addClass('bg-success');
        } else {
            status.text('NÃO').removeClass('bg-success').addClass('bg-danger');
        }
        updateResumo();
    });
}

function salvarDesconto() {
    // Coletar dados do formulário
    const tipoDesconto = $('input[name="tipoDesconto"]:checked').val();
    console.log('Tipo de desconto selecionado para envio:', tipoDesconto);
    
    let valorDesconto = 0;
    if (tipoDesconto === 'porcentagem') {
        valorDesconto = $('#porcentagemDesconto').val() || 0;
    } else if (tipoDesconto === 'valor_fixo') {
        valorDesconto = $('#valorFixoDesconto').val() || 0;
    }
    
    const dados = {
        ativo: $('#ativarDescontoMassa').is(':checked'),
        descricao: $('#descricaoDesconto').val(),
        tipoDesconto: tipoDesconto,
        valorDesconto: valorDesconto, // Enviar um único campo para o backend
        valorMinimoProduto: $('#valorMinimoProduto').val() || 0,
        limitarData: $('#limitarData').is(':checked'),
        dataInicio: $('#dataInicio').val() || null,
        dataFim: $('#dataFim').val() || null,
        estadosSelecionados: estadosSelecionados,
        tipoClientes: $('#selectClientes').val(),
        clientesSelecionados: clientesSelecionados,
        todosProdutos: $('#todosProdutos').is(':checked'),
        tipoAplicacao: $('#tipoAplicacao').val(),
        produtosSelecionados: produtosSelecionados,
        permitirOutrasPromocoes: $('#permitirOutrasPromocoes').is(':checked')
    };

    // Debug para verificar valores
    console.log('Dados a serem enviados:', dados);
    console.log('Tipo de desconto:', tipoDesconto);
    console.log('Valor do desconto:', valorDesconto);

    // Validação específica para descrição
    if (!dados.descricao) {
        Swal.fire({
            icon: 'warning',
            title: 'Descrição obrigatória',
            text: 'Por favor, preencha o campo de descrição.',
            confirmButtonColor: '#fb6c2b'
        });
        $('#descricaoDesconto').focus();
        return;
    }

    // Validação para valor do desconto
    if (!valorDesconto || valorDesconto <= 0) {
        Swal.fire({
            icon: 'warning',
            title: 'Valor de desconto obrigatório',
            text: 'Por favor, informe um valor válido para o desconto.',
            confirmButtonColor: '#fb6c2b'
        });
        if (tipoDesconto === 'porcentagem') {
            $('#porcentagemDesconto').focus();
        } else {
            $('#valorFixoDesconto').focus();
        }
        return;
    }

    // Validação para produtos
    if (!dados.todosProdutos && (!dados.produtosSelecionados || dados.produtosSelecionados.length === 0)) {
        Swal.fire({
            icon: 'warning',
            title: 'Produtos obrigatórios',
            text: 'Por favor, selecione pelo menos um produto ou marque "Aplicar para todos os produtos".',
            confirmButtonColor: '#fb6c2b'
        });
        return;
    }

    // Desabilitar botão durante o envio
    const botaoSalvar = $('button[onclick="salvarDesconto()"]');
    const textoOriginalBotao = botaoSalvar.html();
    botaoSalvar.html('<i class="ti ti-loader-2 animate-spin me-1"></i> Salvando...');
    botaoSalvar.prop('disabled', true);

    // Mostrar mensagem de carregamento
    Swal.fire({
        title: 'Salvando...',
        text: 'Salvando desconto em massa, aguarde...',
        icon: 'info',
        allowOutsideClick: false,
        showConfirmButton: false,
        willOpen: () => {
            Swal.showLoading();
        }
    });

    // Enviar dados via AJAX
    $.ajax({
        url: '/desconto-progressivo/desconto-em-massa/salvar',
        method: 'POST',
        data: JSON.stringify(dados),
        contentType: 'application/json',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            'Accept': 'application/json'
        },
        success: function(response) {
            botaoSalvar.html(textoOriginalBotao);
            botaoSalvar.prop('disabled', false);
            console.log('Resposta do servidor:', response);
            
            if (response.sucesso) {
                Swal.fire({
                    icon: 'success',
                    title: 'Sucesso!',
                    text: response.mensagem || 'Desconto em Massa salvo com sucesso!',
                    confirmButtonColor: '#28a745',
                    timer: 3000,
                    timerProgressBar: true,
                    willClose: () => {
                        window.location.href = '{{ route("desconto-progressivo.index") }}';
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = '{{ route("desconto-progressivo.index") }}';
                    }
                });
            } else {
                let mensagemErro = response.erro || 'Erro ao salvar desconto em massa';
                if (response.detalhes) {
                    console.error('Erros de validação:', response.detalhes);
                    const primeiroErro = Object.values(response.detalhes)[0];
                    if (Array.isArray(primeiroErro) && primeiroErro.length > 0) {
                        mensagemErro = primeiroErro[0];
                    }
                }
                Swal.fire({
                    icon: 'error',
                    title: 'Erro!',
                    text: mensagemErro,
                    confirmButtonColor: '#dc3545'
                });
            }
        },
        error: function(xhr, status, error) {
            botaoSalvar.html(textoOriginalBotao);
            botaoSalvar.prop('disabled', false);
            console.error('Erro na requisição AJAX:', xhr.responseJSON);
            
            let mensagemErro = 'Erro ao salvar desconto em massa';
            let tituloErro = 'Erro na Requisição';
            
            if (xhr.responseJSON) {
                if (xhr.responseJSON.erro) {
                    mensagemErro = xhr.responseJSON.erro;
                } else if (xhr.responseJSON.message) {
                    mensagemErro = xhr.responseJSON.message;
                }
                
                if (xhr.status === 422 && xhr.responseJSON.detalhes) {
                    console.error('Erros de validação:', xhr.responseJSON.detalhes);
                    tituloErro = 'Erro de Validação';
                    const primeiroErro = Object.values(xhr.responseJSON.detalhes)[0];
                    if (Array.isArray(primeiroErro) && primeiroErro.length > 0) {
                        mensagemErro = primeiroErro[0];
                    }
                }
            } else if (xhr.status === 401) {
                tituloErro = 'Não Autenticado';
                mensagemErro = 'Usuário não autenticado. Faça login novamente.';
            } else if (xhr.status === 403) {
                tituloErro = 'Sem Permissão';
                mensagemErro = 'Você não tem permissão para realizar esta ação.';
            } else if (xhr.status === 404) {
                tituloErro = 'Não Encontrado';
                mensagemErro = 'Rota não encontrada. Verifique a configuração.';
            } else if (xhr.status === 500) {
                tituloErro = 'Erro do Servidor';
                mensagemErro = 'Erro interno do servidor. Tente novamente em alguns instantes.';
            }
            
            Swal.fire({
                icon: 'error',
                title: tituloErro,
                text: mensagemErro,
                confirmButtonColor: '#dc3545',
                footer: xhr.status ? `<small>Código do erro: ${xhr.status}</small>` : ''
            });
        }
    });
}
</script>
@endpush 