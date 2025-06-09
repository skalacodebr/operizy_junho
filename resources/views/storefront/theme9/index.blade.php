@extends('storefront.layout.theme9')

@section('page-title')
    {{ __('Home') }}
@endsection

@push('css-page')
@endpush
@php
    $imgpath = \App\Models\Utility::get_file('uploads/');
    $productImg = \App\Models\Utility::get_file('uploads/is_cover_image/');
    $catimg = \App\Models\Utility::get_file('uploads/product_image/');
    $default = \App\Models\Utility::get_file('uploads/theme9/header/img01.png');
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
                $homepage_header_sub_title_key = array_search('Header Sub Title', array_column($ThemeSetting['inner-list'], 'field_name'));
                $homepage_header_title_key = array_search('Title', array_column($ThemeSetting['inner-list'], 'field_name'));
                $homepage_header_Sub_text_key = array_search('Sub text', array_column($ThemeSetting['inner-list'], 'field_name'));
                $homepage_header_Button_key = array_search('Button', array_column($ThemeSetting['inner-list'], 'field_name'));
                $homepage_header_bckground_Image_key = array_search('Background Image', array_column($ThemeSetting['inner-list'], 'field_name'));

                if(isset($getStoreThemeSetting[0]['header-sub-title'])){
                    $homepage_header_sub_title = $getStoreThemeSetting[0]['header-sub-title'][0] ?? $ThemeSetting['inner-list'][$homepage_header_sub_title_key]['field_default_text'];

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
            <section class="home-banner-sec" style="background-image: url({{ $imgpath . $homepage_header_bckground_Image }});">
                <div class="container">
                    <div class="home-banner-content">
                        <div class="section-title">
                            <div class="subtitle">{{ !empty($homepage_header_sub_title) ? $homepage_header_sub_title : __('BESTSELLER') }}</div>
                            <h2>{{ !empty($homepage_header_title) ? $homepage_header_title : 'Modern furniture for your interior' }}</h2>
                            <p>{{ !empty($homepage_header_Sub_text) ? $homepage_header_Sub_text : 'There is only that moment and the incredible certainty that everything under the sun has been written by one hand only.' }}</p>
                        </div>
                        <div class="btn-wrp">
                            <a href="{{ route('store.categorie.product', $store->slug) }}" class="btn"> 
                                {{ !empty($homepage_header_Button) ? $homepage_header_Button : __('Start shopping') }}
                                <svg width="28" height="28" viewBox="0 0 28 28" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M6.05543 7.44351C5.83377 7.44351 5.60043 7.35018 5.4371 7.18684C5.09877 6.84851 5.09877 6.28851 5.4371 5.95018L9.6721 1.71518C10.0104 1.37684 10.5704 1.37684 10.9088 1.71518C11.2471 2.05351 11.2471 2.61351 10.9088 2.95184L6.67377 7.18684C6.49877 7.35018 6.2771 7.44351 6.05543 7.44351Z"
                                        fill="white" />
                                    <path
                                        d="M21.9457 7.44351C21.724 7.44351 21.5024 7.36184 21.3274 7.18684L17.0924 2.95184C16.754 2.61351 16.754 2.05351 17.0924 1.71518C17.4307 1.37684 17.9907 1.37684 18.329 1.71518L22.564 5.95018C22.9024 6.28851 22.9024 6.84851 22.564 7.18684C22.4007 7.35018 22.1674 7.44351 21.9457 7.44351Z"
                                        fill="white" />
                                    <path
                                        d="M23.5778 12.3666C23.4961 12.3666 23.4144 12.3666 23.3328 12.3666H23.0644H4.6661C3.84943 12.3783 2.9161 12.3783 2.23943 11.7016C1.70276 11.1766 1.45776 10.36 1.45776 9.15828C1.45776 5.94995 3.80276 5.94995 4.92276 5.94995H23.0761C24.1961 5.94995 26.5411 5.94995 26.5411 9.15828C26.5411 10.3716 26.2961 11.1766 25.7594 11.7016C25.1528 12.3083 24.3361 12.3666 23.5778 12.3666ZM4.92276 10.6166H23.3444C23.8694 10.6283 24.3594 10.6283 24.5228 10.465C24.6044 10.3833 24.7794 10.1033 24.7794 9.15828C24.7794 7.83995 24.4528 7.69995 23.0644 7.69995H4.92276C3.53443 7.69995 3.20776 7.83995 3.20776 9.15828C3.20776 10.1033 3.39443 10.3833 3.46443 10.465C3.62776 10.6166 4.12943 10.6166 4.64276 10.6166H4.92276Z"
                                        fill="white" />
                                    <path
                                        d="M11.3867 21.3499C10.9083 21.3499 10.5117 20.9533 10.5117 20.4749V16.3333C10.5117 15.8549 10.9083 15.4583 11.3867 15.4583C11.865 15.4583 12.2617 15.8549 12.2617 16.3333V20.4749C12.2617 20.9649 11.865 21.3499 11.3867 21.3499Z"
                                        fill="white" />
                                    <path
                                        d="M16.7533 21.3499C16.275 21.3499 15.8783 20.9533 15.8783 20.4749V16.3333C15.8783 15.8549 16.275 15.4583 16.7533 15.4583C17.2317 15.4583 17.6283 15.8549 17.6283 16.3333V20.4749C17.6283 20.9649 17.2317 21.3499 16.7533 21.3499Z"
                                        fill="white" />
                                    <path
                                        d="M17.3717 26.5419H10.3367C6.16001 26.5419 5.22668 24.0569 4.86501 21.8985L3.22001 11.8069C3.13834 11.3285 3.46501 10.8852 3.94334 10.8035C4.42168 10.7219 4.86501 11.0485 4.94667 11.5269L6.59168 21.6069C6.93001 23.6719 7.63001 24.7919 10.3367 24.7919H17.3717C20.37 24.7919 20.7083 23.7419 21.0933 21.7119L23.0533 11.5035C23.1467 11.0252 23.6017 10.7102 24.08 10.8152C24.5583 10.9085 24.8617 11.3635 24.7683 11.8419L22.8083 22.0502C22.3533 24.4185 21.595 26.5419 17.3717 26.5419Z"
                                        fill="white" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </section>
        @endif
    @endforeach
    
    
    {{-- Logo slider --}}
    @include('storefront.logo_slider')

    @if (count($topRatedProducts) > 0)
        <section class="product-sec  pt pb">
            <div class="container">
                <div class="section-title text-center">
                    <h2>{{ __('Top Rated Products') }}</h2>
                </div>
                <div class="product-slider">
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
                                            @if (Auth::guard('customers')->check())
                                                @if (!empty($wishlist) && isset($wishlist[$topRatedProduct->product->id]['product_id']))
                                                    @if ($wishlist[$topRatedProduct->product->id]['product_id'] != $topRatedProduct->product->id)
                                                        <a href="javascript:void(0)" tabindex="0" class="wishlist-btn btn add_to_wishlist wishlist_{{ $topRatedProduct->product->id }}"
                                                            data-id="{{ $topRatedProduct->product->id }}">
                                                            <svg width="28" height="23" viewBox="0 0 28 23" fill="none"
                                                                xmlns="http://www.w3.org/2000/svg">
                                                                <path
                                                                    d="M0.599095 7.38008L0.599095 7.38008C0.539537 4.05401 2.33093 1.69577 4.77155 0.848363C7.21517 -8.66357e-05 10.4236 0.630794 13.2378 3.54845L13.5977 3.92156L13.9575 3.54845C16.7713 0.631207 19.9795 1.89873e-05 22.4231 0.848089C24.8636 1.69511 26.6552 4.05284 26.5962 7.37893C26.5427 10.402 24.4323 13.5144 21.6585 16.2578C19.0068 18.8804 15.8394 21.077 13.5977 22.4186C11.3561 21.0771 8.18894 18.8807 5.53733 16.2583C2.76364 13.5152 0.653182 10.4029 0.599095 7.38008Z"
                                                                    fill="white" stroke="black"></path>
                                                            </svg>
                                                        </a>
                                                    @else
                                                        <a href="javascript:void(0)" tabindex="0" class="wishlist-btn btn wishlist-active wishlist_{{ $topRatedProduct->product->id }}"
                                                            disabled>
                                                            <svg width="28" height="23" viewBox="0 0 28 23" fill="none"
                                                                xmlns="http://www.w3.org/2000/svg">
                                                                <path
                                                                    d="M0.599095 7.38008L0.599095 7.38008C0.539537 4.05401 2.33093 1.69577 4.77155 0.848363C7.21517 -8.66357e-05 10.4236 0.630794 13.2378 3.54845L13.5977 3.92156L13.9575 3.54845C16.7713 0.631207 19.9795 1.89873e-05 22.4231 0.848089C24.8636 1.69511 26.6552 4.05284 26.5962 7.37893C26.5427 10.402 24.4323 13.5144 21.6585 16.2578C19.0068 18.8804 15.8394 21.077 13.5977 22.4186C11.3561 21.0771 8.18894 18.8807 5.53733 16.2583C2.76364 13.5152 0.653182 10.4029 0.599095 7.38008Z"
                                                                    fill="white" stroke="black"></path>
                                                            </svg>
                                                        </a>
                                                    @endif
                                                @else
                                                    <a href="javascript:void(0)" tabindex="0" class="wishlist-btn btn add_to_wishlist wishlist_{{ $topRatedProduct->product->id }}"
                                                        data-id="{{ $topRatedProduct->product->id }}">
                                                        <svg width="28" height="23" viewBox="0 0 28 23" fill="none"
                                                            xmlns="http://www.w3.org/2000/svg">
                                                            <path
                                                                d="M0.599095 7.38008L0.599095 7.38008C0.539537 4.05401 2.33093 1.69577 4.77155 0.848363C7.21517 -8.66357e-05 10.4236 0.630794 13.2378 3.54845L13.5977 3.92156L13.9575 3.54845C16.7713 0.631207 19.9795 1.89873e-05 22.4231 0.848089C24.8636 1.69511 26.6552 4.05284 26.5962 7.37893C26.5427 10.402 24.4323 13.5144 21.6585 16.2578C19.0068 18.8804 15.8394 21.077 13.5977 22.4186C11.3561 21.0771 8.18894 18.8807 5.53733 16.2583C2.76364 13.5152 0.653182 10.4029 0.599095 7.38008Z"
                                                                fill="white" stroke="black"></path>
                                                        </svg>
                                                    </a>
                                                @endif
                                            @else
                                                <a href="javascript:void(0)" class="wishlist-btn btn add_to_wishlist wishlist_{{ $topRatedProduct->product->id }}"
                                                    data-id="{{ $topRatedProduct->product->id }}">
                                                    <svg width="28" height="23" viewBox="0 0 28 23" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M0.599095 7.38008L0.599095 7.38008C0.539537 4.05401 2.33093 1.69577 4.77155 0.848363C7.21517 -8.66357e-05 10.4236 0.630794 13.2378 3.54845L13.5977 3.92156L13.9575 3.54845C16.7713 0.631207 19.9795 1.89873e-05 22.4231 0.848089C24.8636 1.69511 26.6552 4.05284 26.5962 7.37893C26.5427 10.402 24.4323 13.5144 21.6585 16.2578C19.0068 18.8804 15.8394 21.077 13.5977 22.4186C11.3561 21.0771 8.18894 18.8807 5.53733 16.2583C2.76364 13.5152 0.653182 10.4029 0.599095 7.38008Z"
                                                            fill="white" stroke="black"></path>
                                                    </svg>
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="product-content">
                                    <div class="product-content-top">
                                        <div class="product-cart-btn">
                                            @if ($topRatedProduct->product->enable_product_variant == 'on')
                                                <a href="{{ route('store.product.product_view', [$store->slug, $topRatedProduct->product->id]) }}" class="compare-btn btn cart-btn">
                                                    <span>
                                                        <svg width="15" height="15" viewBox="0 0 15 15" fill="none"
                                                            xmlns="http://www.w3.org/2000/svg">
                                                            <path
                                                                d="M7.50003 15C6.93706 15 6.4809 14.5438 6.4809 13.9809V1.01913C6.4809 0.456164 6.93706 0 7.50003 0C8.063 0 8.51916 0.456164 8.51916 1.01913V13.9809C8.51916 14.5438 8.063 15 7.50003 15Z"
                                                                fill="white" />
                                                            <path
                                                                d="M13.9809 8.51922H1.01913C0.456164 8.51922 0 8.06306 0 7.50009C0 6.93712 0.456164 6.48096 1.01913 6.48096H13.9809C14.5438 6.48096 15 6.93712 15 7.50009C15 8.06306 14.5438 8.51922 13.9809 8.51922Z"
                                                                fill="white" />
                                                        </svg>
                                                    </span>
                                                    {{ __('Add To Cart') }}
                                                </a>
                                            @else
                                                <a data-id="{{ $topRatedProduct->product->id }}" class="compare-btn btn cart-btn add_to_cart">
                                                    <span>
                                                        <svg width="15" height="15" viewBox="0 0 15 15" fill="none"
                                                            xmlns="http://www.w3.org/2000/svg">
                                                            <path
                                                                d="M7.50003 15C6.93706 15 6.4809 14.5438 6.4809 13.9809V1.01913C6.4809 0.456164 6.93706 0 7.50003 0C8.063 0 8.51916 0.456164 8.51916 1.01913V13.9809C8.51916 14.5438 8.063 15 7.50003 15Z"
                                                                fill="white" />
                                                            <path
                                                                d="M13.9809 8.51922H1.01913C0.456164 8.51922 0 8.06306 0 7.50009C0 6.93712 0.456164 6.48096 1.01913 6.48096H13.9809C14.5438 6.48096 15 6.93712 15 7.50009C15 8.06306 14.5438 8.51922 13.9809 8.51922Z"
                                                                fill="white" />
                                                        </svg>
                                                    </span>
                                                    {{ __('Add To Cart') }}
                                                </a>
                                            @endif
                                        </div>
                                        <h3>
                                            <a href="{{ route('store.product.product_view', [$store->slug, $topRatedProduct->product->id]) }}">{{ $topRatedProduct->product->name }}</a>
                                        </h3>
                                        <div class="rating product-rating flex align-center justify-center">
                                            @if ($store->enable_rating == 'on')
                                                @php
                                                    $rating = $topRatedProduct->product->product_rating();
                                                @endphp
                                                @for ($i = 1; $i <= 5; $i++)
                                                    @php
                                                        $icon = 'fa-star';
                                                        $color = '';
                                                        $newVal1 = $i - 0.5;
                                                        if ($rating >= $newVal1) {
                                                            $color = 'text-warning';
                                                        }
                                                        if ($rating < $i && $rating >= $newVal1) {
                                                            $icon = 'fa-star-half-alt';
                                                        }
                                                    @endphp
                                                    <i class="star fas {{ $icon . ' ' . $color }}"></i>
                                                @endfor
                                            @endif
                                        </div>
                                    </div>
                                    <div class="product-content-bottom">
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
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- Promotion --}}
    @include('storefront.promotion')
    
    @foreach ($getStoreThemeSetting as $ThemeSetting)
        @if (isset($ThemeSetting['section_name']) && $ThemeSetting['section_name'] == 'Top-Purchased' && $ThemeSetting['section_enable'] == 'on')
            @php
                $homepage_header_title_key = array_search('Title', array_column($ThemeSetting['inner-list'], 'field_name'));
                $homepage_header_title = $ThemeSetting['inner-list'][$homepage_header_title_key]['field_default_text'];

                $homepage_header_subtext_key = array_search('Sub text', array_column($ThemeSetting['inner-list'], 'field_name'));
                $homepage_header_subtext = $ThemeSetting['inner-list'][$homepage_header_subtext_key]['field_default_text'];

                $homepage_header_btn_key = array_search('Button Text', array_column($ThemeSetting['inner-list'], 'field_name'));
                $homepage_header_btn = $ThemeSetting['inner-list'][$homepage_header_btn_key]['field_default_text'];
            @endphp
            <section class="most-purchased-product-sec pt pb">
                <div class="container">
                    @if(!empty($mostPurchasedDetail))
                        <div class="most-purchased-wrp flex align-center">
                            <div class="most-purchased-left">
                                <div class="purchased-product-img img-ratio">
                                    @if (!empty($mostPurchasedDetail->is_cover))
                                        <img src="{{ $coverImg . $mostPurchasedDetail->is_cover }}" alt="most-purchased-img" loading="lazy">
                                    @else
                                        <img src="{{ asset(Storage::url('uploads/is_cover_image/default.jpg')) }}" alt="most-purchased-img" loading="lazy">
                                    @endif
                                </div>
                            </div>
                            <div class="most-purchased-right">
                                <div class="purchased-product-content">
                                    <div class="section-title">
                                        <h2>{{ $homepage_header_title }}</h2>
                                        <p>{{ $homepage_header_subtext }}</p>
                                    </div>
                                    <div class="btn-wrp">
                                        <a href="{{ route('store.product.product_view', [$store->slug, $mostPurchasedDetail->id]) }}" class="btn">{{ $homepage_header_btn }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </section>
        @endif
    @endforeach

    @if ($products['Start shopping']->count() > 0)
        <section class="top-product-sec tabs-wrapper pb">
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
                                <div class="row">
                                    @foreach ($items as $product)
                                        <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-12">
                                            @include('storefront.theme9.common.product_section')
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

    @if(isset($pro_categories) && !empty($pro_categories))
        <section class="category-sec pb">
            <div class="container">
                <div class="category-slider">
                    @foreach ($pro_categories as $pro_categorie)
                    <div class="category-card">
                        <div class="category-card-inner">
                            @if (!empty($pro_categorie->categorie_img) )
                                <img src="{{ $catimg . (!empty($pro_categorie->categorie_img) ? $pro_categorie->categorie_img : 'default.jpg') }}" class="category-card-img">
                            @else
                                <img src="{{ asset(Storage::url('uploads/product_image/default.jpg')) }}" class="category-card-img">
                            @endif
                            <div class="category-card-content">
                                <h3>
                                    <a href="{{ route('store.categorie.product', [$store->slug, $pro_categorie->name]) }}" tabindex="0">
                                        {{ $pro_categorie->name }}</a>
                                </h3>
                                <a href="{{ route('store.categorie.product', [$store->slug, $pro_categorie->name]) }}" tabindex="0" class="btn">{{ __('View') }}</a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    @foreach ($getStoreThemeSetting as $ThemeSetting)
        @if (isset($ThemeSetting['section_name']) && $ThemeSetting['section_name'] == 'Central-Banner' && $ThemeSetting['section_enable'] == 'on')
            @php
                $central_banner_title_key = array_search('Title', array_column($ThemeSetting['inner-list'], 'field_name'));
                $central_banner_Sub_text_key = array_search('Sub text', array_column($ThemeSetting['inner-list'], 'field_name'));
                $central_banner_Button_key = array_search('Button', array_column($ThemeSetting['inner-list'], 'field_name'));
                $central_banner_bckground_Image_key = array_search('Background Image', array_column($ThemeSetting['inner-list'], 'field_name'));

                if(isset($getStoreThemeSetting[0]['bannner-title'])){
                    $central_banner_title = $getStoreThemeSetting[0]['bannner-title'][0] ?? $ThemeSetting['inner-list'][$central_banner_title_key]['field_default_text'];

                    $central_banner_Sub_text = $getStoreThemeSetting[0]['central-sub-text'][0] ?? $ThemeSetting['inner-list'][$central_banner_Sub_text_key]['field_default_text'];
                    
                    $central_banner_Button = $getStoreThemeSetting[0]['central-header-button'][0] ?? $ThemeSetting['inner-list'][$central_banner_Button_key]['field_default_text'];
                    
                    $central_banner_bckground_Image = $getStoreThemeSetting[0]['central-header-bg-image'][0]['image'] ?? $ThemeSetting['inner-list'][$central_banner_bckground_Image_key]['field_default_text'];
                } else {
                    $central_banner_title = $ThemeSetting['inner-list'][$central_banner_title_key]['field_default_text'];
                    
                    $central_banner_Sub_text = $ThemeSetting['inner-list'][$central_banner_Sub_text_key]['field_default_text'];
                    
                    $central_banner_Button = $ThemeSetting['inner-list'][$central_banner_Button_key]['field_default_text'];
                    
                    $central_banner_bckground_Image = $ThemeSetting['inner-list'][$central_banner_bckground_Image_key]['field_default_text'];
                }
            @endphp
            <section class="bestseller-sec" style="background-image: url({{ $imgpath . $central_banner_bckground_Image }});">
                <div class="container">
                    <div class="bestseller-content">
                        <div class="section-title">
                            <h2>{{ $central_banner_title }}</h2>
                            <p>{{ $central_banner_Sub_text }}</p>
                        </div>
                        <div class="btn-wrp">
                            <a href="{{ route('store.categorie.product', $store->slug) }}" class="btn">{{ $central_banner_Button }}</a>
                        </div>
                    </div>
                </div>
            </section>
        @endif
    @endforeach

    @if ($getStoreThemeSetting[5]['section_enable'] == 'on')
        <section class="category-list-sec pt pb">
            <div class="container">
                <div class="category-list-slider">
                    @php
                        $homepage_category_text = $homepage_category_btn = $homepage_category_bg_img = '';
                        $homepage_category_2 = $getStoreThemeSetting[5];
                    @endphp
                    @for ($i = 0; $i < $homepage_category_2['loop_number']; $i++)
                        @php
                            foreach ($homepage_category_2['inner-list'] as $homepage_category_2_value) {
                                if ($homepage_category_2_value['field_slug'] == 'homepage-categories-title') {
                                    $homepage_category_text = $homepage_category_2_value['field_default_text'];
                                }
                                if ($homepage_category_2_value['field_slug'] == 'homepage-categories-sub-text') {
                                    $homepage_category_sub_text = $homepage_category_2_value['field_default_text'];
                                }
                                if ($homepage_category_2_value['field_slug'] == 'homepage-categories-bg-image') {
                                    $homepage_category_bg_img = $homepage_category_2_value['field_default_text'];
                                }
            
                                if (!empty($homepage_category_2[$homepage_category_2_value['field_slug']])) {
                                    if ($homepage_category_2_value['field_slug'] == 'homepage-categories-title') {
                                        $homepage_category_text = $homepage_category_2[$homepage_category_2_value['field_slug']][$i];
                                    }
                                    if ($homepage_category_2_value['field_slug'] == 'homepage-categories-sub-text') {
                                        $homepage_category_sub_text = $homepage_category_2[$homepage_category_2_value['field_slug']][$i];
                                    }
                                    if ($homepage_category_2_value['field_slug'] == 'homepage-categories-bg-image') {
                                        $homepage_category_bg_img = $homepage_category_2[$homepage_category_2_value['field_slug']][$i]['field_prev_text'];
                                    }
                                }
                            }
                        @endphp
                        <div class="category-list-card">
                            <div class="category-list-inner">
                                <div class="category-list-image">
                                    <img src="{{ $imgpath . $homepage_category_bg_img }}" alt="category-list-img" loading="lazy">
                                </div>
                                <div class="category-list-content">
                                    <h2>{{ $homepage_category_text }}</h2>
                                    <span>{{ $homepage_category_sub_text }}</span>
                                </div>
                            </div>
                        </div>
                    @endfor
                </div>
            </div>
        </section>
    @endif
    
    @if($getStoreThemeSetting[6]['section_enable'] == 'on')
        <section class="testimonial-sec pb">
            <div class="container">
                <div class="section-title text-center">
                    @foreach ($getStoreThemeSetting as $storethemesetting)
                        @if (isset($storethemesetting['section_name']) && $storethemesetting['section_name'] == 'Home-Testimonial' && $storethemesetting['array_type'] == 'inner-list' && $storethemesetting['section_enable'] == 'on')
                            @php
                                $Heading_key = array_search('Heading', array_column($storethemesetting['inner-list'], 'field_name'));
                                $Heading = $storethemesetting['inner-list'][$Heading_key]['field_default_text'];
                            @endphp
                            <h2>{{ !empty($Heading) ? $Heading : __('Testimonials') }}</h2>
                        @endif
                    @endforeach
                </div>
            </div>
            <div class="testimonial-slider">
                @foreach ($testimonials as $key => $testimonial)
                    <div class="testimonial-card">
                        <div class="testimonial-card-inner">
                            <div class="testimonial-card-image">
                                <div class="testimonial-img">
                                    <img src="{{ $testimonialImg . (!empty($testimonial->image) ? $testimonial->image : 'avatar.png') }}" alt="testimonial-img" loading="lazy">
                                </div>
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
                                <div class="subtitle">{{ $testimonial->sub_title ?? '' }}</div>
                                <span>-{{ $testimonial->title ?? '' }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="testimonial-arrows flex align-center justify-between">
                <div class="slick-prev testimonial-left slick-arrow">
                    <svg width="14" height="22" viewBox="0 0 14 22" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M9.19189 11.0048L0.679609 2.82128C0.445222 2.5965 0.316281 2.29595 0.316281 1.97548C0.316281 1.65483 0.445222 1.35446 0.679608 1.12932L1.4255 0.412623C1.65952 0.187122 1.97234 0.0629903 2.3057 0.0629903C2.63906 0.0629902 2.95151 0.187122 3.18571 0.412623L13.3209 10.1557C13.5561 10.3816 13.6848 10.6834 13.6839 11.0042C13.6848 11.3265 13.5563 11.6279 13.3209 11.8539L3.19515 21.5876C2.96095 21.8131 2.64849 21.9373 2.31495 21.9373C1.98159 21.9373 1.66914 21.8131 1.43475 21.5876L0.689045 20.8709C0.203808 20.4045 0.203808 19.6451 0.689045 19.1788L9.19189 11.0048Z"
                            fill="white" />
                    </svg>
                </div>
                <div class="slick-next testimonial-right slick-arrow">
                    <svg width="14" height="22" viewBox="0 0 14 22" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M9.19189 11.0048L0.679609 2.82128C0.445222 2.5965 0.316281 2.29595 0.316281 1.97548C0.316281 1.65483 0.445222 1.35446 0.679608 1.12932L1.4255 0.412623C1.65952 0.187122 1.97234 0.0629903 2.3057 0.0629903C2.63906 0.0629902 2.95151 0.187122 3.18571 0.412623L13.3209 10.1557C13.5561 10.3816 13.6848 10.6834 13.6839 11.0042C13.6848 11.3265 13.5563 11.6279 13.3209 11.8539L3.19515 21.5876C2.96095 21.8131 2.64849 21.9373 2.31495 21.9373C1.98159 21.9373 1.66914 21.8131 1.43475 21.5876L0.689045 20.8709C0.203808 20.4045 0.203808 19.6451 0.689045 19.1788L9.19189 11.0048Z"
                            fill="white" />
                    </svg>
                </div>
            </div>
        </section>
    @endif
</main>
@endsection

