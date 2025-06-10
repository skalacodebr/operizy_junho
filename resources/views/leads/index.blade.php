@extends('layouts.admin')

@section('page-title')
    Leads
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Leads</a></li>
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
                <input type="text" id="daterange" class="form-control" />
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
                        <h3 class="mt-3">{{ $totalAvaliacoes }}</h3>
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
                        <h3 class="mt-3">{{ $totalPerguntas }}</h3>
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
@endsection

@push('script-page')
    <!-- Dependências: Moment.js, DateRangePicker e Chart.js -->
    <script src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        // 1) Inicializa o date range picker
        $('#daterange').daterangepicker({
            locale: { format: 'DD/MM/YYYY' },
            startDate: moment().startOf('month'),
            endDate: moment().endOf('month'),
        }, function(start, end) {
            // ao selecionar, recarrega a página com query params
            window.location.search = '?start='+ start.format('YYYY-MM-DD') +'&end='+ end.format('YYYY-MM-DD');
        });

        // 2) Dados vindos do controller (preenchidos em PHP)
        const avaliacoesData   = [{{ $avaliacoesNovas }}, {{ $avaliacoesPendentes }}, {{ $avaliacoesRespondidas }}];
        const perguntasData    = [{{ $perguntasNovas }}, {{ $perguntasPendentes }}, {{ $perguntasRespondidas }}];

        const mesesLabels      = @json(['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez']);
        const cuponsGerados    = @json($evolucaoCuponsGerados);    // ex: [50,55,60,…]
        const cuponsUsados     = @json($evolucaoCuponsUsados);     // ex: [30,25,40,…]
        const taxasConversao   = @json($evolucaoTaxasConversao);   // ex: [120,150,130,…]
        const tendenciaConversao = taxasConversao.map((v, i, a) => {
            // plota a própria série como tendência só para exemplo
            return v;
        });

        // 3) Configuração comum dos donuts
        const donutOptions = {
            cutout: '70%',
            plugins: {
                legend: { position: 'right' },
            }
        };

        // 4) Cria os charts
        new Chart(document.getElementById('chartAvaliacoes'), {
            type: 'doughnut',
            data: {
                labels: ['Novas','Pendentes','Respondidas'],
                datasets: [{
                    data: avaliacoesData,
                    backgroundColor: ['#9c27b0','#ffb300','#4caf50']
                }]
            },
            options: donutOptions
        });

        new Chart(document.getElementById('chartPerguntas'), {
            type: 'doughnut',
            data: {
                labels: ['Novas','Pendentes','Respondidas'],
                datasets: [{
                    data: perguntasData,
                    backgroundColor: ['#9c27b0','#ffb300','#4caf50']
                }]
            },
            options: donutOptions
        });

        // 5) Gráfico de barras empilhadas (cupons)
        new Chart(document.getElementById('chartCupons'), {
            type: 'bar',
            data: {
                labels: mesesLabels,
                datasets: [
                    {
                        label: 'Cupons gerados',
                        data: cuponsGerados,
                        backgroundColor: 'rgba(220,53,69,0.7)'
                    },
                    {
                        label: 'Cupons usados',
                        data: cuponsUsados,
                        backgroundColor: 'rgba(255,193,7,0.7)'
                    }
                ]
            },
            options: {
                scales: {
                    x: { stacked: true },
                    y: { stacked: true, beginAtZero: true }
                }
            }
        });

        // 6) Gráfico de barras + linha (taxa de conversão)
        new Chart(document.getElementById('chartConversao'), {
            data: {
                labels: mesesLabels,
                datasets: [
                    {
                        type: 'bar',
                        label: 'Taxa mensal (%)',
                        data: taxasConversao,
                        yAxisID: 'y'
                    },
                    {
                        type: 'line',
                        label: 'Tendência',
                        data: tendenciaConversao,
                        yAxisID: 'y',
                        tension: 0.3,
                        fill: false,
                        borderWidth: 2
                    }
                ]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        position: 'left'
                    }
                }
            }
        });
    });
    </script>
@endpush
