@extends('adminlte::page')

@section('title', 'Editar Reunião do Conselho Fiscal')

@section('content_header')
    <h1>Editar Reunião do Conselho Fiscal</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Editar Reunião</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('fiscal-council-meetings.update', $fiscalCouncilMeeting) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="meeting_date">Data da Reunião</label>
                <input type="date" name="meeting_date" class="form-control" value="{{ $fiscalCouncilMeeting->meeting_date->format('Y-m-d') }}" required>
            </div>
            <div class="form-group">
                <label for="attendees">Participantes (um por linha)</label>
                <textarea name="attendees" class="form-control" rows="3">{{ is_array($fiscalCouncilMeeting->attendees) ? implode("\n", $fiscalCouncilMeeting->attendees) : $fiscalCouncilMeeting->attendees }}</textarea>
            </div>
            <div class="form-group">
                <label for="minutes">Ata da Reunião</label>
                <textarea name="minutes" class="form-control" rows="5">{{ $fiscalCouncilMeeting->minutes }}</textarea>
            </div>
            <div class="form-group">
                <label for="decisions">Decisões Tomadas</label>
                <textarea name="decisions" class="form-control" rows="3">{{ $fiscalCouncilMeeting->decisions }}</textarea>
            </div>
            <div class="form-group">
                <label for="status">Status</label>
                <select name="status" class="form-control" required>
                    <option value="scheduled" {{ $fiscalCouncilMeeting->status == 'scheduled' ? 'selected' : '' }}>Agendada</option>
                    <option value="held" {{ $fiscalCouncilMeeting->status == 'held' ? 'selected' : '' }}>Realizada</option>
                    <option value="cancelled" {{ $fiscalCouncilMeeting->status == 'cancelled' ? 'selected' : '' }}>Cancelada</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Salvar</button>
            <a href="{{ route('fiscal-council-meetings.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</div>
@stop