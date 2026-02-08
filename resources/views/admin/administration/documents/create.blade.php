@extends('adminlte::page')

@section('title', 'Novo Documento')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Novo Documento</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.administration.documents.index') }}">Documentos</a></li>
                    <li class="breadcrumb-item active">Novo</li>
                </ol>
            </div>
        </div>
    </div>
@stop

@section('content')
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Dados do Documento</h3>
    </div>
    <form action="{{ route('admin.administration.documents.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 form-group">
                    <label for="title">Título *</label>
                    <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" required>
                    @error('title') <span class="invalid-feedback">{{ $message }}</span> @enderror
                </div>
                <div class="col-md-3 form-group">
                    <label for="document_type">Tipo *</label>
                    <select name="document_type" id="document_type" class="form-control @error('document_type') is-invalid @enderror" required>
                        <option value="">Selecione...</option>
                        <option value="statute">Estatuto</option>
                        <option value="regulation">Regulamento</option>
                        <option value="policy">Política</option>
                        <option value="certificate">Certificado</option>
                        <option value="license">Licença</option>
                        <option value="other">Outro</option>
                    </select>
                    @error('document_type') <span class="invalid-feedback">{{ $message }}</span> @enderror
                </div>
                <div class="col-md-3 form-group">
                    <label for="version">Versão</label>
                    <input type="text" name="version" id="version" class="form-control" value="{{ old('version') }}">
                </div>
            </div>

            <div class="form-group">
                <label for="description">Descrição</label>
                <textarea name="description" id="description" class="form-control" rows="3">{{ old('description') }}</textarea>
            </div>

            <div class="row">
                <div class="col-md-4 form-group">
                    <label for="effective_date">Data de Vigência</label>
                    <input type="date" name="effective_date" id="effective_date" class="form-control" value="{{ old('effective_date') }}">
                </div>
                <div class="col-md-4 form-group">
                    <label for="expiration_date">Data de Expiração</label>
                    <input type="date" name="expiration_date" id="expiration_date" class="form-control" value="{{ old('expiration_date') }}">
                </div>
                <div class="col-md-4 form-group">
                    <label for="status">Status Inicial</label>
                    <select name="status" id="status" class="form-control">
                        <option value="draft">Rascunho</option>
                        <option value="active">Ativo</option>
                        <option value="archived">Arquivado</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label for="file_path">Arquivo</label>
                <div class="input-group">
                    <div class="custom-file">
                        <input type="file" name="file_path" class="custom-file-input" id="file_path">
                        <label class="custom-file-label" for="file_path">Escolher arquivo</label>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Salvar</button>
            <a href="{{ route('admin.administration.documents.index') }}" class="btn btn-default float-right">Cancelar</a>
        </div>
    </form>
</div>
@stop
