@extends('layouts.admin')

@section('page-title')
    Coleções
@endsection

@section('title')
    <div class="d-inline-block">
        <h5 class="h4 d-inline-block text-white font-weight-bold mb-0">Coleções</h5>
    </div>
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Início</a></li>
    <li class="breadcrumb-item"><a href="{{ route('product.index') }}">Produtos</a></li>
    <li class="breadcrumb-item active" aria-current="page">Coleções</li>
@endsection

@section('action-btn')
    <div class="pr-2">
        <a href="{{ route('product.collections.create') }}" class="btn btn-sm btn-primary btn-icon m-1">
            Criar <i class="ti ti-plus"></i>
        </a>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body table-border-style">
                    <div class="table-responsive">
                        <table class="table mb-0 pc-dt-simple">
                            <thead>
                                <tr>
                                    <th>Imagem</th>
                                    <th>Nome</th>
                                    <th>Produtos</th>
                                    <th>Status</th>
                                    <th>Criado em</th>
                                    <th width="250px">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($collections as $collection)
                                    <tr>
                                        <td>
                                            @if($collection->image)
                                                <img src="{{ asset('uploads/collections/'.$collection->image) }}" alt="{{ $collection->name }}" class="wid-25 rounded">
                                            @else
                                                <img src="{{ asset('uploads/collections/default.jpg') }}" alt="{{ $collection->name }}" class="wid-25 rounded">
                                            @endif
                                        </td>
                                        <td>{{ $collection->name }}</td>
                                        <td>{{ $collection->products->count() }}</td>
                                        <td>
                                            @if($collection->is_active)
                                                <span class="badge bg-success p-2 px-3 rounded">Ativo</span>
                                            @else
                                                <span class="badge bg-danger p-2 px-3 rounded">Inativo</span>
                                            @endif
                                        </td>
                                        <td>
                                            {{ \App\Models\Utility::dateFormat($collection->created_at) }}
                                        </td>
                                        <td class="Action">
                                            <div class="d-flex">
                                                <a href="{{ route('product.collections.edit', $collection->id) }}" class="btn btn-sm btn-icon bg-light-secondary me-2" data-bs-toggle="tooltip" data-bs-placement="top" title="Editar">
                                                    <i class="ti ti-edit f-20"></i>
                                                </a>
                                                {!! Form::open(['method' => 'DELETE', 'route' => ['product.collections.destroy', $collection->id], 'id' => 'delete-form-'.$collection->id]) !!}
                                                    <a href="#" class="btn btn-sm btn-icon bg-light-secondary show_confirm" data-bs-toggle="tooltip" data-bs-placement="top" title="Excluir">
                                                        <i class="ti ti-trash f-20"></i>
                                                    </a>
                                                {!! Form::close() !!}
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection 