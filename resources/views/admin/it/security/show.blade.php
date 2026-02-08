@extends('adminlte::page')

@section('title', 'Detalhes do Incidente de Segurança')

@section('content_header')
    <h1>Detalhes do Incidente de Segurança</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Detalhes do Incidente: {{ $securityIncident->title }}</h3>
        <div class="card-tools">
            @can('security.edit')
            <a href="{{ route('admin.it.security.edit', $securityIncident) }}" class="btn btn-warning btn-sm">
                <i class="fas fa-edit"></i> Editar
            </a>
            @endcan
            <a href="{{ route('admin.it.security.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Voltar
            </a>
        </div>
    </div>
    <div class="card-body">
        <dl class="row">
            <dt class="col-sm-3">ID</dt>
            <dd class="col-sm-9">{{ $securityIncident->id }}</dd>

            <dt class="col-sm-3">Título</dt>
            <dd class="col-sm-9">{{ $securityIncident->title }}</dd>

            <dt class="col-sm-3">Descrição</dt>
            <dd class="col-sm-9">{{ $securityIncident->description }}</dd>

            <dt class="col-sm-3">Severidade</dt>
            <dd class="col-sm-9">{{ ucfirst($securityIncident->severity) }}</dd>

            <dt class="col-sm-3">Status</dt>
            <dd class="col-sm-9">{{ ucfirst($securityIncident->status) }}</dd>

            <dt class="col-sm-3">Reportado por</dt>
            <dd class="col-sm-9">{{ $securityIncident->reporter->name }}</dd>

            <dt class="col-sm-3">Data do Relatório</dt>
            <dd class="col-sm-9">{{ $securityIncident->reported_at->format('d/m/Y H:i') }}</dd>

            <dt class="col-sm-3">Data da Resolução</dt>
            <dd class="col-sm-9">{{ $securityIncident->resolved_at ? $securityIncident->resolved_at->format('d/m/Y H:i') : 'N/A' }}</dd>

            <dt class="col-sm-3">Criado em</dt>
            <dd class="col-sm-9">{{ $securityIncident->created_at->format('d/m/Y H:i') }}</dd>

            <dt class="col-sm-3">Atualizado em</dt>
            <dd class="col-sm-9">{{ $securityIncident->updated_at->format('d/m/Y H:i') }}</dd>
        </dl>
    </div>
</div>
@stop