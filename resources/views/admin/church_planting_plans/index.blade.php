@extends('adminlte::page')

@section('title', 'Planos de Plantação de Igrejas')

@section('content_header')
    <h1>Planos de Plantação de Igrejas</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Lista de Planos de Plantação</h3>
        <div class="card-tools">
            <a href="{{ route('expansion.plans.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Novo Plano
            </a>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Localização</th>
                    <th>Data de Início</th>
                    <th>Status</th>
                    <th>Líder</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($plans as $plan)
                <tr>
                    <td>{{ $plan->id }}</td>
                    <td>{{ $plan->name }}</td>
                    <td>{{ $plan->location }}</td>
                    <td>{{ $plan->planned_start_date ? $plan->planned_start_date->format('d/m/Y') : '-' }}</td>
                    <td>
                        <span class="badge badge-{{ $plan->status == 'completed' ? 'success' : ($plan->status == 'in_progress' ? 'warning' : 'secondary') }}">
                            {{ ucfirst(str_replace('_', ' ', $plan->status)) }}
                        </span>
                    </td>
                    <td>{{ $plan->leader ? $plan->leader->name : '-' }}</td>
                    <td>
                        <a href="{{ route('expansion.plans.show', $plan) }}" class="btn btn-info btn-sm">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('expansion.plans.edit', $plan) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('expansion.plans.destroy', $plan) }}" method="POST" style="display: inline;">
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
        {{ $plans->links() }}
    </div>
</div>
@stop