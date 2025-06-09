@extends('layouts.auth')
@section('page-title')
    {{__('Login')}}
@endsection
@section('language-bar')
    @php
        $languages = App\Models\Utility::languages();
        $settings = App\Models\Utility::settings();
        if (isset($settings['RECAPTCHA_MODULE']) && $settings['RECAPTCHA_MODULE'] == 'yes'){
            config(
                [
                    'captcha.secret' => $settings['NOCAPTCHA_SECRET'],
                    'captcha.sitekey' => $settings['NOCAPTCHA_SITEKEY'],
                    'options' => [
                        'timeout' => 30,
                    ],
                ]
            );
        }
    @endphp
    <div class="lang-dropdown-only-desk">
        <li class="dropdown dash-h-item drp-language">
            <a class="dash-head-link dropdown-toggle btn" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                <span class="drp-text"> {{ ucFirst($languages[$lang]) }}
                </span>
            </a>
            <div class="dropdown-menu dash-h-dropdown dropdown-menu-end">
                @foreach($languages as $code => $language)
                    <a href="{{ route('login',$code) }}" tabindex="0" class="dropdown-item {{ $code == $lang ? 'active':'' }}">
                        <span>{{ ucFirst($language)}}</span>
                    </a>
                @endforeach
            </div>
        </li>
    </div>
@endsection
@section('content')

  <div class="card-body">
    <div>
        <h2 class="mb-3 f-w-600">{{ __('Login') }}</h2>
    </div>
    @if(session('status'))
        <div class="alert alert-danger">
            {{ session('status') }}
        </div>
    @endif
    <div class="custom-login-form">
        <form method="POST" action="{{ route('login') }}" id="form_data" class="needs-validation" novalidate>
        @csrf
            <div class="form-group mb-3">
                <label class="form-label">{{ __('Email') }}</label>
                <input id="email" type="email" class="form-control  @error('email') is-invalid @enderror"
                    name="email" placeholder="{{ __('Enter your email') }}"
                    required autofocus>
                @error('email')
                    <span class="error invalid-email text-danger" role="alert">
                        <small>{{ $message }}</small>
                    </span>
                @enderror
            </div>
            <div class="form-group mb-3 pss-field">
                <label class="form-label">{{ __('Password') }}</label>
                <input id="password" type="password" class="form-control  @error('password') is-invalid @enderror" name="password" placeholder="{{ __('Password') }}" required>
                @error('password')
                    <span class="error invalid-password text-danger" role="alert">
                        <small>{{ $message }}</small>
                    </span>
                @enderror
            </div>
            <div class="form-group mb-4">
                <div class="d-flex flex-wrap align-items-center justify-content-between">
                    @if (Route::has('password.request'))
                        <span>
                            <a href="{{ route('password.request', $lang) }}" tabindex="0">{{ __('Forgot Your Password?') }}</a>
                        </span>
                    @endif
                </div>
            </div>
            @if (isset($settings['RECAPTCHA_MODULE']) && $settings['RECAPTCHA_MODULE'] == 'yes')
                @if (isset($settings['google_recaptcha_version']) && $settings['google_recaptcha_version'] == 'v2')
                    <div class="form-group mb-4">
                        {!! NoCaptcha::display($settings['cust_darklayout']=='on' ? ['data-theme' => 'dark'] : []) !!}
                        @error('g-recaptcha-response')
                            <span class="error small text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                @else
                    <div class="form-group col-lg-12 col-md-12 mt-3">
                        <input type="hidden" id="g-recaptcha-response" name="g-recaptcha-response" class="form-control">
                        @error('g-recaptcha-response')
                            <span class="error small text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                @endif
            @endif

            <div class="d-grid">
                <button type="submit" class="btn btn-primary mt-2 login_button" id="login_button">
                    {{ __('Login') }}
                </button>
            </div>
        </form>
        @if(Utility::getValByName('signup_button')=='on')
            <p class="my-4 text-center">{{ __("Don't have an account?") }}
                <a href="{{route('register',[0,$lang])}}" tabindex="0">{{__('Register')}}</a>
            </p>
        @endif
    </div>
</div>  

@endsection
@push('custom-scripts')
    <script src="{{ asset('custom/libs/jquery/dist/jquery.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            $("#form_data").submit(function(e) {
                $("#login_button").attr("disabled", true);
                setInterval(() => {
                    $("#login_button").attr("disabled", false);
                }, 1000);
            });
        });
    </script>
    @if (isset($settings['RECAPTCHA_MODULE']) && $settings['RECAPTCHA_MODULE'] == 'yes')
        @if (isset($settings['google_recaptcha_version']) && $settings['google_recaptcha_version'] == 'v2')
            {!! NoCaptcha::renderJs() !!}
        @else
            <script src="https://www.google.com/recaptcha/api.js?render={{ $settings['NOCAPTCHA_SITEKEY'] }}"></script>
            <script>
                $(document).ready(function() {
                    grecaptcha.ready(function() {
                        grecaptcha.execute('{{ $settings['NOCAPTCHA_SITEKEY'] }}', {
                            action: 'submit'
                        }).then(function(token) {
                            $('#g-recaptcha-response').val(token);
                        });
                    });
                });
            </script>
        @endif
    @endif
@endpush
