@extends('adminlte::page')

@section('title', 'Detalhes da Reserva de Espaço')

@section('content_header')
    <h1>Detalhes da Reserva de Espaço</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Reserva #{{ $spaceBooking->id }}</h3>
        <div class="card-tools">
            @can('patrimony.space_bookings.edit')
            <a href="{{ route('patrimony.space_bookings.edit', $spaceBooking) }}" class="btn btn-warning btn-sm">
                <i class="fas fa-edit"></i> Editar
            </a>
            @endcan
            <a href="{{ route('patrimony.space_bookings.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Voltar
            </a>
        </div>
    </div>
    <div class="card-body">
        <dl class="row">
            <dt class="col-sm-3">Nome do Espaço</dt>
            <dd class="col-sm-9">{{ $spaceBooking->space_name }}</dd>

            <dt class="col-sm-3">Reservado por</dt>
            <dd class="col-sm-9">{{ $spaceBooking->user->name }}</dd>

            <dt class="col-sm-3">Data e Hora de Início</dt>
            <dd class="col-sm-9">{{ $spaceBooking->start_time->format('d/m/Y H:i') }}</dd>

            <dt class="col-sm-3">Data e Hora de Fim</dt>
            <dd class="col-sm-9">{{ $spaceBooking->end_time->format('d/m/Y H:i') }}</dd>

            <dt class="col-sm-3">Propósito</dt>
            <dd class="col-sm-9">{{ $spaceBooking->purpose }}</dd>

            <dt class="col-sm-3">Status</dt>
            <dd class="col-sm-9">
                <span class="badge badge-{{ $spaceBooking->status == 'approved' ? 'success' : ($spaceBooking->status == 'pending' ? 'warning' : 'secondary') }}">
                    {{ ucfirst($spaceBooking->status) }}
                </span>
            </dd>

            <dt class="col-sm-3">Notas</dt>
            <dd class="col-sm-9">{{ $spaceBooking->notes ?: 'Nenhuma nota' }}</dd>

            <dt class="col-sm-3">Criado em</dt>
            <dd class="col-sm-9">{{ $spaceBooking->created_at->format('d/m/Y H:i') }}</dd>

            <dt class="col-sm-3">Atualizado em</dt>
            <dd class="col-sm-9">{{ $spaceBooking->updated_at->format('d/m/Y H:i') }}</dd>
        </dl>
    </div>
</div>
@stop