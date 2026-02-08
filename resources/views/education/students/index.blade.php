@extends('adminlte::page')

@section('title', 'Estudantes')

@section('content_header')
    <h1>Estudantes</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Lista de Estudantes</h3>
        @can('education_students.create')
        <div class="card-tools">
            <a href="{{ route('education.students.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Novo Estudante
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
                    <th>Data de Nascimento</th>
                    <th>Turma</th>
                    <th>Pai/Mãe</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($students as $student)
                <tr>
                    <td>{{ $student->id }}</td>
                    <td>{{ $student->name }}</td>
                    <td>{{ $student->birth_date->format('d/m/Y') }}</td>
                    <td>{{ $student->schoolClass?->name ?? '-' }}</td>
                    <td>{{ $student->parent?->name ?? '-' }}</td>
                    <td>
                        @can('education_students.view')
                        <a href="{{ route('education.students.show', $student) }}" class="btn btn-info btn-sm">
                            <i class="fas fa-eye"></i>
                        </a>
                        @endcan
                        @can('education_students.edit')
                        <a href="{{ route('education.students.edit', $student) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i>
                        </a>
                        @endcan
                        @can('education_students.delete')
                        <form action="{{ route('education.students.destroy', $student) }}" method="POST" style="display: inline;">
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
        {{ $students->links() }}
    </div>
</div>
@stop