@extends('storefront.layout.theme4')

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
    
    @include('storefront.theme4.common.common_banner_section')

    <section class="login-page pb">
        <div class="container">
            <div class="row justify-center">
                <div class="col-lg-7 col-md-8 col-12">
                    <div class="login-form">
                        {!! Form::open(array('route' => array('customer.login', $slug, (!empty($is_cart) && $is_cart==true) ? $is_cart : false), 'class' => 'login-form-inner'), ['method' => 'POST']) !!}
                            <div class="section-title text-center">
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
                            <div class="form-container login-btn-wrp text-center">
                                <button class="btn submit-btn login-btn-2" type="submit">
                                    {{ __('Sign In') }}
                                    <span> <svg width="17" height="16" viewBox="0 0 17 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M11.1875 7.99997C11.1875 8.12784 11.1386 8.25584 11.041 8.35347L6.04097 13.3535C5.8456 13.5488 5.52922 13.5488 5.33397 13.3535C5.13872 13.1581 5.1386 12.8417 5.33397 12.6465L9.98047 7.99997L5.33397 3.35347C5.13859 3.15809 5.13859 2.84172 5.33397 2.64647C5.52934 2.45122 5.84572 2.45109 6.04097 2.64647L11.041 7.64647C11.1386 7.74409 11.1875 7.87209 11.1875 7.99997Z" fill="#203D3E"/>
                                        </svg> 
                                </span>
                                </button>
                                <p>{{ __('By using the system, you accept the') }} <a href="{{ isset($privacyPage) && !empty($privacyPage) ? route('pageoption.slug', $privacyPage->slug) : 'javascript:;' }}" tabindex="0">{{ __('Privacy Policy') }}</a> {{ __('and') }} <a href="{{ isset($termsPage) && !empty($termsPage) ? route('pageoption.slug', $termsPage->slug) : 'javascript:;' }}" tabindex="0"> {{ __('System Regulations') }}.</a></p>
                                <p class="register-btn">{{ __('Dont have account ?') }} <a href="{{ route('store.usercreate', $slug) }}">{{ __('Register') }}</a></p>
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
    <script>
        if ('{!! !empty($is_cart) && $is_cart==true !!}') {
            show_toastr('Error', __("You need to login!"), 'error');
        }
    </script>
@endpush
