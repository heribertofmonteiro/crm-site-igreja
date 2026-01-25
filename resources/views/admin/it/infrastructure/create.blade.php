@extends('adminlte::page')

@section('title', 'Novo Ativo de Infraestrutura')

@section('content_header')
    <h1>Novo Ativo de Infraestrutura</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Cadastrar Novo Ativo</h3>
    </div>
    <form action="{{ route('it.infrastructure.store') }}" method="POST">
        @csrf
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="name">Nome do Ativo *</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="type">Tipo *</label>
                        <select class="form-control @error('type') is-invalid @enderror" id="type" name="type" required>
                            <option value="">Selecione o tipo</option>
                            <option value="server" {{ old('type') == 'server' ? 'selected' : '' }}>Servidor</option>
                            <option value="computer" {{ old('type') == 'computer' ? 'selected' : '' }}>Computador</option>
                            <option value="network" {{ old('type') == 'network' ? 'selected' : '' }}>Rede</option>
                            <option value="printer" {{ old('type') == 'printer' ? 'selected' : '' }}>Impressora</option>
                            <option value="other" {{ old('type') == 'other' ? 'selected' : '' }}>Outro</option>
                        </select>
                        @error('type')
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
                        <label for="status">Status *</label>
                        <select class="form-control @error('status') is-invalid @enderror" id="status" name="status" required>
                            <option value="active" {{ old('status', 'active') == 'active' ? 'selected' : '' }}>Ativo</option>
                            <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inativo</option>
                            <option value="maintenance" {{ old('status') == 'maintenance' ? 'selected' : '' }}>Manutenção</option>
                        </select>
                        @error('status')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="location">Localização</label>
                        <input type="text" class="form-control @error('location') is-invalid @enderror" id="location" name="location" value="{{ old('location') }}">
                        @error('location')
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
                        <label for="purchase_date">Data de Compra</label>
                        <input type="date" class="form-control @error('purchase_date') is-invalid @enderror" id="purchase_date" name="purchase_date" value="{{ old('purchase_date') }}">
                        @error('purchase_date')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="warranty_expiry">Garantia até</label>
                        <input type="date" class="form-control @error('warranty_expiry') is-invalid @enderror" id="warranty_expiry" name="warranty_expiry" value="{{ old('warranty_expiry') }}">
                        @error('warranty_expiry')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="notes">Observações</label>
                <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" rows="3">{{ old('notes') }}</textarea>
                @error('notes')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Salvar</button>
            <a href="{{ route('it.infrastructure.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>
@stop