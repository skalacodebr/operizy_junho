@extends('storefront.layout.theme2')

@section('page-title')
    {{ __('Forgot Password') }}
@endsection

@php
if (!empty(session()->get('lang'))) {
    $currantLang = session()->get('lang');
} else {
    $currantLang = $store->lang;
}
\App::setLocale($currantLang);

$getStoreThemeSetting = Utility::getStoreThemeSetting($store->id, $store->theme_dir);
$getStoreThemeSetting1 = [];
if (!empty($getStoreThemeSetting['dashboard'])) {
    $getStoreThemeSetting = json_decode($getStoreThemeSetting['dashboard'], true);
    $getStoreThemeSetting1 = Utility::getStoreThemeSetting($store->id, $store->theme_dir);
}
if (empty($getStoreThemeSetting)) {
    $path = storage_path() . '/uploads/' . $store->theme_dir . '/' . $store->theme_dir . '.json';
    $getStoreThemeSetting = json_decode(file_get_contents($path), true);
}

$imgpath=\App\Models\Utility::get_file('uploads/');
@endphp

@section('content')

@foreach ($getStoreThemeSetting as $ThemeSetting)
    @if (isset($ThemeSetting['section_name']) && $ThemeSetting['section_name'] == 'Home-Header' && $ThemeSetting['section_enable'] == 'on')
        @php
            $homepage_header_bckground_Image_key = array_search('Background Image', array_column($ThemeSetting['inner-list'], 'field_name'));
            $homepage_header_bckground_Image = $ThemeSetting['inner-list'][$homepage_header_bckground_Image_key]['field_default_text'];
        @endphp
    @endif
@endforeach

<main>
    
    @include('storefront.theme2.common.common_banner_section')

    <section class="login-page pt pb tabs-wrapper">
        <div class="container">
            <div class="login-tab-header">
                <ul class="tabs flex align-center">
                    <li data-tab="login-tab-1" class="active">
                        <a href="javascript:;" class="btn btn-transparent">{{ __('Forgot Password') }}</a>
                    </li>
                </ul>
            </div>
            <div class="row align-center">
                <div class="col-lg-6 col-md-6 col-12">
                    <div class="tabs-container">
                        <div id="login-tab-1" class="tab-content active">
                            <div class="login-form">
                                {!! Form::open(array('route' => array('customer.password.email', $slug), 'class' => 'login-form-inner'), ['method' => 'POST']) !!}
                                    <div class="form-container">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="email">{{ __('Email') }}<sup aria-hidden="true">*</sup></label>
                                                    {{ Form::email('email', null, array('class'=>'form-control', 'placeholder' => __('Enter Your Email'), 'required' => 'required')) }}
                                                    @error('email')
                                                        <span class="error invalid-email text-danger" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-container login-btn-wrp">
                                        <button class="btn submit-btn login-btn-2" type="submit">{{ __('Send Password Reset Link') }}</button>
                                        <p class="register-btn">{{ __('Back to') }} <a href="{{ route('customer.loginform', $slug) }}">{{ __('Login') }}</a></p>
                                    </div>
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-12">
                    <div class="login-image-col">
                        <div class="login-image img-ratio">
                            <img src="{{ $imgpath. (!empty($homepage_header_bckground_Image) ? $homepage_header_bckground_Image : 'home-banner1.png') }}" alt="login image">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection

