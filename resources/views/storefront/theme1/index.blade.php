@extends('storefront.layout.theme1')
@section('page-title')
    {{ __('Home') }}
@endsection

@push('css-page')
@endpush

@php
$imgpath=\App\Models\Utility::get_file('uploads/');
$coverImg = \App\Models\Utility::get_file('uploads/is_cover_image/');
$productImg = \App\Models\Utility::get_file('uploads/product_image/');
$testimonialImg = \App\Models\Utility::get_file('uploads/testimonial_image/');
$default =\App\Models\Utility::get_file('uploads/theme1/header/logo4.png');
$theme_name = $store->theme_dir;
@endphp

@section('content')
<main>
    @foreach ($pixelScript as $script)
        <?= $script; ?>
    @endforeach

    {{-- Banner --}}
    @foreach($getStoreThemeSetting as $ThemeSetting )
        @if (isset($ThemeSetting['section_name']) && $ThemeSetting['section_name'] == 'Home-Header' && $ThemeSetting['section_enable'] == 'on')
        @php
            $homepage_header_title_key = array_search('Title', array_column($ThemeSetting['inner-list'], 'field_name'));
            $homepage_header_title = $ThemeSetting['inner-list'][$homepage_header_title_key]['field_default_text'];

            $homepage_header_Sub_text_key = array_search('Sub text', array_column($ThemeSetting['inner-list'], 'field_name'));
            $homepage_header_Sub_text = $ThemeSetting['inner-list'][$homepage_header_Sub_text_key]['field_default_text'];

            $homepage_header_Button_key = array_search('Button', array_column($ThemeSetting['inner-list'], 'field_name'));
            $homepage_header_Button = $ThemeSetting['inner-list'][$homepage_header_Button_key]['field_default_text'];

            $homepage_header_background_Image_key = array_search('Background Image', array_column($ThemeSetting['inner-list'], 'field_name'));
            $homepage_header_background_Image = $ThemeSetting['inner-list'][$homepage_header_background_Image_key ]['field_default_text'];
        @endphp

            <section class="main-banner-sec" style="background-image: url({{ $imgpath. $homepage_header_background_Image}});">
                <div class="container">
                    <div class="banner-content-row flex justify-center text-center">
                        <div class="banner-content">
                            <div class="section-title">
                                <h2>{{ !empty($homepage_header_title) ? $homepage_header_title : __('Home Accessories') }}</h2>
                                <p>{{ !empty($homepage_header_Sub_text) ? $homepage_header_Sub_text : __('There is only that moment and the incredible certainty that everything under the sun has been written by one hand only.') }}</p>
                            </div>
                            <div class="banner-btn">
                                <a href="{{ route('store.categorie.product', $store->slug) }}" tabindex="0" class="btn">{{ !empty($homepage_header_Button) ? $homepage_header_Button : __('Start Shopping') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @endif
    @endforeach

    {{-- Products --}}
    @if ($products['Start shopping']->count() > 0)
        <section class="product-sec tabs-wrapper pb">
            <div class="container">
                <div class="section-title text-center">
                    <h2>{{ __('Trending Products') }}</h2>
                </div>
                <div class="tab-head-row flex justify-center">
                    <ul class="tabs flex no-wrap align-center">
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
                                            @include('storefront.theme1.common.product_section')
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

    {{-- Newsletter/Subscription --}}
    @if($getStoreThemeSetting[2]['section_enable'] == 'on')
        @foreach ($getStoreThemeSetting as $storethemesetting)
            @if (isset($storethemesetting['section_name']) && $storethemesetting['section_name'] == 'Home-Email-Subscriber' && $storethemesetting['section_enable'] == 'on')
                @php
                    $emailsubs_img_key = array_search('Subscriber Background Image', array_column($storethemesetting['inner-list'], 'field_name'));
                    $emailsubs_img = $storethemesetting['inner-list'][$emailsubs_img_key]['field_default_text'];

                    $SubscriberTitle_key = array_search('Subscriber Title', array_column($storethemesetting['inner-list'], 'field_name'));
                    $SubscriberTitle = $storethemesetting['inner-list'][$SubscriberTitle_key]['field_default_text'];

                    $SubscriberDescription_key = array_search('Subscriber Description', array_column($storethemesetting['inner-list'], 'field_name'));
                    $SubscriberDescription = $storethemesetting['inner-list'][$SubscriberDescription_key]['field_default_text'];

                    $SubscribeButton_key = array_search('Subscribe Button Text', array_column($storethemesetting['inner-list'], 'field_name'));
                    $SubscribeButton = $storethemesetting['inner-list'][$SubscribeButton_key]['field_default_text'];
                @endphp
                <section class="newsletter-sec" style="background-image: url({{ $imgpath  . $emailsubs_img }});">
                    <img src="{{ asset('assets/' . $theme_name . '/images/newsletter-bg-img1.png') }}" alt="newsletter-bg" class="newsletter-bg newsletter-img-top">
                    <img src="{{ asset('assets/' . $theme_name . '/images/newsletter-bg-img2.png') }}" alt="newsletter-bg" class="newsletter-bg newsletter-img-bottom">
                    <div class="container">
                        <div class="newsletter-content">
                            <div class="section-title text-center">
                                <h2>{{ !empty($SubscriberTitle) ? $SubscriberTitle : __('Always on time') }}</h2>
                                <p>{{ !empty($SubscriberDescription) ? $SubscriberDescription : __('Subscription here') }}</p>
                            </div>
                            {{ Form::open(['route' => ['subscriptions.store_email', $store->id], 'method' => 'POST', 'class' => 'newsletter-form']) }}
                                <div class="newsletter-form-wrp flex">
                                    {{ Form::email('email', null, ['placeholder' => __('Enter Your Email Address'), 'class' => 'newsletter-input', 'required' => 'required']) }}
                                    <button type="submit" class="btn">{{ $SubscribeButton }}</button>
                                </div>
                            {{ Form::close() }}
                        </div>
                    </div>
                </section>
            @endif
        @endforeach
    @endif

    {{-- Top Products --}}
    @if (count($topRatedProducts) > 0)
        <section class="top-product-sec pt pb">
            <div class="container">
                <div class="section-title text-center">
                    <h2>{{ __('Top Rated Products') }}</h2>
                </div>
                <div class="row">
                    @foreach ($topRatedProducts as $k => $topRatedProduct)
                        <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-12">
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
                                        <div class="pro-btn-wrapper ">
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

                                            <div class="pro-btn">
                                                @if ($topRatedProduct->product->enable_product_variant == 'on')
                                                    <a href="{{ route('store.product.product_view', [$store->slug, $topRatedProduct->product->id]) }}" class="compare-btn btn cart-btn">
                                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                            xmlns="http://www.w3.org/2000/svg">
                                                            <path
                                                                d="M5.19086 6.37945C5.00086 6.37945 4.80086 6.29945 4.66086 6.15945C4.37086 5.86945 4.37086 5.38945 4.66086 5.09945L8.29086 1.46945C8.58086 1.17945 9.06086 1.17945 9.35086 1.46945C9.64086 1.75945 9.64086 2.23945 9.35086 2.52945L5.72086 6.15945C5.57086 6.29945 5.38086 6.37945 5.19086 6.37945Z"
                                                                fill="#202126" />
                                                            <path
                                                                d="M18.8101 6.37945C18.6201 6.37945 18.4301 6.30945 18.2801 6.15945L14.6501 2.52945C14.3601 2.23945 14.3601 1.75945 14.6501 1.46945C14.9401 1.17945 15.4201 1.17945 15.7101 1.46945L19.3401 5.09945C19.6301 5.38945 19.6301 5.86945 19.3401 6.15945C19.2001 6.29945 19.0001 6.37945 18.8101 6.37945Z"
                                                                fill="#202126" />
                                                            <path
                                                                d="M20.21 10.5996C20.14 10.5996 20.07 10.5996 20 10.5996H19.77H4C3.3 10.6096 2.5 10.6096 1.92 10.0296C1.46 9.57961 1.25 8.87961 1.25 7.84961C1.25 5.09961 3.26 5.09961 4.22 5.09961H19.78C20.74 5.09961 22.75 5.09961 22.75 7.84961C22.75 8.88961 22.54 9.57961 22.08 10.0296C21.56 10.5496 20.86 10.5996 20.21 10.5996ZM4.22 9.09961H20.01C20.46 9.10961 20.88 9.10961 21.02 8.96961C21.09 8.89961 21.24 8.65961 21.24 7.84961C21.24 6.71961 20.96 6.59961 19.77 6.59961H4.22C3.03 6.59961 2.75 6.71961 2.75 7.84961C2.75 8.65961 2.91 8.89961 2.97 8.96961C3.11 9.09961 3.54 9.09961 3.98 9.09961H4.22Z"
                                                                fill="#202126" />
                                                            <path
                                                                d="M9.76074 18.3C9.35074 18.3 9.01074 17.96 9.01074 17.55V14C9.01074 13.59 9.35074 13.25 9.76074 13.25C10.1707 13.25 10.5107 13.59 10.5107 14V17.55C10.5107 17.97 10.1707 18.3 9.76074 18.3Z"
                                                                fill="#202126" />
                                                            <path
                                                                d="M14.3604 18.3C13.9504 18.3 13.6104 17.96 13.6104 17.55V14C13.6104 13.59 13.9504 13.25 14.3604 13.25C14.7704 13.25 15.1104 13.59 15.1104 14V17.55C15.1104 17.97 14.7704 18.3 14.3604 18.3Z"
                                                                fill="#202126" />
                                                            <path
                                                                d="M14.8907 22.7488H8.86073C5.28073 22.7488 4.48073 20.6188 4.17073 18.7688L2.76073 10.1188C2.69073 9.70878 2.97073 9.32878 3.38073 9.25878C3.79073 9.18878 4.17073 9.46878 4.24073 9.87878L5.65073 18.5188C5.94073 20.2888 6.54073 21.2488 8.86073 21.2488H14.8907C17.4607 21.2488 17.7507 20.3488 18.0807 18.6088L19.7607 9.85878C19.8407 9.44878 20.2307 9.17878 20.6407 9.26878C21.0507 9.34878 21.3107 9.73878 21.2307 10.1488L19.5507 18.8988C19.1607 20.9288 18.5107 22.7488 14.8907 22.7488Z"
                                                                fill="#202126" />
                                                        </svg>
                                                    </a>
                                                @else
                                                    <a data-id="{{ $topRatedProduct->product->id }}" class="compare-btn btn cart-btn add_to_cart">
                                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                            xmlns="http://www.w3.org/2000/svg">
                                                            <path
                                                                d="M5.19086 6.37945C5.00086 6.37945 4.80086 6.29945 4.66086 6.15945C4.37086 5.86945 4.37086 5.38945 4.66086 5.09945L8.29086 1.46945C8.58086 1.17945 9.06086 1.17945 9.35086 1.46945C9.64086 1.75945 9.64086 2.23945 9.35086 2.52945L5.72086 6.15945C5.57086 6.29945 5.38086 6.37945 5.19086 6.37945Z"
                                                                fill="#202126" />
                                                            <path
                                                                d="M18.8101 6.37945C18.6201 6.37945 18.4301 6.30945 18.2801 6.15945L14.6501 2.52945C14.3601 2.23945 14.3601 1.75945 14.6501 1.46945C14.9401 1.17945 15.4201 1.17945 15.7101 1.46945L19.3401 5.09945C19.6301 5.38945 19.6301 5.86945 19.3401 6.15945C19.2001 6.29945 19.0001 6.37945 18.8101 6.37945Z"
                                                                fill="#202126" />
                                                            <path
                                                                d="M20.21 10.5996C20.14 10.5996 20.07 10.5996 20 10.5996H19.77H4C3.3 10.6096 2.5 10.6096 1.92 10.0296C1.46 9.57961 1.25 8.87961 1.25 7.84961C1.25 5.09961 3.26 5.09961 4.22 5.09961H19.78C20.74 5.09961 22.75 5.09961 22.75 7.84961C22.75 8.88961 22.54 9.57961 22.08 10.0296C21.56 10.5496 20.86 10.5996 20.21 10.5996ZM4.22 9.09961H20.01C20.46 9.10961 20.88 9.10961 21.02 8.96961C21.09 8.89961 21.24 8.65961 21.24 7.84961C21.24 6.71961 20.96 6.59961 19.77 6.59961H4.22C3.03 6.59961 2.75 6.71961 2.75 7.84961C2.75 8.65961 2.91 8.89961 2.97 8.96961C3.11 9.09961 3.54 9.09961 3.98 9.09961H4.22Z"
                                                                fill="#202126" />
                                                            <path
                                                                d="M9.76074 18.3C9.35074 18.3 9.01074 17.96 9.01074 17.55V14C9.01074 13.59 9.35074 13.25 9.76074 13.25C10.1707 13.25 10.5107 13.59 10.5107 14V17.55C10.5107 17.97 10.1707 18.3 9.76074 18.3Z"
                                                                fill="#202126" />
                                                            <path
                                                                d="M14.3604 18.3C13.9504 18.3 13.6104 17.96 13.6104 17.55V14C13.6104 13.59 13.9504 13.25 14.3604 13.25C14.7704 13.25 15.1104 13.59 15.1104 14V17.55C15.1104 17.97 14.7704 18.3 14.3604 18.3Z"
                                                                fill="#202126" />
                                                            <path
                                                                d="M14.8907 22.7488H8.86073C5.28073 22.7488 4.48073 20.6188 4.17073 18.7688L2.76073 10.1188C2.69073 9.70878 2.97073 9.32878 3.38073 9.25878C3.79073 9.18878 4.17073 9.46878 4.24073 9.87878L5.65073 18.5188C5.94073 20.2888 6.54073 21.2488 8.86073 21.2488H14.8907C17.4607 21.2488 17.7507 20.3488 18.0807 18.6088L19.7607 9.85878C19.8407 9.44878 20.2307 9.17878 20.6407 9.26878C21.0507 9.34878 21.3107 9.73878 21.2307 10.1488L19.5507 18.8988C19.1607 20.9288 18.5107 22.7488 14.8907 22.7488Z"
                                                                fill="#202126" />
                                                        </svg>
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="product-content text-center">
                                        <div class="product-content-top">
                                            <div class="product-lbl">
                                                {{ $topRatedProduct->product->product_category() }}
                                            </div>
                                            <h3>
                                                <a href="{{ route('store.product.product_view', [$store->slug, $topRatedProduct->product->id]) }}">{{ $topRatedProduct->product->name }}</a>
                                            </h3>
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
                                            <div class="rating flex align-center justify-center">
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
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="product-btn-wrp flex justify-center">
                    <a href="{{ route('store.categorie.product', $store->slug) }}" class="showmore-btn btn">{{ __('Show more products') }}</a>
                </div>
            </div>
        </section>
    @endif

    {{-- Category --}}
    @foreach ($getStoreThemeSetting as $storethemesetting)
        @if (isset($storethemesetting['section_name']) && $storethemesetting['section_name'] == 'Home-Categories' && $storethemesetting['section_enable'] == 'on' && !empty($pro_categories))
            @php
                $Titlekey = array_search('Title', array_column($storethemesetting['inner-list'], 'field_name'));
                $Title = $storethemesetting['inner-list'][$Titlekey]['field_default_text'];

                $Description_key = array_search('Description', array_column($storethemesetting['inner-list'], 'field_name'));
                $Description = $storethemesetting['inner-list'][$Description_key]['field_default_text'];
            @endphp
            <section class="category-sec pb">
                <div class="container">
                    <div class="section-title text-center">
                        <h2>{{ !empty($Title) ? $Title : __('Categories') }}</h2>
                        <p>{{ !empty($Description) ? $Description : __('There is only that moment and the incredible certainty <br> that everything under the sun has been written by one hand only.') }}</p>
                    </div>
                    <div class="category-slider">
                        @foreach ($pro_categories as $key => $pro_categorie)
                            @if ($product_count[$key] > 0)
                                <div class="category-card">
                                    <div class="category-card-inner">
                                        <div class="category-content flex justify-between align-center">
                                            <h3>
                                                <a href="{{ route('store.categorie.product', [$store->slug, $pro_categorie->name]) }}" tabindex="0">
                                                    {{ $pro_categorie->name }}</a>
                                            </h3>
                                            <div class="category-btn-wrp">
                                                <a href="{{ route('store.categorie.product', [$store->slug, $pro_categorie->name]) }}" class="category-btn">
                                                    <svg width="43" height="43" viewBox="0 0 43 43" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M19.4531 13.1055L30.1981 15.1512L28.1523 25.8961" stroke="#232323"
                                                            stroke-width="1.7" stroke-miterlimit="10" stroke-linecap="round"
                                                            stroke-linejoin="round"></path>
                                                        <path d="M12.2871 27.333L30.0191 15.2731" stroke="#232323"
                                                            stroke-width="1.7" stroke-miterlimit="10" stroke-linecap="round"
                                                            stroke-linejoin="round"></path>
                                                    </svg>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="category-card-image">
                                            <a href="{{ route('store.categorie.product', [$store->slug, $pro_categorie->name]) }}" tabindex="0" class="category-image img-ratio">
                                                @if (!empty($pro_categorie->categorie_img))
                                                    <img src="{{  $productImg . $pro_categorie->categorie_img }}" alt="category-card-image" loading="lazy">
                                                @else
                                                    <img src="{{ asset(Storage::url('uploads/product_image/default.jpg')) }}" alt="category-card-image" loading="lazy">
                                                @endif
                                                <div class="category-card-lbl text-center flex align-center justify-center">
                                                    <b>{{ !empty($product_count[$key]) ? $product_count[$key] : '0' }}</b> <span>{{ __('Products') }}</span>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </section>
        @endif
    @endforeach

    {{-- Testimonial --}}
    @if($getStoreThemeSetting[4]['section_enable'] == 'on')
        <section class="testimonial-sec pb">
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
                            <p>{{ !empty($HeadingSubText) ? $HeadingSubText : __('There is only that moment and the incredible certainty that <br> everything under the sun has been written by one hand only.') }}</p>
                        @endif
                    @endforeach
                </div>
                <div class="testimonial-slider">
                    @foreach ($testimonials as $key => $testimonial)
                        <div class="testimonial-card">
                            <div class="testimonial-card-inner flex">
                                <div class="testimonial-card-image">
                                    <div class="testimonial-img">
                                        <img src="{{ $testimonialImg . (!empty($testimonial->image) ? $testimonial->image : 'avatar.png') }}" alt="testimonial-img" loading="lazy">
                                    </div>
                                </div>
                                <div class="testimonial-card-content">
                                    <div class="testimonial-content-top">
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
                                    </div>
                                    <div class="testimonial-content-bottom">
                                        <p>{{ $testimonial->description ?? '' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- Logo slider --}}
    @include('storefront.logo_slider')

    {{-- Promotion --}}
    @include('storefront.promotion')

</main>
@endsection

