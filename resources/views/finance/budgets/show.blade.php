@extends('adminlte::page')

@section('title', 'Detalhes do Orçamento')

@section('content_header')
    <h1>Detalhes do Orçamento</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">{{ $budget->name }}</h3>
        <div class="card-tools">
            @can('budgets.edit')
            <a href="{{ route('finance.budgets.edit', $budget) }}" class="btn btn-warning btn-sm">
                <i class="fas fa-edit"></i> Editar
            </a>
            @endcan
            <a href="{{ route('finance.budgets.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Voltar
            </a>
        </div>
    </div>
    <div class="card-body">
        <dl class="row">
            <dt class="col-sm-3">Nome</dt>
            <dd class="col-sm-9">{{ $budget->name }}</dd>

            <dt class="col-sm-3">Valor</dt>
            <dd class="col-sm-9">R$ {{ number_format($budget->amount, 2, ',', '.') }}</dd>

            <dt class="col-sm-3">Ano</dt>
            <dd class="col-sm-9">{{ $budget->year }}</dd>

            <dt class="col-sm-3">Mês</dt>
            <dd class="col-sm-9">{{ date('F', mktime(0, 0, 0, $budget->month, 1)) }}</dd>

            <dt class="col-sm-3">Categoria</dt>
            <dd class="col-sm-9">{{ $budget->category ?: 'Não informado' }}</dd>

            <dt class="col-sm-3">Criado em</dt>
            <dd class="col-sm-9">{{ $budget->created_at->format('d/m/Y H:i') }}</dd>

            <dt class="col-sm-3">Atualizado em</dt>
            <dd class="col-sm-9">{{ $budget->updated_at->format('d/m/Y H:i') }}</dd>
        </dl>
    </div>
</div>
@stop