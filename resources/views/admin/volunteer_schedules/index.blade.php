@extends('adminlte::page')

@section('title', 'Escalas de Voluntários')

@section('content_header')
    <h1>Escalas de Voluntários</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Lista de Escalas</h3>
        @can('volunteer_schedules.create')
        <div class="card-tools">
            <a href="{{ route('admin.volunteer_schedules.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Nova Escala
            </a>
        </div>
        @endcan
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Função</th>
                    <th>Voluntário</th>
                    <th>Data do Evento</th>
                    <th>Horário</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($schedules as $schedule)
                <tr>
                    <td>{{ $schedule->id }}</td>
                    <td>{{ $schedule->volunteerRole->name }}</td>
                    <td>{{ $schedule->user->name }}</td>
                    <td>{{ $schedule->event_date->format('d/m/Y') }}</td>
                    <td>{{ $schedule->start_time }} - {{ $schedule->end_time }}</td>
                    <td>
                        <span class="badge badge-{{ $schedule->status == 'confirmed' ? 'success' : ($schedule->status == 'pending' ? 'warning' : 'danger') }}">
                            {{ ucfirst($schedule->status) }}
                        </span>
                    </td>
                    <td>
                        @can('volunteer_schedules.view')
                        <a href="{{ route('admin.volunteer_schedules.show', $schedule) }}" class="btn btn-info btn-sm">
                            <i class="fas fa-eye"></i>
                        </a>
                        @endcan
                        @can('volunteer_schedules.edit')
                        <a href="{{ route('admin.volunteer_schedules.edit', $schedule) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i>
                        </a>
                        @endcan
                        @can('volunteer_schedules.delete')
                        <form action="{{ route('admin.volunteer_schedules.destroy', $schedule) }}" method="POST" style="display: inline;">
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
        {{ $schedules->links() }}
    </div>
</div>
@stop