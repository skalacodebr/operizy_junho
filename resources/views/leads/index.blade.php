@extends('layouts.admin')
@php
    $storagesetting = App\Models\Utility::StorageSettings();
    if($storagesetting['storage_setting'] == 'wasabi' || $storagesetting['storage_setting'] == 's3'){
        $logo = \App\Models\Utility::get_file('uploads/logo');
    }else{
        $logo = \App\Models\Utility::get_file('uploads/logo/');
    }

    $logo_img = \App\Models\Utility::getValByName('company_logo');
    $logo_light = \App\Models\Utility::getValByName('company_logo_light');
    $logo_dark = \App\Models\Utility::getValByName('company_logo_dark');
    $s_logo = \App\Models\Utility::get_file('uploads/store_logo/');
    if (Auth::user()->type != 'super admin') {
        $theme_name = isset($store_settings) ? $store_settings->theme_dir : 'theme1';
        $brand_logo = \App\Models\Utility::get_file('uploads/'. $theme_name .'/brand_logo/');
    }
    $company_favicon = \App\Models\Utility::getValByName('company_favicon');
    $lang = \App\Models\Utility::getValByName('default_language');
    $company_logo = \App\Models\Utility::GetLogo();
    $metaimage = Utility::get_file('uploads/metaImage/');
    if (Auth::user()->type !== 'super admin') {
        $store_lang = $store_settings->lang;
    }

    // storage setting
    $file_type = config('files_types');
    $setting = App\Models\Utility::settings();

    $local_storage_validation = $setting['local_storage_validation'];
    $local_storage_validations = explode(',', $local_storage_validation);

    $s3_storage_validation = $setting['s3_storage_validation'];
    $s3_storage_validations = explode(',', $s3_storage_validation);

    $wasabi_storage_validation = $setting['wasabi_storage_validation'];
    $wasabi_storage_validations = explode(',', $wasabi_storage_validation);

    $setting_color = App\Models\Utility::colorset();

    $color = 'theme-3';
    if (!empty($setting_color['color'])) {
        $color = $setting_color['color'];
    }
    $flag = (!empty($setting['color_flag'])) ? $setting['color_flag'] : 'false';
    $plan = \App\Models\Plan::find(\Auth::user()->plan);
    $chatgpt = \App\Models\Utility::settings();

    $languages = \App\Models\Utility::languages();
    $google_recaptcha_version = ['v2' => __('v2'),'v3' => __('v3')];
@endphp
@section('page-title')
    @if (Auth::user()->type == 'super admin')
        {{ __('Settings') }}
    @else
        {{ __('Store Settings') }}
    @endif
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
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Home') }}</a></li>
@if (Auth::user()->type == 'super admin')
    <li class="breadcrumb-item active" aria-current="page">{{ __('Settings') }}</li>
@else
    <li class="breadcrumb-item active" aria-current="page">{{ __('Store Settings') }}</li>
@endif
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
