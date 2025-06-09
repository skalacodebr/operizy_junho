@extends('storefront.layout.theme7')

@section('page-title')
    {{ __('Home') }}
@endsection

@push('css-page')
@endpush

@php
$imgpath=\App\Models\Utility::get_file('uploads/');
$default =\App\Models\Utility::get_file('uploads/theme7/header/img01.png');
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
        @if (isset($ThemeSetting['section_name']) && $ThemeSetting['section_name'] == 'Home-Header' && $ThemeSetting['section_enable'] == 'on')
            @php
                $homepage_header_sub_title_key = array_search('Sub Title', array_column($ThemeSetting['inner-list'], 'field_name'));
                $homepage_header_title_key = array_search('Title', array_column($ThemeSetting['inner-list'], 'field_name'));
                $homepage_header_Sub_text_key = array_search('Sub text', array_column($ThemeSetting['inner-list'], 'field_name'));
                $homepage_header_Button_key = array_search('Button', array_column($ThemeSetting['inner-list'], 'field_name'));
                $homepage_header_bckground_Image_key = array_search('Background Image', array_column($ThemeSetting['inner-list'], 'field_name'));

                if(isset($getStoreThemeSetting[0]['homepage-header-sub-title'])){
                    $homepage_header_sub_title = $getStoreThemeSetting[0]['homepage-header-sub-title'][0] ?? $ThemeSetting['inner-list'][$homepage_header_sub_title_key]['field_default_text'];

                    $homepage_header_title = $getStoreThemeSetting[0]['homepage-header-title'][0] ?? $ThemeSetting['inner-list'][$homepage_header_title_key]['field_default_text'];

                    $homepage_header_Sub_text = $getStoreThemeSetting[0]['homepage-sub-text'][0] ?? $ThemeSetting['inner-list'][$homepage_header_Sub_text_key]['field_default_text'];
                    
                    $homepage_header_Button = $getStoreThemeSetting[0]['homepage-header-button'][0] ?? $ThemeSetting['inner-list'][$homepage_header_Button_key]['field_default_text'];
                    
                    $homepage_header_bckground_Image = $getStoreThemeSetting[0]['homepage-header-bg-image'][0]['image'] ?? $ThemeSetting['inner-list'][$homepage_header_bckground_Image_key]['field_default_text'];
                } else {
                    $homepage_header_sub_title = $ThemeSetting['inner-list'][$homepage_header_sub_title_key]['field_default_text'];

                    $homepage_header_title = $ThemeSetting['inner-list'][$homepage_header_title_key]['field_default_text'];
                    
                    $homepage_header_Sub_text = $ThemeSetting['inner-list'][$homepage_header_Sub_text_key]['field_default_text'];
                    
                    $homepage_header_Button = $ThemeSetting['inner-list'][$homepage_header_Button_key]['field_default_text'];
                    
                    $homepage_header_bckground_Image = $ThemeSetting['inner-list'][$homepage_header_bckground_Image_key]['field_default_text'];
                }
            @endphp
            <section class="home-banner-sec pt mb">
                <div class="container">
                    <div class="row align-center">
                        <div class="col-md-6 col-12">
                            <div class="banner-left-col">
                                <div class="banner-image">
                                    <img src="{{ $imgpath . $homepage_header_bckground_Image }}" alt="banner-image" loading="lazy">
                                </div>
                                <div class="banner-img-content">
                                    <span>{{ $store->name }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="banner-right-col">
                                <div class="section-title">
                                    <div class="subtitle">{{ !empty($homepage_header_sub_title) ? $homepage_header_sub_title : __('Modern Light') }}</div>
                                    <h2>{{ !empty($homepage_header_title) ? $homepage_header_title : 'Unconventional and modern lighting for your home' }}</h2>
                                    <p>{{ !empty($homepage_header_Sub_text) ? $homepage_header_Sub_text : 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old.' }}</p>
                                </div>
                                <div class="btn-wrp">
                                    <a href="{{ route('store.categorie.product', $store->slug) }}" class="btn"> 
                                        {{ !empty($homepage_header_Button) ? $homepage_header_Button : __('Start shopping') }}
                                        <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M6.05543 7.44351C5.83377 7.44351 5.60043 7.35018 5.4371 7.18684C5.09877 6.84851 5.09877 6.28851 5.4371 5.95018L9.6721 1.71518C10.0104 1.37684 10.5704 1.37684 10.9088 1.71518C11.2471 2.05351 11.2471 2.61351 10.9088 2.95184L6.67377 7.18684C6.49877 7.35018 6.2771 7.44351 6.05543 7.44351Z" fill="white"/>
                                            <path d="M21.9457 7.44351C21.724 7.44351 21.5024 7.36184 21.3274 7.18684L17.0924 2.95184C16.754 2.61351 16.754 2.05351 17.0924 1.71518C17.4307 1.37684 17.9907 1.37684 18.329 1.71518L22.564 5.95018C22.9024 6.28851 22.9024 6.84851 22.564 7.18684C22.4007 7.35018 22.1674 7.44351 21.9457 7.44351Z" fill="white"/>
                                            <path d="M23.5778 12.3666C23.4961 12.3666 23.4144 12.3666 23.3328 12.3666H23.0644H4.6661C3.84943 12.3783 2.9161 12.3783 2.23943 11.7016C1.70276 11.1766 1.45776 10.36 1.45776 9.15828C1.45776 5.94995 3.80276 5.94995 4.92276 5.94995H23.0761C24.1961 5.94995 26.5411 5.94995 26.5411 9.15828C26.5411 10.3716 26.2961 11.1766 25.7594 11.7016C25.1528 12.3083 24.3361 12.3666 23.5778 12.3666ZM4.92276 10.6166H23.3444C23.8694 10.6283 24.3594 10.6283 24.5228 10.465C24.6044 10.3833 24.7794 10.1033 24.7794 9.15828C24.7794 7.83995 24.4528 7.69995 23.0644 7.69995H4.92276C3.53443 7.69995 3.20776 7.83995 3.20776 9.15828C3.20776 10.1033 3.39443 10.3833 3.46443 10.465C3.62776 10.6166 4.12943 10.6166 4.64276 10.6166H4.92276Z" fill="white"/>
                                            <path d="M11.3867 21.3499C10.9083 21.3499 10.5117 20.9533 10.5117 20.4749V16.3333C10.5117 15.8549 10.9083 15.4583 11.3867 15.4583C11.865 15.4583 12.2617 15.8549 12.2617 16.3333V20.4749C12.2617 20.9649 11.865 21.3499 11.3867 21.3499Z" fill="white"/>
                                            <path d="M16.7533 21.3499C16.275 21.3499 15.8783 20.9533 15.8783 20.4749V16.3333C15.8783 15.8549 16.275 15.4583 16.7533 15.4583C17.2317 15.4583 17.6283 15.8549 17.6283 16.3333V20.4749C17.6283 20.9649 17.2317 21.3499 16.7533 21.3499Z" fill="white"/>
                                            <path d="M17.3717 26.5419H10.3367C6.16001 26.5419 5.22668 24.0569 4.86501 21.8985L3.22001 11.8069C3.13834 11.3285 3.46501 10.8852 3.94334 10.8035C4.42168 10.7219 4.86501 11.0485 4.94667 11.5269L6.59168 21.6069C6.93001 23.6719 7.63001 24.7919 10.3367 24.7919H17.3717C20.37 24.7919 20.7083 23.7419 21.0933 21.7119L23.0533 11.5035C23.1467 11.0252 23.6017 10.7102 24.08 10.8152C24.5583 10.9085 24.8617 11.3635 24.7683 11.8419L22.8083 22.0502C22.3533 24.4185 21.595 26.5419 17.3717 26.5419Z" fill="white"/>
                                        </svg>                                        
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @endif
    @endforeach
    
    {{-- Promotion --}}
    @include('storefront.promotion')

    @if ($products['Start shopping']->count() > 0)
        <section class="product-sec tabs-wrapper pt pb">
        <div class="container">
            <div class="section-title text-center">
                <h2>{{ __('Trending Products') }}</h2>
            </div>
            <div class="tab-head-row flex justify-center">
                <ul class="tabs product-tabs flex no-wrap align-center">
                    @foreach ($categories as $key => $category)
                        <li class="tab-link {{ $key == 0 ? 'active' : '' }}" data-tab="pdp-tab-{!! preg_replace('/[^A-Za-z0-9\-]/', '_', $category) !!}">
                            <a href="javascript:;" >
                                {{ __($category) }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="tabs-container">
                @foreach ($products as $key => $items)
                    <div id="pdp-tab-{!! preg_replace('/[^A-Za-z0-9\-]/', '_', $key) !!}" class="tab-content {{ $key == 'Start shopping' ? 'active show' : '' }}">
                        @if ($items->count() > 0)
                            <div class="row no-gutters">
                                @foreach ($items as $product)
                                    <div class="col-xl-3 col-md-4 col-sm-6 col-12">
                                        @include('storefront.theme7.common.product_section')
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
    
    @if ($getStoreThemeSetting[2]['section_enable'] == 'on')
        <section class="most-purchased-product-sec" style="background-image: url({{ $imgpath . $getStoreThemeSetting[2]['inner-list'][2]['field_default_text'] }});">
            <div class="container">
                <div class="section-title">
                    <h2>{{ $getStoreThemeSetting[2]['inner-list'][0]['field_default_text'] }}</h2>
                    <p>{{ $getStoreThemeSetting[2]['inner-list'][1]['field_default_text'] }}</p>
                </div>
                <div class="btn-wrp">
                    <a href="{{ route('store.categorie.product', [$store->slug, 'Start shopping']) }}" class="btn" tabindex="0"> {{ $getStoreThemeSetting[2]['inner-list'][3]['field_default_text'] }}</a> 
                </div>
            </div>
        </section>
    @endif
    
    @if (count($topRatedProducts) > 0)
        <section class="top-product-sec pt pb">
            <div class="container">
                <div class="section-title text-center">
                    <h2>{{ __('Top Rated Products') }}</h2>
                </div>
                <div class="top-product-slider">
                    @foreach ($topRatedProducts as $k => $topRatedProduct)
                        <div class="product-card">
                            <div class="product-card-inner">
                                <div class="product-card-image">
                                    <a href="{{ route('store.product.product_view', [$store->slug, $topRatedProduct->product_id]) }}" class="default-img img-wrapper">
                                        @if (!empty($topRatedProduct->product->is_cover))
                                            <img alt="product-card-image" src="{{ $coverImg . $topRatedProduct->product->is_cover }}" >
                                        @else
                                            <img alt="product-card-image" src="{{ asset(Storage::url('uploads/is_cover_image/default.jpg')) }}" >
                                        @endif
                                    </a>
                                    <a href="{{ route('store.product.product_view', [$store->slug, $topRatedProduct->product_id]) }}" class="hover-img img-wrapper">
                                        @if (isset($topRatedProduct->product->product_img) && !empty($topRatedProduct->product->product_img))
                                            <img alt="product-card-image" src="{{ $productImg . $topRatedProduct->product->product_img->product_images }}" >
                                        @elseif (!empty($topRatedProduct->product->is_cover))
                                            <img alt="product-card-image" src="{{ $coverImg . $topRatedProduct->product->is_cover }}" >
                                        @else
                                            <img alt="product-card-image" src="{{ asset(Storage::url('uploads/is_cover_image/default.jpg')) }}" >
                                        @endif
                                    </a>
                                    <div class="pro-btn-wrapper">
                                        @if (Auth::guard('customers')->check())
                                            @if (!empty($wishlist) && isset($wishlist[$topRatedProduct->product->id]['product_id']))
                                                @if ($wishlist[$topRatedProduct->product->id]['product_id'] != $topRatedProduct->product->id)
                                                    <div class="pro-btn">
                                                        <a href="javascript:void(0)" data-id="{{ $topRatedProduct->product->id }}" class="wishlist-btn btn heart-icon action-item wishlist-icon bg-light-gray add_to_wishlist wishlist_{{ $topRatedProduct->product->id }}">
                                                            <svg width="28" height="23" viewBox="0 0 28 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M0.599095 7.38008L0.599095 7.38008C0.539537 4.05401 2.33093 1.69577 4.77155 0.848363C7.21517 -8.66357e-05 10.4236 0.630794 13.2378 3.54845L13.5977 3.92156L13.9575 3.54845C16.7713 0.631207 19.9795 1.89873e-05 22.4231 0.848089C24.8636 1.69511 26.6552 4.05284 26.5962 7.37893C26.5427 10.402 24.4323 13.5144 21.6585 16.2578C19.0068 18.8804 15.8394 21.077 13.5977 22.4186C11.3561 21.0771 8.18894 18.8807 5.53733 16.2583C2.76364 13.5152 0.653182 10.4029 0.599095 7.38008Z" fill="white" stroke="black"></path>
                                                            </svg>
                                                        </a>
                                                    </div>
                                                @else
                                                    <div class="pro-btn">
                                                        <a href="javascript:void(0)" data-id="{{ $topRatedProduct->product->id }}" class="wishlist-btn btn wishlist-active heart-icon action-item wishlist-icon bg-light-gray" disabled>
                                                            <svg width="28" height="23" viewBox="0 0 28 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M0.599095 7.38008L0.599095 7.38008C0.539537 4.05401 2.33093 1.69577 4.77155 0.848363C7.21517 -8.66357e-05 10.4236 0.630794 13.2378 3.54845L13.5977 3.92156L13.9575 3.54845C16.7713 0.631207 19.9795 1.89873e-05 22.4231 0.848089C24.8636 1.69511 26.6552 4.05284 26.5962 7.37893C26.5427 10.402 24.4323 13.5144 21.6585 16.2578C19.0068 18.8804 15.8394 21.077 13.5977 22.4186C11.3561 21.0771 8.18894 18.8807 5.53733 16.2583C2.76364 13.5152 0.653182 10.4029 0.599095 7.38008Z" fill="white" stroke="black"></path>
                                                            </svg>
                                                        </a>
                                                    </div>
                                                @endif
                                            @else
                                                <div class="pro-btn">
                                                    <a href="javascript:void(0)" data-id="{{ $topRatedProduct->product->id }}" class="wishlist-btn btn heart-icon action-item wishlist-icon bg-light-gray add_to_wishlist wishlist_{{ $topRatedProduct->product->id }}">
                                                        <svg width="28" height="23" viewBox="0 0 28 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M0.599095 7.38008L0.599095 7.38008C0.539537 4.05401 2.33093 1.69577 4.77155 0.848363C7.21517 -8.66357e-05 10.4236 0.630794 13.2378 3.54845L13.5977 3.92156L13.9575 3.54845C16.7713 0.631207 19.9795 1.89873e-05 22.4231 0.848089C24.8636 1.69511 26.6552 4.05284 26.5962 7.37893C26.5427 10.402 24.4323 13.5144 21.6585 16.2578C19.0068 18.8804 15.8394 21.077 13.5977 22.4186C11.3561 21.0771 8.18894 18.8807 5.53733 16.2583C2.76364 13.5152 0.653182 10.4029 0.599095 7.38008Z" fill="white" stroke="black"></path>
                                                        </svg>
                                                    </a>
                                                </div>
                                            @endif
                                        @else
                                            <div class="pro-btn">
                                                <a href="javascript:void(0)" data-id="{{ $topRatedProduct->product->id }}" class="wishlist-btn btn heart-icon action-item wishlist-icon bg-light-gray add_to_wishlist wishlist_{{ $topRatedProduct->product->id }}">
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
                                            <a href="{{ route('store.product.product_view', [$store->slug, $topRatedProduct->product->id]) }}">{{ $topRatedProduct->product->name }}</a>
                                        </h3>
                                    </div>
                                    <div class="product-content-bottom">
                                        <div class="product-cart-btn flex align-center justify-end">
                                            @if ($topRatedProduct->product->enable_product_variant == 'on')
                                                <a href="{{ route('store.product.product_view', [$store->slug, $topRatedProduct->product->id]) }}" class="compare-btn cart-btn btn">
                                                    <svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M3.89266 4.78496C3.75016 4.78496 3.60016 4.72496 3.49516 4.61996C3.27766 4.40246 3.27766 4.04246 3.49516 3.82496L6.21766 1.10246C6.43516 0.884956 6.79516 0.884956 7.01266 1.10246C7.23016 1.31996 7.23016 1.67996 7.01266 1.89746L4.29016 4.61996C4.17766 4.72496 4.03516 4.78496 3.89266 4.78496Z"
                                                            fill="white" />
                                                        <path
                                                            d="M14.1083 4.78496C13.9658 4.78496 13.8233 4.73246 13.7108 4.61996L10.9883 1.89746C10.7708 1.67996 10.7708 1.31996 10.9883 1.10246C11.2058 0.884956 11.5658 0.884956 11.7833 1.10246L14.5058 3.82496C14.7233 4.04246 14.7233 4.40246 14.5058 4.61996C14.4008 4.72496 14.2508 4.78496 14.1083 4.78496Z"
                                                            fill="white" />
                                                        <path
                                                            d="M15.1575 7.94995C15.105 7.94995 15.0525 7.94995 15 7.94995H14.8275H3C2.475 7.95745 1.875 7.95745 1.44 7.52245C1.095 7.18495 0.9375 6.65995 0.9375 5.88745C0.9375 3.82495 2.445 3.82495 3.165 3.82495H14.835C15.555 3.82495 17.0625 3.82495 17.0625 5.88745C17.0625 6.66745 16.905 7.18495 16.56 7.52245C16.17 7.91245 15.645 7.94995 15.1575 7.94995ZM3.165 6.82495H15.0075C15.345 6.83245 15.66 6.83245 15.765 6.72745C15.8175 6.67495 15.93 6.49495 15.93 5.88745C15.93 5.03995 15.72 4.94995 14.8275 4.94995H3.165C2.2725 4.94995 2.0625 5.03995 2.0625 5.88745C2.0625 6.49495 2.1825 6.67495 2.2275 6.72745C2.3325 6.82495 2.655 6.82495 2.985 6.82495H3.165Z"
                                                            fill="white" />
                                                        <path
                                                            d="M7.32031 13.7249C7.01281 13.7249 6.75781 13.4699 6.75781 13.1624V10.4999C6.75781 10.1924 7.01281 9.93738 7.32031 9.93738C7.62781 9.93738 7.88281 10.1924 7.88281 10.4999V13.1624C7.88281 13.4774 7.62781 13.7249 7.32031 13.7249Z"
                                                            fill="white" />
                                                        <path
                                                            d="M10.7695 13.7249C10.462 13.7249 10.207 13.4699 10.207 13.1624V10.4999C10.207 10.1924 10.462 9.93738 10.7695 9.93738C11.077 9.93738 11.332 10.1924 11.332 10.4999V13.1624C11.332 13.4774 11.077 13.7249 10.7695 13.7249Z"
                                                            fill="white" />
                                                        <path
                                                            d="M11.1671 17.0626H6.64457C3.95957 17.0626 3.35957 15.4651 3.12707 14.0776L2.06957 7.59006C2.01707 7.28256 2.22707 6.99756 2.53457 6.94506C2.84207 6.89256 3.12707 7.10256 3.17957 7.41006L4.23707 13.8901C4.45457 15.2176 4.90457 15.9376 6.64457 15.9376H11.1671C13.0946 15.9376 13.3121 15.2626 13.5596 13.9576L14.8196 7.39506C14.8796 7.08756 15.1721 6.88506 15.4796 6.95256C15.7871 7.01256 15.9821 7.30506 15.9221 7.61256L14.6621 14.1751C14.3696 15.6976 13.8821 17.0626 11.1671 17.0626Z"
                                                            fill="white" />
                                                    </svg>
                                                </a>
                                            @else
                                                <a href="javascript:void(0)" data-id="{{ $topRatedProduct->product->id }}" class="compare-btn cart-btn btn add_to_cart">
                                                    <svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M3.89266 4.78496C3.75016 4.78496 3.60016 4.72496 3.49516 4.61996C3.27766 4.40246 3.27766 4.04246 3.49516 3.82496L6.21766 1.10246C6.43516 0.884956 6.79516 0.884956 7.01266 1.10246C7.23016 1.31996 7.23016 1.67996 7.01266 1.89746L4.29016 4.61996C4.17766 4.72496 4.03516 4.78496 3.89266 4.78496Z"
                                                            fill="white" />
                                                        <path
                                                            d="M14.1083 4.78496C13.9658 4.78496 13.8233 4.73246 13.7108 4.61996L10.9883 1.89746C10.7708 1.67996 10.7708 1.31996 10.9883 1.10246C11.2058 0.884956 11.5658 0.884956 11.7833 1.10246L14.5058 3.82496C14.7233 4.04246 14.7233 4.40246 14.5058 4.61996C14.4008 4.72496 14.2508 4.78496 14.1083 4.78496Z"
                                                            fill="white" />
                                                        <path
                                                            d="M15.1575 7.94995C15.105 7.94995 15.0525 7.94995 15 7.94995H14.8275H3C2.475 7.95745 1.875 7.95745 1.44 7.52245C1.095 7.18495 0.9375 6.65995 0.9375 5.88745C0.9375 3.82495 2.445 3.82495 3.165 3.82495H14.835C15.555 3.82495 17.0625 3.82495 17.0625 5.88745C17.0625 6.66745 16.905 7.18495 16.56 7.52245C16.17 7.91245 15.645 7.94995 15.1575 7.94995ZM3.165 6.82495H15.0075C15.345 6.83245 15.66 6.83245 15.765 6.72745C15.8175 6.67495 15.93 6.49495 15.93 5.88745C15.93 5.03995 15.72 4.94995 14.8275 4.94995H3.165C2.2725 4.94995 2.0625 5.03995 2.0625 5.88745C2.0625 6.49495 2.1825 6.67495 2.2275 6.72745C2.3325 6.82495 2.655 6.82495 2.985 6.82495H3.165Z"
                                                            fill="white" />
                                                        <path
                                                            d="M7.32031 13.7249C7.01281 13.7249 6.75781 13.4699 6.75781 13.1624V10.4999C6.75781 10.1924 7.01281 9.93738 7.32031 9.93738C7.62781 9.93738 7.88281 10.1924 7.88281 10.4999V13.1624C7.88281 13.4774 7.62781 13.7249 7.32031 13.7249Z"
                                                            fill="white" />
                                                        <path
                                                            d="M10.7695 13.7249C10.462 13.7249 10.207 13.4699 10.207 13.1624V10.4999C10.207 10.1924 10.462 9.93738 10.7695 9.93738C11.077 9.93738 11.332 10.1924 11.332 10.4999V13.1624C11.332 13.4774 11.077 13.7249 10.7695 13.7249Z"
                                                            fill="white" />
                                                        <path
                                                            d="M11.1671 17.0626H6.64457C3.95957 17.0626 3.35957 15.4651 3.12707 14.0776L2.06957 7.59006C2.01707 7.28256 2.22707 6.99756 2.53457 6.94506C2.84207 6.89256 3.12707 7.10256 3.17957 7.41006L4.23707 13.8901C4.45457 15.2176 4.90457 15.9376 6.64457 15.9376H11.1671C13.0946 15.9376 13.3121 15.2626 13.5596 13.9576L14.8196 7.39506C14.8796 7.08756 15.1721 6.88506 15.4796 6.95256C15.7871 7.01256 15.9821 7.30506 15.9221 7.61256L14.6621 14.1751C14.3696 15.6976 13.8821 17.0626 11.1671 17.0626Z"
                                                            fill="white" />
                                                    </svg>
                                                </a>
                                            @endif
                                        </div>
                                        <div class="price">
                                            @if ($topRatedProduct->product->enable_product_variant == 'on')
                                                <ins>{{ __('In variant') }}</ins>
                                            @else
                                                <ins>{{ \App\Models\Utility::priceFormat($topRatedProduct->product->price) }}</ins>
                                            @endif
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

    @foreach ($getStoreThemeSetting as $storethemesetting)
        @if (isset($storethemesetting['section_name']) && $storethemesetting['section_name'] == 'Home-Categories' && !empty($pro_categories) && $storethemesetting['section_enable'] == 'on')
            @php
                $Titlekey = array_search('Title', array_column($storethemesetting['inner-list'], 'field_name'));
                $Title = $storethemesetting['inner-list'][$Titlekey]['field_default_text'];

                $Description_key = array_search('Description', array_column($storethemesetting['inner-list'], 'field_name'));
                $Description = $storethemesetting['inner-list'][$Description_key]['field_default_text'];
            @endphp
            <section class="category-sec pb pt">
                <div class="container">
                    <div class="section-title text-center">
                        <h2>{{ $Title }}</h2>
                        <p>{{ $Description }}</p>
                    </div>
                </div>
                <div class="category-slider">
                    @foreach ($pro_categories as $key => $pro_categorie)
                        <div class="category-card">
                            <div class="category-card-inner">
                                <div class="category-card-image">
                                    <a href="{{ route('store.categorie.product', [$store->slug, $pro_categorie->name]) }}" class="category-image img-ratio">
                                        @if (!empty($pro_categorie->categorie_img))
                                            <img src="{{ $productImg . (!empty($pro_categorie->categorie_img) ? $pro_categorie->categorie_img : 'default.jpg') }}" alt="category-card-image">
                                        @else
                                            <img src="{{ asset(Storage::url('uploads/product_image/default.jpg')) }}" alt="category-card-image">
                                        @endif
                                    </a>
                                </div>
                                <div class="category-card-content text-center">
                                    <h3><a href="{{ route('store.categorie.product', [$store->slug, $pro_categorie->name]) }}">{{ $pro_categorie->name }}</a></h3>
                                    <div class="btn-wrp">
                                        <a href="{{ route('store.categorie.product', [$store->slug, $pro_categorie->name]) }}" class="btn">{{ __('View More') }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>
        @endif
    @endforeach

    @foreach ($getStoreThemeSetting as $storethemesetting)
        @if (isset($storethemesetting['section_name']) && $storethemesetting['section_name'] == 'Home-Testimonial' && $storethemesetting['array_type'] == 'inner-list' && $storethemesetting['section_enable'] == 'on')
            @php
                $Heading_key = array_search('Heading', array_column($storethemesetting['inner-list'], 'field_name'));
                $Heading = $storethemesetting['inner-list'][$Heading_key]['field_default_text'];

                $HeadingSubText_key = array_search('Heading Sub Text', array_column($storethemesetting['inner-list'], 'field_name'));
                $HeadingSubText = $storethemesetting['inner-list'][$HeadingSubText_key]['field_default_text'];
            @endphp
            <section class="testimonial-sec pt pb">
                <div class="container">
                    <div class="section-title text-center">
                        <h2>{{ !empty($Heading) ? $Heading : __('Testimonials') }}</h2>
                        <p>{{ !empty($HeadingSubText) ? $HeadingSubText : __('There is only that moment and the incredible certainty that <br> everything under the sun has been written by one hand only.') }}</p>
                    </div>
                    <div class="testimonial-slider">
                        @foreach ($testimonials as $key => $testimonial)
                            <div class="testimonial-card">
                                <div class="testimonial-card-inner">
                                    <div class="testimonial-content-top">
                                        <p>{{ $testimonial->description ?? '' }}</p>
                                        <div class="testimonial-rating product-rating rating">
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
                                    </div>
                                    <div class="testimonial-content-bottom">
                                        <div class="testimonial-img">
                                            <img src="{{ $testimonialImg . (!empty($testimonial->image) ? $testimonial->image : 'avatar.png') }}" alt="testimonial-image">
                                        </div>
                                        <div class="testimonial-img-content">
                                            <h3>{{ $testimonial->title ?? '' }}</h3>
                                            <span>{{ $testimonial->sub_title ?? '' }}</span>
                                        </div>
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
</main>
@endsection
