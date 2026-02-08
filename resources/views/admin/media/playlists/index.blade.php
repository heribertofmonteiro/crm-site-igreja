@extends('adminlte::page')

@section('title', 'Playlists de Mídia')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Playlists de Mídia</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.media.index') }}">Mídias</a></li>
                    <li class="breadcrumb-item active">Playlists</li>
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
                        <h3 class="card-title">Lista de Playlists</h3>
                        <div class="card-tools">
                            <a href="{{ route('admin.media.playlists.create') }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-plus"></i> Nova Playlist
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @forelse($playlists as $playlist)
                                <div class="col-md-6 mb-4">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5 class="card-title mb-0">
                                                <i class="fas fa-list"></i> {{ $playlist->name }}
                                            </h5>
                                            @if($playlist->is_active)
                                                <span class="badge badge-success">Ativa</span>
                                            @else
                                                <span class="badge badge-secondary">Inativa</span>
                                            @endif
                                        </div>
                                        <div class="card-body">
                                            @if($playlist->description)
                                                <p class="card-text">{{ Str::limit($playlist->description, 80) }}</p>
                                            @endif
                                            
                                            <div class="row text-center mb-3">
                                                <div class="col-4">
                                                    <h6>{{ $playlist->medias_count }}</h6>
                                                    <small class="text-muted">Mídias</small>
                                                </div>
                                                <div class="col-4">
                                                    <h6>{{ $playlist->formatted_total_duration }}</h6>
                                                    <small class="text-muted">Duração</small>
                                                </div>
                                                <div class="col-4">
                                                    <h6>{{ $playlist->creator->name }}</h6>
                                                    <small class="text-muted">Criador</small>
                                                </div>
                                            </div>

                                            @if($playlist->medias->count() > 0)
                                                <div class="mb-3">
                                                    <small class="text-muted">Principais mídias:</small>
                                                    <div class="d-flex flex-wrap">
                                                        @foreach($playlist->medias->take(3) as $media)
                                                            <span class="badge badge-info mr-1 mb-1">
                                                                {{ Str::limit($media->title, 20) }}
                                                            </span>
                                                        @endforeach
                                                        @if($playlist->medias->count() > 3)
                                                            <span class="badge badge-secondary">+{{ $playlist->medias->count() - 3 }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="card-footer">
                                            <div class="btn-group btn-group-sm w-100">
                                                <a href="{{ route('admin.media.playlists.show', $playlist) }}" class="btn btn-outline-primary">
                                                    <i class="fas fa-eye"></i> Visualizar
                                                </a>
                                                <a href="{{ route('admin.media.playlists.edit', $playlist) }}" class="btn btn-outline-info">
                                                    <i class="fas fa-edit"></i> Editar
                                                </a>
                                                <form action="{{ route('admin.media.playlists.destroy', $playlist) }}" method="POST" class="d-inline">
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
                                        <i class="fas fa-info-circle"></i> Nenhuma playlist encontrada.
                                        <a href="{{ route('admin.media.playlists.create') }}" class="alert-link">Criar primeira playlist</a>
                                    </div>
                                </div>
                            @endforelse
                        </div>

                        <!-- Paginação -->
                        <div class="d-flex justify-content-center">
                            {{ $playlists->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
