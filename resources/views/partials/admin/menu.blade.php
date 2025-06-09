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

                {{-- SUPER ADMIN --}}
                @if (Auth::user()->type == 'super admin')
                    @can('Manage Dashboard')
                        <li class="dash-item {{ Request::segment(1)=='dashboard' ? ' active' : 'collapsed' }}">
                            <a href="{{ route('dashboard') }}" class="dash-link {{ request()->is('dashboard') ? 'active' : '' }}">
                                <span class="dash-micon"><i class="ti ti-home"></i></span>
                                <span class="dash-mtext">{{ __('Dashboard') }}</span>
                            </a>
                        </li>
                    @endcan

                    @can('Manage Store')
                        <li class="dash-item dash-hasmenu {{ Request::segment(1)=='store-resource' || Request::route()->getName()=='store.grid' ? ' active dash-trigger' : 'collapsed' }}">
                            <a href="{{ route('store-resource.index') }}" class="dash-link {{ request()->is('store-resource') ? 'active' : '' }}">
                                <span class="dash-micon"><i class="ti ti-user"></i></span>
                                <span class="dash-mtext">{{ __('Stores') }}</span>
                            </a>
                        </li>
                    @endcan

                    @can('Manage Coupans')
                        <li class="dash-item dash-hasmenu {{ Request::segment(1)=='coupons' ? ' active' : 'collapsed' }}">
                            <a href="{{ route('coupons.index') }}" class="dash-link {{ request()->is('coupons') ? 'active' : '' }}">
                                <span class="dash-micon"><i class="ti ti-tag"></i></span>
                                <span class="dash-mtext">{{ __('Coupons') }}</span>
                            </a>
                        </li>
                    @endcan

                    @can('Manage Plans')
                        <li class="dash-item dash-hasmenu {{ Request::segment(1)=='plans' || Request::route()->getName()=='stripe' ? ' active dash-trigger' : 'collapsed' }}">
                            <a href="{{ route('plans.index') }}" class="dash-link {{ request()->is('plans') ? 'active' : '' }}">
                                <span class="dash-micon"><i class="ti ti-trophy"></i></span>
                                <span class="dash-mtext">{{ __('Plans') }}</span>
                            </a>
                        </li>
                    @endcan

                    @can('Manage Plan Request')
                        <li class="dash-item dash-hasmenu {{ Request::segment(1)=='plan_request' ? ' active' : 'collapsed' }}">
                            <a href="{{ route('plan_request.index') }}" class="dash-link {{ request()->is('plan_request') ? 'active' : '' }}">
                                <span class="dash-micon"><i class="ti ti-brand-telegram"></i></span>
                                <span class="dash-mtext">{{ __('Plan Requests') }}</span>
                            </a>
                        </li>
                    @endcan

                    <li class="dash-item dash-hasmenu {{ Request::segment(1)=='referral-program' ? 'active' : '' }}">
                        <a href="{{ route('referral-program.index') }}" class="dash-link">
                            <span class="dash-micon"><i class="ti ti-discount-2"></i></span>
                            <span class="dash-mtext">{{ __('Referral Program') }}</span>
                        </a>
                    </li>

                    <li class="dash-item dash-hasmenu {{ Request::segment(1)=='custom_domain_request' ? ' active' : 'collapsed' }}">
                        <a href="{{ route('custom_domain_request.index') }}" class="dash-link {{ request()->is('custom_domain_request') ? 'active' : '' }}">
                            <span class="dash-micon"><i class="ti ti-browser"></i></span>
                            <span class="dash-mtext">{{ __('Domain Requests') }}</span>
                        </a>
                    </li>

                    @can('Manage Email Template')
                        <li class="dash-item dash-hasmenu {{ Request::route()->getName()=='manage.email.language' ? ' active dash-trigger' : 'collapsed' }}">
                            <a href="{{ route('email_templates.index') }}" class="dash-link {{ request()->is('email_template') ? 'active' : '' }}">
                                <span class="dash-micon"><i class="ti ti-mail"></i></span>
                                <span class="dash-mtext">{{ __('Email Templates') }}</span>
                            </a>
                        </li>
                    @endcan

                    @include('landingpage::menu.landingpage')

                    @can('Manage Settings')
                        <li class="dash-item dash-hasmenu {{ Request::segment(1)=='settings' || Request::route()->getName()=='store.editproducts' ? ' active dash-trigger' : 'collapsed' }}">
                            <a href="{{ route('settings') }}" class="dash-link {{ request()->is('settings') ? 'active' : '' }}">
                                <span class="dash-micon"><i class="ti ti-settings"></i></span>
                                <span class="dash-mtext">
                                    {{ Auth::user()->type=='super admin' ? __('Settings') : __('Store Settings') }}
                                </span>
                            </a>
                        </li>
                    @endcan

                {{-- COMMON USERS --}}
                @else

                    {{-- Dashboard/Submenu --}}
                    <li class="dash-item dash-hasmenu {{ Request::segment(1)=='dashboard' || Request::segment(1)=='storeanalytic' || Request::route()->getName()=='orders.show' ? ' active dash-trigger' : 'collapsed' }}">
                        <a href="#!" class="dash-link">
                            <span class="dash-micon"><i class="ti ti-home"></i></span>
                            <span class="dash-mtext">{{ __('Dashboard') }}</span>
                            <span class="dash-arrow"><i data-feather="chevron-right"></i></span>
                        </a>
                        <ul class="dash-submenu {{ Request::segment(1)=='dashboard' || Request::segment(1)=='storeanalytic' ? ' show' : '' }}">
                            @can('Manage Dashboard')
                                <li class="dash-item {{ Request::route()->getName()=='dashboard' ? ' active' : '' }}">
                                    <a href="{{ route('dashboard') }}" class="dash-link">{{ __('Dashboard') }}</a>
                                </li>
                            @endcan
                            @can('Manage Store Analytics')
                                <li class="dash-item {{ Request::route()->getName()=='storeanalytic' ? ' active' : '' }}">
                                    <a href="{{ route('storeanalytic') }}" class="dash-link">{{ __('Store Analytics') }}</a>
                                </li>
                            @endcan
                            @can('Manage Orders')
                                <li class="dash-item {{ Request::segment(1)=='orders.index' || Request::route()->getName()=='orders.show' ? ' active' : '' }}">
                                    <a href="{{ route('orders.index') }}" class="dash-link">{{ __('Orders') }}</a>
                                </li>
                            @endcan
                        </ul>
                    </li>

                    {{-- Themes --}}
                    @can('Manage Themes')
                        <li class="dash-item {{ Request::segment(1)=='themes' ? ' active' : 'collapsed' }}">
                            <a href="{{ route('themes.theme') }}" class="dash-link {{ request()->is('themes') ? 'active' : '' }}">
                                <span class="dash-micon"><i class="ti ti-layout-2"></i></span>
                                <span class="dash-mtext">{{ __('Themes') }}</span>
                            </a>
                        </li>
                    @endcan

                    {{-- STAFF (USUÁRIOS) --}}
                    @canany(['Manage Role','Manage User'])
                        <li class="dash-item dash-hasmenu {{ Request::segment(1)=='users' ? ' active dash-trigger' : 'collapsed' }}">
                          <a href="#!" class="dash-link">
                            <span class="dash-micon"><i class="ti ti-users"></i></span>
                            <span class="dash-mtext">{{ __('Staff') }}</span>
                            <span class="dash-arrow"><i data-feather="chevron-right"></i></span>
                          </a>
                          <ul class="dash-submenu {{ Request::segment(1)=='users' ? ' show' : '' }}">

                            {{-- Roles / Users --}}
                            @can('Manage Role')
                              <li class="dash-item {{ Request::route()->getName()=='roles.index' ? ' active' : '' }}">
                                <a href="{{ route('roles.index') }}" class="dash-link">{{ __('Roles') }}</a>
                              </li>
                            @endcan
                            @can('Manage User')
                              <li class="dash-item {{ Request::route()->getName()=='users.index' ? ' active' : '' }}">
                                <a href="{{ route('users.index') }}" class="dash-link">{{ __('Users') }}</a>
                              </li>
                            @endcan

                            {{-- APLICATIVOS --}}
                            <li class="menu-label">{{ __('APLICATIVOS') }}</li>
                            <li class="dash-item">
                              <a href="#" class="dash-link disabled" aria-disabled="true">
                                <span class="dash-micon"><i class="ti ti-bookmark"></i></span>
                                <span class="dash-mtext">{{ __('Favoritos') }}</span>
                              </a>
                            </li>
                            <li class="dash-item dash-hasmenu collapsed">
                              <a href="#" class="dash-link disabled" aria-disabled="true">
                                <span class="dash-micon"><i class="ti ti-star"></i></span>
                                <span class="dash-mtext">{{ __('Avaliações') }}</span>
                                <span class="dash-arrow"><i data-feather="chevron-right"></i></span>
                              </a>
                              <ul class="dash-submenu"></ul>
                            </li>
                            <li class="dash-item dash-hasmenu collapsed">
                              <a href="#" class="dash-link disabled" aria-disabled="true">
                                <span class="dash-micon"><i class="ti ti-refresh"></i></span>
                                <span class="dash-mtext">{{ __('Trocas e devoluções') }}</span>
                                <span class="dash-arrow"><i data-feather="chevron-right"></i></span>
                              </a>
                              <ul class="dash-submenu"></ul>
                            </li>
                            <li class="dash-item dash-hasmenu collapsed">
                              <a href="#" class="dash-link disabled" aria-disabled="true">
                                <span class="dash-micon"><i class="ti ti-video"></i></span>
                                <span class="dash-mtext">{{ __('Vídeo commerce') }}</span>
                                <span class="dash-arrow"><i data-feather="chevron-right"></i></span>
                              </a>
                              <ul class="dash-submenu"></ul>
                            </li>
                            <li class="dash-item dash-hasmenu collapsed">
                              <a href="#" class="dash-link disabled" aria-disabled="true">
                                <span class="dash-micon"><i class="ti ti-message"></i></span>
                                <span class="dash-mtext">{{ __('Comentários') }}</span>
                                <span class="dash-arrow"><i data-feather="chevron-right"></i></span>
                              </a>
                              <ul class="dash-submenu"></ul>
                            </li>
                            <li class="dash-item dash-hasmenu collapsed">
                              <a href="#" class="dash-link disabled" aria-disabled="true">
                                <span class="dash-micon"><i class="ti ti-activity"></i></span>
                                <span class="dash-mtext">{{ __('Izi Lead') }}</span>
                                <span class="dash-arrow"><i data-feather="chevron-right"></i></span>
                              </a>
                              <ul class="dash-submenu"></ul>
                            </li>

                            {{-- CANAIS --}}
                            <li class="menu-label">{{ __('CANAIS') }}</li>
                            <li class="dash-item dash-hasmenu collapsed">
                              <a href="#" class="dash-link disabled" aria-disabled="true">
                                <span class="dash-micon"><i class="ti ti-layout-grid"></i></span>
                                <span class="dash-mtext">{{ __('Dropshipping') }}</span>
                                <span class="dash-arrow"><i data-feather="chevron-right"></i></span>
                              </a>
                              <ul class="dash-submenu">
                                <li class="dash-item"><a href="#" class="dash-link disabled">{{ __('Drop. Nacional') }}</a></li>
                                <li class="dash-item"><a href="#" class="dash-link disabled">{{ __('Drop. Internacional') }}</a></li>
                                <li class="dash-item"><a href="#" class="dash-link disabled">{{ __('Drop. com link') }}</a></li>
                              </ul>
                            </li>
                            <li class="dash-item dash-hasmenu collapsed">
                              <a href="#" class="dash-link disabled" aria-disabled="true">
                                <span class="dash-micon"><i class="ti ti-repeat"></i></span>
                                <span class="dash-mtext">{{ __('Trade by Fidelize') }}</span>
                                <span class="dash-arrow"><i data-feather="chevron-right"></i></span>
                              </a>
                              <ul class="dash-submenu">
                                <li class="dash-item"><a href="#" class="dash-link disabled">{{ __('Meus Compartilhamentos') }}</a></li>
                                <li class="dash-item"><a href="#" class="dash-link disabled">{{ __('Minha coleção de trade') }}</a></li>
                                <li class="dash-item"><a href="#" class="dash-link disabled">{{ __('Minhas listas') }}</a></li>
                              </ul>
                            </li>
                            <li class="dash-item dash-hasmenu collapsed">
                              <a href="#" class="dash-link disabled" aria-disabled="true">
                                <span class="dash-micon"><i class="ti ti-building-bank"></i></span>
                                <span class="dash-mtext">{{ __('Venda B2B') }}</span>
                                <span class="dash-arrow"><i data-feather="chevron-right"></i></span>
                              </a>
                              <ul class="dash-submenu">
                                <li class="dash-item"><a href="#" class="dash-link disabled">{{ __('Empresas') }}</a></li>
                                <li class="dash-item"><a href="#" class="dash-link disabled">{{ __('Catálogos') }}</a></li>
                              </ul>
                            </li>

                            {{-- SUA LOJA --}}
                            <li class="menu-label">{{ __('SUA LOJA') }}</li>
                            <li class="dash-item">
                              <a href="#" class="dash-link disabled" aria-disabled="true">
                                <span class="dash-micon"><i class="ti ti-window"></i></span>
                                <span class="dash-mtext">{{ __('Vitrine de recomendação') }}</span>
                              </a>
                            </li>
                            <li class="dash-item">
                              <a href="#" class="dash-link disabled" aria-disabled="true">
                                <span class="dash-micon"><i class="ti ti-stack"></i></span>
                                <span class="dash-mtext">{{ __('Gerenciador de Widgets e apps') }}</span>
                              </a>
                            </li>
                            <li class="dash-item">
                              <a href="#" class="dash-link disabled" aria-disabled="true">
                                <span class="dash-micon"><i class="ti ti-adjustments-horizontal"></i></span>
                                <span class="dash-mtext">{{ __('Personalizar loja') }}</span>
                              </a>
                            </li>

                            {{-- REDES SOCIAIS --}}
                            <li class="menu-label">{{ __('REDES SOCIAIS') }}</li>
                            <li class="dash-item">
                              <a href="#" class="dash-link disabled" aria-disabled="true">
                                <span class="dash-micon"><i class="ti ti-brand-instagram"></i></span>
                                <span class="dash-mtext">{{ __('Instagram') }}</span>
                              </a>
                            </li>
                            <li class="dash-item">
                              <a href="#" class="dash-link disabled" aria-disabled="true">
                                <span class="dash-micon"><i class="ti ti-brand-tiktok"></i></span>
                                <span class="dash-mtext">{{ __('TikTok') }}</span>
                                <span class="badge rounded-pill bg-warning ms-auto">Novo</span>
                              </a>
                            </li>

                            {{-- ATENDIMENTO --}}
                            <li class="menu-label">{{ __('ATENDIMENTO') }}</li>
                            <li class="dash-item">
                              <a href="#" class="dash-link disabled" aria-disabled="true">
                                <span class="dash-micon"><i class="ti ti-headset"></i></span>
                                <span class="dash-mtext">{{ __('CRM omnichannel') }}</span>
                              </a>
                            </li>

                            {{-- AUTOMAÇÕES --}}
                            <li class="menu-label">{{ __('AUTOMAÇÕES') }}</li>
                            <li class="dash-item">
                              <a href="#" class="dash-link disabled" aria-disabled="true">
                                <span class="dash-micon"><i class="ti ti-bell"></i></span>
                                <span class="dash-mtext">{{ __('Notificações Manuais') }}</span>
                              </a>
                            </li>
                            <li class="dash-item">
                              <a href="#" class="dash-link disabled" aria-disabled="true">
                                <span class="dash-micon"><i class="ti ti-flash"></i></span>
                                <span class="dash-mtext">{{ __('Notificações inteligentes') }}</span>
                                <span class="badge badge-pill bg-info ms-auto">AI</span>
                              </a>
                            </li>
                            <li class="dash-item">
                              <a href="#" class="dash-link disabled" aria-disabled="true">
                                <span class="dash-micon"><i class="ti ti-settings"></i></span>
                                <span class="dash-mtext">{{ __('Configurações') }}</span>
                              </a>
                            </li>

                            {{-- EXTRAS --}}
                            <li class="menu-label">{{ __('EXTRAS') }}</li>
                            <li class="dash-item">
                              <a href="#" class="dash-link disabled" aria-disabled="true">
                                <span class="dash-micon"><i class="ti ti-gift"></i></span>
                                <span class="dash-mtext">{{ __('Recompensas') }}</span>
                                <span class="badge rounded-pill bg-warning ms-auto">3</span>
                              </a>
                            </li>
                            <li class="dash-item">
                              <a href="#" class="dash-link disabled" aria-disabled="true">
                                <span class="dash-micon"><i class="ti ti-settings"></i></span>
                                <span class="dash-mtext">{{ __('Configurações Gerais') }}</span>
                              </a>
                            </li>

                          </ul>
                        </li>
                    @endcanany

                    {{-- POS --}}
                    @can('Manage Pos')
                        <li class="dash-item {{ Request::segment(1)=='pos' ? ' active' : 'collapsed' }}">
                            <a href="{{ route('pos.index') }}" class="dash-link {{ request()->is('pos') ? 'active' : '' }}">
                                <span class="dash-micon"><i class="ti ti-layers-difference"></i></span>
                                <span class="dash-mtext">{{ __('Pos') }}</span>
                            </a>
                        </li>
                    @endcan

                    {{-- SHOP & OTHERS ... --}}
                    {{-- (os demais blocos permanecem idênticos ao seu original) --}}

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
  box-shadow: 0 5px 7px -1px rgba(146,44,136,0.3);
}

/* Ícone laranja */
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
  box-shadow: -3px 4px 23px rgba(0,0,0,0);
}

/* Ícones brancos no hover */
body.custom-color .dash-sidebar.light-sidebar .dash-navbar > .dash-item.active > .dash-link i,
body.custom-color .dash-sidebar.light-sidebar .dash-navbar > .dash-item:active > .dash-link i,
body.custom-color .dash-sidebar.light-sidebar .dash-navbar > .dash-item:focus > .dash-link i,
body.custom-color .dash-sidebar.light-sidebar .dash-navbar > .dash-item:hover > .dash-link i,
body.custom-color .dash-sidebar .dash-navbar > .dash-item.active > .dash-link i,
body.custom-color .dash-sidebar .dash-navbar > .dash-item:active > .dash-link i,
body.custom-color .dash-sidebar .dash-navbar > .dash-item:focus > .dash-link i,
body.custom-color .dash-sidebar .dash-navbar > .dash-item:hover > .dash-link i {
    color: #fff;
}

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

/* estilo para links desabilitados */
.dash-link.disabled {
    opacity: 0.5;
    pointer-events: none;
}
</style>
