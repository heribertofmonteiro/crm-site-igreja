@extends('adminlte::page')

@section('title', 'Eventos da Igreja')

@section('content_header')
    <h1>Eventos da Igreja</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Lista de Eventos</h3>
        @can('church_events.create')
        <div class="card-tools">
            <a href="{{ route('admin.church_events.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Novo Evento
            </a>
        </div>
        @endcan
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Título</th>
                    <th>Data do Evento</th>
                    <th>Local</th>
                    <th>Criado em</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($events as $event)
                <tr>
                    <td>{{ $event->id }}</td>
                    <td>{{ $event->title }}</td>
                    <td>{{ $event->event_date->format('d/m/Y H:i') }}</td>
                    <td>{{ $event->location ?: 'Não informado' }}</td>
                    <td>{{ $event->created_at->format('d/m/Y') }}</td>
                    <td>
                        @can('church_events.view')
                        <a href="{{ route('admin.church_events.show', $event) }}" class="btn btn-info btn-sm">
                            <i class="fas fa-eye"></i>
                        </a>
                        @endcan
                        @can('church_events.edit')
                        <a href="{{ route('admin.church_events.edit', $event) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i>
                        </a>
                        @endcan
                        @can('church_events.delete')
                        <form action="{{ route('admin.church_events.destroy', $event) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                        @endcan
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{ $events->links() }}
    </div>
</div>
@stop