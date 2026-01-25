@extends('adminlte::page')

@section('title', 'Editar Nota Pastoral')

@section('content_header')
    <h1>Editar Nota Pastoral</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Formulário de Nota Pastoral</h3>
    </div>
    <form action="{{ route('pastoral.notes.update', $note) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="card-body">
            <div class="form-group">
                <label for="title">Título</label>
                <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $note->title) }}" required>
                @error('title')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group">
                <label for="content">Conteúdo</label>
                <textarea class="form-control @error('content') is-invalid @enderror" id="content" name="content" rows="10" required>{{ old('content', $note->content) }}</textarea>
                @error('content')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group">
                <label for="council_id">Conselho Pastoral</label>
                <select class="form-control @error('council_id') is-invalid @enderror" id="council_id" name="council_id" required>
                    <option value="">Selecione um conselho</option>
                    @foreach($councils as $council)
                        <option value="{{ $council->id }}" {{ old('council_id', $note->council_id) == $council->id ? 'selected' : '' }}>
                            {{ $council->name }}
                        </option>
                    @endforeach
                </select>
                @error('council_id')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group">
                <label for="type">Tipo</label>
                <select class="form-control @error('type') is-invalid @enderror" id="type" name="type" required>
                    <option value="">Selecione um tipo</option>
                    @foreach($types as $type)
                        <option value="{{ $type }}" {{ old('type', $note->type) == $type ? 'selected' : '' }}>
                            {{ ucfirst($type) }}
                        </option>
                    @endforeach
                </select>
                @error('type')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Atualizar</button>
            <a href="{{ route('pastoral.notes.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>
@stop