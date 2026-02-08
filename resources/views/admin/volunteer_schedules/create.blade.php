@extends('adminlte::page')

@section('title', 'Nova Escala de Voluntário')

@section('content_header')
    <h1>Nova Escala de Voluntário</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Criar Nova Escala</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.volunteer_schedules.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="volunteer_role_id">Função</label>
                <select name="volunteer_role_id" class="form-control" required>
                    @foreach($volunteerRoles as $role)
                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="user_id">Voluntário</label>
                <select name="user_id" class="form-control" required>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="event_date">Data do Evento</label>
                <input type="date" name="event_date" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="start_time">Horário de Início</label>
                <input type="time" name="start_time" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="end_time">Horário de Fim</label>
                <input type="time" name="end_time" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="status">Status</label>
                <select name="status" class="form-control" required>
                    <option value="pending">Pendente</option>
                    <option value="confirmed">Confirmado</option>
                    <option value="cancelled">Cancelado</option>
                </select>
            </div>
            <div class="form-group">
                <label for="notes">Notas</label>
                <textarea name="notes" class="form-control" rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Salvar</button>
            <a href="{{ route('admin.volunteer_schedules.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</div>
@stop