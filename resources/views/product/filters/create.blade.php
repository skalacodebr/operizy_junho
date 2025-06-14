@extends('layouts.admin')

@section('page-title')
    {{ isset($filter) ? 'Editar Filtro' : 'Criar Filtro' }}
@endsection

@section('title')
    <div class="d-inline-block">
        <h5 class="h4 d-inline-block text-white font-weight-bold mb-0">
            {{ isset($filter) ? 'Editar Filtro' : 'Criar Filtro' }}
        </h5>
    </div>
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Início</a></li>
    <li class="breadcrumb-item"><a href="{{ route('product.index') }}">Produtos</a></li>
    <li class="breadcrumb-item"><a href="{{ route('product.filters.index') }}">Filtros</a></li>
    <li class="breadcrumb-item active" aria-current="page">
        {{ isset($filter) ? 'Editar' : 'Criar' }}
    </li>
@endsection

@push('script-page')
<script>
    // Adicionar novo valor
    function addValue() {
        const valuesList = document.getElementById('values-list');
        const type = document.getElementById('type').value;
        const index = valuesList.children.length;

        const valueRow = document.createElement('div');
        valueRow.className = 'row mb-3 value-row';
        valueRow.innerHTML = `
            <div class="col-${type === 'color' ? '6' : '10'}">
                <input type="text" name="values[]" class="form-control" placeholder="Digite o valor" required>
            </div>
            ${type === 'color' ? `
                <div class="col-4">
                    <input type="color" name="colors[]" class="form-control" value="#000000">
                </div>
            ` : ''}
            <div class="col-2">
                <button type="button" class="btn btn-danger btn-sm" onclick="removeValue(this)">
                    <i class="ti ti-minus"></i>
                </button>
            </div>
        `;

        valuesList.appendChild(valueRow);
    }

    // Remover valor
    function removeValue(button) {
        button.closest('.value-row').remove();
    }

    // Atualizar campos quando o tipo mudar
    document.getElementById('type').addEventListener('change', function() {
        const valuesList = document.getElementById('values-list');
        valuesList.innerHTML = '';
        addValue();
    });

    // Adicionar primeiro valor ao carregar
    document.addEventListener('DOMContentLoaded', function() {
        if (!document.querySelector('.value-row')) {
            addValue();
        }
    });
</script>
@endpush

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    {{ Form::open([
                        'route' => isset($filter) ? ['product.filters.update', $filter->id] : 'product.filters.store',
                        'method' => isset($filter) ? 'PUT' : 'POST'
                    ]) }}
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ Form::label('name', 'Nome', ['class' => 'form-label']) }}
                                {{ Form::text('name', isset($filter) ? $filter->name : '', ['class' => 'form-control', 'placeholder' => 'Digite o nome do filtro']) }}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                {{ Form::label('type', 'Tipo', ['class' => 'form-label']) }}
                                {{ Form::select('type', [
                                    'select' => 'Seleção',
                                    'checkbox' => 'Checkbox',
                                    'radio' => 'Radio',
                                    'color' => 'Cor'
                                ], isset($filter) ? $filter->type : '', ['class' => 'form-control', 'id' => 'type']) }}
                            </div>
                        </div>

                        <div class="col-md-12 mt-3">
                            <div class="form-group">
                                <label class="form-label d-block">Valores</label>
                                <div id="values-list">
                                    @if(isset($filter))
                                        @foreach($filter->values as $value)
                                            <div class="row mb-3 value-row">
                                                <div class="col-{{ $filter->type === 'color' ? '6' : '10' }}">
                                                    <input type="text" name="values[]" class="form-control" value="{{ $value->value }}" required>
                                                </div>
                                                @if($filter->type === 'color')
                                                    <div class="col-4">
                                                        <input type="color" name="colors[]" class="form-control" value="{{ $value->color }}">
                                                    </div>
                                                @endif
                                                <div class="col-2">
                                                    <button type="button" class="btn btn-danger btn-sm" onclick="removeValue(this)">
                                                        <i class="ti ti-minus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                                <button type="button" class="btn btn-success btn-sm mt-2" onclick="addValue()">
                                    <i class="ti ti-plus"></i> Adicionar Valor
                                </button>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-check form-switch">
                                    <input type="checkbox" class="form-check-input" name="is_active" 
                                        {{ isset($filter) && $filter->is_active ? 'checked' : '' }}>
                                    <span class="form-check-label">Ativo</span>
                                </label>
                            </div>
                        </div>

                        <div class="col-md-12 text-end">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Salvar</button>
                            </div>
                        </div>
                    </div>

                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
@endsection 