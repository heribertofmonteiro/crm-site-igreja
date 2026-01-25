@extends('adminlte::page')

@section('title', 'Editar Missionário')

@section('content_header')
    <h1>Editar Missionário</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Editar Missionário: {{ $missionary->name }}</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('missions.missionaries.update', $missionary) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">Nome</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $missionary->name }}" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ $missionary->email }}" required>
            </div>
            <div class="form-group">
                <label for="phone">Telefone</label>
                <input type="text" class="form-control" id="phone" name="phone" value="{{ $missionary->phone }}">
            </div>
            <div class="form-group">
                <label for="country">País</label>
                <input type="text" class="form-control" id="country" name="country" value="{{ $missionary->country }}" required>
            </div>
            <div class="form-group">
                <label for="region">Região</label>
                <input type="text" class="form-control" id="region" name="region" value="{{ $missionary->region }}">
            </div>
            <div class="form-group">
                <label for="start_date">Data de Início</label>
                <input type="date" class="form-control" id="start_date" name="start_date" value="{{ $missionary->start_date->format('Y-m-d') }}" required>
            </div>
            <div class="form-group">
                <label for="end_date">Data de Fim</label>
                <input type="date" class="form-control" id="end_date" name="end_date" value="{{ $missionary->end_date ? $missionary->end_date->format('Y-m-d') : '' }}">
            </div>
            <div class="form-group">
                <label for="status">Status</label>
                <select class="form-control" id="status" name="status" required>
                    <option value="active" {{ $missionary->status === 'active' ? 'selected' : '' }}>Ativo</option>
                    <option value="inactive" {{ $missionary->status === 'inactive' ? 'selected' : '' }}>Inativo</option>
                </select>
            </div>
            <div class="form-group">
                <label for="bio">Biografia</label>
                <textarea class="form-control" id="bio" name="bio" rows="3">{{ $missionary->bio }}</textarea>
            </div>
            <button type="submit" class="btn btn-primary">Atualizar</button>
            <a href="{{ route('missions.missionaries.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</div>
@stop