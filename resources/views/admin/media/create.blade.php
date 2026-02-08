@extends('adminlte::page')

@section('title', 'Nova Mídia')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Nova Mídia</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.media.index') }}">Mídias</a></li>
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
                        <h3 class="card-title">Informações da Mídia</h3>
                    </div>
                    <form action="{{ route('admin.media.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
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

                            <div class="form-group">
                                <label for="description">Descrição</label>
                                <textarea id="description" name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
                            </div>

                            <div class="form-group">
                                <label for="file">Arquivo <span class="text-danger">*</span></label>
                                <div class="custom-file">
                                    <input type="file" id="file" name="file" class="custom-file-input @error('file') is-invalid @enderror" required>
                                    <label class="custom-file-label" for="file">Escolher arquivo...</label>
                                </div>
                                <small class="form-text text-muted">Tamanho máximo: 100MB</small>
                                @error('file')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="media_category_id">Categoria</label>
                                <select id="media_category_id" name="media_category_id" class="form-control">
                                    <option value="">Selecione uma categoria</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('media_category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" id="is_published" name="is_published" 
                                           class="custom-control-input" value="1" {{ old('is_published') ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="is_published">
                                        Publicar imediatamente
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <a href="{{ route('admin.media.index') }}" class="btn btn-secondary">Cancelar</a>
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
                        <h3 class="card-title">Preview</h3>
                    </div>
                    <div class="card-body">
                        <div id="preview-container" class="text-center">
                            <div class="bg-light p-5 rounded">
                                <i class="fas fa-cloud-upload-alt fa-3x text-muted mb-3"></i>
                                <p class="text-muted">Preview do arquivo aparecerá aqui</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Tipos Suportados</h3>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled">
                            <li><i class="fas fa-video text-primary"></i> Vídeos: MP4, AVI, MOV</li>
                            <li><i class="fas fa-music text-success"></i> Áudios: MP3, WAV, AAC</li>
                            <li><i class="fas fa-image text-info"></i> Imagens: JPG, PNG, GIF</li>
                            <li><i class="fas fa-file-alt text-warning"></i> Documentos: PDF, DOC, TXT</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const fileInput = document.getElementById('file');
    const previewContainer = document.getElementById('preview-container');
    const fileLabel = document.querySelector('.custom-file-label');

    fileInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            fileLabel.textContent = file.name;
            
            const reader = new FileReader();
            reader.onload = function(e) {
                const fileType = file.type;
                
                if (fileType.startsWith('image/')) {
                    previewContainer.innerHTML = `
                        <img src="${e.target.result}" class="img-fluid rounded" alt="Preview">
                    `;
                } else if (fileType.startsWith('video/')) {
                    previewContainer.innerHTML = `
                        <video controls class="img-fluid rounded">
                            <source src="${e.target.result}" type="${fileType}">
                            Seu navegador não suporta vídeo.
                        </video>
                    `;
                } else if (fileType.startsWith('audio/')) {
                    previewContainer.innerHTML = `
                        <div class="bg-light p-4 rounded">
                            <i class="fas fa-music fa-3x text-primary mb-3"></i>
                            <audio controls class="w-100">
                                <source src="${e.target.result}" type="${fileType}">
                                Seu navegador não suporta áudio.
                            </audio>
                        </div>
                    `;
                } else {
                    previewContainer.innerHTML = `
                        <div class="bg-light p-5 rounded">
                            <i class="fas fa-file fa-3x text-muted mb-3"></i>
                            <p class="mb-0">${file.name}</p>
                            <small class="text-muted">${(file.size / 1024 / 1024).toFixed(2)} MB</small>
                        </div>
                    `;
                }
            };
            reader.readAsDataURL(file);
        }
    });
});
</script>
@endpush
