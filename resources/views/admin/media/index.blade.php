@extends('adminlte::page')

@section('title', 'Mídias')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Mídias</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Mídias</li>
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
                        <h3 class="card-title">Lista de Mídias</h3>
                        <div class="card-tools">
                            <a href="{{ route('admin.media.create') }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-plus"></i> Nova Mídia
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Filtros -->
                        <form method="GET" class="mb-3">
                            <div class="row">
                                <div class="col-md-3">
                                    <input type="text" name="search" class="form-control" 
                                           placeholder="Buscar..." value="{{ request('search') }}">
                                </div>
                                <div class="col-md-2">
                                    <select name="type" class="form-control">
                                        <option value="">Todos os tipos</option>
                                        <option value="video" {{ request('type') == 'video' ? 'selected' : '' }}>Vídeo</option>
                                        <option value="audio" {{ request('type') == 'audio' ? 'selected' : '' }}>Áudio</option>
                                        <option value="image" {{ request('type') == 'image' ? 'selected' : '' }}>Imagem</option>
                                        <option value="document" {{ request('type') == 'document' ? 'selected' : '' }}>Documento</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <select name="category" class="form-control">
                                        <option value="">Todas categorias</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" 
                                                    {{ request('category') == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-default">
                                        <i class="fas fa-search"></i> Filtrar
                                    </button>
                                </div>
                            </div>
                        </form>

                        <!-- Grid de Mídias -->
                        <div class="row">
                            @forelse($medias as $media)
                                <div class="col-md-3 mb-4">
                                    <div class="card">
                                        @if($media->file_type == 'image')
                                            <img src="{{ asset('storage/' . $media->file_path) }}" 
                                                 class="card-img-top" alt="{{ $media->title }}" style="height: 200px; object-fit: cover;">
                                        @elseif($media->file_type == 'video' && $media->thumbnail_path)
                                            <img src="{{ asset('storage/' . $media->thumbnail_path) }}" 
                                                 class="card-img-top" alt="{{ $media->title }}" style="height: 200px; object-fit: cover;">
                                        @else
                                            <div class="card-img-top d-flex align-items-center justify-content-center bg-light" 
                                                 style="height: 200px;">
                                                <i class="fas fa-{{ $media->file_type == 'video' ? 'video' : ($media->file_type == 'audio' ? 'music' : 'file') }} fa-3x text-muted"></i>
                                            </div>
                                        @endif
                                        
                                        <div class="card-body">
                                            <h6 class="card-title">{{ Str::limit($media->title, 30) }}</h6>
                                            <p class="card-text text-muted small">
                                                {{ $media->formatted_size }}
                                                @if($media->duration)
                                                    • {{ $media->formatted_duration }}
                                                @endif
                                            </p>
                                            @if($media->category)
                                                <span class="badge" style="background-color: {{ $media->category->color }}">
                                                    {{ $media->category->name }}
                                                </span>
                                            @endif
                                            @if($media->is_published)
                                                <span class="badge badge-success">Publicado</span>
                                            @else
                                                <span class="badge badge-secondary">Rascunho</span>
                                            @endif
                                        </div>
                                        <div class="card-footer">
                                            <div class="btn-group btn-group-sm">
                                                <a href="{{ route('admin.media.show', $media) }}" class="btn btn-outline-primary">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.media.edit', $media) }}" class="btn btn-outline-info">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('admin.media.destroy', $media) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-outline-danger" 
                                                            onclick="return confirm('Tem certeza?')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="col-12">
                                    <div class="alert alert-info">
                                        <i class="fas fa-info-circle"></i> Nenhuma mídia encontrada.
                                    </div>
                                </div>
                            @endforelse
                        </div>

                        <!-- Paginação -->
                        <div class="d-flex justify-content-center">
                            {{ $medias->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
