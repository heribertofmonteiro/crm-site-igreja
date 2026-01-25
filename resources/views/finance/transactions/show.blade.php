@extends('adminlte::page')

@section('title', 'Detalhes da Transação')

@section('content_header')
    <h1>Detalhes da Transação</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Transação #{{ $transaction->id }}</h3>
        <div class="card-tools">
            @can('transactions.edit')
            <a href="{{ route('finance.transactions.edit', $transaction) }}" class="btn btn-warning btn-sm">
                <i class="fas fa-edit"></i> Editar
            </a>
            @endcan
            <a href="{{ route('finance.transactions.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Voltar
            </a>
        </div>
    </div>
    <div class="card-body">
        <dl class="row">
            <dt class="col-sm-3">Conta Financeira</dt>
            <dd class="col-sm-9">{{ $transaction->financialAccount->name }}</dd>

            <dt class="col-sm-3">Tipo</dt>
            <dd class="col-sm-9">{{ ucfirst($transaction->type) }}</dd>

            <dt class="col-sm-3">Valor</dt>
            <dd class="col-sm-9">R$ {{ number_format($transaction->amount, 2, ',', '.') }}</dd>

            <dt class="col-sm-3">Descrição</dt>
            <dd class="col-sm-9">{{ $transaction->description }}</dd>

            <dt class="col-sm-3">Data</dt>
            <dd class="col-sm-9">{{ $transaction->date->format('d/m/Y') }}</dd>

            <dt class="col-sm-3">Categoria</dt>
            <dd class="col-sm-9">{{ $transaction->category ?: 'Não informado' }}</dd>

            <dt class="col-sm-3">Criado em</dt>
            <dd class="col-sm-9">{{ $transaction->created_at->format('d/m/Y H:i') }}</dd>

            <dt class="col-sm-3">Atualizado em</dt>
            <dd class="col-sm-9">{{ $transaction->updated_at->format('d/m/Y H:i') }}</dd>
        </dl>
    </div>
</div>
@stop