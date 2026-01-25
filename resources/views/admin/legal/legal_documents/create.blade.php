@extends('adminlte::page')

@section('title', 'Novo Documento Legal')

@section('content_header')
    <h1>Novo Documento Legal</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Criar Novo Documento Legal</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.legal.legal_documents.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="title">Título</label>
                <input type="text" name="title" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="description">Descrição</label>
                <textarea name="description" class="form-control"></textarea>
            </div>
            <div class="form-group">
                <label for="document_type">Tipo de Documento</label>
                <select name="document_type" class="form-control" required>
                    <option value="statute">Estatuto</option>
                    <option value="contract">Contrato</option>
                    <option value="certificate">Certificado</option>
                    <option value="license">Licença</option>
                    <option value="other">Outro</option>
                </select>
            </div>
            <div class="form-group">
                <label for="file_path">Caminho do Arquivo</label>
                <input type="text" name="file_path" class="form-control">
            </div>
            <div class="form-group">
                <label for="expiration_date">Data de Expiração</label>
                <input type="date" name="expiration_date" class="form-control">
            </div>
            <div class="form-group">
                <label for="status">Status</label>
                <select name="status" class="form-control" required>
                    <option value="active">Ativo</option>
                    <option value="expired">Expirado</option>
                    <option value="pending">Pendente</option>
                    <option value="archived">Arquivado</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Salvar</button>
            <a href="{{ route('admin.legal.legal_documents.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</div>
@stop