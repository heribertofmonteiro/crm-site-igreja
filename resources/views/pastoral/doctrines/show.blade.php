@extends('adminlte::page')

@section('title', 'Detalhes da Doutrina')

@section('content_header')
    <h1>Detalhes da Doutrina</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">{{ $doctrine->title }}</h3>
        <div class="card-tools">
            @can('doctrines.edit')
            <a href="{{ route('pastoral.doctrines.edit', $doctrine) }}" class="btn btn-warning btn-sm">
                <i class="fas fa-edit"></i> Editar
            </a>
            @endcan
            <a href="{{ route('pastoral.doctrines.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Voltar
            </a>
        </div>
    </div>
    <div class="card-body">
        <dl class="row">
            <dt class="col-sm-3">ID</dt>
            <dd class="col-sm-9">{{ $doctrine->id }}</dd>

            <dt class="col-sm-3">Título</dt>
            <dd class="col-sm-9">{{ $doctrine->title }}</dd>

            <dt class="col-sm-3">Conteúdo</dt>
            <dd class="col-sm-9">{{ nl2br(e($doctrine->content)) }}</dd>

            <dt class="col-sm-3">Autor</dt>
            <dd class="col-sm-9">{{ $doctrine->author->name }}</dd>

            <dt class="col-sm-3">Status</dt>
            <dd class="col-sm-9">
                @if($doctrine->approved_at)
                    <span class="badge badge-success">Aprovada em {{ $doctrine->approved_at->format('d/m/Y H:i') }}</span>
                @else
                    <span class="badge badge-warning">Pendente de Aprovação</span>
                @endif
            </dd>

            <dt class="col-sm-3">Criado em</dt>
            <dd class="col-sm-9">{{ $doctrine->created_at->format('d/m/Y H:i') }}</dd>

            <dt class="col-sm-3">Atualizado em</dt>
            <dd class="col-sm-9">{{ $doctrine->updated_at->format('d/m/Y H:i') }}</dd>
        </dl>
    </div>
</div>
@stop