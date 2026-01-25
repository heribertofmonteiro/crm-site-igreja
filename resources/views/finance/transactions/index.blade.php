@extends('adminlte::page')

@section('title', 'Transações')

@section('content_header')
    <h1>Transações</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Lista de Transações</h3>
        @can('transactions.create')
        <div class="card-tools">
            <a href="{{ route('finance.transactions.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Nova Transação
            </a>
        </div>
        @endcan
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Conta</th>
                    <th>Tipo</th>
                    <th>Valor</th>
                    <th>Descrição</th>
                    <th>Data</th>
                    <th>Categoria</th>
                    <th>Doador</th>
                    <th>Tipo Doação</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transactions as $transaction)
                <tr>
                    <td>{{ $transaction->id }}</td>
                    <td>{{ $transaction->financialAccount->name }}</td>
                    <td>{{ ucfirst($transaction->type) }}</td>
                    <td>R$ {{ number_format($transaction->amount, 2, ',', '.') }}</td>
                    <td>{{ $transaction->description }}</td>
                    <td>{{ $transaction->date->format('d/m/Y') }}</td>
                    <td>{{ $transaction->category ?: '-' }}</td>
                    <td>{{ $transaction->donor_name ?: '-' }}</td>
                    <td>{{ $transaction->donation_type ?: '-' }}</td>
                    <td>
                        @can('transactions.view')
                        <a href="{{ route('finance.transactions.show', $transaction) }}" class="btn btn-info btn-sm">
                            <i class="fas fa-eye"></i>
                        </a>
                        @endcan
                        @can('transactions.edit')
                        <a href="{{ route('finance.transactions.edit', $transaction) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i>
                        </a>
                        @endcan
                        @can('transactions.delete')
                        <form action="{{ route('finance.transactions.destroy', $transaction) }}" method="POST" style="display: inline;">
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
        {{ $transactions->links() }}
    </div>
</div>
@stop