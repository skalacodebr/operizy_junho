@php
    $theme_name = $store ? $store->theme_dir : 'theme1';
@endphp
@extends('storefront.layout.' . $theme_name)
@section('page-title')
    {{__('My Order')}}
@endsection

@section('content')
<main>
    
    @include('storefront.' . $theme_name . '.common.common_banner_section')

    <section class="order-main-sec pt pb">
        <div class="container">
            <div class="order-history-list">
                <table class="order-history-tbl">
                    <thead>
                        <tr>
                            <th scope="col">{{__('Order')}}</th>
                            <th scope="col">{{__('Date')}}</th>
                            <th scope="col">{{__('Value')}}</th>
                            <th scope="col">{{__('Payment Type')}}</th>
                            <th scope="col">{{__('Status')}}</th>
                            <th scope="col">{{__('Action')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(!empty($orders) && count($orders) > 0)
                            @foreach($orders as $order)
                                <tr>
                                    <td data-label="Order" class="order-info">
                                        <div class="order-number">
                                            <a href="{{route('customer.order',[$store->slug,Crypt::encrypt($order->id)])}}" class="">
                                                {{'#'.$order->order_id}}
                                            </a>
                                        </div>
                                    </td>
                                    <td data-label="Date" class="order-date">
                                        {{\App\Models\Utility::dateFormat($order->created_at)}}
                                    </td>
                                    <td data-label="Value" class="order-price">
                                        <div class="price">
                                            @php
                                                if (!empty($order->shipping_data)) {
                                                    $shipping_data = json_decode($order->shipping_data);
                                                } else {
                                                    $shipping_data = '';
                                                }
                                            @endphp
                                            @if(!empty($shipping_data))
                                                <ins>{{\App\Models\Utility::priceFormat($order->price + $shipping_data->shipping_price)}}</ins>
                                            @else
                                                <ins>{{\App\Models\Utility::priceFormat($order->price)}}</ins>
                                            @endif
                                        </div>
                                    </td>
                                    <td data-label="Payment Type" class="order-payment">
                                        <div>{{$order->payment_type}}</div>
                                    </td>
                                    <td data-label="Status" class="oder-status">
                                        @if ($order->status != 'Cancel Order')
                                            <a href="javascript:;" class="btn {{ $order->status == 'pending' ? 'bg-soft-secondary' : 'bg-soft-success' }}">
                                                @if ($order->status == 'pending')
                                                    <i class="fas fa-check soft-success"></i>
                                                @else
                                                    <i class="fa fa-check-double soft-success"></i>
                                                @endif
                                                
                                                @if ($order->status == 'pending')
                                                    {{ __('Pending') }}:
                                                    {{ \App\Models\Utility::dateFormat($order->created_at) }}
                                                @else
                                                    {{ __('Delivered') }}:
                                                    {{ \App\Models\Utility::dateFormat($order->updated_at) }}
                                                @endif
                                            </a>
                                        @else
                                            <a href="javascript:;" class="btn bg-soft-danger">
                                                @if ($order->status == 'pending')
                                                    <i class="fas fa-check soft-success"></i>
                                                @else
                                                    <i class="fa fa-check-double soft-success"></i>
                                                @endif
                                                {{ __('Cancel') }}:
                                                {{ \App\Models\Utility::dateFormat($order->created_at) }}
                                            </a>
                                        @endif
                                    </td>
                                    <td data-label="Action" class="order-view">
                                        <a href="{{route('customer.order',[$store->slug,Crypt::encrypt($order->id)])}}" class="order-view-btn" data-toggle="tooltip" data-title="{{__('Details')}}">
                                            <svg width="45" height="45" viewBox="0 0 45 45" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M22.5001 29.4318C26.3262 29.4318 29.4279 26.3301 29.4279 22.504C29.4279 18.6779 26.3262 15.5762 22.5001 15.5762C18.674 15.5762 15.5723 18.6779 15.5723 22.504C15.5723 26.3301 18.674 29.4318 22.5001 29.4318Z" fill="#2F96D6"/>
                                                <path d="M44.3098 20.5845C38.9845 14.1494 30.9236 7.95508 22.5001 7.95508C14.075 7.95508 6.0121 14.1538 0.690402 20.5845C-0.230134 21.6964 -0.230134 23.3106 0.690402 24.4225C2.02834 26.0393 4.83325 29.1603 8.57947 31.8873C18.0142 38.7555 26.9652 38.7707 36.4207 31.8873C40.1669 29.1603 42.9718 26.0393 44.3098 24.4225C45.2276 23.3128 45.2324 21.7001 44.3098 20.5845ZM22.5001 12.8046C27.8484 12.8046 32.1991 17.1552 32.1991 22.5035C32.1991 27.8518 27.8484 32.2025 22.5001 32.2025C17.1518 32.2025 12.8011 27.8518 12.8011 22.5035C12.8011 17.1552 17.1518 12.8046 22.5001 12.8046Z" fill="#2F96D6"/>
                                            </svg>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="6">
                                    <div class="text-center">
                                        <i class="fas fa-folder-open text-gray" style="font-size: 48px;"></i>
                                        <h2>{{ __('Opps...') }}</h2>
                                        <h6> {!! __('No data Found.') !!} </h6>
                                    </div>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</main>

@endsection

