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
            <div class="pro-btn-wrapper ">
                @if (Auth::guard('customers')->check())
                    @if (!empty($wishlist) && isset($wishlist[$product->id]['product_id']))
                        @if ($wishlist[$product->id]['product_id'] != $product->id)
                            <div class="pro-btn">
                                <a href="javascript:void(0)" data-id="{{ $product->id }}" class="wishlist-btn heart-icon action-item wishlist-icon bg-light-gray add_to_wishlist wishlist_{{ $product->id }}">
                                    <svg width="28" height="23" viewBox="0 0 28 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M0.599095 7.38008L0.599095 7.38008C0.539537 4.05401 2.33093 1.69577 4.77155 0.848363C7.21517 -8.66357e-05 10.4236 0.630794 13.2378 3.54845L13.5977 3.92156L13.9575 3.54845C16.7713 0.631207 19.9795 1.89873e-05 22.4231 0.848089C24.8636 1.69511 26.6552 4.05284 26.5962 7.37893C26.5427 10.402 24.4323 13.5144 21.6585 16.2578C19.0068 18.8804 15.8394 21.077 13.5977 22.4186C11.3561 21.0771 8.18894 18.8807 5.53733 16.2583C2.76364 13.5152 0.653182 10.4029 0.599095 7.38008Z" fill="white" stroke="black"></path>
                                    </svg>
                                </a>
                            </div>
                        @else
                            <div class="pro-btn">
                                <a href="javascript:void(0)" data-id="{{ $product->id }}" class="wishlist-btn wishlist-active heart-icon action-item wishlist-icon bg-light-gray" disabled>
                                    <svg width="28" height="23" viewBox="0 0 28 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M0.599095 7.38008L0.599095 7.38008C0.539537 4.05401 2.33093 1.69577 4.77155 0.848363C7.21517 -8.66357e-05 10.4236 0.630794 13.2378 3.54845L13.5977 3.92156L13.9575 3.54845C16.7713 0.631207 19.9795 1.89873e-05 22.4231 0.848089C24.8636 1.69511 26.6552 4.05284 26.5962 7.37893C26.5427 10.402 24.4323 13.5144 21.6585 16.2578C19.0068 18.8804 15.8394 21.077 13.5977 22.4186C11.3561 21.0771 8.18894 18.8807 5.53733 16.2583C2.76364 13.5152 0.653182 10.4029 0.599095 7.38008Z" fill="white" stroke="black"></path>
                                    </svg>
                                </a>
                            </div>
                        @endif
                    @else
                        <div class="pro-btn">
                            <a href="javascript:void(0)" data-id="{{ $product->id }}" class="wishlist-btn heart-icon action-item wishlist-icon bg-light-gray add_to_wishlist wishlist_{{ $product->id }}">
                                <svg width="28" height="23" viewBox="0 0 28 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M0.599095 7.38008L0.599095 7.38008C0.539537 4.05401 2.33093 1.69577 4.77155 0.848363C7.21517 -8.66357e-05 10.4236 0.630794 13.2378 3.54845L13.5977 3.92156L13.9575 3.54845C16.7713 0.631207 19.9795 1.89873e-05 22.4231 0.848089C24.8636 1.69511 26.6552 4.05284 26.5962 7.37893C26.5427 10.402 24.4323 13.5144 21.6585 16.2578C19.0068 18.8804 15.8394 21.077 13.5977 22.4186C11.3561 21.0771 8.18894 18.8807 5.53733 16.2583C2.76364 13.5152 0.653182 10.4029 0.599095 7.38008Z" fill="white" stroke="black"></path>
                                </svg>
                            </a>
                        </div>
                    @endif
                @else
                    <div class="pro-btn">
                        <a href="javascript:void(0)" data-id="{{ $product->id }}" class="wishlist-btn heart-icon action-item wishlist-icon bg-light-gray add_to_wishlist wishlist_{{ $product->id }}">
                            <svg width="28" height="23" viewBox="0 0 28 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M0.599095 7.38008L0.599095 7.38008C0.539537 4.05401 2.33093 1.69577 4.77155 0.848363C7.21517 -8.66357e-05 10.4236 0.630794 13.2378 3.54845L13.5977 3.92156L13.9575 3.54845C16.7713 0.631207 19.9795 1.89873e-05 22.4231 0.848089C24.8636 1.69511 26.6552 4.05284 26.5962 7.37893C26.5427 10.402 24.4323 13.5144 21.6585 16.2578C19.0068 18.8804 15.8394 21.077 13.5977 22.4186C11.3561 21.0771 8.18894 18.8807 5.53733 16.2583C2.76364 13.5152 0.653182 10.4029 0.599095 7.38008Z" fill="white" stroke="black"></path>
                            </svg>
                        </a>
                    </div>
                @endif
                @if ($product->enable_product_variant == 'on')
                    <div class="pro-btn">
                        <a href="{{ route('store.product.product_view', [$store->slug, $product->id]) }}" class="compare-btn cart-btn">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M5.19086 6.37945C5.00086 6.37945 4.80086 6.29945 4.66086 6.15945C4.37086 5.86945 4.37086 5.38945 4.66086 5.09945L8.29086 1.46945C8.58086 1.17945 9.06086 1.17945 9.35086 1.46945C9.64086 1.75945 9.64086 2.23945 9.35086 2.52945L5.72086 6.15945C5.57086 6.29945 5.38086 6.37945 5.19086 6.37945Z" fill="#202126"/>
                                <path d="M18.8101 6.37945C18.6201 6.37945 18.4301 6.30945 18.2801 6.15945L14.6501 2.52945C14.3601 2.23945 14.3601 1.75945 14.6501 1.46945C14.9401 1.17945 15.4201 1.17945 15.7101 1.46945L19.3401 5.09945C19.6301 5.38945 19.6301 5.86945 19.3401 6.15945C19.2001 6.29945 19.0001 6.37945 18.8101 6.37945Z" fill="#202126"/>
                                <path d="M20.21 10.5996C20.14 10.5996 20.07 10.5996 20 10.5996H19.77H4C3.3 10.6096 2.5 10.6096 1.92 10.0296C1.46 9.57961 1.25 8.87961 1.25 7.84961C1.25 5.09961 3.26 5.09961 4.22 5.09961H19.78C20.74 5.09961 22.75 5.09961 22.75 7.84961C22.75 8.88961 22.54 9.57961 22.08 10.0296C21.56 10.5496 20.86 10.5996 20.21 10.5996ZM4.22 9.09961H20.01C20.46 9.10961 20.88 9.10961 21.02 8.96961C21.09 8.89961 21.24 8.65961 21.24 7.84961C21.24 6.71961 20.96 6.59961 19.77 6.59961H4.22C3.03 6.59961 2.75 6.71961 2.75 7.84961C2.75 8.65961 2.91 8.89961 2.97 8.96961C3.11 9.09961 3.54 9.09961 3.98 9.09961H4.22Z" fill="#202126"/>
                                <path d="M9.76074 18.3C9.35074 18.3 9.01074 17.96 9.01074 17.55V14C9.01074 13.59 9.35074 13.25 9.76074 13.25C10.1707 13.25 10.5107 13.59 10.5107 14V17.55C10.5107 17.97 10.1707 18.3 9.76074 18.3Z" fill="#202126"/>
                                <path d="M14.3604 18.3C13.9504 18.3 13.6104 17.96 13.6104 17.55V14C13.6104 13.59 13.9504 13.25 14.3604 13.25C14.7704 13.25 15.1104 13.59 15.1104 14V17.55C15.1104 17.97 14.7704 18.3 14.3604 18.3Z" fill="#202126"/>
                                <path d="M14.8907 22.7488H8.86073C5.28073 22.7488 4.48073 20.6188 4.17073 18.7688L2.76073 10.1188C2.69073 9.70878 2.97073 9.32878 3.38073 9.25878C3.79073 9.18878 4.17073 9.46878 4.24073 9.87878L5.65073 18.5188C5.94073 20.2888 6.54073 21.2488 8.86073 21.2488H14.8907C17.4607 21.2488 17.7507 20.3488 18.0807 18.6088L19.7607 9.85878C19.8407 9.44878 20.2307 9.17878 20.6407 9.26878C21.0507 9.34878 21.3107 9.73878 21.2307 10.1488L19.5507 18.8988C19.1607 20.9288 18.5107 22.7488 14.8907 22.7488Z" fill="#202126"/>
                            </svg>
                        </a>
                    </div>
                @else
                    <div class="pro-btn">
                        <a href="javascript:void(0)" data-id="{{ $product->id }}" class="compare-btn cart-btn add_to_cart">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M5.19086 6.37945C5.00086 6.37945 4.80086 6.29945 4.66086 6.15945C4.37086 5.86945 4.37086 5.38945 4.66086 5.09945L8.29086 1.46945C8.58086 1.17945 9.06086 1.17945 9.35086 1.46945C9.64086 1.75945 9.64086 2.23945 9.35086 2.52945L5.72086 6.15945C5.57086 6.29945 5.38086 6.37945 5.19086 6.37945Z" fill="#202126"/>
                                <path d="M18.8101 6.37945C18.6201 6.37945 18.4301 6.30945 18.2801 6.15945L14.6501 2.52945C14.3601 2.23945 14.3601 1.75945 14.6501 1.46945C14.9401 1.17945 15.4201 1.17945 15.7101 1.46945L19.3401 5.09945C19.6301 5.38945 19.6301 5.86945 19.3401 6.15945C19.2001 6.29945 19.0001 6.37945 18.8101 6.37945Z" fill="#202126"/>
                                <path d="M20.21 10.5996C20.14 10.5996 20.07 10.5996 20 10.5996H19.77H4C3.3 10.6096 2.5 10.6096 1.92 10.0296C1.46 9.57961 1.25 8.87961 1.25 7.84961C1.25 5.09961 3.26 5.09961 4.22 5.09961H19.78C20.74 5.09961 22.75 5.09961 22.75 7.84961C22.75 8.88961 22.54 9.57961 22.08 10.0296C21.56 10.5496 20.86 10.5996 20.21 10.5996ZM4.22 9.09961H20.01C20.46 9.10961 20.88 9.10961 21.02 8.96961C21.09 8.89961 21.24 8.65961 21.24 7.84961C21.24 6.71961 20.96 6.59961 19.77 6.59961H4.22C3.03 6.59961 2.75 6.71961 2.75 7.84961C2.75 8.65961 2.91 8.89961 2.97 8.96961C3.11 9.09961 3.54 9.09961 3.98 9.09961H4.22Z" fill="#202126"/>
                                <path d="M9.76074 18.3C9.35074 18.3 9.01074 17.96 9.01074 17.55V14C9.01074 13.59 9.35074 13.25 9.76074 13.25C10.1707 13.25 10.5107 13.59 10.5107 14V17.55C10.5107 17.97 10.1707 18.3 9.76074 18.3Z" fill="#202126"/>
                                <path d="M14.3604 18.3C13.9504 18.3 13.6104 17.96 13.6104 17.55V14C13.6104 13.59 13.9504 13.25 14.3604 13.25C14.7704 13.25 15.1104 13.59 15.1104 14V17.55C15.1104 17.97 14.7704 18.3 14.3604 18.3Z" fill="#202126"/>
                                <path d="M14.8907 22.7488H8.86073C5.28073 22.7488 4.48073 20.6188 4.17073 18.7688L2.76073 10.1188C2.69073 9.70878 2.97073 9.32878 3.38073 9.25878C3.79073 9.18878 4.17073 9.46878 4.24073 9.87878L5.65073 18.5188C5.94073 20.2888 6.54073 21.2488 8.86073 21.2488H14.8907C17.4607 21.2488 17.7507 20.3488 18.0807 18.6088L19.7607 9.85878C19.8407 9.44878 20.2307 9.17878 20.6407 9.26878C21.0507 9.34878 21.3107 9.73878 21.2307 10.1488L19.5507 18.8988C19.1607 20.9288 18.5107 22.7488 14.8907 22.7488Z" fill="#202126"/>
                            </svg>
                        </a>
                    </div>
                @endif
            </div>
        </div>
        <div class="product-content text-center">
            <div class="product-content-top">
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