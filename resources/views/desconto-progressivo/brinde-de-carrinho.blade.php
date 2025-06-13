@extends('layouts.admin')

@section('page-title')
Brinde no Carrinho
@endsection

@push('head')
<meta name="csrf-token" content="{{ csrf_token() }}">
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('desconto-progressivo.index') }}">Desconto Progressivo</a></li>
    <li class="breadcrumb-item active" aria-current="page">Brinde no Carrinho</li>
@endsection

@section('action-btn')
    <div class="col-auto">
        <a href="{{ route('desconto-progressivo.index') }}" class="btn btn-sm btn-secondary me-2">
            <i class="ti ti-arrow-left"></i> Voltar
        </a>
        <button type="button" class="btn btn-sm btn-primary" onclick="salvarBrindeCarrinho()">
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
    
    /* Estilos para seleção de brindes */
    .produto-selecao-item {
        padding: 15px;
        border-bottom: 1px solid rgba(0,0,0,0.05);
        cursor: pointer;
        position: relative;
        transition: all 0.2s ease;
    }
    
    .produto-selecao-item:hover {
        background-color: rgba(0,0,0,0.02);
    }
    
    .produto-selecao-item.selected {
        background-color: rgba(251, 108, 43, 0.05);
        border-left: 3px solid #fb6c2b;
    }
    
    .produto-selecao-item .produto-checkbox {
        display: none;
        color: #fb6c2b;
        font-size: 1.2rem;
    }
    
    .produto-selecao-item.selected .produto-checkbox {
        display: block;
    }
    
    .produto-imagem-modal {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border-radius: 4px;
    }
    
    .produto-nome-modal {
        font-weight: 500;
        margin-bottom: 3px;
    }
    
    .produto-detalhes {
        font-size: 12px;
    }
    
    .produto-checkbox {
        position: absolute;
        top: 15px;
        right: 15px;
    }
    
    /* Estilos para lista de brindes selecionados */
    .list-group-item {
        transition: all 0.2s ease;
    }
    
    .list-group-item:hover {
        background-color: rgba(0,0,0,0.01);
    }
</style>

<div class="container-fluid mt-5">
    <div class="row">
        <!-- Sidebar com informações -->
        <div class="col-lg-4">
            <div class="card h-100">
                <div class="card-header border-0 pb-0">
                    <h6 class="card-title mb-0">
                        <i class="ti ti-gift text-primary me-2"></i>
                        Informações do Brinde no Carrinho
                    </h6>
                </div>
                <div class="card-body">
                    <p class="text-muted mb-3">Cadastre as informações e configurações para a promoção.</p>
                    
                    <div class="alert alert-primary border-0" role="alert">
                        <i class="ti ti-gift me-2 text-secondary"></i>
                        <strong style="color: #fb6c2b;">Resumo:</strong>
                        <div class="mt-2" id="resumoBrinde">
                            <p class="text-muted mb-0">Cadastre as informações e configurações para a promoção.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Área principal de configuração -->
        <div class="col-lg-8">
            
            <!-- Card: Informações do Brinde no Carrinho -->
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="card-title mb-0">
                        <i class="ti ti-gift text-primary me-2"></i>
                        Informações do Brinde no Carrinho
                    </h6>
                </div>
                <div class="card-body">
                    <!-- Switch de ativação -->
                    <div class="d-flex align-items-center mb-4">
                        <label class="custom-toggle me-2 mb-0">
                            <input type="checkbox" id="ativarBrindeCarrinho" checked>
                            <span class="toggle-slider"></span>
                        </label>
                        <span class="toggle-status bg-success me-2">SIM</span>
                        <span class="fw-semibold" style="color: #495057;">Ativar promoção</span>
                    </div>

                    <!-- Descrição -->
                    <div class="form-group mb-4">
                        <label for="descricaoBrinde" class="form-label fw-semibold">Descrição</label>
                        <input type="text" class="form-control" id="descricaoBrinde" placeholder="Ex: Promoção de fim de ano">
                    </div>

                    <!-- Valor Mínimo -->
                    <div class="form-group mb-3">
                        <label for="valorMinimoCompra" class="form-label fw-semibold">Valor Mínimo</label>
                        <div class="input-group">
                            <span class="input-group-text">R$</span>
                            <input type="text" class="form-control" id="valorMinimoCompra" placeholder="00,00">
                        </div>
                        <small class="form-text text-muted mt-2">Liberar brinde(s) quando o pedido atingir esse valor</small>
                    </div>
                </div>
            </div>

            <!-- Card: Configurações do Brinde -->
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="card-title mb-0">
                        <i class="ti ti-settings text-primary me-2"></i>
                        Configurações do Brinde
                    </h6>
                </div>
                <div class="card-body">
                    <!-- Limitar por Data -->
                    <div class="toggle-section">
                        <label class="custom-toggle">
                            <input type="checkbox" id="limitarData">
                            <span class="toggle-slider"></span>
                        </label>
                        <span class="toggle-status bg-danger" id="statusLimitarData">NÃO</span>
                        <span class="toggle-label">Limitar por data</span>
                    </div>

                    <div class="row mb-3" id="camposData">
                        <div class="col-md-6">
                            <label for="dataInicio" class="form-label">Data de início</label>
                            <div class="date-input">
                                <input type="date" class="form-control" id="dataInicio" disabled>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="dataFim" class="form-label">Data de fim</label>
                            <div class="date-input">
                                <input type="date" class="form-control" id="dataFim" disabled>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card: Seleção de Brindes -->
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="card-title mb-0">
                        <i class="ti ti-gift text-primary me-2"></i>
                        Brindes
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-4">
                        <button type="button" class="btn btn-outline-primary" onclick="abrirSeletorBrindes()">
                            <i class="ti ti-plus me-1"></i> Selecionar Brindes
                        </button>
    
                    </div>

                    <div class="card shadow-none border">
                        <div class="card-header bg-light">
                            <h6 class="mb-0 text-primary">Oferecer os brindes (<span id="contadorBrindes">0</span>)</h6>
                        </div>
                        <div class="card-body p-0">
                            <div id="listaBrindesSelecionados" class="list-group list-group-flush">
                                <!-- Lista de brindes selecionados será carregada aqui -->
                                <div class="text-muted text-center py-3">Nenhum brinde selecionado</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal de Seleção de Brindes -->
            <div class="modal fade" id="modalSelecaoBrindes" tabindex="-1" aria-labelledby="modalSelecaoBrindesLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalSelecaoBrindesLabel">
                                <i class="ti ti-gift text-primary me-2"></i>
                                Selecionar Brindes
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="ti ti-search"></i></span>
                                    <input type="text" class="form-control" id="buscarBrindeModal" placeholder="Buscar produto por nome ou SKU">
                                </div>
                            </div>
                            <div class="produtos-lista-modal" style="max-height: 400px; overflow-y: auto;" id="listaProdutosModal">
                                <!-- Produtos serão carregados aqui -->
                                <div class="text-center py-3">
                                    <div class="spinner-border text-primary" role="status">
                                        <span class="visually-hidden">Carregando...</span>
                                    </div>
                                    <p class="mt-2">Carregando produtos...</p>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="button" class="btn btn-primary" onclick="confirmarSelecaoBrindes()">
                                Confirmar Seleção
                            </button>
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
$(document).ready(function() {
    // Inicializar componentes e eventos
    
    // Toggle para ativar/desativar brinde
    $('#ativarBrindeCarrinho').change(function() {
        const isChecked = $(this).is(':checked');
        const status = $(this).siblings('.toggle-status');
        
        if (isChecked) {
            status.text('SIM').removeClass('bg-danger').addClass('bg-success');
        } else {
            status.text('NÃO').removeClass('bg-success').addClass('bg-danger');
        }
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
    });
    
    // Toggle para permitir outras promoções
    $('#permitirOutrasPromocoes').change(function() {
        const isChecked = $(this).is(':checked');
        const status = $(this).siblings('.toggle-status');
        
        if (isChecked) {
            status.text('SIM').removeClass('bg-danger').addClass('bg-success');
        } else {
            status.text('NÃO').removeClass('bg-success').addClass('bg-danger');
        }
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
    });
    
    // Inicializar estados brasileiros
    carregarEstadosBrasileiros();

    // Configurar busca em tempo real no modal de brindes
    $('#buscarBrindeModal').on('input', function() {
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
    
    // Inicializar a seção de clientes específicos
    $('#clientesEspecificosSection').hide();
    
    // Configurar eventos para o campo de busca de clientes
    $('#buscarCliente').keypress(function(e) {
        // Buscar ao pressionar Enter
        if (e.which === 13) {
            e.preventDefault();
            buscarClientes();
        }
    });
});

// Função para carregar estados brasileiros
function carregarEstadosBrasileiros() {
    const estados = [
        'Acre', 'Alagoas', 'Amapá', 'Amazonas', 'Bahia', 'Ceará', 'Distrito Federal',
        'Espírito Santo', 'Goiás', 'Maranhão', 'Mato Grosso', 'Mato Grosso do Sul',
        'Minas Gerais', 'Pará', 'Paraíba', 'Paraná', 'Pernambuco', 'Piauí',
        'Rio de Janeiro', 'Rio Grande do Norte', 'Rio Grande do Sul', 'Rondônia',
        'Roraima', 'Santa Catarina', 'São Paulo', 'Sergipe', 'Tocantins'
    ];
    
    let html = '';
    estados.forEach(estado => {
        html += `
            <div class="col-md-4 col-sm-6 padding-estado">
                <div class="estado-tag" data-estado="${estado}" onclick="toggleEstado(this)">
                    ${estado}
                </div>
            </div>
        `;
    });
    
    $('#listaEstados').html(html);
    atualizarContadorEstados();
}

// Variáveis globais para armazenar seleções
let estadosSelecionados = [];
let brindesSelecionados = [];

// Função para alternar seleção de estado
function toggleEstado(elemento) {
    const estado = $(elemento).data('estado');
    const index = estadosSelecionados.indexOf(estado);
    
    if (index !== -1) {
        // Remover seleção
        estadosSelecionados.splice(index, 1);
        $(elemento).removeClass('selected');
    } else {
        // Adicionar seleção
        estadosSelecionados.push(estado);
        $(elemento).addClass('selected');
    }
    
    atualizarContadorEstados();
}

// Função para atualizar contador de estados
function atualizarContadorEstados() {
    const contador = estadosSelecionados.length;
    $('#contadorEstados').text(contador + ' Estado' + (contador !== 1 ? 's' : ''));
}

// Função para abrir o seletor de brindes
function abrirSeletorBrindes() {
    // Mostrar loading no botão
    const botaoSelecionar = $('button[onclick="abrirSeletorBrindes()"]');
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
                    // Preencher o modal com produtos disponíveis
                    exibirProdutosNoModal(produtos);
                    // Abrir o modal
                    $('#modalSelecaoBrindes').modal('show');
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

// Função para exibir produtos no modal
function exibirProdutosNoModal(produtos) {
    let produtosHtml = '';
    
    produtos.forEach(function(item) {
        const produto = item.produto;
        const imagens = item.imagens;
        const jaSelecionado = brindesSelecionados.find(p => p.id === produto.id) ? 'selected' : '';
        
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
            <div class="produto-selecao-item ${jaSelecionado}" onclick="toggleBrindeSelecionado(${produto.id}, '${produto.name}', '${produto.SKU || ''}', '${imagemUrl}')">
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
    
    $('#listaProdutosModal').html(produtosHtml);
}

// Função para alternar seleção de brinde
function toggleBrindeSelecionado(id, nome, sku, imagem) {
    const index = brindesSelecionados.findIndex(p => p.id === id);
    const elemento = $(`.produto-selecao-item[onclick*="${id}"]`);
    
    if (index !== -1) {
        // Remover seleção
        brindesSelecionados.splice(index, 1);
        elemento.removeClass('selected');
    } else {
        // Adicionar seleção
        brindesSelecionados.push({
            id: id,
            nome: nome,
            codigo: sku,
            imagem: imagem
        });
        elemento.addClass('selected');
    }
    
    // Atualizar contador no botão de confirmação
    const botaoConfirmar = $('.modal-footer button.btn-primary');
    const total = brindesSelecionados.length;
    if (total > 0) {
        botaoConfirmar.text(`Confirmar Seleção (${total})`);
    } else {
        botaoConfirmar.text('Confirmar Seleção');
    }
}

// Função para confirmar seleção de brindes
function confirmarSelecaoBrindes() {
    // Fechar modal
    $('#modalSelecaoBrindes').modal('hide');
    
    // Atualizar lista de brindes selecionados
    atualizarListaBrindes();
    
    if (brindesSelecionados.length > 0) {
        Swal.fire({
            icon: 'success',
            title: 'Brindes selecionados!',
            text: `${brindesSelecionados.length} brinde(s) selecionado(s) com sucesso!`,
            confirmButtonColor: '#28a745',
            timer: 2000,
            timerProgressBar: true
        });
    }
}

// Função para atualizar a lista de brindes selecionados
function atualizarListaBrindes() {
    let html = '';
    
    if (brindesSelecionados.length === 0) {
        html = '<div class="text-muted text-center py-3">Nenhum brinde selecionado</div>';
    } else {
        brindesSelecionados.forEach(brinde => {
            html += `
                <div class="list-group-item p-3">
                    <div class="d-flex align-items-center">
                        <img src="${brinde.imagem}" alt="${brinde.nome}" class="me-3" style="width: 50px; height: 50px; object-fit: cover;" onerror="this.src='https://via.placeholder.com/50x50?text=Sem+Imagem'">
                        <div class="flex-grow-1">
                            <h6 class="mb-0">${brinde.nome}</h6>
                            ${brinde.codigo ? `<small class="text-muted">SKU: ${brinde.codigo}</small>` : ''}
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-danger" onclick="removerBrinde(${brinde.id})">
                            <i class="ti ti-trash"></i>
                        </button>
                    </div>
                </div>
            `;
        });
    }
    
    $('#listaBrindesSelecionados').html(html);
    $('#contadorBrindes').text(brindesSelecionados.length);
}

// Função para remover um brinde da lista
function removerBrinde(brindeId) {
    brindesSelecionados = brindesSelecionados.filter(b => b.id !== brindeId);
    atualizarListaBrindes();
}

// Função para lidar com a seleção de clientes
function handleClienteSelection() {
    const tipoCliente = $('#selectClientes').val();
    
    if (tipoCliente === 'especificos') {
        $('#clientesEspecificosSection').show();
    } else {
        $('#clientesEspecificosSection').hide();
        // Limpar seleções quando voltar para "todos"
        clientesSelecionados = [];
        atualizarListaClientesSelecionados();
    }
}

// Variável global para armazenar clientes selecionados
let clientesSelecionados = [];

// Função para buscar clientes
function buscarClientes() {
    const termoBusca = $('#buscarCliente').val().trim();
    
    if (termoBusca.length < 3) {
        Swal.fire({
            icon: 'warning',
            title: 'Termo muito curto',
            text: 'Digite pelo menos 3 caracteres para buscar',
            confirmButtonColor: '#fb6c2b'
        });
        return;
    }
    
    // Mostrar loading
    $('#resultadosClientes').html('<div class="text-center py-3"><i class="ti ti-loader-2 animate-spin me-1"></i> Buscando clientes...</div>');
    
    // Buscar clientes da loja através da API
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
                
                if (clientes && clientes.length > 0) {
                    // Filtrar clientes pelo termo de busca
                    const clientesFiltrados = clientes.filter(cliente => 
                        cliente.name.toLowerCase().includes(termoBusca.toLowerCase()) || 
                        cliente.email.toLowerCase().includes(termoBusca.toLowerCase())
                    );
                    
                    if (clientesFiltrados.length > 0) {
                        exibirResultadosClientes(clientesFiltrados);
                    } else {
                        $('#resultadosClientes').html('<div class="alert alert-info">Nenhum cliente encontrado com este termo.</div>');
                    }
                } else {
                    $('#resultadosClientes').html('<div class="alert alert-info">Nenhum cliente cadastrado na loja.</div>');
                }
            } else {
                $('#resultadosClientes').html('<div class="alert alert-danger">Erro ao buscar clientes: ' + (response.erro || 'Erro desconhecido') + '</div>');
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
            
            $('#resultadosClientes').html('<div class="alert alert-danger">' + mensagemErro + '</div>');
        }
    });
}

// Função para exibir resultados da busca de clientes
function exibirResultadosClientes(clientes) {
    let html = '<div class="list-group">';
    
    clientes.forEach(cliente => {
        // Verificar se o cliente já está selecionado
        const jaSelecionado = clientesSelecionados.some(c => c.id === cliente.id);
        if (!jaSelecionado) {
            html += `
                <div class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-1">${cliente.name}</h6>
                        <small>${cliente.email}</small>
                    </div>
                    <button type="button" class="btn btn-sm btn-primary" onclick="adicionarCliente(${cliente.id}, '${cliente.name}', '${cliente.email}')">
                        <i class="ti ti-plus"></i> Adicionar
                    </button>
                </div>
            `;
        }
    });
    
    html += '</div>';
    $('#resultadosClientes').html(html);
}

// Função para adicionar um cliente à lista de selecionados
function adicionarCliente(id, nome, email) {
    // Verificar se já está selecionado
    if (!clientesSelecionados.some(c => c.id === id)) {
        clientesSelecionados.push({
            id: id,
            nome: nome,
            email: email
        });
        
        // Limpar resultados da busca
        $('#resultadosClientes').html('');
        $('#buscarCliente').val('');
        
        // Atualizar lista de clientes selecionados
        atualizarListaClientesSelecionados();
    }
}

// Função para atualizar a lista de clientes selecionados
function atualizarListaClientesSelecionados() {
    let html = '';
    
    if (clientesSelecionados.length === 0) {
        html = '<div class="alert alert-info">Nenhum cliente selecionado</div>';
        $('#contadorClientes').text('Nenhum cliente');
    } else {
        html = '<div class="list-group">';
        
        clientesSelecionados.forEach(cliente => {
            html += `
                <div class="list-group-item d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-1">${cliente.nome}</h6>
                        <small>${cliente.email}</small>
                    </div>
                    <button type="button" class="btn btn-sm btn-outline-danger" onclick="removerCliente(${cliente.id})">
                        <i class="ti ti-trash"></i>
                    </button>
                </div>
            `;
        });
        
        html += '</div>';
        $('#contadorClientes').text(clientesSelecionados.length + ' Cliente' + (clientesSelecionados.length !== 1 ? 's' : ''));
    }
    
    $('#clientesSelecionados').html(html);
}

// Função para remover um cliente da lista
function removerCliente(clienteId) {
    clientesSelecionados = clientesSelecionados.filter(c => c.id !== clienteId);
    atualizarListaClientesSelecionados();
}

// Modificar a função salvarBrindeCarrinho para incluir os clientes selecionados
function salvarBrindeCarrinho() {
    // Coletar dados do formulário
    const dados = {
        ativo: $('#ativarBrindeCarrinho').is(':checked'),
        descricao: $('#descricaoBrinde').val(),
        valorMinimoCompra: $('#valorMinimoCompra').val() || 0,
        limitarData: $('#limitarData').is(':checked'),
        dataInicio: $('#dataInicio').val() || null,
        dataFim: $('#dataFim').val() || null,
        estadosSelecionados: estadosSelecionados,
        brindesSelecionados: brindesSelecionados,
        tipoClientes: $('#selectClientes').val(),
        clientesSelecionados: clientesSelecionados,
        permitirOutrasPromocoes: $('#permitirOutrasPromocoes').is(':checked')
    };

    // Validação específica para descrição
    if (!dados.descricao) {
        Swal.fire({
            icon: 'warning',
            title: 'Descrição obrigatória',
            text: 'Por favor, preencha o campo de descrição.',
            confirmButtonColor: '#fb6c2b'
        });
        $('#descricaoBrinde').focus();
        return;
    }

    // Validação para valor mínimo de compra
    if (!dados.valorMinimoCompra || dados.valorMinimoCompra <= 0) {
        Swal.fire({
            icon: 'warning',
            title: 'Valor mínimo obrigatório',
            text: 'Por favor, informe um valor mínimo de compra válido.',
            confirmButtonColor: '#fb6c2b'
        });
        $('#valorMinimoCompra').focus();
        return;
    }

    // Validação para brindes
    if (!dados.brindesSelecionados || dados.brindesSelecionados.length === 0) {
        Swal.fire({
            icon: 'warning',
            title: 'Brindes obrigatórios',
            text: 'Por favor, selecione pelo menos um brinde para oferecer.',
            confirmButtonColor: '#fb6c2b'
        });
        return;
    }

    // Desabilitar botão durante o envio
    const botaoSalvar = $('button[onclick="salvarBrindeCarrinho()"]');
    const textoOriginalBotao = botaoSalvar.html();
    botaoSalvar.html('<i class="ti ti-loader-2 animate-spin me-1"></i> Salvando...');
    botaoSalvar.prop('disabled', true);

    // Mostrar mensagem de carregamento
    Swal.fire({
        title: 'Salvando...',
        text: 'Salvando brinde no carrinho, aguarde...',
        icon: 'info',
        allowOutsideClick: false,
        showConfirmButton: false,
        willOpen: () => {
            Swal.showLoading();
        }
    });

    // Enviar dados via AJAX
    $.ajax({
        url: '/desconto-progressivo/brinde-de-carrinho/salvar',
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
            
            if (response.sucesso) {
                Swal.fire({
                    icon: 'success',
                    title: 'Sucesso!',
                    text: response.mensagem || 'Brinde no carrinho salvo com sucesso!',
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
                let mensagemErro = response.erro || 'Erro ao salvar brinde no carrinho';
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
            
            let mensagemErro = 'Erro ao salvar brinde no carrinho';
            let tituloErro = 'Erro na Requisição';
            
            if (xhr.responseJSON) {
                if (xhr.responseJSON.erro) {
                    mensagemErro = xhr.responseJSON.erro;
                } else if (xhr.responseJSON.message) {
                    mensagemErro = xhr.responseJSON.message;
                }
                
                if (xhr.status === 422 && xhr.responseJSON.detalhes) {
                    tituloErro = 'Erro de Validação';
                    const primeiroErro = Object.values(xhr.responseJSON.detalhes)[0];
                    if (Array.isArray(primeiroErro) && primeiroErro.length > 0) {
                        mensagemErro = primeiroErro[0];
                    }
                }
            }
            
            Swal.fire({
                icon: 'error',
                title: tituloErro,
                text: mensagemErro,
                confirmButtonColor: '#dc3545'
            });
        }
    });
}
</script>
@endpush 