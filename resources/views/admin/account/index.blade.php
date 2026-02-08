@extends('adminlte::page')

@section('title', 'Minha Conta')

@section('content_header')
    <h1>Minha Conta</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Informações da Conta</h3>
        <div class="card-tools">
            <a href="{{ route('profile.edit') }}" class="btn btn-warning btn-sm">
                <i class="fas fa-edit"></i> Editar Conta
            </a>
            <a href="{{ route('password.edit') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-key"></i> Alterar Senha
            </a>
        </div>
    </div>
    <div class="card-body">
        <dl class="row">
            <dt class="col-sm-3">Nome:</dt>
            <dd class="col-sm-9">{{ $user->name }}</dd>

            <dt class="col-sm-3">Email:</dt>
            <dd class="col-sm-9">{{ $user->email }}</dd>

            <dt class="col-sm-3">Funções:</dt>
            <dd class="col-sm-9">{{ $user->roles->pluck('name')->join(', ') }}</dd>

            <dt class="col-sm-3">Criado em:</dt>
            <dd class="col-sm-9">{{ $user->created_at->format('d/m/Y H:i') }}</dd>

            <dt class="col-sm-3">Último login:</dt>
            <dd class="col-sm-9">{{ $user->last_login_at ? $user->last_login_at->format('d/m/Y H:i') : 'Nunca' }}</dd>
        </dl>
    </div>
</div>
@stop