@php
$data = DB::table('settings');
$data = $data
    ->where('created_by', '>', 1)
    ->where('store_id', $store->id)
    ->where('name', 'SITE_RTL')
    ->first(); 
    if(!isset($data)){
        $data = (object)[
            "name"=> "SITE_RTL",
            "value"=> "off"
            ];
    }
    $clang = session()->get('lang');
    if($clang == 'ar' || $clang == 'he'){
        $data->value = 'on';
    }
@endphp
<!DOCTYPE html>
<html lang="en" dir="{{ empty($data) ? '' : ($data->value == 'on' ? 'rtl' : '') }}">
@php
    $setting = DB::table('settings')
        ->where('name', 'company_favicon')
        ->where('store_id', $store->id)
        ->first();
    $settings = \App\Models\Utility::settings();
    $getStoreThemeSetting = \App\Models\Utility::getStoreThemeSetting($store->id, $store->theme_dir);
    $getStoreThemeSetting1 = [];
    if (!empty($getStoreThemeSetting['dashboard'])) {
        $getStoreThemeSetting = json_decode($getStoreThemeSetting['dashboard'], true);
        $getStoreThemeSetting1 = \App\Models\Utility::getStoreThemeSetting($store->id, $store->theme_dir);
    }
    if (empty($getStoreThemeSetting)) {
        $path = storage_path() . '/uploads/' . $store->theme_dir . '/' . $store->theme_dir . '.json';
        $getStoreThemeSetting = json_decode(file_get_contents($path), true);
    }
    $imgpath = \App\Models\Utility::get_file('uploads/');
    $s_logo = \App\Models\Utility::get_file('uploads/store_logo/');
    $brand_logo = \App\Models\Utility::get_file('uploads/theme8/brand_logo/');
    $metaImage = \App\Models\Utility::get_file('uploads/metaImage');
    $themeClass = $store->store_theme;
    $theme_name = $store->theme_dir;
    $storethemesetting1 = Utility::demoStoreThemeSetting($store->id, $store->theme_dir);
    if (!empty(session()->get('lang'))) {
        $currantLang = session()->get('lang');
    } else {
        $currantLang = $store->lang;
    }
    $languages = \App\Models\Utility::languages();
    $langName = \App\Models\Languages::where('code', $currantLang)->first();
@endphp
<head>
    
    @include('storefront.partials.head')

</head>

<body class="{{ !empty($themeClass)? $themeClass : 'theme8-v1' }}">
    <div class="overlay"></div>

    <header class="site-header">
        <div class="main-navigationbar sticky_header" id="header-sticky">
            <div class="container">
                <div class="navigationbar-row flex align-center justify-between">
                    <div class="menu-item-left menu-items-col desk-only">
                        <ul class="main-nav flex align-center">
                            <li class="menu-lnk">
                                <a href="{{ route('store.slug', $store->slug) }}">{{ ucfirst($store->name) }}</a>
                            </li>
                            @if (!empty($page_slug_urls))
                                @foreach ($page_slug_urls as $k => $page_slug_url)
                                    @if ($page_slug_url->enable_page_header == 'on')
                                        <li class="menu-lnk">
                                            <a
                                                href="{{ route('pageoption.slug', $page_slug_url->slug) }}">{{ ucfirst($page_slug_url->name) }}</a>
                                        </li>
                                    @endif
                                @endforeach
                            @endif
                            
                            @if ($store['blog_enable'] == 'on' && !empty($blog))
                                <li class="menu-lnk">
                                    <a href="{{ route('store.blog', $store->slug) }}">{{ __('Blog') }}</a>
                                </li>
                            @endif
                        </ul>
                    </div>
                    <div class="logo-col">
                        <h1>
                            <a href="{{ route('store.slug', $store->slug) }}">
                                <img src="{{ (!empty($store->logo) ? $s_logo . $store->logo : ($brand_logo . 'brand_logo.png')) . '?timestamp='. time() }}" alt="logo" id="navbar-logo">
                            </a>
                        </h1>
                    </div>
                    <div class="menu-item-right flex align-center justify-end">
                        <ul class="menu-item-wrp flex align-center">
                            <li class="search-header search-icon">
                                <a href="javascript:;" tabindex="0">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M11.5 21C16.7467 21 21 16.7467 21 11.5C21 6.2533 16.7467 2 11.5 2C6.2533 2 2 6.2533 2 11.5C2 16.7467 6.2533 21 11.5 21Z"
                                            stroke="#202126" stroke-width="1.5" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                        <path d="M22 22L20 20" stroke="#202126" stroke-width="1.5"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </a>
                            </li>
                            @if (Utility::CustomerAuthCheck($store->slug) == true)
                                <li class="wishlist-header">
                                    <a href="{{ route('store.wishlist', $store->slug) }}">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M12.62 20.8096C12.28 20.9296 11.72 20.9296 11.38 20.8096C8.48 19.8196 2 15.6896 2 8.68961C2 5.59961 4.49 3.09961 7.56 3.09961C9.38 3.09961 10.99 3.97961 12 5.33961C13.01 3.97961 14.63 3.09961 16.44 3.09961C19.51 3.09961 22 5.59961 22 8.68961C22 15.6896 15.52 19.8196 12.62 20.8096Z"
                                                stroke="#202126" stroke-width="1.5" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                        </svg>
                                        <span class="count wishlist_count">{{ !empty($wishlist) ? count($wishlist) : '0' }}</span>
                                    </a>
                                </li>
                            @endif
                            <li class="cart-header">
                                <a href="{{ route('store.cart', $store->slug) }}" class="main-cart flex align-center">
                                    <div class="cart-icon">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M7.5 7.66952V6.69952C7.5 4.44952 9.31 2.23952 11.56 2.02952C14.24 1.76952 16.5 3.87952 16.5 6.50952V7.88952"
                                                stroke="#202126" stroke-width="1.5" stroke-miterlimit="10"
                                                stroke-linecap="round" stroke-linejoin="round" />
                                            <path
                                                d="M9.0008 22H15.0008C19.0208 22 19.7408 20.39 19.9508 18.43L20.7008 12.43C20.9708 9.99 20.2708 8 16.0008 8H8.0008C3.7308 8 3.0308 9.99 3.3008 12.43L4.0508 18.43C4.2608 20.39 4.9808 22 9.0008 22Z"
                                                stroke="#202126" stroke-width="1.5" stroke-miterlimit="10"
                                                stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M15.4945 12H15.5035" stroke="#202126" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M8.49451 12H8.50349" stroke="#202126" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <span class="count shoping_counts"
                                            id="shoping_counts">{{ !empty($total_item) ? $total_item : '0' }}</span>
                                    </div>
                                </a>
                            </li>
                            <li class="mobile-menu mobile-only">
                                <button class="mobile-menu-button">
                                    <div class="one"></div>
                                    <div class="two"></div>
                                    <div class="three"></div>
                                </button>
                            </li>
                        </ul>
                        <div class="header-select-wrp flex align-center">
                            <div class="languages">
                                <div class="nice-select">
                                    <span class="current">{{ ucFirst($langName->fullName) }}</span>
                                    <div class="list-wrp">
                                        <ul class="list">
                                            @foreach ($languages as $code => $language)
                                                <li class="option @if ($code == $currantLang) selected focus @endif"><a href="{{ route('change.languagestore', [$store->slug, $code]) }}"
                                                        class="@if ($code == $currantLang) selected focus @endif">{{  ucFirst($language) }}</a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            @if (Utility::CustomerAuthCheck($store->slug) == true)
                                <li class="profile-header set has-children">
                                    <div class="nice-select">
                                        <a class="current">
                                            {{ __('My Dashboard') }}
                                        </a>
                                        <div class="list-wrp">
                                            <ul class="list">
                                                <li data-name="profile" class="option">
                                                    <a
                                                        href="{{ route('store.slug', $store->slug) }}">{{ __('My Dashboard') }}</a>
                                                </li>
                                                <li data-name="activity" class="option">
                                                    <a href="javascript:;" data-size="lg" class="edit-profile-btn profile-popup-btn mt-0"
                                                        data-url="{{ route('customer.profile', [$store->slug, \Illuminate\Support\Facades\Crypt::encrypt(Auth::guard('customers')->user()->id)]) }}"
                                                        data-profile-popup="true" data-title="{{ __('Edit Profile') }}"
                                                        data-toggle="modal">
                                                        {{ __('My Profile') }}
                                                    </a>
                                                </li>
                                                <li data-name="activity" class="option">
                                                    <a
                                                        href="{{ route('customer.home', $store->slug) }}">{{ __('My Orders') }}</a>
                                                </li>
                                                <li class="option">
                                                    @if (Utility::CustomerAuthCheck($store->slug) == false)
                                                        <a href="{{ route('customer.login', $store->slug) }}">
                                                            {{ __('Sign in') }}
                                                        </a>
                                                    @else
                                                        <a href="#"
                                                            onclick="event.preventDefault(); document.getElementById('customer-frm-logout').submit();"
                                                            class="nav-link">
                                                            {{ __('Logout') }}
                                                        </a>
                                                        <form id="customer-frm-logout"
                                                            action="{{ route('customer.logout', $store->slug) }}"
                                                            method="POST" class="d-none">
                                                            {{ csrf_field() }}
                                                        </form>
                                                    @endif
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </li>
                            @else
                                <li class="profile-header set has-children">
                                    <a href="{{ route('customer.login', $store->slug) }}" class="acnav-label btn">
                                        <span class="login-text" style="display: block;">{{ __('Log in') }}</span>
                                    </a>
                                </li>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    
    @yield('content')

    <footer class="site-footer" style="background-image: url({{ $imgpath . 'theme8/footer/footer-bg.png'}});">
        <div class="container">
            @if (!empty($getStoreThemeSetting[8]))
                @if ($getStoreThemeSetting[8]['section_enable'] == 'on')
                    <div class="footer-row flex">
                        <div class="footer-col">
                            <div class="footer-widget set has-children1">
                                <div class="footer-logo">
                                    <a href="{{ route('store.slug', $store->slug) }}" tabindex="0">
                                        <img src="{{ $imgpath . $getStoreThemeSetting[8]['inner-list'][0]['field_default_text'] }}" alt="logo" loading="lazy">
                                    </a>
                                </div>
                                <p>{{ $getStoreThemeSetting[8]['inner-list'][1]['field_default_text'] }}</p>
                                @if (Utility::CustomerAuthCheck($store->slug) == true)
                                    <a href="javascript:;" data-size="lg"
                                        data-url="{{ route('customer.profile', [$store->slug, \Illuminate\Support\Facades\Crypt::encrypt(Auth::guard('customers')->user()->id)]) }}"
                                        data-profile-popup="true" data-title="{{ __('Edit Profile') }}"
                                        data-toggle="modal">
                                        <button class="btn edit-profile-btn profile-popup-btn">
                                            {{ __('Edit Profile') }}
                                        </button>
                                    </a>
                                @endif
                                @if ($getStoreThemeSetting[15]['section_enable'] == 'on')
                                    <ul class="footer-social-icon flex align-center">
                                        @if (isset($getStoreThemeSetting[16]['homepage-footer-2-social-icon']) || isset($getStoreThemeSetting[16]['homepage-footer-2-social-link']))
                                            @if (isset($getStoreThemeSetting[16]['inner-list'][1]['field_default_text']) && isset($getStoreThemeSetting[16]['inner-list'][0]['field_default_text']))
                                                @foreach ($getStoreThemeSetting[16]['homepage-footer-2-social-icon'] as $icon_key => $storethemesettingicon)
                                                    @foreach ($getStoreThemeSetting[16]['homepage-footer-2-social-link'] as $link_key => $storethemesettinglink)
                                                        @if ($icon_key == $link_key)
                                                            <li>
                                                                <a href="{{ $storethemesettinglink }}" target="_blank" class="flex align-center justify-center">
                                                                    {!! $storethemesettingicon !!}
                                                                </a>
                                                            </li>
                                                        @endif
                                                    @endforeach
                                                @endforeach
                                            @endif
                                        @else
                                            @for ($i = 0; $i < $getStoreThemeSetting[16]['loop_number']; $i++)
                                                @if (isset($getStoreThemeSetting[16]['inner-list'][1]['field_default_text']) && isset($getStoreThemeSetting[16]['inner-list'][0]['field_default_text']))
                                                    <li>
                                                        <a href="{{ $getStoreThemeSetting[16]['inner-list'][1]['field_default_text'] }}" target="_blank" class="flex align-center justify-center">
                                                            {!! $getStoreThemeSetting[16]['inner-list'][0]['field_default_text'] !!}
                                                        </a>
                                                    </li>
                                                @endif
                                            @endfor
                                        @endif
                                    </ul>
                                @endif
                            </div>
                        </div>
                        @foreach ($getStoreThemeSetting as $key => $storethemesetting)
                            @foreach ($storethemesetting['inner-list'] as $keyy => $theme)
                                @if ($theme['field_name'] == 'Enable Quick Link 1')
                                    @if ($getStoreThemeSetting[9]['inner-list'][0]['field_default_text'] == 'on')
                                        @if (!empty($getStoreThemeSetting[9]))
                                            @if ((isset($getStoreThemeSetting[9]['section_enable']) && $getStoreThemeSetting[9]['section_enable'] == 'on') || $getStoreThemeSetting[9]['inner-list'][1]['field_default_text'])
                                                <div class="footer-col footer-link">
                                                    <div class="footer-widget set has-children1">
                                                        <h2 class="footer-acnav">
                                                            <span>{{ __($getStoreThemeSetting[9]['inner-list'][1]['field_default_text']) }}</span>
                                                            <svg xmlns="http://www.w3.org/2000/svg" version="1.2" viewBox="0 0 10 5" width="10"
                                                                height="5">
                                                                <path class="a"
                                                                    d="m5.4 5.1q-0.3 0-0.5-0.2l-3.7-3.7c-0.3-0.3-0.3-0.7 0-1 0.2-0.3 0.7-0.3 0.9 0l3.3 3.2 3.2-3.2c0.2-0.3 0.7-0.3 0.9 0 0.3 0.3 0.3 0.7 0 1l-3.7 3.7q-0.2 0.2-0.4 0.2z">
                                                                </path>
                                                            </svg>
                                                        </h2>
                                                        <ul class="footer-acnav-list">
                                                            @if (isset($getStoreThemeSetting[10]['homepage-header-quick-link-name-1'], $getStoreThemeSetting[10]['homepage-header-quick-link-1']))
                                                                @foreach ($getStoreThemeSetting[10]['homepage-header-quick-link-name-1'] as $name_key => $storethemesettingname)
                                                                    @foreach ($getStoreThemeSetting[10]['homepage-header-quick-link-1'] as $link_key => $storethemesettinglink)
                                                                        @if ($name_key == $link_key)
                                                                            <li>
                                                                                <a href="{{ $storethemesettinglink }}">{{ $storethemesettingname }}</a>
                                                                            </li>
                                                                        @endif
                                                                    @endforeach
                                                                @endforeach
                                                            @else
                                                                @for ($i = 0; $i < $getStoreThemeSetting[10]['loop_number']; $i++)
                                                                    <li>
                                                                        <a href="{{ $getStoreThemeSetting[10]['inner-list'][1]['field_default_text'] }}"> {{ $getStoreThemeSetting[10]['inner-list'][0]['field_default_text'] }}</a>
                                                                    </li>
                                                                @endfor
                                                            @endif
                                                        </ul>
                                                    </div>
                                                </div>
                                            @endif
                                        @endif
                                    @endif
                                    @if ($getStoreThemeSetting[11]['inner-list'][0]['field_default_text'] == 'on')
                                        @if (!empty($getStoreThemeSetting[11]))
                                            @if ((isset($getStoreThemeSetting[11]['section_enable']) && $getStoreThemeSetting[11]['section_enable'] == 'on') || $getStoreThemeSetting[11]['inner-list'][1]['field_default_text'])
                                                <div class="footer-col footer-link">
                                                    <div class="footer-widget set has-children1">
                                                        <h2 class="footer-acnav">
                                                            <span>{{ __($getStoreThemeSetting[11]['inner-list'][1]['field_default_text']) }}</span>
                                                            <svg xmlns="http://www.w3.org/2000/svg" version="1.2" viewBox="0 0 10 5" width="10"
                                                                height="5">
                                                                <path class="a"
                                                                    d="m5.4 5.1q-0.3 0-0.5-0.2l-3.7-3.7c-0.3-0.3-0.3-0.7 0-1 0.2-0.3 0.7-0.3 0.9 0l3.3 3.2 3.2-3.2c0.2-0.3 0.7-0.3 0.9 0 0.3 0.3 0.3 0.7 0 1l-3.7 3.7q-0.2 0.2-0.4 0.2z">
                                                                </path>
                                                            </svg>
                                                        </h2>
                                                        <ul class="footer-acnav-list">
                                                            @if (isset($getStoreThemeSetting[12]['homepage-header-quick-link-name-2'], $getStoreThemeSetting[12]['homepage-header-quick-link-2']))
                                                                @foreach ($getStoreThemeSetting[12]['homepage-header-quick-link-name-2'] as $name_key => $storethemesettingname)
                                                                    @foreach ($getStoreThemeSetting[12]['homepage-header-quick-link-2'] as $link_key => $storethemesettinglink)
                                                                        @if ($name_key == $link_key)
                                                                            <li>
                                                                                <a href="{{ $storethemesettinglink }}">{{ $storethemesettingname }}</a>
                                                                            </li>
                                                                        @endif
                                                                    @endforeach
                                                                @endforeach
                                                            @else
                                                                @for ($i = 0; $i < $getStoreThemeSetting[12]['loop_number']; $i++)
                                                                <li>
                                                                    <a href="{{ $getStoreThemeSetting[12]['inner-list'][1]['field_default_text'] }}">{{ $getStoreThemeSetting[12]['inner-list'][0]['field_default_text'] }}</a>
                                                                </li>
                                                                @endfor
                                                            @endif
                                                        </ul>
                                                    </div>
                                                </div>
                                            @endif
                                        @endif
                                    @endif
                                    @if ($getStoreThemeSetting[13]['inner-list'][1]['field_default_text'] == 'on')
                                        @if (!empty($getStoreThemeSetting[13]))
                                            @if ((isset($getStoreThemeSetting[13]['section_enable']) && $getStoreThemeSetting[13]['section_enable'] == 'on') || $getStoreThemeSetting[13]['inner-list'][1]['field_default_text'])
                                                <div class="footer-col footer-link">
                                                    <div class="footer-widget set has-children1">
                                                        <h2 class="footer-acnav">
                                                            <span>{{ __($getStoreThemeSetting[13]['inner-list'][0]['field_default_text']) }}</span>
                                                            <svg xmlns="http://www.w3.org/2000/svg" version="1.2" viewBox="0 0 10 5" width="10"
                                                                height="5">
                                                                <path class="a"
                                                                    d="m5.4 5.1q-0.3 0-0.5-0.2l-3.7-3.7c-0.3-0.3-0.3-0.7 0-1 0.2-0.3 0.7-0.3 0.9 0l3.3 3.2 3.2-3.2c0.2-0.3 0.7-0.3 0.9 0 0.3 0.3 0.3 0.7 0 1l-3.7 3.7q-0.2 0.2-0.4 0.2z">
                                                                </path>
                                                            </svg>
                                                        </h2>
                                                        <ul class="footer-acnav-list">
                                                            @if (isset($getStoreThemeSetting[14]['homepage-header-quick-link-name-3'], $getStoreThemeSetting[14]['homepage-header-quick-link-3']))
                                                                @foreach ($getStoreThemeSetting[14]['homepage-header-quick-link-name-3'] as $name_key => $storethemesettingname)
                                                                    @foreach ($getStoreThemeSetting[14]['homepage-header-quick-link-3'] as $link_key => $storethemesettinglink)
                                                                        @if ($name_key == $link_key)
                                                                            <li>
                                                                                <a href="{{ $storethemesettinglink }}"> {{ $storethemesettingname }}</a>
                                                                            </li>
                                                                        @endif
                                                                    @endforeach
                                                                @endforeach
                                                            @else
                                                                @for ($i = 0; $i < $getStoreThemeSetting[14]['loop_number']; $i++)
                                                                    <li>
                                                                        <a href="{{ $getStoreThemeSetting[14]['inner-list'][1]['field_default_text'] }}"> {{ $getStoreThemeSetting[14]['inner-list'][0]['field_default_text'] }}</a>
                                                                    </li>
                                                                @endfor
                                                            @endif
                                                        </ul>
                                                    </div>
                                                </div>
                                            @endif
                                        @endif
                                    @endif
                                @endif
                            @endforeach
                        @endforeach
                        @foreach ($getStoreThemeSetting as $storethemesetting)
                            @if (isset($storethemesetting['section_name']) && $storethemesetting['section_name'] == 'Home-Email-Subscriber' && $storethemesetting['section_enable'] == 'on')
                                @php
                                    $SubscriberTitle_key = array_search('Subscriber Title', array_column($storethemesetting['inner-list'], 'field_name'));
                                    $SubscriberTitle = $storethemesetting['inner-list'][$SubscriberTitle_key]['field_default_text'];

                                    $SubscriberDescription_key = array_search('Subscriber Description', array_column($storethemesetting['inner-list'], 'field_name'));
                                    $SubscriberDescription = $storethemesetting['inner-list'][$SubscriberDescription_key]['field_default_text'];

                                    $SubscriberTitle_btn_key = array_search('Button', array_column($storethemesetting['inner-list'], 'field_name'));
                                    $SubscriberTitle_btn = $storethemesetting['inner-list'][$SubscriberTitle_btn_key]['field_default_text'];
                                @endphp
                                <div class="footer-col footer-link footer-subscribe-col">
                                    <div class="footer-widget set has-children1">
                                        <h2 class="footer-acnav">
                                            <span>{{ $SubscriberTitle }}</span>
                                            <svg xmlns="http://www.w3.org/2000/svg" version="1.2" viewBox="0 0 10 5" width="10"
                                                height="5">
                                                <path class="a"
                                                    d="m5.4 5.1q-0.3 0-0.5-0.2l-3.7-3.7c-0.3-0.3-0.3-0.7 0-1 0.2-0.3 0.7-0.3 0.9 0l3.3 3.2 3.2-3.2c0.2-0.3 0.7-0.3 0.9 0 0.3 0.3 0.3 0.7 0 1l-3.7 3.7q-0.2 0.2-0.4 0.2z">
                                                </path>
                                            </svg>
                                        </h2>
                                        <div class="footer-acnav-list">
                                            {{ Form::open(['route' => ['subscriptions.store_email', $store->id], 'method' => 'POST', 'class' => 'subscribe-form-wrapper']) }}
                                                <div class="input-wrapper flex">
                                                    {{ Form::email('email', null, [ 'placeholder' => __('Enter Your Email Address'), 'class' => 'form-control', 'required' => 'required']) }}
                                                </div>
                                                <button type="submit" class="subscribe-btn btn"><span>{{ $SubscriberTitle_btn }}</span></button>
                                            {{ Form::close() }}
                                            <p> {{ $SubscriberDescription }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                @endif
            @endif
        </div>
        @if ($getStoreThemeSetting[15]['section_enable'] == 'on')
            <div class="footer-bottom">
                <div class="container">
                    <div class="footer-bottom-inner text-center">
                        <p>{{ $getStoreThemeSetting[15]['inner-list'][0]['field_default_text'] }}</p>
                    </div>
                </div>
            </div>
        @endif
    </footer>
    @if ($getStoreThemeSetting[15]['section_enable'] == 'on')
        <script>
            {!! $getStoreThemeSetting[17]['inner-list'][0]['field_default_text'] !!}
        </script>
    @endif
    

    @include('storefront.partials.footer')

</html>
