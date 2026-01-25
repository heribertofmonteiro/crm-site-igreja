@extends('adminlte::page')

@section('title', 'Missionários')

@section('content_header')
    <h1>Missionários</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Lista de Missionários</h3>
        <div class="card-tools">
            <a href="{{ route('missions.missionaries.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Novo Missionário
            </a>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>País</th>
                    <th>Status</th>
                    <th>Data Início</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($missionaries as $missionary)
                <tr>
                    <td>{{ $missionary->id }}</td>
                    <td>{{ $missionary->name }}</td>
                    <td>{{ $missionary->email }}</td>
                    <td>{{ $missionary->country }}</td>
                    <td>
                        <span class="badge badge-{{ $missionary->status === 'active' ? 'success' : 'secondary' }}">
                            {{ ucfirst($missionary->status) }}
                        </span>
                    </td>
                    <td>{{ $missionary->start_date->format('d/m/Y') }}</td>
                    <td>
                        <a href="{{ route('missions.missionaries.show', $missionary) }}" class="btn btn-info btn-sm">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('missions.missionaries.edit', $missionary) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('missions.missionaries.destroy', $missionary) }}" method="POST" style="display: inline;">
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
        {{ $missionaries->links() }}
    </div>
</div>
@stop