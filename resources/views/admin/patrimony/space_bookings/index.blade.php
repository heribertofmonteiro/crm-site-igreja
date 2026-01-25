@extends('adminlte::page')

@section('title', 'Reservas de Espaços')

@section('content_header')
    <h1>Reservas de Espaços</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Lista de Reservas de Espaços</h3>
        <div class="card-tools">
            <a href="{{ route('patrimony.space_bookings.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Nova Reserva
            </a>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Espaço</th>
                    <th>Reservado por</th>
                    <th>Início</th>
                    <th>Fim</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($spaceBookings as $booking)
                <tr>
                    <td>{{ $booking->id }}</td>
                    <td>{{ $booking->space_name }}</td>
                    <td>{{ $booking->user->name }}</td>
                    <td>{{ $booking->start_time->format('d/m/Y H:i') }}</td>
                    <td>{{ $booking->end_time->format('d/m/Y H:i') }}</td>
                    <td>
                        <span class="badge badge-{{ $booking->status == 'approved' ? 'success' : ($booking->status == 'pending' ? 'warning' : 'secondary') }}">
                            {{ ucfirst($booking->status) }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('patrimony.space_bookings.show', $booking) }}" class="btn btn-info btn-sm">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('patrimony.space_bookings.edit', $booking) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('patrimony.space_bookings.destroy', $booking) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{ $spaceBookings->links() }}
    </div>
</div>
@stop