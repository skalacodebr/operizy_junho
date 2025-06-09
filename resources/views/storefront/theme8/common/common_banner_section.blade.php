@php
    $commonimgpath = \App\Models\Utility::get_file('uploads/');
@endphp
<section class="common-banner-sec" style="background-image: url({{ $commonimgpath . 'theme8/header/common-banner-bg.png' }});">
    <div class="container">
        <div class="common-banner-content">
            <ul class="filter-cat flex align-center justify-center">
                <li>
                    <a href="{{ route('store.slug', $store->slug) }}" tabindex="0">{{ __('home') }}</a>
                </li>
                <li>
                    <a href="#" tabindex="0">@yield('page-title')</a>
                </li>
            </ul>
        </div>
    </div>
</section>