@extends('adminlte::page')

@section('title', 'Obrigações de Conformidade')

@section('content_header')
    <h1>Obrigações de Conformidade</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Lista de Obrigações de Conformidade</h3>
        @can('compliance_obligations.create')
        <div class="card-tools">
            <a href="{{ route('admin.legal.compliance_obligations.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Nova Obrigação
            </a>
        </div>
        @endcan
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Título</th>
                    <th>Tipo</th>
                    <th>Data de Vencimento</th>
                    <th>Status</th>
                    <th>Responsável</th>
                    <th>Criado em</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($complianceObligations as $obligation)
                <tr>
                    <td>{{ $obligation->id }}</td>
                    <td>{{ $obligation->title }}</td>
                    <td>{{ ucfirst($obligation->obligation_type) }}</td>
                    <td>{{ $obligation->due_date->format('d/m/Y') }}</td>
                    <td>
                        <span class="badge badge-{{ $obligation->status == 'completed' ? 'success' : ($obligation->status == 'overdue' ? 'danger' : 'warning') }}">
                            {{ ucfirst($obligation->status) }}
                        </span>
                    </td>
                    <td>{{ $obligation->responsibleUser->name ?? 'N/A' }}</td>
                    <td>{{ $obligation->created_at->format('d/m/Y') }}</td>
                    <td>
                        @can('compliance_obligations.view')
                        <a href="{{ route('admin.legal.compliance_obligations.show', $obligation) }}" class="btn btn-info btn-sm">
                            <i class="fas fa-eye"></i>
                        </a>
                        @endcan
                        @can('compliance_obligations.edit')
                        <a href="{{ route('admin.legal.compliance_obligations.edit', $obligation) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i>
                        </a>
                        @endcan
                        @can('compliance_obligations.delete')
                        <form action="{{ route('admin.legal.compliance_obligations.destroy', $obligation) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                        @endcan
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{ $complianceObligations->links() }}
    </div>
</div>
@stop