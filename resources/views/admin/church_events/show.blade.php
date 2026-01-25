@extends('adminlte::page')

@section('title', 'Detalhes do Evento')

@section('content_header')
    <h1>Detalhes do Evento</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">{{ $event->title }}</h3>
        <div class="card-tools">
            @can('church_events.edit')
            <a href="{{ route('admin.church_events.edit', $event) }}" class="btn btn-warning btn-sm">
                <i class="fas fa-edit"></i> Editar
            </a>
            @endcan
            <a href="{{ route('admin.church_events.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Voltar
            </a>
        </div>
    </div>
    <div class="card-body">
        <dl class="row">
            <dt class="col-sm-3">Título</dt>
            <dd class="col-sm-9">{{ $event->title }}</dd>

            <dt class="col-sm-3">Descrição</dt>
            <dd class="col-sm-9">{{ $event->description ?: 'Não informado' }}</dd>

            <dt class="col-sm-3">Data do Evento</dt>
            <dd class="col-sm-9">{{ $event->event_date->format('d/m/Y H:i') }}</dd>

            <dt class="col-sm-3">Local</dt>
            <dd class="col-sm-9">{{ $event->location ?: 'Não informado' }}</dd>

            <dt class="col-sm-3">Criado em</dt>
            <dd class="col-sm-9">{{ $event->created_at->format('d/m/Y H:i') }}</dd>

            <dt class="col-sm-3">Atualizado em</dt>
            <dd class="col-sm-9">{{ $event->updated_at->format('d/m/Y H:i') }}</dd>
        </dl>
    </div>
</div>

<div class="card mt-3">
    <div class="card-header">
        <h3 class="card-title">Inscrições no Evento</h3>
    </div>
    <div class="card-body">
        @if($registrations->count() > 0)
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Telefone</th>
                        <th>Confirmado</th>
                        <th>Data da Inscrição</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($registrations as $registration)
                        <tr>
                            <td>{{ $registration->name }}</td>
                            <td>{{ $registration->email }}</td>
                            <td>{{ $registration->phone }}</td>
                            <td>
                                @if($registration->confirmed)
                                    <span class="badge bg-success">Sim</span>
                                @else
                                    <span class="badge bg-warning">Não</span>
                                @endif
                            </td>
                            <td>{{ $registration->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>Nenhuma inscrição registrada ainda.</p>
        @endif
    </div>
</div>
@stop