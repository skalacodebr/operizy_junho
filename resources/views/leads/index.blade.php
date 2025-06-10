@extends('layouts.admin')
@php
  
@endphp
@section('page-title')
   
@endsection
@section('title')
    <div class="d-inline-block">
        @if (Auth::user()->type == 'super admin')
            <h5 class="h4 d-inline-block font-weight-bold mb-0 text-white">{{ __('Settings') }}</h5>
        @else
            <h5 class="h4 d-inline-block font-weight-bold mb-0 text-white">{{ __('Store Settings') }}</h5>
        @endif
    </div>
@endsection

@endsection

@push('script-page')
    <script src="{{ asset('custom/libs/summernote/summernote-bs4.js') }}"></script>

@endpush
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card rounded">
           
            </div>
        </div>
    </div>
@endsection
@push('script-page')
    <script src="{{ asset('custom/libs/jquery-mask-plugin/dist/jquery.mask.min.js') }}"></script>

@endpush
