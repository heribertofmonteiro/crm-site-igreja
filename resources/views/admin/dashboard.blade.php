@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard de KPIs</h1>
@stop

@section('content')
<div class="row">
    <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $metrics['active_members'] }}</h3>
                <p>Membros Ativos</p>
            </div>
            <div class="icon">
                <i class="fas fa-users"></i>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>R$ {{ number_format($metrics['total_donations'], 2, ',', '.') }}</h3>
                <p>Total de Doações</p>
            </div>
            <div class="icon">
                <i class="fas fa-dollar-sign"></i>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{ $metrics['total_events'] }}</h3>
                <p>Total de Eventos</p>
            </div>
            <div class="icon">
                <i class="fas fa-calendar"></i>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-danger">
            <div class="inner">
                <h3>{{ $metrics['total_baptisms'] }}</h3>
                <p>Total de Batismos</p>
            </div>
            <div class="icon">
                <i class="fas fa-water"></i>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Doações por Mês</h3>
            </div>
            <div class="card-body">
                <canvas id="donationsChart" width="400" height="200"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Eventos por Tipo</h3>
            </div>
            <div class="card-body">
                <canvas id="eventsChart" width="400" height="200"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Batismos por Ano</h3>
            </div>
            <div class="card-body">
                <canvas id="baptismsChart" width="400" height="200"></canvas>
            </div>
        </div>
    </div>
</div>
@stop

@section('plugins.Chartjs', true)

@section('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Gráfico de barras para doações
    const donationsCtx = document.getElementById('donationsChart').getContext('2d');
    new Chart(donationsCtx, {
        type: 'bar',
        data: {
            labels: @json($metrics['donations_chart']['labels']),
            datasets: [{
                label: 'Doações (R$)',
                data: @json($metrics['donations_chart']['data']),
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Gráfico de pizza para eventos
    const eventsCtx = document.getElementById('eventsChart').getContext('2d');
    new Chart(eventsCtx, {
        type: 'pie',
        data: {
            labels: @json($metrics['events_chart']['labels']),
            datasets: [{
                data: @json($metrics['events_chart']['data']),
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 205, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 205, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                ],
                borderWidth: 1
            }]
        }
    });

    // Gráfico de linhas para batismos
    const baptismsCtx = document.getElementById('baptismsChart').getContext('2d');
    new Chart(baptismsCtx, {
        type: 'line',
        data: {
            labels: @json($metrics['baptisms_chart']['labels']),
            datasets: [{
                label: 'Batismos',
                data: @json($metrics['baptisms_chart']['data']),
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1,
                fill: false
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
@stop