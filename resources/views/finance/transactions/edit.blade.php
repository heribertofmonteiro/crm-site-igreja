@extends('adminlte::page')

@section('title', 'Editar Transação')

@section('content_header')
    <h1>Editar Transação</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Editar Transação</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('finance.transactions.update', $transaction) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="financial_account_id">Conta Financeira</label>
                <select name="financial_account_id" class="form-control" required>
                    @foreach($financialAccounts as $account)
                    <option value="{{ $account->id }}" {{ $transaction->financial_account_id == $account->id ? 'selected' : '' }}>{{ $account->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="type">Tipo</label>
                <select name="type" class="form-control" required>
                    <option value="income" {{ $transaction->type == 'income' ? 'selected' : '' }}>Receita</option>
                    <option value="expense" {{ $transaction->type == 'expense' ? 'selected' : '' }}>Despesa</option>
                </select>
            </div>
            <div class="form-group">
                <label for="amount">Valor</label>
                <input type="number" step="0.01" name="amount" class="form-control" value="{{ $transaction->amount }}" required>
            </div>
            <div class="form-group">
                <label for="description">Descrição</label>
                <textarea name="description" class="form-control" required>{{ $transaction->description }}</textarea>
            </div>
            <div class="form-group">
                <label for="date">Data</label>
                <input type="date" name="date" class="form-control" value="{{ $transaction->date->format('Y-m-d') }}" required>
            </div>
            <div class="form-group">
                <label for="category">Categoria</label>
                <input type="text" name="category" class="form-control" value="{{ $transaction->category }}">
            </div>
            <button type="submit" class="btn btn-primary">Atualizar</button>
            <a href="{{ route('finance.transactions.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</div>
@stop