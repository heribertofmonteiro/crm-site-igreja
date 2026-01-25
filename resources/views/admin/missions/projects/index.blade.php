@extends('adminlte::page')

@section('title', 'Projetos Missionários')

@section('content_header')
    <h1>Projetos Missionários</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Lista de Projetos Missionários</h3>
        <div class="card-tools">
            <a href="{{ route('missions.projects.create') }}" class="btn btn-primary btn-sm">
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
                    <th>Missionário</th>
                    <th>Localização</th>
                    <th>Status</th>
                    <th>Data Início</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($projects as $project)
                <tr>
                    <td>{{ $project->id }}</td>
                    <td>{{ $project->name }}</td>
                    <td>{{ $project->missionary->name }}</td>
                    <td>{{ $project->location }}</td>
                    <td>
                        <span class="badge badge-{{ $project->status === 'active' ? 'success' : 'secondary' }}">
                            {{ ucfirst($project->status) }}
                        </span>
                    </td>
                    <td>{{ $project->start_date->format('d/m/Y') }}</td>
                    <td>
                        <a href="{{ route('missions.projects.show', $project) }}" class="btn btn-info btn-sm">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('missions.projects.edit', $project) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('missions.projects.destroy', $project) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza?')">
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