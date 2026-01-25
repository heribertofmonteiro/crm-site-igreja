@extends('adminlte::page')

@section('title', 'Detalhes da Obrigação de Conformidade')

@section('content_header')
    <h1>Detalhes da Obrigação de Conformidade</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">{{ $complianceObligation->title }}</h3>
        <div class="card-tools">
            @can('compliance_obligations.edit')
            <a href="{{ route('admin.legal.compliance_obligations.edit', $complianceObligation) }}" class="btn btn-warning btn-sm">
                <i class="fas fa-edit"></i> Editar
            </a>
            @endcan
            <a href="{{ route('admin.legal.compliance_obligations.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Voltar
            </a>
        </div>
    </div>
    <div class="card-body">
        <dl class="row">
            <dt class="col-sm-3">Título</dt>
            <dd class="col-sm-9">{{ $complianceObligation->title }}</dd>

            <dt class="col-sm-3">Descrição</dt>
            <dd class="col-sm-9">{{ $complianceObligation->description ?: 'Não informado' }}</dd>

            <dt class="col-sm-3">Tipo de Obrigação</dt>
            <dd class="col-sm-9">{{ ucfirst($complianceObligation->obligation_type) }}</dd>

            <dt class="col-sm-3">Data de Vencimento</dt>
            <dd class="col-sm-9">{{ $complianceObligation->due_date->format('d/m/Y') }}</dd>

            <dt class="col-sm-3">Status</dt>
            <dd class="col-sm-9">
                <span class="badge badge-{{ $complianceObligation->status == 'completed' ? 'success' : ($complianceObligation->status == 'overdue' ? 'danger' : 'warning') }}">
                    {{ ucfirst($complianceObligation->status) }}
                </span>
            </dd>

            <dt class="col-sm-3">Responsável</dt>
            <dd class="col-sm-9">{{ $complianceObligation->responsibleUser->name ?? 'N/A' }}</dd>

            <dt class="col-sm-3">Notas</dt>
            <dd class="col-sm-9">{{ $complianceObligation->notes ?: 'Não informado' }}</dd>

            <dt class="col-sm-3">Criado em</dt>
            <dd class="col-sm-9">{{ $complianceObligation->created_at->format('d/m/Y H:i') }}</dd>

            <dt class="col-sm-3">Atualizado em</dt>
            <dd class="col-sm-9">{{ $complianceObligation->updated_at->format('d/m/Y H:i') }}</dd>
        </dl>
    </div>
</div>
@stop