@extends('layouts.admin')

@section('page-title')
    {{ isset($brand) ? __('Edit Brand') : __('Create Brand') }}
@endsection

@section('title')
    <div class="d-inline-block">
        <h5 class="h4 d-inline-block text-white font-weight-bold mb-0">
            {{ isset($brand) ? __('Edit Brand') : __('Create Brand') }}
        </h5>
    </div>
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Home') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('product.index') }}">{{ __('Products') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('product.brands.index') }}">{{ __('Brands') }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">
        {{ isset($brand) ? __('Edit') : __('Create') }}
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
                                {{ Form::label('name', __('Name'), ['class' => 'form-label']) }}
                                {{ Form::text('name', isset($brand) ? $brand->name : '', ['class' => 'form-control', 'placeholder' => __('Enter brand name')]) }}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                {{ Form::label('logo', __('Logo'), ['class' => 'form-label']) }}
                                <div class="choose-files">
                                    <label for="logo">
                                        <div class="bg-primary logo_update"> 
                                            <i class="ti ti-upload px-1"></i>{{ __('Choose file here') }}
                                        </div>
                                        <input type="file" name="logo" id="logo" class="form-control file" data-filename="logo_update">
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                {{ Form::label('description', __('Description'), ['class' => 'form-label']) }}
                                {{ Form::textarea('description', isset($brand) ? $brand->description : '', ['class' => 'form-control', 'rows' => 3, 'placeholder' => __('Enter brand description')]) }}
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-check form-switch">
                                    <input type="checkbox" class="form-check-input" name="is_active" 
                                        {{ isset($brand) && $brand->is_active ? 'checked' : '' }}>
                                    <span class="form-check-label">{{ __('Active') }}</span>
                                </label>
                            </div>
                        </div>

                        <div class="col-md-12 text-end">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                            </div>
                        </div>
                    </div>

                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
@endsection 