@extends('storefront.layout.theme2')

@section('page-title')
    {{ __('Register') }}
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
                        <a href="javascript:;" class="btn btn-transparent">{{ __('Login') }}</a>
                    </li>
                    <li data-tab="login-tab-2">
                        <a href="javascript:;" class="btn btn-transparent">{{ __('Register') }}</a>
                    </li>
                </ul>
            </div>
            <div class="row align-center">
                <div class="col-lg-6 col-md-6 col-12">
                    <div class="tabs-container">
                        <div id="login-tab-1" class="tab-content active">
                            <div class="login-form">
                                {!! Form::open(array('route' => array('customer.login', $slug, (!empty($is_cart) && $is_cart==true) ? $is_cart : false), 'class' => 'login-form-inner'), ['method' => 'POST']) !!}
                                    <div class="form-container">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="email">{{ __('Email') }}<sup aria-hidden="true">*</sup></label>
                                                    {{ Form::email('email', null, array('class' => 'form-control', 'placeholder'=> __('Enter Your Email'), 'required' => 'required')) }}
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="password">{{ __('Password') }}<sup aria-hidden="true">*</sup></label>
                                                    {{ Form::password('password', array('class'=>'form-control', 'id'=>'exampleInputPassword1', 'placeholder'=> __('Enter Your Password'), 'required' => 'required')) }}
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group login-btn-wrp" style="margin-bottom: 15px;">
                                                    <p class="register-btn">
                                                        <a href="{{ route('customer.forgot.password', $slug) }}" tabindex="0">{{ __('Forgot Your Password?') }}</a>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-container login-btn-wrp">
                                        <button class="btn submit-btn login-btn-2" type="submit">{{ __('Login') }}</button>
                                        <p>{{ __('By using the system, you accept the') }}  <a href="{{ isset($privacyPage) && !empty($privacyPage) ? route('pageoption.slug', $privacyPage->slug) : 'javascript:;' }}" tabindex="0">{{ __('Privacy Policy') }}</a> {{ __('and') }} <a href="{{ isset($termsPage) && !empty($termsPage) ? route('pageoption.slug', $termsPage->slug) : 'javascript:;' }}" tabindex="0"> {{ __('System Regulations') }}.</a></p>
                                        <p class="register-btn">{{ __('Dont have account ?') }} <a href="{{ route('store.usercreate',$slug) }}">{{ __('Register') }}</a></p>
                                    </div>
                                {!! Form::close() !!}
                            </div>
                        </div>
                        <div id="login-tab-2" class="tab-content">
                            <div class="register-form">
                                {!! Form::open(array('route' => array('store.userstore', $slug), 'class' => 'register-form-inner'), ['method' => 'post']) !!}
                                    <div class="form-container">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="name">{{ __('Full Name') }}<sup aria-hidden="true">*</sup></label>
                                                    <input name="name" class="form-control" type="text" placeholder="{{ __('Enter Full Name') }}" required="required">
                                                </div>
                                                @error('name')
                                                    <span class="error invalid-email text-danger" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="email">{{ __('Email') }}<sup aria-hidden="true">*</sup></label>
                                                    <input name="email" class="form-control" type="email" placeholder="{{ __('Enter Email') }}" required="required">
                                                </div>
                                                @error('email')
                                                    <span class="error invalid-email text-danger" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <x-mobile divClass="form-group" class="form-control" name="phone_number" label="{{ __('Number') }}" placeholder="{{ __('Enter Number') }}" required="true"></x-mobile>
                                                </div>
                                                @error('number')
                                                    <span class="error invalid-email text-danger" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="password">{{ __('Password') }}<sup aria-hidden="true">*</sup></label>
                                                    <input name="password" class="form-control" type="password" placeholder="{{ __('Enter Password') }}" required="required">
                                                </div>
                                                @error('password')
                                                    <span class="error invalid-email text-danger" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="password_confirmation">{{ __('Confirm Password') }}<sup aria-hidden="true">*</sup></label>
                                                    <input name="password_confirmation" class="form-control" type="password" placeholder="{{ __('Enter Confirm Password') }}" required="required">
                                                </div>
                                                @error('password_confirmation')
                                                    <span class="error invalid-email text-danger" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-container register-btn-wrp">
                                        <button class="btn submit-btn login-btn-2" type="submit">{{ __('Register') }}</button>
                                        <p>{{ __('By using the system, you accept the') }} <a href="{{ isset($privacyPage) && !empty($privacyPage) ? route('pageoption.slug', $privacyPage->slug) : 'javascript:;' }}" tabindex="0">{{ __('Privacy Policy') }}</a> {{ __('and') }} <a href="{{ isset($termsPage) && !empty($termsPage) ? route('pageoption.slug', $termsPage->slug) : 'javascript:;' }}" tabindex="0"> {{ __('System Regulations') }}.</a></p>
                                        <p class="register-btn">{{ __('Already registered ?') }} <a href="{{ route('customer.loginform',$slug) }}">{{ __('Login') }}</a></p>
                                    </div>
                                {!! form::close() !!}
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

@push('script-page')
    <script>
        if ('{!! !empty($is_cart) && $is_cart==true !!}') {
            show_toastr('Error', __('You need to login!'), 'error');
        }
    </script>
@endpush