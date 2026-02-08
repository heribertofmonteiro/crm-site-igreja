@extends('adminlte::page')

@section('title', 'Editar Escala de Voluntário')

@section('content_header')
    <h1>Editar Escala de Voluntário</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Editar Escala</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.volunteer_schedules.update', $schedule) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="volunteer_role_id">Função</label>
                <select name="volunteer_role_id" class="form-control" required>
                    @foreach($volunteerRoles as $role)
                        <option value="{{ $role->id }}" {{ $schedule->volunteer_role_id == $role->id ? 'selected' : '' }}>
                            {{ $role->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="user_id">Voluntário</label>
                <select name="user_id" class="form-control" required>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ $schedule->user_id == $user->id ? 'selected' : '' }}>
                            {{ $user->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="event_date">Data do Evento</label>
                <input type="date" name="event_date" class="form-control" value="{{ $schedule->event_date->format('Y-m-d') }}" required>
            </div>
            <div class="form-group">
                <label for="start_time">Horário de Início</label>
                <input type="time" name="start_time" class="form-control" value="{{ $schedule->start_time }}" required>
            </div>
            <div class="form-group">
                <label for="end_time">Horário de Fim</label>
                <input type="time" name="end_time" class="form-control" value="{{ $schedule->end_time }}" required>
            </div>
            <div class="form-group">
                <label for="status">Status</label>
                <select name="status" class="form-control" required>
                    <option value="pending" {{ $schedule->status == 'pending' ? 'selected' : '' }}>Pendente</option>
                    <option value="confirmed" {{ $schedule->status == 'confirmed' ? 'selected' : '' }}>Confirmado</option>
                    <option value="cancelled" {{ $schedule->status == 'cancelled' ? 'selected' : '' }}>Cancelado</option>
                </select>
            </div>
            <div class="form-group">
                <label for="notes">Notas</label>
                <textarea name="notes" class="form-control" rows="3">{{ $schedule->notes }}</textarea>
            </div>
            <button type="submit" class="btn btn-primary">Atualizar</button>
            <a href="{{ route('admin.volunteer_schedules.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</div>
@stop