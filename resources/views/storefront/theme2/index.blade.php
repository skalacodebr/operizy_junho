@extends('storefront.layout.theme2')
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
$default =\App\Models\Utility::get_file('uploads/theme2/header/storego-image.png');
$s_logo = \App\Models\Utility::get_file('uploads/store_logo/');
$theme_name = $store->theme_dir;
@endphp
@section('content')
    <!-- Header_img -->
    @foreach ($getStoreThemeSetting as $ThemeSetting)
        @if (isset($ThemeSetting['section_name']) && $ThemeSetting['section_name'] == 'Home-Header' && $ThemeSetting['section_enable'] == 'on')
            @php
                $homepage_header_title_key = array_search('Title', array_column($ThemeSetting['inner-list'], 'field_name'));
                $homepage_header_title = $ThemeSetting['inner-list'][$homepage_header_title_key]['field_default_text'];

                $homepage_header_Sub_text_key = array_search('Sub text', array_column($ThemeSetting['inner-list'], 'field_name'));
                $homepage_header_Sub_text = $ThemeSetting['inner-list'][$homepage_header_Sub_text_key]['field_default_text'];

                $homepage_header_Button_key = array_search('Button', array_column($ThemeSetting['inner-list'], 'field_name'));
                $homepage_header_Button = $ThemeSetting['inner-list'][$homepage_header_Button_key]['field_default_text'];
                $homepage_header_bckground_Image_key = array_search('Background Image', array_column($ThemeSetting['inner-list'], 'field_name'));
                $homepage_header_bckground_Image = $ThemeSetting['inner-list'][$homepage_header_bckground_Image_key]['field_default_text'];
            @endphp
        @endif
    @endforeach
    
    <main>
        @foreach ($pixelScript as $script)
            <?= $script; ?>
        @endforeach

        {{-- Banner --}}
        @if($getStoreThemeSetting[0]['section_enable'] == 'on')
            <section class="main-banner-sec">
                <img src="{{ asset('assets/' . $theme_name . '/images/banner-bg-img.png') }}" alt="banner-bg-image" class="banner-bg-image">
                <span class="slide-txt">{{ isset($store) ? $store->name :__('delight shop') }}</span>
                <div class="container">
                    <div class="row align-center">
                        <div class="col-lg-6 col-md-7 col-12">
                            <div class="banner-content">
                                <div class="section-title">
                                    <h2>{{ !empty($homepage_header_title) ? $homepage_header_title : 'Home Accessories' }}</h2>
                                    <p>{{ !empty($homepage_header_Sub_text) ? $homepage_header_Sub_text : 'There is only that moment and the incredible certainty that everything under the sun has been written by one hand only.' }}</p>
                                </div>
                                <div class="banner-btn">
                                    <a href="{{ route('store.categorie.product', $store->slug) }}" tabindex="0" class="btn">
                                        {{ !empty($homepage_header_Button) ? $homepage_header_Button : __('Start Shopping') }}
                                        <svg width="31" height="16" viewBox="0 0 31 16" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M30.7071 8.70711C31.0976 8.31658 31.0976 7.68342 30.7071 7.29289L24.3431 0.928932C23.9526 0.538408 23.3195 0.538408 22.9289 0.928932C22.5384 1.31946 22.5384 1.95262 22.9289 2.34315L28.5858 8L22.9289 13.6569C22.5384 14.0474 22.5384 14.6805 22.9289 15.0711C23.3195 15.4616 23.9526 15.4616 24.3431 15.0711L30.7071 8.70711ZM0 9H30V7H0V9Z"
                                                fill="white" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-5 col-12">
                            <div class="banner-image-col">
                                <div class="banner-image img-ratio">
                                    <img src="{{ $imgpath. (!empty($homepage_header_bckground_Image) ? $homepage_header_bckground_Image : 'home-banner1.png') }}" alt="">
                                </div>
                                <div class="banner-image-effect"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @endif

        {{-- Products --}}
        @if ($products['Start shopping']->count() > 0)
            <section class="product-sec tabs-wrapper pb">
                <div class="container">
                    <div class="section-title flex align-center justify-between">
                        <div class="section-title-left">
                            <h2>{{ __('Categories Product') }}</h2>
                        </div>
                        <div class="section-title-right flex">
                            <ul class="tabs product-tabs flex align-center">
                                @foreach ($categories as $key => $category)
                                    <li class="tab-link {{ $key == 0 ? 'active' : '' }}" data-tab="pdp-tab-{!! preg_replace('/[^A-Za-z0-9\-]/', '_', $category) !!}">
                                        <a href="javascript:;" class="btn btn-transparent">
                                            {{ __($category) }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="tabs-container">
                        @foreach ($products as $key => $items)
                            <div id="pdp-tab-{!! preg_replace('/[^A-Za-z0-9\-]/', '_', $key) !!}" class="tab-content {{ $key == 'Start shopping' ? 'active' : '' }}">
                                <div class="row">
                                    @if ($items->count() > 0)
                                        @foreach ($items as $product)
                                            <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-12">
                                                @include('storefront.theme2.common.product_section')
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-12">
                                            <div class="product-card">
                                                <div class="product-card-inner">
                                                    <h6 class="no_record"><i class="fas fa-ban"></i>{{ __('No Record Found') }}</h6>
                                                </div>
                                            </div>
                                        </div>   
                                    @endif
                                </div>
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
                    <section class="newsletter-sec pt pb" style="background-image: url({{ (!empty($emailsubs_img) ? $imgpath . $emailsubs_img : $s_logo . 'email_subscriber_2.png') }});">
                        <div class="container">
                            <div class="newsletter-content-row text-center">
                                <div class="section-title">
                                    <h2>{{ !empty($SubscriberTitle) ? $SubscriberTitle : __('Always on time') }}</h2>
                                    <p>{{ !empty($SubscriberDescription) ? $SubscriberDescription : __('There is only that moment and the incredible certainty that everything under the sun has been written by one hand only.') }}</p>
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
        
        {{-- Category --}}
        @foreach ($getStoreThemeSetting as $storethemesetting)
            @if (isset($storethemesetting['section_name']) && $storethemesetting['section_name'] == 'Home-Categories' && $storethemesetting['section_enable'] == 'on' && !empty($pro_categories))
                @php
                    $Titlekey = array_search('Title', array_column($storethemesetting['inner-list'], 'field_name'));
                    $Title = $storethemesetting['inner-list'][$Titlekey]['field_default_text'];

                    $Description_key = array_search('Description', array_column($storethemesetting['inner-list'], 'field_name'));
                    $Description = $storethemesetting['inner-list'][$Description_key]['field_default_text'];
                @endphp
                <section class="category-sec pt pb">
                    <div class="container">
                        @if($getStoreThemeSetting[3]['section_enable'] == 'on')
                            <div class="section-title flex align-center justify-between">
                                <div class="section-title-left">
                                    <h2>{{ !empty($Title) ? $Title : 'Categories' }}</h2>
                                </div>
                                <div class="section-title-right flex justify-end">
                                    <p>{{ !empty($Description) ? $Description : 'There is only that moment and the incredible certainty that everything under the sun has been written by one hand only.' }}</p>
                                </div>
                            </div>
                        @endif
                        <div class="category-slider">
                            @foreach ($pro_categories as $key => $pro_categorie)
                                <div class="category-card">
                                    <div class="category-card-inner">
                                        @if (!empty($pro_categorie->categorie_img))
                                            <img src="{{ $productImg . $pro_categorie->categorie_img }}" alt="category-image" class="category-card-img">
                                        @else
                                            <img src="{{ asset(Storage::url('uploads/product_image/default.jpg')) }}" alt="category-image" class="category-card-img">
                                        @endif
                                        <div class="category-card-content flex justify-between">
                                            <div class="category-left-content">
                                                <h3>
                                                    <a href="{{ route('store.categorie.product', $store->slug) }}" tabindex="0">{{ $pro_categorie->name }}</a>
                                                </h3>
                                                <p>{{ !empty($product_count[$key]) ? $product_count[$key] . ' ' . __('Products') : '0' . ' ' . __('Products') }}</p>
                                            </div>
                                            <div class="category-right-content">
                                            <a href="{{ route('store.categorie.product', [$store->slug, $pro_categorie->name]) }}" class="cart-btn link-btn">{{ __('Show more products') }}</a>
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
                                <p>{{ !empty($HeadingSubText) ? $HeadingSubText : __('There is only that moment and the incredible certainty that everything under the sun has been written by one hand only.') }}</p>
                            @endif
                        @endforeach
                    </div>
                </div>
                <div class="testimonial-slider">
                    @foreach ($testimonials as $key => $testimonial)
                        <div class="testimonial-card">
                            <div class="testimonial-card-inner">
                                <div class="testimonial-card-image flex">
                                    <div class="testimonial-img">
                                        <img src="{{ $testimonialImg . (!empty($testimonial->image) ? $testimonial->image : 'avatar.png') }}" alt="testimonial-img" loading="lazy">
                                    </div>
                                </div>
                                <div class="testimonial-card-content flex text-center">
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
            </section>
        @endif

        {{-- Logo slider --}}
        @include('storefront.logo_slider')

        {{-- Promotion --}}
        @include('storefront.promotion')

    </main>
    
@endsection

@push('script-page')
    <script>
        $(document).ready(function() {
            $('body').addClass('index');
        });
    </script>
@endpush