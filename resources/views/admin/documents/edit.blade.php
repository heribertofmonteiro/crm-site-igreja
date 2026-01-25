@extends('adminlte::page')

@section('title', 'Editar Documento')

@section('content_header')
    <h1>Editar Documento</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Editar Documento</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.documents.update', $document) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="title">Título</label>
                <input type="text" name="title" class="form-control" value="{{ $document->title }}" required>
            </div>
            <div class="form-group">
                <label for="type">Tipo</label>
                <select name="type" class="form-control" required>
                    <option value="certificate" {{ $document->type == 'certificate' ? 'selected' : '' }}>Certificado</option>
                    <option value="report" {{ $document->type == 'report' ? 'selected' : '' }}>Relatório</option>
                    <option value="contract" {{ $document->type == 'contract' ? 'selected' : '' }}>Contrato</option>
                    <option value="other" {{ $document->type == 'other' ? 'selected' : '' }}>Outro</option>
                </select>
            </div>
            <div class="form-group">
                <label for="file_path">Caminho do Arquivo</label>
                <input type="text" name="file_path" class="form-control" value="{{ $document->file_path }}" required>
            </div>
            <div class="form-group">
                <label for="member_id">Membro (opcional)</label>
                <select name="member_id" class="form-control">
                    <option value="">Selecione um membro</option>
                    @foreach($members as $member)
                    <option value="{{ $member->id }}" {{ $document->member_id == $member->id ? 'selected' : '' }}>{{ $member->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="church_event_id">Evento (opcional)</label>
                <select name="church_event_id" class="form-control">
                    <option value="">Selecione um evento</option>
                    @foreach($events as $event)
                    <option value="{{ $event->id }}" {{ $document->church_event_id == $event->id ? 'selected' : '' }}>{{ $event->title }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Atualizar</button>
            <a href="{{ route('admin.documents.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</div>
@stop