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
<!-- 
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
                    @endcan -->

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
                    <!-- @can('Manage Settings')
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
                    @endcan -->
                @else



<li class="menu-title" style="margin-left: 28px;">INICIO</li>
             
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
            <a class="dash-link" href="{{ route('dashboard') }}">Inicio</a>
        </li>
        @endcan
        @can('Manage Store Analytics')
        <li class="dash-item {{ Request::route()->getName() == 'storeanalytic' ? ' active' : '' }}">
            <a class="dash-link"
                href="{{ route('storeanalytic') }}">Estatisticas</a>
        </li>
        @endcan
            <li class="dash-item {{ Request::segment(1) == 'orders.index' || Request::route()->getName() == 'orders.show' ? ' active dash-trigger' : 'collapsed' }}">
                <a class="dash-link" href="/academy">Academy</a>
            </li>
  
        <!-- @can('Manage Orders')
            <li class="dash-item {{ Request::segment(1) == 'orders.index' || Request::route()->getName() == 'orders.show' ? ' active dash-trigger' : 'collapsed' }}">
                <a class="dash-link" href="{{ route('orders.index') }}">Pedidos</a>
            </li>
        @endcan -->
    </ul>
</li>
<!-- @can('Manage Themes')
    <li class="dash-item {{ Request::segment(1) == 'themes' ? ' active' : 'collapsed' }}">
        <a href="{{ route('themes.theme') }}"
            class="dash-link {{ request()->is('themes') ? 'active' : '' }}">
            <span class="dash-micon">
                <i class="ti ti-layout-2"></i>
            </span>
            <span class="dash-mtext">{{ __('Themes') }}</span>
        </a>
    </li>
@endcan  -->
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

<!-- @can('Manage Plans')
    <li class="dash-item dash-hasmenu {{ Request::segment(1) == 'plans' || Request::route()->getName() == 'stripe' ? ' active dash-trigger' : 'collapsed' }}">
        <a href="{{ route('plans.index') }}"
            class="dash-link {{ request()->is('plans') ? 'active' : '' }}">
            <span class="dash-micon">
                <i class="ti ti-trophy"></i>
            </span>
            <span class="dash-mtext">{{ __('Plans') }}</span>
        </a>
    </li>
@endcan -->

@if (Auth::user()->type == 'Owner')
    <!-- <li class="dash-item dash-hasmenu  {{ Request::segment(1) == 'referral-program' ? 'active' : '' }}">
        <a href="{{ route('referral-program.company') }}" class="dash-link">
            <span class="dash-micon"><i class="ti ti-discount-2"></i></span><span
                class="dash-mtext">{{ __('Referral Program') }}</span>
        </a>
    </li> -->
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

<li class="menu-title" style="margin-left: 28px;">APLICATIVOS</li>

<li class="dash-item {{ Request::segment(1) == 'aplicativos' ? ' active' : 'collapsed' }}">
    <a href="{{ route('aplicativos.index') }}" class="dash-link {{ request()->is('aplicativos') ? 'active' : '' }}">
        <span class="dash-micon"><i class="ti ti-apps"></i></span>
        <span class="dash-mtext">{{ __('Aplicativos') }}</span>
    </a>
</li>

<li class="dash-item">
    <a href="#" class="dash-link">
        <span class="dash-micon"><i class="ti ti-bookmark"></i></span>
        <span class="dash-mtext">Favoritos</span>
    </a>
</li>

<li class="dash-item dash-hasmenu collapsed">
    <a href="#!" class="dash-link">
        <span class="dash-micon"><i class="ti ti-star"></i></span>
        <span class="dash-mtext">Avaliações</span>
        <span class="dash-arrow"><i data-feather="chevron-right"></i></span>
    </a>
    <ul class="dash-submenu">
        <li class="dash-item">
            <a class="dash-link" href="#">Todas Avaliações</a>
        </li>
    </ul>
</li>

<li class="dash-item dash-hasmenu collapsed">
    <a href="#!" class="dash-link">
        <span class="dash-micon"><i class="ti ti-refresh"></i></span>
        <span class="dash-mtext">Trocas e devoluções</span>
        <span class="dash-arrow"><i data-feather="chevron-right"></i></span>
    </a>
    <ul class="dash-submenu">
        <li class="dash-item">
            <a class="dash-link" href="#">Listar trocas/devoluções</a>
        </li>
    </ul>
</li>

<li class="dash-item dash-hasmenu collapsed">
    <a href="#!" class="dash-link">
        <span class="dash-micon"><i class="ti ti-video"></i></span>
        <span class="dash-mtext">Video commerce</span>
        <span class="dash-arrow"><i data-feather="chevron-right"></i></span>
    </a>
    <ul class="dash-submenu">
        <li class="dash-item">
            <a class="dash-link" href="#">Configurar vídeos</a>
        </li>
    </ul>
</li>

<li class="dash-item dash-hasmenu collapsed">
    <a href="#!" class="dash-link">
        <span class="dash-micon"><i class="ti ti-message-circle"></i></span>
        <span class="dash-mtext">Comentários</span>
        <span class="dash-arrow"><i data-feather="chevron-right"></i></span>
    </a>
    <ul class="dash-submenu">
        <li class="dash-item">
            <a class="dash-link" href="#">Todos Comentários</a>
        </li>
    </ul>
</li>


<li class="dash-item dash-hasmenu collapsed">
    <a href="#!" class="dash-link">
        <span class="dash-micon"><i data-feather="zap"></i></span>
        <span class="dash-mtext">Izi Lead</span>
        <span class="dash-arrow"><i data-feather="chevron-right"></i></span>
    </a>
    <ul class="dash-submenu">
        <li class="dash-item">
            <a class="dash-link" href="#">Dashboard</a>
        </li>
    </ul>
</li>

<li class="dash-item dash-hasmenu collapsed">
    <a href="#!" class="dash-link">
       <span class="dash-micon"><i data-feather="star"></i></span>
        <span class="dash-mtext">Izi Review</span>
        <span class="dash-arrow"><i data-feather="chevron-right"></i></span>
    </a>
    <ul class="dash-submenu">
        <li class="dash-item">
            <a class="dash-link" href="{{ route('review.index') }}">Dashboard</a>
        </li>
        <li class="dash-item">
            <a class="dash-link" href="{{ route('review.campanhas') }}">Campanhas</a>
        </li>
        <li class="dash-item">
            <a class="dash-link" href="{{ route('review.perguntas') }}">Avaliações e Perguntas</a>
        </li>
        <li class="dash-item">
            <a class="dash-link" href="{{ route('review.extracao') }}">Extração de Comentários</a>
        </li>
    </ul>
</li>



{{-- === VENDAS === --}}
<li class="menu-title" style="margin-left: 28px;">VENDAS</li>

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

<li class="dash-item dash-hasmenu collapsed">
    <a href="#!" class="dash-link">
        <span class="dash-micon"><i class="ti ti-shopping-cart"></i></span>
        <span class="dash-mtext">Pedidos</span>
        <span class="dash-arrow"><i data-feather="chevron-right"></i></span>
    </a>
    <ul class="dash-submenu">
        <li class="dash-item">
            <a class="dash-link" href="#">Todos Pedidos</a>
        </li>
    </ul>
</li>

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
            <span class="dash-mtext">Produtos</span>
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
            <!-- @can('Manage Subscriber')
                <li
                    class="dash-item {{ Request::route()->getName() == 'subscriptions.index' ? ' active' : '' }}">
                    <a class="dash-link"
                        href="{{ route('subscriptions.index') }}">{{ __('Subscriber') }}</a>
                </li>
            @endcan -->
            <!-- @if (isset($plan->shipping_method) && $plan->shipping_method == 'on')
                @can('Manage Shipping')
                    <li
                        class="dash-item {{ Request::route()->getName() == 'shipping.index' ? ' active' : '' }}">
                        <a class="dash-link" href="{{ route('shipping.index') }}">{{ __('Shipping') }}</a>
                    </li>
                @endcan
            @endif -->
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
            <!-- @can('Manage Testimonial')
                <li
                    class="dash-item {{ Request::route()->getName() == 'testimonial.index' ? ' active' : '' }}">
                    <a class="dash-link" href="{{ route('testimonial.index') }}">{{ __('Testimonial') }}</a>
                </li>
            @endcan -->
        </ul>
    </li>
@endcanany


<li class="dash-item">
    <a href="#" class="dash-link">
        <span class="dash-micon"><i class="ti ti-tag"></i></span>
        <span class="dash-mtext">Promoções</span>
    </a>
</li>

{{-- === CANAIS === --}}
<li class="menu-title" style="margin-left: 28px;">CANAIS</li>
<li class="dash-item disabled">
    <a href="#" class="dash-link disabled-link" onclick="return false;">
        <span class="dash-micon"><i class="ti ti-truck-delivery"></i></span>
        <span class="dash-mtext">Dropshipping</span>
        <span class="lock-icon"><i class="ti ti-lock"></i></span>
    </a>
</li>
<li class="dash-item disabled">
    <a href="#" class="dash-link disabled-link" onclick="return false;">
        <span class="dash-micon"><i class="ti ti-building-store"></i></span>
        <span class="dash-mtext">Trade by Fidelize</span>
        <span class="lock-icon"><i class="ti ti-lock"></i></span>
    </a>
</li>
<li class="dash-item disabled">
    <a href="#" class="dash-link disabled-link" onclick="return false;">
        <span class="dash-micon"><i class="ti ti-building-factory"></i></span>
        <span class="dash-mtext">Venda B2B</span>
        <span class="lock-icon"><i class="ti ti-lock"></i></span>
    </a>
</li>

{{-- === SUA LOJA === --}}
<li class="menu-title" style="margin-left: 28px;">SUA LOJA</li>
<li class="dash-item disabled">
    <a href="#" class="dash-link disabled-link" onclick="return false;">
        <span class="dash-micon"><i class="ti ti-layout-grid"></i></span>
        <span class="dash-mtext">Vitrine de recomendação</span>
        <span class="lock-icon"><i class="ti ti-lock"></i></span>
    </a>
</li>
<li class="dash-item disabled">
    <a href="#" class="dash-link disabled-link" onclick="return false;">
        <span class="dash-micon"><i class="ti ti-apps"></i></span>
        <span class="dash-mtext">Gerenciador de Widgets e apps</span>
        <span class="lock-icon"><i class="ti ti-lock"></i></span>
    </a>
</li>

<li class="menu-title" style="margin-left: 28px;">REDES SOCIAIS</li>
<li class="dash-item disabled">
    <a href="#" class="dash-link disabled-link" onclick="return false;">
        <span class="dash-micon"><i class="ti ti-brand-instagram"></i></span>
        <span class="dash-mtext">Instagram</span>
        <span class="lock-icon"><i class="ti ti-lock"></i></span>
    </a>
</li>
<li class="dash-item disabled">
    <a href="#" class="dash-link disabled-link" onclick="return false;">
        <span class="dash-micon"><i class="ti ti-brand-tiktok"></i></span>
        <span class="dash-mtext">TikTok</span>
        <span class="lock-icon"><i class="ti ti-lock"></i></span>
    </a>
</li>

{{-- === ATENDIMENTO === --}}
<li class="menu-title" style="margin-left: 28px;">ATENDIMENTO</li>
<li class="dash-item disabled">
    <a href="#" class="dash-link disabled-link" onclick="return false;">
        <span class="dash-micon"><i class="ti ti-headset"></i></span>
        <span class="dash-mtext">CRM omnichannel</span>
        <span class="lock-icon"><i class="ti ti-lock"></i></span>
    </a>
</li>

{{-- === AUTOMAÇÕES === --}}
<li class="menu-title" style="margin-left: 28px;">AUTOMAÇÕES</li>
<li class="dash-item disabled">
    <a href="#" class="dash-link disabled-link" onclick="return false;">
        <span class="dash-micon"><i class="ti ti-bell"></i></span>
        <span class="dash-mtext">Notificações Manuais</span>
        <span class="lock-icon"><i class="ti ti-lock"></i></span>
    </a>
</li>
<li class="dash-item disabled">
    <a href="#" class="dash-link disabled-link" onclick="return false;">
        <span class="dash-micon"><i class="ti ti-zap"></i></span>
        <span class="dash-mtext">Notificações inteligentes</span>
        <span class="badge badge-secondary ml-auto">AI</span>
        <span class="lock-icon"><i class="ti ti-lock"></i></span>
    </a>
</li>
<li class="dash-item disabled">
    <a href="#" class="dash-link disabled-link" onclick="return false;">
        <span class="dash-micon"><i class="ti ti-settings"></i></span>
        <span class="dash-mtext">Configurações</span>
        <span class="lock-icon"><i class="ti ti-lock"></i></span>
    </a>
</li>

{{-- === EXTRAS === --}}
<li class="menu-title" style="margin-left: 28px;">EXTRAS</li>
<li class="dash-item disabled">
    <a href="#" class="dash-link disabled-link" onclick="return false;">
        <span class="dash-micon"><i class="ti ti-gift"></i></span>
        <span class="dash-mtext">Recompensas</span>
        <span class="lock-icon"><i class="ti ti-lock"></i></span>
    </a>
</li>


                @endif
            </ul>

        </div>
    </div>
</nav>

<style>
body .dash-sidebar.light-sidebar .dash-link .dash-micon {
    background-color: #25252900;
    box-shadow: -3px 4px 23px rgba(0, 0, 0, 0.1);
}

/* CSS original que faz o link virar laranja */
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

/* <—– Coloque este bloco logo em seguida: */
body.custom-color .dash-sidebar.light-sidebar .dash-navbar > .dash-item.active > .dash-link .dash-micon,
body.custom-color .dash-sidebar.light-sidebar .dash-navbar > .dash-item:active > .dash-link .dash-micon,
body.custom-color .dash-sidebar.light-sidebar .dash-navbar > .dash-item:focus > .dash-link .dash-micon,
body.custom-color .dash-sidebar.light-sidebar .dash-navbar > .dash-item:hover > .dash-link .dash-micon,
body.custom-color .dash-sidebar .dash-navbar > .dash-item.active > .dash-link .dash-micon,
body.custom-color .dash-sidebar .dash-navbar > .dash-item:active > .dash-link .dash-micon,
body.custom-color .dash-sidebar .dash-navbar > .dash-item:focus > .dash-link .dash-micon,
body.custom-color .dash-sidebar .dash-navbar > .dash-item:hover > .dash-link .dash-micon {
  background-color:#fa6b2a;
  /* ajuste o box-shadow se quiser outro estilo no ícone */
  color: #fff;
  box-shadow: -3px 4px 23px rgba(0, 0, 0, 0);
}

body.custom-color .dash-sidebar.light-sidebar .dash-navbar > .dash-item.active > .dash-link i, body.custom-color .dash-sidebar.light-sidebar .dash-navbar > .dash-item:active > .dash-link i, body.custom-color .dash-sidebar.light-sidebar .dash-navbar > .dash-item:focus > .dash-link i, body.custom-color .dash-sidebar.light-sidebar .dash-navbar > .dash-item:hover > .dash-link i, body.custom-color .dash-sidebar .dash-navbar > .dash-item.active > .dash-link i, body.custom-color .dash-sidebar .dash-navbar > .dash-item:active > .dash-link i, body.custom-color .dash-sidebar .dash-navbar > .dash-item:focus > .dash-link i, body.custom-color .dash-sidebar .dash-navbar > .dash-item:hover > .dash-link i {
    color: #ffffff;
}

.dash-sidebar.light-sidebar .dash-navbar > .dash-item > .dash-link {
    border-radius: 5px;
    margin-left: 15px;
    margin-right: 15px;
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
    vertical-align: middle;
}

.fix-logo {
    height: 40px;
    width: 120px;
}
</style>

