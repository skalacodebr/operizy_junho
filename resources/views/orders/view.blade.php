@extends('layouts.admin')
@section('page-title')
    {{ __('Order') }}
@endsection
@section('title')
    <div class="d-inline-block">
        <h5 class="h4 d-inline-block text-white font-weight-bold mb-0 ">{{ __('Orders') }}</h5>
    </div>
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Home') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('orders.index') }}">{{ __('Orders') }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('Order') }} {{ $order->order_id }} </li>
@endsection
@push('css')
    <style>

    </style>
@endpush
@section('action-btn')
    <div class="pr-2 d-flex align-items-center gap-2 rating-btn-wrapper">
        <a href="#" id="{{ env('APP_URL') .'/' . $store->slug . '/order/' . $order_id }}" class="btn btn-sm btn-primary btn-icon"  onclick="copyToClipboard(this)" title="{{__('Click to copy')}}" data-bs-toggle="tooltip" data-original-title="{{__('Click to copy')}}"><i class="ti ti-link text-white"></i></a>

        <a href="{{ route('order.receipt', $order->id) }}" class="btn btn-sm btn-primary btn-icon"
            data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('Receipt') }}"><i class="ti ti-receipt"></i></a>

        {{-- <a href="#" onclick="saveAsPDF();" id="download-buttons" class="btn btn-sm btn-primary btn-icon"
            data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('Print') }}"><i class="ti ti-printer"></i></a> --}}

        <a href="{{ route('invoice.pdf', \Crypt::encrypt($order->id)) }}" target="_blank"
            id="download-buttons" class="btn btn-sm btn-primary btn-icon"
            data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('Print') }}"><i class="ti ti-printer"></i></a>

        <div class="btn-group " id="deliver_btn">
            <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-haspopup="true"
                aria-expanded="false">{{ __('Status') }} : {{ __(ucfirst($order->status)) }}</button>
            <div class="dropdown-menu">
                <h6 class="dropdown-header">{{ __('Set order status') }}</h6>
                <a class="dropdown-item" href="#" id="delivered" data-value="delivered">
                    @if ($order->status == 'pending' || $order->status == 'Cancel Order')
                        <i class="fa fa-check text-primary"></i>
                    @else
                        <i class="fa fa-check-double text-primary"></i>
                    @endif
                    {{ __('Delivered') }}
                </a>
                <a class="dropdown-item text-danger" href="#" id="delivered" data-value="Cancel Order">
                    @if ($order->status != 'Cancel Order')
                        <i class="fa fa-check text-primary"></i>
                    @else
                        <i class="fa fa-check-double text-danger"></i>
                    @endif
                    {{ __('Cancel Order') }}
                </a>
            </div>
        </div>
    </div>
@endsection
@section('filter')
@endsection
@section('content')
    <div class="row">
        <!-- [ sample-page ] start -->
        <div class="col-sm-12">
            <div class="row" id="printableArea">
                <div class="col-xxl-7">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <h5 class="mb-0">{{ __('Order') }} {{ $order->order_id }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>{{ __('Item') }}</th>
                                            <th>{{ __('Quantity') }}</th>
                                            <th>{{ __('Price') }}</th>
                                            <th>{{ __('Total') }}</th>
                                            <th>{{ __('Action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $sub_tax = 0;
                                            $total = 0;
                                            $order_id = trim($order->order_id,'#');
                                        @endphp
                                        @foreach ($order_products as $key => $product)
                                            @if (isset($product->variant_id) && $product->variant_id != 0)
                                                <tr>
                                                    <td class="total">
                                                        <span class="h6 text-sm">
                                                            @if (isset($product->product_name))
                                                                <a
                                                                    href="{{ route('product.show', $product->id) }}">{{ $product->product_name . ' - ( ' . $product->variant_name . ' )' }}</a>
                                                            @else
                                                                <a href="{{ route('product.show', $product->id) }}">
                                                                    {{ $product->name }}
                                                                </a>
                                                            @endif
                                                        </span>
                                                        @if (!empty($product->tax))
                                                            @php
                                                                $total_tax = 0;
                                                            @endphp
                                                            @foreach ($product->tax as $tax)
                                                                @php
                                                                    $sub_tax = ($product->variant_price * $product->quantity * $tax->tax) / 100;
                                                                    $total_tax += $sub_tax;
                                                                @endphp
                                                                {{ $tax->tax_name . ' ' . $tax->tax . '%' . ' (' . $sub_tax . ')' }}
                                                            @endforeach
                                                        @else
                                                            @php
                                                                $total_tax = 0;
                                                            @endphp
                                                        @endif
                                                    </td>
                                                    <td>
                                                        {{ $product->quantity }}
                                                    </td>
                                                    <td>
                                                        {{ App\Models\Utility::priceFormat($product->variant_price) }}
                                                    </td>
                                                    <td>
                                                        {{ App\Models\Utility::priceFormat($product->variant_price * $product->quantity + $total_tax) }}
                                                    </td>
                                                    <td class="d-flex action-btn-wrapper">
                                                        @can('Delete Orders')
                                                            <div class="action-btn bg-danger me-2">
                                                                {!! Form::open(['method' => 'DELETE',
                                                                'route' => ['delete.order_item', $product->id , $product->variant_id,$order_id,$key],]) !!}
                                                                <a class="show_confirm align-items-center bg-danger text-white btn btn-sm d-inline-flex" data-bs-toggle="tooltip" data-bs-placement="top" title="{{__('Delete')}}">
                                                                <span><i class="ti ti-trash"></i></span>
                                                                </a>
                                                                {!! Form::close() !!}
                                                            </div>
                                                        @endcan
                                                    </td>
                                                </tr>
                                            @else
                                                <tr>
                                                    <td class="total">
                                                        <span class="h6 text-sm">

                                                            @if (isset($product->product_name))
                                                                <a href="{{ route('product.show', $product->id) }}">{{ $product->product_name }}
                                                                </a>
                                                            @else
                                                                <a href="{{ route('product.show', $product->id) }}">
                                                                    {{ $product->name }}
                                                                </a>
                                                            @endif
                                                        </span>
                                                        @if (!empty($product->tax))
                                                            @php
                                                                $total_tax = 0;
                                                            @endphp
                                                            @foreach ($product->tax as $tax)
                                                                @php
                                                                    $sub_tax = ($product->price * $product->quantity * $tax->tax) / 100;
                                                                    $total_tax += $sub_tax;
                                                                @endphp
                                                                {{ $tax->tax_name . ' ' . $tax->tax . '%' . ' (' . $sub_tax . ')' }}
                                                            @endforeach
                                                        @else
                                                            @php
                                                                $total_tax = 0;
                                                            @endphp
                                                        @endif
                                                    </td>
                                                    <td>
                                                        {{ $product->quantity }}
                                                    </td>
                                                    <td>
                                                        {{ App\Models\Utility::priceFormat($product->price) }}
                                                    </td>
                                                    <td>
                                                        {{ App\Models\Utility::priceFormat($product->price * $product->quantity + $total_tax) }}
                                                    </td>
                                                    <td>
                                                        <div class="action-btn-wrapper d-flex">

                                                            @can('Delete Orders')
                                                            <div class="action-btn bg-danger me-2">
                                                                {!! Form::open(['method' => 'DELETE',
                                                                'route' => ['delete.order_item', $product->id , $product->variant_id,$order_id,$key],]) !!}
                                                                <a class="show_confirm align-items-center btn btn-sm bg-danger text-white d-inline-flex" data-bs-toggle="tooltip" data-bs-placement="top" title="{{__('Delete')}}">
                                                                    <span ><i class="ti ti-trash"></i></span>
                                                                </a>
                                                                {!! Form::close() !!}
                                                            </div>
                                                            @endcan
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-12 col-lg-6 ">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between">
                                    <h5 class="">{{ __('Shipping Information') }}</h5>
                                </div>
                                <div class="card-body pt-0">
                                    <address class="mb-0 text-sm">
                                        <dl class="row mt-4 align-items-center">
                                            <dt class="col-sm-4 h6 text-sm">{{ __('Name') }}</dt>
                                            <dd class="col-sm-8 text-sm me-0"> {{ !empty($user_details->name) ? $user_details->name : 'Walk-in Customer' }}</dd>
                                            <dt class="col-sm-4 h6 text-sm">{{ __('Company') }}</dt>
                                            <dd class="col-sm-8 text-sm me-0"> {{ !empty($user_details->shipping_address) ? $user_details->shipping_address  : '-' }}</dd>
                                            <dt class="col-sm-4 h6 text-sm">{{ __('City') }}</dt>
                                            <dd class="col-sm-8 text-sm me-0">{{ !empty($user_details->shipping_city) ? $user_details->shipping_city : '-' }}</dd>
                                            <dt class="col-sm-4 h6 text-sm">{{ __('Country') }}</dt>
                                            <dd class="col-sm-8 text-sm me-0"> {{ !empty($user_details->shipping_country) ? $user_details->shipping_country : '-' }}</dd>
                                            <dt class="col-sm-4 h6 text-sm">{{ __('Postal Code') }}</dt>
                                            <dd class="col-sm-8 text-sm me-0">{{ !empty($user_details->shipping_postalcode) ? $user_details->shipping_postalcode : '-' }}</dd>
                                            <dt class="col-sm-4 h6 text-sm">{{ __('Phone') }}</dt>
                                            <dd class="col-sm-8 text-sm me-0">
												@if(!empty($user_details->phone))
                                                <a href="{{ $url = 'https://wa.me/send?phone=' . str_replace(' ', '', $user_details->phone) . '&text=Hi' }}"
                                                    target="_blank">
                                                    {{ !empty($user_details->phone) ? $user_details->phone : '' }}
                                                </a>
                                                @else
                                                -
												@endif
                                            </dd>
                                            @if (!empty($location_data && $shipping_data))
                                                <dt class="col-sm-4 h6 text-sm">{{ __('Location') }}</dt>
                                                <dd class="col-sm-8 text-sm me-0">{{ $location_data->name }}</dd>
                                                <dt class="col-sm-4 h6 text-sm">{{ __('Shipping Method') }}</dt>
                                                <dd class="col-sm-8 text-sm me-0">{{ $shipping_data->shipping_name }}</dd>
                                            @endif
                                        </dl>
                                    </address>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 col-sm-12 col-lg-6 ">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between">
                                    <h5 class="">{{ __('Billing Information') }}</h5>
                                </div>
                                <div class="card-body pt-0">
                                    <dl class="row mt-4 align-items-center">
                                        <dt class="col-sm-4 h6 text-sm">{{ __('Name') }}</dt>
                                        <dd class="col-sm-8 text-sm me-0"> {{ !empty($user_details->name) ? $user_details->name : 'Walk-in Customer' }}</dd>
                                        <dt class="col-sm-4 h6 text-sm">{{ __('Company') }}</dt>
                                        <dd class="col-sm-8 text-sm me-0"> {{ !empty($user_details->billing_address) ? $user_details->billing_address  : '-' }}</dd>
                                        <dt class="col-sm-4 h6 text-sm">{{ __('City') }}</dt>
                                        <dd class="col-sm-8 text-sm me-0">{{ !empty($user_details->billing_city) ? $user_details->billing_city : '-' }}</dd>
                                        <dt class="col-sm-4 h6 text-sm">{{ __('Country') }}</dt>
                                        <dd class="col-sm-8 text-sm me-0"> {{ !empty($user_details->billing_country) ? $user_details->billing_country : '-' }}</dd>
                                        <dt class="col-sm-4 h6 text-sm">{{ __('Postal Code') }}</dt>
                                        <dd class="col-sm-8 text-sm me-0">{{ !empty($user_details->billing_postalcode) ? $user_details->billing_postalcode : '-' }}</dd>
                                        <dt class="col-sm-4 h6 text-sm">{{ __('Phone') }}</dt>
                                        <dd class="col-sm-8 text-sm me-0">
											@if(!empty($user_details->phone))
                                            <a href="{{ $url = 'https://wa.me/send?phone=' . str_replace(' ', '', $user_details->phone) . '&text=Hi' }}"
                                                target="_blank">
                                                {{ $user_details->phone }}
                                            </a>
                                            @else
                                            -
											@endif
                                        </dd>
                                        @if (!empty($location_data && $shipping_data))
                                            <dt class="col-sm-4 h6 text-sm">{{ __('Location') }}</dt>
                                            <dd class="col-sm-8 text-sm me-0">{{ $location_data->name }}</dd>
                                            <dt class="col-sm-4 h6 text-sm">{{ __('Shipping Method') }}</dt>
                                            <dd class="col-sm-8 text-sm me-0">{{ $shipping_data->shipping_name }}</dd>
                                        @endif
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-5">
                    <div class="card  p-0">
                        <div class="card-header d-flex justify-content-between pb-0">
                            <h5 class="mb-4">{{ __('Order') }} {{ $order->order_id }}</h5>
                        </div>
                        <div class="card-body ">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>{{ __('Sub Total') }} :</td>
                                            <td>{{ App\Models\Utility::priceFormat($sub_total) }}</td>
                                        </tr>
                                        <tr>
                                            <td>{{ __('Estimated Tax') }} :</td>
                                            <td>{{ App\Models\Utility::priceFormat($total_taxs) }}</td>
                                        </tr>
                                        @if (!empty($discount_price))
                                            <tr>
                                                <td>{{ __('Apply Coupon') }} :</td>
                                                <td>
                                                    @if($order->payment_type == 'POS')
                                                        {{ App\Models\Utility::priceFormat($discount_price) }}
                                                    @else
                                                        {{ $discount_price }}
                                                    @endif
                                                </td>
                                            </tr>
                                        @endif
                                        @if (!empty($shipping_data))
                                            @if (!empty($discount_value))
                                                <tr>
                                                    <td>{{ __('Shipping Price') }} :</td>
                                                    <td>{{ App\Models\Utility::priceFormat($shipping_data->shipping_price) }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>{{ __('Grand Total') }} :</td>
                                                    <td>{{ App\Models\Utility::priceFormat($grand_total + $shipping_data->shipping_price - $discount_value) }}
                                                    </td>
                                                </tr>
                                            @else
                                                <tr>
                                                    <td>{{ __('Shipping Price') }} :</td>
                                                    <td>{{ App\Models\Utility::priceFormat($shipping_data->shipping_price) }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>{{ __('Grand Total') }} :</td>
                                                    <td>{{ App\Models\Utility::priceFormat($sub_total + $shipping_data->shipping_price + $total_taxs) }}
                                                    </td>
                                                </tr>
                                            @endif
                                        @elseif(!empty($discount_value))
                                            <tr>
                                                <td>{{ __('Grand  Total') }} :</td>
                                                <td>{{ App\Models\Utility::priceFormat($grand_total - $discount_value) }}
                                                </td>
                                            </tr>
                                        @else
                                            <tr>
                                                <td>{{ __('Grand  Total') }} :</td>
                                                <td>
                                                    @if($order->payment_type == 'POS')
                                                        @php
                                                            $discount = !empty($discount_price) ? $discount_price : 0;
                                                        @endphp
                                                        {{ App\Models\Utility::priceFormat($grand_total - $discount) }}
                                                    @else
                                                        {{ App\Models\Utility::priceFormat($grand_total) }}
                                                    @endif
                                                </td>
                                            </tr>
                                        @endif
                                        <td>{{ __('Payment Type') }} :</td>
                                        <td>{{ $order['payment_type'] }}</td>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    @if((!empty($store_payment_setting['custom_field_title_1']) && !empty($user_details->custom_field_title_1)) ||
                        (!empty($store_payment_setting['custom_field_title_2']) && !empty($user_details->custom_field_title_2)) ||
                        (!empty($store_payment_setting['custom_field_title_3']) && !empty($user_details->custom_field_title_3)) ||
                        (!empty($store_payment_setting['custom_field_title_4']) && !empty($user_details->custom_field_title_4)))
                        <div class="card">
                            <div class="card-header d-flex justify-content-between">
                                <h5 class="">{{ __('Extra Information') }}</h5>
                            </div>
                            <div class="card-body pt-0">
                                <dl class="row mt-4 align-items-center">
                                    <dt class="col-sm-4 h6 text-sm">{{isset($store_payment_setting['custom_field_title_1']) ? $store_payment_setting['custom_field_title_1'] : ''}}</dt>
                                    <dd class="col-sm-8 text-sm me-0"> {{ !empty($user_details->custom_field_title_1) ? $user_details->custom_field_title_1 : '' }}</dd>
                                    <dt class="col-sm-4 h6 text-sm">{{isset($store_payment_setting['custom_field_title_2']) ? $store_payment_setting['custom_field_title_2'] : ''}}</dt>
                                    <dd class="col-sm-8 text-sm me-0"> {{ !empty($user_details->custom_field_title_2) ? $user_details->custom_field_title_2  : '' }}</dd>
                                    <dt class="col-sm-4 h6 text-sm">{{isset($store_payment_setting['custom_field_title_3']) ? $store_payment_setting['custom_field_title_3'] : ''}}</dt>
                                    <dd class="col-sm-8 text-sm me-0">{{ !empty($user_details->custom_field_title_3) ? $user_details->custom_field_title_3 : '' }}</dd>
                                    <dt class="col-sm-4 h6 text-sm">{{isset($store_payment_setting['custom_field_title_4']) ? $store_payment_setting['custom_field_title_4'] : ''}}</dt>
                                    <dd class="col-sm-8 text-sm me-0"> {{ !empty($user_details->custom_field_title_4) ? $user_details->custom_field_title_4 : '' }}</dd>
                                </dl>
                            </div>
                        </div>
                    @endif

                </div>
            </div>

        </div>
        <!-- [ sample-page ] end -->
    </div>
@endsection
@push('script-page')
    <script type="text/javascript" src="{{ asset('custom/js/html2pdf.bundle.min.js') }}"></script>
    <script>


        function copyToClipboard(element) {

            var copyText = element.id;
            document.addEventListener('copy', function (e) {
                e.clipboardData.setData('text/plain', copyText);
                e.preventDefault();
            }, true);

            document.execCommand('copy');
            show_toastr('success', 'Url copied to clipboard', 'success');
        }
    </script>
    <script>
        var filename = $('#filesname').val();

        function saveAsPDF() {
            var element = document.getElementById('printableArea');
            var opt = {
                margin: 0.3,
                filename: filename,
                image: {
                    type: 'jpeg',
                    quality: 1
                },
                html2canvas: {
                    scale: 4,
                    dpi: 72,
                    letterRendering: true
                },
                jsPDF: {
                    unit: 'in',
                    format: 'A2'
                }
            };
            html2pdf().set(opt).from(element).save();

        }
    </script>
    <script>
        $("#deliver_btn").on('click', '#delivered', function() {
            var status = $(this).attr('data-value');
            var data = {
                delivered: status,
            }
            $.ajax({
                url: '{{ route('orders.update', $order->id) }}',
                method: 'PUT',
                data: data,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    show_toastr('success', data.success, 'success');
                    setTimeout(function() {
                        location.reload();
                    }, 2000);
                }
            });
        });
    </script>
    <script>
        function myFunction() {
            var copyText = document.getElementById("myInput");
            copyText.select();
            copyText.setSelectionRange(0, 99999)
            document.execCommand("copy");
            show_toastr('Success', 'Link copied', 'success');
        }
    </script>
@endpush
