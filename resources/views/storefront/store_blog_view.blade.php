@php
    $theme_name = $store ? $store->theme_dir : 'theme1';
@endphp
@extends('storefront.layout.' . $theme_name)
@section('page-title')
    {{ __('Blog') }}
@endsection

@php
    $imgpath=\App\Models\Utility::get_file('uploads/blog_cover_image/');
@endphp

@section('content')
<main>

    @include('storefront.' . $theme_name . '.common.common_banner_section')

    <section class="blog-grid-sec pt pb">
        <div class="container">
            <div class="contact-content">
                <div class="row justify-center">
                    <div class="col-lg-7 col-md-9 col-12">
                        <div class="article-inner">
                            <div class="article-title">
                                <h4>{{$blogs->title}}</h4>
                                <span>{{\App\Models\Utility::dateFormat($blogs->created_at)}}</span>
                            </div>
                            <div class="article-img img-ratio">
                                @if(!empty($blogs->blog_cover_image))
                                    <img alt="Image placeholder" src="{{$imgpath.$blogs->blog_cover_image}}">
                                @else
                                    <img alt="Image placeholder" src="{{asset(Storage::url('uploads/blog_cover_image/default.jpg'))}}">
                                @endif
                            </div>
                            <p>{!! $blogs->detail !!}</p>
                        
                        </div>
                    </div>
                </div>
                @if(!empty($socialblogs) && $socialblogs->enable_social_button == 'on')
                    <div id="share" class="text-center"></div>
                @endif
            </div>
        </div>
    </section>
</main>    
@endsection

@push('script')
    <script>
        $(document).ready(function () {
            var blog = {{$blogs}};
            if (blog == '') {
                window.location.href = "{{route('store.slug',$store->slug)}}";
            }
        });
    </script>
@endpush
