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
    $brand_logo = \App\Models\Utility::get_file('uploads/theme5/brand_logo/');
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

<body class="{{ !empty($themeClass)? $themeClass : 'theme5-v1' }}">
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
                    <div class="menu-item-right flex align-center justify-end">
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
                        </div>
                        <ul class="menu-item-wrp flex align-center">
                            <li class="search-header search-icon">
                                <a href="javascript:;" tabindex="0">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M11.5 21C16.7467 21 21 16.7467 21 11.5C21 6.2533 16.7467 2 11.5 2C6.2533 2 2 6.2533 2 11.5C2 16.7467 6.2533 21 11.5 21Z"
                                            stroke="#4C3B2F" stroke-width="1.5" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                        <path d="M22 22L20 20" stroke="#4C3B2F" stroke-width="1.5"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </a>
                            </li>
                            @if (Utility::CustomerAuthCheck($store->slug) == true)
                                <li class="profile-header set has-children">
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
                                <li class="profile-header">
                                    <a href="{{ route('customer.login', $store->slug) }}" class="acnav-label">
                                        <span class="login-text" style="display: block;">{{ __('Log in') }}</span>
                                    </a>
                                </li>
                            @endif
                            
                            @if (Utility::CustomerAuthCheck($store->slug) == true)
                                <li class="wishlist-header">
                                    <a href="{{ route('store.wishlist', $store->slug) }}" tabindex="0">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M12.62 20.8096C12.28 20.9296 11.72 20.9296 11.38 20.8096C8.48 19.8196 2 15.6896 2 8.68961C2 5.59961 4.49 3.09961 7.56 3.09961C9.38 3.09961 10.99 3.97961 12 5.33961C13.01 3.97961 14.63 3.09961 16.44 3.09961C19.51 3.09961 22 5.59961 22 8.68961C22 15.6896 15.52 19.8196 12.62 20.8096Z"
                                                stroke="#4C3B2F" stroke-width="1.5" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                        </svg>
                                        <span class="count wishlist_count">{{ !empty($wishlist) ? count($wishlist) : '0' }}</span>
                                    </a>
                                </li>
                            @endif
                            <li class="cart-header">
                                <a href="{{ route('store.cart', $store->slug) }}" class="main-cart flex align-center" tabindex="0">
                                    <div class="cart-icon">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M7.5 7.66952V6.69952C7.5 4.44952 9.31 2.23952 11.56 2.02952C14.24 1.76952 16.5 3.87952 16.5 6.50952V7.88952"
                                                stroke="#4C3B2F" stroke-width="1.5" stroke-miterlimit="10"
                                                stroke-linecap="round" stroke-linejoin="round" />
                                            <path
                                                d="M9.0008 22H15.0008C19.0208 22 19.7408 20.39 19.9508 18.43L20.7008 12.43C20.9708 9.99 20.2708 8 16.0008 8H8.0008C3.7308 8 3.0308 9.99 3.3008 12.43L4.0508 18.43C4.2608 20.39 4.9808 22 9.0008 22Z"
                                                stroke="#4C3B2F" stroke-width="1.5" stroke-miterlimit="10"
                                                stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M15.4945 12H15.5035" stroke="#4C3B2F" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M8.49451 12H8.50349" stroke="#4C3B2F" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round" />
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
        @if ($getStoreThemeSetting[6]['section_enable'] == 'on')
            <div class="container">
                <div class="footer-row flex">
                    <div class="footer-col contact-col">
                        <div class="footer-widget set has-children1">
                            <div class="footer-logo">
                                <a href="{{ route('store.slug', $store->slug) }}" tabindex="0">
                                    <img src="{{ $imgpath . $getStoreThemeSetting[6]['inner-list'][0]['field_default_text'] }}" alt="logo" loading="lazy">
                                </a>
                            </div>
                            <p>{{ __('Got questions?') }} {{ __('Call us') }} 24/7</p>
                            <ul class="footer-contact-info">
                                <li class="flex align-center">
                                    <svg width="25" height="25" viewBox="0 0 25 25" fill="none"
                                        xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                        <mask id="mask0_295_814" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="0"
                                            y="0" width="25" height="26">
                                            <rect y="0.000244141" width="25" height="25" fill="url(#pattern0_295_814)" />
                                        </mask>
                                        <g mask="url(#mask0_295_814)">
                                        </g>
                                        <mask id="mask1_295_814" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="0"
                                            y="0" width="25" height="26">
                                            <rect y="0.000244141" width="25" height="25" fill="url(#pattern1_295_814)" />
                                        </mask>
                                        <g mask="url(#mask1_295_814)">
                                            <rect y="0.000244141" width="25" height="25" fill="white" />
                                        </g>
                                        <defs>
                                            <pattern id="pattern0_295_814" patternContentUnits="objectBoundingBox" width="1"
                                                height="1">
                                                <use xlink:href="#image0_295_814" transform="scale(0.00195312)" />
                                            </pattern>
                                            <pattern id="pattern1_295_814" patternContentUnits="objectBoundingBox" width="1"
                                                height="1">
                                                <use xlink:href="#image1_295_814" transform="scale(0.00195312)" />
                                            </pattern>
                                            <image id="image0_295_814" width="512" height="512"
                                                xlink:href="data:image/png;base64,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" />
                                            <image id="image1_295_814" width="512" height="512"
                                                xlink:href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAgAAAAIACAYAAAD0eNT6AAAgAElEQVR4nO3dd7hlVX3/8fedSpuBgaFL7+CACIggoQWV4qigoIKCFYyiqElETZEYkqAmKviLCXZREFFRJPTelSpV6oDAMJShDEyfO3d+f6w7MlzunXvOPXuf79p7v1/P83mG5Pnld797rV3W2WUtkCRJkiRJkiRJkiRJkiRJkiRJkiRJkiRJkiRJkiRJkiRJkiRJkiRJkiRJkiRJkiRJkiRJkiRJkiRJkiRJkiRJkiRJkiRJkiRJkiRJkiRJkiRJkiRJkiRJkiRJkiRJkiRpeD3RBahUKwHvAt4HTAHWBJ4BHgYuB84BbgurTnWwBJgNLAL6gFn9//u5wIL+/36+/99ngZn9/y773zNJ++WzwJyuVC3JAUBNrQAcC3wRWH2Y/7fXAF8BLi27KNXSkoL//5sPPAU8QhqoPtz/39P6/32CNNCQJA0wFXiUdGJuJ2cAkwPqVbW1u591mgXA/cBFwP8CnwL2AiaVvaGSlKtJwKl0dnJ9DNit24Wr0ro9AFhengAuAU4GjgR2AsaXt+mSFG8fYDrFnETnk94bkFoRfdFv5Y7BraS7BUcCm5bTDJLUXaOBE4Beij1p9gIf6eJ2qLqiL/AjyZPAucDxwB54l0BSxUwCLqa8k+Ri4D1d2xpVVfTFvIjMBq4A/pV0N21soS0kSQXaAvgT5Z8YFwL7d2mbVE3RF+8yMof0LsFxwEbFNZUkdWZ/0rfW3ToZvgTs0pUtUxVFX6y7kYdIL9hOxccFkoIcRfpV3u0T4DPAll3YPlVP9MW523kJ+A3phcJVC2g/SRrWcaTn8lEnvnuBiaVvpaom+oIcmfmklwmPxGNDUgl6gK8Rf7JbApxZ8raqeqL3yVwyj5cHA6t01KKSBIwjzdAXfXJbNseVusWqmuj9McfMJg2W34FfFEgagQmkN5GjT2YDsxBfCtTLovfH3DMDOAnYbKQNLKlZ1gRuIf7kNVQeIA1QpOh9sUq5GTgaWHFELS2p9tYC7iD+ZDVcflxWA6hSovfDKuZ50meFU0bQ3pJqam3gTuJPUK3miHKaQRUSvQ9WPVcB7yZN6y2podajO7P7FZkXgE3KaAxVRvQ+WJdMI61N4NwCUsOsA9xN/EloJLkWf700WfT+V7fMIi1n/Jp2OkFSNW1Aeqku+sTTST5TeKuoKqL3vbpmAXAa8NrWu0JSlWwAPEj8yabTzAO2LbhtVA3R+17d0wecR1q2WFJNbER67hd9gikqN+CjgCaK3u+alGuBPVvrFkm5Wos0t370CaXoHF9kI6kSove5JuYSYKdWOkdSXiYDdxF/Eikj8/Hb5qaJ3ueamj7S2gOvG76LJOVgInAT8SePMnMrzn/eJNH7W9OzGDgL2Gq4jpIUZ0XSpB/RJ4xu5MsFtZnyF72vmZRFwP+QphGXlJFxpDd5o08S3TwZ7VxIyyl30fuaeWWeJ72LM355nSapO0aTbtFFnxi6nbuBFQpoP+Utej8zg+d+4NDl9JukkvUA3yf+ZBCVf++8CZW56H3MLD+X4mRCUojvEH8CiMwiYNeOW1E5i97HTGvH4an4foDUNV8h/sDPIX/C9c/rLHr/Mq3nGeDIwbtRUlGOIf5gzyk+Cqiv6H3LtJ8rgS0G60w1S090ATX0duBsnBZ3Wb3AG4DbogtRKVYhzf3QA6zW/79bgZfv/EwiTYA1GVijP0v/e63+f9cmfS2j7pgD/BNwCmkuATWQA4Bi7QlchG+/D+YmYDc82Whok4BNh8iGwJi40mrrj8BHgVuiC5GqbDvgOeJv7+Wcz424ddV040jTTB8BnARcADxO/D5dhywETsQfLo3jHYBirA9cT/qVoqHNJZ3Ep0UXotpYA9iBtF+9jnSXyWlxR+Y+4MOkc5mkFqwB3EP8KL4quQwHnirXRGA/4ATSynnziN/vq5Je0h0W1/OQhrEicA3xB23V8oGRNLY0QisAewBfAC4mrVoZfQzknutJ715IGsRo4BziD9Qq5hmclERxViTdITgJ794tLy8CR4+wjaVaO4X4A7TK+Vn7TS6VYivgM6QveHxc8Oqcycufd0qNdxzxB2UdMrXdhpdKtiJpvzyN9K189DGSSx4F9u6gXaVaOJD0okz0AVmH/Jk0iYyUo9WADwLnkz6Viz5eotNLmuJ8VCeNKlXVjsBLxB+Idco32+oBKcbqpAlzLiNNZhV93ETmgv72kBpjPeAx4g++umUxsHsb/SBFew1wPOkOVvTxE5VHgV06bUipCiaQpsyMPujqmjvwu2NVzyjS1wRnkZbcjT6Oup15wEc6bkUpY6OB3xF/sNU9/9Bqh0gZ2oA08dCjxB9L3c5/40JOqqnvEH+ANSHzcApXVd8o0lcENxB/THUzNwEbFdB+UjY+R/yB1aRc1lq3SJWwD/B/QB/xx1Y3MgN4UyEtJwV7K37uF5H3tdI5UoVsDpxMWgwr+vgqO/NJKzZKlbU18ALxB1MTMwNnHVM9rUOafng28cdZmekjrbsgVc7qwAPEH0RNzreG7SWpuiaTBgJ1vyPwA/y6RxUylvQcOvrAaXp6SZMuSXW2FmkgUOf1By4BVi2qwaQy+cZ/PrkRpxxVM2xAekegrssU3wlsWFhrSSU4lvgDxbwyH11uj0n1shnwK+KPuzLyOPC64ppKKs6ewALiDxLzyjxLel4qNcnewG3EH39F50VgrwLbSerYJsAzxB8cZvB8d+iuk2prFHAk8CTxx2CRmQ+8vcB2kkZsVeBPxB8UZugsBnYbqgOlmluFNMVwnd4PWAC8u8hGkto1CjiX+IPBDJ87gDGDd6PUCFuSluGNPhaLyiKcMEiBvkL8QWBaz6cH70apUQ4Fnib+eCwifcCnim0eaXhTSbeWow8A03pmAesN1plSw0wCTiX+mCwifcDfFts80tC2xGl+q5qfDdKfUlMdADxC/HFZRE4quG2kV1kFuIv4nd2MPPu+qlel5lqJdPGsw8Jl/1Rw20h/0QOcRfxObjrLfcB4JC1rD+Bh4o/PTvPZohtGAvgH4nduU0xcaUx6tYlU/92APuDjRTeMmm1/fOmvTpmDc4tLQzkUeI7443Sk6QM+XHirqJE2xpn+6pizkDSUDYGriD9OR5pe4LDCW0WNsgL1nFPbpDivuDS00cDxwELij9WRZAFwUOGtosb4PvE7sSkvd+EMgdJw9gCeIP54HUnmkhZHktpyOPE7ryk/f4Ok4awHXEf88TqSvIhLCasNryW9KBa945ry8yywBpKGM4Y0Z0D0MTuSTAc2KL5JVDerAPcQv8Oa7uUUJLXqcKr5A+ku0gqu0pB+SvyOarqbXmAKklq1A/AQ8cduu7kQ3/vRED5J/A5qYnIZktqxOnAF8cduu/luGY2hatsFmE/8zmnicjCS2jEOOI34Y7fdOBuo/mIS9ZgH23SWB0gnNEmt6wFOIM3AF30Mt5o+4P1lNIaq50zid0iTR1xMRBqZo0iT70Qfw61mHvCmUlpClXE08TuiySfP4WeB0kjtCzxP/HHcap4EXlNKSyh721LNz1lMufkmkkZqW+AR4o/jVnMdPvprnPE4z78ZPAuBLZE0UuuSvruPPpZbzX+X0wzK1SnE73Qm35yNpE6sDdxO/LHcaj5UTjPUV090ASN0AHAe1a1f3fHXwOXRRdTcEmA2sKj/v1/o/9/PJ03TvDTPADP7/3sG6RbzI6SXzpSvScD5wBujC2nBfNLCR7dEF1IVVbyALh2Vrh1diLJ3G7Az6ZMhlWNJh/+3M0if8D4MTCPddr6dNEvd4o6rUxFWAc4hvSCYuz+TjvmZ0YWoeKOAS4i/1WSqkyNQmcrqtznAjaQlvT9N+gU6tkvbpFdbCbiI+OO5lVwCjC6nGRTps8TvXKZaeZj0wqjK0c2+XAjcDJwMHIqfe3bbeOBc4o/pVvKVktpAQbYC5hK/Y5nq5VOoLJH9upg0IDiRNCGMv/rKN470TkD0Md3KvrFPSW2gLhsFXEP8TmWqmaeBCagM0X27bJ4jzQr6QWBymRvdcCsBVxHf38PlMdKCR6q4LxK/M5lq559RGaL7daj0AtcCxwFrlbb1zTWR9I5GdD8Pl1+W1QDqjm1Jcz5H70im2nkJvxwpQ3S/tpIFpM+Gj8Q7QUVaDbiV+P4dLkeW1QAq1xjgJuJ3IFOPfAsVLbpP28084CxgvzIao4HWAv5EfL8uLy8BW5TVACrPvxC/85j6ZAGwKSpSdJ92knuA4/Frgk5tSPr+Pro/l5frST8oVRFTSJ/9RO84pl75CSpSdH8WkTnA/+CvxE5sS/6rCJ5Q2tarUD3AlcTvMKZ+6SV9UqpiRPdnkVlM+s7dxwMj89fk/aNtEbB7aVuvwnyY+J3F1Dc/RUWJ7suycgNwMNWcLj3Sh4jvu+XlPmCF0rZeHVud9N129I5i6pteYGtUhOi+LDt3kmYddCDQun8lvt+WF2cJzNh3id9BTP3jXYBiRPdjt/J7YGpBbVZ3PcBpxPfZUFkE7Fja1mvEdiE9h4veQUz9412AYkT3Y7dzNdVYGjfaWOBS4vtrqNyIU0dnZRRpHefoHcM0Jz9DnYruw4j0keYS2KiA9quzNUiLcUX311D5THmbrna9n/gdwjQr3gXoXHQfRmYOcBKwSsetWF87kNopuq+G6j/nBcnAOGAa8TuEaV58F6Az0f2XQx4BDum0IWvsCOL7aKhcUOJ2q0UfI35HMM3MQtJMZhqZ6P7LKecCG3TWnLX1HeL7Z6i8v8Tt1jB6SFNyRu8Eprn5TzRS0X2XW14grUA4qpNGraFxpOl4o/tnsDxNWthIAd5C/A5gmp1ZwKpoJKL7LtdcCWzZQbvW0TrAdOL7ZrB8o8TtzlYOo9T3RRegxpsIHBNdhGplL+CPpLsBTiKUPAkcTnr5NjfH4hThIXL+TMQ0J9NJtynVnuh+q0IuJP36VXIC8X0yWM4rc6M1uAXEd7wxS4CjULui+6wqeQo4aIRtXDdjgOuI75PBckCJ261BzCS+041ZAtyG2hXdZ1VKH+lZ89gRtXS9bEJ69ya6TwbmTzSof3J4B+D56AKkfq8DdoouQrXVA3wWuAJYN7iWaA8Dn4ouYhBbA5+ILqJbchgAvBBdgLSMj0QXoNp7E+kFwX2iCwl2GnBGdBGD+DIwObqIbnAAIL3S4cBK0UWo9tYCLgaOjy4k2CeBP0cXMcAkGrJkcA4DgKeiC5CWsSrwrugi1AhjSGsJ/JAGPXce4AXgA6T3I3LyMWDz6CLKlsMA4NHoAqQBfAygbvoQ6VPBps5Gdw1pquCcjAH+ObqIsjkAkF5tT1zqVd21L+nTuI2jCwnyJeCx6CIGOBzYJrqIMuUwQ9WBOAGD8nMccEp0ERWxMi9PorQasCJpLfjJ/f+uBaxP+vRr4/5/V+h+mZXwJDAVuDm6kAAHAOdHFzHAWcB7oosoSw4DgNcCd0YXIQ1wGbBfdBE1th6wHbB9f6b0/8/OxpjWqX8XcFF0IQF+Drw3uohlLAF2BG6PLqQMOQwAJpAmhMihFmmp+aRfswuiC2mQMcAOwB6kT+X2BtYMrSjOQtIt6F9HF9Jlk0mrw+bU778FDo4uos4eI34GKGMG5k0o2qakxzGX0Lxpw3tp5vTURxHf9gPzhlK3uOEuIr6DjRmYv0E5WRV4N/AL0m3y6P2jG1lM+iStaS4mvu2XTW7vJtTKN4nvYGMG5qsoVyuTXs46m/S4JnpfKTN95Dltbpm2Jj0GiW77ZbN7qVscIIfPACEtwCDlZkx0ARrSHNKdgENIS+0eA9wRWlF5eoCTSdvYFPcC/y+6iAG+EF1AXe1B/OjOmIH5O1Q1ewA/I79fj0VkMenFwKZYDXia+HZfmj5g21K3uKHWIL5zjRmY16GqWgc4AXiW+P2oyPQChxbYTrn7OPFtvmy+W+7mNteTxHeuMUszHT9NrYMJwOeo1/llPvCWIhspY6NJKydGt/mybb9OqVvcRbm8AwBwa3QB0jK+TTrgVW0vAd8gfU74Geqx+Nh44DfArtGFdMFi4LPRRSxjPPCJ6CLq6F+IH90Zs4S0QllTF2apuwmkRV5eIn4/6zRP0Jw1K35NfHsvzbOkr1BUoLcR37HGLKFZb1s31brAqaRn6tH7Wye5m7R+fd1tASwivr2X5pPlbm7zrEl8pxpzET77b5JdSKvwRe93neRSYGzRDZOhHxDf1kszjfR+ggr0CPEda5qbx0m/DNUsPcDRpEc/0fvgSPPDwlslPxuR13TQ7yp3c5vnl8R3qmlmXsTP/ppuHap9Djq2+CbJzneIb+elubLkbW2czxPfqaZ56QXejpQcCswkfr9sNwup/wJW6wFziW/rpdmm3M1tlr2J71DTrPQC70d6pbVJC8BE75/tZgbpIlln3yK+nZfmayVva6NMoPpv5ZrqpBc4AmlwPaSliKu22ND1wLgS2iMXa5LPZ5zPkOYGUEFuI75TTf2zkLS0rDScnYE/E7/PtpP/KqUl8vE14tt4aZo0NXPp/ov4DjX1zhzgIKTWrUH6RDR63201fdR7H18bmEd8Oy8h7RcqyEHEd6ipb56j/i9KqRyjgf8gXVyj9+NW8gTpdnld5TIvQB+wWcnb2hgTqOdSniY+04EpSJ05lHx+fQ6X86nvxFZbk9YKiG7jJcCJJW9ro1xPfIeaeuWPwGuQirE76QWw6P26lXy8pDbIQS5fasygGbMxdsWJxHeoqU8uBCYiFWtr4CHi9+/hMgfYsqQ2iLYv8e27NFNL3tbGyKlTTbVzKjAGqRxrA7cTv58Pl6uo76OAW4hv3yXA6WVvaFOsQF6zPZnqpRf4NFL5JgG/J36fHy5Hl9UAwY4gvm2XALNxmeDCXEZ8h5pq5iW8HafuWhW4lvh9f3mZRT3fgxkLPEZ8+y6hYgsEjYouYDmuiC5AlTQd2As4N7oQNcos4K2kpYVzNRH4dnQRJVhEPqshvie6gLrYjfjRnKlWbqOev3BUHasCNxN/LCwvh5S29XE2II9p5OcAq5S8rY0wmmquyGVicjawElK8ycBdxB8TQ+VR6nmsXEB82y4B3lv2hhYl50cAi3GKRbXma6R5/edGFyKRfri8GXg4upAhbAB8LrqIEnw/uoB+h0UXUBeHEz+aM/lmPvBBpDxtDTxL/HEyWOYAG5a36SHGkKY/jm7beaRHQerQJNILHtEdavLLE8CuSHn7K/JdTvi0Erc7yleJb9clwPvL3tCmuIr4zjR55Vbq9+tF9XUEeS4g1Ef9BtFbkEdbn132hjbF54nvTJNPfg6siFQt/0H8sTNYrilzo4NcSXy7zsK1AQqxFfGdaeLTB3wBqZpGkc9b6gOzX4nbHeEY4tt0CbB32RvaFDl/UmPKzwLSbVSpylYHphF/PA3MjdRrnYDJ5PHu2FfL3tCm+BfiO9PE5CVgf6R62Jk0oI0+rgbmoDI3OsDFxLfp7aVvZUNsT3xnmu7nCWBHpHr5e+KPrYG5hXrdBfgI8W26hDTnggpwL/GdabqXe4CNkOpnFHAp8cfYwLyzzI3usknkcaflI2VvaCdynglwoN9GF6Cu+QOwB/Dn6EKkEvQBR5EmCcrJF6MLKNDzpEFWtAOiC6iLnYkfzZnycxUwAan+DiP+eBuY3Uvd4u46kvj29HPAAt1HfIea8nIFrqSlZvkN8cfdsvl1uZvbVauSxyyMe5W9oSNVpUcAAGdGF6DSnEe6XTY7uhCpiz4BvBBdxDLeSVrDoA5mAddGFwHsG13AUKo2APh5dAEqxVnAwaTRutQkM4AvRRexjFHAp6KLKNCF0QUAb4ouoE5uIf6WjikupwOjkZprFHAD8cfi0swBVit1i7tnO+LbczZppcLsVO0OAHgXoE5+S3obenF0IVKgPuDY/n9zsBJpKfY6uJv4r4lWBnYIrmFQVRwAnIEXjDq4GHgv0BtdiJSBW0h3w3JxTHQBBboougDSZ80qyOXE39YxI89luKKfNNA6pBfXoo/Ppdm53M3tmncS35Znlb6VI1DFOwAAP44uQCN2A/AOYF50IVJmngS+GV3EMo6OLqAglwELg2vwRcACrQy8SPyozrSXR0nf5koa3KqkGQKjj9UlpIW46jIpVw53jTcpfSvbVNU7AHPI9JaKlmsSMDe6CCljs4D/jC6i3yrUZ32Ay6MLIMO7AFUdAAD8KLoAtW0V6vNcUSrLKcDT0UX0e090AQXJYUIgBwAFuo60QqCqJdtZsaRMzCGfuwBvJt25q7obgUXBNbwh+O+/SpUHAACnRRegtu0TXYBUAf9LehwQbRz1eAwwF7gtuIbtyGxCoDoMAPyOvFp2B1aILkLK3EvA96KL6FeXxwDXBf/98cAWwTW8QtUHANNJi8ioOlYE9o4uQqqAU4i/bQ3psd3k6CIKED0AANg+uoBlVX0AAHBqdAFq2wHRBUgV8Bh5fO00FjgwuogC5PAi4JToApZVhwHAhcCD0UWoLW+LLkCqiFx+4OwfXUABniL+WuEdgIItAX4QXYTasimwZXQRUgVcA9wTXQTwVuqxauf1wX/fAUAJfggsiC5CbfEugNSaHH7grA7sEl1EAW4P/vsbktFSy3UZADwN/Ca6CLXl0OgCpIr4CXn8wKnDuzt3BP/9HjJ6D6AuAwBI382qOnYFNo4uQqqAZ4ELoougHu8BRN8BgIweA9RpAHAVcFd0EWpZD94FkFr1i+gCSNN4V30xr2dILwNG2jb47/9FnQYAACdHF6C2HBZdgFQRvyNNERxpFLBbcA1FiH4MkM2qgHUbAPyU+NGdWrczsHl0EVIFzAXOjy6CDBe0GQEHAP3qNgBYQD7TZ6o1744uQKqIX0UXQD0GAHcG//2NSY9AVYJ1SQOBJaYSuXXwbpQ0wGqkqYEjj9e5pAWCqmxH4s9765a+lS2o2x0AgBnkMX2mWrMjsHV0EVIFvAD8PriGFYEdgmvo1L2ki3CkLB4D1HEAAPDN6ALUFh8DSK3J4XPAXaML6NA84MngGrL4BLquA4BbyWPhB7XmKHwmJrXiwugCyOg79g48HPz3vQNQsm9EF6CWbQ7sE12EVAG3Ac8F1+AAoHMOAEr2W/JYREOtOSa6AKkClgA3BNfwWqp/7YgeAPgIoGRLgP+KLkItO5hM3oyVMndd8N9fmbSiZ5VFDwC8A9AFPwUejS5CLRlLehdA0vLl8H5T1R8DPBL899cO/vtA/QcAi3B64Co5mvrvk1KnbgYWBtfw2uC/36noOwArkz6pDNWEk+2ppNW0lL9NgDdHFyFlbh5wX3ANWdzC7sBjQG9wDWsE//1GDADmAN+JLkIt82VAaXjOZ9+ZXuLXjZkc/PcbMQCA9BggeiUttWYqsH50EVLmouezr/oAAOLvDDsA6JJngR9GF6GWjCG9CyBpaNF3ANan+msCzAz++z4C6KL/ID07U/6OBSZEFyFl7O7gvz8a2DC4hk5FDwC8A9BFM4AfRBehlqyOdwGk5Xmc+C8BspjMpgMOAKIL6LJ/x7sAVfF3wArRRUiZ6iN+jpOqT9wVPQDwEUCXeRegOtYBjowuQspY9Lfs4b9gO+RLgNEFBPAuQHUcT3opUNKrRQ8Awn/Bdij6DsBqwX+/kQMA7wJUx6bAodFFSJl6LPjvh/+C7VD0ACD8EWcTBwDgXYAq+QLQE12ElKHoC1jVBwCzg/9++GeUTR0AeBegOrYHDoouQspQ9ACg6o8AFgT//fHBf7+xAwBI8wLMjS5CLflSdAFShqIHAKsH//1ORX9G6QAg0BPAKdFFqCW7AftHFyFlJvot9vBn2B3yDkB0AcG+CjwXXYRaciK+CyAt68Xgvx9+AeuQA4DoAoK9AHw9ugi1ZCfSQkGSksZfwDrU+PZr+gAA0kqBj0cXoZaciPustFTjL2Adanz7eTJNnwP+W3QRaskU4F3RRUiZaPwFrEONbz+fqSZjSOtrbx1diIZ1P7AtsDi6ECnYaKA38O8vptozddp++ov3AEtMJXLEEH0oSWqRdwBe1gPcRHrZTHl7ENiG2NG7JFXa6OgCMvMQrkBXBauTXty8NboQSVJ9/I74W9xm+DwFTByiDyVJw/AOwKvdCHwc2yZ3K/f/e1loFZJUUV7kXu15YE1g1+hCNKxdgNNJEzpJktSxSaSFNqJvc5vhc+YQfShJWg7vAAxuPmmlKBegyd9rSY8BHo0uRJKqxM8AhzYWuAvYMroQDetW0uOAvuhCJKkqvAMwtD7Sr8r3RReiYa0LPECazVGSpEJcRvxzbjN8HgVWGqIPJUkDeAdgeH8EPoYLJ+VuVVIf+VmgJLXAAcDwngIm42eBVbAbaSKnp6ILkaTc+RJgayYC95KeNStv1wJ7kh4LSJKG4B2A1iwgzQvwzuhCNKwNcZ0ASRqWdwBa1wNcAewVXYiG9RxptcCnowuRpFz5YlvrlgDH4hK0VbA68J/RRUhSznwE0J6ncZ2AqtgBuA6YFl2IJOXIRwDt84XA6ngA2J40tbMkaRneAWifLwRWxxqkfdy5ASRJheghfW4WPfudGT69wBsH70ZJai4fAYzc1qRZAsdHF6JhTSO9EzA7uhBJyoWPAEZuJuniv2d0IRrWJGACcEF0IZKkehgP3EP8bW4zfPqAtw7ejZIktW9P0sUl+gJnhs/jpLsBktR4PgLo3J+BDYDXRxeiYU0E1gLOiS5EklQPqwLTif+Fa1rLIYN3oyRJ7XsP8Rc201qeBNYZvBslSWrfOcRf3ExruQIfgUlqME+Axboe+CjODVAFG5MmCbo6uhBJiuAAoFizgDnAAdGFqCV7AleRXuSUJKkjo4Arib/FbVqL7wNIkgqzCfAS8Rc301ouIA3cJKkxfARQjhdIA4ADowtRSzYnLRl8bXQhkqTq6wEuJv7XrWkti4A9Bu1JSaohVwMs1ybAHcAq0YWoJdOBnUnvBUhSrfncs1wPA5+PLkItWx84Gz/jlCQVoAe4kPhb3Kb1/HjQnpQkqU0bkeYIiL6wmdZz7KA9KUk14VcA3eF94TgAABKaSURBVDELeA6YGl2IWvYW0lcBj0QXIkmqNh8FVC/PkKYMlqTa8SuA7lqb9FXAWtGFqGW3A28iTfEsSbXhVwDd9RRwTHQRassOwI9wsCypZnwHoPvuBV4DvD66ELVsO2BF4NLoQiRJ1bYyaSAQ/YzbtJdPD9aZkiS1YydgAfEXNdN6FgOHDNaZklQ1PgKIM4N0Udk3uhC1rAd4O2m558eCa5EkVdgo4Arif9ma9jIT2GqQ/pSkyvDN5nivIX0aOCm6ELXlYWA30pcdklQ5fgYY73GcdraKNgHOJb3QKUnSiJ1O/K1t034uBlYYpD8lSWrJKvhpYFVzIS4hLEnqwPbAXOIvaKb9/BoY8+oulaQ8+RlgXp4CXgAOjC5EbduG9F7AOaQBgSRlzQFAfm4CtgSmRBeitu0AbEB6OVCSpLZNAO4j/ra2GVm+9eoulaS8eAcgTwuBG4Cj8LlyFb2RdGxdEV2IJA3FAUC+ZgAvAgdEF6IR2QtXEJSUMQcAefsD6cuAbaIL0YjsAawJXBBdiCSpelYDphH/XNuMPKfirJuSpBHYBZcOrnpOx/c5JGXERwDV8AS+D1B1U4CtSfME9AXXIkmqmB8T/0vWdJb/w7UDJEltWgm4nfiLmOksF+EqgpKkNm0MzCT+ImY6y43A2kiS1IY3A73EX8RMZ5kGbIUkBfAlwGqaRvqsbO/oQtSRScDhwPXAo8G1SJIqogc4m/hfsabzzAcOQ5KkFq0GPED8Bcx0nl7gk0iS1KIpwGziL2CmmJyMswZKklp0OPEXLlNcziR98ilJ0rBOJv7CZYrL7cAmSFJJeqILUGHGkiaY2Se6EBXmGeBQ4KroQtR1o4CdgH2BdYDFwMOkgeHNpBdHJekv1gAeJP7XqykuC4FPoKZYHfgy8DRD7xPzgcuATwMbxZQpKUfbArOIv3CZYnMqMA7V1SjgM6RFv9rZL/qAK4APACt2vWpJ2TkQZwqsY67B6YPraCPgcjrfP14AvgPs3N3yJeXmb4m/YJni8yiwG6qLN7L82/0jzW3AkXjXSGqs7xJ/wTLFZxFwAs4XUHXvBOZQ7r4yg7SvTOrSNknKxHjgWuIvWKacnAdMRlX0YdKb/d3aV2YBXwde042Nk5SHtYBHiL9YmXLyGPBXqEo+RHcv/stmIfATYMvSt1JSFnYAXiL+YmXKSS8+EqiKDxJ38V82i4GzcDlqqREOJo8TjykvF5Pu+ChPh5LfMdgLnIZ3BKTa+wfiTzim3MwADkK52Yc0gU/0/jFUlg4EtiirASTF6iE9/4s+2Zjy831gIsrBjlRncq5e4Ec4w6BUS+NI04hGn2hM+XkY14aItinprkz0vtBu5gPfwK9MpNqZSFpUJPokY8pPH2ka4ZVRt00E7iR+H+gkLwEn4d0kqVbWJ31CFn2CMd3JQ8AeqFvGApcQ3+9F5RngeNLcIpJqYCf8PLBJWQSciCfxbvge8f1dRh4C3odLyUu1cADpwhB9YjHdy4PAm1FZPk98H5edm4A9i2owSXE+RvwJxXQ/Z+G8AUU7hPy+9S8z5wKbF9JyksJ8nfiTiel+ngOOw1kEi/B6YDbxfdrtLCS9aLpm500oKUIP8DPiTyYmJtcA26GRWg9fqn0OXxSUKmsFXD2wyVkA/CuwImrHBOCPxPdfLrkfeEdHLSopxBrAfcSfRExcHgOOxDe9WzEKOIf4PssxlwNTRt60kiJsRjVnLzPF5nrgjWh5Tia+n3LOov42mjTSBpbUfVNIz/SiTyAmNn2krwU2QQN9kPj+qUqeJb1sOnpELS2p6/YC5hF/8jDxmYtTwi7rTeS9ul+uuQd46wjaW1KAg0krhEWfOEweeQL4MDCG5toIeJr4vqhyfgFs2G7DS+q+I0m3gqNPGiafTAOOpnm3dFcEbia+/euQucAJ+NmglL0vEX/CMPnlbtIAsQkTCfWQfrlGt3ndcj/wljb6QVKAbxF/sjB55hbgbdTbicS3c51zOrBuy70hqat6gB8Rf6Iw+eb3wFTqx/UyupPZpNkEm/yOiZStscD5xJ8oTN65GtiPepiKL8J2O7cBu7XSOZK6a0XS3PHRJwmTf64nXUCrOqvgLjRzgZ8c0gechosMSdlZg/QCWPRJwlQjfyB9UlqllwU3x8/9cshM0iOYKu07Uu29BniE+BOEqU7uA44hLTyVs7WAB4lvL/NybgB2XF6nSequzYDpxJ8cTLXyFPDPwNrkZxLpGXR0G5lXpxc4BVh1yN6T1FVb4uJBZmRZQFprIJcXBieSHldEt4tZfmbgipVSNnYgLfgRfWIw1c3NwEeBCcRYmfT1QnQ7mNZzBbD1YJ0pqbt2xBUETeeZx8t3Bbr1C28cft5a1SwkLVTllMJSsD3wsylTXO4mTQxT5sIx44BzM9hW01nuBN6IpFD74TLCptj0kW7Pf5z0CWpRxgO/yWD7TDFZDJxM3GMkSaTFPVwv3ZSRXuBa4DhgPUZuPHBOBttjis900rwTkoK8G1hE/MnA1DeLSXcGPgtsQ+tWBi7LoH5Tbs4gzekgKcD7SSfp6BOBaUaeJL1AeDRD3x1YBbg8g1pNd/I8aX/wk8EBbBB1w4eAH+D+pu7qI03oc2l/riGtY3EhsGtgXYpxNWlK4fujC8mFJ2R1y3HAt6KLUKPNBl4gTWGtZpoLfJl0LuoNriXc6OgC1Bh/IC2scgAOPBVjHGmmPzXXWNILyu8gTTz1RGw5sRwAqJtuJk3heRAOAiTFWQf4MOll0Oto6N0AT8KK8F7gp8CY6EIkNd400ntKV0cX0m3eAVCEu4A/AofgIEBSrEnAUaQJpq4gfbXUCN4BUKQDgF+T3syWpGh3Ax8kPa6sPe8AKNKDpBnd3oULeUiKtxYvvxtwNTW/G+AdAOVgD+A8fENbUj7uJD0auC26kLKMii5AIt0F2BeYGV2IJPWbQvp8+QRqerfcOwDKybakGdvWjS5EkpbxB9K7AfdGF1Ik7wAoJ/cA+wCPRxciScvYlfQo4HhqdDfAOwDK0Wakldo2ii5Ekga4inQ34JHoQjrlHQDl6CFgN+CO6EIkaYC9gNtJK51WmgMA5WoGsDdpmk5JyslE0mymp5GWl64kHwEodysBvyJNGiRJuXkEOAK4PrqQdtXmZQbV1iLgLGBTYPvgWiRpoNWAD5CWmr4xuJa2OABQFfQBvyHNzrV7cC2SNNBo4EBgS+Ai0g+X7DkAUJVcQjqw9sXHV5LyM4W03PnFwPPBtQzLk6iq6Cjg+7iSoKQ8PUW6I3BrdCHL4wBAVfV24ExcSVBSnmaTFjq7OLqQofgZoKrqd6QvA2ZFFyJJg1gFOBc4LLqQoTgAUJVdRZo6+KnoQiRpEOOAM0gzB2bHRwCqg82AC4AtoguRpEEsBg4lfc2UDQcAqovJwDn4maCkPM0H9gRuii5kKR8BqC5mkj4P/Hl0IZI0iBWAX5N+rGTBeQBUJ4uBs/v/e+/IQiRpEKsC6/PyeSqUAwDV0ZXAM8D+eJdLUl62B64BHo4uxHcAVGdvAX5JWrlLknJxNWlZ4VAOAFR3O5G+xV03uhBJWsaOwB8jC/D2qOruFmAXgg80SRrgHdEFOABQE0wnTRh0RXQhktRvn+gCHACoKV4gvRPwvehCJAnYNLoABwBqkl7gGOAfgSXBtUhqtjWjC3AAoKZZAvwbMBV4MbgWSc31THQBDgDUVOeRpuV8NLoQSY10R3QBDgDUZLeTPhO8KroQSY1zRnQBzgMgwXjgf8l0yU5JtTMT2BCYF1mEUwFLaQ2Bc0hfCrwZ74xJKtcXgeuii/AOgPRKB5JWFHT6YEllmAZsAyyMLsRfOtIrnU+aOfC+6EIk1dInyeDiDw4ApMHcD+wOXB5diKRa+TFwYXQRS/kOgDS4eaRHAasCuwbXIqn6HgcOJvjFv2U5AJCG1kcard8P7A+Miy1HUkX1Am8ns0eLPgKQhvdz0iOBh6ILkVRJ/wRcE13EQH4FILVuEvAz0pcCktSKc4F3ku4oZsVHAFLr5pPuBswD9sUBtKTluxc4iHTuyI4nMGlkDiTdDZgUXYikLD1PeoH4gehChuI7ANLInA+8gQwW9JCUnYXAYWR88QcHAFInHiSN8H8cXYikbCwBjgYujS5kOL4DIHWml5fXEdgXjymp6f6OtLhY9nwHQCrOTsAvgM2iC5EU4uvA56OLaJUDAKlYE4HvkZ7/SWqOM4APkOHnfkPxdqVUrAXAr4AZwFuAMbHlSOqCy4FDSY8EK8M7AFJ5Xk96JLB5dCGSSnMzsA8wO7qQdvkVgFSeW0nvBZwZXYikUtwBHEAFL/7gIwCpbAuAXwMPkxYUGhtbjqSC3AvsBzwdXchI+QhA6p4dSY8EtoguRFJH7iXd9n8yupBO+AhA6p7bgJ2B06MLkTRi9wB7U/GLP3gHQIpyKHAqriUgVcn9pF/+T0QXUgQHAFKcDYHTgL2iC5E0rAdIv/xrcfEHXwKUIs0CfkJaNcxphKV8PUCNfvkv5R0AKQ9L3w3YMroQSa+w9G3/6dGFFM1fHFIengB+AEwgLTPs4FyKdzfp4l+rX/5LeZKR8rM/8CNgnehCpAa7iTTJz7PRhZTFzwCl/FxImkb4wuhCpIa6nPReTm0v/uAAQMrVDNKvj8NILwlK6o7zgLdR0el92+EAQMrbL4HtgP+LLkRqgF8ABwPzogvpBl8ClPI3m7Sg0BOk75DHx5Yj1dLPgKOo2JK+nfAlQKlaNiF9LbBPdCFSjZwMfBZYEl2IJC1PD3A08BLphGWMGVn6gBNoKO8ASNXl3QBp5BYDnwC+G11IFN8BkKrrBeCnwHPAXwHjYsuRKmMu8G7g59GFRPIOgFQP6wHfBg6JLkTK3PPAVOC66EKiOQCQ6mUq8D/A+tGFSBn6M2mmzXujC8mBjwCkerkf+CGwErALDvKlpe4mze43LbqQXHhykOprD9ILTttEFyIFuwp4B2kJbvXzDoBUX4+SvhJYAuyGx7ua6Vekd2PmRBciSRG2A64l/rtrY7qZr+OU95JED3Ak8CTxJ2Zjykwv8Em0XN4SlJrlduB7pJcEd8JfR6qf2aRv/E+PLkSScrUDcA3xv9aMKSrTgR2RJA2rBzgUeIz4k7cxneR2YAPUMh8BSLqH9LngImB3PC+oei4CDgSeiS5EkqpqCnAp8b/mjGk138ZBqyQVZipputTok7sxQ6UXOA5JUuHGAkcDTxN/sjdm2bxIGqSqA942kTSUPuAW4Pv9//MuwJi4ciQAHgL+Glfzk6Su2QI4i/hff6a5uQpYE0lSiH2Bm4m/GJhm5dt4B0qSwi2dP+A+4i8Mpt5ZBHwKSVJWxpBeFJxO/IXC1C/Pku44SZIytRJwPPAc8RcNU4/cB2yFJKkSJgEnkdZej76AmOrmN8AEJEmVsx7ppa15xF9MTHWyGPhH0jsmkqQKW4t0R2Au8RcXk3dmAe9AklQrDgTM8vInYGskSbXlQMAMzJnAykiSGmE94FvAbOIvQCYmvcDf4/N+SWqkycAJwEziL0ime5kJvBlJUuOtAnwWeIz4i5MpNzcDGyNJ0jLGAkcCdxN/oTLF5zRgRSRJGsIo4J3A1cRftEzneQl4H5IktWFH4FScVKiq+RPw2lf1qiRJLVqbtN6ACw9VJz/FT/wkSQVZAfgIcDvxFzgzeOYBHx2qAyVJ6tROpMcDTiyUTx4Bdllep0mSVJQ1gc8DDxF/AWxyzgAmDtNXkiQVbhSwH3AWsIj4C2JTMhc4roX+kSSpdOuSLkq+K1BubgG2bLFPJEnqqp2Ak4Fnib9g1iV9/W06vo1+kCQpxErAB4DLgMXEX0SrmieB/dtse0mSsrAe6RHBtaRfs9EX1ark0v62kySp8rYirUp4H/EX2FwzB/gULt8rSaqpnYB/x8HAsrkW2KKTRpUkqUq2I00/fC3xF+GIzOvf/tGdNqQkSVW1OfC3wOU0Y46BG4FtCmk5SZJqYmVgKmka4hnEX6yLzELgJGBsYa0lSVINjQZ2Bb4IXEK11yW4Eti22OaRJKkZxpBeJDyeNCCYT/yFfbg8CxyNb/hLklSYlUmT5nwNuBnoJf6CvzSLge8Ak0rbekmSBKQBwV+RXig8E5hGzMX/Rly2V5KkUGsCBwJfBs4DnqC8C//9wGF4u7/x3AEkKU+TSJ/hbTvg3w0Z2bn7buDrwBmkzxjVcA4AJKlaVgI2Jg0ENuj/dyNgbdKgYRKwGrAq8Bjpzf4zSPMXLAmoV5IkSZIkSZIkSZIkSZIkSZIkSZIkSZIkSZIkSZIkSZIkSZIkSZIkSZIkSZIkSZIkSZIkSZIkSZIkSZIkSZIkSZIkSZIkSZIkSZIkSZIkSZIkSZIkSZIkSZIkSZIkSZIkVdj/B3Uhmf1oDclIAAAAAElFTkSuQmCC" />
                                        </defs>
                                    </svg>
                                    <a href="tel:{{ $getStoreThemeSetting[6]['inner-list'][1]['field_default_text'] }}">
                                        {{ $getStoreThemeSetting[6]['inner-list'][1]['field_default_text'] }}
                                    </a>
                                </li>
                            </ul>
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
                        </div>
                    </div>
                    @if ($getStoreThemeSetting[7]['inner-list'][0]['field_default_text'] == 'on')
                        @if (!empty($getStoreThemeSetting[7]))
                            @if ((isset($getStoreThemeSetting[7]['section_enable']) && $getStoreThemeSetting[7]['section_enable'] == 'on') || $getStoreThemeSetting[7]['inner-list'][1]['field_default_text'])
                                <div class="footer-col footer-link">
                                    <div class="footer-widget set has-children1">
                                        <h2 class="footer-acnav">
                                            <span>{{ __($getStoreThemeSetting[7]['inner-list'][1]['field_default_text']) }}</span>
                                            <svg xmlns="http://www.w3.org/2000/svg" version="1.2" viewBox="0 0 10 5" width="10"
                                                height="5">
                                                <path class="a"
                                                    d="m5.4 5.1q-0.3 0-0.5-0.2l-3.7-3.7c-0.3-0.3-0.3-0.7 0-1 0.2-0.3 0.7-0.3 0.9 0l3.3 3.2 3.2-3.2c0.2-0.3 0.7-0.3 0.9 0 0.3 0.3 0.3 0.7 0 1l-3.7 3.7q-0.2 0.2-0.4 0.2z">
                                                </path>
                                            </svg>
                                        </h2>
                                        <ul class="footer-acnav-list">
                                            @if (isset(
                                                    $getStoreThemeSetting[8]['homepage-header-quick-link-name-1'],
                                                    $getStoreThemeSetting[8]['homepage-header-quick-link-1']))
                                                @foreach ($getStoreThemeSetting[8]['homepage-header-quick-link-name-1'] as $name_key => $storethemesettingname)
                                                    @foreach ($getStoreThemeSetting[8]['homepage-header-quick-link-1'] as $link_key => $storethemesettinglink)
                                                        @if ($name_key == $link_key)
                                                            <li class="menu-link">
                                                                <a href="{{ $storethemesettinglink }}" target="_blank">
                                                                    {{ $storethemesettingname }}</a>
                                                            </li>
                                                        @endif
                                                    @endforeach
                                                @endforeach
                                            @else
                                                @for ($i = 0; $i < $getStoreThemeSetting[8]['loop_number']; $i++)
                                                    <li>
                                                        <a
                                                            href="{{ $getStoreThemeSetting[8]['inner-list'][1]['field_default_text'] }}">{{ $getStoreThemeSetting[8]['inner-list'][0]['field_default_text'] }}</a>
                                                    </li>
                                                @endfor
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                            @endif
                        @endif
                    @endif
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
                                            @if (isset(
                                                    $getStoreThemeSetting[10]['homepage-header-quick-link-name-2'],
                                                    $getStoreThemeSetting[10]['homepage-header-quick-link-2']))
                                                @foreach ($getStoreThemeSetting[10]['homepage-header-quick-link-name-2'] as $name_key => $storethemesettingname)
                                                    @foreach ($getStoreThemeSetting[10]['homepage-header-quick-link-2'] as $link_key => $storethemesettinglink)
                                                        @if ($name_key == $link_key)
                                                            <li>
                                                                <a href="{{ $storethemesettinglink }}"
                                                                    target="_blank">{{ $storethemesettingname }}</a>
                                                            </li>
                                                        @endif
                                                    @endforeach
                                                @endforeach
                                            @else
                                                @for ($i = 0; $i < $getStoreThemeSetting[10]['loop_number']; $i++)
                                                    <li>
                                                        <a
                                                            href="{{ $getStoreThemeSetting[10]['inner-list'][1]['field_default_text'] }}">
                                                            {{ $getStoreThemeSetting[10]['inner-list'][0]['field_default_text'] }}</a>
                                                    </li>
                                                @endfor
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                            @endif
                        @endif
                    @endif
                    @if ($getStoreThemeSetting[11]['inner-list'][1]['field_default_text'] == 'on')
                        @if (!empty($getStoreThemeSetting[11]))
                            @if ((isset($getStoreThemeSetting[11]['section_enable']) && $getStoreThemeSetting[11]['section_enable'] == 'on') || $getStoreThemeSetting[11]['inner-list'][1]['field_default_text'])
                                <div class="footer-col footer-link">
                                    <div class="footer-widget set has-children1">
                                        <h2 class="footer-acnav">
                                            <span>{{ __($getStoreThemeSetting[11]['inner-list'][0]['field_default_text']) }}</span>
                                            <svg xmlns="http://www.w3.org/2000/svg" version="1.2" viewBox="0 0 10 5" width="10"
                                                height="5">
                                                <path class="a"
                                                    d="m5.4 5.1q-0.3 0-0.5-0.2l-3.7-3.7c-0.3-0.3-0.3-0.7 0-1 0.2-0.3 0.7-0.3 0.9 0l3.3 3.2 3.2-3.2c0.2-0.3 0.7-0.3 0.9 0 0.3 0.3 0.3 0.7 0 1l-3.7 3.7q-0.2 0.2-0.4 0.2z">
                                                </path>
                                            </svg>
                                        </h2>
                                        <ul class="footer-acnav-list">
                                            @if (isset(
                                                    $getStoreThemeSetting[12]['homepage-header-quick-link-name-3'],
                                                    $getStoreThemeSetting[12]['homepage-header-quick-link-3']))
                                                @foreach ($getStoreThemeSetting[12]['homepage-header-quick-link-name-3'] as $name_key => $storethemesettingname)
                                                    @foreach ($getStoreThemeSetting[12]['homepage-header-quick-link-3'] as $link_key => $storethemesettinglink)
                                                        @if ($name_key == $link_key)
                                                            <li>
                                                                <a href="{{ $storethemesettinglink }}">
                                                                    {{ $storethemesettingname }}</a>
                                                            </li>
                                                        @endif
                                                    @endforeach
                                                @endforeach
                                            @else
                                                @for ($i = 0; $i < $getStoreThemeSetting[12]['loop_number']; $i++)
                                                    <li>
                                                        <a
                                                            href="{{ $getStoreThemeSetting[12]['inner-list'][1]['field_default_text'] }}">{{ $getStoreThemeSetting[12]['inner-list'][0]['field_default_text'] }}</a>
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
                                            @if (isset(
                                                    $getStoreThemeSetting[14]['homepage-header-quick-link-name-4'],
                                                    $getStoreThemeSetting[14]['homepage-header-quick-link-4']))
                                                @foreach ($getStoreThemeSetting[14]['homepage-header-quick-link-name-4'] as $name_key => $storethemesettingname)
                                                    @foreach ($getStoreThemeSetting[14]['homepage-header-quick-link-4'] as $link_key => $storethemesettinglink)
                                                        @if ($name_key == $link_key)
                                                            <li>
                                                                <a href="{{ $storethemesettinglink }}">
                                                                    {{ $storethemesettingname }}</a>
                                                            </li>
                                                        @endif
                                                    @endforeach
                                                @endforeach
                                            @else
                                                @for ($i = 0; $i < $getStoreThemeSetting[14]['loop_number']; $i++)
                                                    <li>
                                                        <a
                                                            href="{{ $getStoreThemeSetting[14]['inner-list'][1]['field_default_text'] }}">{{ $getStoreThemeSetting[14]['inner-list'][0]['field_default_text'] }}</a>
                                                    </li>
                                                @endfor
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                            @endif
                        @endif
                    @endif
                </div>
            </div>
        @endif
        @if($getStoreThemeSetting[15]['section_enable'] == 'on')
            <div class="footer-bottom">
                <div class="container">
                    <div class="footer-bottom-inner flex align-center justify-between">
                        <p>{{ $getStoreThemeSetting[15]['inner-list'][0]['field_default_text'] }}</p>
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
    
</body>

</html>
