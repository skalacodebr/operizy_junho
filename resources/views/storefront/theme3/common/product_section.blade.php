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
                            <svg width="25" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M5.38031 6.38141C5.19031 6.38141 4.99031 6.30141 4.85031 6.16141C4.56031 5.87141 4.56031 5.39141 4.85031 5.10141L8.48031 1.47141C8.77031 1.18141 9.25031 1.18141 9.54031 1.47141C9.83031 1.76141 9.83031 2.24141 9.54031 2.53141L5.91031 6.16141C5.76031 6.30141 5.57031 6.38141 5.38031 6.38141Z" fill="white"/>
                                <path d="M18.9986 6.38141C18.8086 6.38141 18.6186 6.31141 18.4686 6.16141L14.8386 2.53141C14.5486 2.24141 14.5486 1.76141 14.8386 1.47141C15.1286 1.18141 15.6086 1.18141 15.8986 1.47141L19.5286 5.10141C19.8186 5.39141 19.8186 5.87141 19.5286 6.16141C19.3886 6.30141 19.1886 6.38141 18.9986 6.38141Z" fill="white"/>
                                <path d="M20.3975 10.5996C20.3275 10.5996 20.2575 10.5996 20.1875 10.5996H19.9575H4.1875C3.4875 10.6096 2.6875 10.6096 2.1075 10.0296C1.6475 9.57961 1.4375 8.87961 1.4375 7.84961C1.4375 5.09961 3.4475 5.09961 4.4075 5.09961H19.9675C20.9275 5.09961 22.9375 5.09961 22.9375 7.84961C22.9375 8.88961 22.7275 9.57961 22.2675 10.0296C21.7475 10.5496 21.0475 10.5996 20.3975 10.5996ZM4.4075 9.09961H20.1975C20.6475 9.10961 21.0675 9.10961 21.2075 8.96961C21.2775 8.89961 21.4275 8.65961 21.4275 7.84961C21.4275 6.71961 21.1475 6.59961 19.9575 6.59961H4.4075C3.2175 6.59961 2.9375 6.71961 2.9375 7.84961C2.9375 8.65961 3.0975 8.89961 3.1575 8.96961C3.2975 9.09961 3.7275 9.09961 4.1675 9.09961H4.4075Z" fill="white"/>
                                <path d="M9.94531 18.3C9.53531 18.3 9.19531 17.96 9.19531 17.55V14C9.19531 13.59 9.53531 13.25 9.94531 13.25C10.3553 13.25 10.6953 13.59 10.6953 14V17.55C10.6953 17.97 10.3553 18.3 9.94531 18.3Z" fill="white"/>
                                <path d="M14.5469 18.3C14.1369 18.3 13.7969 17.96 13.7969 17.55V14C13.7969 13.59 14.1369 13.25 14.5469 13.25C14.9569 13.25 15.2969 13.59 15.2969 14V17.55C15.2969 17.97 14.9569 18.3 14.5469 18.3Z" fill="white"/>
                                <path d="M15.0782 22.7507H9.04823C5.46823 22.7507 4.66823 20.6207 4.35823 18.7707L2.94823 10.1207C2.87823 9.71073 3.15823 9.33073 3.56823 9.26073C3.97823 9.19073 4.35823 9.47073 4.42823 9.88073L5.83823 18.5207C6.12823 20.2907 6.72823 21.2507 9.04823 21.2507H15.0782C17.6482 21.2507 17.9382 20.3507 18.2682 18.6107L19.9482 9.86073C20.0282 9.45073 20.4182 9.18073 20.8282 9.27073C21.2382 9.35073 21.4982 9.74073 21.4182 10.1507L19.7382 18.9007C19.3482 20.9307 18.6982 22.7507 15.0782 22.7507Z" fill="white"/>
                            </svg>
                        </a>
                    </div>
                @else
                    <div class="pro-btn">
                        <a href="javascript:void(0)" data-id="{{ $product->id }}" class="compare-btn cart-btn add_to_cart">
                            <svg width="25" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M5.38031 6.38141C5.19031 6.38141 4.99031 6.30141 4.85031 6.16141C4.56031 5.87141 4.56031 5.39141 4.85031 5.10141L8.48031 1.47141C8.77031 1.18141 9.25031 1.18141 9.54031 1.47141C9.83031 1.76141 9.83031 2.24141 9.54031 2.53141L5.91031 6.16141C5.76031 6.30141 5.57031 6.38141 5.38031 6.38141Z" fill="white"/>
                                <path d="M18.9986 6.38141C18.8086 6.38141 18.6186 6.31141 18.4686 6.16141L14.8386 2.53141C14.5486 2.24141 14.5486 1.76141 14.8386 1.47141C15.1286 1.18141 15.6086 1.18141 15.8986 1.47141L19.5286 5.10141C19.8186 5.39141 19.8186 5.87141 19.5286 6.16141C19.3886 6.30141 19.1886 6.38141 18.9986 6.38141Z" fill="white"/>
                                <path d="M20.3975 10.5996C20.3275 10.5996 20.2575 10.5996 20.1875 10.5996H19.9575H4.1875C3.4875 10.6096 2.6875 10.6096 2.1075 10.0296C1.6475 9.57961 1.4375 8.87961 1.4375 7.84961C1.4375 5.09961 3.4475 5.09961 4.4075 5.09961H19.9675C20.9275 5.09961 22.9375 5.09961 22.9375 7.84961C22.9375 8.88961 22.7275 9.57961 22.2675 10.0296C21.7475 10.5496 21.0475 10.5996 20.3975 10.5996ZM4.4075 9.09961H20.1975C20.6475 9.10961 21.0675 9.10961 21.2075 8.96961C21.2775 8.89961 21.4275 8.65961 21.4275 7.84961C21.4275 6.71961 21.1475 6.59961 19.9575 6.59961H4.4075C3.2175 6.59961 2.9375 6.71961 2.9375 7.84961C2.9375 8.65961 3.0975 8.89961 3.1575 8.96961C3.2975 9.09961 3.7275 9.09961 4.1675 9.09961H4.4075Z" fill="white"/>
                                <path d="M9.94531 18.3C9.53531 18.3 9.19531 17.96 9.19531 17.55V14C9.19531 13.59 9.53531 13.25 9.94531 13.25C10.3553 13.25 10.6953 13.59 10.6953 14V17.55C10.6953 17.97 10.3553 18.3 9.94531 18.3Z" fill="white"/>
                                <path d="M14.5469 18.3C14.1369 18.3 13.7969 17.96 13.7969 17.55V14C13.7969 13.59 14.1369 13.25 14.5469 13.25C14.9569 13.25 15.2969 13.59 15.2969 14V17.55C15.2969 17.97 14.9569 18.3 14.5469 18.3Z" fill="white"/>
                                <path d="M15.0782 22.7507H9.04823C5.46823 22.7507 4.66823 20.6207 4.35823 18.7707L2.94823 10.1207C2.87823 9.71073 3.15823 9.33073 3.56823 9.26073C3.97823 9.19073 4.35823 9.47073 4.42823 9.88073L5.83823 18.5207C6.12823 20.2907 6.72823 21.2507 9.04823 21.2507H15.0782C17.6482 21.2507 17.9382 20.3507 18.2682 18.6107L19.9482 9.86073C20.0282 9.45073 20.4182 9.18073 20.8282 9.27073C21.2382 9.35073 21.4982 9.74073 21.4182 10.1507L19.7382 18.9007C19.3482 20.9307 18.6982 22.7507 15.0782 22.7507Z" fill="white"/>
                            </svg>
                        </a>
                    </div>
                @endif
            </div>
        </div>
        <div class="product-content">
            <div class="product-content-top">
                <h3>
                    <a href="{{ route('store.product.product_view', [$store->slug, $product->id]) }}">{{ $product->name }}</a>
                </h3>
                
            </div>
            <div class="product-content-bottom">
                <div class="price">
                        @if ($product->enable_product_variant == 'on')
                            <ins>{{ __('In variant') }}</ins>
                        @else
                            <ins>{{ \App\Models\Utility::priceFormat($product->price) }}</ins>
                            <del>{{ \App\Models\Utility::priceFormat($product->last_price) }}</del>

                        @endif
                </div>
                <div class="product-rating rating flex align-center">
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
        </div>
    </div>
</div>
