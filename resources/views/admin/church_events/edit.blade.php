@extends('adminlte::page')

@section('title', 'Editar Evento')

@section('content_header')
    <h1>Editar Evento</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Editar Evento</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.church_events.update', $event) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="title">Título</label>
                <input type="text" name="title" class="form-control" value="{{ $event->title }}" required>
            </div>
            <div class="form-group">
                <label for="description">Descrição</label>
                <textarea name="description" class="form-control">{{ $event->description }}</textarea>
            </div>
            <div class="form-group">
                <label for="event_date">Data do Evento</label>
                <input type="datetime-local" name="event_date" class="form-control" value="{{ $event->event_date->format('Y-m-d\TH:i') }}" required>
            </div>
            <div class="form-group">
                <label for="location">Local</label>
                <input type="text" name="location" class="form-control" value="{{ $event->location }}">
            </div>
            <button type="submit" class="btn btn-primary">Atualizar</button>
            <a href="{{ route('admin.church_events.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</div>
@stop