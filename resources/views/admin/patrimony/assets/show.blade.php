@extends('adminlte::page')

@section('title', 'Detalhes do Bem')

@section('content_header')
    <h1>Detalhes do Bem</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">{{ $asset->name }}</h3>
        <div class="card-tools">
            <a href="{{ route('patrimony.assets.edit', $asset) }}" class="btn btn-warning btn-sm">
                <i class="fas fa-edit"></i> Editar
            </a>
            <a href="{{ route('patrimony.assets.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-list"></i> Voltar
            </a>
        </div>
    </div>
    <div class="card-body">
        <dl class="row">
            <dt class="col-sm-3">Nome</dt>
            <dd class="col-sm-9">{{ $asset->name }}</dd>

            <dt class="col-sm-3">Descrição</dt>
            <dd class="col-sm-9">{{ $asset->description ?: '-' }}</dd>

            <dt class="col-sm-3">Categoria</dt>
            <dd class="col-sm-9">{{ $asset->category }}</dd>

            <dt class="col-sm-3">Valor</dt>
            <dd class="col-sm-9">{{ $asset->value ? 'R$ ' . number_format($asset->value, 2, ',', '.') : '-' }}</dd>

            <dt class="col-sm-3">Data de Aquisição</dt>
            <dd class="col-sm-9">{{ $asset->acquisition_date->format('d/m/Y') }}</dd>

            <dt class="col-sm-3">Status</dt>
            <dd class="col-sm-9">
                <span class="badge badge-{{ $asset->status == 'active' ? 'success' : ($asset->status == 'maintenance' ? 'warning' : 'secondary') }}">
                    {{ ucfirst($asset->status) }}
                </span>
            </dd>

            <dt class="col-sm-3">Localização</dt>
            <dd class="col-sm-9">{{ $asset->location ?: '-' }}</dd>
        </dl>
    </div>
</div>
@stop