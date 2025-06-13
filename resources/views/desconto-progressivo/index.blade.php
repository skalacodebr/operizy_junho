@extends('layouts.admin')

@section('page-title')
    Frete Grátis
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Desconto Progressivo</a></li>
    <li class="breadcrumb-item active" aria-current="page">Frete Grátis</li>
@endsection

@section('title')
    <div class="d-inline-block">
        <h5 class="h4 d-inline-block text-white font-weight-bold mb-0">Frete Grátis</h5>
    </div>
@endsection





@section('content')
<style>
                .promotion-card {
        border-radius: 15px !important;
        color: white !important;
        padding: 30px !important;
        height: 100% !important;
        transition: all 0.3s ease !important;
        border: none !important;
        box-shadow: 0 8px 25px rgba(0,0,0,0.1) !important;
    }
    
    .promotion-card:hover {
        transform: translateY(-5px) !important;
        box-shadow: 0 15px 35px rgba(0,0,0,0.15) !important;
    }
    
    .promotion-icon {
        width: 60px !important;
        height: 60px !important;
        background: rgba(255,255,255,0.2) !important;
        border-radius: 50% !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        margin-bottom: 20px !important;
        font-size: 24px !important;
        color: white !important;
    }
    
    .promotion-title {
        font-size: 18px !important;
        font-weight: 600 !important;
        margin-bottom: 15px !important;
        color: white !important;
    }
    
    .promotion-description {
        font-size: 14px !important;
        opacity: 0.9 !important;
        line-height: 1.5 !important;
        margin-bottom: 25px !important;
        min-height: 60px !important;
        color: white !important;
    }
    
    .btn-configure {
        background: rgba(255,255,255,0.2) !important;
        border: 1px solid rgba(255,255,255,0.3) !important;
        color: white !important;
        padding: 12px 25px !important;
        border-radius: 8px !important;
        font-weight: 500 !important;
        transition: all 0.3s ease !important;
        width: 100% !important;
    }
    
    .btn-configure:hover {
        background: rgba(255,255,255,0.3) !important;
        color: white !important;
        border-color: rgba(255,255,255,0.5) !important;
    }
    
    .search-container {
        position: relative;
        margin-bottom: 30px;
    }
    
    .search-input {
        background: rgb(255 255 255 / 6%);
    border: none;
    border-radius: 25px;
    padding: 15px 50px 15px 20px !important;
    font-size: 16px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    width: 100%;
    }
    
    .search-input:focus {
        outline: none;
        box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    }
    
    .search-icon {
        position: absolute;
        right: 20px;
        top: 50%;
        transform: translateY(-50%);
        color: #f3f5ff;
        font-size: 18px;
    }
    
    .card-hidden {
        display: none !important;
    }
    
    .no-results {
        text-align: center;
        padding: 50px;
        color: #666;
        font-size: 18px;
        display: none;
    }
    
    .page-bg {
        min-height: 100vh;
        padding: 20px 0;
    }
    
    /* Override dark theme for cards */
    .promotion-card * {
        color: white !important;
    }
    
    .card-hidden {
        display: none !important;
    }
    
    /* Ensure proper spacing */
    .promotion-card-item {
        margin-bottom: 1.5rem;
    }
</style>

<div class="page-bg">
<div class="container-fluid">
        <!-- Search Bar -->
        <div class="row justify-content-center mb-5">
            <div class="col-lg-6 col-md-8">
                <div class="search-container">
                    <input type="text" id="searchInput" class="form-control search-input" 
                           placeholder="Buscar por tipo de promoção...">
                    <i class="ti ti-search search-icon"></i>
                </div>
            </div>
        </div>
        
        <!-- Cards Container -->
        <div class="row g-4" id="cardsContainer">
            <!-- CARDS ORIGINAIS -->
            <!-- Cupons de Desconto -->
            <div class="col-lg-4 col-md-6 promotion-card-item" data-search="cupons desconto primeira compra novos produtos fidelização clientes aniversário lançamento">
                <div class="card promotion-card">
                    <div class="card-body">
                        <div class="promotion-icon">
                            <i class="ti ti-ticket"></i>
                        </div>
                        <h5 class="promotion-title">Cupons de descontos</h5>
                        <p class="promotion-description">
                            Primeira compra, novos produtos, fidelização de clientes, aniversário do cliente, lançamento de novos lançamentos e etc.
                        </p>
                        <button type="button" class="btn btn-configure" onclick="configureCupons()">
                            Configurar
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Upsell -->
            <div class="col-lg-4 col-md-6 promotion-card-item" data-search="upsell upgrade produto superior melhor versão">
                <div class="card promotion-card">
                    <div class="card-body">
                        <div class="promotion-icon">
                            <i class="ti ti-arrow-up"></i>
                        </div>
                        <h5 class="promotion-title">Upsell</h5>
                        <p class="promotion-description">
                            Ofereça produtos superiores ou versões premium para aumentar o valor médio do pedido e melhorar a experiência do cliente.
                        </p>
                        <button type="button" class="btn btn-configure" onclick="configureUpsell()">
                            Configurar
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Order Bumps -->
            <div class="col-lg-4 col-md-6 promotion-card-item" data-search="order bumps oferta última chance checkout finalização compra">
                <div class="card promotion-card">
                    <div class="card-body">
                        <div class="promotion-icon">
                            <i class="ti ti-shopping-cart"></i>
                        </div>
                        <h5 class="promotion-title">Order Bumps</h5>
                        <p class="promotion-description">
                            Ofertas especiais no momento da finalização da compra para aumentar o valor do pedido de última hora.
                        </p>
                        <button type="button" class="btn btn-configure" onclick="configureOrderBumps()">
                            Configurar
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Cross-sell -->
            <div class="col-lg-4 col-md-6 promotion-card-item" data-search="cross sell produtos relacionados complementares sugestões recomendações">
                <div class="card promotion-card">
                    <div class="card-body">
                        <div class="promotion-icon">
                            <i class="ti ti-arrows-exchange"></i>
                        </div>
                        <h5 class="promotion-title">Cross-sell</h5>
                        <p class="promotion-description">
                            Sugira produtos complementares e relacionados para aumentar as vendas e melhorar a experiência de compra.
                        </p>
                        <button type="button" class="btn btn-configure" onclick="configureCrossSell()">
                            Configurar
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Brinde no Carrinho -->
            <div class="col-lg-4 col-md-6 promotion-card-item" data-search="brinde carrinho presente grátis oferta especial cortesia">
                <div class="card promotion-card">
                    <div class="card-body">
                        <div class="promotion-icon">
                            <i class="ti ti-gift"></i>
                        </div>
                        <h5 class="promotion-title">Brinde no Carrinho</h5>
                        <p class="promotion-description">
                            Adicione um brinde ou oferta de brinde para seu cliente quando ele adicionar um item específico no carrinho.
                        </p>
                        <button type="button" class="btn btn-configure" onclick="configureBrinde()">
                            Configurar
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Compre Junto -->
            <div class="col-lg-4 col-md-6 promotion-card-item" data-search="compre junto combo kit bundle desconto conjunto">
                <div class="card promotion-card">
                    <div class="card-body">
                        <div class="promotion-icon">
                            <i class="ti ti-package"></i>
                        </div>
                        <h5 class="promotion-title">Compre Junto</h5>
                        <p class="promotion-description">
                            Crie ofertas de produtos em combo com desconto especial quando comprados em conjunto.
                        </p>
                        <button type="button" class="btn btn-configure" onclick="configureCompreJunto()">
                            Configurar
                        </button>
                    </div>
                </div>
            </div>

            <!-- NOVOS CARDS -->
            <!-- Desconto em Massa -->
            <div class="col-lg-4 col-md-6 promotion-card-item" data-search="desconto massa quantidade volume atacado estoque">
                <div class="card promotion-card">
                    <div class="card-body">
                        <div class="promotion-icon">
                            <i class="ti ti-percentage"></i>
                        </div>
                        <h5 class="promotion-title">Desconto em Massa</h5>
                        <p class="promotion-description">
                            Queima de estoque, eventos de grande porte, parcerias com empresas, fim de temporada.
                        </p>
                        <button type="button" class="btn btn-configure" onclick="configureDescontoMassa()">
                            Configurar
                        </button>
                    </div>
                </div>
            </div>

            <!-- Frete Grátis -->
            <div class="col-lg-4 col-md-6 promotion-card-item" data-search="frete gratis gratuito entrega livre envio">
                <div class="card promotion-card">
                    <div class="card-body">
                        <div class="promotion-icon">
                            <i class="ti ti-truck"></i>
                        </div>
                        <h5 class="promotion-title">Frete Grátis</h5>
                        <p class="promotion-description">
                            Se a sua loja oferece frete grátis, destaque esta informação na vitrine antes mesmo do cliente.
                        </p>
                        <button type="button" class="btn btn-configure" onclick="configureFreteGratis()">
                            Configurar
                        </button>
                    </div>
                </div>
            </div>

            <!-- Desconto Progressivo -->
            <div class="col-lg-4 col-md-6 promotion-card-item" data-search="desconto progressivo aumento quantidade maior">
                <div class="card promotion-card">
                    <div class="card-body">
                        <div class="promotion-icon">
                            <i class="ti ti-trending-up"></i>
                        </div>
                        <h5 class="promotion-title">Desconto Progressivo</h5>
                        <p class="promotion-description">
                            Incentive seus clientes a aumentarem o carrinho. Quanto mais produtos adicionarem, maior será o desconto que eles recebem.
                        </p>
                        <button type="button" class="btn btn-configure" onclick="configureDescontoProgressivo()">
                            Configurar
                        </button>
                    </div>
                </div>
            </div>

            <!-- Leve mais e pague menos -->
            <div class="col-lg-4 col-md-6 promotion-card-item" data-search="leve mais pague menos oferta especial promocao">
                <div class="card promotion-card">
                    <div class="card-body">
                        <div class="promotion-icon">
                            <i class="ti ti-shopping-bag"></i>
                        </div>
                        <h5 class="promotion-title">Leve mais e pague menos</h5>
                        <p class="promotion-description">
                            Crie ofertas do tipo "Leve 3 e pague 2" ou "Compre 2 e ganhe 50% de desconto no terceiro" para aumentar o ticket médio.
                        </p>
                        <button type="button" class="btn btn-configure" onclick="configureLeveMais()">
                            Configurar
                        </button>
                    </div>
                </div>
            </div>

            <!-- Cashback -->
            <div class="col-lg-4 col-md-6 promotion-card-item" data-search="cashback dinheiro volta credito retorno">
                <div class="card promotion-card">
                    <div class="card-body">
                        <div class="promotion-icon">
                            <i class="ti ti-coin"></i>
                        </div>
                        <h5 class="promotion-title">Cashback</h5>
                        <p class="promotion-description">
                            Ofereça dinheiro de volta ou créditos para futuras compras, incentivando a fidelização e o retorno dos clientes.
                        </p>
                        <button type="button" class="btn btn-configure" onclick="configureCashback()">
                            Configurar
                        </button>
                    </div>
                </div>
            </div>

            <!-- Cashback progressivo -->
            <div class="col-lg-4 col-md-6 promotion-card-item" data-search="cashback progressivo crescente valor aumenta">
                <div class="card promotion-card">
                    <div class="card-body">
                        <div class="promotion-icon">
                            <i class="ti ti-trending-up-2"></i>
                        </div>
                        <h5 class="promotion-title">Cashback progressivo</h5>
                        <p class="promotion-description">
                            Cashback que aumenta conforme o valor da compra ou quantidade de produtos, incentivando compras maiores.
                        </p>
                        <button type="button" class="btn btn-configure" onclick="configureCashbackProgressivo()">
                            Configurar
                        </button>
                    </div>
                </div>
            </div>

            <!-- Indique e ganhe -->
            <div class="col-lg-4 col-md-6 promotion-card-item" data-search="indique ganhe indicacao referencia amigo">
                <div class="card promotion-card">
                    <div class="card-body">
                        <div class="promotion-icon">
                            <i class="ti ti-users"></i>
                        </div>
                        <h5 class="promotion-title">Indique e ganhe</h5>
                        <p class="promotion-description">
                            Programa de indicação onde clientes ganham benefícios ao indicar amigos, expandindo sua base de clientes.
                        </p>
                        <button type="button" class="btn btn-configure" onclick="configureIndiqueGanhe()">
                            Configurar
                        </button>
                    </div>
                </div>
            </div>

            <!-- Clube de benefícios -->
            <div class="col-lg-4 col-md-6 promotion-card-item" data-search="clube beneficios vip fidelidade premium">
                <div class="card promotion-card">
                    <div class="card-body">
                        <div class="promotion-icon">
                            <i class="ti ti-crown"></i>
                        </div>
                        <h5 class="promotion-title">Clube de benefícios</h5>
                        <p class="promotion-description">
                            Programa de fidelidade VIP com benefícios exclusivos, descontos especiais e vantagens para clientes assíduos.
                        </p>
                        <button type="button" class="btn btn-configure" onclick="configureClubebenificios()">
                            Configurar
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- No Results Message -->
        <div class="no-results" id="noResults">
            <i class="ti ti-search" style="font-size: 3rem; margin-bottom: 1rem;"></i>
            <h4>Nenhum resultado encontrado</h4>
            <p>Tente buscar por outros termos relacionados às promoções.</p>
        </div>
    </div>
</div>
@endsection

@push('script-page')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
$(document).ready(function() {
    // Inicializa escondendo a mensagem de "nenhum resultado"
    $('#noResults').hide();
    
    // Debug: verificar se todos os elementos foram carregados
    console.log('Cards encontrados:', $('.promotion-card-item').length);
    console.log('Campo de busca encontrado:', $('#searchInput').length);
    
    // Funcionalidade de busca
    $('#searchInput').on('keyup input', function() {
        const searchTerm = $(this).val().toLowerCase().trim();
        const cards = $('.promotion-card-item');
        let visibleCount = 0;
        
        if (searchTerm === '') {
            // Se não há termo de busca, mostra todos os cards
            cards.removeClass('card-hidden').show();
            $('#noResults').hide();
            return;
        }
        
        cards.each(function() {
            const searchData = $(this).data('search').toLowerCase();
            const title = $(this).find('.promotion-title').text().toLowerCase();
            const description = $(this).find('.promotion-description').text().toLowerCase();
            
            const isMatch = searchData.includes(searchTerm) || 
                          title.includes(searchTerm) || 
                          description.includes(searchTerm);
            
            if (isMatch) {
                $(this).removeClass('card-hidden').show();
                visibleCount++;
            } else {
                $(this).addClass('card-hidden').hide();
            }
        });
        
        // Mostra mensagem se nenhum resultado foi encontrado
        if (visibleCount === 0 && searchTerm !== '') {
            $('#noResults').show();
        } else {
            $('#noResults').hide();
        }
    });
    
    // Remove qualquer efeito de hover que possa estar conflitando
    $('.promotion-card').on('mouseenter', function() {
        $(this).css({
            'transform': 'translateY(-5px)',
            'box-shadow': '0 15px 35px rgba(0,0,0,0.15)'
        });
    }).on('mouseleave', function() {
        $(this).css({
            'transform': 'translateY(0)',
            'box-shadow': '0 8px 25px rgba(0,0,0,0.1)'
        });
    });
});

// Funções de configuração para cada tipo de promoção

// CARDS ORIGINAIS

function configureCupons() {
    window.location.href = '{{ route("cupons.index") }}';
}

function configureFreteGratis() {
    window.location.href = '{{ route("frete-gratis.index") }}';
}

function configureLeveMais() {
    window.location.href = '{{ route("leve-mais-ganhe.index") }}';
}



{{--


function configureUpsell() {
    window.location.href = '{{ route("upsell.index") }}';
}

function configureOrderBumps() {
    window.location.href = '{{ route("order-bumps.index") }}';
}

function configureCrossSell() {
    window.location.href = '{{ route("cross-sell.index") }}';
}

function configureBrinde() {
    window.location.href = '{{ route("brinde-carrinho.index") }}';
}

function configureCompreJunto() {
    window.location.href = '{{ route("compre-junto.index") }}';
}

// NOVOS CARDS
function configureDescontoMassa() {
    window.location.href = '{{ route("desconto-massa.index") }}';
}



function configureDescontoProgressivo() {
    window.location.href = '{{ route("desconto-progressivo-config.index") }}';
}


function configureCashback() {
    window.location.href = '{{ route("cashback.index") }}';
}

function configureCashbackProgressivo() {
    window.location.href = '{{ route("cashback-progressivo.index") }}';
}

function configureIndiqueGanhe() {
    window.location.href = '{{ route("indique-ganhe.index") }}';
}

function configureClubebenificios() {
    window.location.href = '{{ route("clube-beneficios.index") }}';
}

--}}
</script>
@endpush
