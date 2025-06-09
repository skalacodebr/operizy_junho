@extends('storefront.layout.theme8')

@section('page-title')
    {{ __('Home') }}
@endsection

@push('css-page')
@endpush
@php
    $imgpath = \App\Models\Utility::get_file('uploads/');
    $productImg = \App\Models\Utility::get_file('uploads/is_cover_image/');
    $catimg = \App\Models\Utility::get_file('uploads/product_image/');
    $default = \App\Models\Utility::get_file('uploads/theme8/header/img01.png');
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

    @if ($getStoreThemeSetting[0]['section_enable'] == 'on')
        <section class="main-banner-sec" style="background-image: url({{ $imgpath . 'theme8/header/home-banner-bg.png' }});">
            <div class="container">
                <div class="main-banner-wrapper">
                    <div class="main-banner-slider">
                        @php
                            $homepage_header_text = $homepage_header_btn = $homepage_header_bg_img = '';
                
                            $homepage_header_2_key = array_search('Home-Header', array_column($getStoreThemeSetting, 'section_name'));
                            if ($homepage_header_2_key != '') {
                                $homepage_header_2 = $getStoreThemeSetting[$homepage_header_2_key];
                            }
                        @endphp
                        @for ($i = 0; $i < $homepage_header_2['loop_number']; $i++)
                            @php
                                foreach ($homepage_header_2['inner-list'] as $homepage_header_2_value) {
                                    if ($homepage_header_2_value['field_slug'] == 'homepage-header-sub-title') {
                                        $homepage_header_sub_title = $homepage_header_2_value['field_default_text'];
                                    }
                                    if ($homepage_header_2_value['field_slug'] == 'homepage-header-title') {
                                        $homepage_header_text = $homepage_header_2_value['field_default_text'];
                                    }
                                    if ($homepage_header_2_value['field_slug'] == 'homepage-sub-text') {
                                        $homepage_header_sub_text = $homepage_header_2_value['field_default_text'];
                                    }
                                    if ($homepage_header_2_value['field_slug'] == 'homepage-header-button') {
                                        $homepage_header_btn = $homepage_header_2_value['field_default_text'];
                                    }
                                    if ($homepage_header_2_value['field_slug'] == 'header-img') {
                                        $homepage_header_bg_img = $homepage_header_2_value['field_default_text'];
                                    }
                
                                    if (!empty($homepage_header_2[$homepage_header_2_value['field_slug']])) {
                                        if ($homepage_header_2_value['field_slug'] == 'homepage-header-sub-title') {
                                            $homepage_header_sub_title = $homepage_header_2[$homepage_header_2_value['field_slug']][$i];
                                        }
                                        if ($homepage_header_2_value['field_slug'] == 'homepage-header-title') {
                                            $homepage_header_text = $homepage_header_2[$homepage_header_2_value['field_slug']][$i];
                                        }
                                        if ($homepage_header_2_value['field_slug'] == 'homepage-sub-text') {
                                            $homepage_header_sub_text = $homepage_header_2[$homepage_header_2_value['field_slug']][$i];
                                        }
                                        if ($homepage_header_2_value['field_slug'] == 'homepage-header-button') {
                                            $homepage_header_btn = $homepage_header_2[$homepage_header_2_value['field_slug']][$i];
                                        }
                                        if ($homepage_header_2_value['field_slug'] == 'header-img') {
                                            $homepage_header_bg_img = $homepage_header_2[$homepage_header_2_value['field_slug']][$i]['field_prev_text'];
                                        }
                                    }
                                }
                            @endphp

                            <div class="main-banner-content">
                                <div class="row align-center">
                                    <div class="col-md-6 col-12">
                                        <div class="banner-left-col">
                                            <div class="section-title">
                                                <div class="subtitle">
                                                    {{ __($homepage_header_sub_title) }}
                                                </div>
                                                <h2>{{ __($homepage_header_text) }}</h2>
                                                <p>{{ __($homepage_header_sub_text) }}</p>
                                            </div>
                                            <div class="banner-btn-wrp">
                                                <a href="{{ route('store.categorie.product', $store->slug) }}" tabindex="0" class="btn">
                                                    {{ __($homepage_header_btn) }}
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="banner-right-col">
                                            <div class="banner-right-img img-ratio">
                                                <img src="{{ $imgpath . $homepage_header_bg_img }}" alt="banner-img" loading="lazy">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endfor
                    </div>
                    <div class="main-banner-arrows flex align-center">
                        <div class="slick-prev banner-left slick-arrow">
                            <svg width="28" height="16" viewBox="0 0 28 16" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M27.1265 8.70711C27.5171 8.31658 27.5171 7.68342 27.1265 7.29289L20.7626 0.928932C20.372 0.538408 19.7389 0.538408 19.3484 0.928932C18.9578 1.31946 18.9578 1.95262 19.3484 2.34315L25.0052 8L19.3484 13.6569C18.9578 14.0474 18.9578 14.6805 19.3484 15.0711C19.7389 15.4616 20.372 15.4616 20.7626 15.0711L27.1265 8.70711ZM0.419434 9H26.4194V7H0.419434V9Z"
                                    fill="white" />
                            </svg>
                        </div>
                        <div class="slick-next banner-right slick-arrow">
                            <svg width="28" height="16" viewBox="0 0 28 16" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M27.1265 8.70711C27.5171 8.31658 27.5171 7.68342 27.1265 7.29289L20.7626 0.928932C20.372 0.538408 19.7389 0.538408 19.3484 0.928932C18.9578 1.31946 18.9578 1.95262 19.3484 2.34315L25.0052 8L19.3484 13.6569C18.9578 14.0474 18.9578 14.6805 19.3484 15.0711C19.7389 15.4616 20.372 15.4616 20.7626 15.0711L27.1265 8.70711ZM0.419434 9H26.4194V7H0.419434V9Z"
                                    fill="white" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    @if (count($topRatedProducts) > 0)
        <section class="top-product-sec pt pb">
            <div class="container">
                <div class="section-title section-title-row flex align-center justify-between">
                    <h2>{{ __('TOP PRODUCTS') }}</h2>
                    <div class="title-btn-wrp">
                        <a href="{{ route('store.categorie.product', $store->slug) }}" tabindex="0" class="btn">
                            {{ __('Go To Shop') }}
                        </a>
                    </div>
                </div>
                <div class="top-product-slider">
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
                                </div>
                                <div class="product-content">
                                    <div class="product-content-top">
                                        <div class="product-lbl">
                                            {{ $topRatedProduct->product->product_category() }}
                                        </div>
                                        <h3>
                                            <a href="{{ route('store.product.product_view', [$store->slug, $topRatedProduct->product->id]) }}">{{ $topRatedProduct->product->name }}</a>
                                        </h3>
                                        <div class="price">
                                            <ins>
                                                @if ($topRatedProduct->product->enable_product_variant == 'on')
                                                    {{ __('In variant') }}
                                                @else
                                                    {{ \App\Models\Utility::priceFormat($topRatedProduct->product->price) }}
                                                @endif
                                            </ins>
                                        </div>
                                    </div>
                                    <div class="product-content-bottom">
                                        <div class="pro-btn-wrapper flex align-center">
                                            <div class="pro-btn">
                                                @if ($topRatedProduct->product->enable_product_variant == 'on')
                                                    <a href="{{ route('store.product.product_view', [$store->slug, $topRatedProduct->product->id]) }}" class="compare-btn btn cart-btn">
                                                        <svg width="22" height="23" viewBox="0 0 22 23" fill="none"
                                                            xmlns="http://www.w3.org/2000/svg">
                                                            <path
                                                                d="M4.7305 6.28951C4.55735 6.28951 4.3751 6.21661 4.24752 6.08903C3.98325 5.82476 3.98325 5.38735 4.24752 5.12308L7.55545 1.81515C7.81972 1.55088 8.25713 1.55088 8.5214 1.81515C8.78567 2.07942 8.78567 2.51683 8.5214 2.7811L5.21347 6.08903C5.07678 6.21661 4.90364 6.28951 4.7305 6.28951Z"
                                                                fill="white" />
                                                            <path
                                                                d="M17.141 6.28976C16.9678 6.28976 16.7947 6.22597 16.658 6.08927L13.3501 2.78134C13.0858 2.51707 13.0858 2.07966 13.3501 1.81539C13.6143 1.55112 14.0517 1.55112 14.316 1.81539L17.6239 5.12332C17.8882 5.38759 17.8882 5.825 17.6239 6.08927C17.4964 6.21685 17.3141 6.28976 17.141 6.28976Z"
                                                                fill="white" />
                                                            <path
                                                                d="M18.4167 10.1356C18.3529 10.1356 18.2891 10.1356 18.2253 10.1356H18.0158H3.64493C3.00703 10.1447 2.27801 10.1447 1.74947 9.61613C1.33028 9.20605 1.13892 8.56816 1.13892 7.62954C1.13892 5.12354 2.97058 5.12354 3.84541 5.12354H18.0249C18.8997 5.12354 20.7314 5.12354 20.7314 7.62954C20.7314 8.57727 20.54 9.20605 20.1208 9.61613C19.6469 10.09 19.009 10.1356 18.4167 10.1356ZM3.84541 8.76864H18.2345C18.6445 8.77775 19.0273 8.77775 19.1548 8.65017C19.2186 8.58638 19.3553 8.36768 19.3553 7.62954C19.3553 6.5998 19.1002 6.49045 18.0158 6.49045H3.84541C2.76099 6.49045 2.50583 6.5998 2.50583 7.62954C2.50583 8.36768 2.65163 8.58638 2.70631 8.65017C2.83389 8.76864 3.22574 8.76864 3.6267 8.76864H3.84541Z"
                                                                fill="white" />
                                                            <path
                                                                d="M8.89488 17.1525C8.52126 17.1525 8.21143 16.8426 8.21143 16.469V13.234C8.21143 12.8604 8.52126 12.5505 8.89488 12.5505C9.26851 12.5505 9.57834 12.8604 9.57834 13.234V16.469C9.57834 16.8518 9.26851 17.1525 8.89488 17.1525Z"
                                                                fill="white" />
                                                            <path
                                                                d="M13.0868 17.1527C12.7132 17.1527 12.4033 16.8429 12.4033 16.4693V13.2342C12.4033 12.8606 12.7132 12.5508 13.0868 12.5508C13.4604 12.5508 13.7702 12.8606 13.7702 13.2342V16.4693C13.7702 16.852 13.4604 17.1527 13.0868 17.1527Z"
                                                                fill="white" />
                                                            <path
                                                                d="M13.5684 21.2073H8.07345C4.81108 21.2073 4.08206 19.2663 3.79956 17.5804L2.51466 9.6979C2.45087 9.32427 2.70603 8.97799 3.07965 8.9142C3.45328 8.85041 3.79956 9.10557 3.86335 9.47919L5.14825 17.3526C5.41252 18.9656 5.95929 19.8404 8.07345 19.8404H13.5684C15.9104 19.8404 16.1747 19.0203 16.4754 17.4346L18.0064 9.46096C18.0793 9.08734 18.4347 8.8413 18.8083 8.92331C19.1819 8.99621 19.4188 9.35161 19.3459 9.72523L17.815 17.6989C17.4596 19.5488 16.8673 21.2073 13.5684 21.2073Z"
                                                                fill="white" />
                                                        </svg>
                                                    </a>
                                                @else
                                                    <a data-id="{{ $topRatedProduct->product->id }}" class="compare-btn btn cart-btn add_to_cart">
                                                        <svg width="22" height="23" viewBox="0 0 22 23" fill="none"
                                                            xmlns="http://www.w3.org/2000/svg">
                                                            <path
                                                                d="M4.7305 6.28951C4.55735 6.28951 4.3751 6.21661 4.24752 6.08903C3.98325 5.82476 3.98325 5.38735 4.24752 5.12308L7.55545 1.81515C7.81972 1.55088 8.25713 1.55088 8.5214 1.81515C8.78567 2.07942 8.78567 2.51683 8.5214 2.7811L5.21347 6.08903C5.07678 6.21661 4.90364 6.28951 4.7305 6.28951Z"
                                                                fill="white" />
                                                            <path
                                                                d="M17.141 6.28976C16.9678 6.28976 16.7947 6.22597 16.658 6.08927L13.3501 2.78134C13.0858 2.51707 13.0858 2.07966 13.3501 1.81539C13.6143 1.55112 14.0517 1.55112 14.316 1.81539L17.6239 5.12332C17.8882 5.38759 17.8882 5.825 17.6239 6.08927C17.4964 6.21685 17.3141 6.28976 17.141 6.28976Z"
                                                                fill="white" />
                                                            <path
                                                                d="M18.4167 10.1356C18.3529 10.1356 18.2891 10.1356 18.2253 10.1356H18.0158H3.64493C3.00703 10.1447 2.27801 10.1447 1.74947 9.61613C1.33028 9.20605 1.13892 8.56816 1.13892 7.62954C1.13892 5.12354 2.97058 5.12354 3.84541 5.12354H18.0249C18.8997 5.12354 20.7314 5.12354 20.7314 7.62954C20.7314 8.57727 20.54 9.20605 20.1208 9.61613C19.6469 10.09 19.009 10.1356 18.4167 10.1356ZM3.84541 8.76864H18.2345C18.6445 8.77775 19.0273 8.77775 19.1548 8.65017C19.2186 8.58638 19.3553 8.36768 19.3553 7.62954C19.3553 6.5998 19.1002 6.49045 18.0158 6.49045H3.84541C2.76099 6.49045 2.50583 6.5998 2.50583 7.62954C2.50583 8.36768 2.65163 8.58638 2.70631 8.65017C2.83389 8.76864 3.22574 8.76864 3.6267 8.76864H3.84541Z"
                                                                fill="white" />
                                                            <path
                                                                d="M8.89488 17.1525C8.52126 17.1525 8.21143 16.8426 8.21143 16.469V13.234C8.21143 12.8604 8.52126 12.5505 8.89488 12.5505C9.26851 12.5505 9.57834 12.8604 9.57834 13.234V16.469C9.57834 16.8518 9.26851 17.1525 8.89488 17.1525Z"
                                                                fill="white" />
                                                            <path
                                                                d="M13.0868 17.1527C12.7132 17.1527 12.4033 16.8429 12.4033 16.4693V13.2342C12.4033 12.8606 12.7132 12.5508 13.0868 12.5508C13.4604 12.5508 13.7702 12.8606 13.7702 13.2342V16.4693C13.7702 16.852 13.4604 17.1527 13.0868 17.1527Z"
                                                                fill="white" />
                                                            <path
                                                                d="M13.5684 21.2073H8.07345C4.81108 21.2073 4.08206 19.2663 3.79956 17.5804L2.51466 9.6979C2.45087 9.32427 2.70603 8.97799 3.07965 8.9142C3.45328 8.85041 3.79956 9.10557 3.86335 9.47919L5.14825 17.3526C5.41252 18.9656 5.95929 19.8404 8.07345 19.8404H13.5684C15.9104 19.8404 16.1747 19.0203 16.4754 17.4346L18.0064 9.46096C18.0793 9.08734 18.4347 8.8413 18.8083 8.92331C19.1819 8.99621 19.4188 9.35161 19.3459 9.72523L17.815 17.6989C17.4596 19.5488 16.8673 21.2073 13.5684 21.2073Z"
                                                                fill="white" />
                                                        </svg>
                                                    </a>
                                                @endif
                                            </div>
                                            <div class="pro-btn">
                                                @if (Auth::guard('customers')->check())
                                                    @if (!empty($wishlist) && isset($wishlist[$topRatedProduct->product->id]['product_id']))
                                                        @if ($wishlist[$topRatedProduct->product->id]['product_id'] != $topRatedProduct->product->id)
                                                            <a href="javascript:void(0)" tabindex="0" class="wishlist-btn btn add_to_wishlist wishlist_{{ $topRatedProduct->product->id }}"
                                                                data-id="{{ $topRatedProduct->product->id }}">
                                                                <svg width="28" height="23" viewBox="0 0 28 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                    <path d="M0.599095 7.38008L0.599095 7.38008C0.539537 4.05401 2.33093 1.69577 4.77155 0.848363C7.21517 -8.66357e-05 10.4236 0.630794 13.2378 3.54845L13.5977 3.92156L13.9575 3.54845C16.7713 0.631207 19.9795 1.89873e-05 22.4231 0.848089C24.8636 1.69511 26.6552 4.05284 26.5962 7.37893C26.5427 10.402 24.4323 13.5144 21.6585 16.2578C19.0068 18.8804 15.8394 21.077 13.5977 22.4186C11.3561 21.0771 8.18894 18.8807 5.53733 16.2583C2.76364 13.5152 0.653182 10.4029 0.599095 7.38008Z" fill="white" stroke="black"></path>
                                                                </svg>
                                                            </a>
                                                        @else
                                                            <a href="javascript:void(0)" tabindex="0" class="wishlist-btn btn wishlist-active wishlist_{{ $topRatedProduct->product->id }}"
                                                                disabled>
                                                                <svg width="28" height="23" viewBox="0 0 28 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                    <path d="M0.599095 7.38008L0.599095 7.38008C0.539537 4.05401 2.33093 1.69577 4.77155 0.848363C7.21517 -8.66357e-05 10.4236 0.630794 13.2378 3.54845L13.5977 3.92156L13.9575 3.54845C16.7713 0.631207 19.9795 1.89873e-05 22.4231 0.848089C24.8636 1.69511 26.6552 4.05284 26.5962 7.37893C26.5427 10.402 24.4323 13.5144 21.6585 16.2578C19.0068 18.8804 15.8394 21.077 13.5977 22.4186C11.3561 21.0771 8.18894 18.8807 5.53733 16.2583C2.76364 13.5152 0.653182 10.4029 0.599095 7.38008Z" fill="white" stroke="black"></path>
                                                                </svg>
                                                            </a>
                                                        @endif
                                                    @else
                                                        <a href="javascript:void(0)" tabindex="0" class="wishlist-btn btn add_to_wishlist wishlist_{{ $topRatedProduct->product->id }}"
                                                            data-id="{{ $topRatedProduct->product->id }}">
                                                            <svg width="28" height="23" viewBox="0 0 28 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M0.599095 7.38008L0.599095 7.38008C0.539537 4.05401 2.33093 1.69577 4.77155 0.848363C7.21517 -8.66357e-05 10.4236 0.630794 13.2378 3.54845L13.5977 3.92156L13.9575 3.54845C16.7713 0.631207 19.9795 1.89873e-05 22.4231 0.848089C24.8636 1.69511 26.6552 4.05284 26.5962 7.37893C26.5427 10.402 24.4323 13.5144 21.6585 16.2578C19.0068 18.8804 15.8394 21.077 13.5977 22.4186C11.3561 21.0771 8.18894 18.8807 5.53733 16.2583C2.76364 13.5152 0.653182 10.4029 0.599095 7.38008Z" fill="white" stroke="black"></path>
                                                            </svg>
                                                        </a>
                                                    @endif
                                                @else
                                                    <a href="javascript:void(0)" class="wishlist-btn btn add_to_wishlist wishlist_{{ $topRatedProduct->product->id }}"
                                                        data-id="{{ $topRatedProduct->product->id }}">
                                                        <svg width="28" height="23" viewBox="0 0 28 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M0.599095 7.38008L0.599095 7.38008C0.539537 4.05401 2.33093 1.69577 4.77155 0.848363C7.21517 -8.66357e-05 10.4236 0.630794 13.2378 3.54845L13.5977 3.92156L13.9575 3.54845C16.7713 0.631207 19.9795 1.89873e-05 22.4231 0.848089C24.8636 1.69511 26.6552 4.05284 26.5962 7.37893C26.5427 10.402 24.4323 13.5144 21.6585 16.2578C19.0068 18.8804 15.8394 21.077 13.5977 22.4186C11.3561 21.0771 8.18894 18.8807 5.53733 16.2583C2.76364 13.5152 0.653182 10.4029 0.599095 7.38008Z" fill="white" stroke="black"></path>
                                                        </svg>
                                                    </a>
                                                @endif
                                            </div>
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
        @if (isset($ThemeSetting['section_name']) && $ThemeSetting['section_name'] == 'Top-Purchased' && $ThemeSetting['section_enable'] == 'on')
            @php
                $homepage_header_img_key = array_search('Background Image', array_column($ThemeSetting['inner-list'], 'field_name'));
                $homepage_header_img = $ThemeSetting['inner-list'][$homepage_header_img_key]['field_default_text'];

                $homepage_header_sub_title_key = array_search('Sub Title', array_column($ThemeSetting['inner-list'], 'field_name'));
                $homepage_header_sub_title = $ThemeSetting['inner-list'][$homepage_header_sub_title_key]['field_default_text'];

                $homepage_header_title_key = array_search('Title', array_column($ThemeSetting['inner-list'], 'field_name'));
                $homepage_header_title = $ThemeSetting['inner-list'][$homepage_header_title_key]['field_default_text'];

                $homepage_header_subtext_key = array_search('Sub text', array_column($ThemeSetting['inner-list'], 'field_name'));
                $homepage_header_subtext = $ThemeSetting['inner-list'][$homepage_header_subtext_key]['field_default_text'];

                $homepage_header_btn_key = array_search('Button Text', array_column($ThemeSetting['inner-list'], 'field_name'));
                $homepage_header_btn = $ThemeSetting['inner-list'][$homepage_header_btn_key]['field_default_text'];
            @endphp
            <section class="most-purchased-product-sec" style="background-image: url({{ $imgpath . $homepage_header_img }});">
                <div class="container">
                    <div class="row align-end">
                        @if(!empty($mostPurchasedDetail))
                            <div class="col-lg-6 col-12">
                                <div class="purchased-left-col">
                                    <div class="purchased-product-img-1 img-ratio">
                                        @if (!empty($topRatedProduct->product->is_cover))
                                            <img src="{{ $coverImg . $topRatedProduct->product->is_cover }}" alt="purchased-product-img"
                                                loading="lazy">
                                        @else
                                            <img src="{{ asset(Storage::url('uploads/is_cover_image/default.jpg')) }}" alt="purchased-product-img"
                                                loading="lazy">
                                        @endif
                                    </div>
                                    <div class="purchased-product-img-2">
                                        <div class="purchased-product-img img-ratio">
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
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div class="col-lg-6 col-12">
                            <div class="purchased-product-content">
                                <div class="section-title">
                                    <div class="subtitle">
                                        {{ $homepage_header_sub_title }}
                                    </div>
                                    <h2>{{ $homepage_header_title }}</h2>
                                    <p>{{ $homepage_header_subtext }}</p>
                                </div>
                                <div class="btn-wrp">
                                    <a href="{{ route('store.categorie.product', $store->slug) }}" class="btn">{{ $homepage_header_btn }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @if(!empty($mostPurchasedDetail))
                    <span class="slide-txt">{{ $mostPurchasedDetail->name }}</span>
                @endif
            </section>
        @endif
    @endforeach

    @if ($products['Start shopping']->count() > 0)
        <section class="product-sec tabs-wrapper pt pb">
            <div class="container">
                <div class="section-title section-title-row flex align-center justify-between">
                    <div class="section-title-left">
                        <h2>{{ __('Classy Products') }}</h2>
                    </div>
                    <div class="section-title-right flex">
                        <ul class="tabs product-tabs flex align-center">
                            @foreach ($categories as $key => $category)
                                <li class="tab-link {{ $key == 0 ? 'active' : '' }}" data-tab="pdp-tab-{!! preg_replace('/[^A-Za-z0-9\-]/', '_', $category) !!}">
                                    <a href="javascript:;" >
                                        {{ __($category) }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="tabs-container">
                    @foreach ($products as $key => $items)
                        <div id="pdp-tab-{!! preg_replace('/[^A-Za-z0-9\-]/', '_', $key) !!}" class="tab-content {{ $key == 'Start shopping' ? 'active show' : '' }}">
                            @if ($items->count() > 0)
                                <div class="row no-gutters">
                                    @foreach ($items as $product)
                                        <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-12">
                                            @include('storefront.theme8.common.product_section')
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

    @foreach ($getStoreThemeSetting as $ThemeSetting)
        @if (isset($ThemeSetting['section_name']) && $ThemeSetting['section_name'] == 'Latest Product' && $ThemeSetting['section_enable'] == 'on')
            @php
                $homepage_header_tagImg_key = array_search('Tag Image', array_column($ThemeSetting['inner-list'], 'field_name'));
                $homepage_header_tagImg = $ThemeSetting['inner-list'][$homepage_header_tagImg_key]['field_default_text'];

                $homepage_header_title_key = array_search('Title', array_column($ThemeSetting['inner-list'], 'field_name'));
                $homepage_header_title = $ThemeSetting['inner-list'][$homepage_header_title_key]['field_default_text'];

                $homepage_header_subTxt_key = array_search('Sub text', array_column($ThemeSetting['inner-list'], 'field_name'));
                $homepage_header_subTxt = $ThemeSetting['inner-list'][$homepage_header_subTxt_key]['field_default_text'];
            @endphp
            <section class="latest-product-sec pt pb" style="background-image: url({{ $imgpath . $homepage_header_tagImg }});">
                <span class="slide-txt">{{ __('Timeless Elegance for Every Moment') }}</span>
                <div class="container">
                    <div class="latest-product-inner">
                        <div class="latest-product-slider">
                            @foreach ($latestProduct8 as $keys => $latestProduct)
                                <div class="latest-product-card">
                                    <div class="latest-card-inner">
                                        <div class="latest-card-image img-ratio">
                                            <a href="{{ route('store.product.product_view', [$store->slug, $latestProduct->id]) }}">
                                                @if (!empty($latestProduct->is_cover))
                                                    <img src="{{ $coverImg . $latestProduct->is_cover }}"
                                                        alt="latest-product">
                                                @else
                                                    <img src="{{ asset(Storage::url('uploads/is_cover_image/default.jpg')) }}"
                                                        alt="latest-product">
                                                @endif
                                            </a>
                                        </div>
                                        <div class="latest-card-content text-center">
                                            <div class="latest-content-top">
                                                <span class="product-label">{{ isset($latestProduct->categories->name) ? $latestProduct->categories->name : '' }}</span>
                                                <h2>{{ $homepage_header_title }}</h2>
                                                <p>{{ $homepage_header_subTxt }}</p>

                                                <h3>{{ $latestProduct->name }}</h3>
                                                <div class="price">
                                                    <ins>{{ \App\Models\Utility::priceFormat($latestProduct->price) }}</ins>
                                                </div>
                                            </div>
                                            <div class="latest-content-bottom">
                                                <a href="javascript:void(0)" tabindex="0" class="cart-btn btn add_to_cart" data-id="{{ $latestProduct->id }}">
                                                    <svg width="22" height="23" viewBox="0 0 22 23" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M4.7305 6.28951C4.55735 6.28951 4.3751 6.21661 4.24752 6.08903C3.98325 5.82476 3.98325 5.38735 4.24752 5.12308L7.55545 1.81515C7.81972 1.55088 8.25713 1.55088 8.5214 1.81515C8.78567 2.07942 8.78567 2.51683 8.5214 2.7811L5.21347 6.08903C5.07678 6.21661 4.90364 6.28951 4.7305 6.28951Z"
                                                            fill="white" />
                                                        <path
                                                            d="M17.141 6.28976C16.9678 6.28976 16.7947 6.22597 16.658 6.08927L13.3501 2.78134C13.0858 2.51707 13.0858 2.07966 13.3501 1.81539C13.6143 1.55112 14.0517 1.55112 14.316 1.81539L17.6239 5.12332C17.8882 5.38759 17.8882 5.825 17.6239 6.08927C17.4964 6.21685 17.3141 6.28976 17.141 6.28976Z"
                                                            fill="white" />
                                                        <path
                                                            d="M18.4167 10.1356C18.3529 10.1356 18.2891 10.1356 18.2253 10.1356H18.0158H3.64493C3.00703 10.1447 2.27801 10.1447 1.74947 9.61613C1.33028 9.20605 1.13892 8.56816 1.13892 7.62954C1.13892 5.12354 2.97058 5.12354 3.84541 5.12354H18.0249C18.8997 5.12354 20.7314 5.12354 20.7314 7.62954C20.7314 8.57727 20.54 9.20605 20.1208 9.61613C19.6469 10.09 19.009 10.1356 18.4167 10.1356ZM3.84541 8.76864H18.2345C18.6445 8.77775 19.0273 8.77775 19.1548 8.65017C19.2186 8.58638 19.3553 8.36768 19.3553 7.62954C19.3553 6.5998 19.1002 6.49045 18.0158 6.49045H3.84541C2.76099 6.49045 2.50583 6.5998 2.50583 7.62954C2.50583 8.36768 2.65163 8.58638 2.70631 8.65017C2.83389 8.76864 3.22574 8.76864 3.6267 8.76864H3.84541Z"
                                                            fill="white" />
                                                        <path
                                                            d="M8.89488 17.1525C8.52126 17.1525 8.21143 16.8426 8.21143 16.469V13.234C8.21143 12.8604 8.52126 12.5505 8.89488 12.5505C9.26851 12.5505 9.57834 12.8604 9.57834 13.234V16.469C9.57834 16.8518 9.26851 17.1525 8.89488 17.1525Z"
                                                            fill="white" />
                                                        <path
                                                            d="M13.0868 17.1527C12.7132 17.1527 12.4033 16.8429 12.4033 16.4693V13.2342C12.4033 12.8606 12.7132 12.5508 13.0868 12.5508C13.4604 12.5508 13.7702 12.8606 13.7702 13.2342V16.4693C13.7702 16.852 13.4604 17.1527 13.0868 17.1527Z"
                                                            fill="white" />
                                                        <path
                                                            d="M13.5684 21.2073H8.07345C4.81108 21.2073 4.08206 19.2663 3.79956 17.5804L2.51466 9.6979C2.45087 9.32427 2.70603 8.97799 3.07965 8.9142C3.45328 8.85041 3.79956 9.10557 3.86335 9.47919L5.14825 17.3526C5.41252 18.9656 5.95929 19.8404 8.07345 19.8404H13.5684C15.9104 19.8404 16.1747 19.0203 16.4754 17.4346L18.0064 9.46096C18.0793 9.08734 18.4347 8.8413 18.8083 8.92331C19.1819 8.99621 19.4188 9.35161 19.3459 9.72523L17.815 17.6989C17.4596 19.5488 16.8673 21.2073 13.5684 21.2073Z"
                                                            fill="white" />
                                                    </svg>
                                                    <span>{{ __('Add To Cart') }}</span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="product-arrow-wrapper  flex align-center">
                            <div class="slick-prev product-left slick-arrow" style="">
                                <svg width="28" height="16" viewBox="0 0 28 16" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M27.1265 8.70711C27.5171 8.31658 27.5171 7.68342 27.1265 7.29289L20.7626 0.928932C20.372 0.538408 19.7389 0.538408 19.3484 0.928932C18.9578 1.31946 18.9578 1.95262 19.3484 2.34315L25.0052 8L19.3484 13.6569C18.9578 14.0474 18.9578 14.6805 19.3484 15.0711C19.7389 15.4616 20.372 15.4616 20.7626 15.0711L27.1265 8.70711ZM0.419434 9H26.4194V7H0.419434V9Z"
                                        fill="white"></path>
                                </svg>
                            </div>
                            <div class="slick-next product-right slick-arrow" style="">
                                <svg width="28" height="16" viewBox="0 0 28 16" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M27.1265 8.70711C27.5171 8.31658 27.5171 7.68342 27.1265 7.29289L20.7626 0.928932C20.372 0.538408 19.7389 0.538408 19.3484 0.928932C18.9578 1.31946 18.9578 1.95262 19.3484 2.34315L25.0052 8L19.3484 13.6569C18.9578 14.0474 18.9578 14.6805 19.3484 15.0711C19.7389 15.4616 20.372 15.4616 20.7626 15.0711L27.1265 8.70711ZM0.419434 9H26.4194V7H0.419434V9Z"
                                        fill="white"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @endif
    @endforeach

    @if($getStoreThemeSetting[7]['section_enable'] == 'on')
        <section class="testimonial-sec pt pb">
            <div class="container">
                <div class="section-title text-center">
                    @foreach ($getStoreThemeSetting as $storethemesetting)
                        @if (isset($storethemesetting['section_name']) && $storethemesetting['section_name'] == 'Home-Testimonial' && $storethemesetting['array_type'] == 'inner-list' && $storethemesetting['section_enable'] == 'on')
                            @php
                                $Heading_key = array_search('Heading', array_column($storethemesetting['inner-list'], 'field_name'));
                                $Heading = $storethemesetting['inner-list'][$Heading_key]['field_default_text'];

                                $HeadingSubText_key = array_search('Heading Sub Text', array_column($storethemesetting['inner-list'], 'field_name'));
                                $HeadingSubText = $storethemesetting['inner-list'][$HeadingSubText_key]['field_default_text'];
                            @endphp
                            <h2>{{ !empty($Heading) ? $Heading : __('Testimonials') }}</h2>
                            <p>{{ !empty($HeadingSubText) ? $HeadingSubText : __('Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC') }}</p>
                        @endif
                    @endforeach
                </div>
                <div class="testimonial-wrp">
                    <div class="testimonial-image">
                        <img src="{{ $imgpath . 'theme8/header/testimonial-img.png' }}" alt="testimonial-image" loading="lazy">
                    </div>
                    <div class="testimonial-slider">
                        @foreach ($testimonials as $key => $testimonial)
                            <div class="testimonial-card">
                                <div class="testimonial-inner">
                                    <div class="testimonial-slider-image">
                                        <img src="{{ $testimonialImg . (!empty($testimonial->image) ? $testimonial->image : 'avatar.png') }}" alt="testimonial-image"
                                            loading="lazy" class="testi-image">
                                    </div>
                                    <div class="testimonial-content">
                                        <p>{{ $testimonial->description ?? '' }}</p>
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
                                        <h3>{{ $testimonial->title ?? '' }}</h3>
                                        <span>{{ $testimonial->sub_title ?? '' }}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="testimonial-arrow-wrapper flex align-center">
                        <div class="slick-prev testimonial-left slick-arrow" style="">
                            <svg width="28" height="16" viewBox="0 0 28 16" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M27.1265 8.70711C27.5171 8.31658 27.5171 7.68342 27.1265 7.29289L20.7626 0.928932C20.372 0.538408 19.7389 0.538408 19.3484 0.928932C18.9578 1.31946 18.9578 1.95262 19.3484 2.34315L25.0052 8L19.3484 13.6569C18.9578 14.0474 18.9578 14.6805 19.3484 15.0711C19.7389 15.4616 20.372 15.4616 20.7626 15.0711L27.1265 8.70711ZM0.419434 9H26.4194V7H0.419434V9Z"
                                    fill="white"></path>
                            </svg>
                        </div>
                        <div class="slick-next testimonial-right slick-arrow" style="">
                            <svg width="28" height="16" viewBox="0 0 28 16" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M27.1265 8.70711C27.5171 8.31658 27.5171 7.68342 27.1265 7.29289L20.7626 0.928932C20.372 0.538408 19.7389 0.538408 19.3484 0.928932C18.9578 1.31946 18.9578 1.95262 19.3484 2.34315L25.0052 8L19.3484 13.6569C18.9578 14.0474 18.9578 14.6805 19.3484 15.0711C19.7389 15.4616 20.372 15.4616 20.7626 15.0711L27.1265 8.70711ZM0.419434 9H26.4194V7H0.419434V9Z"
                                    fill="white"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif
    
    @if ($getStoreThemeSetting[6]['section_enable'] == 'on')
        @foreach ($getStoreThemeSetting as $storethemesetting)
            @if (isset($storethemesetting['section_name']) && $storethemesetting['section_name'] == 'Home-Categories' && !empty($pro_categories))
                @php
                    $CatBgkey = array_search('Category Background Image', array_column($storethemesetting['inner-list'], 'field_name'));
                    $CatBg = $storethemesetting['inner-list'][$CatBgkey]['field_default_text'];
                @endphp
            @endif
        @endforeach
        <section class="category-sec pb pt" style="background-image: url({{ $imgpath . $CatBg }});">
            <div class="container">
                <div class="category-slider">
                    @foreach ($pro_categories as $key => $pro_categorie)
                        <div class="category-card">
                            <div class="category-card-inner">
                                <div class="category-card-image">
                                    <a href="{{ route('store.categorie.product', [$store->slug, $pro_categorie->name]) }}" class="category-image img-ratio">
                                        @if (!empty($pro_categorie->categorie_img))
                                            <img src="{{  $productImg . $pro_categorie->categorie_img }}" alt="category-card-image" loading="lazy">
                                        @else
                                            <img src="{{ asset(Storage::url('uploads/product_image/default.jpg')) }}" alt="category-card-image" loading="lazy">
                                        @endif
                                    </a>
                                </div>
                                <div class="category-card-content text-center">
                                    <h2>
                                        <a href="{{ route('store.categorie.product', [$store->slug, $pro_categorie->name]) }}">{{ $pro_categorie->name }}</a>
                                    </h2>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    @foreach ($getStoreThemeSetting as $ThemeSetting)
        @if (isset($ThemeSetting['section_name']) && $ThemeSetting['section_name'] == 'Product-Section-Header' && $ThemeSetting['section_enable'] == 'on')
            @php
                $homepage_header_img_key = array_search('Product Header Image', array_column($ThemeSetting['inner-list'], 'field_name'));
                $homepage_header_img = $ThemeSetting['inner-list'][$homepage_header_img_key]['field_default_text'];

                $homepage_header_tagImg_key = array_search('Product Header Tag', array_column($ThemeSetting['inner-list'], 'field_name'));
                $homepage_header_tagImg = $ThemeSetting['inner-list'][$homepage_header_tagImg_key]['field_default_text'];

                $homepage_header_sub_title_key = array_search('Sub Title', array_column($ThemeSetting['inner-list'], 'field_name'));
                $homepage_header_sub_title = $ThemeSetting['inner-list'][$homepage_header_sub_title_key]['field_default_text'];

                $homepage_header_title_key = array_search('Title', array_column($ThemeSetting['inner-list'], 'field_name'));
                $homepage_header_title = $ThemeSetting['inner-list'][$homepage_header_title_key]['field_default_text'];

                $homepage_header_subTxt_key = array_search('Sub text', array_column($ThemeSetting['inner-list'], 'field_name'));
                $homepage_header_subTxt = $ThemeSetting['inner-list'][$homepage_header_subTxt_key]['field_default_text'];

                $homepage_header_btn_key = array_search('Button', array_column($ThemeSetting['inner-list'], 'field_name'));
                $homepage_header_btn = $ThemeSetting['inner-list'][$homepage_header_btn_key]['field_default_text'];
            @endphp
            <section class="exclusive-product-sec">
                <div class="container">
                    <div class="row align-end">
                        <div class="col-lg-6 col-12">
                            <div class="exclusive-product-content">
                                <div class="section-title">
                                    <div class="subtitle">
                                        {{ $homepage_header_sub_title }}
                                    </div>
                                    <h2>{{ $homepage_header_title }}</h2>
                                    <p>{{ $homepage_header_subTxt }}</p>
                                </div>
                                <div class="btn-wrp">
                                    <a href="{{ route('store.categorie.product', $store->slug) }}" class="btn">{{ $homepage_header_btn }}</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-12">
                            <div class="exclusive-right-col">
                                <div class="exclusive-product-img-1 img-ratio">
                                    <img src="{{ $imgpath . $homepage_header_img }}" alt="exclusive-product-img" loading="lazy">
                                </div>
                                <div class="exclusive-product-img-2">
                                    <div class="exclusive-product-img img-ratio">
                                        <img src="{{ $imgpath . $homepage_header_tagImg }}" alt="exclusive-product"
                                            loading="lazy">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <span class="slide-txt">{{ __('timeless watches') }}</span>
            </section>
        @endif
    @endforeach

    @if ($getStoreThemeSetting[1]['section_enable'] == 'on')
        <section class="about-info-sec pt pb">
            <div class="container">
                <div class="about-info-slider">
                    @foreach ($getStoreThemeSetting as $key => $storethemesetting)
                        @if ($storethemesetting['section_name'] == 'Home-Promotions' && $storethemesetting['array_type'] == 'multi-inner-list')
                            @if (isset($storethemesetting['homepage-promotions-font-icon']) || isset($storethemesetting['homepage-promotions-title']) || isset($storethemesetting['homepage-promotions-description']))
                                @for ($i = 0; $i < $storethemesetting['loop_number']; $i++)
                                    <div class="about-info-item">
                                        <div class="about-info-inner flex align-center">
                                            <div class="info-card-img">
                                                <svg width="85" height="76" viewBox="0 0 85 76" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M5.95543 23.9172C6.04762 23.8209 6.19151 23.7351 6.21548 23.6247C6.23259 23.5413 6.09614 23.425 5.99238 23.271C5.86513 23.4332 5.72442 23.5331 5.7217 23.6376C5.7184 23.7281 5.87197 23.8244 5.95543 23.9172ZM81.3976 46.3838C81.0518 46.8596 80.8121 47.1886 80.576 47.5129C81.3717 47.6456 81.4543 47.1933 81.3976 46.3838ZM44.7437 4.72754C44.9763 4.66879 45.2088 4.61474 45.4343 4.54072C45.4484 4.53602 45.4107 4.29398 45.3965 4.29398C45.158 4.2928 44.9196 4.31396 44.6811 4.33041C44.7024 4.46317 44.7236 4.59477 44.7437 4.72754ZM29.0686 7.60135C29.7261 7.73059 30.0826 7.7999 30.6858 7.91857C30.2502 7.09379 29.8973 7.00333 29.0686 7.60135ZM34.5258 6.4652C35.0039 6.06221 35.2612 5.84721 35.5186 5.63221C35.155 5.7168 34.5766 5.43246 34.5258 6.4652ZM72.1123 7.81987C72.0875 7.81752 72.0627 7.81284 72.0379 7.81049C72.032 7.81636 72.0226 7.81752 72.0155 7.82222C72.0285 7.84337 72.045 7.8657 72.0568 7.88802C72.0757 7.8657 72.0934 7.84219 72.1123 7.81987ZM72.8961 7.85277C73.0153 7.814 73.013 7.41689 73.0661 7.1819C72.9669 7.12668 72.8689 7.07265 72.771 7.01743C72.5514 7.28531 72.3318 7.55316 72.1123 7.81987C72.3814 7.85394 72.6647 7.93031 72.8961 7.85277ZM72.5809 11.4221C72.0698 10.9581 71.7156 10.2566 70.8823 10.2754C71.2199 10.9992 71.6507 11.5831 72.5809 11.4221ZM70.8823 10.2754C70.8764 10.2625 70.8704 10.2508 70.8645 10.239C70.8362 10.232 70.8067 10.2249 70.7796 10.2179C70.7961 10.2367 70.8114 10.2555 70.828 10.2719C70.848 10.2707 70.8634 10.2754 70.8823 10.2754ZM45.9785 3.1179C45.9655 3.10615 45.9525 3.10497 45.9395 3.09322L45.9383 3.09087C45.9324 3.0991 45.9265 3.11202 45.9218 3.1226C45.9371 3.12495 45.9513 3.12848 45.9667 3.13083C45.9702 3.12495 45.9737 3.12377 45.9785 3.1179ZM47.729 3.26594C47.166 2.92756 46.6289 2.18267 45.9785 3.1179C46.5238 3.61371 47.1247 3.45979 47.729 3.26594ZM33.3465 6.04931C32.715 6.33833 32.0717 6.63439 31.4744 6.90932C33.5755 6.87642 33.5755 6.87644 33.3465 6.04931ZM45.9218 3.1226C45.3269 3.02391 44.7768 2.82418 44.1133 3.06738C43.0805 3.44688 43.0498 3.36346 42.8503 4.0308C43.8289 3.83576 44.7744 3.65601 45.714 3.44334C45.8026 3.42337 45.8557 3.24596 45.9218 3.1226ZM4.1935 33.7606C3.98374 33.3764 3.77397 32.9922 3.56373 32.6092C3.62275 32.5281 3.6826 32.4459 3.7421 32.3648C4.36832 32.6245 4.99408 32.883 5.65395 33.1567C5.71061 32.7937 5.69219 32.111 5.84388 32.0711C6.65685 31.8584 6.46963 31.2017 6.62179 30.6859C6.72555 30.3358 6.78776 29.9246 7.01417 29.6649C8.09451 28.4277 8.17065 27.0002 7.95616 25.7102C8.40815 24.8842 8.75898 24.2063 9.14676 23.5495C9.33811 23.2241 9.56498 22.9068 9.83058 22.6401C11.2476 21.2232 12.8264 19.939 14.0714 18.387C15.4248 16.701 17.2867 15.7481 18.9605 14.538C19.4858 14.1573 20.0252 13.8248 20.5352 13.3842C21.1998 12.8097 21.7817 11.6806 23.0436 12.4549C23.3305 12.6311 23.5914 12.0507 23.4107 11.5291C24.5546 10.1626 26.5507 10.1168 27.9566 8.81501C27.3688 8.51659 26.9851 8.32157 26.3867 8.01727C25.6052 9.49648 24.1108 9.95234 22.8028 10.454C21.4548 10.9698 20.4372 12.1623 18.9097 12.2481C18.8154 12.2528 18.7526 12.4901 18.6401 12.5712C18.1776 12.9072 17.705 13.228 17.2315 13.5464C16.7505 13.8706 16.2226 14.1397 15.7891 14.5157C14.9139 15.2758 14.1157 16.1241 13.234 16.876C12.4621 17.5328 11.5022 18.0028 10.8363 18.7441C10.0321 19.6382 9.25193 20.5312 8.35834 21.3501C7.84602 21.8201 7.21803 22.4745 7.57807 23.217C6.90026 23.7058 6.32798 24.1181 5.83928 24.4706C5.87658 24.9711 5.90432 25.3307 5.94575 25.8817C5.45563 25.6314 5.14848 25.4752 4.83814 25.3178C3.70987 26.5643 4.78195 27.9378 4.53571 29.2407C3.06205 30.0632 3.45348 31.7069 2.84106 32.9887C3.258 33.3376 3.62689 33.6466 3.99625 33.9556C4.06212 33.891 4.12763 33.8252 4.1935 33.7606ZM82.3432 28.4735C82.0776 27.6628 81.9017 27.1294 81.688 26.4797C82.6914 26.784 82.7493 26.9532 82.3432 28.4735ZM80.105 21.6556L79.7285 21.6638L79.647 20.859C79.8206 20.8449 79.9941 20.832 80.1676 20.819C80.1476 21.0975 80.1251 21.3771 80.105 21.6556ZM79.3873 49.3598C79.3271 49.3434 79.2658 49.3269 79.2056 49.3093C79.2964 49.0132 79.3874 48.7171 79.4794 48.4211C79.5573 48.4493 79.6341 48.4786 79.7132 48.5068C79.6046 48.7923 79.4959 49.0767 79.3873 49.3598ZM79.0604 18.5491C80.0153 18.844 79.4133 19.6065 79.7049 20.1693C78.5292 19.858 78.5292 19.8568 79.0604 18.5491ZM59.8935 6.97512C59.7023 6.77773 59.5087 6.58154 59.3293 6.37358C59.3186 6.36183 59.4709 6.18089 59.4827 6.18793C59.7271 6.33128 59.962 6.48988 60.2004 6.64614C60.0977 6.75658 59.9962 6.86585 59.8935 6.97512ZM57.3154 4.68405C57.2257 4.84149 56.7771 4.79686 56.4926 4.84621C56.5257 4.59595 56.4714 4.27402 56.6095 4.11071C56.907 3.75706 57.3013 3.48447 57.9175 2.95342C57.666 3.72416 57.5657 4.24581 57.3154 4.68405ZM57.5834 6.1468C56.8173 5.89303 56.0512 5.64043 55.2131 5.36315C55.8599 4.68406 56.0134 4.72164 57.6778 5.82135L57.5834 6.1468ZM55.062 3.70417C55.2945 3.70417 55.5271 3.70066 55.7584 3.71476C55.7702 3.71593 55.7903 3.95091 55.7761 3.95326C55.5471 4.01318 55.3134 4.05078 55.082 4.09543C55.0749 3.96501 55.069 3.83459 55.062 3.70417ZM52.2572 73.6991C52.7684 73.6075 53.2795 73.5171 53.806 73.4231C53.3905 74.0622 52.812 73.8284 52.2572 73.6991ZM51.7709 74.8423C49.5599 75.4791 47.3194 75.5214 45.0506 75.1572C46.8201 74.9751 48.5919 74.813 50.3579 74.6015C51.0744 74.5169 51.8299 74.4323 52.2537 73.7003C52.3977 74.2079 52.4343 74.6508 51.7709 74.8423ZM53.0576 2.24612C52.7318 2.35892 52.4071 2.47288 51.8807 2.65499C52.1734 1.90658 52.6586 2.17798 53.0576 2.24612ZM19.134 17.7208C19.6333 16.8091 19.8494 16.6176 21.0109 16.0642C20.4809 16.9947 20.4172 17.0511 19.134 17.7208ZM16.8072 64.9755C16.2959 64.5607 15.2906 64.6618 15.404 63.2754C16.0598 63.8405 16.5564 64.2682 17.0535 64.697C16.9714 64.7899 16.8893 64.8827 16.8072 64.9755ZM12.8356 62.4401C13.2848 62.4624 13.7514 62.4577 13.875 63.1168C13.0243 63.6279 13.1165 62.7432 12.8356 62.4401ZM11.9844 63.9921C12.0076 63.8605 12.0306 63.7289 12.0536 63.5973C12.4031 63.6655 12.7517 63.7324 13.3014 63.8394C12.683 64.4703 12.3257 64.4045 11.9844 63.9921ZM9.93482 38.4367C9.81724 38.4309 9.69967 38.425 9.5821 38.4179C9.68539 37.3958 9.78774 36.3736 9.89102 35.3514C10.4052 36.4135 10.6938 37.4557 9.93482 38.4367ZM8.99046 59.0857C9.60795 58.6651 9.61622 58.6745 10.1953 59.6743C9.67158 59.4182 9.32618 59.2502 8.99046 59.0857ZM9.54893 60.5743C9.18134 60.2735 8.81481 59.9739 8.36058 59.6015C8.61425 59.3923 8.78802 59.2502 8.95954 59.108C9.2164 59.531 9.47327 59.9539 9.72966 60.3769L9.54893 60.5743ZM4.83637 55.427C4.953 54.7855 5.03964 54.3097 5.14671 53.7223C5.9781 54.1781 5.99191 55.0675 6.47235 55.7337C5.76136 56.1766 5.40263 55.4599 4.83637 55.427ZM5.16654 43.9235C5.28033 43.9611 5.39425 43.9975 5.50769 44.034C5.36249 44.3676 5.21718 44.7013 5.07199 45.0338C4.32123 44.511 5.24586 44.3148 5.16654 43.9235ZM4.43797 53.479C4.17745 52.5614 2.91721 52.1514 3.59502 50.9542C4.75386 51.7613 4.91109 52.2031 4.43797 53.479ZM4.92762 43.1305C4.88241 42.7369 4.83684 42.3445 4.78797 41.918C5.78804 42.0731 5.78804 42.0731 4.92762 43.1305ZM5.30524 46.8808C5.21588 46.1171 5.15545 45.6025 5.09595 45.0937C5.93005 45.4732 5.94433 45.579 5.30524 46.8808ZM6.37921 50.2668C6.17452 50.4854 5.96924 50.7039 5.76408 50.9236C5.67047 50.8273 5.57686 50.7321 5.48325 50.6358C5.69903 50.429 5.91447 50.221 6.13025 50.0131C6.21324 50.0977 6.29622 50.1823 6.37921 50.2668ZM2.15039 48.9639C1.77548 48.5433 1.60255 48.1861 2.07886 47.7784C2.70827 48.0862 2.84803 48.4387 2.15039 48.9639ZM0.676252 41.515C0.807163 40.5151 0.353405 39.5964 1.41816 39.0794C1.71457 39.9488 1.54175 40.6996 0.676252 41.515ZM1.08894 43.8495C0.941383 43.3161 0.793356 42.7815 0.645329 42.2481C1.68978 42.5324 1.16826 43.2362 1.08894 43.8495ZM1.97285 46.7786C1.98017 46.7609 2.0909 46.7574 2.10105 46.7762C2.18639 46.9301 2.32698 47.0946 2.31778 47.2473C2.30762 47.4189 2.18037 47.5822 2.09314 47.749C1.98949 47.5881 1.83356 47.4353 1.80547 47.2626C1.78056 47.1134 1.90321 46.9372 1.97285 46.7786ZM75.7457 11.5361C76.3902 11.9485 76.3996 11.9649 75.9747 12.3421C75.9074 12.1059 75.8389 11.8663 75.7457 11.5361ZM83.8577 29.5815C84.8611 27.9977 84.0831 26.8369 83.0668 25.7818C84.1245 24.7491 83.2061 23.7939 83.1813 22.6378C83.0125 23.0713 82.9192 23.311 82.8071 23.5977C81.7919 22.5837 81.2265 21.5134 81.4295 20.2139C80.9538 20.0036 80.5772 19.838 80.0484 19.6054C80.4332 19.3762 80.6599 19.2423 80.929 19.0813C80.157 17.7796 79.3885 16.4813 78.5752 15.1102C78.3934 15.3968 78.2057 15.6941 77.9803 16.0477C77.1492 15.5108 76.4185 15.0385 75.7032 14.5767C75.8283 14.048 75.7209 13.6063 76.3725 13.3396C77.0701 13.0552 77.1681 11.8557 76.585 11.5326C76.0066 11.2118 75.3148 10.9722 74.6644 10.9498C74.3162 10.9369 73.9479 11.455 73.5843 11.7358C73.288 11.6501 72.9882 11.5631 72.6883 11.4762C72.9126 11.7499 73.1322 12.0284 73.3671 12.2939C74.0364 13.0506 74.1981 13.0153 74.7022 11.9027C75.1118 12.0625 75.5297 12.2234 75.9464 12.3867C75.9912 13.0882 75.3526 12.8238 75.0197 13.0059C75.1094 13.2303 75.1956 13.4477 75.3372 13.8025C74.8993 13.8284 74.5157 13.8507 74.0305 13.8789C74.1332 14.0704 74.1627 14.2184 74.2501 14.2725C74.5133 14.4323 74.799 14.5568 75.2558 14.7859C73.6469 14.8869 73.5371 14.7918 73.4096 13.3889C73.3565 12.805 72.9409 12.5195 72.2516 12.5218C71.993 12.523 71.6991 12.4537 71.4819 12.3198C70.6308 11.7958 70.0866 11.0885 69.6074 9.94411C70.0347 10.0452 70.4089 10.1321 70.7796 10.2179C70.6355 10.064 70.5033 9.89477 70.3357 9.77375C68.8979 8.7457 67.1261 8.19231 65.9905 6.72955C65.8878 6.59679 65.6505 6.5545 65.4664 6.49928C63.7524 5.97997 62.422 4.79097 60.9099 3.92036C60.3421 3.59374 60.067 3.14258 60.1898 2.39063C60.7364 2.53515 61.2357 2.66792 61.7645 2.80773C61.6795 2.54926 61.6193 2.36713 61.46 1.88307C62.4751 2.77482 63.2271 3.43395 64.0487 4.15535C64.7699 3.35876 65.6765 4.69934 66.5276 4.10836C67.3598 5.83665 68.8259 6.70843 70.436 7.39809C70.1185 7.6836 69.7962 7.97379 69.5023 8.23932C70.0052 8.56124 70.3581 8.78799 70.9118 9.14281C70.2543 7.73058 71.5126 8.18174 72.0155 7.82222C71.7735 7.4157 71.3686 6.99743 71.3969 6.61206C71.4737 5.62397 70.8705 5.19045 70.213 4.75456C69.3123 4.15653 68.4352 3.49036 67.4602 3.04389C66.2785 2.50226 65.1524 1.79966 63.7465 1.77852C62.4386 1.75854 61.0999 1.71978 59.9809 0.758705C59.6799 0.500229 59.0105 0.669403 58.3755 0.634155C58.8476 1.66573 59.2313 2.50578 59.6751 3.47507C58.3424 3.19309 57.3804 2.43295 56.1031 2.55396C55.5223 2.60801 55.0631 1.9195 55.1871 1.19341C55.7053 1.10764 56.1586 1.03127 56.6862 0.943146C56.5883 0.643547 56.5871 0.389771 56.4655 0.304001C55.7502 -0.200027 54.6346 -0.052002 53.9795 0.561302C53.8532 0.67997 53.6242 0.714043 53.4353 0.739891C52.5748 0.863251 51.7662 0.658829 50.9717 0.338081C50.8631 0.294609 50.6979 0.389778 50.5314 0.427376V1.26859C49.8161 1.68216 49.1208 2.084 48.4574 2.46703C48.6604 3.30591 48.7549 4.0966 49.822 4.0919C49.6296 4.55833 49.4855 4.91082 49.3946 5.13405C47.9699 5.37961 46.6914 5.60165 45.413 5.82018C45.269 5.84485 45.1073 5.89538 44.9786 5.85661C43.372 5.37254 41.9154 6.11391 40.402 6.39237C40.2604 6.41822 40.1117 6.3959 40.1636 6.3959C39.7351 6.101 39.4211 5.8848 38.9949 5.59343C39.5049 5.07999 39.8897 4.69346 40.2734 4.30574C39.4494 3.45041 38.8332 3.64426 37.4344 5.20335C38.1356 6.04694 38.0412 6.69783 37.1263 7.11022C36.6353 7.33228 36.0923 7.44626 35.6095 7.68124C34.1138 8.4085 32.3266 8.42495 31.0022 9.55991C30.255 10.2002 29.4829 10.689 28.4028 10.6032C27.9614 10.5668 27.4679 10.8641 27.0359 11.0838C26.2037 11.5067 25.3608 11.9274 24.5888 12.4467C22.2268 14.0363 19.8234 15.5801 17.5796 17.3237C16.0787 18.4892 14.943 20.0013 14.0369 21.7578C12.5175 24.7068 10.5679 27.4349 9.01679 30.3687C7.34021 33.5409 6.11644 36.9082 5.74979 40.4717C5.40345 40.5245 5.15226 40.5621 4.90141 40.5997C4.15856 38.9701 4.26267 38.5061 5.41455 38.472V36.9129C4.95075 37.0891 4.54681 37.2418 4.3531 37.3159C3.78176 37.0315 3.34417 36.813 2.77567 36.5299C3.36861 36.1551 3.57884 36.0211 3.89013 35.8237C3.60104 35.4889 3.36447 35.2175 2.96926 34.7616C2.62115 35.4184 2.28779 35.8848 2.11675 36.4041C1.83261 37.2653 1.64917 38.1606 1.42501 39.0418C1.05612 38.8197 0.682155 38.5977 0.178224 38.2969C0.111765 39.07 -0.0338985 39.7879 0.00718088 40.4952C0.102088 42.1459 0.231226 43.799 0.453975 45.438C0.643908 46.8408 0.855092 48.2648 1.28666 49.6054C1.86307 51.3983 2.65893 53.1219 3.36908 54.8713C3.4392 55.044 3.55583 55.2026 3.67245 55.3507C4.63204 56.5761 5.67697 57.7451 6.53833 59.0352C7.42225 60.3616 8.87431 61.2405 9.44057 62.8101C9.52072 63.0345 9.86931 63.1626 10.2433 63.4505C10.6777 62.8043 11.0604 62.2333 11.2822 61.9043C11.2998 61.1194 10.3605 61.0055 10.9258 60.2841C11.5529 60.6001 12.1902 60.9209 12.7606 61.2076V62.4318C12.2759 62.7855 11.7935 63.1368 11.2804 63.5104C11.5893 64.0837 11.8153 64.5032 12.0218 64.8874C12.6443 64.9214 13.2618 64.7981 13.6948 65.0237C14.1384 65.2563 14.3818 65.6522 15.0481 65.5195C15.3409 65.4619 15.7287 66.2761 16.1732 66.4794C16.8677 66.7978 17.2891 67.787 18.2998 67.3899C18.3912 67.3535 18.5927 67.471 18.6793 67.5709C19.2214 68.1983 20.3003 67.9903 20.7028 68.8738C20.7512 68.9796 21.2057 68.9055 21.4725 68.9102C21.6531 68.9126 21.8774 68.8386 22.0072 68.9185C22.8182 69.4225 23.6043 69.9653 24.4059 70.4834C25.4671 71.1684 26.4433 71.9955 27.7784 72.1765C28.2246 72.2376 28.6389 72.5583 29.058 72.7792C29.5668 73.0494 30.0472 73.3808 30.5713 73.6146C32.5545 74.4993 34.7005 74.7765 36.8135 75.0808C38.8958 75.3804 41.0525 75.2418 43.1076 75.6436C45.0223 76.0184 46.9157 76.0901 48.7997 75.8939C50.6424 75.7012 52.5464 75.4204 54.2569 74.7519C59.1581 72.838 63.521 69.9947 67.2866 66.3231C69.6369 64.0321 71.8597 61.6059 74.0919 59.1973C74.5357 58.7191 74.7671 58.0447 75.0953 57.4584C75.9759 55.8817 76.8494 54.3015 77.743 52.733C77.8575 52.5321 78.0582 52.2806 78.2541 52.2454C78.8691 52.135 78.9612 51.6321 79.1772 51.2068C79.4192 50.7274 79.7309 50.2751 79.9067 49.7734C80.1676 49.0367 80.3341 48.266 80.5418 47.5093C80.5418 47.5093 80.5465 47.5552 80.5454 47.5552C80.5548 47.5422 80.5666 47.527 80.576 47.5129C80.5666 47.5117 80.5595 47.5117 80.5489 47.5105C80.6197 46.8937 80.6209 46.2557 80.7897 45.6659C81.5535 43.0048 82.3514 40.3506 83.8707 37.9867C83.971 37.8293 84.0525 37.6401 84.0749 37.458C84.2508 36.0082 84.5022 34.5595 84.5471 33.1038C84.5836 31.8948 85.1042 30.5496 83.8577 29.5815ZM72.6883 11.4762C72.6718 11.4562 72.6541 11.4362 72.6387 11.4163C72.6175 11.421 72.601 11.4186 72.5809 11.4221C72.5915 11.4327 72.6022 11.4445 72.614 11.455C72.6388 11.4621 72.6624 11.4691 72.6883 11.4762Z"
                                                        fill="#D6B29A" />
                                                </svg>
                                                <div class="info-card-icon">
                                                    {!! $storethemesetting['homepage-promotions-font-icon'][$i] !!}
                                                </div>
                                            </div>
                                            <div class="info-card-content">
                                                <h2>{{ $storethemesetting['homepage-promotions-title'][$i] }}</h2>
                                                <p>{{ $storethemesetting['homepage-promotions-description'][$i] }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endfor
                            @else
                                @for ($i = 0; $i < $storethemesetting['loop_number']; $i++)
                                    <div class="about-info-item">
                                        <div class="about-info-inner flex align-center">
                                            <div class="info-card-img">
                                                <svg width="85" height="76" viewBox="0 0 85 76" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M5.95543 23.9172C6.04762 23.8209 6.19151 23.7351 6.21548 23.6247C6.23259 23.5413 6.09614 23.425 5.99238 23.271C5.86513 23.4332 5.72442 23.5331 5.7217 23.6376C5.7184 23.7281 5.87197 23.8244 5.95543 23.9172ZM81.3976 46.3838C81.0518 46.8596 80.8121 47.1886 80.576 47.5129C81.3717 47.6456 81.4543 47.1933 81.3976 46.3838ZM44.7437 4.72754C44.9763 4.66879 45.2088 4.61474 45.4343 4.54072C45.4484 4.53602 45.4107 4.29398 45.3965 4.29398C45.158 4.2928 44.9196 4.31396 44.6811 4.33041C44.7024 4.46317 44.7236 4.59477 44.7437 4.72754ZM29.0686 7.60135C29.7261 7.73059 30.0826 7.7999 30.6858 7.91857C30.2502 7.09379 29.8973 7.00333 29.0686 7.60135ZM34.5258 6.4652C35.0039 6.06221 35.2612 5.84721 35.5186 5.63221C35.155 5.7168 34.5766 5.43246 34.5258 6.4652ZM72.1123 7.81987C72.0875 7.81752 72.0627 7.81284 72.0379 7.81049C72.032 7.81636 72.0226 7.81752 72.0155 7.82222C72.0285 7.84337 72.045 7.8657 72.0568 7.88802C72.0757 7.8657 72.0934 7.84219 72.1123 7.81987ZM72.8961 7.85277C73.0153 7.814 73.013 7.41689 73.0661 7.1819C72.9669 7.12668 72.8689 7.07265 72.771 7.01743C72.5514 7.28531 72.3318 7.55316 72.1123 7.81987C72.3814 7.85394 72.6647 7.93031 72.8961 7.85277ZM72.5809 11.4221C72.0698 10.9581 71.7156 10.2566 70.8823 10.2754C71.2199 10.9992 71.6507 11.5831 72.5809 11.4221ZM70.8823 10.2754C70.8764 10.2625 70.8704 10.2508 70.8645 10.239C70.8362 10.232 70.8067 10.2249 70.7796 10.2179C70.7961 10.2367 70.8114 10.2555 70.828 10.2719C70.848 10.2707 70.8634 10.2754 70.8823 10.2754ZM45.9785 3.1179C45.9655 3.10615 45.9525 3.10497 45.9395 3.09322L45.9383 3.09087C45.9324 3.0991 45.9265 3.11202 45.9218 3.1226C45.9371 3.12495 45.9513 3.12848 45.9667 3.13083C45.9702 3.12495 45.9737 3.12377 45.9785 3.1179ZM47.729 3.26594C47.166 2.92756 46.6289 2.18267 45.9785 3.1179C46.5238 3.61371 47.1247 3.45979 47.729 3.26594ZM33.3465 6.04931C32.715 6.33833 32.0717 6.63439 31.4744 6.90932C33.5755 6.87642 33.5755 6.87644 33.3465 6.04931ZM45.9218 3.1226C45.3269 3.02391 44.7768 2.82418 44.1133 3.06738C43.0805 3.44688 43.0498 3.36346 42.8503 4.0308C43.8289 3.83576 44.7744 3.65601 45.714 3.44334C45.8026 3.42337 45.8557 3.24596 45.9218 3.1226ZM4.1935 33.7606C3.98374 33.3764 3.77397 32.9922 3.56373 32.6092C3.62275 32.5281 3.6826 32.4459 3.7421 32.3648C4.36832 32.6245 4.99408 32.883 5.65395 33.1567C5.71061 32.7937 5.69219 32.111 5.84388 32.0711C6.65685 31.8584 6.46963 31.2017 6.62179 30.6859C6.72555 30.3358 6.78776 29.9246 7.01417 29.6649C8.09451 28.4277 8.17065 27.0002 7.95616 25.7102C8.40815 24.8842 8.75898 24.2063 9.14676 23.5495C9.33811 23.2241 9.56498 22.9068 9.83058 22.6401C11.2476 21.2232 12.8264 19.939 14.0714 18.387C15.4248 16.701 17.2867 15.7481 18.9605 14.538C19.4858 14.1573 20.0252 13.8248 20.5352 13.3842C21.1998 12.8097 21.7817 11.6806 23.0436 12.4549C23.3305 12.6311 23.5914 12.0507 23.4107 11.5291C24.5546 10.1626 26.5507 10.1168 27.9566 8.81501C27.3688 8.51659 26.9851 8.32157 26.3867 8.01727C25.6052 9.49648 24.1108 9.95234 22.8028 10.454C21.4548 10.9698 20.4372 12.1623 18.9097 12.2481C18.8154 12.2528 18.7526 12.4901 18.6401 12.5712C18.1776 12.9072 17.705 13.228 17.2315 13.5464C16.7505 13.8706 16.2226 14.1397 15.7891 14.5157C14.9139 15.2758 14.1157 16.1241 13.234 16.876C12.4621 17.5328 11.5022 18.0028 10.8363 18.7441C10.0321 19.6382 9.25193 20.5312 8.35834 21.3501C7.84602 21.8201 7.21803 22.4745 7.57807 23.217C6.90026 23.7058 6.32798 24.1181 5.83928 24.4706C5.87658 24.9711 5.90432 25.3307 5.94575 25.8817C5.45563 25.6314 5.14848 25.4752 4.83814 25.3178C3.70987 26.5643 4.78195 27.9378 4.53571 29.2407C3.06205 30.0632 3.45348 31.7069 2.84106 32.9887C3.258 33.3376 3.62689 33.6466 3.99625 33.9556C4.06212 33.891 4.12763 33.8252 4.1935 33.7606ZM82.3432 28.4735C82.0776 27.6628 81.9017 27.1294 81.688 26.4797C82.6914 26.784 82.7493 26.9532 82.3432 28.4735ZM80.105 21.6556L79.7285 21.6638L79.647 20.859C79.8206 20.8449 79.9941 20.832 80.1676 20.819C80.1476 21.0975 80.1251 21.3771 80.105 21.6556ZM79.3873 49.3598C79.3271 49.3434 79.2658 49.3269 79.2056 49.3093C79.2964 49.0132 79.3874 48.7171 79.4794 48.4211C79.5573 48.4493 79.6341 48.4786 79.7132 48.5068C79.6046 48.7923 79.4959 49.0767 79.3873 49.3598ZM79.0604 18.5491C80.0153 18.844 79.4133 19.6065 79.7049 20.1693C78.5292 19.858 78.5292 19.8568 79.0604 18.5491ZM59.8935 6.97512C59.7023 6.77773 59.5087 6.58154 59.3293 6.37358C59.3186 6.36183 59.4709 6.18089 59.4827 6.18793C59.7271 6.33128 59.962 6.48988 60.2004 6.64614C60.0977 6.75658 59.9962 6.86585 59.8935 6.97512ZM57.3154 4.68405C57.2257 4.84149 56.7771 4.79686 56.4926 4.84621C56.5257 4.59595 56.4714 4.27402 56.6095 4.11071C56.907 3.75706 57.3013 3.48447 57.9175 2.95342C57.666 3.72416 57.5657 4.24581 57.3154 4.68405ZM57.5834 6.1468C56.8173 5.89303 56.0512 5.64043 55.2131 5.36315C55.8599 4.68406 56.0134 4.72164 57.6778 5.82135L57.5834 6.1468ZM55.062 3.70417C55.2945 3.70417 55.5271 3.70066 55.7584 3.71476C55.7702 3.71593 55.7903 3.95091 55.7761 3.95326C55.5471 4.01318 55.3134 4.05078 55.082 4.09543C55.0749 3.96501 55.069 3.83459 55.062 3.70417ZM52.2572 73.6991C52.7684 73.6075 53.2795 73.5171 53.806 73.4231C53.3905 74.0622 52.812 73.8284 52.2572 73.6991ZM51.7709 74.8423C49.5599 75.4791 47.3194 75.5214 45.0506 75.1572C46.8201 74.9751 48.5919 74.813 50.3579 74.6015C51.0744 74.5169 51.8299 74.4323 52.2537 73.7003C52.3977 74.2079 52.4343 74.6508 51.7709 74.8423ZM53.0576 2.24612C52.7318 2.35892 52.4071 2.47288 51.8807 2.65499C52.1734 1.90658 52.6586 2.17798 53.0576 2.24612ZM19.134 17.7208C19.6333 16.8091 19.8494 16.6176 21.0109 16.0642C20.4809 16.9947 20.4172 17.0511 19.134 17.7208ZM16.8072 64.9755C16.2959 64.5607 15.2906 64.6618 15.404 63.2754C16.0598 63.8405 16.5564 64.2682 17.0535 64.697C16.9714 64.7899 16.8893 64.8827 16.8072 64.9755ZM12.8356 62.4401C13.2848 62.4624 13.7514 62.4577 13.875 63.1168C13.0243 63.6279 13.1165 62.7432 12.8356 62.4401ZM11.9844 63.9921C12.0076 63.8605 12.0306 63.7289 12.0536 63.5973C12.4031 63.6655 12.7517 63.7324 13.3014 63.8394C12.683 64.4703 12.3257 64.4045 11.9844 63.9921ZM9.93482 38.4367C9.81724 38.4309 9.69967 38.425 9.5821 38.4179C9.68539 37.3958 9.78774 36.3736 9.89102 35.3514C10.4052 36.4135 10.6938 37.4557 9.93482 38.4367ZM8.99046 59.0857C9.60795 58.6651 9.61622 58.6745 10.1953 59.6743C9.67158 59.4182 9.32618 59.2502 8.99046 59.0857ZM9.54893 60.5743C9.18134 60.2735 8.81481 59.9739 8.36058 59.6015C8.61425 59.3923 8.78802 59.2502 8.95954 59.108C9.2164 59.531 9.47327 59.9539 9.72966 60.3769L9.54893 60.5743ZM4.83637 55.427C4.953 54.7855 5.03964 54.3097 5.14671 53.7223C5.9781 54.1781 5.99191 55.0675 6.47235 55.7337C5.76136 56.1766 5.40263 55.4599 4.83637 55.427ZM5.16654 43.9235C5.28033 43.9611 5.39425 43.9975 5.50769 44.034C5.36249 44.3676 5.21718 44.7013 5.07199 45.0338C4.32123 44.511 5.24586 44.3148 5.16654 43.9235ZM4.43797 53.479C4.17745 52.5614 2.91721 52.1514 3.59502 50.9542C4.75386 51.7613 4.91109 52.2031 4.43797 53.479ZM4.92762 43.1305C4.88241 42.7369 4.83684 42.3445 4.78797 41.918C5.78804 42.0731 5.78804 42.0731 4.92762 43.1305ZM5.30524 46.8808C5.21588 46.1171 5.15545 45.6025 5.09595 45.0937C5.93005 45.4732 5.94433 45.579 5.30524 46.8808ZM6.37921 50.2668C6.17452 50.4854 5.96924 50.7039 5.76408 50.9236C5.67047 50.8273 5.57686 50.7321 5.48325 50.6358C5.69903 50.429 5.91447 50.221 6.13025 50.0131C6.21324 50.0977 6.29622 50.1823 6.37921 50.2668ZM2.15039 48.9639C1.77548 48.5433 1.60255 48.1861 2.07886 47.7784C2.70827 48.0862 2.84803 48.4387 2.15039 48.9639ZM0.676252 41.515C0.807163 40.5151 0.353405 39.5964 1.41816 39.0794C1.71457 39.9488 1.54175 40.6996 0.676252 41.515ZM1.08894 43.8495C0.941383 43.3161 0.793356 42.7815 0.645329 42.2481C1.68978 42.5324 1.16826 43.2362 1.08894 43.8495ZM1.97285 46.7786C1.98017 46.7609 2.0909 46.7574 2.10105 46.7762C2.18639 46.9301 2.32698 47.0946 2.31778 47.2473C2.30762 47.4189 2.18037 47.5822 2.09314 47.749C1.98949 47.5881 1.83356 47.4353 1.80547 47.2626C1.78056 47.1134 1.90321 46.9372 1.97285 46.7786ZM75.7457 11.5361C76.3902 11.9485 76.3996 11.9649 75.9747 12.3421C75.9074 12.1059 75.8389 11.8663 75.7457 11.5361ZM83.8577 29.5815C84.8611 27.9977 84.0831 26.8369 83.0668 25.7818C84.1245 24.7491 83.2061 23.7939 83.1813 22.6378C83.0125 23.0713 82.9192 23.311 82.8071 23.5977C81.7919 22.5837 81.2265 21.5134 81.4295 20.2139C80.9538 20.0036 80.5772 19.838 80.0484 19.6054C80.4332 19.3762 80.6599 19.2423 80.929 19.0813C80.157 17.7796 79.3885 16.4813 78.5752 15.1102C78.3934 15.3968 78.2057 15.6941 77.9803 16.0477C77.1492 15.5108 76.4185 15.0385 75.7032 14.5767C75.8283 14.048 75.7209 13.6063 76.3725 13.3396C77.0701 13.0552 77.1681 11.8557 76.585 11.5326C76.0066 11.2118 75.3148 10.9722 74.6644 10.9498C74.3162 10.9369 73.9479 11.455 73.5843 11.7358C73.288 11.6501 72.9882 11.5631 72.6883 11.4762C72.9126 11.7499 73.1322 12.0284 73.3671 12.2939C74.0364 13.0506 74.1981 13.0153 74.7022 11.9027C75.1118 12.0625 75.5297 12.2234 75.9464 12.3867C75.9912 13.0882 75.3526 12.8238 75.0197 13.0059C75.1094 13.2303 75.1956 13.4477 75.3372 13.8025C74.8993 13.8284 74.5157 13.8507 74.0305 13.8789C74.1332 14.0704 74.1627 14.2184 74.2501 14.2725C74.5133 14.4323 74.799 14.5568 75.2558 14.7859C73.6469 14.8869 73.5371 14.7918 73.4096 13.3889C73.3565 12.805 72.9409 12.5195 72.2516 12.5218C71.993 12.523 71.6991 12.4537 71.4819 12.3198C70.6308 11.7958 70.0866 11.0885 69.6074 9.94411C70.0347 10.0452 70.4089 10.1321 70.7796 10.2179C70.6355 10.064 70.5033 9.89477 70.3357 9.77375C68.8979 8.7457 67.1261 8.19231 65.9905 6.72955C65.8878 6.59679 65.6505 6.5545 65.4664 6.49928C63.7524 5.97997 62.422 4.79097 60.9099 3.92036C60.3421 3.59374 60.067 3.14258 60.1898 2.39063C60.7364 2.53515 61.2357 2.66792 61.7645 2.80773C61.6795 2.54926 61.6193 2.36713 61.46 1.88307C62.4751 2.77482 63.2271 3.43395 64.0487 4.15535C64.7699 3.35876 65.6765 4.69934 66.5276 4.10836C67.3598 5.83665 68.8259 6.70843 70.436 7.39809C70.1185 7.6836 69.7962 7.97379 69.5023 8.23932C70.0052 8.56124 70.3581 8.78799 70.9118 9.14281C70.2543 7.73058 71.5126 8.18174 72.0155 7.82222C71.7735 7.4157 71.3686 6.99743 71.3969 6.61206C71.4737 5.62397 70.8705 5.19045 70.213 4.75456C69.3123 4.15653 68.4352 3.49036 67.4602 3.04389C66.2785 2.50226 65.1524 1.79966 63.7465 1.77852C62.4386 1.75854 61.0999 1.71978 59.9809 0.758705C59.6799 0.500229 59.0105 0.669403 58.3755 0.634155C58.8476 1.66573 59.2313 2.50578 59.6751 3.47507C58.3424 3.19309 57.3804 2.43295 56.1031 2.55396C55.5223 2.60801 55.0631 1.9195 55.1871 1.19341C55.7053 1.10764 56.1586 1.03127 56.6862 0.943146C56.5883 0.643547 56.5871 0.389771 56.4655 0.304001C55.7502 -0.200027 54.6346 -0.052002 53.9795 0.561302C53.8532 0.67997 53.6242 0.714043 53.4353 0.739891C52.5748 0.863251 51.7662 0.658829 50.9717 0.338081C50.8631 0.294609 50.6979 0.389778 50.5314 0.427376V1.26859C49.8161 1.68216 49.1208 2.084 48.4574 2.46703C48.6604 3.30591 48.7549 4.0966 49.822 4.0919C49.6296 4.55833 49.4855 4.91082 49.3946 5.13405C47.9699 5.37961 46.6914 5.60165 45.413 5.82018C45.269 5.84485 45.1073 5.89538 44.9786 5.85661C43.372 5.37254 41.9154 6.11391 40.402 6.39237C40.2604 6.41822 40.1117 6.3959 40.1636 6.3959C39.7351 6.101 39.4211 5.8848 38.9949 5.59343C39.5049 5.07999 39.8897 4.69346 40.2734 4.30574C39.4494 3.45041 38.8332 3.64426 37.4344 5.20335C38.1356 6.04694 38.0412 6.69783 37.1263 7.11022C36.6353 7.33228 36.0923 7.44626 35.6095 7.68124C34.1138 8.4085 32.3266 8.42495 31.0022 9.55991C30.255 10.2002 29.4829 10.689 28.4028 10.6032C27.9614 10.5668 27.4679 10.8641 27.0359 11.0838C26.2037 11.5067 25.3608 11.9274 24.5888 12.4467C22.2268 14.0363 19.8234 15.5801 17.5796 17.3237C16.0787 18.4892 14.943 20.0013 14.0369 21.7578C12.5175 24.7068 10.5679 27.4349 9.01679 30.3687C7.34021 33.5409 6.11644 36.9082 5.74979 40.4717C5.40345 40.5245 5.15226 40.5621 4.90141 40.5997C4.15856 38.9701 4.26267 38.5061 5.41455 38.472V36.9129C4.95075 37.0891 4.54681 37.2418 4.3531 37.3159C3.78176 37.0315 3.34417 36.813 2.77567 36.5299C3.36861 36.1551 3.57884 36.0211 3.89013 35.8237C3.60104 35.4889 3.36447 35.2175 2.96926 34.7616C2.62115 35.4184 2.28779 35.8848 2.11675 36.4041C1.83261 37.2653 1.64917 38.1606 1.42501 39.0418C1.05612 38.8197 0.682155 38.5977 0.178224 38.2969C0.111765 39.07 -0.0338985 39.7879 0.00718088 40.4952C0.102088 42.1459 0.231226 43.799 0.453975 45.438C0.643908 46.8408 0.855092 48.2648 1.28666 49.6054C1.86307 51.3983 2.65893 53.1219 3.36908 54.8713C3.4392 55.044 3.55583 55.2026 3.67245 55.3507C4.63204 56.5761 5.67697 57.7451 6.53833 59.0352C7.42225 60.3616 8.87431 61.2405 9.44057 62.8101C9.52072 63.0345 9.86931 63.1626 10.2433 63.4505C10.6777 62.8043 11.0604 62.2333 11.2822 61.9043C11.2998 61.1194 10.3605 61.0055 10.9258 60.2841C11.5529 60.6001 12.1902 60.9209 12.7606 61.2076V62.4318C12.2759 62.7855 11.7935 63.1368 11.2804 63.5104C11.5893 64.0837 11.8153 64.5032 12.0218 64.8874C12.6443 64.9214 13.2618 64.7981 13.6948 65.0237C14.1384 65.2563 14.3818 65.6522 15.0481 65.5195C15.3409 65.4619 15.7287 66.2761 16.1732 66.4794C16.8677 66.7978 17.2891 67.787 18.2998 67.3899C18.3912 67.3535 18.5927 67.471 18.6793 67.5709C19.2214 68.1983 20.3003 67.9903 20.7028 68.8738C20.7512 68.9796 21.2057 68.9055 21.4725 68.9102C21.6531 68.9126 21.8774 68.8386 22.0072 68.9185C22.8182 69.4225 23.6043 69.9653 24.4059 70.4834C25.4671 71.1684 26.4433 71.9955 27.7784 72.1765C28.2246 72.2376 28.6389 72.5583 29.058 72.7792C29.5668 73.0494 30.0472 73.3808 30.5713 73.6146C32.5545 74.4993 34.7005 74.7765 36.8135 75.0808C38.8958 75.3804 41.0525 75.2418 43.1076 75.6436C45.0223 76.0184 46.9157 76.0901 48.7997 75.8939C50.6424 75.7012 52.5464 75.4204 54.2569 74.7519C59.1581 72.838 63.521 69.9947 67.2866 66.3231C69.6369 64.0321 71.8597 61.6059 74.0919 59.1973C74.5357 58.7191 74.7671 58.0447 75.0953 57.4584C75.9759 55.8817 76.8494 54.3015 77.743 52.733C77.8575 52.5321 78.0582 52.2806 78.2541 52.2454C78.8691 52.135 78.9612 51.6321 79.1772 51.2068C79.4192 50.7274 79.7309 50.2751 79.9067 49.7734C80.1676 49.0367 80.3341 48.266 80.5418 47.5093C80.5418 47.5093 80.5465 47.5552 80.5454 47.5552C80.5548 47.5422 80.5666 47.527 80.576 47.5129C80.5666 47.5117 80.5595 47.5117 80.5489 47.5105C80.6197 46.8937 80.6209 46.2557 80.7897 45.6659C81.5535 43.0048 82.3514 40.3506 83.8707 37.9867C83.971 37.8293 84.0525 37.6401 84.0749 37.458C84.2508 36.0082 84.5022 34.5595 84.5471 33.1038C84.5836 31.8948 85.1042 30.5496 83.8577 29.5815ZM72.6883 11.4762C72.6718 11.4562 72.6541 11.4362 72.6387 11.4163C72.6175 11.421 72.601 11.4186 72.5809 11.4221C72.5915 11.4327 72.6022 11.4445 72.614 11.455C72.6388 11.4621 72.6624 11.4691 72.6883 11.4762Z"
                                                        fill="#D6B29A" />
                                                </svg>
                                                <div class="info-card-icon">
                                                    {!! $storethemesetting['inner-list'][0]['field_default_text'] !!}
                                                </div>
                                            </div>
                                            <div class="info-card-content">
                                                <h2> {{ $storethemesetting['inner-list'][1]['field_default_text'] }}</h2>
                                                <p>{{ $storethemesetting['inner-list'][2]['field_default_text'] }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endfor
                            @endif
                        @endif
                    @endforeach
                </div>
            </div>
        </section>
    @endif

</main>
@endsection
