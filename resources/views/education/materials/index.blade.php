@extends('adminlte::page')

@section('title', 'Materiais Educacionais')

@section('content_header')
    <h1>Materiais Educacionais</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Lista de Materiais Educacionais</h3>
        @can('education_materials.create')
        <div class="card-tools">
            <a href="{{ route('education.materials.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Novo Material
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
                    <th>Turma</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($materials as $material)
                <tr>
                    <td>{{ $material->id }}</td>
                    <td>{{ $material->title }}</td>
                    <td>{{ $material->type }}</td>
                    <td>{{ $material->schoolClass?->name ?? '-' }}</td>
                    <td>
                        @can('education_materials.view')
                        <a href="{{ route('education.materials.show', $material) }}" class="btn btn-info btn-sm">
                            <i class="fas fa-eye"></i>
                        </a>
                        @endcan
                        @can('education_materials.edit')
                        <a href="{{ route('education.materials.edit', $material) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i>
                        </a>
                        @endcan
                        @can('education_materials.delete')
                        <form action="{{ route('education.materials.destroy', $material) }}" method="POST" style="display: inline;">
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
        {{ $materials->links() }}
    </div>
</div>
@stop