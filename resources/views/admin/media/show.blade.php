@extends('adminlte::page')

@section('title', $media->title)

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">{{ $media->title }}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.media.index') }}">Mídias</a></li>
                    <li class="breadcrumb-item active">{{ Str::limit($media->title, 30) }}</li>
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
                        <h3 class="card-title">Visualização</h3>
                    </div>
                    <div class="card-body text-center">
                        @if($media->file_type == 'image')
                            <img src="{{ asset('storage/' . $media->file_path) }}" 
                                 class="img-fluid" alt="{{ $media->title }}">
                        @elseif($media->file_type == 'video')
                            <video controls class="img-fluid">
                                <source src="{{ asset('storage/' . $media->file_path) }}" type="{{ $media->mime_type }}">
                                Seu navegador não suporta vídeo.
                            </video>
                        @elseif($media->file_type == 'audio')
                            <div class="bg-light p-5 rounded">
                                <i class="fas fa-music fa-4x text-primary mb-3"></i>
                                <audio controls class="w-100">
                                    <source src="{{ asset('storage/' . $media->file_path) }}" type="{{ $media->mime_type }}">
                                    Seu navegador não suporta áudio.
                                </audio>
                            </div>
                        @else
                            <div class="bg-light p-5 rounded">
                                <i class="fas fa-file fa-4x text-muted mb-3"></i>
                                <h4>{{ $media->title }}</h4>
                                <p class="text-muted">{{ $media->formatted_size }}</p>
                                <a href="{{ asset('storage/' . $media->file_path) }}" 
                                   class="btn btn-primary" download>
                                    <i class="fas fa-download"></i> Baixar Arquivo
                                </a>
                            </div>
                        @endif
                    </div>
                </div>

                @if($media->description)
                    <div class="card mt-3">
                        <div class="card-header">
                            <h3 class="card-title">Descrição</h3>
                        </div>
                        <div class="card-body">
                            <p>{{ $media->description }}</p>
                        </div>
                    </div>
                @endif

                @if($media->playlists->count() > 0)
                    <div class="card mt-3">
                        <div class="card-header">
                            <h3 class="card-title">Playlists</h3>
                        </div>
                        <div class="card-body">
                            @foreach($media->playlists as $playlist)
                                <span class="badge badge-info mr-2">
                                    <i class="fas fa-list"></i> {{ $playlist->name }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Informações</h3>
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
                                <td><strong>Status:</strong></td>
                                <td>
                                    @if($media->is_published)
                                        <span class="badge badge-success">Publicado</span>
                                    @else
                                        <span class="badge badge-secondary">Rascunho</span>
                                    @endif
                                </td>
                            </tr>
                            @if($media->category)
                                <tr>
                                    <td><strong>Categoria:</strong></td>
                                    <td>
                                        <span class="badge" style="background-color: {{ $media->category->color }}">
                                            {{ $media->category->name }}
                                        </span>
                                    </td>
                                </tr>
                            @endif
                            <tr>
                                <td><strong>Enviado por:</strong></td>
                                <td>{{ $media->uploader->name }}</td>
                            </tr>
                            <tr>
                                <td><strong>Data:</strong></td>
                                <td>{{ $media->created_at->format('d/m/Y H:i') }}</td>
                            </tr>
                            @if($media->published_at)
                                <tr>
                                    <td><strong>Publicado em:</strong></td>
                                    <td>{{ $media->published_at->format('d/m/Y H:i') }}</td>
                                </tr>
                            @endif
                        </table>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('admin.media.edit', $media) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Editar
                        </a>
                        <form action="{{ route('admin.media.destroy', $media) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" 
                                    onclick="return confirm('Tem certeza que deseja excluir esta mídia?')">
                                <i class="fas fa-trash"></i> Excluir
                            </button>
                        </form>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Ações Rápidas</h3>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <a href="{{ asset('storage/' . $media->file_path) }}" 
                               class="btn btn-outline-primary" download>
                                <i class="fas fa-download"></i> Baixar
                            </a>
                            <button class="btn btn-outline-info" onclick="copyLink()">
                                <i class="fas fa-link"></i> Copiar Link
                            </button>
                            @if($media->file_type == 'video' || $media->file_type == 'audio')
                                <button class="btn btn-outline-success" onclick="embedMedia()">
                                    <i class="fas fa-code"></i> Embed
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
function copyLink() {
    const link = '{{ asset('storage/' . $media->file_path) }}';
    navigator.clipboard.writeText(link).then(function() {
        alert('Link copiado para a área de transferência!');
    });
}

function embedMedia() {
    const embedCode = `{{ $media->file_type == 'video' 
        ? '<video controls><source src="' . asset('storage/' . $media->file_path) . '" type="' . $media->mime_type . '"></video>'
        : '<audio controls><source src="' . asset('storage/' . $media->file_path) . '" type="' . $media->mime_type . '"></audio>' }}`;
    
    navigator.clipboard.writeText(embedCode).then(function() {
        alert('Código embed copiado para a área de transferência!');
    });
}
</script>
@endpush
