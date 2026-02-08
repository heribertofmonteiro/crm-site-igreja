@extends('adminlte::page')

@section('title', 'Editar Conta')

@section('content_header')
    <h1>Editar Conta</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Editar Informações da Conta</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('account.update') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">Nome</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Salvar</button>
            <a href="{{ route('account.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</div>
@stop