@extends('layouts.admin')

@section('page-title')
    {{ isset($tag) ? 'Editar Tag/Selo' : 'Criar Tag/Selo' }}
@endsection

@section('title')
    <div class="d-inline-block">
        <h5 class="h4 d-inline-block text-white font-weight-bold mb-0">
            {{ isset($tag) ? 'Editar Tag/Selo' : 'Criar Tag/Selo' }}
        </h5>
    </div>
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Início</a></li>
    <li class="breadcrumb-item"><a href="{{ route('product.index') }}">Produtos</a></li>
    <li class="breadcrumb-item"><a href="{{ route('product.tags.index') }}">Tags e Selos</a></li>
    <li class="breadcrumb-item active" aria-current="page">
        {{ isset($tag) ? 'Editar' : 'Criar' }}
    </li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    {{ Form::open([
                        'route' => isset($tag) ? ['product.tags.update', $tag->id] : 'product.tags.store',
                        'method' => isset($tag) ? 'PUT' : 'POST'
                    ]) }}
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ Form::label('name', 'Nome', ['class' => 'form-label']) }}
                                {{ Form::text('name', isset($tag) ? $tag->name : '', ['class' => 'form-control', 'placeholder' => 'Digite o nome da tag/selo']) }}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                {{ Form::label('type', 'Tipo', ['class' => 'form-label']) }}
                                {{ Form::select('type', ['tag' => 'Tag', 'seal' => 'Selo'], isset($tag) ? $tag->type : '', ['class' => 'form-control']) }}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                {{ Form::label('color', 'Cor', ['class' => 'form-label']) }}
                                {{ Form::color('color', isset($tag) ? $tag->color : '#000000', ['class' => 'form-control']) }}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                {{ Form::label('icon', 'Ícone', ['class' => 'form-label']) }}
                                {{ Form::text('icon', isset($tag) ? $tag->icon : '', ['class' => 'form-control', 'placeholder' => 'Digite a classe do ícone (ex: ti ti-tag)']) }}
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-check form-switch">
                                    <input type="checkbox" class="form-check-input" name="is_active" 
                                        {{ isset($tag) && $tag->is_active ? 'checked' : '' }}>
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