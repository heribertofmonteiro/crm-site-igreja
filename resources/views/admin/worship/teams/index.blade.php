@extends('adminlte::page')

@section('title', 'Equipes de Louvor')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Equipes de Louvor</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Equipes</li>
                </ol>
            </div>
        </div>
    </div>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Lista de Equipes</h3>
        <div class="card-tools">
            <a href="{{ route('admin.worship.teams.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Nova Equipe
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Líder</th>
                        <th>Status</th>
                        <th>Ensaios</th>
                        <th style="width: 150px">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($teams as $team)
                        <tr>
                            <td>{{ $team->name }}</td>
                            <td>{{ $team->leader?->name ?? 'Sem Líder' }}</td>
                            <td>
                                @if($team->is_active)
                                    <span class="badge badge-success">Ativa</span>
                                @else
                                    <span class="badge badge-danger">Inativa</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge badge-info">{{ $team->rehearsals_count }}</span>
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('admin.worship.teams.show', $team) }}" class="btn btn-info" title="Visualizar">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.worship.teams.edit', $team) }}" class="btn btn-warning" title="Editar">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>
                                    <form action="{{ route('admin.worship.teams.destroy', $team) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" title="Excluir" onclick="return confirm('Tem certeza que deseja excluir esta equipe?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">Nenhuma equipe encontrada.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer clearfix">
        {{ $teams->links() }}
    </div>
</div>
@stop
