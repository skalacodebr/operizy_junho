@php
    $store = \App\Models\Store::where('slug', $slug)->where('is_store_enabled', '1')->first();
    if (!empty(session()->get('lang'))) {
        $lang = session()->get('lang');
    } else {
        $lang = $store->lang;
    }
    $SITE_RTL = 'off';
@endphp
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0" />
    <meta name="author" content="{{ env('APP_NAME') }}">
    <meta name="title" content="{{ $store->metakeyword }}">
    <meta name="description" content="{{ ucfirst($store->metadesc) }}">
    <meta name="keywords" content="{{ $store->metakeyword }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        .invalid-feedback {
            color: red;
        }

        .btn-login {
            font-size: 14px;
            color: #fff;
            font-family: 'Montserrat-SemiBold';
            background: #0f5ef7;
            margin-top: 20px;
            padding: 10px 30px;
            width: 100%;
            border-radius: 5px;
            border: none;
            text-decoration: none;
        }
        .size{
            font-size: 16px;
        }
    </style>
</head>

<body class="color-v1" lang="en" dir="{{ $SITE_RTL == 'on' ? 'rtl' : '' }}">
    <svg style="display: none;">
        <symbol viewBox="0 0 6 5" id="slickarrow">
            <path fill-rule="evenodd" clip-rule="evenodd"
                d="M5.89017 2.75254C6.03661 2.61307 6.03661 2.38693 5.89017 2.24746L3.64017 0.104605C3.49372 -0.0348681 3.25628 -0.0348681 3.10984 0.104605C2.96339 0.244078 2.96339 0.470208 3.10984 0.609681L5.09467 2.5L3.10984 4.39032C2.96339 4.52979 2.96339 4.75592 3.10984 4.8954C3.25628 5.03487 3.49372 5.03487 3.64016 4.8954L5.89017 2.75254ZM0.640165 4.8954L2.89017 2.75254C3.03661 2.61307 3.03661 2.38693 2.89017 2.24746L0.640165 0.104605C0.493719 -0.0348682 0.256282 -0.0348682 0.109835 0.104605C-0.0366115 0.244078 -0.0366115 0.470208 0.109835 0.609681L2.09467 2.5L0.109835 4.39032C-0.0366117 4.52979 -0.0366117 4.75592 0.109835 4.8954C0.256282 5.03487 0.493719 5.03487 0.640165 4.8954Z">
            </path>
        </symbol>
    </svg>
    <!--wrapper start here-->
    <div class="wrapper">
        <section class="login-section">
            <div class="offset-left">
                <div class="row">
                    <div class="col-md-12">
                        <div class="login-left">
                            <div class="section-title">
                                <h6>{{ $store->name }}</h6>
                            </div>
                            <p class="size">{{__('You are receiving this email because we received a password reset request for your account')}}</p><br><br>

                            <div><a href="{{ route('customer.reset.password',[$slug,$token]) }}" target="_blank" class="btn-login" >{{__('Reset Password')}}</a></div><br><br>

                            <p class="text-muted size">
                                {{ __('If you did not request a password reset, no further action is required..') }}
                            </p><br>
                            <p class="size">{{__('Regards')}},</p>
                            <p class="size">{{ $store->name }}</p>
                            <br>
                            <hr>
                            <p> {{__('If you’re having trouble clicking the "Reset Password" button, copy and paste the URL below into your web browser:')}} <a href="{{ url($slug.'/reset-password/'.$token) }}">{{ url($slug.'/reset-password/'.$token) }}</a> </p><br>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

</body>

</html>
