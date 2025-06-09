@extends('storefront.layout.theme10')

@section('page-title')
    {{ __('Home') }}
@endsection

@push('css-page')
@endpush
@php
    $imgpath = \App\Models\Utility::get_file('uploads/');
    $default = \App\Models\Utility::get_file('uploads/theme10/header/social-media-2.png');
    $s_logo = \App\Models\Utility::get_file('uploads/store_logo/');
    $coverImg = \App\Models\Utility::get_file('uploads/is_cover_image/');
    $productImg = \App\Models\Utility::get_file('uploads/product_image/');
    $testimonialImg = \App\Models\Utility::get_file('uploads/testimonial_image/');
    $theme_name = $store->theme_dir;
@endphp
@section('content')
<main>
    @foreach ($pixelScript as $script)
        <?= $script; ?>
    @endforeach

    @foreach ($getStoreThemeSetting as $ThemeSetting)
        @if (isset($ThemeSetting['section_name']) &&
                $ThemeSetting['section_name'] == 'Home-Header' &&
                $ThemeSetting['section_enable'] == 'on')
            @php
                $homepage_header_img_key = array_search('Background Image', array_column($ThemeSetting['inner-list'], 'field_name'));
                $homepage_header_img = $ThemeSetting['inner-list'][$homepage_header_img_key]['field_default_text'];

                $homepage_header_right_img_key = array_search('Right Background Image', array_column($ThemeSetting['inner-list'], 'field_name'));
                $homepage_header_right_img = $ThemeSetting['inner-list'][$homepage_header_right_img_key]['field_default_text'];

                $homepage_header_title_key = array_search('Title', array_column($ThemeSetting['inner-list'], 'field_name'));
                $homepage_header_title = $ThemeSetting['inner-list'][$homepage_header_title_key]['field_default_text'];

                $homepage_header_subtxt_key = array_search('Sub text', array_column($ThemeSetting['inner-list'], 'field_name'));
                $homepage_header_subtxt = $ThemeSetting['inner-list'][$homepage_header_subtxt_key]['field_default_text'];

                $homepage_header_btn_key = array_search('Button', array_column($ThemeSetting['inner-list'], 'field_name'));
                $homepage_header_btn = $ThemeSetting['inner-list'][$homepage_header_btn_key]['field_default_text'];
            @endphp
            <section class="home-banner-sec">
                <img src="{{ $imgpath . $homepage_header_img }}" alt="banner-image" class="banner-bg-img" loading="lazy">
                <div class="container">
                    <div class="home-banner-wrp flex">
                        <div class="banner-left-col">
                            <div class="section-title">
                                <h2>{{ $homepage_header_title }}</h2>
                                <p>{{ $homepage_header_subtxt }}</p>
                            </div>
                            <div class="banner-btn">
                                <a href="{{ route('store.categorie.product', $store->slug) }}" class="btn">{{ $homepage_header_btn }}</a>
                            </div>
                        </div>
                        <div class="banner-right-col">
                            <div class="banner-image img-ratio">
                                <img src="{{ $imgpath . $homepage_header_right_img }}" alt="banner-image" loading="lazy">
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @endif
    @endforeach

    <section class="search-category-sec pb">
        <div class="container">
            <div class="category-search-col">
                <form  action="{{ route('store.categorie.product', [$store->slug, 'Start shopping']) }}" method="get">
                    @csrf
                    <div class="category-form-input flex align-center">
                        <button type="button" class="input-icon">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M11.5 21C16.7467 21 21 16.7467 21 11.5C21 6.2533 16.7467 2 11.5 2C6.2533 2 2 6.2533 2 11.5C2 16.7467 6.2533 21 11.5 21Z" stroke="#333333" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M22 22L20 20" stroke="#333333" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>                                
                        </button>
                        <input type="hidden" name="_token" value="">
                        <input type="text" name="search_data" placeholder="{{ __('Type Car Part') }}" class="search-input">
                    </div>
                    <div class="search-dropdown">
                        <div class="nice-select">
                            <span class="current">{{ __('Start shopping') }}</span>
                            <div class="list-wrp">
                                <ul class="list tabs">
                                    @foreach ($categories as $key => $category)
                                        <li class="option tab-link {{ $key == 0 ? 'selected focus' : '' }}" data-tab="pdp-tab-{!! preg_replace('/[^A-Za-z0-9\-]/', '_', $category) !!}">
                                            <a href="javascript:;" >
                                                {{ __($category) }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn">
                        <svg width="23" height="10" viewBox="0 0 23 10" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M22.5759 5.48481C22.8102 5.25049 22.8102 4.8706 22.5759 4.63628L18.7575 0.817904C18.5232 0.58359 18.1433 0.58359 17.909 0.817904C17.6747 1.05222 17.6747 1.43212 17.909 1.66643L21.3031 5.06055L17.909 8.45466C17.6747 8.68897 17.6747 9.06887 17.909 9.30319C18.1433 9.5375 18.5232 9.5375 18.7575 9.30319L22.5759 5.48481ZM0.848633 5.66055L22.1516 5.66055L22.1516 4.46054L0.848633 4.46055L0.848633 5.66055Z" fill="white"></path></svg>
                    </button>                          
                </form>
            </div>
        </div>
    </section>

    @if ($products['Start shopping']->count() > 0)
        <section class="product-sec pb">
            <div class="container">
                <div class="section-title">
                    <div class="section-content-top flex justify-between">
                        <h2>{{__('Popular Modals')}}</h2>
                        <div class="btn-wrp">
                            <a href="{{ route('store.categorie.product', $store->slug) }}" class="btn">{{__('Go To Shop')}}</a>
                        </div>
                    </div>
                </div>
                <div class="tabs-container">
                    @foreach ($products as $key => $items)
                        <div id="pdp-tab-{!! preg_replace('/[^A-Za-z0-9\-]/', '_', $key) !!}" class="tab-content {{ $key == 'Start shopping' ? 'active show' : '' }}">
                            @if ($items->count() > 0)
                                <div class="row">
                                    @foreach ($items as $product)
                                        <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-12">
                                            @include('storefront.theme10.common.product_section')
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
    
    @if ($getStoreThemeSetting[3]['section_enable'] == 'on')
        <section class="category-sec pb">
            <div class="container">
                <div class="section-title">
                    @foreach ($getStoreThemeSetting as $storethemesetting)
                        @if (isset($storethemesetting['section_name']) &&
                                $storethemesetting['section_name'] == 'Home-Categories' &&
                                !empty($pro_categories))
                            @php
                                $Titlekey = array_search('Title', array_column($storethemesetting['inner-list'], 'field_name'));
                                $Title = $storethemesetting['inner-list'][$Titlekey]['field_default_text'];

                                $Description_key = array_search('Description', array_column($storethemesetting['inner-list'], 'field_name'));
                                $Description = $storethemesetting['inner-list'][$Description_key]['field_default_text'];

                                $CatButton_key = array_search('Button', array_column($storethemesetting['inner-list'], 'field_name'));
                                $CatButton = $storethemesetting['inner-list'][$CatButton_key]['field_default_text'];
                            @endphp
                        @endif
                    @endforeach
                    <div class="section-content-top flex justify-between">
                        <h2>{{ $Title }}</h2>
                        <div class="btn-wrp">
                            <a href="{{ route('store.categorie.product', $store->slug) }}" class="btn">{{ $CatButton }}</a>
                        </div>
                    </div>
                    <div class="section-content-bottom">
                        <p>{{ $Description }}</p>
                    </div>
                </div>
                <div class="category-slider">
                    @foreach ($pro_categories as $key => $pro_categorie)
                        <div class="category-card">
                            <a href="{{ route('store.categorie.product', [$store->slug, $pro_categorie->name]) }}" class="category-card-inner">
                                <div class="category-image">
                                    @if (!empty($pro_categorie->categorie_img))
                                        <img src="{{ $productImg . (!empty($pro_categorie->categorie_img) ? $pro_categorie->categorie_img : 'default.jpg') }}" alt="category-card-image" loading="lazy">
                                    @else
                                        <img src="{{ asset(Storage::url('uploads/product_image/default.jpg')) }}" alt="category-card-image" loading="lazy">
                                    @endif
                                </div>
                                <div class="category-lable">
                                    <h3 >{{ $pro_categorie->name }}</h3>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    @foreach ($getStoreThemeSetting as $ThemeSetting)
        @if (isset($ThemeSetting['section_name']) &&
                $ThemeSetting['section_name'] == 'Latest-Products' &&
                $ThemeSetting['section_enable'] == 'on')
            @php
                $latestCatTitle_key = array_search('Title', array_column($ThemeSetting['inner-list'], 'field_name'));
                $latestCatTitle = $ThemeSetting['inner-list'][$latestCatTitle_key]['field_default_text'];

                $latestCatSubText_key = array_search('Sub text', array_column($ThemeSetting['inner-list'], 'field_name'));
                $latestCatSubText = $ThemeSetting['inner-list'][$latestCatSubText_key]['field_default_text'];

                $latestCatButton_key = array_search('Button', array_column($ThemeSetting['inner-list'], 'field_name'));
                $latestCatButton = $ThemeSetting['inner-list'][$latestCatButton_key]['field_default_text'];

                $latestCatBgText_key = array_search('Background Text', array_column($ThemeSetting['inner-list'], 'field_name'));
                $latestCatBgText = $ThemeSetting['inner-list'][$latestCatBgText_key]['field_default_text'];

                $latestCatbackGround_key = array_search('Category Background Image', array_column($ThemeSetting['inner-list'], 'field_name'));
                $latestCatbackGround = $ThemeSetting['inner-list'][$latestCatbackGround_key]['field_default_text'];
            @endphp
            <section class="arrivals-sec pb pt" style="background-image: url({{ $imgpath . $latestCatbackGround }});">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-4 col-lg-3 col-12">
                            <div class="section-title">
                                <h2>{{ $latestCatTitle }}</h2>
                                <p>{{ $latestCatSubText }}</p>
                            </div>
                            <div class="btn-wrp">
                                <a href="{{ route('store.categorie.product', $store->slug) }}" class="btn btn-white">{{ $latestCatButton }}</a>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-7 col-12">
                            <div class="arrival-slider">
                                @foreach ($latestProduct10 as $keys => $latestProduct)
                                    <div class="product-card">
                                        <div class="product-card-inner">
                                            <div class="product-card-image">
                                                <a href="{{ route('store.product.product_view', [$store->slug, $latestProduct->id]) }}" class="default-img img-wrapper">
                                                    @if (!empty($latestProduct->is_cover))
                                                        <img alt="product-card-image" src="{{ $coverImg . $latestProduct->is_cover }}" >
                                                    @else
                                                        <img alt="product-card-image" src="{{ asset(Storage::url('uploads/is_cover_image/default.jpg')) }}" >
                                                    @endif
                                                </a>
                                                <a href="{{ route('store.product.product_view', [$store->slug, $latestProduct->id]) }}" class="hover-img img-wrapper">
                                                    @if (isset($latestProduct->product_img) && !empty($latestProduct->product_img))
                                                        <img alt="product-card-image" src="{{ $productImg . $latestProduct->product_img->product_images }}" >
                                                    @elseif (!empty($latestProduct->is_cover))
                                                        <img alt="product-card-image" src="{{ $coverImg . $latestProduct->is_cover }}" >
                                                    @else
                                                        <img alt="product-card-image" src="{{ asset(Storage::url('uploads/is_cover_image/default.jpg')) }}" >
                                                    @endif
                                                </a>
                                                <div class="pro-btn-wrapper">
                                                    <div class="pro-btn">
                                                        @if ($latestProduct->enable_product_variant == 'on')
                                                            <a href="{{ route('store.product.product_view', [$store->slug, $latestProduct->id]) }}" class="compare-btn cart-btn">
                                                                <svg width="26" height="26" viewBox="0 0 26 26" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                    <path d="M6.19063 6.89429C5.99324 6.89429 5.78547 6.81117 5.64002 6.66573C5.33874 6.36445 5.33874 5.86579 5.64002 5.56451L9.41119 1.79334C9.71247 1.49206 10.2111 1.49206 10.5124 1.79334C10.8137 2.09462 10.8137 2.59329 10.5124 2.89456L6.74124 6.66573C6.58541 6.81117 6.38802 6.89429 6.19063 6.89429Z" fill="#333333"/>
                                                                    <path d="M20.3397 6.89429C20.1423 6.89429 19.945 6.82156 19.7891 6.66573L16.018 2.89456C15.7167 2.59329 15.7167 2.09462 16.018 1.79334C16.3192 1.49206 16.8179 1.49206 17.1192 1.79334L20.8903 5.56451C21.1916 5.86579 21.1916 6.36445 20.8903 6.66573C20.7449 6.81117 20.5371 6.89429 20.3397 6.89429Z" fill="#333333"/>
                                                                    <path d="M21.7943 11.2793C21.7215 11.2793 21.6488 11.2793 21.5761 11.2793H21.3371H4.95387C4.22665 11.2897 3.39553 11.2897 2.79298 10.6872C2.31509 10.2197 2.09692 9.49243 2.09692 8.42237C2.09692 5.56543 4.18509 5.56543 5.18242 5.56543H21.3475C22.3449 5.56543 24.433 5.56543 24.433 8.42237C24.433 9.50282 24.2149 10.2197 23.737 10.6872C23.1968 11.2274 22.4695 11.2793 21.7943 11.2793ZM5.18242 9.72099H21.5865C22.054 9.73137 22.4903 9.73137 22.6358 9.58593C22.7085 9.51321 22.8643 9.26387 22.8643 8.42237C22.8643 7.24843 22.5734 7.12376 21.3371 7.12376H5.18242C3.94615 7.12376 3.65526 7.24843 3.65526 8.42237C3.65526 9.26387 3.82148 9.51321 3.88381 9.58593C4.02926 9.72099 4.47598 9.72099 4.93309 9.72099H5.18242Z" fill="#333333"/>
                                                                    <path d="M10.9386 19.2786C10.5126 19.2786 10.1594 18.9254 10.1594 18.4994V14.8114C10.1594 14.3854 10.5126 14.0322 10.9386 14.0322C11.3645 14.0322 11.7178 14.3854 11.7178 14.8114V18.4994C11.7178 18.9358 11.3645 19.2786 10.9386 19.2786Z" fill="#333333"/>
                                                                    <path d="M15.7181 19.2786C15.2922 19.2786 14.939 18.9254 14.939 18.4994V14.8114C14.939 14.3854 15.2922 14.0322 15.7181 14.0322C16.1441 14.0322 16.4973 14.3854 16.4973 14.8114V18.4994C16.4973 18.9358 16.1441 19.2786 15.7181 19.2786Z" fill="#333333"/>
                                                                    <path d="M16.2684 23.9008H10.0039C6.28467 23.9008 5.45355 21.6879 5.1315 19.766L3.66667 10.7796C3.59394 10.3536 3.88483 9.95887 4.31078 9.88615C4.73672 9.81343 5.1315 10.1043 5.20422 10.5303L6.66905 19.5063C6.97033 21.3451 7.59367 22.3424 10.0039 22.3424H16.2684C18.9383 22.3424 19.2396 21.4074 19.5824 19.5998L21.3278 10.5095C21.4109 10.0835 21.8161 9.80304 22.242 9.89654C22.6679 9.97965 22.9381 10.3848 22.8549 10.8108L21.1096 19.901C20.7044 22.01 20.0292 23.9008 16.2684 23.9008Z" fill="#333333"/>
                                                                </svg>
                                                            </a>
                                                        @else
                                                            <a href="javascript:void(0)" data-id="{{ $latestProduct->id }}" class="compare-btn cart-btn add_to_cart">
                                                                <svg width="26" height="26" viewBox="0 0 26 26" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                    <path d="M6.19063 6.89429C5.99324 6.89429 5.78547 6.81117 5.64002 6.66573C5.33874 6.36445 5.33874 5.86579 5.64002 5.56451L9.41119 1.79334C9.71247 1.49206 10.2111 1.49206 10.5124 1.79334C10.8137 2.09462 10.8137 2.59329 10.5124 2.89456L6.74124 6.66573C6.58541 6.81117 6.38802 6.89429 6.19063 6.89429Z" fill="#333333"/>
                                                                    <path d="M20.3397 6.89429C20.1423 6.89429 19.945 6.82156 19.7891 6.66573L16.018 2.89456C15.7167 2.59329 15.7167 2.09462 16.018 1.79334C16.3192 1.49206 16.8179 1.49206 17.1192 1.79334L20.8903 5.56451C21.1916 5.86579 21.1916 6.36445 20.8903 6.66573C20.7449 6.81117 20.5371 6.89429 20.3397 6.89429Z" fill="#333333"/>
                                                                    <path d="M21.7943 11.2793C21.7215 11.2793 21.6488 11.2793 21.5761 11.2793H21.3371H4.95387C4.22665 11.2897 3.39553 11.2897 2.79298 10.6872C2.31509 10.2197 2.09692 9.49243 2.09692 8.42237C2.09692 5.56543 4.18509 5.56543 5.18242 5.56543H21.3475C22.3449 5.56543 24.433 5.56543 24.433 8.42237C24.433 9.50282 24.2149 10.2197 23.737 10.6872C23.1968 11.2274 22.4695 11.2793 21.7943 11.2793ZM5.18242 9.72099H21.5865C22.054 9.73137 22.4903 9.73137 22.6358 9.58593C22.7085 9.51321 22.8643 9.26387 22.8643 8.42237C22.8643 7.24843 22.5734 7.12376 21.3371 7.12376H5.18242C3.94615 7.12376 3.65526 7.24843 3.65526 8.42237C3.65526 9.26387 3.82148 9.51321 3.88381 9.58593C4.02926 9.72099 4.47598 9.72099 4.93309 9.72099H5.18242Z" fill="#333333"/>
                                                                    <path d="M10.9386 19.2786C10.5126 19.2786 10.1594 18.9254 10.1594 18.4994V14.8114C10.1594 14.3854 10.5126 14.0322 10.9386 14.0322C11.3645 14.0322 11.7178 14.3854 11.7178 14.8114V18.4994C11.7178 18.9358 11.3645 19.2786 10.9386 19.2786Z" fill="#333333"/>
                                                                    <path d="M15.7181 19.2786C15.2922 19.2786 14.939 18.9254 14.939 18.4994V14.8114C14.939 14.3854 15.2922 14.0322 15.7181 14.0322C16.1441 14.0322 16.4973 14.3854 16.4973 14.8114V18.4994C16.4973 18.9358 16.1441 19.2786 15.7181 19.2786Z" fill="#333333"/>
                                                                    <path d="M16.2684 23.9008H10.0039C6.28467 23.9008 5.45355 21.6879 5.1315 19.766L3.66667 10.7796C3.59394 10.3536 3.88483 9.95887 4.31078 9.88615C4.73672 9.81343 5.1315 10.1043 5.20422 10.5303L6.66905 19.5063C6.97033 21.3451 7.59367 22.3424 10.0039 22.3424H16.2684C18.9383 22.3424 19.2396 21.4074 19.5824 19.5998L21.3278 10.5095C21.4109 10.0835 21.8161 9.80304 22.242 9.89654C22.6679 9.97965 22.9381 10.3848 22.8549 10.8108L21.1096 19.901C20.7044 22.01 20.0292 23.9008 16.2684 23.9008Z" fill="#333333"/>
                                                                </svg>
                                                            </a>
                                                        @endif
                                                    </div>
                                                    @if (Auth::guard('customers')->check())
                                                        @if (!empty($wishlist) && isset($wishlist[$latestProduct->id]['product_id']))
                                                            @if ($wishlist[$latestProduct->id]['product_id'] != $latestProduct->id)
                                                                <div class="pro-btn">
                                                                    <a href="javascript:void(0)" data-id="{{ $latestProduct->id }}" class="wishlist-btn heart-icon action-item wishlist-icon bg-light-gray add_to_wishlist wishlist_{{ $latestProduct->id }}">
                                                                        <svg width="28" height="23" viewBox="0 0 28 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                            <path d="M0.599095 7.38008L0.599095 7.38008C0.539537 4.05401 2.33093 1.69577 4.77155 0.848363C7.21517 -8.66357e-05 10.4236 0.630794 13.2378 3.54845L13.5977 3.92156L13.9575 3.54845C16.7713 0.631207 19.9795 1.89873e-05 22.4231 0.848089C24.8636 1.69511 26.6552 4.05284 26.5962 7.37893C26.5427 10.402 24.4323 13.5144 21.6585 16.2578C19.0068 18.8804 15.8394 21.077 13.5977 22.4186C11.3561 21.0771 8.18894 18.8807 5.53733 16.2583C2.76364 13.5152 0.653182 10.4029 0.599095 7.38008Z" fill="white" stroke="black"></path>
                                                                        </svg>
                                                                    </a>
                                                                </div>
                                                            @else
                                                                <div class="pro-btn">
                                                                    <a href="javascript:void(0)" data-id="{{ $latestProduct->id }}" class="wishlist-btn wishlist-active heart-icon action-item wishlist-icon bg-light-gray" disabled>
                                                                        <svg width="28" height="23" viewBox="0 0 28 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                            <path d="M0.599095 7.38008L0.599095 7.38008C0.539537 4.05401 2.33093 1.69577 4.77155 0.848363C7.21517 -8.66357e-05 10.4236 0.630794 13.2378 3.54845L13.5977 3.92156L13.9575 3.54845C16.7713 0.631207 19.9795 1.89873e-05 22.4231 0.848089C24.8636 1.69511 26.6552 4.05284 26.5962 7.37893C26.5427 10.402 24.4323 13.5144 21.6585 16.2578C19.0068 18.8804 15.8394 21.077 13.5977 22.4186C11.3561 21.0771 8.18894 18.8807 5.53733 16.2583C2.76364 13.5152 0.653182 10.4029 0.599095 7.38008Z" fill="white" stroke="black"></path>
                                                                        </svg>
                                                                    </a>
                                                                </div>
                                                            @endif
                                                        @else
                                                            <div class="pro-btn">
                                                                <a href="javascript:void(0)" data-id="{{ $latestProduct->id }}" class="wishlist-btn heart-icon action-item wishlist-icon bg-light-gray add_to_wishlist wishlist_{{ $latestProduct->id }}">
                                                                    <svg width="28" height="23" viewBox="0 0 28 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                        <path d="M0.599095 7.38008L0.599095 7.38008C0.539537 4.05401 2.33093 1.69577 4.77155 0.848363C7.21517 -8.66357e-05 10.4236 0.630794 13.2378 3.54845L13.5977 3.92156L13.9575 3.54845C16.7713 0.631207 19.9795 1.89873e-05 22.4231 0.848089C24.8636 1.69511 26.6552 4.05284 26.5962 7.37893C26.5427 10.402 24.4323 13.5144 21.6585 16.2578C19.0068 18.8804 15.8394 21.077 13.5977 22.4186C11.3561 21.0771 8.18894 18.8807 5.53733 16.2583C2.76364 13.5152 0.653182 10.4029 0.599095 7.38008Z" fill="white" stroke="black"></path>
                                                                    </svg>
                                                                </a>
                                                            </div>
                                                        @endif
                                                    @else
                                                        <div class="pro-btn">
                                                            <a href="javascript:void(0)" data-id="{{ $latestProduct->id }}" class="wishlist-btn heart-icon action-item wishlist-icon bg-light-gray add_to_wishlist wishlist_{{ $latestProduct->id }}">
                                                                <svg width="28" height="23" viewBox="0 0 28 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                    <path d="M0.599095 7.38008L0.599095 7.38008C0.539537 4.05401 2.33093 1.69577 4.77155 0.848363C7.21517 -8.66357e-05 10.4236 0.630794 13.2378 3.54845L13.5977 3.92156L13.9575 3.54845C16.7713 0.631207 19.9795 1.89873e-05 22.4231 0.848089C24.8636 1.69511 26.6552 4.05284 26.5962 7.37893C26.5427 10.402 24.4323 13.5144 21.6585 16.2578C19.0068 18.8804 15.8394 21.077 13.5977 22.4186C11.3561 21.0771 8.18894 18.8807 5.53733 16.2583C2.76364 13.5152 0.653182 10.4029 0.599095 7.38008Z" fill="white" stroke="black"></path>
                                                                </svg>
                                                            </a>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="product-content">
                                                <div class="product-content-top">
                                                    <h3>
                                                        <a href="{{ route('store.product.product_view', [$store->slug, $latestProduct->id]) }}">{{ $latestProduct->name }}</a>
                                                    </h3>
                                                </div>
                                                <div class="product-content-bottom">
                                                    <div class="price">
                                                        @if ($latestProduct->enable_product_variant == 'on')
                                                            <ins>{{ __('In variant') }}</ins>
                                                        @else
                                                            <ins>{{ \App\Models\Utility::priceFormat($latestProduct->price) }}</ins>
                                                            <del>{{ \App\Models\Utility::priceFormat($latestProduct->last_price) }}</del>
                                                        @endif
                                                    </div>
                                                    <div class="pro-card-label">
                                                        <span>{{ $latestProduct->product_category() }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="col-2 arrival-text-col">
                            <div class="arrival-bg-text">
                                <span>{{ $latestCatBgText }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @endif
    @endforeach

    @foreach ($getStoreThemeSetting as $ThemeSetting)
        @if (isset($ThemeSetting['section_name']) &&
                $ThemeSetting['section_name'] == 'Latest-Category' &&
                $ThemeSetting['section_enable'] == 'on')
            @php
                $homepage_header_title_key = array_search('Title', array_column($ThemeSetting['inner-list'], 'field_name'));
                $homepage_header_title = $ThemeSetting['inner-list'][$homepage_header_title_key]['field_default_text'];

                $homepage_header_subtxt_key = array_search('Sub text', array_column($ThemeSetting['inner-list'], 'field_name'));
                $homepage_header_subtxt = $ThemeSetting['inner-list'][$homepage_header_subtxt_key]['field_default_text'];

                $homepage_header_btn_key = array_search('Button', array_column($ThemeSetting['inner-list'], 'field_name'));
                $homepage_header_btn = $ThemeSetting['inner-list'][$homepage_header_btn_key]['field_default_text'];
            @endphp
            <section class="latest-category-sec pb pt">
                <div class="container">
                    <div class="row align-center">
                        <div class="col-lg-4 col-12">
                            <div class="section-title">
                                <h2>{{ $homepage_header_title }}</h2>
                                <p>{{ $homepage_header_subtxt }}</p>
                            </div>
                            <div class="btn-wrp">
                                <a href="{{ route('store.categorie.product', $store->slug) }}" class="btn">{{ $homepage_header_btn }}</a>
                            </div>
                        </div>
                        <div class="col-lg-8 col-12">
                            <div class="latest-category-slider">
                                @foreach ($latest2category as $key_c => $category)
                                    @if ($key_c < 2)
                                        <div class="latest-category-card">
                                            <div class="latest-category-image img-ratio">
                                                <a href="{{ route('store.categorie.product', [$store->slug, $category->name]) }}">
                                                    @if (!empty($category->categorie_img))
                                                        <img src="{{ $productImg . (!empty($category->categorie_img) ? $category->categorie_img : 'default.jpg') }}" alt="category-image" loading="lazy">
                                                    @else
                                                        <img src="{{ asset(Storage::url('uploads/product_image/default.jpg')) }}" alt="category-image" loading="lazy">
                                                    @endif
                                                </a>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @endif
    @endforeach

    @if (count($topRatedProducts) > 0)
        <section class="top-rated-product-sec">
            <div class="container">
                <div class="section-title">
                    <div class="section-content-top flex justify-between">
                        <h2>{{ __('Top Rated Products') }}</h2>
                        <div class="btn-wrp">
                            <a href="{{ route('store.categorie.product', $store->slug) }}" class="btn">{{ __('Go To Shop') }}</a>
                        </div>
                    </div>
                </div>
                <div class="top-rated-product-slider">
                    @foreach ($topRatedProducts as $k => $topRatedProduct)
                        <div class="product-card">
                            <div class="product-card-inner">
                                <div class="product-card-image">
                                    <a href="{{ route('store.product.product_view', [$store->slug, $topRatedProduct->product_id]) }}" class="default-img img-wrapper">
                                        @if (!empty($topRatedProduct->product->is_cover))
                                            <img src="{{ $coverImg . $topRatedProduct->product->is_cover }}" alt="product-card-image"
                                                loading="lazy">
                                        @else
                                            <img src="{{ asset(Storage::url('uploads/is_cover_image/default.jpg')) }}" alt="product-card-image"
                                                loading="lazy">
                                        @endif
                                    </a>
                                    <a href="{{ route('store.product.product_view', [$store->slug, $topRatedProduct->product_id]) }}" class="hover-img img-wrapper">
                                        @if (isset($topRatedProduct->product) && isset($topRatedProduct->product->product_img) && !empty($topRatedProduct->product->product_img->product_images))
                                            <img src="{{ $productImg . $topRatedProduct->product->product_img->product_images }}" alt="product-card-image"
                                                loading="lazy">
                                        @elseif (!empty($topRatedProduct->product->is_cover))
                                            <img src="{{ $coverImg . $topRatedProduct->product->is_cover }}" alt="product-card-image"
                                                loading="lazy">
                                        @else
                                            <img src="{{ asset(Storage::url('uploads/is_cover_image/default.jpg')) }}" alt="product-card-image"
                                                loading="lazy">
                                        @endif
                                    </a>
                                    <div class="pro-btn-wrapper">
                                        <div class="pro-btn">
                                            @if ($topRatedProduct->product->enable_product_variant == 'on')
                                                <a href="{{ route('store.product.product_view', [$store->slug, $topRatedProduct->product->id]) }}" class="compare-btn cart-btn">
                                                    <svg width="26" height="26" viewBox="0 0 26 26" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M6.19063 6.89429C5.99324 6.89429 5.78547 6.81117 5.64002 6.66573C5.33874 6.36445 5.33874 5.86579 5.64002 5.56451L9.41119 1.79334C9.71247 1.49206 10.2111 1.49206 10.5124 1.79334C10.8137 2.09462 10.8137 2.59329 10.5124 2.89456L6.74124 6.66573C6.58541 6.81117 6.38802 6.89429 6.19063 6.89429Z" fill="#333333"/>
                                                        <path d="M20.3397 6.89429C20.1423 6.89429 19.945 6.82156 19.7891 6.66573L16.018 2.89456C15.7167 2.59329 15.7167 2.09462 16.018 1.79334C16.3192 1.49206 16.8179 1.49206 17.1192 1.79334L20.8903 5.56451C21.1916 5.86579 21.1916 6.36445 20.8903 6.66573C20.7449 6.81117 20.5371 6.89429 20.3397 6.89429Z" fill="#333333"/>
                                                        <path d="M21.7943 11.2793C21.7215 11.2793 21.6488 11.2793 21.5761 11.2793H21.3371H4.95387C4.22665 11.2897 3.39553 11.2897 2.79298 10.6872C2.31509 10.2197 2.09692 9.49243 2.09692 8.42237C2.09692 5.56543 4.18509 5.56543 5.18242 5.56543H21.3475C22.3449 5.56543 24.433 5.56543 24.433 8.42237C24.433 9.50282 24.2149 10.2197 23.737 10.6872C23.1968 11.2274 22.4695 11.2793 21.7943 11.2793ZM5.18242 9.72099H21.5865C22.054 9.73137 22.4903 9.73137 22.6358 9.58593C22.7085 9.51321 22.8643 9.26387 22.8643 8.42237C22.8643 7.24843 22.5734 7.12376 21.3371 7.12376H5.18242C3.94615 7.12376 3.65526 7.24843 3.65526 8.42237C3.65526 9.26387 3.82148 9.51321 3.88381 9.58593C4.02926 9.72099 4.47598 9.72099 4.93309 9.72099H5.18242Z" fill="#333333"/>
                                                        <path d="M10.9386 19.2786C10.5126 19.2786 10.1594 18.9254 10.1594 18.4994V14.8114C10.1594 14.3854 10.5126 14.0322 10.9386 14.0322C11.3645 14.0322 11.7178 14.3854 11.7178 14.8114V18.4994C11.7178 18.9358 11.3645 19.2786 10.9386 19.2786Z" fill="#333333"/>
                                                        <path d="M15.7181 19.2786C15.2922 19.2786 14.939 18.9254 14.939 18.4994V14.8114C14.939 14.3854 15.2922 14.0322 15.7181 14.0322C16.1441 14.0322 16.4973 14.3854 16.4973 14.8114V18.4994C16.4973 18.9358 16.1441 19.2786 15.7181 19.2786Z" fill="#333333"/>
                                                        <path d="M16.2684 23.9008H10.0039C6.28467 23.9008 5.45355 21.6879 5.1315 19.766L3.66667 10.7796C3.59394 10.3536 3.88483 9.95887 4.31078 9.88615C4.73672 9.81343 5.1315 10.1043 5.20422 10.5303L6.66905 19.5063C6.97033 21.3451 7.59367 22.3424 10.0039 22.3424H16.2684C18.9383 22.3424 19.2396 21.4074 19.5824 19.5998L21.3278 10.5095C21.4109 10.0835 21.8161 9.80304 22.242 9.89654C22.6679 9.97965 22.9381 10.3848 22.8549 10.8108L21.1096 19.901C20.7044 22.01 20.0292 23.9008 16.2684 23.9008Z" fill="#333333"/>
                                                    </svg>
                                                </a>
                                            @else
                                                <a data-id="{{ $topRatedProduct->product->id }}" class="compare-btn cart-btn add_to_cart">
                                                    <svg width="26" height="26" viewBox="0 0 26 26" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M6.19063 6.89429C5.99324 6.89429 5.78547 6.81117 5.64002 6.66573C5.33874 6.36445 5.33874 5.86579 5.64002 5.56451L9.41119 1.79334C9.71247 1.49206 10.2111 1.49206 10.5124 1.79334C10.8137 2.09462 10.8137 2.59329 10.5124 2.89456L6.74124 6.66573C6.58541 6.81117 6.38802 6.89429 6.19063 6.89429Z" fill="#333333"/>
                                                        <path d="M20.3397 6.89429C20.1423 6.89429 19.945 6.82156 19.7891 6.66573L16.018 2.89456C15.7167 2.59329 15.7167 2.09462 16.018 1.79334C16.3192 1.49206 16.8179 1.49206 17.1192 1.79334L20.8903 5.56451C21.1916 5.86579 21.1916 6.36445 20.8903 6.66573C20.7449 6.81117 20.5371 6.89429 20.3397 6.89429Z" fill="#333333"/>
                                                        <path d="M21.7943 11.2793C21.7215 11.2793 21.6488 11.2793 21.5761 11.2793H21.3371H4.95387C4.22665 11.2897 3.39553 11.2897 2.79298 10.6872C2.31509 10.2197 2.09692 9.49243 2.09692 8.42237C2.09692 5.56543 4.18509 5.56543 5.18242 5.56543H21.3475C22.3449 5.56543 24.433 5.56543 24.433 8.42237C24.433 9.50282 24.2149 10.2197 23.737 10.6872C23.1968 11.2274 22.4695 11.2793 21.7943 11.2793ZM5.18242 9.72099H21.5865C22.054 9.73137 22.4903 9.73137 22.6358 9.58593C22.7085 9.51321 22.8643 9.26387 22.8643 8.42237C22.8643 7.24843 22.5734 7.12376 21.3371 7.12376H5.18242C3.94615 7.12376 3.65526 7.24843 3.65526 8.42237C3.65526 9.26387 3.82148 9.51321 3.88381 9.58593C4.02926 9.72099 4.47598 9.72099 4.93309 9.72099H5.18242Z" fill="#333333"/>
                                                        <path d="M10.9386 19.2786C10.5126 19.2786 10.1594 18.9254 10.1594 18.4994V14.8114C10.1594 14.3854 10.5126 14.0322 10.9386 14.0322C11.3645 14.0322 11.7178 14.3854 11.7178 14.8114V18.4994C11.7178 18.9358 11.3645 19.2786 10.9386 19.2786Z" fill="#333333"/>
                                                        <path d="M15.7181 19.2786C15.2922 19.2786 14.939 18.9254 14.939 18.4994V14.8114C14.939 14.3854 15.2922 14.0322 15.7181 14.0322C16.1441 14.0322 16.4973 14.3854 16.4973 14.8114V18.4994C16.4973 18.9358 16.1441 19.2786 15.7181 19.2786Z" fill="#333333"/>
                                                        <path d="M16.2684 23.9008H10.0039C6.28467 23.9008 5.45355 21.6879 5.1315 19.766L3.66667 10.7796C3.59394 10.3536 3.88483 9.95887 4.31078 9.88615C4.73672 9.81343 5.1315 10.1043 5.20422 10.5303L6.66905 19.5063C6.97033 21.3451 7.59367 22.3424 10.0039 22.3424H16.2684C18.9383 22.3424 19.2396 21.4074 19.5824 19.5998L21.3278 10.5095C21.4109 10.0835 21.8161 9.80304 22.242 9.89654C22.6679 9.97965 22.9381 10.3848 22.8549 10.8108L21.1096 19.901C20.7044 22.01 20.0292 23.9008 16.2684 23.9008Z" fill="#333333"/>
                                                    </svg>
                                                </a>
                                            @endif
                                        </div>
                                        <div class="pro-btn">
                                            @if (Auth::guard('customers')->check())
                                                @if (!empty($wishlist) && isset($wishlist[$topRatedProduct->product->id]['product_id']))
                                                    @if ($wishlist[$topRatedProduct->product->id]['product_id'] != $topRatedProduct->product->id)
                                                        <a href="javascript:void(0)" tabindex="0" class="wishlist-btn add_to_wishlist wishlist_{{ $topRatedProduct->product->id }}"
                                                            data-id="{{ $topRatedProduct->product->id }}">
                                                            <svg width="28" height="23" viewBox="0 0 28 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M0.599095 7.38008L0.599095 7.38008C0.539537 4.05401 2.33093 1.69577 4.77155 0.848363C7.21517 -8.66357e-05 10.4236 0.630794 13.2378 3.54845L13.5977 3.92156L13.9575 3.54845C16.7713 0.631207 19.9795 1.89873e-05 22.4231 0.848089C24.8636 1.69511 26.6552 4.05284 26.5962 7.37893C26.5427 10.402 24.4323 13.5144 21.6585 16.2578C19.0068 18.8804 15.8394 21.077 13.5977 22.4186C11.3561 21.0771 8.18894 18.8807 5.53733 16.2583C2.76364 13.5152 0.653182 10.4029 0.599095 7.38008Z" fill="white" stroke="black"></path>
                                                            </svg>
                                                        </a>
                                                    @else
                                                        <a href="javascript:void(0)" tabindex="0" class="wishlist-btn wishlist-active wishlist_{{ $topRatedProduct->product->id }}"
                                                            disabled>
                                                            <svg width="28" height="23" viewBox="0 0 28 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M0.599095 7.38008L0.599095 7.38008C0.539537 4.05401 2.33093 1.69577 4.77155 0.848363C7.21517 -8.66357e-05 10.4236 0.630794 13.2378 3.54845L13.5977 3.92156L13.9575 3.54845C16.7713 0.631207 19.9795 1.89873e-05 22.4231 0.848089C24.8636 1.69511 26.6552 4.05284 26.5962 7.37893C26.5427 10.402 24.4323 13.5144 21.6585 16.2578C19.0068 18.8804 15.8394 21.077 13.5977 22.4186C11.3561 21.0771 8.18894 18.8807 5.53733 16.2583C2.76364 13.5152 0.653182 10.4029 0.599095 7.38008Z" fill="white" stroke="black"></path>
                                                            </svg>
                                                        </a>
                                                    @endif
                                                @else
                                                    <a href="javascript:void(0)" tabindex="0" class="wishlist-btn add_to_wishlist wishlist_{{ $topRatedProduct->product->id }}"
                                                        data-id="{{ $topRatedProduct->product->id }}">
                                                        <svg width="28" height="23" viewBox="0 0 28 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M0.599095 7.38008L0.599095 7.38008C0.539537 4.05401 2.33093 1.69577 4.77155 0.848363C7.21517 -8.66357e-05 10.4236 0.630794 13.2378 3.54845L13.5977 3.92156L13.9575 3.54845C16.7713 0.631207 19.9795 1.89873e-05 22.4231 0.848089C24.8636 1.69511 26.6552 4.05284 26.5962 7.37893C26.5427 10.402 24.4323 13.5144 21.6585 16.2578C19.0068 18.8804 15.8394 21.077 13.5977 22.4186C11.3561 21.0771 8.18894 18.8807 5.53733 16.2583C2.76364 13.5152 0.653182 10.4029 0.599095 7.38008Z" fill="white" stroke="black"></path>
                                                        </svg>
                                                    </a>
                                                @endif
                                            @else
                                                <a href="javascript:void(0)" class="wishlist-btn add_to_wishlist wishlist_{{ $topRatedProduct->product->id }}"
                                                    data-id="{{ $topRatedProduct->product->id }}">
                                                    <svg width="28" height="23" viewBox="0 0 28 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M0.599095 7.38008L0.599095 7.38008C0.539537 4.05401 2.33093 1.69577 4.77155 0.848363C7.21517 -8.66357e-05 10.4236 0.630794 13.2378 3.54845L13.5977 3.92156L13.9575 3.54845C16.7713 0.631207 19.9795 1.89873e-05 22.4231 0.848089C24.8636 1.69511 26.6552 4.05284 26.5962 7.37893C26.5427 10.402 24.4323 13.5144 21.6585 16.2578C19.0068 18.8804 15.8394 21.077 13.5977 22.4186C11.3561 21.0771 8.18894 18.8807 5.53733 16.2583C2.76364 13.5152 0.653182 10.4029 0.599095 7.38008Z" fill="white" stroke="black"></path>
                                                    </svg>
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="product-content">
                                    <div class="product-content-top">
                                        <h3>
                                            <a href="{{ route('store.product.product_view', [$store->slug, $topRatedProduct->product->id]) }}">{{ $topRatedProduct->product->name }}</a>
                                        </h3>
                                    </div>
                                    <div class="product-content-bottom">
                                        <div class="price">
                                            @if ($topRatedProduct->product->enable_product_variant == 'on')
                                                <ins>{{ __('In variant') }}</ins>
                                            @else
                                                <ins>{{ \App\Models\Utility::priceFormat($topRatedProduct->product->price) }}</ins>
                                                <del>{{ \App\Models\Utility::priceFormat($topRatedProduct->product->last_price) }}</del>
                                            @endif
                                        </div>
                                        <div class="pro-card-label">
                                            <span>{{ $topRatedProduct->product->product_category() }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    @foreach ($getStoreThemeSetting as $ThemeSetting)
        @if (isset($ThemeSetting['section_name']) &&
                $ThemeSetting['section_name'] == 'Top-Purchased' &&
                $ThemeSetting['section_enable'] == 'on')
            @php
                $homepage_header_img_key = array_search('Background Image', array_column($ThemeSetting['inner-list'], 'field_name'));
                $homepage_header_img = $ThemeSetting['inner-list'][$homepage_header_img_key]['field_default_text'];

                $homepage_header_title_key = array_search('Title', array_column($ThemeSetting['inner-list'], 'field_name'));
                $homepage_header_title = $ThemeSetting['inner-list'][$homepage_header_title_key]['field_default_text'];

                $homepage_header_subtext_key = array_search('Sub text', array_column($ThemeSetting['inner-list'], 'field_name'));
                $homepage_header_subtext = $ThemeSetting['inner-list'][$homepage_header_subtext_key]['field_default_text'];

                $homepage_header_btn_key = array_search('Button Text', array_column($ThemeSetting['inner-list'], 'field_name'));
                $homepage_header_btn = $ThemeSetting['inner-list'][$homepage_header_btn_key]['field_default_text'];
            @endphp
            <section class="purchased-product-sec" style="background-image: url({{ $imgpath . $homepage_header_img }});">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-8 col-md-7 col-12">
                            @if(!empty($mostPurchasedDetail))
                                <div class="purchased-product-image img-ratio">
                                    @if (!empty($mostPurchasedDetail->is_cover))
                                        <img src="{{ $coverImg. $mostPurchasedDetail->is_cover }}" alt="product-image" loading="lazy">
                                    @else
                                        <img src="{{ asset(Storage::url('uploads/is_cover_image/default.jpg')) }}" alt="product-image" loading="lazy">
                                    @endif
                                </div>
                            @endif
                        </div>
                        <div class="col-lg-4 col-md-5 col-12">
                            <div class="purchased-banner-col">
                                <div class="section-title">
                                    <h2>{{ $homepage_header_title }}</h2>
                                    <p>{{ $homepage_header_subtext }}</p>
                                </div>
                                <div class="btn-wrp">
                                    @if(!empty($mostPurchasedDetail))
                                        <a href="{{ route('store.product.product_view', [$store->slug, $mostPurchasedDetail->id]) }}" class="btn">{{ $homepage_header_btn }}</a>
                                    @else
                                        <a href="{{ route('store.categorie.product', $store->slug) }}" class="btn btn-white">{{ $homepage_header_btn }}</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @endif
    @endforeach

    @foreach ($getStoreThemeSetting as $storethemesetting)
        @if (isset($storethemesetting['section_name']) &&
                $storethemesetting['section_name'] == 'Home-Testimonial' &&
                $storethemesetting['array_type'] == 'inner-list' &&
                $storethemesetting['section_enable'] == 'on')
            @php
                $Heading_key = array_search('Heading', array_column($storethemesetting['inner-list'], 'field_name'));
                $Heading = $storethemesetting['inner-list'][$Heading_key]['field_default_text'];

            @endphp
            <section class="testimonial-sec pb">
                <div class="testimonial-bg-animation">
                    <span>{{ $Heading }}</span>
                </div>
                <div class="container">
                    <div class="testimonial-slider">
                        @foreach ($testimonials as $key => $testimonial)
                            <div class="testimonial-card">
                                <div class="testimonial-card-inner">
                                    <div class="testimonial-image">
                                        <img src="{{ $testimonialImg . (!empty($testimonial->image) ? $testimonial->image : 'avatar.png') }}" alt="testimonial-img" loading="lazy">
                                    </div>
                                    <div class="testimonial-content text-center">
                                        <h3>{{ $testimonial->title ?? '' }}</h3>
                                        <span>{{ $testimonial->sub_title ?? '' }}</span>
                                        <div class="testimonial-rating product-rating">
                                            @for ($i = 1; $i <= 5; $i++)
                                                @php
                                                    $icon = 'fa-star';
                                                    $color = '';
                                                    $newVal1 = $i - 0.5;
                                                    if ($testimonial->ratting >= $newVal1) {
                                                        $color = 'text-warning';
                                                    }
                                                    if ($testimonial->ratting < $i && $testimonial->ratting >= $newVal1) {
                                                        $icon = 'fa-star-half-alt';
                                                    }
                                                @endphp
                                                <i class="star fas {{ $icon . ' ' . $color }}"></i>
                                            @endfor
                                        </div>
                                        <p>{{ $testimonial->description ?? '' }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif
    @endforeach

    @if ($getStoreThemeSetting[6]['section_enable'] == 'on')
        <section class="social-media-sec pb">
            <div class="container">
                <div class="section-title text-center">
                    <h2>{{ $getStoreThemeSetting[6]['inner-list'][1]['field_default_text'] }}</h2>
                    <p>{{ $getStoreThemeSetting[6]['inner-list'][2]['field_default_text'] }}</p>
                </div>
                <div class="social-media-slider">
                    @foreach ($getStoreThemeSetting as $key => $storethemesetting)
                        @if (isset($storethemesetting['section_name']) && $storethemesetting['section_name'] == 'Home-Brand-Logo' && $storethemesetting['section_enable'] == 'on')
                            @foreach ($storethemesetting['inner-list'] as $image)
                                @if ($image['field_slug'] == 'homepage-brand-logo-input')
                                    @if (!empty($image['image_path']))
                                        @foreach ($image['image_path'] as $img)
                                            <div class="social-media-card">
                                                <div class="social-media-img img-ratio">
                                                    <img src="{{ $imgpath . (!empty($img) ? $img : 'theme7/brand_logo/brand_logo.png') }}" alt="social-media-card-image" loading="lazy">
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="social-media-card">
                                            <div class="social-media-img img-ratio">
                                                <img src="{{ $default }}" alt="social-media-card-image" loading="lazy">
                                            </div>
                                        </div>
                                    @endif
                                @endif
                            @endforeach
                        @endif
                    @endforeach
                </div>
            </div>
        </section>
    @endif
    
    @foreach ($getStoreThemeSetting as $storethemesetting)
        @if (isset($storethemesetting['section_name']) &&
                $storethemesetting['section_name'] == 'Home-Email-Subscriber' &&
                $storethemesetting['section_enable'] == 'on')
            @php
                $SubscriberTitle_key = array_search('Subscriber Title', array_column($storethemesetting['inner-list'], 'field_name'));
                $SubscriberTitle = $storethemesetting['inner-list'][$SubscriberTitle_key]['field_default_text'];

                $SubscriberButton_key = array_search('Button Text', array_column($storethemesetting['inner-list'], 'field_name'));
                $SubscriberButton = $storethemesetting['inner-list'][$SubscriberButton_key]['field_default_text'];
            @endphp
            <section class="subscribe-sec pb">
                <div class="container">
                    <div class="section-title">
                        <h2>{{ $SubscriberTitle }}</h2>
                    </div>
                    {{ Form::open(['route' => ['subscriptions.store_email', $store->id], 'method' => 'POST', 'class' => 'subscribe-form']) }}
                        <div class="input-wrapper flex">
                            {{ Form::email('email', null, ['placeholder' => __('Enter Your Email Address'), 'class' => 'newsletter-input', 'required' => 'required']) }}
                            <button type="submit" class="btn">{{ $SubscriberButton }}
                                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40" fill="none">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M28.6143 11.3858L15.4142 20.5505L1.60749 15.9477C0.643763 15.6258 -0.00550973 14.7216 3.52419e-05 13.7057C0.00565318 12.6899 0.662368 11.7913 1.62982 11.4806L36.9289 0.113033C37.7679 -0.156701 38.6889 0.0646601 39.3122 0.687959C39.9354 1.31126 40.1568 2.23216 39.887 3.07128L28.5195 38.3702C28.2088 39.3377 27.3101 39.9944 26.2943 40C25.2785 40.0056 24.3743 39.3563 24.0524 38.3926L19.4272 24.519L28.6143 11.3858Z" fill="white"></path>
                                </svg>
                            </button>
                        </div>
                    {{ Form::close() }}
                </div>
            </section>
        @endif
    @endforeach
</main>
@endsection

