@extends('storefront.layout.theme5')

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

    @include('storefront.theme5.common.common_banner_section')

    <section class="register-page pt pb">
        <div class="container">
            <div class="register-inner">
                <div class="row align-center">
                    <div class="col-md-6 col-12">
                        <div class="register-image-col">
                            <div class="register-img img-ratio">
                                <img src="{{ $imgpath. (!empty($homepage_header_bckground_Image) ? $homepage_header_bckground_Image : 'home-banner1.png') }}" alt="login-image" >
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
                                    <button class="btn submit-btn login-btn-2" type="submit">{{__('Register')}}
                                        <svg width="31" height="16" viewBox="0 0 31 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M30.7071 8.70711C31.0976 8.31658 31.0976 7.68342 30.7071 7.29289L24.3431 0.928932C23.9526 0.538408 23.3195 0.538408 22.9289 0.928932C22.5384 1.31946 22.5384 1.95262 22.9289 2.34315L28.5858 8L22.9289 13.6569C22.5384 14.0474 22.5384 14.6805 22.9289 15.0711C23.3195 15.4616 23.9526 15.4616 24.3431 15.0711L30.7071 8.70711ZM0 9H30V7H0V9Z" fill="#222222"></path>
                                        </svg>
                                    </button>
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
