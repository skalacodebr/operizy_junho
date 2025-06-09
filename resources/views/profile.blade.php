@extends('layouts.admin')
@php
// $profile = asset(Storage::url('uploads/profile/'));
$storagesetting = App\Models\Utility::StorageSettings();
if($storagesetting['storage_setting'] == 'wasabi' || $storagesetting['storage_setting'] == 's3'){
    $profile = \App\Models\Utility::get_file('uploads/profile');
}else{
    $profile = \App\Models\Utility::get_file('uploads/profile/');
}
// $profile=\App\Models\Utility::get_file('uploads/profile/');
    $users = \Auth::user();
@endphp
@section('page-title')
    {{ __('Profile') }}
@endsection
@section('title')
    <div class="d-inline-block">
        <h5 class="h4 d-inline-block text-white font-weight-400 mb-0"> {{ __('Profile') }}</h5>
    </div>
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Home') }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('Profile') }}</li>
@endsection
@section('action-btn')
@endsection
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="row">
            <div class="col-xl-3">
                <div class="card sticky-top" style="top:30px">
                    <div class="list-group list-group-flush" id="useradd-sidenav">
                        <a href="#Personal_Info" id="Personal_Info_tab"
                            class="list-group-item list-group-item-action">{{ __('Personal Info') }} <div
                                class="float-end"><i class="ti ti-chevron-right"></i></div></a>

                        <a href="#Change_Password" id="Change_Password_tab"
                            class="list-group-item list-group-item-action">{{__('Change Password')}}<div
                                class="float-end"><i class="ti ti-chevron-right"></i></div></a>
                        @if($userDetail->type == 'super admin' || $userDetail->type == 'Owner')
                            <a href="#Two_Factor_Authentication" id="Two_Factor_Authentication_tab"
                                class="list-group-item list-group-item-action">{{ __('Two Factor Authentication') }}
                                <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-xl-9">
                    <div class="active" id="Personal_Info">
                        {{Form::model($userDetail,array('route' => array('update.account'), 'method' => 'put', 'enctype' => "multipart/form-data", 'class'=>'needs-validation', 'novalidate'))}}
                        <div class="row">
                            <div class="col-lg-12 col-sm-12 col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5>{{ __('Personal Info') }}</h5>
                                    </div>
                                    <div class="card-body pb-0">
                                        <div class=" setting-card">
                                            <div class="row">
                                                <div class="col-lg-4 col-sm-6 col-md-6">
                                                        <div class="card-body pt-0 text-center">
                                                            <div class=" setting-card">
                                                                <h4>{{__('Picture')}}</h4>
                                                                <div class="logo-content mt-2 d-flex justify-content-center">
                                                                    {{-- <img src="{{(!empty($userDetail->avatar))? $profile.'/'.$userDetail->avatar : $profile.'/avatar.png'}}"
                                                                        class=" rounded-circle-avatar" width="100px"> --}}
                                                                        <img src="{{ !empty($users->avatar) ? $profile . '/' . $users->avatar : $profile . '/avatar.png' }}" id="blah" width="100px" class="border border-2 border-primary rounded user-img"/>
                                                                </div>
                                                                <div class="choose-files mt-4">
                                                                    <label for="file-1">
                                                                        <div class=" bg-primary profile_update" style="max-width: 100% !important;"> <i
                                                                                class="ti ti-upload px-1"></i>{{ __('Choose file here') }}
                                                                        </div>
                                                                        <input type="file" class="form-control file" name="profile" id="file-1"
                                                                            data-filename="profile_update">
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                </div>
                                                <div class="col-lg-8 col-sm-6 col-md-6">
                                                        <div class="card-body pt-0">
                                                            @if(\Auth::user()->type=='client')
                                                            @php $client=$userDetail->clientDetail; @endphp
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    {{Form::label('name',__('Name'),array('class'=>'col-form-label')) }}
                                                                    {{Form::text('name',null,array('class'=>'form-control font-style','placeholder'=>__('Enter User Name')))}}
                                                                    @error('name')
                                                                    <span class="invalid-name" role="alert">
                                                                            <strong class="text-danger">{{ $message }}</strong>
                                                                        </span>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                {{Form::label('email',__('Email'),array('class'=>'col-form-label')) }}
                                                                {{Form::text('email',null,array('class'=>'form-control','placeholder'=>__('Enter User Email')))}}
                                                                @error('email')
                                                                <span class="invalid-email" role="alert">
                                                                        <strong class="text-danger">{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                            </div>

                                                            <div class="col-md-4">
                                                                {{Form::label('mobile',__('Mobile'),array('class'=>'col-form-label')) }}
                                                                {{Form::number('mobile',$client->mobile,array('class'=>'form-control'))}}
                                                                @error('mobile')
                                                                <span class="invalid-mobile" role="alert">
                                                                            <strong class="text-danger">{{ $message }}</strong>
                                                                        </span>
                                                                @enderror
                                                            </div>
                                                            <div class="col-md-4">
                                                                {{Form::label('address_1',__('Address 1'),array('class'=>'col-form-label')) }}
                                                                {{Form::textarea('address_1', $client->address_1, ['class'=>'form-control','rows'=>'4'])}}
                                                                @error('address_1')
                                                                <span class="invalid-address_1" role="alert">
                                                                            <strong class="text-danger">{{ $message }}</strong>
                                                                        </span>
                                                                @enderror
                                                            </div>
                                                            <div class="col-md-4">
                                                                {{Form::label('address_2',__('Address 2'),array('class'=>'col-form-label')) }}
                                                                {{Form::textarea('address_2', $client->address_2, ['class'=>'form-control','rows'=>'4'])}}
                                                                @error('address_2')
                                                                <span class="invalid-address_2" role="alert">
                                                                            <strong class="text-danger">{{ $message }}</strong>
                                                                        </span>
                                                                @enderror
                                                            </div>

                                                            <div class="col-md-4">
                                                                {{Form::label('city',__('City'),array('class'=>'col-form-label')) }}
                                                                {{Form::text('city',$client->city,array('class'=>'form-control'))}}
                                                                @error('city')
                                                                <span class="invalid-city" role="alert">
                                                                            <strong class="text-danger">{{ $message }}</strong>
                                                                        </span>
                                                                @enderror
                                                            </div>
                                                            <div class="col-md-4">
                                                                {{Form::label('state',__('State'),array('class'=>'col-form-label')) }}
                                                                {{Form::text('state',$client->state,array('class'=>'form-control'))}}
                                                                @error('state')
                                                                <span class="invalid-state" role="alert">
                                                                            <strong class="text-danger">{{ $message }}</strong>
                                                                        </span>
                                                                @enderror
                                                            </div>
                                                            <div class="col-md-4">
                                                                {{Form::label('country',__('Country'),array('class'=>'col-form-label')) }}
                                                                {{Form::text('country',$client->country,array('class'=>'form-control'))}}
                                                                @error('country')
                                                                <span class="invalid-country" role="alert">
                                                                            <strong class="text-danger">{{ $message }}</strong>
                                                                        </span>
                                                                @enderror
                                                            </div>
                                                            <div class="col-md-4">
                                                                {{Form::label('zip_code',__('Zip Code'),array('class'=>'col-form-label')) }}
                                                                {{Form::text('zip_code',$client->zip_code,array('class'=>'form-control'))}}
                                                                @error('zip_code')
                                                                <span class="invalid-zip_code" role="alert">
                                                                            <strong class="text-danger">{{ $message }}</strong>
                                                                        </span>
                                                                @enderror
                                                            </div>
                                                        @else
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    {{Form::label('name',__('Name'),array('class'=>'col-form-label')) }}<x-required></x-required>
                                                                    {{Form::text('name',null,array('class'=>'form-control font-style','placeholder'=>__('Enter Name'),'required'=>'required'))}}
                                                                    @error('name')
                                                                    <span class="invalid-name" role="alert">
                                                                            <strong class="text-danger">{{ $message }}</strong>
                                                                        </span>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                {{Form::label('email',__('Email'),array('class'=>'col-form-label')) }}<x-required></x-required>
                                                                {{Form::text('email',null,array('class'=>'form-control','placeholder'=>__('Enter User Email'),'required'=>'required'))}}
                                                                @error('email')
                                                                <span class="invalid-email" role="alert">
                                                                        <strong class="text-danger">{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                            </div>
                                                        @endif
                                                        </div>
                                                    </div>
                                                </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <div class="col-sm-12 ">
                                            <div class="text-end">
                                                {{ Form::submit(__('Save Changes'), ['class' => 'btn btn-xs btn-primary']) }}
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        {{Form::close()}}
                    </div>
                    <div class="" id="Change_Password">
                        {{Form::model($userDetail,array('route' => array('update.password',$userDetail->id), 'method' => 'put', 'class'=>'needs-validation', 'novalidate'))}}
                        <div class="row">
                            <div class="col-lg-12 col-sm-12 col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5>{{ __('Change Password') }}</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    {{Form::label('current_password',__('Current Password'),array('class'=>'col-form-label')) }}<x-required></x-required>
                                                    {{Form::password('current_password',array('class'=>'form-control','placeholder'=>__('Enter Current Password'),'required'=>'required'))}}
                                                    @error('current_password')
                                                    <span class="invalid-current_password" role="alert">
                                                         <strong class="text-danger">{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    {{Form::label('new_password',__('New Password'),array('class'=>'col-form-label')) }}<x-required></x-required>
                                                    {{Form::password('new_password',array('class'=>'form-control','placeholder'=>__('Enter New Password'),'required'=>'required'))}}
                                                    @error('new_password')
                                                    <span class="invalid-new_password" role="alert">
                                                            <strong class="text-danger">{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                {{Form::label('confirm_password',__('Re-type New Password'),array('class'=>'col-form-label')) }}<x-required></x-required>
                                                {{Form::password('confirm_password',array('class'=>'form-control','placeholder'=>__('Enter Re-type New Password'),'required'=>'required'))}}
                                                @error('confirm_password')
                                                <span class="invalid-confirm_password" role="alert">
                                                        <strong class="text-danger">{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <div class="col-sm-12 ">
                                            <div class="text-end">
                                                {{ Form::submit(__('Save Changes'), ['class' => 'btn btn-xs btn-primary']) }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                    @if($userDetail->type == 'super admin' || $userDetail->type == 'Owner')
                        <div class="" id="Two_Factor_Authentication">
                            <div class="card">
                                <div class="card-header">
                                    <h5>{{ __('Two Factor Authentication') }}</h5>
                                </div>
                                <div class="card-body">
                                    <p>{{ __('Two factor authentication (2FA) strengthens access security by requiring two methods (also referred to as factors) to verify your identity. Two factor authentication protects against phishing, social engineering and password brute force attacks and secures your logins from attackers exploiting weak or stolen credentials.') }}
                                    </p>
                                    @if ($userDetail->google2fa_secret == null)
                                        <div class=" ">
                                            <form class="form-horizontal" method="POST"
                                                action="{{ route('generate2faSecret') }}">
                                                @csrf <div class="col-lg-12 text-center">
                                                    <button type="submit" class="btn btn-primary">
                                                        {{ __('Generate Secret Key to Enable 2FA') }}
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    @elseif ($userDetail->google2fa_secret != null && $userDetail->google2fa_enable == 0)
                                        @php
                                            $svg_base64 = base64_encode($userDetail->google2fa_url);
                                            // Create the data URI
                                            $data_uri = 'data:image/svg+xml;base64,' . $svg_base64;
    
                                        @endphp
    
                                        1. {{ __('Install "Google Authentication App" on your') }} <a
                                            href="https://apps.apple.com/us/app/google-authenticator/id388497605"
                                            target="_black"> {{ __('IOS') }}</a> {{ __('or') }} <a
                                            href="https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2"
                                            target="_black">{{ __('Android phone.') }}</a><br />
                                        2. {{ __('Open the Google Authentication App and scan the below QR code.') }}<br />
                                        <div class="text-start">
                                            <img src="{{ $data_uri }}" alt="QR Code" />
                                        </div>
                                        {{ __('Alternatively, you can use the code:') }}
                                        <code>{{ $userDetail->google2fa_secret }}</code>. <br>
                                        3.
                                        {{ __('Enter the 6-digit Google Authentication code from the app') }}<br /><br />
                                        <form class="form-horizontal" method="POST"
                                            action="{{ route('enable2fa') }}">
                                            @csrf
                                            <div class="form-group">
                                                <label for="secret"
                                                    class="col-form-label">{{ __('Authenticator Code') }}</label>
                                                <input id="secret" type="password" name="secret" class="form-control"
                                                    placeholder="{{ __('Enter the code from your authenticator app') }}"
                                                    required>
                                                <div class="text-center">
                                                    <button type="submit" class="btn btn-primary mt-3">
                                                        {{ __('Enable 2FA') }}
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    @else
                                        <div class="alert alert-success">
                                            {{ __('2FA is currently') }} <strong>{{ __('Enabled') }}</strong>
                                            {{ __('on your account.') }}
                                        </div>
                                        <p>{{ __('If you are looking to disable Two Factor Authentication. Please confirm your password and Click Disable 2FA Button.') }}
                                        </p>
                                        <form class="form-horizontal" method="POST" action="{{ route('disable2fa') }}">
                                            @csrf
                                            <div class="form-group">
                                                <label for="password"
                                                    class="col-form-label">{{ __('Current Password') }}</label>
                                                <input id="password" type="password" name="password" class="form-control"
                                                    placeholder="{{ __('Enter Your Current Password') }}" required>
                                            </div>
                                            <div class=" text-center">
                                                <button type="submit" class="btn btn-primary mt-3">
                                                    {{ __('Disable 2FA') }}
                                                </button>
                                            </div>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif
            </div>
        </div>
        <!-- [ sample-page ] end -->
    </div>
</div>

@endsection
@push('script-page')
    <script>
        $(document).on('click', '.list-group-item', function() {
            $('.list-group-item').removeClass('active');
            $('.list-group-item').removeClass('text-primary');
            setTimeout(() => {
                $(this).addClass('active').removeClass('text-primary');
            }, 10);
        });

        var type = window.location.hash.substr(1);
        $('.list-group-item').removeClass('active');
        $('.list-group-item').removeClass('text-primary');
        if (type != '') {
            $('a[href="#' + type + '"]').addClass('active').removeClass('text-primary');
        } else {
            $('.list-group-item:eq(0)').addClass('active').removeClass('text-primary');
        }




        var scrollSpy = new bootstrap.ScrollSpy(document.body, {
            target: '#useradd-sidenav',
            offset: 300
        })
    </script>
@endpush
