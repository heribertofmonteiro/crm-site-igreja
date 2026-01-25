@extends('adminlte::page')

@section('title', 'Suportes Missionários')

@section('content_header')
    <h1>Suportes Missionários</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Lista de Suportes Missionários</h3>
        <div class="card-tools">
            <a href="{{ route('missions.supports.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Novo Suporte
            </a>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Missionário</th>
                    <th>Apoiador</th>
                    <th>Valor</th>
                    <th>Frequência</th>
                    <th>Status</th>
                    <th>Data Início</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($supports as $support)
                <tr>
                    <td>{{ $support->id }}</td>
                    <td>{{ $support->missionary->name }}</td>
                    <td>{{ $support->supporter->name }}</td>
                    <td>R$ {{ number_format($support->amount, 2, ',', '.') }}</td>
                    <td>{{ ucfirst($support->frequency) }}</td>
                    <td>
                        <span class="badge badge-{{ $support->status === 'active' ? 'success' : 'secondary' }}">
                            {{ ucfirst($support->status) }}
                        </span>
                    </td>
                    <td>{{ $support->start_date->format('d/m/Y') }}</td>
                    <td>
                        <a href="{{ route('missions.supports.show', $support) }}" class="btn btn-info btn-sm">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('missions.supports.edit', $support) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('missions.supports.destroy', $support) }}" method="POST" style="display: inline;">
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
        {{ $supports->links() }}
    </div>
</div>
@stop