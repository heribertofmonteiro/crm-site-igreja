@extends('adminlte::page')

@section('title', 'Detalhes da Escala de Voluntário')

@section('content_header')
    <h1>Detalhes da Escala de Voluntário</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Escala #{{ $schedule->id }}</h3>
        <div class="card-tools">
            @can('volunteer_schedules.edit')
            <a href="{{ route('admin.volunteer_schedules.edit', $schedule) }}" class="btn btn-warning btn-sm">
                <i class="fas fa-edit"></i> Editar
            </a>
            @endcan
            <a href="{{ route('admin.volunteer_schedules.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Voltar
            </a>
        </div>
    </div>
    <div class="card-body">
        <dl class="row">
            <dt class="col-sm-3">Função</dt>
            <dd class="col-sm-9">{{ $schedule->volunteerRole->name }}</dd>

            <dt class="col-sm-3">Voluntário</dt>
            <dd class="col-sm-9">{{ $schedule->user->name }}</dd>

            <dt class="col-sm-3">Data do Evento</dt>
            <dd class="col-sm-9">{{ $schedule->event_date->format('d/m/Y') }}</dd>

            <dt class="col-sm-3">Horário de Início</dt>
            <dd class="col-sm-9">{{ $schedule->start_time }}</dd>

            <dt class="col-sm-3">Horário de Fim</dt>
            <dd class="col-sm-9">{{ $schedule->end_time }}</dd>

            <dt class="col-sm-3">Status</dt>
            <dd class="col-sm-9">
                <span class="badge badge-{{ $schedule->status == 'confirmed' ? 'success' : ($schedule->status == 'pending' ? 'warning' : 'danger') }}">
                    {{ ucfirst($schedule->status) }}
                </span>
            </dd>

            <dt class="col-sm-3">Notas</dt>
            <dd class="col-sm-9">{{ $schedule->notes ?: 'Nenhuma nota' }}</dd>

            <dt class="col-sm-3">Criado em</dt>
            <dd class="col-sm-9">{{ $schedule->created_at->format('d/m/Y H:i') }}</dd>

            <dt class="col-sm-3">Atualizado em</dt>
            <dd class="col-sm-9">{{ $schedule->updated_at->format('d/m/Y H:i') }}</dd>
        </dl>
    </div>
</div>
@stop