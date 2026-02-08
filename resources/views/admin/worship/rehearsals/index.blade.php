@extends('adminlte::page')

@section('title', 'Ensaios')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Ensaios</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Ensaios</li>
                </ol>
            </div>
        </div>
    </div>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Lista de Ensaios</h3>
        <div class="card-tools">
            <a href="{{ route('admin.worship.rehearsals.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Novo Ensaio
            </a>
            <a href="{{ route('admin.worship.rehearsals.calendar') }}" class="btn btn-info btn-sm">
                <i class="fas fa-calendar"></i> Calendário
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Equipe</th>
                        <th>Data/Hora</th>
                        <th>Local</th>
                        <th>Status</th>
                        <th style="width: 150px">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($rehearsals as $rehearsal)
                        <tr>
                            <td>{{ $rehearsal->worshipTeam->name }}</td>
                            <td>{{ $rehearsal->scheduled_at->format('d/m/Y H:i') }}</td>
                            <td>{{ $rehearsal->location ?? 'Não definido' }}</td>
                            <td>
                                @if($rehearsal->status == 'scheduled')
                                    <span class="badge badge-warning">Agendado</span>
                                @elseif($rehearsal->status == 'in_progress')
                                    <span class="badge badge-info">Em Andamento</span>
                                @elseif($rehearsal->status == 'completed')
                                    <span class="badge badge-success">Concluído</span>
                                @elseif($rehearsal->status == 'cancelled')
                                    <span class="badge badge-danger">Cancelado</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('admin.worship.rehearsals.show', $rehearsal) }}" class="btn btn-info" title="Visualizar">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @if($rehearsal->status == 'scheduled')
                                    <a href="{{ route('admin.worship.rehearsals.edit', $rehearsal) }}" class="btn btn-warning" title="Editar">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>
                                    @endif
                                    <form action="{{ route('admin.worship.rehearsals.destroy', $rehearsal) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" title="Excluir" onclick="return confirm('Tem certeza que deseja excluir este ensaio?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">Nenhum ensaio agendado.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer clearfix">
        {{ $rehearsals->links() }}
    </div>
</div>
@stop
