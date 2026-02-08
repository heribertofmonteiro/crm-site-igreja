@extends('adminlte::page')

@section('title', 'Transmissões ao Vivo')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Transmissões ao Vivo</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.media.index') }}">Mídias</a></li>
                    <li class="breadcrumb-item active">Transmissões</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Lista de Transmissões</h3>
                        <div class="card-tools">
                            <a href="{{ route('admin.media.livestreams.create') }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-plus"></i> Nova Transmissão
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Filtros -->
                        <form method="GET" class="mb-3">
                            <div class="row">
                                <div class="col-md-3">
                                    <select name="status" class="form-control">
                                        <option value="">Todos os status</option>
                                        <option value="scheduled" {{ request('status') == 'scheduled' ? 'selected' : '' }}>Agendadas</option>
                                        <option value="live" {{ request('status') == 'live' ? 'selected' : '' }}>Ao Vivo</option>
                                        <option value="ended" {{ request('status') == 'ended' ? 'selected' : '' }}>Encerradas</option>
                                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Canceladas</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-default">
                                        <i class="fas fa-search"></i> Filtrar
                                    </button>
                                </div>
                            </div>
                        </form>

                        <!-- Lista de Transmissões -->
                        <div class="row">
                            @forelse($streams as $stream)
                                <div class="col-md-6 mb-4">
                                    <div class="card">
                                        <div class="card-header">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <h5 class="card-title mb-0">
                                                    <i class="{{ $stream->platform_icon }} mr-2"></i>
                                                    {{ $stream->title }}
                                                </h5>
                                                <span class="badge badge-{{ $stream->status == 'live' ? 'danger' : ($stream->status == 'scheduled' ? 'warning' : ($stream->status == 'ended' ? 'success' : 'secondary')) }}">
                                                    {{ $stream->status == 'live' ? 'AO VIVO' : ($stream->status == 'scheduled' ? 'AGENDADA' : ($stream->status == 'ended' ? 'ENCERRADA' : 'CANCELADA')) }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            @if($stream->description)
                                                <p class="card-text">{{ Str::limit($stream->description, 100) }}</p>
                                            @endif

                                            <div class="row text-center mb-3">
                                                <div class="col-4">
                                                    <h6>{{ ucfirst($stream->platform) }}</h6>
                                                    <small class="text-muted">Plataforma</small>
                                                </div>
                                                <div class="col-4">
                                                    <h6>{{ $stream->viewer_count }}</h6>
                                                    <small class="text-muted">Visualizadores</small>
                                                </div>
                                                <div class="col-4">
                                                    <h6>
                                                        @if($stream->status == 'live')
                                                            <i class="fas fa-circle text-danger fa-pulse"></i>
                                                        @else
                                                            <i class="fas fa-circle text-muted"></i>
                                                        @endif
                                                    </h6>
                                                    <small class="text-muted">Status</small>
                                                </div>
                                            </div>

                                            @if($stream->scheduled_at)
                                                <div class="mb-2">
                                                    <small class="text-muted">
                                                        <i class="fas fa-calendar"></i> 
                                                        Agendado para: {{ $stream->scheduled_at->format('d/m/Y H:i') }}
                                                    </small>
                                                </div>
                                            @endif

                                            @if($stream->started_at && $stream->ended_at)
                                                <div class="mb-2">
                                                    <small class="text-muted">
                                                        <i class="fas fa-clock"></i> 
                                                        Duração: {{ $stream->formatted_duration }}
                                                    </small>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="card-footer">
                                            <div class="btn-group btn-group-sm w-100">
                                                <a href="{{ route('admin.media.livestreams.show', $stream) }}" class="btn btn-outline-primary">
                                                    <i class="fas fa-eye"></i> Visualizar
                                                </a>
                                                <a href="{{ route('admin.media.livestreams.edit', $stream) }}" class="btn btn-outline-info">
                                                    <i class="fas fa-edit"></i> Editar
                                                </a>
                                                
                                                @if($stream->status == 'scheduled')
                                                    <form action="{{ route('admin.media.livestreams.start', $stream) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="btn btn-outline-success" 
                                                                onclick="return confirm('Iniciar transmissão agora?')">
                                                            <i class="fas fa-play"></i> Iniciar
                                                        </button>
                                                    </form>
                                                @elseif($stream->status == 'live')
                                                    <form action="{{ route('admin.media.livestreams.end', $stream) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="btn btn-outline-danger" 
                                                                onclick="return confirm('Encerrar transmissão agora?')">
                                                            <i class="fas fa-stop"></i> Encerrar
                                                        </button>
                                                    </form>
                                                @endif

                                                <form action="{{ route('admin.media.livestreams.destroy', $stream) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-outline-danger" 
                                                            onclick="return confirm('Tem certeza?')">
                                                        <i class="fas fa-trash"></i> Excluir
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="col-12">
                                    <div class="alert alert-info">
                                        <i class="fas fa-info-circle"></i> Nenhuma transmissão encontrada.
                                        <a href="{{ route('admin.media.livestreams.create') }}" class="alert-link">Criar primeira transmissão</a>
                                    </div>
                                </div>
                            @endforelse
                        </div>

                        <!-- Paginação -->
                        <div class="d-flex justify-content-center">
                            {{ $streams->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
