@extends('adminlte::page')

@section('title', 'Departamentos')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Departamentos</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Administração</li>
                    <li class="breadcrumb-item active">Departamentos</li>
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
                        <h3 class="card-title">Lista de Departamentos</h3>
                        <div class="card-tools">
                            <a href="{{ route('admin.administration.departments.create') }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-plus"></i> Novo Departamento
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @forelse($departments as $department)
                                <div class="col-md-4 mb-4">
                                    <div class="card">
                                        <div class="card-header">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <h5 class="card-title mb-0">
                                                    @if($department->icon)
                                                        <i class="{{ $department->icon }} mr-2" @if($department->color) style="color: {{ $department->color }};" @endif></i>
                                                    @endif
                                                    {{ $department->name }}
                                                </h5>
                                                @if($department->is_active)
                                                    <span class="badge badge-success">Ativo</span>
                                                @else
                                                    <span class="badge badge-secondary">Inativo</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            @if($department->description)
                                                <p class="card-text">{{ Str::limit($department->description, 100) }}</p>
                                            @endif
                                            
                                            @if($department->responsible)
                                                <div class="mb-2">
                                                    <small class="text-muted">
                                                        <i class="fas fa-user"></i> Responsável: {{ $department->responsible->name }}
                                                    </small>
                                                </div>
                                            @endif

                                            <div class="row text-center mb-3">
                                                <div class="col-4">
                                                    <h6>{{ $department->documents_count }}</h6>
                                                    <small class="text-muted">Documentos</small>
                                                </div>
                                                <div class="col-4">
                                                    <h6>{{ $department->active_announcements_count }}</h6>
                                                    <small class="text-muted">Comunicados</small>
                                                </div>
                                                <div class="col-4">
                                                    <h6>{{ $department->meeting_count }}</h6>
                                                    <small class="text-muted">Atas</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <div class="btn-group btn-group-sm w-100">
                                                <a href="{{ route('admin.administration.departments.show', $department) }}" class="btn btn-outline-primary">
                                                    <i class="fas fa-eye"></i> Visualizar
                                                </a>
                                                <a href="{{ route('admin.administration.departments.edit', $department) }}" class="btn btn-outline-info">
                                                    <i class="fas fa-edit"></i> Editar
                                                </a>
                                                <form action="{{ route('admin.administration.departments.destroy', $department) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-outline-danger" 
                                                            onclick="return confirm('Tem certeza?')">
                                                        <i class="fas fa-trash"></i> Excluir
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="col-12">
                                    <div class="alert alert-info">
                                        <i class="fas fa-info-circle"></i> Nenhum departamento encontrado.
                                        <a href="{{ route('admin.administration.departments.create') }}" class="alert-link">Criar primeiro departamento</a>
                                    </div>
                                </div>
                            @endforelse
                        </div>

                        <!-- Paginação -->
                        <div class="d-flex justify-content-center">
                            {{ $departments->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
