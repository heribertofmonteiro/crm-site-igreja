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
        <form action="{{ route('admin.social_assistance.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="social_project_id">Projeto Social</label>
                <select name="social_project_id" class="form-control" required>
                    @foreach($socialProjects as $project)
                        <option value="{{ $project->id }}">{{ $project->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="beneficiary_name">Nome do Beneficiário</label>
                <input type="text" name="beneficiary_name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="beneficiary_contact">Contato do Beneficiário</label>
                <input type="text" name="beneficiary_contact" class="form-control">
            </div>
            <div class="form-group">
                <label for="assistance_type">Tipo de Assistência</label>
                <select name="assistance_type" class="form-control" required>
                    <option value="food">Alimentação</option>
                    <option value="clothing">Vestuário</option>
                    <option value="medical">Médica</option>
                    <option value="financial">Financeira</option>
                    <option value="other">Outros</option>
                </select>
            </div>
            <div class="form-group">
                <label for="description">Descrição</label>
                <textarea name="description" class="form-control" rows="3" required></textarea>
            </div>
            <div class="form-group">
                <label for="date_provided">Data da Assistência</label>
                <input type="date" name="date_provided" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="amount">Valor</label>
                <input type="number" name="amount" class="form-control" step="0.01" min="0" required>
            </div>
            <button type="submit" class="btn btn-primary">Salvar</button>
            <a href="{{ route('admin.social_assistance.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</div>
@stop