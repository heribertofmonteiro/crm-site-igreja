@extends('adminlte::page')

@section('title', 'Detalhes da Equipe')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Detalhes da Equipe</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.worship.teams.index') }}">Equipes</a></li>
                    <li class="breadcrumb-item active">Detalhes</li>
                </ol>
            </div>
        </div>
    </div>
@stop

@section('content')
<div class="row">
    <div class="col-md-3">
        <div class="card card-primary card-outline">
            <div class="card-body box-profile">
                <div class="text-center">
                    <i class="fas fa-users-cog fa-5x text-secondary"></i>
                </div>

                <h3 class="profile-username text-center mt-3">{{ $worshipTeam->name }}</h3>

                <p class="text-muted text-center">
                    @if($worshipTeam->is_active)
                        <span class="badge badge-success">Ativa</span>
                    @else
                        <span class="badge badge-danger">Inativa</span>
                    @endif
                </p>

                <ul class="list-group list-group-unbordered mb-3">
                    <li class="list-group-item">
                        <b>Membros</b> <span class="float-right badge badge-primary">--</span>
                    </li>
                    <li class="list-group-item">
                        <b>Ensaios</b> <span class="float-right badge badge-info">{{ $worshipTeam->rehearsals_count ?? 0 }}</span>
                    </li>
                </ul>
            </div>
        </div>

        <div class="card card-default">
            <div class="card-header">
                <h3 class="card-title">Sobre</h3>
            </div>
            <div class="card-body">
                <strong><i class="fas fa-user mr-1"></i> Líder</strong>
                <p class="text-muted">{{ $worshipTeam->leader?->name ?? 'Não Definido' }}</p>
                
                @if($worshipTeam->description)
                <hr>
                <strong><i class="fas fa-file-alt mr-1"></i> Descrição</strong>
                <p class="text-muted">{{ $worshipTeam->description }}</p>
                @endif
            </div>
        </div>
    </div>
    
    <div class="col-md-9">
        <div class="card">
            <div class="card-header p-2">
                <ul class="nav nav-pills">
                    <li class="nav-item"><a class="nav-link active" href="#rehearsals" data-toggle="tab">Ensaios</a></li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content">
                    <div class="active tab-pane" id="rehearsals">
                        @if($worshipTeam->rehearsals->count() > 0)
                            <div class="timeline timeline-inverse">
                                @foreach($worshipTeam->rehearsals as $rehearsal)
                                    <div>
                                        <i class="fas fa-microphone bg-info"></i>
                                        <div class="timeline-item">
                                            <span class="time"><i class="far fa-clock"></i> {{ $rehearsal->scheduled_at->format('d/m/Y H:i') }}</span>
                                            <h3 class="timeline-header"><a href="#">Ensaio</a> {{ $rehearsal->status_label }}</h3>
                                            <div class="timeline-body">
                                                Local: {{ $rehearsal->location ?? 'Não definido' }}<br>
                                                {{ $rehearsal->notes }}
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                <div>
                                    <i class="far fa-clock bg-gray"></i>
                                </div>
                            </div>
                        @else
                            <p class="text-muted">Nenhum ensaio recente.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="card-footer">
            <a href="{{ route('admin.worship.teams.index') }}" class="btn btn-default">
                <i class="fas fa-arrow-left"></i> Voltar
            </a>
            <div class="float-right">
                <a href="{{ route('admin.worship.teams.edit', $worshipTeam) }}" class="btn btn-warning">
                    <i class="fas fa-pencil-alt"></i> Editar
                </a>
            </div>
        </div>
    </div>
</div>
@stop
