@extends('adminlte::page')

@section('title', $worshipSong->title)

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">{{ $worshipSong->title }}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Louvor</li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.worship.songs.index') }}">Músicas</a></li>
                    <li class="breadcrumb-item active">{{ Str::limit($worshipSong->title, 30) }}</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Informações da Música</h3>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <strong>Artista:</strong> {{ $worshipSong->artist ?? '--' }}
                            </div>
                            <div class="col-md-6">
                                <strong>Tom:</strong> 
                                <span class="badge badge-info">{{ $worshipSong->key ?? '--' }}</span>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <strong>BPM:</strong> {{ $worshipSong->bpm ?? '--' }}
                            </div>
                            <div class="col-md-6">
                                <strong>Duração:</strong> {{ $worshipSong->formatted_duration }}
                            </div>
                        </div>
                        @if($worshipSong->ccli_number)
                            <div class="row mb-3">
                                <div class="col-12">
                                    <strong>CCLI:</strong> {{ $worshipSong->ccli_number }}
                                </div>
                            </div>
                        @endif
                        @if($worshipSong->youtube_link)
                            <div class="row mb-3">
                                <div class="col-12">
                                    <strong>YouTube:</strong> 
                                    <a href="{{ $worshipSong->youtube_link }}" target="_blank" class="btn btn-sm btn-danger">
                                        <i class="fab fa-youtube"></i> Assistir
                                    </a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                @if($worshipSong->lyrics)
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Letra</h3>
                        </div>
                        <div class="card-body">
                            <pre class="lyrics-text">{{ $worshipSong->lyrics }}</pre>
                        </div>
                    </div>
                @endif

                @if($worshipSong->chords)
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Cifras</h3>
                            <div class="card-tools">
                                <a href="{{ route('admin.worship.songs.chord-sheet', $worshipSong) }}" class="btn btn-success btn-sm">
                                    <i class="fas fa-print"></i> Imprimir Cifra
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <pre class="chords-text">{{ $worshipSong->chords }}</pre>
                        </div>
                    </div>
                @endif

                @if($worshipSong->youtube_embed_url)
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Vídeo de Referência</h3>
                        </div>
                        <div class="card-body">
                            <div class="embed-responsive embed-responsive-16by9">
                                <iframe class="embed-responsive-item" 
                                        src="{{ $worshipSong->youtube_embed_url }}" 
                                        allowfullscreen></iframe>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Estatísticas</h3>
                    </div>
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-6">
                                <h4>{{ $worshipSong->usage_count }}</h4>
                                <small class="text-muted">Usos</small>
                            </div>
                            <div class="col-6">
                                <h4>{{ $worshipSong->last_used ?? '--' }}</h4>
                                <small class="text-muted">Último uso</small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Histórico de Uso</h3>
                    </div>
                    <div class="card-body">
                        @if($worshipSong->setlists->count() > 0)
                            @foreach($worshipSong->setlists as $setlist)
                                <div class="mb-2">
                                    <small class="text-muted">
                                        {{ $setlist->date->format('d/m/Y') }}
                                        @if($setlist->churchEvent)
                                            - {{ $setlist->churchEvent->title }}
                                        @endif
                                    </small>
                                    @if($setlist->pivot->key_override)
                                        <span class="badge badge-warning ml-2">Tom: {{ $setlist->pivot->key_override }}</span>
                                    @endif
                                </div>
                            @endforeach
                        @else
                            <p class="text-muted">Esta música ainda não foi utilizada em setlists.</p>
                        @endif
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Ações</h3>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <a href="{{ route('admin.worship.songs.chord-sheet', $worshipSong) }}" class="btn btn-success">
                                <i class="fas fa-print"></i> Imprimir Cifra
                            </a>
                            <a href="{{ route('admin.worship.songs.edit', $worshipSong) }}" class="btn btn-warning">
                                <i class="fas fa-edit"></i> Editar
                            </a>
                            <form action="{{ route('admin.worship.songs.destroy', $worshipSong) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" 
                                        onclick="return confirm('Tem certeza que deseja excluir esta música?')">
                                    <i class="fas fa-trash"></i> Excluir
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Transposição</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.worship.songs.transpose', $worshipSong) }}" method="GET">
                            <div class="form-group">
                                <label for="target_key">Transpor para:</label>
                                <select name="target_key" id="target_key" class="form-control">
                                    @foreach(['C', 'C#', 'D', 'D#', 'E', 'F', 'F#', 'G', 'G#', 'A', 'A#', 'B'] as $key)
                                        <option value="{{ $key }}">{{ $key }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary btn-sm">
                                <i class="fas fa-exchange-alt"></i> Transpor
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@push('styles')
<style>
.lyrics-text, .chords-text {
    background: #f8f9fa;
    padding: 15px;
    border-radius: 5px;
    white-space: pre-wrap;
    font-family: 'Courier New', monospace;
    line-height: 1.6;
}
</style>
@endpush
