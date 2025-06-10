@php
    use App\Models\Utility;
    $settings = \Modules\LandingPage\Entities\LandingPageSetting::settings();
    $logo  =  Utility::get_file('uploads/landing_page_image');
    $sup_logo  =  Utility::get_file('uploads/logo');
    $adminSettings = Utility::settings();
    $setting = \App\Models\Utility::colorset();
    $SITE_RTL = Utility::getValByName('SITE_RTL');
    // $color = (!empty($setting['color'])) ? $setting['color'] : 'theme-3';
    $admin_payment_setting = Utility::getAdminPaymentSetting();
 //   $getseo= App\Models\Utility::getSeoSetting();
 //   $metatitle =  isset($getseo['meta_title']) ? $getseo['meta_title'] :'';
 //   $metsdesc= isset($getseo['meta_desc'])?$getseo['meta_desc']:'';
  //  $meta_image = \App\Models\Utility::get_file('uploads/meta/');
 //   $meta_logo = isset($getseo['meta_image'])?$getseo['meta_image']:'';
   // $get_cookie = Utility::getCookieSetting();
   $color = !empty($setting['color']) ? $setting['color'] : 'theme-3';

    if(isset($setting['color_flag']) && $setting['color_flag'] == 'true')
    {
        $themeColor = 'custom-color';
    }
    else {
        $themeColor = $color;
    }
    $lang = \App::getLocale('lang');
    if ($lang == 'ar' || $lang == 'he') {
        $setting['SITE_RTL'] = 'on';
    }
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"  dir="{{$setting['SITE_RTL'] == 'on'?'rtl':''}}">

<head>
    <title>{{ env('APP_NAME') }}</title>
    <!-- Meta -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui" />

    {{--  <meta name="title" content="{{$metatitle}}">
    <meta name="description" content="{{$metsdesc}}">  --}}

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ env('APP_URL') }}">
    {{--  <meta property="og:title" content="{{$metatitle}}">
    <meta property="og:description" content="{{$metsdesc}}">
    <meta property="og:image" content="{{$meta_image.$meta_logo}}">  --}}

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ env('APP_URL') }}">
    {{--  <meta property="twitter:title" content="{{$metatitle}}">
    <meta property="twitter:description" content="{{$metsdesc}}">
    <meta property="twitter:image" content="{{$meta_image.$meta_logo}}">  --}}

    <!-- Favicon icon -->
    <link rel="icon" href="{{ $sup_logo.'/favicon.png' . '?timestamp='. time() }}" type="image/x-icon" />

    <!-- font css -->
    <link rel="stylesheet" href=" {{ asset('assets/fonts/tabler-icons.min.css')}}" />
    <link rel="stylesheet" href=" {{ asset('assets/fonts/feather.css')}}" />
    <link rel="stylesheet" href="  {{ asset('assets/fonts/fontawesome.css')}}" />
    <link rel="stylesheet" href="{{ asset('assets/fonts/material.css')}}" />

    <!-- vendor css -->
    <link rel="stylesheet" href="  {{ asset('assets/css/style.css')}}" />
    <link rel="stylesheet" href=" {{ asset('assets/css/customizer.css')}}" />
    <link rel="stylesheet" href=" {{ asset('assets/landingpage/css/landing-page.css')}}" />
    <link rel="stylesheet" href=" {{ asset('assets/landingpage/css/custom.css')}}" />

    {{-- @if ($SITE_RTL == 'on')
    <link rel="stylesheet" href="{{ asset('assets/css/style-rtl.css') }}">
    @endif
    @if ($setting['cust_darklayout'] == 'on')
        <link rel="stylesheet" href="{{ asset('assets/css/style-dark.css') }}">
    @else
        <link rel="stylesheet" href="{{ asset('assets/css/style.css')}}" id="main-style-link">
    @endif --}}
    @if ($setting['cust_darklayout'] == 'on')
        @if ($SITE_RTL == 'on')
            <link rel="stylesheet" href="{{ asset('assets/css/style-rtl.css') }}">
        @endif
        <link rel="stylesheet" href="{{ asset('assets/css/style-dark.css') }}">
    @else
        @if ($SITE_RTL == 'on')
            <link rel="stylesheet" href="{{ asset('assets/css/style-rtl.css') }}">
        @else
            <link rel="stylesheet" href="{{ asset('assets/css/style.css')}}" id="main-style-link">
        @endif
    @endif

    <style>
        :root {
            --color-customColor: <?= $color ?>;    
        }

        [dir="rtl"] .site-footer .footer-row .ftr-subscribe form .input-wrapper input {
            padding: 15px 15px 15px 105px;
        }
        [dir="rtl"] .site-footer .footer-row .ftr-subscribe form .input-wrapper .btn {
            left: 5px;
            right: auto;
        }
        [dir="rtl"] .site-footer .footer-row .ftr-col:not(:first-of-type) {
            padding-right: 60px;
        }
        @media only screen and (max-width: 767px){
            [dir="rtl"] .site-footer .footer-row .ftr-col:not(:first-of-type) {
                padding-right: 0;
                margin-top: 15px;
            }
        }
    </style>

    <link rel="stylesheet" href="{{ asset('css/custom-color.css') }}">

</head>
<body>


    <script src="{{ asset('assets/js/plugins/popper.min.js')}}"></script>
    <script src="{{ asset('assets/js/plugins/bootstrap.min.js')}}"></script>
    <script src="{{ asset('assets/js/plugins/feather.min.js')}}"></script>

    <script>
  document.addEventListener('DOMContentLoaded', () => {
    // Redireciona para /login
    window.location.replace('/login');
  });
</script>

</body>

</html>
