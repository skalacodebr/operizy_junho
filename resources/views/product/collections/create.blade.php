@extends('layouts.admin')

@section('page-title')
    {{ isset($collection) ? __('Edit Collection') : __('Create Collection') }}
@endsection

@section('title')
    <div class="d-inline-block">
        <h5 class="h4 d-inline-block text-white font-weight-bold mb-0">
            {{ isset($collection) ? __('Edit Collection') : __('Create Collection') }}
        </h5>
    </div>
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Home') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('product.index') }}">{{ __('Products') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('product.collections.index') }}">{{ __('Collections') }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">
        {{ isset($collection) ? __('Edit') : __('Create') }}
    </li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    {{ Form::open([
                        'route' => isset($collection) ? ['product.collections.update', $collection->id] : 'product.collections.store',
                        'method' => isset($collection) ? 'PUT' : 'POST',
                        'enctype' => 'multipart/form-data'
                    ]) }}
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ Form::label('name', __('Name'), ['class' => 'form-label']) }}
                                {{ Form::text('name', isset($collection) ? $collection->name : '', ['class' => 'form-control', 'placeholder' => __('Enter collection name')]) }}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                {{ Form::label('image', __('Image'), ['class' => 'form-label']) }}
                                <div class="choose-files">
                                    <label for="image">
                                        <div class="bg-primary image_update"> 
                                            <i class="ti ti-upload px-1"></i>{{ __('Choose file here') }}
                                        </div>
                                        <input type="file" name="image" id="image" class="form-control file" data-filename="image_update">
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                {{ Form::label('description', __('Description'), ['class' => 'form-label']) }}
                                {{ Form::textarea('description', isset($collection) ? $collection->description : '', ['class' => 'form-control', 'rows' => 3, 'placeholder' => __('Enter collection description')]) }}
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-check form-switch">
                                    <input type="checkbox" class="form-check-input" name="is_active" 
                                        {{ isset($collection) && $collection->is_active ? 'checked' : '' }}>
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