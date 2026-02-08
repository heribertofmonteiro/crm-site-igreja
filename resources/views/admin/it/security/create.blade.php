@extends('adminlte::page')

@section('title', 'Criar Incidente de Segurança')

@section('content_header')
    <h1>Criar Incidente de Segurança</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Criar Novo Incidente de Segurança</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.it.security.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="title">Título</label>
                <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
                @error('title')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="description">Descrição</label>
                <textarea name="description" class="form-control" rows="3" required>{{ old('description') }}</textarea>
                @error('description')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="severity">Severidade</label>
                <select name="severity" class="form-control" required>
                    <option value="low" {{ old('severity') == 'low' ? 'selected' : '' }}>Baixa</option>
                    <option value="medium" {{ old('severity') == 'medium' ? 'selected' : '' }}>Média</option>
                    <option value="high" {{ old('severity') == 'high' ? 'selected' : '' }}>Alta</option>
                    <option value="critical" {{ old('severity') == 'critical' ? 'selected' : '' }}>Crítica</option>
                </select>
                @error('severity')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="status">Status</label>
                <select name="status" class="form-control" required>
                    <option value="open" {{ old('status') == 'open' ? 'selected' : '' }}>Aberto</option>
                    <option value="investigating" {{ old('status') == 'investigating' ? 'selected' : '' }}>Investigando</option>
                    <option value="resolved" {{ old('status') == 'resolved' ? 'selected' : '' }}>Resolvido</option>
                    <option value="closed" {{ old('status') == 'closed' ? 'selected' : '' }}>Fechado</option>
                </select>
                @error('status')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="reported_by">Reportado por</label>
                <select name="reported_by" class="form-control" required>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ old('reported_by') == $user->id ? 'selected' : '' }}>
                            {{ $user->name }}
                        </option>
                    @endforeach
                </select>
                @error('reported_by')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="reported_at">Data do Relatório</label>
                <input type="datetime-local" name="reported_at" class="form-control" value="{{ old('reported_at', now()->format('Y-m-d\TH:i')) }}" required>
                @error('reported_at')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="resolved_at">Data da Resolução</label>
                <input type="datetime-local" name="resolved_at" class="form-control" value="{{ old('resolved_at') }}">
                @error('resolved_at')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Criar</button>
            <a href="{{ route('admin.it.security.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</div>
@stop