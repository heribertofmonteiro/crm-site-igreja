@extends('adminlte::page')

@section('title', 'Nova Ordem de Manutenção')

@section('content_header')
    <h1>Nova Ordem de Manutenção</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Criar Nova Ordem de Manutenção</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('patrimony.maintenance_orders.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="asset_id">Bem</label>
                <select name="asset_id" class="form-control" required>
                    @foreach($assets as $asset)
                        <option value="{{ $asset->id }}">{{ $asset->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="description">Descrição</label>
                <textarea name="description" class="form-control" required></textarea>
            </div>
            <div class="form-group">
                <label for="priority">Prioridade</label>
                <select name="priority" class="form-control" required>
                    <option value="low">Baixa</option>
                    <option value="medium">Média</option>
                    <option value="high">Alta</option>
                    <option value="urgent">Urgente</option>
                </select>
            </div>
            <div class="form-group">
                <label for="status">Status</label>
                <select name="status" class="form-control" required>
                    <option value="pending">Pendente</option>
                    <option value="in_progress">Em Andamento</option>
                    <option value="completed">Concluída</option>
                    <option value="cancelled">Cancelada</option>
                </select>
            </div>
            <div class="form-group">
                <label for="scheduled_date">Data Agendada</label>
                <input type="datetime-local" name="scheduled_date" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="assigned_to">Atribuído a</label>
                <input type="text" name="assigned_to" class="form-control">
            </div>
            <div class="form-group">
                <label for="notes">Notas</label>
                <textarea name="notes" class="form-control"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Salvar</button>
            <a href="{{ route('patrimony.maintenance_orders.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</div>
@stop