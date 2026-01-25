@extends('adminlte::page')

@section('title', 'Detalhes da Reunião do Conselho Fiscal')

@section('content_header')
    <h1>Detalhes da Reunião do Conselho Fiscal</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Reunião #{{ $fiscalCouncilMeeting->id }}</h3>
        <div class="card-tools">
            <a href="{{ route('fiscal-council-meetings.edit', $fiscalCouncilMeeting) }}" class="btn btn-warning btn-sm">
                <i class="fas fa-edit"></i> Editar
            </a>
        </div>
    </div>
    <div class="card-body">
        <dl class="row">
            <dt class="col-sm-3">Data da Reunião</dt>
            <dd class="col-sm-9">{{ $fiscalCouncilMeeting->meeting_date->format('d/m/Y') }}</dd>

            <dt class="col-sm-3">Status</dt>
            <dd class="col-sm-9">
                @if($fiscalCouncilMeeting->status == 'scheduled')
                    <span class="badge badge-info">Agendada</span>
                @elseif($fiscalCouncilMeeting->status == 'held')
                    <span class="badge badge-success">Realizada</span>
                @else
                    <span class="badge badge-danger">Cancelada</span>
                @endif
            </dd>

            <dt class="col-sm-3">Participantes</dt>
            <dd class="col-sm-9">
                @if($fiscalCouncilMeeting->attendees)
                    <ul>
                        @foreach($fiscalCouncilMeeting->attendees as $attendee)
                            <li>{{ $attendee }}</li>
                        @endforeach
                    </ul>
                @else
                    Nenhum participante registrado.
                @endif
            </dd>

            <dt class="col-sm-3">Ata da Reunião</dt>
            <dd class="col-sm-9">{{ $fiscalCouncilMeeting->minutes ?: 'Não registrada.' }}</dd>

            <dt class="col-sm-3">Decisões Tomadas</dt>
            <dd class="col-sm-9">{{ $fiscalCouncilMeeting->decisions ?: 'Nenhuma decisão registrada.' }}</dd>
        </dl>
    </div>
</div>
@stop