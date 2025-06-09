@extends('layouts.admin')
@php
$dir = asset(Storage::url('uploads/plan'));
@endphp
@push('script-page')
<script src="https://js.stripe.com/v3/"></script>
<script src="https://js.paystack.co/v1/inline.js"></script>
<script src="https://api.ravepay.co/flwv3-pug/getpaidx/api/flwpbf-inline.js"></script>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script>
        var type = window.location.hash.substr(1);
        $('.list-group-item').removeClass('active');
        $('.list-group-item').removeClass('text-primary');
        if (type != '') {
            $('a[href="#' + type + '"]').addClass('active').removeClass('text-primary');
        } else {
            $('.list-group-item:eq(0)').addClass('active').removeClass('text-primary');
        }

        $(document).on('click', '.list-group-item', function() {
            $('.list-group-item').removeClass('active');
            $('.list-group-item').removeClass('text-primary');
            setTimeout(() => {
                $(this).addClass('active').removeClass('text-primary');
            }, 10);
        });

        var scrollSpy = new bootstrap.ScrollSpy(document.body, {
            target: '#useradd-sidenav',
            offset: 300
        })

        $(document).ready(function () {
            $(document).on('click', '.apply-coupon', function () {
            var ele = $(this);
            var coupon = ele.closest('.row').find('.coupon').val();
            $.ajax({
                url: '{{route('apply.coupon')}}',
                datType: 'json',
                data: {
                    plan_id: '{{\Illuminate\Support\Facades\Crypt::encrypt($plan->id)}}',
                    coupon: coupon
                },
                success: function (data) {
                
                    if(ele.closest($('#payfast-form')).length == 1){
                        get_payfast_status(data.price,coupon);
                    }
                    $('.final-price').val(data.price);
                    $('.price-final').text(data.price);
                    $('#final_price_pay').val(data.price);
                    $('#mollie_total_price').val(data.price);
                    $('#skrill_total_price').val(data.price);
                    $('#coingate_total_price').val(data.price);
                   // $('#stripe_coupon, #paypal_coupon, #skrill_coupon,#coingate_coupon,#toyyibpay_coupan').val(coupon);
                    if (data.is_success == true) {
                        show_toastr('Success', data.message, 'success');
                    } else if (data.is_success == false) {
                        show_toastr('Error', data.message, 'error');
                    } else {
                        show_toastr('Error', 'Coupon code is required', 'error');
                    }
                }
            })
        });
    });
    </script>
    @if(isset($admin_payments_details['is_stripe_enabled']) && $admin_payments_details['is_stripe_enabled']=='on')
        <script type="text/javascript">
            var stripe = Stripe('{{ isset($admin_payments_details['stripe_key']) ? $admin_payments_details['stripe_key'] : '' }}');
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

                // Submit the form
                form.submit();
            }
        </script>
    @endif

    <script>
        function preparePayment(ele, payment) {
            // var coupon = $(ele).closest('.row').find('.coupon').val();
            var coupon = $(ele).val();
            var amount = 0;
            $.ajax({
                url: '{{route('plan.prepare.amount')}}',
                datType: 'json',
                data: {
                    plan_id: '{{\Illuminate\Support\Facades\Crypt::encrypt($plan->id)}}',
                    coupon: coupon
                },
                success: function (data) {

                    if (data.is_success == true) {
                        amount = data.price;
                        $('#coupon_use_id').val(data.coupon_id);
                        if (payment == 'paystack') {
                            payWithPaystack(amount);
                        }
                        if (payment == 'flutterwave') {
                            payWithRave(amount);
                        }
                        if (payment == 'razorpay') {
                            payRazorPay(amount);
                        }
                        if (payment == 'mercado') {
                            payMercado(amount);
                        }
                    } else {
                        show_toastr('Error', 'Paymenent request failed', 'error');
                    }

                }
            })
        }
    </script>

    @if(isset($admin_payments_details['is_paystack_enabled']) && $admin_payments_details['is_paystack_enabled']=='on')
        <script>
            function payWithPaystack(amount) {
                var coupon_id = $('#coupon_use_id').val();
                var paystack_callback = "{{ url('/paystack-plan') }}";
                var handler = PaystackPop.setup({
                    key: '{{ $admin_payments_details['paystack_public_key']  }}',
                    email: '{{Auth::user()->email}}',
                    amount: amount * 100,
                    currency: '{{ isset($admin_payments_details['currency']) && !empty($admin_payments_details['currency']) ? $admin_payments_details['currency'] : "USD" }}',
                    ref: 'pay_ref_id' + Math.floor((Math.random() * 1000000000) +
                        1
                    ),
                    // generates a pseudo-unique reference. Please replace with a reference you generated. Or remove the line entirely so our API will generate one for you
                    metadata: {
                        custom_fields: [{
                            display_name: "Mobile Number",
                            variable_name: "mobile_number",
                        }]
                    },

                    callback: function (response) {
                        {{--console.log(paystack_callback +'/'+ response.reference + '/' + '{{\Illuminate\Support\Facades\Crypt::encrypt($plan->id)}}');--}}
                            window.location.href = paystack_callback + '/' + response.reference + '/' + '{{\Illuminate\Support\Facades\Crypt::encrypt($plan->id)}}?coupon_id=' + coupon_id;
                    },
                    onClose: function () {
                        alert('window closed');
                    }
                });
                handler.openIframe();
            }
        </script>
    @endif

    @if(isset($admin_payments_details['is_flutterwave_enabled']) && $admin_payments_details['is_flutterwave_enabled']=='on')
        {{-- Flutterwave JAVASCRIPT FUNCTION --}}
        <script>
            function payWithRave(amount) {
                var coupon_id = $('#coupon_use_id').val();
                var API_publicKey = '{{ $admin_payments_details['flutterwave_public_key']  }}';
                var nowTim = "{{ date('d-m-Y-h-i-a') }}";
                var flutter_callback = "{{ url('/flutterwave-plan') }}";
                var x = getpaidSetup({
                    PBFPubKey: API_publicKey,
                    customer_email: '{{Auth::user()->email}}',
                    amount: amount,
                    currency: '{{isset($admin_payments_details['currency']) && !empty($admin_payments_details['currency']) ? $admin_payments_details['currency'] : "USD"}}',
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
                            window.location.href = flutter_callback + '/' + txref + '/' + '{{\Illuminate\Support\Facades\Crypt::encrypt($plan->id)}}?coupon_id=' + coupon_id;
                        } else {
                            // redirect to a failure page.
                        }
                        x.close(); // use this to close the modal immediately after payment.
                    }
                });
            }
        </script>
    @endif

    @if(isset($admin_payments_details['is_razorpay_enabled']) && $admin_payments_details['is_razorpay_enabled']=='on')
        {{-- Razorpay JAVASCRIPT FUNCTION --}}
        @php
            $logo         =asset(Storage::url('uploads/logo/'));
            $company_logo =\App\Models\Utility::getValByName('company_logo');
        @endphp
        <script>
            function payRazorPay(amount) {
                var razorPay_callback = '{{url('razorpay-plan')}}';
                var totalAmount = amount * 100;
                var coupon_id = $('#coupon_use_id').val();
                var options = {
                    "key": "{{ $admin_payments_details['razorpay_public_key']  }}", // your Razorpay Key Id
                    "amount": totalAmount,
                    "name": 'Plan',
                    "currency": '{{ isset($admin_payments_details['currency']) && !empty($admin_payments_details['currency']) ? $admin_payments_details['currency'] : "USD" }}',
                    "description": "",
                    "image": "{{$logo.'/'.(isset($company_logo) && !empty($company_logo)?$company_logo:'logo-dark.png')}}",
                    "handler": function (response) {
                        window.location.href = razorPay_callback + '/' + response.razorpay_payment_id + '/' + '{{\Illuminate\Support\Facades\Crypt::encrypt($plan->id)}}?coupon_id=' + coupon_id;
                    },
                    "theme": {
                        "color": "#528FF0"
                    }
                };
                var rzp1 = new Razorpay(options);
                rzp1.open();
            }
        </script>
    @endif

    @if(isset($admin_payments_details['is_mercado_enabled']) && $admin_payments_details['is_mercado_enabled']=='on')
        {{-- Mercado JAVASCRIPT FUNCTION --}}
        <script>
            function payMercado(amount) {
                var coupon_id = $('#coupon_use_id').val();
                var data = {
                    coupon_id: coupon_id,
                    total_price: amount,
                    plan: {{$plan->id}},
                }
                console.log(data);
                $.ajax({
                    url: '{{ route('mercadopago.prepare.plan') }}',
                    method: 'POST',
                    data: data,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (data) {
                        if (data.status == 'success') {
                            window.location.href = data.url;
                        } else {
                            show_toastr("Error", data.error, data["status"]);
                        }
                    }
                });
            }
        </script>
    @endif

    @if (isset($admin_payments_details['is_payfast_enabled']) && $admin_payments_details['is_payfast_enabled'] == 'on' && !empty($admin_payments_details['payfast_merchant_id']) && !empty($admin_payments_details['payfast_merchant_key']))
        <script>
            $(document).ready(function(){
                get_payfast_status(amount = 0,coupon = null);
            })

            function get_payfast_status(amount,coupon){
                var plan_id = $('#plan_id').val();

                $.ajax({
                    url: '{{ route('payfast.payment') }}',
                    method: 'POST',
                    data : {
                        'plan_id' : plan_id,
                        'coupon_amount' : amount,
                        'coupon_code' : coupon
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

    @if (isset($admin_payments_details['is_khalti_enabled']) && $admin_payments_details['is_khalti_enabled'] == 'on')
        <script src="https://khalti.s3.ap-south-1.amazonaws.com/KPG/dist/2020.12.17.0.0.0/khalti-checkout.iffe.js"></script>

        <script>
            var config = {
                "publicKey": "{{ isset($admin_payments_details['khalti_public_key']) ? $admin_payments_details['khalti_public_key'] : '' }}",
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
                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-Token': '{{ csrf_token() }}'
                                }
                            });
                            $.ajax({
                                url: "{{ route('plan.get.khalti.status') }}",
                                method: 'POST',
                                data: {
                                    'payload': payload,
                                    'coupon_code': $('#khalti_coupan').val(),
                                    'plan_id': $('.khalti_plan_id').val(),
                                },
                                success: function(data) {
                                    if (data.status_code === 200) {

                                        show_toastr('Success', 'Plan activated Successfully!', 'success');
                                        setTimeout(() => {
                                            window.location.href = "{{ route('plans.index') }}";
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
                event.preventDefault()
                var coupon_code = $('#khalti_coupan').val();
                var plan_id = $('.khalti_plan_id').val();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "{{ route('plan.pay.with.khalti') }}",
                    method: 'POST',
                    data: {
                        'coupon_code': coupon_code,
                        'plan_id': plan_id,
                    },
                    success: function(data) {
                        if (data == 0) {
                            show_toastr('Success', 'Plan Successfully Activated', 'success');
                            setTimeout(() => {
                                window.location.href = '{{ route('plans.index') }}';
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
@php
$dir = asset(Storage::url('uploads/plan'));
$dir_payment = asset(Storage::url('uploads/payments'));
@endphp
@section('page-title')
    {{ __('Order Summary') }}
@endsection
@section('title')
    <div class="d-inline-block">
        <h5 class="h4 d-inline-block font-weight-400 mb-0 text-white">{{ __('Order Summary') }}</h5>
    </div>
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('plans.index') }}">{{ __('Plan') }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('Order Summary') }}</li>
@endsection
@section('action-btn')
@endsection
@section('content')
<input type="hidden" id="coupon_use_id" name="user_coupon_id">
    <div class="row mt-4">
        <!-- [ sample-page ] start -->
        <div class="col-sm-12">
            <div class="row row-gap">
                <div class="col-xl-3">
                    <div class="sticky-top" style="top:30px">
                        <div class="card ">
                            <div class="list-group list-group-flush" id="useradd-sidenav">
                                @if (isset($admin_payments_details['is_stripe_enabled']) && $admin_payments_details['is_stripe_enabled'] == 'on')
                                    <a href="#stripe_payment"
                                        class="list-group-item list-group-item-action border-0">{{ __('Stripe') }}
                                        <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                                    </a>
                                @endif
                                @if (isset($admin_payments_details['manually_enabled']) && $admin_payments_details['manually_enabled'] == 'on')
                                    <a href="#manually_payment"
                                        class="list-group-item list-group-item-action border-0">{{ __('Manually Payment') }}
                                        <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                                    </a>
                                @endif
                                @if (isset($admin_payments_details['enable_bank']) && $admin_payments_details['enable_bank'] == 'on')
                                    <a href="#bank_payment"
                                        class="list-group-item list-group-item-action border-0">{{ __('Bank Transfer') }}
                                        <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                                    </a>
                                @endif

                                @if (isset($admin_payments_details['is_paypal_enabled']) && $admin_payments_details['is_paypal_enabled'] == 'on')
                                    <a href="#paypal_payment"
                                        class="list-group-item list-group-item-action border-0">{{ __('Paypal') }}
                                        <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                                    </a>
                                @endif

                                @if (isset($admin_payments_details['is_paystack_enabled']) && $admin_payments_details['is_paystack_enabled'] == 'on')
                                    <a href="#paystack_payment"
                                        class="list-group-item list-group-item-action border-0">{{ __('Paystack') }}<div
                                            class="float-end"><i class="ti ti-chevron-right"></i></div>
                                    </a>
                                @endif


                                @if (isset($admin_payments_details['is_flutterwave_enabled']) && $admin_payments_details['is_flutterwave_enabled'] == 'on')
                                    <a href="#flutterwave_payment"
                                        class="list-group-item list-group-item-action border-0">{{ __('Flutterwave') }}<div
                                            class="float-end"><i class="ti ti-chevron-right"></i></div></a>
                                @endif

                                @if (isset($admin_payments_details['is_razorpay_enabled']) && $admin_payments_details['is_razorpay_enabled'] == 'on')
                                    <a href="#razorpay_payment"
                                        class="list-group-item list-group-item-action border-0">{{ __('Razorpay') }} <div
                                            class="float-end"><i class="ti ti-chevron-right"></i></div></a>
                                @endif

                                @if (isset($admin_payments_details['is_mercado_enabled']) && $admin_payments_details['is_mercado_enabled'] == 'on')
                                    <a href="#mercado_payment"
                                        class="list-group-item list-group-item-action border-0">{{ __('Mercado Pago') }}<div
                                            class="float-end"><i class="ti ti-chevron-right"></i></div></a>
                                @endif

                                @if (isset($admin_payments_details['is_paytm_enabled']) && $admin_payments_details['is_paytm_enabled'] == 'on')
                                    <a href="#paytm_payment"
                                        class="list-group-item list-group-item-action border-0">{{ __('Paytm') }}
                                        <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                                    </a>
                                @endif

                                @if (isset($admin_payments_details['is_mollie_enabled']) && $admin_payments_details['is_mollie_enabled'] == 'on')
                                    <a href="#mollie_payment"
                                        class="list-group-item list-group-item-action border-0">{{ __('Mollie') }}<div
                                            class="float-end"><i class="ti ti-chevron-right"></i></div></a>
                                @endif

                                @if (isset($admin_payments_details['is_skrill_enabled']) && $admin_payments_details['is_skrill_enabled'] == 'on')
                                    <a href="#skrill_payment"
                                        class="list-group-item list-group-item-action border-0">{{ __('Skrill') }}<div
                                            class="float-end"><i class="ti ti-chevron-right"></i></div></a>
                                @endif

                                @if (isset($admin_payments_details['is_coingate_enabled']) && $admin_payments_details['is_coingate_enabled'] == 'on')
                                    <a href="#coingate_payment"
                                        class="list-group-item list-group-item-action border-0">{{ __('Coingate') }}<div
                                            class="float-end"><i class="ti ti-chevron-right"></i></div></a>
                                @endif

                                @if (isset($admin_payments_details['is_paymentwall_enabled']) && $admin_payments_details['is_paymentwall_enabled'] == 'on')
                                    <a href="#paymentwall_payment"
                                        class="list-group-item list-group-item-action border-0">{{ __('Paymentwall') }}<div
                                            class="float-end"><i class="ti ti-chevron-right"></i></div></a>
                                @endif
                                @if (isset($admin_payments_details['is_toyyibpay_enabled']) && $admin_payments_details['is_toyyibpay_enabled'] == 'on')
                                    <a href="#toyyibpay_payment" class="list-group-item list-group-item-action border-0">{{ __('Toyyibpay') }}<div
                                            class="float-end"><i class="ti ti-chevron-right"></i></div></a>
                                @endif
                                @if (isset($admin_payments_details['is_payfast_enabled']) && $admin_payments_details['is_payfast_enabled'] == 'on')
                                    <a href="#payfast_payment" class="list-group-item list-group-item-action border-0">{{ __('Payfast') }}<div
                                        class="float-end"><i class="ti ti-chevron-right"></i></div></a>
                                @endif
                                @if (isset($admin_payments_details['is_iyzipay_enabled']) && $admin_payments_details['is_iyzipay_enabled'] == 'on')
                                    <a href="#iyzipay_payment" class="list-group-item list-group-item-action border-0">{{ __('Iyzipay') }}<div
                                        class="float-end"><i class="ti ti-chevron-right"></i></div></a>
                                @endif
                                @if (isset($admin_payments_details['is_paytab_enabled']) && $admin_payments_details['is_paytab_enabled'] == 'on')
                                    <a href="#paytab_payment" class="list-group-item list-group-item-action border-0">{{ __('Paytab') }}<div
                                        class="float-end"><i class="ti ti-chevron-right"></i></div></a>
                                @endif
                                @if (isset($admin_payments_details['is_benefit_enabled']) && $admin_payments_details['is_benefit_enabled'] == 'on')
                                    <a href="#benefit_payment" class="list-group-item list-group-item-action border-0">{{ __('Benefit') }}<div
                                        class="float-end"><i class="ti ti-chevron-right"></i></div></a>
                                @endif
                                @if (isset($admin_payments_details['is_cashfree_enabled']) && $admin_payments_details['is_cashfree_enabled'] == 'on')
                                    <a href="#cashfree_payment" class="list-group-item list-group-item-action border-0">{{ __('Cashfree') }}<div
                                        class="float-end"><i class="ti ti-chevron-right"></i></div></a>
                                @endif
                                @if (isset($admin_payments_details['is_aamarpay_enabled']) && $admin_payments_details['is_aamarpay_enabled'] == 'on')
                                    <a href="#aamarpay_payment" class="list-group-item list-group-item-action border-0">{{ __('Aamarpay') }}<div
                                        class="float-end"><i class="ti ti-chevron-right"></i></div></a>
                                @endif
                                @if (isset($admin_payments_details['is_paytr_enabled']) && $admin_payments_details['is_paytr_enabled'] == 'on')
                                    <a href="#paytr_payment" class="list-group-item list-group-item-action border-0">{{ __('Paytr') }}<div
                                        class="float-end"><i class="ti ti-chevron-right"></i></div></a>
                                @endif
                                @if (isset($admin_payments_details['is_yookassa_enabled']) && $admin_payments_details['is_yookassa_enabled'] == 'on')
                                    <a href="#yookassa_payment" class="list-group-item list-group-item-action border-0">{{ __('Yookassa') }}<div
                                        class="float-end"><i class="ti ti-chevron-right"></i></div></a>
                                @endif
                                @if (isset($admin_payments_details['is_midtrans_enabled']) && $admin_payments_details['is_midtrans_enabled'] == 'on')
                                    <a href="#midtrans_payment" class="list-group-item list-group-item-action border-0">{{ __('Midtrans') }}<div
                                        class="float-end"><i class="ti ti-chevron-right"></i></div></a>
                                @endif
                                @if (isset($admin_payments_details['is_xendit_enabled']) && $admin_payments_details['is_xendit_enabled'] == 'on')
                                    <a href="#xendit_payment" class="list-group-item list-group-item-action border-0">{{ __('Xendit') }}<div
                                        class="float-end"><i class="ti ti-chevron-right"></i></div></a>
                                @endif
                                @if (isset($admin_payments_details['is_nepalste_enabled']) && $admin_payments_details['is_nepalste_enabled'] == 'on')
                                    <a href="#nepalste_payment" class="list-group-item list-group-item-action border-0">{{ __('Nepalste') }}<div
                                        class="float-end"><i class="ti ti-chevron-right"></i></div></a>
                                @endif
                                @if (isset($admin_payments_details['is_paiementpro_enabled']) && $admin_payments_details['is_paiementpro_enabled'] == 'on')
                                    <a href="#paiementpro_payment" class="list-group-item list-group-item-action border-0">{{ __('Paiement Pro') }}<div
                                        class="float-end"><i class="ti ti-chevron-right"></i></div></a>
                                @endif
                                @if (isset($admin_payments_details['is_fedapay_enabled']) && $admin_payments_details['is_fedapay_enabled'] == 'on')
                                    <a href="#fedapay_payment" class="list-group-item list-group-item-action border-0">{{ __('Fedapay') }}<div
                                        class="float-end"><i class="ti ti-chevron-right"></i></div></a>
                                @endif
                                @if (isset($admin_payments_details['is_payhere_enabled']) && $admin_payments_details['is_payhere_enabled'] == 'on')
                                    <a href="#payhere_payment" class="list-group-item list-group-item-action border-0">{{ __('PayHere') }}<div
                                        class="float-end"><i class="ti ti-chevron-right"></i></div></a>
                                @endif
                                @if (isset($admin_payments_details['is_cinetpay_enabled']) && $admin_payments_details['is_cinetpay_enabled'] == 'on')
                                    <a href="#cinetpay_payment" class="list-group-item list-group-item-action border-0">{{ __('CinetPay') }}<div
                                        class="float-end"><i class="ti ti-chevron-right"></i></div></a>
                                @endif
                                @if (isset($admin_payments_details['is_tap_enabled']) && $admin_payments_details['is_tap_enabled'] == 'on')
                                    <a href="#tap_payment" class="list-group-item list-group-item-action border-0">{{ __('Tap') }}<div
                                        class="float-end"><i class="ti ti-chevron-right"></i></div></a>
                                @endif
                                @if (isset($admin_payments_details['is_authorizenet_enabled']) && $admin_payments_details['is_authorizenet_enabled'] == 'on')
                                    <a href="#authorizenet_payment" class="list-group-item list-group-item-action border-0">{{ __('AuthorizeNet') }}<div
                                        class="float-end"><i class="ti ti-chevron-right"></i></div></a>
                                @endif
                                @if (isset($admin_payments_details['is_khalti_enabled']) && $admin_payments_details['is_khalti_enabled'] == 'on')
                                    <a href="#khalti_payment" class="list-group-item list-group-item-action border-0">{{ __('Khalti') }}<div
                                        class="float-end"><i class="ti ti-chevron-right"></i></div></a>
                                @endif
                                @if (isset($admin_payments_details['is_ozow_enabled']) && $admin_payments_details['is_ozow_enabled'] == 'on')
                                    <a href="#ozow_payment" class="list-group-item list-group-item-action border-0">{{ __('Ozow') }}<div
                                        class="float-end"><i class="ti ti-chevron-right"></i></div></a>
                                @endif
                            </div>
                        </div>
                        <div class="mt-5">
                            <div class="card price-card price-1 wow animate__fadeInUp" data-wow-delay="0.2s" style="
                                                                        visibility: visible;
                                                                        animation-delay: 0.2s;
                                                                        animation-name: fadeInUp;
                                                                      ">
                                <div class="card-body">
                                    <span class="price-badge bg-primary">{{ $plan->name }}</span>
                                    @if (\Auth::user()->plan == $plan->id)
                                        <div class="d-flex flex-row-reverse m-0 p-0 ">
                                            <span class="d-flex align-items-center ">
                                                <i class="f-10 lh-1 fas fa-circle text-primary"></i>
                                                <span class="ms-2">{{ __('Active') }}</span>
                                            </span>
                                        </div>
                                    @endif

                                    <div class="text-end">
                                        <div class="">
                                            @if (\Auth::user()->type == 'super admin')
                                                <a title="Edit Plan" data-size="lg" href="#" class="action-item"
                                                    data-url="{{ route('plans.edit', $plan->id) }}"
                                                    data-ajax-popup="true" data-title="{{ __('Edit Plan') }}"
                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                    title="{{ __('Edit Plan') }}"><i class="fas fa-edit"></i></a>
                                            @endif
                                        </div>
                                    </div>

                                    <h3 class="mb-4 f-w-600  ">
                                        {{ isset($admin_payments_details['currency_symbol']) ? $admin_payments_details['currency_symbol'] : '$' }}{{ $plan->price . ' / ' . __(\App\Models\Plan::$arrDuration[$plan->duration]) }}</small>
                                        </h1>
                                        <p class="mb-0">
                                            {{ __('Trial : ') . $plan->trial_days . __(' Days') }}<br />
                                        </p>
                                        @if ($plan->description)
                                            <p class="mb-0">
                                                {{ $plan->description }}<br />
                                            </p>
                                        @endif
                                        <ul class="list-unstyled d-inline-block my-5">
                                            @if ($plan->enable_custdomain == 'on')
                                                <li class="d-flex align-items-center">
                                                    <span class="theme-avtar">
                                                    <i class="text-primary ti ti-circle-plus"></i></span>{{ __('Custom Domain') }}
                                                </li>
                                                @else
                                                    <li class="text-danger d-flex align-items-center">
                                                        <span class="theme-avtar">
                                                        <i class="text-danger ti ti-circle-plus"></i></span>{{ __('Custom Domain') }}
                                                    </li>
                                                @endif
                                                @if ($plan->enable_custsubdomain == 'on')
                                                    <li class="d-flex align-items-center">
                                                        <span class="theme-avtar">
                                                        <i class="text-primary ti ti-circle-plus"></i></span>{{ __('Sub Domain') }}
                                                    </li>
                                                @else
                                                    <li class="text-danger d-flex align-items-center">
                                                            <span class="theme-avtar">
                                                        <i class="text-danger ti ti-circle-plus"></i></span>{{ __('Sub Domain') }}
                                                    </li>
                                                @endif
                                                @if ($plan->shipping_method == 'on')
                                                    <li class="d-flex align-items-center">
                                                        <span class="theme-avtar">
                                                            <i class="text-primary ti ti-circle-plus"></i></span>{{ __('Shipping Method') }}
                                                    </li>
                                                @else
                                                    <li class="text-danger d-flex align-items-center">
                                                        <span class="theme-avtar">
                                                            <i class="text-danger ti ti-circle-plus"></i></span>{{ __('Shipping Method') }}
                                                    </li>
                                                @endif

                                                @if ($plan->additional_page == 'on')
                                                    <li class="d-flex align-items-center">
                                                        <span class="theme-avtar">
                                                            <i class="text-primary ti ti-circle-plus"></i></span>{{ __('Additional Page') }}
                                                    </li>
                                                @else
                                                    <li class="text-danger d-flex align-items-center">
                                                        <span class="theme-avtar">
                                                        <i class="text-danger ti ti-circle-plus"></i></span>{{ __('Additional Page') }}
                                                    </li>
                                                @endif
                                                @if ($plan->blog == 'on')
                                                    <li class="d-flex align-items-center">
                                                        <span class="theme-avtar d-flex align-items-center">
                                                            <i class="text-primary ti ti-circle-plus"></i></span>{{ __('Blog') }}
                                                    </li>
                                                @else
                                                    <li class="text-danger d-flex align-items-center">
                                                        <span class="theme-avtar">
                                                            <i class="text-danger ti ti-circle-plus"></i></span>{{ __('Blog') }}
                                                    </li>

                                                @endif
                                                @if ($plan->pwa_store == 'on')
                                                    <li class="d-flex align-items-center">
                                                        <span class="theme-avtar">
                                                            <i class="text-primary ti ti-circle-plus"></i
                                                        ></span>
                                                            {{ __('Progressive Web App (PWA)') }}
                                                    </li>
                                                @else
                                                    <li class="text-danger d-flex align-items-center">
                                                            <span class="theme-avtar">
                                                            <i class="text-danger ti ti-circle-plus"></i
                                                            ></span>
                                                        {{ __('Progressive Web App (PWA)') }}

                                                    </li>
                                                @endif

                                                @if ($plan->enable_chatgpt == 'on')
                                                    <li class="d-flex align-items-center">
                                                        <span class="theme-avtar">
                                                            <i class="text-primary ti ti-circle-plus"></i></span>{{ __('Chatgpt') }}
                                                    </li>
                                                @else
                                                    <li class="text-danger d-flex align-items-center">
                                                        <span class="theme-avtar">
                                                            <i class="text-danger ti ti-circle-plus"></i></span>{{ __('Chatgpt') }}
                                                    </li>
                                                @endif
                                        </ul>

                                        <div class="row mb-3">
                                            <div class="col-3 text-center">
                                                @if ($plan->max_products == '-1')
                                                    <span class="h5 mb-0">{{ __('Unlimited') }}</span>
                                                @else
                                                    <span class="h5 mb-0">{{ $plan->max_products }}</span>
                                                @endif
                                                <span class="d-block text-sm">{{ __('Products') }}</span>
                                            </div>
                                            <div class="col-3 text-center">
                                                <span class="h5 mb-0">
                                                    @if ($plan->max_stores == '-1')
                                                        <span class="h5 mb-0">{{ __('Unlimited') }}</span>
                                                    @else
                                                        <span class="h5 mb-0">{{ $plan->max_stores }}</span>
                                                    @endif
                                                </span>
                                                <span class="d-block text-sm">{{ __('Store') }}</span>
                                            </div>
                                            <div class="col-3 text-center">
                                                <span class="h5 mb-0">
                                                    @if ($plan->max_users == '-1')
                                                        <span class="h5 mb-0">{{ __('Unlimited') }}</span>
                                                    @else
                                                        <span class="h5 mb-0">{{ $plan->max_users }}</span>
                                                    @endif
                                                </span>
                                                <span class="d-block text-sm">{{ __('Users') }}</span>
                                            </div>
                                            <div class="col-3 text-center">
                                                <span class="h5 mb-0">
                                                    @if ($plan->storage_limit == '-1')
                                                        <span class="h5 mb-0">{{ __('Unlimited') }}</span>
                                                    @else
                                                        <span class="h5 mb-0">{{ $plan->storage_limit }}</span>
                                                    @endif
                                                </span>
                                                <span class="d-block text-sm">{{ __('Storage Limit') }}</span>
                                            </div>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-9">
                    @if (isset($admin_payments_details['is_stripe_enabled']) && $admin_payments_details['is_stripe_enabled'] == 'on')
                    {{-- stripe payment --}}
                    <div id="stripe_payment" class="card">
                        <div class="card-header">
                            <h5>{{ __('Stripe') }}</h5>
                        </div>
                        @if ($admin_payments_details['is_stripe_enabled'] == 'on' && !empty($admin_payments_details['stripe_key']) && !empty($admin_payments_details['stripe_secret']))
                            <div class="tab-pane {{ ($admin_payments_details['is_stripe_enabled'] == 'on' &&!empty($admin_payments_details['stripe_key']) &&!empty($admin_payments_details['stripe_secret'])) == 'on'? 'active': '' }}"
                                id="stripe_payment">
                                <form role="form" action="{{ route('stripe.payment') }}" method="post" class="require-validation" id="payment-form">
                                    @csrf
                                    <div class="card-body">
                                        <input type="hidden" name="total_price" value="{{ $plan->price }}" class="form-control final-price">
                                        <div class=" p-3 stripe-payment-div">
                                            <div class="row">
                                                <div class="col-sm-8">
                                                    <div class="custom-radio">
                                                        <label
                                                            class="f-15  fw-bold">{{ __('Credit / Debit Card') }}</label>
                                                    </div>
                                                    <p class="mb-2 mt-2 pt-1 text-sm">
                                                        {{ __('Safe money transfer using your bank account. We support Mastercard, Visa, Discover and American express.') }}
                                                    </p>
                                                </div>

                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="card-name-on"
                                                            class="form-label text-dark">{{ __('Name on card') }}</label>
                                                        <input type="text" name="name" id="card-name-on"
                                                            class="form-control required"
                                                            placeholder="{{ \Auth::user()->name }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div id="card-element">
                                                        <!-- A Stripe Element will be inserted here. -->
                                                    </div>
                                                    <div id="card-errors" role="alert"></div>
                                                </div>
                                                <div class="col-md-12 mt-3">
                                                        <label for="paypal_coupon"
                                                            class="form-label">{{ __('Coupon') }}</label>
                                                    <div class="d-flex align-items-center input-btn-wrp">
                                                        <div class="form-group w-100 mb-0">
                                                            <input type="text" id="stripe_coupon" name="coupon"
                                                                class="form-control coupon"
                                                                placeholder="{{ __('Enter Coupon Code') }}">
                                                        </div>
                                                        <div class="form-group mb-0">
                                                            <a href="javascript:void(0)" class="text-white d-flex align-items-center justify-content-center apply-coupon btn btn-sm btn-primary" data-toggle="tooltip"
                                                            data-bs-placement="top"  data-bs-toggle="tooltip" title="{{ __('Apply') }}"><i
                                                                    class="fas fa-save"></i></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="error" style="display: none;">
                                                        <div class='alert-danger alert'>
                                                            {{ __('Please correct the errors and try again.') }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer  py-3 px-3 border-top">
                                        <div class="text-end">
                                            <input type="hidden" name="plan_id"
                                                value="{{ \Illuminate\Support\Facades\Crypt::encrypt($plan->id) }}">
                                            <input type="submit" value="{{ __('Pay Now') }}"
                                                class="btn btn-xs btn-primary">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        @endif
                    </div>
                    {{-- stripr payment end --}}
                    @endif
                    <!-- manually payment -->
                    @if (!empty($admin_payments_details['manually_enabled']) && $admin_payments_details['manually_enabled'] == 'on'  )
                        <div id="manually_payment" class="card">
                            <div class="card-header">
                                <h5>{{ __('Manually') }}</h5>
                            </div>
                            <div class="tab-pane {{ ($admin_payments_details['manually_enabled'] == 'on') ? 'active': '' }}"
                                id="manually_payment">
                                <div class="card-body">
                                    <div class="p-3">
                                        <div class="row">
                                            <div class="col-sm-8">
                                                <p class="mb-0 pt-1 text-sm">
                                                    {{ __('Requesting manual payment for the planned amount for the subscriptions plan.') }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer py-3 px-3 border-top">
                                    <div class="text-end">
                                        <a href="{{ route('send.request', [\Illuminate\Support\Facades\Crypt::encrypt($plan->id)]) }}"
                                            class="btn btn-primary m-1"
                                            data-title="{{ __('Send Request') }}" data-toggle="tooltip">{{ __('Send Request') }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    <!-- bank transfer payment -->
                    @if (!empty($admin_payments_details['enable_bank'] ) && $admin_payments_details['enable_bank'] == 'on' && !empty($admin_payments_details['bank_number']) )
                        <div id="bank_payment" class="card">
                            <div class="card-header">
                                <h5>{{ __('Bank Transfer') }}</h5>
                            </div>
                            <div class="tab-pane {{ ($admin_payments_details['enable_bank'] == 'on' && !empty($admin_payments_details['bank_number'])) ? 'active': '' }}"
                                id="bank_payment">
                            <form action="{{ route('plan.bank_transfer') }}" method="POST"
                                class="payment-method-form" id="bank_transfer_form" enctype='multipart/form-data'>
                                @csrf
                                <div class="card-body">
                                    <div class="p-3 stripe-payment-div">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label
                                                        class="form-label">{{ __('Bank Details :') }}</label>
                                                        <p class="">
                                                            {!!$admin_payments_details['bank_number'] !!}
                                                        </p>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label class="form-label">{{ __('Payment Receipt') }}</label>
                                                    <input type="file" class="form-control mb-2" required name="payment_receipt" id="payment_receipt" aria-label="file example" onchange="document.getElementById('blah3').src = window.URL.createObjectURL(this.files[0])">
                                                    <img src="" id="blah3" width="25%"/>
                                                    <div class="invalid-feedback">{{ __('invalid form file') }}</div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12 mb-3">
                                            <label for="bank_coupon"class="form-label fw-bold">{{ __('Coupon') }}</label>
                                            <div class="row align-items-center">
                                                <div class="col-lg-10 col-mg-10 col-sm-12 col-xs-12">
                                                    <div class="form-group mb-0">
                                                        <input type="text" id="bank_coupon" name="coupon" class="form-control coupon" placeholder="{{__('Enter Coupon Code Here')}}"/>
                                                    </div>
                                                </div>
                                                <div class="col-lg-2 col-mg-2 col-sm-12 col-xs-12">
                                                    <a href="javascript:void(0)" class="btn btn-print-invoice  btn-primary  w-100 apply-coupon">{{__('Apply')}}</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="" class="col-form-label">{{ __('Plan Price : ') }}<span
                                                            class="paypal-final-price">{{ isset($admin_payments_details['currency_symbol']) ? $admin_payments_details['currency_symbol'] : '$' }}{{ $plan->price }}</span></label>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for=""
                                                        class="col-form-label">{{ __('Net Amount : ') }}<span
                                                            class="final-price">{{ isset($admin_payments_details['currency_symbol']) ? $admin_payments_details['currency_symbol'] : '$' }}<span class="price-final">{{ $plan->price }}</span></span></label><br>
                                                    <small class="text-xs">
                                                        {{ __('(After Coupon Apply)') }}
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer py-3 px-3 border-top">
                                    <div class="text-end">
                                        <input type="hidden" name="plan_id"
                                            value="{{ \Illuminate\Support\Facades\Crypt::encrypt($plan->id) }}">
                                        <input type="submit" value="{{ __('Pay Now') }}"
                                            class="btn btn-primary">
                                    </div>
                                </div>
                            </form>

                            </div>
                        </div>
                    @endif
                    <!--  bank transfer payment end -->
                    @if (isset($admin_payments_details['is_paypal_enabled']) && $admin_payments_details['is_paypal_enabled'] == 'on')
                    {{-- paypal  --}}
                    <div id="paypal_payment" class="card">
                        <div class="card-header">
                            <h5>{{ __('Paypal') }}</h5>
                        </div>
                        {{-- <div class="card-body"> --}}
                        @if ($admin_payments_details['is_paypal_enabled'] == 'on' && !empty($admin_payments_details['paypal_client_id']) && !empty($admin_payments_details['paypal_secret_key']))
                            <div class="tab-pane {{ ($admin_payments_details['is_stripe_enabled'] != 'on' &&$admin_payments_details['is_paypal_enabled'] == 'on' &&!empty($admin_payments_details['paypal_client_id']) &&!empty($admin_payments_details['paypal_secret_key'])) == 'on'? 'active': '' }}"
                                id="paypal_payment">
                                {{-- <div class="card"> --}}
                                <form class="w3-container w3-display-middle w3-card-4" method="POST" id="payment-form"
                                    action="{{ route('plan.pay.with.paypal') }}">
                                    @csrf
                                    <div class="card-body">
                                        <input type="hidden" name="plan_id" value="{{ \Illuminate\Support\Facades\Crypt::encrypt($plan->id) }}">
                                        <div class="p-3">
                                            <div class="row">
                                                <div class="col-md-12 mt-3">
                                                    <div class="d-flex align-items-center input-btn-wrp">
                                                        <div class="form-group w-100">
                                                            <input type="hidden" name="total_price" value="{{ $plan->price }}" class="form-control final-price">
                                                            <label for="paypal_coupon"
                                                                class="form-label">{{ __('Coupon') }}</label>
                                                            <input type="text" id="paypal_coupon" name="coupon"
                                                                class="form-control coupon"
                                                                placeholder="{{ __('Enter Coupon Code') }}">
                                                        </div>
                                                        <div class="form-group mb-0 mt-1">
                                                            <a href="javascript:void(0)" class="text-white d-flex align-items-center justify-content-center apply-coupon btn btn-sm btn-primary"
                                                                        data-bs-placement="top"  data-bs-toggle="tooltip" title="{{ __('Apply') }}"><i class="fas fa-save"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer py-3 px-3 border-top">
                                        <div class="text-end">
                                            <input type="submit" value="{{ __('Pay Now') }}"
                                                class="btn btn-xs btn-primary">
                                        </div>
                                    </div>
                                </form>
                                {{-- </div> --}}
                            </div>
                        @endif
                        {{-- </div> --}}
                    </div>
                    {{-- paypal end --}}
                    @endif
                    @if (isset($admin_payments_details['is_paystack_enabled']) && $admin_payments_details['is_paystack_enabled'] == 'on')
                    {{-- Paystack --}}
                    <div id="paystack_payment" class="card">
                        <div class="card-header">
                            <h5>{{ __('Paystack') }}</h5>

                        </div>
                        {{-- <div class="card-body"> --}}
                        @if (isset($admin_payments_details['is_paystack_enabled']) && $admin_payments_details['is_paystack_enabled'] == 'on')
                            <div id="paystack-payment" class="tabs-card">
                                <div class="card-body">
                                    <div class="row p-3 payment-box">
                                        <div class="d-flex align-items-center input-btn-wrp">
                                            <div class="form-group w-100">
                                                <label for="paystack_coupon"
                                                    class="form-label">{{ __('Coupon') }}</label>
                                                <input type="text" id="paystack_coupon" name="coupon"
                                                    class="form-control coupon"
                                                    placeholder="{{ __('Enter Coupon Code') }}">
                                            </div>

                                            <div class="form-group mb-0 mt-1">
                                                <a href="javascript:void(0)" class="text-white d-flex align-items-center justify-content-center apply-coupon btn btn-sm btn-primary"
                                                            data-bs-placement="top"  data-bs-toggle="tooltip" title="{{ __('Apply') }}"><i class="fas fa-save"></i>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-12 text-right paymentwall-coupon-tr" style="display: none">
                                            <b>{{__('Coupon Discount')}}</b> : <b class="paymentwall-coupon-price"></b>
                                        </div>
                                    </div>
                                </div>
                                 <div class="card-footer py-3 px-3 border-top">
                                    <div class="text-end">
                                        <button class="btn btn-xs btn-primary" type="button" onclick="preparePayment('#paystack_coupon','paystack')">
                                            {{ __('Pay Now') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endif
                        {{-- </div> --}}
                    </div>
                    {{-- Paystack end --}}
                    @endif

                    @if (isset($admin_payments_details['is_flutterwave_enabled']) && $admin_payments_details['is_flutterwave_enabled'] == 'on')
                    {{-- Flutterwave --}}
                    <div id="flutterwave_payment" class="card">
                        <div class="card-header">
                            <h5>{{ __('Flutterwave') }}</h5>

                        </div>
                        {{-- <div class="card-body"> --}}
                        @if (isset($admin_payments_details['is_flutterwave_enabled']) && $admin_payments_details['is_flutterwave_enabled'] == 'on')
                            <div class="tab-pane " id="flutterwave_payment">
                                <form class="w3-container w3-display-middle w3-card-4" method="POST" id="payment-form"
                                    action="{{ route('plan.pay.with.paypal') }}">
                                    @csrf
                                    <div class="card-body">
                                        <input type="hidden" name="plan_id"
                                            value="{{ \Illuminate\Support\Facades\Crypt::encrypt($plan->id) }}">
                                        <input type="hidden" name="total_price" value="{{ $plan->price }}" class="form-control final-price">
                                        <div class="row p-3 payment-box">
                                            <div class="d-flex align-items-center input-btn-wrp">
                                                <div class="form-group w-100">
                                                    <label for="flutterwave_coupon"
                                                        class="form-label">{{ __('Coupon') }}</label>
                                                    <input type="text" id="flutterwave_coupon" name="coupon"
                                                        class="form-control coupon"
                                                        placeholder="{{ __('Enter Coupon Code') }}">
                                                </div>

                                                <div class="form-group mb-0 mt-1">
                                                    <a href="javascript:void(0)" class="text-white d-flex align-items-center justify-content-center apply-coupon btn btn-sm btn-primary"
                                                                data-bs-placement="top"  data-bs-toggle="tooltip" title="{{ __('Apply') }}"><i class="fas fa-save"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                     <div class="card-footer py-3 px-3 border-top">
                                        <div class="text-end">
                                            <button class="btn btn-xs btn-primary" type="button"
                                            onclick="preparePayment('#flutterwave_coupon','flutterwave')">
                                             {{ __('Pay Now') }}
                                        </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        @endif
                        {{-- </div> --}}
                    </div>
                    {{-- Flutterwave END --}}
                    @endif

                    @if (isset($admin_payments_details['is_razorpay_enabled']) && $admin_payments_details['is_razorpay_enabled'] == 'on')
                    {{-- Razorpay --}}
                    <div id="razorpay_payment" class="card">
                        <div class="card-header">
                            <h5>{{ __('Razorpay') }} </h5>

                        </div>
                        {{-- <div class="card-body"> --}}
                        @if (isset($admin_payments_details['is_razorpay_enabled']) && $admin_payments_details['is_razorpay_enabled'] == 'on')
                            <div class="tab-pane " id="razorpay_payment">

                                <form class="w3-container w3-display-middle w3-card-4" method="POST" id="payment-form"
                                    action="{{ route('plan.pay.with.paypal') }}">
                                    @csrf
                                    <div class="card-body">
                                        <input type="hidden" name="plan_id"
                                            value="{{ \Illuminate\Support\Facades\Crypt::encrypt($plan->id) }}">
                                        <input type="hidden" name="total_price" value="{{ $plan->price }}" class="form-control final-price">
                                        <div class="row p-3 payment-box">
                                            <div class="d-flex align-items-center input-btn-wrp">
                                                <div class="form-group w-100">
                                                    <label for="razorpay_coupon"
                                                        class="form-label">{{ __('Coupon') }}</label>
                                                    <input type="text" id="razorpay_coupon" name="coupon"
                                                        class="form-control coupon"
                                                        placeholder="{{ __('Enter Coupon Code') }}">
                                                </div>

                                                <div class="form-group mb-0 mt-1">
                                                    <a href="javascript:void(0)" class="text-white d-flex align-items-center justify-content-center apply-coupon btn btn-sm btn-primary"
                                                                data-bs-placement="top"  data-bs-toggle="tooltip" title="{{ __('Apply') }}"><i class="fas fa-save"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                     <div class="card-footer py-3 px-3 border-top">
                                        <div class="text-end">
                                            <button class="btn btn-xs btn-primary" type="button"
                                            onclick="preparePayment('#razorpay_coupon','razorpay')">
                                           {{ __('Pay Now') }}
                                        </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        @endif
                        {{-- </div> --}}
                    </div>
                    {{-- Razorpay end --}}
                    @endif

                    @if (isset($admin_payments_details['is_mercado_enabled']) && $admin_payments_details['is_mercado_enabled'] == 'on')
                    {{-- Mercado Pago --}}
                    <div id="mercado_payment" class="card">
                        <div class="card-header">
                            <h5>{{ __('Mercado Pago') }}</h5>

                        </div>
                        {{-- <div class="card-body"> --}}
                        @if (isset($admin_payments_details['is_mercado_enabled']) && $admin_payments_details['is_mercado_enabled'] == 'on')
                            <div class="tab-pane " id="mercado_payment">

                                <form class="w3-container w3-display-middle w3-card-4" method="POST" id="payment-form"
                                    action="{{ route('plan.pay.with.paypal') }}">
                                    @csrf
                                    <div class="card-body">
                                        <input type="hidden" name="plan_id"
                                            value="{{ \Illuminate\Support\Facades\Crypt::encrypt($plan->id) }}">
                                        <input type="hidden" name="total_price" value="{{ $plan->price }}" class="form-control final-price">
                                        <div class="row p-3 payment-box">
                                            <div class="d-flex align-items-center input-btn-wrp">
                                                <div class="form-group w-100">
                                                    <label for="mercado_coupon"
                                                        class="form-label">{{ __('Coupon') }}</label>
                                                    <input type="text" id="mercado_coupon" name="coupon"
                                                        class="form-control coupon"
                                                        placeholder="{{ __('Enter Coupon Code') }}">
                                                </div>

                                                <div class="form-group mb-0 mt-1">
                                                    <a href="javascript:void(0)" class="text-white d-flex align-items-center justify-content-center apply-coupon btn btn-sm btn-primary"
                                                                data-bs-placement="top"  data-bs-toggle="tooltip" title="{{ __('Apply') }}"><i class="fas fa-save"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                     <div class="card-footer py-3 px-3 border-top">
                                        <div class="text-end">
                                            <button class="btn btn-xs btn-primary" type="button"
                                                onclick="preparePayment('#mercado_coupon','mercado')">
                                                {{ __('Pay Now') }}
                                            </button>

                                        </div>
                                    </div>
                                </form>

                            </div>
                        @endif
                        {{-- </div> --}}
                    </div>
                    {{-- Mercado Pago end --}}
                    @endif

                    @if (isset($admin_payments_details['is_paytm_enabled']) && $admin_payments_details['is_paytm_enabled'] == 'on')
                    {{-- Paytm --}}
                    <div id="paytm_payment" class="card">
                        <div class="card-header">
                            <h5>{{ __('Paytm') }}</h5>

                        </div>
                        {{-- <div class="card-body"> --}}
                        @if (isset($admin_payments_details['is_paytm_enabled']) && $admin_payments_details['is_paytm_enabled'] == 'on')
                            <div class="tab-pane " id="paytm_payment">
                                <form class="w3-container w3-display-middle w3-card-4" method="POST" id="payment-form"
                                    action="{{ route('paytm.prepare.plan') }}">
                                    @csrf
                                    <div class="card-body">
                                        <input type="hidden" name="plan_id"
                                            value="{{ \Illuminate\Support\Facades\Crypt::encrypt($plan->id) }}">
                                        <input type="hidden" name="total_price" id="paytm_total_price"
                                            value="{{ $plan->price }}" class="form-control">
                                        <div class="border p-3 rounded payment-box">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="mobile_number">{{ __('Mobile Number') }}</label>
                                                    <input type="text" id="mobile_number" name="mobile_number"
                                                        class="form-control coupon"
                                                        placeholder="{{ __('Enter Mobile Number') }}">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="d-flex align-items-center input-btn-wrp">
                                                    <div class="form-group w-100">
                                                        <label for="paytm_coupon"
                                                            class="form-label">{{ __('Coupon') }}</label>
                                                        <input type="text" id="paytm_coupon" name="coupon"
                                                            class="form-control coupon"
                                                            placeholder="{{ __('Enter Coupon Code') }}">
                                                    </div>

                                                    <div class="form-group mb-0 mt-1">
                                                        <a href="javascript:void(0)" class="text-white d-flex align-items-center justify-content-center apply-coupon btn btn-sm btn-primary"
                                                                    data-bs-placement="top"  data-bs-toggle="tooltip" title="{{ __('Apply') }}"><i class="fas fa-save"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                     <div class="card-footer py-3 px-3 border-top">
                                        <div class="text-end">
                                            <button class="btn btn-xs btn-primary" type="submit">
                                                {{ __('Pay Now') }}
                                            </button>
                                        </div>
                                    </div>
                                </form>

                            </div>
                        @endif
                        {{-- </div> --}}
                    </div>
                    {{-- Paytm end --}}
                    @endif

                    @if (isset($admin_payments_details['is_mollie_enabled']) && $admin_payments_details['is_mollie_enabled'] == 'on')
                    {{-- Mollie --}}
                    <div id="mollie_payment" class="card">
                        <div class="card-header">
                            <h5>{{ __('Mollie') }}</h5>

                        </div>
                        {{-- <div class="card-body"> --}}
                        @if (isset($admin_payments_details['is_mollie_enabled']) && $admin_payments_details['is_mollie_enabled'] == 'on')
                        <div class="tab-pane " id="mollie_payment">
                                <form class="w3-container w3-display-middle w3-card-4" method="POST" id="payment-form"
                                    action="{{ route('mollie.prepare.plan') }}">
                                    @csrf
                                    <div class="card-body">
                                        <input type="hidden" name="plan_id"
                                            value="{{ \Illuminate\Support\Facades\Crypt::encrypt($plan->id) }}">
                                        <input type="hidden" name="total_price" id="mollie_total_price"
                                            value="{{ $plan->price }}" class="form-control">
                                        <div class="row p-3 payment-box">
                                            <div class="d-flex align-items-center input-btn-wrp">
                                                <div class="form-group w-100">
                                                    <label for="mollie_coupon"
                                                        class="form-label">{{ __('Coupon') }}</label>
                                                    <input type="text" id="mollie_coupon" name="coupon"
                                                        class="form-control coupon"
                                                        placeholder="{{ __('Enter Coupon Code') }}">
                                                </div>

                                                <div class="form-group mb-0 mt-1">
                                                    <a href="javascript:void(0)" class="text-white d-flex align-items-center justify-content-center apply-coupon btn btn-sm btn-primary"
                                                                data-bs-placement="top"  data-bs-toggle="tooltip" title="{{ __('Apply') }}"><i class="fas fa-save"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                     <div class="card-footer py-3 px-3 border-top">
                                        <div class="text-end">
                                            <button class="btn btn-xs btn-primary" type="submit">
                                                 {{ __('Pay Now') }}
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        @endif
                        {{-- Mollie end --}}
                    </div>
                    @endif

                    @if (isset($admin_payments_details['is_skrill_enabled']) && $admin_payments_details['is_skrill_enabled'] == 'on')
                        {{-- Skrill --}}
                        <div id="skrill_payment" class="card">
                            <div class="card-header">
                                <h5>{{ __('Skrill') }}</h5>

                            </div>
                            {{-- <div class="card-body"> --}}
                            @if (isset($admin_payments_details['is_skrill_enabled']) && $admin_payments_details['is_skrill_enabled'] == 'on')
                                <div class="tab-pane " id="skrill_payment">

                                    <form class="w3-container w3-display-middle w3-card-4" method="POST" id="payment-form" action="{{ route('skrill.prepare.plan') }}">
                                        @csrf
                                        <div class="card-body">
                                            <input type="hidden" name="id"
                                                value="{{ date('Y-m-d') }}-{{ strtotime(date('Y-m-d H:i:s')) }}-payatm">
                                            <input type="hidden" name="order_id"
                                                value="{{ str_pad(!empty($order->id) ? $order->id + 1 : 0 + 1, 4, '100', STR_PAD_LEFT) }}">

                                            @php
                                                $skrill_data = [
                                                    'transaction_id' => md5(date('Y-m-d') . strtotime('Y-m-d H:i:s') . 'user_id'),
                                                    'user_id' => 'user_id',
                                                    'amount' => 'amount',
                                                    'currency' => 'currency',
                                                ];
                                                session()->put('skrill_data', $skrill_data);

                                            @endphp
                                            <input type="hidden" name="plan_id"
                                                value="{{ \Illuminate\Support\Facades\Crypt::encrypt($plan->id) }}">
                                            <input type="hidden" name="total_price" id="skrill_total_price"
                                                value="{{ $plan->price }}" class="form-control">
                                            <input type="hidden" name="transaction_id" value="{{ date('Y-m-d') . strtotime('Y-m-d H:i:s') . 'user_id' }}">
                                            <div class="row p-3 payment-box">
                                                <div class="d-flex align-items-center input-btn-wrp">
                                                    <div class="form-group w-100">
                                                        <label for="skrill_coupon"
                                                            class="form-label">{{ __('Coupon') }}</label>
                                                        <input type="text" id="skrill_coupon" name="coupon"
                                                            class="form-control coupon"
                                                            placeholder="{{ __('Enter Coupon Code') }}">
                                                    </div>
                                                    <div class="form-group mb-0 mt-1">
                                                        <a href="javascript:void(0)" class="text-white d-flex align-items-center justify-content-center apply-coupon btn btn-sm btn-primary"
                                                                    data-bs-placement="top"  data-bs-toggle="tooltip" title="{{ __('Apply') }}"><i class="fas fa-save"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                         <div class="card-footer py-3 px-3 border-top">
                                            <div class="text-end">
                                                <button class="btn btn-xs btn-primary" type="submit">
                                                     {{ __('Pay Now') }}
                                                </button>
                                            </div>
                                        </div>
                                    </form>

                                </div>
                            @endif
                            {{-- </div> --}}
                        </div>
                        {{-- Skrill end --}}
                    @endif

                    @if (isset($admin_payments_details['is_coingate_enabled']) && $admin_payments_details['is_coingate_enabled'] == 'on')
                        {{-- Coingate --}}
                        <div id="coingate_payment" class="card">
                            <div class="card-header">
                                <h5>{{ __('Coingate') }}</h5>

                            </div>
                            {{-- <div class="card-body"> --}}
                            @if (isset($admin_payments_details['is_coingate_enabled']) && $admin_payments_details['is_coingate_enabled'] == 'on')
                                <div class="tab-pane " id="coingate_payment">
                                    <form class="w3-container w3-display-middle w3-card-4" method="POST" id="payment-form"
                                        action="{{ route('coingate.prepare.plan') }}">
                                        @csrf
                                        <div class="card-body">
                                            <input type="hidden" name="counpon" id="coingate_coupon" value="">
                                            <input type="hidden" name="plan_id"
                                                value="{{ \Illuminate\Support\Facades\Crypt::encrypt($plan->id) }}">
                                            <input type="hidden" name="total_price" id="coingate_total_price"
                                                value="{{ $plan->price }}" class="form-control">
                                            <div class="row p-3 payment-box">
                                                <div class="d-flex align-items-center input-btn-wrp">
                                                    <div class="form-group w-100">
                                                        <label for="coingate_coupon"
                                                            class="form-label">{{ __('Coupon') }}</label>
                                                        <input type="text" id="coingate_coupon" name="coupon"
                                                            class="form-control coupon"
                                                            placeholder="{{ __('Enter Coupon Code') }}">
                                                    </div>

                                                    <div class="form-group mb-0 mt-1">
                                                        <a href="javascript:void(0)" class="text-white d-flex align-items-center justify-content-center apply-coupon btn btn-sm btn-primary"
                                                                    data-bs-placement="top"  data-bs-toggle="tooltip" title="{{ __('Apply') }}"><i class="fas fa-save"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                         <div class="card-footer py-3 px-3 border-top">
                                            <div class="text-end">
                                                <button class="btn btn-xs btn-primary" type="submit">
                                                    {{ __('Pay Now') }}
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            @endif
                            {{-- </div> --}}
                        </div>
                        {{-- Coingate end --}}
                    @endif

                    @if (isset($admin_payments_details['is_paymentwall_enabled']) && $admin_payments_details['is_paymentwall_enabled'] == 'on')
                        {{-- Paymentwall --}}
                        <div id="paymentwall_payment" class="card">
                            <div class="card-header">
                                <h5>{{ __('Paymentwall') }}</h5>

                            </div>
                            {{-- <div class="card-body"> --}}
                            @if (isset($admin_payments_details['is_paymentwall_enabled']) && $admin_payments_details['is_paymentwall_enabled'] == 'on')
                                <div class="tab-pane " id="paymentwall_payment">

                                    <form role="form" action="{{ route('paymentwall') }}" method="post"
                                        id="paymentwall-payment-form" class="w3-container w3-display-middle w3-card-4">
                                        @csrf
                                        <div class="card-body">
                                            <div class="row p-3 payment-box">
                                                <div class="d-flex align-items-center input-btn-wrp">
                                                    <div class="form-group w-100">
                                                        <label for="paymentwall_coupon"
                                                            class="form-label">{{ __('Coupon') }}</label>
                                                        <input type="text" id="paymentwall_coupon" name="coupon"
                                                            class="form-control coupon"
                                                            placeholder="{{ __('Enter Coupon Code') }}">
                                                    </div>

                                                    <div class="form-group mb-0 mt-1">
                                                        <a href="javascript:void(0)" class="text-white d-flex align-items-center justify-content-center apply-coupon btn btn-sm btn-primary"
                                                                    data-bs-placement="top"  data-bs-toggle="tooltip" title="{{ __('Apply') }}"><i class="fas fa-save"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                         <div class="card-footer py-3 px-3 border-top">
                                            <div class="text-end">
                                                <input type="hidden" name="plan_id"
                                                value="{{ \Illuminate\Support\Facades\Crypt::encrypt($plan->id) }}">
                                                <input type="hidden" name="total_price" value="{{ $plan->price }}" class="form-control final-price">
                                            <button class="btn btn-xs btn-primary" type="submit"
                                                id="pay_with_paymentwall">
                                                    {{ __('Pay Now') }}
                                                </button>

                                            </div>
                                        </div>
                                    </form>

                                </div>
                            @endif
                            {{-- </div> --}}
                        </div>
                        {{-- Paymentwall end --}}
                    @endif
                    @if (isset($admin_payments_details['is_toyyibpay_enabled']) && $admin_payments_details['is_toyyibpay_enabled'] == 'on')
                        <div id="toyyibpay_payment" class="card">
                            <div class="card-header">
                                <h5>{{ __('Toyyibpay') }}</h5>
                            </div>
                            <div class="tab-pane " id="Toyyibpay_payment">
                                <form role="form" action="{{ route('toyyibpay.prepare.plan') }}" method="post"
                                    id="toyyibpay-payment-form" class="w3-container w3-display-middle w3-card-4">
                                    @csrf
                                    <div class="card-body">
                                        <div class="row p-3 payment-box">
                                            <div class="d-flex align-items-center input-btn-wrp">
                                                <div class="form-group w-100">
                                                    <label for="toyyibpay_coupan"
                                                        class="form-label">{{ __('Coupon') }}</label>
                                                    <input type="text" id="toyyibpay_coupan" name="coupon"
                                                        class="form-control coupon"
                                                        placeholder="{{ __('Enter Coupon Code') }}">
                                                </div>

                                                <div class="form-group mb-0 mt-1">
                                                    <a href="javascript:void(0)" class="text-white d-flex align-items-center justify-content-center apply-coupon btn btn-sm btn-primary"
                                                                data-bs-placement="top"  data-bs-toggle="tooltip" title="{{ __('Apply') }}"><i class="fas fa-save"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                     <div class="card-footer py-3 px-3 border-top">
                                        <div class="text-end">
                                            <input type="hidden" name="plan_id"
                                            value="{{ \Illuminate\Support\Facades\Crypt::encrypt($plan->id) }}">
                                            <input type="hidden" name="total_price" value="{{ $plan->price }}" class="form-control final-price">
                                        <button class="btn btn-xs btn-primary" type="submit"
                                            id="pay_with_toyyibpay">
                                                {{ __('Pay Now') }}
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endif
                    @if (isset($admin_payments_details['is_payfast_enabled']) && $admin_payments_details['is_payfast_enabled'] == 'on')
                        <div id="payfast_payment" class="card">
                            <div class="card-header">
                                <h5>{{ __('Payfast') }}</h5>
                            </div>

                            <div class="tab-pane {{ ($admin_payments_details['is_payfast_enabled'] == 'on' &&!empty($admin_payments_details['payfast_merchant_id']) &&!empty($admin_payments_details['payfast_merchant_key'])) == 'on'? 'active': '' }}">
                                @php
                                    $pfHost = $admin_payments_details['payfast_mode'] == 'sandbox' ? 'sandbox.payfast.co.za' : 'www.payfast.co.za';
                                @endphp
                                <form role="form" action={{"https://" . $pfHost . "/eng/process"}} method="post" class="require-validation" id="payfast-form" >
                                    @csrf
                                    <div class="card-body">
                                        <div class="row p-3 payment-box">
                                            <div class="d-flex align-items-center input-btn-wrp">
                                                <div class="form-group w-100">
                                                    <label for="payfast_coupan"
                                                        class="form-label">{{ __('Coupon') }}</label>
                                                    <input type="text" id="payfast_coupan" name="coupon"
                                                        class="form-control coupon"
                                                        placeholder="{{ __('Enter Coupon Code') }}">
                                                </div>
                                                <div class="form-group mb-0 mt-1">
                                                    <a href="javascript:void(0)" class="text-white d-flex align-items-center justify-content-center apply-coupon btn btn-sm btn-primary"
                                                                data-bs-placement="top"  data-bs-toggle="tooltip" title="{{ __('Apply') }}"><i class="fas fa-save"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="get-payfast-inputs"></div>
                                     <div class="card-footer py-3 px-3 border-top">
                                        <div class="text-end">
                                            <input type="hidden" name="plan_id" id="plan_id"
                                                value="{{ \Illuminate\Support\Facades\Crypt::encrypt($plan->id) }}">
                                            <button class="btn btn-primary" type="submit" id="pay_with_payfast">
                                                {{ __('Pay Now') }}
                                            </button>

                                        </div>
                                    </div>
                                </form>

                            </div>
                        </div>
                    @endif
                    @if (isset($admin_payments_details['is_iyzipay_enabled']) && $admin_payments_details['is_iyzipay_enabled'] == 'on')
                        <div id="iyzipay_payment" class="card">
                            <div class="card-header">
                                <h5>{{ __('Iyzipay') }}</h5>
                            </div>
                            <div class="tab-pane" id="iyzipay_payment">
                                <form role="form" action={{ route('iyzipay.payment.init') }} method="post" class="require-validation" id="iyzipay-form" >
                                    @csrf
                                    <div class="card-body">
                                        <div class="row p-3 payment-box">
                                            <div class="d-flex align-items-center input-btn-wrp">
                                                <div class="form-group w-100">
                                                    <label for="iyzipay_coupan"
                                                        class="form-label">{{ __('Coupon') }}</label>
                                                    <input type="text" id="iyzipay_coupan" name="coupon"
                                                        class="form-control coupon"
                                                        placeholder="{{ __('Enter Coupon Code') }}">
                                                </div>

                                                <div class="form-group mb-0 mt-1">
                                                    <a href="javascript:void(0)" class="text-white d-flex align-items-center justify-content-center apply-coupon btn btn-sm btn-primary"
                                                                data-bs-placement="top"  data-bs-toggle="tooltip" title="{{ __('Apply') }}"><i class="fas fa-save"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                     <div class="card-footer py-3 px-3 border-top">
                                        <div class="text-end">
                                            <input type="hidden" name="plan_id" id="plan_id"
                                                value="{{ \Illuminate\Support\Facades\Crypt::encrypt($plan->id) }}">
                                            <button class="btn btn-primary" type="submit" id="pay_with_iyzipay">
                                                {{ __('Pay Now') }}
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endif
                    {{-- Paytab --}}
                    @if (isset($admin_payments_details['is_paytab_enabled']) && $admin_payments_details['is_paytab_enabled'] == 'on')
                        <div id="paytab_payment" class="card">
                            <div class="card-header">
                                <h5>{{ __('Paytab') }}</h5>
                            </div>
                            <form role="form" action="{{ route('plan.pay.with.paytab') }}" method="post"
                                class="require-validation" id="coingate-payment-form">
                                @csrf
                                <div class="card-body">
                                    <input type="hidden" name="plan_id" value="{{ \Illuminate\Support\Facades\Crypt::encrypt($plan->id) }}">
                                    <div class="row p-3 payment-box">
                                        <div class="d-flex align-items-center input-btn-wrp">
                                            <div class="form-group w-100">
                                                <label for="paytab_coupan"
                                                    class="form-label">{{ __('Coupon') }}</label>
                                                <input type="text" id="paytab_coupan" name="coupon"
                                                    class="form-control coupon"
                                                    placeholder="{{ __('Enter Coupon Code') }}">
                                            </div>

                                            <div class="form-group mb-0 mt-1">
                                                <a href="javascript:void(0)" class="text-white d-flex align-items-center justify-content-center apply-coupon btn btn-sm btn-primary"
                                                            data-bs-placement="top"  data-bs-toggle="tooltip" title="{{ __('Apply') }}"><i class="fas fa-save"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                 <div class="card-footer py-3 px-3 border-top">
                                    <div class="text-end">
                                        <input type="submit" id="" value="{{ __('Pay Now') }}"
                                            class="btn-create btn btn-lg btn-primary badge-blue">
                                    </div>
                                </div>
                            </form>
                        </div>
                    @endif
                    {{-- Paytab end --}}
                    @if (isset($admin_payments_details['is_benefit_enabled']) && $admin_payments_details['is_benefit_enabled'] == 'on')
                        <div id="benefit_payment" class="card">
                            <div class="card-header">
                                <h5>{{ __('Benefit') }}</h5>
                            </div>
                            <form role="form" action="{{ route('benefit.initiate') }}" method="post" class="require-validation" id="benefit-payment-form">
                                @csrf
                                <div class="card-body">
                                    <input type="hidden" name="plan_id" value="{{ \Illuminate\Support\Facades\Crypt::encrypt($plan->id) }}">
                                    <div class="row p-3 payment-box">
                                        <div class="d-flex align-items-center input-btn-wrp">
                                            <div class="form-group w-100">
                                                <label for="benefit_coupan"
                                                    class="form-label">{{ __('Coupon') }}</label>
                                                <input type="text" id="benefit_coupan" name="coupon"
                                                    class="form-control coupon"
                                                    placeholder="{{ __('Enter Coupon Code') }}">
                                            </div>

                                            <div class="form-group mb-0 mt-1">
                                                <a href="javascript:void(0)" class="text-white d-flex align-items-center justify-content-center apply-coupon btn btn-sm btn-primary"
                                                            data-bs-placement="top"  data-bs-toggle="tooltip" title="{{ __('Apply') }}"><i class="fas fa-save"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                 <div class="card-footer py-3 px-3 border-top">
                                    <div class="text-end">
                                        <input type="submit" id="" value="{{ __('Pay Now') }}"
                                            class="btn-create btn btn-lg btn-primary badge-blue">
                                    </div>
                                </div>
                            </form>
                        </div>
                    @endif
                    @if (isset($admin_payments_details['is_cashfree_enabled']) && $admin_payments_details['is_cashfree_enabled'] == 'on')
                        <div id="cashfree_payment" class="card">
                            <div class="card-header">
                                <h5>{{ __('Cashfree') }}</h5>
                            </div>
                            <form role="form" action="{{ route('cashfree.payment') }}" method="post" class="require-validation" id="cashfree-payment-form">
                                @csrf
                                <div class="card-body">
                                    <input type="hidden" name="plan_id" value="{{ \Illuminate\Support\Facades\Crypt::encrypt($plan->id) }}">
                                    <div class="row p-3 payment-box">
                                        <div class="d-flex align-items-center input-btn-wrp">
                                            <div class="form-group w-100">
                                                <label for="cashfree_coupan"
                                                    class="form-label">{{ __('Coupon') }}</label>
                                                <input type="text" id="cashfree_coupan" name="coupon"
                                                    class="form-control coupon"
                                                    placeholder="{{ __('Enter Coupon Code') }}">
                                            </div>

                                            <div class="form-group mb-0 mt-1">
                                                <a href="javascript:void(0)" class="text-white d-flex align-items-center justify-content-center apply-coupon btn btn-sm btn-primary"
                                                            data-bs-placement="top"  data-bs-toggle="tooltip" title="{{ __('Apply') }}"><i class="fas fa-save"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                 <div class="card-footer py-3 px-3 border-top">
                                    <div class="text-end">
                                        <input type="submit" id="" value="{{ __('Pay Now') }}"
                                            class="btn-create btn btn-lg btn-primary badge-blue">
                                    </div>
                                </div>
                            </form>
                        </div>
                    @endif
                    @if (isset($admin_payments_details['is_aamarpay_enabled']) && $admin_payments_details['is_aamarpay_enabled'] == 'on')
                        <div id="aamarpay_payment" class="card">
                            <div class="card-header">
                                <h5>{{ __('Aamarpay') }}</h5>
                            </div>
                            <form role="form" action="{{ route('pay.aamarpay.payment') }}" method="post" class="require-validation" id="aamarpay-payment-form">
                                @csrf
                                <div class="card-body">
                                    <input type="hidden" name="plan_id" value="{{ \Illuminate\Support\Facades\Crypt::encrypt($plan->id) }}">
                                    <div class="row p-3 payment-box">
                                        <div class="d-flex align-items-center input-btn-wrp">
                                            <div class="form-group w-100">
                                                <label for="aamarpay_coupan"
                                                    class="form-label">{{ __('Coupon') }}</label>
                                                <input type="text" id="aamarpay_coupan" name="coupon"
                                                    class="form-control coupon"
                                                    placeholder="{{ __('Enter Coupon Code') }}">
                                            </div>
                                            <div class="form-group mb-0 mt-1">
                                                <a href="javascript:void(0)" class="text-white d-flex align-items-center justify-content-center apply-coupon btn btn-sm btn-primary"
                                                            data-bs-placement="top"  data-bs-toggle="tooltip" title="{{ __('Apply') }}"><i class="fas fa-save"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                 <div class="card-footer py-3 px-3 border-top">
                                    <div class="text-end">
                                        <input type="submit" id="" value="{{ __('Pay Now') }}"
                                            class="btn-create btn btn-lg btn-primary badge-blue">
                                    </div>
                                </div>
                            </form>
                        </div>
                    @endif
                    @if (isset($admin_payments_details['is_paytr_enabled']) && $admin_payments_details['is_paytr_enabled'] == 'on')
                        <div id="paytr_payment" class="card">
                            <div class="card-header">
                                <h5>{{ __('Paytr') }}</h5>
                            </div>
                            <form role="form" action="{{ route('plan.pay.with.paytr') }}" method="post" class="require-validation" id="paytr-payment-form">
                                @csrf
                                <div class="card-body">
                                    <input type="hidden" name="plan_id" value="{{ \Illuminate\Support\Facades\Crypt::encrypt($plan->id) }}">
                                    <div class="row p-3 payment-box">
                                        <div class="d-flex align-items-center input-btn-wrp">
                                            <div class="form-group w-100">
                                                <label for="paytr_coupan"
                                                    class="form-label">{{ __('Coupon') }}</label>
                                                <input type="text" id="paytr_coupan" name="coupon"
                                                    class="form-control coupon"
                                                    placeholder="{{ __('Enter Coupon Code') }}">
                                            </div>
                                            <div class="form-group mb-0 mt-1">
                                                <a href="javascript:void(0)" class="text-white d-flex align-items-center justify-content-center apply-coupon btn btn-sm btn-primary"
                                                            data-bs-placement="top"  data-bs-toggle="tooltip" title="{{ __('Apply') }}"><i class="fas fa-save"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                 <div class="card-footer py-3 px-3 border-top">
                                    <div class="text-end">
                                        <input type="submit" id="" value="{{ __('Pay Now') }}"
                                            class="btn-create btn btn-lg btn-primary badge-blue">
                                    </div>
                                </div>
                            </form>
                        </div>
                    @endif
                    @if (isset($admin_payments_details['is_yookassa_enabled']) && $admin_payments_details['is_yookassa_enabled'] == 'on')
                        <div id="yookassa_payment" class="card">
                            <div class="card-header">
                                <h5>{{ __('Yokassa') }}</h5>
                            </div>
                            <form role="form" action="{{ route('plan.pay.with.yookassa') }}" method="get" class="require-validation" id="yookassa-payment-form">
                                @csrf
                                <div class="card-body">
                                    <input type="hidden" name="plan_id" value="{{ \Illuminate\Support\Facades\Crypt::encrypt($plan->id) }}">
                                    <div class="row p-3 payment-box">
                                        <div class="d-flex align-items-center input-btn-wrp">
                                            <div class="form-group w-100">
                                                <label for="yookassa_coupan"
                                                    class="form-label">{{ __('Coupon') }}</label>
                                                <input type="text" id="yookassa_coupan" name="coupon"
                                                    class="form-control coupon"
                                                    placeholder="{{ __('Enter Coupon Code') }}">
                                            </div>
                                            <div class="form-group mb-0 mt-1">
                                                <a href="javascript:void(0)" class="text-white d-flex align-items-center justify-content-center apply-coupon btn btn-sm btn-primary"
                                                            data-bs-placement="top"  data-bs-toggle="tooltip" title="{{ __('Apply') }}"><i class="fas fa-save"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                 <div class="card-footer py-3 px-3 border-top">
                                    <div class="text-end">
                                        <input type="submit" id="" value="{{ __('Pay Now') }}"
                                            class="btn-create btn btn-lg btn-primary badge-blue">
                                    </div>
                                </div>
                            </form>
                        </div>
                    @endif
                    @if (isset($admin_payments_details['is_midtrans_enabled']) && $admin_payments_details['is_midtrans_enabled'] == 'on')
                        <div id="midtrans_payment" class="card">
                            <div class="card-header">
                                <h5>{{ __('Midtrans') }}</h5>
                            </div>
                            <form role="form" action="{{ route('plan.get.midtrans') }}" method="get" class="require-validation" id="midtrans-payment-form">
                                @csrf
                                <div class="card-body">
                                    <input type="hidden" name="plan_id" value="{{ \Illuminate\Support\Facades\Crypt::encrypt($plan->id) }}">
                                    <div class="row p-3 payment-box">
                                        <div class="d-flex align-items-center input-btn-wrp">
                                            <div class="form-group w-100">
                                                <label for="midtrans_coupan"
                                                    class="form-label">{{ __('Coupon') }}</label>
                                                <input type="text" id="midtrans_coupan" name="coupon"
                                                    class="form-control coupon"
                                                    placeholder="{{ __('Enter Coupon Code') }}">
                                            </div>
                                            <div class="form-group mb-0 mt-1">
                                                <a href="javascript:void(0)" class="text-white d-flex align-items-center justify-content-center apply-coupon btn btn-sm btn-primary"
                                                            data-bs-placement="top"  data-bs-toggle="tooltip" title="{{ __('Apply') }}"><i class="fas fa-save"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                 <div class="card-footer py-3 px-3 border-top">
                                    <div class="text-end">
                                        <input type="submit" id="" value="{{ __('Pay Now') }}"
                                            class="btn-create btn btn-lg btn-primary badge-blue">
                                    </div>
                                </div>
                            </form>
                        </div>
                    @endif
                    @if (isset($admin_payments_details['is_xendit_enabled']) && $admin_payments_details['is_xendit_enabled'] == 'on')
                        <div id="xendit_payment" class="card">
                            <div class="card-header">
                                <h5>{{ __('Xendit') }}</h5>
                            </div>
                            <form role="form" action="{{ route('plan.xendit.payment') }}" method="get" class="require-validation" id="midtrans-payment-form">
                                @csrf
                                <div class="card-body">
                                    <input type="hidden" name="plan_id" value="{{ \Illuminate\Support\Facades\Crypt::encrypt($plan->id) }}">
                                    <div class="row p-3 payment-box">
                                        <div class="d-flex align-items-center input-btn-wrp">
                                            <div class="form-group w-100">
                                                <label for="xendit_coupan"
                                                    class="form-label">{{ __('Coupon') }}</label>
                                                <input type="text" id="xendit_coupan" name="coupon"
                                                    class="form-control coupon"
                                                    placeholder="{{ __('Enter Coupon Code') }}">
                                            </div>
                                            <div class="form-group mb-0 mt-1">
                                                <a href="javascript:void(0)" class="text-white d-flex align-items-center justify-content-center apply-coupon btn btn-sm btn-primary"
                                                            data-bs-placement="top"  data-bs-toggle="tooltip" title="{{ __('Apply') }}"><i class="fas fa-save"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                 <div class="card-footer py-3 px-3 border-top">
                                    <div class="text-end">
                                        <input type="submit" id="" value="{{ __('Pay Now') }}"
                                            class="btn-create btn btn-lg btn-primary badge-blue">
                                    </div>
                                </div>
                            </form>
                        </div>
                    @endif
                    @if (isset($admin_payments_details['is_nepalste_enabled']) && $admin_payments_details['is_nepalste_enabled'] == 'on')
                        <div id="nepalste_payment" class="card">
                            <div class="card-header">
                                <h5>{{ __('Nepalste') }}</h5>
                            </div>
                            <form role="form" action="{{ route('plan.pay.with.nepalste') }}" method="post" class="require-validation" id="nepalste-payment-form">
                                @csrf
                                <div class="card-body">
                                    <input type="hidden" name="plan_id" value="{{ \Illuminate\Support\Facades\Crypt::encrypt($plan->id) }}">
                                    <div class="row p-3 payment-box">
                                        <div class="d-flex align-items-center input-btn-wrp">
                                            <div class="form-group w-100">
                                                <label for="nepalste_coupan"
                                                    class="form-label">{{ __('Coupon') }}</label>
                                                <input type="text" id="nepalste_coupan" name="coupon"
                                                    class="form-control coupon"
                                                    placeholder="{{ __('Enter Coupon Code') }}">
                                            </div>
                                            <div class="form-group mb-0 mt-1">
                                                <a href="javascript:void(0)" class="text-white d-flex align-items-center justify-content-center apply-coupon btn btn-sm btn-primary"
                                                            data-bs-placement="top"  data-bs-toggle="tooltip" title="{{ __('Apply') }}"><i class="fas fa-save"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                 <div class="card-footer py-3 px-3 border-top">
                                    <div class="text-end">
                                        <input type="submit" id="" value="{{ __('Pay Now') }}"
                                            class="btn-create btn btn-lg btn-primary badge-blue">
                                    </div>
                                </div>
                            </form>
                        </div>
                    @endif
                    @if (isset($admin_payments_details['is_paiementpro_enabled']) && $admin_payments_details['is_paiementpro_enabled'] == 'on')
                        <div id="paiementpro_payment" class="card">
                            <div class="card-header">
                                <h5>{{ __('Paiement Pro') }}</h5>
                            </div>
                            <form role="form" action="{{ route('plan.pay.with.paiementpro') }}" method="post" class="require-validation" id="paiementpro-payment-form">
                                @csrf
                                <div class="card-body">
                                    <input type="hidden" name="plan_id" value="{{ \Illuminate\Support\Facades\Crypt::encrypt($plan->id) }}">

                                    <div class="row p-3 payment-box">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="mobile_number"
                                                    class="form-label text-dark">{{ __('Mobile Number') }}</label>
                                                <input type="text" id="mobile_number" name="mobile_number"
                                                    class="form-control mobile_number" data-from="mobile_number"
                                                    placeholder="{{ __('Enter Mobile Number') }}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="channel"
                                                    class="form-label text-dark">{{ __('Channel') }}</label>
                                                <input type="text" id="channel" name="channel"
                                                    class="form-control" data-from="paiementpro"
                                                    placeholder="{{ __('Enter Channel Code') }}" required>
                                                    <small class="text-danger">{{ __('Example : OMCIV2,MOMO,CARD,FLOOZ ,PAYPAL') }}</small>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center input-btn-wrp">
                                            <div class="form-group w-100">
                                                <label for="paiementpro_coupan"
                                                    class="form-label">{{ __('Coupon') }}</label>
                                                <input type="text" id="paiementpro_coupan" name="coupon"
                                                    class="form-control coupon"
                                                    placeholder="{{ __('Enter Coupon Code') }}">
                                            </div>
                                            <div class="form-group mb-0 mt-1">
                                                <a href="javascript:void(0)" class="text-white d-flex align-items-center justify-content-center apply-coupon btn btn-sm btn-primary"
                                                            data-bs-placement="top"  data-bs-toggle="tooltip" title="{{ __('Apply') }}"><i class="fas fa-save"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                 <div class="card-footer py-3 px-3 border-top">
                                    <div class="text-end">
                                        <input type="submit" id="" value="{{ __('Pay Now') }}"
                                            class="btn-create btn btn-lg btn-primary badge-blue">
                                    </div>
                                </div>
                            </form>
                        </div>
                    @endif
                    @if (isset($admin_payments_details['is_fedapay_enabled']) && $admin_payments_details['is_fedapay_enabled'] == 'on')
                        <div id="fedapay_payment" class="card">
                            <div class="card-header">
                                <h5>{{ __('Fedapay') }}</h5>
                            </div>
                            <form role="form" action="{{ route('plan.pay.with.fedapay') }}" method="post" class="require-validation" id="fedapay-payment-form">
                                @csrf
                                <div class="card-body">
                                    <input type="hidden" name="plan_id" value="{{ \Illuminate\Support\Facades\Crypt::encrypt($plan->id) }}">
                                    <div class="row p-3 payment-box">
                                        <div class="d-flex align-items-center input-btn-wrp">
                                            <div class="form-group w-100">
                                                <label for="fedapay_coupan"
                                                    class="form-label">{{ __('Coupon') }}</label>
                                                <input type="text" id="fedapay_coupan" name="coupon"
                                                    class="form-control coupon"
                                                    placeholder="{{ __('Enter Coupon Code') }}">
                                            </div>
                                            <div class="form-group mb-0 mt-1">
                                                <a href="javascript:void(0)" class="text-white d-flex align-items-center justify-content-center apply-coupon btn btn-sm btn-primary"
                                                            data-bs-placement="top"  data-bs-toggle="tooltip" title="{{ __('Apply') }}"><i class="fas fa-save"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                 <div class="card-footer py-3 px-3 border-top">
                                    <div class="text-end">
                                        <input type="submit" id="" value="{{ __('Pay Now') }}"
                                            class="btn-create btn btn-lg btn-primary badge-blue">
                                    </div>
                                </div>
                            </form>
                        </div>
                    @endif
                    @if (isset($admin_payments_details['is_payhere_enabled']) && $admin_payments_details['is_payhere_enabled'] == 'on')
                        <div id="payhere_payment" class="card">
                            <div class="card-header">
                                <h5>{{ __('PayHere') }}</h5>
                            </div>
                            <form role="form" action="{{ route('plan.pay.with.payhere') }}" method="post" class="require-validation" id="payhere-payment-form">
                                @csrf
                                <div class="card-body">
                                    <input type="hidden" name="plan_id" value="{{ \Illuminate\Support\Facades\Crypt::encrypt($plan->id) }}">
                                    <div class="row p-3 payment-box">
                                        <div class="d-flex align-items-center input-btn-wrp">
                                            <div class="form-group w-100">
                                                <label for="payhere_coupan"
                                                    class="form-label">{{ __('Coupon') }}</label>
                                                <input type="text" id="payhere_coupan" name="coupon"
                                                    class="form-control coupon"
                                                    placeholder="{{ __('Enter Coupon Code') }}">
                                            </div>
                                            <div class="form-group mb-0 mt-1">
                                                <a href="javascript:void(0)" class="text-white d-flex align-items-center justify-content-center apply-coupon btn btn-sm btn-primary"
                                                            data-bs-placement="top"  data-bs-toggle="tooltip" title="{{ __('Apply') }}"><i class="fas fa-save"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                 <div class="card-footer py-3 px-3 border-top">
                                    <div class="text-end">
                                        <input type="submit" id="" value="{{ __('Pay Now') }}"
                                            class="btn-create btn btn-lg btn-primary badge-blue">
                                    </div>
                                </div>
                            </form>
                        </div>
                    @endif
                    @if (isset($admin_payments_details['is_cinetpay_enabled']) && $admin_payments_details['is_cinetpay_enabled'] == 'on')
                        <div id="cinetpay_payment" class="card">
                            <div class="card-header">
                                <h5>{{ __('CinetPay') }}</h5>
                            </div>
                            <form role="form" action="{{ route('plan.pay.with.cinetpay') }}" method="post" class="require-validation" id="cinetpay-payment-form">
                                @csrf
                                <div class="card-body">
                                    <input type="hidden" name="plan_id" value="{{ \Illuminate\Support\Facades\Crypt::encrypt($plan->id) }}">
                                    <div class="row p-3 payment-box">
                                        <div class="d-flex align-items-center input-btn-wrp">
                                            <div class="form-group w-100">
                                                <label for="cinetpay_coupan"
                                                    class="form-label">{{ __('Coupon') }}</label>
                                                <input type="text" id="cinetpay_coupan" name="coupon"
                                                    class="form-control coupon"
                                                    placeholder="{{ __('Enter Coupon Code') }}">
                                            </div>
                                            <div class="form-group mb-0 mt-1">
                                                <a href="javascript:void(0)" class="text-white d-flex align-items-center justify-content-center apply-coupon btn btn-sm btn-primary"
                                                            data-bs-placement="top"  data-bs-toggle="tooltip" title="{{ __('Apply') }}"><i class="fas fa-save"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                 <div class="card-footer py-3 px-3 border-top">
                                    <div class="text-end">
                                        <input type="submit" id="" value="{{ __('Pay Now') }}"
                                            class="btn-create btn btn-lg btn-primary badge-blue">
                                    </div>
                                </div>
                            </form>
                        </div>
                    @endif
                    @if (isset($admin_payments_details['is_tap_enabled']) && $admin_payments_details['is_tap_enabled'] == 'on')
                        <div id="tap_payment" class="card">
                            <div class="card-header">
                                <h5>{{ __('Tap') }}</h5>
                            </div>
                            <form role="form" action="{{ route('plan.pay.with.tap') }}" method="post" class="require-validation" id="tap-payment-form">
                                @csrf
                                <div class="card-body">
                                    <input type="hidden" name="plan_id" value="{{ \Illuminate\Support\Facades\Crypt::encrypt($plan->id) }}">
                                    <div class="row p-3 payment-box">
                                        <div class="d-flex align-items-center input-btn-wrp">
                                            <div class="form-group w-100">
                                                <label for="tap_coupan"
                                                    class="form-label">{{ __('Coupon') }}</label>
                                                <input type="text" id="tap_coupan" name="coupon"
                                                    class="form-control coupon"
                                                    placeholder="{{ __('Enter Coupon Code') }}">
                                            </div>
                                            <div class="form-group mb-0 mt-1">
                                                <a href="javascript:void(0)" class="text-white d-flex align-items-center justify-content-center apply-coupon btn btn-sm btn-primary"
                                                            data-bs-placement="top"  data-bs-toggle="tooltip" title="{{ __('Apply') }}"><i class="fas fa-save"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                 <div class="card-footer py-3 px-3 border-top">
                                    <div class="text-end">
                                        <input type="submit" id="" value="{{ __('Pay Now') }}"
                                            class="btn-create btn btn-lg btn-primary badge-blue">
                                    </div>
                                </div>
                            </form>
                        </div>
                    @endif
                    @if (isset($admin_payments_details['is_authorizenet_enabled']) && $admin_payments_details['is_authorizenet_enabled'] == 'on')
                        <div id="authorizenet_payment" class="card">
                            <div class="card-header">
                                <h5>{{ __('AuthorizeNet') }}</h5>
                            </div>
                            <form role="form" action="{{ route('plan.pay.with.authorizenet') }}" method="post" class="require-validation" id="authorizenet-payment-form">
                                @csrf
                                <div class="card-body">
                                    <input type="hidden" name="plan_id" value="{{ \Illuminate\Support\Facades\Crypt::encrypt($plan->id) }}">
                                    <div class="row p-3 payment-box">
                                        <div class="d-flex align-items-center input-btn-wrp">
                                            <div class="form-group w-100">
                                                <label for="authorizenet_coupan"
                                                    class="form-label">{{ __('Coupon') }}</label>
                                                <input type="text" id="authorizenet_coupan" name="coupon"
                                                    class="form-control coupon"
                                                    placeholder="{{ __('Enter Coupon Code') }}">
                                            </div>
                                            <div class="form-group mb-0 mt-1">
                                                <a href="javascript:void(0)" class="text-white d-flex align-items-center justify-content-center apply-coupon btn btn-sm btn-primary"
                                                            data-bs-placement="top"  data-bs-toggle="tooltip" title="{{ __('Apply') }}"><i class="fas fa-save"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                 <div class="card-footer py-3 px-3 border-top">
                                    <div class="text-end">
                                        <input type="submit" id="" value="{{ __('Pay Now') }}"
                                            class="btn-create btn btn-lg btn-primary badge-blue">
                                    </div>
                                </div>
                            </form>
                        </div>
                    @endif
                    @if (isset($admin_payments_details['is_khalti_enabled']) && $admin_payments_details['is_khalti_enabled'] == 'on')
                        <div id="khalti_payment" class="card">
                            <div class="card-header">
                                <h5>{{ __('Khalti') }}</h5>
                            </div>
                            <form role="form" action="{{ route('plan.pay.with.khalti') }}" method="post" class="require-validation" id="khalti-payment-form">
                                @csrf
                                <div class="card-body">
                                    <input type="hidden" name="plan_id" class="khalti_plan_id" value="{{ \Illuminate\Support\Facades\Crypt::encrypt($plan->id) }}">
                                    <div class="row p-3 payment-box">
                                        <div class="d-flex align-items-center input-btn-wrp">
                                            <div class="form-group w-100">
                                                <label for="khalti_coupan"
                                                    class="form-label">{{ __('Coupon') }}</label>
                                                <input type="text" id="khalti_coupan" name="coupon"
                                                    class="form-control coupon"
                                                    placeholder="{{ __('Enter Coupon Code') }}">
                                            </div>
                                            <div class="form-group mb-0 mt-1">
                                                <a href="javascript:void(0)" class="text-white d-flex align-items-center justify-content-center apply-coupon btn btn-sm btn-primary"
                                                            data-bs-placement="top"  data-bs-toggle="tooltip" title="{{ __('Apply') }}"><i class="fas fa-save"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                 <div class="card-footer py-3 px-3 border-top">
                                    <div class="text-end">
                                        <input type="submit" id="pay_with_khalti" value="{{ __('Pay Now') }}"
                                            class="btn-create btn btn-lg btn-primary badge-blue">
                                    </div>
                                </div>
                            </form>
                        </div>
                    @endif
                    @if (isset($admin_payments_details['is_ozow_enabled']) && $admin_payments_details['is_ozow_enabled'] == 'on')
                        <div id="ozow_payment" class="card">
                            <div class="card-header">
                                <h5>{{ __('Ozow') }}</h5>
                            </div>
                            <form role="form" action="{{ route('plan.pay.with.ozow') }}" method="post" class="require-validation" id="ozow-payment-form">
                                @csrf
                                <div class="card-body">
                                    <input type="hidden" name="plan_id" value="{{ \Illuminate\Support\Facades\Crypt::encrypt($plan->id) }}">
                                    <div class="row p-3 payment-box">
                                        <div class="d-flex align-items-center input-btn-wrp">
                                            <div class="form-group w-100">
                                                <label for="ozow_coupan"
                                                    class="form-label">{{ __('Coupon') }}</label>
                                                <input type="text" id="ozow_coupan" name="coupon"
                                                    class="form-control coupon"
                                                    placeholder="{{ __('Enter Coupon Code') }}">
                                            </div>
                                            <div class="form-group mb-0 mt-1">
                                                <a href="javascript:void(0)" class="text-white d-flex align-items-center justify-content-center apply-coupon btn btn-sm btn-primary"
                                                            data-bs-placement="top"  data-bs-toggle="tooltip" title="{{ __('Apply') }}"><i class="fas fa-save"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                 <div class="card-footer py-3 px-3 border-top">
                                    <div class="text-end">
                                        <input type="submit" id="" value="{{ __('Pay Now') }}"
                                            class="btn-create btn btn-lg btn-primary badge-blue">
                                    </div>
                                </div>
                            </form>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    @endsection
