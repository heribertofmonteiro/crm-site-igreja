@extends('adminlte::page')

@section('title', 'Criar Doutrina')

@section('content_header')
    <h1>Criar Nova Doutrina</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Formulário de Doutrina</h3>
    </div>
    <form action="{{ route('pastoral.doctrines.store') }}" method="POST">
        @csrf
        <div class="card-body">
            <div class="form-group">
                <label for="title">Título</label>
                <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}" required>
                @error('title')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group">
                <label for="content">Conteúdo</label>
                <textarea class="form-control @error('content') is-invalid @enderror" id="content" name="content" rows="10" required>{{ old('content') }}</textarea>
                @error('content')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group">
                <label for="author_id">Autor</label>
                <select class="form-control @error('author_id') is-invalid @enderror" id="author_id" name="author_id" required>
                    <option value="">Selecione um autor</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ old('author_id') == $user->id ? 'selected' : '' }}>
                            {{ $user->name }}
                        </option>
                    @endforeach
                </select>
                @error('author_id')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Salvar</button>
            <a href="{{ route('pastoral.doctrines.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>
@stop