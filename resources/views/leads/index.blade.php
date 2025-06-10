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
    </script>
@endpush
