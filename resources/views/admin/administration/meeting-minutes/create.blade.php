@extends('adminlte::page')

@section('title', 'Nova Ata')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Nova Ata</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.administration.meeting-minutes.index') }}">Atas</a></li>
                    <li class="breadcrumb-item active">Nova</li>
                </ol>
            </div>
        </div>
    </div>
@stop

@section('content')
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Dados da Reunião</h3>
    </div>
    <form action="{{ route('admin.administration.meeting-minutes.store') }}" method="POST">
        @csrf
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 form-group">
                    <label for="title">Título da Reunião *</label>
                    <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" required>
                    @error('title') <span class="invalid-feedback">{{ $message }}</span> @enderror
                </div>
                <div class="col-md-3 form-group">
                    <label for="meeting_type">Tipo de Reunião</label>
                    <select name="meeting_type" id="meeting_type" class="form-control">
                        <option value="Geral">Geral</option>
                        <option value="Administrativa">Administrativa</option>
                        <option value="Financeira">Financeira</option>
                        <option value="Ministerial">Ministerial</option>
                        <option value="Liderança">Liderança</option>
                    </select>
                </div>
                <div class="col-md-3 form-group">
                    <label for="meeting_date">Data e Hora *</label>
                    <input type="datetime-local" name="meeting_date" id="meeting_date" class="form-control @error('meeting_date') is-invalid @enderror" value="{{ old('meeting_date') }}" required>
                    @error('meeting_date') <span class="invalid-feedback">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="form-group">
                <label for="location">Local</label>
                <input type="text" name="location" id="location" class="form-control" value="{{ old('location') }}" placeholder="Ex: Sala de Reuniões, Templo, Zoom...">
            </div>

            <div class="form-group">
                <label for="participants">Participantes</label>
                @inject('users', 'App\Models\User')
                <select name="participants[]" id="participants" class="form-control select2" multiple style="width: 100%; height: 100px;">
                    @foreach($users::all() as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
                <small class="text-muted">Selecione os participantes (segure Ctrl para selecionar múltiplos)</small>
            </div>

            <div class="form-group">
                <label for="content">Pauta e Discussões *</label>
                <textarea name="content" id="content" class="form-control" rows="5" required>{{ old('content') }}</textarea>
            </div>

            <div class="row">
                <div class="col-md-6 form-group">
                    <label for="decisions">Decisões</label>
                    <textarea name="decisions" id="decisions" class="form-control" rows="3">{{ old('decisions') }}</textarea>
                </div>
                <div class="col-md-6 form-group">
                    <label for="action_items">Encaminhamentos</label>
                    <textarea name="action_items" id="action_items" class="form-control" rows="3">{{ old('action_items') }}</textarea>
                </div>
            </div>

            <div class="form-group">
                <label for="status">Status Inicial</label>
                <select name="status" id="status" class="form-control">
                    <option value="draft">Rascunho</option>
                    <option value="approved">Aprovada</option>
                    <option value="archived">Arquivada</option>
                </select>
            </div>
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Salvar Ata</button>
            <a href="{{ route('admin.administration.meeting-minutes.index') }}" class="btn btn-default float-right">Cancelar</a>
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
                placeholder: "Selecione os participantes",
                allowClear: true
            });
        });
    </script>
@stop
