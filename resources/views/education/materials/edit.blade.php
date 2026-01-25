@extends('adminlte::page')

@section('title', 'Editar Material Educacional')

@section('content_header')
    <h1>Editar Material Educacional</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Editar Material Educacional</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('education.materials.update', $material) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="title">Título</label>
                <input type="text" name="title" class="form-control" value="{{ $material->title }}" required>
            </div>
            <div class="form-group">
                <label for="description">Descrição</label>
                <textarea name="description" class="form-control">{{ $material->description }}</textarea>
            </div>
            <div class="form-group">
                <label for="type">Tipo</label>
                <select name="type" class="form-control" required>
                    <option value="book" {{ $material->type == 'book' ? 'selected' : '' }}>Livro</option>
                    <option value="video" {{ $material->type == 'video' ? 'selected' : '' }}>Vídeo</option>
                    <option value="worksheet" {{ $material->type == 'worksheet' ? 'selected' : '' }}>Atividade</option>
                    <option value="other" {{ $material->type == 'other' ? 'selected' : '' }}>Outro</option>
                </select>
            </div>
            <div class="form-group">
                <label for="url">URL</label>
                <input type="url" name="url" class="form-control" value="{{ $material->url }}">
            </div>
            <div class="form-group">
                <label for="class_id">Turma</label>
                <select name="class_id" class="form-control" required>
                    <option value="">Selecione uma turma</option>
                    @foreach($classes as $class)
                    <option value="{{ $class->id }}" {{ $class->id == $material->class_id ? 'selected' : '' }}>{{ $class->name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Salvar</button>
            <a href="{{ route('education.materials.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</div>
@stop