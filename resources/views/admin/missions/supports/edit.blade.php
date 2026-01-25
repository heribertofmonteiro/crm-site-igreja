@extends('adminlte::page')

@section('title', 'Editar Suporte Missionário')

@section('content_header')
    <h1>Editar Suporte Missionário</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Editar Suporte: {{ $support->missionary->name }} - {{ $support->supporter->name }}</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('missions.supports.update', $support) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="missionary_id">Missionário</label>
                <select class="form-control" id="missionary_id" name="missionary_id" required>
                    <option value="">Selecione um missionário</option>
                    @foreach($missionaries as $missionary)
                        <option value="{{ $missionary->id }}" {{ $support->missionary_id == $missionary->id ? 'selected' : '' }}>{{ $missionary->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="supporter_id">Apoiador</label>
                <select class="form-control" id="supporter_id" name="supporter_id" required>
                    <option value="">Selecione um membro</option>
                    @foreach($members as $member)
                        <option value="{{ $member->id }}" {{ $support->supporter_id == $member->id ? 'selected' : '' }}>{{ $member->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="amount">Valor</label>
                <input type="number" step="0.01" class="form-control" id="amount" name="amount" value="{{ $support->amount }}" required>
            </div>
            <div class="form-group">
                <label for="frequency">Frequência</label>
                <select class="form-control" id="frequency" name="frequency" required>
                    <option value="monthly" {{ $support->frequency === 'monthly' ? 'selected' : '' }}>Mensal</option>
                    <option value="yearly" {{ $support->frequency === 'yearly' ? 'selected' : '' }}>Anual</option>
                    <option value="one_time" {{ $support->frequency === 'one_time' ? 'selected' : '' }}>Única</option>
                </select>
            </div>
            <div class="form-group">
                <label for="start_date">Data de Início</label>
                <input type="date" class="form-control" id="start_date" name="start_date" value="{{ $support->start_date->format('Y-m-d') }}" required>
            </div>
            <div class="form-group">
                <label for="end_date">Data de Fim</label>
                <input type="date" class="form-control" id="end_date" name="end_date" value="{{ $support->end_date ? $support->end_date->format('Y-m-d') : '' }}">
            </div>
            <div class="form-group">
                <label for="status">Status</label>
                <select class="form-control" id="status" name="status" required>
                    <option value="active" {{ $support->status === 'active' ? 'selected' : '' }}>Ativo</option>
                    <option value="inactive" {{ $support->status === 'inactive' ? 'selected' : '' }}>Inativo</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Atualizar</button>
            <a href="{{ route('missions.supports.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</div>
@stop