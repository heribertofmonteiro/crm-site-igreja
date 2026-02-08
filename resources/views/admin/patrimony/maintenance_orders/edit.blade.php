@extends('adminlte::page')

@section('title', 'Editar Ordem de Manutenção')

@section('content_header')
    <h1>Editar Ordem de Manutenção</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Editar Ordem de Manutenção</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('patrimony.maintenance_orders.update', $maintenanceOrder) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="asset_id">Bem</label>
                <select name="asset_id" class="form-control" required>
                    @foreach($assets as $asset)
                        <option value="{{ $asset->id }}" {{ $maintenanceOrder->asset_id == $asset->id ? 'selected' : '' }}>
                            {{ $asset->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="description">Descrição</label>
                <textarea name="description" class="form-control" rows="3" required>{{ $maintenanceOrder->description }}</textarea>
            </div>
            <div class="form-group">
                <label for="priority">Prioridade</label>
                <select name="priority" class="form-control" required>
                    <option value="low" {{ $maintenanceOrder->priority == 'low' ? 'selected' : '' }}>Baixa</option>
                    <option value="medium" {{ $maintenanceOrder->priority == 'medium' ? 'selected' : '' }}>Média</option>
                    <option value="high" {{ $maintenanceOrder->priority == 'high' ? 'selected' : '' }}>Alta</option>
                    <option value="urgent" {{ $maintenanceOrder->priority == 'urgent' ? 'selected' : '' }}>Urgente</option>
                </select>
            </div>
            <div class="form-group">
                <label for="status">Status</label>
                <select name="status" class="form-control" required>
                    <option value="pending" {{ $maintenanceOrder->status == 'pending' ? 'selected' : '' }}>Pendente</option>
                    <option value="in_progress" {{ $maintenanceOrder->status == 'in_progress' ? 'selected' : '' }}>Em Andamento</option>
                    <option value="completed" {{ $maintenanceOrder->status == 'completed' ? 'selected' : '' }}>Concluída</option>
                    <option value="cancelled" {{ $maintenanceOrder->status == 'cancelled' ? 'selected' : '' }}>Cancelada</option>
                </select>
            </div>
            <div class="form-group">
                <label for="scheduled_date">Data Agendada</label>
                <input type="datetime-local" name="scheduled_date" class="form-control" value="{{ $maintenanceOrder->scheduled_date->format('Y-m-d\TH:i') }}" required>
            </div>
            <div class="form-group">
                <label for="completed_date">Data de Conclusão</label>
                <input type="datetime-local" name="completed_date" class="form-control" value="{{ $maintenanceOrder->completed_date ? $maintenanceOrder->completed_date->format('Y-m-d\TH:i') : '' }}">
            </div>
            <div class="form-group">
                <label for="assigned_to">Atribuído a</label>
                <input type="text" name="assigned_to" class="form-control" value="{{ $maintenanceOrder->assigned_to }}">
            </div>
            <div class="form-group">
                <label for="notes">Notas</label>
                <textarea name="notes" class="form-control" rows="3">{{ $maintenanceOrder->notes }}</textarea>
            </div>
            <button type="submit" class="btn btn-primary">Atualizar</button>
            <a href="{{ route('patrimony.maintenance_orders.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</div>
@stop