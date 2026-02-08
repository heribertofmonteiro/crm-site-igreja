@extends('adminlte::page')

@section('title', 'Editar Categoria')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Editar Categoria</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.media.index') }}">Mídias</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.media.categories.index') }}">Categorias</a></li>
                    <li class="breadcrumb-item active">Editar</li>
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
                        <h3 class="card-title">Informações da Categoria</h3>
                    </div>
                    <form action="{{ route('admin.media.categories.update', $mediaCategory) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="form-group">
                                <label for="name">Nome <span class="text-danger">*</span></label>
                                <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" 
                                       value="{{ old('name', $mediaCategory->name) }}" required>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="description">Descrição</label>
                                <textarea id="description" name="description" class="form-control" rows="3">{{ old('description', $mediaCategory->description) }}</textarea>
                            </div>

                            <div class="form-group">
                                <label for="color">Cor</label>
                                <div class="input-group">
                                    <input type="color" id="color" name="color" class="form-control" 
                                           value="{{ old('color', $mediaCategory->color) }}">
                                    <input type="text" id="color_text" name="color_text" class="form-control" 
                                           value="{{ old('color', $mediaCategory->color) }}" readonly>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="icon">Ícone</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i id="icon_preview" class="{{ $mediaCategory->icon ?? 'fas fa-folder' }}"></i>
                                        </span>
                                    </div>
                                    <input type="text" id="icon" name="icon" class="form-control" 
                                           placeholder="fas fa-folder" value="{{ old('icon', $mediaCategory->icon) }}">
                                </div>
                                <small class="form-text text-muted">
                                    Use classes do FontAwesome. Ex: fas fa-music, fas fa-video, fas fa-image
                                </small>
                            </div>

                            <div class="form-group">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" id="is_active" name="is_active" 
                                           class="custom-control-input" value="1" 
                                           {{ old('is_active', $mediaCategory->is_active) ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="is_active">
                                        Categoria ativa
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <a href="{{ route('admin.media.categories.index') }}" class="btn btn-secondary">Cancelar</a>
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
                        <h3 class="card-title">Preview</h3>
                    </div>
                    <div class="card-body text-center">
                        <div id="preview" class="mb-3">
                            <i id="preview_icon" class="{{ $mediaCategory->icon ?? 'fas fa-folder' }} fa-3x" style="color: {{ $mediaCategory->color }}"></i>
                        </div>
                        <h5 id="preview_name">{{ $mediaCategory->name }}</h5>
                        <p id="preview_description" class="text-muted">{{ $mediaCategory->description ?? 'Descrição da categoria aparecerá aqui...' }}</p>
                        <div class="mt-3">
                            <span class="badge badge-pill badge-primary">{{ $mediaCategory->medias_count }} mídias</span>
                            <span id="status_badge" class="badge badge-pill {{ $mediaCategory->is_active ? 'badge-success' : 'badge-secondary' }}">
                                {{ $mediaCategory->is_active ? 'Ativa' : 'Inativa' }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Ícones Sugeridos</h3>
                    </div>
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-3 mb-2">
                                <button type="button" class="btn btn-outline-secondary btn-sm icon-suggestion" data-icon="fas fa-folder">
                                    <i class="fas fa-folder"></i>
                                </button>
                            </div>
                            <div class="col-3 mb-2">
                                <button type="button" class="btn btn-outline-secondary btn-sm icon-suggestion" data-icon="fas fa-music">
                                    <i class="fas fa-music"></i>
                                </button>
                            </div>
                            <div class="col-3 mb-2">
                                <button type="button" class="btn btn-outline-secondary btn-sm icon-suggestion" data-icon="fas fa-video">
                                    <i class="fas fa-video"></i>
                                </button>
                            </div>
                            <div class="col-3 mb-2">
                                <button type="button" class="btn btn-outline-secondary btn-sm icon-suggestion" data-icon="fas fa-image">
                                    <i class="fas fa-image"></i>
                                </button>
                            </div>
                            <div class="col-3 mb-2">
                                <button type="button" class="btn btn-outline-secondary btn-sm icon-suggestion" data-icon="fas fa-church">
                                    <i class="fas fa-church"></i>
                                </button>
                            </div>
                            <div class="col-3 mb-2">
                                <button type="button" class="btn btn-outline-secondary btn-sm icon-suggestion" data-icon="fas fa-pray">
                                    <i class="fas fa-pray"></i>
                                </button>
                            </div>
                            <div class="col-3 mb-2">
                                <button type="button" class="btn btn-outline-secondary btn-sm icon-suggestion" data-icon="fas fa-bible">
                                    <i class="fas fa-bible"></i>
                                </button>
                            </div>
                            <div class="col-3 mb-2">
                                <button type="button" class="btn btn-outline-secondary btn-sm icon-suggestion" data-icon="fas fa-cross">
                                    <i class="fas fa-cross"></i>
                                </button>
                            </div>
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
document.addEventListener('DOMContentLoaded', function() {
    const nameInput = document.getElementById('name');
    const descriptionInput = document.getElementById('description');
    const colorInput = document.getElementById('color');
    const colorTextInput = document.getElementById('color_text');
    const iconInput = document.getElementById('icon');
    const iconPreview = document.getElementById('icon_preview');
    const previewIcon = document.getElementById('preview_icon');
    const previewName = document.getElementById('preview_name');
    const previewDescription = document.getElementById('preview_description');
    const statusBadge = document.getElementById('status_badge');
    const isActiveCheckbox = document.getElementById('is_active');

    // Sync color inputs
    colorInput.addEventListener('input', function() {
        colorTextInput.value = this.value;
        updatePreview();
    });

    // Update preview on input changes
    nameInput.addEventListener('input', updatePreview);
    descriptionInput.addEventListener('input', updatePreview);
    iconInput.addEventListener('input', updatePreview);
    isActiveCheckbox.addEventListener('change', updatePreview);

    // Icon suggestions
    document.querySelectorAll('.icon-suggestion').forEach(button => {
        button.addEventListener('click', function() {
            const icon = this.dataset.icon;
            iconInput.value = icon;
            updatePreview();
        });
    });

    function updatePreview() {
        const name = nameInput.value || 'Nome da Categoria';
        const description = descriptionInput.value || 'Descrição da categoria aparecerá aqui...';
        const color = colorInput.value;
        const icon = iconInput.value || 'fas fa-folder';
        const isActive = isActiveCheckbox.checked;

        previewName.textContent = name;
        previewDescription.textContent = description;
        previewIcon.className = icon + ' fa-3x';
        previewIcon.style.color = color;
        iconPreview.className = icon;
        iconPreview.style.color = color;
        
        statusBadge.className = 'badge badge-pill ' + (isActive ? 'badge-success' : 'badge-secondary');
        statusBadge.textContent = isActive ? 'Ativa' : 'Inativa';
    }

    // Initialize preview
    updatePreview();
});
</script>
@endpush
