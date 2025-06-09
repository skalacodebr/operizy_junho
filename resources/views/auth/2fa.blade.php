@extends('layouts.auth')
@section('page-title')
    {{ __('Login') }}
@endsection
@section('language-bar')
    @php
        $users = \Auth::user();
        $currantLang = !empty($users) ? $users->currentLanguages() : 'en';
        $languages = \App\Models\Utility::languages();
        $checktableExist = \App\Models\Utility::checktableExist();
        if ($checktableExist) {
            $LangName = \App\Models\Languages::where('code', $currantLang)->value('fullName') ?? 'english';
        } else {
            $LangName = 'english';
        }
    @endphp
    <div class="lang-dropdown-only-desk">
        <li class="dropdown dash-h-item drp-language">
            <a class="dash-head-link dropdown-toggle btn" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                <span class="drp-text"> {{ ucFirst($LangName) }}
                </span>
            </a>
            <div class="dropdown-menu dash-h-dropdown dropdown-menu-end">
                @foreach ($languages as $code => $lang)
                    <a href="javascript:void(0)" class="dropdown-item {{ $currantLang == $code ? 'active' : '' }}">   {{-- {{ route('change.language', $code) }} --}}
                        <span>{{ ucFirst($lang) }}</span>
                    </a>
                @endforeach
            </div>
        </li>
    </div>
@endsection
@section('content')
    <div class="card-body">
        <div>
            <h2 class="mb-3 f-w-600">{{ __('Login') }}</h2>
        </div>
        <div class="custom-login-form">
            <form method="POST" action="{{ route('2faVerify') }}" class="needs-validation" novalidate>
                @csrf
                <input type="hidden" name="2fa_referrer" value="{{ request()->get('2fa_referrer') ?? URL()->current() }}">

                <div class="row">
                    <div class="form-group col-12">
                        <p>{{ __('Please enter the') }} <strong>{{ __(' OTP') }}</strong>
                            {{ __(' generated on your Authenticator App') }}. <br>
                            {{ __('Ensure you submit the current one because it refreshes every 30 seconds') }}.
                        </p>
                        <label for="one_time_password" class="col-md-12 form-label">{{ __('One Time Password') }}</label>
                        <input id="one_time_password" type="password"
                            class="form-control @if ($errors->any()) is-invalid @endif"
                            name="one_time_password" required="required" autofocus>
                        @if ($errors->any())
                            <span class="error invalid-email text-danger" role="alert">
                                @foreach ($errors->all() as $error)
                                    <small>{{ $error }}</small>
                                @endforeach
                            </span>
                        @endif
                    </div>
                    <div class="form-group col-12 mb-0">
                        <div class="d-flex flex-column align-items-center">
                            <div class="d-flex justify-content-center gap-3">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>

                                <a href="{{ route('logout') }}" class="btn btn-danger text-white"
                                    onclick="event.preventDefault(); document.getElementById('frm-logout').submit();">
                                    {{ __('Logout') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <form id="frm-logout" action="{{ route('logout') }}" method="POST" class="d-none">
                {{ csrf_field() }}
            </form>
        </div>
    </div>
@endsection
