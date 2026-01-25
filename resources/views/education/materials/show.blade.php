@extends('adminlte::page')

@section('title', 'Detalhes do Material Educacional')

@section('content_header')
    <h1>Detalhes do Material Educacional</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">{{ $material->title }}</h3>
        <div class="card-tools">
            @can('education.materials.edit')
            <a href="{{ route('education.materials.edit', $material) }}" class="btn btn-warning btn-sm">
                <i class="fas fa-edit"></i> Editar
            </a>
            @endcan
            <a href="{{ route('education.materials.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Voltar
            </a>
        </div>
    </div>
    <div class="card-body">
        <dl class="row">
            <dt class="col-sm-3">Título</dt>
            <dd class="col-sm-9">{{ $material->title }}</dd>

            <dt class="col-sm-3">Descrição</dt>
            <dd class="col-sm-9">{{ $material->description ?: 'Não informado' }}</dd>

            <dt class="col-sm-3">Tipo</dt>
            <dd class="col-sm-9">{{ $material->type }}</dd>

            <dt class="col-sm-3">URL</dt>
            <dd class="col-sm-9">
                @if($material->url)
                <a href="{{ $material->url }}" target="_blank">{{ $material->url }}</a>
                @else
                Não informado
                @endif
            </dd>

            <dt class="col-sm-3">Turma</dt>
            <dd class="col-sm-9">{{ $material->schoolClass->name ?? 'Não informado' }}</dd>

            <dt class="col-sm-3">Criado em</dt>
            <dd class="col-sm-9">{{ $material->created_at->format('d/m/Y H:i') }}</dd>

            <dt class="col-sm-3">Atualizado em</dt>
            <dd class="col-sm-9">{{ $material->updated_at->format('d/m/Y H:i') }}</dd>
        </dl>
    </div>
</div>
@stop