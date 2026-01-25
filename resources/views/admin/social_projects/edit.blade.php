@extends('adminlte::page')

@section('title', 'Editar Projeto Social')

@section('content_header')
    <h1>Editar Projeto Social</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Editar Projeto Social</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('social.update', $social) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">Nome do Projeto</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $social->name) }}" required>
            </div>
            <div class="form-group">
                <label for="description">Descrição</label>
                <textarea name="description" class="form-control" rows="3">{{ old('description', $social->description) }}</textarea>
            </div>
            <div class="form-group">
                <label for="start_date">Data de Início</label>
                <input type="date" name="start_date" class="form-control" value="{{ old('start_date', $social->start_date->format('Y-m-d')) }}" required>
            </div>
            <div class="form-group">
                <label for="end_date">Data de Fim</label>
                <input type="date" name="end_date" class="form-control" value="{{ old('end_date', $social->end_date ? $social->end_date->format('Y-m-d') : '') }}">
            </div>
            <div class="form-group">
                <label for="status">Status</label>
                <select name="status" class="form-control" required>
                    <option value="planned" {{ old('status', $social->status) == 'planned' ? 'selected' : '' }}>Planejado</option>
                    <option value="active" {{ old('status', $social->status) == 'active' ? 'selected' : '' }}>Ativo</option>
                    <option value="completed" {{ old('status', $social->status) == 'completed' ? 'selected' : '' }}>Concluído</option>
                </select>
            </div>
            <div class="form-group">
                <label for="budget">Orçamento</label>
                <input type="number" name="budget" class="form-control" step="0.01" min="0" value="{{ old('budget', $social->budget) }}">
            </div>
            <button type="submit" class="btn btn-primary">Atualizar</button>
            <a href="{{ route('social.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</div>
@stop