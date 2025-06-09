@php
    $theme_name = $store ? $store->theme_dir : 'theme1';
@endphp
@extends('storefront.layout.' . $theme_name)

@section('page-title')
    {{ __('Payment') }}
@endsection

@section('content')
@php
    $coupon_price = !empty($coupon_price) ? $coupon_price : 0;
    $shipping_price = !empty($shipping_price) ? $shipping_price : 0;
    $productImg = \App\Models\Utility::get_file('uploads/is_cover_image/');
@endphp
<main>
    
    @include('storefront.' . $theme_name . '.common.common_banner_section')

    <input type="hidden" id="return_url">
    <input type="hidden" id="return_order_id">
    <section class="payment-sec pt pb">
        <div class="container">
            <div class="row">
                <input type="hidden" class="form-control hidden_coupon" data_id="{{ $coupon_id }}">
                <div class="col-lg-8 col-12">
                    <div class="checkout-left-col sticky-column">
                        @if($store['enable_cod'] == 'on')
                            <div class="order-detail-card payment-card">
                                <div class="detail-card-header">
                                    <h2>{{ __('COD') }}</h2>
                                </div>
                                <div class="order-detail-body">
                                    <div class="payment-content-wrp flex align-center justify-between">
                                        <div class="payment-card-content">
                                            <p>{{ __('Cash on delivery is a type of transaction in which payment for a good is made at the time of delivery.') }}</p>
                                        </div>
                                        <div class="payment-card-image flex align-center justify-between">
                                            <div class="payment-image">
                                                <img src="{{ asset('assets/img/cod.png') }}" alt="payment-icon">
                                            </div>
                                        </div>
                                    </div>
                                    <form class="w3-container w3-display-middle w3-card-4" method="POST" action="{{ route('user.cod', $store->slug) }}">
                                        @csrf
                                        <input type="hidden" name="product_id">
                                        <div class="payment-card-btn">
                                            <button type="button" class="btn" id="cash_on_delivery">{{ __('Pay Now') }}</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @endif
                        @if(isset($store_payments['is_stripe_enabled']) && $store_payments['is_stripe_enabled'] == 'on')
                            <div class="order-detail-card payment-card">
                                <div class="detail-card-header">
                                    <h2>{{ __('Stripe') }}</h2>
                                </div>
                                <div class="order-detail-body">
                                    <div class="payment-content-wrp  flex align-center justify-between">
                                        <div class="payment-card-content">
                                            <p>{{ __('Safe money transfer using your bank account. We support Mastercard, Visa and Skrill.') }}</p>
                                        </div>
                                        <div class="payment-card-image payment-img-type flex align-center justify-between">
                                            <div class="payment-image">
                                                <img src="{{ asset('assets/img/visa.png') }}" alt="payment-icon">
                                            </div>
                                            <div class="payment-image">
                                                <img src="{{ asset('assets/img/mastercard.png') }}" alt="payment-icon">
                                            </div>
                                            <div class="payment-image">
                                                <img src="{{ asset('assets/img/skrill.png') }}" alt="payment-icon">
                                            </div>
                                        </div>
                                    </div>
                                    <form action="{{ route('stripe.post', $store->slug) }}" method="post" class="payment-form-wrp payment-method-form" id="payment-form">
                                        @csrf
                                        <input type="hidden" name="product_id">
                                        <div class="form-group">
                                            <label>{{ __('Name on card') }}</label><sup aria-hidden="true">*</sup>
                                            <input type="text" name="name" class="form-control" placeholder="{{ __('Enter Your Name') }}" required="">
                                        </div>
                                        <div class="form-group">
                                            <div id="card-element"></div>
                                            <div id="card-errors" role="alert"></div>
                                        </div>
                                        <div class="payment-card-btn">
                                            <button type="submit" class="btn">{{ __('Pay Now') }}</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @endif
                        @if($store['enable_telegram'] == 'on')
                            <div class="order-detail-card payment-card">
                                <div class="detail-card-header">
                                    <h2>{{ __('Telegram') }}</h2>
                                </div>
                                <div class="order-detail-body">
                                    <div class="payment-content-wrp flex align-center justify-between">
                                        <div class="payment-card-content">
                                            <p>{{ __('Click to chat. The click to chat feature lets customers click an URL in order to directly start a chat with another person or business via Telegram. ... QR code. As you know, having to add a phone number to your contacts in order to start up a Telegram message can take a little while') }}.....</p>
                                        </div>
                                        <div class="payment-card-image flex align-center justify-between">
                                            <div class="payment-image">
                                                <img src="{{ asset('assets/img/telegram.svg') }}" alt="payment-icon">
                                            </div>
                                        </div>
                                    </div>
                                    <form action="{{ route('user.telegram', $store->slug) }}" method="post" class="payment-method-form" id="payment-form">
                                        @csrf
                                        <input type="hidden" name="product_id">
                                        <div class="payment-card-btn">
                                            <button type="submit" class="btn" id="owner-telegram">{{ __('Pay Now') }}</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @endif
                        @if($store['enable_bank'] == 'on')
                            <div class="order-detail-card payment-card">
                                <div class="detail-card-header">
                                    <h2>{{ __('Bank Transfer') }}</h2>
                                </div>
                                <div class="order-detail-body">
                                    <div class="payment-content-wrp flex align-center justify-between">
                                        <div class="payment-card-content">
                                            <p>{!! $store->bank_number !!}</p>
                                        </div>
                                        <div class="payment-card-image flex align-center justify-between">
                                            <div class="payment-image">
                                                <img src="{{ asset('assets/img/bank.png') }}" alt="payment-icon">
                                            </div>
                                        </div>
                                    </div>
                                    <form action="{{ route('user.bank_transfer', $store->slug) }}" method="POST" id="bank_transfer_form" class="payment-method-form" enctype="multipart/form-data">
                                        @csrf
                                        <div class="upload-btn-wrapper payment-content-wrp">
                                            <label for="bank_transfer_invoice" class="btn"> {{--file-upload--}}
                                                <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 17 17" fill="none">
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M6.67952 7.2448C6.69833 7.59772 6.42748 7.89908 6.07456 7.91789C5.59289 7.94357 5.21139 7.97498 4.91327 8.00642C4.51291 8.04864 4.26965 8.29456 4.22921 8.64831C4.17115 9.15619 4.12069 9.92477 4.12069 11.0589C4.12069 12.193 4.17115 12.9616 4.22921 13.4695C4.26972 13.8238 4.51237 14.0691 4.91213 14.1112C5.61223 14.1851 6.76953 14.2586 8.60022 14.2586C10.4309 14.2586 11.5882 14.1851 12.2883 14.1112C12.6881 14.0691 12.9307 13.8238 12.9712 13.4695C13.0293 12.9616 13.0798 12.193 13.0798 11.0589C13.0798 9.92477 13.0293 9.15619 12.9712 8.64831C12.9308 8.29456 12.6875 8.04864 12.2872 8.00642C11.9891 7.97498 11.6076 7.94357 11.1259 7.91789C10.773 7.89908 10.5021 7.59772 10.5209 7.2448C10.5397 6.89187 10.8411 6.62103 11.194 6.63984C11.695 6.66655 12.0987 6.69958 12.4214 6.73361C13.3713 6.8338 14.1291 7.50771 14.2428 8.50295C14.3077 9.07016 14.3596 9.88879 14.3596 11.0589C14.3596 12.229 14.3077 13.0476 14.2428 13.6148C14.1291 14.6095 13.3732 15.2837 12.4227 15.384C11.6667 15.4638 10.4629 15.5384 8.60022 15.5384C6.73752 15.5384 5.5337 15.4638 4.77779 15.384C3.82728 15.2837 3.07133 14.6095 2.95763 13.6148C2.89279 13.0476 2.84082 12.229 2.84082 11.0589C2.84082 9.88879 2.89279 9.07016 2.95763 8.50295C3.0714 7.50771 3.82911 6.8338 4.77903 6.73361C5.10175 6.69958 5.50546 6.66655 6.00642 6.63984C6.35935 6.62103 6.6607 6.89187 6.67952 7.2448Z" fill="white"></path>
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M6.81509 4.79241C6.56518 5.04232 6.16 5.04232 5.91009 4.79241C5.66018 4.5425 5.66018 4.13732 5.91009 3.88741L8.14986 1.64764C8.39977 1.39773 8.80495 1.39773 9.05486 1.64764L11.2946 3.88741C11.5445 4.13732 11.5445 4.5425 11.2946 4.79241C11.0447 5.04232 10.6395 5.04232 10.3896 4.79241L9.24229 3.64508V9.77934C9.24229 10.1328 8.95578 10.4193 8.60236 10.4193C8.24893 10.4193 7.96242 10.1328 7.96242 9.77934L7.96242 3.64508L6.81509 4.79241Z" fill="white"></path>
                                                </svg>
                                                {{ __('Upload invoice reciept') }}
                                            </label>
                                            <input type="file" name="bank_transfer_invoice" id="bank_transfer_invoice" class="file-input" >
                                            <input type="hidden" name="product_id">
                                        </div>
                                        <div class="payment-card-btn">
                                            <button type="submit" class="btn" id="bank_transfer">{{ __('Pay Now') }}</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @endif
                        @if($store['enable_whatsapp'] == 'on')
                            <div class="order-detail-card payment-card">
                                <div class="detail-card-header">
                                    <h2>{{ __('WhatsApp') }}</h2>
                                </div>
                                <div class="order-detail-body">
                                    <div class="payment-content-wrp flex align-center justify-between">
                                        <div class="payment-card-content">
                                            <p>{{ __('Click to chat. The click to chat feature lets customers click an URL in order to directly start a chat with another person or business via WhatsApp. ... QR code. As you know, having to add a phone number to your contacts in order to start up a WhatsApp message can take a little while') }}.....</p>
                                        </div>
                                        <div class="payment-card-image flex align-center justify-between">
                                            <div class="payment-image">
                                                <img src="{{ asset('assets/img/whatsapp.png') }}" alt="payment-icon">
                                            </div>
                                        </div>
                                    </div>
                                    <form method="POST" action="{{ route('user.whatsapp', $store->slug) }}" class="payment-method-form">
                                        @csrf
                                        <input type="hidden" name="product_id">
                                        <div class="form-group">
                                            <label>{{ __('Phone Number') }}</label><sup aria-hidden="true">*</sup>
                                            <input name="wts_number" id="wts_number" type="text" placeholder="{{ __('Enter Your Phone Number') }}">
                                        </div>
                                        <div class="payment-card-btn">
                                            <button type="submit" class="btn" id="owner-whatsapp">{{ __('Pay Now') }}</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @endif
                        @if(isset($store_payments['is_paystack_enabled']) && $store_payments['is_paystack_enabled'] == 'on')
                            <script src="https://js.paystack.co/v1/inline.js"></script>
                            <script src="https://checkout.paystack.com/service-worker.js"></script>
                            {{-- PAYSTACK JAVASCRIPT FUNCTION --}}
                            <script>
                                function payWithPaystack() {
                                    var paystack_callback = "{{ url('/paystack') }}";
                                    var order_id = '{{$order_id = time()}}';
                                    var slug = '{{$store->slug}}';
                                    var handler = PaystackPop.setup({
                                        key: '{{ $store_payments['paystack_public_key']}}',
                                        email: '{{$cust_details['email']}}',
                                        amount: $('.pro_total_price').data('value') * 100,
                                        currency: '{{$store['currency_code']}}',
                                        ref: 'pay_ref_id' + Math.floor((Math.random() * 1000000000) +
                                            1
                                        ),
                                        metadata: {
                                            custom_fields: [{
                                                display_name: "Mobile Number",
                                                variable_name: "mobile_number",
                                                value: "{{$cust_details['phone']}}"
                                            }]
                                        },

                                        callback: function (response) {
                                            console.log(response.reference, order_id);
                                            window.location.href = paystack_callback + '/' + slug + '/' + response.reference + '/' + {{$order_id}};
                                        },
                                        onClose: function () {
                                            alert('window closed');
                                        }
                                    });
                                    handler.openIframe();
                                }
                            </script>
                            {{-- /PAYSTACK JAVASCRIPT FUNCTION --}}
                            <div class="order-detail-card payment-card">
                                <div class="detail-card-header">
                                    <h2>{{ __('Paystack') }}</h2>
                                </div>
                                <div class="order-detail-body">
                                    <div class="payment-content-wrp flex align-center justify-between">
                                        <div class="payment-card-content">
                                            <p>{{ __('Pay your order using the most known and secure platform for online money transfers. You will be redirected to Paystack to finish complete your purchase.') }}</p>
                                        </div>
                                        <div class="payment-card-image flex align-center justify-between">
                                            <div class="payment-image">
                                                <img src="{{ asset('assets/img/paystack.jpg') }}" alt="payment-icon">
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" name="product_id">
                                    <div class="payment-card-btn">
                                        <button type="submit" class="btn" onclick="payWithPaystack()">{{ __('Pay Now') }}</button>
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if(isset($store_payments['is_paypal_enabled']) && $store_payments['is_paypal_enabled'] == 'on')
                            <div class="order-detail-card payment-card">
                                <div class="detail-card-header">
                                    <h2>{{ __('Paypal') }}</h2>
                                </div>
                                <div class="order-detail-body">
                                    <div class="payment-content-wrp flex align-center justify-between">
                                        <div class="payment-card-content">
                                            <p>{{ __('Pay your order using the most known and secure platform for online money transfers. You will be redirected to PayPal to finish complete your purchase.') }}</p>
                                        </div>
                                        <div class="payment-card-image flex align-center justify-between">
                                            <div class="payment-image">
                                                <img src="{{ asset('assets/img/paypal.png') }}" alt="payment-icon">
                                            </div>
                                        </div>
                                    </div>
                                    <form method="POST" action="{{ route('pay.with.paypal', $store->slug) }}" class="payment-method-form">
                                        @csrf
                                        <input type="hidden" name="product_id">
                                        <div class="payment-card-btn">
                                            <button type="submit" class="btn">{{ __('Pay Now') }}</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @endif
                        @if(isset($store_payments['is_flutterwave_enabled']) && $store_payments['is_flutterwave_enabled'] == 'on')
                            <script src="https://api.ravepay.co/flwv3-pug/getpaidx/api/flwpbf-inline.js"></script>
                            {{-- Flutterwave JAVASCRIPT FUNCTION --}}
                            <script>
                                function payWithRave() {
                                    var API_publicKey = '{{ $store_payments['flutterwave_public_key']  }}';
                                    var nowTim = "{{ date('d-m-Y-h-i-a') }}";
                                    var order_id = '{{$order_id = time()}}';
                                    var flutter_callback = "{{ url('/flutterwave') }}";
                                    var x = getpaidSetup({
                                        PBFPubKey: API_publicKey,
                                        customer_email: '{{$cust_details['email']}}',
                                        amount: $('.product_total').val(),
                                        customer_phone: '{{$cust_details['phone']}}',
                                        currency: '{{$store['currency_code']}}',
                                        txref: nowTim + '__' + Math.floor((Math.random() * 1000000000)) + 'fluttpay_online-' +
                                        {{ date('Y-m-d') }},
                                        meta: [{
                                            metaname: "payment_id",
                                            metavalue: "id"
                                        }],
                                        onclose: function () {
                                        },
                                        callback: function (response) {

                                            var txref = response.tx.txRef;
                                            if (
                                                response.tx.chargeResponseCode == "00" ||
                                                response.tx.chargeResponseCode == "0"
                                            ) {
                                                window.location.href = flutter_callback + '/{{$store->slug}}/' + txref + '/' + {{$order_id}};
                                            } else {
                                                // redirect to a failure page.
                                            }
                                            x.close(); // use this to close the modal immediately after payment.
                                        }
                                    });
                                }
                            </script>
                            {{-- /Flutterwave JAVASCRIPT FUNCTION --}}
                            <div class="order-detail-card payment-card">
                                <div class="detail-card-header">
                                    <h2>{{ __('Flutterwave') }}</h2>
                                </div>
                                <div class="order-detail-body">
                                    <div class="payment-content-wrp flex align-center justify-between">
                                        <div class="payment-card-content">
                                            <p>{{ __('Pay your order using the most known and secure platform for online money transfers. You will be redirected to Flutterwave to finish complete your purchase.') }}</p>
                                        </div>
                                        <div class="payment-card-image flex align-center justify-between">
                                            <div class="payment-image">
                                                <img src="{{ asset('assets/img/flutterwave.png') }}" alt="payment-icon">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="payment-card-btn">
                                        <button type="submit" class="btn" onclick="payWithRave()">{{ __('Pay Now') }}</button>
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if(isset($store_payments['is_razorpay_enabled']) && $store_payments['is_razorpay_enabled'] == 'on')
                            @php
                                $logo          = asset(Storage::url('uploads/logo/'));
                                $settings_data = \App\Models\Utility::settingsById($store->created_by);
                                $logo_dark     = isset($settings_data) && isset($settings_data['company_logo_dark']) && !empty($settings_data['company_logo_dark']) ? $settings_data['company_logo_dark'] : 'logo-dark.png';
                            @endphp
                            <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
                            {{-- Razerpay JAVASCRIPT FUNCTION --}}
                            <script>
                                function payRazorPay() {
                                    var getAmount = $('.product_total').val();
                                    var order_id = '{{$order_id = time()}}';
                                    var product_id = '{{$order_id}}';
                                    var useremail = '{{$cust_details['email']}}';
                                    var razorPay_callback = '{{url('razorpay')}}';
                                    var totalAmount = getAmount * 100;
                                    var product_array = '{{$encode_product}}';
                                    var product = JSON.parse(product_array.replace(/&quot;/g, '"'));
                                    var coupon_id = $('.hidden_coupon').attr('data_id');
                                    var dicount_price = $('.dicount_price').html();
    
                                    var options = {
                                        "key": "{{ $store_payments['razorpay_public_key']  }}", // your Razorpay Key Id
                                        "amount": totalAmount,
                                        "name": product,
                                        "currency": '{{$store['currency_code']}}',
                                        "description": "Order Id : " + order_id,
                                        "image": "{{$logo.'/'.$logo_dark}}",
                                        "handler": function (response) {
                                            window.location.href = razorPay_callback + '/{{$store->slug}}/' + response.razorpay_payment_id + '/' + order_id;
                                        },
                                        "theme": {
                                            "color": "#528FF0"
                                        }
                                    };
    
                                    var rzp1 = new Razorpay(options);
                                    rzp1.open();
                                }
                            </script>
                            {{-- /Razerpay JAVASCRIPT FUNCTION --}}
                            <div class="order-detail-card payment-card">
                                <div class="detail-card-header">
                                    <h2>{{ __('Razorpay') }}</h2>
                                </div>
                                <div class="order-detail-body">
                                    <div class="payment-content-wrp flex align-center justify-between">
                                        <div class="payment-card-content">
                                            <p>{{ __('Pay your order using the most known and secure platform for online money transfers. You will be redirected to Razorpay to finish complete your purchase.') }}</p>
                                        </div>
                                        <div class="payment-card-image flex align-center justify-between">
                                            <div class="payment-image">
                                                <img src="{{ asset('assets/img/razorpay.png') }}" alt="payment-icon">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="payment-card-btn">
                                        <button type="submit" class="btn" onclick="payRazorPay()">{{ __('Pay Now') }}</button>
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if(isset($store_payments['is_paytm_enabled']) && $store_payments['is_paytm_enabled'] == 'on')
                            <div class="order-detail-card payment-card">
                                <div class="detail-card-header">
                                    <h2>{{ __('Paytm') }}</h2>
                                </div>
                                <div class="order-detail-body">
                                    <div class="payment-content-wrp flex align-center justify-between">
                                        <div class="payment-card-content">
                                            <p>{{ __('Pay your order using the most known and secure platform for online money transfers. You will be redirected to Paytm to finish complete your purchase.') }}</p>
                                        </div>
                                        <div class="payment-card-image flex align-center justify-between">
                                            <div class="payment-image">
                                                <img src="{{ asset('assets/img/Paytm.png') }}" alt="payment-icon">
                                            </div>
                                        </div>
                                    </div>
                                    <form method="POST" action="{{ route('paytm.prepare.payments', $store->slug) }}" class="payment-method-form">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ date('Y-m-d') }}-{{ strtotime(date('Y-m-d H:i:s')) }}-payatm">
                                        <input type="hidden" name="order_id" value="{{str_pad(!empty($order->id) ? $order->id + 1 : 0 + 1, 4, "100", STR_PAD_LEFT)}}">
                                        <div class="payment-card-btn">
                                            <button type="submit" class="btn">{{ __('Pay Now') }}</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @endif
                        @if(isset($store_payments['is_mercado_enabled']) && $store_payments['is_mercado_enabled'] == 'on')
                            <script>
                                function payMercado() {
                                    var product_array = '{{$encode_product}}';
                                    var product = JSON.parse(product_array.replace(/&quot;/g, '"'));
                                    var order_id = '{{$order_id = time()}}';
                                    var total_price = $('#Subtotal .pro_total_price').attr('data-value');
                                    var coupon_id = $('.hidden_coupon').attr('data_id');
                                    var dicount_price = $('.dicount_price').html();

                                    var data = {
                                        coupon_id: coupon_id,
                                        dicount_price: dicount_price,
                                        total_price: total_price,
                                        product: product,
                                        order_id: order_id,
                                    }
                                    $.ajax({
                                        url: '{{ route('mercadopago.prepare', $store->slug) }}',
                                        method: 'POST',
                                        data: data,
                                        headers: {
                                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                        },
                                        success: function (data) {
                                            if (data.status == 'success') {
                                                window.location.href = data.url;
                                            } else {
                                                show_toastr("Error", data.success, data["status"]);
                                            }
                                        }
                                    });
                                }
                            </script>
                            <div class="order-detail-card payment-card">
                                <div class="detail-card-header">
                                    <h2>{{ __('Mercado Pago') }}</h2>
                                </div>
                                <div class="order-detail-body">
                                    <div class="payment-content-wrp flex align-center justify-between">
                                        <div class="payment-card-content">
                                            <p>{{ __('Pay your order using the most known and secure platform for online money transfers. You will be redirected to Mercado Pago to finish complete your purchase.') }}</p>
                                        </div>
                                        <div class="payment-card-image flex align-center justify-between">
                                            <div class="payment-image">
                                                <img src="{{ asset('assets/img/mercadopago.png') }}" alt="payment-icon">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="payment-card-btn">
                                        <button type="submit" class="btn" onclick="payMercado()">{{ __('Pay Now') }}</button>
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if(isset($store_payments['is_mollie_enabled']) && $store_payments['is_mollie_enabled'] == 'on')
                            <div class="order-detail-card payment-card">
                                <div class="detail-card-header">
                                    <h2>{{ __('Mollie') }}</h2>
                                </div>
                                <div class="order-detail-body">
                                    <div class="payment-content-wrp flex align-center justify-between">
                                        <div class="payment-card-content">
                                            <p>{{ __('Pay your order using the most known and secure platform for online money transfers. You will be redirected to Mollie to finish complete your purchase.') }}</p>
                                        </div>
                                        <div class="payment-card-image flex align-center justify-between">
                                            <div class="payment-image">
                                                <img src="{{ asset('assets/img/mollie.png') }}" alt="payment-icon">
                                            </div>
                                        </div>
                                    </div>
                                    <form action="{{ route('mollie.prepare.payments', $store->slug) }}" method="POST" class="payment-method-form">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ date('Y-m-d') }}-{{ strtotime(date('Y-m-d H:i:s')) }}-payatm">
                                        <input type="hidden" name="desc" value="{{time()}}">
                                        <div class="payment-card-btn">
                                            <button type="submit" class="btn">{{ __('Pay Now') }}</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @endif
                        @if(isset($store_payments['is_skrill_enabled']) && $store_payments['is_skrill_enabled'] == 'on')
                            <div class="order-detail-card payment-card">
                                <div class="detail-card-header">
                                    <h2>{{ __('Skrill') }}</h2>
                                </div>
                                <div class="order-detail-body">
                                    <div class="payment-content-wrp flex align-center justify-between">
                                        <div class="payment-card-content">
                                            <p>{{ __('Pay your order using the most known and secure platform for online money transfers. You will be redirected to Skrill to finish complete your purchase.') }}</p>
                                        </div>
                                        <div class="payment-card-image flex align-center justify-between">
                                            <div class="payment-image">
                                                <img src="{{ asset('assets/img/skrill.png') }}" alt="payment-icon">
                                            </div>
                                        </div>
                                    </div>
                                    <form method="POST" action="{{ route('skrill.prepare.payments', $store->slug) }}" class="payment-method-form">
                                        @csrf
                                        <input type="hidden" name="transaction_id" value="{{ date('Y-m-d') . strtotime('Y-m-d H:i:s') . 'user_id' }}">
                                        <input type="hidden" name="desc" value="{{time()}}">
                                        <div class="payment-card-btn">
                                            <button type="submit" class="btn">{{ __('Pay Now') }}</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @endif
                        @if(isset($store_payments['is_coingate_enabled']) && $store_payments['is_coingate_enabled'] == 'on')
                            <div class="order-detail-card payment-card">
                                <div class="detail-card-header">
                                    <h2>{{ __('CoinGate') }}</h2>
                                </div>
                                <div class="order-detail-body">
                                    <div class="payment-content-wrp flex align-center justify-between">
                                        <div class="payment-card-content">
                                            <p>{{ __('Pay your order using the most known and secure platform for online money transfers. You will be redirected to CoinGate to finish complete your purchase.') }}</p>
                                        </div>
                                        <div class="payment-card-image flex align-center justify-between">
                                            <div class="payment-image">
                                                <img src="{{ asset('assets/img/coingate.png') }}" alt="payment-icon">
                                            </div>
                                        </div>
                                    </div>
                                    <form method="POST" action="{{ route('coingate.prepare', $store->slug) }}" class="payment-method-form">
                                        @csrf
                                        <input type="hidden" name="transaction_id" value="{{ date('Y-m-d') . strtotime('Y-m-d H:i:s') . 'user_id' }}">
                                        <input type="hidden" name="desc" value="{{time()}}">
                                        <div class="payment-card-btn">
                                            <button type="submit" class="btn">{{ __('Pay Now') }}</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @endif
                        @if(isset($store_payments['is_paymentwall_enabled']) && $store_payments['is_paymentwall_enabled'] == 'on')
                            <div class="order-detail-card payment-card">
                                <div class="detail-card-header">
                                    <h2>{{ __('PaymentWall') }}</h2>
                                </div>
                                <div class="order-detail-body">
                                    <div class="payment-content-wrp flex align-center justify-between">
                                        <div class="payment-card-content">
                                            <p>{{ __('Pay your order using the most known and secure platform for online money transfers. You will be redirected to PaymentWall to finish complete your purchase.') }}</p>
                                        </div>
                                        <div class="payment-card-image flex align-center justify-between">
                                            <div class="payment-image">
                                                <img src="{{ asset('assets/img/Paymentwall.png') }}" alt="payment-icon">
                                            </div>
                                        </div>
                                    </div>
                                    <form method="POST" action="{{ route('paymentwall.session.store', $store->slug) }}" class="payment-method-form">
                                        @csrf
                                        <input type="hidden" name="transaction_id" value="{{ date('Y-m-d') . strtotime('Y-m-d H:i:s') . 'user_id' }}">
                                        <input type="hidden" name="desc" value="{{time()}}">
                                        <div class="payment-card-btn">
                                            <button type="submit" class="btn">{{ __('Pay Now') }}</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @endif
                        @if(isset($store_payments['is_toyyibpay_enabled']) && $store_payments['is_toyyibpay_enabled'] == 'on')
                            <div class="order-detail-card payment-card">
                                <div class="detail-card-header">
                                    <h2>{{ __('Toyyibpay') }}</h2>
                                </div>
                                <div class="order-detail-body">
                                    <div class="payment-content-wrp flex align-center justify-between">
                                        <div class="payment-card-content">
                                            <p>{{ __('Pay your order using the most known and secure platform for online money transfers. You will be redirected to toyyibpay to finish complete your purchase.') }}</p>
                                        </div>
                                        <div class="payment-card-image flex align-center justify-between">
                                            <div class="payment-image">
                                                <img src="{{ asset('assets/img/toyyibpay.png') }}" alt="payment-icon">
                                            </div>
                                        </div>
                                    </div>
                                    <form method="POST" action="{{ route('toyyibpay.prepare.payments', $store->slug) }}" class="payment-method-form">
                                        @csrf
                                        <div class="payment-card-btn">
                                            <button type="submit" class="btn">{{ __('Pay Now') }}</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @endif
                        @if(isset($store_payments['is_payfast_enabled']) && $store_payments['is_payfast_enabled'] == 'on')
                            <div class="order-detail-card payment-card">
                                <div class="detail-card-header">
                                    <h2>{{ __('Payfast') }}</h2>
                                </div>
                                <div class="order-detail-body">
                                    <div class="payment-content-wrp flex align-center justify-between">
                                        <div class="payment-card-content">
                                            <p>{{ __('Pay your order using the most known and secure platform for online money transfers. You will be redirected to payfast to finish complete your purchase.') }}</p>
                                        </div>
                                        <div class="payment-card-image flex align-center justify-between">
                                            <div class="payment-image">
                                                <img src="{{ asset('assets/img/payfast.png') }}" alt="payment-icon">
                                            </div>
                                        </div>
                                    </div>
                                    @php
                                        $pfHost = $store_payments['payfast_mode'] == 'sandbox' ? 'sandbox.payfast.co.za' : 'www.payfast.co.za';
                                    @endphp
                                    <form method="POST" action='{{"https://" . $pfHost . "/eng/process"}}' class="payment-method-form" id="payfast-form">
                                        @csrf
                                        <div id="get-payfast-inputs"></div>
                                        <div class="payment-card-btn">
                                            <input type="hidden" name="product_id" id="product_id">
                                            <button type="submit" class="btn" id="pay_with_payfast">{{ __('Pay Now') }}</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @endif
                        @if(isset($store_payments['is_iyzipay_enabled']) && $store_payments['is_iyzipay_enabled'] == 'on')
                            <div class="order-detail-card payment-card">
                                <div class="detail-card-header">
                                    <h2>{{ __('Iyzipay') }}</h2>
                                </div>
                                <div class="order-detail-body">
                                    <div class="payment-content-wrp flex align-center justify-between">
                                        <div class="payment-card-content">
                                            <p>{{ __('Pay your order using the most known and secure platform for online money transfers. You will be redirected to iyzipay to finish complete your purchase.') }}</p>
                                        </div>
                                        <div class="payment-card-image flex align-center justify-between">
                                            <div class="payment-image">
                                                <img src="{{ asset('assets/img/iyzipay.svg') }}" alt="payment-icon">
                                            </div>
                                        </div>
                                    </div>
                                    <form method="POST" action="{{ route('iyzipay.prepare.payment', $store->slug) }}" class="payment-method-form" id="iyzipay-form">
                                        @csrf
                                        <div class="payment-card-btn">
                                            <input type="hidden" name="product_id" id="product_id">
                                            <button type="submit" class="btn" id="pay_with_iyzipay">{{ __('Pay Now') }}</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @endif
                        @if(isset($store_payments['is_paytab_enabled']) && $store_payments['is_paytab_enabled'] == 'on')
                            <div class="order-detail-card payment-card">
                                <div class="detail-card-header">
                                    <h2>{{ __('Paytab') }}</h2>
                                </div>
                                <div class="order-detail-body">
                                    <div class="payment-content-wrp flex align-center justify-between">
                                        <div class="payment-card-content">
                                            <p>{{ __('Pay your order using the most known and secure platform for online money transfers. You will be redirected to Paytab to finish complete your purchase.') }}</p>
                                        </div>
                                        <div class="payment-card-image flex align-center justify-between">
                                            <div class="payment-image">
                                                <img src="{{ asset('assets/img/paytab.png') }}" alt="payment-icon">
                                            </div>
                                        </div>
                                    </div>
                                    <form method="POST" action="{{ route('pay.with.paytab', $store->slug) }}" class="payment-method-form">
                                        @csrf
                                        <div class="payment-card-btn">
                                            <button type="submit" class="btn">{{ __('Pay Now') }}</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @endif
                        @if(isset($store_payments['is_benefit_enabled']) && $store_payments['is_benefit_enabled'] == 'on')
                            <div class="order-detail-card payment-card">
                                <div class="detail-card-header">
                                    <h2>{{ __('Benefit') }}</h2>
                                </div>
                                <div class="order-detail-body">
                                    <div class="payment-content-wrp flex align-center justify-between">
                                        <div class="payment-card-content">
                                            <p>{{ __('Pay your order using the most known and secure platform for online money transfers. You will be redirected to Benefit to finish complete your purchase.') }}</p>
                                        </div>
                                        <div class="payment-card-image flex align-center justify-between">
                                            <div class="payment-image">
                                                <img src="{{ asset('assets/img/benefit.png') }}" alt="payment-icon">
                                            </div>
                                        </div>
                                    </div>
                                    <form method="POST" action="{{ route('store.benefit.initiate', $store->slug) }}" class="payment-method-form">
                                        @csrf
                                        <div class="payment-card-btn">
                                            <button type="submit" class="btn">{{ __('Pay Now') }}</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @endif
                        @if(isset($store_payments['is_cashfree_enabled']) && $store_payments['is_cashfree_enabled'] == 'on')
                            <div class="order-detail-card payment-card">
                                <div class="detail-card-header">
                                    <h2>{{ __('Cashfree') }}</h2>
                                </div>
                                <div class="order-detail-body">
                                    <div class="payment-content-wrp flex align-center justify-between">
                                        <div class="payment-card-content">
                                            <p>{{ __('Pay your order using the most known and secure platform for online money transfers. You will be redirected to Cashfree to finish complete your purchase.') }}</p>
                                        </div>
                                        <div class="payment-card-image flex align-center justify-between">
                                            <div class="payment-image">
                                                <img src="{{ asset('assets/img/cashfree.png') }}" alt="payment-icon">
                                            </div>
                                        </div>
                                    </div>
                                    <form method="POST" action="{{ route('store.cashfree.initiate', $store->slug) }}" class="payment-method-form">
                                        @csrf
                                        <div class="payment-card-btn">
                                            <button type="submit" class="btn">{{ __('Pay Now') }}</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @endif
                        @if(isset($store_payments['is_aamarpay_enabled']) && $store_payments['is_aamarpay_enabled'] == 'on')
                            <div class="order-detail-card payment-card">
                                <div class="detail-card-header">
                                    <h2>{{ __('Aamarpay') }}</h2>
                                </div>
                                <div class="order-detail-body">
                                    <div class="payment-content-wrp flex align-center justify-between">
                                        <div class="payment-card-content">
                                            <p>{{ __('Pay your order using the most known and secure platform for online money transfers. You will be redirected to Aamarpay to finish complete your purchase.') }}</p>
                                        </div>
                                        <div class="payment-card-image flex align-center justify-between">
                                            <div class="payment-image">
                                                <img src="{{ asset('assets/img/aamarpay.png') }}" alt="payment-icon">
                                            </div>
                                        </div>
                                    </div>
                                    <form method="POST" action="{{ route('store.pay.aamarpay.payment', $store->slug) }}" class="payment-method-form">
                                        @csrf
                                        <div class="payment-card-btn">
                                            <button type="submit" class="btn">{{ __('Pay Now') }}</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @endif
                        @if(isset($store_payments['is_paytr_enabled']) && $store_payments['is_paytr_enabled'] == 'on')
                            <div class="order-detail-card payment-card">
                                <div class="detail-card-header">
                                    <h2>{{ __('Paytr') }}</h2>
                                </div>
                                <div class="order-detail-body">
                                    <div class="payment-content-wrp flex align-center justify-between">
                                        <div class="payment-card-content">
                                            <p>{{ __('Pay your order using the most known and secure platform for online money transfers. You will be redirected to Paytr to finish complete your purchase.') }}</p>
                                        </div>
                                        <div class="payment-card-image flex align-center justify-between">
                                            <div class="payment-image">
                                                <img src="{{ asset('assets/img/paytr.png') }}" alt="payment-icon">
                                            </div>
                                        </div>
                                    </div>
                                    <form method="POST" action="{{ route('order.pay.with.paytr', $store->slug) }}" class="payment-method-form">
                                        @csrf
                                        <div class="payment-card-btn">
                                            <button type="submit" class="btn">{{ __('Pay Now') }}</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @endif
                        @if(isset($store_payments['is_yookassa_enabled']) && $store_payments['is_yookassa_enabled'] == 'on')
                            <div class="order-detail-card payment-card">
                                <div class="detail-card-header">
                                    <h2>{{ __('Yookassa') }}</h2>
                                </div>
                                <div class="order-detail-body">
                                    <div class="payment-content-wrp flex align-center justify-between">
                                        <div class="payment-card-content">
                                            <p>{{ __('Pay your order using the most known and secure platform for online money transfers. You will be redirected to Yookassa to finish complete your purchase.') }}</p>
                                        </div>
                                        <div class="payment-card-image flex align-center justify-between">
                                            <div class="payment-image">
                                                <img src="{{ asset('assets/img/yookassa.png') }}" alt="payment-icon">
                                            </div>
                                        </div>
                                    </div>
                                    <form method="get" action="{{ route('store.with.yookassa', $store->slug) }}" class="payment-method-form">
                                        @csrf
                                        <div class="payment-card-btn">
                                            <button type="submit" class="btn">{{ __('Pay Now') }}</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @endif
                        @if(isset($store_payments['is_midtrans_enabled']) && $store_payments['is_midtrans_enabled'] == 'on')
                            <div class="order-detail-card payment-card">
                                <div class="detail-card-header">
                                    <h2>{{ __('Midtrans') }}</h2>
                                </div>
                                <div class="order-detail-body">
                                    <div class="payment-content-wrp flex align-center justify-between">
                                        <div class="payment-card-content">
                                            <p>{{ __('Pay your order using the most known and secure platform for online money transfers. You will be redirected to Midtrans to finish complete your purchase.') }}</p>
                                        </div>
                                        <div class="payment-card-image flex align-center justify-between">
                                            <div class="payment-image">
                                                <img src="{{ asset('assets/img/midtrans.png') }}" alt="payment-icon">
                                            </div>
                                        </div>
                                    </div>
                                    <form method="get" action="{{ route('order.pay.with.midtrans', $store->slug) }}" class="payment-method-form">
                                        @csrf
                                        <div class="payment-card-btn">
                                            <button type="submit" class="btn">{{ __('Pay Now') }}</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @endif
                        @if(isset($store_payments['is_xendit_enabled']) && $store_payments['is_xendit_enabled'] == 'on')
                            <div class="order-detail-card payment-card">
                                <div class="detail-card-header">
                                    <h2>{{ __('Xendit') }}</h2>
                                </div>
                                <div class="order-detail-body">
                                    <div class="payment-content-wrp flex align-center justify-between">
                                        <div class="payment-card-content">
                                            <p>{{ __('Pay your order using the most known and secure platform for online money transfers. You will be redirected to Xendit to finish complete your purchase.') }}</p>
                                        </div>
                                        <div class="payment-card-image flex align-center justify-between">
                                            <div class="payment-image">
                                                <img src="{{ asset('assets/img/xendit.png') }}" alt="payment-icon">
                                            </div>
                                        </div>
                                    </div>
                                    <form method="get" action="{{ route('order.pay.with.xendit', $store->slug) }}" class="payment-method-form">
                                        @csrf
                                        <div class="payment-card-btn">
                                            <button type="submit" class="btn">{{ __('Pay Now') }}</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @endif
                        @if(isset($store_payments['is_nepalste_enabled']) && $store_payments['is_nepalste_enabled'] == 'on')
                            <div class="order-detail-card payment-card">
                                <div class="detail-card-header">
                                    <h2>{{ __('Nepalste') }}</h2>
                                </div>
                                <div class="order-detail-body">
                                    <div class="payment-content-wrp flex align-center justify-between">
                                        <div class="payment-card-content">
                                            <p>{{ __('Pay your order using the most known and secure platform for online money transfers. You will be redirected to Nepalste to finish complete your purchase.') }}</p>
                                        </div>
                                        <div class="payment-card-image flex align-center justify-between">
                                            <div class="payment-image">
                                                <img src="{{ asset('assets/img/nepalste.png') }}" alt="payment-icon">
                                            </div>
                                        </div>
                                    </div>
                                    <form method="get" action="{{ route('order.with.nepalste', $store->slug) }}" class="payment-method-form">
                                        @csrf
                                        <div class="payment-card-btn">
                                            <button type="submit" class="btn">{{ __('Pay Now') }}</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @endif
                        @if(isset($store_payments['is_paiementpro_enabled']) && $store_payments['is_paiementpro_enabled'] == 'on')
                            <div class="order-detail-card payment-card">
                                <div class="detail-card-header">
                                    <h2>{{ __('Paiement Pro') }}</h2>
                                </div>
                                <div class="order-detail-body">
                                    <div class="payment-content-wrp flex align-center justify-between">
                                        <div class="payment-card-content">
                                            <p>{{ __('Pay your order using the most known and secure platform for online money transfers. You will be redirected to Paiement Pro to finish complete your purchase.') }}</p>
                                        </div>
                                        <div class="payment-card-image flex align-center justify-between">
                                            <div class="payment-image">
                                                <img src="{{ asset('assets/img/paiementpro.png') }}" alt="payment-icon">
                                            </div>
                                        </div>
                                    </div>
                                    <form method="get" action="{{ route('order.with.paiementpro', $store->slug) }}" class="payment-method-form">
                                        @csrf
                                        <div class="payment-content-wrp">
                                            <div class="form-group">
                                                <label>{{__('Mobile Number')}}</label>
                                                <input name="mobile_number" id="mobile_number" type="number" placeholder="Enter Your Mobile Number">
                                            </div>
                                            <div class="form-group">
                                                <label>{{__('Channel')}}</label>
                                                <input name="channel" id="channel" type="text" placeholder="Enter Your Channel Code" required>
                                                <small style="color: red">{{ __('Example : OMCIV2,MOMO,CARD,FLOOZ ,PAYPAL') }}</small>
                                            </div>
                                        </div>
                                        <div class="payment-card-btn">
                                            <button type="submit" class="btn">{{ __('Pay Now') }}</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @endif
                        @if(isset($store_payments['is_fedapay_enabled']) && $store_payments['is_fedapay_enabled'] == 'on')
                            <div class="order-detail-card payment-card">
                                <div class="detail-card-header">
                                    <h2>{{ __('Fedapay') }}</h2>
                                </div>
                                <div class="order-detail-body">
                                    <div class="payment-content-wrp flex align-center justify-between">
                                        <div class="payment-card-content">
                                            <p>{{ __('Pay your order using the most known and secure platform for online money transfers. You will be redirected to Fedapay to finish complete your purchase.') }}</p>
                                        </div>
                                        <div class="payment-card-image flex align-center justify-between">
                                            <div class="payment-image">
                                                <img src="{{ asset('assets/img/fedapay.svg') }}" alt="payment-icon">
                                            </div>
                                        </div>
                                    </div>
                                    <form method="get" action="{{ route('order.with.fedapay', $store->slug) }}" class="payment-method-form">
                                        @csrf
                                        <div class="payment-card-btn">
                                            <button type="submit" class="btn">{{ __('Pay Now') }}</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @endif
                        @if(isset($store_payments['is_payhere_enabled']) && $store_payments['is_payhere_enabled'] == 'on')
                            <div class="order-detail-card payment-card">
                                <div class="detail-card-header">
                                    <h2>{{ __('PayHere') }}</h2>
                                </div>
                                <div class="order-detail-body">
                                    <div class="payment-content-wrp flex align-center justify-between">
                                        <div class="payment-card-content">
                                            <p>{{ __('Pay your order using the most known and secure platform for online money transfers. You will be redirected to PayHere to finish complete your purchase.') }}</p>
                                        </div>
                                        <div class="payment-card-image flex align-center justify-between">
                                            <div class="payment-image">
                                                <img src="{{ asset('assets/img/payhere.png') }}" alt="payment-icon">
                                            </div>
                                        </div>
                                    </div>
                                    <form method="post" action="{{ route('order.with.payhere', $store->slug) }}" class="payment-method-form">
                                        @csrf
                                        <div class="payment-card-btn">
                                            <button type="submit" class="btn">{{ __('Pay Now') }}</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @endif
                        @if(isset($store_payments['is_cinetpay_enabled']) && $store_payments['is_cinetpay_enabled'] == 'on')
                            <div class="order-detail-card payment-card">
                                <div class="detail-card-header">
                                    <h2>{{ __('CinetPay') }}</h2>
                                </div>
                                <div class="order-detail-body">
                                    <div class="payment-content-wrp flex align-center justify-between">
                                        <div class="payment-card-content">
                                            <p>{{ __('Pay your order using the most known and secure platform for online money transfers. You will be redirected to CinetPay to finish complete your purchase.') }}</p>
                                        </div>
                                        <div class="payment-card-image flex align-center justify-between">
                                            <div class="payment-image">
                                                <img src="{{ asset('assets/img/cinetpay.png') }}" alt="payment-icon">
                                            </div>
                                        </div>
                                    </div>
                                    <form method="post" action="{{ route('order.with.cinetpay', $store->slug) }}" class="payment-method-form">
                                        @csrf
                                        <div class="payment-card-btn">
                                            <button type="submit" class="btn">{{ __('Pay Now') }}</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @endif
                        @if(isset($store_payments['is_tap_enabled']) && $store_payments['is_tap_enabled'] == 'on')
                            <div class="order-detail-card payment-card">
                                <div class="detail-card-header">
                                    <h2>{{ __('Tap') }}</h2>
                                </div>
                                <div class="order-detail-body">
                                    <div class="payment-content-wrp flex align-center justify-between">
                                        <div class="payment-card-content">
                                            <p>{{ __('Pay your order using the most known and secure platform for online money transfers. You will be redirected to Tap to finish complete your purchase.') }}</p>
                                        </div>
                                        <div class="payment-card-image flex align-center justify-between">
                                            <div class="payment-image">
                                                <img src="{{ asset('assets/img/tap.png') }}" alt="payment-icon">
                                            </div>
                                        </div>
                                    </div>
                                    <form method="post" action="{{ route('order.with.tap', $store->slug) }}" class="payment-method-form">
                                        @csrf
                                        <div class="payment-card-btn">
                                            <button type="submit" class="btn">{{ __('Pay Now') }}</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @endif
                        @if(isset($store_payments['is_authorizenet_enabled']) && $store_payments['is_authorizenet_enabled'] == 'on')
                            <div class="order-detail-card payment-card">
                                <div class="detail-card-header">
                                    <h2>{{ __('AuthorizeNet') }}</h2>
                                </div>
                                <div class="order-detail-body">
                                    <div class="payment-content-wrp flex align-center justify-between">
                                        <div class="payment-card-content">
                                            <p>{{ __('Pay your order using the most known and secure platform for online money transfers. You will be redirected to AuthorizeNet to finish complete your purchase.') }}</p>
                                        </div>
                                        <div class="payment-card-image flex align-center justify-between">
                                            <div class="payment-image">
                                                <img src="{{ asset('assets/img/authorizenet.png') }}" alt="payment-icon">
                                            </div>
                                        </div>
                                    </div>
                                    <form method="post" action="{{ route('order.with.authorizenet', $store->slug) }}" class="payment-method-form">
                                        @csrf
                                        <div class="payment-card-btn">
                                            <button type="submit" class="btn">{{ __('Pay Now') }}</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @endif
                        @if(isset($store_payments['is_khalti_enabled']) && $store_payments['is_khalti_enabled'] == 'on')
                            <div class="order-detail-card payment-card">
                                <div class="detail-card-header">
                                    <h2>{{ __('Khalti') }}</h2>
                                </div>
                                <div class="order-detail-body">
                                    <div class="payment-content-wrp flex align-center justify-between">
                                        <div class="payment-card-content">
                                            <p>{{ __('Pay your order using the most known and secure platform for online money transfers. You will be redirected to Khalti to finish complete your purchase.') }}</p>
                                        </div>
                                        <div class="payment-card-image flex align-center justify-between">
                                            <div class="payment-image">
                                                <img src="{{ asset('assets/img/khalti.png') }}" alt="payment-icon">
                                            </div>
                                        </div>
                                    </div>
                                    <form method="POST" action="{{ route('order.with.khalti', $store->slug) }}" class="payment-method-form">
                                        @csrf
                                        <div class="payment-card-btn">
                                            <input type="hidden" name="product_id">
                                            <button type="button" class="btn" id="pay_with_khalti">{{ __('Pay Now') }}</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @endif
                        @if(isset($store_payments['is_ozow_enabled']) && $store_payments['is_ozow_enabled'] == 'on')
                            <div class="order-detail-card payment-card">
                                <div class="detail-card-header">
                                    <h2>{{ __('Ozow') }}</h2>
                                </div>
                                <div class="order-detail-body">
                                    <div class="payment-content-wrp flex align-center justify-between">
                                        <div class="payment-card-content">
                                            <p>{{ __('Pay your order using the most known and secure platform for online money transfers. You will be redirected to Ozow to finish complete your purchase.') }}</p>
                                        </div>
                                        <div class="payment-card-image flex align-center justify-between">
                                            <div class="payment-image">
                                                <img src="{{ asset('assets/img/ozow.png') }}" alt="payment-icon">
                                            </div>
                                        </div>
                                    </div>
                                    <form method="post" action="{{ route('order.with.ozow', $store->slug) }}" class="payment-method-form">
                                        @csrf
                                        <div class="payment-card-btn">
                                            <button type="submit" class="btn">{{ __('Pay Now') }}</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @endif

                    </div>
                </div>
                <div class="col-lg-4 col-12">
                    <div class="checkout-right-col sticky-column">
                        <div class="order-detail-card order-summary-card">
                            <div class="detail-card-header">
                               <h2>{{ __('Summary') }}</h2>
                            </div>
                            <div class="mini-cart-has-item" id="cart-body">
                                @if(!empty($products))
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
                                                            <img src="{{ $productImg . $product['image'] }}" alt="">
                                                        </a>
                                                    </div>
                                                    @php
                                                        $total_tax = 0;
                                                    @endphp
                                                    <div class="mini-cart-details flex align-center justify-between">
                                                        <div class="cart-details-left">
                                                            <a href="{{ route('store.product.product_view', [$store->slug, $product['id']]) }}" class="mini-cart-title">{{ $product['product_name'].' - ( ' . $product['variant_name'] .' ) ' }}</a>
                                                            <p>
                                                                {{ $product['quantity'] }} x {{ \App\Models\Utility::priceFormat($product['variant_price']) }}
                                                                @if(!empty($product['tax']))
                                                                    @foreach($product['tax'] as $tax)
                                                                        @php
                                                                            $sub_tax = ($product['variant_price'] * $product['quantity'] * $tax['tax']) / 100;
                                                                            $total_tax += $sub_tax;
                                                                        @endphp

                                                                        + {{ \App\Models\Utility::priceFormat($sub_tax).' ('.$tax['tax_name'].' '.($tax['tax']).'%)' }}
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
                                                            <img src="{{ $productImg . $product['image'] }}" alt="">
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
    
                                                                        + {{ \App\Models\Utility::priceFormat($sub_tax).' ('.$tax['tax_name'].' '.($tax['tax']).'%)' }}
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
                                        <input type="hidden" name="coupon" class="hidd_val" data_id="{{ $coupon_id }}" value="{{ $coupon_price }}">
                                        <ul class="mini-cart-summery">
                                            <li class="flex align-center justify-between">
                                                <span>{{ __('item') }}</span>
                                                <span>{{\App\Models\Utility::priceFormat( !empty($sub_total) ? $sub_total : '0') }}</span>
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
                                                <span class="dicount_price">{{ !empty($discount_price) ? $discount_price : '0.00' }}</span>
                                            </li>
                                            @if($store->enable_shipping == "on")
                                                <li class="flex align-center justify-between shipping_price_add">
                                                    <span>{{ __('Shipping Price') }}</span>
                                                    <span class="shipping_price" data-value="{{ $shipping_price }}">{{ \App\Models\Utility::priceFormat(!empty($shipping_price) ? $shipping_price : 0) }}</span>
                                                </li>
                                            @endif
                                            <li class="flex align-center justify-between">
                                                <span><b>{{ __('Total') }}</b></span>
                                                <div class="mini-total-price final_total_price" id="total_value">
                                                    <input type="hidden" class="product_total" value="{{ $total + $shipping_price - $coupon_price }}">
                                                    <input type="hidden" class="total_pay_price" value="{{ \App\Models\Utility::priceFormat($total) }}">
                                                    <span class="pro_total_price" data-value="{{ $total + $shipping_price - $coupon_price }}"><b>{{ \App\Models\Utility::priceFormat(!empty($total) ? $total + $shipping_price - $coupon_price : 0) }}</b></span> 
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
        </div>
    </section>
</main>
@endsection

@push('script-page')
    <script src="{{asset('custom/libs/jquery-mask-plugin/dist/jquery.mask.min.js')}}"></script>
    @if(isset($store_payments['is_stripe_enabled']) && $store_payments['is_stripe_enabled'] == 'on')
        <script src="https://js.stripe.com/v3/"></script>
        <script type="text/javascript">
            var stripe = Stripe('{{ isset($store_payments['stripe_key']) ? $store_payments['stripe_key'] : '' }}');
            var elements = stripe.elements();

            // Custom styling can be passed to options when creating an Element.
            var style = {
                base: {
                    // Add your base input styles here. For example:
                    fontSize: '14px',
                    color: '#32325d',
                },
            };

            // Create an instance of the card Element.
            var card = elements.create('card', {style: style});
            // Add an instance of the card Element into the `card-element` <div>.
            card.mount('#card-element');

            // Create a token or display an error when the form is submitted.
            var form = document.getElementById('payment-form');
            form.addEventListener('submit', function (event) {
                event.preventDefault();

                stripe.createToken(card).then(function (result) {
                    if (result.error) {
                        $("#card-errors").html(result.error.message);
                        show_toastr('Error', result.error.message, 'error');
                    } else {
                        // Send the token to your server.
                        stripeTokenHandler(result.token);
                    }
                });
            });

            function stripeTokenHandler(token) {
                // Insert the token ID into the form so it gets submitted to the server
                var form = document.getElementById('payment-form');
                var hiddenInput = document.createElement('input');
                hiddenInput.setAttribute('type', 'hidden');
                hiddenInput.setAttribute('name', 'stripeToken');
                hiddenInput.setAttribute('value', token.id);
                form.appendChild(hiddenInput);

                form.submit();
            }
        </script>
    @endif
    @if($store['enable_whatsapp'] == 'on')
        <script>
            $(document).on('click', '#owner-whatsapp', function () {
                $('#owner-whatsapp').prop('disabled',true);
                var product_array = '{{$encode_product}}';
                var product = JSON.parse(product_array.replace(/&quot;/g, '"'));
                var order_id = '{{$order_id = time()}}';
                var total_price = $('.pro_total_price').attr('data-value');
                var coupon_id = $('.hidden_coupon').attr('data_id');
                var dicount_price = $('.dicount_price').html();

                var data = {
                    type: 'whatsapp',
                    coupon_id: coupon_id,
                    dicount_price: dicount_price,
                    total_price: total_price,
                    product: product,
                    order_id: order_id,
                    wts_number: $('#wts_number').val()
                }
                getWhatsappUrl(dicount_price, total_price, coupon_id, data);

                $.ajax({
                    url: '{{ route('user.whatsapp', $store->slug) }}',
                    method: 'POST',
                    data: data,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (data) {
                        if (data.status == 'success') {
                            $('#owner-whatsapp').prop('disabled',true);
                            removesession();
                            show_toastr(data["status"],data["success"], data["status"]);
                            setTimeout(function () {
                                var get_url_msg_url = $('#return_url').val();
                                var append_href = get_url_msg_url + '{{route('user.order',[$store->slug,Crypt::encrypt(!empty($order->id) ? $order->id + 1 : 0 + 1)])}}';
                                console.log(append_href)
                                window.open(append_href, '_blank');
                            }, 1000);
                            setTimeout(function () {
                                var url = '{{ route('store-complete.complete', [$store->slug, ":id"]) }}';
                                url = url.replace(':id', data.order_id);

                                window.location.href = url;
                            }, 1000);

                        } else {
                            $('#owner-whatsapp').prop('disabled',false);
                            show_toastr("Error", data.success, data["status"]);
                        }
                    }
                });

            });

            //for create/get Whatsapp Url
            function getWhatsappUrl(coupon = '', finalprice = '', coupon_id = '', data = '') {
                $.ajax({
                    url: '{{ route('get.whatsappurl', $store->slug) }}',
                    method: 'post',
                    data: {dicount_price: coupon, finalprice: finalprice, coupon_id: coupon_id, data: data},
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (data) {
                        if (data.status == 'success') {
                            $('#return_url').val(data.url);
                            $('#return_order_id').val(data.order_id);

                        } else {
                            $('#return_url').val('');
                            show_toastr("Error", data.success, data["status"]);
                        }
                    }
                });
            }
        </script>
    @endif
    @if($store['enable_telegram'] == 'on')
        <script>
            $(document).on('click', '#owner-telegram', function () {
                $('#owner-telegram').prop('disabled',true);
                var product_array = '{{$encode_product}}';
                var product = JSON.parse(product_array.replace(/&quot;/g, '"'));
                var order_id = '{{$order_id = time()}}';
                var total_price = $('.pro_total_price').attr('data-value');
                var coupon_id = $('.hidden_coupon').attr('data_id');
                var dicount_price = $('.dicount_price').html();

                var data = {
                    type: 'telegram',
                    coupon_id: coupon_id,
                    dicount_price: dicount_price,
                    total_price: total_price,
                    product: product,
                    order_id: order_id,
                }

                getTelegramUrl(dicount_price, total_price, coupon_id, data);

                $.ajax({
                    url: '{{ route('user.telegram', $store->slug) }}',
                    method: 'POST',
                    data: data,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (data) {
                        if (data.status == 'success') {
                            $('#owner-telegram').prop('disabled',true);
                            show_toastr(data["status"],data["success"], data["status"]);

                            setTimeout(function () {
                                var url = '{{ route('store-complete.complete', [$store->slug, ":id"]) }}';
                                url = url.replace(':id', data.order_id);

                                window.location.href = url;
                            }, 1000);
                            removesession();

                        } else {
                            $('#owner-telegram').prop('disabled',false);
                            show_toastr("Error", data.success, data["status"]);
                        }
                    }
                });
            });

            //for create/get Telegram Url
            function getTelegramUrl(coupon = '', finalprice = '', coupon_id = '', data = '') {
                $.ajax({
                    url: '{{ route('get.whatsappurl', $store->slug) }}',
                    method: 'post',
                    data: {dicount_price: coupon, finalprice: finalprice, coupon_id: coupon_id, data: data},
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (data) {
                        if (data.status == 'success') {
                            $('#return_url').val(data.url);
                            $('#return_order_id').val(data.order_id);

                        } else {
                            $('#return_url').val('');
                            show_toastr("Error", data.success, data["status"]);
                        }
                    }
                });
            }
        </script>
    @endif
    @if($store['enable_cod'] == 'on')
        <script>
            $(document).on('click', '#cash_on_delivery', function () {
                $('#cash_on_delivery').prop('disabled',true);
                var product_array = '{{$encode_product}}';
                var product = JSON.parse(product_array.replace(/&quot;/g, '"'));
                var order_id = '{{$order_id = time()}}';

                var total_price = $('.pro_total_price').attr('data-value');
                var coupon_id = $('.hidden_coupon').attr('data_id');
                var dicount_price = $('.dicount_price').html();
                var data = {
                    coupon_id: coupon_id,
                    dicount_price: dicount_price,
                    total_price: total_price,
                    product: product,
                    order_id: order_id,
                }

                $.ajax({
                    url: '{{ route('user.cod', $store->slug) }}',
                    method: 'POST',
                    data: data,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (data) {
                        if (data.status == 'success') {
                            $('#cash_on_delivery').prop('disabled',true);
                            show_toastr(data["status"],data["success"], data["status"]);

                            setTimeout(function () {
                                var url = '{{ route('store-complete.complete', [$store->slug, ":id"]) }}';
                                url = url.replace(':id', data.order_id);
                                window.location.href = url;
                            }, 1000);
                            removesession();
                        } else {
                            $('#cash_on_delivery').prop('disabled',false);
                            show_toastr("Error", data.success, data["status"]);
                        }
                    }
                });
            });
        </script>
    @endif
    @if($store['enable_bank'] == 'on')
        <script>
            $(document).on('click', '#bank_transfer', function() {
                $('#bank_transfer').prop('disabled',true);
                var product_array = '{!! $encode_product !!}';
                var product = JSON.parse(product_array.replace(/&quot;/g, '"'));
                var order_id = '{{ $order_id = time() }}';
                var total_price = $('.pro_total_price').attr('data-value');
                var coupon_id = $('.hidden_coupon').attr('data_id');
                var dicount_price = $('.dicount_price').html();
                var files = $('#bank_transfer_invoice')[0].files;

                var formData = new FormData($("#bank_transfer_form")[0]);
                formData.append('product', product_array);
                formData.append('order_id', order_id);
                formData.append('total_price', total_price);
                formData.append('coupon_id', coupon_id);
                formData.append('dicount_price', dicount_price);
                formData.append('files', files);

                $.ajax({
                    url: '{{ route('user.bank_transfer', $store->slug) }}',
                    method: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(data) {
                        if (data.status == 'success') {
                            $('#bank_transfer').prop('disabled',true);
                            removesession();
                            show_toastr(data["status"],data["success"], data["status"]);
                            setTimeout(function() {
                                var url =
                                    '{{ route('store-complete.complete', [$store->slug, ':id']) }}';
                                url = url.replace(':id', data.order_id);
                                window.location.href = url;
                            }, 1000);
                        } else {
                            $('#bank_transfer').prop('disabled',false);
                            show_toastr("Error", data.success, data["status"]);
                        }
                    }
                });
            });
        </script>
    @endif
    <script>
        function removesession(slug) {
            $.ajax({
                url: '{{ route('remove.session', $store->slug) }}',
                method: 'get',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (data) {

                }
            });
        }
    </script>
    @if(isset($store_payments['is_payfast_enabled']) && $store_payments['is_payfast_enabled'] == 'on')
        <script>
            $(document).ready(function(){
                get_payfast_status(amount = 0,coupon = null);
            })
            function get_payfast_status(amount,coupon){
                var product_id = $('#product_id').val();
                var coupon_id = $('.hidden_coupon').attr('data_id');
                $.ajax({
                    url: '{{ route('payfast.prepare.payment', $store->slug) }}',
                    method: 'POST',
                    data : {
                        'product_id' : product_id,
                        'coupon_amount' : amount,
                        'coupon_id' : coupon_id
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (data) {
                        if (data.success == true) {
                            $('#get-payfast-inputs').append(data.inputs);

                        }else{
                            show_toastr('Error', data.inputs, 'error')
                        }
                    }
                });
            }
        </script>
    @endif

    @if(isset($store_payments['is_khalti_enabled']) && $store_payments['is_khalti_enabled'] == 'on')
        <script src="https://khalti.s3.ap-south-1.amazonaws.com/KPG/dist/2020.12.17.0.0.0/khalti-checkout.iffe.js"></script>
        <script>
            var config = {
                "publicKey": "{{ isset($store_payments['khalti_public_key']) ? $store_payments['khalti_public_key'] : '' }}",
                "productIdentity": "1234567890",
                "productName": "demo",
                "productUrl": "{{ env('APP_URL') }}",
                "paymentPreference": [
                    "KHALTI",
                    "EBANKING",
                    "MOBILE_BANKING",
                    "CONNECT_IPS",
                    "SCT",
                ],
                "eventHandler": {
                    onSuccess(payload) {
                        if (payload.status == 200) {
                            var product_array = '{{$encode_product}}';
                            var product = JSON.parse(product_array.replace(/&quot;/g, '"'));
                            var order_id = '{{$order_id = time()}}';

                            var total_price = $('.pro_total_price').attr('data-value');
                            var coupon_id = $('.hidden_coupon').attr('data_id');
                            var dicount_price = $('.dicount_price').html();
                            var data = {
                                payload: payload,
                                coupon_id: coupon_id,
                                dicount_price: dicount_price,
                                total_price: total_price,
                                product: product,
                                order_id: order_id,
                            }
                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-Token': '{{ csrf_token() }}'
                                }
                            });
                            $.ajax({
                                url: "{{ route('order.get.khalti.status', $store->slug) }}",
                                method: 'POST',
                                data: data,
                                success: function(data) {
                                    if (data.status == 'success') {
                                            show_toastr(data["status"],data["success"], data["status"]);
                                        setTimeout(() => {
                                            var url = '{{ route('store-complete.complete', [$store->slug, ":id"]) }}';
                                                url = url.replace(':id', data.order_id);
                                                window.location.href = url;
                                        }, 1000);
                                    } else {
                                        show_toastr('Error', 'Payment Failed', 'error');
                                    }
                                },
                                error: function(err) {
                                    show_toastr('Error', err.response, 'error');
                                },
                            });
                        }
                    },
                    onError(error) {
                        show_toastr('Error', error, 'error')
                    },
                    onClose() {}
                }

            };

            var checkout = new KhaltiCheckout(config);

            $(document).on("click", "#pay_with_khalti", function(event) {
                event.preventDefault();
                    var product_array = '{{$encode_product}}';
                    var product = JSON.parse(product_array.replace(/&quot;/g, '"'));
                    var order_id = '{{$order_id = time()}}';

                    var total_price = $('.pro_total_price').attr('data-value');
                    var coupon_id = $('.hidden_coupon').attr('data_id');
                    var dicount_price = $('.dicount_price').html();
                    var data = {
                        coupon_id: coupon_id,
                        dicount_price: dicount_price,
                        total_price: total_price,
                        product: product,
                        order_id: order_id,
                    }

                var coupon_code = $('#khalti_coupan').val();
                var plan_id = $('.khalti_plan_id').val();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "{{ route('order.with.khalti', $store->slug) }}",
                    method: 'POST',
                    data: data,
                    success: function(data) {
                        if (data == 0) {
                            show_toastr('Success', 'Your Order Successfully Added', 'success');
                            setTimeout(() => {
                                var url = '{{ route('store-complete.complete', [$store->slug, ":id"]) }}';
                                    url = url.replace(':id', data.order_id);
                                    window.location.href = url;
                            }, 1000);
                        } else {
                            let price = data * 100;
                            checkout.show({
                                amount: price
                            });
                        }
                    }
                });
            })
        </script>
    @endif
@endpush
