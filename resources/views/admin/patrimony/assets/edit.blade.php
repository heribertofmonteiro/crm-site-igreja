@extends('adminlte::page')

@section('title', 'Editar Bem')

@section('content_header')
    <h1>Editar Bem</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Editar Bem</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('patrimony.assets.update', $asset) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">Nome</label>
                <input type="text" name="name" class="form-control" value="{{ $asset->name }}" required>
            </div>
            <div class="form-group">
                <label for="description">Descrição</label>
                <textarea name="description" class="form-control">{{ $asset->description }}</textarea>
            </div>
            <div class="form-group">
                <label for="category">Categoria</label>
                <input type="text" name="category" class="form-control" value="{{ $asset->category }}" required>
            </div>
            <div class="form-group">
                <label for="value">Valor</label>
                <input type="number" name="value" class="form-control" value="{{ $asset->value }}" step="0.01">
            </div>
            <div class="form-group">
                <label for="acquisition_date">Data de Aquisição</label>
                <input type="date" name="acquisition_date" class="form-control" value="{{ $asset->acquisition_date->format('Y-m-d') }}" required>
            </div>
            <div class="form-group">
                <label for="status">Status</label>
                <select name="status" class="form-control" required>
                    <option value="active" {{ $asset->status == 'active' ? 'selected' : '' }}>Ativo</option>
                    <option value="inactive" {{ $asset->status == 'inactive' ? 'selected' : '' }}>Inativo</option>
                    <option value="maintenance" {{ $asset->status == 'maintenance' ? 'selected' : '' }}>Manutenção</option>
                    <option value="disposed" {{ $asset->status == 'disposed' ? 'selected' : '' }}>Descartado</option>
                </select>
            </div>
            <div class="form-group">
                <label for="location">Localização</label>
                <input type="text" name="location" class="form-control" value="{{ $asset->location }}">
            </div>
            <button type="submit" class="btn btn-primary">Salvar</button>
            <a href="{{ route('patrimony.assets.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</div>
@stop