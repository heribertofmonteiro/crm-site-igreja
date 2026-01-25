@extends('adminlte::page')

@section('title', 'Criar Projeto Missionário')

@section('content_header')
    <h1>Criar Projeto Missionário</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Novo Projeto Missionário</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('missions.projects.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Nome do Projeto</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="description">Descrição</label>
                <textarea class="form-control" id="description" name="description" rows="3"></textarea>
            </div>
            <div class="form-group">
                <label for="location">Localização</label>
                <input type="text" class="form-control" id="location" name="location" required>
            </div>
            <div class="form-group">
                <label for="start_date">Data de Início</label>
                <input type="date" class="form-control" id="start_date" name="start_date" required>
            </div>
            <div class="form-group">
                <label for="end_date">Data de Fim</label>
                <input type="date" class="form-control" id="end_date" name="end_date">
            </div>
            <div class="form-group">
                <label for="budget">Orçamento</label>
                <input type="number" step="0.01" class="form-control" id="budget" name="budget">
            </div>
            <div class="form-group">
                <label for="missionary_id">Missionário</label>
                <select class="form-control" id="missionary_id" name="missionary_id" required>
                    <option value="">Selecione um missionário</option>
                    @foreach($missionaries as $missionary)
                        <option value="{{ $missionary->id }}">{{ $missionary->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="status">Status</label>
                <select class="form-control" id="status" name="status" required>
                    <option value="planning">Planejamento</option>
                    <option value="active">Ativo</option>
                    <option value="completed">Concluído</option>
                    <option value="cancelled">Cancelado</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Salvar</button>
            <a href="{{ route('missions.projects.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</div>
@stop