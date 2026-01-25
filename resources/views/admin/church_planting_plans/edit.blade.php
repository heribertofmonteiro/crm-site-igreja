@extends('adminlte::page')

@section('title', 'Editar Plano de Plantação')

@section('content_header')
    <h1>Editar Plano de Plantação</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Editar Plano de Plantação</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('expansion.church-planting-plans.update', $plan) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">Nome</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $plan->name) }}" required>
            </div>
            <div class="form-group">
                <label for="description">Descrição</label>
                <textarea name="description" class="form-control">{{ old('description', $plan->description) }}</textarea>
            </div>
            <div class="form-group">
                <label for="location">Localização</label>
                <input type="text" name="location" class="form-control" value="{{ old('location', $plan->location) }}" required>
            </div>
            <div class="form-group">
                <label for="planned_start_date">Data de Início Planejada</label>
                <input type="date" name="planned_start_date" class="form-control" value="{{ old('planned_start_date', $plan->planned_start_date ? $plan->planned_start_date->format('Y-m-d') : '') }}" required>
            </div>
            <div class="form-group">
                <label for="planned_end_date">Data de Fim Planejada</label>
                <input type="date" name="planned_end_date" class="form-control" value="{{ old('planned_end_date', $plan->planned_end_date ? $plan->planned_end_date->format('Y-m-d') : '') }}">
            </div>
            <div class="form-group">
                <label for="status">Status</label>
                <select name="status" class="form-control" required>
                    <option value="planned" {{ old('status', $plan->status) == 'planned' ? 'selected' : '' }}>Planejado</option>
                    <option value="in_progress" {{ old('status', $plan->status) == 'in_progress' ? 'selected' : '' }}>Em Andamento</option>
                    <option value="completed" {{ old('status', $plan->status) == 'completed' ? 'selected' : '' }}>Concluído</option>
                </select>
            </div>
            <div class="form-group">
                <label for="budget">Orçamento</label>
                <input type="number" name="budget" class="form-control" step="0.01" min="0" value="{{ old('budget', $plan->budget) }}">
            </div>
            <div class="form-group">
                <label for="leader_id">Líder</label>
                <select name="leader_id" class="form-control">
                    <option value="">Selecione um líder</option>
                    @foreach($leaders as $leader)
                        <option value="{{ $leader->id }}" {{ old('leader_id', $plan->leader_id) == $leader->id ? 'selected' : '' }}>{{ $leader->name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Atualizar</button>
            <a href="{{ route('expansion.church-planting-plans.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</div>
@stop