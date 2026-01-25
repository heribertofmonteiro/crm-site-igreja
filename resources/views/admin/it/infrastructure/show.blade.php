@extends('adminlte::page')

@section('title', 'Detalhes do Ativo de Infraestrutura')

@section('content_header')
    <h1>Detalhes do Ativo de Infraestrutura</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">{{ $infrastructure->name }}</h3>
        <div class="card-tools">
            <a href="{{ route('it.infrastructure.edit', $infrastructure) }}" class="btn btn-warning btn-sm">
                <i class="fas fa-edit"></i> Editar
            </a>
            <a href="{{ route('it.infrastructure.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Voltar
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <table class="table table-bordered">
                    <tr>
                        <th>ID</th>
                        <td>{{ $infrastructure->id }}</td>
                    </tr>
                    <tr>
                        <th>Nome</th>
                        <td>{{ $infrastructure->name }}</td>
                    </tr>
                    <tr>
                        <th>Tipo</th>
                        <td>{{ ucfirst($infrastructure->type) }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>
                            <span class="badge badge-{{ $infrastructure->status === 'active' ? 'success' : ($infrastructure->status === 'maintenance' ? 'warning' : 'secondary') }}">
                                {{ ucfirst($infrastructure->status) }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th>Localização</th>
                        <td>{{ $infrastructure->location ?? '-' }}</td>
                    </tr>
                </table>
            </div>
            <div class="col-md-6">
                <table class="table table-bordered">
                    <tr>
                        <th>Data de Compra</th>
                        <td>{{ $infrastructure->purchase_date ? $infrastructure->purchase_date->format('d/m/Y') : '-' }}</td>
                    </tr>
                    <tr>
                        <th>Garantia até</th>
                        <td>{{ $infrastructure->warranty_expiry ? $infrastructure->warranty_expiry->format('d/m/Y') : '-' }}</td>
                    </tr>
                    <tr>
                        <th>Criado em</th>
                        <td>{{ $infrastructure->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                    <tr>
                        <th>Atualizado em</th>
                        <td>{{ $infrastructure->updated_at->format('d/m/Y H:i') }}</td>
                    </tr>
                </table>
            </div>
        </div>
        @if($infrastructure->notes)
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label>Observações</label>
                    <div class="border p-2 bg-light">
                        {{ $infrastructure->notes }}
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@stop