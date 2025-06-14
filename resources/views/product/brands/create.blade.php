@extends('layouts.admin')

@section('page-title')
    {{ isset($brand) ? 'Editar Marca' : 'Criar Marca' }}
@endsection

@section('title')
    <div class="d-inline-block">
        <h5 class="h4 d-inline-block text-white font-weight-bold mb-0">
            {{ isset($brand) ? 'Editar Marca' : 'Criar Marca' }}
        </h5>
    </div>
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Início</a></li>
    <li class="breadcrumb-item"><a href="{{ route('product.index') }}">Produtos</a></li>
    <li class="breadcrumb-item"><a href="{{ route('product.brands.index') }}">Marcas</a></li>
    <li class="breadcrumb-item active" aria-current="page">
        {{ isset($brand) ? 'Editar' : 'Criar' }}
    </li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    {{ Form::open([
                        'route' => isset($brand) ? ['product.brands.update', $brand->id] : 'product.brands.store',
                        'method' => isset($brand) ? 'PUT' : 'POST',
                        'enctype' => 'multipart/form-data'
                    ]) }}
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ Form::label('name', 'Nome', ['class' => 'form-label']) }}
                                {{ Form::text('name', isset($brand) ? $brand->name : '', ['class' => 'form-control', 'placeholder' => 'Digite o nome da marca']) }}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                {{ Form::label('logo', 'Logo', ['class' => 'form-label']) }}
                                <div class="choose-files">
                                    <label for="logo">
                                        <div class="bg-primary logo_update"> 
                                            <i class="ti ti-upload px-1"></i>Escolher arquivo
                                        </div>
                                        <input type="file" name="logo" id="logo" class="form-control file" data-filename="logo_update">
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                {{ Form::label('description', 'Descrição', ['class' => 'form-label']) }}
                                {{ Form::textarea('description', isset($brand) ? $brand->description : '', ['class' => 'form-control', 'rows' => 3, 'placeholder' => 'Digite a descrição da marca']) }}
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-check form-switch">
                                    <input type="checkbox" class="form-check-input" name="is_active" 
                                        {{ isset($brand) && $brand->is_active ? 'checked' : '' }}>
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