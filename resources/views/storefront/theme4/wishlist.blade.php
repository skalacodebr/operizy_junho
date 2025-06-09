@extends('storefront.layout.theme4')
@section('page-title')
    {{ __('Wish list') }}
@endsection

@php
    $imgpath = \App\Models\Utility::get_file('uploads/is_cover_image/');
    $imgpath2 = \App\Models\Utility::get_file('uploads/product_image/');
@endphp

@section('content')
<main>
    
    @include('storefront.theme4.common.common_banner_section')
    
    <section class="pro-wishlist-sec pb">
        <div class="container">
            @if(count($products) > 0)
                <div class="row">
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
                                    <div class="product-content">
                                        <div class="product-content-top">
                                            <div class="pro-label">{{ \App\Models\Product::getCategoryById($product['product_id']) }}</div>
                                            <h3>
                                                <a href="{{ route('store.product.product_view', [$store->slug, $product['product_id']]) }}" tabindex="0">{{ $product['product_name'] }}</a>
                                            </h3>
                                            <div class="product-rating flex align-center">
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
                                            <div class="product-cart-btn flex align-center justify-end">
                                                @if ($product['enable_product_variant'] == 'on')
                                                    <a href="{{ route('store.product.product_view', [$store->slug, $product['product_id']]) }}" class="cart-btn btn">
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
                                                    <a class="cart-btn btn add_to_cart" data-id="{{ $product['product_id'] }}">
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
                <div class="row justify-center">
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
