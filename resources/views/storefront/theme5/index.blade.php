@extends('storefront.layout.theme5')

@section('page-title')
    {{ __('Home') }}
@endsection

@php
    $s_logo = \App\Models\Utility::get_file('uploads/blog_cover_image/');
    $imgpath = \App\Models\Utility::get_file('uploads/');
    $coverImg = \App\Models\Utility::get_file('uploads/is_cover_image/');
    $productImg = \App\Models\Utility::get_file('uploads/product_image/');
    $testimonialImg = \App\Models\Utility::get_file('uploads/testimonial_image/');
    $default = \App\Models\Utility::get_file('uploads/theme5/header/brand_logo.png');
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
                $homepage_header_title_key = array_search('Title', array_column($ThemeSetting['inner-list'], 'field_name'));
                $homepage_header_title = $ThemeSetting['inner-list'][$homepage_header_title_key]['field_default_text'];
                
                $homepage_header_Sub_text_key = array_search('Sub text', array_column($ThemeSetting['inner-list'], 'field_name'));
                $homepage_header_Sub_text = $ThemeSetting['inner-list'][$homepage_header_Sub_text_key]['field_default_text'];
                
                $homepage_header_Button_key = array_search('Button', array_column($ThemeSetting['inner-list'], 'field_name'));
                $homepage_header_Button = $ThemeSetting['inner-list'][$homepage_header_Button_key]['field_default_text'];
                
                $homepage_header_bckground_Image_key = array_search('Background Image', array_column($ThemeSetting['inner-list'], 'field_name'));
                $homepage_header_bckground_Image = $ThemeSetting['inner-list'][$homepage_header_bckground_Image_key]['field_default_text'];
            @endphp
            <section class="main-banner-sec">
                <div class="banner-bg-wrp">
                    <svg class="banner-bg-img banner-bg-one" width="46" height="39" viewBox="0 0 46 39" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M45.4941 22.8888C41.5488 23.0581 37.6023 23.1925 33.6553 23.299C34.0624 19.7786 34.4073 16.2519 34.7008 12.7202C36.9037 12.6948 39.1071 12.6669 41.3104 12.6528C42.4507 12.6453 43.8181 11.732 44.6578 11.0296C45.0428 10.7076 46.1421 9.67196 44.9998 9.67945C41.6457 9.70109 38.2912 9.73603 34.9376 9.78305C35.1643 6.72111 35.3497 3.65585 35.4904 0.587252C35.5296 -0.261552 30.8236 1.53634 30.7626 2.85906C30.6549 5.19618 30.515 7.53081 30.358 9.86377C25.8027 9.94324 21.2479 10.0419 16.6938 10.1683C17.3915 6.90919 18.0508 3.64128 18.6637 0.363816C18.8245 -0.494975 16.8032 0.421655 16.5715 0.530252C15.8416 0.87227 14.1117 1.69694 13.936 2.6352C13.4571 5.19493 12.9472 7.748 12.4166 10.2969C10.0813 10.3693 7.74601 10.44 5.41115 10.5249C4.25374 10.5669 2.92264 11.4299 2.06419 12.1481C1.70135 12.4514 0.567313 13.5403 1.72222 13.4982C5.08337 13.3763 8.44455 13.2677 11.8065 13.1716C11.0554 16.6471 10.2566 20.1123 9.40946 23.5657C7.67085 23.5566 5.93223 23.5412 4.19361 23.52C3.06459 23.5062 1.6738 24.4507 0.846243 25.1431C0.447079 25.4772 -0.629757 26.4795 0.504269 26.4937C3.22493 26.527 5.94517 26.5415 8.66583 26.5453C7.86625 29.6971 7.02576 32.8389 6.14602 35.9703C5.77357 36.2803 5.52889 36.6003 5.52096 36.8936C5.50844 37.3713 5.4955 37.8494 5.48256 38.327C5.45542 39.3539 9.90217 37.1262 10.2103 36.0552C11.1201 32.8943 11.9853 29.7212 12.8132 26.5395C18.1556 26.5174 23.4971 26.4379 28.8378 26.3015C28.3439 30.4876 27.7747 34.6655 27.1201 38.8321C27.0115 39.5224 31.6294 37.9492 31.8478 36.5603C32.3906 33.1056 32.8712 29.6426 33.3037 26.1741C36.138 26.0847 38.9714 25.9836 41.8048 25.8617C42.966 25.8117 44.2891 24.9604 45.1517 24.2385C45.51 23.9398 46.6515 22.8392 45.4941 22.8888ZM13.5723 23.5745C14.4512 20.0831 15.2813 16.5801 16.0616 13.0655C20.7577 12.9461 25.4541 12.8462 30.1514 12.7763C29.8808 16.3259 29.5497 19.8701 29.1639 23.4089C23.9673 23.5179 18.7702 23.5732 13.5723 23.5745Z"
                            fill="#FF6B31" />
                    </svg>
                    <svg class="banner-bg-img banner-bg-two" width="49" height="49" viewBox="0 0 49 49" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M47.7632 30.1583C47.7042 24.8793 47.4413 19.605 46.9475 14.3481C46.6675 11.3674 46.3156 8.39381 45.8914 5.4304C45.6066 3.44224 45.7556 0.47062 43.2843 0.0804171C40.9791 -0.283258 38.0701 0.683326 35.7916 1.05134C32.9321 1.51389 30.0774 2.0078 27.2284 2.5345C21.3619 3.61829 15.521 4.8323 9.7059 6.17124C8.75734 6.38973 5.06361 7.99348 5.42551 9.3657C6.68691 14.1504 7.90641 18.9462 9.07448 23.7554C9.82065 26.8274 10.7597 29.9881 11.4178 33.1632C6.58501 33.7372 0.978927 36.8757 0.111325 41.6281C-0.321047 43.9958 0.511795 46.6795 2.50937 48.0734C4.89552 49.7379 7.88879 48.8847 10.2711 47.6649C12.9096 46.3144 15.4296 44.3069 16.6919 41.5345C18.151 38.3299 17.6238 34.6194 16.9329 31.2884C15.3358 23.5895 13.3468 15.949 11.343 8.34413C15.0744 7.52996 18.8162 6.76451 22.5709 6.0661C25.1194 5.59197 27.6722 5.1434 30.2298 4.7204C32.6578 4.31911 35.6154 3.38147 38.082 3.52038C40.5619 3.65978 40.331 7.15134 40.5958 9.03387C40.9686 11.6862 41.2838 14.3467 41.5419 17.0125C41.9948 21.693 42.251 26.3875 42.3438 31.0873C42.1391 31.2826 41.9733 31.4708 41.8614 31.6415C39.6515 32.3568 37.5568 33.7367 35.9373 35.1441C33.244 37.4849 29.7317 42.8243 34.4078 45.0868C38.2458 46.9438 43.3524 44.0928 46.1171 41.4559C49.3413 38.3806 49.8179 33.9229 47.7632 30.1583ZM10.7849 45.0213C9.44542 46.2927 7.37594 44.8384 6.48072 43.5246C5.53979 42.1446 5.17265 40.3412 5.56931 38.7066C5.6774 38.261 5.81502 37.8789 6.03263 37.4748C6.09882 37.3513 6.43786 36.9485 6.595 36.7122C6.86309 36.662 7.3307 36.5217 7.46832 36.5062C8.1245 36.4339 8.76782 36.4797 9.41971 36.5675C10.2216 36.6751 11.1102 36.3124 11.8982 35.8628C12.023 36.7257 12.1192 37.5881 12.173 38.4486C12.2901 40.3292 12.2892 43.5936 10.7849 45.0213ZM43.5776 38.9623C43.3805 40.2231 42.6995 41.0015 42.2362 42.1017C42.201 42.1099 42.1648 42.1186 42.1219 42.1297C41.7153 41.9498 40.7486 42.1548 40.2581 42.0221C37.9001 41.3845 36.992 39.3443 37.9206 37.1159C38.1215 36.6331 38.8953 35.0048 39.3482 34.7168C40.2224 34.1617 41.7567 34.7294 42.6076 35.0882C42.759 35.1519 42.9767 35.1567 43.23 35.1229C43.6324 36.3432 43.7852 37.6373 43.5776 38.9623Z"
                            fill="#FF6B31" />
                    </svg>

                    <svg class="banner-bg-img banner-bg-three" width="35" height="46" viewBox="0 0 35 46" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M34.8361 14.765C34.2899 14.2799 31.9222 15.7395 31.5611 15.9962C32.282 15.4842 30.8985 15.7161 30.4631 15.6406C29.9721 15.5559 29.4924 15.3986 29.0348 15.2116C27.8212 14.7147 26.8413 13.8538 26.0105 12.8814C24.5284 11.1471 23.6172 9.04667 22.3514 7.17479C21.1547 5.40523 19.6721 3.98453 17.6681 3.09892C15.6154 2.19191 13.3207 1.83382 11.7256 0.172863C10.9143 -0.672082 6.52521 1.79734 6.83372 2.89849C9.45868 12.2684 10.9078 21.9066 11.0847 31.5918C5.6679 31.3016 -1.98361 35.6555 0.472747 41.6879C2.69881 47.1551 11.1051 47.231 14.6434 43.0034C16.4276 40.8719 15.9066 37.041 15.9835 34.452C16.0886 30.8966 16.0195 27.3386 15.7901 23.7885C15.4056 17.8274 14.5352 11.9136 13.2199 6.08621C13.3763 6.1575 13.5315 6.23173 13.6848 6.31057C16.6596 7.83357 17.9745 10.8456 19.6243 13.4941C21.0787 15.8289 23.0314 18.0714 25.9484 18.6082C28.6946 19.1135 31.4073 18.0555 33.5969 16.501C34.0392 16.1865 35.4823 15.3387 34.8361 14.765Z"
                            fill="#FF6B31" />
                    </svg>
                    <svg class="banner-bg-img banner-bg-four" width="38" height="37" viewBox="0 0 38 37" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M6.68802 36.9487L11.438 22.9017L0.0705098 15.3505H13.9145L18.9893 0.247914L24.0641 15.3505H37.9081L26.5406 22.9017L31.2094 36.9487L18.9893 27.9359L6.68802 36.9487ZM11.1538 30.8184L18.9893 24.891L26.8247 30.8184L23.6175 21.968L30.7628 17.3398H22.1965L18.9893 7.5556L15.7414 17.3398H7.1346L14.3611 21.968L11.1538 30.8184Z"
                            fill="#FF6B31" />
                    </svg>
                </div>
                <div class="container">
                    <div class="row align-center">
                        <div class="col-md-6 col-12">
                            <div class="banner-left-col">
                                <div class="section-title">
                                    <div class="subtitle">
                                        {{ __('Get 30% Off On This Product') }}
                                    </div>
                                    <h2>{{ !empty($homepage_header_title) ? $homepage_header_title : 'Home Accessories' }}  </h2>
                                    <p>{{ !empty($homepage_header_Sub_text) ? $homepage_header_Sub_text : 'There is only that moment and the incredible certainty that everything under the sun has been written by one hand only.' }}</p>
                                </div>
                                <div class="banner-btn-wrp">
                                    <a href="{{ route('store.categorie.product', $store->slug) }}" tabindex="0" class="btn">
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
                        <div class="col-md-6 col-12">
                            <div class="banner-right-col">
                                <div class="banner-image-wrp">
                                    <div class="banner-img img-ratio">
                                        <img src="{{ $imgpath . $homepage_header_bckground_Image }}" alt="banner-image">
                                    </div>
                                    <div class="banner-image-content flex align-center justify-center">
                                        {{ __('Buy This Products') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @endif
    @endforeach

    @if ($products['Start shopping']->count() > 0)
        <section class="product-sec tabs-wrapper pt">
            <div class="container">
                <div class="section-title section-title-row flex align-center justify-between">
                    <div class="section-title-left">
                        <h2>{{ __('Classy Products') }}</h2>
                    </div>
                    <div class="section-title-right flex">
                        <ul class="tabs product-tabs flex align-center">
                            @foreach ($categories as $key => $category)
                                <li class="tab-link {{ $key == 0 ? 'active' : '' }}" data-tab="pdp-tab-{!! preg_replace('/[^A-Za-z0-9\-]/', '_', $category) !!}">
                                    <a href="javascript:;" class="btn btn-transparent"> {{ __($category) }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="tabs-container">
                    @foreach ($products as $key => $items)
                        <div class="tab-content {{ $key == 'Start shopping' ? 'active' : '' }}" id="pdp-tab-{!! preg_replace('/[^A-Za-z0-9\-]/', '_', $key) !!}">
                            @if ($items->count() > 0)
                                <div class="row no-gutters">
                                    @foreach ($items as $product)
                                        <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-12">
                                            @include('storefront.theme5.common.product_section')
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
                    <div class="section-title section-title-row flex align-center justify-between">
                        <div class="section-title-left">
                            <h2>{{ !empty($Title) ? $Title : 'Categories' }}</h2>
                        </div>
                        <div class="section-title-right flex">
                            <div class="section-title-content">
                                <p>{{ !empty($Description) ? $Description : 'There is only that moment and the incredible certainty that everything under the sun has been written by one hand only.' }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="category-slider">
                        @foreach ($pro_categories as $key => $pro_categorie)
                            <div class="category-card">
                                <div class="category-card-inner img-ratio">
                                    @if (!empty($pro_categorie->categorie_img))
                                        <img src="{{  $productImg . $pro_categorie->categorie_img }}" class="category-card-img" alt="category-image" loading="lazy">
                                    @else
                                        <img src="{{ asset(Storage::url('uploads/product_image/default.jpg')) }}" class="category-card-img" alt="category-image" loading="lazy">
                                    @endif
                                    <div class="category-card-content">
                                        <div class="category-top-content">
                                            <h3>
                                                <a href="{{ route('store.categorie.product', [$store->slug, $pro_categorie->name]) }}" tabindex="0">{{ $pro_categorie->name }}</a>
                                            </h3>
                                            <p>{{ __('Products') }}: {{ !empty($product_count[$key]) ? $product_count[$key] : '0' }}</p>
                                        </div>
                                        <div class="category-bottom-content">
                                            <a href="{{ route('store.categorie.product', [$store->slug, $pro_categorie->name]) }}" tabindex="0" class="btn">{{ __('Start shopping') }}</a>
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

    {{-- Promotion --}}
    @include('storefront.promotion')

    @foreach ($getStoreThemeSetting as $storethemesetting)
        @if (isset($storethemesetting['section_name']) &&
                $storethemesetting['section_name'] == 'Home-Email-Subscriber' &&
                $storethemesetting['section_enable'] == 'on')
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
            <section class="newsletter-sec pt pb">
                <div class="container">
                    <div class="newsletter-content-row text-center">
                        <img src="{{ $imgpath  . $emailsubs_img }}" alt="newsletter-bg-img" class="newsletter-bg-img">
                        <svg class="newsletter-bg-icon newsletter-icon-one" width="67" height="87" viewBox="0 0 67 87"
                            fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M66.6863 27.9252C65.6407 27.0076 61.1082 29.7683 60.417 30.2536C61.797 29.2853 59.1485 29.7239 58.315 29.5811C57.3751 29.4209 56.4568 29.1235 55.5809 28.7698C53.2577 27.83 51.382 26.2018 49.7916 24.3627C46.9543 21.0825 45.21 17.11 42.787 13.5697C40.4962 10.2229 37.6581 7.53597 33.8218 5.86099C29.8924 4.14557 25.4997 3.46831 22.4461 0.326936C20.8932 -1.27111 12.4911 3.39931 13.0817 5.48193C18.1066 23.2032 20.8807 41.4321 21.2192 59.7497C10.85 59.2009 -3.7972 67.4354 0.904974 78.8446C5.16629 89.1847 21.2583 89.3283 28.0317 81.3325C31.447 77.3013 30.4497 70.0557 30.5969 65.1593C30.7982 58.4348 30.666 51.7056 30.2268 44.9914C29.4906 33.717 27.8245 22.5323 25.3067 11.5109C25.6061 11.6457 25.9031 11.7861 26.1967 11.9352C31.8912 14.8157 34.4082 20.5123 37.5666 25.5214C40.3506 29.9372 44.0888 34.1786 49.6726 35.1937C54.9296 36.1494 60.1225 34.1484 64.314 31.2085C65.1608 30.6137 67.9232 29.0101 66.6863 27.9252Z"
                                fill="#FF6B31" />
                        </svg>
                        <svg class="newsletter-bg-icon newsletter-icon-two" width="49" height="49" viewBox="0 0 49 49"
                            fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M47.7632 30.1583C47.7041 24.8793 47.4413 19.605 46.9475 14.3481C46.6675 11.3674 46.3156 8.39381 45.8913 5.4304C45.6065 3.44224 45.7556 0.47062 43.2842 0.0804171C40.979 -0.283258 38.07 0.683326 35.7915 1.05134C32.932 1.51389 30.0773 2.0078 27.2283 2.5345C21.3618 3.61829 15.521 4.8323 9.70584 6.17124C8.75728 6.38973 5.06355 7.99348 5.42545 9.3657C6.68685 14.1504 7.90635 18.9462 9.07442 23.7554C9.82059 26.8274 10.7596 29.9881 11.4177 33.1632C6.58495 33.7372 0.978866 36.8757 0.111264 41.6281C-0.321108 43.9958 0.511734 46.6795 2.50931 48.0734C4.89546 49.7379 7.88873 48.8847 10.2711 47.6649C12.9096 46.3144 15.4295 44.3069 16.6919 41.5345C18.1509 38.3299 17.6238 34.6194 16.9328 31.2884C15.3357 23.5895 13.3467 15.949 11.3429 8.34413C15.0743 7.52996 18.8161 6.76451 22.5708 6.0661C25.1193 5.59197 27.6721 5.1434 30.2297 4.7204C32.6578 4.31911 35.6153 3.38147 38.0819 3.52038C40.5619 3.65978 40.3309 7.15134 40.5957 9.03387C40.9685 11.6862 41.2838 14.3467 41.5419 17.0125C41.9947 21.693 42.2509 26.3875 42.3438 31.0873C42.139 31.2826 41.9733 31.4708 41.8614 31.6415C39.6514 32.3568 37.5567 33.7367 35.9372 35.1441C33.2439 37.4849 29.7316 42.8243 34.4077 45.0868C38.2457 46.9438 43.3523 44.0928 46.117 41.4559C49.3412 38.3806 49.8179 33.9229 47.7632 30.1583ZM10.7849 45.0213C9.44536 46.2927 7.37588 44.8384 6.48066 43.5246C5.53973 42.1446 5.17259 40.3412 5.56925 38.7066C5.67734 38.261 5.81496 37.8789 6.03257 37.4748C6.09876 37.3513 6.4378 36.9485 6.59494 36.7122C6.86303 36.662 7.33064 36.5217 7.46826 36.5062C8.12444 36.4339 8.76776 36.4797 9.41965 36.5675C10.2215 36.6751 11.1101 36.3124 11.8982 35.8628C12.0229 36.7257 12.1191 37.5881 12.1729 38.4486C12.2901 40.3292 12.2891 43.5936 10.7849 45.0213ZM43.5775 38.9623C43.3804 40.2231 42.6995 41.0015 42.2361 42.1017C42.2009 42.1099 42.1647 42.1186 42.1219 42.1297C41.7152 41.9498 40.7485 42.1548 40.2581 42.0221C37.9 41.3845 36.992 39.3443 37.9205 37.1159C38.1215 36.6331 38.8953 35.0048 39.3481 34.7168C40.2224 34.1617 41.7566 34.7294 42.6076 35.0882C42.759 35.1519 42.9766 35.1567 43.2299 35.1229C43.6323 36.3432 43.7852 37.6373 43.5775 38.9623Z"
                                fill="#FF6B31" />
                        </svg>

                        <div class="newsletter-content-wrp">
                            <div class="section-title">
                                <h2>{{ !empty($SubscriberTitle) ? $SubscriberTitle : 'Always on time' }}</h2>
                                <p>{{ !empty($SubscriberDescription) ? $SubscriberDescription : 'There is only that moment and the incredible certainty that everything under the sun has been written by one hand only.' }}</p>
                            </div>
                            {{ Form::open(['route' => ['subscriptions.store_email', $store->id], 'method' => 'POST', 'class' => 'newsletter-form']) }}
                                <div class="newsletter-form-wrp flex">
                                    {{ Form::email('email', null, ['class' => 'form-control form-control-flush', 'aria-label' => 'Enter your email address', 'placeholder' => __('Enter Your Email Address'), 'required' => 'required']) }}
                                    <button type="submit" class="btn"><span>{{ $SubscribeButton }}</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40"
                                            fill="none">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M28.6143 11.3858L15.4142 20.5505L1.60749 15.9477C0.643763 15.6258 -0.00550973 14.7216 3.52419e-05 13.7057C0.00565318 12.6899 0.662368 11.7913 1.62982 11.4806L36.9289 0.113033C37.7679 -0.156701 38.6889 0.0646601 39.3122 0.687959C39.9354 1.31126 40.1568 2.23216 39.887 3.07128L28.5195 38.3702C28.2088 39.3377 27.3101 39.9944 26.2943 40C25.2785 40.0056 24.3743 39.3563 24.0524 38.3926L19.4272 24.519L28.6143 11.3858Z"
                                                fill="white"></path>
                                        </svg>
                                    </button>
                                </div>
                            {{ Form::close() }}
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
            <section class="testimonial-sec pb">
                <div class="container">
                    <div class="section-title section-title-row flex align-center justify-between">
                        @php
                            $Heading_key = array_search('Heading', array_column($storethemesetting['inner-list'], 'field_name'));
                            $Heading = $storethemesetting['inner-list'][$Heading_key]['field_default_text'];
                            
                            $HeadingSubText_key = array_search('Heading Sub Text', array_column($storethemesetting['inner-list'], 'field_name'));
                            $HeadingSubText = $storethemesetting['inner-list'][$HeadingSubText_key]['field_default_text'];
                        @endphp
                        <div class="section-title-left">
                            <h2>{{ !empty($Heading) ? $Heading : 'Testimonials' }}</h2>
                        </div>
                        <div class="section-title-right flex">
                            <div class="section-title-content">
                                <p>{{ !empty($HeadingSubText) ? $HeadingSubText : 'There is only that moment and the incredible certainty that everything under the sun has been written by one hand only.' }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="testimonial-slider">
                        @foreach ($testimonials as $key => $testimonial)
                            <div class="testimonial-card">
                                <div class="testimonial-card-content">
                                    <div class="testimonial-content-top">
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
                                    </div>
                                    <div class="testimonial-content-bottom">
                                        <div class="testimonial-client-info flex align-center">
                                            <div class="testimonial-img">
                                                <img src="{{ $testimonialImg . (!empty($testimonial->image) ? $testimonial->image : 'avatar.png') }}" alt="testimonial-image">
                                            </div>
                                            <div class="testimonial-client-content">
                                                <h3>{{ $testimonial->title ?? '' }}</h3>
                                                <span>{{ $testimonial->sub_title ?? '' }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="arrow-wrapper flex align-center">
                        <div class="slick-prev testimonial-left slick-arrow">
                            <svg width="69" height="24" viewBox="0 0 69 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M0.939339 10.9393C0.353554 11.5251 0.353554 12.4749 0.939339 13.0607L10.4853 22.6066C11.0711 23.1924 12.0208 23.1924 12.6066 22.6066C13.1924 22.0208 13.1924 21.0711 12.6066 20.4853L4.12132 12L12.6066 3.51471C13.1924 2.92893 13.1924 1.97918 12.6066 1.39339C12.0208 0.807606 11.0711 0.807606 10.4853 1.39339L0.939339 10.9393ZM69 10.5L2 10.5L2 13.5L69 13.5L69 10.5Z"
                                    fill="#222222" />
                            </svg>
                        </div>
                        <div class="slick-next testimonial-right slick-arrow">
                            <svg width="69" height="24" viewBox="0 0 69 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M68.0607 13.0607C68.6464 12.4749 68.6464 11.5251 68.0607 10.9393L58.5147 1.3934C57.9289 0.807611 56.9792 0.807611 56.3934 1.3934C55.8076 1.97919 55.8076 2.92893 56.3934 3.51472L64.8787 12L56.3934 20.4853C55.8076 21.0711 55.8076 22.0208 56.3934 22.6066C56.9792 23.1924 57.9289 23.1924 58.5147 22.6066L68.0607 13.0607ZM0 13.5H67V10.5H0V13.5Z"
                                    fill="#222222" />
                            </svg>
                        </div>
                    </div>
                </div>
            </section>
        @endif
    @endforeach
    
    {{-- Logo slider --}}
    @include('storefront.logo_slider')

</main>
@endsection
