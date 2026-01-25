@extends('adminlte::page')

@section('title', 'Nova Conta Financeira')

@section('content_header')
    <h1>Nova Conta Financeira</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Criar Nova Conta Financeira</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('finance.financial_accounts.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Nome</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="type">Tipo</label>
                <select name="type" class="form-control" required>
                    <option value="checking">Conta Corrente</option>
                    <option value="savings">Conta Poupança</option>
                    <option value="investment">Investimento</option>
                </select>
            </div>
            <div class="form-group">
                <label for="balance">Saldo Inicial</label>
                <input type="number" step="0.01" name="balance" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="description">Descrição</label>
                <textarea name="description" class="form-control"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Salvar</button>
            <a href="{{ route('finance.financial_accounts.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</div>
@stop