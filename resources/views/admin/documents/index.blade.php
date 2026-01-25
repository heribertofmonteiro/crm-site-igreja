@extends('adminlte::page')

@section('title', 'Documentos')

@section('content_header')
    <h1>Documentos</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Lista de Documentos</h3>
        @can('documents.create')
        <div class="card-tools">
            <a href="{{ route('admin.documents.create') }}" class="btn btn-primary btn-sm">
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
                    <th>Membro</th>
                    <th>Evento</th>
                    <th>Criado em</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($documents as $document)
                <tr>
                    <td>{{ $document->id }}</td>
                    <td>{{ $document->title }}</td>
                    <td>{{ ucfirst($document->type) }}</td>
                    <td>{{ $document->member ? $document->member->name : 'N/A' }}</td>
                    <td>{{ $document->churchEvent ? $document->churchEvent->title : 'N/A' }}</td>
                    <td>{{ $document->created_at->format('d/m/Y') }}</td>
                    <td>
                        @can('documents.view')
                        <a href="{{ route('admin.documents.show', $document) }}" class="btn btn-info btn-sm">
                            <i class="fas fa-eye"></i>
                        </a>
                        @endcan
                        @can('documents.edit')
                        <a href="{{ route('admin.documents.edit', $document) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i>
                        </a>
                        @endcan
                        @can('documents.delete')
                        <form action="{{ route('admin.documents.destroy', $document) }}" method="POST" style="display: inline;">
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
        {{ $documents->links() }}
    </div>
</div>
@stop