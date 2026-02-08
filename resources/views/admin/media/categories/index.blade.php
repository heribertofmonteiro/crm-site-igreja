@extends('adminlte::page')

@section('title', 'Categorias de Mídia')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Categorias de Mídia</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.media.index') }}">Mídias</a></li>
                    <li class="breadcrumb-item active">Categorias</li>
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
                        <h3 class="card-title">Lista de Categorias</h3>
                        <div class="card-tools">
                            <a href="{{ route('admin.media.categories.create') }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-plus"></i> Nova Categoria
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @forelse($categories as $category)
                                <div class="col-md-4 mb-4">
                                    <div class="card">
                                        <div class="card-body text-center">
                                            <div class="mb-3">
                                                @if($category->icon)
                                                    <i class="{{ $category->icon }} fa-3x" style="color: {{ $category->color }}"></i>
                                                @else
                                                    <i class="fas fa-folder fa-3x" style="color: {{ $category->color }}"></i>
                                                @endif
                                            </div>
                                            <h5 class="card-title">{{ $category->name }}</h5>
                                            @if($category->description)
                                                <p class="card-text text-muted">{{ Str::limit($category->description, 50) }}</p>
                                            @endif
                                            <div class="mb-2">
                                                <span class="badge badge-pill badge-primary">
                                                    {{ $category->medias_count }} mídias
                                                </span>
                                                @if($category->is_active)
                                                    <span class="badge badge-pill badge-success">Ativa</span>
                                                @else
                                                    <span class="badge badge-pill badge-secondary">Inativa</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <div class="btn-group btn-group-sm w-100">
                                                <a href="{{ route('admin.media.categories.edit', $category) }}" class="btn btn-outline-info">
                                                    <i class="fas fa-edit"></i> Editar
                                                </a>
                                                <form action="{{ route('admin.media.categories.destroy', $category) }}" method="POST" class="d-inline">
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
                                        <i class="fas fa-info-circle"></i> Nenhuma categoria encontrada.
                                        <a href="{{ route('admin.media.categories.create') }}" class="alert-link">Criar primeira categoria</a>
                                    </div>
                                </div>
                            @endforelse
                        </div>

                        <!-- Paginação -->
                        <div class="d-flex justify-content-center">
                            {{ $categories->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
