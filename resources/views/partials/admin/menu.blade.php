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
                <!-- ========   change your logo hear   ============ -->
                <img src="{{ $logo . '/' . (isset($company_logo) && !empty($company_logo) ? $company_logo : 'logo-dark.png') . '?timestamp='. time() }}"
                    alt="{{ config('app.name', 'Storego') }}" class="logo logo-lg fix-logo" height="40px" />
            </a>
        </div>
        <div class="navbar-content">
            <ul class="dash-navbar">
                @if (Auth::user()->type == 'super admin')
                    @can('Manage Dashboard')
                        <li class="dash-item {{ Request::segment(1) == 'dashboard' ? ' active' : 'collapsed' }}">
                            <a href="{{ route('dashboard') }}"
                                class="dash-link {{ request()->is('dashboard') ? 'active' : '' }}">
                                <span class="dash-micon">
                                    <i class="ti ti-home"></i>
                                </span>
                                <span class="dash-mtext">{{ __('Dashboard') }}</span>
                            </a>
                        </li>
                    @endcan
                    @can('Manage Store')
                        <li
                            class="dash-item dash-hasmenu {{ Request::segment(1) == 'store-resource' || Request::route()->getName() == 'store.grid' ? ' active dash-trigger' : 'collapsed' }}">
                            <a href="{{ route('store-resource.index') }}"
                                class="dash-link {{ request()->is('store-resource') ? 'active' : '' }}">
                                <span class="dash-micon">
                                    <i class="ti ti-user"></i>
                                </span>
                                <span class="dash-mtext">{{ __('Stores') }}</span>
                            </a>
                        </li>
                    @endcan

                    @can('Manage Coupans')
                        <li
                            class="dash-item dash-hasmenu {{ Request::segment(1) == 'coupons' ? ' active' : 'collapsed' }}">
                            <a href="{{ route('coupons.index') }}"
                                class="dash-link {{ request()->is('coupons') ? 'active' : '' }}">
                                <span class="dash-micon">
                                    <i class="ti ti-tag"></i>
                                </span>
                                <span class="dash-mtext">{{ __('Coupons') }}</span>
                            </a>
                        </li>
                    @endcan

                    @can('Manage Plans')
                        <li
                            class="dash-item dash-hasmenu {{ Request::segment(1) == 'plans' || Request::route()->getName() == 'stripe' ? ' active dash-trigger' : 'collapsed' }}">
                            <a href="{{ route('plans.index') }}"
                                class="dash-link {{ request()->is('plans') ? 'active' : '' }}">
                                <span class="dash-micon">
                                    <i class="ti ti-trophy"></i>
                                </span>
                                <span class="dash-mtext">{{ __('Plans') }}</span>
                            </a>
                        </li>
                    @endcan

                    @can('Manage Plan Request')
                        <li
                            class="dash-item dash-hasmenu {{ Request::segment(1) == 'plan_request' ? ' active' : 'collapsed' }}">
                            <a href="{{ route('plan_request.index') }}"
                                class="dash-link {{ request()->is('plan_request') ? 'active' : '' }}">
                                <span class="dash-micon">
                                    <i class="ti ti-brand-telegram"></i>
                                </span>
                                <span class="dash-mtext">{{ __('Plan Requests') }}</span>
                            </a>
                        </li>
                    @endcan

                    <li class="dash-item dash-hasmenu  {{ Request::segment(1) == 'referral-program' ? 'active' : '' }}">
                        <a href="{{ route('referral-program.index') }}" class="dash-link">
                            <span class="dash-micon"><i class="ti ti-discount-2"></i></span><span
                                class="dash-mtext">{{ __('Referral Program') }}</span>
                        </a>
                    </li>

                    <li
                        class="dash-item dash-hasmenu {{ Request::segment(1) == 'custom_domain_request' ? ' active' : 'collapsed' }}">
                        <a href="{{ route('custom_domain_request.index') }}"
                            class="dash-link {{ request()->is('custom_domain_request') ? 'active' : '' }}">
                            <span class="dash-micon">
                                <i class="ti ti-browser"></i>
                            </span>
                            <span class="dash-mtext">{{ __('Domain Requests') }}</span>
                        </a>
                    </li>

                    @can('Manage Email Template')
                        <li
                            class="dash-item dash-hasmenu {{ Request::route()->getName() == 'manage.email.language' || Request::route()->getName() == 'manage.email.language' ? ' active dash-trigger' : 'collapsed' }}">
                            <a href="{{ route('email_templates.index') }}"
                                class="dash-link {{ request()->is('email_template') ? 'active' : '' }}">
                                <span class="dash-micon">
                                    <i class="ti ti-mail"></i>
                                </span>
                                <span class="dash-mtext">{{ __('Email Templates') }}</span>
                            </a>
                        </li>
                    @endcan
                    @include('landingpage::menu.landingpage')
                    @can('Manage Settings')
                        <li class="dash-item dash-hasmenu {{ Request::segment(1) == 'settings' || Request::route()->getName() == 'store.editproducts' ? ' active dash-trigger' : 'collapsed' }}">
                            <a href="{{ route('settings') }}" class="dash-link {{ request()->is('settings') ? 'active' : '' }}">
                                <span class="dash-micon">
                                    <i class="ti ti-settings"></i>
                                </span>
                                <span class="dash-mtext">
                                    @if (Auth::user()->type == 'super admin')
                                        {{ __('Settings') }}
                                    @else
                                        {{ __('Store Settings') }}
                                    @endif
                                </span>
                            </a>
                        </li>
                    @endcan
                @else
                    <li class="dash-item dash-hasmenu {{ Request::segment(1) == 'dashboard' || Request::segment(1) == 'storeanalytic' || Request::route()->getName() == 'orders.show' ? ' active dash-trigger' : 'collapsed' }}">
                        <a href="#!" class="dash-link ">
                            <span class="dash-micon">
                                <i class="ti ti-home"></i>
                            </span>
                            <span class="dash-mtext">{{ __('Dashboard') }}</span>
                            <span class="dash-arrow">
                                <i data-feather="chevron-right"></i>
                            </span>
                        </a>
                        <ul
                            class="dash-submenu {{ Request::segment(1) == 'dashboard' || Request::segment(1) == 'storeanalytic' ? ' show' : '' }}">
                            @can('Manage Dashboard')
                            <li class="dash-item {{ Request::route()->getName() == 'dashboard' ? ' active' : '' }}">
                                <a class="dash-link" href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a>
                            </li>
                            @endcan
                            @can('Manage Store Analytics')
                            <li class="dash-item {{ Request::route()->getName() == 'storeanalytic' ? ' active' : '' }}">
                                <a class="dash-link"
                                    href="{{ route('storeanalytic') }}">{{ __('Store Analytics') }}</a>
                            </li>
                            @endcan
                            @can('Manage Orders')
                                <li class="dash-item {{ Request::segment(1) == 'orders.index' || Request::route()->getName() == 'orders.show' ? ' active dash-trigger' : 'collapsed' }}">
                                    <a class="dash-link" href="{{ route('orders.index') }}">{{ __('Orders') }}</a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                    @can('Manage Themes')
                        <li class="dash-item {{ Request::segment(1) == 'themes' ? ' active' : 'collapsed' }}">
                            <a href="{{ route('themes.theme') }}"
                                class="dash-link {{ request()->is('themes') ? 'active' : '' }}">
                                <span class="dash-micon">
                                    <i class="ti ti-layout-2"></i>
                                </span>
                                <span class="dash-mtext">{{ __('Themes') }}</span>
                            </a>
                        </li>
                    @endcan
                    @canany(['Manage Role', 'Manage User'])
                        <li class="dash-item dash-hasmenu {{ Request::segment(1) == 'users' || Request::segment(1) == 'roles' ? ' active dash-trigger' : 'collapsed' }}">
                            <a href="#!" class="dash-link ">
                                <span class="dash-micon">
                                    <i class="ti ti-users"></i>
                                </span>
                                <span class="dash-mtext">{{ __('Staff') }}</span>
                                <span class="dash-arrow">
                                    <i data-feather="chevron-right"></i>
                                </span>
                            </a>
                            <ul class="dash-submenu {{ Request::segment(1) == 'roles' || Request::segment(1) == 'roles' ? ' show' : '' }}">
                                @can('Manage Role')
                                    <li class="dash-item {{ Request::route()->getName() == 'roles' ? ' active' : '' }}">
                                        <a class="dash-link"
                                            href="{{ route('roles.index') }}">{{ __('Roles') }}</a>
                                    </li>
                                @endcan
                                @can('Manage User')
                                    <li
                                        class="dash-item {{ Request::segment(1) == 'users.index' || Request::route()->getName() == 'users.show' ? ' active dash-trigger' : 'collapsed' }}">
                                        <a class="dash-link" href="{{ route('users.index') }}">{{ __('User') }}</a>
                                    </li>
                                @endcan
                            </ul>
                        </li>
                    @endcanany
                    @can('Manage Pos')
                        <li class="dash-item {{ Request::segment(1) == 'pos' ? ' active' : 'collapsed' }}">
                            <a href="{{ route('pos.index') }}"
                                class="dash-link {{ request()->is('themes') ? 'active' : '' }}">
                                <span class="dash-micon">
                                    <i class="ti ti-layers-difference"></i>
                                </span>
                                <span class="dash-mtext">{{ __('Pos') }}</span>
                            </a>
                        </li>
                    @endcan
                    @canany([
                        'Manage Products',
                        'Manage Product category',
                        'Manage Product Tax',
                        'Manage Product Coupan',
                        'Manage Subscriber',
                        'Manage Shipping',
                        'Manage Custom Page',
                        'Manage Blog',
                        'Manage Testimonial'
                    ])
                        <li class="dash-item dash-hasmenu {{ Request::segment(1) == 'product' || Request::segment(1) == 'product_categorie' || Request::segment(1) == 'product_tax' || Request::segment(1) == 'product-coupon' || Request::segment(1) == 'shipping' || Request::segment(1) == 'subscriptions' || Request::segment(1) == 'custom-page' || Request::segment(1) == 'blog' || Request::segment(1) == 'products' ? ' active dash-trigger' : 'collapsed' }}">
                            <a href="#!" class="dash-link">
                                <span class="dash-micon">
                                    <i class="ti ti-license"></i>
                                </span>
                                <span class="dash-mtext">{{ __('Shop') }}</span>
                                <span class="dash-arrow">
                                    <i data-feather="chevron-right"></i>
                                </span>
                            </a>
                            <ul class="dash-submenu {{ Request::segment(1) == 'product.index' ? ' show' : '' }}">
                                @can('Manage Products')
                                    <li
                                        class="dash-item {{ Request::route()->getName() == 'product.index' || Request::route()->getName() == 'product.create' || Request::route()->getName() == 'product.edit' || Request::route()->getName() == 'product.show' || Request::route()->getName() == 'product.grid' ? ' active' : '' }}">
                                        <a class="dash-link" href="{{ route('product.index') }}">{{ __('Products') }}</a>
                                    </li>
                                @endcan
                                @can('Manage Product category')
                                    <li
                                        class="dash-item {{ Request::route()->getName() == 'product_categorie.index' ? ' active' : '' }}">
                                        <a class="dash-link"
                                            href="{{ route('product_categorie.index') }}">{{ __('Product Category') }}</a>
                                    </li>
                                @endcan
                                @can('Manage Product Tax')
                                    <li
                                        class="dash-item {{ Request::route()->getName() == 'product_tax.index' ? ' active' : '' }}">
                                        <a class="dash-link"
                                            href="{{ route('product_tax.index') }}">{{ __('Product Tax') }}</a>
                                    </li>
                                @endcan
                                @can('Manage Product Coupan')
                                    <li
                                        class="dash-item {{ Request::route()->getName() == 'product-coupon.index' || Request::route()->getName() == 'product-coupon.show' ? ' active' : '' }}">
                                        <a class="dash-link"
                                            href="{{ route('product-coupon.index') }}">{{ __('Product Coupon') }}</a>
                                    </li>
                                @endcan
                                @can('Manage Subscriber')
                                    <li
                                        class="dash-item {{ Request::route()->getName() == 'subscriptions.index' ? ' active' : '' }}">
                                        <a class="dash-link"
                                            href="{{ route('subscriptions.index') }}">{{ __('Subscriber') }}</a>
                                    </li>
                                @endcan
                                @if (isset($plan->shipping_method) && $plan->shipping_method == 'on')
                                    @can('Manage Shipping')
                                        <li
                                            class="dash-item {{ Request::route()->getName() == 'shipping.index' ? ' active' : '' }}">
                                            <a class="dash-link" href="{{ route('shipping.index') }}">{{ __('Shipping') }}</a>
                                        </li>
                                    @endcan
                                @endif
                                @if (isset($plan->additional_page) && $plan->additional_page == 'on')
                                    @can('Manage Custom Page')
                                        <li
                                            class="dash-item {{ Request::route()->getName() == 'custom-page.index' ? ' active' : '' }}">
                                            <a class="dash-link"
                                                href="{{ route('custom-page.index') }}">{{ __('Custom Page') }}</a>
                                        </li>
                                    @endcan
                                @endif
                                @if (isset($plan->blog) && $plan->blog == 'on')
                                    @can('Manage Blog')
                                        <li
                                            class="dash-item {{ Request::route()->getName() == 'blog.index' ? ' active' : '' }}">
                                            <a class="dash-link" href="{{ route('blog.index') }}">{{ __('Blog') }}</a>
                                        </li>
                                    @endcan
                                @endif
                                @can('Manage Testimonial')
                                    <li
                                        class="dash-item {{ Request::route()->getName() == 'testimonial.index' ? ' active' : '' }}">
                                        <a class="dash-link" href="{{ route('testimonial.index') }}">{{ __('Testimonial') }}</a>
                                    </li>
                                @endcan
                            </ul>
                        </li>
                    @endcanany
                    @can('Manage Customers')
                        <li
                            class="dash-item {{ Request::segment(1) == 'customer.index' || Request::route()->getName() == 'customer.show' ? ' active dash-trigger ' : 'collapsed' }}">
                            <a href="{{ route('customer.index') }}"
                                class="dash-link {{ request()->is('customer.index') ? 'active' : '' }}">
                                <span class="dash-micon">
                                    <i class="ti ti-user"></i>
                                </span>
                                <span class="dash-mtext">{{ __('Customers') }}</span>
                            </a>
                        </li>
                    @endcan
                    @can('Manage Plans')
                        <li class="dash-item dash-hasmenu {{ Request::segment(1) == 'plans' || Request::route()->getName() == 'stripe' ? ' active dash-trigger' : 'collapsed' }}">
                            <a href="{{ route('plans.index') }}"
                                class="dash-link {{ request()->is('plans') ? 'active' : '' }}">
                                <span class="dash-micon">
                                    <i class="ti ti-trophy"></i>
                                </span>
                                <span class="dash-mtext">{{ __('Plans') }}</span>
                            </a>
                        </li>
                    @endcan

                    @if (Auth::user()->type == 'Owner')
                        <li class="dash-item dash-hasmenu  {{ Request::segment(1) == 'referral-program' ? 'active' : '' }}">
                            <a href="{{ route('referral-program.company') }}" class="dash-link">
                                <span class="dash-micon"><i class="ti ti-discount-2"></i></span><span
                                    class="dash-mtext">{{ __('Referral Program') }}</span>
                            </a>
                        </li>
                    @endif

                    @can('Manage Settings')
                    <li class="dash-item dash-hasmenu {{ Request::segment(1) == 'settings' || Request::route()->getName() == 'store.editproducts' ? ' active dash-trigger' : 'collapsed' }}">
                            <a href="{{ route('settings') }}" class="dash-link {{ request()->is('settings') ? 'active' : '' }}">
                                <span class="dash-micon">
                                    <i class="ti ti-settings"></i>
                                </span>
                                <span class="dash-mtext">
                                    @if (Auth::user()->type == 'super admin')
                                        {{ __('Settings') }}
                                    @else
                                        {{ __('Store Settings') }}
                                    @endif
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
  /* container collapsed / expand on hover */
  nav.dash-sidebar.light-sidebar {
    width: 60px !important;
    background: linear-gradient(180deg, #1f1f1f 0%, #151515 100%) !important;
    overflow: hidden !important;
    transition: width .3s ease !important;
    border-radius: 0 8px 8px 0 !important;
    box-shadow: 2px 0 8px rgba(0,0,0,.5) !important;
  }
  nav.dash-sidebar.light-sidebar:hover {
    width: 220px !important;
  }

  /* logo centralizado */
  nav.dash-sidebar .m-header {
    padding: 16px 0 !important;
    text-align: center !important;
  }
  nav.dash-sidebar .logo-lg {
    height: 32px !important;
    width: auto !important;
    display: inline-block !important;
  }

  /* itens em coluna, sem texto */
  nav.dash-sidebar .dash-link {
    display: flex !important;
    align-items: center !important;
    padding: 12px !important;
    position: relative !important;
  }
  /* ícone */
  nav.dash-sidebar .dash-micon {
    width: 36px !important;
    text-align: center !important;
    color: #ccc !important;
  }
  /* texto escondido quando está colapsado */
  nav.dash-sidebar .dash-mtext {
    margin-left: 12px !important;
    white-space: nowrap !important;
    opacity: 0 !important;
    transition: opacity .2s ease, transform .2s ease !important;
    transform: translateX(-10px) !important;
    color: #fff !important;
  }
  /* texto aparece ao passar o mouse */
  nav.dash-sidebar.light-sidebar:hover .dash-mtext {
    opacity: 1 !important;
    transform: translateX(0) !important;
  }

  /* destaque no item ativo */
  nav.dash-sidebar .dash-item.active > .dash-link {
    background: rgba(255, 125, 0, .2) !important;
    border-radius: 6px !important;
  }
  nav.dash-sidebar .dash-item.active .dash-micon,
  nav.dash-sidebar .dash-item.active .dash-mtext {
    color: #ff7d00 !important;
  }

  /* setinhas de submenu reposicionadas */
  nav.dash-sidebar .dash-arrow {
    position: absolute !important;
    right: 16px !important;
    opacity: 0 !important;
    transition: opacity .2s !important;
  }
  nav.dash-sidebar.light-sidebar:hover .dash-arrow {
    opacity: 1 !important;
  }

  /* submenu flutuante */
  nav.dash-sidebar .dash-submenu {
    position: absolute !important;
    left: 100% !important;
    top: 0 !important;
    width: 180px !important;
    background: #1a1a1a !important;
    border-radius: 6px !important;
    padding: 8px 0 !important;
    box-shadow: 2px 2px 8px rgba(0,0,0,.5) !important;
    display: none !important;
  }
  nav.dash-sidebar .dash-item:hover > .dash-submenu {
    display: block !important;
  }

  /* espaçamento entre grupos */
  nav.dash-sidebar .navbar-content > ul > li:nth-child(1),
  nav.dash-sidebar .navbar-content > ul > li:nth-child(5),
  nav.dash-sidebar .navbar-content > ul > li:nth-child(9) {
    margin-top: 16px !important;
    border-top: 1px solid rgba(255,255,255,.1) !important;
    padding-top: 16px !important;
  }
</style>

