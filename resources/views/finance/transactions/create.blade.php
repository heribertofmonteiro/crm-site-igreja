@extends('adminlte::page')

@section('title', 'Nova Transação')

@section('content_header')
    <h1>Nova Transação</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Criar Nova Transação</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('finance.transactions.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="financial_account_id">Conta Financeira</label>
                <select name="financial_account_id" class="form-control" required>
                    @foreach($financialAccounts as $account)
                    <option value="{{ $account->id }}">{{ $account->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="type">Tipo</label>
                <select name="type" class="form-control" required>
                    <option value="income">Receita</option>
                    <option value="expense">Despesa</option>
                </select>
            </div>
            <div class="form-group">
                <label for="amount">Valor</label>
                <input type="number" step="0.01" name="amount" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="description">Descrição</label>
                <textarea name="description" class="form-control" required></textarea>
            </div>
            <div class="form-group">
                <label for="date">Data</label>
                <input type="date" name="date" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="category">Categoria</label>
                <input type="text" name="category" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Salvar</button>
            <a href="{{ route('finance.transactions.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</div>
@stop