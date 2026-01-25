@extends('adminlte::page')

@section('title', 'Bens')

@section('content_header')
    <h1>Bens</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Lista de Bens</h3>
        <div class="card-tools">
            <a href="{{ route('patrimony.assets.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Novo Bem
            </a>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Categoria</th>
                    <th>Valor</th>
                    <th>Status</th>
                    <th>Data de Aquisição</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($assets as $asset)
                <tr>
                    <td>{{ $asset->id }}</td>
                    <td>{{ $asset->name }}</td>
                    <td>{{ $asset->category }}</td>
                    <td>{{ $asset->value ? 'R$ ' . number_format($asset->value, 2, ',', '.') : '-' }}</td>
                    <td>
                        <span class="badge badge-{{ $asset->status == 'active' ? 'success' : ($asset->status == 'maintenance' ? 'warning' : 'secondary') }}">
                            {{ ucfirst($asset->status) }}
                        </span>
                    </td>
                    <td>{{ $asset->acquisition_date->format('d/m/Y') }}</td>
                    <td>
                        <a href="{{ route('patrimony.assets.show', $asset) }}" class="btn btn-info btn-sm">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('patrimony.assets.edit', $asset) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('patrimony.assets.destroy', $asset) }}" method="POST" style="display: inline;">
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
        {{ $assets->links() }}
    </div>
</div>
@stop