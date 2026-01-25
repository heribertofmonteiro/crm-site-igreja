@extends('adminlte::page')

@section('title', 'Detalhes da Conta Financeira')

@section('content_header')
    <h1>Detalhes da Conta Financeira</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">{{ $financialAccount->name }}</h3>
        <div class="card-tools">
            @can('financial_accounts.edit')
            <a href="{{ route('finance.financial_accounts.edit', $financialAccount) }}" class="btn btn-warning btn-sm">
                <i class="fas fa-edit"></i> Editar
            </a>
            @endcan
            <a href="{{ route('finance.financial_accounts.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Voltar
            </a>
        </div>
    </div>
    <div class="card-body">
        <dl class="row">
            <dt class="col-sm-3">Nome</dt>
            <dd class="col-sm-9">{{ $financialAccount->name }}</dd>

            <dt class="col-sm-3">Tipo</dt>
            <dd class="col-sm-9">{{ ucfirst($financialAccount->type) }}</dd>

            <dt class="col-sm-3">Saldo</dt>
            <dd class="col-sm-9">R$ {{ number_format($financialAccount->balance, 2, ',', '.') }}</dd>

            <dt class="col-sm-3">Descrição</dt>
            <dd class="col-sm-9">{{ $financialAccount->description ?: 'Não informado' }}</dd>

            <dt class="col-sm-3">Criado em</dt>
            <dd class="col-sm-9">{{ $financialAccount->created_at->format('d/m/Y H:i') }}</dd>

            <dt class="col-sm-3">Atualizado em</dt>
            <dd class="col-sm-9">{{ $financialAccount->updated_at->format('d/m/Y H:i') }}</dd>
        </dl>
    </div>
</div>
@stop