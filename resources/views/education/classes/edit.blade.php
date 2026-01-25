@extends('adminlte::page')

@section('title', 'Editar Turma')

@section('content_header')
    <h1>Editar Turma</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Editar Turma</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('education.classes.update', $class) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">Nome</label>
                <input type="text" name="name" class="form-control" value="{{ $class->name }}" required>
            </div>
            <div class="form-group">
                <label for="description">Descrição</label>
                <textarea name="description" class="form-control">{{ $class->description }}</textarea>
            </div>
            <div class="form-group">
                <label for="age_group">Faixa Etária</label>
                <input type="text" name="age_group" class="form-control" value="{{ $class->age_group }}" required>
            </div>
            <div class="form-group">
                <label for="teacher_id">Professor</label>
                <select name="teacher_id" class="form-control" required>
                    <option value="">Selecione um professor</option>
                    @foreach($teachers as $teacher)
                    <option value="{{ $teacher->id }}" {{ $teacher->id == $class->teacher_id ? 'selected' : '' }}>{{ $teacher->name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Salvar</button>
            <a href="{{ route('education.classes.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</div>
@stop