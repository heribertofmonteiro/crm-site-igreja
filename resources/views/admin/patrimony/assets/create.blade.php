@extends('adminlte::page')

@section('title', 'Novo Bem')

@section('content_header')
    <h1>Novo Bem</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Criar Novo Bem</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('patrimony.assets.store') }}" method="POST">
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
                <label for="category">Categoria</label>
                <input type="text" name="category" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="value">Valor</label>
                <input type="number" name="value" class="form-control" step="0.01">
            </div>
            <div class="form-group">
                <label for="acquisition_date">Data de Aquisição</label>
                <input type="date" name="acquisition_date" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="status">Status</label>
                <select name="status" class="form-control" required>
                    <option value="active">Ativo</option>
                    <option value="inactive">Inativo</option>
                    <option value="maintenance">Manutenção</option>
                    <option value="disposed">Descartado</option>
                </select>
            </div>
            <div class="form-group">
                <label for="location">Localização</label>
                <input type="text" name="location" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Salvar</button>
            <a href="{{ route('patrimony.assets.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</div>
@stop