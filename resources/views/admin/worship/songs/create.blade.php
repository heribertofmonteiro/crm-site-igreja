@extends('adminlte::page')

@section('title', 'Nova Música')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Nova Música</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Louvor</li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.worship.songs.index') }}">Músicas</a></li>
                    <li class="breadcrumb-item active">Nova</li>
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
                    <form action="{{ route('admin.worship.songs.store') }}" method="POST">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="title">Título <span class="text-danger">*</span></label>
                                        <input type="text" id="title" name="title" class="form-control @error('title') is-invalid @enderror" 
                                               value="{{ old('title') }}" required>
                                        @error('title')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="artist">Artista</label>
                                        <input type="text" id="artist" name="artist" class="form-control @error('artist') is-invalid @enderror" 
                                               value="{{ old('artist') }}">
                                        @error('artist')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="key">Tom</label>
                                        <select id="key" name="key" class="form-control">
                                            <option value="">Selecione</option>
                                            @foreach(['C', 'C#', 'D', 'D#', 'E', 'F', 'F#', 'G', 'G#', 'A', 'A#', 'B'] as $key)
                                                <option value="{{ $key }}" {{ old('key') == $key ? 'selected' : '' }}>{{ $key }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="bpm">BPM</label>
                                        <input type="number" id="bpm" name="bpm" class="form-control @error('bpm') is-invalid @enderror" 
                                               value="{{ old('bpm') }}" min="40" max="200">
                                        @error('bpm')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="duration">Duração (segundos)</label>
                                        <input type="number" id="duration" name="duration" class="form-control @error('duration') is-invalid @enderror" 
                                               value="{{ old('duration') }}" min="1">
                                        @error('duration')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="ccli_number">CCLI</label>
                                        <input type="text" id="ccli_number" name="ccli_number" class="form-control @error('ccli_number') is-invalid @enderror" 
                                               value="{{ old('ccli_number') }}">
                                        @error('ccli_number')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="youtube_link">Link do YouTube</label>
                                <input type="url" id="youtube_link" name="youtube_link" class="form-control @error('youtube_link') is-invalid @enderror" 
                                       value="{{ old('youtube_link') }}" placeholder="https://www.youtube.com/watch?v=...">
                                @error('youtube_link')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="lyrics">Letra</label>
                                <textarea id="lyrics" name="lyrics" class="form-control @error('lyrics') is-invalid @enderror" 
                                          rows="8">{{ old('lyrics') }}</textarea>
                                @error('lyrics')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="chords">Cifras</label>
                                <textarea id="chords" name="chords" class="form-control @error('chords') is-invalid @enderror" 
                                          rows="8">{{ old('chords') }}</textarea>
                                <small class="form-text text-muted">
                                    Insira as cifras separadas por linha ou no formato de cifra tradicional
                                </small>
                                @error('chords')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" id="is_active" name="is_active" 
                                           class="custom-control-input" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="is_active">
                                        Música ativa
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <a href="{{ route('admin.worship.songs.index') }}" class="btn btn-secondary">Cancelar</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Salvar
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Dicas de Preenchimento</h3>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <h6><i class="fas fa-music text-primary"></i> Tom Musical</h6>
                            <small class="text-muted">Tom original da música para referência</small>
                        </div>
                        <div class="mb-3">
                            <h6><i class="fas fa-tachometer-alt text-success"></i> BPM</h6>
                            <small class="text-muted">Batidas por minuto para controle de tempo</small>
                        </div>
                        <div class="mb-3">
                            <h6><i class="fab fa-youtube text-danger"></i> YouTube</h6>
                            <small class="text-muted">Link para versão de referência</small>
                        </div>
                        <div class="mb-3">
                            <h6><i class="fas fa-file-alt text-info"></i> CCLI</h6>
                            <small class="text-muted">Número de licença CCLI para direitos autorais</small>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Formato de Cifras</h3>
                    </div>
                    <div class="card-body">
                        <small class="text-muted">
                            <strong>Exemplo de formato:</strong><br>
                            <pre class="bg-light p-2 rounded">
[Intro]  G   C   G   D
[Verso 1]
G           C
Amazing grace
G           D
How sweet the sound</pre>
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
