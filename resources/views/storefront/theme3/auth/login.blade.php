@extends('storefront.layout.theme3')

@section('page-title')
    {{ __('Login') }}
@endsection

@php
if (!empty(session()->get('lang'))) {
    $currantLang = session()->get('lang');
} else {
    $currantLang = $store->lang;
}
\App::setLocale($currantLang);
@endphp

@section('content')
<main>
    
    @include('storefront.theme3.common.common_banner_section')

    <section class="login-page pt pb">
        <div class="container">
            <div class="login-inner">
                <div class="row">
                    <div class="col-md-6 col-12">
                        <div class="login-image-col">
                            <img src="{{ asset('assets/theme3/images/login-bg-img.png') }}" alt="login-bg" class="login-bg-col">
                            <div class="login-image-inner">
                                <h3 class="login-image-content">
                                &#x1F44c;  {{ __('Very Good Works are Waiting For You Login Now') }}                                     
                                </h3>
                                <div class="login-img img-ratio">
                                <img src="{{ asset('assets/theme3/images/login-image.png') }}" alt="login-image" >
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="login-form">
                            {!! Form::open(array('route' => array('customer.login', $slug, (!empty($is_cart) && $is_cart==true) ? $is_cart : false), 'class' => 'login-form-inner'), ['method' => 'POST']) !!}
                                <div class="section-title">
                                    <h2>{{ __('Customer Login') }}</h2>
                                </div>
                                <div class="form-container">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="email">{{ __('Email') }}<sup aria-hidden="true">*</sup></label>
                                                {{ Form::email('email', null, array('class'=>'form-control', 'placeholder' => __('Enter Your Email'), 'required' => 'required')) }}
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
                                    <button class="btn submit-btn login-btn-2" type="submit">
                                        <span>{{ __('Sign In') }}</span>
                                        <svg width="31" height="16" viewBox="0 0 31 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M30.7071 8.70711C31.0976 8.31658 31.0976 7.68342 30.7071 7.29289L24.3431 0.928932C23.9526 0.538408 23.3195 0.538408 22.9289 0.928932C22.5384 1.31946 22.5384 1.95262 22.9289 2.34315L28.5858 8L22.9289 13.6569C22.5384 14.0474 22.5384 14.6805 22.9289 15.0711C23.3195 15.4616 23.9526 15.4616 24.3431 15.0711L30.7071 8.70711ZM0 9H30V7H0V9Z" fill="#222222"></path>
                                        </svg>
                                    </button>
                                    <p>{{ __('By using the system, you accept the') }} <a href="{{ isset($privacyPage) && !empty($privacyPage) ? route('pageoption.slug', $privacyPage->slug) : 'javascript:;' }}" tabindex="0">{{ __('Privacy Policy') }}</a> {{ __('and') }} <a href="{{ isset($termsPage) && !empty($termsPage) ? route('pageoption.slug', $termsPage->slug) : 'javascript:;' }}" tabindex="0"> {{ __('System Regulations') }}.</a></p>
                                    <p class="register-btn">{{ __('Dont have account ?') }} <a href="{{ route('store.usercreate', $slug) }}">{{ __('Register') }}</a></p>
                                </div>
                            {!! Form::close() !!}
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
            show_toastr('Error', __("You need to login!"), 'error');
        }
    </script>
@endpush
