@extends('adminlte::page')

@section('title', 'Músicas de Louvor')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Músicas de Louvor</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Louvor</li>
                    <li class="breadcrumb-item active">Músicas</li>
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
                        <h3 class="card-title">Lista de Músicas</h3>
                        <div class="card-tools">
                            <a href="{{ route('admin.worship.songs.create') }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-plus"></i> Nova Música
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Filtros -->
                        <form method="GET" class="mb-3">
                            <div class="row">
                                <div class="col-md-3">
                                    <input type="text" name="search" class="form-control" 
                                           placeholder="Buscar música ou artista..." value="{{ request('search') }}">
                                </div>
                                <div class="col-md-2">
                                    <select name="key" class="form-control">
                                        <option value="">Todos os tons</option>
                                        @foreach(['C', 'C#', 'D', 'D#', 'E', 'F', 'F#', 'G', 'G#', 'A', 'A#', 'B'] as $key)
                                            <option value="{{ $key }}" {{ request('key') == $key ? 'selected' : '' }}>{{ $key }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <input type="text" name="artist" class="form-control" 
                                           placeholder="Artista..." value="{{ request('artist') }}">
                                </div>
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-default">
                                        <i class="fas fa-search"></i> Filtrar
                                    </button>
                                </div>
                            </div>
                        </form>

                        <!-- Lista de Músicas -->
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Título</th>
                                        <th>Artista</th>
                                        <th>Tom</th>
                                        <th>BPM</th>
                                        <th>Duração</th>
                                        <th>Uso</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($songs as $song)
                                        <tr>
                                            <td>
                                                <strong>{{ $song->title }}</strong>
                                                @if($song->youtube_link)
                                                    <a href="{{ $song->youtube_link }}" target="_blank" class="text-danger ml-2">
                                                        <i class="fab fa-youtube"></i>
                                                    </a>
                                                @endif
                                            </td>
                                            <td>{{ $song->artist ?? '--' }}</td>
                                            <td>
                                                <span class="badge badge-info">{{ $song->key ?? '--' }}</span>
                                            </td>
                                            <td>{{ $song->bpm ?? '--' }}</td>
                                            <td>{{ $song->formatted_duration }}</td>
                                            <td>
                                                <small class="text-muted">
                                                    {{ $song->usage_count }}x
                                                    @if($song->last_used)
                                                        <br>Último: {{ $song->last_used }}
                                                    @endif
                                                </small>
                                            </td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <a href="{{ route('admin.worship.songs.show', $song) }}" class="btn btn-outline-primary">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('admin.worship.songs.chord-sheet', $song) }}" class="btn btn-outline-success" title="Cifra">
                                                        <i class="fas fa-music"></i>
                                                    </a>
                                                    <a href="{{ route('admin.worship.songs.edit', $song) }}" class="btn btn-outline-info">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('admin.worship.songs.destroy', $song) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-outline-danger" 
                                                                onclick="return confirm('Tem certeza?')">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center">
                                                <div class="alert alert-info">
                                                    <i class="fas fa-info-circle"></i> Nenhuma música encontrada.
                                                    <a href="{{ route('admin.worship.songs.create') }}" class="alert-link">Cadastrar primeira música</a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Paginação -->
                        <div class="d-flex justify-content-center">
                            {{ $songs->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
