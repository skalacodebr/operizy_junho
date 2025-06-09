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
    $brand_logo = \App\Models\Utility::get_file('uploads/theme4/brand_logo/');
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

<body class="{{ !empty($themeClass)? $themeClass : 'theme4-v1' }}">
    <div class="overlay"></div>
    
    <header class="site-header">
        <div class="main-navigationbar sticky_header" id="header-sticky">
            <div class="container">
                <div class="navigationbar-row flex align-center justify-between">
                    <div class="logo-col">
                        <h1>
                            <a href="{{ route('store.slug', $store->slug) }}">
                                <img src="{{ (!empty($store->logo) ? $s_logo . $store->logo : ($brand_logo . 'brand_logo.png')) . '?timestamp='. time() }}" alt="logo" id="navbar-logo">
                            </a>
                        </h1>
                    </div>
                    <div class="menu-item-left menu-items-col desk-only">
                        <ul class="main-nav flex align-center">
                            <li class="menu-lnk">
                                <a class="{{ route('store.slug') ?: 'text-dark' }} {{ Request::segment(1) == 'store-blog' ? 'text-dark' : '' }}" href="{{ route('store.slug', $store->slug) }}">{{ ucfirst($store->name) }}</a>
                            </li>
                            @if (!empty($page_slug_urls))
                                @foreach ($page_slug_urls as $k => $page_slug_url)
                                    @if ($page_slug_url->enable_page_header == 'on')
                                        <li class="menu-lnk">
                                            <a href="{{ route('pageoption.slug', $page_slug_url->slug) }}">{{ ucfirst($page_slug_url->name) }}</a>
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
                    <div class="menu-item-right flex align-center justify-end">
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
                        <ul class="menu-item-wrp flex align-center">
                            <li class="search-header search-icon">
                                <a href="javascript:;" tabindex="0">
                                    <svg width="25" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M11.6875 21C16.9342 21 21.1875 16.7467 21.1875 11.5C21.1875 6.25329 16.9342 2 11.6875 2C6.44079 2 2.1875 6.25329 2.1875 11.5C2.1875 16.7467 6.44079 21 11.6875 21Z" stroke="#151515" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M22.1875 22L20.1875 20" stroke="#151515" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>                                                                                                                       
                                </a>
                            </li>
                            <li class="profile-header">
                                @if (Utility::CustomerAuthCheck($store->slug) == true)
                                    <div class="nice-select">
                                        <a class="current">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M12 12C14.7614 12 17 9.76142 17 7C17 4.23858 14.7614 2 12 2C9.23858 2 7 4.23858 7 7C7 9.76142 9.23858 12 12 12Z"
                                                    stroke="#202126" stroke-width="1.5" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                                <path
                                                    d="M20.5901 22C20.5901 18.13 16.7402 15 12.0002 15C7.26015 15 3.41016 18.13 3.41016 22"
                                                    stroke="#202126" stroke-width="1.5" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                            </svg>
                                        </a>
                                        <div class="list-wrp">
                                            <ul class="list">
                                                <li data-name="profile" class="option">
                                                    <a
                                                        href="{{ route('store.slug', $store->slug) }}">{{ __('My Dashboard') }}</a>
                                                </li>
                                                <li data-name="activity" class="option">
                                                    <a href="javascript:;" data-size="lg" class="edit-profile-btn profile-popup-btn"
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
                                @else
                                    <a href="{{ route('customer.login', $store->slug) }}" class="">
                                        <span class="login-text" style="display: block;">{{ __('Log in') }}</span>
                                    </a>
                                @endif
                            </li>
                            @if (Utility::CustomerAuthCheck($store->slug) == true)
                                <li class="wishlist-header">
                                    <a href="{{ route('store.wishlist', $store->slug) }}">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M12.62 20.8096C12.28 20.9296 11.72 20.9296 11.38 20.8096C8.48 19.8196 2 15.6896 2 8.68961C2 5.59961 4.49 3.09961 7.56 3.09961C9.38 3.09961 10.99 3.97961 12 5.33961C13.01 3.97961 14.63 3.09961 16.44 3.09961C19.51 3.09961 22 5.59961 22 8.68961C22 15.6896 15.52 19.8196 12.62 20.8096Z" stroke="#202126" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                        </svg>
                                        <span class="count wishlist_count">{{ !empty($wishlist) ? count($wishlist) : '0' }}</span>
                                    </a>
                                </li>
                            @endif
                            <li class="cart-header">
                                <a href="{{ route('store.cart', $store->slug) }}" class="main-cart flex align-center" tabindex="0">
                                    <div class="cart-icon">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M7.5 7.66952V6.69952C7.5 4.44952 9.31 2.23952 11.56 2.02952C14.24 1.76952 16.5 3.87952 16.5 6.50952V7.88952" stroke="#202126" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
                                            <path d="M9.0008 22H15.0008C19.0208 22 19.7408 20.39 19.9508 18.43L20.7008 12.43C20.9708 9.99 20.2708 8 16.0008 8H8.0008C3.7308 8 3.0308 9.99 3.3008 12.43L4.0508 18.43C4.2608 20.39 4.9808 22 9.0008 22Z" stroke="#202126" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
                                            <path d="M15.4945 12H15.5035" stroke="#202126" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                            <path d="M8.49451 12H8.50349" stroke="#202126" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                        </svg>
                                        <span class="count shoping_counts" id="shoping_counts">{{ !empty($total_item) ? $total_item : '0' }}</span>
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
                    </div>
                </div>
            </div>
        </div>
    </header>

    @yield('content')

    <footer class="site-footer">
        <div class="footer-row">
            <div class="container">
                <div class="footer-col flex justify-center text-center">
                    <div class="footer-logo">
                        @if ($getStoreThemeSetting[6]['section_enable'] == 'on')
                            <a href="{{ route('store.slug', $store->slug) }}">
                                @if (!empty($getStoreThemeSetting[6]))
                                    <img src="{{ $imgpath. $getStoreThemeSetting[6]['inner-list'][0]['field_default_text'] }}" alt="logo" loading="lazy">
                                @endif
                            </a>
                        @endif
                    </div>
                    @if ($getStoreThemeSetting[6]['section_enable'] == 'on')
                        <ul class="footer-acnav-list flex align-center justify-center">
                            @if (!empty($getStoreThemeSetting[7]['inner-list'][0]['field_default_text']) && $getStoreThemeSetting[7]['inner-list'][0]['field_default_text'] == 'on')
                                @if (isset($getStoreThemeSetting[8]['homepage-header-quick-link-name-1']) || isset($getStoreThemeSetting[8]['homepage-header-quick-link-1']))
                                    <li>
                                        <a href="{{ $getStoreThemeSetting[8]['homepage-header-quick-link-1'][0] }}"> {{ $getStoreThemeSetting[8]['homepage-header-quick-link-name-1'][0] }}</a>
                                    </li>
                                @else
                                    <li>
                                        <a href="{{ $getStoreThemeSetting[8]['inner-list'][1]['field_default_text'] }}">{{ $getStoreThemeSetting[8]['inner-list'][0]['field_default_text'] }}</a>
                                    </li>
                                @endif
                            @endif
                            @if (!empty($getStoreThemeSetting[9]['inner-list'][0]['field_default_text']) && $getStoreThemeSetting[9]['inner-list'][0]['field_default_text'] == 'on')
                                @if (isset($getStoreThemeSetting[10]['homepage-header-quick-link-name-2']) || isset($getStoreThemeSetting[10]['homepage-header-quick-link-2']))
                                    <li>
                                        <a href="{{ $getStoreThemeSetting[10]['homepage-header-quick-link-2'][0] }}"> {{ $getStoreThemeSetting[10]['homepage-header-quick-link-name-2'][0] }}</a>
                                    </li>
                                @else
                                <li>
                                    <a href="{{ $getStoreThemeSetting[10]['inner-list'][1]['field_default_text'] }}">{{ $getStoreThemeSetting[10]['inner-list'][0]['field_default_text'] }}</a>
                                </li>
                                @endif
                            @endif
                            @if (!empty($getStoreThemeSetting[11]['inner-list'][0]['field_default_text']) && $getStoreThemeSetting[11]['inner-list'][0]['field_default_text'] == 'on')
                                @if (isset($getStoreThemeSetting[12]['homepage-header-quick-link-name-3']) || isset($getStoreThemeSetting[12]['homepage-header-quick-link-3']))
                                    <li>
                                        <a href="{{ $getStoreThemeSetting[12]['homepage-header-quick-link-3'][0] }}"> {{ $getStoreThemeSetting[12]['homepage-header-quick-link-name-3'][0] }}</a>
                                    </li>
                                @else
                                    <li>
                                        <a href="{{ $getStoreThemeSetting[12]['inner-list'][1]['field_default_text'] }}">{{ $getStoreThemeSetting[12]['inner-list'][0]['field_default_text'] }}</a>
                                    </li>
                                @endif
                            @endif
                            @if (!empty($getStoreThemeSetting[13]['inner-list'][0]['field_default_text']) && $getStoreThemeSetting[13]['inner-list'][0]['field_default_text'] == 'on')
                                @if (isset($getStoreThemeSetting[14]['homepage-header-quick-link-name-4']) || isset($getStoreThemeSetting[14]['homepage-header-quick-link-4']))
                                    <li>
                                        <a href="{{ $getStoreThemeSetting[14]['homepage-header-quick-link-4'][0] }}">{{ $getStoreThemeSetting[14]['homepage-header-quick-link-name-4'][0] }}</a>
                                    </li>
                                @else
                                    <li>
                                        <a href="{{ $getStoreThemeSetting[14]['inner-list'][1]['field_default_text'] }}">{{ $getStoreThemeSetting[14]['inner-list'][0]['field_default_text'] }}</a>
                                    </li>
                                @endif
                            @endif
                        </ul>
                    @endif
                    @if ($getStoreThemeSetting[15]['section_enable'] == 'on')
                        <ul class="footer-social-icon flex align-center justify-center">
                            @if (isset($getStoreThemeSetting[15]['homepage-footer-2-social-icon']) || isset($getStoreThemeSetting[15]['homepage-footer-2-social-link']))
                                @if (isset($getStoreThemeSetting[15]['inner-list'][1]['field_default_text']) && isset($getStoreThemeSetting[15]['inner-list'][0]['field_default_text']))
                                    @foreach ($getStoreThemeSetting[15]['homepage-footer-2-social-icon'] as $icon_key => $storethemesettingicon)
                                        @foreach ($getStoreThemeSetting[15]['homepage-footer-2-social-link'] as $link_key => $storethemesettinglink)
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
                                @for ($i = 0; $i < $getStoreThemeSetting[15]['loop_number']; $i++)
                                    @if (isset($getStoreThemeSetting[15]['inner-list'][1]['field_default_text']) && isset($getStoreThemeSetting[15]['inner-list'][0]['field_default_text']))
                                        <li>
                                            <a href="{{ $getStoreThemeSetting[15]['inner-list'][1]['field_default_text'] }}" target="_blank" class="flex align-center justify-center">
                                                {!! $getStoreThemeSetting[15]['inner-list'][0]['field_default_text'] !!}
                                            </a>
                                        </li>
                                    @endif
                                @endfor
                            @endif
                        </ul>
                    @endif
                    @if (Utility::CustomerAuthCheck($store->slug) == true)
                        <div class="edit-profile-btn flex align-center justify-center">
                            <a href="javascript:;" data-size="lg"
                                data-url="{{ route('customer.profile', [$store->slug, \Illuminate\Support\Facades\Crypt::encrypt(Auth::guard('customers')->user()->id)]) }}"
                                data-profile-popup="true" data-title="{{ __('Edit Profile') }}"
                                data-toggle="modal">
                                <button class="btn profile-popup-btn">
                                    {{ __('Edit Profile') }}
                                </button>
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        @if ($getStoreThemeSetting[15]['section_enable'] == 'on')
            <div class="footer-bottom">
                <div class="container">
                    <div class="footer-bottom-inner text-center">
                        <p> {{ $getStoreThemeSetting[16]['inner-list'][0]['field_default_text'] }}</p>
                    </div>
                </div>
            </div>
        @endif
    </footer> 
    @if ($getStoreThemeSetting[15]['section_enable'] == 'on')
        <script>
            {!! $getStoreThemeSetting[16]['inner-list'][1]['field_default_text'] !!}
        </script>
    @endif
    

    @include('storefront.partials.footer')
    
</body>

</html>
