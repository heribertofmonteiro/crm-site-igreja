@extends('adminlte::page')

@section('title', 'Log de Acesso')

@section('content_header')
    <h1>Log de Acesso #{{ $log->id }}</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Detalhes do Log de Acesso</h3>
        <div class="card-tools">
            <a href="{{ route('admin.it.access.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-list"></i> Voltar
            </a>
        </div>
    </div>
    <div class="card-body">
        <dl class="row">
            <dt class="col-sm-3">ID:</dt>
            <dd class="col-sm-9">{{ $log->id }}</dd>

            <dt class="col-sm-3">Usuário:</dt>
            <dd class="col-sm-9">{{ $log->user->name ?? 'N/A' }} ({{ $log->user->email ?? 'N/A' }})</dd>

            <dt class="col-sm-3">Ação:</dt>
            <dd class="col-sm-9">{{ $log->action }}</dd>

            <dt class="col-sm-3">IP:</dt>
            <dd class="col-sm-9">{{ $log->ip_address }}</dd>

            <dt class="col-sm-3">User Agent:</dt>
            <dd class="col-sm-9">{{ $log->user_agent }}</dd>

            <dt class="col-sm-3">Acessado em:</dt>
            <dd class="col-sm-9">{{ $log->accessed_at->format('d/m/Y H:i:s') }}</dd>

            <dt class="col-sm-3">Criado em:</dt>
            <dd class="col-sm-9">{{ $log->created_at->format('d/m/Y H:i:s') }}</dd>

            <dt class="col-sm-3">Atualizado em:</dt>
            <dd class="col-sm-9">{{ $log->updated_at->format('d/m/Y H:i:s') }}</dd>
        </dl>
    </div>
</div>
@stop