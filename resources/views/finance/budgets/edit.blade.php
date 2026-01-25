@extends('adminlte::page')

@section('title', 'Editar Orçamento')

@section('content_header')
    <h1>Editar Orçamento</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Editar Orçamento</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('finance.budgets.update', $budget) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">Nome</label>
                <input type="text" name="name" class="form-control" value="{{ $budget->name }}" required>
            </div>
            <div class="form-group">
                <label for="amount">Valor</label>
                <input type="number" step="0.01" name="amount" class="form-control" value="{{ $budget->amount }}" required>
            </div>
            <div class="form-group">
                <label for="year">Ano</label>
                <input type="number" name="year" class="form-control" value="{{ $budget->year }}" required>
            </div>
            <div class="form-group">
                <label for="month">Mês</label>
                <select name="month" class="form-control" required>
                    @for($i = 1; $i <= 12; $i++)
                    <option value="{{ $i }}" {{ $budget->month == $i ? 'selected' : '' }}>{{ date('F', mktime(0, 0, 0, $i, 1)) }}</option>
                    @endfor
                </select>
            </div>
            <div class="form-group">
                <label for="category">Categoria</label>
                <input type="text" name="category" class="form-control" value="{{ $budget->category }}">
            </div>
            <button type="submit" class="btn btn-primary">Atualizar</button>
            <a href="{{ route('finance.budgets.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</div>
@stop