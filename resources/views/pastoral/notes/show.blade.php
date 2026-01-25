@extends('adminlte::page')

@section('title', 'Detalhes da Nota Pastoral')

@section('content_header')
    <h1>Detalhes da Nota Pastoral</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">{{ $note->title }}</h3>
        <div class="card-tools">
            @can('pastoral_notes.edit')
            <a href="{{ route('pastoral.notes.edit', $note) }}" class="btn btn-warning btn-sm">
                <i class="fas fa-edit"></i> Editar
            </a>
            @endcan
            <a href="{{ route('pastoral.notes.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Voltar
            </a>
        </div>
    </div>
    <div class="card-body">
        <dl class="row">
            <dt class="col-sm-3">ID</dt>
            <dd class="col-sm-9">{{ $note->id }}</dd>

            <dt class="col-sm-3">Título</dt>
            <dd class="col-sm-9">{{ $note->title }}</dd>

            <dt class="col-sm-3">Conteúdo</dt>
            <dd class="col-sm-9">{{ nl2br(e($note->content)) }}</dd>

            <dt class="col-sm-3">Tipo</dt>
            <dd class="col-sm-9">{{ ucfirst($note->type) }}</dd>

            <dt class="col-sm-3">Conselho Pastoral</dt>
            <dd class="col-sm-9">{{ $note->council->name }}</dd>

            <dt class="col-sm-3">Autor</dt>
            <dd class="col-sm-9">{{ $note->user->name }}</dd>

            <dt class="col-sm-3">Criado em</dt>
            <dd class="col-sm-9">{{ $note->created_at->format('d/m/Y H:i') }}</dd>

            <dt class="col-sm-3">Atualizado em</dt>
            <dd class="col-sm-9">{{ $note->updated_at->format('d/m/Y H:i') }}</dd>
        </dl>
    </div>
</div>
@stop