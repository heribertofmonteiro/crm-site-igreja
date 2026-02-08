@extends('adminlte::page')

@section('title', 'Editar Incidente de Segurança')

@section('content_header')
    <h1>Editar Incidente de Segurança</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Editar Incidente: {{ $securityIncident->title }}</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.it.security.update', $securityIncident) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="title">Título</label>
                <input type="text" name="title" class="form-control" value="{{ old('title', $securityIncident->title) }}" required>
                @error('title')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="description">Descrição</label>
                <textarea name="description" class="form-control" rows="3" required>{{ old('description', $securityIncident->description) }}</textarea>
                @error('description')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="severity">Severidade</label>
                <select name="severity" class="form-control" required>
                    <option value="low" {{ old('severity', $securityIncident->severity) == 'low' ? 'selected' : '' }}>Baixa</option>
                    <option value="medium" {{ old('severity', $securityIncident->severity) == 'medium' ? 'selected' : '' }}>Média</option>
                    <option value="high" {{ old('severity', $securityIncident->severity) == 'high' ? 'selected' : '' }}>Alta</option>
                    <option value="critical" {{ old('severity', $securityIncident->severity) == 'critical' ? 'selected' : '' }}>Crítica</option>
                </select>
                @error('severity')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="status">Status</label>
                <select name="status" class="form-control" required>
                    <option value="open" {{ old('status', $securityIncident->status) == 'open' ? 'selected' : '' }}>Aberto</option>
                    <option value="investigating" {{ old('status', $securityIncident->status) == 'investigating' ? 'selected' : '' }}>Investigando</option>
                    <option value="resolved" {{ old('status', $securityIncident->status) == 'resolved' ? 'selected' : '' }}>Resolvido</option>
                    <option value="closed" {{ old('status', $securityIncident->status) == 'closed' ? 'selected' : '' }}>Fechado</option>
                </select>
                @error('status')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="reported_by">Reportado por</label>
                <select name="reported_by" class="form-control" required>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ old('reported_by', $securityIncident->reported_by) == $user->id ? 'selected' : '' }}>
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
                <input type="datetime-local" name="reported_at" class="form-control" value="{{ old('reported_at', $securityIncident->reported_at->format('Y-m-d\TH:i')) }}" required>
                @error('reported_at')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="resolved_at">Data da Resolução</label>
                <input type="datetime-local" name="resolved_at" class="form-control" value="{{ old('resolved_at', $securityIncident->resolved_at ? $securityIncident->resolved_at->format('Y-m-d\TH:i') : '') }}">
                @error('resolved_at')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Atualizar</button>
            <a href="{{ route('admin.it.security.show', $securityIncident) }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</div>
@stop