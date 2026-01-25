@extends('adminlte::page')

@section('title', 'Projetos Sociais')

@section('content_header')
    <h1>Projetos Sociais</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Lista de Projetos Sociais</h3>
        <div class="card-tools">
            <a href="{{ route('social.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Novo Projeto
            </a>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Data Início</th>
                    <th>Data Fim</th>
                    <th>Status</th>
                    <th>Orçamento</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($projects as $project)
                <tr>
                    <td>{{ $project->id }}</td>
                    <td>{{ $project->name }}</td>
                    <td>{{ $project->start_date->format('d/m/Y') }}</td>
                    <td>{{ $project->end_date ? $project->end_date->format('d/m/Y') : '-' }}</td>
                    <td>
                        <span class="badge badge-{{ $project->status === 'active' ? 'success' : ($project->status === 'completed' ? 'primary' : 'secondary') }}">
                            {{ ucfirst($project->status) }}
                        </span>
                    </td>
                    <td>{{ $project->budget ? 'R$ ' . number_format($project->budget, 2, ',', '.') : '-' }}</td>
                    <td>
                        <a href="{{ route('social.show', $project) }}" class="btn btn-info btn-sm">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('social.edit', $project) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('social.destroy', $project) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja excluir?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{ $projects->links() }}
    </div>
</div>
@stop