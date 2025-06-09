@extends('layouts.admin')
@section('page-title')
    {{ __('Users') }}
@endsection
@php
$profile=\App\Models\Utility::get_file('uploads/profile/');
@endphp
@section('title')
    <div class="d-inline-block">
        <h5 class="h4 d-inline-block text-white font-weight-bold mb-0 ">{{ __('users') }}</h5>
    </div>
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Home') }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('Users') }}</li>
@endsection
@section('action-btn')
@can('Create User')
<div class="action-btn-wrapper">
    <a class="btn btn-sm btn-icon text-light btn-primary" data-url="{{ route('users.create') }}" data-title="{{ __('Create User') }}" data-ajax-popup="true" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('Create') }}">
        <i  data-feather="plus"></i>
    </a>
</div>
@endcan
@endsection
@section('filter')
@endsection
@php
$logo=\App\Models\Utility::get_file('uploads/profile/');
@endphp
@section('content')
    <div class="row">
        @foreach ($users as $user)
            <div class="col-xl-3 col-lg-4 col-sm-6 col-md-6">
                <div class="card text-center user-card-wrp">
                    <div class="card-header border-0 pb-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="mb-0">
                                <div class="badge p-2 px-3 tbl-btn-w bg-primary">{{ ucfirst($user->type) }}</div>
                            </h6>
                        </div>
                        @if (Gate::check('Edit User') || Gate::check('Delete User'))
                            <div class="card-header-right">
                                <div class="btn-group card-option">
                                    @if($user->is_active == 1)
                                        <button type="button" class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="feather icon-more-vertical"></i>
                                        </button>
                                    @else
                                        <div class="">{{--btn--}}
                                            <i class="ti ti-lock"></i>
                                        </div>
                                    @endif
                                <div class="dropdown-menu dropdown-menu-end">
                                    @can('Edit User')
                                        <a href="#" class="dropdown-item" data-url="{{ route('users.edit', $user->id) }}" data-size="md" data-ajax-popup="true" data-title="{{ __('Update User') }}" title="{{ __('Edit User') }}">
                                            <i class="ti ti-pencil "></i>
                                            <span class="ms-2">{{ __('Edit') }}</span>
                                        </a>
                                    @endcan
                                    @can('Reset Password')
                                        <a href="#" class="dropdown-item" data-url="{{ route('users.reset', \Crypt::encrypt($user->id)) }}" data-ajax-popup="true" data-size="md" data-title="{{ __('Change Password') }}" title="{{ __('Change Password') }}">
                                            <i class="ti ti-key"></i>
                                            <span class="ms-2">{{ __('Reset Password') }}</span>
                                        </a>
                                    @endcan
                                    @can('Delete User')
                                        {!! Form::open(['method' => 'DELETE', 'route' => ['users.destroy', $user->id], 'id' => 'delete-form-' . $user->id]) !!}
                                        <a href="#" class="bs-pass-para dropdown-item"
                                            data-confirm="{{ __('Are You Sure?') }}"
                                            data-text="{{ __('This action can not be undone. Do you want to continue?') }}"
                                            data-confirm-yes="delete-form-{{ $user->id }}"
                                            title="{{ __('Delete') }}">
                                            <i class="ti ti-trash"></i><span
                                                class="ms-2">{{ __('Delete') }}</span></a>
                                        {!! Form::close() !!}
                                    @endcan
                                    {{-- @permission('user login manage') --}}
                                    @if ($user->is_enable_login == 1)
                                        <a href="{{ route('owner.users.login', \Crypt::encrypt($user->id)) }}"
                                            class="dropdown-item" title="{{ __('Login Disable') }}">
                                            <i class="ti ti-road-sign"></i>
                                            <span class="text-danger"> {{ __('Login Disable') }}</span>
                                        </a>
                                    @elseif ($user->is_enable_login == 0 && $user->password == null)
                                        <a href="#" data-url="{{ route('users.reset', \Crypt::encrypt($user->id)) }}"
                                            data-ajax-popup="true" data-size="md" class="dropdown-item login_enable"
                                            data-title="{{ __('New Password') }}" class="dropdown-item"
                                            title="{{ __('Login Enable') }}">
                                            <i class="ti ti-road-sign"></i>
                                            <span class="text-success"> {{ __('Login Enable') }}</span>
                                        </a>
                                    @else
                                        <a href="{{ route('owner.users.login', \Crypt::encrypt($user->id)) }}"
                                            class="dropdown-item" title="{{ __('Login Enable') }}">
                                            <i class="ti ti-road-sign"></i>
                                            <span class="text-success"> {{ __('Login Enable') }}</span>
                                        </a>
                                    @endif
                            {{-- @endpermission --}}
                                </div>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="card-body">
                        <div class="">
                            <a href="{{ !empty($user->avatar) ?($profile . $user->avatar) :  $logo."avatar.png" }}" target="_blank">
                                <img src="{{ !empty($user->avatar) ? ($profile . $user->avatar) :  $logo."avatar.png" }}" class="border border-2 border-primary rounded user-img" alt="user">
                            </a>
                        </div>
                        <h4 class="mt-2 text-primary">{{ $user->name }}</h4>
                        <small class="">{{ $user->email }}</small>
                    </div>
                </div>
            </div>
        @endforeach
        <div class="col-xl-3 col-lg-4 col-sm-6 col-md-6 create-user-card">
            @can('Create User')
                <a class="btn-addnew-project border-primary" data-url="{{ route('users.create') }}" data-title="{{ __('Create User') }}" data-ajax-popup="true">
                    <div class="bg-primary proj-add-icon"  data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('Create') }}">
                        <i class="ti ti-plus my-2"></i>
                    </div>
                    <h6 class="mt-2 mb-2">{{ __('New User') }}</h6>
                    <p class="text-muted text-center">{{ __('Click here to add New User') }}</p>
                </a>
            @endcan
        </div>
    </div>

@endsection

@push('script-page')
    {{-- Password  --}}
    <script>
        $(document).on('change', '#password_switch', function() {
            if ($(this).is(':checked')) {
                $('.ps_div').removeClass('d-none');
                $('#password').attr("required", true);

            } else {
                $('.ps_div').addClass('d-none');
                $('#password').val(null);
                $('#password').removeAttr("required");
            }
        });
        $(document).on('click', '.login_enable', function() {
            setTimeout(function() {
                $('.login_field').append($('<input>', {
                    type: 'hidden',
                    val: 'true',
                    name: 'login_enable'
                }));
            }, 2000);
        });
    </script>
@endpush
