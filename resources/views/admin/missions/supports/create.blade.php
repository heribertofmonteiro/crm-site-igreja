@extends('adminlte::page')

@section('title', 'Criar Suporte Missionário')

@section('content_header')
    <h1>Criar Suporte Missionário</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Novo Suporte Missionário</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('missions.supports.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="missionary_id">Missionário</label>
                <select class="form-control" id="missionary_id" name="missionary_id" required>
                    <option value="">Selecione um missionário</option>
                    @foreach($missionaries as $missionary)
                        <option value="{{ $missionary->id }}">{{ $missionary->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="supporter_id">Apoiador</label>
                <select class="form-control" id="supporter_id" name="supporter_id" required>
                    <option value="">Selecione um membro</option>
                    @foreach($members as $member)
                        <option value="{{ $member->id }}">{{ $member->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="amount">Valor</label>
                <input type="number" step="0.01" class="form-control" id="amount" name="amount" required>
            </div>
            <div class="form-group">
                <label for="frequency">Frequência</label>
                <select class="form-control" id="frequency" name="frequency" required>
                    <option value="monthly">Mensal</option>
                    <option value="yearly">Anual</option>
                    <option value="one_time">Única</option>
                </select>
            </div>
            <div class="form-group">
                <label for="start_date">Data de Início</label>
                <input type="date" class="form-control" id="start_date" name="start_date" required>
            </div>
            <div class="form-group">
                <label for="end_date">Data de Fim</label>
                <input type="date" class="form-control" id="end_date" name="end_date">
            </div>
            <div class="form-group">
                <label for="status">Status</label>
                <select class="form-control" id="status" name="status" required>
                    <option value="active">Ativo</option>
                    <option value="inactive">Inativo</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Salvar</button>
            <a href="{{ route('missions.supports.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</div>
@stop