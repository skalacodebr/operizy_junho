@php
    $data = DB::table('settings');
    $data = $data
        ->where('created_by', '>', 1)
        ->where('store_id', $store->id)
        ->where('name', 'SITE_RTL')
        ->first();
    if(!isset($data)){
        $data = (object)[
            "name"=> "SITE_RTL",
            "value"=> "off"
            ];
    }
    $clang = session()->get('lang');
    if($clang == 'ar' || $clang == 'he'){
        $data->value = 'on';
    }
@endphp
<!DOCTYPE html>
<html lang="en" dir="{{ empty($data) ? '' : ($data->value == 'on' ? 'rtl' : '') }}">
@php
    $setting = DB::table('settings')
        ->where('name', 'company_favicon')
        ->where('store_id', $store->id)
        ->first();
    $settings = \App\Models\Utility::settings();
    $getStoreThemeSetting = \App\Models\Utility::getStoreThemeSetting($store->id, $store->theme_dir);
    $getStoreThemeSetting1 = [];
    if (!empty($getStoreThemeSetting['dashboard'])) {
        $getStoreThemeSetting = json_decode($getStoreThemeSetting['dashboard'], true);
        $getStoreThemeSetting1 = \App\Models\Utility::getStoreThemeSetting($store->id, $store->theme_dir);
    }
    if (empty($getStoreThemeSetting)) {
        $path = storage_path() . '/uploads/' . $store->theme_dir . '/' . $store->theme_dir . '.json';
        $getStoreThemeSetting = json_decode(file_get_contents($path), true);
    }
    $imgpath = \App\Models\Utility::get_file('uploads/');
    $s_logo = \App\Models\Utility::get_file('uploads/store_logo/');
    $brand_logo = \App\Models\Utility::get_file('uploads/theme1/brand_logo/');
    $metaImage = \App\Models\Utility::get_file('uploads/metaImage');
    $themeClass = $store->store_theme;
    $theme_name = $store->theme_dir;
    $storethemesetting1 = Utility::demoStoreThemeSetting($store->id, $store->theme_dir);
    if (!empty(session()->get('lang'))) {
        $currantLang = session()->get('lang');
    } else {
        $currantLang = $store->lang;
    }
    $languages = \App\Models\Utility::languages();
    $langName = \App\Models\Languages::where('code', $currantLang)->first();
@endphp
<head>
    
    @include('storefront.partials.head')

</head>

<body class="{{ !empty($themeClass) ? $themeClass : 'theme1-v1' }}">
    <div class="overlay"></div>
    
    <header class="site-header">
        @if ($storethemesetting1['enable_top_bar'] == 'on')
            <div class="announcebar">
                <div class="container">
                    <div class="announcebar-row flex align-center justify-between">
                        <div class="announcebar-left announcebar-col flex align-center">
                            <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g clip-path="url(#clip0_23_3164)">
                                    <path
                                        d="M7.00013 14C7.83936 14 8.56206 13.4931 8.87916 12.7695H5.12109C5.4382 13.4931 6.16092 14 7.00013 14Z"
                                        fill="white" />
                                    <path
                                        d="M11.2383 6.77748V5.87891C11.2383 3.96971 9.96926 2.35154 8.2305 1.82301V1.23047C8.2305 0.551988 7.67851 0 7.00003 0C6.32155 0 5.76956 0.551988 5.76956 1.23047V1.82301C4.03077 2.35154 2.76175 3.96968 2.76175 5.87891V6.77748C2.76175 8.45452 2.12251 10.0447 0.961794 11.2552C0.848044 11.3738 0.816079 11.5488 0.880555 11.7C0.945032 11.8511 1.09351 11.9492 1.25784 11.9492H12.7422C12.9066 11.9492 13.055 11.8511 13.1195 11.7C13.184 11.5488 13.152 11.3738 13.0383 11.2552C11.8776 10.0447 11.2383 8.4545 11.2383 6.77748ZM7.41019 1.66053C7.27519 1.64752 7.13839 1.64062 7.00003 1.64062C6.86167 1.64062 6.72487 1.64752 6.58988 1.66053V1.23047C6.58988 1.00431 6.77387 0.820312 7.00003 0.820312C7.22619 0.820312 7.41019 1.00431 7.41019 1.23047V1.66053Z"
                                        fill="white" />
                                    <path
                                        d="M12.3322 5.87872C12.3322 6.10523 12.5159 6.28887 12.7424 6.28887C12.9689 6.28887 13.1525 6.10523 13.1525 5.87872C13.1525 4.23536 12.5126 2.69035 11.3506 1.52833C11.1904 1.36818 10.9307 1.36815 10.7705 1.52833C10.6103 1.68851 10.6103 1.94819 10.7705 2.10837C11.7776 3.11547 12.3322 4.45446 12.3322 5.87872Z"
                                        fill="white" />
                                    <path
                                        d="M1.25781 6.28886C1.48433 6.28886 1.66797 6.10522 1.66797 5.8787C1.66797 4.45447 2.22261 3.11548 3.22968 2.10838C3.38986 1.9482 3.38986 1.68852 3.22968 1.52834C3.06953 1.36816 2.80982 1.36816 2.64964 1.52834C1.48761 2.69037 0.847656 4.23534 0.847656 5.8787C0.847656 6.10522 1.0313 6.28886 1.25781 6.28886Z"
                                        fill="white" />
                                </g>
                            </svg>
                            <p>{{ !empty($storethemesetting1['top_bar_title']) ? $storethemesetting1['top_bar_title'] : '' }}</p>
                        </div>
                        <div class="announcebar-center flex align-center">
                            <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g clip-path="url(#clip0_23_3173)">
                                    <path
                                        d="M10.6436 9.26092C10.1862 8.80936 9.61519 8.80936 9.16072 9.26092C8.81404 9.60468 8.46736 9.94845 8.12651 10.298C8.03329 10.3942 7.95463 10.4146 7.84101 10.3505C7.61669 10.2281 7.3778 10.1291 7.16222 9.99506C6.15714 9.36288 5.31521 8.55008 4.56941 7.63532C4.19942 7.18085 3.87023 6.69433 3.64008 6.14664C3.59347 6.03593 3.6022 5.9631 3.69252 5.87279C4.0392 5.53776 4.37713 5.194 4.71799 4.85023C5.19285 4.37246 5.19285 3.81311 4.71507 3.33242C4.44414 3.05857 4.17321 2.79055 3.90227 2.51671C3.6226 2.23703 3.34584 1.95444 3.06325 1.67768C2.60587 1.23195 2.03487 1.23195 1.5804 1.6806C1.23081 2.02436 0.895779 2.37687 0.540361 2.71481C0.211161 3.02653 0.045105 3.40817 0.0101458 3.8539C-0.0452063 4.5793 0.132503 5.26392 0.383044 5.93106C0.895779 7.31194 1.67654 8.53843 2.62335 9.66295C3.90227 11.1837 5.42882 12.3869 7.21466 13.255C8.01872 13.6454 8.85191 13.9455 9.75794 13.995C10.3814 14.0299 10.9232 13.8726 11.3573 13.3861C11.6545 13.054 11.9895 12.751 12.3041 12.4335C12.7703 11.9615 12.7732 11.3905 12.31 10.9244C11.7564 10.368 11.2 9.81444 10.6436 9.26092Z"
                                        fill="white" />
                                    <path
                                        d="M10.0867 6.93954L11.1617 6.75601C10.9927 5.76841 10.5266 4.87403 9.81867 4.1632C9.06996 3.41449 8.12315 2.94254 7.0802 2.79688L6.92871 3.8777C7.73569 3.99132 8.46983 4.35547 9.04957 4.93521C9.59726 5.48291 9.9556 6.17627 10.0867 6.93954Z"
                                        fill="white" />
                                    <path
                                        d="M11.7685 2.26652C10.5274 1.02547 8.95715 0.241801 7.22376 0L7.07227 1.08082C8.56969 1.29058 9.92727 1.96937 10.9994 3.03854C12.0161 4.05527 12.6832 5.34002 12.925 6.75296L14 6.56942C13.7174 4.93216 12.9454 3.4464 11.7685 2.26652Z"
                                        fill="white" />
                                </g>
                            </svg>
                            <a href="tel:{{ !empty($storethemesetting1['top_bar_number']) ? $storethemesetting1['top_bar_number'] : '2123081220' }}">
                                {{ !empty($storethemesetting1['top_bar_number']) ? $storethemesetting1['top_bar_number'] : '(212) 308-1220' }}
                                {{ __('Request a call') }}</a>
                        </div>
                        <ul class="announcebar-right announcebar-col flex align-center justify-end">
                            @if (!empty($storethemesetting1['top_bar_whatsapp']))
                                <li>
                                    <a href="{{ $storethemesetting1['top_bar_whatsapp'] }}" target="_blank" class="flex align-center justify-center">
                                        <svg width="10" height="10" viewBox="0 0 10 10" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <g clip-path="url(#clip0_23_3134)">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M8.22942 2.12623C7.42393 1.31979 6.35268 0.875473 5.21144 0.875C2.8598 0.875 0.945913 2.78884 0.944967 5.14111C0.944651 5.89305 1.14109 6.62708 1.51446 7.27408L0.90918 9.48489L3.1709 8.89159C3.7941 9.23154 4.4957 9.41068 5.20971 9.4109H5.2115C7.56287 9.4109 9.47697 7.4969 9.47787 5.14452C9.47834 4.00449 9.03497 2.93262 8.22942 2.12623ZM5.21144 8.69037H5.20997C4.57369 8.69011 3.94965 8.51911 3.40512 8.19608L3.27569 8.1192L1.93355 8.47129L2.29179 7.16273L2.20744 7.02857C1.85246 6.46396 1.66501 5.81139 1.66533 5.14137C1.66607 3.18623 3.25688 1.59557 5.21286 1.59557C6.16003 1.59589 7.0504 1.96521 7.71989 2.6355C8.38939 3.30578 8.75787 4.19672 8.75756 5.14426C8.75671 7.09956 7.16601 8.69037 5.21144 8.69037ZM7.15655 6.03452C7.04998 5.98113 6.52584 5.72332 6.42809 5.68769C6.33045 5.65211 6.2593 5.6344 6.18831 5.74108C6.1172 5.84776 5.91294 6.08791 5.85072 6.15901C5.7885 6.23017 5.72639 6.2391 5.61976 6.18571C5.51314 6.13237 5.16966 6.01975 4.76245 5.65658C4.44557 5.37391 4.23164 5.02481 4.16942 4.91814C4.1073 4.81135 4.16889 4.75922 4.21619 4.70058C4.33159 4.55727 4.44715 4.40703 4.48267 4.33593C4.51825 4.26477 4.50043 4.2025 4.47374 4.14916C4.44715 4.09582 4.23395 3.57111 4.14514 3.35759C4.05854 3.14981 3.97072 3.17787 3.90525 3.17461C3.84313 3.17151 3.77203 3.17088 3.70093 3.17088C3.62988 3.17088 3.51437 3.19753 3.41663 3.30431C3.31894 3.41104 3.04357 3.6689 3.04357 4.19362C3.04357 4.71834 3.42556 5.22524 3.47885 5.2964C3.53214 5.36755 4.23059 6.44431 5.29994 6.90602C5.55428 7.01595 5.75282 7.08149 5.90769 7.13062C6.16308 7.21176 6.39541 7.2003 6.57912 7.17287C6.78397 7.14223 7.20978 6.91495 7.2987 6.66597C7.38751 6.41693 7.38751 6.20352 7.36081 6.15901C7.33422 6.11455 7.26312 6.08791 7.15655 6.03452Z"
                                                fill="#202126" />
                                        </g>
                                    </svg>
                                    </a>
                                </li>
                            @endif
                            @if (!empty($storethemesetting1['top_bar_twitter']))
                                <li>
                                    <a href="{{ $storethemesetting1['top_bar_twitter'] }}" target="_blank" class="flex align-center justify-center">
                                        <svg width="9" height="9" viewBox="0 0 9 9" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <g clip-path="url(#clip0_23_3139)">
                                            <path
                                                d="M5.65624 3.55823L8.62992 0.101562H7.92525L5.3432 3.10293L3.28093 0.101562H0.902344L4.0209 4.64017L0.902344 8.26501H1.60705L4.33376 5.09546L6.51167 8.26501H8.89026L5.65606 3.55823H5.65624ZM4.69104 4.68015L4.37507 4.22821L1.86097 0.632053H2.94336L4.97227 3.53427L5.28824 3.98621L7.92558 7.75864H6.84319L4.69104 4.68033V4.68015Z"
                                                fill="#202126" />
                                        </g>
                                    </svg>
                                    </a>
                                </li>
                            @endif
                            @if (!empty($storethemesetting1['top_bar_instagram']))
                                <li>
                                    <a href="{{ $storethemesetting1['top_bar_instagram'] }}" target="_blank" class="flex align-center justify-center">
                                        <svg width="10" height="10" viewBox="0 0 10 10" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <g clip-path="url(#clip0_23_3144)">
                                            <path
                                                d="M7.02055 0.591797H2.42873C1.16609 0.591797 0.132812 1.62507 0.132812 2.88771V7.47976C0.132812 8.74207 1.16609 9.77567 2.42873 9.77567H7.02055C8.28319 9.77567 9.31647 8.74207 9.31647 7.47976V2.88771C9.31647 1.62507 8.28319 0.591797 7.02055 0.591797ZM8.55112 7.47976C8.55112 8.32351 7.86477 9.01033 7.02055 9.01033H2.42873C1.58487 9.01033 0.898154 8.32351 0.898154 7.47976V2.88771C0.898154 2.04374 1.58487 1.35714 2.42873 1.35714H7.02055C7.86477 1.35714 8.55112 2.04374 8.55112 2.88771V7.47976Z"
                                                fill="#202126" />
                                            <path
                                                d="M7.21265 3.271C7.52965 3.271 7.78663 3.01402 7.78663 2.69703C7.78663 2.38003 7.52965 2.12305 7.21265 2.12305C6.89565 2.12305 6.63867 2.38003 6.63867 2.69703C6.63867 3.01402 6.89565 3.271 7.21265 3.271Z"
                                                fill="#202126" />
                                            <path
                                                d="M4.72462 2.88867C3.45636 2.88867 2.42871 3.91643 2.42871 5.18459C2.42871 6.45227 3.45636 7.48072 4.72462 7.48072C5.99253 7.48072 7.02054 6.45227 7.02054 5.18459C7.02054 3.91643 5.99253 2.88867 4.72462 2.88867ZM4.72462 6.71538C3.87937 6.71538 3.19405 6.03006 3.19405 5.18459C3.19405 4.33911 3.87937 3.65401 4.72462 3.65401C5.56987 3.65401 6.2552 4.33911 6.2552 5.18459C6.2552 6.03006 5.56987 6.71538 4.72462 6.71538Z"
                                                fill="#202126" />
                                        </g>
                                    </svg>
                                    </a>
                                </li>
                            @endif
                            @if (!empty($storethemesetting1['top_bar_messenger']))
                                <li>
                                    <a href="{{ $storethemesetting1['top_bar_messenger'] }}" target="_blank" class="flex align-center justify-center">
                                        <svg width="11" height="10" viewBox="0 0 11 10" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <g clip-path="url(#clip0_23_3157)">
                                            <path
                                                d="M9.28002 1.95508H1.7105C1.26452 1.95508 0.90332 2.31852 0.90332 2.76225V7.60532C0.90332 8.05168 1.26718 8.41249 1.7105 8.41249H9.28002C9.72226 8.41249 10.0872 8.05321 10.0872 7.60532V2.76225C10.0872 2.31931 9.72743 1.95508 9.28002 1.95508ZM9.16698 2.4932C9.00207 2.65723 6.16401 5.48034 6.06602 5.57781C5.91356 5.73028 5.71087 5.81423 5.49526 5.81423C5.27965 5.81423 5.07696 5.73026 4.92399 5.57731C4.85809 5.51175 2.05136 2.71982 1.82354 2.4932H9.16698ZM1.44144 7.49579V2.87212L3.76679 5.18522L1.44144 7.49579ZM1.82388 7.87437L4.14831 5.56472L4.54399 5.95832C4.79809 6.21242 5.13592 6.35234 5.49526 6.35234C5.8546 6.35234 6.19243 6.21242 6.44602 5.95882L6.8422 5.56472L9.16664 7.87437H1.82388ZM9.54908 7.49579L7.22373 5.18522L9.54908 2.87212V7.49579Z"
                                                fill="#202126" />
                                        </g>
                                    </svg>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        @endif
        <div class="main-navigationbar sticky_header" id="header-sticky">
            <div class="container">
                <div class="navigationbar-row flex align-center justify-between">
                    <div class="logo-col">
                        <h1>
                            <a href="{{ route('store.slug', $store->slug) }}">
                                <img src="{{ (!empty($store->logo) ? $s_logo . $store->logo : ($brand_logo . 'brand_logo.png')) . '?timestamp='. time() }}" alt="logo" id="navbar-logo">
                            </a>
                        </h1>
                    </div>
                    <div class="menu-item-left menu-items-col desk-only">
                        <ul class="main-nav flex align-center">
                            <li class="menu-link">
                                <a href="{{ route('store.slug', $store->slug) }}">{{ ucfirst($store->name) }}</a>
                            </li>
                            @if (!empty($page_slug_urls))
                                @foreach ($page_slug_urls as $k => $page_slug_url)
                                    @if ($page_slug_url->enable_page_header == 'on')
                                        <li class="menu-link">
                                            <a
                                                href="{{ route('pageoption.slug', $page_slug_url->slug) }}">{{ ucfirst($page_slug_url->name) }}</a>
                                        </li>
                                    @endif
                                @endforeach
                            @endif
                            
                            @if ($store['blog_enable'] == 'on' && !empty($blog))
                                <li class="menu-link">
                                    <a href="{{ route('store.blog', $store->slug) }}">{{ __('Blog') }}</a>
                                </li>
                            @endif
                        </ul>
                    </div>
                    <div class="menu-item-right flex align-center justify-end">
                        <div class="languages">
                            <div class="nice-select">
                                <span class="current">{{ ucFirst($langName->fullName) }}</span>
                                <div class="list-wrp">
                                    <ul class="list">
                                        @foreach ($languages as $code => $language)
                                            <li class="option @if ($code == $currantLang) selected focus @endif"><a href="{{ route('change.languagestore', [$store->slug, $code]) }}"
                                                    class="@if ($code == $currantLang) selected focus @endif">{{  ucFirst($language) }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <ul class="menu-item-wrp flex align-center">
                            <li class="search-header search-icon">
                                <a href="javascript:;" tabindex="0">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M11.5 21C16.7467 21 21 16.7467 21 11.5C21 6.2533 16.7467 2 11.5 2C6.2533 2 2 6.2533 2 11.5C2 16.7467 6.2533 21 11.5 21Z"
                                            stroke="#202126" stroke-width="1.5" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                        <path d="M22 22L20 20" stroke="#202126" stroke-width="1.5" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                    </svg>
                                </a>
                            </li>
                            @if (Utility::CustomerAuthCheck($store->slug) == true)
                                <li class="profile-header set has-children">
                                    <div class="nice-select">
                                        <a class="current">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M12 12C14.7614 12 17 9.76142 17 7C17 4.23858 14.7614 2 12 2C9.23858 2 7 4.23858 7 7C7 9.76142 9.23858 12 12 12Z"
                                                    stroke="#202126" stroke-width="1.5" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                                <path
                                                    d="M20.5901 22C20.5901 18.13 16.7402 15 12.0002 15C7.26015 15 3.41016 18.13 3.41016 22"
                                                    stroke="#202126" stroke-width="1.5" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                            </svg>
                                        </a>
                                        <div class="list-wrp">
                                            <ul class="list">
                                                <li data-name="profile" class="option">
                                                    <a
                                                        href="{{ route('store.slug', $store->slug) }}">{{ __('My Dashboard') }}</a>
                                                </li>
                                                <li data-name="activity" class="option">
                                                    <a href="javascript:;" data-size="lg" class="edit-profile-btn"
                                                        data-url="{{ route('customer.profile', [$store->slug, \Illuminate\Support\Facades\Crypt::encrypt(Auth::guard('customers')->user()->id)]) }}"
                                                        data-profile-popup="true" data-title="{{ __('Edit Profile') }}"
                                                        data-toggle="modal">
                                                        {{ __('My Profile') }}
                                                    </a>
                                                </li>
                                                <li data-name="activity" class="option">
                                                    <a
                                                        href="{{ route('customer.home', $store->slug) }}">{{ __('My Orders') }}</a>
                                                </li>
                                                <li class="option">
                                                    @if (Utility::CustomerAuthCheck($store->slug) == false)
                                                        <a href="{{ route('customer.login', $store->slug) }}">
                                                            {{ __('Sign in') }}
                                                        </a>
                                                    @else
                                                        <a href="#"
                                                            onclick="event.preventDefault(); document.getElementById('customer-frm-logout').submit();"
                                                            class="nav-link">
                                                            {{ __('Logout') }}
                                                        </a>
                                                        <form id="customer-frm-logout"
                                                            action="{{ route('customer.logout', $store->slug) }}"
                                                            method="POST" class="d-none">
                                                            {{ csrf_field() }}
                                                        </form>
                                                    @endif
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </li>
                            @else
                                <li class="profile-header set has-children">
                                    <a href="{{ route('customer.login', $store->slug) }}" class="acnav-label">
                                        <span class="login-text" style="display: block;">{{ __('Log in') }}</span>
                                    </a>
                                </li>
                            @endif
                            @if (Utility::CustomerAuthCheck($store->slug) == true)
                                <li class="wishlist-header">
                                    <a href="{{ route('store.wishlist', $store->slug) }}">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M12.62 20.8096C12.28 20.9296 11.72 20.9296 11.38 20.8096C8.48 19.8196 2 15.6896 2 8.68961C2 5.59961 4.49 3.09961 7.56 3.09961C9.38 3.09961 10.99 3.97961 12 5.33961C13.01 3.97961 14.63 3.09961 16.44 3.09961C19.51 3.09961 22 5.59961 22 8.68961C22 15.6896 15.52 19.8196 12.62 20.8096Z"
                                                stroke="#202126" stroke-width="1.5" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                        </svg>
                                        <span class="count wishlist_count">{{ !empty($wishlist) ? count($wishlist) : '0' }}</span>
                                    </a>
                                </li>
                            @endif
                            <li class="cart-header">
                                <a href="{{ route('store.cart', $store->slug) }}" class="main-cart flex align-center">
                                    <div class="cart-icon">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M7.5 7.66952V6.69952C7.5 4.44952 9.31 2.23952 11.56 2.02952C14.24 1.76952 16.5 3.87952 16.5 6.50952V7.88952"
                                                stroke="#202126" stroke-width="1.5" stroke-miterlimit="10"
                                                stroke-linecap="round" stroke-linejoin="round" />
                                            <path
                                                d="M9.0008 22H15.0008C19.0208 22 19.7408 20.39 19.9508 18.43L20.7008 12.43C20.9708 9.99 20.2708 8 16.0008 8H8.0008C3.7308 8 3.0308 9.99 3.3008 12.43L4.0508 18.43C4.2608 20.39 4.9808 22 9.0008 22Z"
                                                stroke="#202126" stroke-width="1.5" stroke-miterlimit="10"
                                                stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M15.4945 12H15.5035" stroke="#202126" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M8.49451 12H8.50349" stroke="#202126" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <span class="count shoping_counts"
                                            id="shoping_counts">{{ !empty($total_item) ? $total_item : '0' }}</span>
                                    </div>
                                </a>
                            </li>
                            <li class="mobile-menu mobile-only">
                                <button class="mobile-menu-button">
                                    <div class="one"></div>
                                    <div class="two"></div>
                                    <div class="three"></div>
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </header>
    
    @yield('content')

    <footer class="site-footer">
        @if (isset($getStoreThemeSetting[6]) && $getStoreThemeSetting[6]['section_enable'] == 'on')
            <div class="container">
                <div class="footer-row flex">
                    @if (!empty($getStoreThemeSetting[6]))
                        @if ($getStoreThemeSetting[6]['section_enable'] == 'on')
                            <div class="footer-col social-col">
                                <div class="footer-widget set has-children1">
                                    <div class="footer-logo">
                                        <a href="{{ route('store.slug', $store->slug) }}" tabindex="0">
                                            <img src="{{ $imgpath . $getStoreThemeSetting[6]['inner-list'][0]['field_default_text'] }}" alt="logo" loading="lazy">
                                        </a>
                                    </div>
                                    <p>{{ $getStoreThemeSetting[6]['inner-list'][1]['field_default_text'] }}</p>
                                    @if (Utility::CustomerAuthCheck($store->slug) == true)
                                        <a href="javascript:;" data-size="lg"
                                            data-url="{{ route('customer.profile', [$store->slug, \Illuminate\Support\Facades\Crypt::encrypt(Auth::guard('customers')->user()->id)]) }}"
                                            data-profile-popup="true" data-title="{{ __('Edit Profile') }}"
                                            data-toggle="modal">
                                            <button class="btn edit-profile-btn profile-popup-btn">
                                                {{ __('Edit Profile') }}
                                            </button>
                                        </a>
                                    @endif
                                    <ul class="footer-social-icon flex align-center">
                                        @if (isset($getStoreThemeSetting[16]['homepage-footer-2-social-icon']) ||
                                                isset($getStoreThemeSetting[16]['homepage-footer-2-social-link']))
                                            @if (isset($getStoreThemeSetting[16]['inner-list'][1]['field_default_text']) &&
                                                    isset($getStoreThemeSetting[16]['inner-list'][0]['field_default_text']))
                                                @foreach ($getStoreThemeSetting[16]['homepage-footer-2-social-icon'] as $icon_key => $storethemesettingicon)
                                                    @foreach ($getStoreThemeSetting[16]['homepage-footer-2-social-link'] as $link_key => $storethemesettinglink)
                                                        @if ($icon_key == $link_key)
                                                            <li>
                                                                <a href="{{ $storethemesettinglink }}" target="_blank" class="flex align-center justify-center">
                                                                    {!! $storethemesettingicon !!}
                                                                </a>
                                                            </li>
                                                        @endif
                                                    @endforeach
                                                @endforeach
                                            @endif
                                        @else
                                            @for ($i = 0; $i < $getStoreThemeSetting[16]['loop_number']; $i++)
                                                @if (isset($getStoreThemeSetting[16]['inner-list'][1]['field_default_text']) &&
                                                        isset($getStoreThemeSetting[16]['inner-list'][0]['field_default_text']))
                                                    <li>
                                                        <a href="{{ $getStoreThemeSetting[16]['inner-list'][1]['field_default_text'] }}" target="_blank" class="flex align-center justify-center">
                                                            {!! $getStoreThemeSetting[16]['inner-list'][0]['field_default_text'] !!}
                                                        </a>
                                                    </li>
                                                @endif
                                            @endfor
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        @endif
                    @endif
                    @if ($getStoreThemeSetting[7]['inner-list'][0]['field_default_text'] == 'on')
                        @if (!empty($getStoreThemeSetting[7]))
                            @if (
                                (isset($getStoreThemeSetting[7]['section_enable']) && $getStoreThemeSetting[7]['section_enable'] == 'on') ||
                                    $getStoreThemeSetting[7]['inner-list'][1]['field_default_text']
                            )
                                <div class="footer-col footer-link">
                                    <div class="footer-widget set has-children1">
                                        <h2 class="footer-acnav">
                                            <span>{{ __($getStoreThemeSetting[7]['inner-list'][1]['field_default_text']) }}</span>
                                            <svg xmlns="http://www.w3.org/2000/svg" version="1.2" viewBox="0 0 10 5" width="10"
                                                height="5">
                                                <path class="a"
                                                    d="m5.4 5.1q-0.3 0-0.5-0.2l-3.7-3.7c-0.3-0.3-0.3-0.7 0-1 0.2-0.3 0.7-0.3 0.9 0l3.3 3.2 3.2-3.2c0.2-0.3 0.7-0.3 0.9 0 0.3 0.3 0.3 0.7 0 1l-3.7 3.7q-0.2 0.2-0.4 0.2z">
                                                </path>
                                            </svg>
                                        </h2>
                                        <ul class="footer-acnav-list">
                                            @if (isset(
                                                    $getStoreThemeSetting[8]['homepage-header-quick-link-name-1'],
                                                    $getStoreThemeSetting[8]['homepage-header-quick-link-1']))
                                                @foreach ($getStoreThemeSetting[8]['homepage-header-quick-link-name-1'] as $name_key => $storethemesettingname)
                                                    @foreach ($getStoreThemeSetting[8]['homepage-header-quick-link-1'] as $link_key => $storethemesettinglink)
                                                        @if ($name_key == $link_key)
                                                            <li class="menu-link">
                                                                <a href="{{ $storethemesettinglink }}" target="_blank">
                                                                    {{ $storethemesettingname }}</a>
                                                            </li>
                                                        @endif
                                                    @endforeach
                                                @endforeach
                                            @else
                                                @for ($i = 0; $i < $getStoreThemeSetting[8]['loop_number']; $i++)
                                                    <li>
                                                        <a
                                                            href="{{ $getStoreThemeSetting[8]['inner-list'][1]['field_default_text'] }}">{{ $getStoreThemeSetting[8]['inner-list'][0]['field_default_text'] }}</a>
                                                    </li>
                                                @endfor
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                            @endif
                        @endif
                    @endif
                    @if ($getStoreThemeSetting[9]['inner-list'][0]['field_default_text'] == 'on')
                        @if (!empty($getStoreThemeSetting[9]))
                            @if (
                                (isset($getStoreThemeSetting[9]['section_enable']) && $getStoreThemeSetting[9]['section_enable'] == 'on') ||
                                    $getStoreThemeSetting[9]['inner-list'][1]['field_default_text']
                            )
                                <div class="footer-col footer-link">
                                    <div class="footer-widget set has-children1">
                                        <h2 class="footer-acnav">
                                            <span>{{ __($getStoreThemeSetting[9]['inner-list'][1]['field_default_text']) }}</span>
                                            <svg xmlns="http://www.w3.org/2000/svg" version="1.2" viewBox="0 0 10 5" width="10"
                                                height="5">
                                                <path class="a"
                                                    d="m5.4 5.1q-0.3 0-0.5-0.2l-3.7-3.7c-0.3-0.3-0.3-0.7 0-1 0.2-0.3 0.7-0.3 0.9 0l3.3 3.2 3.2-3.2c0.2-0.3 0.7-0.3 0.9 0 0.3 0.3 0.3 0.7 0 1l-3.7 3.7q-0.2 0.2-0.4 0.2z">
                                                </path>
                                            </svg>
                                        </h2>
                                        <ul class="footer-acnav-list">
                                            @if (isset(
                                                    $getStoreThemeSetting[10]['homepage-header-quick-link-name-2'],
                                                    $getStoreThemeSetting[10]['homepage-header-quick-link-2']))
                                                @foreach ($getStoreThemeSetting[10]['homepage-header-quick-link-name-2'] as $name_key => $storethemesettingname)
                                                    @foreach ($getStoreThemeSetting[10]['homepage-header-quick-link-2'] as $link_key => $storethemesettinglink)
                                                        @if ($name_key == $link_key)
                                                            <li>
                                                                <a href="{{ $storethemesettinglink }}"
                                                                    target="_blank">{{ $storethemesettingname }}</a>
                                                            </li>
                                                        @endif
                                                    @endforeach
                                                @endforeach
                                            @else
                                                @for ($i = 0; $i < $getStoreThemeSetting[10]['loop_number']; $i++)
                                                    <li>
                                                        <a
                                                            href="{{ $getStoreThemeSetting[10]['inner-list'][1]['field_default_text'] }}">
                                                            {{ $getStoreThemeSetting[10]['inner-list'][0]['field_default_text'] }}</a>
                                                    </li>
                                                @endfor
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                            @endif
                        @endif
                    @endif
                    @if ($getStoreThemeSetting[11]['inner-list'][1]['field_default_text'] == 'on')
                        @if (!empty($getStoreThemeSetting[11]))
                            @if (
                                (isset($getStoreThemeSetting[11]['section_enable']) && $getStoreThemeSetting[11]['section_enable'] == 'on') ||
                                    $getStoreThemeSetting[11]['inner-list'][1]['field_default_text']
                            )
                                <div class="footer-col footer-link">
                                    <div class="footer-widget set has-children1">
                                        <h2 class="footer-acnav">
                                            <span>{{ __($getStoreThemeSetting[11]['inner-list'][0]['field_default_text']) }}</span>
                                            <svg xmlns="http://www.w3.org/2000/svg" version="1.2" viewBox="0 0 10 5" width="10"
                                                height="5">
                                                <path class="a"
                                                    d="m5.4 5.1q-0.3 0-0.5-0.2l-3.7-3.7c-0.3-0.3-0.3-0.7 0-1 0.2-0.3 0.7-0.3 0.9 0l3.3 3.2 3.2-3.2c0.2-0.3 0.7-0.3 0.9 0 0.3 0.3 0.3 0.7 0 1l-3.7 3.7q-0.2 0.2-0.4 0.2z">
                                                </path>
                                            </svg>
                                        </h2>
                                        <ul class="footer-acnav-list">
                                            @if (isset(
                                                    $getStoreThemeSetting[12]['homepage-header-quick-link-name-3'],
                                                    $getStoreThemeSetting[12]['homepage-header-quick-link-3']))
                                                @foreach ($getStoreThemeSetting[12]['homepage-header-quick-link-name-3'] as $name_key => $storethemesettingname)
                                                    @foreach ($getStoreThemeSetting[12]['homepage-header-quick-link-3'] as $link_key => $storethemesettinglink)
                                                        @if ($name_key == $link_key)
                                                            <li>
                                                                <a href="{{ $storethemesettinglink }}">
                                                                    {{ $storethemesettingname }}</a>
                                                            </li>
                                                        @endif
                                                    @endforeach
                                                @endforeach
                                            @else
                                                @for ($i = 0; $i < $getStoreThemeSetting[12]['loop_number']; $i++)
                                                    <li>
                                                        <a
                                                            href="{{ $getStoreThemeSetting[12]['inner-list'][1]['field_default_text'] }}">{{ $getStoreThemeSetting[12]['inner-list'][0]['field_default_text'] }}</a>
                                                    </li>
                                                @endfor
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                            @endif
                        @endif
                    @endif
                    @if ($getStoreThemeSetting[13]['inner-list'][1]['field_default_text'] == 'on')
                        @if (!empty($getStoreThemeSetting[13]))
                            @if (
                                (isset($getStoreThemeSetting[13]['section_enable']) && $getStoreThemeSetting[13]['section_enable'] == 'on') ||
                                    $getStoreThemeSetting[13]['inner-list'][1]['field_default_text']
                            )
                                <div class="footer-col footer-link">
                                    <div class="footer-widget set has-children1">
                                        <h2 class="footer-acnav">
                                            <span>{{ __($getStoreThemeSetting[13]['inner-list'][0]['field_default_text']) }}</span>
                                            <svg xmlns="http://www.w3.org/2000/svg" version="1.2" viewBox="0 0 10 5" width="10"
                                                height="5">
                                                <path class="a"
                                                    d="m5.4 5.1q-0.3 0-0.5-0.2l-3.7-3.7c-0.3-0.3-0.3-0.7 0-1 0.2-0.3 0.7-0.3 0.9 0l3.3 3.2 3.2-3.2c0.2-0.3 0.7-0.3 0.9 0 0.3 0.3 0.3 0.7 0 1l-3.7 3.7q-0.2 0.2-0.4 0.2z">
                                                </path>
                                            </svg>
                                        </h2>
                                        <ul class="footer-acnav-list">
                                            @if (isset(
                                                    $getStoreThemeSetting[14]['homepage-header-quick-link-name-4'],
                                                    $getStoreThemeSetting[14]['homepage-header-quick-link-4']))
                                                @foreach ($getStoreThemeSetting[14]['homepage-header-quick-link-name-4'] as $name_key => $storethemesettingname)
                                                    @foreach ($getStoreThemeSetting[14]['homepage-header-quick-link-4'] as $link_key => $storethemesettinglink)
                                                        @if ($name_key == $link_key)
                                                            <li>
                                                                <a href="{{ $storethemesettinglink }}">
                                                                    {{ $storethemesettingname }}</a>
                                                            </li>
                                                        @endif
                                                    @endforeach
                                                @endforeach
                                            @else
                                                @for ($i = 0; $i < $getStoreThemeSetting[14]['loop_number']; $i++)
                                                    <li>
                                                        <a
                                                            href="{{ $getStoreThemeSetting[14]['inner-list'][1]['field_default_text'] }}">{{ $getStoreThemeSetting[14]['inner-list'][0]['field_default_text'] }}</a>
                                                    </li>
                                                @endfor
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                            @endif
                        @endif
                    @endif
                </div>
            </div>
        @endif
        @if ($getStoreThemeSetting[15]['section_enable'] == 'on')
            <div class="footer-bottom">
                <div class="container">
                    <div class="footer-bottom-inner text-center">
                        @if ($getStoreThemeSetting[15]['section_enable'] == 'on')
                            <p>{{ $getStoreThemeSetting[15]['inner-list'][0]['field_default_text'] }}</p>
                        @endif
                    </div>
                </div>
            </div>
        @endif
    </footer>
    
    @if ($getStoreThemeSetting[15]['section_enable'] == 'on')
        <script>
            {!! $getStoreThemeSetting[17]['inner-list'][0]['field_default_text'] !!}
        </script>
    @endif


    @include('storefront.partials.footer')
    
</body>

</html>
