@extends('storefront.layout.theme8')
@section('page-title')
    {{ __('Categories Product') }}
@endsection

@php
    $coverImg = \App\Models\Utility::get_file('uploads/is_cover_image/');
    $productImg = \App\Models\Utility::get_file('uploads/product_image/');
@endphp

@section('content')
<main>
    
    @include('storefront.theme8.common.common_banner_section')

    <section class="product-category-sec tabs-wrapper pt pb">
        <div class="container">
            <div class="section-title section-title-row flex align-center justify-between">
                <div class="section-title-left">
                    <h2>{{ __('Products') }}</h2>
                </div>
                <div class="section-title-right flex">
                    <ul class="tabs product-tabs flex align-center">
                        @foreach($categories as $key=>$category)
                            <li class="tab-link {{($category==$categorie_name)?'active':''}}" data-tab="pdp-tab-{!! preg_replace('/[^A-Za-z0-9\-]/', '_', $category)!!}">
                                <a href="#{!!preg_replace('/[^A-Za-z0-9\-]/','_',$category)!!}" id="electronic-tab" data-id="{{$key}}">{{ $category }}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="tabs-container">
                @if($products['Start shopping']->count() > 0)
                    @foreach($products as $key => $items)
                        <div class="tab-content {{ $key == $categorie_name ? 'active' : '' }}" id="pdp-tab-{!! preg_replace('/[^A-Za-z0-9\-]/', '_', $key)!!}">
                            @if ($items->count() > 0)
                                <div class="row no-gutters">
                                    @foreach($items as $product)
                                        <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-12">
                                            @include('storefront.theme8.common.product_section')
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="row no-gutters">
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
            <div class="btn-wrp text-center">
                <a href="{{ route('store.categorie.product', $store->slug) }}" class="btn">
                    {{ __('Show More Products') }}
                    <span>
                        <svg width="17" height="16" viewBox="0 0 17 16" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M11.1875 7.99997C11.1875 8.12784 11.1386 8.25584 11.041 8.35347L6.04097 13.3535C5.8456 13.5488 5.52922 13.5488 5.33397 13.3535C5.13872 13.1581 5.1386 12.8417 5.33397 12.6465L9.98047 7.99997L5.33397 3.35347C5.13859 3.15809 5.13859 2.84172 5.33397 2.64647C5.52934 2.45122 5.84572 2.45109 6.04097 2.64647L11.041 7.64647C11.1386 7.74409 11.1875 7.87209 11.1875 7.99997Z"
                                fill="#203D3E" />
                        </svg>
                    </span>
                </a>
            </div>
        </div>
    </section>
</main>
@endsection
