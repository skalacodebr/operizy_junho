@extends('storefront.layout.theme6')
@section('page-title')
    {{ __('Categories Product') }}
@endsection

@php
    $coverImg = \App\Models\Utility::get_file('uploads/is_cover_image/');
    $productImg = \App\Models\Utility::get_file('uploads/product_image/');
@endphp

@section('content')
<main>
    
    @include('storefront.theme6.common.common_banner_section')

    <section class="category-product-sec tabs-wrapper pt pb">
        <div class="container">
            <div class="section-title text-center">
                <h2>{{ __('Products category') }}</h2>
                <p>{{ __('Discover the teas our customers can not stop talking about! These handpicked favorites deliver exceptional flavor.') }}</p>
            </div>
            <div class="tab-head-row flex justify-center">
                <ul class="tabs product-tabs flex no-wrap align-center">
                    @foreach($categories as $key=>$category)
                        <li class="tab-link {{($category==$categorie_name)?'active':''}}" data-tab="pdp-tab-{!! preg_replace('/[^A-Za-z0-9\-]/', '_', $category)!!}">
                            <a href="#{!!preg_replace('/[^A-Za-z0-9\-]/','_',$category)!!}" id="electronic-tab" data-id="{{$key}}">{{ $category }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="tabs-container">
                @if($products['Start shopping']->count() > 0)
                    @foreach($products as $key => $items)
                        <div class="tab-content {{ $key == $categorie_name ? 'active' : '' }}" id="pdp-tab-{!! preg_replace('/[^A-Za-z0-9\-]/', '_', $key)!!}">
                            @if ($items->count() > 0)
                                <div class="row">
                                    @foreach($items as $product)
                                        <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-12">
                                            @include('storefront.theme6.common.product_section')
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="row">
                                    <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-12">
                                        <div class="product-card">
                                            <h6 class="no_record"><i class="fas fa-ban"></i> {{ __('No Record Found') }}</h6>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endforeach
                @else
                    <div class="row justify-center">
                        <div class="text-center">
                            <i class="fas fa-folder-open text-gray" style="font-size: 48px;"></i>
                            <h2>{{ __('Opps...') }}</h2>
                            <h6> {!! __('No data Found.') !!} </h6>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>
</main>
@endsection
