@extends('storefront.layout.theme10')

@section('page-title')
    {{ __('Reset Password') }}
@endsection

@php
if (!empty(session()->get('lang'))) {
    $currantLang = session()->get('lang');
} else {
    $currantLang = $store->lang;
}
\App::setLocale($currantLang);
$imgpath = \App\Models\Utility::get_file('uploads/');
@endphp

@section('content')
<main>
    
    @include('storefront.theme10.common.common_banner_section')

    <section class="login-page pt pb">
        <div class="container">
            <div class="section-title text-center">
                <h2>{{ __('Reset Password') }}</h2>
            </div>
            <div class="login-inner">
                <div class="row no-gutters">
                    <div class="col-md-6 col-12">
                        <div class="login-img img-ratio">
                            <img src="{{ $imgpath. 'theme10/header/login-image.png' }}" alt="login-image" >
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="login-form">
                            {!! Form::open(array('route' => array('customer.reset.password.update', $slug), 'class' => 'login-form-inner'), ['method' => 'POST']) !!}
                                <div class="form-container">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="email">{{ __('Email') }}<sup aria-hidden="true">*</sup></label>
                                                <input name="email" class="form-control" type="email" placeholder="{{ __('Enter Your Email') }}" required="required" autofocus>
                                                @error('email')
                                                    <span class="error invalid-email text-danger" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="password">{{ __('Password') }}<sup aria-hidden="true">*</sup></label>
                                                <input name="password" class="form-control" type="password" placeholder="{{ __('Enter Your Password') }}" required="required">
                                                @error('password')
                                                    <span class="error invalid-email text-danger" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="password_confirmation">{{ __('Confirm Password') }}<sup aria-hidden="true">*</sup></label>
                                                <input name="password_confirmation" class="form-control" type="password" placeholder="{{ __('Enter Confirm Password') }}" required="required">
                                                @error('password_confirmation')
                                                    <span class="error invalid-email text-danger" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-container login-btn-wrp">
                                    <input type="hidden" name="token" value="{{ $token }}">
                                    <button class="btn submit-btn login-btn-2" type="submit">{{ __('Reset Password') }}</button>
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

