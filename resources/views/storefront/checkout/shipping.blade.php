@php
    $theme_name = $store ? $store->theme_dir : 'theme1';
@endphp
@extends('storefront.layout.' . $theme_name)
@section('page-title')
    {{__('Checkout')}}
@endsection
@php
    $productImg = \App\Models\Utility::get_file('uploads/is_cover_image/');
@endphp
@section('content')
<main>
    
    @include('storefront.' . $theme_name . '.common.common_banner_section')

    <section class="checkout-sec pt pb">
        <div class="container">
            {{ Form::model($cust_details, array('route' => array('store.customer',$store->slug), 'method' => 'POST')) }}
                <div class="row">
                    <div class="col-lg-8 col-12">
                        <div class="checkout-left-col sticky-column">
                            <div class="order-detail-card">
                                <div class="detail-card-header">
                                    <h2>{{ __('Billing information') }}</h2>
                                    <p>{{ __('Fill the form below so we can send you the orders invoice.') }}</p>
                                </div>
                                <div class="checkout-form-wrp">
                                    <div class="form-container">
                                        <div class="row">
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    {{ Form::label('name', __('First Name'), array("class" => "form-control-label")) }}<sup aria-hidden="true">*</sup>
                                                    {{ Form::text('name', old('name'), array('class' => 'form-control', 'placeholder' => __('Enter Your First Name'), 'required' => 'required')) }}
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    {{ Form::label('last_name', __('Last Name'), array("class" => "form-control-label")) }}<sup aria-hidden="true">*</sup>
                                                    {{ Form::text('last_name', old('last_name'), array('class' => 'form-control', 'placeholder' => __('Enter Your Last Name'), 'required' => 'required')) }}
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    {{ Form::label('phone', __('Phone'), array("class" => "form-control-label")) }}<sup aria-hidden="true">*</sup>
                                                    {{ Form::text('phone', old('phone'), array('class' => 'form-control', 'placeholder' => '+91 12345 67890', 'required' => 'required')) }}
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    {{ Form::label('email', __('Email'), array("class" => "form-control-label")) }}<sup aria-hidden="true">*</sup>
                                                    {{ Form::email('email', (Utility::CustomerAuthCheck($store->slug) ? Auth::guard('customers')->user()->email : ''), array('class' => 'form-control', 'placeholder' => __('Enter Your Email Address'), 'required' => 'required')) }}
                                                </div>
                                            </div>
                                            @if(!empty($store_payment_setting['custom_field_title_1']))
                                                <div class="col-md-6 col-12">
                                                    <div class="form-group">
                                                        {{ Form::label('custom_field_title_1', $store_payment_setting['custom_field_title_1'], array("class" => "form-control-label")) }}<sup aria-hidden="true">*</sup>
                                                        {{ Form::text('custom_field_title_1', old('custom_field_title_1'), array('class' => 'form-control', 'placeholder' => 'Enter ' . $store_payment_setting['custom_field_title_1'], 'required' => 'required')) }}
                                                    </div>
                                                </div>
                                            @endif
                                            @if(!empty($store_payment_setting['custom_field_title_2']))
                                                <div class="col-md-6 col-12">
                                                    <div class="form-group">
                                                        {{ Form::label('custom_field_title_2', $store_payment_setting['custom_field_title_2'], array("class" => "form-control-label")) }}<sup aria-hidden="true">*</sup>
                                                        {{ Form::text('custom_field_title_2', old('custom_field_title_2'), array('class' => 'form-control', 'placeholder' => 'Enter ' . $store_payment_setting['custom_field_title_1'], 'required' => 'required')) }}
                                                    </div>
                                                </div>
                                            @endif
                                            @if(!empty($store_payment_setting['custom_field_title_3']))
                                                    <div class="col-md-6 col-12">
                                                        <div class="form-group">
                                                            {{ Form::label('custom_field_title_3', $store_payment_setting['custom_field_title_3'], array("class" => "form-control-label")) }}<sup aria-hidden="true">*</sup>
                                                            {{ Form::text('custom_field_title_3', old('custom_field_title_3'), array('class' => 'form-control', 'placeholder' => 'Enter ' . $store_payment_setting['custom_field_title_1'], 'required' => 'required')) }}
                                                        </div>
                                                    </div>
                                            @endif
                                            @if(!empty($store_payment_setting['custom_field_title_4']))
                                                <div class="col-md-6 col-12">
                                                    <div class="form-group">
                                                        {{ Form::label('custom_field_title_4', $store_payment_setting['custom_field_title_4'], array("class" => "form-control-label")) }}<sup aria-hidden="true">*</sup>
                                                        {{ Form::text('custom_field_title_4', old('custom_field_title_4'), array('class' => 'form-control', 'placeholder' => 'Enter ' . $store_payment_setting['custom_field_title_1'], 'required' => 'required')) }}
                                                    </div>
                                                </div>
                                            @endif
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    {{ Form::label('billingaddress', __('Address'), array("class" => "form-control-label")) }}<sup aria-hidden="true">*</sup>
                                                    {{ Form::text('billing_address', old('billing_address'), array('class' => 'form-control', 'placeholder' => __('Billing Address'), 'required' => 'required')) }}
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    {{ Form::label('billing_country', __('Country'), array("class" => "form-control-label")) }}<sup aria-hidden="true">*</sup>
                                                    <select name="billing_country" id="" class="form-control change_country" required>
                                                        <option value="">{{ __('Select Country') }}</option>
                                                        @foreach($countries as $key => $value)
                                                            <option value="{{ $key }}">{{ $key }}</option>
                                                        @endforeach   
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    {{ Form::label('billing_city', __('City'), array("class" => "form-control-label")) }}<sup aria-hidden="true">*</sup>
                                                    <select name="billing_city" id="city" class="form-control" required>  
                                                        <option value="">{{ __('select city') }}</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    {{ Form::label('billing_postalcode', __('Postal Code'), array("class" => "form-control-label")) }}<sup aria-hidden="true">*</sup>
                                                    {{ Form::text('billing_postalcode', old('billing_postalcode'), array('class' => 'form-control', 'placeholder' => __('Billing Postal Code'), 'required' => 'required')) }}
                                                </div>
                                            </div>
                                            @if($store->enable_shipping == "on" && $shippings->count() > 0)
                                                <div class="col-md-6 col-12">
                                                    <div class="form-group">
                                                        {{ Form::label('location_id', __('Location'), array("class" => "form-control-label")) }}<sup aria-hidden="true">*</sup>
                                                        {{ Form::select('location_id', $locations, null, array('class' => 'form-control change_location', 'required' => 'required')) }}
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="order-detail-card shipping-info-card">
                                <div class="detail-card-header flex align-center justify-between">
                                    <div class="detail-header-left">
                                        <h2>{{ __('Shipping informations') }}</h2>
                                        <p>{{ __('Fill the form below so we can send you the orders invoice.') }}</p>
                                    </div>
                                    <div class="detail-header-right">
                                        <a class="cart-btn btn btn-white" onclick="billing_data()" id="billing_data" data-toggle="tooltip" data-placement="top" title="{{ __('Same As Billing Address') }}">
                                            {{ __('Copy Address') }}
                                        </a>
                                    </div>
                                </div>
                                <div class="checkout-form-wrp">
                                    <div class="form-container">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    {{ Form::label('shipping_address', __('Address'), array("class" => "form-control-label")) }}<sup aria-hidden="true">*</sup>
                                                    {{ Form::text('shipping_address', old('shipping_address'), array('class' => 'form-control', 'placeholder' => __('Shipping Address'))) }}
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    {{ Form::label('shipping_country', __('Country'), array("class" => "form-control-label")) }}<sup aria-hidden="true">*</sup>
                                                    {{ Form::text('shipping_country', old('shipping_country'), array('class' => 'form-control', 'placeholder' => __('Shipping Country'))) }}
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    {{ Form::label('shipping_city', __('City'), array("class" => "form-control-label")) }}<sup aria-hidden="true">*</sup>
                                                    {{ Form::text('shipping_city', old('shipping_city'), array('class' => 'form-control', 'placeholder' => __('Shipping City'))) }}
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    {{ Form::label('shipping_postalcode', __('Postal Code'), array("class" => "form-control-label")) }}<sup aria-hidden="true">*</sup>
                                                    {{ Form::text('shipping_postalcode', old('shipping_postalcode'), array('class' => 'form-control', 'placeholder' => __('Shipping Postal Code'))) }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="checkout-btn-wrapper flex align-center">
                                <a href="{{ route('store.slug', $store->slug) }}" class="btn">{{ __('Return to shop') }}</a>
                                <button type="submit" class="btn btn-transparent">{{ __('Next step') }}</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-12">
                        <div class="checkout-right-col sticky-column">
                            <div class="order-detail-card" id="location_hide" style="display: none">
                                <div class="detail-card-header">
                                    <h2>{{ __('Select Shipping') }}</h2>
                                </div>
                                <div class="order-detail-body radio-group" id="shipping_location_content">

                                </div>
                            </div>
                            <div class="order-detail-card">
                                <div class="detail-card-header">
                                    <h2>{{ __('Coupon') }}</h2>
                                </div>
                                <div class="order-detail-body">
                                    <div class="coupon-code">
                                        <input type="text" class="discount-coupon coupon hidd_val" id="stripe_coupon" name="coupon" placeholder="{{ __('Enter Coupon Code') }}">
                                        <input type="hidden" name="coupon" class="form-control hidden_coupon " value="">
                                        <button type="submit" class="apply-coupon-btn btn apply-coupon">{{ __('Apply') }}</button>
                                    </div>
                                </div>
                            </div>
                            <div class="order-detail-card order-summary-card" id="card-summary">
                                <div class="detail-card-header">
                                <h2>{{ __('Summary') }}</h2>
                                </div>
                                <div class="mini-cart-has-item">
                                    @if(isset($products) && !empty($products))
                                        @php
                                            $total = 0;
                                            $sub_tax = 0;
                                            $sub_total= 0;
                                        @endphp
                                        @foreach($products as $product)
                                            @if(isset($product['variant_id']) && !empty($product['variant_id']))
                                                <div class="mini-cart-body">
                                                    <div class="mini-cart-item flex">
                                                        <div class="mini-cart-image">
                                                            <a href="{{ route('store.product.product_view', [$store->slug, $product['id']]) }}" tabindex="0" class="img-ratio">
                                                                <img src="{{ $productImg . $product['image'] }}" alt="img">
                                                            </a>
                                                        </div>
                                                        @php
                                                            $total_tax = 0;
                                                        @endphp
                                                        <div class="mini-cart-details flex align-center justify-between">
                                                            <div class="cart-details-left">
                                                                <a href="{{ route('store.product.product_view', [$store->slug, $product['id']]) }}" class="mini-cart-title">{{ $product['product_name'] . ' - ( ' . $product['variant_name'] . ' ) ' }}</a>
                                                                <p>
                                                                    {{ $product['quantity'] }} x {{ \App\Models\Utility::priceFormat($product['variant_price']) }}
                                                                    @if(!empty($product['tax']))
                                                                        @foreach($product['tax'] as $tax)
                                                                            @php
                                                                                $sub_tax = ($product['variant_price'] * $product['quantity'] * $tax['tax']) / 100;
                                                                                $total_tax += $sub_tax;
                                                                            @endphp

                                                                            + {{ \App\Models\Utility::priceFormat($sub_tax).' ('.$tax['tax_name'].' '.($tax['tax']).'%)'}}
                                                                        @endforeach
                                                                    @endif
                                                                </p>
                                                                @php
                                                                    $totalprice = $product['variant_price'] * $product['quantity'] + $total_tax;
                                                                    $subtotal = $product['variant_price'] * $product['quantity'];
                                                                    $sub_total += $subtotal;
                                                                @endphp
                                                            </div>
                                                            <div class="cart-details-right">
                                                                <div class="price">
                                                                    <ins>{{ \App\Models\Utility::priceFormat($totalprice) }}</ins>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @php
                                                    $total += $totalprice;
                                                @endphp
                                            @else
                                                <div class="mini-cart-body">
                                                    <div class="mini-cart-item flex">
                                                        <div class="mini-cart-image">
                                                            <a href="{{ route('store.product.product_view', [$store->slug, $product['id']]) }}" tabindex="0" class="img-ratio">
                                                                <img src="{{ $productImg . $product['image'] }}" alt="img">
                                                            </a>
                                                        </div>
                                                        @php
                                                            $total_tax = 0;
                                                        @endphp
                                                        <div class="mini-cart-details flex align-center justify-between">
                                                            <div class="cart-details-left">
                                                                <a href="{{ route('store.product.product_view', [$store->slug, $product['id']]) }}" class="mini-cart-title">{{ $product['product_name'] }}</a>
                                                                <p>
                                                                    {{ $product['quantity'] }} x {{ \App\Models\Utility::priceFormat($product['price']) }}
                                                                    @if(!empty($product['tax']))
                                                                        @foreach($product['tax'] as $tax)
                                                                            @php
                                                                                $sub_tax = ($product['price'] * $product['quantity'] * $tax['tax']) / 100;
                                                                                $total_tax += $sub_tax;
                                                                            @endphp
        
                                                                            + {{ \App\Models\Utility::priceFormat($sub_tax).' ('.$tax['tax_name'].' '.($tax['tax']).'%)'}}
                                                                        @endforeach
                                                                    @endif
                                                                </p>
                                                                @php
                                                                    $totalprice = $product['price'] * $product['quantity'] + $total_tax;
                                                                    $subtotal = $product['price'] * $product['quantity'];
                                                                    $sub_total += $subtotal;
                                                                @endphp
                                                            </div>
                                                            <div class="cart-details-right">
                                                                <div class="price">
                                                                    <ins>{{ \App\Models\Utility::priceFormat($totalprice) }}</ins>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @php
                                                    $total += $totalprice;
                                                @endphp
                                            @endif
                                        @endforeach
                                        <div class="mini-cart-footer order-detail-body">
                                            <ul class="mini-cart-summery">
                                                <li class="flex align-center justify-between">
                                                    <span>{{ __('item') }}</span>
                                                    <span>{{ \App\Models\Utility::priceFormat( !empty($sub_total) ? $sub_total : '0') }}</span>
                                                </li>
                                                @if(isset($taxArr))
                                                    @foreach($taxArr['tax'] as $k => $tax)
                                                        <li class="flex align-center justify-between">
                                                            @php
                                                                $rate = $taxArr['rate'][$k];
                                                            @endphp
                                                            <span>{{ $tax }}</span>
                                                            <span>{{ \App\Models\Utility::priceFormat($rate) }}</span>
                                                        </li>
                                                    @endforeach
                                                @endif
                                                <li class="flex align-center justify-between">
                                                    <span>{{ __('Coupon') }}</span>
                                                    <span class="dicount_price">{{ \App\Models\Utility::priceFormat(0) }}</span>
                                                </li>
                                                @if($store->enable_shipping == "on")
                                                    <li class="flex align-center justify-between shipping_price_add">
                                                        <span>{{ __('Shipping Price') }}</span>
                                                        <span class="shipping_price" data-value="">{{ \App\Models\Utility::priceFormat(0) }}</span>
                                                    </li>
                                                @endif
                                                <li class="flex align-center justify-between">
                                                    <span><b>{{ __('Total') }}</b></span>
                                                    <div class="mini-total-price final_total_price" id="total_value">
                                                        <input type="hidden" class="product_total" value="{{ $total }}">
                                                        <input type="hidden" class="total_pay_price" value="{{ \App\Models\Utility::priceFormat($total) }}">
                                                        <span class="pro_total_price" data-value="{{ \App\Models\Utility::priceFormat( !empty($total) ? $total : 0) }}"><b>{{ \App\Models\Utility::priceFormat( !empty($total) ? $total : '0') }}</b></span> 
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            {{ Form::close() }}
        </div>
    </section>
</main>
@endsection

@push('script-page')
    <script>
        function billing_data() {
            $("[name='shipping_address']").val($("[name='billing_address']").val());
            $("[name='shipping_city']").val($("[name='billing_city']").val());
            $("[name='shipping_state']").val($("[name='billing_state']").val());
            $("[name='shipping_country']").val($("[name='billing_country']").val());
            $("[name='shipping_postalcode']").val($("[name='billing_postalcode']").val());
        }

        $(document).ready(function () {
            $('.change_location').trigger('change');

            setTimeout(function () {
                var shipping_id = $("input[name='shipping_id']:checked").val();
                getTotal(shipping_id);
            }, 200);
        });

        $(document).on('change', '.shipping_mode', function () {
            var shipping_id = this.value;
            getTotal(shipping_id);
        });

        function getTotal(shipping_id) {
            var pro_total_price = $('.pro_total_price').attr('data-value');
            if (shipping_id == undefined) {
                $('.shipping_price_add').hide();
                return false
            } else {
                $('.shipping_price_add').show();
            }
            $.ajax({
                url: '{{ route('user.shipping', [$store->slug,'_shipping'])}}'.replace('_shipping', shipping_id),
                data: {
                    "pro_total_price": pro_total_price,
                    "_token": "{{ csrf_token() }}",
                },
                method: 'POST',
                context: this,
                dataType: 'json',

                success: function (data) {
                    var price = data.price + pro_total_price;
                    $('.shipping_price').html(data.price);
                    $('.shipping_price').attr('data-value', data.price);
                    $('.pro_total_price').html('<b>' + data.total_price + '</b>');
                }
            });
        }

        $(document).on('change', '.change_location', function () {
            var location_id = $('.change_location').val();
            if (location_id == 0) {
                $('#location_hide').hide();
            } else {
                $('#location_hide').show();
            }

            $.ajax({
                url: '{{ route('user.location', [$store->slug,'_location_id'])}}'.replace('_location_id', location_id),
                data: {
                    "_token": "{{ csrf_token() }}",
                },
                method: 'POST',
                context: this,
                dataType: 'json',

                success: function (data) {
                    var html = '';
                    var shipping_id = '{{ (isset($cust_details['shipping_id']) ? $cust_details['shipping_id'] : '') }}';
                    $.each(data.shipping, function (key, value) {
                        var checked = '';
                        if (shipping_id != '' && shipping_id == value.id) {
                            checked = 'checked';
                        }

                        html += '<div class="radio-group">' +
                                    ' <ul class="checkout-checkbox-wrapper">' +
                                        ' <li>' +
                                            ' <div class="checkbox-custom">' +
                                                ' <input type="radio" name="shipping_id" data-id="' + value.price + '" value="' + value.id + '" id="shipping_price' + key + '" class="shipping_mode" ' + checked + '>' +
                                                ' <label name="shipping_label" for="shipping_price' + key + '"> ' + value.name + '</label>' +
                                            ' </div>' +
                                        ' </li>' +
                                    ' </ul>' +
                                ' </div>';

                    });
                    $('#shipping_location_content').html(html);
                }
            });
        });

        $(document).on('click', '.apply-coupon', function (e) {
            e.preventDefault();

            var ele = $(this);
            var coupon = ele.closest('.row').find('.coupon').val();
            var hidden_field = $('.hidden_coupon').val();
            var price = $('#card-summary .product_total').val();
            var shipping_price = $('#card-summary .shipping_price').attr('data-value');

            if (coupon == hidden_field && coupon != "") {
                show_toastr('Error', "{{ __('Coupon Already Used') }}", 'error');
            } else {
                if (coupon != '') {
                    $.ajax({
                        url: '{{route('apply.productcoupon')}}',
                        datType: 'json',
                        data: {
                            price: price,
                            shipping_price: shipping_price,
                            store_id: {{$store->id}},
                            coupon: coupon
                        },
                        success: function (data) {
                            $('#stripe_coupon, #paypal_coupon').val(coupon);
                            if (data.is_success) {
                                $('.hidden_coupon').val(coupon);
                                $('.hidden_coupon').attr(data);
                                $('.dicount_price').html(data.discount_price);

                                var html = '';
                                html += '<span class="text-sm font-weight-bold s-p-total pro_total_price" data-value="' + data.final_price_data_value + '"><b>' + data.final_price + '</b></span>'
                                $('.final_total_price').html(html);

                                show_toastr('Success', data.message, 'success');
                            } else {
                                show_toastr('Error', data.message, 'error');
                            }
                        }
                    })
                } else {
                    $.ajax({
                        url: '{{route('apply.removecoupn')}}',
                        datType: 'json',
                        data: {
                            price: "price",
                            shipping_price: "shipping_price",
                            slug:{{$store->id}} ,
                            coupon: "coupon"
                        },
                        success: function (data) {
                        }
                    });
                    var hidd_cou = $('.hidd_val').val();
                    var discount_value_defualt = "{{ \App\Models\Utility::priceFormat(0) }}";

                    if(hidd_cou == ""){
                       var total_pa_val =  $(".total_pay_price").val();
                       $(".pro_total_price").html('<b>' + total_pa_val + '</b>');
                       $(".dicount_price").html(discount_value_defualt);
                    }
                    show_toastr('Error', '{{ __('Invalid Coupon Code.') }}', 'error');
                }
            }

        });
        $(document).on('change','.change_country',function(){
            var country = $('.change_country').val();
            $.ajax({
                url : '{{ route('user.city',[$store->slug,'_country']) }}'.replace('_country',country),
                method : 'POST',
                data : {
                    "_token":"{{ csrf_token() }}",
                },
                context : this,
                dataType : 'json',
                success : function(data){
                    $('#city').html('<option value="">Select city</option>'); 
                    $.each(data.cities,function(key,value){
                        $("#city").append('<option value="'+value+'">'+value+'</option>');
                    });
                }
            }); 
        });
    </script>
@endpush
