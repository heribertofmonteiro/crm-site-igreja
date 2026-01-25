@extends('adminlte::page')

@section('title', 'Conselhos Pastorais')

@section('content_header')
    <h1>Conselhos Pastorais</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Lista de Conselhos Pastorais</h3>
        @can('pastoral_councils.create')
        <div class="card-tools">
            <a href="{{ route('pastoral.councils.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Novo Conselho
            </a>
        </div>
        @endcan
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Descrição</th>
                    <th>Membros</th>
                    <th>Criado em</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse($councils as $council)
                <tr>
                    <td>{{ $council->id }}</td>
                    <td>{{ $council->name }}</td>
                    <td>{{ Str::limit($council->description, 50) }}</td>
                    <td>{{ $council->members ? count($council->members) : 0 }} membros</td>
                    <td>{{ $council->created_at->format('d/m/Y') }}</td>
                    <td>
                        @can('pastoral_councils.view')
                        <a href="{{ route('pastoral.councils.show', $council) }}" class="btn btn-info btn-sm">
                            <i class="fas fa-eye"></i>
                        </a>
                        @endcan
                        @can('pastoral_councils.edit')
                        <a href="{{ route('pastoral.councils.edit', $council) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i>
                        </a>
                        @endcan
                        @can('pastoral_councils.delete')
                        <form action="{{ route('pastoral.councils.destroy', $council) }}" method="POST" style="display: inline;">
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
                    <td colspan="6" class="text-center">Nenhum conselho pastoral encontrado.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer">
        {{ $councils->links() }}
    </div>
</div>
@stop