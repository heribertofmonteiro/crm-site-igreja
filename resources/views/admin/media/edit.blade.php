@extends('adminlte::page')

@section('title', 'Editar Mídia')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Editar Mídia</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.media.index') }}">Mídias</a></li>
                    <li class="breadcrumb-item active">Editar</li>
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
                        <h3 class="card-title">Informações da Mídia</h3>
                    </div>
                    <form action="{{ route('admin.media.update', $media) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="form-group">
                                <label for="title">Título <span class="text-danger">*</span></label>
                                <input type="text" id="title" name="title" class="form-control @error('title') is-invalid @enderror" 
                                       value="{{ old('title', $media->title) }}" required>
                                @error('title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="description">Descrição</label>
                                <textarea id="description" name="description" class="form-control" rows="3">{{ old('description', $media->description) }}</textarea>
                            </div>

                            <div class="form-group">
                                <label for="media_category_id">Categoria</label>
                                <select id="media_category_id" name="media_category_id" class="form-control">
                                    <option value="">Selecione uma categoria</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" 
                                                {{ old('media_category_id', $media->media_category_id) == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" id="is_published" name="is_published" 
                                           class="custom-control-input" value="1" 
                                           {{ old('is_published', $media->is_published) ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="is_published">
                                        Publicado
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <a href="{{ route('admin.media.show', $media) }}" class="btn btn-secondary">Cancelar</a>
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
                        <h3 class="card-title">Informações do Arquivo</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-sm">
                            <tr>
                                <td><strong>Tipo:</strong></td>
                                <td>
                                    <span class="badge badge-{{ $media->file_type == 'video' ? 'primary' : ($media->file_type == 'audio' ? 'success' : ($media->file_type == 'image' ? 'info' : 'secondary')) }}">
                                        {{ ucfirst($media->file_type) }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Tamanho:</strong></td>
                                <td>{{ $media->formatted_size }}</td>
                            </tr>
                            @if($media->duration)
                                <tr>
                                    <td><strong>Duração:</strong></td>
                                    <td>{{ $media->formatted_duration }}</td>
                                </tr>
                            @endif
                            <tr>
                                <td><strong>MIME Type:</strong></td>
                                <td><small>{{ $media->mime_type }}</small></td>
                            </tr>
                            <tr>
                                <td><strong>Enviado em:</strong></td>
                                <td>{{ $media->created_at->format('d/m/Y H:i') }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Preview</h3>
                    </div>
                    <div class="card-body text-center">
                        @if($media->file_type == 'image')
                            <img src="{{ asset('storage/' . $media->file_path) }}" 
                                 class="img-fluid rounded" alt="{{ $media->title }}">
                        @elseif($media->file_type == 'video' && $media->thumbnail_path)
                            <img src="{{ asset('storage/' . $media->thumbnail_path) }}" 
                                 class="img-fluid rounded" alt="{{ $media->title }}">
                        @else
                            <div class="bg-light p-5 rounded">
                                <i class="fas fa-{{ $media->file_type == 'video' ? 'video' : ($media->file_type == 'audio' ? 'music' : 'file') }} fa-3x text-muted"></i>
                                <p class="mt-3 mb-0">{{ $media->title }}</p>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Estatísticas</h3>
                    </div>
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-6">
                                <h4>{{ $media->playlists->count() }}</h4>
                                <small class="text-muted">Playlists</small>
                            </div>
                            <div class="col-6">
                                <h4>
                                    @if($media->is_published)
                                        <i class="fas fa-eye text-success"></i>
                                    @else
                                        <i class="fas fa-eye-slash text-muted"></i>
                                    @endif
                                </h4>
                                <small class="text-muted">Status</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
