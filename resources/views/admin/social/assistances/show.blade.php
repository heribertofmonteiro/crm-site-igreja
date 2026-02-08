@extends('adminlte::page')

@section('title', 'Assistência Social')

@section('content_header')
    <h1>Assistência Social #{{ $assistance->id }}</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Detalhes da Assistência Social</h3>
        <div class="card-tools">
            @can('social_assistance.edit')
            <a href="{{ route('social.assistances.edit', $assistance) }}" class="btn btn-warning btn-sm">
                <i class="fas fa-edit"></i> Editar
            </a>
            @endcan
            <a href="{{ route('social.assistances.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-list"></i> Voltar
            </a>
        </div>
    </div>
    <div class="card-body">
        <dl class="row">
            <dt class="col-sm-3">ID:</dt>
            <dd class="col-sm-9">{{ $assistance->id }}</dd>

            <dt class="col-sm-3">Projeto Social:</dt>
            <dd class="col-sm-9">{{ $assistance->socialProject->name ?? 'N/A' }}</dd>

            <dt class="col-sm-3">Beneficiário:</dt>
            <dd class="col-sm-9">{{ $assistance->beneficiary_name }}</dd>

            <dt class="col-sm-3">Contato:</dt>
            <dd class="col-sm-9">{{ $assistance->beneficiary_contact ?: 'N/A' }}</dd>

            <dt class="col-sm-3">Tipo de Assistência:</dt>
            <dd class="col-sm-9">{{ ucfirst($assistance->assistance_type) }}</dd>

            <dt class="col-sm-3">Descrição:</dt>
            <dd class="col-sm-9">{{ $assistance->description ?: 'N/A' }}</dd>

            <dt class="col-sm-3">Data:</dt>
            <dd class="col-sm-9">{{ $assistance->date_provided->format('d/m/Y') }}</dd>

            <dt class="col-sm-3">Valor:</dt>
            <dd class="col-sm-9">{{ $assistance->amount ? 'R$ ' . number_format($assistance->amount, 2, ',', '.') : 'N/A' }}</dd>

            <dt class="col-sm-3">Criado em:</dt>
            <dd class="col-sm-9">{{ $assistance->created_at->format('d/m/Y H:i') }}</dd>

            <dt class="col-sm-3">Atualizado em:</dt>
            <dd class="col-sm-9">{{ $assistance->updated_at->format('d/m/Y H:i') }}</dd>
        </dl>
    </div>
</div>
@stop