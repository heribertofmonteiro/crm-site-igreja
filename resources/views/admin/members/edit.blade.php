@extends('adminlte::page')

@section('title', 'Editar Membro')

@section('content_header')
    <h1>Editar Membro</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Editar Membro</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.members.update', $member) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">Nome</label>
                <input type="text" name="name" class="form-control" value="{{ $member->name }}" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" class="form-control" value="{{ $member->email }}" required>
            </div>
            <div class="form-group">
                <label for="phone">Telefone</label>
                <input type="text" name="phone" class="form-control" value="{{ $member->phone }}">
            </div>
            <div class="form-group">
                <label for="address">Endereço</label>
                <textarea name="address" class="form-control">{{ $member->address }}</textarea>
            </div>
            <div class="form-group">
                <label for="birth_date">Data de Nascimento</label>
                <input type="date" name="birth_date" class="form-control" value="{{ $member->birth_date ? $member->birth_date->format('Y-m-d') : '' }}">
            </div>
            <div class="form-group">
                <label for="baptism_date">Data de Batismo</label>
                <input type="date" name="baptism_date" class="form-control" value="{{ $member->baptism_date ? $member->baptism_date->format('Y-m-d') : '' }}">
            </div>
            <div class="form-group">
                <label for="marital_status">Estado Civil</label>
                <select name="marital_status" class="form-control" required>
                    <option value="single" {{ $member->marital_status == 'single' ? 'selected' : '' }}>Solteiro</option>
                    <option value="married" {{ $member->marital_status == 'married' ? 'selected' : '' }}>Casado</option>
                    <option value="divorced" {{ $member->marital_status == 'divorced' ? 'selected' : '' }}>Divorciado</option>
                    <option value="widowed" {{ $member->marital_status == 'widowed' ? 'selected' : '' }}>Viúvo</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Atualizar</button>
            <a href="{{ route('admin.members.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</div>
@stop