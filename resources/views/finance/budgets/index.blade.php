@extends('adminlte::page')

@section('title', 'Orçamentos')

@section('content_header')
    <h1>Orçamentos</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Lista de Orçamentos</h3>
        @can('budgets.create')
        <div class="card-tools">
            <a href="{{ route('finance.budgets.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Novo Orçamento
            </a>
        </div>
        @endcan
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Valor</th>
                    <th>Ano</th>
                    <th>Mês</th>
                    <th>Categoria</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($budgets as $budget)
                <tr>
                    <td>{{ $budget->id }}</td>
                    <td>{{ $budget->name }}</td>
                    <td>R$ {{ number_format($budget->amount, 2, ',', '.') }}</td>
                    <td>{{ $budget->year }}</td>
                    <td>{{ $budget->month }}</td>
                    <td>{{ $budget->category ?: '-' }}</td>
                    <td>
                        @can('budgets.view')
                        <a href="{{ route('finance.budgets.show', $budget) }}" class="btn btn-info btn-sm">
                            <i class="fas fa-eye"></i>
                        </a>
                        @endcan
                        @can('budgets.edit')
                        <a href="{{ route('finance.budgets.edit', $budget) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i>
                        </a>
                        @endcan
                        @can('budgets.delete')
                        <form action="{{ route('finance.budgets.destroy', $budget) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                        @endcan
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{ $budgets->links() }}
    </div>
</div>
@stop