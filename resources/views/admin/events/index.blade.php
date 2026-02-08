@extends('adminlte::page')

@section('title', 'Eventos')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Eventos</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Eventos</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Lista de Eventos</h3>
                        <div class="card-tools">
                            <a href="{{ route('admin.events.create') }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-plus"></i> Novo Evento
                            </a>
                            <a href="{{ route('admin.events.calendar') }}" class="btn btn-info btn-sm">
                                <i class="fas fa-calendar"></i> Calendário
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Filtros -->
                        <form method="GET" class="mb-3">
                            <div class="row">
                                <div class="col-md-3">
                                    <input type="text" name="search" class="form-control" 
                                           placeholder="Buscar evento..." value="{{ request('search') }}">
                                </div>
                                <div class="col-md-2">
                                    <select name="status" class="form-control">
                                        <option value="">Todos os status</option>
                                        <option value="planned" {{ request('status') == 'planned' ? 'selected' : '' }}>Planejado</option>
                                        <option value="ongoing" {{ request('status') == 'ongoing' ? 'selected' : '' }}>Em Andamento</option>
                                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Concluído</option>
                                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelado</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <select name="event_type_id" class="form-control">
                                        <option value="">Todos os tipos</option>
                                        @foreach($eventTypes as $type)
                                            <option value="{{ $type->id }}" {{ request('event_type_id') == $type->id ? 'selected' : '' }}>
                                                {{ $type->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <select name="venue_id" class="form-control">
                                        <option value="">Todos os locais</option>
                                        @foreach($venues as $venue)
                                            <option value="{{ $venue->id }}" {{ request('venue_id') == $venue->id ? 'selected' : '' }}>
                                                {{ $venue->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-1">
                                    <button type="submit" class="btn btn-default">
                                        <i class="fas fa-search"></i> Filtrar
                                    </button>
                                </div>
                            </div>
                        </form>

                        <!-- Lista de Eventos -->
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Evento</th>
                                        <th>Tipo</th>
                                        <th>Data/Hora</th>
                                        <th>Local</th>
                                        <th>Status</th>
                                        <th>Inscrições</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($events as $event)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    @if($event->image)
                                                        <img src="{{ $event->image_url }}" class="mr-2" style="width: 40px; height: 40px; object-fit: cover;">
                                                    @endif
                                                    <div>
                                                        <strong>{{ $event->title }}</strong>
                                                        @if(!$event->is_public)
                                                            <span class="badge badge-secondary ml-1">Privado</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge" @if($event->eventType->color) style="background-color: {{ $event->eventType->color }};" @endif>
                                                    {{ $event->eventType->name }}
                                                </span>
                                            </td>
                                            <td>
                                                <small>
                                                    {{ $event->formatted_date }}<br>
                                                    {{ $event->formatted_time }}
                                                </small>
                                            </td>
                                            <td>{{ $event->venue?->name ?? '--' }}</td>
                                            <td>{!! $event->status_badge !!}</td>
                                            <td>
                                                <small>
                                                    @if($event->requires_registration)
                                                        {{ $event->current_participants }}
                                                        @if($event->max_participants)
                                                            / {{ $event->max_participants }}
                                                        @endif
                                                    @else
                                                        Não requer
                                                    @endif
                                                </small>
                                            </td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <a href="{{ route('admin.events.show', $event) }}" class="btn btn-outline-primary">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('admin.events.edit', $event) }}" class="btn btn-outline-info">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <a href="{{ route('admin.events.duplicate', $event) }}" class="btn btn-outline-warning" title="Duplicar">
                                                        <i class="fas fa-copy"></i>
                                                    </a>
                                                    <form action="{{ route('admin.events.destroy', $event) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-outline-danger" 
                                                                onclick="return confirm('Tem certeza?')">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center">
                                                <div class="alert alert-info">
                                                    <i class="fas fa-info-circle"></i> Nenhum evento encontrado.
                                                    <a href="{{ route('admin.events.create') }}" class="alert-link">Criar primeiro evento</a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Paginação -->
                        <div class="d-flex justify-content-center">
                            {{ $events->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
