@extends('adminlte::page')

@section('title', 'DB Inspector')

@section('content_header')
    <h1>Database Inspector</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Ferramentas de Inspeção de Banco de Dados</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <ul class="nav nav-tabs" id="db-inspector-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="schema-tab" data-toggle="tab" href="#schema" role="tab">Schema Watcher</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="query-tab" data-toggle="tab" href="#query" role="tab">Query Analyzer</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="integridade-tab" data-toggle="tab" href="#integridade" role="tab">Integridade</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="cache-tab" data-toggle="tab" href="#cache" role="tab">Cache (Redis)</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="relacionamentos-tab" data-toggle="tab" href="#relacionamentos" role="tab">Mapa de Relacionamentos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="migrations-tab" data-toggle="tab" href="#migrations" role="tab">Relatório de Migrations</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="nplusone-tab" data-toggle="tab" href="#nplusone" role="tab">Detector N+1</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="tipagem-tab" data-toggle="tab" href="#tipagem" role="tab">Auditoria de Tipagem</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="agents-tab" data-toggle="tab" href="#agents" role="tab">Validador AGENTS.md</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="slowlog-tab" data-toggle="tab" href="#slowlog" role="tab">Slow Query Log</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="carga-tab" data-toggle="tab" href="#carga" role="tab">Simulador de Carga</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="indices-tab" data-toggle="tab" href="#indices" role="tab">Auto-Fix de Índices</a>
                    </li>
                </ul>
                <div class="tab-content" id="db-inspector-content">
                    <div class="tab-pane fade show active" id="schema" role="tabpanel">
                        @include('admin.db_inspector.schema_watcher')
                    </div>
                    <div class="tab-pane fade" id="query" role="tabpanel">
                        @include('admin.db_inspector.query_analyzer')
                    </div>
                    <div class="tab-pane fade" id="integridade" role="tabpanel">
                        @include('admin.db_inspector.integridade')
                    </div>
                    <div class="tab-pane fade" id="cache" role="tabpanel">
                        @include('admin.db_inspector.cache')
                    </div>
                    <div class="tab-pane fade" id="relacionamentos" role="tabpanel">
                        @include('admin.db_inspector.mapa_relacionamentos')
                    </div>
                    <div class="tab-pane fade" id="migrations" role="tabpanel">
                        @include('admin.db_inspector.relatorio_migrations')
                    </div>
                    <div class="tab-pane fade" id="nplusone" role="tabpanel">
                        @include('admin.db_inspector.detector_n_plus_one')
                    </div>
                    <div class="tab-pane fade" id="tipagem" role="tabpanel">
                        @include('admin.db_inspector.auditoria_tipagem')
                    </div>
                    <div class="tab-pane fade" id="agents" role="tabpanel">
                        @include('admin.db_inspector.validador_agents')
                    </div>
                    <div class="tab-pane fade" id="slowlog" role="tabpanel">
                        @include('admin.db_inspector.slow_query_log')
                    </div>
                    <div class="tab-pane fade" id="carga" role="tabpanel">
                        @include('admin.db_inspector.simulador_carga')
                    </div>
                    <div class="tab-pane fade" id="indices" role="tabpanel">
                        @include('admin.db_inspector.auto_fix_indices')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('js')
<script>
$(document).ready(function() {
    // Initialize tabs
    $('#db-inspector-tabs a').on('click', function (e) {
        e.preventDefault();
        $(this).tab('show');
    });

    // Load tab content dynamically if needed
    $('#db-inspector-tabs a').on('shown.bs.tab', function (e) {
        var target = $(e.target).attr("href");
        // Could load content via AJAX here if needed
    });
});
</script>
@stop