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

    </div>


@endsection

@push('script-page')
    <!-- Dependências: Moment.js, DateRangePicker e Chart.js -->
    <script src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>

    </script>
@endpush
