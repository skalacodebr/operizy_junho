@extends('layouts.admin')

@section('page-title')
    Review
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Review</a></li>
    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
@endsection

@section('title')
    <div class="d-inline-block">
        <h5 class="h4 d-inline-block text-white font-weight-bold mb-0">Dashboard</h5>
    </div>
@endsection

@push('css-page')
    <!-- Date Range Picker CSS -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@endpush

@section('content')
    <div class="container-fluid">
        <!-- FILTRO DE PERÍODO -->
        <div class="row mb-4">
            <div class="col-md-3">
                <label for="daterange">Período:</label>
                <input type="date" id="daterange" class="form-control" />
            </div>
        </div>

        <!-- GRÁFICOS DE DOUNUT -->
        <div class="row">
            <!-- Avaliações -->
            <div class="col-lg-6 mb-4">
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-star"></i> Avaliações
                    </div>
                    <div class="card-body text-center">
                        <canvas id="chartAvaliacoes" height="200"></canvas>
                        <h3 class="mt-3" id="totalAvaliacoes">380</h3>
                    </div>
                </div>
            </div>
            <!-- Perguntas -->
            <div class="col-lg-6 mb-4">
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-question-circle"></i> Perguntas
                    </div>
                    <div class="card-body text-center">
                        <canvas id="chartPerguntas" height="200"></canvas>
                        <h3 class="mt-3" id="totalPerguntas">380</h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- GRÁFICOS DE BARRAS -->
        <div class="row">
            <!-- Evolução Cupons -->
            <div class="col-lg-6 mb-4">
                <div class="card">
                    <div class="card-header">
                        Evolução mensal das campanhas de engajamento
                    </div>
                    <div class="card-body">
                        <canvas id="chartCupons" height="200"></canvas>
                    </div>
                </div>
            </div>
            <!-- Taxas de Conversão -->
            <div class="col-lg-6 mb-4">
                <div class="card">
                    <div class="card-header">
                        Evolução mensal das taxas de conversão
                    </div>
                    <div class="card-body">
                        <canvas id="chartConversao" height="200"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

<div class="container-fluid ranking-section">
    <!-- FILTRO DE PERÍODO -->
    <div class="row mb-4">
        <div class="col-md-3">
            <label for="daterangeRanking">Período:</label>
            <input type="text" id="daterangeRanking" class="form-control"/>
        </div>
    </div>

    <div class="card">
        <!-- cabeçalho com abas -->
        <div class="card-header">
            <ul class="nav nav-tabs card-header-tabs" id="rankingTabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="mais-avaliacoes-tab" data-toggle="tab" href="#mais-avaliacoes" role="tab">
                        Produtos com mais avaliações
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="melhores-avaliados-tab" data-toggle="tab" href="#melhores-avaliados" role="tab">
                        Produtos melhores avaliados
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="mais-perguntas-tab" data-toggle="tab" href="#mais-perguntas" role="tab">
                        Produtos com mais perguntas
                    </a>
                </li>
            </ul>
        </div>

        <!-- conteúdo das abas -->
        <div class="card-body">
            <div class="tab-content" id="rankingTabsContent">
                {{-- Aba: Mais avaliações --}}
                <div class="tab-pane fade show active" id="mais-avaliacoes" role="tabpanel">
                    <table class="table table-borderless mb-0">
                        <thead>
                            <tr class="text-secondary">
                                <th style="width: 5%;">Ranking</th>
                                <th style="width: 35%;">Produto</th>
                                <th style="width: 20%;">Avaliações</th>
                                <th style="width: 20%;">Perguntas</th>
                                <th style="width: 10%;">Visualizar</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- item 1 --}}
                            <tr>
                                <td class="align-middle">
                                    <strong>1<sup>º</sup></strong>
                                </td>
                                <td class="d-flex align-items-center gap-2">
                                    <img src="{{ asset('assets/images/user/avatar-1.jpg') }}" alt="Blusa de Botão" class="rounded mr-3" width="60" height="60">
                                    <div>
                                        <div><strong>Blusa de Botão</strong></div>
                                        <small class="text-muted">SKU: 7804456</small>
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <i class="fas fa-star text-warning"></i>
                                        <strong>5.0</strong>
                                        <small>(6 avaliações)</small>
                                    </div>
                                    <small class="text-success">+2 novas</small>
                                </td>
                                <td>
                                    <div>
                                        <i class="fas fa-question-circle"></i>
                                        <strong>1 pergunta respondida</strong>
                                    </div>
                                    <small class="text-success">+2 novas</small>
                                </td>
                                <td class="text-center">
                                    <a href="#" class="text-secondary"><i class="fas fa-external-link-alt"></i></a>
                                </td>
                            </tr>
                            {{-- item 2 --}}
                            <tr>
                                <td class="align-middle"><strong>2<sup>º</sup></strong></td>
                                <td class="d-flex align-items-center gap-2">
                                    <img src="{{ asset('assets/images/user/avatar-1.jpg') }}" alt="Blusa de Botão" class="rounded mr-3" width="60" height="60">
                                    <div>
                                        <div><strong>Blusa de Botão</strong></div>
                                        <small class="text-muted">SKU: 7804456</small>
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <i class="fas fa-star text-warning"></i>
                                        <strong>3.5</strong>
                                        <small>(6 avaliações)</small>
                                    </div>
                                    <small class="text-success">+2 novas</small>
                                </td>
                                <td>
                                    <div>
                                        —
                                    </div>
                                    <small class="text-muted">0 perguntas</small>
                                </td>
                                <td class="text-center">
                                    <a href="#" class="text-secondary"><i class="fas fa-external-link-alt"></i></a>
                                </td>
                            </tr>
                            {{-- item 3 --}}
                            <tr>
                                <td class="align-middle"><strong>3<sup>º</sup></strong></td>
                                <td class="d-flex align-items-center gap-2 gap-2">
                                    <img src="{{ asset('assets/images/user/avatar-1.jpg') }}" alt="Tênis Casual" class="rounded mr-3" width="60" height="60">
                                    <div>
                                        <div><strong>Tênis Casual</strong></div>
                                        <small class="text-muted">SKU: 7804456</small>
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <i class="fas fa-star text-warning"></i>
                                        <strong>5.0</strong>
                                        <small>(6 avaliações)</small>
                                    </div>
                                    <small class="text-success">+2 novas</small>
                                </td>
                                <td>
                                    <div>
                                        <i class="fas fa-question-circle"></i>
                                        <strong>1 pergunta respondida</strong>
                                    </div>
                                    <small class="text-success">+2 novas</small>
                                </td>
                                <td class="text-center">
                                    <a href="#" class="text-secondary"><i class="fas fa-external-link-alt"></i></a>
                                </td>
                            </tr>
                            {{-- item 4 --}}
                            <tr>
                                <td class="align-middle"><strong>4<sup>º</sup></strong></td>
                                <td class="d-flex align-items-center gap-2">
                                    <img src="{{ asset('assets/images/user/avatar-1.jpg') }}" alt="Tênis Casual" class="rounded mr-3" width="60" height="60">
                                    <div>
                                        <div><strong>Tênis Casual</strong></div>
                                        <small class="text-muted">SKU: 7804456</small>
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <i class="fas fa-star text-warning"></i>
                                        <strong>4.5</strong>
                                        <small>(6 avaliações)</small>
                                    </div>
                                    <small class="text-success">+2 novas</small>
                                </td>
                                <td>
                                    <div>
                                        <i class="fas fa-question-circle"></i>
                                        <strong>5 perguntas respondidas</strong>
                                    </div>
                                    <small class="text-success">+2 novas</small>
                                </td>
                                <td class="text-center">
                                    <a href="#" class="text-secondary"><i class="fas fa-external-link-alt"></i></a>
                                </td>
                            </tr>
                            {{-- item 5 --}}
                            <tr>
                                <td class="align-middle"><strong>5<sup>º</sup></strong></td>
                                <td class="d-flex align-items-center gap-2">
                                    <img src="{{ asset('assets/images/user/avatar-1.jpg') }}" alt="Blusa de Botão" class="rounded mr-3" width="60" height="60">
                                    <div>
                                        <div><strong>Blusa de Botão</strong></div>
                                        <small class="text-muted">SKU: 7804456</small>
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <i class="fas fa-star text-warning"></i>
                                        <strong>2.5</strong>
                                        <small>(6 avaliações)</small>
                                    </div>
                                    <small class="text-success">+2 novas</small>
                                </td>
                                <td>
                                    <div>
                                        <i class="fas fa-question-circle"></i>
                                        <strong>7 perguntas respondidas</strong>
                                    </div>
                                    <small class="text-success">+2 novas</small>
                                </td>
                                <td class="text-center">
                                    <a href="#" class="text-secondary"><i class="fas fa-external-link-alt"></i></a>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <!-- botão Ver mais -->
                    <div class="text-center mt-4">
                        <button class="btn btn-purple">
                            <i class="fas fa-plus"></i> Ver mais
                        </button>
                    </div>
                </div>

                {{-- aba “Produtos melhores avaliados” --}}
                <div class="tab-pane fade" id="melhores-avaliados" role="tabpanel">
                    <!-- repita a tabela acima com outro conjunto de dados -->
                    {{-- ... --}}
                </div>

                {{-- aba “Produtos com mais perguntas” --}}
                <div class="tab-pane fade" id="mais-perguntas" role="tabpanel">
                    <!-- repita a tabela acima com outro conjunto de dados -->
                    {{-- ... --}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script-page')
    <!-- Dependências: Moment.js, DateRangePicker e Chart.js -->
    <script src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        // 1) Inicializa o date range picker (só visual)
        $('#daterange').daterangepicker({
            locale: { format: 'DD/MM/YYYY' },
            startDate: moment().startOf('month'),
            endDate: moment().endOf('month'),
        });

        // 2) DADOS FICTÍCIOS
        const avaliacoesData    = [120, 45, 200];   // novas, pendentes, respondidas
        const perguntasData     = [120, 45, 200];
        const totalAvaliacoes   = avaliacoesData.reduce((a,b)=>a+b, 0);
        const totalPerguntas    = perguntasData.reduce((a,b)=>a+b, 0);

        const mesesLabels       = ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'];
        const cuponsGerados     = [50,55,60,65,75,90,110,100,120,130,140,150];
        const cuponsUsados      = [30,25,40,55,60,65,95,90,100,105,110,120];
        const taxasConversao    = [120,150,130,170,200,180,210,195,220,250,230,240];
        const tendenciaConv     = [...taxasConversao]; // só espelhando para linha

        // 3) Atualiza totais no HTML
        document.getElementById('totalAvaliacoes').textContent = totalAvaliacoes;
        document.getElementById('totalPerguntas').textContent  = totalPerguntas;

        // 4) Opções comuns para doughnut
        const donutOptions = {
            cutout: '70%',
            plugins: { legend: { position: 'right' } }
        };

        // 5) Cria charts
        new Chart('chartAvaliacoes', {
            type: 'doughnut',
            data: {
                labels: ['Novas','Pendentes','Respondidas'],
                datasets: [{ data: avaliacoesData, backgroundColor: ['#9c27b0','#ffb300','#4caf50'] }]
            },
            options: donutOptions
        });

        new Chart('chartPerguntas', {
            type: 'doughnut',
            data: {
                labels: ['Novas','Pendentes','Respondidas'],
                datasets: [{ data: perguntasData, backgroundColor: ['#9c27b0','#ffb300','#4caf50'] }]
            },
            options: donutOptions
        });

        new Chart('chartCupons', {
            type: 'bar',
            data: {
                labels: mesesLabels,
                datasets: [
                    { label: 'Cupons gerados', data: cuponsGerados, backgroundColor: 'rgba(220,53,69,0.7)' },
                    { label: 'Cupons usados',  data: cuponsUsados,  backgroundColor: 'rgba(255,193,7,0.7)' }
                ]
            },
            options: {
                scales: { x: { stacked: true }, y: { stacked: true, beginAtZero: true } }
            }
        });

        new Chart('chartConversao', {
            data: {
                labels: mesesLabels,
                datasets: [
                    { type: 'bar',  label: 'Taxa mensal (%)', data: taxasConversao,  yAxisID: 'y' },
                    { type: 'line', label: 'Tendência',       data: tendenciaConv,   yAxisID: 'y', tension:0.3, fill:false, borderWidth:2 }
                ]
            },
            options: {
                scales: {
                    y: { beginAtZero: true, position: 'left' }
                }
            }
        });
    });


    document.addEventListener('DOMContentLoaded', function(){
    $('#daterangeRanking').daterangepicker({
        locale: { format: 'DD/MM/YYYY' },
        startDate: moment().startOf('month'),
        endDate: moment().endOf('month'),
    });
    // ativa as abas Bootstrap
    $('#rankingTabs a').on('click', function (e) {
        e.preventDefault();
        $(this).tab('show');
    });
});
    </script>
@endpush
