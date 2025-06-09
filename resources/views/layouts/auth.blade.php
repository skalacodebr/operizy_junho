@php
    $settings = Utility::settings();
    $setting = App\Models\Utility::colorset();
    // $color = 'theme-3';
    // if (!empty($setting['color'])) {
    //     $color = $setting['color'];
    // }
    $color = !empty($setting['color']) ? $setting['color'] : 'theme-3';

    if(isset($setting['color_flag']) && $setting['color_flag'] == 'true')
    {
        $themeColor = 'custom-color';
    }
    else {
        $themeColor = $color;
    }
    $company_logo = \App\Models\Utility::GetLogo();
    $logo = \App\Models\Utility::get_file('uploads/logo/');
    $lang = \App::getLocale('lang');
    if ($lang == 'ar' || $lang == 'he') {
        $setting['SITE_RTL'] = 'on';
    }
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    dir="{{ isset($setting['SITE_RTL']) && $setting['SITE_RTL'] == 'on' ? 'rtl' : '' }}">

<head>
    <title>
        {{ \App\Models\Utility::getValByName('title_text') ? \App\Models\Utility::getValByName('title_text') : config('app.name', 'StoreGo SaaS') }}
        - @yield('page-title')</title>
    <!-- Meta -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="Dashboard Template Description" />
    <meta name="keywords" content="Dashboard Template" />
    <meta name="author" content="WorkDo" />

    <!-- Favicon icon -->
    <link rel="icon" href="{{ asset(Storage::url('uploads/logo/')) . '/favicon.png' . '?timestamp=' . time() }}"
        type="image/png">

    @if ($setting['cust_darklayout'] == 'on')
        @if (isset($setting['SITE_RTL']) && $setting['SITE_RTL'] == 'on')
            <link rel="stylesheet" href="{{ asset('assets/css/style-rtl.css') }}" id="main-style-link">
        @endif
        <link rel="stylesheet" href="{{ asset('assets/css/style-dark.css') }}">
    @else
        @if (isset($setting['SITE_RTL']) && $setting['SITE_RTL'] == 'on')
            <link rel="stylesheet" href="{{ asset('assets/css/style-rtl.css') }}" id="main-style-link">
        @else
            <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" id="main-style-link">
        @endif
    @endif
  
    @if (isset($setting['SITE_RTL']) && $setting['SITE_RTL'] == 'on')
        <link rel="stylesheet" href="{{ asset('custom/css/custom-auth-rtl.css') }}" id="main-style-link">
    @else
        <link rel="stylesheet" href="{{ asset('custom/css/custom-auth.css') }}" id="main-style-link">
    @endif
    @if ($setting['cust_darklayout'] == 'on')
        <link rel="stylesheet" href="{{ asset('custom/css/custom-auth-dark.css') }}" id="main-style-link">
    @endif

    <style>
        :root {
            --color-customColor: <?= $color ?>;    
        }
    </style>

    <link rel="stylesheet" href="{{ asset('css/custom-color.css') }}">
</head>

<body class="{{ $themeColor }}">
    <!-- [custom-login] start -->
    <div class="custom-login">
        <div class="login-bg-img">
            <img src="{{ isset($setting['color_flag']) && $setting['color_flag'] == 'false' ? asset('assets/images/auth/'.$color.'.svg') : asset('assets/images/auth/theme-1.svg') }}" class="login-bg-1">
            <img src="{{ asset('assets/images/auth/common.svg') }}" class="login-bg-2">
        </div>
        <div class="bg-login bg-primary"></div>
        <div class="custom-login-inner">
            <header class="dash-header">
                <nav class="navbar navbar-expand-md default">
                    <div class="container">
                        <div class="navbar-brand">
                            <a href="#">
                                <img src="{{ $logo . $company_logo . '?timestamp=' . time() }}"
                                    alt="{{ config('app.name', 'Storego Saas') }}" alt="logo" loading="lazy"
                                    class="" height="40px" width="165px"/>{{--logo--}}
                            </a>
                        </div>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                            data-bs-target="#navbarlogin">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarlogin">
                            <ul class="navbar-nav align-items-center ms-auto mb-2 mb-lg-0">
                                @include('landingpage::layouts.buttons')
                                @yield('language-bar')
                            </ul>
                        </div>
                    </div>
                </nav>
            </header>
            <main class="custom-wrapper">
                <div class="custom-row">
                    <div class="card">
                        @yield('content')
                    </div>
                </div>
            </main>
            <footer>
                <div class="auth-footer">
                    <div class="container">
                        <div class="row">
                            <div class="col-12">
                                <span>&copy; {{ date('Y') }}
                                    {{ App\Models\Utility::getValByName('footer_text') ? App\Models\Utility::getValByName('footer_text') : config('app.name', 'Storego Saas') }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <!-- [custom-login] end -->

    <!-- Required Js -->
    @if ($settings['enable_cookie'] == 'on')
        @include('layouts.cookie_consent')
    @endif

    <script src="{{ asset('assets/js/vendor-all.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/feather.min.js') }}"></script>

    @stack('custom-scripts')

    <script>
        $(document).ready(function()
        {
            validation();
        });
        function validation() {
        
            var forms = document.querySelectorAll('.needs-validation');
            Array.prototype.forEach.call(forms, function (form) {
                form.addEventListener('submit', function (event) {
                    var submitButton = form.querySelector('button[type="submit"], input[type="submit"]');
                    if (submitButton) {
                        submitButton.disabled = true;
                    }
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                        if (submitButton) {
                            submitButton.disabled = false;
                        }
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }
    </script>
</body>
</html>
