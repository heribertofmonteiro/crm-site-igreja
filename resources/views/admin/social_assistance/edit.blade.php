@extends('adminlte::page')

@section('title', 'Editar Assistência Social')

@section('content_header')
    <h1>Editar Assistência Social</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Editar Assistência Social</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.social_assistance.update', $socialAssistance) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="social_project_id">Projeto Social</label>
                <select name="social_project_id" class="form-control" required>
                    @foreach($socialProjects as $project)
                        <option value="{{ $project->id }}" {{ $socialAssistance->social_project_id == $project->id ? 'selected' : '' }}>
                            {{ $project->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="beneficiary_name">Nome do Beneficiário</label>
                <input type="text" name="beneficiary_name" class="form-control" value="{{ $socialAssistance->beneficiary_name }}" required>
            </div>
            <div class="form-group">
                <label for="beneficiary_contact">Contato do Beneficiário</label>
                <input type="text" name="beneficiary_contact" class="form-control" value="{{ $socialAssistance->beneficiary_contact }}">
            </div>
            <div class="form-group">
                <label for="assistance_type">Tipo de Assistência</label>
                <select name="assistance_type" class="form-control" required>
                    <option value="food" {{ $socialAssistance->assistance_type == 'food' ? 'selected' : '' }}>Alimentação</option>
                    <option value="clothing" {{ $socialAssistance->assistance_type == 'clothing' ? 'selected' : '' }}>Vestuário</option>
                    <option value="medical" {{ $socialAssistance->assistance_type == 'medical' ? 'selected' : '' }}>Médica</option>
                    <option value="financial" {{ $socialAssistance->assistance_type == 'financial' ? 'selected' : '' }}>Financeira</option>
                    <option value="other" {{ $socialAssistance->assistance_type == 'other' ? 'selected' : '' }}>Outros</option>
                </select>
            </div>
            <div class="form-group">
                <label for="description">Descrição</label>
                <textarea name="description" class="form-control" rows="3" required>{{ $socialAssistance->description }}</textarea>
            </div>
            <div class="form-group">
                <label for="date_provided">Data da Assistência</label>
                <input type="date" name="date_provided" class="form-control" value="{{ $socialAssistance->date_provided->format('Y-m-d') }}" required>
            </div>
            <div class="form-group">
                <label for="amount">Valor</label>
                <input type="number" name="amount" class="form-control" step="0.01" min="0" value="{{ $socialAssistance->amount }}" required>
            </div>
            <button type="submit" class="btn btn-primary">Atualizar</button>
            <a href="{{ route('admin.social_assistance.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</div>
@stop