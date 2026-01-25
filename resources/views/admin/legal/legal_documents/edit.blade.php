@extends('adminlte::page')

@section('title', 'Editar Documento Legal')

@section('content_header')
    <h1>Editar Documento Legal</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Editar Documento Legal</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.legal.legal_documents.update', $legalDocument) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="title">Título</label>
                <input type="text" name="title" class="form-control" value="{{ old('title', $legalDocument->title) }}" required>
            </div>
            <div class="form-group">
                <label for="description">Descrição</label>
                <textarea name="description" class="form-control">{{ old('description', $legalDocument->description) }}</textarea>
            </div>
            <div class="form-group">
                <label for="document_type">Tipo de Documento</label>
                <select name="document_type" class="form-control" required>
                    <option value="statute" {{ old('document_type', $legalDocument->document_type) == 'statute' ? 'selected' : '' }}>Estatuto</option>
                    <option value="contract" {{ old('document_type', $legalDocument->document_type) == 'contract' ? 'selected' : '' }}>Contrato</option>
                    <option value="certificate" {{ old('document_type', $legalDocument->document_type) == 'certificate' ? 'selected' : '' }}>Certificado</option>
                    <option value="license" {{ old('document_type', $legalDocument->document_type) == 'license' ? 'selected' : '' }}>Licença</option>
                    <option value="other" {{ old('document_type', $legalDocument->document_type) == 'other' ? 'selected' : '' }}>Outro</option>
                </select>
            </div>
            <div class="form-group">
                <label for="file_path">Caminho do Arquivo</label>
                <input type="text" name="file_path" class="form-control" value="{{ old('file_path', $legalDocument->file_path) }}">
            </div>
            <div class="form-group">
                <label for="expiration_date">Data de Expiração</label>
                <input type="date" name="expiration_date" class="form-control" value="{{ old('expiration_date', $legalDocument->expiration_date ? $legalDocument->expiration_date->format('Y-m-d') : '') }}">
            </div>
            <div class="form-group">
                <label for="status">Status</label>
                <select name="status" class="form-control" required>
                    <option value="active" {{ old('status', $legalDocument->status) == 'active' ? 'selected' : '' }}>Ativo</option>
                    <option value="expired" {{ old('status', $legalDocument->status) == 'expired' ? 'selected' : '' }}>Expirado</option>
                    <option value="pending" {{ old('status', $legalDocument->status) == 'pending' ? 'selected' : '' }}>Pendente</option>
                    <option value="archived" {{ old('status', $legalDocument->status) == 'archived' ? 'selected' : '' }}>Arquivado</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Atualizar</button>
            <a href="{{ route('admin.legal.legal_documents.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</div>
@stop