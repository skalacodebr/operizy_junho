@extends('storefront.layout.theme9')
@section('page-title')
    {{ __('Wish list') }}
@endsection

@php
    $imgpath = \App\Models\Utility::get_file('uploads/is_cover_image/');
    $imgpath2 = \App\Models\Utility::get_file('uploads/product_image/');
@endphp

@section('content')
<main>
    
    @include('storefront.theme9.common.common_banner_section')

    <section class="pro-wishlist-sec pt pb">
        <div class="container">
            @if(count($products) > 0)
                <div class="row no-gutters">
                    @foreach($products as $k => $product)
                        <div class="col-xl-3 col-md-4 col-sm-6 col-12">
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
                                        <div class="pro-btn-wrapper">
                                            <div class="pro-btn">
                                                <a href="javascript:void(0)" id="delete_wishlist_item1" class="wishlist-btn wishlist-active btn heart-btn delete_wishlist_item" data-id="{{$product['product_id']}}">
                                                    <svg width="28" height="23" viewBox="0 0 28 23" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M0.599095 7.38008L0.599095 7.38008C0.539537 4.05401 2.33093 1.69577 4.77155 0.848363C7.21517 -8.66357e-05 10.4236 0.630794 13.2378 3.54845L13.5977 3.92156L13.9575 3.54845C16.7713 0.631207 19.9795 1.89873e-05 22.4231 0.848089C24.8636 1.69511 26.6552 4.05284 26.5962 7.37893C26.5427 10.402 24.4323 13.5144 21.6585 16.2578C19.0068 18.8804 15.8394 21.077 13.5977 22.4186C11.3561 21.0771 8.18894 18.8807 5.53733 16.2583C2.76364 13.5152 0.653182 10.4029 0.599095 7.38008Z"
                                                            fill="white" stroke="black"></path>
                                                    </svg>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="product-content">
                                        <div class="product-content-top">
                                            <div class="product-cart-btn">
                                                @if ($product['enable_product_variant'] == 'on')
                                                    <a href="{{ route('store.product.product_view', [$store->slug, $product['product_id']]) }}" class="cart-btn btn">
                                                        <span>
                                                            <svg width="15" height="15" viewBox="0 0 15 15"
                                                                fill="none" xmlns="http://www.w3.org/2000/svg">
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
                                                    <a class="cart-btn btn add_to_cart" data-id="{{ $product['product_id'] }}">
                                                        <span>
                                                            <svg width="15" height="15" viewBox="0 0 15 15"
                                                                fill="none" xmlns="http://www.w3.org/2000/svg">
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
                                                <a href="{{ route('store.product.product_view', [$store->slug, $product['product_id']]) }}" tabindex="0">{{ $product['product_name'] }}</a>
                                            </h3>
                                            <div class="product-rating flex align-center justify-center">
                                                @if ($store->enable_rating == 'on')
                                                    @php
                                                        $rating = \App\Models\Product::getRatingById($product['product_id']);
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
                                                <span>{{ '(' . $rating .')' }}</span>
                                            </div>
                                        </div>
                                        <div class="product-content-bottom">
                                            <div class="price">
                                                @if ($product['enable_product_variant'] == 'on')
                                                    <ins>{{ __('In variant') }}</ins>
                                                @else
                                                    <ins>{{ \App\Models\Utility::priceFormat($product['price']) }}</ins>
                                                @endif
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

