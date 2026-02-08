@extends('adminlte::page')

@section('title', 'Comunicados')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Comunicados</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Administração</li>
                    <li class="breadcrumb-item active">Comunicados</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Lista de Comunicados</h3>
                        <div class="card-tools">
                            <a href="{{ route('admin.administration.announcements.create') }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-plus"></i> Novo Comunicado
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Filtros -->
                        <form method="GET" class="mb-3">
                            <div class="row">
                                <div class="col-md-3">
                                    <input type="text" name="search" class="form-control" 
                                           placeholder="Buscar comunicado..." value="{{ request('search') }}">
                                </div>
                                <div class="col-md-2">
                                    <select name="type" class="form-control">
                                        <option value="">Todos os tipos</option>
                                        <option value="general" {{ request('type') == 'general' ? 'selected' : '' }}>Geral</option>
                                        <option value="urgent" {{ request('type') == 'urgent' ? 'selected' : '' }}>Urgente</option>
                                        <option value="event" {{ request('type') == 'event' ? 'selected' : '' }}>Evento</option>
                                        <option value="meeting" {{ request('type') == 'meeting' ? 'selected' : '' }}>Reunião</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <select name="priority" class="form-control">
                                        <option value="">Todas as prioridades</option>
                                        <option value="low" {{ request('priority') == 'low' ? 'selected' : '' }}>Baixa</option>
                                        <option value="normal" {{ request('priority') == 'normal' ? 'selected' : '' }}>Normal</option>
                                        <option value="high" {{ request('priority') == 'high' ? 'selected' : '' }}>Alta</option>
                                        <option value="urgent" {{ request('priority') == 'urgent' ? 'selected' : '' }}>Urgente</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <select name="department_id" class="form-control">
                                        <option value="">Todos os departamentos</option>
                                        @foreach($departments as $department)
                                            <option value="{{ $department->id }}" {{ request('department_id') == $department->id ? 'selected' : '' }}>
                                                {{ $department->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-1">
                                    <button type="submit" class="btn btn-default">
                                        <i class="fas fa-search"></i> Filtrar
                                    </button>
                                </div>
                            </div>
                        </form>

                        <!-- Lista de Comunicados -->
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Título</th>
                                        <th>Tipo</th>
                                        <th>Prioridade</th>
                                        <th>Departamento</th>
                                        <th>Autor</th>
                                        <th>Publicado</th>
                                        <th>Status</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($announcements as $announcement)
                                        <tr>
                                            <td>
                                                <strong>{{ $announcement->title }}</strong>
                                                @if($announcement->expires_at && $announcement->isExpired())
                                                    <span class="badge badge-danger ml-1">Expirado</span>
                                                @endif
                                            </td>
                                            <td>{!! $announcement->type_badge !!}</td>
                                            <td>{!! $announcement->priority_badge !!}</td>
                                            <td>{{ $announcement->department?->name ?? '--' }}</td>
                                            <td>{{ $announcement->author->name }}</td>
                                            <td>
                                                <small>
                                                    {{ $announcement->formatted_published_at }}
                                                    @if($announcement->expires_at)
                                                        <br>Expira: {{ $announcement->formatted_expires_at }}
                                                    @endif
                                                </small>
                                            </td>
                                            <td>
                                                @if($announcement->isVisible())
                                                    <span class="badge badge-success">Visível</span>
                                                @else
                                                    <span class="badge badge-secondary">Não visível</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <a href="{{ route('admin.administration.announcements.show', $announcement) }}" class="btn btn-outline-primary">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('admin.administration.announcements.edit', $announcement) }}" class="btn btn-outline-info">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('admin.administration.announcements.destroy', $announcement) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-outline-danger" 
                                                                onclick="return confirm('Tem certeza?')">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center">
                                                <div class="alert alert-info">
                                                    <i class="fas fa-info-circle"></i> Nenhum comunicado encontrado.
                                                    <a href="{{ route('admin.administration.announcements.create') }}" class="alert-link">Criar primeiro comunicado</a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Paginação -->
                        <div class="d-flex justify-content-center">
                            {{ $announcements->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
