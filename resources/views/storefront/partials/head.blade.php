<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="author" content="WorkDo.io">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0" />
<title>@yield('page-title') - {{ $store->tagline ? $store->tagline : env('APP_NAME', ucfirst($store->name)) }} </title>
<!-- Primary Meta Tags -->
<meta name="title" content="{{ $store->metakeyword }}">
<meta name="description" content="{{ ucfirst($store->metadesc) }}">
<meta name="keywords" content="{{ $store->metakeyword }}">

<!-- Open Graph / Facebook -->
<meta property="og:type" content="website">
<meta property="og:url" content="{{ route('store.slug',$store->slug) }}">
<meta property="og:title" content="{{ $store->metakeyword }}">
<meta property="og:description" content="{{ ucfirst($store->metadesc) }}">
<meta property="og:image" content="{{ $metaImage .'/'. $store->metaimage }}">

<!-- Twitter -->
<meta property="twitter:card" content="summary_large_image">
<meta property="twitter:url" content="{{ route('store.slug',$store->slug) }}">
<meta property="twitter:title" content="{{ $store->metakeyword }}">
<meta property="twitter:description" content="{{ ucfirst($store->metadesc) }}">
<meta property="twitter:image" content="{{ $metaImage .'/'. $store->metaimage }}">

<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="shortcut icon" href="{{ asset('assets/' . $theme_name . '/images/favicon.png') }}">
<link rel="icon"
    href="{{ asset(Storage::url('uploads/logo/') . (!empty($setting->value) ? $setting->value : 'favicon.png' . '?timestamp='. time())) }}"
    type="image/png">
<link rel="stylesheet" href="{{ asset('assets/' . $theme_name . '/fonts/fontawesome-free/css/all.min.css') }}">

@if (isset($data->value) && $data->value == 'on')
    <link rel="stylesheet" href="{{ asset('assets/' . $theme_name . '/css/rtl-main-style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/' . $theme_name . '/css/rtl-responsive.css') }}">
@else
    <link rel="stylesheet" href="{{ asset('assets/' . $theme_name . '/css/main-style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/' . $theme_name . '/css/responsive.css') }}">
@endif

{{-- pwa customer app --}}
<meta name="mobile-wep-app-capable" content="yes">
<meta name="apple-mobile-wep-app-capable" content="yes">
<meta name="msapplication-starturl" content="/">
<link rel="apple-touch-icon"
    href="{{ asset(Storage::url('uploads/logo/') . (!empty($setting->value) ? $setting->value : 'favicon.png' . '?timestamp='. time())) }}" />
@if ($store->enable_pwa_store == 'on')
    <link rel="manifest" href="{{ asset('storage/uploads/customer_app/store_' . $store->id . '/manifest.json') }}" />
@endif

@if (!empty($pwa->theme_color))
    <meta name="theme-color" content="{{ $pwa->theme_color }}" />
@endif
@if (!empty($pwa->background_color))
    <meta name="apple-mobile-web-app-status-bar"
        content="{{ $pwa->background_color }}" />
@endif

<style>
    .text-danger{
        color: red;
    }
</style>

@stack('css-page')
