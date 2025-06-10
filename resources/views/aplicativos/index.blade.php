@extends('layouts.admin')
@section('page-title')
    {{ __('Aplicativos') }}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Home') }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('Aplicativos') }}</li>
@endsection
@section('title')
    <div class="d-inline-block">
        <h5 class="h4 d-inline-block text-white font-weight-bold mb-0 ">{{ __('Aplicativos') }}</h5>
    </div>
@endsection

@push('css-page')
<style>
    :root {
        --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --secondary-gradient: linear-gradient(135deg, #a855f7 0%, #3b82f6 100%);
        --accent-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        --success-color: #10b981;
        --card-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        --card-shadow-hover: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }

    .aplicativos-container {
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        min-height: 100vh;
        padding: 2rem 0;
    }

    .app-card {
        background: white;
        border: none;
        border-radius: 20px;
        box-shadow: var(--card-shadow);
        transition: all 0.4s cubic-bezier(0.25, 0.8, 0.25, 1);
        overflow: hidden;
        position: relative;
        backdrop-filter: blur(10px);
    }

    .app-card:hover {
        transform: translateY(-8px) scale(1.02);
        box-shadow: var(--card-shadow-hover);
    }

    .app-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: var(--secondary-gradient);
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .app-card:hover::before {
        opacity: 1;
    }

    .app-icon {
        width: 64px;
        height: 64px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        background: var(--secondary-gradient);
        color: white;
        margin: 0 auto 1.5rem;
        box-shadow: 0 8px 16px rgba(168, 85, 247, 0.3);
    }

    .banner-principal {
        background: var(--primary-gradient);
        border-radius: 24px;
        color: white;
        position: relative;
        overflow: hidden;
        box-shadow: 0 10px 40px rgba(102, 126, 234, 0.3);
    }

    .banner-principal::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="50" cy="50" r="1" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
        opacity: 0.1;
    }

    .combo-card {
        background: var(--secondary-gradient);
        border-radius: 24px;
        color: white;
        box-shadow: 0 10px 40px rgba(168, 85, 247, 0.3);
        position: relative;
        overflow: hidden;
    }

    .combo-card::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        animation: shimmer 3s infinite;
    }

    @keyframes shimmer {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    .search-container {
        max-width: 500px;
        margin: 0 auto;
        position: relative;
    }

    .search-input {
        border-radius: 50px;
        border: 2px solid transparent;
        background: white;
        padding: 1rem 3rem 1rem 1.5rem;
        font-size: 1.1rem;
        box-shadow: var(--card-shadow);
        transition: all 0.3s ease;
        width: 100%;
    }

    .search-input:focus {
        outline: none;
        border-color: #a855f7;
        box-shadow: 0 0 0 4px rgba(168, 85, 247, 0.1);
        transform: scale(1.02);
    }

    .search-icon {
        position: absolute;
        right: 1.5rem;
        top: 50%;
        transform: translateY(-50%);
        color: #9ca3af;
        font-size: 1.2rem;
    }

    .price-display {
        background: #f8fafc;
        border-radius: 16px;
        padding: 1.5rem;
        margin: 1rem 0;
        border: 2px solid transparent;
        transition: all 0.3s ease;
    }

    .price-display:hover {
        border-color: #e5e7eb;
        background: #ffffff;
    }

    .price-value {
        font-size: 2rem;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 0.25rem;
    }

    .price-period {
        font-size: 0.875rem;
        color: #6b7280;
        font-weight: 500;
    }

    .btn-premium {
        background: var(--secondary-gradient);
        border: none;
        border-radius: 12px;
        padding: 0.75rem 2rem;
        font-weight: 600;
        color: white;
        transition: all 0.3s ease;
        box-shadow: 0 4px 14px rgba(168, 85, 247, 0.4);
    }

    .btn-premium:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(168, 85, 247, 0.5);
        color: white;
    }

    .btn-outline-premium {
        border: 2px solid #e5e7eb;
        background: transparent;
        border-radius: 12px;
        padding: 0.75rem 2rem;
        font-weight: 600;
        color: #6b7280;
        transition: all 0.3s ease;
    }

    .btn-outline-premium:hover {
        border-color: #a855f7;
        color: #a855f7;
        background: rgba(168, 85, 247, 0.05);
    }

    .feature-list {
        list-style: none;
        padding: 0;
        margin: 1.5rem 0;
    }

    .feature-item {
        display: flex;
        align-items: center;
        padding: 0.5rem 0;
        color: #6b7280;
        font-size: 0.9rem;
    }

    .feature-icon {
        width: 20px;
        height: 20px;
        border-radius: 50%;
        background: var(--success-color);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 0.75rem;
        font-size: 0.7rem;
    }

    .apps-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
        gap: 2rem;
        margin-top: 3rem;
    }

    .combo-apps-icons {
        display: flex;
        justify-content: center;
        gap: 0.5rem;
        margin-bottom: 1rem;
    }

    .combo-icon {
        width: 40px;
        height: 40px;
        border-radius: 12px;
        background: rgba(255, 255, 255, 0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        animation: float 3s ease-in-out infinite;
    }

    .combo-icon:nth-child(2) { animation-delay: 0.5s; }
    .combo-icon:nth-child(3) { animation-delay: 1s; }
    .combo-icon:nth-child(4) { animation-delay: 1.5s; }
    .combo-icon:nth-child(5) { animation-delay: 2s; }

    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
    }

    .custom-combo-card {
        background: var(--accent-gradient);
        border-radius: 24px;
        color: white;
        box-shadow: 0 10px 40px rgba(240, 147, 251, 0.3);
        margin-top: 3rem;
    }

    .section-title {
        font-size: 2.5rem;
        font-weight: 700;
        color: #1f2937;
        text-align: center;
        margin-bottom: 3rem;
        background: var(--primary-gradient);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    @media (max-width: 768px) {
        .apps-grid {
            grid-template-columns: 1fr;
            gap: 1.5rem;
        }
        
        .search-container {
            max-width: 100%;
            padding: 0 1rem;
        }

        .section-title {
            font-size: 2rem;
        }
    }
</style>
@endpush

@section('content')
    <div class="aplicativos-container">
        <div class="container">
            <!-- Header Section -->
            <div class="text-center mb-5">
                <h1 class="section-title">Aplicativos Premium</h1>
                <p class="lead text-muted">Potencialize seu e-commerce com ferramentas profissionais</p>
            </div>

            <!-- Search Bar -->
            <div class="search-container mb-5">
                <input type="text" class="search-input" placeholder="Pesquisar aplicativos..." id="searchApp">
                <i class="fas fa-search search-icon"></i>
            </div>

            <!-- Featured Banner -->
            <div class="banner-principal p-5 mb-5">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h2 class="h3 mb-3 fw-bold">{{ $banner['titulo'] }}</h2>
                        <h4 class="mb-3 opacity-75">{{ $banner['subtitulo'] }}</h4>
                        <p class="mb-4 fs-5 opacity-90">{{ $banner['descricao'] }}</p>
                        <div class="d-flex align-items-center gap-3">
                            <a href="#" class="btn btn-light btn-lg px-4 py-3 fw-bold">Experimentar Grátis</a>
                            <a href="#" class="btn btn-outline-light px-4 py-3">Saiba Mais</a>
                        </div>
                    </div>
                    <div class="col-md-4 text-center">
                        <div class="app-icon mb-4">
                            <i class="ti ti-device-desktop"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Premium Combo -->
            <div class="combo-card p-5 mb-5">
                <div class="text-center mb-4">
                    <h3 class="h2 mb-3 fw-bold">{{ $combo_especial['nome'] }}</h3>
                    <p class="fs-5 mb-4 opacity-90">{{ $combo_especial['descricao'] }}</p>
                    
                    <!-- Animated Icons -->
                    <div class="combo-apps-icons mb-4">
                        <div class="combo-icon">📱</div>
                        <div class="combo-icon">🎯</div>
                        <div class="combo-icon">💻</div>
                        <div class="combo-icon">📊</div>
                        <div class="combo-icon">🔗</div>
                    </div>
                    
                    <div class="price-display d-inline-block text-center">
                        <div class="price-value text-white">R$ {{ $combo_especial['preco_promocional'] }}</div>
                        <div class="price-period text-white-50">{{ $combo_especial['cobranca'] }} - Economize {{ $combo_especial['desconto'] }}%</div>
                        <div class="mt-2 text-white-50 text-decoration-line-through">De R$ {{ $combo_especial['preco_original'] }}</div>
                    </div>
                    
                    <div class="mt-4">
                        <a href="#" class="btn btn-light btn-lg px-5 py-3 fw-bold me-3">Assinar Combo Premium</a>
                        <a href="#" class="btn btn-outline-light px-4 py-3">Ver Detalhes</a>
                    </div>
                </div>
            </div>

            <!-- Apps Grid -->
            <div class="apps-grid" id="appsGrid">
                @foreach($aplicativos as $app)
                <div class="app-card-container app-item" data-name="{{ strtolower($app['nome']) }}" data-category="{{ $app['categoria'] ?? 'geral' }}">
                    <div class="app-card h-100">
                        <div class="p-4 text-center">
                            <div class="app-icon mb-4">{{ $app['icone'] }}</div>
                            <h5 class="fw-bold mb-3">{{ $app['nome'] }}</h5>
                            <p class="text-muted mb-4">{{ $app['descricao'] }}</p>
                            
                            <!-- Features List -->
                            <ul class="feature-list text-start">
                                <li class="feature-item">
                                    <div class="feature-icon">
                                        <i class="fas fa-check"></i>
                                    </div>
                                    Integração automática
                                </li>
                                <li class="feature-item">
                                    <div class="feature-icon">
                                        <i class="fas fa-check"></i>
                                    </div>
                                    Analytics avançados
                                </li>
                                <li class="feature-item">
                                    <div class="feature-icon">
                                        <i class="fas fa-check"></i>
                                    </div>
                                    Suporte 24/7
                                </li>
                                @if($app['limitado'] ?? false)
                                <li class="feature-item">
                                    <div class="feature-icon">
                                        <i class="fas fa-infinity"></i>
                                    </div>
                                    Recursos ilimitados
                                </li>
                                @endif
                                @if($app['armazenamento'] ?? false)
                                <li class="feature-item">
                                    <div class="feature-icon">
                                        <i class="fas fa-cloud"></i>
                                    </div>
                                    {{ $app['armazenamento'] }} de armazenamento
                                </li>
                                @endif
                            </ul>
                            
                            <div class="price-display">
                                <div class="d-flex justify-content-between text-start">
                                    <div>
                                        <div class="price-value">R$ {{ $app['preco_mensal'] ?? '49,90' }}</div>
                                        <div class="price-period">Mensal</div>
                                    </div>
                                    @if($app['preco_anual'] ?? false)
                                    <div>
                                        <div class="price-value">R$ {{ $app['preco_anual'] }}</div>
                                        <div class="price-period">Anual ({{ $app['desconto'] ?? '20' }}% OFF)</div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="d-grid gap-2">
                                @if($app['status'] == 'Ativo')
                                    <a href="#" class="btn btn-outline-premium">Gerenciar App</a>
                                    <a href="#" class="btn btn-premium">Configurações</a>
                                @else
                                    <a href="{{ route('aplicativos.show', $app['id']) }}" class="btn btn-outline-premium">Ver Detalhes</a>
                                    <a href="#" class="btn btn-premium" onclick="subscribeApp({{ $app['id'] }})">Começar Teste Grátis</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Custom Combo Section -->
            <div class="custom-combo-card p-5 text-center">
                <div class="mb-4">
                    <i class="ti ti-puzzle" style="font-size: 4rem; color: white;"></i>
                </div>
                <h3 class="h2 mb-3 fw-bold">Faça do seu jeito</h3>
                <p class="fs-5 mb-4 opacity-90">
                    Faça você mesmo um combo perfeito para o seu negócio. Assine o que precisa para aumentar seus lucros e pague menos.
                </p>
                <div class="d-flex justify-content-center gap-3">
                    <a href="#" class="btn btn-light btn-lg px-5 py-3 fw-bold">Montar Combo Personalizado</a>
                    <a href="#" class="btn btn-outline-light px-4 py-3">Falar com Especialista</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script-page')
<script>
    // Enhanced search functionality
    document.getElementById('searchApp').addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        const appItems = document.querySelectorAll('.app-item');
        let visibleCount = 0;
        
        appItems.forEach(item => {
            const appName = item.getAttribute('data-name');
            const appCategory = item.getAttribute('data-category') || '';
            
            if (appName.includes(searchTerm) || appCategory.includes(searchTerm)) {
                item.style.display = 'block';
                item.style.opacity = '1';
                item.style.transform = 'scale(1)';
                visibleCount++;
            } else {
                item.style.opacity = '0';
                item.style.transform = 'scale(0.9)';
                setTimeout(() => {
                    if (item.style.opacity === '0') {
                        item.style.display = 'none';
                    }
                }, 300);
            }
        });
        
        // Show no results message if needed
        const noResults = document.getElementById('noResults');
        if (visibleCount === 0 && searchTerm !== '') {
            if (!noResults) {
                const message = document.createElement('div');
                message.id = 'noResults';
                message.className = 'text-center py-5';
                message.innerHTML = `
                    <div class="text-muted">
                        <i class="fas fa-search fa-3x mb-3"></i>
                        <h4>Nenhum aplicativo encontrado</h4>
                        <p>Tente pesquisar por outros termos</p>
                    </div>
                `;
                document.getElementById('appsGrid').appendChild(message);
            }
        } else if (noResults) {
            noResults.remove();
        }
    });

    // Subscribe to app function
    function subscribeApp(appId) {
        Swal.fire({
            title: 'Começar teste grátis?',
            text: 'Você terá 14 dias grátis para testar todos os recursos.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Sim, começar teste!',
            cancelButtonText: 'Cancelar',
            confirmButtonColor: '#a855f7',
            cancelButtonColor: '#6b7280'
        }).then((result) => {
            if (result.isConfirmed) {
                // Show loading
                Swal.fire({
                    title: 'Processando...',
                    text: 'Preparando seu teste grátis',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                
                // Simulate API call
                setTimeout(() => {
                    Swal.fire({
                        title: 'Sucesso!',
                        text: 'Seu teste grátis foi ativado com sucesso!',
                        icon: 'success',
                        confirmButtonColor: '#10b981'
                    }).then(() => {
                        window.location.href = `/aplicativos/${appId}`;
                    });
                }, 2000);
            }
        });
    }

    // Smooth scroll for internal links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // Intersection Observer for animations
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);

    // Observe all app cards
    document.querySelectorAll('.app-card').forEach(card => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(30px)';
        card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        observer.observe(card);
    });

    // Add loading states to buttons
    document.querySelectorAll('.btn-premium, .btn-outline-premium').forEach(button => {
        button.addEventListener('click', function(e) {
            if (this.href && this.href !== '#') return;
            
            e.preventDefault();
            const originalText = this.textContent;
            const loadingText = 'Carregando...';
            
            this.textContent = loadingText;
            this.disabled = true;
            
            setTimeout(() => {
                this.textContent = originalText;
                this.disabled = false;
            }, 2000);
        });
    });

    // Enhanced search with debounce
    let searchTimeout;
    document.getElementById('searchApp').addEventListener('input', function() {
        clearTimeout(searchTimeout);
        const searchInput = this;
        
        searchTimeout = setTimeout(() => {
            // Add search analytics here if needed
            console.log('Search performed:', searchInput.value);
        }, 500);
    });
</script>
@endpush 