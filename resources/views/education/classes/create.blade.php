@extends('adminlte::page')

@section('title', 'Nova Turma')

@section('content_header')
    <h1>Nova Turma</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Criar Nova Turma</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('education.classes.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Nome</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="description">Descrição</label>
                <textarea name="description" class="form-control"></textarea>
            </div>
            <div class="form-group">
                <label for="age_group">Faixa Etária</label>
                <input type="text" name="age_group" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="teacher_id">Professor</label>
                <select name="teacher_id" class="form-control" required>
                    <option value="">Selecione um professor</option>
                    @foreach($teachers as $teacher)
                    <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Salvar</button>
            <a href="{{ route('education.classes.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</div>
@stop