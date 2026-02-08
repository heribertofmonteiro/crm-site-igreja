@extends('adminlte::page')

@section('title', 'Voluntários Sociais')

@section('content_header')
    <h1>Voluntários Sociais</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Lista de Voluntários Sociais</h3>
        @can('social_volunteers.create')
        <div class="card-tools">
            <a href="{{ route('admin.social_volunteers.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Novo Voluntário
            </a>
        </div>
        @endcan
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Projeto</th>
                    <th>Usuário</th>
                    <th>Função</th>
                    <th>Data de Ingresso</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($socialVolunteers as $volunteer)
                <tr>
                    <td>{{ $volunteer->id }}</td>
                    <td>{{ $volunteer->project->name }}</td>
                    <td>{{ $volunteer->user->name }}</td>
                    <td>{{ $volunteer->role }}</td>
                    <td>{{ $volunteer->joined_at->format('d/m/Y') }}</td>
                    <td>{{ ucfirst($volunteer->status) }}</td>
                    <td>
                        @can('social_volunteers.view')
                        <a href="{{ route('admin.social_volunteers.show', $volunteer) }}" class="btn btn-info btn-sm">
                            <i class="fas fa-eye"></i>
                        </a>
                        @endcan
                        @can('social_volunteers.edit')
                        <a href="{{ route('admin.social_volunteers.edit', $volunteer) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i>
                        </a>
                        @endcan
                        @can('social_volunteers.delete')
                        <form action="{{ route('admin.social_volunteers.destroy', $volunteer) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja excluir este voluntário?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                        @endcan
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@stop