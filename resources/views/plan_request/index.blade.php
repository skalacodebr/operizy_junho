@extends('layouts.admin')
@section('page-title')
    {{__('Plan Requests')}}
@endsection
@section('title')
<h5 class="h4 d-inline-block font-weight-bold mb-0 text-white">{{__('Plan Requests')}}</h5>
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Home') }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('Plan Requests') }}</li>
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body pb-0 table-border-style">
                    <div class="table-responsive">
                        <table class="table mb-0 dataTable">
                            <thead>
                                <tr>
                                    <th>{{ __('Name') }}</th>
                                    <th>{{ __('Plan Name') }}</th>
                                    <th>{{ __('Max Products') }}</th>
                                    <th>{{ __('Max Stores') }}</th>
                                    <th>{{ __('Duration') }}</th>
                                    <th>{{ __('Created at') }}</th>
                                    <th class="text-right">{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($plan_requests as $prequest)

                                    <tr>
                                        <td>
                                            <div class="font-style font-weight-bold">{{ $prequest->user->name }}</div>
                                        </td>
                                        <td>
                                            <div class="font-style font-weight-bold">{{ $prequest->plan->name }}</div>
                                        </td>
                                        <td>
                                            <div class="font-weight-bold">
                                                @if ($prequest->plan->max_products == '-1')
                                                    {{ __('Unlimited') }}
                                                @else
                                                    {{ $prequest->plan->max_products }}
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            <div class="font-weight-bold">
                                                @if ($prequest->plan->max_stores == '-1')
                                                    {{ __('Unlimited') }}
                                                @else
                                                    {{ $prequest->plan->max_stores }}
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            <div class="font-style font-weight-bold">{{ ($prequest->duration == 'Lifetime') ? __('Lifetime') : 'One '.$prequest->duration }}</div>
                                        </td>
                                        <td>{{ \App\Models\Utility::getDateFormated($prequest->created_at,false) }}</td>
                                        <td>
                                            <div class="d-flex action-btn-wrapper">
                                                <a href="{{route('response.request',[$prequest->id,1])}}" class="btn btn-primary btn-sm me-2" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('Approve') }}">
                                                    <i class="ti ti-check"></i>
                                                </a>
                                                <a href="{{route('response.request',[$prequest->id,0])}}" class="btn btn-danger btn-sm" style="width: 32px;" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('Reject') }}">
                                                    <i class="ti ti-x"></i>
                                                </a>
                                            </div>
                                        </td>
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
