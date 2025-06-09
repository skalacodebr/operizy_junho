@extends('storefront.layout.theme1')
@section('page-title')
    {{ __('Blog') }}
@endsection

@php
    $imgpath=\App\Models\Utility::get_file('uploads/blog_cover_image/');
@endphp

@section('content')
<main>
    
    @include('storefront.theme1.common.common_banner_section')

    <section class="blog-grid-sec pt pb">
        <div class="container">
            <div class="row">
                @foreach($blogs as $blog)
                    <div class="col-md-4 col-sm-6 col-12">
                        <div class="blog-card">
                            <div class="blog-card-inner">
                                <div class="blog-card-image">
                                    <a href="{{route('store.store_blog_view',[$store->slug,$blog->id])}}" class="blog-image img-ratio">
                                        @if(!empty($blog->blog_cover_image))
                                            <img alt="blog-image" src="{{ $imgpath.$blog->blog_cover_image }}">
                                        @else
                                            <img alt="blog-image" src="{{ asset(Storage::url('uploads/blog_cover_image/default.jpg')) }}">
                                        @endif
                                    </a>
                                </div>
                                <div class="blog-content text-center">
                                    <div class="blog-content-top">
                                        <h3>
                                            <a href="{{route('store.store_blog_view',[$store->slug,$blog->id])}}">{{ $blog->title }}</a>
                                        </h3>
                                    </div>
                                    <div class="blog-content-bottom">
                                        <div class="blog-date"><span>{{\App\Models\Utility::dateFormat($blog->created_at)}}</span></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
</main>
@endsection