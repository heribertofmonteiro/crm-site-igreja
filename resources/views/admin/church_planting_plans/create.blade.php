@extends('adminlte::page')

@section('title', 'Novo Plano de Plantação')

@section('content_header')
    <h1>Novo Plano de Plantação</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Criar Novo Plano de Plantação</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('expansion.church-planting-plans.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Nome</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="description">Descrição</label>
                <textarea name="description" class="form-control"></textarea>
            </div>
            <div class="form-group">
                <label for="location">Localização</label>
                <input type="text" name="location" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="planned_start_date">Data de Início Planejada</label>
                <input type="date" name="planned_start_date" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="planned_end_date">Data de Fim Planejada</label>
                <input type="date" name="planned_end_date" class="form-control">
            </div>
            <div class="form-group">
                <label for="status">Status</label>
                <select name="status" class="form-control" required>
                    <option value="planned">Planejado</option>
                    <option value="in_progress">Em Andamento</option>
                    <option value="completed">Concluído</option>
                </select>
            </div>
            <div class="form-group">
                <label for="budget">Orçamento</label>
                <input type="number" name="budget" class="form-control" step="0.01" min="0">
            </div>
            <div class="form-group">
                <label for="leader_id">Líder</label>
                <select name="leader_id" class="form-control">
                    <option value="">Selecione um líder</option>
                    @foreach($leaders as $leader)
                        <option value="{{ $leader->id }}">{{ $leader->name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Salvar</button>
            <a href="{{ route('expansion.church-planting-plans.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</div>
@stop