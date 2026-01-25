@extends('adminlte::page')

@section('title', 'Auditorias Financeiras')

@section('content_header')
    <h1>Auditorias Financeiras</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Lista de Auditorias</h3>
        <div class="card-tools">
            <a href="{{ route('financial-audits.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Nova Auditoria
            </a>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Data da Auditoria</th>
                    <th>Período</th>
                    <th>Status</th>
                    <th>Auditor</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($audits as $audit)
                <tr>
                    <td>{{ $audit->id }}</td>
                    <td>{{ $audit->audit_date->format('d/m/Y') }}</td>
                    <td>{{ $audit->period_start->format('d/m/Y') }} - {{ $audit->period_end->format('d/m/Y') }}</td>
                    <td>
                        @if($audit->status == 'pending')
                            <span class="badge badge-warning">Pendente</span>
                        @elseif($audit->status == 'in_progress')
                            <span class="badge badge-info">Em Andamento</span>
                        @else
                            <span class="badge badge-success">Concluída</span>
                        @endif
                    </td>
                    <td>{{ $audit->auditor ?: '-' }}</td>
                    <td>
                        <a href="{{ route('financial-audits.show', $audit) }}" class="btn btn-info btn-sm">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('financial-audits.edit', $audit) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="{{ route('financial-audits.report', $audit) }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-file-alt"></i> Relatório
                        </a>
                        <form action="{{ route('financial-audits.destroy', $audit) }}" method="POST" style="display: inline;">
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
        {{ $audits->links() }}
    </div>
</div>
@stop