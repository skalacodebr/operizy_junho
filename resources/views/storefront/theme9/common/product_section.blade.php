<div class="product-card">
    <div class="product-card-inner">
        <div class="product-card-image">
            <a href="{{ route('store.product.product_view', [$store->slug, $product->id]) }}" class="default-img img-wrapper">
                @if (!empty($product->is_cover))
                    <img alt="product-card-image" src="{{ $coverImg . $product->is_cover }}" >
                @else
                    <img alt="product-card-image" src="{{ asset(Storage::url('uploads/is_cover_image/default.jpg')) }}" >
                @endif
            </a>
            <a href="{{ route('store.product.product_view', [$store->slug, $product->id]) }}" class="hover-img img-wrapper">
                @if (isset($product->product_img) && !empty($product->product_img))
                    <img alt="product-card-image" src="{{ $productImg . $product->product_img->product_images }}" >
                @elseif (!empty($product->is_cover))
                    <img alt="product-card-image" src="{{ $coverImg . $product->is_cover }}" >
                @else
                    <img alt="product-card-image" src="{{ asset(Storage::url('uploads/is_cover_image/default.jpg')) }}" >
                @endif
            </a>
            <div class="pro-btn-wrapper">
                @if (Auth::guard('customers')->check())
                    @if (!empty($wishlist) && isset($wishlist[$product->id]['product_id']))
                        @if ($wishlist[$product->id]['product_id'] != $product->id)
                            <div class="pro-btn">
                                <a href="javascript:void(0)" data-id="{{ $product->id }}" class="wishlist-btn btn heart-icon action-item wishlist-icon bg-light-gray add_to_wishlist wishlist_{{ $product->id }}">
                                    <svg width="28" height="23" viewBox="0 0 28 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M0.599095 7.38008L0.599095 7.38008C0.539537 4.05401 2.33093 1.69577 4.77155 0.848363C7.21517 -8.66357e-05 10.4236 0.630794 13.2378 3.54845L13.5977 3.92156L13.9575 3.54845C16.7713 0.631207 19.9795 1.89873e-05 22.4231 0.848089C24.8636 1.69511 26.6552 4.05284 26.5962 7.37893C26.5427 10.402 24.4323 13.5144 21.6585 16.2578C19.0068 18.8804 15.8394 21.077 13.5977 22.4186C11.3561 21.0771 8.18894 18.8807 5.53733 16.2583C2.76364 13.5152 0.653182 10.4029 0.599095 7.38008Z" fill="white" stroke="black"></path>
                                    </svg>
                                </a>
                            </div>
                        @else
                            <div class="pro-btn">
                                <a href="javascript:void(0)" data-id="{{ $product->id }}" class="wishlist-btn btn wishlist-active heart-icon action-item wishlist-icon bg-light-gray" disabled>
                                    <svg width="28" height="23" viewBox="0 0 28 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M0.599095 7.38008L0.599095 7.38008C0.539537 4.05401 2.33093 1.69577 4.77155 0.848363C7.21517 -8.66357e-05 10.4236 0.630794 13.2378 3.54845L13.5977 3.92156L13.9575 3.54845C16.7713 0.631207 19.9795 1.89873e-05 22.4231 0.848089C24.8636 1.69511 26.6552 4.05284 26.5962 7.37893C26.5427 10.402 24.4323 13.5144 21.6585 16.2578C19.0068 18.8804 15.8394 21.077 13.5977 22.4186C11.3561 21.0771 8.18894 18.8807 5.53733 16.2583C2.76364 13.5152 0.653182 10.4029 0.599095 7.38008Z" fill="white" stroke="black"></path>
                                    </svg>
                                </a>
                            </div>
                        @endif
                    @else
                        <div class="pro-btn">
                            <a href="javascript:void(0)" data-id="{{ $product->id }}" class="wishlist-btn btn heart-icon action-item wishlist-icon bg-light-gray add_to_wishlist wishlist_{{ $product->id }}">
                                <svg width="28" height="23" viewBox="0 0 28 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M0.599095 7.38008L0.599095 7.38008C0.539537 4.05401 2.33093 1.69577 4.77155 0.848363C7.21517 -8.66357e-05 10.4236 0.630794 13.2378 3.54845L13.5977 3.92156L13.9575 3.54845C16.7713 0.631207 19.9795 1.89873e-05 22.4231 0.848089C24.8636 1.69511 26.6552 4.05284 26.5962 7.37893C26.5427 10.402 24.4323 13.5144 21.6585 16.2578C19.0068 18.8804 15.8394 21.077 13.5977 22.4186C11.3561 21.0771 8.18894 18.8807 5.53733 16.2583C2.76364 13.5152 0.653182 10.4029 0.599095 7.38008Z" fill="white" stroke="black"></path>
                                </svg>
                            </a>
                        </div>
                    @endif
                @else
                    <div class="pro-btn">
                        <a href="javascript:void(0)" data-id="{{ $product->id }}" class="wishlist-btn btn heart-icon action-item wishlist-icon bg-light-gray add_to_wishlist wishlist_{{ $product->id }}">
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
                <div class="product-cart-btn">
                    @if ($product->enable_product_variant == 'on')
                        <a href="{{ route('store.product.product_view', [$store->slug, $product->id]) }}" class="compare-btn cart-btn btn">
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
                        <a href="javascript:void(0)" data-id="{{ $product->id }}" class="compare-btn btn cart-btn add_to_cart">
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
                    <a href="{{ route('store.product.product_view', [$store->slug, $product->id]) }}">{{ $product->name }}</a>
                </h3>
                <div class="product-rating flex align-center justify-center">
                    @if ($store->enable_rating == 'on')
                        @php
                            $rating = $product->product_rating();
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
                        @if ($product->enable_product_variant == 'on')
                            {{ __('In variant') }}
                        @else
                            {{ \App\Models\Utility::priceFormat($product->price) }}
                        @endif
                    </ins>
                </div>
            </div>
        </div>
    </div>
</div>
