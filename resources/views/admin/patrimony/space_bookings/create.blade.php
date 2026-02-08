@extends('adminlte::page')

@section('title', 'Nova Reserva de Espaço')

@section('content_header')
    <h1>Nova Reserva de Espaço</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Criar Nova Reserva de Espaço</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('patrimony.space_bookings.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="space_name">Nome do Espaço</label>
                <input type="text" name="space_name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="booked_by">Reservado por</label>
                <select name="booked_by" class="form-control" required>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="start_time">Data e Hora de Início</label>
                <input type="datetime-local" name="start_time" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="end_time">Data e Hora de Fim</label>
                <input type="datetime-local" name="end_time" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="purpose">Propósito</label>
                <input type="text" name="purpose" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="status">Status</label>
                <select name="status" class="form-control" required>
                    <option value="pending">Pendente</option>
                    <option value="approved">Aprovada</option>
                    <option value="rejected">Rejeitada</option>
                    <option value="cancelled">Cancelada</option>
                </select>
            </div>
            <div class="form-group">
                <label for="notes">Notas</label>
                <textarea name="notes" class="form-control" rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Salvar</button>
            <a href="{{ route('patrimony.space_bookings.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</div>
@stop