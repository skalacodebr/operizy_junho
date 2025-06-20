@php
    $theme_name = $store ? $store->theme_dir : 'theme1';
@endphp
@extends('storefront.layout.' . $theme_name)

@section('page-title')
    {{ __('My Cart') }}
@endsection

@section('content')
    @php
        $cart = session()->get($store->slug);
        $imgpath = \App\Models\Utility::get_file('uploads/is_cover_image/');
    @endphp

    @if(!empty($cart['products']) || $cart['products'] = [])
        <main>
            
            @include('storefront.' . $theme_name . '.common.common_banner_section')

            <section class="cart-page-sec pt pb">
                <div class="container">
                    <div class="order-historycontent">
                        <table class="cart-table">
                            <thead>
                                <tr>
                                    <th scope="col">{{ __('Product') }}</th>
                                    <th scope="col">{{ __('Name') }}</th>
                                    <th scope="col">{{ __('Price') }}</th>
                                    <th scope="col">{{ __('quantity') }}</th>
                                    <th scope="col">{{ __('Tax') }}</th>
                                    <th scope="col">{{ __('Total') }}</th>
                                    <th scope="col">{{ __('Remove') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(!empty($products))
                                    @php
                                        $sub_tax = 0;
                                        $total = 0;
                                    @endphp
                                    @foreach($products['products'] as $key => $product)
                                        @if($product['variant_id'] != 0 )
                                            <tr data-id="{{$key}}" id="product-variant-id-{{ $product['variant_id'] }}">
                                                <td data-label="Product">
                                                    <div class="cart-image">
                                                        <a href="{{ route('store.product.product_view', [$store->slug, $product['id']]) }}" class="pro-img-cart img-ratio" tabindex="0">
                                                            @if(!empty($product['image']))
                                                                <img alt="" src="{{ $imgpath.$product['image'] }}" class="">
                                                            @else
                                                                <img alt="" src="{{ asset(Storage::url('uploads/is_cover_image/default.jpg')) }}" class="">
                                                            @endif
                                                        </a>
                                                    </div>
                                                </td>
                                                <td data-label="Name" class="cart-details">
                                                    <h2>
                                                        <a href="{{ route('store.product.product_view', [$store->slug, $product['id']]) }}" tabindex="0">{{$product['product_name'] .' - '. $product['variant_name']}}</a>
                                                    </h2>
                                                </td>
                                                <td data-label="Price" class="cart-price">
                                                    <div class="price">
                                                        <ins>{{ \App\Models\Utility::priceFormat($product['variant_price']) }}</ins>
                                                    </div>
                                                </td>
                                                <td data-label="Quantity" class="cart-quantity">
                                                    <div class="qty-spinner flex align-center" data-id="{{$key}}">
                                                        <button type="button" class="quantity-decrement qty-minus product_qty">
                                                            <svg width="12" height="2" viewBox="0 0 12 2" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M0 0.251343V1.74871H12V0.251343H0Z" fill="#61AFB3">
                                                                </path>
                                                            </svg>
                                                        </button>
                                                        <input type="number" class="quantity product_qty_input bx-cart-qty" data-cke-saved-name="quantity" name="quantity"  data-id="{{$product['product_id']}}" value="{{$product['quantity']}}" id="product_qty">
                                                        <button type="button" class="quantity-increment qty-plus product_qty">
                                                            <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M6.74868 5.25132V0H5.25132V5.25132H0V6.74868H5.25132V12H6.74868V6.74868H12V5.25132H6.74868Z" fill="#61AFB3"></path>
                                                            </svg>
                                                        </button>
                                                    </div>
                                                </td>
                                                <td data-label="Tax" class="cart-Tax">
                                                    @php
                                                        $total_tax=0;
                                                    @endphp
                                                    @if(!empty($product['tax']))
                                                        @foreach($product['tax'] as $k => $tax)
                                                            @php
                                                                $sub_tax = ($product['variant_price']* $product['quantity'] * $tax['tax']) / 100;
                                                                $total_tax += $sub_tax;
                                                            @endphp
                                                            <div class="product-tax t-gray p-title mb-0 variant_tax_{{ $k }}">
                                                                {{$tax['tax_name'].' '.$tax['tax'].'%'.' ('.$sub_tax.')'}}
                                                            </div>
                                                        @endforeach 
                                                    @else
                                                        <div class="product-tax">
                                                            -
                                                        </div>
                                                    @endif
                                                </td>
                                                <td data-label="Total" class="cart-total">
                                                    <div class="price">
                                                        @php
                                                            $totalprice = $product['variant_price'] * $product['quantity'] + $total_tax;
                                                            $total += $totalprice;
                                                        @endphp
                                                        <ins class="subtotal">{{ \App\Models\Utility::priceFormat($totalprice) }}</ins>
                                                    </div>
                                                </td>
                                                <td data-label="Remove" class="cart-remove">
                                                    <a href="javascript:;" class="remove-btn action-item mr-2" data-toggle="tooltip" data-size="md" data-original-title="{{__('Move to trash')}}" data-confirm="{{__('Are You Sure?').' | '.__('This action can not be undone. Do you want to continue?')}}" data-confirm-yes="document.getElementById('delete-product-cart-{{$key}}').submit();">
                                                        <svg width="45" height="45" viewBox="0 0 45 45" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <g clip-path="url(#clip0_1_16769)">
                                                            <path d="M15.1675 4.09091C15.1675 2.74944 16.2144 1.76904 17.5559 1.76904H27.3741C28.7152 1.76904 29.7621 2.74944 29.7621 4.09091V6.63391H31.5311V4.09091C31.5311 1.77422 29.6908 0 27.3741 0H17.5559C15.2392 0 13.3984 1.77422 13.3984 4.09091V6.63391H15.1675V4.09091Z" fill="#E05353"/>
                                                            <path d="M12.0084 45.0009H32.9272C34.9441 45.0009 36.5093 43.2266 36.5093 41.0205V13.7109H8.42578V41.0205C8.42578 43.2266 9.99097 45.0009 12.0084 45.0009ZM28.1064 17.9344C28.1064 17.446 28.5024 17.0499 28.9909 17.0499C29.4794 17.0499 29.8754 17.446 29.8754 17.9344V38.8312C29.8754 39.3197 29.4794 39.7158 28.9909 39.7158C28.5024 39.7158 28.1064 39.3197 28.1064 38.8312V17.9344ZM21.583 17.9344C21.583 17.446 21.9791 17.0499 22.4676 17.0499C22.956 17.0499 23.3521 17.446 23.3521 17.9344V38.8312C23.3521 39.3197 22.956 39.7158 22.4676 39.7158C21.9791 39.7158 21.583 39.3197 21.583 38.8312V17.9344ZM15.0597 17.9344C15.0597 17.446 15.4557 17.0499 15.9442 17.0499C16.4327 17.0499 16.8287 17.446 16.8287 17.9344V38.8312C16.8287 39.3197 16.4327 39.7158 15.9442 39.7158C15.4557 39.7158 15.0597 39.3197 15.0597 38.8312V17.9344Z" fill="#E05353"/>
                                                            <path d="M7.51599 11.9402H37.4126C38.634 11.9402 39.6239 10.9503 39.6239 9.72888C39.6239 8.50748 38.634 7.51758 37.4126 7.51758H7.51599C6.29459 7.51758 5.30469 8.50748 5.30469 9.72888C5.30469 10.9503 6.29459 11.9402 7.51599 11.9402Z" fill="#E05353"/>
                                                            </g>
                                                            <defs>
                                                            <clipPath id="clip0_1_16769">
                                                            <rect width="45" height="45" fill="white"/>
                                                            </clipPath>
                                                            </defs>
                                                        </svg>
                                                            
                                                    </a>
                                                    {!! Form::open(['method' => 'DELETE', 'route' => ['delete.cart_item',[$store->slug,$product['product_id'],$product['variant_id']]],'id'=>'delete-product-cart-'.$key]) !!}
                                                    {!! Form::close() !!}
                                                </td>
                                            </tr>
                                        @else
                                            <tr data-id="{{$key}}" class="alert" id="product-id-{{ $product['product_id'] }}">
                                                <td data-label="Image">
                                                    <div class="cart-image">
                                                        <a href="{{ route('store.product.product_view', [$store->slug, $product['id']]) }}" class="pro-img-cart img-ratio" tabindex="0">
                                                            @if(!empty($product['image']))
                                                                <img alt="" src="{{ $imgpath.$product['image']}}" class="">
                                                            @else
                                                                <img alt="" src="{{ asset(Storage::url('uploads/is_cover_image/default.jpg')) }}" class="">
                                                            @endif
                                                        </a>
                                                    </div>
                                                </td>
                                                <td data-label="Name" class="cart-details">
                                                    <h2>
                                                        <a href="{{ route('store.product.product_view', [$store->slug, $product['id']]) }}" tabindex="0">{{ $product['product_name'] }}</a>
                                                    </h2>
                                                </td>
                                                <td data-label="Price" class="cart-price">
                                                    <div class="price">
                                                        <ins>{{ \App\Models\Utility::priceFormat($product['price']) }}</ins>
                                                    </div>
                                                </td>
                                                <td data-label="Quantity" class="cart-quantity">
                                                    <div class="qty-spinner flex align-center" data-id="{{$key}}">
                                                        <button type="button" class="quantity-decrement qty-minus product_qty">
                                                            <svg width="12" height="2" viewBox="0 0 12 2" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M0 0.251343V1.74871H12V0.251343H0Z" fill="#61AFB3">
                                                                </path>
                                                            </svg>
                                                        </button>
                                                        <input type="number" class="quantity product_qty_input bx-cart-qty" data-cke-saved-name="quantity" name="quantity" data-id="{{$product['product_id']}}" value="{{$product['quantity']}}" id="product_qty">
                                                        <button type="button" class="quantity-increment qty-plus product_qty">
                                                            <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M6.74868 5.25132V0H5.25132V5.25132H0V6.74868H5.25132V12H6.74868V6.74868H12V5.25132H6.74868Z" fill="#61AFB3"></path>
                                                            </svg>
                                                        </button>
                                                    </div>
                                                </td>
                                                <td data-label="Tax" class="cart-Tax">
                                                    @php
                                                        $total_tax=0;
                                                    @endphp
                                                    @if(!empty($product['tax']))
                                                        @foreach($product['tax'] as $k => $tax)
                                                            @php
                                                                $sub_tax = ($product['price']* $product['quantity'] * $tax['tax']) / 100;
                                                                $total_tax += $sub_tax;
                                                            @endphp
                                                            <div class="product-tax t-gray p-title mb-0 tax_{{ $k }}">
                                                                {{$tax['tax_name'].' '.$tax['tax'].'%'.' ('.$sub_tax.')'}}
                                                            </div>
                                                        @endforeach
                                                    @else
                                                        <div class="product-tax">
                                                            -
                                                        </div>
                                                    @endif
                                                </td>
                                                <td data-label="Total" class="cart-total">
                                                    <div class="price">
                                                        @php
                                                            $totalprice = $product['price'] * $product['quantity'] + $total_tax;
                                                            $total += $totalprice;
                                                        @endphp
                                                        <ins class="subtotal">{{ \App\Models\Utility::priceFormat($totalprice) }}</ins>
                                                    </div>
                                                </td>
                                                <td data-label="Remove" class="cart-remove">
                                                    <a href="javascript:;" class="remove-btn action-item mr-2" data-toggle="tooltip" data-size="md" data-original-title="{{__('Move to trash')}}" data-confirm="{{__('Are You Sure?').' | '.__('This action can not be undone. Do you want to continue?')}}" data-confirm-yes="document.getElementById('delete-product-cart-{{$key}}').submit();">
                                                        <svg width="45" height="45" viewBox="0 0 45 45" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <g clip-path="url(#clip0_1_16769)">
                                                            <path d="M15.1675 4.09091C15.1675 2.74944 16.2144 1.76904 17.5559 1.76904H27.3741C28.7152 1.76904 29.7621 2.74944 29.7621 4.09091V6.63391H31.5311V4.09091C31.5311 1.77422 29.6908 0 27.3741 0H17.5559C15.2392 0 13.3984 1.77422 13.3984 4.09091V6.63391H15.1675V4.09091Z" fill="#E05353"/>
                                                            <path d="M12.0084 45.0009H32.9272C34.9441 45.0009 36.5093 43.2266 36.5093 41.0205V13.7109H8.42578V41.0205C8.42578 43.2266 9.99097 45.0009 12.0084 45.0009ZM28.1064 17.9344C28.1064 17.446 28.5024 17.0499 28.9909 17.0499C29.4794 17.0499 29.8754 17.446 29.8754 17.9344V38.8312C29.8754 39.3197 29.4794 39.7158 28.9909 39.7158C28.5024 39.7158 28.1064 39.3197 28.1064 38.8312V17.9344ZM21.583 17.9344C21.583 17.446 21.9791 17.0499 22.4676 17.0499C22.956 17.0499 23.3521 17.446 23.3521 17.9344V38.8312C23.3521 39.3197 22.956 39.7158 22.4676 39.7158C21.9791 39.7158 21.583 39.3197 21.583 38.8312V17.9344ZM15.0597 17.9344C15.0597 17.446 15.4557 17.0499 15.9442 17.0499C16.4327 17.0499 16.8287 17.446 16.8287 17.9344V38.8312C16.8287 39.3197 16.4327 39.7158 15.9442 39.7158C15.4557 39.7158 15.0597 39.3197 15.0597 38.8312V17.9344Z" fill="#E05353"/>
                                                            <path d="M7.51599 11.9402H37.4126C38.634 11.9402 39.6239 10.9503 39.6239 9.72888C39.6239 8.50748 38.634 7.51758 37.4126 7.51758H7.51599C6.29459 7.51758 5.30469 8.50748 5.30469 9.72888C5.30469 10.9503 6.29459 11.9402 7.51599 11.9402Z" fill="#E05353"/>
                                                            </g>
                                                            <defs>
                                                            <clipPath id="clip0_1_16769">
                                                            <rect width="45" height="45" fill="white"/>
                                                            </clipPath>
                                                            </defs>
                                                            </svg>
                                                            
                                                    </a>
                                                    {!! Form::open(['method' => 'DELETE', 'route' => ['delete.cart_item',[$store->slug,$product['product_id'],$product['variant_id']]],'id'=>'delete-product-cart-'.$key]) !!}
                                                    {!! Form::close() !!}
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <div class="cart-total-row flex align-center">
                        <div class="cart-total-left flex align-center">
                            @if($store_settings['is_checkout_login_required'] == null || $store_settings['is_checkout_login_required'] == 'off' && !Auth::guard('customers')->user())
                                <a href="javascript:;" class="btn checkout-btn modal-target" data-modal="Checkout" id="checkout-btn">
                                    {{__('Proceed to checkout')}}
                                </a>
                            @else
                                <a href="{{route('user-address.useraddress',$store->slug)}}" class="btn checkout-btn">
                                    {{__('Proceed to checkout')}}
                                </a>
                            @endif
                       
                            <a href="{{ route('store.slug', $store->slug) }}" class="btn btn-transparent cart-btn">{{__('Return to shop')}}</a>

                        </div>
                        <div class="cart-total-right">
                            <div class="cart-total flex align-center justify-between">
                                <span>{{ __('Total') }}:</span>
                                <span id="displaytotal">{{ \App\Models\Utility::priceFormat(!empty($total) ? $total : 0) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    @else
        <main>
            
            @include('storefront.' . $theme_name . '.common.common_banner_section')

            <section class="empty-cart-section pt pb">
                <div class="container">
                    <div class="row flex justify-center">
                        <div class="col-lg-5 col-md-12 col-12">
                            <div class="empty-cart">
                                <svg id="8fc77738-ee79-4216-bfe1-e1f5c470859a" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="1015.56" height="783.53" viewBox="0 0 1015.56 783.53">
                                    <defs>
                                        <linearGradient id="55e18adb-5a4b-48dc-a3c1-f250c98f7014" x1="535.54" y1="705.46" x2="535.54" gradientUnits="userSpaceOnUse">
                                            <stop offset="0" stop-color="gray" stop-opacity="0.25"></stop>
                                            <stop offset="0.54" stop-color="gray" stop-opacity="0.12"></stop>
                                            <stop offset="1" stop-color="gray" stop-opacity="0.1"></stop>
                                        </linearGradient>
                                        <linearGradient id="dcaa3d52-8271-46b6-bbc0-03906cb73c47" x1="237.19" y1="818.89" x2="237.19" y2="359.58" xlink:href="#55e18adb-5a4b-48dc-a3c1-f250c98f7014"></linearGradient>
                                    </defs>
                                    <title>online shopping</title>
                                    <path d="M729.3,184.55c-42.28,26.74-97.12,25-145.17,11.1s-92.2-38.69-139-56.3A490.89,490.89,0,0,0,323,110.59c-59.67-6.17-126.3,1.34-167.88,44.57-46.3,48.15-42.75,135,7.33,179.18,25.47,22.48,58.83,33.51,87.92,51.06s56,46.7,53.53,80.58c-2.29,31.36-28.95,55.43-56.54,70.53-21.33,11.67-47.6,24.41-50.17,48.58-2.48,23.39,19.6,41.72,40.69,52.14,68.8,34,153.56,33.67,222.09-.86,24.45-12.32,46.93-28.7,72.57-38.3,67.33-25.21,141.51.17,212.8,9.45a469.33,469.33,0,0,0,181-11.91c35.3-9.42,70.74-23.82,95.54-50.65,17.88-19.35,29-43.83,39.49-68q16.73-38.68,32.16-77.9c6.18-15.7,12.26-31.7,13.85-48.5,2.89-30.43-9.28-60.51-25.87-86.2C1042.11,203.37,975.8,160.49,904,149.6S756.21,160,700.51,206.53" transform="translate(-92.22 -58.23)" class="fill-primary" opacity="0.1"></path>
                                    <ellipse cx="135.74" cy="756.99" rx="135.74" ry="26.54" class="fill-primary" opacity="0.1"></ellipse>
                                    <ellipse cx="538.99" cy="701.56" rx="284.54" ry="26.54" class="fill-primary" opacity="0.1"></ellipse>
                                    <path d="M824.35,570.83s39.89-70.66,100-91c25.21-8.55,47.22-24.62,62.27-46.58A207.22,207.22,0,0,0,1005,400.18" transform="translate(-92.22 -58.23)" fill="none" stroke="#535461" stroke-miterlimit="10" stroke-width="2"></path>
                                    <path d="M1042.73,387.12c-6.85,6.64-38.73,13.51-38.73,13.51s7.83-31.65,14.67-38.3a17.27,17.27,0,0,1,24.06,24.79Z" transform="translate(-92.22 -58.23)" class="fill-primary"></path>
                                    <path d="M1024.7,444.41c-9.36,1.85-39.85-9.71-39.85-9.71s23.77-22.32,33.12-24.18a17.28,17.28,0,1,1,6.73,33.89Z" transform="translate(-92.22 -58.23)" class="fill-primary"></path>
                                    <path d="M959,506.4c-9-3.12-29.5-28.49-29.5-28.49s31.79-7.28,40.8-4.16A17.28,17.28,0,1,1,959,506.4Z" transform="translate(-92.22 -58.23)" class="fill-primary"></path>
                                    <path d="M898.79,542.11C889.38,540.56,864.9,519,864.9,519s30.1-12.54,39.51-11a17.27,17.27,0,1,1-5.62,34.08Z" transform="translate(-92.22 -58.23)" class="fill-primary"></path>
                                    <path d="M958.26,410c0,9.54,17.26,37.21,17.26,37.21s17.28-27.66,17.29-37.2a17.28,17.28,0,0,0-34.55,0Z" transform="translate(-92.22 -58.23)" class="fill-primary"></path>
                                    <path d="M888.34,452.63c2.85,9.1,27.59,30.34,27.59,30.34s8.22-31.56,5.37-40.66a17.27,17.27,0,1,0-33,10.32Z" transform="translate(-92.22 -58.23)" class="fill-primary"></path>
                                    <path d="M826.06,503.42c1.27,9.46,22.08,34.57,22.08,34.57s13.43-29.71,12.16-39.17a17.27,17.27,0,1,0-34.24,4.6Z" transform="translate(-92.22 -58.23)" class="fill-primary"></path>
                                    <path d="M1042.73,387.12c-6.85,6.64-38.73,13.51-38.73,13.51s7.83-31.65,14.67-38.3a17.27,17.27,0,0,1,24.06,24.79Z" transform="translate(-92.22 -58.23)" opacity="0.25"></path>
                                    <path d="M1024.7,444.41c-9.36,1.85-39.85-9.71-39.85-9.71s23.77-22.32,33.12-24.18a17.28,17.28,0,1,1,6.73,33.89Z" transform="translate(-92.22 -58.23)" opacity="0.25"></path>
                                    <path d="M959,506.4c-9-3.12-29.5-28.49-29.5-28.49s31.79-7.28,40.8-4.16A17.28,17.28,0,1,1,959,506.4Z" transform="translate(-92.22 -58.23)" opacity="0.25"></path>
                                    <path d="M898.79,542.11C889.38,540.56,864.9,519,864.9,519s30.1-12.54,39.51-11a17.27,17.27,0,1,1-5.62,34.08Z" transform="translate(-92.22 -58.23)" opacity="0.25"></path>
                                    <path d="M958.26,410c0,9.54,17.26,37.21,17.26,37.21s17.28-27.66,17.29-37.2a17.28,17.28,0,0,0-34.55,0Z" transform="translate(-92.22 -58.23)" opacity="0.25"></path>
                                    <path d="M888.34,452.63c2.85,9.1,27.59,30.34,27.59,30.34s8.22-31.56,5.37-40.66a17.27,17.27,0,1,0-33,10.32Z" transform="translate(-92.22 -58.23)" opacity="0.25"></path>
                                    <path d="M826.06,503.42c1.27,9.46,22.08,34.57,22.08,34.57s13.43-29.71,12.16-39.17a17.27,17.27,0,1,0-34.24,4.6Z" transform="translate(-92.22 -58.23)" opacity="0.25"></path>
                                    <path d="M826.65,569.42s7.83-80.76,54.49-123.71a123,123,0,0,0,38.06-67.82,207,207,0,0,0,3.4-37.66" transform="translate(-92.22 -58.23)" fill="none" stroke="#535461" stroke-miterlimit="10" stroke-width="2"></path>
                                    <path d="M951.85,313c-3.57,8.85-29.93,28-29.93,28s-5.68-32.11-2.11-41a17.27,17.27,0,0,1,32,12.91Z" transform="translate(-92.22 -58.23)" class="fill-primary"></path>
                                    <path d="M958.57,372.66c-7.8,5.49-40.36,7.28-40.36,7.28s12.69-30,20.49-35.53a17.27,17.27,0,0,1,19.87,28.25Z" transform="translate(-92.22 -58.23)" class="fill-primary"></path>
                                    <path d="M923.66,455.94c-9.5.8-38.51-14.09-38.51-14.09s26.11-19.53,35.62-20.33a17.27,17.27,0,1,1,2.89,34.42Z" transform="translate(-92.22 -58.23)" class="fill-primary"></path>
                                    <path d="M883.06,513c-9.23,2.39-40.34-7.38-40.34-7.38s22.44-23.67,31.67-26.06A17.27,17.27,0,0,1,883.06,513Z" transform="translate(-92.22 -58.23)" class="fill-primary"></path>
                                    <path d="M883.88,368.1c3.87,8.72,30.86,27,30.86,27s4.59-32.28.73-41a17.27,17.27,0,0,0-31.59,14Z" transform="translate(-92.22 -58.23)" class="fill-primary"></path>
                                    <path d="M837.24,435.44c6.3,7.16,37.53,16.55,37.53,16.55s-5.28-32.18-11.57-39.35a17.28,17.28,0,0,0-26,22.8Z" transform="translate(-92.22 -58.23)" class="fill-primary"></path>
                                    <path d="M800.89,507.11c5,8.13,34.19,22.66,34.19,22.66s.24-32.61-4.75-40.74a17.27,17.27,0,1,0-29.44,18.08Z" transform="translate(-92.22 -58.23)" class="fill-primary"></path>
                                    <polygon points="281.84 0 281.84 27.38 281.84 705.46 789.24 705.46 789.24 27.38 789.24 0 281.84 0" fill="url(#55e18adb-5a4b-48dc-a3c1-f250c98f7014)"></polygon>
                                    <rect x="286.29" y="6.19" width="498.5" height="26.89" fill="#f6f7f9"></rect>
                                    <g opacity="0.2">
                                        <rect x="286.29" y="6.19" width="498.5" height="26.89" class="fill-primary"></rect>
                                    </g>
                                    <rect x="286.29" y="33.08" width="498.5" height="666.19" fill="#f6f7f9"></rect>
                                    <circle cx="299.4" cy="19.63" r="4.56" fill="#f6f7f9"></circle>
                                    <circle cx="311.76" cy="19.63" r="4.56" fill="#f6f7f9"></circle>
                                    <circle cx="324.12" cy="19.63" r="4.56" fill="#f6f7f9"></circle>
                                    <g opacity="0.2">
                                        <rect x="375.26" y="74.15" width="320.55" height="12.55" class="fill-primary"></rect>
                                    </g>
                                    <rect x="653.22" y="74.15" width="42.59" height="12.55" class="fill-primary"></rect>
                                    <g opacity="0.2">
                                        <rect x="329.32" y="330.62" width="201.72" height="144.49" class="fill-primary" opacity="0.2"></rect>
                                    </g>
                                    <g opacity="0.2">
                                        <rect x="329.32" y="143.19" width="201.72" height="144.49" class="fill-primary" opacity="0.2"></rect>
                                    </g>
                                    <g opacity="0.2">
                                        <rect x="329.32" y="515.61" width="201.72" height="144.49" class="fill-primary" opacity="0.2"></rect>
                                    </g>
                                    <g opacity="0.2">
                                        <rect x="540.04" y="330.62" width="201.72" height="144.49" class="fill-primary" opacity="0.2"></rect>
                                    </g>
                                    <g opacity="0.2">
                                        <rect x="540.04" y="143.19" width="201.72" height="144.49" class="fill-primary" opacity="0.2"></rect>
                                    </g>
                                    <g opacity="0.2">
                                        <rect x="540.04" y="515.61" width="201.72" height="144.49" class="fill-primary" opacity="0.2"></rect>
                                    </g>
                                    <path d="M1023.79,692.73s7.14,9.33-3.29,23.41-19,26-15.55,34.76c0,0,15.73-26.16,28.54-26.52S1037.88,708.46,1023.79,692.73Z" transform="translate(-92.22 -58.23)" fill="#3acc6c"></path>
                                    <path d="M1023.79,692.73a11.49,11.49,0,0,1,1.46,2.92c12.5,14.68,19.15,28.38,7.14,28.73-11.18.32-24.61,20.32-27.82,25.37a11.06,11.06,0,0,0,.38,1.15s15.73-26.16,28.54-26.52S1037.88,708.46,1023.79,692.73Z" transform="translate(-92.22 -58.23)" opacity="0.1"></path>
                                    <path d="M1037.06,704.62c0,3.28-.37,5.94-.82,5.94s-.83-2.66-.83-5.94.46-1.74.92-1.74S1037.06,701.33,1037.06,704.62Z" transform="translate(-92.22 -58.23)" fill="#ffd037"></path>
                                    <path d="M1041.61,708.54c-2.88,1.57-5.4,2.52-5.61,2.12s1.94-2,4.82-3.57,1.75-.42,2,0S1044.49,707,1041.61,708.54Z" transform="translate(-92.22 -58.23)" fill="#ffd037"></path>
                                    <path d="M986.11,692.73s-7.14,9.33,3.29,23.41,19,26,15.55,34.76c0,0-15.73-26.16-28.54-26.52S972,708.46,986.11,692.73Z" transform="translate(-92.22 -58.23)" fill="#3acc6c"></path>
                                    <path d="M986.11,692.73a11.49,11.49,0,0,0-1.46,2.92c-12.5,14.68-19.15,28.38-7.14,28.73,11.19.32,24.61,20.32,27.82,25.37a9.11,9.11,0,0,1-.38,1.15s-15.73-26.16-28.54-26.52S972,708.46,986.11,692.73Z" transform="translate(-92.22 -58.23)" opacity="0.1"></path>
                                    <path d="M972.84,704.62c0,3.28.37,5.94.83,5.94s.82-2.66.82-5.94-.46-1.74-.91-1.74S972.84,701.33,972.84,704.62Z" transform="translate(-92.22 -58.23)" fill="#ffd037"></path>
                                    <path d="M968.29,708.54c2.89,1.57,5.4,2.52,5.62,2.12s-1.95-2-4.83-3.57-1.75-.42-2,0S965.41,707,968.29,708.54Z" transform="translate(-92.22 -58.23)" fill="#ffd037"></path>
                                    <ellipse cx="912.73" cy="752.6" rx="74.6" ry="11.45" class="fill-primary" opacity="0.1"></ellipse>
                                    <path d="M1043.35,738.33l-.36,2.91-.5,4.12-.21,1.71-.5,4.12-.22,1.72-.5,4.11-5.71,46.8c-.51,4.18-7.33,7.43-15.57,7.43H990.12c-8.24,0-15-3.25-15.56-7.43L968.84,757l-.5-4.11-.21-1.72-.51-4.12-.21-1.71-.5-4.12-.36-2.91C966.27,736,970,734,974.62,734h60.67C1039.94,734,1043.64,736,1043.35,738.33Z" transform="translate(-92.22 -58.23)" fill="#65617d"></path>
                                    <polygon points="950.77 683.01 950.27 687.12 875.19 687.12 874.69 683.01 950.77 683.01" fill="#9d9cb5"></polygon>
                                    <polygon points="950.06 688.84 949.56 692.96 875.91 692.96 875.4 688.84 950.06 688.84" fill="#9d9cb5"></polygon>
                                    <polygon points="949.34 694.67 948.84 698.79 876.62 698.79 876.12 694.67 949.34 694.67" fill="#9d9cb5"></polygon>
                                    <path d="M683.83,229.34s-1.83-4.57,10.51-3.43,47.77,5.08,63.09,1.63,24.45-4.55,23.54,0-26.51,14.83-26.51,14.83l-33.15,3.43-24.45-3.89-13.13-7.77Z" transform="translate(-92.22 -58.23)" class="fill-primary"></path>
                                    <path d="M781,227.54c-.92,4.55-26.51,14.83-26.51,14.83l-33.15,3.43-24.45-3.88-13.12-7.77.09-4.8a2,2,0,0,1,.7-2.21c1.13-1,3.77-1.78,9.81-1.22,12.35,1.14,47.77,5.07,63.09,1.62,12.48-2.81,20.86-4.06,23-2A2,2,0,0,1,781,227.54Z" transform="translate(-92.22 -58.23)" opacity="0.1"></path>
                                    <path d="M800.7,296.77a143.09,143.09,0,0,0-58.82,26.05,10.91,10.91,0,0,0-4.69-5.57,16.47,16.47,0,0,0-4.76-2c-1.53-.39-3,.54-4.35,1.88a24.63,24.63,0,0,0-3.87,5.73c-23.31-16-58.67-26.21-58.67-26.21v-3.2c0-.63.11-1.39.23-2.25s.27-1.62.46-2.55c3-15.26,14.86-50.13,14.86-50.13h3.67l9.74,0,26,5.4,29.25-1.79L779.21,236l3.82-.8c6.37,5,13.6,40,16.44,54.9.36,1.89.64,3.45.85,4.6C800.57,296,800.7,296.77,800.7,296.77Z" transform="translate(-92.22 -58.23)" class="fill-primary"></path>
                                    <path d="M670.38,290.16c.77-14.65,12.41-46.4,14.38-51.67h-3.67s-12.56,37-15.11,51.44a.36.36,0,0,0,0,.11c-.07.39-.14.77-.19,1.13-.12.86-.2,1.62-.23,2.25v3.2s35.36,10.22,58.67,26.21a24.63,24.63,0,0,1,3.87-5.73C719.19,309,685.4,295.8,670.38,290.16Z" transform="translate(-92.22 -58.23)" class="fill-primary"></path>
                                    <path d="M800.32,294.66c-.09-.51-.2-1.1-.32-1.75-.15-.84-.33-1.79-.53-2.85h0c-2.84-14.92-10.07-49.93-16.44-54.9l-3.82.8c2.32,6.23,17.27,46.91,16,54.85-25,5-50.34,21.25-58,26.44a10.91,10.91,0,0,1,4.69,5.57,143.09,143.09,0,0,1,58.82-26.05S800.57,296,800.32,294.66Z" transform="translate(-92.22 -58.23)" class="fill-primary"></path>
                                    <path d="M671.3,289.24c.76-14.65,12.41-46.4,14.38-51.66H682s-12.56,37-15.11,51.43c0,0,0,.08,0,.11q-.11.6-.18,1.14c-.12.86-.2,1.62-.23,2.25v3.2s35.35,10.21,58.67,26.21a24.21,24.21,0,0,1,3.86-5.73C720.1,308.11,686.32,294.88,671.3,289.24Z" transform="translate(-92.22 -58.23)" opacity="0.1"></path>
                                    <path d="M670.38,290.16c.77-14.65,12.41-46.4,14.38-51.67h-3.67s-12.56,37-15.11,51.44a.36.36,0,0,0,0,.11c-.07.39-.14.77-.19,1.13-.12.86-.2,1.62-.23,2.25v3.2s35.36,10.22,58.67,26.21a24.63,24.63,0,0,1,3.87-5.73C719.19,309,685.4,295.8,670.38,290.16Z" transform="translate(-92.22 -58.23)" class="fill-primary"></path>
                                    <path d="M799.41,293.74l-.32-1.75c-.16-.84-.33-1.78-.53-2.85h0c-2.83-14.91-10.07-49.92-16.44-54.9l-3.81.81c2.32,6.23,17.27,46.91,16,54.85-25,5-50.35,21.25-58,26.43a10.93,10.93,0,0,1,4.69,5.58,142.94,142.94,0,0,1,58.81-26.06S799.66,295.1,799.41,293.74Z" transform="translate(-92.22 -58.23)" opacity="0.1"></path>
                                    <path d="M800.32,294.66c-.09-.51-.2-1.1-.32-1.75-.15-.84-.33-1.79-.53-2.85h0c-2.84-14.92-10.07-49.93-16.44-54.9l-3.82.8c2.32,6.23,17.27,46.91,16,54.85-25,5-50.34,21.25-58,26.44a10.91,10.91,0,0,1,4.69,5.57,143.09,143.09,0,0,1,58.82-26.05S800.57,296,800.32,294.66Z" transform="translate(-92.22 -58.23)" class="fill-primary"></path>
                                    <path d="M679.07,256.57s23.2,14.6,28.62-6.78l5.16,1.38s1.7,23.69-35.32,10.17Z" transform="translate(-92.22 -58.23)" opacity="0.1"></path>
                                    <path d="M679.07,254.74s23.2,14.6,28.62-6.78l5.16,1.38s1.7,23.69-35.32,10.17Z" transform="translate(-92.22 -58.23)" class="fill-primary"></path>
                                    <path d="M752.07,250.48s3,17.47,34.79,9l-1.12-3.3s-21.71,9-29.58-6.63Z" transform="translate(-92.22 -58.23)" opacity="0.1"></path>
                                    <path d="M752.07,248.65s3,17.47,34.79,9l-1.12-3.3s-21.71,9-29.58-6.63Z" transform="translate(-92.22 -58.23)" class="fill-primary"></path>
                                    <path d="M730.91,250.25v36.46h5.64s7.8-2.81,7.62-19.2-1.37-20.8-1.37-20.8Z" transform="translate(-92.22 -58.23)" opacity="0.1"></path>
                                    <path d="M730,249.34V285.8h5.64s7.8-2.81,7.62-19.2-1.38-20.8-1.38-20.8Z" transform="translate(-92.22 -58.23)" class="fill-primary"></path>
                                    <path d="M783,237c-2.3,4.28-23.18,11.31-26.87,12.52l-.56.18s-1.32.34-3.53.8c-6.72,1.4-21.7,4-33,1.72-1.64-.32-3.34-.67-5.07-1l-4-.87c-13-2.89-26.45-6.67-28.84-10,0,0,.65-10.87,2.84-10.58s26.64,10.58,26.64,10.58l.35.05c.63.08,2.06.26,4.07.49,7.94.87,24.67,2.25,33.67-.16.43-.12.83-.24,1.22-.38.68-.23,1.39-.47,2.12-.74,11.58-4.1,28.92-11.44,28.92-11.44S785.54,232.29,783,237Z" transform="translate(-92.22 -58.23)" opacity="0.1"></path>
                                    <path d="M781,227.54c-.92,4.55-26.51,14.83-26.51,14.83l-33.15,3.43-24.45-3.88-13.12-7.77.09-4.8a2,2,0,0,1,.7-2.21c4.35,1.32,26,10.43,26,10.43l.35.05c.63.08,2.06.26,4.07.49,7.94.87,24.67,2.25,33.67-.16.43-.12.83-.24,1.22-.38.68-.22,1.39-.47,2.12-.74,10.47-3.71,25.66-10.07,28.47-11.25A2,2,0,0,1,781,227.54Z" transform="translate(-92.22 -58.23)" opacity="0.1"></path>
                                    <path d="M783,235.16c-2.3,4.28-23.18,11.3-26.87,12.51l-.56.19s-1.32.33-3.53.79c-6.72,1.4-21.7,4-33,1.72-1.64-.32-3.34-.67-5.07-1l-4-.87c-13-2.89-26.45-6.67-28.84-10,0,0,.65-10.87,2.84-10.57s26.64,10.57,26.64,10.57l.35.05c.63.08,2.06.27,4.07.49,7.94.87,24.67,2.25,33.67-.16.43-.12.83-.24,1.22-.38.68-.22,1.39-.47,2.12-.74,11.58-4.1,28.92-11.44,28.92-11.44S785.54,230.47,783,235.16Z" transform="translate(-92.22 -58.23)" class="fill-primary"></path>
                                    <circle cx="642.65" cy="188.48" r="3.66" opacity="0.1"></circle>
                                    <circle cx="642.65" cy="187.56" r="3.66" class="fill-primary"></circle>
                                    <path d="M715.9,239l-1,10.32-4-.87,1-9.94C712.46,238.61,713.9,238.8,715.9,239Z" transform="translate(-92.22 -58.23)" opacity="0.1"></path>
                                    <path d="M715,239l-1,10.32-4-.87,1-9.94C711.55,238.61,713,238.8,715,239Z" transform="translate(-92.22 -58.23)" class="fill-primary"></path>
                                    <path d="M755.24,247.67l-.56.19s-1.31.33-3.53.79l-3.41-9.79c.43-.12.84-.24,1.23-.38.68-.22,1.39-.47,2.12-.74Z" transform="translate(-92.22 -58.23)" opacity="0.1"></path>
                                    <path d="M756.16,247.67l-.56.19s-1.32.33-3.53.79l-3.41-9.79c.43-.12.83-.24,1.22-.38.68-.22,1.39-.47,2.12-.74Z" transform="translate(-92.22 -58.23)" class="fill-primary"></path>
                                    <g opacity="0.5">
                                        <path d="M498.24,221a26.4,26.4,0,0,1,13.29,3.69s12.18,1.48,18.82,0,10-6.64,11.26-5.17,1.29,15.32,1.29,15.32l-5.72,15.32-12.92,9.59-20.48-5.9L497,236.52Z" transform="translate(-92.22 -58.23)" class="fill-primary"></path>
                                        <path d="M542.9,234.86l-5.72,15.32-12.92,9.59-20.48-5.9L497,236.52l1.29-15.5h.3a27.12,27.12,0,0,1,13,3.7s12.18,1.48,18.82,0c6.31-1.4,9.63-6.14,11-5.34h0a.62.62,0,0,1,.21.16C542.9,221,542.9,234.86,542.9,234.86Z" transform="translate(-92.22 -58.23)" opacity="0.1"></path>
                                        <path d="M542.9,234.86l-5.72,15.32-12.92,9.59-20.48-5.9L497,236.52l1.29-15.5h.3c1.14,4.89,6,20.33,21.48,21.42,15.92,1.11,20.44-17.83,21.38-23.05a.62.62,0,0,1,.21.16C542.9,221,542.9,234.86,542.9,234.86Z" transform="translate(-92.22 -58.23)" opacity="0.1"></path>
                                        <path d="M498.24,221s3.32,21.59,21.78,22.88,21.59-24.36,21.59-24.36,26.76,8.77,33,24.41,10.89,28.19,10.89,28.19-2,3.5-4.25,3.87-17.53,10.89-17.53,10.89-.18,29.9,1.48,31.74,1.11,9.78-3.88,9.41-39.49-8.12-69-1.66c0,0-12.36,4.43-12-2.77s.92-35.43.92-35.43-18.64-8.12-19.74-8.12-3.88-1.46-.93-6.27,6.65-21.22,6.65-21.22S474.62,229,498.24,221Z" transform="translate(-92.22 -58.23)" class="fill-primary"></path>
                                        <path d="M555.63,259.77s5.54,4.06,4.25,7.2S555.63,259.77,555.63,259.77Z" transform="translate(-92.22 -58.23)" opacity="0.1"></path>
                                        <path d="M563.75,263.67a10,10,0,0,0,0,5.51" transform="translate(-92.22 -58.23)" opacity="0.1"></path>
                                        <path d="M567.44,273.8s.74,5-1.47,5.53" transform="translate(-92.22 -58.23)" opacity="0.1"></path>
                                        <path d="M492.15,258.48s-10.33,9-6.83,12.55" transform="translate(-92.22 -58.23)" opacity="0.1"></path>
                                        <path d="M485.69,280.26s-.17,9.41,2.68,10.15" transform="translate(-92.22 -58.23)" opacity="0.1"></path>
                                        <path d="M515.4,311.81s7-4.79,8.86-4.61" transform="translate(-92.22 -58.23)" opacity="0.1"></path>
                                        <path d="M522.4,316.8s7.58-5.36,9.61-5" transform="translate(-92.22 -58.23)" opacity="0.1"></path>
                                    </g>
                                    <g opacity="0.5">
                                        <path d="M687,402.65s60.38,2.86,90.4,1.1l-.66,7.92-53.12,7-15.72-4.84Z" transform="translate(-92.22 -58.23)" class="fill-primary"></path>
                                        <path d="M777.44,403.75l-.66,7.92-53.11,7-15.73-4.84L687,402.65s1.24.07,3.45.16h0c13.1.57,60.27,2.41,86.17,1Z" transform="translate(-92.22 -58.23)" opacity="0.1"></path>
                                        <path d="M798.34,516.37c-11.66,7-52.13.22-52.13.22l-11.22-40-12.54,40.69c-17.81,6.38-54.55-2.86-54.55-2.86l14.3-88,2.47-12.13L687,402.65l22.66,6.82s6.81,4.62,35.19,3.3,32.55-9,32.55-9c1.25.36,2.44,4.77,3.64,10.25,1.74,8,3.51,18.26,5.6,21.65C790.2,441.37,798.34,516.37,798.34,516.37Z" transform="translate(-92.22 -58.23)" class="fill-primary"></path>
                                        <path d="M781.08,414.88C755.78,428.77,734,428.39,734,428.39c-5.39.66-49.33-13.23-49.33-13.23L687,403.53l22.66,6.82s6.81,4.62,35.19,3.3,32.55-9,32.55-9C778.69,405,779.88,409.4,781.08,414.88Z" transform="translate(-92.22 -58.23)" opacity="0.1"></path>
                                        <path d="M777.44,403.75l-.66,7.92-53.11,7-15.73-4.84L687,402.65s1.24.07,3.45.16h0l19.2,5.78s6.81,4.62,35.19,3.3c22.29-1,29.65-6,31.78-8.09Z" transform="translate(-92.22 -58.23)" opacity="0.1"></path>
                                        <path d="M781.08,414C755.78,427.89,734,427.51,734,427.51c-5.39.66-49.33-13.23-49.33-13.23L687,402.65l22.66,6.82s6.81,4.62,35.19,3.3,32.55-9,32.55-9C778.69,404.11,779.88,408.52,781.08,414Z" transform="translate(-92.22 -58.23)" class="fill-primary"></path>
                                        <circle cx="646.07" cy="364.87" r="2.31" opacity="0.1"></circle>
                                        <circle cx="646.07" cy="363.99" r="2.31" fill="none" class="stroke-primary" stroke-miterlimit="10"></circle>
                                        <path d="M679.23,463.58s4.07,12.1,6.93,11.88S679.23,463.58,679.23,463.58Z" transform="translate(-92.22 -58.23)" opacity="0.1"></path>
                                        <path d="M676.59,475.46s2.53,7.26,5.17,8.47" transform="translate(-92.22 -58.23)" opacity="0.1"></path>
                                        <path d="M676.59,483.05s4,5.06,6.37,6.27" transform="translate(-92.22 -58.23)" opacity="0.1"></path>
                                        <path d="M784,437.3s3.74,5.61,0,6.82" transform="translate(-92.22 -58.23)" opacity="0.1"></path>
                                        <path d="M785.7,446.42c-4.34-5.15-1.66,7-1.66,7S786.81,447.74,785.7,446.42Z" transform="translate(-92.22 -58.23)" opacity="0.1"></path>
                                        <path d="M787.89,452.69s-6.6,9.79-5.28,10.89" transform="translate(-92.22 -58.23)" opacity="0.1"></path>
                                        <path d="M700.58,437.51c-8.09,0-16.53-3.66-17-3.88l.36-.81c.16.08,16.31,7.09,25.05,1.83,3.3-2,5.15-5.52,5.51-10.5l.88.07c-.38,5.28-2.38,9-5.94,11.18A17,17,0,0,1,700.58,437.51Z" transform="translate(-92.22 -58.23)" opacity="0.1"></path>
                                        <path d="M700.58,436.63c-8.09,0-16.53-3.66-17-3.88l.36-.8c.16.07,16.31,7.08,25.05,1.82,3.3-2,5.15-5.52,5.51-10.5l.88.07c-.38,5.28-2.38,9-5.94,11.18A17,17,0,0,1,700.58,436.63Z" transform="translate(-92.22 -58.23)" class="fill-primary"></path>
                                        <path d="M767,438.17a13.69,13.69,0,0,1-6-1.29c-6.56-3.16-7.62-10.9-7.67-11.23l.88-.11c0,.08,1.05,7.61,7.18,10.55,5.46,2.63,13.21,1,23-5l.45.75C777.87,436.06,771.9,438.17,767,438.17Z" transform="translate(-92.22 -58.23)" opacity="0.1"></path>
                                        <path d="M767,437.29a13.69,13.69,0,0,1-6-1.29c-6.56-3.16-7.62-10.9-7.67-11.23l.88-.11c0,.08,1.05,7.61,7.18,10.55,5.46,2.63,13.21,1,23-5l.45.75C777.87,435.18,771.9,437.29,767,437.29Z" transform="translate(-92.22 -58.23)" class="fill-primary"></path>
                                    </g>
                                    <path d="M503.34,404s11.35,15.85,19.06,14.31,8.47-3.23,15.32-14.31l5.62,12.93-6.62,16-7.84,10.15-16.62-2.61-5.38-18.16Z" transform="translate(-92.22 -58.23)" class="fill-primary"></path>
                                    <path d="M543.34,416.92l-6.62,16-7.84,10.15-16.62-2.61-5.38-18.16L503.34,404s1,1.38,2.56,3.28c3.81,4.55,11.06,12.11,16.5,11,7.6-1.52,8.45-3.19,15.05-13.86l.27-.45Z" transform="translate(-92.22 -58.23)" opacity="0.1"></path>
                                    <path d="M543.34,416.92l-6.62,16-7.84,10.15-16.62-2.61-5.38-18.16L503.34,404s1,1.38,2.56,3.28c2.48,8,7.81,20.83,16.5,20.72,9.81-.11,13.77-16.36,15.05-23.55l.27-.45Z" transform="translate(-92.22 -58.23)" opacity="0.1"></path>
                                    <path d="M497.34,403.53s-3.85-.46-1.85,4.31,5.69,20.46,3.85,23.69-.92,12-8.92,13.7l2.3,9.07s.46,20-.46,22.93-1.08,19.07-.77,20.76.16,12.77-1.07,13.24-2,5.84,2,6.76,21.07,1.39,24.15,2.31,24.92,0,24.92,0,9.23-1.23,11.54-2,2.77-2.61,2-6.15-4.31-29.23-3.54-32.46.93-34.77.93-34.77-6-2-6-7.85-2.31-21.54,2.46-31.38c0,0-3.85-2.64-4.46-2.17S538,402.3,538,402.3s-3,26.77-15.55,26.92-18.14-26.92-18.14-26.92S504.42,399.84,497.34,403.53Z" transform="translate(-92.22 -58.23)" class="fill-primary"></path>
                                    <path d="M515.49,489.38s2.59,6.31,6.91,7.23S515.49,489.38,515.49,489.38Z" transform="translate(-92.22 -58.23)" opacity="0.1"></path>
                                    <path d="M511.49,494.3s8.36,6.77,8,8.16" transform="translate(-92.22 -58.23)" opacity="0.1"></path>
                                    <path d="M494.72,454.3s6.62,4.46,6.62,7.69" transform="translate(-92.22 -58.23)" opacity="0.1"></path>
                                    <path d="M499.18,468.3s-1.84-6.46-3.07-7.84" transform="translate(-92.22 -58.23)" opacity="0.1"></path>
                                    <path d="M496.11,470.76s2.77,5.54,3.07,7.08" transform="translate(-92.22 -58.23)" opacity="0.1"></path>
                                    <path d="M549.8,459.53s-8.61,2.62-7.85,5.85" transform="translate(-92.22 -58.23)" opacity="0.1"></path>
                                    <path d="M541.91,489.38s11.28-13.08,7.89-12.77S541.91,489.38,541.91,489.38Z" transform="translate(-92.22 -58.23)" opacity="0.1"></path>
                                    <g opacity="0.1">
                                        <path d="M546.41,437.07c0-2.7-.49-7.5-.55-12.85-.06,6.14.55,11.82.55,14.85,0,5.72,5.73,7.75,6,7.84,0-1.25,0-2,0-2S546.41,442.92,546.41,437.07Z" transform="translate(-92.22 -58.23)"></path>
                                        <path d="M555,514.15a15.57,15.57,0,0,1,.27,1.59,10,10,0,0,0-.27-3.59c-.66-3-3.34-22.26-3.62-29.78C551.08,487.51,554.3,510.79,555,514.15Z" transform="translate(-92.22 -58.23)"></path>
                                        <path d="M491.35,494.2c0-5.49.31-13.06.91-15,.49-1.56.59-7.94.58-13.58,0,5.06-.15,10.2-.58,11.58C491.58,479.38,491.32,488.76,491.35,494.2Z" transform="translate(-92.22 -58.23)"></path>
                                        <path d="M497.34,405.53c7.07-3.69,6.92-1.23,6.92-1.23s5.54,27.08,18.14,26.92S538,404.3,538,404.3s5.85,1.69,6.46,1.22,2.66,1,3.79,1.72c.21-.53.43-1.05.68-1.55,0,0-3.85-2.64-4.47-2.17S538,402.3,538,402.3s-3,26.77-15.55,26.92-18.14-26.92-18.14-26.92.15-2.46-6.92,1.23c0,0-3.13-.36-2.26,3.09C495.63,405.33,497.34,405.53,497.34,405.53Z" transform="translate(-92.22 -58.23)"></path>
                                        <path d="M490.41,513.23c1-.37,1.27-7.22,1.21-11-.05,3.8-.4,8.69-1.21,9s-1.2,2-.89,3.63C489.68,514,490,513.37,490.41,513.23Z" transform="translate(-92.22 -58.23)"></path>
                                        <path d="M499.34,433.53a8.6,8.6,0,0,0,.47-4.11,5.27,5.27,0,0,1-.47,2.11c-1.85,3.23-.93,12-8.93,13.7l.48,1.88C498.37,445.17,497.53,436.7,499.34,433.53Z" transform="translate(-92.22 -58.23)"></path>
                                    </g>
                                    <path d="M543.78,591.64c-3.78,6.88-42.15,0-42.15,0l.1-.69.76-5.33h40.43l.77,5.32Z" transform="translate(-92.22 -58.23)" class="fill-primary"></path>
                                    <path d="M543.78,591.64c-3.78,6.88-42.15,0-42.15,0l.1-.69c1.84,0,29.6-.66,42,0Z" transform="translate(-92.22 -58.23)" opacity="0.1"></path>
                                    <path d="M501.63,591.64h0s-6.88,1.72-17.55,30.62-14.45,66.24-14.45,66.24-6,10.16,19.61,10.84c0,0-2.06,6.71,12.39,5.68S514,704,514,704s9.29-5.85,13.42-4.82,6.71,1.38,11.18,5.16,18.76,2.24,18.93-.68a27,27,0,0,0,0-4.31s21.85,1.38,17.72-14.45-7.57-41.81-7.57-41.81-11.18-50.75-23.92-51.44S501.63,591.64,501.63,591.64Z" transform="translate(-92.22 -58.23)" class="fill-primary"></path>
                                    <rect x="449.23" y="655.13" width="88.12" height="0.69" transform="translate(-296.91 1028.29) rotate(-84.73)" opacity="0.1"></rect>
                                    <rect x="467.99" y="657.45" width="92.39" height="0.69" transform="translate(-237.83 1111.17) rotate(-89.78)" opacity="0.1"></rect>
                                    <path d="M535.18,611.6" transform="translate(-92.22 -58.23)" fill="none" class="stroke-primary" stroke-miterlimit="10"></path>
                                    <rect x="536.56" y="611.56" width="0.69" height="92.8" transform="translate(-116.25 -37.87) rotate(-2.13)" opacity="0.1"></rect>
                                    <path d="M557.2,699.35C556,646.5,547,610.32,546.89,610l.67-.17c.09.36,9.14,36.61,10.33,89.55Z" transform="translate(-92.22 -58.23)" opacity="0.1"></path>
                                    <path d="M502.83,596.8s-1.2.69,0,4" transform="translate(-92.22 -58.23)" opacity="0.1"></path>
                                    <path d="M506.28,596.8s-3.27,2.06,0,5.51" transform="translate(-92.22 -58.23)" opacity="0.1"></path>
                                    <path d="M536.9,596.8s4.47,4.3,3.44,5.51" transform="translate(-92.22 -58.23)" opacity="0.1"></path>
                                    <path d="M540.5,595.77s.7,5.16,3.28,6.54" transform="translate(-92.22 -58.23)" opacity="0.1"></path>
                                    <g opacity="0.5">
                                        <path d="M723.12,587.52S740,580.8,747.3,589s-5,18.18-5,18.18l-5.16,10.3L725,616.15l-2.86-14.24Z" transform="translate(-92.22 -58.23)" class="fill-primary"></path>
                                        <path d="M742.3,607.13l-5.16,10.3L725,616.14l-2.86-14.23,1-14.39.27-.1c2.14-.79,16.59-5.83,23.5,1.11a5.35,5.35,0,0,1,.41.42C754.6,597.11,742.3,607.13,742.3,607.13Z" transform="translate(-92.22 -58.23)" opacity="0.1"></path>
                                        <path d="M742.3,607.13l-5.16,10.3L725,616.14l-2.86-14.23,1-14.39.27-.1c2.09,11.45,7.67,16.28,8.61,17l.14.1,3.43-.28c6.67-3.68,10.19-12.43,11.32-15.74a5.35,5.35,0,0,1,.41.42C754.6,597.11,742.3,607.13,742.3,607.13Z" transform="translate(-92.22 -58.23)" opacity="0.1"></path>
                                        <path d="M771.78,646.35s-3.72,47.38-2.71,53.1-2.15,6.15-2.15,6.15-13.46,3-16,1-6.87-2.39-6.87-2.39-10,2.29-14.46.58-11.88-1-11.88-1-5.72,3.44-7.3,2.72-3.58-.43-8.16-1.71-7.16-2.44-4.73-10.31.3-32.78.15-35.79-1.57-10.3-3.58-19,3.43-6.87,3.43-6.87c12.75-6.58,7.45-19.47,5.45-25.19s1.14-6,2.71-6,7.59-5.15,7.59-5.15l2.44-2.19,7.44-6.68C725,600.13,731,605.38,732,606.16l.14.11,3.43-.29c8.3-4.57,11.73-17,11.73-17,1,1.7,3.23,3.64,5.72,5.44a98,98,0,0,0,10.17,6.3c6,3.58,1.58,7.16,1.58,7.16-7.3,24.9,3,26,3,26C775.36,635,771.78,646.35,771.78,646.35Z" transform="translate(-92.22 -58.23)" class="fill-primary"></path>
                                        <path d="M715.53,601.69s-2.15,1.15-2.15,2.43" transform="translate(-92.22 -58.23)" opacity="0.1"></path>
                                        <path d="M716.82,604.12s-2.86,3-2.36,3.87" transform="translate(-92.22 -58.23)" opacity="0.1"></path>
                                        <path d="M716.82,608s-2.15,2.29-1.29,3.58" transform="translate(-92.22 -58.23)" opacity="0.1"></path>
                                        <path d="M731.14,607.88l-9,8.69c-.33-9.66-5-17.39-7.3-20.65l7.44-6.68C724.1,601.85,730.15,607.1,731.14,607.88Z" transform="translate(-92.22 -58.23)" opacity="0.1"></path>
                                        <path d="M732,606.16l-9,8.7c-.32-9.67-5-17.39-7.29-20.66l7.44-6.68C725,600.13,731,605.38,732,606.16Z" transform="translate(-92.22 -58.23)" class="fill-primary"></path>
                                        <path d="M753.88,596.11c-3.6,5.62-10.29,20.46-10.29,20.46l-7.16-8.87c8.3-4.58,11.73-17,11.73-17C749.16,592.36,751.39,594.3,753.88,596.11Z" transform="translate(-92.22 -58.23)" opacity="0.1"></path>
                                        <path d="M753,594.39c-3.59,5.63-10.29,20.47-10.29,20.47L735.57,606c8.3-4.57,11.73-17,11.73-17C748.3,590.65,750.53,592.59,753,594.39Z" transform="translate(-92.22 -58.23)" class="fill-primary"></path>
                                        <path d="M747.74,686.14s-1.53,13-2.41,13.74" transform="translate(-92.22 -58.23)" opacity="0.1"></path>
                                        <path d="M760.33,688.43s1.72,9.3,1,11.45" transform="translate(-92.22 -58.23)" opacity="0.1"></path>
                                        <path d="M723.69,689s-1.57,8.73,0,9.73" transform="translate(-92.22 -58.23)" opacity="0.1"></path>
                                        <path d="M714.4,687.71s-1.3,10.31-1,12.17" transform="translate(-92.22 -58.23)" opacity="0.1"></path>
                                        <path d="M762.48,637.47s-4,3.15-3.72,4" transform="translate(-92.22 -58.23)" opacity="0.1"></path>
                                        <path d="M765.34,639.48s-7.66,6.44-3.83,5.72S765.34,639.48,765.34,639.48Z" transform="translate(-92.22 -58.23)" opacity="0.1"></path>
                                    </g>
                                    <path d="M341,455l.05-.07-.09-.07h0l-.54-.36.11.08a1.79,1.79,0,0,0-2.36.52l-.22.31h0l-12.15,17.48L323.68,476c-6.41-1.93-16.82,6.19-22.09,10.85-.33.29-.64.56-.92.82-.42-.94-.67-1.54-.67-1.54-.26,2.86-10.36,7.15-12.72,8.71a8.5,8.5,0,0,1-3.52,1.18c.34-10.87-8.07-22.31-8.07-22.31l-20.55-26.15a23.08,23.08,0,0,1,2.1-13.87c.17-.34.34-.68.53-1h.1a22.74,22.74,0,0,0-1.29,6.83c.05,1.77,1.69,10.35,4,10a1.26,1.26,0,0,0,1.18-.56c1.84-2.14,2-5.78,1.91-9.15a18.75,18.75,0,0,1-.33,2.95c.15-2.8-.17-5.76-.17-7.87,0-.84,0-1.67.06-2.51l.25,0c0,.32,0,.66,0,1,0-.35,0-.69,0-1l.26,0a27.61,27.61,0,0,0,12.55-5.82,6.73,6.73,0,0,0,4.72-2.21,4.59,4.59,0,0,1-.89,4.28c2.75-.13,5.08-2.27,6.14-4.78a16.68,16.68,0,0,0,.78-8,55.59,55.59,0,0,1-.59-8.13,29.91,29.91,0,0,0,.24-4.43,8.54,8.54,0,0,0-.24-1.34h.08a2,2,0,0,0,1.43-.56c1.14-.88,1.51-2.6,1.8-3.92a33.38,33.38,0,0,0,1.06-9.31c-.06.95-.18,1.91-.32,2.86.25-3.6-.25-7.1-2.63-9.71-1.64-1.79-3.93-2.84-6.13-3.89a4.49,4.49,0,0,1-2-1.43,5.79,5.79,0,0,1-.62-2.48c-.77-5.26-5.72-8.92-10.65-11-6.34-2.76-14-3.94-20.05-.66-3,1.59-5.3,4.08-8,6.11-3.38,2.57-7.28,4.37-10.89,6.61s-7,5.08-8.77,8.94c-2.65,6-.66,12.8-.33,19.31.53,10.25-3.69,21-12.05,27a10.81,10.81,0,0,0-2.65,2.29,2.86,2.86,0,0,0-.22,3.27c.43.56,1.11.88,1.58,1.41.95,1.08.76,2.73.39,4.11a25.77,25.77,0,0,1-7,11.86c.15,1.06,1.46,1.48,2.53,1.64a58.25,58.25,0,0,0,8.55.62h1.23c-.13.33-.27.68-.41,1.05-1.55,4.08-3.56,10.36-2.89,14.2,1,6.06,4.2,33.77,2.62,38.63S214.65,549,214.65,549s.55,2.72,1.5,6.78c-2.47,5.82-5.29,12.28-6.7,14.87-2.84,5.19-1.44,31.69,8.35,43.47,0,0,4,5.72,3,7.79s.18,5.72.18,5.72l1.55,34.29a88.88,88.88,0,0,1-.72,10.48c-4.18,5.17-10.62,12.71-13.65,13.94-4.69,1.91-39.67,44.34-39.67,44.34s.28.51.83,1.34l-1,1.14-6.71,7.78-.53.61c-1.26-.24-9.65-1.76-16.3-2.24l-.66,0v-.12a24.88,24.88,0,0,0-7,.19,2.25,2.25,0,0,0-1.16.6c-2.27,2.78-3.49,46.42-3.49,46.42s2.42,21.85,10,23.07a4,4,0,0,0,1.2.22H144c5.4-.4,7.88-3.49,9-5.61a8.69,8.69,0,0,0,.75-2s-.88-3.89,1.48-9.26S162,778,162,778s8-8.41,6.57-12.49c.22-.33.48-.69.76-1.1,3-4.28,9.08-12.73,14-18.37.32-.38.64-.73,1-1.08a24.56,24.56,0,0,0,5.58,1.61s7.52-2.94,10.31-9.52c1.19-2.8,5.86-7.76,10.83-12.53l-.16,1.27-.17,41.74a29.83,29.83,0,0,0,5.14,2.83v1a134,134,0,0,1-1.08,17.79l-.15.93c-.62-.44-1.16-.59-1.5-.25-1.54,1.56-2.5,11.52-2.59,16.11,0,.15,0,.3,0,.46-.25,4.58-2.86,11.24,5,11.58,5.88.25,31.23.63,44.79.83a30.15,30.15,0,0,0,20-7.09c4.31-3.69,6.92-8.08,1.05-11.31-.36-.2-.74-.39-1.16-.58l-13-2-22.21-11.34s-.13-6.86-2.8-5.72a7.5,7.5,0,0,0-2.25.89c-.13-.25-.27-.52-.4-.8a25.55,25.55,0,0,1-2.74-11.56c0-.36,0-.73.05-1.1a22.09,22.09,0,0,0,1.84-1.89s-.17-15.59,1.58-18.53,7.17-32.74,7.17-32.74.17-5.54,3.67-8.83,2.27-12.82,2.27-12.82,4.9-2.6,6.47-11.08,6.65-27,6.65-27,10.49-27.37,9.8-44.68,1-26.33,1-26.33l2.18-40.24,0-.62c.87.66,1.46,1.2,1.46,1.2s0-.16,0-.44c.32.27.5.44.5.44s1.12-18.26.74-25.5c6.12-2.08,15.44-5.5,16-7.24.78-2.59,11.28-10.78,11.28-10.78a1.74,1.74,0,0,1-.64-.24c.33-.15.67-.33,1-.52,6.88-3.68,19.66-14.44,17.51-21l14-20.09A3.41,3.41,0,0,0,341,455Z" transform="translate(-92.22 -58.23)" fill="url(#dcaa3d52-8271-46b6-bbc0-03906cb73c47)"></path>
                                    <path d="M308.43,503.52a9.12,9.12,0,0,1-3.35,1.27c-4.37.13-8-11.7-8-11.7s1.24-1.26,3.22-3c5.86-5.21,18.15-14.83,23.91-9.45C330.71,486.65,316,499.45,308.43,503.52Z" transform="translate(-92.22 -58.23)" fill="#ecb4b6"></path>
                                    <path d="M242,785.65l-16.13,17.41s-14.92.17-12-8.06a30.09,30.09,0,0,0,1.24-5.48,134.65,134.65,0,0,0,1.05-17.62c0-3.86-.06-6.57-.06-6.57s23.49-10.29,21.09.43a20.15,20.15,0,0,0-.48,4.08,25.54,25.54,0,0,0,2.68,11.45A25.91,25.91,0,0,0,242,785.65Z" transform="translate(-92.22 -58.23)" fill="#ecb4b6"></path>
                                    <path d="M242,785.65l-16.13,17.41s-14.92.17-12-8.06a30.09,30.09,0,0,0,1.24-5.48c2.13,1.65,5.19,6.51,5.19,6.51s10.29,3,13.12-6c1.58-5,4.08-7.53,6-8.74A25.91,25.91,0,0,0,242,785.65Z" transform="translate(-92.22 -58.23)" opacity="0.1"></path>
                                    <path d="M279.42,811.87a29.34,29.34,0,0,1-19.64,7c-13.3-.19-38.15-.58-43.92-.82-7.72-.34-5.16-6.93-4.91-11.47,0-.16,0-.3,0-.45.09-4.55,1-14.41,2.54-15.95s6.81,6.86,6.81,6.86,10.29,3,13.12-6,8.58-9.87,8.58-9.87c2.61-1.13,2.74,5.66,2.74,5.66l21.78,11.23,12.78,2c.41.19.78.38,1.13.57C286.21,803.87,283.65,808.21,279.42,811.87Z" transform="translate(-92.22 -58.23)" fill="#c17174"></path>
                                    <circle cx="146.96" cy="735.39" r="0.94" fill="#fff" opacity="0.25"></circle>
                                    <circle cx="155.8" cy="739.77" r="0.94" fill="#fff" opacity="0.25"></circle>
                                    <circle cx="160.34" cy="741.8" r="0.94" fill="#fff" opacity="0.25"></circle>
                                    <circle cx="169.77" cy="745.42" r="0.94" fill="#fff" opacity="0.25"></circle>
                                    <circle cx="164.97" cy="743.88" r="0.94" fill="#fff" opacity="0.25"></circle>
                                    <path d="M279.42,811.87a29.34,29.34,0,0,1-19.64,7c-13.3-.19-38.15-.58-43.92-.82-7.72-.34-5.16-6.93-4.91-11.47l48.47,3s19.85-3,21-8.92C286.21,803.87,283.65,808.21,279.42,811.87Z" transform="translate(-92.22 -58.23)" fill="#c17174"></path>
                                    <path d="M279.42,811.87a29.34,29.34,0,0,1-19.64,7c-13.3-.19-38.15-.58-43.92-.82-7.72-.34-5.16-6.93-4.91-11.47l48.47,3s19.85-3,21-8.92C286.21,803.87,283.65,808.21,279.42,811.87Z" transform="translate(-92.22 -58.23)" fill="#fff" opacity="0.25"></path>
                                    <path d="M189.19,741.92a33.47,33.47,0,0,0-4.86,4.88c-4.81,5.58-10.76,14-13.71,18.18-1.14,1.64-1.83,2.67-1.83,2.67l-6.44-.95s-6.94-10.63-6.85-10.88S161,744.15,161,744.15l2.09-2.45,6.59-7.7,3-3.48S195,737.72,189.19,741.92Z" transform="translate(-92.22 -58.23)" fill="#ecb4b6"></path>
                                    <path d="M170.62,765c-1.14,1.64-1.83,2.67-1.83,2.67l-6.44-.95s-6.94-10.63-6.85-10.88S161,744.15,161,744.15l2.09-2.45.68.13h1.64c-5.75,6,.42,19.2.42,19.2S168.49,761.28,170.62,765Z" transform="translate(-92.22 -58.23)" opacity="0.1"></path>
                                    <path d="M163.43,778.44s-4.29,9.26-6.61,14.58-1.46,9.17-1.46,9.17a9,9,0,0,1-.73,2,10.1,10.1,0,0,1-8.78,5.56h-.42c-7.82-.2-10.3-22.9-10.3-22.9s1.2-43.21,3.43-46a2.14,2.14,0,0,1,1.13-.6,24,24,0,0,1,6.89-.19c7.07.51,16.16,2.25,16.16,2.25h1.63c-5.75,6,.42,19.21.42,19.21s2.75.25,4.89,4.11S163.43,778.44,163.43,778.44Z" transform="translate(-92.22 -58.23)" fill="#c17174"></path>
                                    <circle cx="61.77" cy="707.35" r="0.94" fill="#fff" opacity="0.25"></circle>
                                    <circle cx="61.3" cy="714.84" r="0.94" fill="#fff" opacity="0.25"></circle>
                                    <path d="M154,804a10.1,10.1,0,0,1-8.78,5.56h-.41c-7.82-.2-10.31-22.9-10.31-22.9s1.2-43.21,3.43-46a2.14,2.14,0,0,1,1.13-.6,24,24,0,0,1,6.89-.19c-.13,7.77-.5,32.32,0,34.76S150.88,797.49,154,804Z" transform="translate(-92.22 -58.23)" fill="#c17174"></path>
                                    <path d="M154,804a10.1,10.1,0,0,1-8.78,5.56h-.41c-7.82-.2-10.31-22.9-10.31-22.9s1.2-43.21,3.43-46a2.14,2.14,0,0,1,1.13-.6,24,24,0,0,1,6.89-.19c-.13,7.77-.5,32.32,0,34.76S150.88,797.49,154,804Z" transform="translate(-92.22 -58.23)" fill="#fff" opacity="0.25"></path>
                                    <path d="M144.8,809.58c-7.82-.2-10.31-22.9-10.31-22.9s1.2-43.21,3.43-46a2.14,2.14,0,0,1,1.13-.6c1.64,2.44,3.08,7.84,1.78,19.72-2.44,22.51.5,23.93.5,23.93S145,802.86,144.8,809.58Z" transform="translate(-92.22 -58.23)" fill="#c17174"></path>
                                    <path d="M144.8,809.58c-7.82-.2-10.31-22.9-10.31-22.9s1.2-43.21,3.43-46a2.14,2.14,0,0,1,1.13-.6c1.64,2.44,3.08,7.84,1.78,19.72-2.44,22.51.5,23.93.5,23.93S145,802.86,144.8,809.58Z" transform="translate(-92.22 -58.23)" opacity="0.1"></path>
                                    <path d="M308.43,503.52a9.12,9.12,0,0,1-3.35,1.27c-4.37.13-8-11.7-8-11.7s1.24-1.26,3.22-3C301.73,493.29,305.67,501.92,308.43,503.52Z" transform="translate(-92.22 -58.23)" opacity="0.1"></path>
                                    <path d="M280.39,499.26s3.6.26,5.91-1.28,12.22-5.79,12.48-8.62c0,0,5.91,14.4,9.26,14.92,0,0-10.29,8.1-11.06,10.67s-20.84,8.88-20.84,8.88Z" transform="translate(-92.22 -58.23)" fill="#ff748e"></path>
                                    <path d="M280.39,499.26s3.6.26,5.91-1.28,12.22-5.79,12.48-8.62c0,0,5.91,14.4,9.26,14.92,0,0-10.29,8.1-11.06,10.67s-20.84,8.88-20.84,8.88Z" transform="translate(-92.22 -58.23)" opacity="0.1"></path>
                                    <path d="M189.19,741.92a33.47,33.47,0,0,0-4.86,4.88c-7.76-3.25-12.76-9.89-14.66-12.8l3-3.48S195,737.72,189.19,741.92Z" transform="translate(-92.22 -58.23)" opacity="0.1"></path>
                                    <path d="M225.89,669s-12.58,16.81-17.18,18.7-38.89,43.9-38.89,43.9,7.37,13.55,20.92,15.77c0,0,7.37-2.91,10.12-9.43S225.21,713,225.21,713Z" transform="translate(-92.22 -58.23)" fill="#5e5a6b"></path>
                                    <path d="M225.89,669s-12.58,16.81-17.18,18.7-38.89,43.9-38.89,43.9,7.37,13.55,20.92,15.77c0,0,7.37-2.91,10.12-9.43S225.21,713,225.21,713Z" transform="translate(-92.22 -58.23)" opacity="0.1"></path>
                                    <path d="M187.78,725.25a54.84,54.84,0,0,0,11.45,0C206,724.6,200.9,728.72,187.78,725.25Z" transform="translate(-92.22 -58.23)" opacity="0.1"></path>
                                    <path d="M184.69,729.62s9,5.14,12.48,2.57S193.82,734.67,184.69,729.62Z" transform="translate(-92.22 -58.23)" opacity="0.1"></path>
                                    <path d="M237.21,765.76a20.15,20.15,0,0,0-.48,4.08c-6.95,6.31-15.32,4.36-20.55,2.06,0-3.86-.06-6.57-.06-6.57S239.61,755,237.21,765.76Z" transform="translate(-92.22 -58.23)" opacity="0.1"></path>
                                    <path d="M278.88,542.05l-.25,4.74-2.14,39.85s-1.72,8.92-1,26.06S265.85,657,265.85,657s-5,18.35-6.52,26.75-6.34,11-6.34,11,1.2,9.43-2.23,12.69-3.6,8.74-3.6,8.74-5.32,29.5-7,32.42-1.55,18.35-1.55,18.35c-11.14,13.2-27.43,1.2-27.43,1.2l.17-41.33s4.63-38.07,8.06-43.39,3.43-19.89,3.43-19.89l-1.53-34s-1.22-3.6-.17-5.66-2.93-7.71-2.93-7.71c-9.61-11.67-11-37.91-8.19-43s11.12-25.72,11.12-25.72l11.47-6.69,20.73.61Z" transform="translate(-92.22 -58.23)" fill="#5e5a6b"></path>
                                    <path d="M230.1,744.15s2.71,9.39,4.89,10.42S230.1,744.15,230.1,744.15Z" transform="translate(-92.22 -58.23)" opacity="0.1"></path>
                                    <path d="M233.83,712.9s7,5.54,10,5.53S233.83,712.9,233.83,712.9Z" transform="translate(-92.22 -58.23)" opacity="0.1"></path>
                                    <path d="M276.14,480.74v11.32l-7.47-3.22-7.45-3.21L245,469.68s-12.83-8.33-19.69-15.92c-3.92-4.33-5.89-8.42-2.44-10.58a21.5,21.5,0,0,0,4.49-3.93,73.82,73.82,0,0,0,8.94-13.2c.11-.19.22-.38.32-.57,3.34-6.13,5.55-11.36,5.55-11.36s9.4,3,15.44,7.28c.49.34.95.69,1.39,1.05,3.37,2.76,5.05,6,1.94,9.16a24,24,0,0,0-2.21,2.64h0a21.67,21.67,0,0,0-1.38,2.16c-.18.34-.36.67-.52,1a23.06,23.06,0,0,0-2.06,13.73Z" transform="translate(-92.22 -58.23)" fill="#ecb4b6"></path>
                                    <path d="M274.77,400c.39.68.93,1.26,1.29,1.95a9.37,9.37,0,0,1,.57,4.8,27.3,27.3,0,0,0,.5,7.66c.53,2.26,1.52,4.44,1.6,6.76.11,3.27-1.59,6.3-3.23,9.13a6.57,6.57,0,0,0,4.7-2.19,4.56,4.56,0,0,1-.86,4.23c2.69-.13,5-2.25,6-4.73a16.49,16.49,0,0,0,.77-8,54.6,54.6,0,0,1-.58-8.05,29.43,29.43,0,0,0,.23-4.39c-.25-2.91-2-5.44-3.76-7.8l-3.48-4.78a2.46,2.46,0,0,0-1-.91C274.23,392.28,273.85,398.34,274.77,400Z" transform="translate(-92.22 -58.23)" fill="#464353"></path>
                                    <path d="M261,431.61a24,24,0,0,0-2.21,2.64h0a21.67,21.67,0,0,0-1.38,2.16c-.18.34-.36.67-.52,1a27,27,0,0,1-20.21-10.92c-.11-.15-.22-.3-.32-.46.11-.19.22-.38.32-.57,3.34-6.13,5.55-11.36,5.55-11.36s9.4,3,15.44,7.28c.49.34.95.69,1.39,1.05C262.39,425.21,264.07,428.41,261,431.61Z" transform="translate(-92.22 -58.23)" opacity="0.1"></path>
                                    <path d="M285.38,409.44A27,27,0,0,1,263.27,436a27.31,27.31,0,0,1-4.9.44h-.12c-.29,0-.59,0-.88,0a27,27,0,1,1,28-27Z" transform="translate(-92.22 -58.23)" fill="#ecb4b6"></path>
                                    <path d="M261.91,476.2s13.6,7.67,10.12,1.2l-17.75-26.24h0l20.15,25.89s12.86,17.67,5.83,29.84c0,0-1,10.12.17,12.52s-.34,28-.34,28-4.81-4.46-7.38-3.61S252,546.17,252,546.17Z" transform="translate(-92.22 -58.23)" opacity="0.1"></path>
                                    <path d="M278.88,542.05l-.25,4.74c-1.63-1.18-3.9-2.5-5.41-2-2.57.86-20.74,2.41-20.74,2.41l.83-5.91Z" transform="translate(-92.22 -58.23)" opacity="0.1"></path>
                                    <path d="M262.42,476.2s13.61,7.67,10.12,1.2l-17.75-26.24h0l20.15,25.89s12.86,17.67,5.83,29.84c0,0-1,10.12.17,12.52s-.34,28-.34,28-4.8-4.46-7.37-3.61-20.75,2.41-20.75,2.41Z" transform="translate(-92.22 -58.23)" fill="#464353"></path>
                                    <path d="M269.69,489.35c-.79,8.25-4.18,18.06-4.18,18.06S263.11,531.76,260,539s-1.72,17.15-3.43,35.5c-.62,6.61-2.75,11.15-5.62,14.21-4.72,5-11.46,6.09-16.78,5.78l-1.26-.1c-8.58-.85-16.81-42.18-16.81-42.18s-3.94-35.16-2.4-40S212.18,480,211.15,474c-.66-3.81,1.31-10,2.83-14.06.89-2.34,1.62-4,1.62-4s2.92-9.26,7.72-14.06a7.08,7.08,0,0,1,5.09-2.14,12.73,12.73,0,0,1,6.35,2,1.77,1.77,0,0,1,.22.15s31.22,31.9,34.13,39.27C269.92,483.23,270,486.17,269.69,489.35Z" transform="translate(-92.22 -58.23)" opacity="0.1"></path>
                                    <path d="M268.67,488.84c-.8,8.24-4.19,18.05-4.19,18.05s-2.4,24.36-5.49,31.56-1.71,17.15-3.43,35.5c-.62,6.6-2.75,11.14-5.62,14.21-4.72,5-11.46,6.08-16.78,5.78l-1.26-.1c-8.58-.86-16.81-42.19-16.81-42.19s-3.94-35.15-2.4-39.95-1.54-32.24-2.57-38.25c-.66-3.8,1.31-10,2.83-14.06.89-2.34,1.62-3.95,1.62-3.95s2.92-9.26,7.72-14.06a7,7,0,0,1,5.09-2.13,12.52,12.52,0,0,1,6.35,2l.22.14s31.22,31.9,34.13,39.27C268.89,482.71,269,485.66,268.67,488.84Z" transform="translate(-92.22 -58.23)" fill="#ff748e"></path>
                                    <path d="M233.7,614.38s-7.08,6.3-9.52,6S233.7,614.38,233.7,614.38Z" transform="translate(-92.22 -58.23)" opacity="0.1"></path>
                                    <path d="M235.58,620.43s-7.46,3.46-9.69,4S232.7,619.54,235.58,620.43Z" transform="translate(-92.22 -58.23)" opacity="0.1"></path>
                                    <path d="M264.44,525.76s11.06.13,12.73,3.6S268,524.34,264.44,525.76Z" transform="translate(-92.22 -58.23)" opacity="0.1"></path>
                                    <path d="M262.89,531.8s8.49,1.8,11.06,3.86S262.89,531.8,262.89,531.8Z" transform="translate(-92.22 -58.23)" opacity="0.1"></path>
                                    <path d="M248.62,510.84s-1,34.85-4.82,39.36S248.62,510.84,248.62,510.84Z" transform="translate(-92.22 -58.23)" opacity="0.1"></path>
                                    <path d="M239.1,609.36S232,640.1,246.24,642s9.84-35,9.84-35Z" transform="translate(-92.22 -58.23)" opacity="0.1"></path>
                                    <path d="M238.58,608.85s-7.06,30.74,7.15,32.66,9.83-35,9.83-35Z" transform="translate(-92.22 -58.23)" fill="#ecb4b6"></path>
                                    <path d="M285.21,406.46a10.41,10.41,0,0,1-1-1.87c-1.89-3.94-6.75-2-10.31-.13L272,406.91a15.25,15.25,0,0,0-2.17,3.35,25.35,25.35,0,0,0-.91,3c-.49,1.74-1.21,3.4-1.86,5.1A59.29,59.29,0,0,0,263.27,436a27.31,27.31,0,0,1-4.9.44h-.12l0-.12c.18-.68.33-1.37.47-2.06h0a35.68,35.68,0,0,0,.27-11.8c0-.09,0-.17,0-.26-.13-.87-.3-1.75-.37-2.62-.33.6-.65,1.21-1,1.83-2.15,4-4.41,8-8.47,9.75a17.37,17.37,0,0,1-5.15,1.16,29.38,29.38,0,0,0-6.44,1.07,4,4,0,0,0-1.87,1.13,5.52,5.52,0,0,0-.94,2.82,22.73,22.73,0,0,1-1,3.91,34.28,34.28,0,0,1-8.4,12.52l-.93.9a17.41,17.41,0,0,1-5.56,3.85,17,17,0,0,1-5.89.88c.89-2.34,1.62-3.95,1.62-3.95s2.92-9.26,7.72-14.06a7,7,0,0,1,5.09-2.13,75.53,75.53,0,0,0,9.26-13.77,27,27,0,1,1,48.57-19Z" transform="translate(-92.22 -58.23)" opacity="0.1"></path>
                                    <path d="M286.93,385.39c-1.6-1.78-3.85-2.82-6-3.85a4.57,4.57,0,0,1-1.95-1.42,5.94,5.94,0,0,1-.6-2.45c-.75-5.22-5.61-8.83-10.44-10.95-6.22-2.73-13.69-3.9-19.66-.66-2.9,1.58-5.19,4.05-7.81,6.06-3.32,2.54-7.14,4.32-10.68,6.54s-6.92,5-8.6,8.86c-2.6,5.9-.65,12.67-.32,19.11.51,10.16-3.62,20.77-11.82,26.78a10.32,10.32,0,0,0-2.6,2.27,2.85,2.85,0,0,0-.21,3.23c.41.56,1.09.88,1.54,1.4.94,1.07.75,2.7.38,4.08a25.52,25.52,0,0,1-6.86,11.73c.14,1.06,1.42,1.47,2.47,1.63a56.1,56.1,0,0,0,8.39.61,14.1,14.1,0,0,0,11.73-4.73c5-4.7,9.23-10.57,10.36-17.33a5.71,5.71,0,0,1,.94-2.82,4.23,4.23,0,0,1,1.87-1.13c3.73-1.28,8-.65,11.59-2.23,4.68-2,7-7,9.45-11.58.08.87.24,1.75.38,2.63a35.56,35.56,0,0,1-.7,14.12c-.67,2.61-1.64,5.21-1.57,7.9.05,2,2.08,12.45,4.75,9.32s1.69-10.05,1.69-13.93a59.55,59.55,0,0,1,3.93-21.25c.64-1.69,1.37-3.36,1.86-5.1a27.33,27.33,0,0,1,.9-3,15.67,15.67,0,0,1,2.18-3.35l1.91-2.45c3.56-1.89,8.42-3.81,10.31.13.72,1.51,1.11,3.18,3,1.71,1.11-.87,1.47-2.58,1.76-3.88C289.69,395.94,290.67,389.53,286.93,385.39Z" transform="translate(-92.22 -58.23)" fill="#464353"></path>
                                    <path d="M250.74,479.8c-.73-18.47-26.58-22.29-32.61-4.82a2.53,2.53,0,0,0-.12.36c-3.95,11.83-2.23,41.79-2.23,41.79s.51,20.12,2.4,26.81,7.2,25.89,7.2,29,4.93,14.92,7,15.78,3.12,7.54,3.63,8.74,2,16.81,2,16.81,19.38-1.2,19.72-4.29-4.29-18.18-4.29-18.18-3.41-6.17-3.85-11.14S246.47,573.43,247,570s-1.55-5.14-1.55-7.37-1.54-8.23-1.54-8.23-3.26-2.58-2.74-5.66-4.63-9.26-3.26-11.49,1.71-7.72,1.71-7.72,1.72-24.69,2.92-31.38,8.23-17.49,8.23-17.49S250.76,480.35,250.74,479.8Z" transform="translate(-92.22 -58.23)" opacity="0.1"></path>
                                    <path d="M249.94,588.16c-4.72,5-11.46,6.08-16.78,5.78-.62-2.34-1.52-5.22-2.83-5.76-2.08-.86-7-12.69-7-15.77s-5.31-22.3-7.2-29-2.4-26.8-2.4-26.8-1.72-30,2.23-41.8c0-.11.07-.23.12-.35,6-17.48,31.88-13.65,32.61,4.82,0,.55,0,.85,0,.85s-7,10.8-8.23,17.49S237.56,529,237.56,529s-.35,5.49-1.72,7.72,3.77,8.41,3.26,11.49,2.74,5.66,2.74,5.66,1.54,6,1.54,8.24,2.06,3.94,1.55,7.37,2.23,5.66,2.67,10.63A27.72,27.72,0,0,0,249.94,588.16Z" transform="translate(-92.22 -58.23)" opacity="0.1"></path>
                                    <path d="M249.71,479.29c-.73-18.47-26.58-22.29-32.61-4.82l-.12.35c-3.95,11.84-2.23,41.8-2.23,41.8s.51,20.11,2.4,26.8,7.2,25.9,7.2,29,4.93,14.92,7,15.78,3.12,7.55,3.63,8.75,2,16.8,2,16.8,19.38-1.2,19.72-4.28-4.28-18.18-4.28-18.18-3.42-6.18-3.86-11.15-3.18-7.2-2.66-10.63-1.55-5.15-1.55-7.38-1.54-8.23-1.54-8.23-3.26-2.57-2.74-5.66-4.63-9.26-3.26-11.49,1.71-7.71,1.71-7.71,1.72-24.7,2.92-31.39,8.23-17.49,8.23-17.49S249.73,479.84,249.71,479.29Z" transform="translate(-92.22 -58.23)" fill="#ff748e"></path>
                                    <path d="M217.88,526.79c.51-.52,10.29-11.32,13.37-7.46S217.88,526.79,217.88,526.79Z" transform="translate(-92.22 -58.23)" opacity="0.1"></path>
                                    <path d="M218.78,535.15c.38-.39,9.77-.77,12.09-6S218.78,535.15,218.78,535.15Z" transform="translate(-92.22 -58.23)" opacity="0.1"></path>
                                    <g opacity="0.1">
                                        <path d="M208.08,440.31a2.65,2.65,0,0,1,.51.93,4,4,0,0,0-.51-3.5c-.46-.53-1.13-.84-1.55-1.4,0,0-.05-.09-.08-.14a2.65,2.65,0,0,0,.08,2.71C207,439.47,207.62,439.79,208.08,440.31Z" transform="translate(-92.22 -58.23)"></path>
                                        <path d="M221.17,407c0-1,0-2,0-2.92-.18-3.5-.83-7.09-1-10.6-.21,4.3.75,8.81,1,13.17C221.17,406.75,221.16,406.86,221.17,407Z" transform="translate(-92.22 -58.23)"></path>
                                        <path d="M261.25,449.94c-2.38,2.79-4.25-5.24-4.66-8.41a13.19,13.19,0,0,0-.09,1.66c.06,2,2.08,12.45,4.75,9.32,1.81-2.12,2-5.73,1.88-9.06C263,446,262.6,448.36,261.25,449.94Z" transform="translate(-92.22 -58.23)"></path>
                                        <path d="M258.77,421.17a34.41,34.41,0,0,1,.37,4.06,35.14,35.14,0,0,0-.37-6.64c-.13-.87-.3-1.75-.38-2.63-2.47,4.62-4.76,9.56-9.44,11.59-3.63,1.57-7.86.95-11.59,2.23a4,4,0,0,0-1.87,1.13,5.58,5.58,0,0,0-.94,2.82c-1.14,6.76-5.38,12.63-10.37,17.33a14.1,14.1,0,0,1-11.73,4.73,57.32,57.32,0,0,1-8.38-.61,6.33,6.33,0,0,1-1.26-.33c-.39.44-.8.86-1.22,1.27.14,1.06,1.43,1.47,2.48,1.63a56,56,0,0,0,8.38.61,14.1,14.1,0,0,0,11.73-4.73c5-4.7,9.23-10.57,10.37-17.33a5.61,5.61,0,0,1,.94-2.82,4.12,4.12,0,0,1,1.87-1.13c3.73-1.28,8-.65,11.59-2.23,4.68-2,7-7,9.44-11.58C258.47,419.41,258.64,420.29,258.77,421.17Z" transform="translate(-92.22 -58.23)"></path>
                                        <path d="M288.79,398.82c-.29,1.3-.66,3-1.77,3.88-1.88,1.46-2.26-.2-3-1.71-1.89-3.94-6.75-2-10.31-.13l-1.91,2.45a15.25,15.25,0,0,0-2.17,3.35,23.57,23.57,0,0,0-.9,3c-.5,1.74-1.22,3.4-1.87,5.09A59.85,59.85,0,0,0,262.94,436c0,.33,0,.69,0,1.06a59.7,59.7,0,0,1,3.91-19.73c.65-1.69,1.37-3.36,1.87-5.1a23.57,23.57,0,0,1,.9-3,15.25,15.25,0,0,1,2.17-3.35l1.91-2.45c3.56-1.89,8.42-3.81,10.31.13.73,1.51,1.11,3.18,3,1.71,1.11-.87,1.48-2.58,1.77-3.88a33.91,33.91,0,0,0,1-9.22A44.09,44.09,0,0,1,288.79,398.82Z" transform="translate(-92.22 -58.23)"></path>
                                    </g>
                                    <path d="M312.18,496.18l.53.36a2.12,2.12,0,0,1-.55-3L336,459a2.11,2.11,0,0,1,2.95-.54l-.53-.37a3.41,3.41,0,0,1,.87,4.74L316.92,495.3A3.42,3.42,0,0,1,312.18,496.18Z" transform="translate(-92.22 -58.23)" fill="#464353"></path>
                                    <path d="M325.63,453.79h.49a0,0,0,0,1,0,0v46.26a0,0,0,0,1,0,0h-.49a1.74,1.74,0,0,1-1.74-1.74V455.54a1.74,1.74,0,0,1,1.74-1.74Z" transform="translate(235.71 -158.44) rotate(34.56)" fill="#9f9eff"></path>
                                    <rect x="334.37" y="463.08" width="0.43" height="3.77" rx="0.17" ry="0.17" transform="translate(230.62 -165.99) rotate(34.56)" fill="#464353"></rect>
                                    <path d="M841.62,340.23A17.27,17.27,0,1,1,824.35,323,17.27,17.27,0,0,1,841.62,340.23Zm-19.27,9.14,12.82-12.81a1.12,1.12,0,0,0,0-1.57l-1.58-1.58a1.1,1.1,0,0,0-1.57,0l-10.45,10.45L816.69,339a1.13,1.13,0,0,0-1.58,0l-1.57,1.58a1.1,1.1,0,0,0,0,1.57l7.24,7.24a1.1,1.1,0,0,0,1.57,0Z" transform="translate(-92.22 -58.23)" fill="#3acc6c"></path>
                                    <path d="M632.41,529.77a17.27,17.27,0,1,1-17.27-17.27A17.27,17.27,0,0,1,632.41,529.77Zm-19.27,9.14L626,526.1a1.11,1.11,0,0,0,0-1.58L624.38,523a1.11,1.11,0,0,0-1.58,0L612.35,533.4l-4.88-4.88a1.1,1.1,0,0,0-1.57,0l-1.58,1.57a1.13,1.13,0,0,0,0,1.58l7.24,7.24a1.11,1.11,0,0,0,1.58,0Z" transform="translate(-92.22 -58.23)" fill="#3acc6c"></path>
                                    <path d="M632.41,718.43a17.27,17.27,0,1,1-17.27-17.27A17.27,17.27,0,0,1,632.41,718.43Zm-19.27,9.14L626,714.76a1.11,1.11,0,0,0,0-1.58l-1.57-1.57a1.11,1.11,0,0,0-1.58,0l-10.45,10.45-4.88-4.88a1.1,1.1,0,0,0-1.57,0l-1.58,1.57a1.13,1.13,0,0,0,0,1.58l7.24,7.24a1.11,1.11,0,0,0,1.58,0Z" transform="translate(-92.22 -58.23)" fill="#3acc6c"></path>
                                </svg>
                                <h4>{{__('Your cart is empty')}}.</h4>
                                <p>
                                    {{__('Your cart is currently empty. Return to our shop and check out the latest offers. 
                                            We have some great items that are waiting for you')}}.
                                </p>
                                <a href="{{ route('store.slug', $store->slug) }}" class="btn btn-transparent cart-btn">
                                    <i class="fas fa-angle-left"></i>
                                    {{__('Return to shop')}}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    @endif
@endsection

@push('script-page')
<script>
    $(document).on('click', '.product_qty', function (e) {
        e.preventDefault();
        var currEle = $(this);
        var product_id = $(this).siblings(".bx-cart-qty").attr('data-id');
        var arrkey = $(this).parents('tr').attr('data-id');
        var sum = 0;
        setTimeout(function () {
            if (currEle.hasClass('qty-minus') == true) {
                qty_id = currEle.next().val()
            } else {
                qty_id = currEle.prev().val();
            }
            
            if (qty_id == 0 || qty_id == '' || qty_id < 0) {
                location.reload();
                return false;
            }

            $.ajax({
                url: '{{route('user-product_qty.product_qty',['__product_id',$store->slug,'arrkeys'])}}'.replace('__product_id', product_id).replace('arrkeys', arrkey),
                type: "post",
                headers: {
                    'x-csrf-token': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    "product_qty": qty_id,
                },
                success: function (response) {
                    if (response.status == "Error") {
                        show_toastr('Error', response.error, 'error');
                        setTimeout(function () {
                            location.reload();
                        }, 1000);
                    } else {
                        $.each(response.product, function (key, value) {
                            if(value.variant_id != 0){
                                sum += value.variant_subtotal;
                                if(value.tax.length > 0){
                                    $.each(value.tax ,function(key, tv){
                                        var subtax = value.variant_price * value.quantity * tv.tax /100;
                                        $('#product-variant-id-' + value.variant_id + ' .variant_tax_'+key).text(tv.tax_name + ' ' + tv.tax + '% ' + '(' + subtax + ')');
                                    });
                                }
                                else{
                                    $('#product-variant-id-' + value.variant_id + ' .variant_tax').text('-');
                                }
                                $('#product-variant-id-' + value.variant_id + ' .subtotal').text(addCommas(value.variant_subtotal));
                            }
                            else{
                                sum += value.subtotal;
                                if(value.tax.length > 0){
                                    $.each(value.tax ,function(key, tv){
                                        var subtax = value.price * value.quantity * tv.tax /100;
                                        $('#product-id-' + value.id + ' .tax_'+key).text(tv.tax_name + ' ' + tv.tax + '% ' + '(' + subtax + ')');
                                    });
                                }
                                else{
                                    $('#product-id-' + value.id + ' .tax').text('-');
                                }
                                $('#product-id-' + value.id + ' .subtotal').text(addCommas(value.subtotal));
                            }
                        });
                        $('#displaytotal').text(addCommas(sum));
                    }
                },
                error: function (result) {
                    // console.log('error12');
                }
            });
        }, 100);
    })

    $(".product_qty_input").on('blur', function (e) {
        e.preventDefault();

        var product_id = $(this).attr('data-id');
        var arrkey = $(this).parents('div').attr('data-id');
        var qty_id = $(this).val();
        

        setTimeout(function () {
            if (qty_id == 0 || qty_id == '' || qty_id < 0) {
                location.reload();
                return false;
            }

            $.ajax({
                url: '{{route('user-product_qty.product_qty',['__product_id',$store->slug,'arrkeys'])}}'.replace('__product_id', product_id).replace('arrkeys', arrkey),
                type: "post",
                headers: {
                    'x-csrf-token': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    "product_qty": qty_id,
                },
                success: function (response) {
                    if (response.status == "Error") {
                        show_toastr('Error', response.error, 'error');
                        setTimeout(function () {
                        location.reload();
                        }, 1000);
                    } else {
                       location.reload(); // then reload the page
                    }
                },
                error: function (result) {
                    // console.log('error12');
                }
            });
        }, 500);
    });

    function qtyChange(product_id, arrkey, qty_id) {

    }

    $(document).on('click', '.qty-plus', function () {
          $(this).prev().val(+$(this).prev().val() );
        
    });

    $(document).on('click', '.qty-minus', function () {
        if ($(this).next().val() > 1) $(this).next().val(+$(this).next().val() );
    });
</script>
<script>
    var site_currency_symbol_position = '{{ \App\Models\Utility::getValByName('currency_symbol_position') }}';
    var site_currency_symbol = '{{ $store->currency }}';
</script>

@endpush