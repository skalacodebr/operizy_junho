@extends('layouts.admin')

@section('page-title')
    {{ isset($tag) ? __('Edit Tag') : __('Create Tag') }}
@endsection

@section('title')
    <div class="d-inline-block">
        <h5 class="h4 d-inline-block text-white font-weight-bold mb-0">
            {{ isset($tag) ? __('Edit Tag') : __('Create Tag') }}
        </h5>
    </div>
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Home') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('product.index') }}">{{ __('Products') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('product.tags.index') }}">{{ __('Tags & Seals') }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">
        {{ isset($tag) ? __('Edit') : __('Create') }}
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
                                {{ Form::label('name', __('Name'), ['class' => 'form-label']) }}
                                {{ Form::text('name', isset($tag) ? $tag->name : '', ['class' => 'form-control', 'placeholder' => __('Enter tag name')]) }}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                {{ Form::label('type', __('Type'), ['class' => 'form-label']) }}
                                {{ Form::select('type', ['tag' => __('Tag'), 'seal' => __('Seal')], isset($tag) ? $tag->type : '', ['class' => 'form-control']) }}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                {{ Form::label('color', __('Color'), ['class' => 'form-label']) }}
                                {{ Form::color('color', isset($tag) ? $tag->color : '#000000', ['class' => 'form-control']) }}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                {{ Form::label('icon', __('Icon'), ['class' => 'form-label']) }}
                                {{ Form::text('icon', isset($tag) ? $tag->icon : '', ['class' => 'form-control', 'placeholder' => __('Enter icon class (e.g. ti ti-tag)')]) }}
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-check form-switch">
                                    <input type="checkbox" class="form-check-input" name="is_active" 
                                        {{ isset($tag) && $tag->is_active ? 'checked' : '' }}>
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