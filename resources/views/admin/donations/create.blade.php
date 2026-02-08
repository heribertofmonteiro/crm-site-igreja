@extends('adminlte::page')

@section('title', 'Criar Doação')

@section('content_header')
    <h1>Criar Doação</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Criar Nova Doação</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.donations.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="donor_name">Nome do Doador</label>
                <input type="text" name="donor_name" class="form-control" value="{{ old('donor_name') }}" required>
                @error('donor_name')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="donor_email">Email do Doador</label>
                <input type="email" name="donor_email" class="form-control" value="{{ old('donor_email') }}">
                @error('donor_email')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="donation_type">Tipo de Doação</label>
                <select name="donation_type" class="form-control" required>
                    <option value="tithe" {{ old('donation_type') == 'tithe' ? 'selected' : '' }}>Dízimo</option>
                    <option value="offering" {{ old('donation_type') == 'offering' ? 'selected' : '' }}>Oferta</option>
                    <option value="special" {{ old('donation_type') == 'special' ? 'selected' : '' }}>Especial</option>
                </select>
                @error('donation_type')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="amount">Valor</label>
                <input type="number" name="amount" class="form-control" step="0.01" min="0" value="{{ old('amount') }}" required>
                @error('amount')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="date">Data</label>
                <input type="date" name="date" class="form-control" value="{{ old('date', date('Y-m-d')) }}" required>
                @error('date')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="payment_method">Método de Pagamento</label>
                <select name="payment_method" class="form-control" required>
                    <option value="cash" {{ old('payment_method') == 'cash' ? 'selected' : '' }}>Dinheiro</option>
                    <option value="card" {{ old('payment_method') == 'card' ? 'selected' : '' }}>Cartão</option>
                    <option value="transfer" {{ old('payment_method') == 'transfer' ? 'selected' : '' }}>Transferência</option>
                    <option value="check" {{ old('payment_method') == 'check' ? 'selected' : '' }}>Cheque</option>
                </select>
                @error('payment_method')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="description">Descrição</label>
                <textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
                @error('description')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Criar</button>
            <a href="{{ route('admin.donations.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</div>
@stop