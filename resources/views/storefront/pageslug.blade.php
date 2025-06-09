@php
    $theme_name = $store ? $store->theme_dir : 'theme1';
@endphp
@extends('storefront.layout.' . $theme_name)

@section('page-title')
    {{ ucfirst($pageoption->name) }}
@endsection

@section('content')
<main> 
    
    @include('storefront.' . $theme_name . '.common.common_banner_section')

    <section class="contact-us-section pt pb">
        <div class="container">
            <div class="contact-content">
                <h3> {{ ucfirst($pageoption->name) }}</h3>
                <p>{!! $pageoption->contents !!}</p>
            </div>
        </div>
    </section>
</main>
@endsection


