@extends('adminlte::page')

@section('title', 'Detalhes do Projeto Missionário')

@section('content_header')
    <h1>Detalhes do Projeto Missionário</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">{{ $project->name }}</h3>
        <div class="card-tools">
            <a href="{{ route('missions.projects.edit', $project) }}" class="btn btn-warning btn-sm">
                <i class="fas fa-edit"></i> Editar
            </a>
            <a href="{{ route('missions.projects.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-list"></i> Voltar
            </a>
        </div>
    </div>
    <div class="card-body">
        <dl class="row">
            <dt class="col-sm-3">Nome</dt>
            <dd class="col-sm-9">{{ $project->name }}</dd>

            <dt class="col-sm-3">Descrição</dt>
            <dd class="col-sm-9">{{ $project->description ?: 'N/A' }}</dd>

            <dt class="col-sm-3">Localização</dt>
            <dd class="col-sm-9">{{ $project->location }}</dd>

            <dt class="col-sm-3">Data de Início</dt>
            <dd class="col-sm-9">{{ $project->start_date->format('d/m/Y') }}</dd>

            <dt class="col-sm-3">Data de Fim</dt>
            <dd class="col-sm-9">{{ $project->end_date ? $project->end_date->format('d/m/Y') : 'N/A' }}</dd>

            <dt class="col-sm-3">Orçamento</dt>
            <dd class="col-sm-9">{{ $project->budget ? 'R$ ' . number_format($project->budget, 2, ',', '.') : 'N/A' }}</dd>

            <dt class="col-sm-3">Missionário</dt>
            <dd class="col-sm-9">
                <a href="{{ route('missions.missionaries.show', $project->missionary) }}">{{ $project->missionary->name }}</a>
            </dd>

            <dt class="col-sm-3">Status</dt>
            <dd class="col-sm-9">
                <span class="badge badge-{{ $project->status === 'active' ? 'success' : 'secondary' }}">
                    {{ ucfirst($project->status) }}
                </span>
            </dd>
        </dl>
    </div>
</div>
@stop