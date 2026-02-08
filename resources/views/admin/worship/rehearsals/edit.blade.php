@extends('adminlte::page')

@section('title', 'Editar Ensaio')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Editar Ensaio</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.worship.rehearsals.index') }}">Ensaios</a></li>
                    <li class="breadcrumb-item active">Editar</li>
                </ol>
            </div>
        </div>
    </div>
@stop

@section('content')
<div class="card card-warning">
    <div class="card-header">
        <h3 class="card-title">Dados do Ensaio</h3>
    </div>
    <form action="{{ route('admin.worship.rehearsals.update', $worshipRehearsal) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="card-body">
            <div class="form-group">
                <label for="worship_team_id">Equipe *</label>
                <select name="worship_team_id" id="worship_team_id" class="form-control select2" required>
                    <option value="">Selecione uma equipe...</option>
                    @foreach($teams as $team)
                        <option value="{{ $team->id }}" {{ old('worship_team_id', $worshipRehearsal->worship_team_id) == $team->id ? 'selected' : '' }}>
                            {{ $team->name }}
                        </option>
                    @endforeach
                </select>
                @error('worship_team_id') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="row">
                <div class="col-md-6 form-group">
                    <label for="scheduled_at">Data e Hora *</label>
                    <input type="datetime-local" name="scheduled_at" id="scheduled_at" class="form-control @error('scheduled_at') is-invalid @enderror" value="{{ old('scheduled_at', $worshipRehearsal->scheduled_at->format('Y-m-d\TH:i')) }}" required>
                    @error('scheduled_at') <span class="invalid-feedback">{{ $message }}</span> @enderror
                </div>
                <div class="col-md-6 form-group">
                    <label for="location">Local</label>
                    <input type="text" name="location" id="location" class="form-control" value="{{ old('location', $worshipRehearsal->location) }}" placeholder="Ex: Templo Principal">
                </div>
            </div>

            <div class="form-group">
                <label for="notes">Observações</label>
                <textarea name="notes" id="notes" class="form-control" rows="3">{{ old('notes', $worshipRehearsal->notes) }}</textarea>
            </div>
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-warning">Atualizar Ensaio</button>
            <a href="{{ route('admin.worship.rehearsals.index') }}" class="btn btn-default float-right">Cancelar</a>
        </div>
    </form>
</div>
@stop

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: "Selecione...",
                allowClear: true
            });
        });
    </script>
@stop
