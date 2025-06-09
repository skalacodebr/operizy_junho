@extends('storefront.layout.theme5')
@section('page-title')
    {{ __('Blog') }}
@endsection

@php
    $imgpath = \App\Models\Utility::get_file('uploads/blog_cover_image/');
@endphp

@section('content')
<main>
    
    @include('storefront.theme5.common.common_banner_section')

    <section class="blog-grid-sec pt pb">
        <div class="container">
            <div class="row">
                @foreach($blogs as $blog)
                    <div class="col-sm-6 col-12">
                        <div class="blog-card">
                            <div class="blog-card-inner">
                                <div class="blog-card-image">
                                    <a href="{{ route('store.store_blog_view', [$store->slug, $blog->id]) }}" class="blog-image img-ratio">
                                        @if(!empty($blog->blog_cover_image))
                                            <img src="{{ $imgpath . $blog->blog_cover_image }}">
                                        @else
                                            <img src="{{ asset(Storage::url('uploads/blog_cover_image/default.jpg')) }}">
                                        @endif
                                    </a>
                                </div>
                                <div class="blog-card-content">
                                    <div class="blog-date">
                                        <span>{{ \App\Models\Utility::dateFormat($blog->created_at) }}</span>
                                    </div>
                                    <h3>
                                        <a href="{{ route('store.store_blog_view', [$store->slug, $blog->id]) }}">{{ $blog->title }}</a>
                                    </h3>
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
@push('script')
    <script>
        $(document).ready(function () {
            var blog = {{sizeof($blogs)}};
            if (blog < 1) {
                window.location.href = "{{route('store.slug',$store->slug)}}";
            }
        });
    </script>
@endpush
