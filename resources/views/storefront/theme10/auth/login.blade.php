@extends('storefront.layout.theme10')

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

$imgpath = \App\Models\Utility::get_file('uploads/');
@endphp

@section('content')
<main>
    
    @include('storefront.theme10.common.common_banner_section')

    <section class="login-page pt pb">
        <div class="container">
            <div class="section-title text-center">
                <h2>{{ __('Customer Login') }}</h2>
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
                            {!! Form::open(array('route' => array('customer.login', $slug, (!empty($is_cart) && $is_cart==true) ? $is_cart : false), 'class' => 'login-form-inner'), ['method' => 'POST']) !!}
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
