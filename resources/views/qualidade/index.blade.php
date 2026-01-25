@extends('adminlte::page')

@section('title', 'Saúde do Código - Sistema Kilocode')

@section('content_header')
    <h1>Saúde do Código</h1>
@stop

@section('content')
<div class="card card-primary card-tabs">
    <div class="card-header p-0 pt-1">
        <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">Dashboard</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill" href="#custom-tabs-one-profile" role="tab" aria-controls="custom-tabs-one-profile" aria-selected="false">Arquivos Críticos</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="custom-tabs-one-messages-tab" data-toggle="pill" href="#custom-tabs-one-messages" role="tab" aria-controls="custom-tabs-one-messages" aria-selected="false">Fila de Refatoração</a>
            </li>
        </ul>
    </div>
    <div class="card-body">
        <div class="tab-content" id="custom-tabs-one-tabContent">
            <div class="tab-pane fade show active" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">
                <div class="row">
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{ $latestReport ? $latestReport->total_files : 0 }}</h3>
                                <p>Total de Arquivos</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-file-code"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h3>{{ $criticalFilesCount }}</h3>
                                <p>Arquivos Críticos</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-exclamation-triangle"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-danger">
                            <div class="inner">
                                <h3>{{ $pendingTasks }}</h3>
                                <p>Tarefas Pendentes</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-tasks"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ $latestReport ? number_format($latestReport->average_complexity, 1) : 0 }}</h3>
                                <p>Complexidade Média</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-chart-line"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Último Relatório</h3>
                            </div>
                            <div class="card-body">
                                @if($latestReport)
                                    <p>Data da Análise: {{ $latestReport->scan_date->format('d/m/Y H:i') }}</p>
                                    <p>Dívida Técnica: {{ $latestReport->technical_debt_hours }} horas</p>
                                    <p>Linhas Duplicadas: {{ $latestReport->duplicated_lines }}</p>
                                @else
                                    <p>Nenhum relatório encontrado. <a href="#" onclick="document.getElementById('scan-form').submit()">Executar primeira análise</a></p>
                                    <form id="scan-form" method="POST" action="{{ route('qualidade.scan') }}" style="display: none;">
                                        @csrf
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Evolução da Qualidade</h3>
                            </div>
                            <div class="card-body">
                                <p>Gráfico de evolução aqui (placeholder)</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="custom-tabs-one-profile" role="tabpanel" aria-labelledby="custom-tabs-one-profile-tab">
                <a href="{{ route('qualidade.critical') }}" class="btn btn-warning">Ver Arquivos Críticos</a>
            </div>
            <div class="tab-pane fade" id="custom-tabs-one-messages" role="tabpanel" aria-labelledby="custom-tabs-one-messages-tab">
                <a href="{{ route('qualidade.queue') }}" class="btn btn-danger">Ver Fila de Refatoração</a>
            </div>
        </div>
    </div>
</div>
@stop

@section('plugins.Datatables', true)