@extends('adminlte::page')

@section('title', 'Detalhes da Auditoria Financeira')

@section('content_header')
    <h1>Detalhes da Auditoria Financeira</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Auditoria #{{ $financialAudit->id }}</h3>
        <div class="card-tools">
            <a href="{{ route('financial-audits.edit', $financialAudit) }}" class="btn btn-warning btn-sm">
                <i class="fas fa-edit"></i> Editar
            </a>
            <a href="{{ route('financial-audits.report', $financialAudit) }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-file-alt"></i> Relatório
            </a>
        </div>
    </div>
    <div class="card-body">
        <dl class="row">
            <dt class="col-sm-3">Data da Auditoria</dt>
            <dd class="col-sm-9">{{ $financialAudit->audit_date->format('d/m/Y') }}</dd>

            <dt class="col-sm-3">Período</dt>
            <dd class="col-sm-9">{{ $financialAudit->period_start->format('d/m/Y') }} - {{ $financialAudit->period_end->format('d/m/Y') }}</dd>

            <dt class="col-sm-3">Status</dt>
            <dd class="col-sm-9">
                @if($financialAudit->status == 'pending')
                    <span class="badge badge-warning">Pendente</span>
                @elseif($financialAudit->status == 'in_progress')
                    <span class="badge badge-info">Em Andamento</span>
                @else
                    <span class="badge badge-success">Concluída</span>
                @endif
            </dd>

            <dt class="col-sm-3">Auditor</dt>
            <dd class="col-sm-9">{{ $financialAudit->auditor ?: '-' }}</dd>

            <dt class="col-sm-3">Achados</dt>
            <dd class="col-sm-9">{{ $financialAudit->findings ?: '-' }}</dd>

            <dt class="col-sm-3">Recomendações</dt>
            <dd class="col-sm-9">{{ $financialAudit->recommendations ?: '-' }}</dd>
        </dl>
    </div>
</div>
@stop