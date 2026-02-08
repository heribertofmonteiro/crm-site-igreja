@extends('adminlte::page')

@section('title', 'Editar Documento')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Editar Documento</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.administration.documents.index') }}">Documentos</a></li>
                    <li class="breadcrumb-item active">Editar</li>
                </ol>
            </div>
        </div>
    </div>
@stop

@section('content')
<div class="card card-warning">
    <div class="card-header">
        <h3 class="card-title">Dados do Documento</h3>
    </div>
    <form action="{{ route('admin.administration.documents.update', $document) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 form-group">
                    <label for="title">Título *</label>
                    <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $document->title) }}" required>
                    @error('title') <span class="invalid-feedback">{{ $message }}</span> @enderror
                </div>
                <div class="col-md-3 form-group">
                    <label for="document_type">Tipo *</label>
                    <select name="document_type" id="document_type" class="form-control @error('document_type') is-invalid @enderror" required>
                        <option value="">Selecione...</option>
                        <option value="statute" {{ old('document_type', $document->document_type) == 'statute' ? 'selected' : '' }}>Estatuto</option>
                        <option value="regulation" {{ old('document_type', $document->document_type) == 'regulation' ? 'selected' : '' }}>Regulamento</option>
                        <option value="policy" {{ old('document_type', $document->document_type) == 'policy' ? 'selected' : '' }}>Política</option>
                        <option value="certificate" {{ old('document_type', $document->document_type) == 'certificate' ? 'selected' : '' }}>Certificado</option>
                        <option value="license" {{ old('document_type', $document->document_type) == 'license' ? 'selected' : '' }}>Licença</option>
                        <option value="other" {{ old('document_type', $document->document_type) == 'other' ? 'selected' : '' }}>Outro</option>
                    </select>
                    @error('document_type') <span class="invalid-feedback">{{ $message }}</span> @enderror
                </div>
                <div class="col-md-3 form-group">
                    <label for="version">Versão</label>
                    <input type="text" name="version" id="version" class="form-control" value="{{ old('version', $document->version) }}">
                </div>
            </div>

            <div class="form-group">
                <label for="description">Descrição</label>
                <textarea name="description" id="description" class="form-control" rows="3">{{ old('description', $document->description) }}</textarea>
            </div>

            <div class="row">
                <div class="col-md-4 form-group">
                    <label for="effective_date">Data de Vigência</label>
                    <input type="date" name="effective_date" id="effective_date" class="form-control" value="{{ old('effective_date', optional($document->effective_date)->format('Y-m-d')) }}">
                </div>
                <div class="col-md-4 form-group">
                    <label for="expiration_date">Data de Expiração</label>
                    <input type="date" name="expiration_date" id="expiration_date" class="form-control" value="{{ old('expiration_date', optional($document->expiration_date)->format('Y-m-d')) }}">
                </div>
                <div class="col-md-4 form-group">
                    <label for="status">Status</label>
                    <select name="status" id="status" class="form-control">
                        <option value="draft" {{ old('status', $document->status) == 'draft' ? 'selected' : '' }}>Rascunho</option>
                        <option value="active" {{ old('status', $document->status) == 'active' ? 'selected' : '' }}>Ativo</option>
                        <option value="archived" {{ old('status', $document->status) == 'archived' ? 'selected' : '' }}>Arquivado</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label for="file_path">Arquivo</label>
                @if($document->file_path)
                    <div class="mb-2">
                        <a href="{{ $document->file_url }}" target="_blank" class="text-info">
                            <i class="{{ $document->icon }}"></i> Arquivo Atual
                        </a>
                    </div>
                @endif
                <div class="input-group">
                    <div class="custom-file">
                        <input type="file" name="file_path" class="custom-file-input" id="file_path">
                        <label class="custom-file-label" for="file_path">Substituir arquivo (opcional)</label>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-warning">Atualizar</button>
            <a href="{{ route('admin.administration.documents.index') }}" class="btn btn-default float-right">Cancelar</a>
        </div>
    </form>
</div>
@stop
