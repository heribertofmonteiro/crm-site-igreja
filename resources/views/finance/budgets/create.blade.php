@extends('adminlte::page')

@section('title', 'Novo Orçamento')

@section('content_header')
    <h1>Novo Orçamento</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Criar Novo Orçamento</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('finance.budgets.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Nome</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="amount">Valor</label>
                <input type="number" step="0.01" name="amount" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="year">Ano</label>
                <input type="number" name="year" class="form-control" value="{{ date('Y') }}" required>
            </div>
            <div class="form-group">
                <label for="month">Mês</label>
                <select name="month" class="form-control" required>
                    @for($i = 1; $i <= 12; $i++)
                    <option value="{{ $i }}" {{ $i == date('m') ? 'selected' : '' }}>{{ date('F', mktime(0, 0, 0, $i, 1)) }}</option>
                    @endfor
                </select>
            </div>
            <div class="form-group">
                <label for="category">Categoria</label>
                <input type="text" name="category" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Salvar</button>
            <a href="{{ route('finance.budgets.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</div>
@stop