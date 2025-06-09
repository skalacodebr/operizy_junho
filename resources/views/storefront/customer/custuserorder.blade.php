@php
    $theme_name = $store ? $store->theme_dir : 'theme1';
@endphp
@extends('storefront.layout.' . $theme_name)

@section('page-title')
    {{__('Order Detail')}}
@endsection

@section('content')
<main>
    
    @include('storefront.' . $theme_name . '.common.common_banner_section')

    <section class="order-detail-sec pt pb">
        <div class="container">
            <div class="pending-btn text-right">
                @if($order->status == 'pending')
                    <a class="btn bg-soft-secondary">{{__('Pending')}}</a>
                @elseif($order->status == 'Cancel Order')
                    <a class="btn bg-soft-danger">{{__('Order Canceled')}}</a>
                @else
                    <a class="btn bg-soft-success">{{__('Delivered')}}</a>
                @endif    
            </div>
            <div class="row">
                <div class="col-lg-7 col-12">
                    <div class="row">
                        <div class="col-12">
                            <div class="order-detail-card">
                                <div class="detail-card-header">
                                    <h2>{{__('Items from Order')}} {{$order->order_id}}</h2>
                                </div>
                                <div class="order-detail-content">
                                    <div class="order-detail-list">
                                        <table class="order-detail-table">
                                            <thead>
                                                <tr>
                                                    <th scope="col">{{__('Item')}}</th>
                                                    <th scope="col">{{__('Quantity')}}</th>
                                                    <th scope="col">{{__('Price')}}</th>
                                                    <th scope="col">{{__('Total')}}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $sub_tax = 0;
                                                    $total = 0;
                                                @endphp
                                                @foreach($order_products as $key => $product)
                                                    @if($product->variant_id != 0)
                                                        <tr>
                                                            <td data-label="Item" class="detail-info">
                                                                <div class="pro-detail">
                                                                    <a href="{{ route('store.product.product_view', [$store->slug, $product->id]) }}" tabindex="0">
                                                                        <span>{{$product->product_name .' - ( '.$product->variant_name.' )'}}</span>
                                                                        @if(!empty($product->tax))
                                                                            @php
                                                                                $total_tax=0;
                                                                            @endphp
                                                                            @foreach($product->tax as $tax)
                                                                                @php
                                                                                    $sub_tax = ($product->variant_price* $product->quantity * $tax->tax) / 100;
                                                                                    $total_tax += $sub_tax;
                                                                                @endphp
                                                                                {{$tax->tax_name.' '.$tax->tax.'%'.' ('.$sub_tax.')'}}
                                                                            @endforeach
                                                                        @else
                                                                            @php
                                                                                $total_tax = 0
                                                                            @endphp
                                                                        @endif
                                                                    </a>
                                                                </div>
                                                            </td>
                                                            <td data-label="Quantity" class="product-detail-quantity">
                                                                <span>{{$product->quantity}}</span>
                                                            </td>
                                                            <td data-label="Price" class="product-detail-price">
                                                                <div class="price justify-center">
                                                                    <ins>{{App\Models\Utility::priceFormat($product->variant_price)}}</ins>
                                                                </div>
                                                            </td>
                                                            <td data-label="Total" class="product-detail-total">
                                                                <div class="price justify-center">
                                                                    <ins>{{App\Models\Utility::priceFormat($product->variant_price * $product->quantity + $total_tax)}}</ins>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @else
                                                        <tr>
                                                            <td data-label="Item" class="detail-info">
                                                                <div class="pro-detail">
                                                                    <a href="{{ route('store.product.product_view', [$store->slug, $product->id]) }}" tabindex="0">
                                                                        <span>{{$product->product_name}}</span>
                                                                        @if(!empty($product->tax))
                                                                            @php
                                                                                $total_tax=0;
                                                                            @endphp
                                                                            @foreach($product->tax as $tax)
                                                                                @php
                                                                                    $sub_tax = ($product->price* $product->quantity * $tax->tax) / 100;
                                                                                    $total_tax += $sub_tax;
                                                                                @endphp
                                                                                {{$tax->tax_name.' '.$tax->tax.'%'.' ('.$sub_tax.')'}}
                                                                            @endforeach
                                                                        @else
                                                                            @php
                                                                                $total_tax = 0
                                                                            @endphp
                                                                        @endif
                                                                    </a>
                                                                </div>
                                                            </td>
                                                            <td data-label="Quantity" class="product-detail-quantity">
                                                                <span>{{$product->quantity}}</span>
                                                            </td>
                                                            <td data-label="Price" class="product-detail-price">
                                                                <div class="price justify-center">
                                                                    <ins>{{App\Models\Utility::priceFormat($product->price)}}</ins>
                                                                </div>
                                                            </td>
                                                            <td data-label="Total" class="product-detail-total">
                                                                <div class="price justify-center">
                                                                    <ins>{{App\Models\Utility::priceFormat($product->price * $product->quantity + $total_tax)}}</ins>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endif
                                                    @if($order->status == 'delivered' && !empty($product->downloadable_prodcut))
                                                        <tr>
                                                            <td>
                                                            <div class="detail-bottom">
                                                                <button data-value="{{asset(Storage::url('uploads/downloadable_prodcut'.'/'.$product->downloadable_prodcut))}}" data-id="{{$order->id}}" class="btn cart-btn downloadable_prodcut">{{ __('Download') }}
                                                                    <i class="fas fa-shopping-basket"></i>
                                                                </button>
                                                        
                                                            </div>
                                                            </td>
                                                            <td>
                                                                <h6>{{__('Get your product from here')}}</h6>
                                                            </td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="order-payment-box">
                                        <ul>
                                            <li class="flex align-center justify-between">
                                                <span>{{__('Sub Total')}} :</span>
                                                <span>{{ App\Models\Utility::priceFormat($sub_total) }}</span>
                                            </li>
                                            <li class="flex align-center justify-between">
                                                <span>{{__('Estimated Tax')}} :</span>
                                                <span>{{ App\Models\Utility::priceFormat($final_taxs) }}</span>
                                            </li>
                                            @if(!empty($discount_price))
                                                <li class="flex align-center justify-between">
                                                    <span>{{ __('Apply Coupon') }} :</span>
                                                    <span>{{ $discount_price }}</span>
                                                </li>
                                            @endif
                                            @if(!empty($shipping_data))
                                                @if(!empty($discount_value))
                                                    <li class="flex align-center justify-between">
                                                        <span>{{__('Shipping Price')}} :</span>
                                                        <span>{{ App\Models\Utility::priceFormat($shipping_data->shipping_price) }}</span>
                                                    </li>
                                                    <li class="flex align-center justify-between">
                                                        <span>{{__('Grand Total')}} :</span>
                                                        <span>{{ \App\Models\Utility::priceFormat($order->price + $shipping_data->shipping_price) }}</span>
                                                    </li>
                                                @else
                                                    <li class="flex align-center justify-between">
                                                        <span>{{__('Shipping Price')}} :</span>
                                                        <span>{{ App\Models\Utility::priceFormat($shipping_data->shipping_price) }}</span>
                                                    </li>
                                                    <li class="flex align-center justify-between">
                                                        <span>{{__('Grand Total')}} :</span>
                                                        <span>{{ App\Models\Utility::priceFormat($sub_total + $shipping_data->shipping_price + $final_taxs) }}</span>
                                                    </li>
                                                @endif
                                            @elseif(!empty($discount_value))
                                                <li class="flex align-center justify-between">
                                                    <span>{{__('Grand Total')}} :</span>
                                                    <span>{{ App\Models\Utility::priceFormat($grand_total - $discount_value) }}</span>
                                                </li>
                                            @else
                                                <li class="flex align-center justify-between">
                                                    <span>{{__('Grand Total')}} :</span>
                                                    <span>{{ App\Models\Utility::priceFormat($grand_total) }}</span>
                                                </li>
                                            @endif
                                            <li class="flex align-center justify-between">
                                                <span>{{__('Payment Type')}} :</span>
                                                <span>{{ $order['payment_type'] }}</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if((!empty($store_payment_setting['custom_field_title_1']) && !empty($user_details->custom_field_title_1)) || 
                            (!empty($store_payment_setting['custom_field_title_2']) && !empty($user_details->custom_field_title_2)) || 
                            (!empty($store_payment_setting['custom_field_title_3']) && !empty($user_details->custom_field_title_3)) || 
                            (!empty($store_payment_setting['custom_field_title_4']) && !empty($user_details->custom_field_title_4)))
                            <div class="col-12">
                                <div class="order-detail-card">
                                    <div class="detail-card-header">
                                        <h2>{{__('Extra Information')}}</h2>
                                    </div>
                                    <div class="order-list-wrp">
                                        <ul>
                                            <li class="flex align-center justify-between">
                                                <span>{{ isset($store_payment_setting['custom_field_title_1']) ? $store_payment_setting['custom_field_title_1'] : '' }}</span>
                                                <span>{{ $user_details->custom_field_title_1 }}</span>
                                            </li>
                                            <li class="flex align-center justify-between">
                                                <span>{{ isset($store_payment_setting['custom_field_title_2']) ? $store_payment_setting['custom_field_title_2'] : '' }}</span>
                                                <span>{{ $user_details->custom_field_title_2 }}</span>
                                            </li>
                                            <li class="flex align-center justify-between">
                                                <span>{{ isset($store_payment_setting['custom_field_title_3']) ? $store_payment_setting['custom_field_title_3'] : '' }}</span>
                                                <span>{{ $user_details->custom_field_title_3 }}</span>
                                            </li>
                                            <li class="flex align-center justify-between">
                                                <span>{{ isset($store_payment_setting['custom_field_title_4']) ? $store_payment_setting['custom_field_title_4'] : '' }}</span>
                                                <span>{{ $user_details->custom_field_title_4 }}</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-lg-5 col-12">
                    <div class="row">
                        <div class="col-lg-12 col-md-6 col-12">
                            <div class="order-detail-card">
                                <div class="detail-card-header">
                                    <h2>{{__('Shipping Information')}}</h2>
                                </div>
                                <div class="order-list-wrp">
                                    <ul>
                                        <li class="flex align-center justify-between">
                                            <span>{{__('Company')}}</span>
                                            <span>{{ isset($user_details->shipping_address) ? $user_details->shipping_address : '' }}</span>
                                        </li>
                                        <li class="flex align-center justify-between">
                                            <span>{{__('City')}}</span>
                                            <span>{{ isset($user_details->shipping_city) ? $user_details->shipping_city : '' }}</span>
                                        </li>
                                        <li class="flex align-center justify-between">
                                            <span>{{__('Country')}}</span>
                                            <span>{{ isset($user_details->shipping_country) ? $user_details->shipping_country : '' }}</span>
                                        </li>
                                        <li class="flex align-center justify-between">
                                            <span>{{__('Postal Code')}}</span>
                                            <span>{{ isset($user_details->shipping_postalcode) ? $user_details->shipping_postalcode : '' }}</span>
                                        </li>
                                        <li class="flex align-center justify-between">
                                            <span>{{__('Phone')}}</span>
                                            <span>{{ isset($user_details->phone) ? $user_details->phone : '' }}</span>
                                        </li>
                                        @if(!empty($location_data && $shipping_data))
                                            <li class="flex align-center justify-between">
                                                <span>{{__('Location')}}</span>
                                                <span>{{$location_data->name}}</span>
                                            </li>
                                            <li class="flex align-center justify-between">
                                                <span>{{__('Shipping Method')}}</span>
                                                <span>{{$shipping_data->shipping_name}}</span>
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-6 col-12">
                            <div class="order-detail-card">
                                <div class="detail-card-header">
                                    <h2>{{__('Billing Information')}}</h2>
                                </div>
                                <div class="order-list-wrp">
                                    <ul>
                                        <li class="flex align-center justify-between">
                                            <span>{{__('Company')}}</span>
                                            <span>{{ isset($user_details->billing_address) ? $user_details->billing_address : '' }}</span>
                                        </li>
                                        <li class="flex align-center justify-between">
                                            <span>{{__('City')}}</span>
                                            <span>{{ isset($user_details->billing_city) ? $user_details->billing_city : '' }}</span>
                                        </li>
                                        <li class="flex align-center justify-between">
                                            <span>{{__('Country')}}</span>
                                            <span>{{ isset($user_details->billing_country) ? $user_details->billing_country : '' }}</span>
                                        </li>
                                        <li class="flex align-center justify-between">
                                            <span>{{__('Postal Code')}}</span>
                                            <span>{{ isset($user_details->billing_postalcode) ? $user_details->billing_postalcode : '' }}</span>
                                        </li>
                                        <li class="flex align-center justify-between">
                                            <span>{{__('Phone')}}</span>
                                            <span>{{ isset($user_details->phone) ? $user_details->phone : '' }}</span>
                                        </li>
                                        @if(!empty($location_data && $shipping_data))
                                            <li class="flex align-center justify-between">
                                                <span>{{__('Location')}}</span>
                                                <span>{{$location_data->name}}</span>
                                            </li>
                                            <li class="flex align-center justify-between">
                                                <span>{{__('Shipping Method')}}</span>
                                                <span>{{$shipping_data->shipping_name}}</span>
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
     <!-- wrapper end here -->
 </main>
@endsection
