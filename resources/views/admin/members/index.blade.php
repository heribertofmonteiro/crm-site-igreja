@extends('adminlte::page')

@section('title', 'Membros')

@section('content_header')
    <h1>Membros</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Lista de Membros</h3>
        @can('members.create')
        <div class="card-tools">
            <a href="{{ route('admin.members.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Novo Membro
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
                    <th>Email</th>
                    <th>Telefone</th>
                    <th>Estado Civil</th>
                    <th>Criado em</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($members as $member)
                <tr>
                    <td>{{ $member->id }}</td>
                    <td>{{ $member->name }}</td>
                    <td>{{ $member->email }}</td>
                    <td>{{ $member->phone }}</td>
                    <td>{{ ucfirst($member->marital_status) }}</td>
                    <td>{{ $member->created_at->format('d/m/Y') }}</td>
                    <td>
                        @can('members.view')
                        <a href="{{ route('admin.members.show', $member) }}" class="btn btn-info btn-sm">
                            <i class="fas fa-eye"></i>
                        </a>
                        @endcan
                        @can('members.edit')
                        <a href="{{ route('admin.members.edit', $member) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i>
                        </a>
                        @endcan
                        @can('members.delete')
                        <form action="{{ route('admin.members.destroy', $member) }}" method="POST" style="display: inline;">
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
        {{ $members->links() }}
    </div>
</div>
@stop