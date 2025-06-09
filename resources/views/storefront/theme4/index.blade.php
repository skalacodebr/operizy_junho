@extends('storefront.layout.theme4')
@section('page-title')
    {{ __('Home') }}
@endsection

@php
$s_logo = \App\Models\Utility::get_file('uploads/store_logo/');
$imgpath = \App\Models\Utility::get_file('uploads/');
$coverImg = \App\Models\Utility::get_file('uploads/is_cover_image/');
$productImg = \App\Models\Utility::get_file('uploads/product_image/');
$testimonialImg = \App\Models\Utility::get_file('uploads/testimonial_image/');
$default = \App\Models\Utility::get_file('uploads/theme4/header/brand_logo.png');
$theme_name = $store->theme_dir;
@endphp

@section('content')
<main>
    @foreach ($pixelScript as $script)
        <?= $script; ?>
    @endforeach

    @if (isset($getStoreThemeSetting[0]['section_name']) && $getStoreThemeSetting[0]['section_name'] == 'Home-Header' && $getStoreThemeSetting[0]['section_enable'] == 'on')
        @php
            $homepage_header_title_key = array_search('Title', array_column($getStoreThemeSetting[0]['inner-list'], 'field_name'));
            $homepage_header_title = $getStoreThemeSetting[0]['inner-list'][$homepage_header_title_key]['field_default_text'];

            $homepage_header_Sub_text_key = array_search('Sub text', array_column($getStoreThemeSetting[0]['inner-list'], 'field_name'));
            $homepage_header_Sub_text = $getStoreThemeSetting[0]['inner-list'][$homepage_header_Sub_text_key]['field_default_text'];

            $homepage_header_Button_key = array_search('Button', array_column($getStoreThemeSetting[0]['inner-list'], 'field_name'));
            $homepage_header_Button = $getStoreThemeSetting[0]['inner-list'][$homepage_header_Button_key]['field_default_text'];

            $homepage_header_background_Image_key = array_search('Background Image', array_column($getStoreThemeSetting[0]['inner-list'], 'field_name'));
            $homepage_header_background_Image = $getStoreThemeSetting[0]['inner-list'][$homepage_header_background_Image_key ]['field_default_text'];
        @endphp
        <section class="home-banner-sec">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 col-12">
                        <div class="banner-left-col">
                            <div class="section-title">
                                <div class="subtitle">{{ __('Trending Collection') }} &#128293;</div>
                                <h2>{{ !empty($homepage_header_title) ? $homepage_header_title : __('Crafted Best Cusion Collection For You') }}</h2>
                                <p>{{ !empty($homepage_header_Sub_text) ? $homepage_header_Sub_text : __('We are at the end of the ‘50s: an interesting series of armchairs and sofas, designed by Roberto Menghi and called Hall, joins arflex collection.') }}</p>
                            </div>
                            <div class="btn-wrp">
                                <a href="{{ route('store.categorie.product', $store->slug) }}" class="btn">{{ !empty($homepage_header_Button) ? $homepage_header_Button : __('Start Shopping') }}
                                    <span>
                                        <svg width="17" height="16" viewBox="0 0 17 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M11.1875 7.99997C11.1875 8.12784 11.1386 8.25584 11.041 8.35347L6.04097 13.3535C5.8456 13.5488 5.52922 13.5488 5.33397 13.3535C5.13872 13.1581 5.1386 12.8417 5.33397 12.6465L9.98047 7.99997L5.33397 3.35347C5.13859 3.15809 5.13859 2.84172 5.33397 2.64647C5.52934 2.45122 5.84572 2.45109 6.04097 2.64647L11.041 7.64647C11.1386 7.74409 11.1875 7.87209 11.1875 7.99997Z" fill="#203D3E"/>
                                            </svg>    
                                    </span>                                    
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="banner-right-col">
                            <div class="banner-image img-ratio">
                                <img src="{{ $imgpath. $homepage_header_background_Image}}" alt="banner-image" loading="lazy">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="banner-slider">
                <span>{{ $store->name }}</span>
            </div>
        </section>
    @endif

    @if($products['Start shopping']->count() > 0)
        <section class="product-sec tabs-wrapper pt pb">
            <div class="container">
                <div class="section-title text-center">
                    <h2>{{ __('Products Category') }}</h2>
                </div>
                <div class="tab-head-row flex justify-center">
                    <ul class="tabs product-tabs flex no-wrap align-center">
                        @foreach($categories as $key => $category)
                            <li class="tab-link {{ $key == 0 ? 'active' : '' }}" data-tab="pdp-tab-{!! preg_replace('/[^A-Za-z0-9\-]/', '_', $category) !!}">
                                <a> {{ __($category) }}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="tabs-container">
                    @foreach($products as $key => $items)
                        <div id="pdp-tab-{!! preg_replace('/[^A-Za-z0-9\-]/', '_', $key)!!}" class="tab-content {{($key=='Start shopping')?'active show':''}}">
                            <div class="row">
                                @if($items->count() > 0)
                                    @foreach($items as $product)
                                        <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-12">
                                            @include('storefront.theme4.common.product_section')
                                        </div>
                                    @endforeach
                                @else
                                    <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-12 product-card">
                                        <h6 class="no_record"><i class="fas fa-ban"></i> {{ __('No Record Found') }}</h6>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="btn-wrp text-center">
                    <a href="{{ route('store.categorie.product', [$store->slug, 'Start shopping']) }}" class="btn">
                        {{ __('Show More Products') }}
                        <span>
                            <svg width="17" height="16" viewBox="0 0 17 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M11.1875 7.99997C11.1875 8.12784 11.1386 8.25584 11.041 8.35347L6.04097 13.3535C5.8456 13.5488 5.52922 13.5488 5.33397 13.3535C5.13872 13.1581 5.1386 12.8417 5.33397 12.6465L9.98047 7.99997L5.33397 3.35347C5.13859 3.15809 5.13859 2.84172 5.33397 2.64647C5.52934 2.45122 5.84572 2.45109 6.04097 2.64647L11.041 7.64647C11.1386 7.74409 11.1875 7.87209 11.1875 7.99997Z" fill="#203D3E"/>
                                </svg>    
                        </span>  
                    </a>
                </div>
            </div>
        </section>
    @endif

    @if (isset($getStoreThemeSetting[3]['section_name']) && $getStoreThemeSetting[3]['section_name'] == 'Home-Categories' && $getStoreThemeSetting[3]['section_enable'] == 'on' && !empty($pro_categories))
        @php
            $Titlekey = array_search('Title', array_column($getStoreThemeSetting[3]['inner-list'], 'field_name'));
            $Title = $getStoreThemeSetting[3]['inner-list'][$Titlekey]['field_default_text'];

            $Description_key = array_search('Description', array_column($getStoreThemeSetting[3]['inner-list'], 'field_name'));
            $Description = $getStoreThemeSetting[3]['inner-list'][$Description_key]['field_default_text'];
        @endphp
        <section class="category-sec pb pt">
            <div class="container">
                <div class="section-title text-center">
                    <h2>{{ !empty($Title) ? $Title : 'Best Categories' }}</h2>
                    <p>{{ !empty($Description) ? $Description : 'There is only that moment and the incredible certainty that everything under the sun has been written by one hand only.' }}</p>
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
                                        <div class="category-card-lbl text-center flex align-center justify-center">
                                            <b>{{ !empty($product_count[$key]) ? $product_count[$key] : '0' }}</b>
                                            <span>{{ __('Products') }}</span>
                                        </div>
                                    </a>
                                </div>
                                <div class="category-card-content text-center">
                                    <h3>
                                        <a href="{{ route('store.categorie.product', [$store->slug, $pro_categorie->name]) }}">{{ $pro_categorie->name }}</a>
                                    </h3>
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

    @if($getStoreThemeSetting[2]['section_enable'] == 'on')
        @if (isset($getStoreThemeSetting[2]['section_name']) && $getStoreThemeSetting[2]['section_name'] == 'Home-Email-Subscriber' && $getStoreThemeSetting[2]['section_enable'] == 'on')
            @php
                $emailsubs_img_key = array_search('Subscriber Background Image', array_column($getStoreThemeSetting[2]['inner-list'], 'field_name'));
                $emailsubs_img = $getStoreThemeSetting[2]['inner-list'][$emailsubs_img_key]['field_default_text'];

                $SubscriberTitle_key = array_search('Subscriber Title', array_column($getStoreThemeSetting[2]['inner-list'], 'field_name'));
                $SubscriberTitle = $getStoreThemeSetting[2]['inner-list'][$SubscriberTitle_key]['field_default_text'];

                $SubscriberDescription_key = array_search('Subscriber Description', array_column($getStoreThemeSetting[2]['inner-list'], 'field_name'));
                $SubscriberDescription = $getStoreThemeSetting[2]['inner-list'][$SubscriberDescription_key]['field_default_text'];

                $SubscribeButton_key = array_search('Subscribe Button Text', array_column($getStoreThemeSetting[2]['inner-list'], 'field_name'));
                $SubscribeButton = $getStoreThemeSetting[2]['inner-list'][$SubscribeButton_key]['field_default_text'];
            @endphp
            <section class="newsletter-sec pt pb">
                <div class="container">
                    <div class="row align-center">
                        <div class="col-md-5 col-12">
                            <div class="newsletter-left-col">
                                <div class="newsletter-img img-ratio">
                                    <img src="{{ $imgpath  . $emailsubs_img }}" alt="newsletter-image" loading="lazy">
                                </div>
                                <div class="newsletter-bottom-img img-ratio">
                                    <img src="{{ $imgpath  . $emailsubs_img }}" alt="newsletter-image" loading="lazy">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-7 col-12">
                            <div class="newsletter-right-col">
                                <div class="section-title">
                                    <h2>{{ !empty($SubscriberTitle) ? $SubscriberTitle : 'Always on time' }}</h2>
                                    <p>{{ !empty($SubscriberDescription) ? $SubscriberDescription : 'There is only that moment and the incredible certainty that everything under the sun has been written by one hand only.' }}</p>
                                </div>
                                {{ Form::open(['route' => ['subscriptions.store_email', $store->id], 'method' => 'POST', 'class' => 'newsletter-form']) }}
                                    <div class="newsletter-form-wrp">
                                        {{ Form::email('email', null, ['placeholder' => __('Enter Your Email Address'), 'class' => 'newsletter-input', 'required' => 'required']) }}
                                        <button type="submit" class="btn">{{ $SubscribeButton }}
                                            <svg width="26" height="25" viewBox="0 0 26 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <g clip-path="url(#clip0_385_121)">
                                                <path d="M9.30209 18.3459V23.1772C9.30209 23.5147 9.51875 23.8137 9.83959 23.9199C9.91979 23.9459 10.0021 23.9584 10.0833 23.9584C10.3271 23.9584 10.5625 23.8439 10.7125 23.6397L13.5385 19.7939L9.30209 18.3459Z" fill="#FFC700"/>
                                                <path d="M24.8594 0.144884C24.6198 -0.0249077 24.3053 -0.0478244 24.0448 0.088634L0.607338 12.3282C0.330255 12.473 0.166713 12.7688 0.18963 13.0803C0.213588 13.3928 0.42088 13.6595 0.715671 13.7605L7.2313 15.9876L21.1073 4.12301L10.3698 17.0595L21.2896 20.7918C21.3709 20.8188 21.4563 20.8334 21.5417 20.8334C21.6834 20.8334 21.824 20.7949 21.948 20.7199C22.1459 20.5991 22.2803 20.3959 22.3146 20.1678L25.1792 0.896967C25.2219 0.605301 25.099 0.315717 24.8594 0.144884Z" fill="#FFC700"/>
                                                </g>
                                                </svg>                                            
                                        </button>
                                    </div>
                                {{ Form::close() }}
                            </div>
                        </div>
                    </div>
                    <div class="newsletter-slider">
                        <span>{{ !empty($SubscriberTitle) ? $SubscriberTitle : 'Always on time' }}</span>
                    </div>
                </div>
            </section>
        @endif
    @endif

    @if($getStoreThemeSetting[4]['section_enable'] == 'on')
        <section class="testimonial-sec pt pb">
            <div class="container">
                <div class="section-title text-center">
                    @if (isset($getStoreThemeSetting[4]['section_name']) && $getStoreThemeSetting[4]['section_name'] == 'Home-Testimonial' && $getStoreThemeSetting[4]['array_type'] == 'inner-list' && $getStoreThemeSetting[4]['section_enable'] == 'on')
                        @php
                            // $Heading_key = array_search('Heading', array_column($getStoreThemeSetting[4]['inner-list'], 'field_name'));
                            $Heading_key = array_search('Main Heading', array_column($getStoreThemeSetting[4]['inner-list'], 'field_name'));
                            $Heading = $getStoreThemeSetting[4]['inner-list'][$Heading_key]['field_default_text'];

                            // $HeadingSubText_key = array_search('Heading Sub Text', array_column($getStoreThemeSetting[4]['inner-list'], 'field_name'));
                            $HeadingSubText_key = array_search('Main Heading Title', array_column($getStoreThemeSetting[4]['inner-list'], 'field_name'));
                            $HeadingSubText = $getStoreThemeSetting[4]['inner-list'][$HeadingSubText_key]['field_default_text'];
                        @endphp
                        <h2>{{ !empty($Heading) ? $Heading : __('Testimonials') }}</h2>
                        <p>{{ !empty($HeadingSubText) ? $HeadingSubText : __('There is only that moment and the incredible certainty that <br> everything under the sun has been written by one hand only.') }}</p>
                    @endif
                </div>
                <div class="testimonial-slider-wrp">
                    <div class="testimonial-slider">
                        @foreach ($testimonials as $key => $testimonial)
                            <div class="testimonial-card">
                                <div class="testimonial-card-inner">
                                    <div class="testimonial-image">
                                        <img src="{{ $testimonialImg . (!empty($testimonial->image) ? $testimonial->image : 'avatar.png') }}" alt="testimonial-card-image" loading="lazy">
                                    </div>
                                    <div class="testimonial-content">
                                        <div class="testimonial-content-inner">
                                            <h3>{{ $testimonial->title ?? '' }}</h3>
                                            <p>{{ $testimonial->sub_title ?? '' }}</p>
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
                            </div>
                        @endforeach
                    </div>
                    <div class="arrow-wrapper flex align-center">
                        <div class="slick-next testimonial-right slick-arrow">
                            <svg width="69" height="24" viewBox="0 0 69 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M68.0607 13.0607C68.6464 12.4749 68.6464 11.5251 68.0607 10.9393L58.5147 1.3934C57.9289 0.807611 56.9792 0.807611 56.3934 1.3934C55.8076 1.97919 55.8076 2.92893 56.3934 3.51472L64.8787 12L56.3934 20.4853C55.8076 21.0711 55.8076 22.0208 56.3934 22.6066C56.9792 23.1924 57.9289 23.1924 58.5147 22.6066L68.0607 13.0607ZM0 13.5H67V10.5H0V13.5Z"
                                    fill="#222222" />
                            </svg>
                        </div>
                        <div class="slick-prev testimonial-left slick-arrow">
                            <svg width="69" height="24" viewBox="0 0 69 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M0.939339 10.9393C0.353554 11.5251 0.353554 12.4749 0.939339 13.0607L10.4853 22.6066C11.0711 23.1924 12.0208 23.1924 12.6066 22.6066C13.1924 22.0208 13.1924 21.0711 12.6066 20.4853L4.12132 12L12.6066 3.51471C13.1924 2.92893 13.1924 1.97918 12.6066 1.39339C12.0208 0.807606 11.0711 0.807606 10.4853 1.39339L0.939339 10.9393ZM69 10.5L2 10.5L2 13.5L69 13.5L69 10.5Z"
                                    fill="#222222" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    {{-- Logo slider --}}
    @include('storefront.logo_slider')
    
</main>
@endsection
@push('script-page')
    <script>
        $(document).ready(function(){
            $('body').addClass('index');
        });
    </script>
@endpush