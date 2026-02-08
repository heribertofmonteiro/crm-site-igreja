@extends('adminlte::page')

@section('title', 'Nova Playlist')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Nova Playlist</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.media.index') }}">Mídias</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.media.playlists.index') }}">Playlists</a></li>
                    <li class="breadcrumb-item active">Nova</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Informações da Playlist</h3>
                    </div>
                    <form action="{{ route('admin.media.playlists.store') }}" method="POST">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label for="name">Nome <span class="text-danger">*</span></label>
                                <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" 
                                       value="{{ old('name') }}" required>
                                @error('name')
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
                                <label for="medias">Mídias <span class="text-danger">*</span></label>
                                <div class="media-selector">
                                    <div class="row" id="medias_container">
                                        @foreach($medias as $media)
                                            <div class="col-md-6 mb-2">
                                                <div class="custom-control custom-checkbox media-item">
                                                    <input type="checkbox" id="media_{{ $media->id }}" name="medias[]" 
                                                           value="{{ $media->id }}" class="custom-control-input media-checkbox">
                                                    <label class="custom-control-label" for="media_{{ $media->id }}">
                                                        <div class="d-flex align-items-center">
                                                            @if($media->file_type == 'image')
                                                                <img src="{{ asset('storage/' . $media->file_path) }}" 
                                                                     class="mr-2" style="width: 40px; height: 40px; object-fit: cover;">
                                                            @else
                                                                <div class="mr-2 bg-light d-flex align-items-center justify-content-center" 
                                                                     style="width: 40px; height: 40px;">
                                                                    <i class="fas fa-{{ $media->file_type == 'video' ? 'video' : ($media->file_type == 'audio' ? 'music' : 'file') }} text-muted"></i>
                                                                </div>
                                                            @endif
                                                            <div class="flex-grow-1">
                                                                <div class="font-weight-small">{{ Str::limit($media->title, 30) }}</div>
                                                                <small class="text-muted">
                                                                    {{ $media->formatted_size }}
                                                                    @if($media->duration)
                                                                        • {{ $media->formatted_duration }}
                                                                    @endif
                                                                </small>
                                                            </div>
                                                        </div>
                                                    </label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                @error('medias')
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
                                        Playlist ativa
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <a href="{{ route('admin.media.playlists.index') }}" class="btn btn-secondary">Cancelar</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Salvar
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Preview da Playlist</h3>
                    </div>
                    <div class="card-body">
                        <div id="playlist_preview">
                            <h5 id="preview_name">Nome da Playlist</h5>
                            <p id="preview_description" class="text-muted">Descrição aparecerá aqui...</p>
                            
                            <div class="mt-3">
                                <h6>Mídias Selecionadas:</h6>
                                <div id="selected_medias" class="list-group list-group-flush">
                                    <div class="text-muted text-center py-3">
                                        <i class="fas fa-music fa-2x mb-2"></i>
                                        <p class="mb-0">Nenhuma mídia selecionada</p>
                                    </div>
                                </div>
                            </div>

                            <div class="row text-center mt-3">
                                <div class="col-4">
                                    <h6 id="total_medias">0</h6>
                                    <small class="text-muted">Mídias</small>
                                </div>
                                <div class="col-4">
                                    <h6 id="total_duration">00:00</h6>
                                    <small class="text-muted">Duração</small>
                                </div>
                                <div class="col-4">
                                    <h6 id="total_size">0 MB</h6>
                                    <small class="text-muted">Tamanho</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Ajuda</h3>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled">
                            <li class="mb-2">
                                <i class="fas fa-info-circle text-info"></i>
                                <small>Selecione as mídias que farão parte da playlist</small>
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-sort text-warning"></i>
                                <small>A ordem de seleção será a ordem de execução</small>
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-play text-success"></i>
                                <small>Playlists ativas estarão disponíveis para reprodução</small>
                            </li>
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
    const nameInput = document.getElementById('name');
    const descriptionInput = document.getElementById('description');
    const mediaCheckboxes = document.querySelectorAll('.media-checkbox');
    const previewName = document.getElementById('preview_name');
    const previewDescription = document.getElementById('preview_description');
    const selectedMediasContainer = document.getElementById('selected_medias');
    const totalMediasEl = document.getElementById('total_medias');
    const totalDurationEl = document.getElementById('total_duration');
    const totalSizeEl = document.getElementById('total_size');

    const mediasData = @json($medias);

    // Update preview on input changes
    nameInput.addEventListener('input', updatePreview);
    descriptionInput.addEventListener('input', updatePreview);

    // Update preview when media selection changes
    mediaCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', updateSelectedMedias);
    });

    function updatePreview() {
        previewName.textContent = nameInput.value || 'Nome da Playlist';
        previewDescription.textContent = descriptionInput.value || 'Descrição aparecerá aqui...';
    }

    function updateSelectedMedias() {
        const selectedIds = Array.from(mediaCheckboxes)
            .filter(cb => cb.checked)
            .map(cb => parseInt(cb.value));

        const selectedMedias = mediasData.filter(media => selectedIds.includes(media.id));

        // Update selected medias list
        if (selectedMedias.length === 0) {
            selectedMediasContainer.innerHTML = `
                <div class="text-muted text-center py-3">
                    <i class="fas fa-music fa-2x mb-2"></i>
                    <p class="mb-0">Nenhuma mídia selecionada</p>
                </div>
            `;
        } else {
            selectedMediasContainer.innerHTML = selectedMedias.map((media, index) => `
                <div class="list-group-item d-flex align-items-center">
                    <span class="badge badge-primary mr-3">${index + 1}</span>
                    <div class="flex-grow-1">
                        <div class="font-weight-small">${media.title}</div>
                        <small class="text-muted">
                            ${media.file_type} • ${media.formatted_size}
                            ${media.duration ? ' • ' + media.formatted_duration : ''}
                        </small>
                    </div>
                    <span class="badge badge-info">${media.file_type}</span>
                </div>
            `).join('');
        }

        // Update statistics
        totalMediasEl.textContent = selectedMedias.length;
        
        const totalSeconds = selectedMedias.reduce((sum, media) => sum + (media.duration || 0), 0);
        const hours = Math.floor(totalSeconds / 3600);
        const minutes = Math.floor((totalSeconds % 3600) / 60);
        const seconds = totalSeconds % 60;
        
        if (hours > 0) {
            totalDurationEl.textContent = `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
        } else {
            totalDurationEl.textContent = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
        }

        const totalBytes = selectedMedias.reduce((sum, media) => sum + media.file_size, 0);
        const totalMB = (totalBytes / 1024 / 1024).toFixed(1);
        totalSizeEl.textContent = `${totalMB} MB`;
    }

    // Initialize preview
    updatePreview();
    updateSelectedMedias();
});
</script>
@endpush
