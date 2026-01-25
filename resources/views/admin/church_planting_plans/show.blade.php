@extends('adminlte::page')

@section('title', 'Detalhes do Plano de Plantação')

@section('content_header')
    <h1>Detalhes do Plano de Plantação</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">{{ $plan->name }}</h3>
        <div class="card-tools">
            <a href="{{ route('expansion.church-planting-plans.edit', $plan) }}" class="btn btn-warning btn-sm">
                <i class="fas fa-edit"></i> Editar
            </a>
            <a href="{{ route('expansion.church-planting-plans.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Voltar
            </a>
        </div>
    </div>
    <div class="card-body">
        <dl class="row">
            <dt class="col-sm-3">Nome</dt>
            <dd class="col-sm-9">{{ $plan->name }}</dd>

            <dt class="col-sm-3">Descrição</dt>
            <dd class="col-sm-9">{{ $plan->description ?: 'Não informado' }}</dd>

            <dt class="col-sm-3">Localização</dt>
            <dd class="col-sm-9">{{ $plan->location }}</dd>

            <dt class="col-sm-3">Data de Início Planejada</dt>
            <dd class="col-sm-9">{{ $plan->planned_start_date ? $plan->planned_start_date->format('d/m/Y') : 'Não informado' }}</dd>

            <dt class="col-sm-3">Data de Fim Planejada</dt>
            <dd class="col-sm-9">{{ $plan->planned_end_date ? $plan->planned_end_date->format('d/m/Y') : 'Não informado' }}</dd>

            <dt class="col-sm-3">Status</dt>
            <dd class="col-sm-9">
                <span class="badge badge-{{ $plan->status == 'completed' ? 'success' : ($plan->status == 'in_progress' ? 'warning' : 'secondary') }}">
                    {{ ucfirst(str_replace('_', ' ', $plan->status)) }}
                </span>
            </dd>

            <dt class="col-sm-3">Orçamento</dt>
            <dd class="col-sm-9">{{ $plan->budget ? 'R$ ' . number_format($plan->budget, 2, ',', '.') : 'Não informado' }}</dd>

            <dt class="col-sm-3">Líder</dt>
            <dd class="col-sm-9">{{ $plan->leader ? $plan->leader->name : 'Não informado' }}</dd>

            <dt class="col-sm-3">Criado em</dt>
            <dd class="col-sm-9">{{ $plan->created_at->format('d/m/Y H:i') }}</dd>

            <dt class="col-sm-3">Atualizado em</dt>
            <dd class="col-sm-9">{{ $plan->updated_at->format('d/m/Y H:i') }}</dd>
        </dl>
    </div>
</div>
@stop