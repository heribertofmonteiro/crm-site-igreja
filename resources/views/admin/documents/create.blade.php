@extends('adminlte::page')

@section('title', 'Novo Documento')

@section('content_header')
    <h1>Novo Documento</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Criar Novo Documento</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.documents.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="title">Título</label>
                <input type="text" name="title" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="type">Tipo</label>
                <select name="type" class="form-control" required>
                    <option value="certificate">Certificado</option>
                    <option value="report">Relatório</option>
                    <option value="contract">Contrato</option>
                    <option value="other">Outro</option>
                </select>
            </div>
            <div class="form-group">
                <label for="file_path">Caminho do Arquivo</label>
                <input type="text" name="file_path" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="member_id">Membro (opcional)</label>
                <select name="member_id" class="form-control">
                    <option value="">Selecione um membro</option>
                    @foreach($members as $member)
                    <option value="{{ $member->id }}">{{ $member->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="church_event_id">Evento (opcional)</label>
                <select name="church_event_id" class="form-control">
                    <option value="">Selecione um evento</option>
                    @foreach($events as $event)
                    <option value="{{ $event->id }}">{{ $event->title }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Salvar</button>
            <a href="{{ route('admin.documents.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</div>
@stop