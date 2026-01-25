@extends('adminlte::page')

@section('title', 'Doutrinas')

@section('content_header')
    <h1>Doutrinas</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Lista de Doutrinas</h3>
        @can('doctrines.create')
        <div class="card-tools">
            <a href="{{ route('pastoral.doctrines.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Nova Doutrina
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
                    <th>Autor</th>
                    <th>Aprovada</th>
                    <th>Criado em</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse($doctrines as $doctrine)
                <tr>
                    <td>{{ $doctrine->id }}</td>
                    <td>{{ $doctrine->title }}</td>
                    <td>{{ $doctrine->author->name }}</td>
                    <td>
                        @if($doctrine->approved_at)
                            <span class="badge badge-success">Aprovada</span>
                        @else
                            <span class="badge badge-warning">Pendente</span>
                        @endif
                    </td>
                    <td>{{ $doctrine->created_at->format('d/m/Y') }}</td>
                    <td>
                        @can('doctrines.view')
                        <a href="{{ route('pastoral.doctrines.show', $doctrine) }}" class="btn btn-info btn-sm">
                            <i class="fas fa-eye"></i>
                        </a>
                        @endcan
                        @can('doctrines.edit')
                        <a href="{{ route('pastoral.doctrines.edit', $doctrine) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i>
                        </a>
                        @endcan
                        @can('doctrines.delete')
                        <form action="{{ route('pastoral.doctrines.destroy', $doctrine) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                        @endcan
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center">Nenhuma doutrina encontrada.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer">
        {{ $doctrines->links() }}
    </div>
</div>
@stop