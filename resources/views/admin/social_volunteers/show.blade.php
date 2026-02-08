@extends('adminlte::page')

@section('title', 'Detalhes do Voluntário Social')

@section('content_header')
    <h1>Detalhes do Voluntário Social</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Detalhes do Voluntário</h3>
        <div class="card-tools">
            @can('social_volunteers.edit')
            <a href="{{ route('admin.social_volunteers.edit', $socialVolunteer) }}" class="btn btn-warning btn-sm">
                <i class="fas fa-edit"></i> Editar
            </a>
            @endcan
            <a href="{{ route('admin.social_volunteers.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Voltar
            </a>
        </div>
    </div>
    <div class="card-body">
        <dl class="row">
            <dt class="col-sm-3">ID</dt>
            <dd class="col-sm-9">{{ $socialVolunteer->id }}</dd>

            <dt class="col-sm-3">Projeto Social</dt>
            <dd class="col-sm-9">{{ $socialVolunteer->project->name }}</dd>

            <dt class="col-sm-3">Usuário</dt>
            <dd class="col-sm-9">{{ $socialVolunteer->user->name }}</dd>

            <dt class="col-sm-3">Função</dt>
            <dd class="col-sm-9">{{ $socialVolunteer->role }}</dd>

            <dt class="col-sm-3">Data de Ingresso</dt>
            <dd class="col-sm-9">{{ $socialVolunteer->joined_at->format('d/m/Y') }}</dd>

            <dt class="col-sm-3">Status</dt>
            <dd class="col-sm-9">{{ ucfirst($socialVolunteer->status) }}</dd>

            <dt class="col-sm-3">Criado em</dt>
            <dd class="col-sm-9">{{ $socialVolunteer->created_at->format('d/m/Y H:i') }}</dd>

            <dt class="col-sm-3">Atualizado em</dt>
            <dd class="col-sm-9">{{ $socialVolunteer->updated_at->format('d/m/Y H:i') }}</dd>
        </dl>
    </div>
</div>
@stop