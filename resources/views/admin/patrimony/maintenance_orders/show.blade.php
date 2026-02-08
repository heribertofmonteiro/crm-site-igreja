@extends('adminlte::page')

@section('title', 'Detalhes da Ordem de Manutenção')

@section('content_header')
    <h1>Detalhes da Ordem de Manutenção</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Ordem #{{ $maintenanceOrder->id }}</h3>
        <div class="card-tools">
            @can('patrimony.maintenance_orders.edit')
            <a href="{{ route('patrimony.maintenance_orders.edit', $maintenanceOrder) }}" class="btn btn-warning btn-sm">
                <i class="fas fa-edit"></i> Editar
            </a>
            @endcan
            <a href="{{ route('patrimony.maintenance_orders.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Voltar
            </a>
        </div>
    </div>
    <div class="card-body">
        <dl class="row">
            <dt class="col-sm-3">Bem</dt>
            <dd class="col-sm-9">{{ $maintenanceOrder->asset->name }}</dd>

            <dt class="col-sm-3">Descrição</dt>
            <dd class="col-sm-9">{{ $maintenanceOrder->description }}</dd>

            <dt class="col-sm-3">Prioridade</dt>
            <dd class="col-sm-9">
                <span class="badge badge-{{ $maintenanceOrder->priority == 'urgent' ? 'danger' : ($maintenanceOrder->priority == 'high' ? 'warning' : 'info') }}">
                    {{ ucfirst($maintenanceOrder->priority) }}
                </span>
            </dd>

            <dt class="col-sm-3">Status</dt>
            <dd class="col-sm-9">
                <span class="badge badge-{{ $maintenanceOrder->status == 'completed' ? 'success' : ($maintenanceOrder->status == 'in_progress' ? 'primary' : 'secondary') }}">
                    {{ ucfirst(str_replace('_', ' ', $maintenanceOrder->status)) }}
                </span>
            </dd>

            <dt class="col-sm-3">Data Agendada</dt>
            <dd class="col-sm-9">{{ $maintenanceOrder->scheduled_date->format('d/m/Y H:i') }}</dd>

            <dt class="col-sm-3">Data de Conclusão</dt>
            <dd class="col-sm-9">{{ $maintenanceOrder->completed_date ? $maintenanceOrder->completed_date->format('d/m/Y H:i') : 'Não concluída' }}</dd>

            <dt class="col-sm-3">Atribuído a</dt>
            <dd class="col-sm-9">{{ $maintenanceOrder->assigned_to ?: 'Não atribuído' }}</dd>

            <dt class="col-sm-3">Notas</dt>
            <dd class="col-sm-9">{{ $maintenanceOrder->notes ?: 'Nenhuma nota' }}</dd>

            <dt class="col-sm-3">Criado em</dt>
            <dd class="col-sm-9">{{ $maintenanceOrder->created_at->format('d/m/Y H:i') }}</dd>

            <dt class="col-sm-3">Atualizado em</dt>
            <dd class="col-sm-9">{{ $maintenanceOrder->updated_at->format('d/m/Y H:i') }}</dd>
        </dl>
    </div>
</div>
@stop