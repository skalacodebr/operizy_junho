@extends('storefront.layout.theme9')
@section('page-title')
    {{ __('Product Details') }}
@endsection

@php
    $coverImg = \App\Models\Utility::get_file('uploads/is_cover_image/');
    $productImg = \App\Models\Utility::get_file('uploads/product_image/');
@endphp

@section('content')
<main>
    
    @include('storefront.theme9.common.common_banner_section')

    <section class="pdp-page-main-sec pt">
        <div class="container">
            <div class="row justify-center">
                <div class="col-12">
                    <div class="pdp-left-column">
                        <div class="pdp-slider-wrapper">
                            <div class="pro-main-slider">
                                @foreach ($products_image as $key => $productss)
                                    <div class="product-main-item {{ $key == 0 ? 'active' : '' }}"  data-slide-number="{{ $key }}">
                                        <div class="pdp-img-wrp">
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
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-6 col-xl-8 col-md-10 col-12">
                    @include('storefront.product_detail.details')
                </div>
            </div>
        </div>
    </section>
    <section class="pdp-tab-sec tabs-wrapper pb pt">
        <div class="container">
            <div class="tab-head-row">
                <ul class="tabs flex no-wrap align-center">
                    <li data-tab="pdp-tab-1" class="active">
                        <a href="javascript:;" class="">{{ __('Information') }}</a>
                    </li>
                    <li data-tab="pdp-tab-2">
                        <a href="javascript:;" class="">{{ __('Reviews') }}</a>
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
                        @include('storefront.theme9.common.product_section')
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