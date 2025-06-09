<div id="pdp-tab-1" class="tab-content active">
    <div class="pdp-description">
        @if (!empty($products->description))
            <div class="set has-children">
                <a href="javascript:;" class="pdp-acnav-label flex align-center justify-between">
                    <span>{{ __('Description') }}</span>
                    <svg width="28" height="16" viewBox="0 0 28 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M0.534844 0.54072C1.24797 -0.18024 2.4042 -0.18024 3.11733 0.54072L14 11.5429L24.8828 0.54072C25.5959 -0.18024 26.752 -0.18024 27.4651 0.54072C28.1783 1.26168 28.1783 2.43062 27.4651 3.1515L15.2912 15.4592C14.9489 15.8055 14.4843 16 14 16C13.5157 16 13.0512 15.8055 12.7089 15.4592L0.534844 3.1515C-0.178281 2.43062 -0.178281 1.26168 0.534844 0.54072Z" fill="#202126"/>
                        </svg>
                        
                </a>
                <div class="pdp-acnav-list">
                    <p>{!! $products->description !!}</p>
                </div>
            </div>
        @endif
        @if (!empty($products->specification))
            <div class="set has-children">
                <a href="javascript:;" class="pdp-acnav-label flex align-center justify-between">
                    <span>{{ __('Specification') }}</span>
                    <svg width="28" height="16" viewBox="0 0 28 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M0.534844 0.54072C1.24797 -0.18024 2.4042 -0.18024 3.11733 0.54072L14 11.5429L24.8828 0.54072C25.5959 -0.18024 26.752 -0.18024 27.4651 0.54072C28.1783 1.26168 28.1783 2.43062 27.4651 3.1515L15.2912 15.4592C14.9489 15.8055 14.4843 16 14 16C13.5157 16 13.0512 15.8055 12.7089 15.4592L0.534844 3.1515C-0.178281 2.43062 -0.178281 1.26168 0.534844 0.54072Z" fill="#202126"/>
                        </svg>
                        
                </a>
                <div class="pdp-acnav-list">
                    <p>{!! $products->specification !!}</p>
                </div>
            </div>
        @endif
        @if (!empty($products->detail))
            <div class="set has-children">
                <a href="javascript:;" class="pdp-acnav-label flex align-center justify-between">
                    <span>{{ __('Details') }}</span>
                    <svg width="28" height="16" viewBox="0 0 28 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M0.534844 0.54072C1.24797 -0.18024 2.4042 -0.18024 3.11733 0.54072L14 11.5429L24.8828 0.54072C25.5959 -0.18024 26.752 -0.18024 27.4651 0.54072C28.1783 1.26168 28.1783 2.43062 27.4651 3.1515L15.2912 15.4592C14.9489 15.8055 14.4843 16 14 16C13.5157 16 13.0512 15.8055 12.7089 15.4592L0.534844 3.1515C-0.178281 2.43062 -0.178281 1.26168 0.534844 0.54072Z" fill="#202126"/>
                        </svg>
                        
                </a>
                <div class="pdp-acnav-list">
                    <p>{!! $products->detail !!}</p>
                </div>
            </div>
        @endif
        @if (!empty($products->attachment))
            <div class="set has-children">
                <a href="javascript:;" class="pdp-acnav-label flex align-center justify-between">
                    <span>{{ __('Download attachment') }}</span>
                    <svg width="28" height="16" viewBox="0 0 28 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M0.534844 0.54072C1.24797 -0.18024 2.4042 -0.18024 3.11733 0.54072L14 11.5429L24.8828 0.54072C25.5959 -0.18024 26.752 -0.18024 27.4651 0.54072C28.1783 1.26168 28.1783 2.43062 27.4651 3.1515L15.2912 15.4592C14.9489 15.8055 14.4843 16 14 16C13.5157 16 13.0512 15.8055 12.7089 15.4592L0.534844 3.1515C-0.178281 2.43062 -0.178281 1.26168 0.534844 0.54072Z" fill="#202126"/>
                        </svg>
                        
                </a>
                <div class="pdp-acnav-list">
                    <a href="{{asset(Storage::url('uploads/is_cover_image/'.$products->attachment))}}" class="btn btn-instruction" download="{{$products->attachment}}">
                        <i class="fas fa-download"></i>
                        {{ __('Download attachment') }}
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>
<div id="pdp-tab-2" class="tab-content">
    <div class="pdp-description ">
        <div class="review-title flex align-center justify-between">
            <span>{{ __('Reviews') }}: {{ $avg_rating }}/5 ({{ $user_count }} {{ __('reviews') }})</span>
            <div class="rating-wrp flex align-center">
                <div class="pdp-rating">
                    @if ($store_setting->enable_rating == 'on')
                    @for ($i = 1; $i <= 5; $i++)
                        @php
                            $icon = 'fa-star';
                            $color = '';
                            $newVal1 = $i - 0.5;
                            if ($avg_rating < $i && $avg_rating >= $newVal1) {
                                $icon = 'fa-star-half-alt';
                            }
                            if ($avg_rating >= $newVal1) {
                                $color = 'text-warning';
                            }
                        @endphp
                        <i class="star fas {{ $icon . ' ' . $color }}"></i>
                    @endfor
                @endif
                </div>

                @if (Auth::guard('customers')->check())
                    <a href="javascript:;"
                        class="btn btn-sm btn-primary add-review-btn btn-icon-only rounded-circle float-right"
                        data-size="lg" data-toggle="modal"
                        data-url="{{ route('rating', [$store->slug, $products->id]) }}"
                        data-profile-popup="true" data-title="{{ __('Create New Rating') }}">
                        <i class="fas fa-plus"></i>
                    </a>
                @endif
            </div>
        </div>
        @foreach ($product_ratings as $product_key => $product_rating)
            @if ($product_rating->rating_view == 'on')
                <div class="review-item">
                    <p>{{ $product_rating->description }}</p>
                    <div class="review-item-content flex align-center justify-between">
                        <div class="review-item-left">
                            <div class="review-left-content">
                                <b>{{ __('Customer') }} :</b>
                                <span>{{ $product_rating->name }}</span>
                            </div>
                            <p>{{ $product_rating->title }}</p>
                        </div>
                        <div class="review-item-right rating flex align-center">
                            @for ($i = 0; $i < 5; $i++)
                                <i class="star fas fa-star {{ $product_rating->ratting > $i ? 'text-warning' : '' }}"></i>
                            @endfor
                            <span>{{ $product_rating->ratting }}/5 ({{ __('Reviews') }})</span>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    </div>
</div>