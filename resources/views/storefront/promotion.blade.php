
@if($getStoreThemeSetting[1]['section_enable'] == 'on')
<section class="about-info-sec">
    <div class="container">
        <div class="about-info-slider">
            @foreach ($getStoreThemeSetting as $key => $storethemesetting)
                @if ($storethemesetting['section_name'] == 'Home-Promotions')
                    @if (isset($storethemesetting['homepage-promotions-font-icon']) || isset($storethemesetting['homepage-promotions-title']) || isset($storethemesetting['homepage-promotions-description']))
                        @for ($i = 0; $i < $storethemesetting['loop_number']; $i++)
                            <div class="about-info-item">
                                <div class="about-info-inner flex align-center">
                                    <div class="info-card-img">
                                        {!! $storethemesetting['homepage-promotions-font-icon'][$i] !!}
                                    </div>
                                    <div class="info-card-content">
                                        <h2>{{ $storethemesetting['homepage-promotions-title'][$i] }}</h2>
                                        <p>{{ $storethemesetting['homepage-promotions-description'][$i] }}</p>
                                    </div>
                                </div>
                            </div>
                        @endfor
                    @else
                        @for ($i = 0; $i < $storethemesetting['loop_number']; $i++)
                            <div class="about-info-item">
                                <div class="about-info-inner flex align-center">
                                    <div class="info-card-img">
                                        {!! $storethemesetting['inner-list'][0]['field_default_text'] !!}
                                    </div>
                                    <div class="info-card-content">
                                        <h2>{{ $storethemesetting['inner-list'][1]['field_default_text'] }}</h2>
                                        <p>{{ $storethemesetting['inner-list'][2]['field_default_text'] }}</p>
                                    </div>
                                </div>
                            </div>
                        @endfor
                    @endif
                @endif
            @endforeach
        </div>
    </div>
</section>
@endif