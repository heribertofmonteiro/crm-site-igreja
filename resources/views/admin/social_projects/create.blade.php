@extends('adminlte::page')

@section('title', 'Novo Projeto Social')

@section('content_header')
    <h1>Novo Projeto Social</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Criar Novo Projeto Social</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('social.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Nome do Projeto</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="description">Descrição</label>
                <textarea name="description" class="form-control" rows="3"></textarea>
            </div>
            <div class="form-group">
                <label for="start_date">Data de Início</label>
                <input type="date" name="start_date" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="end_date">Data de Fim</label>
                <input type="date" name="end_date" class="form-control">
            </div>
            <div class="form-group">
                <label for="status">Status</label>
                <select name="status" class="form-control" required>
                    <option value="planned">Planejado</option>
                    <option value="active">Ativo</option>
                    <option value="completed">Concluído</option>
                </select>
            </div>
            <div class="form-group">
                <label for="budget">Orçamento</label>
                <input type="number" name="budget" class="form-control" step="0.01" min="0">
            </div>
            <button type="submit" class="btn btn-primary">Salvar</button>
            <a href="{{ route('social.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</div>
@stop