@extends('storefront.layout.theme3')

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
@endphp

@section('content')
<main>

    @include('storefront.theme3.common.common_banner_section')

    <section class="register-page pt pb">
        <div class="container">
            <div class="register-inner">
                <div class="row">
                    <div class="col-md-6 col-12">
                        <div class="register-image-col">
                            <img src="{{ asset('assets/theme3/images/login-bg-img.png') }}" alt="login-bg" class="register-bg-col">
                            <div class="register-image-inner">
                                <h3 class="register-image-content">
                                &#x1F44c; {{ __('Very Good Works are Waiting For You Login Now') }}                                     
                                </h3>
                                <div class="register-img img-ratio">
                                <img src="{{ asset('assets/theme3/images/login-image.png') }}" alt="login-image" >
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="register-form">
                            {!! Form::open(array('route' => array('store.userstore', $slug), 'class' => 'register-form-inner'), ['method' => 'post']) !!}
                                <div class="section-title">
                                    <h2>{{ __('Customer Register') }}</h2>
                                </div>
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
                                    <button class="btn submit-btn login-btn-2" type="submit">{{__('Register')}}</button>
                                    <p>{{ __('By using the system, you accept the') }} <a href="{{ isset($privacyPage) && !empty($privacyPage) ? route('pageoption.slug', $privacyPage->slug) : 'javascript:;' }}" tabindex="0">{{ __('Privacy Policy') }}</a> {{ __('and') }} <a href="{{ isset($termsPage) && !empty($termsPage) ? route('pageoption.slug', $termsPage->slug) : 'javascript:;' }}" tabindex="0"> {{ __('System Regulations') }}.</a></p>
                                    <p class="register-btn">{{ __('Already registered ?') }} <a href="{{ route('customer.loginform',$slug) }}">{{ __('Login') }}</a></p>
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
@endpush
