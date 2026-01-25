@extends('adminlte::page')

@section('title', 'Detalhes do Suporte Missionário')

@section('content_header')
    <h1>Detalhes do Suporte Missionário</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Suporte: {{ $support->missionary->name }} - {{ $support->supporter->name }}</h3>
        <div class="card-tools">
            <a href="{{ route('missions.supports.edit', $support) }}" class="btn btn-warning btn-sm">
                <i class="fas fa-edit"></i> Editar
            </a>
            <a href="{{ route('missions.supports.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-list"></i> Voltar
            </a>
        </div>
    </div>
    <div class="card-body">
        <dl class="row">
            <dt class="col-sm-3">Missionário</dt>
            <dd class="col-sm-9">
                <a href="{{ route('missions.missionaries.show', $support->missionary) }}">{{ $support->missionary->name }}</a>
            </dd>

            <dt class="col-sm-3">Apoiador</dt>
            <dd class="col-sm-9">
                <a href="{{ route('admin.members.show', $support->supporter) }}">{{ $support->supporter->name }}</a>
            </dd>

            <dt class="col-sm-3">Valor</dt>
            <dd class="col-sm-9">R$ {{ number_format($support->amount, 2, ',', '.') }}</dd>

            <dt class="col-sm-3">Frequência</dt>
            <dd class="col-sm-9">{{ ucfirst($support->frequency) }}</dd>

            <dt class="col-sm-3">Data de Início</dt>
            <dd class="col-sm-9">{{ $support->start_date->format('d/m/Y') }}</dd>

            <dt class="col-sm-3">Data de Fim</dt>
            <dd class="col-sm-9">{{ $support->end_date ? $support->end_date->format('d/m/Y') : 'N/A' }}</dd>

            <dt class="col-sm-3">Status</dt>
            <dd class="col-sm-9">
                <span class="badge badge-{{ $support->status === 'active' ? 'success' : 'secondary' }}">
                    {{ ucfirst($support->status) }}
                </span>
            </dd>
        </dl>
    </div>
</div>
@stop