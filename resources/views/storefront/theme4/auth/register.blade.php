@extends('storefront.layout.theme4')

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

    @include('storefront.theme4.common.common_banner_section')

    <section class="register-page pb">
        <div class="container">
            <div class="row justify-center">
                <div class="col-lg-7 col-md-8 col-12">
                    <div class="register-form">
                        {!! Form::open(array('route' => array('store.userstore', $slug), 'class' => 'register-form-inner'), ['method' => 'post']) !!}
                            <div class="section-title text-center">
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
                            <div class="form-container register-btn-wrp text-center">
                                <button class="btn submit-btn login-btn-2" type="submit">
                                    {{ __('Register') }}
                                    <span> <svg width="17" height="16" viewBox="0 0 17 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M11.1875 7.99997C11.1875 8.12784 11.1386 8.25584 11.041 8.35347L6.04097 13.3535C5.8456 13.5488 5.52922 13.5488 5.33397 13.3535C5.13872 13.1581 5.1386 12.8417 5.33397 12.6465L9.98047 7.99997L5.33397 3.35347C5.13859 3.15809 5.13859 2.84172 5.33397 2.64647C5.52934 2.45122 5.84572 2.45109 6.04097 2.64647L11.041 7.64647C11.1386 7.74409 11.1875 7.87209 11.1875 7.99997Z" fill="#203D3E"/>
                                        </svg> 
                                </span>
                                </button>
                                <p>{{ __('By using the system, you accept the') }} <a href="{{ isset($privacyPage) && !empty($privacyPage) ? route('pageoption.slug', $privacyPage->slug) : 'javascript:;' }}" tabindex="0">{{ __('Privacy Policy') }}</a> {{ __('and') }} <a href="{{ isset($termsPage) && !empty($termsPage) ? route('pageoption.slug', $termsPage->slug) : 'javascript:;' }}" tabindex="0"> {{ __('System Regulations') }}.</a></p>
                                <p class="register-btn">{{ __('Already registered ?') }} <a href="{{ route('customer.loginform',$slug) }}">{{ __('Login') }}</a></p>
                            </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection

@push('script-page')
@endpush
