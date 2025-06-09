@extends('storefront.layout.theme2')
@section('page-title')
    {{ __('Categories Product') }}
@endsection
@push('css-page')

@endpush
@php
    $coverImg = \App\Models\Utility::get_file('uploads/is_cover_image/');
    $productImg = \App\Models\Utility::get_file('uploads/product_image/');
@endphp
@section('content')
<main>
    
    @include('storefront.theme2.common.common_banner_section')
    
    <section class="product-category-sec pt tabs-wrapper pb">
        <div class="container">
            <div class="section-title flex align-center justify-between">
                <div class="section-title-left">
                    <h2>{{ __('Categories Product') }}</h2>
                </div>
                <div class="section-title-right flex">
                    <ul class="tabs product-tabs flex align-center">
                        @foreach($categories as $key => $category)
                            <li class="tab-link {{($category==$categorie_name)?'active':''}}" data-tab="pdp-tab-{!! preg_replace('/[^A-Za-z0-9\-]/', '_', $category)!!}">
                                <a href="#tab-{!!preg_replace('/[^A-Za-z0-9\-]/','_',$category)!!}" id="electronic-tab" data-id="{{$key}}" class="btn btn-transparent">{{$category}}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="tabs-container">
                @if($products['Start shopping']->count() > 0)
                    @foreach ($products as $key => $items)
                        <div id="pdp-tab-{!! preg_replace('/[^A-Za-z0-9\-]/', '_', $key) !!}" class="tab-content {{ $key == $categorie_name ? 'active show' : '' }}">
                            @if ($items->count() > 0)
                                <div class="row">
                                    @foreach ($items as $product)
                                        <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-12">
                                            @include('storefront.theme2.common.product_section')
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
