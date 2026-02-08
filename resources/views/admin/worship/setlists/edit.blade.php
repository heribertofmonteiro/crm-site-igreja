@extends('adminlte::page')

@section('title', 'Editar Setlist')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Editar Setlist</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.worship.setlists.index') }}">Setlists</a></li>
                    <li class="breadcrumb-item active">Editar</li>
                </ol>
            </div>
        </div>
    </div>
@stop

@section('content')
<div class="card card-warning">
    <div class="card-header">
        <h3 class="card-title">Dados da Setlist</h3>
    </div>
    <form action="{{ route('admin.worship.setlists.update', $worshipSetlist) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="card-body">
            <div class="row">
                <div class="col-md-4 form-group">
                    <label for="date">Data da Ministração *</label>
                    <input type="date" name="date" id="date" class="form-control @error('date') is-invalid @enderror" value="{{ old('date', $worshipSetlist->date->format('Y-m-d')) }}" required>
                    @error('date') <span class="invalid-feedback">{{ $message }}</span> @enderror
                </div>
                <div class="col-md-4 form-group">
                    <label for="event_id">Evento (Opcional)</label>
                    <select name="event_id" id="event_id" class="form-control select2">
                        <option value="">Selecione um evento...</option>
                        @foreach($events as $event)
                            <option value="{{ $event->id }}" {{ old('event_id', $worshipSetlist->church_event_id) == $event->id ? 'selected' : '' }}>
                                {{ $event->title }} ({{ $event->formatted_start_date }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4 form-group">
                    <label for="theme">Tema (Opcional)</label>
                    <input type="text" name="theme" id="theme" class="form-control" value="{{ old('theme', $worshipSetlist->theme) }}" placeholder="Ex: Adoração Extravagante">
                </div>
            </div>

            <div class="form-group">
                <label for="songs">Músicas (Selecione na ordem de execução) *</label>
                <select name="songs[]" id="songs" class="form-control select2" multiple required style="width: 100%;">
                    @foreach($songs as $song)
                        <option value="{{ $song->id }}" {{ $worshipSetlist->songs->contains($song->id) ? 'selected' : '' }}>
                            {{ $song->title }} ({{ $song->artist }})
                        </option>
                    @endforeach
                </select>
                <small class="text-muted">A ordem de seleção definirá a ordem na setlist.</small>
                @error('songs') <span class="text-danger d-block">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="notes">Observações Gerais</label>
                <textarea name="notes" id="notes" class="form-control" rows="3">{{ old('notes', $worshipSetlist->notes) }}</textarea>
            </div>
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-warning">Atualizar Setlist</button>
            <a href="{{ route('admin.worship.setlists.index') }}" class="btn btn-default float-right">Cancelar</a>
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
