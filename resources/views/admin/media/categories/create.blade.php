@extends('adminlte::page')

@section('title', 'Nova Categoria')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Nova Categoria</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.media.index') }}">Mídias</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.media.categories.index') }}">Categorias</a></li>
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
                        <h3 class="card-title">Informações da Categoria</h3>
                    </div>
                    <form action="{{ route('admin.media.categories.store') }}" method="POST">
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
                                <label for="color">Cor</label>
                                <div class="input-group">
                                    <input type="color" id="color" name="color" class="form-control" 
                                           value="{{ old('color', '#6c757d') }}">
                                    <input type="text" id="color_text" name="color_text" class="form-control" 
                                           value="{{ old('color', '#6c757d') }}" readonly>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="icon">Ícone</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i id="icon_preview" class="fas fa-folder"></i>
                                        </span>
                                    </div>
                                    <input type="text" id="icon" name="icon" class="form-control" 
                                           placeholder="fas fa-folder" value="{{ old('icon') }}">
                                </div>
                                <small class="form-text text-muted">
                                    Use classes do FontAwesome. Ex: fas fa-music, fas fa-video, fas fa-image
                                </small>
                            </div>

                            <div class="form-group">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" id="is_active" name="is_active" 
                                           class="custom-control-input" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
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
                            <i id="preview_icon" class="fas fa-folder fa-3x" style="color: #6c757d"></i>
                        </div>
                        <h5 id="preview_name">Nome da Categoria</h5>
                        <p id="preview_description" class="text-muted">Descrição da categoria aparecerá aqui...</p>
                        <div class="mt-3">
                            <span class="badge badge-pill badge-primary">0 mídias</span>
                            <span class="badge badge-pill badge-success">Ativa</span>
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

    // Sync color inputs
    colorInput.addEventListener('input', function() {
        colorTextInput.value = this.value;
        updatePreview();
    });

    // Update preview on input changes
    nameInput.addEventListener('input', updatePreview);
    descriptionInput.addEventListener('input', updatePreview);
    iconInput.addEventListener('input', updatePreview);

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

        previewName.textContent = name;
        previewDescription.textContent = description;
        previewIcon.className = icon + ' fa-3x';
        previewIcon.style.color = color;
        iconPreview.className = icon;
        iconPreview.style.color = color;
    }

    // Initialize preview
    updatePreview();
});
</script>
@endpush
