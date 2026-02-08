@extends('adminlte::page')

@section('title', 'Detalhes da Ata')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Detalhes da Ata</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.administration.meeting-minutes.index') }}">Atas</a></li>
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
                <h3 class="profile-username text-center">{{ $minute->title }}</h3>
                <p class="text-muted text-center">{{ $minute->meeting_type ?? 'Geral' }}</p>

                <ul class="list-group list-group-unbordered mb-3">
                    <li class="list-group-item">
                        <b>Data</b> <span class="float-right">{{ $minute->formatted_meeting_date }}</span>
                    </li>
                    <li class="list-group-item">
                        <b>Status</b> <span class="float-right">{!! $minute->status_badge !!}</span>
                    </li>
                    <li class="list-group-item">
                        <b>Participantes</b> <span class="float-right badge badge-info">{{ $minute->participants_count }}</span>
                    </li>
                </ul>
                
                @if($minute->canBeApproved())
                    <form action="{{ route('admin.administration.meeting-minutes.approve', $minute) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-success btn-block"><b>Aprovar Ata</b></button>
                    </form>
                @endif
            </div>
        </div>

        <div class="card card-default">
            <div class="card-header">
                <h3 class="card-title">Participantes</h3>
            </div>
            <div class="card-body">
                <p>{{ $minute->participants_list }}</p>
            </div>
        </div>
    </div>
    
    <div class="col-md-9">
        <div class="card">
            <div class="card-header p-2">
                <ul class="nav nav-pills">
                    <li class="nav-item"><a class="nav-link active" href="#content" data-toggle="tab">Pauta e Discussão</a></li>
                    <li class="nav-item"><a class="nav-link" href="#outcomes" data-toggle="tab">Decisões e Encaminhamentos</a></li>
                    <li class="nav-item"><a class="nav-link" href="#metadata" data-toggle="tab">Metadados</a></li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content">
                    <div class="active tab-pane" id="content">
                        <strong><i class="fas fa-map-marker-alt mr-1"></i> Local</strong>
                        <p class="text-muted">{{ $minute->location ?? 'Não informado' }}</p>
                        
                        <hr>

                        <strong><i class="fas fa-file-alt mr-1"></i> Conteúdo</strong>
                        <div class="mt-2">
                            {!! nl2br(e($minute->content)) !!}
                        </div>
                    </div>

                    <div class="tab-pane" id="outcomes">
                        <strong><i class="fas fa-gavel mr-1"></i> Decisões</strong>
                        @if($minute->decisions)
                            <div class="callout callout-info mt-2">
                                {!! nl2br(e($minute->decisions)) !!}
                            </div>
                        @else
                            <p class="text-muted mt-2">Nenhuma decisão registrada.</p>
                        @endif

                        <hr>

                        <strong><i class="fas fa-tasks mr-1"></i> Encaminhamentos</strong>
                        @if($minute->action_items)
                            <div class="callout callout-warning mt-2">
                                {!! nl2br(e($minute->action_items)) !!}
                            </div>
                        @else
                            <p class="text-muted mt-2">Nenhum encaminhamento registrado.</p>
                        @endif
                    </div>

                    <div class="tab-pane" id="metadata">
                        <dl class="row">
                            <dt class="col-sm-3">Criado por</dt>
                            <dd class="col-sm-9">{{ $minute->creator?->name ?? 'Sistema' }} em {{ $minute->created_at->format('d/m/Y H:i') }}</dd>

                            <dt class="col-sm-3">Aprovado por</dt>
                            <dd class="col-sm-9">
                                @if($minute->approved_by)
                                    {{ $minute->approver?->name ?? $minute->approved_by }} em {{ optional($minute->approved_at)->format('d/m/Y H:i') }}
                                @else
                                    <span class="text-warning">Pendente</span>
                                @endif
                            </dd>

                            <dt class="col-sm-3">Última atualização</dt>
                            <dd class="col-sm-9">{{ $minute->updated_at->format('d/m/Y H:i') }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <a href="{{ route('admin.administration.meeting-minutes.index') }}" class="btn btn-default">
                    <i class="fas fa-arrow-left"></i> Voltar
                </a>
                <div class="float-right">
                    <a href="{{ route('admin.administration.meeting-minutes.edit', $minute) }}" class="btn btn-warning">
                        <i class="fas fa-pencil-alt"></i> Editar
                    </a>
                    <form action="{{ route('admin.administration.meeting-minutes.destroy', $minute) }}" method="POST" class="d-inline" onsubmit="return confirm('Tem certeza que deseja excluir esta ata?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash"></i> Excluir
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
