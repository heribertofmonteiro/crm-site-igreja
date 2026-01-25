@extends('adminlte::page')

@section('title', 'Criar Conselho Pastoral')

@section('content_header')
    <h1>Criar Novo Conselho Pastoral</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Formulário de Conselho Pastoral</h3>
    </div>
    <form action="{{ route('pastoral.councils.store') }}" method="POST">
        @csrf
        <div class="card-body">
            <div class="form-group">
                <label for="name">Nome</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group">
                <label for="description">Descrição</label>
                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description') }}</textarea>
                @error('description')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group">
                <label for="vision">Visão</label>
                <textarea class="form-control @error('vision') is-invalid @enderror" id="vision" name="vision" rows="3">{{ old('vision') }}</textarea>
                @error('vision')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group">
                <label for="doctrine_statement">Declaração Doutrinária</label>
                <textarea class="form-control @error('doctrine_statement') is-invalid @enderror" id="doctrine_statement" name="doctrine_statement" rows="3">{{ old('doctrine_statement') }}</textarea>
                @error('doctrine_statement')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group">
                <label>Membros</label>
                <select class="form-control select2 @error('members') is-invalid @enderror" name="members[]" multiple>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ in_array($user->id, old('members', [])) ? 'selected' : '' }}>
                            {{ $user->name }}
                        </option>
                    @endforeach
                </select>
                @error('members')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Salvar</button>
            <a href="{{ route('pastoral.councils.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>
@stop

@section('plugins.Select2', true)