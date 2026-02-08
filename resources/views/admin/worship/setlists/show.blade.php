@extends('adminlte::page')

@section('title', 'Detalhes da Setlist')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Detalhes da Setlist</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.worship.setlists.index') }}">Setlists</a></li>
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
                    <i class="fas fa-list-ol fa-5x text-secondary"></i>
                </div>

                <h3 class="profile-username text-center mt-3">{{ $worshipSetlist->date->format('d/m/Y') }}</h3>

                <p class="text-muted text-center">{{ $worshipSetlist->theme ?? 'Sem Tema' }}</p>

                <ul class="list-group list-group-unbordered mb-3">
                    <li class="list-group-item">
                        <b>Músicas</b> <span class="float-right badge badge-primary">{{ $worshipSetlist->song_count }}</span>
                    </li>
                    <li class="list-group-item">
                        <b>Duração Aprox.</b> <span class="float-right">{{ $worshipSetlist->formatted_total_duration }}</span>
                    </li>
                    @if($worshipSetlist->event)
                    <li class="list-group-item">
                        <b>Evento</b> <span class="float-right">{{ $worshipSetlist->event->title }}</span>
                    </li>
                    @endif
                </ul>
                
                <a href="{{ route('admin.worship.setlists.print', $worshipSetlist) }}" target="_blank" class="btn btn-default btn-block">
                    <i class="fas fa-print"></i> Imprimir
                </a>
            </div>
        </div>

        <div class="card card-default">
            <div class="card-header">
                <h3 class="card-title">Metadados</h3>
            </div>
            <div class="card-body">
                <strong><i class="fas fa-user mr-1"></i> Criado por</strong>
                <p class="text-muted">{{ $worshipSetlist->creator?->name ?? 'Sistema' }}</p>
                <hr>
                <strong><i class="far fa-clock mr-1"></i> Atualizado em</strong>
                <p class="text-muted">{{ $worshipSetlist->updated_at->format('d/m/Y H:i') }}</p>
            </div>
        </div>
    </div>
    
    <div class="col-md-9">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Músicas</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                </div>
            </div>
            <div class="card-body p-0">
                <table class="table table-striped projects">
                    <thead>
                        <tr>
                            <th style="width: 5%">#</th>
                            <th style="width: 40%">Título</th>
                            <th style="width: 15%">Tom</th>
                            <th style="width: 40%">Observações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($worshipSetlist->songs as $index => $song)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <strong>{{ $song->title }}</strong><br>
                                    <small>{{ $song->artist }}</small>
                                </td>
                                <td>
                                    @if($song->pivot->key_override)
                                        <span class="badge badge-warning" title="Tom Original: {{ $song->key }}">{{ $song->pivot->key_override }}</span>
                                    @else
                                        {{ $song->key ?? '--' }}
                                    @endif
                                </td>
                                <td>
                                    {{ $song->pivot->notes ?? $song->notes ?? '--' }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        @if($worshipSetlist->notes)
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Observações da Setlist</h3>
            </div>
            <div class="card-body">
                {!! nl2br(e($worshipSetlist->notes)) !!}
            </div>
        </div>
        @endif

        <div class="card-footer">
            <a href="{{ route('admin.worship.setlists.index') }}" class="btn btn-default">
                <i class="fas fa-arrow-left"></i> Voltar
            </a>
            <div class="float-right">
                <a href="{{ route('admin.worship.setlists.edit', $worshipSetlist) }}" class="btn btn-warning">
                    <i class="fas fa-pencil-alt"></i> Editar
                </a>
                <form action="{{ route('admin.worship.setlists.destroy', $worshipSetlist) }}" method="POST" class="d-inline" onsubmit="return confirm('Tem certeza que deseja excluir esta setlist?');">
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
@stop
