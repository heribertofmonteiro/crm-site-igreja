@extends('adminlte::page')

@section('title', 'Detalhes do Ensaio')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Detalhes do Ensaio</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.worship.rehearsals.index') }}">Ensaios</a></li>
                    <li class="breadcrumb-item active">Detalhes</li>
                </ol>
            </div>
        </div>
    </div>
@stop

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="card card-outline card-primary">
            <div class="card-body box-profile">
                <h3 class="profile-username text-center">Ensaio</h3>
                <p class="text-muted text-center">{{ $worshipRehearsal->worshipTeam->name }}</p>

                <ul class="list-group list-group-unbordered mb-3">
                    <li class="list-group-item">
                        <b>Data</b> <span class="float-right">{{ $worshipRehearsal->scheduled_at->format('d/m/Y') }}</span>
                    </li>
                    <li class="list-group-item">
                        <b>Hora</b> <span class="float-right">{{ $worshipRehearsal->scheduled_at->format('H:i') }}</span>
                    </li>
                    <li class="list-group-item">
                        <b>Status</b> 
                        <span class="float-right">
                            @if($worshipRehearsal->status == 'scheduled')
                                <span class="badge badge-warning">Agendado</span>
                            @elseif($worshipRehearsal->status == 'in_progress')
                                <span class="badge badge-info">Em Andamento</span>
                            @elseif($worshipRehearsal->status == 'completed')
                                <span class="badge badge-success">Concluído</span>
                            @elseif($worshipRehearsal->status == 'cancelled')
                                <span class="badge badge-danger">Cancelado</span>
                            @endif
                        </span>
                    </li>
                    <li class="list-group-item">
                        <b>Local</b> <span class="float-right">{{ $worshipRehearsal->location ?? 'Não definido' }}</span>
                    </li>
                </ul>

                @if($worshipRehearsal->status == 'scheduled')
                    <form action="{{ route('admin.worship.rehearsals.start', $worshipRehearsal) }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-primary btn-block"><b>Iniciar Ensaio</b></button>
                    </form>
                    <form action="{{ route('admin.worship.rehearsals.cancel', $worshipRehearsal) }}" method="POST" class="d-inline mt-2">
                        @csrf
                        <button type="submit" class="btn btn-danger btn-block mt-2" onclick="return confirm('Tem certeza que deseja cancelar?')"><b>Cancelar Ensaio</b></button>
                    </form>
                @elseif($worshipRehearsal->status == 'in_progress')
                    <form action="{{ route('admin.worship.rehearsals.complete', $worshipRehearsal) }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-success btn-block"><b>Concluir Ensaio</b></button>
                    </form>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Informações Adicionais</h3>
            </div>
            <div class="card-body">
                <strong><i class="fas fa-sticky-note mr-1"></i> Observações</strong>
                <p class="text-muted">
                    {{ $worshipRehearsal->notes ?? 'Nenhuma observação.' }}
                </p>
                <hr>
                <strong><i class="fas fa-user-clock mr-1"></i> Agendado por</strong>
                <p class="text-muted">
                    {{ $worshipRehearsal->creator?->name ?? 'Sistema' }} em {{ $worshipRehearsal->created_at->format('d/m/Y H:i') }}
                </p>
                @if($worshipRehearsal->started_at)
                    <hr>
                    <strong><i class="fas fa-play mr-1"></i> Iniciado em</strong>
                    <p class="text-muted">{{ $worshipRehearsal->started_at->format('d/m/Y H:i') }}</p>
                @endif
                @if($worshipRehearsal->ended_at)
                    <hr>
                    <strong><i class="fas fa-check mr-1"></i> Concluído em</strong>
                    <p class="text-muted">{{ $worshipRehearsal->ended_at->format('d/m/Y H:i') }}</p>
                @endif
            </div>
            <div class="card-footer">
                <a href="{{ route('admin.worship.rehearsals.index') }}" class="btn btn-default">Voltar</a>
                @if($worshipRehearsal->status == 'scheduled')
                    <a href="{{ route('admin.worship.rehearsals.edit', $worshipRehearsal) }}" class="btn btn-warning float-right">Editar</a>
                @endif
            </div>
        </div>
    </div>
</div>
@stop
