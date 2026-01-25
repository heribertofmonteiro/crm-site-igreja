@extends('adminlte::page')

@section('title', 'Notas Pastorais')

@section('content_header')
    <h1>Notas Pastorais</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Lista de Notas Pastorais</h3>
        @can('pastoral_notes.create')
        <div class="card-tools">
            <a href="{{ route('pastoral.notes.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Nova Nota
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
                    <th>Conselho</th>
                    <th>Autor</th>
                    <th>Criado em</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse($notes as $note)
                <tr>
                    <td>{{ $note->id }}</td>
                    <td>{{ $note->title }}</td>
                    <td>{{ ucfirst($note->type) }}</td>
                    <td>{{ $note->council->name }}</td>
                    <td>{{ $note->user->name }}</td>
                    <td>{{ $note->created_at->format('d/m/Y') }}</td>
                    <td>
                        @can('pastoral_notes.view')
                        <a href="{{ route('pastoral.notes.show', $note) }}" class="btn btn-info btn-sm">
                            <i class="fas fa-eye"></i>
                        </a>
                        @endcan
                        @can('pastoral_notes.edit')
                        <a href="{{ route('pastoral.notes.edit', $note) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i>
                        </a>
                        @endcan
                        @can('pastoral_notes.delete')
                        <form action="{{ route('pastoral.notes.destroy', $note) }}" method="POST" style="display: inline;">
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
                    <td colspan="7" class="text-center">Nenhuma nota pastoral encontrada.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer">
        {{ $notes->links() }}
    </div>
</div>
@stop