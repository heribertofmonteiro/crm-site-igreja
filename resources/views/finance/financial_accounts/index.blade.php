@extends('adminlte::page')

@section('title', 'Contas Financeiras')

@section('content_header')
    <h1>Contas Financeiras</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Lista de Contas Financeiras</h3>
        @can('financial_accounts.create')
        <div class="card-tools">
            <a href="{{ route('finance.financial_accounts.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Nova Conta
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
                    <th>Tipo</th>
                    <th>Saldo</th>
                    <th>Descrição</th>
                    <th>Criado em</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($financialAccounts as $account)
                <tr>
                    <td>{{ $account->id }}</td>
                    <td>{{ $account->name }}</td>
                    <td>{{ ucfirst($account->type) }}</td>
                    <td>R$ {{ number_format($account->balance, 2, ',', '.') }}</td>
                    <td>{{ $account->description ?: '-' }}</td>
                    <td>{{ $account->created_at->format('d/m/Y') }}</td>
                    <td>
                        @can('financial_accounts.view')
                        <a href="{{ route('finance.financial_accounts.show', $account) }}" class="btn btn-info btn-sm">
                            <i class="fas fa-eye"></i>
                        </a>
                        @endcan
                        @can('financial_accounts.edit')
                        <a href="{{ route('finance.financial_accounts.edit', $account) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i>
                        </a>
                        @endcan
                        @can('financial_accounts.delete')
                        <form action="{{ route('finance.financial_accounts.destroy', $account) }}" method="POST" style="display: inline;">
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
        {{ $financialAccounts->links() }}
    </div>
</div>
@stop