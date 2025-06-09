@php
    $company_logo = \App\Models\Utility::GetLogo();
    $plan = \Auth::user()->currentPlan;
@endphp

@if (isset($setting['cust_theme_bg']) && $setting['cust_theme_bg'] == 'on')
    <nav class="dash-sidebar light-sidebar transprent-bg">
@else
    <nav class="dash-sidebar light-sidebar">
@endif
    <div class="navbar-wrapper">
        <div class="m-header justify-content-center">
            <a href="{{ route('dashboard') }}" class="b-brand">
                <!-- ======== change your logo here ============ -->
                <img src="{{ $logo . '/' . (isset($company_logo) && !empty($company_logo) ? $company_logo : 'logo-dark.png') . '?timestamp=' . time() }}"
                     alt="{{ config('app.name', 'Storego') }}"
                     class="logo logo-lg fix-logo"
                     height="40px" />
            </a>
        </div>
        <div class="navbar-content">
            <ul class="dash-navbar">
                {{-- Super Admin --}}
                @if (Auth::user()->type == 'super admin')
                    @can('Manage Dashboard')
                        <li class="dash-item {{ Request::segment(1) == 'dashboard' ? ' active' : 'collapsed' }}">
                            <a href="{{ route('dashboard') }}"
                               class="dash-link {{ request()->is('dashboard') ? 'active' : '' }}">
                                <span class="dash-micon"><i class="ti ti-home"></i></span>
                                <span class="dash-mtext">{{ __('Dashboard') }}</span>
                            </a>
                        </li>
                    @endcan

                    @can('Manage Store')
                        <li class="dash-item dash-hasmenu {{ Request::segment(1) == 'store-resource' || Request::route()->getName() == 'store.grid' ? ' active dash-trigger' : 'collapsed' }}">
                            <a href="{{ route('store-resource.index') }}"
                               class="dash-link {{ request()->is('store-resource') ? 'active' : '' }}">
                                <span class="dash-micon"><i class="ti ti-user"></i></span>
                                <span class="dash-mtext">{{ __('Stores') }}</span>
                            </a>
                        </li>
                    @endcan

                    @can('Manage Coupans')
                        <li class="dash-item dash-hasmenu {{ Request::segment(1) == 'coupons' ? ' active' : 'collapsed' }}">
                            <a href="{{ route('coupons.index') }}"
                               class="dash-link {{ request()->is('coupons') ? 'active' : '' }}">
                                <span class="dash-micon"><i class="ti ti-tag"></i></span>
                                <span class="dash-mtext">{{ __('Coupons') }}</span>
                            </a>
                        </li>
                    @endcan

                    @can('Manage Plans')
                        <li class="dash-item dash-hasmenu {{ Request::segment(1) == 'plans' || Request::route()->getName() == 'stripe' ? ' active dash-trigger' : 'collapsed' }}">
                            <a href="{{ route('plans.index') }}"
                               class="dash-link {{ request()->is('plans') ? 'active' : '' }}">
                                <span class="dash-micon"><i class="ti ti-trophy"></i></span>
                                <span class="dash-mtext">{{ __('Plans') }}</span>
                            </a>
                        </li>
                    @endcan

                    @can('Manage Plan Request')
                        <li class="dash-item dash-hasmenu {{ Request::segment(1) == 'plan_request' ? ' active' : 'collapsed' }}">
                            <a href="{{ route('plan_request.index') }}"
                               class="dash-link {{ request()->is('plan_request') ? 'active' : '' }}">
                                <span class="dash-micon"><i class="ti ti-brand-telegram"></i></span>
                                <span class="dash-mtext">{{ __('Plan Requests') }}</span>
                            </a>
                        </li>
                    @endcan

                    <li class="dash-item dash-hasmenu {{ Request::segment(1) == 'referral-program' ? 'active' : '' }}">
                        <a href="{{ route('referral-program.index') }}" class="dash-link">
                            <span class="dash-micon"><i class="ti ti-discount-2"></i></span>
                            <span class="dash-mtext">{{ __('Referral Program') }}</span>
                        </a>
                    </li>

                    <li class="dash-item dash-hasmenu {{ Request::segment(1) == 'custom_domain_request' ? ' active' : 'collapsed' }}">
                        <a href="{{ route('custom_domain_request.index') }}"
                           class="dash-link {{ request()->is('custom_domain_request') ? 'active' : '' }}">
                            <span class="dash-micon"><i class="ti ti-browser"></i></span>
                            <span class="dash-mtext">{{ __('Domain Requests') }}</span>
                        </a>
                    </li>

                    @can('Manage Email Template')
                        <li class="dash-item dash-hasmenu {{ Request::route()->getName() == 'manage.email.language' ? ' active dash-trigger' : 'collapsed' }}">
                            <a href="{{ route('email_templates.index') }}"
                               class="dash-link {{ request()->is('email_template') ? 'active' : '' }}">
                                <span class="dash-micon"><i class="ti ti-mail"></i></span>
                                <span class="dash-mtext">{{ __('Email Templates') }}</span>
                            </a>
                        </li>
                    @endcan

                    @include('landingpage::menu.landingpage')

                    @can('Manage Settings')
                        <li class="dash-item dash-hasmenu {{ Request::segment(1) == 'settings' || Request::route()->getName() == 'store.editproducts' ? ' active dash-trigger' : 'collapsed' }}">
                            <a href="{{ route('settings') }}"
                               class="dash-link {{ request()->is('settings') ? 'active' : '' }}">
                                <span class="dash-micon"><i class="ti ti-settings"></i></span>
                                <span class="dash-mtext">
                                    {{ Auth::user()->type == 'super admin' ? __('Settings') : __('Store Settings') }}
                                </span>
                            </a>
                        </li>
                    @endcan

                {{-- Outros usuários --}}
                @else

                    {{-- Dashboard --}}
                    <li class="dash-item dash-hasmenu {{ Request::segment(1) == 'dashboard' || Request::segment(1) == 'storeanalytic' || Request::route()->getName() == 'orders.show' ? ' active dash-trigger' : 'collapsed' }}">
                        <a href="#!" class="dash-link">
                            <span class="dash-micon"><i class="ti ti-home"></i></span>
                            <span class="dash-mtext">{{ __('Dashboard') }}</span>
                            <span class="dash-arrow"><i data-feather="chevron-right"></i></span>
                        </a>
                        <ul class="dash-submenu {{ Request::segment(1) == 'dashboard' || Request::segment(1) == 'storeanalytic' ? ' show' : '' }}">
                            @can('Manage Dashboard')
                                <li class="dash-item {{ Request::route()->getName() == 'dashboard' ? ' active' : '' }}">
                                    <a href="{{ route('dashboard') }}" class="dash-link">{{ __('Dashboard') }}</a>
                                </li>
                            @endcan
                            @can('Manage Store Analytics')
                                <li class="dash-item {{ Request::route()->getName() == 'storeanalytic' ? ' active' : '' }}">
                                    <a href="{{ route('storeanalytic') }}" class="dash-link">{{ __('Store Analytics') }}</a>
                                </li>
                            @endcan
                            @can('Manage Orders')
                                <li class="dash-item {{ Request::segment(1) == 'orders.index' || Request::route()->getName() == 'orders.show' ? ' active' : '' }}">
                                    <a href="{{ route('orders.index') }}" class="dash-link">{{ __('Orders') }}</a>
                                </li>
                            @endcan
                        </ul>
                    </li>

                    {{-- Themes --}}
                    @can('Manage Themes')
                        <li class="dash-item {{ Request::segment(1) == 'themes' ? ' active' : 'collapsed' }}">
                            <a href="{{ route('themes.theme') }}"
                               class="dash-link {{ request()->is('themes') ? 'active' : '' }}">
                                <span class="dash-micon"><i class="ti ti-layout-2"></i></span>
                                <span class="dash-mtext">{{ __('Themes') }}</span>
                            </a>
                        </li>
                    @endcan

                    {{-- Staff (Usuários) --}}
                    @canany(['Manage Role', 'Manage User'])
                        <li class="dash-item dash-hasmenu {{ Request::segment(1) == 'users' || Request::segment(1) == 'roles' ? ' active dash-trigger' : 'collapsed' }}">
                            <a href="#!" class="dash-link">
                                <span class="dash-micon"><i class="ti ti-users"></i></span>
                                <span class="dash-mtext">{{ __('Staff') }}</span>
                                <span class="dash-arrow"><i data-feather="chevron-right"></i></span>
                            </a>
                            <ul class="dash-submenu {{ Request::segment(1) == 'users' || Request::segment(1) == 'roles' ? ' show' : '' }}">
                                @can('Manage Role')
                                    <li class="dash-item {{ Request::route()->getName() == 'roles.index' ? ' active' : '' }}">
                                        <a href="{{ route('roles.index') }}" class="dash-link">{{ __('Roles') }}</a>
                                    </li>
                                @endcan
                                @can('Manage User')
                                    <li class="dash-item {{ Request::route()->getName() == 'users.index' ? ' active' : '' }}">
                                        <a href="{{ route('users.index') }}" class="dash-link">{{ __('Users') }}</a>
                                    </li>
                                @endcan

                                {{-- Itens que faltavam, desabilitados --}}
                                <li class="dash-item">
                                    <a href="#"
                                       class="dash-link disabled"
                                       aria-disabled="true">
                                        <span class="dash-micon"><i class="ti ti-bookmark"></i></span>
                                        <span class="dash-mtext">{{ __('Favoritos') }}</span>
                                    </a>
                                </li>
                                <li class="dash-item">
                                    <a href="#"
                                       class="dash-link disabled"
                                       aria-disabled="true">
                                        <span class="dash-micon"><i class="ti ti-star"></i></span>
                                        <span class="dash-mtext">{{ __('Avaliações') }}</span>
                                    </a>
                                </li>
                                <li class="dash-item">
                                    <a href="#"
                                       class="dash-link disabled"
                                       aria-disabled="true">
                                        <span class="dash-micon"><i class="ti ti-refresh"></i></span>
                                        <span class="dash-mtext">{{ __('Trocas e devoluções') }}</span>
                                    </a>
                                </li>
                                <li class="dash-item">
                                    <a href="#"
                                       class="dash-link disabled"
                                       aria-disabled="true">
                                        <span class="dash-micon"><i class="ti ti-video"></i></span>
                                        <span class="dash-mtext">{{ __('Vídeo commerce') }}</span>
                                    </a>
                                </li>
                                <li class="dash-item">
                                    <a href="#"
                                       class="dash-link disabled"
                                       aria-disabled="true">
                                        <span class="dash-micon"><i class="ti ti-message"></i></span>
                                        <span class="dash-mtext">{{ __('Comentários') }}</span>
                                    </a>
                                </li>
                                <li class="dash-item">
                                    <a href="#"
                                       class="dash-link disabled"
                                       aria-disabled="true">
                                        <span class="dash-micon"><i class="ti ti-activity"></i></span>
                                        <span class="dash-mtext">{{ __('Izi Lead') }}</span>
                                    </a>
                                </li>
                                {{-- Provedor virtual e Programa de afiliados foram omitidos --}}
                            </ul>
                        </li>
                    @endcanany

                    {{-- POS --}}
                    @can('Manage Pos')
                        <li class="dash-item {{ Request::segment(1) == 'pos' ? ' active' : 'collapsed' }}">
                            <a href="{{ route('pos.index') }}"
                               class="dash-link {{ request()->is('pos') ? 'active' : '' }}">
                                <span class="dash-micon"><i class="ti ti-layers-difference"></i></span>
                                <span class="dash-mtext">{{ __('Pos') }}</span>
                            </a>
                        </li>
                    @endcan

                    {{-- Shop --}}
                    @canany(['Manage Products','Manage Product category','Manage Product Tax','Manage Product Coupan','Manage Subscriber','Manage Shipping','Manage Custom Page','Manage Blog','Manage Testimonial'])
                        <li class="dash-item dash-hasmenu {{ in_array(Request::segment(1), ['product','product_categorie','product_tax','product-coupon','shipping','subscriptions','custom-page','blog','products']) ? ' active dash-trigger' : 'collapsed' }}">
                            <a href="#!" class="dash-link">
                                <span class="dash-micon"><i class="ti ti-license"></i></span>
                                <span class="dash-mtext">{{ __('Shop') }}</span>
                                <span class="dash-arrow"><i data-feather="chevron-right"></i></span>
                            </a>
                            <ul class="dash-submenu {{ Request::segment(1) == 'product' ? ' show' : '' }}">
                                @can('Manage Products')
                                    <li class="dash-item {{ Request::route()->getName() == 'product.index' ? ' active' : '' }}">
                                        <a href="{{ route('product.index') }}" class="dash-link">{{ __('Products') }}</a>
                                    </li>
                                @endcan
                                @can('Manage Product category')
                                    <li class="dash-item {{ Request::route()->getName() == 'product_categorie.index' ? ' active' : '' }}">
                                        <a href="{{ route('product_categorie.index') }}" class="dash-link">{{ __('Product Category') }}</a>
                                    </li>
                                @endcan
                                @can('Manage Product Tax')
                                    <li class="dash-item {{ Request::route()->getName() == 'product_tax.index' ? ' active' : '' }}">
                                        <a href="{{ route('product_tax.index') }}" class="dash-link">{{ __('Product Tax') }}</a>
                                    </li>
                                @endcan
                                @can('Manage Product Coupan')
                                    <li class="dash-item {{ Request::route()->getName() == 'product-coupon.index' ? ' active' : '' }}">
                                        <a href="{{ route('product-coupon.index') }}" class="dash-link">{{ __('Product Coupon') }}</a>
                                    </li>
                                @endcan
                                @can('Manage Subscriber')
                                    <li class="dash-item {{ Request::route()->getName() == 'subscriptions.index' ? ' active' : '' }}">
                                        <a href="{{ route('subscriptions.index') }}" class="dash-link">{{ __('Subscriber') }}</a>
                                    </li>
                                @endcan
                                @if(isset($plan->shipping_method) && $plan->shipping_method == 'on')
                                    @can('Manage Shipping')
                                        <li class="dash-item {{ Request::route()->getName() == 'shipping.index' ? ' active' : '' }}">
                                            <a href="{{ route('shipping.index') }}" class="dash-link">{{ __('Shipping') }}</a>
                                        </li>
                                    @endcan
                                @endif
                                @if(isset($plan->additional_page) && $plan->additional_page == 'on')
                                    @can('Manage Custom Page')
                                        <li class="dash-item {{ Request::route()->getName() == 'custom-page.index' ? ' active' : '' }}">
                                            <a href="{{ route('custom-page.index') }}" class="dash-link">{{ __('Custom Page') }}</a>
                                        </li>
                                    @endcan
                                @endif
                                @if(isset($plan->blog) && $plan->blog == 'on')
                                    @can('Manage Blog')
                                        <li class="dash-item {{ Request::route()->getName() == 'blog.index' ? ' active' : '' }}">
                                            <a href="{{ route('blog.index') }}" class="dash-link">{{ __('Blog') }}</a>
                                        </li>
                                    @endcan
                                @endif
                                @can('Manage Testimonial')
                                    <li class="dash-item {{ Request::route()->getName() == 'testimonial.index' ? ' active' : '' }}">
                                        <a href="{{ route('testimonial.index') }}" class="dash-link">{{ __('Testimonial') }}</a>
                                    </li>
                                @endcan
                            </ul>
                        </li>
                    @endcanany

                    {{-- Customers --}}
                    @can('Manage Customers')
                        <li class="dash-item {{ Request::segment(1) == 'customer.index' ? ' active' : 'collapsed' }}">
                            <a href="{{ route('customer.index') }}" class="dash-link">
                                <span class="dash-micon"><i class="ti ti-user"></i></span>
                                <span class="dash-mtext">{{ __('Customers') }}</span>
                            </a>
                        </li>
                    @endcan

                    {{-- Plans --}}
                    @can('Manage Plans')
                        <li class="dash-item dash-hasmenu {{ Request::segment(1) == 'plans' ? ' active dash-trigger' : 'collapsed' }}">
                            <a href="{{ route('plans.index') }}" class="dash-link">
                                <span class="dash-micon"><i class="ti ti-trophy"></i></span>
                                <span class="dash-mtext">{{ __('Plans') }}</span>
                            </a>
                        </li>
                    @endcan

                    {{-- Referral Program (Owner) --}}
                    @if (Auth::user()->type == 'Owner')
                        <li class="dash-item dash-hasmenu {{ Request::segment(1) == 'referral-program' ? 'active' : '' }}">
                            <a href="{{ route('referral-program.company') }}" class="dash-link">
                                <span class="dash-micon"><i class="ti ti-discount-2"></i></span>
                                <span class="dash-mtext">{{ __('Referral Program') }}</span>
                            </a>
                        </li>
                    @endif

                    {{-- Store Settings --}}
                    @can('Manage Settings')
                        <li class="dash-item dash-hasmenu {{ Request::segment(1) == 'settings' ? ' active dash-trigger' : 'collapsed' }}">
                            <a href="{{ route('settings') }}" class="dash-link">
                                <span class="dash-micon"><i class="ti ti-settings"></i></span>
                                <span class="dash-mtext">
                                    {{ Auth::user()->type == 'super admin' ? __('Settings') : __('Store Settings') }}
                                </span>
                            </a>
                        </li>
                    @endcan

                @endif
            </ul>
        </div>
    </div>
</nav>

<style>
    /* ícones padrão */
    body .dash-sidebar.light-sidebar .dash-link .dash-micon {
        background-color: #25252900;
        box-shadow: -3px 4px 23px rgba(0, 0, 0, 0.1);
    }

    /* link laranja padrão */
    body.custom-color .dash-sidebar.light-sidebar .dash-navbar > .dash-item.active > .dash-link,
    body.custom-color .dash-sidebar.light-sidebar .dash-navbar > .dash-item:active > .dash-link,
    body.custom-color .dash-sidebar.light-sidebar .dash-navbar > .dash-item:focus > .dash-link,
    body.custom-color .dash-sidebar.light-sidebar .dash-navbar > .dash-item:hover > .dash-link,
    body.custom-color .dash-sidebar .dash-navbar > .dash-item.active > .dash-link,
    body.custom-color .dash-sidebar .dash-navbar > .dash-item:active > .dash-link,
    body.custom-color .dash-sidebar .dash-navbar > .dash-item:focus > .dash-link,
    body.custom-color .dash-sidebar .dash-navbar > .dash-item:hover > .dash-link {
      background: linear-gradient(141.55deg, var(--color-customColor) 3.46%, var(--color-customColor) 99.86%), var(--color-customColor);
      color: #fff;
      box-shadow: 0 5px 7px -1px rgba(146, 44, 136, 0.3);
    }

    /* ícone laranja */
    body.custom-color .dash-sidebar.light-sidebar .dash-navbar > .dash-item.active > .dash-link .dash-micon,
    body.custom-color .dash-sidebar.light-sidebar .dash-navbar > .dash-item:active > .dash-link .dash-micon,
    body.custom-color .dash-sidebar.light-sidebar .dash-navbar > .dash-item:focus > .dash-link .dash-micon,
    body.custom-color .dash-sidebar.light-sidebar .dash-navbar > .dash-item:hover > .dash-link .dash-micon,
    body.custom-color .dash-sidebar .dash-navbar > .dash-item.active > .dash-link .dash-micon,
    body.custom-color .dash-sidebar .dash-navbar > .dash-item:active > .dash-link .dash-micon,
    body.custom-color .dash-sidebar .dash-navbar > .dash-item:focus > .dash-link .dash-micon,
    body.custom-color .dash-sidebar .dash-navbar > .dash-item:hover > .dash-link .dash-micon {
      background-color: #fa6b2a;
      color: #fff;
      box-shadow: -3px 4px 23px rgba(0, 0, 0, 0);
    }

    /* ícones brancos no hover */
    body.custom-color .dash-sidebar.light-sidebar .dash-navbar > .dash-item.active > .dash-link i,
    body.custom-color .dash-sidebar.light-sidebar .dash-navbar > .dash-item:active > .dash-link i,
    body.custom-color .dash-sidebar.light-sidebar .dash-navbar > .dash-item:focus > .dash-link i,
    body.custom-color .dash-sidebar.light-sidebar .dash-navbar > .dash-item:hover > .dash-link i,
    body.custom-color .dash-sidebar .dash-navbar > .dash-item.active > .dash-link i,
    body.custom-color .dash-sidebar .dash-navbar > .dash-item:active > .dash-link i,
    body.custom-color .dash-sidebar .dash-navbar > .dash-item:focus > .dash-link i,
    body.custom-color .dash-sidebar .dash-navbar > .dash-item:hover > .dash-link i {
        color: #ffffff;
    }

    /* estilo dos links */
    .dash-sidebar.light-sidebar .dash-navbar > .dash-item > .dash-link {
        border-radius: 5px;
        margin: 0 15px;
        padding: 7px 10px 7px 7px;
    }

    .dash-sidebar .dash-micon {
        margin-right: 15px;
        border-radius: 5px;
        height: 35px;
        width: 35px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    /* links desabilitados */
    .dash-link.disabled {
      opacity: 0.5;
      pointer-events: none;
    }
</style>
