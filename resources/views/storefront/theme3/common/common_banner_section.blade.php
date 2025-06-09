<section class="common-banner-sec">
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