@extends('adminlte::page')

@section('title', 'Incidentes de Segurança')

@section('content_header')
    <h1>Incidentes de Segurança</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Lista de Incidentes</h3>
        <div class="card-tools">
            <a href="{{ route('it.security.create') }}" class="btn btn-danger btn-sm">
                <i class="fas fa-plus"></i> Novo Incidente
            </a>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Título</th>
                    <th>Severidade</th>
                    <th>Status</th>
                    <th>Reportado por</th>
                    <th>Data do Relatório</th>
                    <th>Data da Resolução</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse(\App\Models\SecurityIncident::with('reporter')->latest()->get() as $incident)
                <tr>
                    <td>{{ $incident->id }}</td>
                    <td>{{ $incident->title }}</td>
                    <td>
                        <span class="badge badge-{{ $incident->severity === 'critical' ? 'danger' : ($incident->severity === 'high' ? 'warning' : ($incident->severity === 'medium' ? 'info' : 'secondary')) }}">
                            {{ ucfirst($incident->severity) }}
                        </span>
                    </td>
                    <td>
                        <span class="badge badge-{{ $incident->status === 'open' ? 'danger' : ($incident->status === 'investigating' ? 'warning' : 'success') }}">
                            {{ ucfirst($incident->status) }}
                        </span>
                    </td>
                    <td>{{ $incident->reporter->name ?? 'Usuário não encontrado' }}</td>
                    <td>{{ $incident->reported_at->format('d/m/Y H:i') }}</td>
                    <td>{{ $incident->resolved_at ? $incident->resolved_at->format('d/m/Y H:i') : '-' }}</td>
                    <td>
                        <a href="{{ route('it.security.show', $incident) }}" class="btn btn-info btn-sm">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('it.security.edit', $incident) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('it.security.destroy', $incident) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja excluir este incidente?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center">Nenhum incidente de segurança encontrado.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@stop