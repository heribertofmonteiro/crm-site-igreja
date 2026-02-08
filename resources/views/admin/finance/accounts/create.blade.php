@extends('adminlte::page')

@section('title', 'Nova Conta Financeira')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Nova Conta Financeira</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Finanças</li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.finance.accounts.index') }}">Contas</a></li>
                    <li class="breadcrumb-item active">Nova</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Informações da Conta</h3>
                    </div>
                    <form action="{{ route('admin.finance.accounts.store') }}" method="POST">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Nome da Conta <span class="text-danger">*</span></label>
                                        <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" 
                                               value="{{ old('name') }}" required>
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="account_type">Tipo de Conta <span class="text-danger">*</span></label>
                                        <select id="account_type" name="account_type" class="form-control @error('account_type') is-invalid @enderror" required>
                                            <option value="">Selecione...</option>
                                            <option value="checking" {{ old('account_type') == 'checking' ? 'selected' : '' }}>Conta Corrente</option>
                                            <option value="savings" {{ old('account_type') == 'savings' ? 'selected' : '' }}>Poupança</option>
                                            <option value="investment" {{ old('account_type') == 'investment' ? 'selected' : '' }}>Investimento</option>
                                            <option value="credit_card" {{ old('account_type') == 'credit_card' ? 'selected' : '' }}>Cartão de Crédito</option>
                                        </select>
                                        @error('account_type')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="bank_name">Banco</label>
                                        <input type="text" id="bank_name" name="bank_name" class="form-control @error('bank_name') is-invalid @enderror" 
                                               value="{{ old('bank_name') }}">
                                        @error('bank_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="currency">Moeda</label>
                                        <select id="currency" name="currency" class="form-control @error('currency') is-invalid @enderror">
                                            <option value="BRL" {{ old('currency', 'BRL') == 'BRL' ? 'selected' : '' }}>Real (BRL)</option>
                                            <option value="USD" {{ old('currency') == 'USD' ? 'selected' : '' }}>Dólar (USD)</option>
                                            <option value="EUR" {{ old('currency') == 'EUR' ? 'selected' : '' }}>Euro (EUR)</option>
                                        </select>
                                        @error('currency')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="agency_number">Agência</label>
                                        <input type="text" id="agency_number" name="agency_number" class="form-control @error('agency_number') is-invalid @enderror" 
                                               value="{{ old('agency_number') }}">
                                        @error('agency_number')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="account_number">Número da Conta</label>
                                        <input type="text" id="account_number" name="account_number" class="form-control @error('account_number') is-invalid @enderror" 
                                               value="{{ old('account_number') }}">
                                        @error('account_number')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="opening_balance">Saldo Inicial <span class="text-danger">*</span></label>
                                        <input type="number" id="opening_balance" name="opening_balance" class="form-control @error('opening_balance') is-invalid @enderror" 
                                               value="{{ old('opening_balance') }}" step="0.01" min="0" required>
                                        @error('opening_balance')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="responsible_id">Responsável</label>
                                        <select id="responsible_id" name="responsible_id" class="form-control @error('responsible_id') is-invalid @enderror">
                                            <option value="">Selecione...</option>
                                            @foreach(\App\Models\User::orderBy('name')->get() as $user)
                                                <option value="{{ $user->id }}" {{ old('responsible_id') == $user->id ? 'selected' : '' }}>
                                                    {{ $user->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('responsible_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="custom-control custom-switch mt-4">
                                            <input type="checkbox" id="is_active" name="is_active" 
                                                   class="custom-control-input" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="is_active">
                                                Conta ativa
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="notes">Observações</label>
                                <textarea id="notes" name="notes" class="form-control @error('notes') is-invalid @enderror" 
                                          rows="3">{{ old('notes') }}</textarea>
                                @error('notes')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="card-footer">
                            <a href="{{ route('admin.finance.accounts.index') }}" class="btn btn-secondary">Cancelar</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Salvar
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Dicas de Preenchimento</h3>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled">
                            <li class="mb-2">
                                <i class="fas fa-info-circle text-primary"></i>
                                <small>Use nomes descritivos para fácil identificação</small>
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-university text-success"></i>
                                <small>Contas correntes são para uso diário</small>
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-piggy-bank text-warning"></i>
                                <small>Poupança para economias e reservas</small>
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-chart-line text-info"></i>
                                <small>Investimentos para aplicações financeiras</small>
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-credit-card text-danger"></i>
                                <small>Cartões para controle de despesas</small>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Informações Importantes</h3>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i>
                            <strong>Saldo Inicial:</strong> Será usado como ponto de partida para cálculo de saldos futuros.
                        </div>
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle"></i>
                            <strong>Responsável:</strong> Terá acesso privilegiado para gerenciar esta conta.
                        </div>
                        <div class="alert alert-success">
                            <i class="fas fa-check-circle"></i>
                            <strong>Status:</strong> Contas inativas não aparecem nos relatórios, mas mantêm histórico.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
