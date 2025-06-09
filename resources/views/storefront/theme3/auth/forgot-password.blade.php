@extends('storefront.layout.theme3')

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
                            {!! Form::open(array('route' => array('customer.password.email', $slug), 'class' => 'login-form-inner'), ['method' => 'POST']) !!}
                                <div class="section-title">
                                    <h2>{{ __('Forgot Password') }}</h2>
                                </div>
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
        </div>
    </section>
</main>
@endsection

