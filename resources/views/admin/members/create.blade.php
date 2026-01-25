@extends('adminlte::page')

@section('title', 'Novo Membro')

@section('content_header')
    <h1>Novo Membro</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Criar Novo Membro</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.members.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Nome</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="phone">Telefone</label>
                <input type="text" name="phone" class="form-control">
            </div>
            <div class="form-group">
                <label for="address">Endereço</label>
                <textarea name="address" class="form-control"></textarea>
            </div>
            <div class="form-group">
                <label for="birth_date">Data de Nascimento</label>
                <input type="date" name="birth_date" class="form-control">
            </div>
            <div class="form-group">
                <label for="baptism_date">Data de Batismo</label>
                <input type="date" name="baptism_date" class="form-control">
            </div>
            <div class="form-group">
                <label for="marital_status">Estado Civil</label>
                <select name="marital_status" class="form-control" required>
                    <option value="single">Solteiro</option>
                    <option value="married">Casado</option>
                    <option value="divorced">Divorciado</option>
                    <option value="widowed">Viúvo</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Salvar</button>
            <a href="{{ route('admin.members.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</div>
@stop