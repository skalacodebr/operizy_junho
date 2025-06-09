@extends('storefront.layout.theme9')

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

$imgpath = \App\Models\Utility::get_file('uploads/');
@endphp

@section('content')
<main>

    @include('storefront.theme9.common.common_banner_section')

    <section class="register-page pb pt">
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
                                <button class="btn submit-btn login-btn-2" type="submit">{{__('Register')}}</button>
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
