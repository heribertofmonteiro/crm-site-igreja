@extends('adminlte::page')

@section('title', 'Infraestrutura TI')

@section('content_header')
    <h1>Infraestrutura TI</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Ativos de Infraestrutura</h3>
        <div class="card-tools">
            <a href="{{ route('it.infrastructure.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Novo Ativo
            </a>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Tipo</th>
                    <th>Status</th>
                    <th>Localização</th>
                    <th>Data de Compra</th>
                    <th>Garantia até</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($assets as $asset)
                <tr>
                    <td>{{ $asset->id }}</td>
                    <td>{{ $asset->name }}</td>
                    <td>{{ ucfirst($asset->type) }}</td>
                    <td>
                        <span class="badge badge-{{ $asset->status === 'active' ? 'success' : ($asset->status === 'maintenance' ? 'warning' : 'secondary') }}">
                            {{ ucfirst($asset->status) }}
                        </span>
                    </td>
                    <td>{{ $asset->location ?? '-' }}</td>
                    <td>{{ $asset->purchase_date ? $asset->purchase_date->format('d/m/Y') : '-' }}</td>
                    <td>{{ $asset->warranty_expiry ? $asset->warranty_expiry->format('d/m/Y') : '-' }}</td>
                    <td>
                        <a href="{{ route('it.infrastructure.show', $asset) }}" class="btn btn-info btn-sm">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('it.infrastructure.edit', $asset) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('it.infrastructure.destroy', $asset) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja excluir este ativo?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="card-footer">
        {{ $assets->links() }}
    </div>
</div>
@stop