@extends('adminlte::page')

@section('title', 'Atas de Reunião')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Atas de Reunião</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Atas de Reunião</li>
                </ol>
            </div>
        </div>
    </div>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Lista de Atas</h3>
        <div class="card-tools">
            <a href="{{ route('admin.administration.meeting-minutes.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Nova Ata
            </a>
        </div>
    </div>
    <div class="card-body">
        <!-- Filtros -->
        <form method="GET" class="mb-3">
            <div class="row">
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control" placeholder="Buscar por título ou tipo..." value="{{ request('search') }}">
                </div>
                <div class="col-md-2">
                    <select name="status" class="form-control">
                        <option value="">Todos Status</option>
                        <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Rascunho</option>
                        <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Aprovado</option>
                        <option value="archived" {{ request('status') == 'archived' ? 'selected' : '' }}>Arquivado</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}" placeholder="De">
                </div>
                <div class="col-md-2">
                    <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}" placeholder="Até">
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
                        <th>Data</th>
                        <th>Título</th>
                        <th>Tipo</th>
                        <th>Status</th>
                        <th>Resumo</th>
                        <th style="width: 150px">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($minutes as $minute)
                        <tr>
                            <td>{{ $minute->formatted_meeting_date }}</td>
                            <td>
                                <strong>{{ $minute->title }}</strong><br>
                                <small class="text-muted">{{ $minute->location }}</small>
                            </td>
                            <td>{{ $minute->meeting_type ?? 'Geral' }}</td>
                            <td>{!! $minute->status_badge !!}</td>
                            <td><small>{{ $minute->summary }}</small></td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('admin.administration.meeting-minutes.show', $minute) }}" class="btn btn-info" title="Visualizar">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.administration.meeting-minutes.edit', $minute) }}" class="btn btn-warning" title="Editar">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Nenhuma ata encontrada.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer clearfix">
        {{ $minutes->links() }}
    </div>
</div>
@stop
