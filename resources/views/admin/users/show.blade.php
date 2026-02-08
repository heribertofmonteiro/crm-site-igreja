@extends('adminlte::page')

@section('title', 'Detalhes do Usuário')

@section('content_header')
    <h1>Detalhes do Usuário</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Detalhes do Usuário: {{ $user->name }}</h3>
        <div class="card-tools">
            @can('user.edit')
            <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-warning btn-sm">
                <i class="fas fa-edit"></i> Editar
            </a>
            @endcan
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Voltar
            </a>
        </div>
    </div>
    <div class="card-body">
        <dl class="row">
            <dt class="col-sm-3">ID</dt>
            <dd class="col-sm-9">{{ $user->id }}</dd>

            <dt class="col-sm-3">Nome</dt>
            <dd class="col-sm-9">{{ $user->name }}</dd>

            <dt class="col-sm-3">Email</dt>
            <dd class="col-sm-9">{{ $user->email }}</dd>

            <dt class="col-sm-3">Email Verificado</dt>
            <dd class="col-sm-9">{{ $user->email_verified_at ? 'Sim' : 'Não' }}</dd>

            <dt class="col-sm-3">Funções</dt>
            <dd class="col-sm-9">{{ $user->roles->pluck('name')->join(', ') }}</dd>

            <dt class="col-sm-3">Criado em</dt>
            <dd class="col-sm-9">{{ $user->created_at->format('d/m/Y H:i') }}</dd>

            <dt class="col-sm-3">Atualizado em</dt>
            <dd class="col-sm-9">{{ $user->updated_at->format('d/m/Y H:i') }}</dd>
        </dl>
    </div>
</div>
@stop