@extends('storefront.layout.theme8')
@section('page-title')
    {{ __('Wish list') }}
@endsection

@php
    $imgpath = \App\Models\Utility::get_file('uploads/is_cover_image/');
    $imgpath2 = \App\Models\Utility::get_file('uploads/product_image/');
@endphp

@section('content')
<main>
    
    @include('storefront.theme8.common.common_banner_section')

    <section class="pro-wishlist-sec pt pb">
        <div class="container">
            @if(count($products) > 0)
                <div class="row no-gutters">
                    @foreach($products as $k => $product)
                        <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-12">
                            <div class="product-card">
                                <div class="product-card-inner">
                                    <div class="product-card-image">
                                        <a href="{{ route('store.product.product_view', [$store->slug, $product['product_id']]) }}" class="default-img img-wrapper">
                                            @if(!empty($product['image']))
                                                <img src="{{ $imgpath.$product['image'] }}" alt="product-card-image" loading="lazy">
                                            @else
                                                <img src="{{asset(Storage::url('uploads/is_cover_image/default.jpg'))}}" alt="product-card-image" loading="lazy">
                                            @endif
                                        </a>
                                        <a href="{{ route('store.product.product_view', [$store->slug, $product['product_id']]) }}" class="hover-img img-wrapper">
                                            @if(!empty($product['product_image']))
                                                <img src="{{ $imgpath2.$product['product_image'] }}" alt="product-card-image" loading="lazy">
                                            @elseif(!empty($product['image']))
                                                <img src="{{ $imgpath.$product['image'] }}" alt="product-card-image" loading="lazy">
                                            @else
                                                <img src="{{ asset(Storage::url('uploads/is_cover_image/default.jpg')) }}" alt="product-card-image" loading="lazy">
                                            @endif
                                        </a>
                                    </div>
                                    <div class="product-content">
                                        <div class="product-content-top">
                                            <div class="product-lbl">
                                                {{ \App\Models\Product::getCategoryById($product['product_id']) }}
                                            </div>
                                            <h3>
                                                <a href="{{ route('store.product.product_view', [$store->slug, $product['product_id']]) }}" tabindex="0">{{ $product['product_name'] }}</a>
                                            </h3>
                                            <div class="price">
                                                @if ($product['enable_product_variant'] == 'on')
                                                    <ins>{{ __('In variant') }}</ins>
                                                @else
                                                    <ins>{{ \App\Models\Utility::priceFormat($product['price']) }}</ins>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="product-content-bottom">
                                            <div class="pro-btn-wrapper flex align-center">
                                                <div class="pro-btn">
                                                    @if ($product['enable_product_variant'] == 'on')
                                                        <a href="{{ route('store.product.product_view', [$store->slug, $product['product_id']]) }}" class="cart-btn btn">
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
                                                        <a class="cart-btn btn add_to_cart" data-id="{{ $product['product_id'] }}">
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
                                                    <a href="javascript:void(0)" id="delete_wishlist_item1" class="wishlist-btn wishlist-active btn heart-btn delete_wishlist_item" data-id="{{$product['product_id']}}">
                                                        <svg width="28" height="23" viewBox="0 0 28 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M0.599095 7.38008L0.599095 7.38008C0.539537 4.05401 2.33093 1.69577 4.77155 0.848363C7.21517 -8.66357e-05 10.4236 0.630794 13.2378 3.54845L13.5977 3.92156L13.9575 3.54845C16.7713 0.631207 19.9795 1.89873e-05 22.4231 0.848089C24.8636 1.69511 26.6552 4.05284 26.5962 7.37893C26.5427 10.402 24.4323 13.5144 21.6585 16.2578C19.0068 18.8804 15.8394 21.077 13.5977 22.4186C11.3561 21.0771 8.18894 18.8807 5.53733 16.2583C2.76364 13.5152 0.653182 10.4029 0.599095 7.38008Z" fill="white" stroke="black"></path>
                                                        </svg>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="row no-gutters justify-center">
                    <div class="text-center">
                        <i class="fas fa-folder-open text-gray" style="font-size: 48px;"></i>
                        <h2>{{ __('Opps...') }}</h2>
                        <h6> {!! __('No data Found.') !!} </h6>
                    </div>
                </div>
            @endif
        </div>
    </section>
</main>
@endsection

