@extends('adminlte::page')

@section('title', 'Nova Reunião do Conselho Fiscal')

@section('content_header')
    <h1>Nova Reunião do Conselho Fiscal</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Criar Nova Reunião</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('fiscal-council-meetings.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="meeting_date">Data da Reunião</label>
                <input type="date" name="meeting_date" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="attendees">Participantes (um por linha)</label>
                <textarea name="attendees" class="form-control" rows="3" placeholder="João Silva&#10;Maria Santos"></textarea>
            </div>
            <div class="form-group">
                <label for="minutes">Ata da Reunião</label>
                <textarea name="minutes" class="form-control" rows="5"></textarea>
            </div>
            <div class="form-group">
                <label for="decisions">Decisões Tomadas</label>
                <textarea name="decisions" class="form-control" rows="3"></textarea>
            </div>
            <div class="form-group">
                <label for="status">Status</label>
                <select name="status" class="form-control" required>
                    <option value="scheduled">Agendada</option>
                    <option value="held">Realizada</option>
                    <option value="cancelled">Cancelada</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Salvar</button>
            <a href="{{ route('fiscal-council-meetings.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</div>
@stop