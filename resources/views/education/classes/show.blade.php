@extends('adminlte::page')

@section('title', 'Detalhes da Turma')

@section('content_header')
    <h1>Detalhes da Turma</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">{{ $class->name }}</h3>
        <div class="card-tools">
            @can('education.classes.edit')
            <a href="{{ route('education.classes.edit', $class) }}" class="btn btn-warning btn-sm">
                <i class="fas fa-edit"></i> Editar
            </a>
            @endcan
            <a href="{{ route('education.classes.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Voltar
            </a>
        </div>
    </div>
    <div class="card-body">
        <dl class="row">
            <dt class="col-sm-3">Nome</dt>
            <dd class="col-sm-9">{{ $class->name }}</dd>

            <dt class="col-sm-3">Descrição</dt>
            <dd class="col-sm-9">{{ $class->description ?: 'Não informado' }}</dd>

            <dt class="col-sm-3">Faixa Etária</dt>
            <dd class="col-sm-9">{{ $class->age_group }}</dd>

            <dt class="col-sm-3">Professor</dt>
            <dd class="col-sm-9">{{ $class->teacher->name ?? 'Não informado' }}</dd>

            <dt class="col-sm-3">Criado em</dt>
            <dd class="col-sm-9">{{ $class->created_at->format('d/m/Y H:i') }}</dd>

            <dt class="col-sm-3">Atualizado em</dt>
            <dd class="col-sm-9">{{ $class->updated_at->format('d/m/Y H:i') }}</dd>
        </dl>
    </div>
</div>

@if($class->students->count() > 0)
<div class="card mt-3">
    <div class="card-header">
        <h3 class="card-title">Estudantes</h3>
    </div>
    <div class="card-body">
        <ul class="list-group">
            @foreach($class->students as $student)
            <li class="list-group-item">{{ $student->name }}</li>
            @endforeach
        </ul>
    </div>
</div>
@endif

@if($class->educationalMaterials->count() > 0)
<div class="card mt-3">
    <div class="card-header">
        <h3 class="card-title">Materiais Educacionais</h3>
    </div>
    <div class="card-body">
        <ul class="list-group">
            @foreach($class->educationalMaterials as $material)
            <li class="list-group-item">{{ $material->title }} ({{ $material->type }})</li>
            @endforeach
        </ul>
    </div>
</div>
@endif
@stop