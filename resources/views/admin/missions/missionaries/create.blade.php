@extends('adminlte::page')

@section('title', 'Criar Missionário')

@section('content_header')
    <h1>Criar Missionário</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Novo Missionário</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('missions.missionaries.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Nome</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="phone">Telefone</label>
                <input type="text" class="form-control" id="phone" name="phone">
            </div>
            <div class="form-group">
                <label for="country">País</label>
                <input type="text" class="form-control" id="country" name="country" required>
            </div>
            <div class="form-group">
                <label for="region">Região</label>
                <input type="text" class="form-control" id="region" name="region">
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
                <label for="status">Status</label>
                <select class="form-control" id="status" name="status" required>
                    <option value="active">Ativo</option>
                    <option value="inactive">Inativo</option>
                </select>
            </div>
            <div class="form-group">
                <label for="bio">Biografia</label>
                <textarea class="form-control" id="bio" name="bio" rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Salvar</button>
            <a href="{{ route('missions.missionaries.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</div>
@stop