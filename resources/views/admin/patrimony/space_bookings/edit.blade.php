@extends('adminlte::page')

@section('title', 'Editar Reserva de Espaço')

@section('content_header')
    <h1>Editar Reserva de Espaço</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Editar Reserva de Espaço</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('patrimony.space_bookings.update', $spaceBooking) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="space_name">Nome do Espaço</label>
                <input type="text" name="space_name" class="form-control" value="{{ $spaceBooking->space_name }}" required>
            </div>
            <div class="form-group">
                <label for="booked_by">Reservado por</label>
                <select name="booked_by" class="form-control" required>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ $spaceBooking->booked_by == $user->id ? 'selected' : '' }}>
                            {{ $user->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="start_time">Data e Hora de Início</label>
                <input type="datetime-local" name="start_time" class="form-control" value="{{ $spaceBooking->start_time->format('Y-m-d\TH:i') }}" required>
            </div>
            <div class="form-group">
                <label for="end_time">Data e Hora de Fim</label>
                <input type="datetime-local" name="end_time" class="form-control" value="{{ $spaceBooking->end_time->format('Y-m-d\TH:i') }}" required>
            </div>
            <div class="form-group">
                <label for="purpose">Propósito</label>
                <input type="text" name="purpose" class="form-control" value="{{ $spaceBooking->purpose }}" required>
            </div>
            <div class="form-group">
                <label for="status">Status</label>
                <select name="status" class="form-control" required>
                    <option value="pending" {{ $spaceBooking->status == 'pending' ? 'selected' : '' }}>Pendente</option>
                    <option value="approved" {{ $spaceBooking->status == 'approved' ? 'selected' : '' }}>Aprovada</option>
                    <option value="rejected" {{ $spaceBooking->status == 'rejected' ? 'selected' : '' }}>Rejeitada</option>
                    <option value="cancelled" {{ $spaceBooking->status == 'cancelled' ? 'selected' : '' }}>Cancelada</option>
                </select>
            </div>
            <div class="form-group">
                <label for="notes">Notas</label>
                <textarea name="notes" class="form-control" rows="3">{{ $spaceBooking->notes }}</textarea>
            </div>
            <button type="submit" class="btn btn-primary">Atualizar</button>
            <a href="{{ route('patrimony.space_bookings.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</div>
@stop