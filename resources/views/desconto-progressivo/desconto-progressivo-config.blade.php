@extends('layouts.admin')

@section('page-title')
    Novo Desconto Progressivo
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('desconto-progressivo.index') }}">Promoções e Descontos</a></li>
    <li class="breadcrumb-item active" aria-current="page">Novo Desconto Progressivo</li>
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

@push('css-page')
<style>
    .info-card {
        background: #f8f9fa;
        border: 1px solid #e9ecef;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 20px;
    }
    
    .info-card h6 {
        color: #6c757d;
        font-weight: 600;
        margin-bottom: 8px;
    }
    
    .info-card p {
        color: #6c757d;
        font-size: 14px;
        margin-bottom: 0;
        line-height: 1.5;
    }
    
    .config-section {
        background: white;
        border: 1px solid #e9ecef;
        border-radius: 12px;
        padding: 25px;
        margin-bottom: 20px;
    }
    
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
    
    input:checked + .toggle-slider {
        background-color: #28a745;
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
        background: #28a745;
        color: white;
        padding: 2px 8px;
        border-radius: 12px;
        font-size: 12px;
        font-weight: 600;
        margin-left: 8px;
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
        border: 1px solid #d1d5db;
        border-radius: 8px;
        padding: 10px 14px;
        font-size: 14px;
    }
    
    .form-control:focus {
        border-color: #8B5CF6;
        box-shadow: 0 0 0 0.2rem rgba(139, 92, 246, 0.25);
    }
    
    .input-group-text {
        background: #f8f9fa;
        border: 1px solid #d1d5db;
        color: #6c757d;
        font-weight: 500;
    }
    
    .date-section {
        border: 2px solid #dc3545;
        border-radius: 12px;
        padding: 20px;
        background: #fff5f5;
    }
    
    .date-row {
        display: flex;
        gap: 20px;
        margin-top: 15px;
    }
    
    .date-field {
        flex: 1;
    }
    
    .date-input {
        position: relative;
    }
    
    .date-input .form-control {
        background: #f8f9fa;
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
        color: #8B5CF6;
        pointer-events: none;
    }
    
    .resumo-icon {
        color: #8B5CF6;
        margin-right: 8px;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar com informações -->
        <div class="col-lg-4">
            <div class="info-card">
                <h6><i class="ti ti-info-circle resumo-icon"></i>Informações do Desconto Progressivo</h6>
                <p>Cadastre as informações e configurações do Desconto Progressivo</p>
                
                <div class="mt-3">
                    <small class="text-muted"><i class="ti ti-diamond resumo-icon"></i><strong>Resumo:</strong></small>
                </div>
            </div>
        </div>
        
        <!-- Área principal de configuração -->
        <div class="col-lg-8">
            <div class="config-section">
                <!-- Toggle Ativar Desconto -->
                <div class="toggle-section">
                    <label class="custom-toggle">
                        <input type="checkbox" id="ativarDesconto" checked>
                        <span class="toggle-slider"></span>
                    </label>
                    <span class="toggle-status">SIM</span>
                    <span class="toggle-label">Ativar Desconto Progressivo</span>
                </div>
                
                <!-- Título da Promoção -->
                <div class="form-group">
                    <label for="tituloPromocao" class="form-label">Título da Promoção</label>
                    <input type="text" class="form-control" id="tituloPromocao" placeholder="Ex: Promoção de fim de ano">
                </div>
                
                <!-- Valor mínimo do produto -->
                <div class="form-group">
                    <label for="valorMinimo" class="form-label">
                        Valor mínimo do produto 
                        <i class="ti ti-info-circle text-muted ms-1" data-bs-toggle="tooltip" 
                           title="Valor mínimo que o produto deve ter para participar da promoção"></i>
                    </label>
                    <div class="input-group">
                        <span class="input-group-text">R$</span>
                        <input type="number" class="form-control" id="valorMinimo" placeholder="00,00" step="0.01" min="0">
                    </div>
                </div>
            </div>
            
            <!-- Seção de Data (destacada) -->
            <div class="date-section">
                <div class="toggle-section">
                    <label class="custom-toggle">
                        <input type="checkbox" id="limitarData" checked>
                        <span class="toggle-slider"></span>
                    </label>
                    <span class="toggle-status">SIM</span>
                    <span class="toggle-label">Limitar uso por data</span>
                    <i class="ti ti-info-circle text-muted ms-1" data-bs-toggle="tooltip" 
                       title="Defina um período específico para a promoção"></i>
                </div>
                
                <div class="date-row">
                    <div class="date-field">
                        <label for="dataInicio" class="form-label">Data de início</label>
                        <div class="date-input">
                            <input type="date" class="form-control" id="dataInicio">
                        </div>
                    </div>
                    <div class="date-field">
                        <label for="dataFim" class="form-label">Data de fim</label>
                        <div class="date-input">
                            <input type="date" class="form-control" id="dataFim">
                        </div>
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
    // Inicializar tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
    
    // Toggle para ativar desconto
    $('#ativarDesconto').change(function() {
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
        const dateFields = $('.date-field input');
        
        if (isChecked) {
            status.text('SIM').removeClass('bg-danger').addClass('bg-success');
            dateFields.prop('disabled', false);
        } else {
            status.text('NÃO').removeClass('bg-success').addClass('bg-danger');
            dateFields.prop('disabled', true);
        }
    });
    
    // Máscara para valor monetário
    $('#valorMinimo').on('input', function() {
        let valor = $(this).val();
        valor = valor.replace(/\D/g, '');
        valor = (valor / 100).toFixed(2) + '';
        valor = valor.replace(".", ",");
        valor = valor.replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.');
        $(this).val(valor);
    });
    
    // Validação de datas
    $('#dataInicio, #dataFim').change(function() {
        const dataInicio = new Date($('#dataInicio').val());
        const dataFim = new Date($('#dataFim').val());
        
        if (dataInicio && dataFim && dataInicio >= dataFim) {
            alert('A data de início deve ser anterior à data de fim.');
            $(this).val('');
        }
    });
});

function salvarDesconto() {
    // Coletar dados do formulário
    const dados = {
        ativo: $('#ativarDesconto').is(':checked'),
        titulo: $('#tituloPromocao').val(),
        valorMinimo: $('#valorMinimo').val(),
        limitarData: $('#limitarData').is(':checked'),
        dataInicio: $('#dataInicio').val(),
        dataFim: $('#dataFim').val()
    };
    
    // Validações básicas
    if (!dados.titulo.trim()) {
        alert('Por favor, informe o título da promoção.');
        $('#tituloPromocao').focus();
        return;
    }
    
    if (dados.limitarData && (!dados.dataInicio || !dados.dataFim)) {
        alert('Por favor, informe as datas de início e fim quando limitar por data.');
        return;
    }
    
    // Aqui você implementaria a chamada AJAX para salvar
    console.log('Dados para salvar:', dados);
    alert('Desconto Progressivo salvo com sucesso!');
    
    // Redirecionar de volta para a lista
    // window.location.href = '{{ route("desconto-progressivo.index") }}';
}
</script>
@endpush 