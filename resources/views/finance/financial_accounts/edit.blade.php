@extends('adminlte::page')

@section('title', 'Editar Conta Financeira')

@section('content_header')
    <h1>Editar Conta Financeira</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Editar Conta Financeira</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('finance.financial_accounts.update', $financialAccount) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">Nome</label>
                <input type="text" name="name" class="form-control" value="{{ $financialAccount->name }}" required>
            </div>
            <div class="form-group">
                <label for="type">Tipo</label>
                <select name="type" class="form-control" required>
                    <option value="checking" {{ $financialAccount->type == 'checking' ? 'selected' : '' }}>Conta Corrente</option>
                    <option value="savings" {{ $financialAccount->type == 'savings' ? 'selected' : '' }}>Conta Poupança</option>
                    <option value="investment" {{ $financialAccount->type == 'investment' ? 'selected' : '' }}>Investimento</option>
                </select>
            </div>
            <div class="form-group">
                <label for="balance">Saldo</label>
                <input type="number" step="0.01" name="balance" class="form-control" value="{{ $financialAccount->balance }}" required>
            </div>
            <div class="form-group">
                <label for="description">Descrição</label>
                <textarea name="description" class="form-control">{{ $financialAccount->description }}</textarea>
            </div>
            <button type="submit" class="btn btn-primary">Atualizar</button>
            <a href="{{ route('finance.financial_accounts.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</div>
@stop