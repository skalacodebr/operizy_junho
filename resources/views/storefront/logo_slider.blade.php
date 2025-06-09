
@if($getStoreThemeSetting[5]['section_enable'] == 'on')
<section class="partner-logo-sec pb">
    <div class="container">
        <div class="partner-logo-slider">
            @foreach ($getStoreThemeSetting as $key => $storethemesetting)
                @if (isset($storethemesetting['section_name']) && $storethemesetting['section_name'] == 'Home-Brand-Logo' && $storethemesetting['section_enable'] == 'on')
                    @foreach ($storethemesetting['inner-list'] as $image)
                        @if (!empty($image['image_path']))
                            @foreach ($image['image_path'] as $img)
                                <div class="partner-logo-image">
                                    <a href="#">
                                        <img src="{{ $imgpath . (!empty($img) ? $img : 'storego-image.png') }}" alt="partner-logo-img">
                                    </a>
                                </div>
                            @endforeach
                        @else
                            <div class="partner-logo-image">
                                <a href="#">
                                    <img src="{{ $default }}" alt="partner-logo-img">
                                </a>
                            </div>
                            <div class="partner-logo-image">
                                <a href="#">
                                    <img src="{{ $default }}" alt="partner-logo-img">
                                </a>
                            </div>
                            <div class="partner-logo-image">
                                <a href="#">
                                    <img src="{{ $default }}" alt="partner-logo-img">
                                </a>
                            </div>
                            <div class="partner-logo-image">
                                <a href="#">
                                    <img src="{{ $default }}" alt="partner-logo-img">
                                </a>
                            </div>
                            <div class="partner-logo-image">
                                <a href="#">
                                    <img src="{{ $default }}" alt="partner-logo-img">
                                </a>
                            </div>
                            <div class="partner-logo-image">
                                <a href="#">
                                    <img src="{{ $default }}" alt="partner-logo-img">
                                </a>
                            </div>
                            <div class="partner-logo-image">
                                <a href="#">
                                    <img src="{{ $default }}" alt="partner-logo-img">
                                </a>
                            </div>
                        @endif
                    @endforeach
                @endif
            @endforeach
        </div>
    </div>
</section>
@endif