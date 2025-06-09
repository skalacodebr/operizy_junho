<div class="pdp-right-column sticky-column">
    <div class="section-title flex align-center justify-between">
        <h2>{{ $products->name }}</h2>
        @if (Auth::guard('customers')->check())
            @if (!empty($wishlist) && isset($wishlist[$products->id]['product_id']))
                @if ($wishlist[$products->id]['product_id'] != $products->id)
                    <a href="javascript:void(0)" class="btn wishlist-btn btn-icon add_to_wishlist wishlist_{{ $products->id }}" data-id="{{ $products->id }}">
                        <i class="far fa-heart"></i>
                        {{-- <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M10.6112 19.1443C10.3371 19.1443 10.0718 19.1089 9.85078 19.0293C6.47291 17.871 1.10547 13.7592 1.10547 7.68432C1.10547 4.58942 3.60792 2.07812 6.68513 2.07812C8.17953 2.07812 9.57666 2.66174 10.6112 3.70516C11.6458 2.66174 13.0429 2.07812 14.5373 2.07812C17.6146 2.07812 20.117 4.59826 20.117 7.68432C20.117 13.768 14.7496 17.871 11.3717 19.0293C11.1506 19.1089 10.8854 19.1443 10.6112 19.1443ZM6.68513 3.40451C4.34185 3.40451 2.43186 5.32335 2.43186 7.68432C2.43186 13.7238 8.24143 17.084 10.2841 17.7825C10.4432 17.8356 10.7881 17.8356 10.9473 17.7825C12.9811 17.084 18.7995 13.7326 18.7995 7.68432C18.7995 5.32335 16.8895 3.40451 14.5462 3.40451C13.2021 3.40451 11.9553 4.03233 11.1506 5.11997C10.903 5.45599 10.3371 5.45599 10.0895 5.11997C9.26717 4.02349 8.02921 3.40451 6.68513 3.40451Z" fill="white"/>
                        </svg> --}}
                    </a>
                @else
                    <a href="javascript:void(0)" class="btn wishlist-btn wishlist-active btn-icon">
                        <i class="fas fa-heart"></i>
                        {{-- <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M10.6112 19.1443C10.3371 19.1443 10.0718 19.1089 9.85078 19.0293C6.47291 17.871 1.10547 13.7592 1.10547 7.68432C1.10547 4.58942 3.60792 2.07812 6.68513 2.07812C8.17953 2.07812 9.57666 2.66174 10.6112 3.70516C11.6458 2.66174 13.0429 2.07812 14.5373 2.07812C17.6146 2.07812 20.117 4.59826 20.117 7.68432C20.117 13.768 14.7496 17.871 11.3717 19.0293C11.1506 19.1089 10.8854 19.1443 10.6112 19.1443ZM6.68513 3.40451C4.34185 3.40451 2.43186 5.32335 2.43186 7.68432C2.43186 13.7238 8.24143 17.084 10.2841 17.7825C10.4432 17.8356 10.7881 17.8356 10.9473 17.7825C12.9811 17.084 18.7995 13.7326 18.7995 7.68432C18.7995 5.32335 16.8895 3.40451 14.5462 3.40451C13.2021 3.40451 11.9553 4.03233 11.1506 5.11997C10.903 5.45599 10.3371 5.45599 10.0895 5.11997C9.26717 4.02349 8.02921 3.40451 6.68513 3.40451Z" fill="white"/>
                        </svg> --}}
                    </a>
                @endif
            @else
                <a href="javascript:void(0)" class="btn wishlist-btn btn-icon add_to_wishlist wishlist_{{ $products->id }}" data-id="{{ $products->id }}">
                    <i class="far fa-heart"></i>
                    {{-- <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M10.6112 19.1443C10.3371 19.1443 10.0718 19.1089 9.85078 19.0293C6.47291 17.871 1.10547 13.7592 1.10547 7.68432C1.10547 4.58942 3.60792 2.07812 6.68513 2.07812C8.17953 2.07812 9.57666 2.66174 10.6112 3.70516C11.6458 2.66174 13.0429 2.07812 14.5373 2.07812C17.6146 2.07812 20.117 4.59826 20.117 7.68432C20.117 13.768 14.7496 17.871 11.3717 19.0293C11.1506 19.1089 10.8854 19.1443 10.6112 19.1443ZM6.68513 3.40451C4.34185 3.40451 2.43186 5.32335 2.43186 7.68432C2.43186 13.7238 8.24143 17.084 10.2841 17.7825C10.4432 17.8356 10.7881 17.8356 10.9473 17.7825C12.9811 17.084 18.7995 13.7326 18.7995 7.68432C18.7995 5.32335 16.8895 3.40451 14.5462 3.40451C13.2021 3.40451 11.9553 4.03233 11.1506 5.11997C10.903 5.45599 10.3371 5.45599 10.0895 5.11997C9.26717 4.02349 8.02921 3.40451 6.68513 3.40451Z" fill="white"/>
                    </svg> --}}
                </a>
            @endif
        @else
            <a href="javascript:void(0)" class="btn wishlist-btn btn-icon add_to_wishlist wishlist_{{ $products->id }}" data-id="{{ $products->id }}">
                <i class="far fa-heart"></i>
                {{-- <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M10.6112 19.1443C10.3371 19.1443 10.0718 19.1089 9.85078 19.0293C6.47291 17.871 1.10547 13.7592 1.10547 7.68432C1.10547 4.58942 3.60792 2.07812 6.68513 2.07812C8.17953 2.07812 9.57666 2.66174 10.6112 3.70516C11.6458 2.66174 13.0429 2.07812 14.5373 2.07812C17.6146 2.07812 20.117 4.59826 20.117 7.68432C20.117 13.768 14.7496 17.871 11.3717 19.0293C11.1506 19.1089 10.8854 19.1443 10.6112 19.1443ZM6.68513 3.40451C4.34185 3.40451 2.43186 5.32335 2.43186 7.68432C2.43186 13.7238 8.24143 17.084 10.2841 17.7825C10.4432 17.8356 10.7881 17.8356 10.9473 17.7825C12.9811 17.084 18.7995 13.7326 18.7995 7.68432C18.7995 5.32335 16.8895 3.40451 14.5462 3.40451C13.2021 3.40451 11.9553 4.03233 11.1506 5.11997C10.903 5.45599 10.3371 5.45599 10.0895 5.11997C9.26717 4.02349 8.02921 3.40451 6.68513 3.40451Z" fill="white"/>
                </svg> --}}
            </a>
        @endif
    </div>
    <div class="rating-wrp flex align-center">
        @if ($store_setting->enable_rating == 'on')
            <span>
                @for ($i = 1; $i <= 5; $i++)
                    @php
                        $icon = 'fa-star';
                        $color = '';
                        $newVal1 = $i - 0.5;
                        if ($avg_rating < $i && $avg_rating >= $newVal1) {
                            $icon = 'fa-star-half-alt';
                        }
                        if ($avg_rating >= $newVal1) {
                            $color = 'text-warning';
                        }
                    @endphp
                    <i class="star fas {{ $icon . ' ' . $color }}"></i>
                @endfor
            </span>
            <p>{{ $avg_rating }}/5 ({{ $user_count }} {{ __('reviews') }})</p>
        @endif
    </div>
    <div class="pdp-content">
        <p>{!! $products->detail !!}</p>
    </div>
    
    @if ($products->enable_product_variant == 'on')
        <input type="hidden" id="product_id" value="{{ $products->id }}">
        <input type="hidden" id="variant_id" value="">
        <input type="hidden" id="variant_qty" value="">
        <div class="pdp-color">
            {{-- <span class="variation">{{__('VARIATION:')}}</span> --}}
            @foreach ($product_variant_names as $key => $variant)
                <div class="select-wrp">
                    {{-- <label>{{ empty($variant->variant_name) ? $variant['variant_name'] :  $variant->variant_name}}</label> --}}
                    <label>{{ __('Variation') . ' ' . (empty($variant->variant_name) ? $variant['variant_name'] :  $variant->variant_name) . ' :'}}</label>
                    <select name="product[{{ $key }}]"  id="pro_variants_name"
                        class="form-control variant-selection  pro_variants_name{{ $key }} pro_variants_name variant_loop variant_val">
                        {{-- <option value="">{{ __('Select') }}</option> --}}
                        @foreach ($variant->variant_options ?? $variant['variant_options']  as $key => $values)
                            <option value="{{ $values }}" id="{{ $values }}_varient_option">{{ $values }}</option>
                        @endforeach
                    </select>
                </div>
            @endforeach
        </div>
    @endif
    <div class="price product-price">
        <span class="variation_price">
            @if ($products->enable_product_variant == 'on')
                {{ \App\Models\Utility::priceFormat(0) }} 
            @else
                {{ \App\Models\Utility::priceFormat($products->price) }}
            @endif
        </span>
        <del>{{ \App\Models\Utility::priceFormat($products->last_price) }}</del>
    </div>
    <span class=" mb-0 text-danger product-price-error"></span>
    
    <div class="cart-btn-wrp flex align-center addcart-btn">
        <a href="javascript:void(0)" class="add_to_cart" data-id="{{ $products->id }}">
            <button class="btn cart-btn">{{ __('Add to cart') }}</button>
        </a>
    </div>
    <ul class="pdp-variables">
        <li><b>{{ __('Category') }}:</b><span class="pdp-categorie">{{ $products->product_category() }}</span></li>
        <li><b>{{ __('ID') }} :</b><span>{{ $products->SKU }}</span></li>
        @if (!empty($products->custom_field_1) && !empty($products->custom_value_1))
            <li>
                <b>{{ $products->custom_field_1 }} :</b>
                <span>{{ $products->custom_value_1 }}</span>
            </li>
        @endif
        @if (!empty($products->custom_field_2) && !empty($products->custom_value_2))
            <li>
                <b>{{ $products->custom_field_2 }} : </b>
                <span>{{ $products->custom_value_2 }}</span>
            </li>
        @endif
        @if (!empty($products->custom_field_3) && !empty($products->custom_value_3))
            <li>
                <b>{{ $products->custom_field_3 }} :</b>
                <span> {{ $products->custom_value_3 }}</span>
            </li>
        @endif
        @if (!empty($products->custom_field_4) && !empty($products->custom_value_4))
            <li>
                <b>{{ $products->custom_field_4 }} : </b>
                <span> {{ $products->custom_value_4 }}</span>
            </li>
        @endif
    </ul>
</div>