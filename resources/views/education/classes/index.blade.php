@extends('adminlte::page')

@section('title', 'Turmas')

@section('content_header')
    <h1>Turmas</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Lista de Turmas</h3>
        @can('education_classes.create')
        <div class="card-tools">
            <a href="{{ route('education.classes.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Nova Turma
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
                    <th>Faixa Etária</th>
                    <th>Professor</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($classes as $class)
                <tr>
                    <td>{{ $class->id }}</td>
                    <td>{{ $class->name }}</td>
                    <td>{{ $class->age_group }}</td>
                    <td>{{ $class->teacher?->name ?? '-' }}</td>
                    <td>
                        @can('education_classes.view')
                        <a href="{{ route('education.classes.show', $class) }}" class="btn btn-info btn-sm">
                            <i class="fas fa-eye"></i>
                        </a>
                        @endcan
                        @can('education_classes.edit')
                        <a href="{{ route('education.classes.edit', $class) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i>
                        </a>
                        @endcan
                        @can('education_classes.delete')
                        <form action="{{ route('education.classes.destroy', $class) }}" method="POST" style="display: inline;">
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
        {{ $classes->links() }}
    </div>
</div>
@stop