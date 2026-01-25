@extends('adminlte::page')

@section('title', 'Detalhes do Documento')

@section('content_header')
    <h1>Detalhes do Documento</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">{{ $document->title }}</h3>
        <div class="card-tools">
            @can('documents.edit')
            <a href="{{ route('admin.documents.edit', $document) }}" class="btn btn-warning btn-sm">
                <i class="fas fa-edit"></i> Editar
            </a>
            @endcan
            <a href="{{ route('admin.documents.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Voltar
            </a>
        </div>
    </div>
    <div class="card-body">
        <dl class="row">
            <dt class="col-sm-3">Título</dt>
            <dd class="col-sm-9">{{ $document->title }}</dd>

            <dt class="col-sm-3">Tipo</dt>
            <dd class="col-sm-9">{{ ucfirst($document->type) }}</dd>

            <dt class="col-sm-3">Caminho do Arquivo</dt>
            <dd class="col-sm-9">{{ $document->file_path }}</dd>

            <dt class="col-sm-3">Membro</dt>
            <dd class="col-sm-9">{{ $document->member ? $document->member->name : 'N/A' }}</dd>

            <dt class="col-sm-3">Evento</dt>
            <dd class="col-sm-9">{{ $document->churchEvent ? $document->churchEvent->title : 'N/A' }}</dd>

            <dt class="col-sm-3">Criado em</dt>
            <dd class="col-sm-9">{{ $document->created_at->format('d/m/Y H:i') }}</dd>

            <dt class="col-sm-3">Atualizado em</dt>
            <dd class="col-sm-9">{{ $document->updated_at->format('d/m/Y H:i') }}</dd>
        </dl>
    </div>
</div>
@stop