@extends('storefront.layout.theme4')
@section('page-title')
    {{ __('Product Details') }}
@endsection

@php
    $coverImg = \App\Models\Utility::get_file('uploads/is_cover_image/');
    $productImg = \App\Models\Utility::get_file('uploads/product_image/');
@endphp

@section('content')
<main>
    
    @include('storefront.theme4.common.common_banner_section')

    <section class="pdp-page-main-sec pb">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-12">
                    <div class="pdp-left-column sticky-column">
                        <div class="pdp-slider-wrapper flex">
                            <div class="pro-thumb-slider">
                                @foreach ($products_image as $key => $productss)
                                    <div class="thumb-image-item" data-slide-to="{{ $key }}">
                                        <div class="thumb-item-inner">
                                            <div class="pdp-thumb-image img-ratio">
                                                @if (!empty($products_image[$key]->product_images))
                                                    <img src="{{ $productImg . $products_image[$key]->product_images}}" alt="...">
                                                @else
                                                    <img src="{{ asset(Storage::url('uploads/product_image/default.jpg')) }}" alt="...">
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="pro-main-slider">
                                @foreach ($products_image as $key => $productss)
                                    <div class="product-main-item {{ $key == 0 ? 'active' : '' }}"  data-slide-number="{{ $key }}">
                                        @if (!empty($products_image[$key]->product_images))
                                            <div class="product-item-img img-ratio">
                                                <img src="{{ $productImg . $products_image[$key]->product_images }}"  data-remote="{{ $productImg . $products_image[$key]->product_images }}" data-type="image" data-toggle="lightbox" data-gallery="example-gallery" alt="product">
                                            </div>    
                                        @else
                                            <div class="product-item-img img-ratio">
                                                <img src="{{ asset(Storage::url('uploads/product_image/default.jpg')) }}"  data-remote="{{ $productImg . $products_image[$key]->product_images }}" data-type="image" data-toggle="lightbox" data-gallery="example-gallery" alt="product">
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-12">
                    @include('storefront.product_detail.details')
                </div>
            </div>
        </div>
    </section>
    <section class="pdp-tab-sec tabs-wrapper pb">
        <div class="container">
            <div class="tab-head-row">
                <ul class="tabs flex no-wrap align-center">
                    <li data-tab="pdp-tab-1" class="active">
                        <a href="javascript:;" class="">{{ __('Information') }}</a>
                        <div class="line"></div>
                    </li>
                    <li data-tab="pdp-tab-2">
                        <a href="javascript:;" class="">{{ __('Reviews') }}</a>
                        <div class="line"></div>
                    </li>
                </ul>
            </div>
            <div class="tabs-container">
                @include('storefront.product_detail.information_tab')
            </div>
        </div>
    </section>
    <section class="related-product-sec pb">
        <div class="container">
            <div class="section-title text-center">
                <h2>{{ __('Related products') }}</h2>
            </div>
            <div class="related-product-slider">
                @foreach ($all_products as $key => $product)
                    @if ($product->id != $products->id)
                        @include('storefront.theme4.common.product_section')
                    @endif
                @endforeach
            </div>
        </div>
    </section>
 </main>

@endsection

@push('script-page')
    <script>
        $(document).ready(function() {
            set_variant_price();
        });

        $(document).on('change', '#pro_variants_name', function() {
            set_variant_price();
        });
    </script>
@endpush