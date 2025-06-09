
<!--  Edit Profile popup start-->
<div class="profile-popup" id="profileModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="profile-popup-head">
        <button type="submit" class="common-close close-profile close-button">
            <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M1.07344 22.0001C0.860953 22.0002 0.653225 21.9372 0.476534 21.8192C0.299843 21.7011 0.162127 21.5333 0.0808052 21.337C-0.000516403 21.1407 -0.0217899 20.9247 0.0196757 20.7163C0.0611412 20.5079 0.163483 20.3165 0.313755 20.1662L20.1653 0.314673C20.3668 0.113191 20.6401 0 20.925 0C21.2099 0 21.4832 0.113191 21.6847 0.314673C21.8862 0.516155 21.9994 0.789422 21.9994 1.07436C21.9994 1.3593 21.8862 1.63257 21.6847 1.83405L1.83313 21.6856C1.73346 21.7855 1.61504 21.8647 1.48467 21.9187C1.3543 21.9726 1.21455 22.0003 1.07344 22.0001Z"
                        fill="#202126" />
                    <path
                        d="M20.9249 22.0001C20.7838 22.0003 20.6441 21.9726 20.5137 21.9187C20.3834 21.8647 20.2649 21.7855 20.1653 21.6856L0.313696 1.83405C0.112215 1.63257 -0.000976562 1.3593 -0.000976562 1.07436C-0.000976562 0.789422 0.112215 0.516155 0.313696 0.314673C0.515178 0.113191 0.788446 0 1.07338 0C1.35832 0 1.63159 0.113191 1.83307 0.314673L21.6846 20.1662C21.8349 20.3165 21.9372 20.5079 21.9787 20.7163C22.0202 20.9247 21.9989 21.1407 21.9176 21.337C21.8363 21.5333 21.6985 21.7011 21.5219 21.8192C21.3452 21.9372 21.1374 22.0002 20.9249 22.0001Z"
                        fill="#202126" />
            </svg>
        </button>
    </div>
    <div class="modal-dialog modal-dialog-centered profile-popup-inner lg-dialog" role="document">
        <div class="profile-popup-title">
            <h2></h2>
        </div>
        <div class="profile-body">
        </div>
    </div>
</div>
<!--  Edit Profile popup end-->

<div class="mask-body mask-body-home mask-body-dark"></div>

<!-- mobile-menu start -->
<div class="mobile-menu-wrapper">
    <div class="menu-close-icon">
        <button type="submit" class="common-close close-menu">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="18" viewBox="0 0 20 18">
                <path fill="#24272a"
                    d="M19.95 16.75l-.05-.4-1.2-1-5.2-4.2c-.1-.05-.3-.2-.6-.5l-.7-.55c-.15-.1-.5-.45-1-1.1l-.1-.1c.2-.15.4-.35.6-.55l1.95-1.85 1.1-1c1-1 1.7-1.65 2.1-1.9l.5-.35c.4-.25.65-.45.75-.45.2-.15.45-.35.65-.6s.3-.5.3-.7l-.3-.65c-.55.2-1.2.65-2.05 1.35-.85.75-1.65 1.55-2.5 2.5-.8.9-1.6 1.65-2.4 2.3-.8.65-1.4.95-1.9 1-.15 0-1.5-1.05-4.1-3.2C3.1 2.6 1.45 1.2.7.55L.45.1c-.1.05-.2.15-.3.3C.05.55 0 .7 0 .85l.05.35.05.4 1.2 1 5.2 4.15c.1.05.3.2.6.5l.7.6c.15.1.5.45 1 1.1l.1.1c-.2.15-.4.35-.6.55l-1.95 1.85-1.1 1c-1 1-1.7 1.65-2.1 1.9l-.5.35c-.4.25-.65.45-.75.45-.25.15-.45.35-.65.6-.15.3-.25.55-.25.75l.3.65c.55-.2 1.2-.65 2.05-1.35.85-.75 1.65-1.55 2.5-2.5.8-.9 1.6-1.65 2.4-2.3.8-.65 1.4-.95 1.9-1 .15 0 1.5 1.05 4.1 3.2 2.6 2.15 4.3 3.55 5.05 4.2l.2.45c.1-.05.2-.15.3-.3.1-.15.15-.3.15-.45z">
                </path>
            </svg>
        </button>
    </div>
    <div class="mobile-menu-bar">
        <ul>
            <li class="mobile-item">
                <a href="{{ route('store.slug', $store->slug) }}">{{ ucfirst($store->name) }}</a>
            </li>

            @if (!empty($page_slug_urls))
                @foreach ($page_slug_urls as $k => $page_slug_url)
                    @if ($page_slug_url->enable_page_header == 'on')
                        <li class="mobile-item">
                            <a
                                href="{{ route('pageoption.slug', $page_slug_url->slug) }}">{{ ucfirst($page_slug_url->name) }}</a>
                        </li>
                    @endif
                @endforeach
            @endif
           
            @if ($store['blog_enable'] == 'on' && !empty($blog))
                <li class="mobile-item">
                    <a href="{{ route('store.blog', $store->slug) }}">{{ __('Blog') }}</a>
                </li>
            @endif
        </ul>
    </div>
</div>
<!-- mobile-menu end -->

<!-- search popup start -->
<div class="search-popup">
    <button type="submit" class="common-close close-search">
        <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
            <g clip-path="url(#clip0_1_26816)">
                <path
                    d="M1.07344 22.0001C0.860953 22.0002 0.653225 21.9372 0.476534 21.8192C0.299843 21.7011 0.162127 21.5333 0.0808052 21.337C-0.000516403 21.1407 -0.0217899 20.9247 0.0196757 20.7163C0.0611412 20.5079 0.163483 20.3165 0.313755 20.1662L20.1653 0.314673C20.3668 0.113191 20.6401 0 20.925 0C21.2099 0 21.4832 0.113191 21.6847 0.314673C21.8862 0.516155 21.9994 0.789422 21.9994 1.07436C21.9994 1.3593 21.8862 1.63257 21.6847 1.83405L1.83313 21.6856C1.73346 21.7855 1.61504 21.8647 1.48467 21.9187C1.3543 21.9726 1.21455 22.0003 1.07344 22.0001Z"
                    fill="#202126" />
                <path
                    d="M20.9249 22.0001C20.7838 22.0003 20.6441 21.9726 20.5137 21.9187C20.3834 21.8647 20.2649 21.7855 20.1653 21.6856L0.313696 1.83405C0.112215 1.63257 -0.000976562 1.3593 -0.000976562 1.07436C-0.000976562 0.789422 0.112215 0.516155 0.313696 0.314673C0.515178 0.113191 0.788446 0 1.07338 0C1.35832 0 1.63159 0.113191 1.83307 0.314673L21.6846 20.1662C21.8349 20.3165 21.9372 20.5079 21.9787 20.7163C22.0202 20.9247 21.9989 21.1407 21.9176 21.337C21.8363 21.5333 21.6985 21.7011 21.5219 21.8192C21.3452 21.9372 21.1374 22.0002 20.9249 22.0001Z"
                    fill="#202126" />
            </g>
            <defs>
                <clipPath id="clip0_1_26816">
                    <rect width="22" height="22" fill="white" />
                </clipPath>
            </defs>
        </svg>
    </button>
    <div class="search-wrp">
        <div class="section-title text-center">
            <h2>{{ __('Search here') }}</h2>
        </div>
        <form class="search-form" action="{{ route('store.categorie.product', [$store->slug, 'Start shopping']) }}" method="get">
            <div class="search-form-wrp flex align-center">
                @csrf
                <input type="hidden" name="_token" value="">
                <input type="text" name="search_data" id="product-search" placeholder="{{ __('Search product') }}" class="search-input">
                <button type="submit" id="search-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 13 13" fill="none">
                        <path
                            d="M12.8589 12.178L9.36383 8.68284C10.1301 7.76406 10.5926 6.58348 10.5926 5.29625C10.5926 2.37585 8.2167 0 5.29628 0C2.37586 0 0 2.37585 0 5.29625C0 8.21665 2.37586 10.5925 5.29628 10.5925C6.58352 10.5925 7.76411 10.13 8.6829 9.36376L12.1781 12.8589C12.2721 12.9529 12.3954 13 12.5185 13C12.6416 13 12.7649 12.9529 12.8589 12.8589C13.047 12.6708 13.047 12.366 12.8589 12.178ZM0.962961 5.29625C0.962961 2.90692 2.9067 0.962954 5.29628 0.962954C7.68587 0.962954 9.62961 2.90692 9.62961 5.29625C9.62961 7.68558 7.68587 9.62954 5.29628 9.62954C2.9067 9.62954 0.962961 7.68558 0.962961 5.29625Z"
                            fill="#262626" />
                    </svg>
                </button>
            </div>
        </form>
        <ul id="product-results" class=""></ul>
    </div>
</div>
<!-- search popup end -->

{{-- checkout modal --}}
<div class="modal-popup top-center" id="Checkout">
    <div class="modal-dialog-inner modal-md">
        <div class="popup-content">
            <div class="popup-header modal-header">
                <h4>{{ __('Checkout As Guest Or Login') }}</h4>
                <div class="close-button">
                    <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 50 50"
                        fill="none">
                        <path
                            d="M27.7618 25.0008L49.4275 3.33503C50.1903 2.57224 50.1903 1.33552 49.4275 0.572826C48.6647 -0.189868 47.428 -0.189965 46.6653 0.572826L24.9995 22.2386L3.33381 0.572826C2.57102 -0.189965 1.3343 -0.189965 0.571605 0.572826C-0.191089 1.33562 -0.191186 2.57233 0.571605 3.33503L22.2373 25.0007L0.571605 46.6665C-0.191186 47.4293 -0.191186 48.666 0.571605 49.4287C0.952952 49.81 1.45285 50.0007 1.95275 50.0007C2.45266 50.0007 2.95246 49.81 3.3339 49.4287L24.9995 27.763L46.6652 49.4287C47.0465 49.81 47.5464 50.0007 48.0463 50.0007C48.5462 50.0007 49.046 49.81 49.4275 49.4287C50.1903 48.6659 50.1903 47.4292 49.4275 46.6665L27.7618 25.0008Z"
                            fill="white"></path>
                    </svg>
                </div>
            </div>
            <div class="modal-body">
                <div class="btn-group checkout-btns">
                    <a href="{{ route('customer.login', $store->slug) }}"
                        class="btn guest-checkout-btn">{{ __('Countinue to sign in') }}</a>
                    <a href="{{ route('user-address.useraddress', $store->slug) }}"
                        class="btn guest-checkout-btn">{{ __('Countinue as guest') }}</a>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- back to top start here -->
<div class="progress-wrap active-progress">
    <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
        <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98"
            style="transition: stroke-dashoffset 10ms linear; stroke-dasharray: 307.919, 307.919; stroke-dashoffset: 0;">
        </path>
    </svg>
</div>
<!-- back to top end here -->

@if ($settings['enable_cookie'] == 'on')
    @include('layouts.cookie_consent')
@endif


<!--scripts start here-->
<script src="{{ asset('custom/js/jquery.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/bootstrap.min.js') }}"></script>
<script src="{{ asset('custom/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/' . $theme_name . '/js/slick.min.js') }}" defer="defer"></script>
<script src="{{ asset('custom/libs/bootstrap-notify/bootstrap-notify.min.js') }}"></script>

{{-- pwa customer app --}}
@if ($store->enable_pwa_store == 'on')
    <script type="text/javascript">
        const container = document.querySelector("body")

        const coffees = [];

        if ("serviceWorker" in navigator) {

            window.addEventListener("load", function() {
                navigator.serviceWorker
                    .register("{{ asset('serviceWorker.js') }}")
                    .then(res => console.log(""))
                    .catch(err => console.log("service worker not registered", err))

            })
        }
    </script>
@endif
@if (isset($data->value) && $data->value == 'on')
    <script src="{{ asset('assets/' . $theme_name . '/js/rtl-custom.js') }}"></script>
@else
    <script src="{{ asset('assets/' . $theme_name . '/js/custom.js') }}" defer="defer"></script>
@endif

<script src="{{ asset('custom/js/custom.js') }}"></script>

@stack('script-page')

<script>
    $(".add_to_cart").click(function(e) {
        e.preventDefault();
        var id = $(this).attr('data-id');
        var variants = [];
        $(".variant-selection").each(function(index, element) {
            variants.push(element.value);
        });

        if (jQuery.inArray('', variants) != -1) {
            show_toastr('Error', "{{ __('Please select all option.') }}", 'error');
            return false;
        }
        var variation_ids = $('#variant_id').val();

        $.ajax({
            url: '{{ route('user.addToCart', ['__product_id', $store->slug, 'variation_id']) }}'
                .replace(
                    '__product_id', id).replace('variation_id', variation_ids ?? 0),
            type: "POST",
            data: {
                "_token": "{{ csrf_token() }}",
                variants: variants.join(' : '),
            },
            success: function(response) {
                if (response.status == "Success") {
                    show_toastr('Success', response.success, 'success');
                    $("#shoping_counts").html(response.item_count);
                } else {
                    show_toastr('Error', response.error, 'error');
                }
            },
            error: function(result) {
                console.log('error');
            }
        });
    });

    $(document).on('click', '.add_to_wishlist', function(e) {
        e.preventDefault();
        var id = $(this).attr('data-id');
        $.ajax({
            type: "POST",
            url: '{{ route('store.addtowishlist', [$store->slug, '__product_id']) }}'.replace(
                '__product_id', id),
            data: {
                "_token": "{{ csrf_token() }}",
            },

            success: function(response) {
                if (response.status == "Success") {
                    show_toastr('Success', response.message, 'success');
                    $('.wishlist_' + response.id).removeClass('add_to_wishlist');
                    $('.wishlist_' + response.id).addClass('wishlist-active');
                    // $('.wishlist_' + response.id).html('<i class="fas fa-heart"></i>');
                    $('.wishlist_count').html(response.count);
                } else {
                    show_toastr('Error', response.error, 'error');
                }
            },
            error: function(result) {}
        });
    });
    $(".productTab").click(function(e) {
        e.preventDefault();
        $('.productTab').removeClass('active')

    });
</script>
<script>
    function set_variant_price() {
        var variants = [];
        $(".variant-selection").each(function(index, element) {
            variants.push(element.value);
        });

        if (variants.length > 0) {
            $.ajax({
                url: '{{ route('get.products.variant.quantity') }}',
                data: {
                    "_token": $('meta[name="csrf-token"]').attr('content'),
                    variants: variants.join(' : '),
                    product_id: $('#product_id').val()
                },
                
                success: function(data) {
                    $('.product-price-error').hide();
                    $('.product-price').show();

                    $('.variation_price').html(data.price);
                    $('#variant_id').val(data.variant_id);
                    $('#variant_qty').val(data.quantity);


                    var variant_message_array = [];
                    $( ".variant_loop" ).each(function( index ) {
                            var variant_name = $(this).prev().text();
                            var variant_val = $(this).val();
                            variant_message_array.push(variant_val+" "+variant_name);
                    });
                    var variant_message = variant_message_array.join(" and ");

                    if(data.variant_id == 0) {
                        $('.add_to_cart').hide();

                        $('.product-price').hide();
                        $('.product-price-error').show();
                        var message =  '<span class=" mb-0 text-danger">This product is not available with '+variant_message+'.</span>';
                        $('.product-price-error').html(message);
                    }else{
                        $('.add_to_cart').show();
                    }
                }
            });
        }
    }
</script>
<script>
    $(document).on('click', '.delete_wishlist_item', function(e) {
        e.preventDefault();
        var id = $(this).attr('data-id');

        $.ajax({
            type: "DELETE",
            url: '{{ route('delete.wishlist_item', [$store->slug, '__product_id']) }}'.replace(
                '__product_id', id),
            data: {
                "_token": "{{ csrf_token() }}",
            },
            success: function(response) {
                if (response.status == "success") {
                    show_toastr('Success', response.message, 'success');
                    $('.wishlist_' + response.id).remove();
                    $('.wishlist_count').html(response.count);
                    location.reload();
                } else {
                    show_toastr('Error', response.message, 'error');
                }
            },
            error: function(result) {}
        });
    });
</script>

@if (Session::has('success'))
    <script>
        show_toastr('{{ __('Success') }}', '{!! session('success') !!}', 'success');
    </script>
    {{ Session::forget('success') }}
@endif
@if (Session::has('error'))
    <script>
        show_toastr('{{ __('Error') }}', '{!! session('error') !!}', 'error');
    </script>
    {{ Session::forget('error') }}
@endif

<script async src="https://www.googletagmanager.com/gtag/js?id={{ $store->google_analytic }}"></script>

{!! $store->storejs !!}

<script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
        dataLayer.push(arguments);
    }

    gtag('js', new Date());

    gtag('config', '{{ $store->google_analytic }}');
</script>

<script>
    ! function(f, b, e, v, n, t, s) {
        if (f.fbq) return;
        n = f.fbq = function() {
            n.callMethod ?
                n.callMethod.apply(n, arguments) : n.queue.push(arguments)
        };
        if (!f._fbq) f._fbq = n;
        n.push = n;
        n.loaded = !0;
        n.version = '2.0';
        n.queue = [];
        t = b.createElement(e);
        t.async = !0;
        t.src = v;
        s = b.getElementsByTagName(e)[0];
        s.parentNode.insertBefore(t, s)
    }(window, document, 'script',
        'https://connect.facebook.net/en_US/fbevents.js');
    fbq('init', '{{ $store->fbpixel_code }}');
    fbq('track', 'PageView');
</script>

<noscript><img height="1" width="1" style="display:none"
        src="https://www.facebook.com/tr?id=0000&ev=PageView&noscript={{ $store->fbpixel_code }}" /></noscript>
        
<script type="text/javascript">
    $(function() {
        $(".drop-down__button ").on("click", function(e) {
            $(".drop-down").addClass("drop-down--active");
            e.stopPropagation()
        });
        $(document).on("click", function(e) {
            if ($(e.target).is(".drop-down") === false) {
                $(".drop-down").removeClass("drop-down--active");
            }
        });
    });
</script>


<script>
    $(document).on('click', 'a[data-profile-popup="true"], button[data-profile-popup="true"], div[data-profile-popup="true"]', function () {
        var data = {};
        var title = $(this).data('title');
        var size = ($(this).data('size') == '') ? 'md' : $(this).data('size');
        var url = $(this).data('url');
        $("#profileModal .profile-popup-title").html(title);
        $("#profileModal .modal-dialog").addClass('modal-' + size);
        if ($('#vc_name_hidden').length > 0) {
            data['vc_name'] = $('#vc_name_hidden').val();
        }
        if ($('#store_id').length > 0) {
            data['store_id'] = $('#store_id').val();
        }
        if ($('#discount_hidden').length > 0) {
            data['discount'] = $('#discount_hidden').val();
        }
        $.ajax({
            url: url,
            data:data,
            success: function (data) {
            
                $('#profileModal .profile-body').html(data);
                // $("#profileModal").modal('active');
                taskCheckbox();
                common_bind("#profileModal");
                common_bind_select("#profileModal");
                $('#enable_subscriber').trigger('change');
                $('#enable_flat').trigger('change');
                $('#enable_domain').trigger('change');
                $('#enable_header_img').trigger('change');
                $('#enable_product_variant').trigger('change');
                $('#enable_social_button').trigger('change');

                if ($(".multi-select").length > 0) {
                    $( $(".multi-select") ).each(function( index,element ) {
                        var id = $(element).attr('id');
                        var multipleCancelButton = new Choices(
                                '#'+id, {
                                    removeItemButton: true,
                                }
                            );
                    });
                }
                validation();
            },
            error: function (data) {
                data = data.responseJSON;
            }
        });

    });
</script>
<script type="text/javascript">
    $(document).on('click', '.downloadable_prodcut', function () {
        var download_product = $(this).attr('data-value');
        var order_id = $(this).attr('data-id');

        var data = {
            download_product: download_product,
            order_id: order_id,
        }

        $.ajax({
            url: '{{ route('user.downloadable_prodcut',$store->slug) }}',
            method: 'POST',
            data: data,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (data) {
                if (data.status == 'success') {
                    show_toastr("success", data.message+'<br> <b>'+data.msg+'<b>', data["status"]);
                    $('.downloadab_msg').html('<span class="text-success">' + data.msg + '</sapn>');
                } else {
                    show_toastr("Error", data.message+'<br> <b>'+data.msg+'<b>', data["status"]);
                }
            }
        });
    });

    document.addEventListener('DOMContentLoaded', function () {
        const searchConfigs = [
            {
                inputId: 'product-search',
                resultId: 'product-results',
                searchId: 'search-icon'
            },
            {
                inputId: 'product-search-mobile',
                resultId: 'product-results-mobile',
                searchId: 'search-icon-mobile'
            }
        ];

        searchConfigs.forEach(config => {
            const searchInput = document.getElementById(config.inputId);
            const resultsBox = document.getElementById(config.resultId);
            const searchIcon = document.getElementById(config.searchId);
            const storeSlug = @json($store->slug);
            const searchUrl = @json(route('products.search', [$store->slug]));
            const productViewBaseUrl = @json(route('store.product.product_view', [$store->slug, 0]));

            if (!searchInput || !resultsBox || !searchIcon) return;

            const performSearch = () => {
                const query = searchInput.value.trim();
                if (query.length > 1) {
                    const url = `${searchUrl}?search_product=${encodeURIComponent(query)}`;

                    fetch(url, {
                        headers: {
                            'Accept': 'application/json'
                        }
                    })
                        .then(response => response.json())
                        .then(products => {
                            resultsBox.innerHTML = '';
                            if (products.length > 0) {
                                products.forEach(product => {
                                    const item = document.createElement('li');
                                    item.textContent = product.name;
                                    item.style.padding = '8px';
                                    item.style.cursor = 'pointer';
                                    item.addEventListener('click', () => {
                                        window.location.href = `{{ url('') }}/store/${storeSlug}/product/${product.id}`;
                                    });
                                    resultsBox.appendChild(item);
                                });
                            } else {
                                resultsBox.innerHTML = '<li style="padding: 8px;">No results found</li>';
                            }
                        })
                        .catch(() => {
                            resultsBox.innerHTML = '<li style="padding: 8px;">Error loading results</li>';
                        });
                } else {
                    resultsBox.innerHTML = '<li style="padding: 8px;">No results found</li>';
                }
            };

            // script pending
            const openFirstResult = () => {
                const query = searchInput.value.trim();
                
                if (query.length > 1) {
                    const url = `${searchUrl}?search_product=${encodeURIComponent(query)}`;

                    fetch(url, {
                        headers: {
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(products => {
                        
                        if (products.length > 0) {
                            const firstProduct = products[0];
                            if (firstProduct) {
                                window.location.href = `{{ url('') }}/store/${storeSlug}/product/${firstProduct.id}`;
                            }
                        } else {
                        }   
                    })
                    .catch(() => {
                        firstProduct.click();
                    });
                }
            };

            searchInput.addEventListener('input', performSearch);
            searchInput.addEventListener('keydown', function (e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    const firstItem = resultsBox.querySelector('li');
                    if (
                        firstItem &&
                        firstItem.textContent !== 'No results found' &&
                        firstItem.textContent !== 'Error loading results'
                    ) {
                        firstItem.click();
                    }
                }
                $('#product-results').addClass('list');
            });
            searchIcon.addEventListener('click', function () {
                openFirstResult(); 
            });
            document.addEventListener('click', function (e) {
                if (!searchInput.contains(e.target) && !resultsBox.contains(e.target) && !searchIcon.contains(e.target)) {
                    resultsBox.innerHTML = '';
                    $('#product-results').removeClass('list');
                }
            });
            if (searchInput.form) {
                searchInput.form.addEventListener('submit', function (e) {
                    e.preventDefault();
                });
            }
        });
    });
</script>
<!--scripts end here-->