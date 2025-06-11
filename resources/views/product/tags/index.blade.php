@extends('layouts.admin')

@section('page-title')
    {{ __('Tags & Seals') }}
@endsection

@section('title')
    <div class="d-inline-block">
        <h5 class="h4 d-inline-block text-white font-weight-bold mb-0">{{ __('Tags & Seals') }}</h5>
    </div>
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Home') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('product.index') }}">{{ __('Products') }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('Tags & Seals') }}</li>
@endsection

@section('action-btn')
    <div class="pr-2">
        <a href="{{ route('product.tags.create') }}" class="btn btn-sm btn-primary btn-icon m-1">
            {{ __('Create') }} <i class="ti ti-plus"></i>
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
                                    <th>{{ __('Name') }}</th>
                                    <th>{{ __('Type') }}</th>
                                    <th>{{ __('Color') }}</th>
                                    <th>{{ __('Icon') }}</th>
                                    <th>{{ __('Products') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th>{{ __('Created At') }}</th>
                                    <th width="250px">{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tags as $tag)
                                    <tr>
                                        <td>{{ $tag->name }}</td>
                                        <td>
                                            <span class="badge bg-{{ $tag->type == 'tag' ? 'info' : 'warning' }} p-2 px-3 rounded">
                                                {{ ucfirst($tag->type) }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge p-2 px-3 rounded" style="background-color: {{ $tag->color }}">
                                                {{ $tag->color }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($tag->icon)
                                                <i class="{{ $tag->icon }} f-20"></i>
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>{{ $tag->products->count() }}</td>
                                        <td>
                                            @if($tag->is_active)
                                                <span class="badge bg-success p-2 px-3 rounded">{{ __('Active') }}</span>
                                            @else
                                                <span class="badge bg-danger p-2 px-3 rounded">{{ __('Inactive') }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            {{ \App\Models\Utility::dateFormat($tag->created_at) }}
                                        </td>
                                        <td class="Action">
                                            <div class="d-flex">
                                                <a href="{{ route('product.tags.edit', $tag->id) }}" class="btn btn-sm btn-icon bg-light-secondary me-2" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('Edit') }}">
                                                    <i class="ti ti-edit f-20"></i>
                                                </a>
                                                {!! Form::open(['method' => 'DELETE', 'route' => ['product.tags.destroy', $tag->id], 'id' => 'delete-form-'.$tag->id]) !!}
                                                    <a href="#" class="btn btn-sm btn-icon bg-light-secondary show_confirm" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('Delete') }}">
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