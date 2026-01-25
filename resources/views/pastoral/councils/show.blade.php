@extends('adminlte::page')

@section('title', 'Detalhes do Conselho Pastoral')

@section('content_header')
    <h1>Detalhes do Conselho Pastoral</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">{{ $council->name }}</h3>
        <div class="card-tools">
            @can('pastoral_councils.edit')
            <a href="{{ route('pastoral.councils.edit', $council) }}" class="btn btn-warning btn-sm">
                <i class="fas fa-edit"></i> Editar
            </a>
            @endcan
            <a href="{{ route('pastoral.councils.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Voltar
            </a>
        </div>
    </div>
    <div class="card-body">
        <dl class="row">
            <dt class="col-sm-3">ID</dt>
            <dd class="col-sm-9">{{ $council->id }}</dd>

            <dt class="col-sm-3">Nome</dt>
            <dd class="col-sm-9">{{ $council->name }}</dd>

            <dt class="col-sm-3">Descrição</dt>
            <dd class="col-sm-9">{{ $council->description ?: 'N/A' }}</dd>

            <dt class="col-sm-3">Visão</dt>
            <dd class="col-sm-9">{{ $council->vision ?: 'N/A' }}</dd>

            <dt class="col-sm-3">Declaração Doutrinária</dt>
            <dd class="col-sm-9">{{ $council->doctrine_statement ?: 'N/A' }}</dd>

            <dt class="col-sm-3">Membros</dt>
            <dd class="col-sm-9">
                @if($council->members)
                    <ul>
                        @foreach($council->members as $memberId)
                            <li>{{ \App\Models\User::find($memberId)->name ?? 'Usuário não encontrado' }}</li>
                        @endforeach
                    </ul>
                @else
                    Nenhum membro definido
                @endif
            </dd>

            <dt class="col-sm-3">Criado em</dt>
            <dd class="col-sm-9">{{ $council->created_at->format('d/m/Y H:i') }}</dd>

            <dt class="col-sm-3">Atualizado em</dt>
            <dd class="col-sm-9">{{ $council->updated_at->format('d/m/Y H:i') }}</dd>
        </dl>
    </div>
</div>

@if($council->pastoralNotes->count() > 0)
<div class="card mt-3">
    <div class="card-header">
        <h3 class="card-title">Notas Pastorais Relacionadas</h3>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Título</th>
                    <th>Tipo</th>
                    <th>Autor</th>
                    <th>Criado em</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($council->pastoralNotes as $note)
                <tr>
                    <td>{{ $note->title }}</td>
                    <td>{{ ucfirst($note->type) }}</td>
                    <td>{{ $note->user->name }}</td>
                    <td>{{ $note->created_at->format('d/m/Y') }}</td>
                    <td>
                        @can('pastoral_notes.view')
                        <a href="{{ route('pastoral.notes.show', $note) }}" class="btn btn-info btn-sm">
                            <i class="fas fa-eye"></i>
                        </a>
                        @endcan
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif
@stop