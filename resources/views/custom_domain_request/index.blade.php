@extends('layouts.admin')
@section('page-title')
    {{ __('Custom Domain Requests') }}
@endsection
@section('title')
<h5 class="h4 d-inline-block font-weight-bold mb-0 text-white">{{ __('Custom Domain Requests') }}</h5>
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Home') }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('Custom Domain Requests') }}</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body pb-0">
                    <div class="table-responsive">
                        <table class="table dataTable pc-dt-simple">
                            <thead>
                                <tr>
                                    <th> {{ __('Owner Name') }}</th>
                                    <th> {{ __('Store') }}</th>
                                    <th> {{ __('Custom Domain') }}</th>
                                    <th> {{ __('Status') }}</th>
                                    <th width="200px"> {{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($custom_domain_requests as $custom_domain_request)
                                    <tr>
                                        <td>
                                            <div class="font-style font-weight-bold">
                                                {{ $custom_domain_request->user->name }}</div>
                                        </td>
                                        <td>
                                            <div class="font-style font-weight-bold">
                                                {{ $custom_domain_request->store->name }}</div>
                                        </td>
                                        <td>
                                            <div class="font-style font-weight-bold">
                                                {{ $custom_domain_request->custom_domain }}</div>
                                        </td>
                                        <td>
                                            @if ($custom_domain_request->status == 0)
                                                <span
                                                    class="badge fix_badges border border-1 bg-light-danger border-danger p-2 px-3 common-lbl-radius tbl-btn-w">{{ __(App\Models\CustomDomainRequest::$statues[$custom_domain_request->status]) }}</span>
                                            @elseif($custom_domain_request->status == 1)
                                                <span
                                                    class="badge fix_badges border border-1 bg-light-primary border-primary p-2 px-3 common-lbl-radius tbl-btn-w">{{ __(App\Models\CustomDomainRequest::$statues[$custom_domain_request->status]) }}</span>
                                            @elseif($custom_domain_request->status == 2)
                                                <span
                                                    class="badge fix_badges border border-1 bg-light-warning border-warning p-2 px-3 common-lbl-radius tbl-btn-w">{{ __(App\Models\CustomDomainRequest::$statues[$custom_domain_request->status]) }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex action-btn-wrappers">
                                                @if($custom_domain_request->status == 0)
                                                    <a href="{{ route('custom_domain_request.request',[$custom_domain_request->id,1]) }}"
                                                        class="btn btn-sm btn-icon bg-primary text-white me-2" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('Approve') }}">{{-- btn-primary --}}
                                                        <i class="ti ti-check f-20"></i>
                                                    </a>
                                                    <a href="{{ route('custom_domain_request.request',[$custom_domain_request->id,0]) }}"
                                                        class="btn btn-sm btn-icon bg-secondary text-white me-2" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('Reject') }}">{{-- btn-warning --}}
                                                        <i class="ti ti-x f-20"></i>
                                                    </a>
                                                @endif

                                                {!! Form::open(['method' => 'DELETE', 'route' => ['custom_domain_request.destroy',$custom_domain_request->id], 'id' => 'delete-form-' . $custom_domain_request->id]) !!}
                                                <a class="bs-pass-para btn btn-sm btn-icon bg-danger text-white" href="#"
                                                        data-title="{{ __('Delete Domain Request') }}"
                                                        data-confirm="{{ __('Are You Sure?') }}"
                                                        data-text="{{ __('This action can not be undone. Do you want to continue?') }}"
                                                        data-confirm-yes="delete-form-{{ $custom_domain_request->id }}"
                                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                                        title="{{ __('Delete') }}">
                                                        <i class="ti ti-trash f-20"></i>
                                                    </a>{{-- btn-danger --}}
                                                {!! Form::close() !!}
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
