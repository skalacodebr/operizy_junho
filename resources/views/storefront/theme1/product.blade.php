
@extends('storefront.layout.theme1')
@section('page-title')
    {{ __('Products') }}
@endsection

@php
    $coverImg = \App\Models\Utility::get_file('uploads/is_cover_image/');
    $productImg = \App\Models\Utility::get_file('uploads/product_image/');
@endphp

@section('content')
<main>
        
    @include('storefront.theme1.common.common_banner_section')

    <section class="product-category-sec pt tabs-wrapper pb">
        <div class="container">
            <div class="section-title text-center">
                <h2>{{ __('Categories Products') }}</h2>
            </div>
            <div class="tab-head-row flex justify-center">
                <ul class="tabs flex no-wrap align-center">
                    @foreach($categories as $key => $category)
                        <li class="tab-link {{($category==$categorie_name)?'active':''}}" data-tab="cat-tab-{!! preg_replace('/[^A-Za-z0-9\-]/', '_', $category)!!}">
                            <a href="#{!!preg_replace('/[^A-Za-z0-9\-]/','_',$category)!!}" id="electronic-tab" data-id="{{$key}}">{{$category}}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="tabs-container">
                @if($products['Start shopping']->count() > 0)
                    @foreach ($products as $key => $items)
                        <div id="cat-tab-{!! preg_replace('/[^A-Za-z0-9\-]/', '_', $key) !!}" class="tab-content {{ $key == $categorie_name ? 'active show' : '' }}">
                            @if ($items->count() > 0)
                                <div class="row">
                                    @foreach ($items as $product)
                                        <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-12">
                                            @include('storefront.theme1.common.product_section')
                                        </div>
                                    @endforeach
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
