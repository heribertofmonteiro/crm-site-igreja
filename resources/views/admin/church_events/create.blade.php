@extends('adminlte::page')

@section('title', 'Novo Evento')

@section('content_header')
    <h1>Novo Evento</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Criar Novo Evento</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.church_events.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="title">Título</label>
                <input type="text" name="title" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="description">Descrição</label>
                <textarea name="description" class="form-control"></textarea>
            </div>
            <div class="form-group">
                <label for="event_date">Data do Evento</label>
                <input type="datetime-local" name="event_date" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="location">Local</label>
                <input type="text" name="location" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Salvar</button>
            <a href="{{ route('admin.church_events.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</div>
@stop