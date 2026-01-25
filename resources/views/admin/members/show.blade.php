@extends('adminlte::page')

@section('title', 'Detalhes do Membro')

@section('content_header')
    <h1>Detalhes do Membro</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">{{ $member->name }}</h3>
        <div class="card-tools">
            @can('members.edit')
            <a href="{{ route('admin.members.edit', $member) }}" class="btn btn-warning btn-sm">
                <i class="fas fa-edit"></i> Editar
            </a>
            @endcan
            <a href="{{ route('admin.members.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Voltar
            </a>
        </div>
    </div>
    <div class="card-body">
        <dl class="row">
            <dt class="col-sm-3">Nome</dt>
            <dd class="col-sm-9">{{ $member->name }}</dd>

            <dt class="col-sm-3">Email</dt>
            <dd class="col-sm-9">{{ $member->email }}</dd>

            <dt class="col-sm-3">Telefone</dt>
            <dd class="col-sm-9">{{ $member->phone ?: 'Não informado' }}</dd>

            <dt class="col-sm-3">Endereço</dt>
            <dd class="col-sm-9">{{ $member->address ?: 'Não informado' }}</dd>

            <dt class="col-sm-3">Data de Nascimento</dt>
            <dd class="col-sm-9">{{ $member->birth_date ? $member->birth_date->format('d/m/Y') : 'Não informado' }}</dd>

            <dt class="col-sm-3">Data de Batismo</dt>
            <dd class="col-sm-9">{{ $member->baptism_date ? $member->baptism_date->format('d/m/Y') : 'Não informado' }}</dd>

            <dt class="col-sm-3">Estado Civil</dt>
            <dd class="col-sm-9">{{ ucfirst($member->marital_status) }}</dd>

            <dt class="col-sm-3">Criado em</dt>
            <dd class="col-sm-9">{{ $member->created_at->format('d/m/Y H:i') }}</dd>

            <dt class="col-sm-3">Atualizado em</dt>
            <dd class="col-sm-9">{{ $member->updated_at->format('d/m/Y H:i') }}</dd>
        </dl>
    </div>
</div>
@stop