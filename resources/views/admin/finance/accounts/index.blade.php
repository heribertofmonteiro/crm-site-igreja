@extends('adminlte::page')

@section('title', 'Contas Financeiras')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Contas Financeiras</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Finanças</li>
                    <li class="breadcrumb-item active">Contas</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Lista de Contas</h3>
                        <div class="card-tools">
                            <a href="{{ route('admin.finance.accounts.create') }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-plus"></i> Nova Conta
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Cards de Resumo -->
                        <div class="row mb-4">
                            <div class="col-md-3">
                                <div class="info-box">
                                    <span class="info-box-icon bg-info"><i class="fas fa-university"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Total de Contas</span>
                                        <span class="info-box-number">{{ $accounts->count() }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="info-box">
                                    <span class="info-box-icon bg-success"><i class="fas fa-wallet"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Saldo Total</span>
                                        <span class="info-box-number">
                                            R$ {{ number_format($accounts->sum('current_balance'), 2, ',', '.') }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="info-box">
                                    <span class="info-box-icon bg-warning"><i class="fas fa-exchange-alt"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Transações</span>
                                        <span class="info-box-number">{{ $accounts->sum('transactions_count') }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="info-box">
                                    <span class="info-box-icon bg-primary"><i class="fas fa-check-circle"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Ativas</span>
                                        <span class="info-box-number">{{ $accounts->where('is_active', true)->count() }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Lista de Contas -->
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Conta</th>
                                        <th>Tipo</th>
                                        <th>Banco</th>
                                        <th>Saldo Atual</th>
                                        <th>Responsável</th>
                                        <th>Transações</th>
                                        <th>Status</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($accounts as $account)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <i class="{{ $account->account_type_icon }} mr-2"></i>
                                                    <div>
                                                        <strong>{{ $account->name }}</strong>
                                                        @if($account->account_number)
                                                            <br><small class="text-muted">{{ $account->account_number }}</small>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge badge-info">{{ $account->account_type_label }}</span>
                                            </td>
                                            <td>{{ $account->bank_name ?? '--' }}</td>
                                            <td>
                                                <strong>{{ $account->formatted_current_balance }}</strong>
                                                <br><small class="text-muted">{{ $account->currency }}</small>
                                            </td>
                                            <td>{{ $account->responsible?->name ?? '--' }}</td>
                                            <td>
                                                <small class="text-muted">
                                                    {{ $account->transactions_count }}
                                                    @if($account->last_transaction)
                                                        <br>Última: {{ $account->last_transaction->formatted_transaction_date }}
                                                    @endif
                                                </small>
                                            </td>
                                            <td>
                                                @if($account->is_active)
                                                    <span class="badge badge-success">Ativa</span>
                                                @else
                                                    <span class="badge badge-secondary">Inativa</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <a href="{{ route('admin.finance.accounts.show', $account) }}" class="btn btn-outline-primary">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('admin.finance.accounts.edit', $account) }}" class="btn btn-outline-info">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <button type="button" class="btn btn-outline-warning" 
                                                            onclick="updateBalance({{ $account->id }})" title="Atualizar Saldo">
                                                        <i class="fas fa-sync"></i>
                                                    </button>
                                                    <form action="{{ route('admin.finance.accounts.destroy', $account) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-outline-danger" 
                                                                onclick="return confirm('Tem certeza?')">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center">
                                                <div class="alert alert-info">
                                                    <i class="fas fa-info-circle"></i> Nenhuma conta encontrada.
                                                    <a href="{{ route('admin.finance.accounts.create') }}" class="alert-link">Criar primeira conta</a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Paginação -->
                        <div class="d-flex justify-content-center">
                            {{ $accounts->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
function updateBalance(accountId) {
    if (confirm('Deseja atualizar o saldo desta conta?')) {
        fetch(`/admin/finance/accounts/${accountId}/update-balance`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Erro ao atualizar saldo: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Erro ao atualizar saldo');
        });
    }
}
</script>
@endpush
