@extends('adminlte::page')

@section('title', 'Relatório de Auditoria Financeira')

@section('content_header')
    <h1>Relatório de Auditoria Financeira</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Relatório da Auditoria #{{ $financialAudit->id }}</h3>
    </div>
    <div class="card-body">
        <h4>Informações Gerais</h4>
        <p><strong>Data da Auditoria:</strong> {{ $financialAudit->audit_date->format('d/m/Y') }}</p>
        <p><strong>Período Auditado:</strong> {{ $financialAudit->period_start->format('d/m/Y') }} - {{ $financialAudit->period_end->format('d/m/Y') }}</p>
        <p><strong>Status:</strong>
            @if($financialAudit->status == 'pending')
                Pendente
            @elseif($financialAudit->status == 'in_progress')
                Em Andamento
            @else
                Concluída
            @endif
        </p>
        <p><strong>Auditor:</strong> {{ $financialAudit->auditor ?: 'Não informado' }}</p>

        <h4>Achados</h4>
        <p>{{ $financialAudit->findings ?: 'Nenhum achado registrado.' }}</p>

        <h4>Recomendações</h4>
        <p>{{ $financialAudit->recommendations ?: 'Nenhuma recomendação registrada.' }}</p>

        <div class="mt-3">
            <a href="{{ route('financial-audits.index') }}" class="btn btn-secondary">Voltar</a>
            <button onclick="window.print()" class="btn btn-primary">Imprimir</button>
        </div>
    </div>
</div>
@stop