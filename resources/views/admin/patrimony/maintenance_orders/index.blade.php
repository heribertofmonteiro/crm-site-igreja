@extends('adminlte::page')

@section('title', 'Ordens de Manutenção')

@section('content_header')
    <h1>Ordens de Manutenção</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Lista de Ordens de Manutenção</h3>
        <div class="card-tools">
            <a href="{{ route('patrimony.maintenance_orders.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Nova Ordem
            </a>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Bem</th>
                    <th>Descrição</th>
                    <th>Prioridade</th>
                    <th>Status</th>
                    <th>Data Agendada</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($maintenanceOrders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->asset->name }}</td>
                    <td>{{ Str::limit($order->description, 50) }}</td>
                    <td>
                        <span class="badge badge-{{ $order->priority == 'urgent' ? 'danger' : ($order->priority == 'high' ? 'warning' : 'info') }}">
                            {{ ucfirst($order->priority) }}
                        </span>
                    </td>
                    <td>
                        <span class="badge badge-{{ $order->status == 'completed' ? 'success' : ($order->status == 'in_progress' ? 'primary' : 'secondary') }}">
                            {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                        </span>
                    </td>
                    <td>{{ $order->scheduled_date->format('d/m/Y H:i') }}</td>
                    <td>
                        <a href="{{ route('patrimony.maintenance_orders.show', $order) }}" class="btn btn-info btn-sm">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('patrimony.maintenance_orders.edit', $order) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('patrimony.maintenance_orders.destroy', $order) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{ $maintenanceOrders->links() }}
    </div>
</div>
@stop