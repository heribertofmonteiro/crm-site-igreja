@extends('adminlte::page')

@section('title', 'Nova Assistência Social')

@section('content_header')
    <h1>Nova Assistência Social</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Criar Nova Assistência Social</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('social.assistances.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="social_project_id">Projeto Social</label>
                <select class="form-control @error('social_project_id') is-invalid @enderror" id="social_project_id" name="social_project_id" required>
                    <option value="">Selecione um projeto</option>
                    @foreach($projects as $project)
                        <option value="{{ $project->id }}" {{ old('social_project_id') == $project->id ? 'selected' : '' }}>{{ $project->name }}</option>
                    @endforeach
                </select>
                @error('social_project_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="beneficiary_name">Nome do Beneficiário</label>
                <input type="text" class="form-control @error('beneficiary_name') is-invalid @enderror" id="beneficiary_name" name="beneficiary_name" value="{{ old('beneficiary_name') }}" required>
                @error('beneficiary_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="beneficiary_contact">Contato do Beneficiário</label>
                <input type="text" class="form-control @error('beneficiary_contact') is-invalid @enderror" id="beneficiary_contact" name="beneficiary_contact" value="{{ old('beneficiary_contact') }}">
                @error('beneficiary_contact')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="assistance_type">Tipo de Assistência</label>
                <select class="form-control @error('assistance_type') is-invalid @enderror" id="assistance_type" name="assistance_type" required>
                    <option value="">Selecione o tipo</option>
                    <option value="food" {{ old('assistance_type') == 'food' ? 'selected' : '' }}>Alimentação</option>
                    <option value="clothing" {{ old('assistance_type') == 'clothing' ? 'selected' : '' }}>Vestuário</option>
                    <option value="medical" {{ old('assistance_type') == 'medical' ? 'selected' : '' }}>Médica</option>
                    <option value="financial" {{ old('assistance_type') == 'financial' ? 'selected' : '' }}>Financeira</option>
                    <option value="other" {{ old('assistance_type') == 'other' ? 'selected' : '' }}>Outros</option>
                </select>
                @error('assistance_type')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="description">Descrição</label>
                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description') }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="date_provided">Data da Assistência</label>
                <input type="date" class="form-control @error('date_provided') is-invalid @enderror" id="date_provided" name="date_provided" value="{{ old('date_provided') }}" required>
                @error('date_provided')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="amount">Valor (opcional)</label>
                <input type="number" step="0.01" class="form-control @error('amount') is-invalid @enderror" id="amount" name="amount" value="{{ old('amount') }}">
                @error('amount')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Criar Assistência</button>
            <a href="{{ route('social.assistances.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</div>
@stop