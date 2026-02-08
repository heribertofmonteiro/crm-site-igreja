@extends('adminlte::page')

@section('title', 'Detalhes do Estudante')

@section('content_header')
    <h1>Detalhes do Estudante</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">{{ $student->name }}</h3>
        <div class="card-tools">
            @can('education_students.edit')
            <a href="{{ route('education.students.edit', $student) }}" class="btn btn-warning btn-sm">
                <i class="fas fa-edit"></i> Editar
            </a>
            @endcan
            <a href="{{ route('education.students.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Voltar
            </a>
        </div>
    </div>
    <div class="card-body">
        <dl class="row">
            <dt class="col-sm-3">Nome</dt>
            <dd class="col-sm-9">{{ $student->name }}</dd>

            <dt class="col-sm-3">Data de Nascimento</dt>
            <dd class="col-sm-9">{{ $student->birth_date->format('d/m/Y') }}</dd>

            <dt class="col-sm-3">Informações de Contato</dt>
            <dd class="col-sm-9">{{ $student->contact_info ?: 'Não informado' }}</dd>

            <dt class="col-sm-3">Turma</dt>
            <dd class="col-sm-9">{{ $student->schoolClass->name ?? 'Não informado' }}</dd>

            <dt class="col-sm-3">Pai/Mãe</dt>
            <dd class="col-sm-9">{{ $student->parent->name ?? 'Não informado' }}</dd>

            <dt class="col-sm-3">Criado em</dt>
            <dd class="col-sm-9">{{ $student->created_at->format('d/m/Y H:i') }}</dd>

            <dt class="col-sm-3">Atualizado em</dt>
            <dd class="col-sm-9">{{ $student->updated_at->format('d/m/Y H:i') }}</dd>
        </dl>
    </div>
</div>
@stop