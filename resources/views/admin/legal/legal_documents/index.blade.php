@extends('adminlte::page')

@section('title', 'Documentos Legais')

@section('content_header')
    <h1>Documentos Legais</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Lista de Documentos Legais</h3>
        @can('legal_documents.create')
        <div class="card-tools">
            <a href="{{ route('admin.legal.legal_documents.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Novo Documento
            </a>
        </div>
        @endcan
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Título</th>
                    <th>Tipo</th>
                    <th>Status</th>
                    <th>Data de Expiração</th>
                    <th>Criado por</th>
                    <th>Criado em</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($legalDocuments as $document)
                <tr>
                    <td>{{ $document->id }}</td>
                    <td>{{ $document->title }}</td>
                    <td>{{ ucfirst($document->document_type) }}</td>
                    <td>
                        <span class="badge badge-{{ $document->status == 'active' ? 'success' : ($document->status == 'expired' ? 'danger' : 'warning') }}">
                            {{ ucfirst($document->status) }}
                        </span>
                    </td>
                    <td>{{ $document->expiration_date ? $document->expiration_date->format('d/m/Y') : 'N/A' }}</td>
                    <td>{{ $document->creator->name ?? 'N/A' }}</td>
                    <td>{{ $document->created_at->format('d/m/Y') }}</td>
                    <td>
                        @can('legal_documents.view')
                        <a href="{{ route('admin.legal.legal_documents.show', $document) }}" class="btn btn-info btn-sm">
                            <i class="fas fa-eye"></i>
                        </a>
                        @endcan
                        @can('legal_documents.edit')
                        <a href="{{ route('admin.legal.legal_documents.edit', $document) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i>
                        </a>
                        @endcan
                        @can('legal_documents.delete')
                        <form action="{{ route('admin.legal.legal_documents.destroy', $document) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                        @endcan
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{ $legalDocuments->links() }}
    </div>
</div>
@stop