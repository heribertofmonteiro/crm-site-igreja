@extends('adminlte::page')

@section('title', 'Novo Material Educacional')

@section('content_header')
    <h1>Novo Material Educacional</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Criar Novo Material Educacional</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('education.materials.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="title">Título</label>
                <input type="text" name="title" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="description">Descrição</label>
                <textarea name="description" class="form-control"></textarea>
            </div>
            <div class="form-group">
                <label for="type">Tipo</label>
                <select name="type" class="form-control" required>
                    <option value="book">Livro</option>
                    <option value="video">Vídeo</option>
                    <option value="worksheet">Atividade</option>
                    <option value="other">Outro</option>
                </select>
            </div>
            <div class="form-group">
                <label for="url">URL</label>
                <input type="url" name="url" class="form-control">
            </div>
            <div class="form-group">
                <label for="class_id">Turma</label>
                <select name="class_id" class="form-control" required>
                    <option value="">Selecione uma turma</option>
                    @foreach($classes as $class)
                    <option value="{{ $class->id }}">{{ $class->name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Salvar</button>
            <a href="{{ route('education.materials.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</div>
@stop