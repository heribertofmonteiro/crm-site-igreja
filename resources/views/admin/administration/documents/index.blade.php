@extends('adminlte::page')

@section('title', 'Documentos Institucionais')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Documentos Institucionais</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Documentos</li>
                </ol>
            </div>
        </div>
    </div>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Lista de Documentos</h3>
        <div class="card-tools">
            <a href="{{ route('admin.administration.documents.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Novo Documento
            </a>
        </div>
    </div>
    <div class="card-body">
        <!-- Filtros -->
        <form method="GET" class="mb-3">
            <div class="row">
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control" placeholder="Buscar por título ou descrição..." value="{{ request('search') }}">
                </div>
                <div class="col-md-2">
                    <select name="status" class="form-control">
                        <option value="">Todos Status</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Ativo</option>
                        <option value="archived" {{ request('status') == 'archived' ? 'selected' : '' }}>Arquivado</option>
                        <option value="expired" {{ request('status') == 'expired' ? 'selected' : '' }}>Expirado</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-default"><i class="fas fa-search"></i> Filtrar</button>
                </div>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th style="width: 50px">Tipo</th>
                        <th>Título</th>
                        <th>Categoria</th>
                        <th>Departamento</th>
                        <th>Status</th>
                        <th>Data</th>
                        <th style="width: 150px">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($documents as $document)
                        <tr>
                            <td class="text-center">
                                <i class="{{ $document->icon }} fa-2x text-muted" title="{{ $document->type_label }}"></i>
                            </td>
                            <td>
                                <strong>{{ $document->title }}</strong><br>
                                <small class="text-muted">{{ Str::limit($document->description, 50) }}</small>
                            </td>
                            <td>{{ $document->category?->name ?? 'N/A' }}</td>
                            <td>{{ $document->department?->name ?? 'Geral' }}</td>
                            <td>{!! $document->status_badge !!}</td>
                            <td>{{ $document->created_at->format('d/m/Y') }}</td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('admin.administration.documents.show', $document) }}" class="btn btn-info" title="Visualizar">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ $document->file_url }}" target="_blank" class="btn btn-default" title="Baixar">
                                        <i class="fas fa-download"></i>
                                    </a>
                                    <a href="{{ route('admin.administration.documents.edit', $document) }}" class="btn btn-warning" title="Editar">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">Nenhum documento encontrado.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer clearfix">
        {{ $documents->links() }}
    </div>
</div>
@stop
