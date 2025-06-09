@extends('layouts.admin')
@section('page-title')
    {{ __('Plans') }}
@endsection
@php
    $dir = asset(Storage::url('uploads/plan'));
    $settings = Utility::settings();
@endphp
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Home') }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('Plans') }}</li>
@endsection
@section('title')
    <div class="d-inline-block">
        <h5 class="h4 d-inline-block text-white font-weight-bold mb-0 ">{{ __('Plans') }}</h5>
    </div>
@endsection
@section('action-btn')

    @if (Auth::user()->type == 'super admin')
            @can('Create Plans')
            <div class="pr-2 action-btn-wrapper">
                <a class="btn btn-sm btn-icon  btn-primary text-white" data-url="{{ route('plans.create') }}" data-title="{{ __('Create New Plan') }}" data-ajax-popup="true" data-size="lg" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('Create') }}">
                    <i  data-feather="plus"></i>
                </a>
            </div>
            @endcan
    @endif
@endsection
@section('content')
    <div class="row row-gap mb-4">
        @foreach ($plans as $plan)
            <div class="col-xxl-3 col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12">
                <div class="plan_card d-flex flex-column h-100"">
                    <div class="card price-card h-100 mb-0 price-1 wow animate__fadeInUp" data-wow-delay="0.2s" style="
                                        visibility: visible;
                                        animation-delay: 0.2s;
                                        animation-name: fadeInUp;
                                      ">
                        <div class="card-body">
                            <span class="price-badge bg-primary">{{ $plan->name }}</span>
                            @if (\Auth::user()->type !== 'super admin' && \Auth::user()->plan == $plan->id)
                                <div class="d-flex flex-row-reverse m-0 p-0 plan-active-status">
                                    <span class="d-flex align-items-center ">
                                        <i class="f-10 lh-1 fas fa-circle text-primary"></i>
                                        <span class="ms-2">{{ __('Active') }}</span>
                                    </span>
                                </div>
                            @endif

                            @if( \Auth::user()->type == 'super admin')
                                <div class="row d-flex my-2">
                                    <div class="col-6 text-start">
                                        @can('Edit Plans')
                                            @if($plan->id != 1)
                                                <div class="align-items-center mt-1">
                                                    <div class="form-check form-switch custom-switch-v1">
                                                        <input type="checkbox" name="plan_active"
                                                        class="form-check-input input-primary is_active" value="1"
                                                        data-id='{{ $plan->id }}'
                                                        data-name="{{ __('plan') }}"
                                                        {{ $plan->is_active == 1 ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="plan_active"></label>
                                                    </div>
                                                </div>
                                            @endif
                                        @endcan
                                    </div>
                                    <div class="col-6  d-flex justify-content-end action-btn-wrapper {{ isset($settings['SITE_RTL']) && $settings['SITE_RTL'] == 'on' ? 'text-start' : 'text-end' }}">
                                        @can('Edit Plans')
                                            <div class="d-inline-flex align-items-center">
                                                <a class="btn btn-sm btn-icon  bg-info text-white me-2" data-url="{{ route('plans.edit',$plan->id) }}" data-title="{{__('Edit Plan')}}" data-ajax-popup="true" data-size="lg" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('Edit') }}">
                                                    <i  class=" ti ti-pencil f-20"></i>
                                                </a>
                                            </div>
                                        @endcan
                                        @can('Edit Plans')
                                            @if($plan->id != 1)
                                                <a class="bs-pass-para btn btn-sm btn-icon bg-danger text-white"
                                                    data-title="{{ __('Delete') }}"
                                                    data-confirm="{{ __('Are You Sure?') }}"
                                                    data-text="{{ __('This action can not be undone. Do you want to continue?') }}"
                                                    data-confirm-yes="delete-form-{{ $plan->id }}"
                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                    title="{{ __('Delete') }}">
                                                    <i class="ti ti-trash f-20"></i>
                                                </a>
                                                {!! Form::open(['method' => 'DELETE', 'route' => ['plans.destroy', $plan->id], 'id' => 'delete-form-' . $plan->id]) !!}
                                                {!! Form::close() !!}
                                            @endif
                                        @endcan
                                    </div>
                                </div>
                            @endif
                            <h3 class="mb-3 f-w-600 mt-3">
                                {{ isset($admin_payments_setting['currency_symbol']) ? $admin_payments_setting['currency_symbol'] : '$' }}{{ $plan->price . ' / ' . __(\App\Models\Plan::$arrDuration[$plan->duration]) }}</small>
                            </h3>
                            <div class="plan-card-detail text-center">
                                @if ($plan->trial == 'on')
                                    <p class="mb-1">{{__('Free Trial Days : ')}}<b>{{ $plan->trial_days }}</b></p>
                                @else
                                    <p class="mb-1">{{__('Free Trial Days : ')}}<b>{{ 0 }}</b></p>
                                @endif
                                @if ($plan->description)
                                    <p class="mb-0">
                                        {{ $plan->description }}<br />
                                    </p>
                                @endif
                                <ul class="list-unstyled d-inline-block plan-item-wrp  my-4">
                                    @if ($plan->enable_custdomain == 'on')
                                        <li class="d-flex align-items-center">
                                            <span class="theme-avtar">
                                            <i class="text-primary ti ti-circle-plus"></i></span>{{ __('Custom Domain') }}
                                        </li>
                                    @else
                                        <li class="text-danger d-flex align-items-center">
                                                <span class="theme-avtar">
                                                <i class="text-danger ti ti-circle-minus"></i></span>{{ __('Custom Domain') }}
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
                                                <i class="text-danger ti ti-circle-minus"></i>
                                            </span>{{ __('Sub Domain') }}
                                        </li>
                                    @endif
                                    @if ($plan->shipping_method == 'on')
                                        <li class="d-flex align-items-center">
                                            <span class="theme-avtar">
                                                <i class="text-primary ti ti-circle-plus"></i>
                                            </span>{{ __('Shipping Method') }}
                                        </li>
                                    @else
                                        <li class="text-danger d-flex align-items-center">
                                            <span class="theme-avtar">
                                                <i class="text-danger ti ti-circle-minus"></i>
                                            </span>{{ __('Shipping Method') }}
                                        </li>
                                    @endif

                                    @if ($plan->additional_page == 'on')
                                        <li class="d-flex align-items-center">
                                                <span class="theme-avtar">
                                                    <i class="text-primary ti ti-circle-plus"></i>
                                                </span>{{ __('Additional Page') }}
                                        </li>
                                    @else
                                        <li class="text-danger d-flex align-items-center">
                                                <span class="theme-avtar">
                                                <i class="text-danger ti ti-circle-minus"></i></span>{{ __('Additional Page') }}
                                        </li>
                                    @endif
                                    @if ($plan->blog == 'on')
                                        <li class="d-flex align-items-center">
                                                <span class="theme-avtar">
                                                    <i class="text-primary ti ti-circle-plus"></i></span>{{ __('Blog') }}
                                        </li>
                                    @else
                                        <li class="text-danger d-flex align-items-center">
                                                <span class="theme-avtar">
                                                    <i class="text-danger ti ti-circle-minus"></i></span>{{ __('Blog') }}
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
                                        <li class=" text-danger d-flex align-items-center">
                                                <span class="theme-avtar">
                                                <i class="text-danger ti ti-circle-minus"></i
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
                                                <i class="text-danger ti ti-circle-minus"></i></span>{{ __('Chatgpt') }}
                                        </li>
                                    @endif

                                </ul>

                            </div>
                            <div class="row row-gap mb-4 mt-2 justify-content-center">
                                <div class="col-auto text-center">
                                    @if ($plan->max_products == '-1')
                                        <span class="h5 mb-0">{{ __('Unlimited') }}</span>
                                    @else
                                        <span class="h5 mb-0">{{ $plan->max_products }}</span>
                                    @endif
                                    <span class="d-block text-sm">{{ __('Products') }}</span>
                                </div>
                                <div class="col-auto text-center">
                                        <span class="h5 mb-0">
                                            @if ($plan->max_stores == '-1')
                                                <span class="h5 mb-0">{{ __('Unlimited') }}</span>
                                            @else
                                                <span class="h5 mb-0">{{ $plan->max_stores }}</span>
                                            @endif
                                        </span>
                                    <span class="d-block text-sm">{{ __('Store') }}</span>
                                </div>
                                <div class="col-auto text-center">
                                    <span class="h5 mb-0">
                                        @if ($plan->max_users == '-1')
                                            <span class="h5 mb-0">{{ __('Unlimited') }}</span>
                                        @else
                                            <span class="h5 mb-0">{{ $plan->max_users }}</span>
                                        @endif
                                    </span>
                                    <span class="d-block text-sm">{{ __('Users') }}</span>
                                </div>
                                <div class="col-auto text-center">
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
                            <div class="row m-0 plan-btn-wrpper justify-content-center">
                                @if (\Auth::user()->type != 'super admin')
                                    @if($plan->price <= 0)
                                        <div class="col-12">
                                            <p class="server-plan font-bold text-center mx-sm-5">
                                                {{ __('Lifetime') }}
                                            </p>
                                        </div>
                                    @elseif(\Auth::user()->trial_plan == $plan->id && \Auth::user()->trial_expire_date && date('Y-m-d') < \Auth::user()->trial_expire_date)
                                        <div class="col-12">
                                            <p class="display-total-time text-dark mb-0">
                                                {{ __('Plan Trial Expired : ') }}
                                                {{ !empty(\Auth::user()->trial_expire_date) ? \Auth::user()->dateFormat(\Auth::user()->trial_expire_date) : 'lifetime' }}
                                            </p>
                                        </div>
                                    @elseif (\Auth::user()->plan == $plan->id && date('Y-m-d') < \Auth::user()->plan_expire_date && \Auth::user()->is_trial_done != 1)
                                        <h5 class="h6 my-4">
                                            {{ __('Expired : ') }}
                                            {{ \Auth::user()->plan_expire_date? \App\Models\Utility::dateFormat(\Auth::user()->plan_expire_date): __('Lifetime') }}
                                        </h5>
                                    @elseif(\Auth::user()->plan == $plan->id && !empty(\Auth::user()->plan_expire_date) && \Auth::user()->plan_expire_date < date('Y-m-d'))
                                        <div class="col-12">
                                            <p class="server-plan font-weight-bold text-center mx-sm-5">
                                                {{ __('Expired') }}
                                            </p>
                                        </div>
                                    @elseif(\Auth::user()->plan == $plan->id && $plan->duration == 'Lifetime')
                                        <h5 class="h6 my-4">
                                            {{ __('Expired : ') }}
                                            {{ __('Lifetime') }}
                                        </h5>

                                    @else
                                        @if (
                                            $plan->price > 0 &&
                                                \Auth::user()->trial_plan == 0 &&
                                                \Auth::user()->plan != $plan->id && $plan->trial != 'off' && $plan->trial_days != 0)
                                            <div class="{{ $plan->id == 1 ? 'col-auto' : 'col-auto' }} px-0">
                                                <a href="{{ route('plan.trial', \Illuminate\Support\Facades\Crypt::encrypt($plan->id)) }}"
                                                    data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('Free Trial') }}"
                                                    class="btn  btn-primary plan-btn g-2 d-flex justify-content-center align-items-center ">{{ __('Free Trial') }}
                                                    <i class="fas fa-arrow-right m-1"></i>
                                                </a>
                                            </div>
                                            <div class="{{ $plan->id == 1 ? 'col-auto' : 'col-auto' }} p-1">
                                                <a href="{{ route('stripe', \Illuminate\Support\Facades\Crypt::encrypt($plan->id)) }}"
                                                    data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('Subscribe') }}"
                                                    class="btn  btn-primary plan-btn  d-flex justify-content-center align-items-center ">{{ __('Subscribe') }}
                                                    <i class="fas fa-arrow-right m-1"></i>
                                                </a>
                                            </div>
                                        @else
                                            <div class="{{ $plan->id == 1 ? 'col-auto' : 'col-auto' }} p-1">
                                                <a href="{{ route('stripe', \Illuminate\Support\Facades\Crypt::encrypt($plan->id)) }}"
                                                    data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('Subscribe') }}"
                                                    class="btn  btn-primary plan-btn d-flex justify-content-center align-items-center ">{{ __('Subscribe') }}
                                                    <i class="fas fa-arrow-right m-1"></i>
                                                </a>
                                            </div>
                                        @endif

                                    @endif
                                @endif

                                {{-- @if(\Auth::user()->type =='Owner' && $plan->id != \Auth::user()->plan && $plan->id !== 1)
                                    <div class="{{ $plan->id == 1 ? 'col-12' : 'col-8' }}">
                                        <a href="{{ route('stripe', \Illuminate\Support\Facades\Crypt::encrypt($plan->id)) }}"
                                            class="btn  btn-primary d-flex justify-content-center align-items-center ">{{ __('Subscribe') }}
                                                <i class="fas fa-arrow-right m-1"></i></a>
                                            <p></p>
                                    </div>
                                @endif --}}
                                @if (\Auth::user()->type != 'super admin' && \Auth::user()->plan != $plan->id)
                                    @if ($plan->id != 1)
                                        @if (\Auth::user()->requested_plan != $plan->id)
                                            <div class="col-auto px-0">
                                                <a href="{{ route('send.request',[\Illuminate\Support\Facades\Crypt::encrypt($plan->id)]) }}"
                                                   class="btn plan-request-btn mt-1 btn-primary my-0 btn-icon d-flex justify-content-center align-items-center"
                                                   data-title="{{ __('Send Request') }}"  data-bs-toggle="tooltip" data-bs-placement="top"
                                                   title="{{ __('Send Request') }}">
                                                    <span class="btn-inner--icon"><i class="fas fa-share m-1"></i></span>
                                                </a>
                                            </div>
                                        @else
                                            <div class="col-auto px-0">
                                                <a href="{{  route('request.cancel',\Auth::user()->id) }} }}"
                                                   class="btn btn-icon plan-request-btn mt-1 my-0 btn-danger d-flex justify-content-center align-items-center"
                                                   data-title="{{ __('Cancel Request') }}"  data-bs-toggle="tooltip" data-bs-placement="top"
                                                   title="{{ __('Cancel Request') }}">
                                                    <span class="btn-inner--icon"><i class="fas fa-times m-1"></i></span>
                                                </a>
                                            </div>
                                        @endif
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body pb-0 table-border-style">
                    <h5></h5>
                    <div class="table-responsive">
                        <table class="table mb-0 dataTable ">
                            <thead>
                            <tr>
                                <th> {{ __('Order Id') }}</th>
                                <th>{{ __('Date') }}</th>
                                <th>{{ __('Name') }}</th>
                                <th>{{ __('Plan Name') }}</th>
                                <th> {{ __('Price') }}</th>
                                <th> {{ __('Payment Type') }}</th>
                                <th> {{ __('Status') }}</th>
                                <th> {{ __('Coupon') }}</th>
                                <th> {{ __('Invoice') }}</th>
                                @if(\Auth::user()->type == 'super admin')
                                    <th>{{ __('Action') }}</th>
                                @endif
                            </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $order)
                                    <tr>
                                        <td>{{ $order->order_id }}</td>
                                        <td>{{ $order->created_at->format('d M Y') }}</td>
                                        <td>{{ $order->user_name }}</td>
                                        <td>{{ $order->plan_name }}</td>
                                        <td>{{ isset($admin_payments_setting['currency_symbol']) ? $admin_payments_setting['currency_symbol'] . $order->price : '$' . $order->price }}</td>
                                        <td>{{ $order->payment_type }}</td>
                                        <td>
                                            @if ($order->payment_status == 'succeeded')
                                                <i class="mdi mdi-circle text-primary"></i>
                                                {{ ucfirst($order->payment_status) }}
                                            @else
                                                <i class="mdi mdi-circle text-danger"></i>
                                                {{ ucfirst($order->payment_status) }}
                                            @endif
                                        </td>

                                        <td>{{ !empty($order->total_coupon_used)? (!empty($order->total_coupon_used->coupon_detail)? $order->total_coupon_used->coupon_detail->code: '-'): '-' }}
                                        </td>

                                        <td class="text-center">
                                            @if ($order->receipt != 'free coupon' && $order->payment_type == 'STRIPE')
                                                <a href="{{ $order->receipt }}" title="Invoice" target="_blank"
                                                class=""><i class="fas fa-file-invoice"></i> </a>
                                            @elseif ($order->payment_type == 'Bank Transfer')
                                                <a href="{{ \App\Models\Utility::get_file($order->receipt) }}"  title="Invoice" target="_blank"
                                                    class="" download="">
                                                    <i class="fas fa-file-invoice"></i>
                                                </a>
                                            @elseif($order->receipt == 'free coupon')
                                                <p>{{ __('Used') . '100 %' . __('discount coupon code.') }}</p>
                                            @elseif($order->payment_type == 'Manually')
                                                <p>{{ __('Manually plan upgraded by super admin') }}</p>
                                            @else
                                                -
                                            @endif
                                        </td>
                                        @if(\Auth::user()->type == 'super admin')
                                            <td>
                                                <div class="d-flex action-btn-wrapper">
                                                    <a class="bs-pass-para btn btn-sm btn-icon bg-danger text-white" href="#"
                                                        data-title="{{ __('Delete Order') }}"
                                                        data-confirm="{{ __('Are You Sure?') }}"
                                                        data-text="{{ __('This action can not be undone. Do you want to continue?') }}"
                                                        data-confirm-yes="delete-form-{{ $order->id }}"
                                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                                        data-bs-original-title="{{ __('Delete') }}"
                                                        title="{{ __('Delete') }}">
                                                        <i class="ti ti-trash f-20"></i>
                                                    </a>
                                                    {!! Form::open(['method' => 'DELETE', 'route' => ['planorder.destroy', $order->id], 'id' => 'delete-form-' . $order->id]) !!}
                                                    {!! Form::close() !!}
                                                    @if($order->payment_status == 'pending' && $order->payment_type == 'Bank Transfer')
                                                        <a href="#" class="mx-2 btn btn-sm btn-icon bg-secondary text-white align-items-center"
                                                            data-url="{{ route('bank_transfer.show',$order->id) }}"
                                                            data-ajax-popup="true" data-size="lg" data-bs-toggle="tooltip" title="{{ __('Payment Status') }}" data-bs-placement="top" 
                                                            data-title="{{ __('Payment Status') }}"
                                                            data-bs-original-title="{{ __('Payment Status') }}">
                                                            <i class="ti ti-caret-right"></i>
                                                        </a>
                                                    @endif
                                                    @php
                                                        $user = \App\Models\User::find($order->user_id);
                                                    @endphp
                                                    @foreach($userOrders as $userOrder)
                                                        @if ($user->plan == $order->plan_id &&
                                                            $order->order_id == $userOrder->order_id &&
                                                            $order->is_refund == 0 && $user->plan != 1)
                                                                <a href="{{ route('order.refund' , [$order->id , $order->user_id])}}"
                                                                    class="badge bg-warning rounded p-2 px-3 common-lbl-radius ms-2 d-flex align-items-center"
                                                                    data-bs-toggle="tooltip" title="{{ __('Refund') }}" data-bs-placement="top" 
                                                                    data-bs-original-title="{{ __('Refund') }}">
                                                                    <span class ="text-white">{{ __('Refund') }}</span>
                                                                </a>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script-page')
    {{-- <script>
        $(document).ready(function() {
            var tohref = '';
            @if (Auth::user()->is_register_trial == 1)
                tohref = $('#trial_{{ Auth::user()->interested_plan_id }}').attr("href");
            @elseif(Auth::user()->interested_plan_id != 0)
                tohref = $('#interested_plan_{{ Auth::user()->interested_plan_id }}').attr("href");
            @endif

            if (tohref != '') {
                window.location = tohref;
            }
        });
    </script> --}}
    <script>
        $(document).on("click", ".is_active", function() {

            var id = $(this).attr('data-id');
            var is_active = ($(this).is(':checked')) ? $(this).val() : 0;

            $.ajax({
                url: '{{ route('plan.enable') }}',
                type: 'POST',
                data: {
                    "is_active": is_active,
                    "id": id,
                    "_token": "{{ csrf_token() }}",
                },
                success: function(data) {
                    if (data.success) {
                        show_toastr('Success', data.success, 'success');
                    } else {
                        show_toastr('Error', data.error, 'error');

                    }

                }
            });
        });
    </script>
@endpush
